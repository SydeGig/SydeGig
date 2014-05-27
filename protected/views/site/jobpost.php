<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - JobPost';
$this->breadcrumbs=array(
	'JobPost',
);
?>

<h1>New Job Post</h1>

<p>Please fill in the information for the job you'd like done:</p>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'job-post-form',
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
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title'); ?>
		<?php echo $form->error($model,'title'); ?>
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
