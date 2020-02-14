<?php
/**
* 友情链接
*
* @package custom
*/
$this -> need('header.php');
?>
	<div id="links">
		<div id="links-content">
			<h2>ともだち</h2>
			<div id="links-post">
				<?php
				$content = $this->content;
				emotionContent($content,$this->options->themeUrl);
				 ?>
		 </div>
	    <div class="friends">
				<?php if (isset($this->options->plugins['activated']['Links'])) : ?>
					<?php Links_Plugin::output("
					<li class='clear'>
						<a href='{url}' target='_blank'></a>
						<img src='{image}' alt='{name}'/>
						<div class='link-item-content'>
							<h3>{name}</h3>
							<span>{sort}</span>
							<p>{description}</p>
						</div>
					</li>
					", 0); ?>
				<?php endif ?>

		</div>
	</div>
  </div>
<?php $this -> need('footer.php'); ?>
