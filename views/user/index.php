<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var snapcms\models\search\UserSearch $searchModel
 */
 
$this->params['menu'] = [
    [
        'label' => '<span class="glyphicon glyphicon-plus-sign"></span> ' . Yii::t('snapcms', 'Create {modelClass}', ['modelClass' => 'User']), 
        'visible' => \Yii::$app->user->can('Create User'),
        'url' => ['create']
    ],
];

$this->title = Yii::t('snapcms', 'Users');
$this->params['breadcrumbs'][] = $this->title;
$this->params['header'] = $this->title;
?>
<div class="user-index">
    
    <div class="panel panel-primary">
        <div class="panel-heading">
            &nbsp;
        </div>
        <div class="panel-body">

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class'=>'table'],
                'layout' => "{items}\n{summary}\n{pager}",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'id',
                    'username',
                    'email:email',
                    // 'role',
                    // 'status',
                    'created_at:datetime',
                    //'updated_at:datetime',
                    //@todo: FB - Extend ActionColumn to provide a visibility setting
                    ['class' => 'yii\grid\ActionColumn', 'contentOptions' => ['class'=>'button-column'],
                        'buttons' => [
                            'view' => function ($url, $model) {
                                if(!\Yii::$app->user->can('View User')) {
                                    return '';
                                }
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                    'title' => Yii::t('yii', 'View'),
                                    'data-pjax' => '0',
                                ]);
                            },
                            'update' => function ($url, $model) {
                                if(!\Yii::$app->user->can('Update User')) {
                                    return '';
                                }
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                    'title' => Yii::t('yii', 'Update'),
                                    'data-pjax' => '0',
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                if(!\Yii::$app->user->can('Delete User')) {
                                    return '';
                                }
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                    'title' => Yii::t('yii', 'Delete'),
                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    'data-method' => 'post',
                                    'data-pjax' => '0',
                                ]);
                            },
                        ]
                    ],
                ],
            ]);  ?>

        </div>
    </div>
</div>
