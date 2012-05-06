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

		<div class="clearfix">
			<label for="titletags">Title Tags  </label>
			<div class="input">
				<input class="xlarge" id="titletags" name="titletags" size="30" type="text" placeholder="[SMP] [ML]" value="<?php if(isset($mod['titletags'])) echo $mod['titletags']; else echo set_value('titletags'); ?>"> 
			</div>
		</div><!-- /clearfix -->

		<div class="clearfix">
			<label for="tags">Search Tags  </label>
			<div class="input">
				<input class="xlarge" id="tags" name="tags" size="30" type="text" placeholder="this, is an, example" value="<?php if(isset($mod['tags'])) echo $mod['tags']; else  echo set_value('tags'); ?>"> 
				<p class="help-block">
					<strong>Note:</strong> Extra tags people can search for, as many as you like! Use a comma to separate
				</p>
			</div>
		</div><!-- /clearfix -->

		<div class="clearfix">
			<label for="content">Page Content <span class="required">*</span></label>
			<div class="input">
				<textarea class="xxlarge" name="content" rows="5"><?php if(isset($mod['content'])) echo $mod['content']; else echo set_value('content'); ?></textarea>
				<p class="help-block">Full <a href="http://daringfireball.net/projects/markdown/basics" target="_blank">Markdown</a> &amp; HTML support.</p>
			</div>
		</div>

		<div class="clearfix">

			<label for="version">Mod Version <span class="required">*</span></label>
			<div class="input">
				<?php
				$options = array();
				foreach($mod['files']['0'] as $version => $file) {
					$options[$version] = $version;
				}

				echo form_dropdown('version', $options, $mod['version']);
				?>
			</div>	
		</div><!-- /clearfix -->

	<div class="actions">
		<input type="submit" class="btn btn-primary btn-large" value="Edit Mod">
	</div>

</form>