<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#hot" data-toggle="tab" style="color: Red;">Hot</a></li>
		<li><a href="#top" data-toggle="tab">Top</a></li>
		<li><a href="#new" data-toggle="tab">New</a></li>
	</ul>

<div class="tab-content">
	<div class="tab-pane active" id="hot">
		<p><strong>What's a Hot server?</strong> Hot Servers are ones that we've found are hot this week, this depends on players, rating, latency and more.</p>
		<table id="sort" class="table table-striped servers table-condensed"> 
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
	<div class="tab-pane" id="top">
		<p><strong>What's a Top server?</strong> Top servers are the absolute best (rank wise) servers, you can bet these servers will have tons of players, and tons of uptime.</p>
		<table id="sort" class="table table-striped servers table-condensed"> 
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
				<?php foreach($top as $server): ?>
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
	<div class="tab-pane" id="new">
		<p><strong>What's a New server?</strong> New servers are the servers that are brand spanking new (to our list).</p>
		<table id="sort" class="table table-striped servers table-condensed"> 
			<thead>
				<tr>
					<th>Title</th>
					<th>MOTD</th>
					<th style="width: 270px;">Server IP</th>
					<th style="width: 70px">Players</th>
					<th style="width: 30px">Ping</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($new as $server): ?>
				<tr>
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
</div>