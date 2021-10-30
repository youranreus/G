<?php
/**
* 歌词页
*
* @package custom
*/
$this -> need('components/header.php');
?>

<div id="lyrics">
    <?php $this->content(); ?>
</div>

<?php $this->need('components/footer.php'); ?>