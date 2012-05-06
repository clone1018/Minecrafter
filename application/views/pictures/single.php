<h2 style="display: inline"><?php echo anchor('user/'.$picture['username'], $picture['username']); ?>'s picture on <?php echo anchor($picture['url'], $picture['url']); ?></h2>
<hr>

<div class="well center">
	<img src="<?php echo base_url('uploads/pictures/'.$picture['file']['file_name']); ?>">
</div>

<hr>
<?php $this->load->view('root/comments'); ?>