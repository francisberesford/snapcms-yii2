<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model snapcms\models\Media */

$this->title = Yii::t('snapcms', 'Create {modelClass}', [
    'modelClass' => 'Media',
]);
$this->params['header'] = $this->title;

$this->params['breadcrumbs'][] = ['label' => Yii::t('snapcms', 'Media'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="media-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
