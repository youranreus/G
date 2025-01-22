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

<?php $placeholders = [
    "💡 新奇的點子等著被你發現！",
    "🌟 你的一句話可能改變一切哦～",
    "🎨 把這裡當作你的留言畫布吧！",
    "😜 留點什麼，不然這裡會太孤單了！",
    "🤗 分享一下吧，別讓好想法溜走！",
    "🌻 這裡等著你的心聲盛開！",
    "🪄 點一下鍵盤，讓魔法發生～",
    "🔑 你的留言是這裡最重要的一部分！",
    "🍀 今天，你的幸運留言是什麼？",
    "🌼 把你的心情種在這裡吧！",
    "✨ 說點什麼，讓我們更接近你的世界！",
    "🌱 播種你的靈感，我們一起成長！",
    "🔥 火熱的話題，快來加入！",
    "🌊 分享你的故事，讓靈感如潮水湧來！",
    "✨ 用你的留言點亮這裡吧！",
    "🎵 你的意見，像音樂一樣動人～",
    "📚 寫下一句話，這裡成為你的日記！",
    "🖋️ 在這裡落下你的足跡～",
    "🌈 在這裡寫下你的想法吧～！",
    "👋 嘿，你好！有什麼想分享的嗎？",
    "🌟 今天你的亮點是什麼？",
    "🕶️ 低調地留言，讓人高調地發現！",
    "💬 今天有什麼新鮮事？",
    "📝 寫下你的想法吧！",
    "🤔 你怎麼看？",
    "✨ 分享你的靈感！",
    "😄 讓我們知道你的意見！",
    "📢 大聲說出來！",
    "🎉 你的評論會讓我們更好！",
    "👀 我在聽哦！",
    "🗣️ 說點什麼吧！",
    "🌟 你的回饋是我們的動力！"
];
$randomPlaceholder = $placeholders[array_rand($placeholders)];
?>

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

    <?php if ($comments->have()): ?>
        <?php $comments->listComments(); ?>
        <?php $comments->pageNav('<span>👈</span>', '<span>👉</span>'); ?>
    <?php endif; ?>
</div>