<?php 
    if($this->options->customWidgets != '') 
    {
        $widgets = json_decode($this->options->customWidgets);
        if (is_array($widgets))
        {
            foreach($widgets as $w)
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
                else if ($w->type == 'hitokoto')
                {
                    $c = '';
                    $cs = explode(',', $w->cate);
                    foreach($cs as $_)
                        $c = $c.'&c='.$_;
                    
                    $hitokoto = json_decode(file_get_contents('https://v1.hitokoto.cn?encode=json'.$c));

                    echo '
                    <div class="widget widget-hitokoto">
                        <div>
                            <p>'. $hitokoto->hitokoto .'</p>
                            <span>'. $hitokoto->from_who .'</span>
                        </div>
                    </div>
                    ';
                }
                else if ($w->type == 'like')
                {
                    echo '
                    <div class="widget large" id="DoYouLikeMe" onclick="DYLM(\''.$this->options->siteUrl.'\')">
                        <p>
                        ❤  <span>'.G::DYLM('query').'</span>
                        </p>
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