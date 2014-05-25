<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - BusinessSignup';
$this->breadcrumbs=array(
	'BusinessSignup',
);
?>

<h1>New Business Signup</h1>

<p>Please fill out the following form with your desired login credentials:</p>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'business-signup-form',
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
		<?php echo $form->labelEx($model,'businessName'); ?>
		<?php echo $form->textField($model,'businessName'); ?>
		<?php echo $form->error($model,'businessName'); ?>
	</div>
        <div class="row">
		<?php echo $form->labelEx($model,'industry'); ?>
		<?php echo $form->textField($model,'industry'); ?>
		<?php echo $form->error($model,'industry'); ?>
	</div>

	<div class="row">
            <!-- should it be a has value from the start?? -->
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
		
	</div>
        

	<div class="row buttons">
		<?php echo CHtml::submitButton('Signup'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
