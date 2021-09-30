<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;


class G {
    public static $version = "3.0";
    public static $config = [
        'favicon'=>'',
        'cdn'=>'',
    ];

    public static function init()
    {
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
        {
            return Helper::options()->themeUrl($path);
        }
        
        return self::$config['cdn'].$path;
    }

    
}
