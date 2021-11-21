<?php
/**
 * 歌词页
 *
 * @package custom
 */
$this->need('components/header.php');
?>

    <div id="lyrics">
        <?php $this->content(); ?>
    </div>
<?php if ($this->fields->enableComment == 1): ?>
    <?php $this->need('components/comments.php'); ?>
<?php endif; ?>
<?php $this->need('components/footer.php'); ?>