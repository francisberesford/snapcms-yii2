<?php
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var snapcms\ConfigSearch $searchModel
 * @var \yii\rbac\ManagerInterface $auth
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Inflector;
use snapcms\models\User;

$this->params['menu'] = [
    [
        'label' => '<span class="glyphicon glyphicon-plus-sign"></span> ' . Yii::t('snapcms', 'Create Role'), 
        'url' => ['create-role']
    ],
];

if(!User::isSystemRole($currentRole)) 
{
    $this->params['menu'][] = [
        'label' => '<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('snapcms', 'Delete {modelClass}', ['modelClass' => 'Role']), 
        'url' => ['user/delete-role', 'role' => $currentRole],
        'linkOptions' => [
            'class' => 'text-danger',
            'data' => [
                'confirm' => Yii::t('snapcms', 'Are you sure you want to delete this role?'),
                //'method' => 'post',
            ],
        ],
    ];
}

$this->title = Yii::t('snapcms', 'Groups');
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['config/index']];
$this->params['breadcrumbs'][] = $currentRole;

$this->params['header'] = $this->title;
$this->params['headerSubtext'] = $currentRole;
$current_role = $auth->getRole($currentRole);
?>
<?php $form = ActiveForm::begin(); ?>
<div class="config-index row">
    
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                Roles
            </div>
            <ul class="nav nav-pills nav-stacked" role="tablist">
                <?php foreach($roleNames as $role): ?>
                <li class="<?= $role == $currentRole ? 'active' : '' ?>">
                    <?= Html::a($role, ['user/groups', 'role' => $role ]) ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    
    <div class="col-md-6">
        <?php foreach($rootPermissions as $groupPerm => $groupData): ?>
        <fieldset>
            <legend><?= $groupPerm?></legend>
            <?php foreach($auth->getChildren($groupPerm) as $perm => $data): ?>
            <div class="checkbox clearfix">
                <?php $name = "auth[$currentRole][$perm]"; ?>
                <?php $id = Inflector::slug($name); ?>
                <label for="<?= $id ?>" class="col-md-6">
                    <?= Html::checkbox($name, $auth->hasChild($current_role, $data), ['id' => $id, 'uncheck' => '0'] ); ?>
                    <?= $perm ?>
                </label>
                <span class="col-md-6 text-muted"><?= $data->description ?></span>
            </div>
            <?php endforeach; ?>
        </fieldset>
        <?php endforeach; ?>
    </div>
    
    <?= $this->render('//global/_form_sidebar',['showSaveButton'=>true]) ?>
</div>
<?php ActiveForm::end(); ?>
