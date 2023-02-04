<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
if (isset($_POST['agree'])) {
    if ($_POST['agree'] == $this->cid)
        exit((string)G::agree($this->cid));
    exit('error');
}
$agree = $this->hidden ? array('agree' => 0, 'recording' => true) : G::agreeNum($this->cid);
$this->need('components/header.php');
?>

<div id="post" class="PAP" role="main">
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
                <p><?php echo G::getSemanticDate($this->created); ?> · <?php $this->category(' · '); ?> · <?php echo G::getPostView($this); ?>次阅读</p>
            </div>
        </div>
        <div class="post-content PAP-content" itemprop="articleBody">
            <?php echo G::analyzeContent($this->content); ?>
        </div>
        <div id="post-toolbar">
            <a id="agree-btn" onclick="sendLike()" class="<?php echo $agree['recording'] ? 'agreed' : ''; ?> post-toolbar-btn" data-cid="<?php echo $this->cid; ?>" data-url="<?php $this->permalink(); ?>">
                <span class="agree-icon">👍</span>
                <span class="agree-num"><?php echo $agree['agree']; ?></span>
            </a>
            <?php if ($this->options->sponsorIMG != ''): ?>
                <span class="post-toolbar-btn" onclick="sponsorToggle()"><?php echo G::getSponsorText(); ?></span>
            <?php endif; ?>
        </div>
        <?php if ($this->options->sponsorIMG != ''): ?>
            <div id="post-sponsor" data-collapsed="true">
                <img src="<?php $this->options->sponsorIMG(); ?>" alt="<?php echo G::getSponsorText(); ?>"/>
            </div>
        <?php endif; ?>
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

<?php $this->need('components/comments.php'); ?>
<?php $this->need('components/footer.php'); ?>
