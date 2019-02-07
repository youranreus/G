<?php
/**
 * 优雅のTYPECHO主题
 *
 *
 * @package G
 * @author YOURAN
 * @version beta
 * @link https://gundam.exia.xyz/
 */

 $this->need('header.php');
 ?>
<div id="article">
  <div id="article-content">
 <?php while($this->next()): ?>
    <div id="article-<?php $this->cid();?>" class="article-item">
    	<h2 id="article-<?php $this->cid();?>-title"><a href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h2>
      <p><?php $this->excerpt(50); ?></p>
      <span><?php $this->category(''); ?><?php $this->date('F j, Y'); ?></span>
    </div>
<?php endwhile; ?>
<div id="pages" class="clear">
  <?php $this->pageLink('更多 >','next'); ?>
  <?php $this->pageLink('< 返回','prev'); ?>
</div>
  </div>
</div>




  <?php $this->need('footer.php'); ?>
