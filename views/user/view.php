<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var snapcms\models\User $model
 */
 
$this->params['menu'] = [
    [
        'label' => '<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('snapcms', 'Update {modelClass}', ['modelClass' => 'User']), 
        'url' => ['update', 'id' => $model->id]
    ],
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

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('snapcms', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['header'] = $this->title;
?>
<div class="user-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            'email:email',
            'role',
            'status',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
