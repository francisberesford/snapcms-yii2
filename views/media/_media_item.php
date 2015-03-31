<?php
    use yii\helpers\Html;
?>
<div class="panel">
    <?= Html::a($model->icon, Yii::$app->urlManagerFrontend->createUrl(['media/show-file','id'=>$model->id])) ?>
    <h4><?= $model->title ?></h4>
    <span class="ext"><?= $model->extension ?></span>
    
    <span class="actions">
        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['media/update','id'=>$model->id]) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['media/delete','id'=>$model->id], [
            'data' => [
                'confirm' => Yii::t('pvsell', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ]
        ]); ?>
    </span>
    
    <a data-pjax="0" title="" data-original-title="Update"></a> 
    <a data-pjax="0" data-method="post" data-confirm="Are you sure you want to delete this item?" title="" data-original-title="Delete"></a></td>
    
</div>
