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
    return "<div class='shortcode-notice'>".$content."</div>";
}
add_shortcode( 'notice' , 'shortcode_notice' );


function shortcode_warn( $atts, $content = '' ) {
    return "<div class='shortcode-warn'>".$content."</div>";
}
add_shortcode( 'warn' , 'shortcode_warn' );

function shortcode_warn_block( $atts, $content = '' ) {
    return "<div class='post-content-warn'><div class='post-content-content'>".$content."</div></div>";
}
add_shortcode( 'warn-block' , 'shortcode_warn_block' );


function shortcode_notice_block( $atts, $content = '' ) {
    return "<div class='post-content-notice'><div class='post-content-content'>".$content."</div></div>";
}
add_shortcode( 'notice-block' , 'shortcode_notice_block' );


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
    if(preg_match('/[a-zA-Z]/',$content)){
      return '<iframe class="bilibili" src="//player.bilibili.com/player.html?bvid='.$content.'" scrolling="no" border="0" frameborder="no" framespacing="0" allowfullscreen="true"> </iframe>';
    }else{
            return '<iframe class="bilibili" src="//player.bilibili.com/player.html?aid='.$content.'" scrolling="no" border="0" frameborder="no" framespacing="0" allowfullscreen="true"> </iframe>';
    }
}
add_shortcode( 'bili' , 'shortcode_bili' );

function shortcode_collapse( $atts, $content = '' ) {
    $args = shortcode_atts( array(
        'title' => '折叠框'
    ), $atts );

    return '<div class="collapse-box"><div class="collapse-title"><p>'.$args['title'].'</p></div><div class="collapse-content" style="display: none;">'.shortcodeContent($content).'</div></div>';
}
add_shortcode( 'collapse' , 'shortcode_collapse' );

function shortcode_photos( $atts, $content = '' ) {
  $content = strip_tags($content);
  $content = trim($content);
  $content = str_replace(["\t", "\r\n", "\r", "\n", " "], '', $content);
  $content = preg_replace('/\s+|\t+/u', '', $content);
  $arr = explode('|',$content);

  $result = "<div class='photos'>";

  foreach ($arr as $info) {
    $info = explode(',',$info);
    if($info[0]!=''){
      $result .= "
        <figure>
          <div><img src='".$info[1]."' /></div>
          <figcaption>".$info[0]."</figcaption>
        </figure>
      ";
    }

  }
  $result .="</div>";
  return $result;
}
add_shortcode( 'photos' , 'shortcode_photos' );
