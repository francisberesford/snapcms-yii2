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
        return [
            [['is_public', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['filename'], 'file'],
            [['mime_type', 'extension'], 'string', 'max' => 45]
        ];
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
        $dataDir = Yii::getAlias('@frontend/data');

        $dirPath = $dataDir . '/media';
        if (!file_exists($dirPath)) {
            mkdir($dirPath, 0777, true);
        }
        
        $filePath = $dirPath . '/' . $field . '_' . $this->id;

        if ($this->$field instanceof \yii\web\UploadedFile && !$this->$field->saveAs($filePath)) {
            $this->addError($field, Yii::t('snapcms', 'There was a problem uploading this file'));
        }

        $this->refresh(); //reload the uploaded attribute
    }
    
    public function getIcon()
    {
        $output = '';
        //var_dump($this->mime_type);
        switch($this->mime_type)
        {
            case 'text/plain':
                $output .= '<span class="fa fa-file-text-o"></span>';
                break;
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

}
