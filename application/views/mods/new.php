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
		<label class="control-label" for="file">Update Upload <span class="required">*</span></label>
		<div class="controls">
			<input class="input-file" id="file" name="file" type="file">
			<p class="help-block"><strong>Allowed Types:</strong> jar, zip, rar, 7z, tar, tar.bz2, tar.gz</p>
		</div>
	</fieldset>

	<fieldset class="control-group">
		<label class="control-label" for="description">Update Description <span class="required">*</span></label>
		<div class="controls">
			<textarea class="xxlarge" name="description" rows="5" placeholder="Describe your update."><?php echo set_value('description'); ?></textarea>
			<p class="help-block">Patch notes, upgrade notes, etc. Full <a href="http://daringfireball.net/projects/markdown/basics" target="_blank">Markdown</a> &amp; HTML support.</p>
		</div>
	</fieldset>

	<fieldset class="control-group">
		<label class="control-label" for="version">Mod Version <span class="required">*</span></label>
		<div class="controls">
			<input id="version" name="version" size="5" type="text" placeholder="1.3.3.7" value="<?php echo set_value('version'); ?>">
		</div>
	</fieldset>

	<fieldset class="control-group">
		<label class="control-label" for="mcversion">Mod Version <span class="required">*</span></label>
		<div class="controls">
			<select class="medium" name="mcversion" id="mcversion">
				<option selected>1.1</option>
				<option>1.0.0</option>
				<option>1.8.1</option>
			</select>
		</div>
	</fieldset>

	<fieldset class="form-actions">
		<input type="submit" class="btn btn-primary btn-large" value="Submit Update">
	</fieldset>

</form>