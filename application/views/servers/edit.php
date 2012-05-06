<p>Required fields are marked by <span class="required">*</span>.</p>
<?php echo form_open(uri_string(), array('class' => 'form-horizontal')); ?>

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


		<fieldset class="control-group">
			<label class="control-label" for="ip">Server Connection <span class="required">*</span></label>
			<div class="controls">
				<input id="ip" name="ip" type="text" placeholder="8.8.8.8" value="<?php if(isset($server['ip'])) echo $server['ip']; else  echo set_value('ip'); ?>"> : <input class="span2" id="port" name="port" type="number" placeholder="25565" style="width: 101px" value="<?php if(isset($server['port'])) echo $server['port']; else  echo set_value('port'); ?>">
			</div>
		</fieldset>

		<fieldset class="control-group">
			<label class="control-label" for="content">Server Page <span class="required">*</span></label>
			<div class="controls">
				<textarea name="content" rows="5" placeholder="Describe your server." class="span6"><?php if(isset($server['content'])) echo $server['content']; else  echo set_value('content'); ?></textarea>
				<p class="help-block">Full <a href="http://daringfireball.net/projects/markdown/basics" target="_blank">Markdown</a> &amp; HTML support.</p>
			</div>
		</fieldset>

		<fieldset class="control-group">
			<label class="control-label" for="rconport">RCON&nbsp;&nbsp;</label>
			<div class="controls">
				<input id="rconpass" name="rconpass" type="text" placeholder="password" value="<?php if(isset($server['rconpass'])) echo $server['rconpass']; else  echo set_value('rconpass'); ?>">&nbsp;&nbsp;
				<input class="span2" id="rconport" name="rconport" type="number" placeholder="25575" style="width: 101px" value="<?php if(isset($server['rconport'])) echo $server['rconport']; else  echo set_value('rconport'); ?>">
			</div>
		</fieldset>

		<fieldset class="control-group">
			<label class="control-label" for="minequeryport">MineQuery&nbsp;&nbsp;</label>
			<div class="controls">
				<input class="span2" id="minequeryport" name="minequeryport" type="number" placeholder="25566" style="width: 101px" value="<?php if(isset($server['minequeryport'])) echo $server['minequeryport']; else  echo set_value('minequeryport'); ?>">
			</div>
		</fieldset>

		<fieldset class="control-group">
			<label class="control-label" for="tos">Options&nbsp;&nbsp;</label>
			<div class="controls">
				<label class="checkbox">
					<input type="checkbox" name="comments" checked>
					Allow Comments
				</label>
			</div>
		</fieldset>

	<div class="actions">
		<input type="submit" class="btn btn-primary btn-large" value="Edit Server">
	</div>

</form>