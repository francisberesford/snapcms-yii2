<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var snapcms\models\User $model
 */

$this->title = Yii::t('snapcms', 'Update {modelClass}', [
  'modelClass' => 'User',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('snapcms', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('snapcms', 'Update');

$this->params['header'] = $this->title;
$this->params['headerSubtext'] = $model->username;

$this->params['menu'] = [
    [
        'label' => '<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('snapcms', 'Delete {modelClass}', ['modelClass' => 'User']), 
        'url' => ['delete', 'id' => $model->id],
        'linkOptions' => [
            'class' => 'text-danger',
            'data' => [
                'confirm' => Yii::t('snapcms', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ],
    ],
];

?>
<div class="user-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
