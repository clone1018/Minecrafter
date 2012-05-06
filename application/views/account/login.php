<p>If you had an account on the old Minecrafter, it'll work fine here!</p>
<?php if (validation_errors() != '') { ?>
	<div class="alert alert-block alert-error">
		<a class="close" href="#">&times;</a>
		<h3 class="alert-heading">Oh snap! You got an error!</h3>
		<ul>
			<?php echo str_replace(array('<p>', '</p>'), array('<li>', '</li>'), validation_errors()); ?>
		</ul>
	</div>	
<?php } ?>
<?php echo form_open('account/login', array('class' => 'form-horizontal')); ?>
	<legend>Your Login Information</legend>
	<fieldset class="control-group">
		<label class="control-label" for="username">Username <span class="required">*</span></label>
		<div class="controls">
			<input type="text" class="xlarge" name="username">
		</div>
	</fieldset>
	<fieldset class="control-group">
		<label class="control-label" for="password">Password <span class="required">*</span></label>
		<div class="controls">
			<input type="password" class="xlarge" name="password">
		</div>
	</fieldset>
	<fieldset class="form-actions">
		<button type="submit" class="btn btn-primary btn-large">Login</button>
		<a href="/account/forgot" class="btn btn-danger">Forgot Password</a>
	</fieldset>
</form>