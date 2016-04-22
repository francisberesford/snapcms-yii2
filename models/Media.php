<?php

namespace snapcms\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%media}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $filename
 * @property string $mime_type
 * @property string $extension
 * @property integer $is_public
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class Media extends \yii\db\ActiveRecord
{
    public $mediaRules = [
        [['is_public', 'is_tmp', 'created_by', 'updated_by'], 'integer'],
        [['created_at', 'updated_at'], 'safe'],
        [['title', 'mime_type'], 'string', 'max' => 255],
        [['filename'], 'file'],
        [['extension'], 'string', 'max' => 45]
    ];
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%media}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return $this->mediaRules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('snapcms', 'ID'),
            'title' => Yii::t('snapcms', 'Title'),
            'filename' => Yii::t('snapcms', 'Filename'),
            'mime_type' => Yii::t('snapcms', 'Mime Type'),
            'extension' => Yii::t('snapcms', 'Extension'),
            'is_public' => Yii::t('snapcms', 'Is Public'),
            'is_tmp' => Yii::t('snapcms', 'Is Temporary'),
            'created_at' => Yii::t('snapcms', 'Created At'),
            'updated_at' => Yii::t('snapcms', 'Updated At'),
            'created_by' => Yii::t('snapcms', 'Created By'),
            'updated_by' => Yii::t('snapcms', 'Updated By'),
        ];
    }
    
    public function beforeSave($insert) 
    {
        $field = 'filename';
        $uploadFile = UploadedFile::getInstance($this, $field);

        if ($uploadFile) 
        {
            $this->$field = $uploadFile;
            $this->mime_type = $uploadFile->type;
            $this->extension = pathinfo($uploadFile->name, PATHINFO_EXTENSION);
            if(empty($this->title)) {
                $this->title = basename($uploadFile->name, '.'.$this->extension);
            }
        }

        return parent::beforeSave($insert);
    }
    
    public function afterSave($insert, $changedAttributes) 
    {
        parent::afterSave($insert, $changedAttributes);

        $field = 'filename';

        $dirPath = $this->dir_path;
        if (!file_exists($dirPath)) {
            mkdir($dirPath, 0777, true);
        }
        if ($this->$field instanceof \yii\web\UploadedFile && !$this->$field->saveAs($this->file_path)) {
            $this->addError($field, Yii::t('snapcms', 'There was a problem uploading this file'));
        }

        $this->refresh(); //reload the uploaded attribute
    }
    
    public function getIcon()
    {
        $output = '';
        switch($this->mime_type)
        {
            case 'text/plain':
                $output .= '<span class="fa fa-file-text-o"></span>';
                break;
            case 'text/csv':
            case 'application/vnd.ms-excel':
            case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                $output .= '<span class="fa fa-file-excel-o"></span>';
                break;
            case 'application/pdf':
                $output .= '<span class="fa fa-file-pdf-o"></span>';
                break;
            case 'image/jpeg':
            case 'image/png':
            case 'image/gif':
                $output .= '<span class="fa fa-file-image-o"></span>';
                break;
            default:
                $output .= '<span class="fa fa-file-o"></span>';
                break;
        }
        
        return $output;
    }
    
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('{{%media_tags}}', ['media_id' => 'id']);
    }
    
    public function hasTag($Tag)
    {
        $query = $this->getTags();
        $query->where(['{{%tags}}.id' => $Tag->id]);
        return $query->count() ? true : false;
    }

    public function generateTags($model, $attribute)
    {
        $name = (new \ReflectionClass($model))->getShortName();
        $ParentTag = Tag::findOne(['name' => $name]);
        if(!$ParentTag) 
        {
            $ParentTag = new Tag();
            $ParentTag->name = $name;
            $ParentTag->save();
        }
        
        if(!$this->hasTag($ParentTag)) {
            $this->link('tags', $ParentTag);
        }
        
        $attrName = $model->getAttributeLabel($attribute);
        $ChildTag = Tag::findOne(['parent' => $ParentTag->id, 'name' => $attrName]);
        if(!$ChildTag) 
        {
            $ChildTag = new Tag();
            $ChildTag->name = $attrName;
            $ChildTag->parent = $ParentTag->id;
            $ChildTag->save();
        }
        if(!$this->hasTag($ChildTag)) {
            $this->link('tags', $ChildTag);
        }
    }
    
    public function getDir_path()
    {
        $dataDir = Yii::getAlias('@frontend/data');
        return $dataDir . '/media';
    }
    
    public function getFile_path() 
    {
        return $this->dir_path . '/filename_' . $this->id;
    }
    
    public function isCsv()
    {
        $mimes = ['text/plain','text/csv','text/tsv'];
        return in_array($this->mime_type, $mimes);
    }
    
    public function getCsvData()
    {
        return self::readCsvData($this->file_path);
    }
    
    public static function readCsvData($filepath) 
    {
        ini_set('auto_detect_line_endings', true);
        $file = @fopen($filepath, "r");
        if(!$file)
            return false;
     
        $data = [];
        while(!feof($file)) {
            $line = fgetcsv($file);
            if($line) {
                $data[] = $line;
            }
        }
        ini_set('auto_detect_line_endings', false);
        return $data;
    }
    
    public function duplicate()
    {   
        $NewMedia = new self;
        $NewMedia->attributes = $this->attributes;
        $NewMedia->id = null;
        $NewMedia->save();
        
        if(file_exists($this->file_path)) {
            copy($this->file_path, $NewMedia->file_path);
        }
        
        return $NewMedia;
    }

}