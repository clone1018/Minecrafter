<p>Required fields are marked by <span class="required">*</span>.</p>
<?php echo form_open_multipart(uri_string(), array('class' => 'form-horizontal')); ?>

	<?php if (isset($error))
		echo($error['error']); ?>
	<?php if (validation_errors() != '') { ?>
		<div class="alert-message block-message error" data-alert="alert">
			<a class="close" href="#">&times;</a>
			<p><strong>Oh snap! You got an error!</strong> Change this and that and <a href="#">try again</a>.</p>
			<ul>
				<?php echo str_replace(array('<p>', '</p>'), array('<li>', '</li>'), validation_errors()); ?>
			</ul>
		</div>	
	<?php } ?>

	<fieldset class="control-group">
		<label class="control-label" for="name">Skin Name <span class="required">*</span></label>
		<div class="controls">
			<input class="xlarge" id="name" name="name" size="30" type="text" placeholder="Steve" value="<?php echo set_value('name'); ?>">
			<p class="help-block"><strong>Note:</strong> a-z and spaces only!</p>
		</div>
	</fieldset>

	<fieldset class="control-group">
		<label class="control-label" for="file">Skin Upload <span class="required">*</span></label>
		<div class="controls">
			<input class="input-file" id="file" name="file" type="file">
			<p class="help-block"><strong>Allowed Types:</strong> png</p>
		</div>
	</fieldset>

	<fieldset class="control-group">
		<label class="control-label" for="content">Skin Description <span class="required">*</span></label>
		<div class="controls">
			<textarea class="xxlarge" name="content" rows="5" placeholder="Describe your update."><?php echo set_value('content'); ?></textarea>
			<p class="help-block">Full <a href="http://daringfireball.net/projects/markdown/basics" target="_blank">Markdown</a> &amp; HTML support.</p>
		</div>
	</fieldset>

	<fieldset class="control-group">
		<label class="control-label" for="tags">Skin Tags&nbsp;&nbsp;</label>
		<div class="controls">
			<input class="xlarge" id="tags" name="tags" size="30" type="text" placeholder="this, example" value="<?php echo set_value('tags'); ?>">
			<p class="help-block"><strong>Note:</strong> Add tags for your skin, as many as you like! Use a comma to separate.</p>
		</div>
	</fieldset>

	<fieldset class="form-actions">
		<input type="submit" class="btn btn-primary btn-large" value="Add Skin">
	</fieldset>

</form>