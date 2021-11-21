<?php
if (!defined('__TYPECHO_ROOT_DIR__'))
    exit;
$GLOBALS['theme_url'] = $this->options->themeUrl;
$header = G::Comment_hash_fix($this);
echo $header;
?>

<?php
function threadedComments($comments, $options)
{
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

    <li id="li-<?php $comments->theId(); ?>" class="comment-body<?php if ($comments->levels > 0) {
        echo ' comment-child';
        $comments->levelsAlt(' comment-level-odd', ' comment-level-even');
    } else {
        echo ' comment-parent';
    }
    $comments->alt(' comment-odd', ' comment-even');
    echo $commentClass; ?>">
        <div id="<?php $comments->theId(); ?>">
            <div class="comment-inner">
                <div class="comment-avatar">
                    <?php $comments->gravatar('200', ''); ?>
                    <span class="comment-reply"><?php $comments->reply(); ?></span>
                </div>
                <div class="comment-content">
                    <div class="comment-meta">
                        <span><?php $comments->author(); ?></span>
                        <span><?php echo G::getSemanticDate($comments->created); ?></span>
                    </div>
                    <?php echo G::analyzeMeme($comments->content); ?>
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

<?php $this->comments()->to($comments); ?>
<div id="comments">
    <?php if ($this->allow('comment')): ?>
        <div id="<?php $this->respondId(); ?>">
            <div id="comments-form">
                <h3>评论</h3>
                <form method="post" action="<?php $this->commentUrl() ?>" id="comment_form">
                    <!-- 如果当前用户已经登录 -->
                    <?php if ($this->user->hasLogin()): ?>
                        <!-- 显示当前登录用户的用户名以及登出连接 -->
                        <span style="font-size: 0.875rem;position: absolute;top: 1.5rem;right: 1.5rem;color:var(--theme-text-main);">🙋<?php $this->user->screenName(); ?></span>
                        <!-- 若当前用户未登录 -->
                    <?php else: ?>
                        <!-- 要求输入名字、邮箱、网址 -->
                        <div class="comments-Input">
                            <input type="text" name="author" class="text" size="35" value="<?php $this->remember('author'); ?>" placeholder="🙌用户名"/>
                            <input type="text" name="mail" class="text" size="35" value="<?php $this->remember('mail'); ?>" placeholder="📫邮箱"/>
                            <input type="text" name="url" class="text" size="35" value="<?php $this->remember('url'); ?>" placeholder="🔗博客链接"/>
                            <input type="hidden" name="receiveMail" id="receiveMail" value="yes"/>
                        </div>
                    <?php endif; ?>
                    <!-- 输入要回复的内容 -->
                    <div id="comments-textarea-wrap">
                        <textarea id="comments-textarea" name="text" placeholder="说点什么" onfocus="closeOwO()"><?php $this->remember('text'); ?></textarea>
                        <input type="submit" value="发送" class="submit" id="comment-submit"/>
                        <span id="OwO-logo" onclick="toggleOwO()">(QwQ)</span>
                        <span class="cancel-comment-reply"><?php $comments->cancelReply(); ?></span>
                        <?php $this->need('components/OwO.php'); ?>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($comments->have()): ?>
        <?php $comments->listComments(); ?>
        <?php $comments->pageNav('<span>👈</span>', '<span>👉</span>'); ?>
    <?php endif; ?>
</div>