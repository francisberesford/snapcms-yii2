<?php
use yii\helpers\Inflector;
use yii\helpers\ArrayHelper;

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

    <?php $method   = ArrayHelper::getValue($data, 'input.method', 'textInput'); ?>
    <?php $params   = ArrayHelper::getValue($data, 'input.params', []); ?>
    <?php $label    = ArrayHelper::getValue($data, 'input.label', $heading); ?>
    <?php $hint     = ArrayHelper::getValue($data, 'input.hint', null) ?>
    <?php $template = ArrayHelper::getValue($data, 'input.template', "{label}\n<div class=\"col-md-9\">{input}\n{hint}\n{error}</div>") ?>

    <?php $input = $form->field($data['_model'], 'value'); ?>
    <?php $input->inputOptions['name'] = 'Configs[' . $data['_model']->path . ']'; ?>
    <?php $input->inputOptions['id'] = Inflector::slug($data['_model']->path); ?>
    <?php $input->labelOptions['class'] = 'control-label col-md-3' ?>
    <?php $input->template = $template; ?>
    <?= call_user_func_array([$input, $method], $params)->label($label)->hint($hint); ?>

<?php endif; ?>