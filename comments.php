<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>


<?php function threadedComments($comments, $options) {
    $commentClass = '';
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $commentClass .= ' comment-by-author';
        } else {
            $commentClass .= ' comment-by-user';
        }
    }

    $commentLevelClass = $comments->levels > 0 ? ' comment-child' : ' comment-parent';
?>

<li id="li-<?php $comments->theId(); ?>" class="comment-body<?php
if ($comments->levels > 0) {
    echo ' comment-child';
    $comments->levelsAlt(' comment-level-odd', ' comment-level-even');
} else {
    echo ' comment-parent';
}
$comments->alt(' comment-odd', ' comment-even');
echo $commentClass;
?>">
    <div id="<?php $comments->theId(); ?>">
        <div class="comment-inner">
            <div class="comment-author">
                <?php $comments->gravatar('40', ''); ?>
                <span><?php $comments->author(); ?></span>
            </div>
            <div class="comment-content">
              <?php
                $cos = preg_replace('#\@\((.*?)\)#','<img src="/C/themes/G/IMG/bq/$1.png" class="bq">',$comments->content);
                echo $cos;
              ?>
            </div>
            <div class="comment-meta">
                <span><?php $comments->date('Y-m-d H:i'); ?></span>
                <span class="comment-reply"><?php $comments->reply(); ?></span>
            </div>
        </div>
    </div>
<?php if ($comments->children) { ?>
    <div class="comment-children">
        <?php $comments->threadedComments($options); ?>
    </div>
<?php } ?>
</li>
<?php } ?>


<div id="comments">
    <?php $this->comments()->to($comments); ?>
    <div class="comments-header" id="<?php $this->respondId(); ?>" >
        <?php if($this->allow('comment')): ?>

        <form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" role="form">
          <h3 class="comment-title">🎯回复  <?php $comments->cancelReply('/ 取消回复'); ?></h3>
            <?php if(!$this->user->hasLogin()): ?>
    			<input type="text" name="author" id="author" class="text" value="<?php $this->remember('author'); ?>" required placeholder="Name" />
    			<input type="email" name="mail" id="mail" class="text" value="<?php $this->remember('mail'); ?>"<?php if ($this->options->commentsRequireMail): ?> required<?php endif; ?> placeholder="E-mail"  />
    			<input type="url" name="url" id="url" class="text" placeholder="<?php _e('http://'); ?>" value="<?php $this->remember('url'); ?>"<?php if ($this->options->commentsRequireURL): ?> required<?php endif; ?> />
            <?php endif; ?>
                <textarea name="text" id="textarea" class="OwO-textarea textarea" required placeholder="开始你的表演"><?php $this->remember('text'); ?></textarea>
                <?php  $this->need('owo.php'); ?>
                <button type="submit" class="submit"><?php _e('🚀发射'); ?></button>
    	</form>
        <?php endif; ?>
    </div>

    <?php if ($comments->have()): ?>
        <?php $comments->listComments(); ?>
        <?php $comments->pageNav('<i class="iconfont icon-prev-m"></i>', '<i class="iconfont icon-next-m"></i>'); ?>
    <?php endif; ?>

</div>
