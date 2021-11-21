<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('components/header.php');
?>

<div id="container">
    <h3 class="archive-title"><?php $this->archiveTitle(array(
            'category' => _t('分类 %s 下的文章'),
            'search' => _t('包含关键字 %s 的文章'),
            'tag' => _t('标签 %s 下的文章'),
            'author' => _t('%s 发布的文章')
        ), '', ''); ?></h3>
    <?php if ($this->have()): ?>
        <div id="articles">
            <?php $this->need('components/article.php'); ?>
        </div>
        <div id="articles-switch" class="clear">
            <?php $this->pageLink('更多 >', 'next'); ?>
            <?php $this->pageLink('< 返回', 'prev'); ?>
        </div>
    <?php else: ?>
        <article class="post">
            <h2 class="post-title"><?php _e('没有找到内容'); ?></h2>
        </article>
    <?php endif; ?>
</div>

<?php $this->need('components/footer.php'); ?>
