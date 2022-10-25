<?php
/**
 * 归档页
 *
 * @package custom
 */
$this->need('components/header.php');
?>

    <div class="PAP" id="archives">
        <div id="page-banner" class="PAP-banner <?php $img = G::getArticleFieldsBanner($this);
        if ($img != 'none') echo 'PAP-IMG-Banner'; ?>">
            <?php $img = G::getArticleFieldsBanner($this);
            if ($img != 'none'): ?>
                <div class="PAP-banner-background" style="background-image: url('<?php echo $img; ?>');"></div>
                <div class="PAP-banner-mask"></div>
            <?php endif; ?>
            <div>
                <h1 itemprop="name headline"><?php $this->title() ?></h1>
            </div>
        </div>
        <div id="archives-content">
            <div id="tag-cloud">
                <?php $this->widget('Widget_Metas_Tag_Cloud', array('sort' => 'count', 'ignoreZeroCount' => true, 'desc' => true, 'limit' => 20))->to($tags); ?>
                <?php if ($tags->have()): ?>
                    <?php while ($tags->next()): ?>
                        <li>
                            <a href="<?php $tags->permalink(); ?>" rel="tag" class="size-<?php $tags->split(5, 10, 20, 30); ?>" title="<?php $tags->count(); ?> 个话题"><?php $tags->name(); ?></a>
                        </li>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
            <div id="timeline">
                <?php
                $Month_E = array(1 => "Jan",
                    2 => "Feb",
                    3 => "Mar",
                    4 => "Apr",
                    5 => "May",
                    6 => "Jun",
                    7 => "Jul",
                    8 => "Aug",
                    9 => "Sep",
                    10 => "Oct",
                    11 => "Nov",
                    12 => "Dec");
                $this->widget('Widget_Contents_Post_Recent', 'pageSize=10000')->to($archives);
                $year = 0;
                $mon = 0;
                $i = 0;
                $j = 0;
                $all = array();
                $output = '';
                while ($archives->next()):
                    $year_tmp = date('Y', $archives->created);
                    $mon_tmp = date('n', $archives->created);

                    $y = $year;
                    $m = $mon;
                    if ($mon != $mon_tmp && $mon > 0) $output .= '</div></div>';
                    if ($year != $year_tmp) {
                        $year = $year_tmp;
                        $all[$year] = array();
                    }

                    if ($mon != $mon_tmp) {
                        $mon = $mon_tmp;
                        array_push($all[$year], $mon);
                        $output .= "<div class='archive-title' id='arti-$year-$mon'><h3>$year-$Month_E[$mon]</h3><div class='archives archives-$mon' data-date='$year-$mon'>";
                    }
                    $output .= '<div class="brick"><a href="' . $archives->permalink . '" style="text-decoration:none;"><span class="time">' . date('m-d', $archives->created) . '</span style="color:#888;">' . $archives->title . '</a></div>';
                endwhile;
                $output .= '</div></div>';
                echo $output;

                $html = "";
                $year_now = date("Y");
                foreach ($all as $key => $value) {
                    $html .= "<li class='year' id='year-$key'><a href='#' class='year-toogle' id='yeto-$key'>$key</a><ul class='monthall'>";
                    for ($i = 12; $i > 0; $i--) {
                        if ($key == $year_now && $i > $value[0]) continue;
                        $html .= in_array($i, $value) ? ("<li class='month monthed' id='mont-$key-$i'>$i</li>") : ("<li class='month'>$i</li>");
                    }
                    $html .= "</ul></li>";
                }
                ?>
            </div>
        </div>
    </div>


<?php $this->need('components/footer.php'); ?>