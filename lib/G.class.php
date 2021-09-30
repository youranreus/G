<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;


class G {
    public static $version = "3.0";
    public static $config = [
        'favicon'=>'',
        'cdn'=>'',
        'background'=>'',
        'themeColor'=>'',
        'headerColor'=>'',
        'themeRadius'=>''
    ];

    /**
     * 初始化
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

    public static function setColors()
    {
        return "
        :root {
            --theme-color: ".self::$config["themeColor"].";
            --header-color: ".self::$config["headerColor"].";
            --theme-radius: ".self::$config["themeRadius"].";
        }
        ";
    }

    public static function test()
    {
        var_dump(self::$config);
    }
}
