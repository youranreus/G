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
      <?php if ($this->options->enableSliderBarVideo): ?>
        <video id="sliderbar-video" loop muted autoplay src="<?php echo $this->options->profileVideo; ?>" poster="<?php echo $this->options->profilePhoto; ?>"></video>
      <?php endif; ?>
      <div>
        <p><?php echo $this->options->profilePhotoDes; ?></p>
      </div>
    </div>

  </div>

  <div class="sliderbar-content" id="recentComment">
    <div class="">
      <h4>新鲜出炉の评论</h4>
      <?php
      $obj = $this->widget('Widget_Comments_Recent','pageSize=5');
      if($obj->have()){
        while($obj->next()){
          $cos = preg_replace('#\@\((.*?)\)#','<img src="https://cdn.jsdelivr.net/gh/youranreus/R@v1.1.8/G/IMG/bq/$1.png" class="bq">',$obj->text);
          $cos = preg_replace('/\:\:(.*?)\:(.*?)\:\:/','<img src="https://cdn.jsdelivr.net/gh/youranreus/R@v1.1.8/W/bq/$1/$2.png" class="bq">',$cos);
          echo '<a href="'.$obj->permalink.'" onclick="sideMenu_toggle()">
            <div class="recentComment-item clear">
            <div class="recentComment-title">
              <h5 aligen="center">'.getTitleByID($obj->cid).'</h5>
            </div>
              <div class="left">
                <img src="https://sdn.geekzu.org/avatar/'.md5($obj->mail).'" alt="'.$obj->author.'"/>
              </div>
              <div class="right">
                <h5>'.$obj->author.'<span>'.date('Y-m-d',$obj->created).'</span></h5>
                <p>'.$cos.'</p>
              </div>
            </div>
          </a>
          ';
        }
      }else{
        echo '无最新回复';
      }
      ?>
    </div>
  </div>

</div>
<div id="sliderbar-toc" class="move_right">
  <div class="toc">
  </div>
</div>
<div id="sliderbar-cover" onclick="sideMenu_toggle();"></div>
<div id="sliderbar-toc-cover" onclick="toc_toggle();"></div>
