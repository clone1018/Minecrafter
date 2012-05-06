<p>Sadly old Minecrafter accounts aren't compatable with new Minecrafter accounts, but you can easily convert your account by using the form below or you can <?php echo anchor('account/reset', 'reset your account'); ?> (if you don't remember your old password).</p>

<?php if (validation_errors() != '') { ?>
	<div class="alert-message block-message error" data-alert="alert">
		<a class="close" href="#">&times;</a>
		<p><strong>Oh snap! You got an error!</strong></p>
		<ul>
			<?php echo str_replace(array('<p>', '</p>'), array('<li>', '</li>'), validation_errors()); ?>
		</ul>
	</div>	
<?php } ?>
<?php echo form_open('account/convert'); ?>
	<div class="clearfix">
		<label for="username">Username <span class="required">*</span></label>
		<div class="input">
			<input class="xlarge" id="username" name="username" size="30" type="text" value="<?php echo set_value('username'); ?>">
		</div>
	</div><!-- /clearfix -->
	<div class="clearfix">
		<label for="oldpassword">Old Password <span class="required">*</span></label>
		<div class="input">
			<input class="xlarge" id="oldpassword" name="oldpassword" size="30" type="password">
		</div>
	</div><!-- /clearfix -->
	<div class="clearfix">
		<label for="password">New Password <span class="required">*</span></label>
		<div class="input">
			<input class="xlarge" id="password" name="password" size="30" type="password">
		</div>
	</div><!-- /clearfix -->
	<div class="clearfix">
		<label for="confirmpass">Repeat Password <span class="required">*</span></label>
		<div class="input">
			<input class="xlarge" id="confirmpass" name="confirmpass" size="30" type="password">
		</div>
	</div><!-- /clearfix -->
	<div class="actions">
		<input type="submit" class="btn btn-primary btn-large" value="Convert Account">
	</div>
</form>