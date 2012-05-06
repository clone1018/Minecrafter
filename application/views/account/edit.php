<?php
if(!isset($user['name'])) $user['name'] = '';

?>
<?php if(validation_errors() != '') { ?>
		<div class="alert-message block-message error" data-alert="alert">
		<a class="close" href="#">&times;</a>
		<p><strong>Oh snap! You got an error!</strong> Change this and that and try again.</p>
		<ul>
			<?php echo str_replace(array('<p>', '</p>'), array('<li>', '</li>'), validation_errors()); ?>
		</ul>
	</div>	
<?php } ?>
<?php echo form_open('account/edit', array('class' => 'form-horizontal')); ?>

	<fieldset class="control-group">
		<label class="control-label" for="currentpassword">Current Password <span class="required">*</span></label>
		<div class="controls">
			<input class="xlarge" name="currentpassword" type="password"> 
		</div>
	</fieldset>

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

	<fieldset class="control-group">
		<label class="control-label" for="email">Email&nbsp;&nbsp;</label>
		<div class="controls">
			<input class="xlarge" name="email" type="email" value="<?php if(set_value('email') != '') echo set_value('email'); else echo $user['email']; ?>"> 
		</div>
	</fieldset>

	<fieldset class="control-group">
		<label class="control-label" for="mcname">Minecraft Name&nbsp;&nbsp;</label>
		<div class="controls">
			<input type="text" class="xlarge" name="mcname" value="<?php if(set_value('mcname') != '') echo set_value('mcname'); else echo $user['mcname']; ?>">
			<p class="help-block">This is case sensitive, and is used for several things.</p>
		</div>
	</fieldset>

	<fieldset class="control-group">
		<label class="control-label" for="name">Full Name&nbsp;&nbsp;</label>
		<div class="controls">
			<input class="xlarge" name="name" type="text" value="<?php if(set_value('name') != '') echo set_value('name'); else echo $user['name']; ?>"> 
		</div>
	</fieldset>

	<fieldset class="control-group">
		<label class="control-label" for="donate">Donate Link&nbsp;&nbsp;</label>
		<div class="controls">
			<input class="xlarge" name="donate" type="text" value="<?php if(set_value('donate') != '') echo set_value('donate'); elseif(isset($user['donate'])) echo $user['donate']; ?>"> 
			<p class="help-block">Appears on your mod/user/etc pages.</p>
		</div>
	</fieldset>

	<fieldset class="form-actions">
		<input type="submit" class="btn btn-primary" value="Change Values">
		<?php echo anchor('account', '&nbsp;Nevermind&nbsp;', array('class' => 'btn btn-danger')); ?>
	</fieldset>
</form>
