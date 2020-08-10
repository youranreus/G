<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
	$this->need('header.php');
?>

<div id="post">
	<div id="post-header" style="background-image:url(<?php  $imgurl = $this->fields->imgurl;if($imgurl != ''){echo $imgurl;}else{$this->options->defaultPostIMG();}?>)">
		<div id="post-header-mask">
			<div id="post-header-content">
				<h2 id="post-content-title"><?php $this->title();?></h2>
				<span id="post-content-meta"><?php $this->date('F j, Y'); ?> · <?php $this->category(' · '); ?> · <?php get_post_view($this); ?>次阅读</span>
			</div>
		</div>
	</div>
	<?php
		$excerpt = $this->fields->excerpt;
		if($excerpt != ''):
	 ?>
	<div id="post-content-excerpt">
		<blockquote>
			<p><?php  echo $excerpt;?></p>
		</blockquote>
	</div>
<?php endif; ?>
	<div id="post-content">
		<div id="post-content-article">
			<?php
			$db = Typecho_Db::get();
			$sql = $db->select()->from('table.comments')
			    ->where('cid = ?',$this->cid)
			    ->where('mail = ?', $this->remember('mail',true))
			    ->where('status = ?', 'approved')
			//只有通过审核的评论才能看回复可见内容
			    ->limit(1);
			$result = $db->fetchAll($sql);
			if($this->user->hasLogin() || $result) {
			    $content = preg_replace("/\[hide\](.*?)\[\/hide\]/sm",'<div class="reply2see">$1</div>',$this->content);
			}
			else{
			    $content = preg_replace("/\[hide\](.*?)\[\/hide\]/sm",'<div class="reply2see">此处内容需要评论回复后方可阅读。</div>',$this->content);
			}

			emotionContent($content);
			 ?>
		</div>
	</div>

	<?php if ($this->options->feedIMG): ?>
	<p align='center'><a id="feedme" onclick="feedme_show()">喝杯水</a></p>
	<div id="feedme-content">
		<img src="<?php $this->options->feedIMG(); ?>"></img>
	</div>
	<?php endif; ?>

	<div id="post-footer" class="clear">
		<div id="post-tags"><p><?php $this->tags('', true, 'none'); ?></p></div>
		<div id="post-lastEdit"><p>最后编辑于<?php echo formatTime($this->modified);?></p></div>
	</div>
</div>


	<?php $this->need('comments.php'); ?>

	<?php $this->need('footer.php'); ?>
