<?php
namespace snapcms\components;

use Yii;
use snapcms\models\Media;
use yii\web\UploadedFile;
use yii\helpers\Html;

trait MediaFiles
{
    public function beforeSave($insert)
    {
        foreach($this->_mediaFiles as $attribute => $config)
        {            
            if(empty($this->$attribute)) {
                $Media = new Media;
            } else {
                $Media = Media::findOne($this->$attribute);
            }
            
            //Our media item as dissapeared! (maybe from deletion in the media manager)
            if(!$Media) {
                $Media = new Media;
                $this->$attribute = null;
            }
            
            //Are we deleting?
            $formName = $this->formName();
            $name = '_delete_'.$attribute;
            $deleteMe = isset($_POST[$formName][$name]) ? $_POST[$formName][$name] : false;
            if($deleteMe) {
                $Media->delete();
                $this->$attribute = null;
            }
            
            $uploadFile = UploadedFile::getInstance($this, '_'.$attribute);
            if($uploadFile) 
            {
                $Media->filename = $uploadFile;
                $Media->mime_type = $uploadFile->type;
                $Media->extension = pathinfo($uploadFile->name, PATHINFO_EXTENSION);
                //FB - I guess we don't use titles when adding from the front end?
                //if(empty($Media->title)) {
                    //remove extension from the title
                    $Media->title = basename($uploadFile->name, '.'.$Media->extension);
                //}
                $Media->save();
                $Media->generateTags($this,  $attribute);
                $this->$attribute = $Media->id;
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

        foreach($this->_mediaFiles as $attribute => $config)
        {
            if(!empty($this->$attribute)) {
                $Media = Media::findOne($this->$attribute);
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
}
