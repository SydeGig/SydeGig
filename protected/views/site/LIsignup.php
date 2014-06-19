<?php
/* @var $this SiteController */
/* @var $model LISignupForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - LinkedInSignup';
$this->breadcrumbs=array(
	'LinkedInSignup',
);
?>

<h1>New User Signup through LinkedIn</h1>

<p>We got your info from LinkedIn! <br>, We just need to add a username and a password:</p>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'LIsignup-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); 
?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
            <!-- should it be a has value from the start?? -->
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
		<p class="hint">
			Hint: Your email address is a good username.
		</p>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Signup'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->