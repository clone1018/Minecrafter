<p>Required fields are marked by <span class="required">*</span>.</p>
<?php echo form_open_multipart(uri_string(), array('class' => 'form-horizontal')); ?>

	<?php if (isset($error))
		var_dump($error); ?>
	<?php if (validation_errors() != '') { ?>
		<div class="alert-message block-message error" data-alert="alert">
			<a class="close" href="#">&times;</a>
			<p><strong>Oh snap! You got an error!</strong> Change this and that and <a href="#">try again</a>.</p>
			<ul>
				<?php echo str_replace(array('<p>', '</p>'), array('<li>', '</li>'), validation_errors()); ?>
			</ul>
		</div>	
	<?php } ?>
	<p><strong>We manually approve all mod submissions!</strong><br>
		<strong>Note:</strong> You can add more information once your mod is approved.</p><br>

		<fieldset class="control-group">
			<label class="control-label" for="name">Mod Name <span class="required">*</span></label>
			<div class="controls">
				<input class="xlarge" id="name" name="name" size="30" type="text" placeholder="The Most Interesting Mod in the World" value="<?php echo set_value('name'); ?>">
				<p class="help-block"><strong>Note:</strong> This will be primarly for your url. a-z and space only!</p>
			</div>
		</fieldset>

		<fieldset class="control-group">
			<label class="control-label" for="titletags">Title Tags&nbsp;&nbsp;</label>
			<div class="controls">
				<input class="xlarge" id="titletags" name="titletags" size="30" type="text" placeholder="[SMP] [ML]" value="<?php echo set_value('titletags'); ?>">
			</div>
		</fieldset>

		<fieldset class="control-group">
			<label class="control-label" for="titletags">Search Tags&nbsp;&nbsp;</label>
			<div class="controls">
				<input class="xlarge" id="titletags" name="titletags" size="30" type="text" placeholder="this, example" value="<?php echo set_value('titletags'); ?>">
				<p class="help-block"><strong>Note:</strong> Extra tags people can search for, as many as you like! Use a comma to separate</p>
			</div>
		</fieldset>

		<fieldset class="control-group">
			<label class="control-label" for="titletags">Page Content <span class="required">*</span></label>
			<div class="controls">
				<textarea class="xxlarge span9" name="content" rows="10"><?php echo set_value('content'); ?></textarea>
				<p class="help-block">Your mod pages content. Full <a href="http://daringfireball.net/projects/markdown/basics" target="_blank">Markdown</a> &amp; HTML support.</p>
			</div>
		</fieldset>

		<fieldset class="control-group">
			<label class="control-label" for="file">Mod Upload <span class="required">*</span></label>
			<div class="controls">
				<input class="input-file" id="file" name="file" type="file">
				<p class="help-block"><strong>Allowed Types:</strong> jar, zip, rar, 7z, tar, tar.bz2, tar.gz</p>
			</div>
		</fieldset>

		<fieldset class="control-group">
			<label class="control-label" for="version">Mod Version <span class="required">*</span></label>
			<div class="controls">
				<input id="version" name="version" size="5" type="text" placeholder="1.3.3.7" value="<?php echo set_value('version'); ?>">
			</div>
		</fieldset>

		<fieldset class="control-group">
			<label class="control-label" for="mcversion">Minecraft Version <span class="required">*</span></label>
			<div class="controls">
				<select class="medium" name="mcversion" id="mcversion">
					<option selected>1.1</option>
					<option>1.0.0</option>
					<option>1.8.1</option>
				</select>
			</div>
		</fieldset>

		<fieldset class="control-group">
			<label class="control-label" for="optionsCheckboxes"></label>
			<div class="controls">
				<label class="checkbox">
					<input type="checkbox" name="tos" value="off">
					This mod complies with the <a data-toggle="modal" href="#termsmodal">Terms of the Service</a>
				</label>
			</div>
		</fieldset>

		<fieldset class="form-actions">
			<input type="submit" class="btn-primary large" value="Submit Mod">
		</fieldset>

</form>

<div id="termsmodal" class="modal hide fade">
	<div class="modal-header">
		<a href="#" class="close" data-dismiss="modal" >&times;</a>
		<h3>Terms of Service</h3>
	</div>
	<div class="modal-body" style="height: 350px; overflow: scroll;">
		<?php echo $this->load->view('root/terms', null, true); ?>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn-primary" data-dismiss="modal">Done</a>
	</div>
</div>