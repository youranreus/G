<?php
/**
* 说说页面
* Author:TestGifts
* CreateTime：2021/07/20
* @package custom
*/
$this -> need('header.php');
?>
 
    <?php
function threadedComments($comments, $options) {
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
            <div class="comment-meta">
                <span><?php $comments->date('Y-m-d H:i'); ?></span>
            </div>
            <div class="comment-content">
              <?php
                $cos = preg_replace('#\@\((.*?)\)#','<img src="https://cdn.jsdelivr.net/gh/youranreus/R@v1.1.8/G/IMG/bq/$1.png" class="bq">',$comments->content);
                $cos = preg_replace('/\:\:(.*?)\:(.*?)\:\:/','<img src="https://cdn.jsdelivr.net/gh/youranreus/R@v1.1.8/W/bq/$1/$2.png" class="bq">',$cos);
                echo $cos;
              ?>
            </div>
            <span class="comment-reply"><?php $comments->reply(); ?></span>
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
            <?php if($this->user->hasLogin()): ?>
          <form method="post" action="<?php $this->commentUrl() ?>" id="comment-form">
            <img id="comment-loading" src="https://cdn.jsdelivr.net/gh/youranreus/R@v1.0.3/G/IMG/loading.gif"></img>
            <div class="cancel-comment-reply clear">
                <?php $comments->cancelReply(); ?>
            </div>
                  <h2 id="response" class="widget-title text-left"><?php _e('发一条说说吧'); ?></h2>
              <p>
                  <input name="_" type="hidden" id="comment_" value="<?php echo Helper::security()->getToken(str_replace(array('?_pjax=%23pjax-container', '&_pjax=%23pjax-container'), '', Typecho_Request::getInstance()->getRequestUrl()));?>"/>
                  <textarea rows="5" name="text" id="textarea" placeholder="今天想说点什么呢..." style="resize:none;"><?php $this->remember('text'); ?></textarea>
              </p>
              <div class="clear">
                <div class="OwO-logo" onclick="OwO_show()">
                  <span>(OwO)</span>
                </div>
                <button type="submit" class="submit"><?php _e('发射'); ?></button>
              </div>
              <div id="OwO-container"><?php  $this->need('owo.php'); ?></div>
          </form>
        <?php endif; ?>
    <?php endif; ?>
		    </div>

    <?php if ($comments->have()): ?>
        <?php $comments->listComments(); ?>
        <?php $comments->pageNav('<上一页', '下一页>'); ?>
    <?php endif; ?>

  

<?php $this -> need('footer.php'); ?>
