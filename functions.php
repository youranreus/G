<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
 function themeConfig($form) {
   echo "<h2 style='color:RGB(182,177,150)'>主题G配置界面：</h2>";
   $bkimg = new Typecho_Widget_Helper_Form_Element_Text('bkimg', NULL, NULL,_t('背景图片'), _t('想要啥背景？'));
   $form->addInput($bkimg);

   $beian = new Typecho_Widget_Helper_Form_Element_Text('beian', NULL, NULL,_t('备案号'), _t('没备案当我没说'));
   $form->addInput($beian);

   $enableUpyun = new Typecho_Widget_Helper_Form_Element_Radio('enableUpyun',
    array('1' => _t('我是盟友'),
    '0' => _t('啥东西，不要')),
    '0', _t('又拍云联盟开关'), _t('默认为关闭'));
   $form->addInput($enableUpyun);

   $enableOpac = new Typecho_Widget_Helper_Form_Element_Radio('enableOpac',
    array('1' => _t('喜欢'),
    '0' => _t('不要，快瞎了')),
    '0', _t('半透明开关'), _t('默认为打开'));
   $form->addInput($enableOpac);

  }
  //获取评论的锚点链接
  function get_comment_at($coid)
  {
      $db   = Typecho_Db::get();
      $prow = $db->fetchRow($db->select('parent')->from('table.comments')
                                   ->where('coid = ? AND status = ?', $coid, 'approved'));
      $parent = $prow['parent'];
      if ($parent != "0") {
          $arow = $db->fetchRow($db->select('author')->from('table.comments')
                                       ->where('coid = ? AND status = ?', $parent, 'approved'));
          $author = $arow['author'];
          $href   = '<span class="comment-reply-author" href="#comment-' . $parent . '">@' . $author . '</span>';
          echo $href;
      } else {
          echo '';
      }
  }

  function formatTime($time)
  {
      $text = '';
      $time = intval($time);
      $ctime = time();
      $t = $ctime - $time; //时间差
      if ($t < 0) {
          return date('Y-m-d', $time);
      }
      ;
      $y = date('Y', $ctime) - date('Y', $time);//是否跨年
      switch ($t) {
          case $t == 0:
              $text = '刚刚';
              break;
          case $t < 60://一分钟内
              $text = $t . '秒前';
              break;
          case $t < 3600://一小时内
              $text = floor($t / 60) . '分钟前';
              break;
          case $t < 86400://一天内
              $text = floor($t / 3600) . '小时前'; // 一天内
              break;
          case $t < 2592000://30天内
              if($time > strtotime(date('Ymd',strtotime("-1 day")))) {
                  $text = '昨天';
              } elseif($time > strtotime(date('Ymd',strtotime("-2 days")))) {
                  $text = '前天';
              } else {
                  $text = floor($t / 86400) . '天前';
              }
              break;
          case $t < 31536000 && $y == 0://一年内 不跨年
              $m = date('m', $ctime) - date('m', $time) -1;

              if($m == 0) {
                  $text = floor($t / 86400) . '天前';
              } else {
                  $text = $m . '个月前';
              }
              break;
          case $t < 31536000 && $y > 0://一年内 跨年
              $text = (11 - date('m', $time) + date('m', $ctime)) . '个月前';
              break;
          default:
              $text = (date('Y', $ctime) - date('Y', $time)) . '年前';
              break;
      }

      return $text;
  }

  function img_postthumb($content) {

  preg_match_all("/\<img.*?src\=\"(.*?)\"[^>]*>/i", $content, $thumbUrl);  //通过正则式获取图片地址
  $img_src = $thumbUrl[1][0];  //将赋值给img_src
  $img_counter = count($thumbUrl[0]);  //一个src地址的计数器

  switch ($img_counter > 0) {
  case $allPics = 1:
  echo $img_src;  //当找到一个src地址的时候，输出缩略图
  break;
  default:
  echo "";  //没找到(默认情况下)，不输出任何内容
  };
  }
