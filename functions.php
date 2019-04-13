<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
function themeConfig($form) {
    echo "<h2 style='color:RGB(182,177,150)'>主题G配置面板：</h2>";
    $favicon = new Typecho_Widget_Helper_Form_Element_Text('favicon', NULL, NULL, _t('图标') , _t(''));
    $form->addInput($favicon);
    $bkimg = new Typecho_Widget_Helper_Form_Element_Text('bkimg', NULL, NULL, _t('背景图片') , _t('想要啥背景？'));
    $form->addInput($bkimg);
    $bkcolor = new Typecho_Widget_Helper_Form_Element_Text('bkcolor', NULL, NULL, _t('背景颜色') , _t('如果没有想要的背景就换成纯色吧'));
    $form->addInput($bkcolor);
    $beian = new Typecho_Widget_Helper_Form_Element_Text('beian', NULL, NULL, _t('备案号') , _t('没备案当我没说'));
    $form->addInput($beian);
    $builtTime = new Typecho_Widget_Helper_Form_Element_Text('builtTime', NULL, NULL, _t('运行时间') , _t('格式YYYY-MM-DD'));
    $form->addInput($builtTime);
    $animateTime = new Typecho_Widget_Helper_Form_Element_Text('animateTime', NULL, NULL, _t('动画过渡时间') , _t('格式 1s'));
    $form->addInput($animateTime);

    $enableIndexPage = new Typecho_Widget_Helper_Form_Element_Radio('enableIndexPage', array(
        '1' => _t('cool') ,
        '0' => _t('nope')
    ) , '0', _t('是否使用独立页面做首页') , _t('默认为关闭'));
    $form->addInput($enableIndexPage);
    $enableUpyun = new Typecho_Widget_Helper_Form_Element_Radio('enableUpyun', array(
        '1' => _t('我是盟友') ,
        '0' => _t('啥东西，不要')
    ) , '0', _t('又拍云联盟开关') , _t('默认为关闭'));
    $form->addInput($enableUpyun);
    $enableOpac = new Typecho_Widget_Helper_Form_Element_Radio('enableOpac', array(
        '1' => _t('喜欢') ,
        '0' => _t('不要，快瞎了')
    ) , '0', _t('半透明开关') , _t('默认为打开'));
    $form->addInput($enableOpac);

    $enableOneRow = new Typecho_Widget_Helper_Form_Element_Radio('enableOneRow', array(
        '1' => _t('开启') ,
        '0' => _t('关闭')
    ) , '0', _t('开启文章页双排显示') , _t('默认为打开'));
    $form->addInput($enableOneRow);
}

require_once __DIR__ . '/lib/Parsedown.php';
require_once __DIR__ . '/lib/shortcode.php';

// 主题初始化
function themeInit($archive){
    // 判断是否是添加评论的操作
    // 为文章或页面、post操作，且包含参数`themeAction=comment`(自定义)
    if($archive->is('single') && $archive->request->isPost() && $archive->request->is('themeAction=comment')){
        // 为添加评论的操作时
        ajaxComment($archive);
    }
}

/**
 * ajaxComment
 * 实现Ajax评论的方法(实现feedback中的comment功能)
 * @param Widget_Archive $archive
 * @return void
 */
function ajaxComment($archive){
    $options = Helper::options();
    $user = Typecho_Widget::widget('Widget_User');
    $db = Typecho_Db::get();
    // Security 验证不通过时会直接跳转，所以需要自己进行判断
    // 需要开启反垃圾保护，此时将不验证来源
    if($archive->request->get('_') != Helper::security()->getToken($archive->request->getReferer())){
        $archive->response->throwJson(array('status'=>0,'msg'=>_t('非法请求')));
    }
    /** 评论关闭 */
    if(!$archive->allow('comment')){
        $archive->response->throwJson(array('status'=>0,'msg'=>_t('评论已关闭')));
    }
    /** 检查ip评论间隔 */
    if (!$user->pass('editor', true) && $archive->authorId != $user->uid &&
    $options->commentsPostIntervalEnable){
        $latestComment = $db->fetchRow($db->select('created')->from('table.comments')
                    ->where('cid = ?', $archive->cid)
                    ->where('ip = ?', $archive->request->getIp())
                    ->order('created', Typecho_Db::SORT_DESC)
                    ->limit(1));

        if ($latestComment && ($options->gmtTime - $latestComment['created'] > 0 &&
        $options->gmtTime - $latestComment['created'] < $options->commentsPostInterval)) {
            $archive->response->throwJson(array('status'=>0,'msg'=>_t('对不起, 您的发言过于频繁, 请稍侯再次发布')));
        }
    }

    $comment = array(
        'cid'       =>  $archive->cid,
        'created'   =>  $options->gmtTime,
        'agent'     =>  $archive->request->getAgent(),
        'ip'        =>  $archive->request->getIp(),
        'ownerId'   =>  $archive->author->uid,
        'type'      =>  'comment',
        'status'    =>  !$archive->allow('edit') && $options->commentsRequireModeration ? 'waiting' : 'approved'
    );

    /** 判断父节点 */
    if ($parentId = $archive->request->filter('int')->get('parent')) {
        if ($options->commentsThreaded && ($parent = $db->fetchRow($db->select('coid', 'cid')->from('table.comments')
        ->where('coid = ?', $parentId))) && $archive->cid == $parent['cid']) {
            $comment['parent'] = $parentId;
        } else {
            $archive->response->throwJson(array('status'=>0,'msg'=>_t('父级评论不存在')));
        }
    }
    $feedback = Typecho_Widget::widget('Widget_Feedback');
    //检验格式
    $validator = new Typecho_Validate();
    $validator->addRule('author', 'required', _t('必须填写用户名'));
    $validator->addRule('author', 'xssCheck', _t('请不要在用户名中使用特殊字符'));
    $validator->addRule('author', array($feedback, 'requireUserLogin'), _t('您所使用的用户名已经被注册,请登录后再次提交'));
    $validator->addRule('author', 'maxLength', _t('用户名最多包含200个字符'), 200);

    if ($options->commentsRequireMail && !$user->hasLogin()) {
        $validator->addRule('mail', 'required', _t('必须填写电子邮箱地址'));
    }

    $validator->addRule('mail', 'email', _t('邮箱地址不合法'));
    $validator->addRule('mail', 'maxLength', _t('电子邮箱最多包含200个字符'), 200);

    if ($options->commentsRequireUrl && !$user->hasLogin()) {
        $validator->addRule('url', 'required', _t('必须填写个人主页'));
    }
    $validator->addRule('url', 'url', _t('个人主页地址格式错误'));
    $validator->addRule('url', 'maxLength', _t('个人主页地址最多包含200个字符'), 200);

    $validator->addRule('text', 'required', _t('必须填写评论内容'));

    $comment['text'] = $archive->request->text;

    /** 对一般匿名访问者,将用户数据保存一个月 */
    if (!$user->hasLogin()) {
        /** Anti-XSS */
        $comment['author'] = $archive->request->filter('trim')->author;
        $comment['mail'] = $archive->request->filter('trim')->mail;
        $comment['url'] = $archive->request->filter('trim')->url;

        /** 修正用户提交的url */
        if (!empty($comment['url'])) {
            $urlParams = parse_url($comment['url']);
            if (!isset($urlParams['scheme'])) {
                $comment['url'] = 'http://' . $comment['url'];
            }
        }

        $expire = $options->gmtTime + $options->timezone + 30*24*3600;
        Typecho_Cookie::set('__typecho_remember_author', $comment['author'], $expire);
        Typecho_Cookie::set('__typecho_remember_mail', $comment['mail'], $expire);
        Typecho_Cookie::set('__typecho_remember_url', $comment['url'], $expire);
    } else {
        $comment['author'] = $user->screenName;
        $comment['mail'] = $user->mail;
        $comment['url'] = $user->url;

        /** 记录登录用户的id */
        $comment['authorId'] = $user->uid;
    }

    /** 评论者之前须有评论通过了审核 */
    if (!$options->commentsRequireModeration && $options->commentsWhitelist) {
        if ($feedback->size($feedback->select()->where('author = ? AND mail = ? AND status = ?', $comment['author'], $comment['mail'], 'approved'))) {
            $comment['status'] = 'approved';
        } else {
            $comment['status'] = 'waiting';
        }
    }

    if ($error = $validator->run($comment)) {
        $archive->response->throwJson(array('status'=>0,'msg'=> implode(';',$error)));
    }

    /** 添加评论 */
    $commentId = $feedback->insert($comment);
    if(!$commentId){
        $archive->response->throwJson(array('status'=>0,'msg'=>_t('评论失败')));
    }
    Typecho_Cookie::delete('__typecho_remember_text');
    $db->fetchRow($feedback->select()->where('coid = ?', $commentId)
    ->limit(1), array($feedback, 'push'));
    // 返回评论数据
    $data = array(
        'cid' => $feedback->cid,
        'coid' => $feedback->coid,
        'parent' => $feedback->parent,
        'mail' => $feedback->mail,
        'url' => $feedback->url,
        'ip' => $feedback->ip,
        'agent' => $feedback->agent,
        'author' => $feedback->author,
        'authorId' => $feedback->authorId,
        'permalink' => $feedback->permalink,
        'created' => $feedback->created,
        'datetime' => $feedback->date->format('Y-m-d H:i:s'),
        'status' => $feedback->status,
    );
    // 评论内容
    ob_start();
    $feedback->content();
    $data['content'] = ob_get_clean();

    $data['avatar'] = Typecho_Common::gravatarUrl($data['mail'], 48, Helper::options()->commentsAvatarRating, NULL, $archive->request->isSecure());
    $archive->response->throwJson(array('status'=>1,'comment'=>$data));
}

/**
* 网站运行时间
*
* @access public
* @param mixed $arg1
* @return array 返回类型
*/
function getBuildTime($builtTime) {
    $site_create_time = strtotime($builtTime . ' 00:00:00');
    $time = time() - $site_create_time;
    if (is_numeric($time)) {
        $value = array(
            "years" => 0,
            "days" => 0,
            "hours" => 0,
            "minutes" => 0,
            "seconds" => 0,
        );
        if ($time >= 31556926) {
            $value["years"] = floor($time / 31556926);
            $time = ($time % 31556926);
        }
        if ($time >= 86400) {
            $value["days"] = floor($time / 86400);
            $time = ($time % 86400);
        }
        if ($time >= 3600) {
            $value["hours"] = floor($time / 3600);
            $time = ($time % 3600);
        }
        if ($time >= 60) {
            $value["minutes"] = floor($time / 60);
            $time = ($time % 60);
        }
        $value["seconds"] = floor($time);
        echo '<span class="btime">' . $value['years'] . '年' . $value['days'] . '天</span>';
    } else {
        echo '';
    }
}


/**
* 文章阅读次数
*
* @access public
* @param mixed
* @return
*/
function get_post_view($archive)
{
    $cid    = $archive->cid;
    $db     = Typecho_Db::get();
    $prefix = $db->getPrefix();
    if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
        $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
        echo 0;
        return;
    }
    $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
    if ($archive->is('single')) {
 $views = Typecho_Cookie::get('extend_contents_views');
        if(empty($views)){
            $views = array();
        }else{
            $views = explode(',', $views);
        }
if(!in_array($cid,$views)){
       $db->query($db->update('table.contents')->rows(array('views' => (int) $row['views'] + 1))->where('cid = ?', $cid));
            array_push($views, $cid);
            $views = implode(',', $views);
            Typecho_Cookie::set('extend_contents_views', $views); //记录查看cookie
        }
    }
    echo $row['views'];
}

/**
* 通过id获取原始文章内容
*
* @access public
* @param mixed
* @return
*/

function GetOriginalContent($id){
  $db = Typecho_Db::get();
  $result = $db->fetchAll($db->select()->from('table.contents')
    ->where('status = ?','publish')
    ->where('type = ?', 'post')
    ->where('cid = ?',$id)
  );
  foreach($result as $val){
    $val = Typecho_Widget::widget('Widget_Abstract_Contents')->push($val);
    $content = $val['text'];
    return $content;
  }
}


/**
* 通过id获取文章信息
*
* @access public
* @param mixed
* @return
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
				return '<div class="ArtinArt">
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
* 文章内容解析（短代码，表情）
*
* @access public
* @param mixed
* @return
*/
function emotionContent($content,$url)
{
    //HyperDown解析
    $Parsedown = new Parsedown();
    $content =  $Parsedown->text($content);
    //表情解析
    $fcontent = preg_replace('#\@\((.*?)\)#','<img src="'. $url .'/IMG/bq/$1.png" class="bq">',$content);

    //同博客内文章传送解析
    $arts=[];
    preg_match_all("/\[art\](.*?)\[\/art\]/sm",$fcontent, $arts);
    $art_num = count($arts[0]) - 1;
    for($art_count = 0;$art_num>=$art_count;$art_count++)
    {
      $postid = ltrim($arts[0][$art_count],"[art]");
      $postid = rtrim($postid,"[/art]");
      $art_info = GetPostById($postid);

      $fcontent = preg_replace('/(\\[art\\])('.$postid.')(\\[\\/art\\])/is',$art_info,$fcontent);
    }

    //感谢Maicong大佬的短代码解析QwQ
    $fcontent = do_shortcode($fcontent);


    //输出最终结果
    echo $fcontent;
}
