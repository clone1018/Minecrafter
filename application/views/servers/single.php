<div class="row">
	<div class="span8">
		<div style="border-bottom:1px solid #ddd">
			<h2 style="display: inline; float: left;"><?php echo $server['name']; ?></h2>
			<div style="display: inline; float: right">
			</div>
			<div style="clear: both"></div>
		</div>
		<br>
		<ul class="nav nav-tabs">
			<li class="active"><a href="#about" data-toggle="tab">About</a></li>
			<li><a href="#pics" data-toggle="tab">Pictures</a></li>
			<li><a href="#checks" data-toggle="tab">Checks</a></li>
			</li>
		</ul>

		<div class="tab-content">
			<div class="active tab-pane" id="about">
				<?php echo markdown($server['content']); ?>
			</div>
			<div class="tab-pane" id="pics">
				<?php $this->load->view('root/pictures'); ?>
			</div>
			<div class="tab-pane" id="checks">
				<?php foreach($checks as $check): ?>
				At <?php echo $check['time']; ?>, <?php echo $check['server']; ?> was <?php echo $check['status']; if($check['status'] != 'offline') { ?> with <?php echo $check['players']; ?> players and the motd of: <?php echo $check['motd']; } ?><br>
				<?php endforeach; ?>
			</div>
		</div>	
	</div>
	<div class="span4">
		<div class="btn-group center">
			<input type="text" value="<?php echo $server['ip']. ':' .$server['port']; ?>" style="text-align: center">
		</div>
		<div class="well" style="padding: 14px 14px;">
			<div class="user-account-info-box">
				<h4>Players</h4>
				Coming Soon!
				<?php if($this->session->userdata('username') == $server['username']) { ?>
				<h4>Owner Information</h4>
				<ul>
					<li><?php echo anchor(uri_string().'/edit','Edit this server'); ?></li>
				</ul>

				<?php } ?>
			</div>
		</div>
	</div>
</div>


<hr>
<?php if($server['comments'] == 'true' || $server['comments'] == 'on') $this->load->view('root/comments'); ?>