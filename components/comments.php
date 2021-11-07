<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<div id="comments">
    <?php if($this->allow('comment')): ?>
        <div id="comments-form">
            <h3>评论</h3>
            <form method="post" action="<?php $this->commentUrl() ?>" id="comment_form">
                <!-- 如果当前用户已经登录 -->
                <?php if($this->user->hasLogin()): ?>
                    <!-- 显示当前登录用户的用户名以及登出连接 -->
                    <span style="font-size: 0.875rem;position: absolute;top: 1.5rem;right: 1.5rem;">🙋<?php $this->user->screenName(); ?></span> 
                <!-- 若当前用户未登录 -->
                <?php else: ?>
                <!-- 要求输入名字、邮箱、网址 -->
                <div class="comments-Input">
                    <input type="text" name="author" class="text" size="35" value="<?php $this->remember('author'); ?>" placeholder="🙌用户名"/>
                    <input type="text" name="mail" class="text" size="35" value="<?php $this->remember('mail'); ?>" placeholder="📫邮箱"/>
                    <input type="text" name="url" class="text" size="35" value="<?php $this->remember('url'); ?>" placeholder="🔗博客链接"/>
                </div>
                <?php endif; ?>
                <!-- 输入要回复的内容 -->
                <textarea id="comments-textarea" name="text"><?php $this->remember('text'); ?></textarea>
                <input type="submit" value="发送" class="submit"/>
            </form>
        </div>
    <?php endif; ?>
</div>