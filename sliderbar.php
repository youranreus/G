<div id="sliderbar" class="move_left">
  <div class="sliderbar-content" id="profile">
    <div class="profile-content">
      <div class="profile-avatar-container">
        <img src="<?php echo $this->options->profileAvatar; ?>" alt="avatar">
      </div>
      <div class="profile-cover" style="background-image:url(<?php echo $this->options->profileBG; ?>)"></div>
      <h4><?php $this->author(); ?></h4>
      <i><?php echo $this->options->profileDes; ?></i>
      <div class="profile-meta clear">
        <?php Typecho_Widget::widget('Widget_Stat')->to($stat); ?>
        <div class="articles">
          <p><?php $stat->publishedPostsNum() ?></p>
          <span>文章数</span>
        </div>
        <div class="reviews">
          <p><?php $stat->publishedCommentsNum() ?></p>
          <span>评论数</span>
        </div>
        <div class="cats">
          <p><?php $stat->categoriesNum() ?></p>
          <span>分类</span>
        </div>
      </div>
    </div>
  </div>

  <div class="clear">
    <div class="sliderbar-content" id="categoryList">
      <div class="category-content">
        <?php $this->widget('Widget_Metas_Category_List')->parse('<li><a onclick="sideMenu_toggle()" href="{permalink}">{name}</a></li>'); ?>
      </div>
    </div>

    <div class="sliderbar-content" id="sliderbar-photo" style="background-image:url(<?php echo $this->options->profilePhoto; ?>)">
      <div>
        <p><?php echo $this->options->profilePhotoDes; ?></p>
      </div>
    </div>
    <script type="text/javascript">
      document.getElementById("sliderbar-photo").style.height = document.getElementById('categoryList').clientHeight;
    </script>
  </div>

</div>
<div id="sliderbar-toc" class="move_right">
  <div class="toc">
  </div>
</div>
<div id="sliderbar-cover" onclick="sideMenu_toggle();"></div>
<div id="sliderbar-toc-cover" onclick="toc_toggle();"></div>
