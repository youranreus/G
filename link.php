<?php
/**
 * 友情链接
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
        </article>
    </div>

    <div id="link-list">
        <?php if (isset($this->options->plugins['activated']['Links'])) : ?>
            <?php
            Links_Plugin::output('
				<a target="_blank" href="{url}" class="link-wrap">
					<div class="link-item">
						<img src="{image}" alt="{name}"/>
						<div class="link-item-content">
							<h4>{name}</h4>
							<p>{sort}</p>
						</div>
						<div class="link-item-m-content">
							<span>{name}</span>
						</div>
					</div>
				</a>', 0);
            ?>
        <?php endif; ?>
    </div>

<?php if ($this->fields->enableComment == 1): ?>
    <?php $this->need('components/comments.php'); ?>
<?php endif; ?>
<?php $this->need('components/footer.php'); ?>
