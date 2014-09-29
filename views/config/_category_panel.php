<?php
use yii\helpers\Html;
use yii\widgets\ActiveField;

/**
 * @var yii\web\View $this
 * @var snapcms\models\Config $model
 * @var yii\widgets\ActiveForm $form
 */
?>
<?php if(is_array($data) && !isset($data['_model'])): ?>
    
    <?php if($level !== 1): ?>
    <fieldset>
        <legend><?= $heading ?></legend>
    <?php endif ;?>
        
    <?php foreach($data as $subcat => $newData): ?>
    
    <?= $this->render('_category_panel', [
        'data' => $newData,
        'heading' => $subcat,
        'form' => $form,
        'level' => $level+1,
    ]) ?>
    
    <?php endforeach; ?>
        
    <?php if($level !== 1): ?>
    </fieldset>
    <?php endif ;?>

<?php else: ?>

    <?php $params = []; ?>
    <?php $method = isset($data['input']['method']) ? $data['input']['method'] : 'textInput'; ?>
    <?php if(isset($data['input']['params'])) { 
        $params = $data['input']['params'];
    } ?>

    <?php $input = $form->field($data['_model'], 'value'); ?>
    <?php $input->inputOptions['name'] = 'Configs[' . $data['_model']->path . ']'; ?>
    <?php $input->inputOptions['id'] = \yii\helpers\Inflector::slug($data['_model']->path); ?>
    <?php $input->labelOptions['class'] = 'control-label col-md-3' ?>
    <?php $input->template = "{label}\n<div class=\"col-md-9\">{input}\n{hint}\n{error}</div>"; ?>
    <?= call_user_func_array([$input, $method], $params)->label($heading); ?>

<?php endif; ?>