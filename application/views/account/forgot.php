<?php if (validation_errors() != '') { ?>
	<div class="alert alert-block alert-error">
		<a class="close" href="#">&times;</a>
		<h3 class="alert-heading">Oh snap! You got an error!</h3>
		<ul>
			<?php echo str_replace(array('<p>', '</p>'), array('<li>', '</li>'), validation_errors()); ?>
		</ul>
	</div>	
<?php } ?>
<?php if(isset($sent)) echo "<p>Email sent!</p>"; else { ?>
<?php echo form_open('account/forgot', array('class' => 'form-horizontal')); ?>
	<fieldset class="control-group">
		<label class="control-label" for="email">Email <span class="required">*</span></label>
		<div class="controls">
			<input type="text" class="xlarge" name="email">
		</div>
	</fieldset>
	<fieldset class="form-actions">
		<button type="submit" class="btn btn-primary btn-large">Forgot Password</button>
	</fieldset>
</form>
<?php } ?>