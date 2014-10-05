<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var yii\gii\generators\crud\Generator $generator
 */

/** @var \yii\db\ActiveRecord $model */
$model = new $generator->modelClass;
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var <?= ltrim($generator->modelClass, '\\') ?> $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form row">
    <?= "<?php " ?>$form = ActiveForm::begin(); ?>
        <div class="col-md-9">

<?php foreach ($safeAttributes as $attribute) {
    echo "      <?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
} ?>
        </div>
    <?= "<?= \$this->render('//global/_form_sidebar', ['showSaveButton' => true]) ?>" ?>
    <?= "<?php " ?>ActiveForm::end(); ?>
</div>
