<div id="termsmodal" class="modal hide fade">
	<div class="modal-header">
		<a href="#" class="close" data-dismiss="modal" >&times;</a>
		<h3>Terms of Service</h3>
	</div>
	<div class="modal-body" style="height: 350px; overflow: scroll;">
		<?php echo $this->load->view('root/terms', null, true); ?>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn btn-primary" data-dismiss="modal">Done</a>
	</div>
</div>

<?php if (validation_errors() != '') { ?>
	<div class="alert-message block-message error" data-alert="alert">
		<a class="close" href="#">&times;</a>
		<p><strong>Oh snap! You got an error!</strong> Change this and that and <a href="#">try again</a>.</p>
		<ul>
			<?php echo str_replace(array('<p>', '</p>'), array('<li>', '</li>'), validation_errors()); ?>
		</ul>
	</div>	
<?php } ?>
<p>Required fields are marked by <span class="required">*</span>.</p>
<?php echo form_open('account/register', array('class' => 'form-horizontal')); ?>

	<fieldset class="control-group">
		<label class="control-label" for="mcname">Minecraft Name&nbsp;&nbsp;</label>
		<div class="controls">
			<input type="text" class="xlarge" name="mcname" value="<?php echo set_value('mcname'); ?>">
			<p class="help-block">This is case sensitive, and is used for several things.</p>
		</div>
	</fieldset>

	<fieldset class="control-group">
		<label class="control-label" for="username">Username <span class="required">*</span></label>
		<div class="controls">
			<input type="text" class="xlarge" name="username" value="<?php echo set_value('username'); ?>">
		</div>
	</fieldset>

	<fieldset class="control-group">
		<label class="control-label" for="password">Password <span class="required">*</span></label>
		<div class="controls">
			<input type="password" class="xlarge" name="password" value="<?php echo set_value('password'); ?>">
		</div>
	</fieldset>

	<fieldset class="control-group">
		<label class="control-label" for="confirmpass">Confirm Password <span class="required">*</span></label>
		<div class="controls">
			<input type="password" class="xlarge" name="confirmpass" value="<?php echo set_value('confirmpass'); ?>">
		</div>
	</fieldset>

	<fieldset class="control-group">
		<label class="control-label" for="email">Email <span class="required">*</span></label>
		<div class="controls">
			<input type="text" type="email" class="xlarge" name="email" value="<?php echo set_value('email'); ?>">
		</div>
	</fieldset>

	<fieldset class="control-group">
		<label class="control-label" for="name">Full Name&nbsp;&nbsp;</label>
		<div class="controls">
			<input type="text" type="text" class="xlarge" name="name" value="<?php echo set_value('name'); ?>">
		</div>
	</fieldset>

	<fieldset class="control-group">
		<label class="control-label" for="optionsCheckboxes">Options&nbsp;&nbsp;</label>
		<div class="controls">
			<label class="checkbox">
				<input type="checkbox" name="terms" value="off">
				I accept the <a data-toggle="modal" href="#termsmodal">Terms of the Service</a>.
			</label>
			<label class="checkbox">
				<input type="checkbox" name="newsletter" value="off">
				I would like to recieve the weekly update newsletter.
			</label>
		</div>
	</fieldset>
	<fieldset class="form-actions">
		<button type="submit" class="btn btn-large btn-primary">Register</button>
		<a href="/account/forgot" class="btn btn-danger">Forgot Password</a>
	</fieldset>
</form>