<a name="comments"></a>
<h2>Comments</h2>
<?php if(!isset($comments) || empty($comments)) echo "No comments yet, post one?"; else foreach($comments as $comment): ?>

<div class="row">
  <div class="span2" style="text-align: center">
  	<h3><?php echo anchor('user/'.$comment['username'], $comment['username']); ?></h3>
    <img src="//minotar.net/avatar/<?php echo $this->Account_model->detail($comment['username'], 'mcname'); ?>/90">
  </div>
  <div class="span9">
  	<h2><?php if(isset($comment['title'])) echo $comment['title']; ?></h2>
    <?php echo markdown($comment['content']); ?>
  </div>
</div>

<?php endforeach; ?>
<hr>
<?php if($this->session->userdata('username') == '') { ?>
<p>You need to <?php echo anchor('account/login', 'login'); ?> or <?php echo anchor('accoung/register', 'register'); ?> to post comments.</p>
<?php } else { ?>
<h2>Post Comment</h2>
<?php if (validation_errors() != '') { ?>
	<div class="alert-message block-message error" data-alert="alert">
		<a class="close" href="#">&times;</a>
		<p><strong>Oh snap! You got an error!</strong> Change this and that and <a href="#">try again</a>.</p>
		<ul>
			<?php echo str_replace(array('<p>', '</p>'), array('<li>', '</li>'), validation_errors()); ?>
		</ul>
	</div>	
<?php } ?>
<?php echo form_open(uri_string().'/post'); ?>
	<div class="row">
	  <div class="span2" style="text-align: center">
	  	<h2 style="margin-top: 8px;"><?php echo $this->session->userdata('username'); ?></h2>
	    <img style="margin-top: 15px;" src="//minotar.net/avatar/<?php echo $this->Account_model->detail($this->session->userdata('username'), 'mcname'); ?>/90">
	  </div>
	  <div class="span6">
	  	<br><input class="span6" name="title" placeholder="Title" value="<?php echo set_value('title'); ?>">
	  	<textarea class="span6" id="commentbox" name="content" rows="5" placeholder="Comment content"><?php echo set_value('content'); ?></textarea>
	  	<input type="hidden" name="url" value="<?php echo uri_string(); ?>">

  		<div style="float: right; margin-right: 0px">
		  	<input type="submit" class="btn btn-primary" value="Comment" style="margin-top: 10px;">
		</div>
	  </div>
	  <div class="span4">
	  	<h2 style="margin-top: 10px;"><a href="http://daringfireball.net/projects/markdown/basics" target="_blank">Markdown</a> Cheatsheet</h2>
		<pre style="margin-top: 9px; padding-bottom: 13px; padding-top: 13px">
*italic* **bold** 
[example](http://url.com/ "Title")
![alt text](/path/to/img.jpg "Title")
> Angle brackets for blockquotes.
</pre>
	  </div>
	</div>
</form>
<?php } ?>