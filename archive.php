<?php $this -> need('header.php'); ?>



 <div id="article">
   <div id="article-content">
     <h1 style="background: white;padding: 10px;border-radius: 10px;text-align: center;margin: 1rem 1%;"><?php $this -> archiveTitle(array('category' => _t('分类「%s」下的文章'), 'search' => _t('包含关键字「%s」的文章'), 'tag' => _t('标签 「%s」 下的文章'), 'author' => _t('「%s」 发布的文章')), '', ''); ?></h1>
     <?php  $this->need('IndexSwitcher.php'); ?>
     <div id="pages" class="clear">
       <?php $this->pageLink('更多 >','next'); ?>
       <?php $this->pageLink('< 返回','prev'); ?>
     </div>
   </div>
 </div>


<?php $this -> need('footer.php'); ?>
