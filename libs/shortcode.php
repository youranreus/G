<?php
require_once("shortcode.lib.php");
require_once("G.class.php");

//文章跳转
function shortcode_jump_button($atts, $content = '')
{

    $db = Typecho_Db::get();
    $result = $db->fetchAll($db->select()->from('table.contents')
        ->where('status = ?', 'publish')
        ->where('type = ?', 'post')
        ->where('cid = ?', $content)
    );
    if ($result) {
        $i = 1;
        foreach ($result as $val) {
            $val = Typecho_Widget::widget('Widget_Abstract_Contents')->push($val);
            $post_title = htmlspecialchars($val['title']);
            $post_permalink = $val['permalink'];
            $post_date = $val['created'];
            $post_cid = $val['cid'];
            $post_date = date('Y-m-d', $post_date);
            return '
      <div class="ArtinArt">
                <h5><a href="' . $post_permalink . '">' . $post_title . '</a></h5>
                <p class="clear"><span style="float:left">ID:' . $post_cid . '</span><span style="float:right">' . $post_date . '</span></p>
      </div>
      ';
        }
    } else {
        return '<span>id无效QAQ</span>';
    }
}

add_shortcode('art', 'shortcode_jump_button');


function shortcode_notice($atts, $content = '')
{
    return "<div class='shortcode-notice'>" . $content . "</div>";
}

add_shortcode('notice', 'shortcode_notice');


function shortcode_warn($atts, $content = '')
{
    return "<div class='shortcode-warn'>" . $content . "</div>";
}

add_shortcode('warn', 'shortcode_warn');

function shortcode_tag($atts, $content = '')
{
    $args = shortcode_atts(array(
        'type' => 'blue'
    ), $atts);
    return "<span class='post-content-tag tag-" . $args["type"] . "'>" . $content . "</span>";
}

add_shortcode('tag', 'shortcode_tag');

function shortcode_dplayer($atts, $content = '')
{
    $args = shortcode_atts(array(
        'id' => '',
        'pic' => '',
        'url' => ''
    ), $atts);
    return "
    <div id='dplayer-" . $args["id"] . "' class='dp'></div>
    <script>
        let dplayer" . $args["id"] . " = new DPlayer({
        container: document.getElementById('dplayer-" . $args["id"] . "'),
        preload:'auto',
        autoplay: false,
        video: {
            url: '" . $args["url"] . "',
            pic: '" . $args["pic"] . "'
        }
        });
    </script>
    ";
}

add_shortcode('dplayer', 'shortcode_dplayer');

function shortcode_bili($atts, $content = '')
{
    $args = shortcode_atts(array(
        '' => ''
    ), $atts);
    if (preg_match('/[a-zA-Z]/', $content)) {
        return '<iframe class="bilibili" src="//player.bilibili.com/player.html?bvid=' . $content . '" scrolling="no" border="0" frameborder="no" framespacing="0" allowfullscreen="true"> </iframe>';
    } else {
        return '<iframe class="bilibili" src="//player.bilibili.com/player.html?aid=' . $content . '" scrolling="no" border="0" frameborder="no" framespacing="0" allowfullscreen="true"> </iframe>';
    }
}

add_shortcode('bili', 'shortcode_bili');

function shortcode_collapse($atts, $content = '')
{
    $args = shortcode_atts(array(
        'title' => '折叠框'
    ), $atts);

    return '<div class="collapse-box" data-collapsed="true"><div class="collapse-title" onclick="collapseController(this)"><p>' . $args['title'] . '</p></div><div class="collapse-content"><div class="collapse-content-inner">' . G::analyzeContent($content) . '</div></div></div>';
}

add_shortcode('collapse', 'shortcode_collapse');

function shortcode_photos($atts, $content = '')
{
    $content = strip_tags($content);
    $content = trim($content);
    $content = str_replace(["\t", "\r\n", "\r", "\n", " "], '', $content);
    $content = preg_replace('/\s+|\t+/u', '', $content);
    $arr = explode('|', $content);

    $result = "<div class='photos'>";

    foreach ($arr as $info) {
        $info = explode(',', $info);
        if ($info[0] != '') {
            $result .= "
        <figure>
          <div><img src='" . $info[1] . "' /></div>
          <figcaption>" . $info[0] . "</figcaption>
        </figure>
      ";
        }

    }
    $result .= "</div>";
    return $result;
}

add_shortcode('photos', 'shortcode_photos');