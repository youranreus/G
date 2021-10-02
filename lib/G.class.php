<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;


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
        'buildYear'=>''
    ];

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
        foreach ($keys as $key) {
            if(!empty($options->{$key})){
                self::$config[$key] = $options->{$key};
            }
        }
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
            Helper::options()->themeUrl($path);
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
     * @return void
     */
    public static function setColors()
    {
        return "
        :root {
            --theme-color: ".self::$config["themeColor"].";
            --header-color: ".self::$config["headerColor"].";
            --theme-radius: ".self::$config["themeRadius"].";
            --theme-shadow: ".self::getBoxShadow(self::$config["themeShadow"]).";
        }
        ";
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

        if(isset($banner) && $banner != '')
            return $post->fields->imgurl;
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

    public static function test()
    {
        var_dump(self::$config);
    }
}
