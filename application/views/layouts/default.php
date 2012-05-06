<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php if(isset($title) AND $title != 'Minecrafter') echo $title . ' @ '; ?>Minecrafter</title>
		<meta name="description" content="Minecrafter is an all in one Minecraft hub for servers, mods, blocks, items, skins, maps and so much more.">
		<meta name="author" content="Axxim, LLC">

		<link rel="shortcut icon" href="<?php echo base_url('favicon.ico'); ?>">

		<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
		<!--[if lt IE 9]>
		  <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<!-- Le styles -->
		<link href="<?php echo base_url('bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
		<link href="<?php echo base_url('css/minecrafter.css'); ?>" rel="stylesheet">

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url('js/three.js'); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url('js/RequestAnimationFrame.js'); ?>"></script>

		<!-- Le fav and touch icons -->
		<link rel="shortcut icon" href="images/favicon.ico">
		<link rel="apple-touch-icon" href="images/apple-touch-icon.png">
		<link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
	</head>
	<body>
	<?php if($this->Account_model->loggedin()) $this->Account_model->markOnline($this->session->userdata('username'), uri_string()); ?>
		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<a class="brand" href="/">MINECRAFTER</a>
					<ul class="nav">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Community <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><?php echo anchor('forums', 'Forums'); ?></li>
								<li><?php echo anchor('community/chat', 'Chat'); ?></li>
							</ul>
						</li>
						<li><?php echo anchor('database', 'Database'); ?></li>
						<li><?php echo anchor('mods', 'Mods'); ?></li>
						<li><?php echo anchor('servers', 'Servers'); ?></li>
						<li><?php echo anchor('skins', 'Skins'); ?></li>
						<!-- <li><?php echo anchor('textures', 'Textures'); ?></li>
						<li><?php echo anchor('maps', 'Maps'); ?></li> -->
					</ul>
					
					<ul class="nav pull-right">
					<form class="navbar-search pull-left" action="/search" method='GET'>
						<input type="text" class="search-query span2" name="q" placeholder="Search">
					</form>
						<?php if($this->notifications->get($this->session->userdata('username'))) { ?><li><a data-toggle="modal" href="#notifcations" data-keyboard="true"><span class="label label-important"> <?php echo count($this->notifications->get($this->session->userdata('username'))); ?> </span></a> </li><?php } ?>
						<li class="dropdown">
							<?php if($this->Account_model->loggedin()) { ?>
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->session->userdata('username'); ?> <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><?php echo anchor('account', 'Account'); ?></li>
								<li class="divider"></li>
								<li><?php echo anchor('account/logout', 'Logout'); ?></li>
							</ul>
							<?php } else { ?> 
							<li><?php echo anchor('account/register', 'Register'); ?></li>
							<li><?php echo anchor('account/login', 'Login'); ?></li>
							<?php } ?>
						</li>
					</ul>
				</div>
			</div>
		</div>
		


		<div class="container">

			<div class="content">
				<?php if(isset($title) && isset($description)) { ?>
				<div class="page-header">
					<?php if(isset($button)) echo $button; ?>
					<h1><?php echo $title; ?> <small><?php echo $description; ?></small></h1>
				</div>
				<?php } ?>

				<?php echo $content; ?>
				<hr>
				<div class="center">
					<strong>Users Online:</strong> 
					<?php 
						foreach($this->mongo_db->get('online') as $user) { 
							$user = array_merge($user, $this->Account_model->info($user['username']));
							if($user['group'] == 'admin' || $user['group'] == 'owner') $tags = 'label-important';
							if($user['group'] == 'moderator' || $user['group'] == 'moderators') $tags = 'label-info'; 
							if($user['group'] == 'user' || $user['group'] == 'users') $tags = 'label-success'; 
							echo anchor('user/'.$user['username'],
										'<span class="label '.$tags.'">'.$user['username'].'</span>',
										array('rel' => 'tooltip',  'title' => $user['url'])). ' '; 
						} 
					?><br>

					<strong>Statistics:</strong> There are <?php echo $this->mongo_db->count('users'); ?> users who have made <?php echo $this->mongo_db->count('skins'); ?> skins, created <?php echo $this->mongo_db->count('mods'); ?> mods and added <?php echo $this->mongo_db->count('servers'); ?> servers.<br><br>
					<?php echo anchor('home/terms', 'Terms of Service'); ?>
					<p>&copy; <a href="http://axxim.net">Axxim, LLC</a> 2011</p>
				</div>

				
			</div>

			<?php if($this->Account_model->loggedin()) { ?>
				<div id="notifcations" class="modal hide fade">
					<div class="modal-header">
						<a class="close" data-dismiss="modal" >&times;</a>
						<h3>Minecrafter Notifications</h3>
					</div>
					<div class="modal-body">
						<?php foreach($this->notifications->get($this->session->userdata('username')) as $key => $notification): ?>
							<h4><?php echo anchor('notifications/read/'.$notification['_id']['$id'], $notification['title']); ?> by <?php echo $notification['from']; ?></h4>
							<p><?php echo $notification['content']; ?></p>
						<?php endforeach; ?>
					</div>
					<div class="modal-footer">

						<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>
						<a href="<?php echo base_url('notifications/readAll'); ?>" class="btn btn-danger">Read All</a>
					</div>
				</div>
			<?php } ?>

		</div> <!-- /container -->
		<script src="<?php echo base_url('bootstrap/js/bootstrap.min.js'); ?>"></script>
		<script src="<?php echo base_url('js/application.js'); ?>"></script>

	</body>
</html>
