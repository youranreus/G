<?php
/**
 * 友情链接_旧
 *
 * @package custom
 */
$this->need('components/header.php');
?>

    <div class="PAP" id="link">
        <article itemscope itemtype="http://schema.org/BlogPosting">
            <div id="post-banner" class="PAP-banner <?php $img = G::getArticleFieldsBanner($this);
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
            <div class="post-content PAP-content" itemprop="articleBody">
                <?php echo G::analyzeContent($this->content); ?>
            </div>
            <div class="friends">
				<?php if (isset($this->options->plugins['activated']['Links'])) : ?>
					<?php Links_Plugin::output("
					<li class='clear'>
						<a href='{url}' target='_blank'></a>
						<img src='{image}' alt='{name}'/>
						<div class='link-item-content-old'>
							<h3>{name}</h3>
							<span>{sort}</span>
							<p>{description}</p>
						</div>
					</li>
					", 0); ?>
				<?php else: ?>
					<p>请启用Link插件</p>
				<?php endif; ?>
		    </div>
        </article>
    </div>

<?php if ($this->fields->enableComment == 1): ?>
    <?php $this->need('components/comments.php'); ?>
<?php endif; ?>
<?php $this->need('components/footer.php'); ?>
