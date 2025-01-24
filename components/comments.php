<?php
if (!defined('__TYPECHO_ROOT_DIR__'))
    exit;

if (G::$config["commentType"] != '1')
    return;

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
                        
                        <?php if ($comments->status == 'waiting') { ?>
                            <span><?php $options->commentStatus(); ?></span>
                        <?php } else { ?>
                            <span><?php echo G::getSemanticDate($comments->created); ?></span>
                        <?php }?>
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

<?php 
function displayComments($comments) {
    if ($comments->have()):
        $comments->listComments();
        $comments->pageNav('<span>👈</span>', '<span>👉</span>');
    endif;
}
?>

<?php $placeholders = [
 "💡 新奇的点子等着被你发现！",
 "🌟 你的一句话可能改变一切哦～",
 "🎨 把这里当作你的留言画布吧！",
 "😜 留点什么，不然这里会太孤单了！",
 "🤗 分享一下吧，别让好想法溜走！",
 "🌻 这里等着你的心声盛开！",
 "🪄 点一下键盘，让魔法发生～",
 "🔑 你的留言是这里最重要的一部分！",
 "🍀 今天，你的幸运留言是什么？",
 "🌼 把你的心情种在这里吧！",
 "✨ 说点什么，让我们更接近你的世界！",
 "🌱 播种你的灵感，我们一起成长！",
 "🔥 火热的话题，快来加入！",
 "🌊 分享你的故事，让灵感如潮水涌来！",
 "✨ 用你的留言点亮这里吧！",
 "🎵 你的意见，像音乐一样动人～",
 "📚 写下一句话，这里成为你的日记！",
 "🖋️ 在这里落下你的足迹～",
 "🌈 在这里写下你的想法吧～！",
 "👋 嘿，你好！有什么想分享的吗？",
 "🌟 今天你的亮点是什么？",
 "🕶️ 低调地留言，让人高调地发现！",
 "💬 今天有什么新鲜事？",
 "📝 写下你的想法吧！",
 "🤔 你怎么看？",
 "✨ 分享你的灵感！",
 "😄 让我们知道你的意见！",
 "📢 大声说出来！",
 "🎉 你的评论会让我们更好！",
 "👀 我在听哦！",
 "🗣️ 说点什么吧！",
 "🌟 你的回馈是我们的动力！"
];
$randomPlaceholder = $placeholders[array_rand($placeholders)];
?>

<?php $this->comments()->to($comments); ?>
<div id="comments">
    <?php if ($this->allow('comment')): ?>
        <?php if ($this->fields->comment_forward): ?>
            <?php displayComments($comments); ?>
        <?php endif; ?>
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
                            <input type="text" name="author" class="text" size="35" value="<?php $this->remember('author'); ?>" placeholder="🙌用户名*"/>
                            <input type="text" name="mail" class="text" size="35" value="<?php $this->remember('mail'); ?>" placeholder="📫邮箱*"/>
                            <input type="text" name="url" class="text" size="35" value="<?php $this->remember('url'); ?>" placeholder="🔗博客链接"/>
                            <input type="hidden" name="receiveMail" id="receiveMail" value="yes"/>
                        </div>
                    <?php endif; ?>
                    <!-- 输入要回复的内容 -->
                    <div id="comments-textarea-wrap">
                    <textarea id="comments-textarea" name="text" placeholder="<?php echo htmlspecialchars($randomPlaceholder); ?>" onfocus="closeOwO()"><?php $this->remember('text'); ?></textarea>
                        <input type="submit" value="发送" class="submit" id="comment-submit"/>
                        <span id="OwO-logo" onclick="toggleOwO()">(QwQ)</span>
                        <span class="cancel-comment-reply"><?php $comments->cancelReply(); ?></span>
                        <?php $this->need('components/OwO.php'); ?>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
    <?php if (!$this->fields->comment_forward): ?>
            <?php displayComments($comments); ?>
    <?php endif; ?>
</div>
