<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\log\Logger;
/**
 * @var yii\web\View $this
 */
$this->title = 'Logs';

$selectedCat = $selectedLevel ? ucwords(Logger::getLevelName($selectedLevel)) : 'All';

$this->params['menu'] = [
    [
        'label' => '<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('snapcms', 'Clear Logs'), 
        'url' => ['site/clear-logs'],
        'visible' => Yii::$app->user->can('Clear Logs'),
    ],
];

$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['site/logs']];
$this->params['breadcrumbs'][] = $selectedCat;

$this->params['header'] = $this->title;
//$this->params['headerSubtext'] = $selectedCat;
?>
<div class="snap-tabs site-logs row">
    <div class="col-md-9">
        <ul class="nav nav-tabs">
            <li class="<?php echo $selectedLevel===null ? 'active' : '' ?>"><?php echo Html::a('All', ['site/logs']) ?></li>
            <?php foreach($levels as $level): ?>
            <li class="<?php echo $level==$selectedLevel ? 'active' : '' ?>"><?php echo Html::a(ucwords(Logger::getLevelName($level)),['site/logs','level'=>$level]) ?></li>
            <?php endforeach; ?>
        </ul>
        
        <div class="panel panel-default">
            <?php echo ListView::widget([
                'dataProvider' => $dataProvider,
                'options' => ['class' => 'panel-body'],
                'itemOptions' => ['class' => 'item'],
                'itemView' => '_log_view',
                'layout' => "{items}\n{summary}\n{pager}",
            ]) ?>
        </div>
    </div>
    <?= $this->render('/global/_form_sidebar') ?>
</div>
