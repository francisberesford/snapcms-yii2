<?php foreach (Yii::$app->session->getAllFlashes() as $key => $message): ?>
    <div class="alert alert-<?php echo $key ?> alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php if(is_array($message)) :?>
        <?php foreach($message as $m) : ?>
            <?php echo $m; ?><br />
        <?php endforeach; ?>
        <?php else : ?>
            <?php echo $message; ?>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

<?php if(isset($this->params['header'])): ?>
<div class="page-header">
    <h1><?= $this->params['header'] ?><?= isset($this->params['headerSubtext']) ? ' <small>' . $this->params['headerSubtext'] . '</small>' : '' ?></h1>
</div>
<?php endif; ?>