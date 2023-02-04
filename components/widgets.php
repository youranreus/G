<?php 
    if($this->options->customWidgets != '') 
    {
        $widgets = json_decode($this->options->customWidgets);
        if (is_array($widgets))
        {
            foreach($widgets as $w)
            {
                switch ($w->type ?? $w->name)
                {
                    case 'photo':
                        echo '
                            <div class="widget widget-photo '.($w->size == 'large' ? 'large' : '').'" style="background-image:url('.$w->url.')">
                                <div>
                                    <p>'.$w->desc.'</p>
                                </div>
                            </div>
                        ';
                        break;
                    case 'video':
                        echo '
                            <div class="widget widget-photo '.($w->size == 'large' ? 'large' : '').'">
                                <video class="widget-video" loop muted autoplay src="'.$w->url.'"></video>
                                <div>
                                    <p>'.$w->desc.'</p>
                                </div>
                            </div>
                        ';
                        break;
                    case 'cate':
                        echo '
                        <div class="widget category-list '.($w->size == 'large' ? 'large' : '').'">
                            <div class="category-content">
                                <li><a onclick="toggleSidebar()" href="'.$w->content[0]->url.'">'.$w->content[0]->name.'</a></li>
                                <li><a onclick="toggleSidebar()" href="'.$w->content[1]->url.'">'.$w->content[1]->name.'</a></li>
                                <li><a onclick="toggleSidebar()" href="'.$w->content[2]->url.'">'.$w->content[2]->name.'</a></li>
                            </div>
                        </div>
                        ';
                        break;
                    case 'hitokoto':
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
                        break;
                    case 'like':
                        echo '
                        <div class="widget '.($w->size == 'large' ? 'large' : 'normal').'" id="DoYouLikeMe" onclick="DYLM(\''.$this->options->siteUrl.'\')">
                            <p>
                            ❤  <span>'.G::DYLM('query').'</span>
                            </p>
                        </div>
                        ';
                        break;
                    case 'comments':
                        echo '<div class="widget widget-recent-comment">';
                        $len = $w->len ?? 5;
                        $obj = $this->widget('Widget_Comments_Recent', 'ignoreAuthor=true');
                        if($obj->have()) {
                            while($obj->next() && $len) {
                                echo '
                                <div class="recent-comment-item">
                                    <img class="avatar" src="https://sdn.geekzu.org/avatar/'.md5($obj->mail).'?s=60" alt="'.$obj->author.'" title="'.$obj->author.'">
                                    <a href="'.G::getArticleInfo($obj->cid)["permalink"].'">
                                        <div class="recent-comment-content">
                                            <div class="meta">
                                                <span>'.$obj->author.'</span>
                                                <span>'.G::getSemanticDate($obj->created).'</span>
                                            </div>
                                            <p>'.G::analyzeMeme($obj->text).'</p>
                                            <div class="meta">
                                                <span></span>
                                                <span>《'.G::getTitleByID($obj->cid).'》</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                ';

                                $len--;
                            }
                        } 
                        else echo '无最新回复';

                        echo '</div>';
                        break;
                    case 'randomPost':
                        $data = G::randomArticle($w->len);
                        echo '<div class="widget widget-random-post">';
                        echo '  <h3>随机文章</h3>';
                        foreach($data as $item) {
                            echo '
                            <a href="'.$item["permalink"].'">
                                <div class="item">
                                    <h4>'.$item["title"].'</h4><span>'.G::getSemanticDate($item['created']).'</span>
                                </div>
                            </a>
                            ';
                        }

                        echo '</div>';
                        break;
                    default:
                        break;
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