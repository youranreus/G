<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
function themeConfig($form) {
    echo "<h2 style='color:RGB(182,177,150)'>主题G配置界面：</h2>";
    $bkimg = new Typecho_Widget_Helper_Form_Element_Text('bkimg', NULL, NULL, _t('背景图片') , _t('想要啥背景？'));
    $form->addInput($bkimg);
    $beian = new Typecho_Widget_Helper_Form_Element_Text('beian', NULL, NULL, _t('备案号') , _t('没备案当我没说'));
    $form->addInput($beian);
    $builtTime = new Typecho_Widget_Helper_Form_Element_Text('builtTime', NULL, NULL, _t('运行时间') , _t('格式YYYY-MM-DD'));
    $form->addInput($builtTime);
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
}



date_default_timezone_set('Asia/Shanghai');


/**
* 网站运行时间
*
* @access public
* @param mixed $arg1 用户自定义建站时间
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
