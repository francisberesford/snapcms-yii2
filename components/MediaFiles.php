<?php
namespace snapcms\components;

use Yii;
use yii\web\UploadedFile;

trait MediaFiles
{
    private $_mediaClass = '\snapcms\models\Media';
    
    public function processMediaFiles($forceNew = false)
    {
        $id = !empty($this->id) ? $this->id : 'new';

        foreach($this->_mediaFiles as $attribute => $config)
        {
            $class = isset($config['class']) ? $config['class'] : $this->_mediaClass;
            if($forceNew || empty($this->$attribute)) {
                $Media = new $class;
            } else {
                $Media = $class::findOne($this->$attribute);
            }
            
            //Our media item as dissapeared! (maybe from deletion in the media manager)
            if(!$Media) {
                $Media = new $class;
                $this->$attribute = null;
            }
            
            //Are we deleting?
            $formName = $this->formName();
            $name = '_delete_'.$attribute;
            $deleteMe = 
                (isset($_POST[$formName][$name]) && $_POST[$formName][$name]) || 
                (isset($_POST[$formName][$id][$name]) && $_POST[$formName][$id][$name]);
            
            if($deleteMe) {
                $Media->delete();
                $this->$attribute = null;
            }
            
            $uploadFile = UploadedFile::getInstance($this, '_'.$attribute);
            
            if(!$uploadFile) {
                $uploadFile = UploadedFile::getInstance($this, "[$id]_".$attribute);
            }
            
            if($uploadFile) 
            {
                $Media->filename = $uploadFile;
                $Media->mime_type = $uploadFile->type;
                $Media->extension = pathinfo($uploadFile->name, PATHINFO_EXTENSION);
                //FB - I guess we don't use titles when adding from the front end?
                //if(empty($Media->title)) {
                    //remove extension from the title
                    $Media->title = basename($uploadFile->name, '.' . $Media->extension) . ' (' . $this->id . ')';
                //}
                if($Media->save()) {
                    $Media->generateTags($this,  $attribute);
                }
                $this->$attribute = $Media->id;
            }
        }
    }
    
    public function beforeSave($insert, $forceNew = false)
    {
        $this->processMediaFiles($forceNew);
        
        return parent::beforeSave($insert);
    }
    
    public function afterSave($insert, $changedAttributes) 
    {
        parent::afterSave($insert, $changedAttributes);
        
        $field = 'filename';
        $dataDir = Yii::getAlias('@frontend/data');

        $dirPath = $dataDir . '/media';
        if (!file_exists($dirPath)) {
            mkdir($dirPath, 0777, true);
        }

        foreach($this->_mediaFiles as $attribute => $config)
        {
            $class = isset($config['class']) ? $config['class'] : $this->_mediaClass;
            if(!empty($this->$attribute)) {
                $Media = $class::findOne($this->$attribute);
            } else {
                continue;
            }
            
            //Record was probably deleted
            if(!$Media) {
                continue;
            }
            
            $filePath = $dirPath . "/{$field}_" . $Media->id;

            if ($Media->$field instanceof \yii\web\UploadedFile && !$Media->$field->saveAs($filePath)) {
                $this->addError($field, Yii::t('snapcms', 'There was a problem uploading this file'));
            }
            $Media->refresh(); //reload the uploaded attribute
        }
    }
    
    public function getMediaFilesConfig()
    {
        return $this->_mediaFiles;
    }
}
