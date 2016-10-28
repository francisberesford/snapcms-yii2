<?php

namespace snapcms\models;

use Yii;
use yii\helpers\ArrayHelper;
use snapcms\components\ActiveRecord;

/**
 * This is the model class for table "{{%config}}".
 *
 * @property string $path
 * @property string $value
 */
class Config extends ActiveRecord
{
    protected static $_configCache = array();
    public $validator = '\yii\validators\StringValidator';
    public $validatorOptions = array('max' => 255);
    public $rules = [
        [['path', 'value'], 'string', 'max' => 255]
    ];
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return "{{%config}}";
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return $this->rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'path' => Yii::t('snapcms', 'Config Path'),
            'value' => Yii::t('snapcms', 'Value'),
        ];
    }
    
    /**
     * Internal function to fill cache variable with file data.
     * @param array $filedata The array to populate internal cache with
     * @param string $path The config filename with trailing slash
     * @return array The cache array
     */
    protected static function fillCache($filedata, $path)
    {
        $overrides = self::getFileData('_allow_db_override');
        
        foreach($filedata as $key => $value)
        {
            $newPath = "$path$key.";
            if(is_array($value)) {
                self::fillCache($value, $newPath);
            } else { //must be string
                $newPath = rtrim($newPath, ".");
                if(!in_array($newPath, array_keys($overrides), 1) && !in_array($newPath, array_values($overrides), 1)) {
                    self::$_configCache[$newPath] = $value;
                }
            }
        }
        return self::$_configCache;
    }
    
    /**
     * Returns a config value defined by a path in the format "config_file/location.in.array"
     * 
     * Config files are located in the config/snapcms folders
     * @param string $fullPath The config location e.g. general/site.title
     * @param string $location The location of the config data, e.g. common or frontend
     * @return string The value found in the config file/database table
     */
    public static function getData($fullPath, $location='frontend') /* @todo detect current context (frontend/backend) */
    {
        if (isset(self::$_configCache[$fullPath])) {
            return self::$_configCache[$fullPath];
        }

        $overrides = self::getFileData('_allow_db_override');

        //Check if the configuration is overwritten in the database if it's whitelisted.
        if(in_array($fullPath, array_keys($overrides), 1) || in_array($fullPath, array_values($overrides), 1))
        {
            $Config = self::find()->where('path=:fullPath',[':fullPath'=>$fullPath])->one();
            if ($Config) 
            {
                self::$_configCache[$fullPath] = $Config->value;
                return $Config->value;
            }
            else 
            {
                //Value not in database, get the file value
                list($filePath, $confLoc) = explode('/', $fullPath);
                $fullConf = self::getFileData($filePath, $location);
                self::$_configCache[$fullPath] = ArrayHelper::getValue($fullConf, $confLoc);
            }
        }
        else
        {
            list($filePath, $confLoc) = explode('/', $fullPath);

            //Fill cache with file data
            $fullConf = self::getFileData($filePath, $location);
            self::fillCache($fullConf, $filePath.'/');
        }
        
        //If the config still doesn't exist throw Exception.
        if(!isset(self::$_configCache[$fullPath])) {
            throw new \yii\base\ErrorException("Configuration not found: $fullPath");
        }
        
        return self::$_configCache[$fullPath];
    }
    
    /**
     * Returns a full SnapCMS config file array
     * @param string $file The config filename found in the config/snapcms folder (without .php)
     * @param string $location The location of the config data, e.g. common or frontend
     * @return array the config array for the chosen file
     */
    public static function getFileData($file, $location='frontend') 
    {
        $aCommon = $aCommonLocal = $aLocation = $aLocationLocal = [];
        
        $confPath = Yii::getAlias("@$location/config/snapcms/$file.php", false);
        $confPathLocal = Yii::getAlias("@$location/config/snapcms-local/$file.php", false);
        
        $fileFound = false;
        if(file_exists($confPath)) {
            $aLocation = require($confPath);
            $fileFound = true;
        }
        if(file_exists($confPathLocal)) {
            $aLocationLocal = require($confPathLocal);
            $fileFound = true;
        }
        
        //If the config file doesn't exist throw Exception.
        if(!$fileFound) {
            throw new \yii\base\ErrorException("SnapCMS configuration file not found: $file.php");
        }
        
        return \yii\helpers\ArrayHelper::merge($aCommon, $aCommonLocal, $aLocation, $aLocationLocal);
    }
    
    /**
     * Processes config/snapcms/_allow_db_override.php into an associative PHP array
     * 
     * This is used by the settings page in the admin area.
     * 
     * @param sting $catgory The category which you want from the override file, no category will return all data.
     * @param string $postData The post data which you want to save
     * @return array
     */
    public static function getOverrideArrayTree($category = false, $postData = array())
    {
        $data = self::getFileData('_allow_db_override');
        $tree = [];
        foreach($data as $path => $value)
        {
            if(is_numeric($path)) {
                $path = $value;
                $value = [];
            }
            $parts = explode('/',$path);
            $file = $parts[0];
            
            if($category && $file != strtolower($category)) {
                continue;
            }
            
            $arrayParts = explode('.',$parts[1]);
            array_unshift($arrayParts,$file);

            $branch = &$tree;
            foreach($arrayParts as $level) 
            {
                $key = \yii\helpers\Inflector::camel2words($level, true);
                if(!isset($branch[$key])) {
                    $branch[$key] = [];
                }
                $branch = &$branch[$key];
            }
            //var_dump($branch);
            $modelClass = isset($value['class']) ? $value['class'] : __CLASS__;
            $branch = $value;
            $branch['_model'] = $modelClass::findOne($path);
            if(!$branch['_model']) {
                $branch['_model'] = new $modelClass;
                $branch['_model']->path = $path;
                $branch['_model']->value = self::getData($path);
            }
            
            //Set the rules if defined
            if(isset($value['rules'])) {
                foreach($value['rules'] as $rule) {
                    $branch['_model']->rules []= array_merge([["value"]], $rule);
                }
            }
            
            //insert postData if given
            if(isset($postData['Configs'][$path])) 
            {
                $branch['_model']->value = $postData['Configs'][$path];
                $branch['_model']->save();
            }
        }
        return $tree;
    }
    
    /**
     * Get a list of all configuration categories;
     * @return array
     */
    public static function getCategoriesArray()
    {
        $data = self::getFileData('_allow_db_override');
        $menu = [];
        foreach($data as $path => $value)
        {
            if(is_numeric($path)) {
                $path = $value;
                $value = [];
            }
            $parts = explode('/',$path);
            $key = \yii\helpers\Inflector::camel2words($parts[0]);
            $menu[$key] = [];
        }
        return array_keys($menu);
    }
}