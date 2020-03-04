<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>


		<div id="page">
			<div id="page-content">
				<h2 id="page-content-title"><?php if($this->is('page','About')or$this->is('page','about')): ?><img src="<?php $this->options->themeUrl('IMG/about.png'); ?>"><?php endif; ?><?php $this->title();?></h2>
				<div id="page-content-article">
					<?php
					$content = $this->content;
					emotionContent($content,$this->options->themeUrl);
					 ?>
				</div>
			</div>
		</div>

		<?php
			$enableComment = $this->fields->enableComment;
			if ($enableComment == 1):
		?>
		<?php $this->need('comments.php'); ?>
	<?php endif; ?>
	<?php $this->need('footer.php'); ?>
