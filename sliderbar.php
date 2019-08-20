<div id="sliderbar">
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
				<a href="<?php Helper::options()->siteUrl()?>links.html" onclick="sideMenu_toggle()">友人帐</a>
				<a href="<?php Helper::options()->siteUrl()?>archive.html" onclick="sideMenu_toggle()">归档</a>
				<a href="<?php Helper::options()->siteUrl()?>about.html" onclick="sideMenu_toggle()">关于</a>
      </div>
    </div>
  </div>
  <div class="sliderbar-content-menu">
    <div class="Sliderbar-content clear">
      <h2>控制面板</h2>

    </div>
  </div>
</div>

<div id="sliderbar-cover" onclick="sideMenu_toggle();"></div>
