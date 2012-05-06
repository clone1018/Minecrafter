<p>Required fields are marked by <span class="required">*</span>.</p>
<?php echo form_open(uri_string(), array('class' => 'form-horizontal')); ?>


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

	<div class="row">
		<div class="span8">
			
			<fieldset class="control-group">
				<label class="control-label" for="name">Server Name <span class="required">*</span></label>
				<div class="controls">
					<input class="xlarge" name="name" type="text" placeholder="Server Name Here" value="<?php echo set_value('name'); ?>"> 
				</div>
			</fieldset>

			<fieldset class="control-group">
				<label class="control-label" for="ip">Server Connection <span class="required">*</span></label>
				<div class="controls">
					<input id="ip" name="ip" type="text" placeholder="8.8.8.8" value="<?php echo set_value('ip'); ?>"> : <input class="span2" id="port" name="port" type="number" placeholder="25565" style="width: 101px" value="<?php echo set_value('port'); ?>">
				</div>
			</fieldset>

			<fieldset class="control-group">
				<label class="control-label" for="content">Server Page <span class="required">*</span></label>
				<div class="controls">
					<textarea name="content" rows="5" placeholder="Describe your server." class="span6"><?php echo set_value('content'); ?></textarea>
					<p class="help-block">Full <a href="http://daringfireball.net/projects/markdown/basics" target="_blank">Markdown</a> &amp; HTML support.</p>
				</div>
			</fieldset>

			<fieldset class="control-group">
				<label class="control-label" for="rconport">RCON&nbsp;&nbsp;</label>
				<div class="controls">
					<input id="rconpass" name="rconpass" type="text" placeholder="password" value="<?php echo set_value('rconpass'); ?>">&nbsp;&nbsp;
					<input class="span2" id="rconport" name="rconport" type="number" placeholder="25575" style="width: 101px" value="<?php echo set_value('rconport'); ?>">
				</div>
			</fieldset>

			<fieldset class="control-group">
				<label class="control-label" for="minequeryport">MineQuery&nbsp;&nbsp;</label>
				<div class="controls">
					<input class="span2" id="minequeryport" name="minequeryport" type="number" placeholder="25566" style="width: 101px" value="<?php echo set_value('minequeryport'); ?>">
				</div>
			</fieldset>

			<fieldset class="control-group">
				<label class="control-label" for="tos">Options&nbsp;&nbsp;</label>
				<div class="controls">
					<label class="checkbox">
						<input type="checkbox" name="tos">
						I accept the <a data-toggle="modal" href="#termsmodal">Terms of the Service</a>
					</label>
					<label class="checkbox">
						<input type="checkbox" name="comments">
						Allow Comments
					</label>
				</div>
			</fieldset>

		</div>
		<div class="span4">
			<h2>F.A.Q</h2>
			<dl>
				<dt>Can I add a server if I don't own it?</dt>
				<dd>Absolutely not, you'll need to ask your server owner to add their server to the list. </dd>

				<dt>Why do you want my RCON port/pass?</dt>
				<dd>Instead of requiring server owners to install a plugin, we can instead get all of the information we need via RCON. We do not store your password in plain text and will never use it for anything but pulling information. <a href="http://dinnerbone.com/blog/2011/10/14/minecraft-19-has-rcon-and-query/" target="_blank">More Information</a></dd>
			</dl>

		</div>
	</div>

	<fieldset class="form-actions">
		<input type="submit" class="btn btn-primary btn-large" value="Submit Server">
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
		<a href="#" class="btn btn-primary" data-dismiss="modal">Done</a>
	</div>
</div>