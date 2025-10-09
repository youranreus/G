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
 "🌸 把心事吹进风里，也落在这一格里。",
 "🌈 让一句话，为今天上色。",
 "✨ 你的字，会发光。",
 "🍃 轻轻落下一片叶，说给我们听。",
 "🌙 夜色里的小小心愿？",
 "☁️ 把云捏成一封留言。",
 "🐾 留下脚印，让故事有路。",
 "🪄 一敲键盘，星星就掉下来。",
 "🎈 把快乐绑在字尾。",
 "🌟 你的一句，会成为路标。",
 "📮 投递一则心情明信片。",
 "🫧 泡泡般的灵感，戳一下试试。",
 "💌 对世界说一句悄悄话。",
 "🌻 让温暖在这里开花。",
 "🍯 甜一点也没关系。",
 "🦋 放飞一只字的蝴蝶。",
 "🌊 把心事推向岸边。",
 "🎵 让句子有点旋律。",
 "🌧️ 下点小雨，让文字长出芽。",
 "🗺️ 用一句话画一张地图。",
 "📎 夹好你的灵感，不让它走。",
 "🍃 把叹息折成纸飞机。",
 "🫶 你的回音很重要。",
 "🔥 把热情点到这里。",
 "🍀 今天抽到的幸运签是？",
 "🎨 涂一笔属于你的颜色。",
 "🕊️ 让温柔先到达。",
 "🔮 在这里占卜你的灵感。",
 "🧸 放一点可爱在字里。",
 "🎐 让风替你挂上声音。",
 "🔖 给此刻打一个可爱书签。",
 "📖 写下今天的小注脚"
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
