<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model snapcms\models\Media */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="media-form row">
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
        'layout' => 'horizontal',
    ]); ?>
    <div class="col-md-9">

        <?= $form->field($model, 'filename')->fileInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'title')->textInput(['maxlength' => 255])->hint('If left empty the filename will be used') ?>
        <?= $form->field($model, 'is_public')->checkbox()->hint('Should this item be available to the public, or be restricted to User Groups?') ?>

    </div>
    <?= $this->render('//global/_form_sidebar', ['showSaveButton'=>true]) ?>
    <?php ActiveForm::end(); ?>
</div>
