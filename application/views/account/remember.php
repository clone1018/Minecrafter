<?php if (validation_errors() != '') { ?>
	<div class="alert alert-block alert-error">
		<a class="close" href="#">&times;</a>
		<h3 class="alert-heading">Oh snap! You got an error!</h3>
		<ul>
			<?php echo str_replace(array('<p>', '</p>'), array('<li>', '</li>'), validation_errors()); ?>
		</ul>
	</div>	
<?php } ?>
<?php echo form_open(uri_string(), array('class' => 'form-horizontal')); ?>

	<fieldset class="control-group">
		<label class="control-label" for="password">New Password&nbsp;&nbsp;</label>
		<div class="controls">
			<input class="xlarge" name="password" type="password"> 
		</div>
	</fieldset>

	<fieldset class="control-group">
		<label class="control-label" for="password2">Confirm Password&nbsp;&nbsp;</label>
		<div class="controls">
			<input class="xlarge" name="password2" type="password"> 
		</div>
	</fieldset>

	<fieldset class="form-actions">
		<button type="submit" class="btn btn-primary btn-large">Forgot Password</button>
	</fieldset>
</form>