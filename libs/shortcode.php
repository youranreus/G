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
    return "<div class='shortcode-notice'>" . G::analyzeContent($content) . "</div>";
}

add_shortcode('notice', 'shortcode_notice');


function shortcode_warn($atts, $content = '')
{
    return "<div class='shortcode-warn'>" . G::analyzeContent($content) . "</div>";
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

function shortcode_download($atts, $content = '')
{
    $args = shortcode_atts(array(
        'url' => ''
    ), $atts);
    return "<div class='shortcode-download'><a target='_blank' href='".$args["url"]."'> <svg t='1663510610479' class='icon' viewBox='0 0 1024 1024' version='1.1' xmlns='http://www.w3.org/2000/svg' p-id='2569' width='200' height='200'><path d='M808.192 246.528a320.16 320.16 0 0 0-592.352 0A238.592 238.592 0 0 0 32 479.936c0 132.352 107.648 240 240 240h91.488a32 32 0 1 0 0-64H272a176.192 176.192 0 0 1-176-176 175.04 175.04 0 0 1 148.48-173.888l19.04-2.976 6.24-18.24C305.248 181.408 402.592 111.936 512 111.936a256 256 0 0 1 242.208 172.896l6.272 18.24 19.04 2.976A175.04 175.04 0 0 1 928 479.936c0 97.024-78.976 176-176 176h-97.28a32 32 0 1 0 0 64h97.28c132.352 0 240-107.648 240-240a238.592 238.592 0 0 0-183.808-233.408z' p-id='2570'></path><path d='M649.792 789.888L544 876.48V447.936a32 32 0 0 0-64 0V876.48l-106.752-87.424a31.968 31.968 0 1 0-40.544 49.504l159.04 130.24a32 32 0 0 0 40.576 0l158.048-129.44a32 32 0 1 0-40.576-49.472z' p-id='2571'></path></svg> " . $content . "</a></div>";
}

add_shortcode('dl', 'shortcode_download');

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
        var dplayer" . $args["id"] . " = new DPlayer({
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