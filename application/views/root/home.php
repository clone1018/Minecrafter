<div class="row">
	<div class="span8">
		<div id="myCarousel" class="carousel slide">
			<div class="carousel-inner">
				<div class="item active">
					<img src="https://minecrafter.com/uploads/pictures/ss_(2012-02-09_at_04.11_.59)_.png" alt="">
					<div class="carousel-caption">
						<h4>SocialMiner</h4>
						<p>SocialMiners goal is to add social features to Minecraft such as a friends list, messaging system, profile pages, and a whole bunch of other ideas. <a href="https://minecrafter.com/mod/SocialMiner">Check it out...</a></p>
					</div>
				</div>
			</div>
			<!--<a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
			<a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>-->
		</div>
	</div>
	<div class="span4">
		<h3>Newest Members</h3>
		<?php foreach($users as $user): ?>

			<?php echo anchor('user/'.$user['username'], '<img src="https://minotar.net/avatar/'.$user['mcname'].'/48"'."\" style='width: 48px; height: 48px'>"); ?>

		<?php endforeach; ?>
	</div>
</div>
<div class="row">
	<div class="span4">
		<h3>Newest Skins</h3>
		<?php foreach($skins as $skin): ?>

			<?php echo anchor('skin/'.$skin['_id']['$id'], '<img src="'.base_url("uploads/skins/".$skin['_id']['$id']."/head_front.png")."\" style='width: 48px; height: 48px'>"); ?>

		<?php endforeach; ?>
	</div>
	<div class="span4">
		<h3>Newest Mods</h3>
		<table class="table table-condensed">
			<thead>
				<tr>
					<th>Mod Name</th>
					<th>Creator</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($mods as $mod): ?>
				<tr>
					<td><?php echo anchor('mod/'.$mod['url'], $mod['name']); ?></td>
					<td><?php echo anchor('user/'.$mod['username'], $mod['username']); ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<div class="span4">
		<h3>Newest Servers</h3>
		<table class="table table-condensed">
			<thead>
				<tr>
					<th>Server Name</th>
					<th>IP</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($servers as $server): ?>
				<tr>
					<td><?php echo anchor('server/'.$server['url'], $server['name']); ?></td>
					<td><?php echo $server['ip'].':'.$server['port']; ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>