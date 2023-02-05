<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
require_once("shortcode.php");

class G
{

    /**
     * 主题版本号
     *
     * @var string
     */
    public static $version = "3.3.9";

    /**
     * 主题配置
     *
     * @var array
     */
    public static $config = [
        'favicon' => '',
        'cdn' => '',
        'background' => '',
        'themeColor' => '',
        'headerColor' => '',
        'themeRadius' => '',
        'themeShadow' => '',
        'autoBanner' => '',
        'defaultBanner' => '',
        'buildYear' => '',
        'icp' => '',
        'defaultArticlePath' => '',
        'enableIndexPage' => '',
        'advanceSetting' => '',
        'footerLOGO' => '',
        'enableUPYUNLOGO' => '',
        'enableDefaultTOC' => '',
        'autoNightSpan' => '',
        'autoNightMode' => '',
    ];

    public static $advanceConfig = [];

    public static $themeUrl = '';

    public static $themeBackup = 'Gbf';

    /**
     * 初始化
     *
     * @return void
     */
    public static function init()
    {
        //读取配置内容
        $options = Helper::options();
        $keys = array_keys(self::$config);
        foreach ($keys as $key)
            if (!empty($options->{$key}))
                self::$config[$key] = $options->{$key};
        if (self::$config['advanceSetting'] != '') {
            $advanceConfig = explode("\n", self::$config['advanceSetting']);
            foreach ($advanceConfig as $item)
                if ($item != '')
                    self::$advanceConfig[explode("=", $item)[0]] = explode("=", $item)[1];
        }
        self::$themeUrl = Helper::options()->themeUrl . '/';
    }

    /**
     * 获取背景信息
     * regex source: https://daringfireball.net/2010/07/improved_regex_for_matching_urls
     *
     * @return string
     */
    public static function getBackground()
    {
        $background = "background";
        $regex = '@(?i)\b((?:[a-z][\w-]+:(?:/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))@';
        if (self::$config['background'] == '')
            return $background . ": #fff;";
        else if (self::$config['background'] == 'bing')
        {
            $bingP = json_decode(file_get_contents('https://cn.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1'));
            return $background . "-image: url(https://cn.bing.com" . $bingP->{'images'}[0]->{'url'} . ");";
        }
        else if (preg_match($regex, self::$config['background']) == 0)
            return ($background . ": " . self::$config['background'] . ";");
        return $background . "-image: url(" . self::$config['background'] . ");";
    }

    /**
     * 配置主题CSS变量
     *
     * @return string
     */
    public static function setCSSValues()
    {
        $result = "html {
            --theme-color: " . self::$config["themeColor"] . ";
            --header-color: " . self::$config["headerColor"] . ";
            --theme-radius: " . self::$config["themeRadius"] . ";
            --theme-shadow: " . self::getBoxShadow(self::$config["themeShadow"]) . ";
        ";
        if (isset(self::$advanceConfig['customAnimationInDuration']))
            $result .= "    --theme-animation-in-duration: " . self::$advanceConfig['customAnimationInDuration'] . ";\n        ";
        if (isset(self::$advanceConfig['customAnimationOutDuration']))
            $result .= "    --theme-animation-out-duration: " . self::$advanceConfig['customAnimationOutDuration'] . ";\n    ";
        if (isset(self::$advanceConfig['customHeaderOffsetX']))
            $result .= "    --theme-header-offset-x: " . self::$advanceConfig['customHeaderOffsetX'] . ";\n    ";
        if (isset(self::$advanceConfig['customHeaderOffsetY']))
            $result .= "    --theme-header-offset-y: " . self::$advanceConfig['customHeaderOffsetY'] . ";\n    ";
        $result .= "    }\n";
        return $result;
    }

    /**
     * 根据配置返回阴影值
     *
     * @param int $config
     * @return string
     */
    public static function getBoxShadow($config)
    {
        return ($config == 1) ? "0 6px 12px 0 rgb(31 35 41 / 8%)" : "none";
    }

    /**
     * 获取文章头图
     *
     * @param Object $post
     * @return String
     */
    public static function getArticleBanner($post)
    {
        $img = array();
        $banner = $post->fields->imgurl;
        $mirageBanner = $post->fields->thumb;

        if (isset($banner) && $banner != '')
            return str_replace("{random}", (string)rand(1000, 9999), $post->fields->imgurl);
        if (isset($mirageBanner) && $mirageBanner != '')
            return str_replace("{random}", (string)rand(1000, 9999), $mirageBanner);
        if (self::$config['defaultBanner'] != '')
            return str_replace("{random}", (string)rand(1000, 9999), self::$config['defaultBanner']);
        if (self::$config['autoBanner'] == 0)
            return 'none';

        preg_match_all("/<img.*?src=\"(.*?)\".*?\/?>/i", $post->content, $img);
        if (count($img) > 0 && count($img[0]) > 0)
            return $img[1][0];
        else
            return 'none';
    }

    /**
     * 获取文章字段头图
     *
     * @param Object $post
     * @return String
     */
    public static function getArticleFieldsBanner($post)
    {
        $img = array();
        $banner = $post->fields->imgurl;
        $mirageBanner = $post->fields->banner;

        if (isset($banner) && $banner != '')
            return $post->fields->imgurl;
        else if (isset($mirageBanner) && $mirageBanner != '')
            return $mirageBanner;
        return 'none';
    }

    /**
     * 获取ICP备案号
     *
     * @return String
     */
    public static function getICP()
    {
        if (Helper::options()->icp != '')
            return Helper::options()->icp;
        if (isset(self::$advanceConfig["customICP"]))
            return self::$advanceConfig["customICP"];
        return '还没有备案噢';
    }

    /**
     * 获取赞助按钮文字
     *
     * @return string
     */
    public static function getSponsorText()
    {
        if (isset(self::$advanceConfig["customSponsorText"]))
            return self::$advanceConfig["customSponsorText"];
        return "支持 ☕";
    }

    /**
     * 获取头部文章路径
     *
     * @return String
     */
    public static function getArticlePath()
    {
        $path = Helper::options()->siteUrl;
        if (substr($path, -1) == '/')
            $path = $path . self::$config["defaultArticlePath"];
        else
            $path = $path . '/' . self::$config["defaultArticlePath"];
        return $path;
    }

    /**
     * 以HTML格式返回底部LOGO
     *
     * @return String
     */
    public static function getFooterLogos()
    {
        if (self::$config['enableUPYUNLOGO'] == 1)
            $logos = '<a href="https://www.upyun.com/?utm_source=lianmeng&utm_medium=referral"><img alt="upyun" src="' . self::staticUrl('static/img/upyun.png') . '"/></a>';
        else
            $logos = '';
        $imgs = explode(',', self::$config["footerLOGO"]);
        foreach ($imgs as $img)
            if ($img != '')
                $logos = $logos . '<img alt="logo" src="' . $img . '" />';
        return $logos;
    }

    /**
     * 获取静态资源路径
     *
     * @param String $path
     * @return string
     */
    public static function staticUrl($path)
    {
        if (self::$config['cdn'] == 'local' || self::$config['cdn'] == '')
            return self::$themeUrl . $path;
        else if (self::$config['cdn'] == 'jsdelivr')
            return 'https://cdn.jsdelivr.net/gh/youranreus/G@v' . self::$version . '/' . $path;
        else if (self::$config['cdn'] == 'sourcestorage')
            return 'https://source.ahdark.com/typecho/theme/G-theme/' . self::$version . '/' . $path;
        else if (self::$config['cdn'] == 'jsdfastly')
            return 'https://fastly.jsdelivr.net/gh/youranreus/G@v' . self::$version . '/' . $path;
        else if (self::$config['cdn'] == 'jsdgcore')
            return 'https://gcore.jsdelivr.net/gh/youranreus/G@v' . self::$version . '/' . $path;
        else
            return self::$config['cdn'] . $path;
    }

    /**
     * 获取语义化修改时间
     *
     * @param string $modified
     * @param string $created
     * @return string
     */
    public static function getModifiedDate($modified, $created)
    {
        return $modified == $created ? "还没有修改过" : "最后修改于" . self::getSemanticDate($modified);
    }

    /**
     * 获取语义化日期
     *
     * @param string $date
     * @return string
     */
    public static function getSemanticDate($date)
    {
        $now = time();
        $sub = $now - $date;

        if ($sub < 60)
            return $sub . "秒前";
        else if ($sub < 3600)
            return (int)($sub / 60) . "分钟前";
        else if ($sub < 86400)
            return (int)($sub / 3600) . "小时前";
        else
            return (int)($sub / 86400) . "天前";
    }

    /**
     * 解析文章内容
     *
     * @param string $content
     * @return string
     */
    public static function analyzeContent($content)
    {
        $content = self::analyzeMeme($content);
        return do_shortcode($content);
    }

    /**
     * 解析文字中的表情包
     *
     * @param string $content
     * @return string
     */
    public static function analyzeMeme($content)
    {
        //@(xx)格式表情
        $result = preg_replace('#@\((.*?)\)#', '<img alt="$1" src="'.G::staticUrl('static/img/bq/paopao').'/$1.png" class="bq" />', $content);
        //mirage格式表情 （原神，小黄脸）
        $result = preg_replace_callback('/\:\:(.*?)\:(.*?)\:\:/',function($matches){
            $img = preg_replace('/%/', '', urlencode($matches[2]));
            return '<img alt="'.$matches[2].'" src="'.self::staticUrl('static/img/bq/'.$matches[1].'/'.$img).'.png" class="bq" />';
        },$result);
        $result = preg_replace_callback('#\#\((.*?)\)#',function($matches) {
            $emotionText = substr(substr($matches[0], 0, -1), 2);
            $url = "<img class='bq bq-aru' alt='".$emotionText."' src='https://cdn.jsdelivr.net/gh/youranreus/R/W/bq/aru/".urlencode($emotionText).".png'/>";
            $url = preg_replace('/%/', '', $url);
            return $url;
        }, $result);
        return $result;
    }

    /**
     * 输出文章概要
     *
     * @param string $content
     * @param Integer $limit
     * @return string
     */
    public static function excerpt($content, $limit)
    {
        $result = mb_substr($content, 0, $limit);
        $result = self::analyzeMeme($result);
        $result = preg_replace('/\[[^\]]*\]/', '', $result);
        return strip_tags($result);
    }

    /**
     * 获取表情包url
     *
     * @param String $path
     * @param String $name
     * @return String
     */
    public static function MemeUrl($path, $name) 
    {
        return self::staticUrl($path.preg_replace('/%/', '', urlencode($name)));
    }

    /**
     * 修复评论锚点
     *
     * @param object $archive
     * @return string
     */
    public static function Comment_hash_fix($archive)
    {
        return "<script type=\"text/javascript\">
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
                    var response = this.dom('$archive->respondId'),
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
    }

    /**
     * 获取文章阅读数
     *
     * @param object $archive
     * @return int
     */
    public static function getPostView($archive)
    {
        $cid = $archive->cid;
        $db = Typecho_Db::get();
        $prefix = $db->getPrefix();

        if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
            $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
            return 0;
        }

        $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));

        if ($archive->is('single')) {
            $views = Typecho_Cookie::get('extend_contents_views');

            if (empty($views))
                $views = array();
            else
                $views = explode(',', $views);

            if (!in_array($cid, $views)) {
                $db->query($db->update('table.contents')->rows(array('views' => (int)$row['views'] + 1))->where('cid = ?', $cid));
                array_push($views, $cid);
                $views = implode(',', $views);
                Typecho_Cookie::set('extend_contents_views', $views); //记录查看cookie
            }
        }
        return $row['views'];
    }

    /**
     * 获取点赞数
     * by MisterMa
     *
     * @param int $cid
     * @return array
     */
    public static function agreeNum($cid)
    {
        $db = Typecho_Db::get();
        $prefix = $db->getPrefix();

        if (!array_key_exists('agree', $db->fetchRow($db->select()->from('table.contents'))))
            $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `agree` INT(10) NOT NULL DEFAULT 0;');

        $agree = $db->fetchRow($db->select('table.contents.agree')->from('table.contents')->where('cid = ?', $cid));
        $AgreeRecording = Typecho_Cookie::get('typechoAgreeRecording');
        if (empty($AgreeRecording))
            Typecho_Cookie::set('typechoAgreeRecording', json_encode(array(0)));

        return array(
            'agree' => $agree['agree'],
            'recording' => in_array($cid, json_decode(Typecho_Cookie::get('typechoAgreeRecording')))
        );
    }

    /**
     * 点赞
     * by MisterMa
     *
     * @param int $cid
     * @return int
     */
    public static function agree($cid)
    {
        $db = Typecho_Db::get();
        $agree = $db->fetchRow($db->select('table.contents.agree')->from('table.contents')->where('cid = ?', $cid));

        $agreeRecording = Typecho_Cookie::get('typechoAgreeRecording');
        if (empty($agreeRecording))
            Typecho_Cookie::set('typechoAgreeRecording', json_encode(array($cid)));
        else {
            $agreeRecording = json_decode($agreeRecording);
            if (in_array($cid, $agreeRecording))
                return $agree['agree'];
            array_push($agreeRecording, $cid);
            Typecho_Cookie::set('typechoAgreeRecording', json_encode($agreeRecording));
        }

        $db->query($db->update('table.contents')->rows(array('agree' => (int)$agree['agree'] + 1))->where('cid = ?', $cid));
        $agree = $db->fetchRow($db->select('table.contents.agree')->from('table.contents')->where('cid = ?', $cid));
        return $agree['agree'];
    }

    /**
     * 获取文章标题
     *
     * @param int $id
     * @return string
     */
    public static function getTitleByID($id)
    {
        $db = Typecho_Db::get();
        $result = $db->fetchAll($db->select()->from('table.contents')
            ->where('status = ?', 'publish')
            ->where('type = ?', 'post')
            ->where('cid = ?', $id)
        );
        if ($result) {
            $i = 1;
            foreach ($result as $val) {
                $val = Typecho_Widget::widget('Widget_Abstract_Contents')->push($val);
                return htmlspecialchars($val['title']);
            }
        } else {
            $result = $db->fetchAll($db->select()->from('table.contents')
                ->where('status = ?', 'publish')
                ->where('type = ?', 'page')
                ->where('cid = ?', $id)
            );
            if ($result) {
                $i = 1;
                foreach ($result as $val) {
                    $val = Typecho_Widget::widget('Widget_Abstract_Contents')->push($val);
                    return htmlspecialchars($val['title']);
                }
            } else
                return '标题获取失败';
        }
    }

    /**
     * 点赞小组件
     *
     * @param string $action
     * @return string
     */
    public static function DYLM($action)
    {
        $db = Typecho_Db::get();
        $data = $db->fetchRow($db->select()->from('table.options')->where('name = ?', 'G:likes'));

        if($data == NULL) {
            $insert = $db->insert('table.options')->rows(['name'=> 'G:likes', "user"=> '0', "value" => "0"]);
            $db->query($insert);
            $data = $db->fetchRow($db->select()->from('table.options')->where('name = ?', 'G:likes'));
        }

        if($action == 'query')
        {
            return (int)$data['value'];
        }
        else if ($action == 'add')
        {
            $update = $db->update('table.options')->rows(["value"=> ((int)$data['value']) + 1])->where('name = ?', 'G:likes');
            return $db->query($update) == 1 ? 'success' : 'error';
        }

        return 'error param';
    }

    /**
     * 随机文章
     *
     * @param integer $limit
     * @return array
     */
    public static function randomArticle($limit = 5)
    {
        $db = Typecho_Db::get();
        $sql = $db->select()->from('table.contents')
                ->where('status = ?','publish')
                ->where('type = ?', 'post')
                ->where('created <= unix_timestamp(now())', 'post')
                ->limit($limit)
                ->order('RAND()');

        $result = $db->fetchAll($sql);
        for($i = 0; $i < $limit; $i++)
            $result[$i] =  Typecho_Widget::widget('Widget_Abstract_Contents')->filter($result[$i]);

        return $result;
    }
    
    /**
     * 通过cid获取文章信息
     *
     * @param string|integer $cid
     * @return array
     */
    public static function getArticleInfo($cid)
    {
        $db = Typecho_Db::get();
        $select = $db->select()->from('table.contents')
                               ->where('status = ?', 'publish')
                               ->where('type = ?', 'post')
                               ->where('cid = ?', $cid);

        return Typecho_Widget::widget('Widget_Abstract_Contents')->filter($db->fetchRow($select));
    }
}
