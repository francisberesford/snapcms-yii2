<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\menu;
use snapcms\models\Tag;

/* @var $this yii\web\View */
/* @var $searchModel snapcms\models\search\MediaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('snapcms', 'Media');
$this->params['header'] = Html::encode($this->title);
$this->params['breadcrumbs'][] = $this->title;

$this->params['menu'] = [
    [
        'label' => '<span class="glyphicon glyphicon-plus-sign"></span> ' . Yii::t('snapcms', 'New Media Item'), 
        'url' => ['media/create'],
        'visible' => Yii::$app->user->can('Create Content'),
    ],
];

?>
<div class="media-index">

    <div class="row">
        <div class="col-md-9">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                //'options' => ['class' => 'panel-body'],
                'itemOptions' => ['class' => 'media-item col-md-3'],
                'itemView' => '_media_item',
                'layout' => "<div class=\"row\">{items}</div>\n{summary}\n{pager}",
            ]); ?>
        </div>
        <?= $this->render('//global/_form_sidebar') ?>
        <div id="sidebar" class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Filter
                </div>
                <div class="panel-body">
                    <?= Menu::widget([
                        'items' => array_merge([['label' => 'None', 'url' => ['media/index']]] , Tag::getList())
                    ]); ?>
                </div>
            </div>
        </div>
    </div>

</div>
