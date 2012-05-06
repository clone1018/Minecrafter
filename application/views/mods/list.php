<ul class="thumbnails">
	<?php foreach($mods as $mod): ?>
	<?php $image = $this->mongo_db->where(array('url' => 'mod/'.$mod['url']))->limit(1)->get('pictures'); if($image) { $image = $image[0]; $image = "/uploads/pictures/".$image['file']['file_name']; } else $image = 'http://placehold.it/260x180&text=Upload+an+image'; ?>
	<li class="span3">
		<div class="thumbnail">
			<?php echo anchor('mod/'. $mod['url'], '<h4>'.character_limiter($mod['name'].' '.$mod['titletags'], 40).'</h4>'); ?>
			<?php echo anchor('mod/'. $mod['url'], '<img src="'.$image.'" alt="" style="width: 260px; height: 180px;">'); ?>
		</div>
	</li>
	<?php endforeach; ?>
</ul>