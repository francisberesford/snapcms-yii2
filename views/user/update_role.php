<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var snapcms\models\User $model
 */

$this->title = Yii::t('snapcms', 'Update Role');
$this->params['breadcrumbs'][] = ['label' => Yii::t('snapcms', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['header'] = $this->title;
$this->params['headerSubtext'] = $role->name;
?>
<div class="user-create">

    <?= $this->render('_role_form', [
        'role' => $role,
    ]) ?>

</div>
