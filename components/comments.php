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
 "🌸 把心事吹進風裡，也落在這一格裡。",
 "🌈 讓一句話，為今天上色。",
 "✨ 你的字，會發光。",
 "🍃 輕輕落下一片葉，說給我們聽。",
 "🌙 夜色裡的小小心願？",
 "☁️ 把雲捏成一封留言。",
 "🐾 留下腳印，讓故事有路。",
 "🪄 一敲鍵盤，星星就掉下來。",
 "🎈 把快樂綁在字尾。",
 "🌟 你的一句，會成為路標。",
 "📮 投遞一則心情明信片。",
 "🫧 泡泡般的靈感，戳一下試試。",
 "💌 對世界說一句悄悄話。",
 "🌻 讓溫暖在這裡開花。",
 "🍯 甜一點也沒關係。",
 "🦋 放飛一隻字的蝴蝶。",
 "🌊 把心事推向岸邊。",
 "🎵 讓句子有點旋律。",
 "🌧️ 下點小雨，讓文字長出芽。",
 "🗺️ 用一句話畫一張地圖。",
 "📎 夾好你的靈感，不讓它走。",
 "🍃 把嘆息折成紙飛機。",
 "🫶 你的回音很重要。",
 "🔥 把熱情點到這裡。",
 "🍀 今天抽到的幸運簽是？",
 "🎨 塗一筆屬於你的顏色。",
 "🕊️ 讓溫柔先到達。",
 "🔮 在這裡占卜你的靈感。",
 "🧸 放一點可愛在字裡。",
 "🎐 讓風替你掛上聲音。",
 "🔖 給此刻打一個可愛書籤。",
 "📖 寫下今天的小註腳"
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
