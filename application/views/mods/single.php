<div class="row">
	<div class="span8">
		<div style="border-bottom:1px solid #ddd">
			<h2 style="display: inline"><?php echo $mod['name']; ?> <?php echo $mod['titletags']; ?></h2>
			<div style="display: inline; float: right">
				<div class="btn-group">
					<?php if(isset($user['donate'])) echo '<a href="'.$user['donate'].'" class="btn btn-primary" target="_blank">Donate to Author</a>'; ?>
					<a href="<?php echo base_url('uploads/mods/'. $mod['url'] . '/'. $primary['upload_data']['file_name']); ?>" class="btn btn-success">Download Mod</a>
					<?php if($this->Account_model->loggedin()) { if(!$subscribed) { ?>
						<a href="<?php echo base_url('notifications/subscribe/mods/'. $mod['url']); ?>" class="btn btn-info">Subscribe</a>
					<?php } else { ?>
						<a href="<?php echo base_url('notifications/unsubscribe/mods/'. $mod['url']); ?>" class="btn btn-danger">Unsubscribe</a>
					<?php } } ?>
				</div>
			</div>
		</div>
		<br>
		<div style="text-align: center">
			<script type="text/javascript"><!--
				google_ad_client = "ca-pub-5632175804795221";
				/* Minecrafter Mod Pages */
				google_ad_slot = "0554916979";
				google_ad_width = 728;
				google_ad_height = 90;
				//-->
			</script>
			<script type="text/javascript" src="https://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
		</div>
		<div class="tabbable">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#about" data-toggle="tab">About</a></li>
				<li><a href="#files" data-toggle="tab">Files</a></li>
				<li><a href="#pics" data-toggle="tab">Pictures</a></li>
				<li><a href="#stats" data-toggle="tab">Stats</a></li>
			</ul>

			<div class="tab-content">
				<div class="tab-pane active" id="about">
					<?php echo markdown($mod['content']); ?>
				</div>
				<div class="tab-pane" id="files">
					<table id="sort" class="table table-striped">
						<thead>
							<tr>
								<th>MC</th>
								<th>File Name</th>
								<th>Version</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody>
							<?php asort($mod['files']["0"], SORT_NUMERIC); foreach($mod['files']['0'] as $version => $file): ?>
						 	<tr>
								<td><?php echo $file['mcversion']; ?></td>
								<td><?php echo anchor('uploads/mods/'. $mod['url'] .'/'.$file['upload_data']['file_name'], $file['upload_data']['file_name']); ?></td>
								<td><?php echo $version; ?></td>
								<td><?php if(isset($file['description'])) echo $file['description']; ?></td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<div class="tab-pane" id="pics">
					<?php $this->load->view('root/pictures'); ?>
				</div>
				<div class="tab-pane" id="stats">
					<h3>Coming Soon!</h3>
				</div>
			</div>
		</div>	
	</div>

	<div class="span4">
		<div class="well" style="padding: 14px 14px;">
			<div class="user-account-info-box">
				<h4>Mod Information</h4>
				<ul>
					<li><strong>Created:</strong> <?php echo date('M j, Y', $mod['date']); ?></li>
					<li><strong>Last Updated:</strong> December 20 2011</li>
					<li><strong>Total Downloads:</strong> <?php echo $primary['downloads']; ?></li>
				</ul>
				<h4>Author Information</h4>
				<div style="text-align: center">
					<h3><?php echo anchor('user/'. $mod['username'], $mod['username']); ?></h3>
					<img src="//minotar.net/avatar/<?php echo $this->Account_model->detail($mod['username'], 'mcname'); ?>/128">
				</div>
				<ul>
					<li><strong>Mods:</strong> <?php echo $this->mongo_db->where(array('username' => $mod['username']))->count('mods'); ?></li>
					<li><strong>Comments:</strong> <?php echo $this->mongo_db->where(array('username' => $mod['username']))->count('comments'); ?></li>
				</ul>
				<?php if($this->session->userdata('username') == $mod['username']) { ?>
				<h4>Developer Information</h4>
				<ul>
					<li><?php echo anchor(uri_string().'/new','Upload a new version'); ?></li>
					<li><?php echo anchor(uri_string().'/edit','Edit this Mod'); ?></li>
				</ul>

				<?php } ?>
			</div>
		</div>
		<div style="text-align: center">
			<script type="text/javascript"><!--
				google_ad_client = "ca-pub-5632175804795221";
				/* Minecrafter Mods Right */
				google_ad_slot = "0464405686";
				google_ad_width = 250;
				google_ad_height = 250;
				//-->
			</script>
			<script type="text/javascript" src="https://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
		</div>
	</div>
</div>

<hr>
<?php $this->load->view('root/comments'); ?>