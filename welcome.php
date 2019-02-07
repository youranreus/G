<?php
/**
* 首页
*
* @package custom
*/
$this -> need('header.php');
?>

  <div id="zp">
    <div id="zp-content">
      <?php $this->content();?>
    </div>
  </div>

<?php $this -> need('footer.php'); ?>
