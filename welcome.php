<?php
/**
* 歌词页面
*
* @package custom
*/
$this -> need('header.php');
?>

  <div id="lyric">
    <div id="lyric-content">
      <?php $this->content();?>
    </div>
  </div>

<?php $this -> need('footer.php'); ?>
