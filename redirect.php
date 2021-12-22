<?php
/**
 * 重定向
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

    <script type="text/javascript"> 
        setTimeout(window.location.href= '<?php echo $this->fields->redirectURL ;?>',<?php echo $this->fields->redirectSecond ;?>)
    </script>

<?php if ($this->fields->enableComment == 1): ?>
    <?php $this->need('components/comments.php'); ?>
<?php endif; ?>
<?php $this->need('components/footer.php'); ?>