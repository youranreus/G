<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<div id="sliderbar" class="move-left">
    <div class="sliderbar-content" id="profile">
        <div class="profile-content">
            <div class="profile-avatar-container">
                <img id="profile-avatar" src="<?php echo $this->options->profileAvatar; ?>" alt="avatar">
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

    <div id="widgets">
        <?php 
            if($this->options->customWidgets != '') 
            {
                $widgets = json_decode($this->options->customWidgets);
                if (isset($widgets->widgets))
                {
                    foreach($widgets->widgets as $w)
                    {
                        if($w->type == "photo")
                        {
                            echo '
                                <div class="widget widget-photo '.($w->size == 'large' ? 'large' : '').'" style="background-image:url('.$w->url.')">
                                    <div>
                                        <p>'.$w->desc.'</p>
                                    </div>
                                </div>
                            ';
                        }
                        else if ($w->type == "cate")
                        {
                            echo '
                                <div class="widget category-list '.($w->size == 'large' ? 'large' : '').'">
                                    <div class="category-content">
                                        <li><a onclick="toggleSidebar()" href="'.$w->content[0]->url.'">'.$w->content[0]->name.'</a></li>
                                        <li><a onclick="toggleSidebar()" href="'.$w->content[1]->url.'">'.$w->content[1]->name.'</a></li>
                                        <li><a onclick="toggleSidebar()" href="'.$w->content[2]->url.'">'.$w->content[2]->name.'</a></li>
                                    </div>
                                </div>
                            ';
                        }
                        else if ($w->type == "video")
                        {
                            echo '
                            <div class="widget widget-photo '.($w->size == 'large' ? 'large' : '').'">
                                <video class="widget-video" loop muted autoplay src="'.$w->url.'"></video>
                                <div>
                                    <p>'.$w->desc.'</p>
                                </div>
                            </div>
                            ';
                        }
                    }
                }
                else
                {
                    echo '<script>alert("widgets配置出错");</script>';
                }
            }
            else
            { ?>
                <div class="widget category-list" style="<?php if ($this->options->profilePhoto == ''): ?>width: 15rem;<?php endif; ?>">
                    <div class="category-content">
                        <?php $this->widget('Widget_Metas_Category_List')->parse('<li><a onclick="toggleSidebar()" href="{permalink}">{name}</a></li>'); ?>
                    </div>
                </div>
                <?php if ($this->options->profilePhoto != ''): ?>
                    <div class="widget widget-photo" style="background-image:url(<?php echo $this->options->profilePhoto; ?>)">
                        <?php if ($this->options->profileVideo != ''): ?>
                            <video class="widget-video" loop muted autoplay src="<?php echo $this->options->profileVideo; ?>" poster="<?php echo $this->options->profilePhoto; ?>"></video>
                        <?php endif; ?>
                        <div>
                            <p><?php echo $this->options->profilePhotoDes; ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            <?php }
        ?>
    </div>
</div>
<div id="sliderbar-cover" onclick="toggleSidebar()"></div>