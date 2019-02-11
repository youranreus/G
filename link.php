<?php
/**
* LINK
*
* @package custom
*/
$this -> need('header.php');
?>
	<div id="links">
		<div id="links-content">
			<h2>ともだち</h2>
	    <div class="friends">

					<?php Links_Plugin::output("
					<a href='{url}' target='_blank'>
						<li class='clear hoverup'>
								<img src='{image}' alt='{name}'/>
								<div class='link-item-content'>
									<h3>{name}</h3>
									<span>{sort}</span>
									<p>{description}</p>
								</div>
						</li>
					</a>
					", 0); ?>

					<?php $this->content();?>

			</div>
	</div>
  </div>
<?php $this -> need('footer.php'); ?>
