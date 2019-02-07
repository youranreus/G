<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>


		<div id="page">
			<div id="page-content">
				<h2 id="page-content-title"><img src="https://i.loli.net/2019/02/07/5c5c380db5e0b.png"><?php $this->title();?></h2>
				<div id="page-content-article">
					<?php $this->content();?>
				</div>
			</div>
		</div>



	<?php $this->need('footer.php'); ?>
