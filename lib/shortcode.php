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


// 下载
function shortcode_button_dl( $atts, $content = '' ) {
    $args = shortcode_atts( array(
        'href' => 'https://',
        'target' => '_blank'
    ), $atts );
    return '<div class="post-download"><a href="//' .  $args['href'] . '" target="' . $args['target'] . '"><span>' . $content . '</span></a></div>';
}
add_shortcode( 'dl' , 'shortcode_button_dl' );
