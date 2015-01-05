<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model snapcms\models\Media */

$this->title = Yii::t('snapcms', 'Update {modelClass}: ', [
    'modelClass' => 'Media',
]) . ' ' . $model->title;

$this->params['header'] = $this->title;

$this->params['breadcrumbs'][] = ['label' => Yii::t('snapcms', 'Media'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('snapcms', 'Update');
?>
<div class="media-update">
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
