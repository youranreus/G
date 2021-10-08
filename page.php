<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('components/header.php'); ?>

<div id="page" class="PAP" role="main">
    <article itemscope itemtype="http://schema.org/BlogPosting">
        <div id="page-banner" class="PAP-banner">
            <h2 itemprop="name headline"><?php $this->title() ?></h2>
        </div>
        <div id="page-content" itemprop="articleBody">
            <?php $this->content(); ?>
        </div>
    </article>
</div><!-- end #main-->
<?php $this->need('components/footer.php'); ?>
