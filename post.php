<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('components/header.php'); ?>

<div id="post" class="PAP" role="main">
    <article itemscope itemtype="http://schema.org/BlogPosting">
        <div id="post-banner" class="PAP-banner">
            <div>
                <h2 itemprop="name headline"><?php $this->title() ?></h2>
                <p><?php echo G::getSemanticDate($this->created); ?> · <?php $this->category(' · '); ?> </p>
            </div>
        </div>
        <div class="post-content PAP-content" itemprop="articleBody">
            <?php $this->content(); ?>
        </div>
        <div id="post-footer">
            <div id="post-footer-tag">
                <p><?php $this->tags(' ', true, 'none'); ?></p>
            </div>
            <div id="post-footer-modified">
                <p><?php echo G::getModifiedDate($this->modified, $this->created); ?></p>
            </div>
        </div>
    </article>
</div><!-- end #main-->

<?php $this->need('components/sidebar.php'); ?>
<?php $this->need('components/footer.php'); ?>
