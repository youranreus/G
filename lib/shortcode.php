<?php
/**
 *
 * 感谢Maicong大佬的短代码解析QwQ
 * 注册短代码
 *
 * @author  MaiCong <i@maicong.me>
 * @link    https://github.com/maicong/stay
 * @since   1.5.4
 *
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;

require_once __DIR__ . '/shortcode.main.php';

//文章跳转
function shortcode_jump_button( $atts, $content= ''){

  $db = Typecho_Db::get();
  $result = $db->fetchAll($db->select()->from('table.contents')
    ->where('status = ?','publish')
    ->where('type = ?', 'post')
    ->where('cid = ?',$content)
  );
  if($result){
    $i=1;
    foreach($result as $val){
      $val = Typecho_Widget::widget('Widget_Abstract_Contents')->push($val);
      $post_title = htmlspecialchars($val['title']);
      $post_permalink = $val['permalink'];
      $post_date = $val['created'];
      $post_cid = $val['cid'];
      $post_date = date('Y-m-d',$post_date);
      return '
      <div class="ArtinArt">
                <h4><a href="'.$post_permalink.'">'.$post_title.'</a></h4>
                <p class="clear"><span style="float:left">ID:'.$post_cid.'</span><span style="float:right">'.$post_date.'</span></p>
      </div>
      ';
    }
  }
  else{
    return '<span>id无效QAQ</span>';
  }



}
add_shortcode('art','shortcode_jump_button');

// 下载
function shortcode_button_dl( $atts, $content = '' ) {
    $args = shortcode_atts( array(
        'href' => 'https://',
        'target' => '_blank'
    ), $atts );
    return '<div class="post-download"><a href="//' .  $args['href'] . '" target="' . $args['target'] . '"><span>' . $content . '</span></a></div>';
}
add_shortcode( 'dl' , 'shortcode_button_dl' );


function shortcode_notice( $atts, $content = '' ) {
    return "<div class='post-content-notice'>".$content."</div>";
}
add_shortcode( 'notice' , 'shortcode_notice' );


function shortcode_warn( $atts, $content = '' ) {
    return "<div class='post-content-warn'>".$content."</div>";
}
add_shortcode( 'warn' , 'shortcode_warn' );


function shortcode_tag( $atts, $content = '' ) {
    $args = shortcode_atts( array(
        'type' => 'blue'
    ), $atts );
    return "<span class='post-content-tag tag-".$args["type"]."'>".$content."</span>";
}
add_shortcode( 'tag' , 'shortcode_tag' );

function shortcode_dplayer( $atts, $content = '' ) {
    $args = shortcode_atts( array(
        'id'=>'',
        'pic'=>'',
        'url'=>''
    ), $atts );
    return "
    <div id='dplayer-".$args["id"]."' class='dp'></div>
    <script>
    var dplayer". $args["id"] ." = new DPlayer({
    container: document.getElementById('dplayer-".$args["id"]."'),
    preload:'auto',
    autoplay: false,
    video: {
        url: '".$args["url"]."',
        pic: '".$args["pic"]."'
      }
    });
    </script>
    ";
}
add_shortcode( 'dplayer' , 'shortcode_dplayer' );

function shortcode_bili( $atts, $content = '' ) {
    $args = shortcode_atts( array(
        '' => ''
    ), $atts );
    return '<iframe class="bilibili" src="//player.bilibili.com/player.html?aid='.$content.'" scrolling="no" border="0" frameborder="no" framespacing="0" allowfullscreen="true"> </iframe>';
}
add_shortcode( 'bili' , 'shortcode_bili' );
