<?php 

use yii\bootstrap\Nav;

?>
<?php $this->beginContent('@snapcms/views/layouts/outer.php'); ?>
<div class="container-fluid">
    <?= $this->render('_page_top'); ?>
    <div class="row">
        <div class="col-lg-10 col-md-9">
            <?php echo $content; ?>
        </div>
        <div id="sidebar" class="col-lg-2 col-md-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Operations
                </div>
                <div>
                    <?= Nav::widget([
                        'encodeLabels' => false,
                        'items' => isset($this->params['menu']) ? $this->params['menu'] : [],
                        'options' => ['class' => 'nav nav-stacked'],
                    ]); ?>
                </div>
            </div>
        </div><!-- #sidebar -->
    </div>
</div>
<?php $this->endContent(); ?>