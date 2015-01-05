<?php
    use yii\helpers\Html;
?>
<div class="item">
    <?= Html::a($model->icon, ['media/show-file','id'=>$model->id], ['target'=>'_blank', 'data-pjax' => 0]) ?>
    <h4><?= $model->title ?></h4>
    <span class="ext"><?= $model->extension ?></span>
</div>
