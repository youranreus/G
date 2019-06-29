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

// // 项目面板
// function shortcode_panel_task( $atts, $content = '' ) {
//     return '<div class="tip mc-panel p-task clearfix">' . $content . '</div>';
// }
// add_shortcode( 'task' , 'shortcode_panel_task' );

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
