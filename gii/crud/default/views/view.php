<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var yii\gii\generators\crud\Generator $generator
 */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var <?= ltrim($generator->modelClass, '\\') ?> $model
 */
 
 $this->params['menu'] = [
    [
        'label' => '<span class="glyphicon glyphicon-plus-sign"></span> ' . Yii::t('snapcms', 'Update {modelClass}', ['modelClass' => '<?= Inflector::camel2words(StringHelper::basename($generator->modelClass)) ?>']), 
        'url' => ['update', <?= $urlParams ?>]
    ],
    [
        'label' => '<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('snapcms', 'Delete {modelClass}', ['modelClass' => '<?= Inflector::camel2words(StringHelper::basename($generator->modelClass)) ?>']), 
        'url' => ['delete', <?= $urlParams ?>],
        'linkOptions' => [
            'class' => 'text-danger',
            'data' => [
                'confirm' => <?= $generator->generateString('Are you sure you want to delete this item?') ?>,
                'method' => 'post',
            ],
        ],
    ],
];

$this->title = $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['header'] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">

    <?= "<?= " ?>DetailView::widget([
        'model' => $model,
        'attributes' => [
<?php
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        echo "            '" . $name . "',\n";
    }
} else {
    foreach ($generator->getTableSchema()->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
    }
}
?>
        ],
    ]) ?>

</div>
