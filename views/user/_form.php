<?php
use yii\widgets\ActiveForm;
/**
 * @var yii\web\View $this
 * @var snapcms\models\User $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="user-form row">
    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-md-10\">{input}\n{hint}\n{error}</div>",
            'labelOptions' => ['class' => 'col-md-2 control-label'],
        ]
    ]); ?>
        <div class="col-md-9">
            <?= $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>
            <?= $form->field($model, 'role')->textInput() ?>
            <?= $form->field($model, 'status')->textInput() ?>
        </div>
        <?= $this->render('/global/_form_sidebar') ?>
    <?php ActiveForm::end(); ?>
</div>
