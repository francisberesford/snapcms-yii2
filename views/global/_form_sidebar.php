<?php
use yii\bootstrap\Nav;
?>
<div id="sidebar" class="col-md-3">
    <div class="panel panel-primary">
        <div class="panel-heading">
            Operations
        </div>
        <?php if(isset($showSaveButton) && $showSaveButton): ?>
        <div class="btn-group btn-group-vertical">
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-thumbs-up"></span> Save</button>
        </div>
        <?php endif; ?>
        <div class="btn-group btn-group-vertical">
            <?= Nav::widget([
                'encodeLabels' => false,
                'items' => isset($this->params['menu']) ? $this->params['menu'] : [],
                'options' => ['class' => 'nav nav-stacked'],
            ]); ?>
        </div>
    </div>
</div><!-- #sidebar -->