<?php
/**
 * RAW
 *
 * @package custom
 */
$this->need('components/header.php');
?>

    <div class="PAP">
        <div class="PAP-content">
            <?php $this->content(); ?>
        </div>
    </div>

<?php if ($this->fields->enableComment == 1): ?>
    <?php $this->need('components/comments.php'); ?>
<?php endif; ?>
<?php $this->need('components/footer.php'); ?>