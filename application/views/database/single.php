<?php
if($db['dec'] == '351') $type = 'gif'; else $type = 'png';
?>

<div class="row">
	<div class="span8">
		<div class="tabbable">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#about" data-toggle="tab">About</a></li>
				<li><a href="#pics" data-toggle="tab">Pictures</a></li>
			</ul>

			<div class="tab-content">
				<div class="tab-pane active" id="about">
					<?php echo markdown($db['description']); ?>
				</div>
				<div class="tab-pane" id="pics">
					<?php $this->load->view('root/pictures'); ?>
				</div>
			</div>
		</div>	
	</div>

	<div class="span4">
		<div class="well" style="padding: 14px 14px;">
			<div class="user-account-info-box">
				<h4>Block Information</h4>
				<div style="text-align: center">
					<h3><?php echo $db['name']; ?></h3>
					<img src="<?php echo base_url('images/'. $db['category'] . '/' . $db['dec'] . '.' . $type); ?>" alt="">
				</div>
			</div>
		</div>
	</div>
</div>


<hr>
<?php $this->load->view('root/comments'); ?>