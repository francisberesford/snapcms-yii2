<?php
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var snapcms\ConfigSearch $searchModel
 */

//use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('snapcms', 'Settings');
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['config/index']];
$this->params['breadcrumbs'][] = $category;

$this->params['header'] = $this->title;
$this->params['headerSubtext'] = $category;

$first = array_keys($configData)[0];
?>
<?php $form = ActiveForm::begin(); ?>
<div class="config-index row">
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                Categories
            </div>
            <ul class="nav nav-pills nav-stacked" role="tablist">
                <?php foreach($menuItems as $file): ?>
                <li class="<?= $file == $category ? 'active' : '' ?>">
                    <?= Html::a($file, ['config/index','category' => $file ]) ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-horizontal">
            <?= $this->render('_category_panel', [
                'data' => $configData,
                'heading' => $category,
                'form' => $form,
                'level' => 1,
            ]) ?>
        </div>
    </div>
    <?= $this->render('//global/_form_sidebar',['showSaveButton' => true]) ?>
</div>
<?php ActiveForm::end(); ?>
