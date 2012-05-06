<?php 
// Data crap
if(!isset($user['registered']) && isset($user['date'])) $user['registered'] = $user['date'];

?>

<div class="row">
	<div class="span8">
		<div class="tabbable">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#overview" data-toggle="tab">Overview</a></li>
				<li><a href="#comments" data-toggle="tab">Comments</a></li>
				<li><a href="#mods" data-toggle="tab">Mods</a></li>
				<li><a href="#servers" data-toggle="tab">Servers</a></li>
				<li><a href="#skins" data-toggle="tab">Skins</a></li>
				<li><a href="#other" data-toggle="tab">Other</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="overview">
					<table id="sort" class="table table-striped"> 
						<thead>
							<tr>
								<th class="title">Title</th>
								<th class="latestfile">Latest File</th>
								<th class="created">Created</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($mods as $mod): $file = $this->Mods_model->getPrimaryVersion($mod['url'])?>
								<tr>
									<td class="title"><?php echo anchor('mod/'.$mod['url'], $mod['name']); ?></td>
									<td class="latestfile"><?php echo anchor('uploads/mods/'. $mod['url'] .'/'.$file['upload_data']['file_name'], $file['upload_data']['file_name']); ?></td>
									<td class="created"><?php echo date('M j Y', $mod['date']); ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<div class="tab-pane" id="comments">
					<?php if(!isset($comments) || empty($comments)) echo "No comments found."; else foreach($comments as $comment): ?>

					<div class="row">
						<div class="span2" style="text-align: center">
							<h3><?php echo $comment['username']; ?></h3>
							<img src="//minotar.net/avatar/<?php echo $comment['username']; ?>/90">
						</div>
						<div class="span6">
							<h2><?php if(isset($comment['title'])) echo anchor($comment['url'].'#comments', $comment['title']); ?> </h2>
							<?php echo markdown($comment['content']); ?>
						</div>
					</div>

					<?php endforeach; ?>
				</div>

				<div class="tab-pane"  id="mods">
					<table id="sort" class="table table-striped"> 
						<thead>
							<tr>
								<th class="title">Title</th>
								<th class="latestfile">Latest File</th>
								<th class="created">Created</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($mods as $mod): $file = $this->Mods_model->getPrimaryVersion($mod['url'])?>
								<tr>
									<td class="title"><?php echo anchor('mod/'.$mod['url'], $mod['name']); ?></td>
									<td class="latestfile"><?php echo anchor('uploads/mods/'. $mod['url'] .'/'.$file['upload_data']['file_name'], $file['upload_data']['file_name']); ?></td>
									<td class="created"><?php echo date('M j Y', $mod['date']); ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<div class="tab-pane" id="servers">
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
							<?php foreach($servers as $server): ?>
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
				<div class="tab-pane" id="skins">
					<?php $this->load->view('skins/home'); ?>
				</div>
				<div class="tab-pane" id="other">
					<p>No Other</p>
				</div>
			</div>
		</div>
	</div>

	<div class="span4">
		<?php if($this->session->userdata('username') == $user['username']) { ?>
		<?php echo anchor('account/edit', '<button class="btn btn-success">&nbsp;Edit Account&nbsp;</button>', array('style' => 'float: left')); ?>
		<?php echo anchor('mods/upload', '<button class="btn btn-info">&nbsp;Add Mod&nbsp;</button>', array('style' => 'float: right')); ?><br /><br />
		<?php } ?>
		<div class="well" style="padding: 14px 14px;">
			<div class="user-account-info-box">
				<div style="text-align: center">
					<img src="//minotar.net/avatar/<?php echo $user['mcname']; ?>/128">
				</div>
				<h4>Account Information</h4>
				<ul>
					<li><strong>Username:</strong> <?php echo $user['username']; ?></li>
					<!-- <li><strong>Total Downloads:</strong> 13020</li>
					<li><strong>Files:</strong> 1</li>
					<li><strong>Friends:</strong> 13020</li> -->
					<li><strong>Minecraft Name:</strong> <?php echo $user['mcname']; ?></li>
					<li><strong>Joined:</strong> <?php echo date('M j Y', $user['registered']); ?></li>
					<li><strong>Group:</strong> <?php echo humanize($user['group']); ?></li>
				</ul>
			</div>
		</div>
	</div>
</div>