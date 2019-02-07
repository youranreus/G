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

					<?php Links_Plugin::output("SHOW_TEXT", 0, "好朋友"); ?>

			</div>
	</div>
  </div>
<?php $this -> need('footer.php'); ?>
