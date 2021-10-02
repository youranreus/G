<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

    <footer>
        <p class="clear">
            <span class="left"><a class="icp" href="http://beian.miit.gov.cn"><?php echo G::getICP(); ?></a></span>
            <span class="right"><?php echo $this->options->buildYear." - ".date('Y'); ?> &copy <?php $this->options->title(); ?></span>
        </p>
    </footer>
</div>
<?php $this->footer(); ?>
</body>
</html>
