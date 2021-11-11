<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
require_once("shortcode.php");

class G {

    /**
     * 主题版本号
     *
     * @var string
     */
    public static $version = "3.0";

    /**
     * 主题配置
     *
     * @var array
     */
    public static $config = [
        'favicon'=>'',
        'cdn'=>'',
        'background'=>'',
        'themeColor'=>'',
        'headerColor'=>'',
        'themeRadius'=>'',
        'themeShadow'=>'',
        'autoBanner'=>'',
        'defaultBanner'=>'',
        'buildYear'=>'',
        'icp'=>'',
        'defaultArticlePath'=>'',
        'enableIndexPage'=>'',
        'advanceSetting'=>'',
        'footerLOGO'=>'',
        'enableUPYUNLOGO'=>''
    ];

    public static $advanceConfig = [];

    public static $themeUrl = '';

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
            if(!empty($options->{$key}))
                self::$config[$key] = $options->{$key};
        if(self::$config['advanceSetting']!='')
        {
            $advanceConfig = explode("\n",self::$config['advanceSetting']);
            foreach($advanceConfig as $item)
                self::$advanceConfig[explode("=",$item)[0]] = explode("=",$item)[1];
        }
        self::$themeUrl = Helper::options()->themeUrl.'/';
    }

    /**
     * 获取静态资源路径
     *
     * @param String $path
     * @return void
     */
    public static function staticUrl($path)
    {
        if(self::$config['cdn'] == 'local' || self::$config['cdn'] == '' || self::$config['cdn'] == 'jsdelivr')
            return self::$themeUrl.$path;
        else
            return self::$config['cdn'].$path;
    }

    /**
     * 获取背景信息
     * regex source: https://daringfireball.net/2010/07/improved_regex_for_matching_urls
     *
     * @return void
     */
    public static function getBackground()
    {
        $background = "background";
        if(self::$config['background'] == '')
            return $background.": #fff;";
        
        $regex = '@(?i)\b((?:[a-z][\w-]+:(?:/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))@';
        if(preg_match($regex, self::$config['background']) == 0)
            return ($background.": ".self::$config['background'].";");
        return $background."-image: url(".self::$config['background'].");";
    }

    /**
     * 配置主题CSS变量
     *
     * @return string
     */
    public static function setColors()
    {
        $result = "html {
            --theme-color: ".self::$config["themeColor"].";
            --header-color: ".self::$config["headerColor"].";
            --theme-radius: ".self::$config["themeRadius"].";
            --theme-shadow: ".self::getBoxShadow(self::$config["themeShadow"]).";
        ";
        if(isset(self::$advanceConfig['customAnimationInDuration']))
            $result .= "    --theme-animation-in-duration: ".self::$advanceConfig['customAnimationInDuration'].";\n        ";
        if(isset(self::$advanceConfig['customAnimationOutDuration']))
            $result .= "    --theme-animation-out-duration: ".self::$advanceConfig['customAnimationOutDuration'].";\n    ";
        $result .= "    }\n";
        return $result;
    }
    
    /**
     * 根据配置返回阴影值
     *
     * @param int $config
     * @return void
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
        
        if(isset($banner) && $banner != '')
            return $post->fields->imgurl;
        if(isset($mirageBanner) && $mirageBanner != '')
            return $mirageBanner;
        if(self::$config['defaultBanner'] != '')
            return self::$config['defaultBanner'];
        if(self::$config['autoBanner'] == 0)
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
        
        if(isset($banner) && $banner != '')
            return $post->fields->imgurl;
        else if(isset($mirageBanner) && $mirageBanner != '')
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
        if(Helper::options()->icp != '')
            return Helper::options()->icp;
        if(isset(self::$advanceConfig["customICP"]))
            return self::$advanceConfig["customICP"];
        return '还没有备案噢';
    }

    /**
     * 获取头部文章路径
     *
     * @return String
     */
    public static function getArticlePath()
    {
        $path = Helper::options()->siteUrl;
        if(substr($path, -1) == '/')
            $path = $path.self::$config["defaultArticlePath"];
        else
            $path = $path.'/'.self::$config["defaultArticlePath"];
        return $path;
    }

    /**
     * 以HTML格式返回底部LOGO
     *
     * @return String
     */
    public static function getFooterLogos()
    {
        if(self::$config['enableUPYUNLOGO'] == 1)
            $logos = '<a href="https://www.upyun.com/?utm_source=lianmeng&utm_medium=referral"><img src="'.self::staticUrl('static/img/upyun.png').'"/></a>';
        else
            $logos = '';
        $imgs = explode(',', self::$config["footerLOGO"]);
        foreach($imgs as $img)
            if($img != '')
                $logos = $logos.'<img src="'.$img.'" />';
        return $logos;
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

        if($sub < 60)
            return $sub."秒前";
        else if($sub < 3600)
            return (int)($sub/60)."分钟前";
        else if($sub < 86400)
            return (int)($sub/3600)."小时前";
        else
            return (int)($sub/86400)."天前";
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
        return $modified == $created ? "还没有修改过" : "最后修改于".self::getSemanticDate($modified);
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
        $result = preg_replace('#\@\((.*?)\)#','<img src="https://cdn.jsdelivr.net/gh/youranreus/R@v1.1.8/G/IMG/bq/$1.png" class="bq">',$content);
        //mirage格式表情 （原神，小黄脸）
        $result = preg_replace('/\:\:(.*?)\:(.*?)\:\:/','<img src="https://cdn.jsdelivr.net/gh/youranreus/R@v1.1.8/W/bq/$1/$2.png" class="bq">',$result);
        return $result;
    }

    /**
     * 修复评论锚点
     *
     * @param object $archive
     * @return string
     */
    public static function Comment_hash_fix($archive){
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

        if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents'))))
        {
            $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
            return 0;
        }

        $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));

        if ($archive->is('single'))
        {
            $views = Typecho_Cookie::get('extend_contents_views');

            if(empty($views))
                $views = array();
            else
                $views = explode(',', $views);

            if(!in_array($cid,$views))
            {
                $db->query($db->update('table.contents')->rows(array('views' => (int) $row['views'] + 1))->where('cid = ?', $cid));
                array_push($views, $cid);
                $views = implode(',', $views);
                Typecho_Cookie::set('extend_contents_views', $views); //记录查看cookie
            }
        }
        return $row['views'];
    }

    public static function test()
    {
        var_dump(self::$themeUrl);
    }
}
