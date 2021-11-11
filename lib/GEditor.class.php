<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;


class GEditor
{

    /**
     * 回复可见代码替换
     */
    public static function reply2see($con, $obj, $text)
    {
        $text = empty($text) ? $con : $text;
        if (!$obj->is('single')) {
            $text = preg_replace("/\[hide\](.*?)\[\/hide\]/sm", '', $text);
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
        
        echo '<script src="https://cdn.jsdelivr.net/gh/youranreus/R@v1.2.5/G/JS/editor.js"></script>';
    }

}
