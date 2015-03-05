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
            <ul class="nav nav-tabs">
                <li class="active"><a href="#details" data-toggle="tab">Details</a></li>
                <li><a href="#groups" data-toggle="tab">Groups</a></li>
            </ul>
            <div class="tab-content">
                <div id="details" class="tab-pane active">
                    <?= $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>
                    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>
                    <?= $form->field($model, 'role')->textInput() ?>
                    <?= $form->field($model, 'status')->textInput() ?>
                </div>
                <div id="groups" class="tab-pane">
                    <div class="form-group">
                        <?php //echo CHtml::checkBoxList('UserGroups', CHtml::listData($userGroups, 'name', 'name'), CHtml::listData($groups, 'name', 'name'));?>
                    </div>
                </div>
            </div>
        </div>
        <?= $this->render('//global/_form_sidebar', ['showSaveButton' => true]) ?>
    <?php ActiveForm::end(); ?>
</div>
