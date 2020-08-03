<div id="sliderbar" class="move_left">
  <div class="sliderbar-content-menu">
    <div class="Sliderbar-content clear">
      <div class="Sliderbar-content-switch clear">
        <h2>CATEGORIES</h2>
        <a onclick="show_slide_content(1);"><i class="i down"></i></a>
      </div>
      <div id="Sliderbar-content-1" class="clear">
        <?php $this->widget('Widget_Metas_Category_List')->parse('<a onclick="sideMenu_toggle()" href="{permalink}">{name}</a>'); ?>
      </div>
    </div>
  </div>
  <div class="sliderbar-content-menu">
    <div class="Sliderbar-content clear">
      <div class="Sliderbar-content-switch clear">
        <h2>PAGES</h2>
        <a onclick="show_slide_content(2);"><i class="i down"></i></a>
      </div>
      <div id="Sliderbar-content-2" class="clear">
        <a href="<?php Helper::options()->siteUrl()?>" onclick="sideMenu_toggle()">首页</a>
				<?php if ($this->options->enableIndexPage): ?>
						<a href="<?php Helper::options()->siteUrl()?>blog" onclick="sideMenu_toggle()">文章</a>
				<?php endif; ?>
        <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
        <?php while($pages->next()): ?>
        <a href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>" onclick="sideMenu_toggle()"><?php $pages->title(); ?></a>
        <?php endwhile; ?>
      </div>
    </div>
  </div>
</div>
<div id="sliderbar-toc" class="move_right">
  <div class="toc">
  </div>
</div>
<div id="sliderbar-cover" onclick="sideMenu_toggle();"></div>
<div id="sliderbar-toc-cover" onclick="toc_toggle();"></div>
