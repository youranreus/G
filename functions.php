<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
function themeConfig($form) {
    echo "<link rel='stylesheet' href='https://cdn.jsdelivr.net/gh/youranreus/R@v1.1.5/G/CSS/S.css'/>";
    echo "<h2>G主题设置</h2>";

    $favicon = new Typecho_Widget_Helper_Form_Element_Text('favicon', NULL, NULL, _t('图标') , _t(''));
    $form->addInput($favicon);

    $bkimg = new Typecho_Widget_Helper_Form_Element_Text('bkimg', NULL, NULL, _t('背景图片') , _t('想要啥背景？'));
    $form->addInput($bkimg);

    $bkcolor = new Typecho_Widget_Helper_Form_Element_Text('bkcolor', NULL, NULL, _t('背景颜色') , _t('如果没有想要的背景就换成纯色吧'));
    $form->addInput($bkcolor);

    $headerbkcolor = new Typecho_Widget_Helper_Form_Element_Text('headerbkcolor', NULL, NULL, _t('头部背景颜色') , _t('#787878'));
    $form->addInput($headerbkcolor);

    $beian = new Typecho_Widget_Helper_Form_Element_Text('beian', NULL, NULL, _t('备案号') , _t('没备案当我没说'));
    $form->addInput($beian);

    $builtTime = new Typecho_Widget_Helper_Form_Element_Text('builtTime', NULL, NULL, _t('运行时间') , _t('格式YYYY-MM-DD'));
    $form->addInput($builtTime);

    $animateTime = new Typecho_Widget_Helper_Form_Element_Text('animateTime', NULL, NULL, _t('动画过渡时间') , _t('格式 1s'));
    $form->addInput($animateTime);

    $feedIMG = new Typecho_Widget_Helper_Form_Element_Text('feedIMG', NULL, NULL, _t('打赏二维码图片') , _t('http://...'));
    $form->addInput($feedIMG);

    $defaultPostIMG = new Typecho_Widget_Helper_Form_Element_Text('defaultPostIMG', NULL, NULL, _t('没有设置文章头图的就用这里的图片啦') , _t('http://...'));
    $form->addInput($defaultPostIMG);

    $headerLOGO = new Typecho_Widget_Helper_Form_Element_Text('headerLOGO', NULL, NULL, _t('头部logo') , _t('如果留空则不显示'));
    $form->addInput($headerLOGO);

    $Links = new Typecho_Widget_Helper_Form_Element_Textarea('Links', NULL, NULL, _t('友情链接'), _t('按照格式输入链接信息，格式：<br><strong>链接名称,链接地址,链接描述,链接分类</strong><br>不同信息之间用英文逗号“,”分隔，例如：<br><strong>季悠然,https://gundam.exia.xyz/,寻找有趣的灵魂,好朋友,https://xxx.xxx.com/avatar.jpg</strong><br>多个链接换行即可，一行一个'));
    $form->addInput($Links);

    $enableIndexPage = new Typecho_Widget_Helper_Form_Element_Radio('enableIndexPage', array(
        '1' => _t('cool') ,
        '0' => _t('nope')
    ) , '0', _t('是否使用独立页面做首页') , _t('默认为关闭'));
    $form->addInput($enableIndexPage);

    $articlePath = new Typecho_Widget_Helper_Form_Element_Text('articlePath', NULL, NULL, _t('头部文章路径') , _t('默认index.php/blog'));
    $form->addInput($articlePath);

    $enableSmooth = new Typecho_Widget_Helper_Form_Element_Radio('enableSmooth', array(
        '1' => _t('开启') ,
        '0' => _t('关闭')
    ) , '1', _t('开启平滑滚动') , _t('默认为开启'));
    $form->addInput($enableSmooth);

    $enablenprogress = new Typecho_Widget_Helper_Form_Element_Radio('enablenprogress', array(
        '1' => _t('开启') ,
        '0' => _t('关闭')
    ) , '0', _t('开启加载进度条') , _t('默认为关闭'));
    $form->addInput($enablenprogress);

    $enableHeaderSearch = new Typecho_Widget_Helper_Form_Element_Radio('enableHeaderSearch', array(
        '1' => _t('开启') ,
        '0' => _t('关闭')
    ) , '0', _t('在头部添加一个搜索') , _t('默认为关闭'));
    $form->addInput($enableHeaderSearch);

    $enableUpyun = new Typecho_Widget_Helper_Form_Element_Radio('enableUpyun', array(
        '1' => _t('我是盟友') ,
        '0' => _t('啥东西，不要')
    ) , '0', _t('又拍云联盟开关') , _t('默认为关闭'));
    $form->addInput($enableUpyun);

    $enableAliLogo = new Typecho_Widget_Helper_Form_Element_Radio('enableAliLogo', array(
        '1' => _t('给爸爸打个广告') ,
        '0' => _t('不给广告费就算了')
    ) , '0', _t('阿里云图标') , _t('默认为关闭'));
    $form->addInput($enableAliLogo);

    $enableOpac = new Typecho_Widget_Helper_Form_Element_Radio('enableOpac', array(
        '1' => _t('喜欢') ,
        '0' => _t('不要，快瞎了')
    ) , '0', _t('半透明开关') , _t('默认为打开'));
    $form->addInput($enableOpac);

    $IndexStyle = new Typecho_Widget_Helper_Form_Element_Radio('IndexStyle', array(
        '2' => _t('大图') ,
        '1' => _t('单列') ,
        '0' => _t('双列')
    ) , '0', _t('首页样式') , _t('默认为双列'));
    $form->addInput($IndexStyle);

    $CustomCSS = new Typecho_Widget_Helper_Form_Element_Textarea('CustomCSS', NULL, NULL, _t('自定义CSS'), _t('#logo{...}'));
    $form->addInput($CustomCSS);

    $CustomJSh = new Typecho_Widget_Helper_Form_Element_Textarea('CustomJSh', NULL, NULL, _t('自定义JS(head前)'), _t('var...'));
    $form->addInput($CustomJSh);

    $CustomJSf = new Typecho_Widget_Helper_Form_Element_Textarea('CustomJSf', NULL, NULL, _t('自定义JS(footer后，主题含JQ)'), _t('var...'));
    $form->addInput($CustomJSf);

    //主题配置备份
    $db = Typecho_Db::get();
    $sjdq=$db->fetchRow($db->select()->from ('table.options')->where ('name = ?', 'theme:G'));
    $ysj = $sjdq['value'];
    if(isset($_POST['type']))
    {
      if($_POST["type"]=="备份模板数据")
      {
        if($db->fetchRow($db->select()->from ('table.options')->where ('name = ?', 'theme:Gbf')))
        {
          $update = $db->update('table.options')->rows(array('value'=>$ysj))->where('name = ?', 'theme:Gbf');
          $updateRows= $db->query($update);
          echo '<div class="tongzhi">备份已更新，请等待自动刷新！如果等不到请点击';
          ?>
            <a href="<?php Helper::options()->adminUrl('options-theme.php'); ?>">这里</a></div>
            <script language="JavaScript">window.setTimeout("location=\'<?php Helper::options()->adminUrl('options-theme.php'); ?>\'", 2500);</script>
          <?php
        }
        else
        {
          if($ysj)
          {
            $insert = $db->insert('table.options')->rows(array('name' => 'theme:Gbf','user' => '0','value' => $ysj));
            $insertId = $db->query($insert);
            echo '<div class="tongzhi">备份完成，请等待自动刷新！如果等不到请点击';
            ?>
              <a href="<?php Helper::options()->adminUrl('options-theme.php'); ?>">这里</a></div>
              <script language="JavaScript">window.setTimeout("location=\'<?php Helper::options()->adminUrl('options-theme.php'); ?>\'", 2500);</script>
            <?php
          }
        }
      }
      if($_POST["type"]=="还原模板数据")
      {

        if($db->fetchRow($db->select()->from ('table.options')->where ('name = ?', 'theme:Gbf')))
        {

          $sjdub=$db->fetchRow($db->select()->from ('table.options')->where ('name = ?', 'theme:Gbf'));
          $bsj = $sjdub['value'];
          $update = $db->update('table.options')->rows(array('value'=>$bsj))->where('name = ?', 'theme:G');
          $updateRows= $db->query($update);
          echo '<div class="tongzhi">检测到模板备份数据，恢复完成，请等待自动刷新！如果等不到请点击';
          ?>
            <a href="<?php Helper::options()->adminUrl('options-theme.php'); ?>">这里</a></div>
            <script language="JavaScript">window.setTimeout("location=\'<?php Helper::options()->adminUrl('options-theme.php'); ?>\'", 2000);</script>
          <?php

        }
        else
        {

          echo '<div class="tongzhi">没有模板备份数据，恢复不了哦！</div>';

        }
      }
      if($_POST["type"]=="删除备份数据")
      {
        if($db->fetchRow($db->select()->from ('table.options')->where ('name = ?', 'theme:Gbf')))
        {
          $delete = $db->delete('table.options')->where ('name = ?', 'theme:Gbf');
          $deletedRows = $db->query($delete);
          echo '<div class="tongzhi">删除成功，请等待自动刷新，如果等不到请点击';
          ?>
          <a href="<?php Helper::options()->adminUrl('options-theme.php'); ?>">这里</a></div>
          <script language="JavaScript">window.setTimeout("location=\'<?php Helper::options()->adminUrl('options-theme.php'); ?>\'", 2500);</script>
          <?php
        }
        else
        {
          echo '<div class="tongzhi">不用删了！备份不存在！！！</div>';
        }
      }
    }
    echo '<div id="backup"><form class="protected Data-backup" action="?Gbf" method="post"><h4>数据备份</h4>
    <input type="submit" name="type" class="btn btn-s" value="备份模板数据" />&nbsp;&nbsp;<input type="submit" name="type" class="btn btn-s" value="还原模板数据" />&nbsp;&nbsp;<input type="submit" name="type" class="btn btn-s" value="删除备份数据" /></form></div>';
}

/**
* 为文章编辑页自动插入自定义字段
*/
function themeFields(Typecho_Widget_Helper_Layout $layout)
{
    $excerpt = new Typecho_Widget_Helper_Form_Element_Textarea('excerpt', null, null, '文章引语', '会显示在标题下方，单栏模式时会覆盖文章摘要');
    $layout->addItem($excerpt);
    $imgurl = new Typecho_Widget_Helper_Form_Element_Text('imgurl', null, null, '文章主图', '该图片会用于主页文章列表及文章头图的显示。');
    $layout->addItem($imgurl);
}

//感谢泽泽大佬的代码
Typecho_Plugin::factory('Widget_Abstract_Contents')->excerptEx = array('Gx','reply2see');
Typecho_Plugin::factory('Widget_Abstract_Contents')->contentEx = array('Gx','reply2see');
Typecho_Plugin::factory('admin/write-post.php')->bottom = array('Gx', 'addButton');
Typecho_Plugin::factory('admin/write-page.php')->bottom = array('Gx', 'addButton');

/**
* 为文章编辑器插入自定义代码
*
* @author      qqdie ,modified by youranreus
*
*/
class Gx {

    /**
    * 回复可见代码替换
    */
    public static function reply2see($con,$obj,$text)
    {
      $text = empty($text)?$con:$text;
      if(!$obj->is('single')){
        $text = preg_replace("/\[hide\](.*?)\[\/hide\]/sm",'',$text);
      }
      return $text;
    }

    /**
    * 文章编辑器插入按钮
    */
    public static function addButton()
    {
      echo '  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/youranreus/R@v1.1.7/G/CSS/OwO.min.css?v=2" rel="stylesheet" />';

        echo '
        <style>
          .wmd-button-row{
            height:auto;
          }
          .wmd-button{
            color:#999;
          }
          .OwO{
            background:#fff;
          }
          #g-shortcode{
            line-height: 30px;
            background:#fff;
          }
          #g-shortcode a{
            cursor: pointer;
            font-weight:bold;
            font-size:14px;
            text-decoration:none;
            color: #999 !important;
            margin:5px;
            display:inline-block;
          }
        </style>
        ';
        //核心JS
        echo '<script src="https://cdn.jsdelivr.net/gh/youranreus/R@v1.2.5/G/JS/editor.js"></script>';
    }

}

require_once __DIR__ . '/lib/Parsedown.php';
require_once __DIR__ . '/lib/shortcode.php';


/**
* 网站运行时间
*/
function getBuildTime($builtTime) {
  echo $builtTime;
}


/**
* 文章阅读次数
*/
function get_post_view($archive)
{

  $cid    = $archive->cid;
  $db     = Typecho_Db::get();
  $prefix = $db->getPrefix();

  if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents'))))
  {
    $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
    echo 0;

    return;
  }

  $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));

  if ($archive->is('single'))
  {
    $views = Typecho_Cookie::get('extend_contents_views');

    if(empty($views))
    {
      $views = array();
    }
    else
    {
      $views = explode(',', $views);
    }

    if(!in_array($cid,$views))
    {
      $db->query($db->update('table.contents')->rows(array('views' => (int) $row['views'] + 1))->where('cid = ?', $cid));
      array_push($views, $cid);
      $views = implode(',', $views);
      Typecho_Cookie::set('extend_contents_views', $views); //记录查看cookie
    }
  }
  echo $row['views'];

}


/**
* 通过id获取文章信息
*/

function GetPostById($id){

		$db = Typecho_Db::get();
		$result = $db->fetchAll($db->select()->from('table.contents')
			->where('status = ?','publish')
			->where('type = ?', 'post')
			->where('cid = ?',$id)
		);
		if($result){
			$i=1;
			foreach($result as $val){
				$val = Typecho_Widget::widget('Widget_Abstract_Contents')->push($val);
				$post_title = htmlspecialchars($val['title']);
				$post_permalink = $val['permalink'];
        $post_date = $val['created'];
        $post_date = date('Y-m-d',$post_date);
				echo '<div class="ArtinArt">
                <h4><a href="'.$post_permalink.'">'.$post_title.'</a></h4>
                <p class="clear"><span style="float:left">ID:'.$id.'</span><span style="float:right">'.$post_date.'</span></p>
              </div>';
			}
		}
    else{
      return '<span>id无效QAQ</span>';
    }
}


/**
* 时间友好化
*/
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

/**
* 文章图片计数
*/
function imgNum($content){
  $output = preg_match_all('#<img(.*?) src="([^"]*/)?(([^"/]*)\.[^"]*)"(.*?)>#', $content,$s);
  $cnt = count( $s[1] );
  return $cnt;
}

/**
* 评论锚点修复
*/
function Comment_hash_fix($archive){
  $header = "<script type=\"text/javascript\">
  (function () {
      window.TypechoComment = {
          dom : function (id) {
              return document.getElementById(id);
          },

          create : function (tag, attr) {
              var el = document.createElement(tag);

              for (var key in attr) {
                  el.setAttribute(key, attr[key]);
              }

              return el;
          },
          reply : function (cid, coid) {
              var comment = this.dom(cid), parent = comment.parentNode,
                  response = this.dom('" . $archive->respondId . "'), input = this.dom('comment-parent'),
                  form = 'form' == response.tagName ? response : response.getElementsByTagName('form')[0],
                  textarea = response.getElementsByTagName('textarea')[0];
              if (null == input) {
                  input = this.create('input', {
                      'type' : 'hidden',
                      'name' : 'parent',
                      'id'   : 'comment-parent'
                  });
                  form.appendChild(input);
              }
              input.setAttribute('value', coid);
              if (null == this.dom('comment-form-place-holder')) {
                  var holder = this.create('div', {
                      'id' : 'comment-form-place-holder'
                  });
                  response.parentNode.insertBefore(holder, response);
              }
              comment.appendChild(response);
              this.dom('cancel-comment-reply-link').style.display = '';
              if (null != textarea && 'text' == textarea.name) {
                  textarea.focus();
              }
              return false;
          },
          cancelReply : function () {
              var response = this.dom('{$archive->respondId}'),
              holder = this.dom('comment-form-place-holder'), input = this.dom('comment-parent');
              if (null != input) {
                  input.parentNode.removeChild(input);
              }
              if (null == holder) {
                  return true;
              }
              this.dom('cancel-comment-reply-link').style.display = 'none';
              holder.parentNode.insertBefore(response, holder);
              return false;
          }
      };
  })();
  </script>
  ";
  return $header;
}



/**
* 文章内容解析（短代码，表情）
*/
function emotionContent($content)
{
    //HyperDown解析
    //$Parsedown = new Parsedown();
    //$content =  $Parsedown->text($content);
    //表情解析
    $fcontent = preg_replace('#\@\((.*?)\)#','<img src="https://cdn.jsdelivr.net/gh/youranreus/R@v1.1.5/G/IMG/bq/$1.png" class="bq">',$content);
    //感谢Maicong大佬的短代码解析QwQ
    $fcontent = do_shortcode($fcontent);
    //输出最终结果
    echo $fcontent;
}

/**
* 文章内容解析（短代码，表情）
*/
function shortcodeContent($content)
{
    $Parsedown = new Parsedown();
    $fcontent =  $Parsedown->text($content);
    $fcontent = preg_replace('#\@\((.*?)\)#','<img src="https://cdn.jsdelivr.net/gh/youranreus/R@v1.1.5/G/IMG/bq/$1.png" class="bq">',$fcontent);
    return $fcontent;
}

/**
* 泽泽大佬的字数统计
*/
Typecho_Plugin::factory('admin/write-post.php')->bottom = array('myG', 'one');
Typecho_Plugin::factory('admin/write-page.php')->bottom = array('myG', 'one');
class myG {
    public static function one()
    {
    ?>
<style>
.field.is-grouped{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:start;-ms-flex-pack:start;justify-content:flex-start;  -ms-flex-wrap: wrap;flex-wrap: wrap;}.field.is-grouped>.control{-ms-flex-negative:0;flex-shrink:0}.field.is-grouped>.control:not(:last-child){margin-bottom:.5rem;margin-right:.75rem}.field.is-grouped>.control.is-expanded{-webkit-box-flex:1;-ms-flex-positive:1;flex-grow:1;-ms-flex-negative:1;flex-shrink:1}.field.is-grouped.is-grouped-centered{-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center}.field.is-grouped.is-grouped-right{-webkit-box-pack:end;-ms-flex-pack:end;justify-content:flex-end}.field.is-grouped.is-grouped-multiline{-ms-flex-wrap:wrap;flex-wrap:wrap}.field.is-grouped.is-grouped-multiline>.control:last-child,.field.is-grouped.is-grouped-multiline>.control:not(:last-child){margin-bottom:.75rem}.field.is-grouped.is-grouped-multiline:last-child{margin-bottom:-.75rem}.field.is-grouped.is-grouped-multiline:not(:last-child){margin-bottom:0}.tags{-webkit-box-align:center;-ms-flex-align:center;align-items:center;display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;-webkit-box-pack:start;-ms-flex-pack:start;justify-content:flex-start}.tags .tag{margin-bottom:.5rem}.tags .tag:not(:last-child){margin-right:.5rem}.tags:last-child{margin-bottom:-.5rem}.tags:not(:last-child){margin-bottom:1rem}.tags.has-addons .tag{margin-right:0}.tags.has-addons .tag:not(:first-child){border-bottom-left-radius:0;border-top-left-radius:0}.tags.has-addons .tag:not(:last-child){border-bottom-right-radius:0;border-top-right-radius:0}.tag{-webkit-box-align:center;-ms-flex-align:center;align-items:center;background-color:#f5f5f5;border-radius:3px;color:#4a4a4a;display:-webkit-inline-box;display:-ms-inline-flexbox;display:inline-flex;font-size:.75rem;height:2em;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;line-height:1.5;padding-left:.75em;padding-right:.75em;white-space:nowrap}.tag .delete{margin-left:.25em;margin-right:-.375em}.tag.is-white{background-color:#fff;color:#0a0a0a}.tag.is-black{background-color:#0a0a0a;color:#fff}.tag.is-light{background-color:#fff;color:#363636}.tag.is-dark{background-color:#363636;color:#f5f5f5}.tag.is-primary{background-color:#00d1b2;color:#fff}.tag.is-info{background-color:#3273dc;color:#fff}.tag.is-success{background-color:#23d160;color:#fff}.tag.is-warning{background-color:#ffdd57;color:rgba(0,0,0,.7)}.tag.is-danger{background-color:#ff3860;color:#fff}.tag.is-large{font-size:1.25rem}.tag.is-delete{margin-left:1px;padding:0;position:relative;width:2em}.tag.is-delete:after,.tag.is-delete:before{background-color:currentColor;content:"";display:block;left:50%;position:absolute;top:50%;-webkit-transform:translateX(-50%) translateY(-50%) rotate(45deg);transform:translateX(-50%) translateY(-50%) rotate(45deg);-webkit-transform-origin:center center;transform-origin:center center}.tag.is-delete:before{height:1px;width:50%}.tag.is-delete:after{height:50%;width:1px}.tag.is-delete:focus,.tag.is-delete:hover{background-color:#e8e8e8}.tag.is-delete:active{background-color:#dbdbdb}.tag.is-rounded{border-radius:290486px}#panel-toggle{border: 0;height: 20px;position: relative;top: 7px;cursor: pointer;}
</style>
<script language="javascript">
    var EventUtil = function() {};
    EventUtil.addEventHandler = function(obj, EventType, Handler) {
        if (obj.addEventListener) {
            obj.addEventListener(EventType, Handler, false);
        }
        else if (obj.attachEvent) {
            obj.attachEvent('on' + EventType, Handler);
        } else {
            obj['on' + EventType] = Handler;
        }
    }
    if (document.getElementById("text")) {
        EventUtil.addEventHandler(document.getElementById('text'), 'propertychange', CountChineseCharacters);
        EventUtil.addEventHandler(document.getElementById('text'), 'input', CountChineseCharacters);
    }
    function showit(Word) {
        alert(Word);
    }
    function CountChineseCharacters() {
        Words = document.getElementById('text').value;
        var W = new Object();
        var Result = new Array();
        var iNumwords = 0;
        var sNumwords = 0;
        var sTotal = 0;
        var iTotal = 0;
        var eTotal = 0;
        var otherTotal = 0;
        var bTotal = 0;
        var inum = 0;
      var znum = 0;
      var gl = 0;
      var paichu = 0;
        for (i = 0; i < Words.length; i++) {
            var c = Words.charAt(i);
            if (c.match(/[\u4e00-\u9fa5]/) || c.match(/[\u0800-\u4e00]/) || c.match(/[\uac00-\ud7ff]/)) {
                if (isNaN(W[c])) {
                    iNumwords++;
                    W[c] = 1;
                }
                iTotal++;
            }
        }
        for (i = 0; i < Words.length; i++) {
            var c = Words.charAt(i);
            if (c.match(/[^\x00-\xff]/)) {
                if (isNaN(W[c])) {
                    sNumwords++;
                }
                sTotal++;
            } else {
                eTotal++;
            }
            if (c.match(/[0-9]/)) {
                inum++;
            }
           if (c.match(/[a-zA-Z]/)) {
                znum++;
            }
          if (c.match(/[\s]/)) {
               gl++;
            }
           if (c.match(/[　◕‿↑↓←→↖↗↘↙↔↕。《》、【】“”•‘’❝❞′……—―‐〈〉„╗╚┐└‖〃「」‹›『』〖〗〔〕∶〝〞″≌∽≦≧≒≠≤≥㏒≡≈✓✔◐◑◐◑✕✖★☆₸₹€₴₰₤₳र₨₲₪₵₣₱฿₡₮₭₩₢₧₥₫₦₠₯○㏄㎏㎎㏎㎞㎜㎝㏕㎡‰〒々℃℉ㄅㄆㄇㄈㄉㄊㄋㄌㄍㄎㄏㄐㄑㄒㄓㄔㄕㄖㄗㄘㄙㄚㄛㄜㄝㄞㄟㄠㄡㄢㄣㄤㄥㄦㄧㄨㄩ]/)) {
               paichu++;
            }
        }
        document.getElementById('hanzi').innerText = iTotal - paichu;
        document.getElementById('zishu').innerText = inum + iTotal - paichu;
        document.getElementById('biaodian').innerText = sTotal - iTotal + eTotal - inum - znum - gl + paichu;
        document.getElementById('zimu').innerText = znum;
        document.getElementById('shuzi').innerText = inum;
        document.getElementById("zifu").innerHTML = iTotal * 2 + (sTotal - iTotal) * 2 + eTotal;
    }
</script>
<script>
$(document).ready(function(){
$("#wmd-editarea").append('<div class="field is-grouped"><span class="tag">共计：</span><div class="control"><div class="tags has-addons"><span class="tag is-dark" id="zishu">0</span> <span class="tag is-primary">个字数</span></div></div><div class="control"><div class="tags has-addons"><span class="tag is-dark" id="zifu">0</span> <span class="tag is-primary">个字符</span></div></div><span class="tag">包含：</span><div class="control"><div class="tags has-addons"><span class="tag is-light" id="hanzi">0</span> <span class="tag is-danger">个文字</span></div></div><div class="control"><div class="tags has-addons"><span class="tag is-light" id="biaodian">0</span> <span class="tag is-info">个符号</span></div></div><div class="control"><div class="tags has-addons"><span class="tag is-light" id="zimu">0</span> <span class="tag is-success">个字母</span></div></div><div class="control"><div class="tags has-addons"><span class="tag is-light" id="shuzi">0</span> <span class="tag is-warning">个数字</span></div></div></div>');
//$("#wmd-button-row").append('<img src="https://i.loli.net/2020/03/04/JFTcewagjrt5xBO.png" id="panel-toggle"></img>');
CountChineseCharacters();
});
</script>
<?php
    }
}


/**
* 免插件实现友情链接功能
* @author OFFODD<https://www.offodd.com/59.html>
*/
function Links($sorts = NULL) {
    $options = Typecho_Widget::widget('Widget_Options');
    $link = NULL;
    if ($options->Links) {
        $list = explode("\r\n", $options->Links);
        foreach ($list as $val) {
            list($name, $url, $description, $sort,$img) = explode(",", $val);
            if ($sorts) {
                $arr = explode(",", $sorts);
                if ($sort && in_array($sort, $arr)) {
                    $link .= $url ? '<li class="clear"><a href="'.$url.'" target="_blank"></a><img src="'.$img.'" alt="'.$name.'"/><div class="link-item-content"><h3>'.$name.'</h3><span>'.$sort.'</span><p>'.$description.'</p></div></li>' : '<li class="clear"><a href="'.$url.'" target="_blank"></a><img src="'.$img.'" alt="'.$name.'"/><div class="link-item-content"><h3>'.$name.'</h3><span>'.$sort.'</span><p>'.$description.'</p></div></li>';
                }
            } else {
                $link .= $url ? '<li class="clear"><a href="'.$url.'" target="_blank"></a><img src="'.$img.'" alt="'.$name.'"/><div class="link-item-content"><h3>'.$name.'</h3><span>'.$sort.'</span><p>'.$description.'</p></div></li>' : '<li class="clear"><a href="'.$url.'" target="_blank"></a><img src="'.$img.'" alt="'.$name.'"/><div class="link-item-content"><h3>'.$name.'</h3><span>'.$sort.'</span><p>'.$description.'</p></div></li>';
            }
        }
    }
    echo $link ? $link : '<li>暂无链接</li>';
}
