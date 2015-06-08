<?php
namespace snapcms\components;

use Yii;
use yii\helpers\Html;
use snapcms\models\Media;

trait MediaField
{
    /**
     * @var string the template for SnapCMS media files in default layout
     */
    public $mediaTemplate = "{beginLabel}{labelTitle}<br />{hint}{endLabel}{beginWrapper}<div class=\"media-item\">{icon}</div>{delete}{input}{error}{endWrapper}";
    
    public function media($options = [])
    {
        $model = $this->model;
        $attribute = $this->attribute;
        
        if (!preg_match('/(^|.*\])([\w\.]+)(\[.*|$)/', $attribute, $matches)) {
            throw new InvalidParamException('Attribute name must contain word characters only.');
        }
        $prefix = $matches[1];
        $attributeClean = $matches[2];
        $suffix = $matches[3];
        
        Html::removeCssClass($this->inputOptions, 'form-control');
        if ($this->inputOptions !== ['class' => 'form-control']) {
            $options = array_merge($this->inputOptions, $options);
        }
        $this->adjustLabelFor($options);
        
        if(!isset($options['name'])) {
            $options['name'] = Html::getInputName($model, $prefix.'_'.$attributeClean.$suffix);
        }
        $this->parts['{input}'] = 
            Html::activeHiddenInput($model, $attribute).
            Html::activeInput('file', $model, $attribute, $options);
        
        $Model = Media::findOne($model->$attributeClean);
        if($Model) {
            $this->parts['{icon}'] = $this->form->getView()->render('@snapcms/views/media/_media_item_frontend', ['model' => $Model]);
            $deleteName = Html::getInputName($model, $prefix.'_delete_'.$attributeClean.$suffix);
            $this->parts['{delete}'] = Html::label(Html::checkbox($deleteName).' '.Yii::t('snapcms', 'Delete?'));
        } else {
            $this->parts['{icon}'] = '';
            $this->parts['{delete}'] = '';
        }
        
        if (!isset($options['template'])) {
            $this->template = $this->mediaTemplate;
        } else {
            $this->template = $options['template'];
            unset($options['template']);
        }

        return $this;
    }
}
