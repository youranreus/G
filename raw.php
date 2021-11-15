<?php
/**
* RAW
*
* @package custom
*/
$this -> need('components/header.php');
?>

<div class="PAP">
    <div class="PAP-content">
        <?php $this->content(); ?>
    </div>
</div>

<?php $this->need('components/footer.php'); ?>