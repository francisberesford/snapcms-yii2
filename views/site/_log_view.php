<div class="alert alert-<?php echo \yii\log\Logger::getLevelName($model->level); ?>">
    <strong><?php echo $model->level ?> - <?php echo $model->category ?></strong> - 
    <span class="date"><?php echo Yii::$app->formatter->asDatetime($model->log_time) ?></span><br />
    <p>&nbsp;</p>
    <pre><?php echo $model->message; ?></pre>
</div>