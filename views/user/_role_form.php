<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var snapcms\models\User $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="role-form row">
    <?php $form = ActiveForm::begin(); ?>
        <div class="col-md-9">
            <?= Html::label('Role Name', 'role', ['class' => 'control-label']) ?>
            <?= Html::textInput('role', isset($role) ? $role->name : '', ['class' => 'form-control']); ?>
        </div>
        <?= $this->render('/global/_form_sidebar') ?>
    <?php ActiveForm::end(); ?>
</div>
