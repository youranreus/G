<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('components/header.php');
?>

<div id="page" class="PAP" role="main">
    <article itemscope itemtype="http://schema.org/BlogPosting">
        <div id="page-banner" class="PAP-banner <?php $img = G::getArticleFieldsBanner($this);
        if ($img != 'none') echo 'PAP-IMG-Banner'; ?>">
            <?php $img = G::getArticleFieldsBanner($this);
            if ($img != 'none'): ?>
                <div class="PAP-banner-background" style="background-image: url('<?php echo $img; ?>');"></div>
                <div class="PAP-banner-mask"></div>
            <?php endif; ?>
            <div>
                <h1 itemprop="name headline"><?php $this->title() ?></h1>
            </div>
        </div>
        <div id="page-content" class="PAP-content" itemprop="articleBody">
            <?php echo G::analyzeContent($this->content); ?>
        </div>
    </article>
</div>
<?php if ($this->fields->enableComment == 1): ?>
    <?php $this->need('components/comments.php'); ?>
<?php endif; ?>
<?php $this->need('components/footer.php'); ?>
