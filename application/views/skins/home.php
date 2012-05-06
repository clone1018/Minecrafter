<?php foreach($skins as $skin): ?>

	<?php echo anchor('skin/'.$skin['_id']['$id'], '<img src="'.base_url("uploads/skins/".$skin['_id']['$id']."/head_front.png")."\" style='width: 48px; height: 48px'>"); ?>

<?php endforeach; ?>