<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Signup';
$this->breadcrumbs=array(
	'Signup',
);
?>

<h1>New User Signup</h1>

<p>Please fill out the following form with your desired login credentials:</p>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'signup-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>
        <div class="row">
		<?php echo $form->labelEx($model,'First Name'); ?>
		<?php echo $form->textField($model,'fname'); ?>
		<?php echo $form->error($model,'fname'); ?>
	</div>
        <div class="row">
		<?php echo $form->labelEx($model,'Last Name'); ?>
		<?php echo $form->textField($model,'lname'); ?>
		<?php echo $form->error($model,'lname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
		<p class="hint">
			Hint: Your email address is a good username.
		</p>
	</div>

	<div class="row rememberMe">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Signup'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
