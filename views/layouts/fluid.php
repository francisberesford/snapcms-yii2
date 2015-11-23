<?php $this->beginContent('@snapcms/views/layouts/outer.php'); ?>
<div class="container-fluid">
    <?= $this->render('_page_top'); ?>
    <?= $content; ?>
</div>
<?php $this->endContent(); ?>