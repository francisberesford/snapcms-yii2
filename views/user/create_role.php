<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var snapcms\models\User $model
 */

$this->title = Yii::t('snapcms', 'Create {modelClass}', [
  'modelClass' => 'Role',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('snapcms', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['header'] = $this->title;
?>
<div class="user-create">

    <?= $this->render('_role_form') ?>

</div>
