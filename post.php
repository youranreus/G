<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div id="post">
	<div id="post-content">
		<h2 id="post-content-title"><?php $this->title();?></h2>
		<div id="post-content-article">
			<?php $this->content();?>
		</div>
	</div>
</div>
	<?php $this->need('comments.php'); ?>

	<?php $this->need('footer.php'); ?>
