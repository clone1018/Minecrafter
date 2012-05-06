<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#database" data-toggle="tab">Database (<?php echo count($items) + count($blocks); ?>)</a></li>
		<li><a href="#mods" data-toggle="tab">Mods (<?php echo count($mods); ?>)</a></li>
		<li><a href="#servers" data-toggle="tab">Servers (<?php echo count($hot); ?>)</a></li>
		<li><a href="#users" data-toggle="tab">Users (<?php echo count($users); ?>)</a></li>
	</ul>

	<div class="tab-content">
		<div class="active tab-pane" id="database">
			<?php $this->load->view('database/home'); ?>
		</div>
		<div class="tab-pane" id="mods">
			<?php $this->load->view('mods/list'); ?>
		</div>
		<div class="tab-pane" id="servers">
			<table id="sort" class="table table-striped servers"> 
				<thead>
					<tr>
						<th>Rank</th>
						<th>Title</th>
						<th>MOTD</th>
						<th style="width: 270px;">Server IP</th>
						<th style="width: 70px">Players</th>
						<th style="width: 30px">Ping</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($hot as $server): ?>
					<tr>
						<td style="vertical-align:middle"><?php echo $server['rank']; ?></td>
						<td style="vertical-align:middle"><?php echo anchor('server/'.$server['url'], $server['name']); ?></td>
						<td style="vertical-align:middle"><?php echo $server['query']['motd']; ?></td>
						<!-- <td style="vertical-align:middle"><?php echo $server['ip']. ':' .$server['port']; ?></td>-->
						<td style="width: 270px;">
							<div class="btn-group" style="margin-left: 10px; margin-bottom: -20px; margin-top: -2px;">
								<div class="input-prepend">
									<span class="add-on">IP</span>
									<input type="text" value="<?php echo $server['ip']. ':' .$server['port']; ?>" style="text-align: center">
								</div>
							</div>
						</td>
						<td style="vertical-align:middle; text-align: center"><?php echo $server['query']['players'] . '/' . $server['query']['max_players']; ?></td>
						<td style="vertical-align:middle;"><img src="<?php echo base_url('images/lag/'. $this->servers->calcLag($server['query']['latency']) .'.png'); ?>" alt="<?php echo $server['query']['latency']; ?>" class="lag"></tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<div class="tab-pane" id="users">
			<ul class="thumbnails">
				<?php foreach($users as $user): ?>
				<li>
					<a href="<?php echo '/user/'.$user["username"]; ?>" rel="popover" title="<?php echo $user['username']; ?>" data-content="">
						<img class="thumbnail" src="//minotar.net/avatar/<?php echo $user['mcname']; ?>/43">
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>