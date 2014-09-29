<?php 

use yii\bootstrap\Nav;

?>
<?php $this->beginContent('@snapcms/views/layouts/main.php'); ?>
<div class="row">
    <div class="col-md-9">
        <?php echo $content; ?>
    </div>
    <div id="sidebar" class="col-md-3">
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
<?php $this->endContent(); ?>