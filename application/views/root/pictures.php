<ul class="thumbnails">
	<?php $pictures = $this->mongo_db->where(array('url' => uri_string()))->get('pictures'); ?>

	<?php foreach($pictures as $picture): ?>
	<li class="span2">
		<a href="<?php echo base_url('picture/'.$picture['_id']['$id']); ?>" class="thumbnail">
			<img src="<?php echo base_url('uploads/pictures/'.$picture['file']['file_name']); ?>" alt="">
		</a>
	</li>
	<?php endforeach; ?>
</ul>

<?php if($this->Account_model->loggedin()) { ?>
<div class="well">
	<h3>Upload Picture</h3>
	<?php echo form_open_multipart('pictures/submit'); ?>
		<input type="hidden" name="url" value="<?php echo uri_string(); ?>">
		<input type="file" name="file">
		<p>By uploading this picture I agree to the <a data-toggle="modal" href="#termsmodal">Terms of the Service</a>.</p>
		<input type="submit" class="btn btn-primary" value="Upload Picture">
	</form>
</div>

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
<?php } ?>