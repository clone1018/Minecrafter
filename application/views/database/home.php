<h3>Blocks</h3>
<ul class="thumbnails">
	<?php foreach($blocks as $db): if($db['dec'] == '351') $type = 'gif'; else $type = 'png'; ?>
	<li>
		<a href="<?php echo 'database/'.$db["category"].'/'.$db["dec"]; ?>" rel="popover" title="<?php echo $db['dec']; ?> - <?php echo $db['name']; ?>" class="thumbnail" data-content="<?php echo word_limiter(strip_tags($db['description']), 40, null); ?>">
			<img src="<?php echo base_url('images/'. $db['category'] . '/' . $db['dec'] . '.' . $type); ?>" style="width: 43px; height: 43px;" alt="">
		</a>
	</li>
	<?php endforeach; ?>
</ul>
<h3>Items</h3>
<ul class="thumbnails">
	<?php foreach($items as $db): if($db['dec'] == '351') $type = 'gif'; else $type = 'png'; ?>
	<li>
		<a href="<?php echo 'database/'.$db["category"].'/'.$db["dec"]; ?>" rel="popover" title="<?php echo $db['dec']; ?> - <?php echo $db['name']; ?>" class="thumbnail" data-content="<?php echo word_limiter(strip_tags($db['description']), 40, null); ?>">
			<img src="<?php echo base_url('images/'. $db['category'] . '/' . $db['dec'] . '.' . $type); ?>" style="width: 43px; height: 43px;" alt="">
		</a>
	</li>
	<?php endforeach; ?>
</ul>


<h3>Mobs</h3>
 <a href="#" class="btn btn-danger" rel="popover" title="A Title" data-content="And here's some amazing content. It's very engaging. right?">hover for popover</a>