<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('components/header.php'); ?>

<div id="post" class="PAP" role="main">
    <article itemscope itemtype="http://schema.org/BlogPosting">
        <div id="post-banner" class="PAP-banner <?php $img = G::getArticleFieldsBanner($this); if($img != 'none') echo 'PAP-IMG-Banner'; ?>">
            <?php $img = G::getArticleFieldsBanner($this); if($img != 'none'): ?>
                <div class="PAP-banner-background" style="background-image: url('<?php echo $img; ?>');"></div>
                <div class="PAP-banner-mask"></div>
            <?php endif; ?>
            <div>
                <h2 itemprop="name headline"><?php $this->title() ?></h2>
                <p><?php echo G::getSemanticDate($this->created); ?> · <?php $this->category(' · '); ?> </p>
            </div>
        </div>
        <div class="post-content PAP-content" itemprop="articleBody">
            <?php echo G::analyzeContent($this->content); ?>
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
