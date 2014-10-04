<?php

use snapcms\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use snapcms\components\SnapCMSController;

$user = \Yii::$app->user;
$fluid = isset(\Yii::$app->controller->layoutFluid) && \Yii::$app->controller->layoutFluid === true ? '-fluid' : '';

/**
 * @var \yii\web\View $this
 * @var string $content
 */
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <?php
        NavBar::begin([
            'brandLabel' => Html::img(Yii::$app->assetManager->getPublishedUrl('@snapcms/assets') . '/images/snap-logo.png'),
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-static-top navbar-default',
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'activateParents' => true,
            'items' => SnapCMSController::$primaryMenu,
        ]);

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => 'Login', 'url' => ['/site/login'], 'visible' => $user->isGuest],
                [
                    'label' => 'Logout (' . ($user->identity ? $user->identity->username : '') . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post'],
                    'visible' => !$user->isGuest,
                ],
            ],
        ]);
        NavBar::end();
        ?>

        <div class="breadcrumb-area">
            <div class="container">
                <?=
                Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>
            </div>
        </div>

        <div class="content-area">
            <div class="container">
                
                <?php foreach (Yii::$app->session->getAllFlashes() as $key => $message): ?>
                <div class="alert alert-<?php echo $key ?> alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?php echo $message ?>
                </div>
                <?php endforeach; ?>
                
                <?php if(isset($this->params['header'])): ?>
                <div class="page-header">
                    <h1><?= $this->params['header'] ?><?= isset($this->params['headerSubtext']) ? ' <small>' . $this->params['headerSubtext'] . '</small>' : '' ?></h1>
                </div>
                <?php endif; ?>
                
                <?= $content ?>
            </div>
        </div>

        <footer>
            <div class="container">
                <p class="pull-left">&copy; 2014 <a href="http://www.snapfrozen.com">Snapfrozen</a> All Rights Reserved</p>
                <p class="pull-right"><?= Yii::powered() ?></p>
            </div>
        </footer>

<?php $this->endBody() ?>
        <script>$('a[title]').tooltip();</script>
    </body>
</html>
<?php $this->endPage() ?>
