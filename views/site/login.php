<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var \frontend\models\LoginForm $model
 */
$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<div class="site-login panel panel-default">
			<div class="panel-heading">
				<?= Html::encode($this->title) ?>
			</div>
			<div class="panel-body">
				<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
					<?= $form->field($model, 'username')->label('Username or Email') ?>
					<?= $form->field($model, 'password')->passwordInput() ?>
					<?= $form->field($model, 'rememberMe')->checkbox() ?>
					<div class="form-group">
						<?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
					</div>
				<?php ActiveForm::end(); ?>
			</div>
		</div>
    </div>
</div>
