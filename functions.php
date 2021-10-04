<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

require_once("lib/G.class.php");
G::init();


function themeConfig($form) {
    echo "<link rel='stylesheet' href='https://cdn.jsdelivr.net/gh/youranreus/R@v1.1.5/G/CSS/S.css'/>";
    echo "<h2>G主题设置</h2>";

    $favicon = new Typecho_Widget_Helper_Form_Element_Text('favicon', NULL, NULL, _t('站点 LOGO 地址'), _t('在这里填入一个图片 URL 地址, 以在网站标题前加上一个 LOGO'));
    $form->addInput($favicon);

    $buildYear = new Typecho_Widget_Helper_Form_Element_Text('buildYear', NULL, date('Y'), _t('建站年份'), _t('什么时候开始建站的呀'));
    $form->addInput($buildYear);

    $cdn = new Typecho_Widget_Helper_Form_Element_Text('cdn', NULL, NULL, _t('是否开启静态资源cdn加速'), _t('填写加速域名或者jsdelivr，留空则使用本地文件'));
    $form->addInput($cdn);

    $icp = new Typecho_Widget_Helper_Form_Element_Text('icp', NULL, NULL, _t('ICP备案号'), _t('没有可以不填哟'));
    $form->addInput($icp);

    $background = new Typecho_Widget_Helper_Form_Element_Text('background', NULL, NULL, _t('背景图片'), _t('可填颜色代码或者图片url'));
    $form->addInput($background);

    $themeColor = new Typecho_Widget_Helper_Form_Element_Text('themeColor', NULL, '#07F', _t('主题色'), _t('一般在链接、按钮的颜色中体现'));
    $form->addInput($themeColor);

    $headerColor = new Typecho_Widget_Helper_Form_Element_Text('headerColor', NULL, '#6A6A6A', _t('头部色'), _t('想要一朵绿帽子不？'));
    $form->addInput($headerColor);

    $themeRadius = new Typecho_Widget_Helper_Form_Element_Text('themeRadius', NULL, '30px', _t('主题圆角'), _t('圆还是方，由你来定'));
    $form->addInput($themeRadius);

    $defaultBanner = new Typecho_Widget_Helper_Form_Element_Text('defaultBanner', NULL, NULL, _t('默认头图'), _t('填入图片API时，可以使用{random}来替换生成一个随机字符串以达到随机图片得效果'));
    $form->addInput($defaultBanner);

    $footerLOGO = new Typecho_Widget_Helper_Form_Element_Text('footerLOGO', NULL, NULL, _t('底部左侧logo'), _t('填写logo图片链接，用,分割'));
    $form->addInput($footerLOGO);

    $enableUPYUNLOGO = new Typecho_Widget_Helper_Form_Element_Radio('enableUPYUNLOGO', array(
        '1' => _t('开启') ,
        '0' => _t('关闭')
    ) , '0', _t('是否开启又拍云联盟图标展示') , _t('默认关闭'));
    $form->addInput($enableUPYUNLOGO);

    $themeShadow = new Typecho_Widget_Helper_Form_Element_Radio('themeShadow', array(
        '1' => _t('开启') ,
        '0' => _t('关闭')
    ) , '1', _t('是否开启主题阴影') , _t('默认开启'));
    $form->addInput($themeShadow);

    $autoBanner = new Typecho_Widget_Helper_Form_Element_Radio('autoBanner', array(
        '1' => _t('开启') ,
        '0' => _t('关闭')
    ) , '1', _t('自动获取第一张图片作为头图') , _t('默认开启'));
    $form->addInput($autoBanner);

    $enableIndexPage = new Typecho_Widget_Helper_Form_Element_Radio('enableIndexPage', array(
        '1' => _t('使用') ,
        '0' => _t('不使用')
    ) , '0', _t('是否使用独立页面作首页') , _t('默认不使用'));
    $form->addInput($enableIndexPage);

    $defaultArticlePath = new Typecho_Widget_Helper_Form_Element_Text('defaultArticlePath', NULL, 'index.php/blog', _t('默认头部文章路径'), _t('前面不需要加/'));
    $form->addInput($defaultArticlePath);

    $customCSS = new Typecho_Widget_Helper_Form_Element_Textarea('customCSS', NULL, NULL, _t('自定义CSS'), _t(''));
    $form->addInput($customCSS);

    $advanceSetting = new Typecho_Widget_Helper_Form_Element_Textarea('advanceSetting', NULL, NULL, _t('高级设置'), _t('看着就很高级'));
    $form->addInput($advanceSetting);
}


function themeFields($layout) {
    $imgurl = new Typecho_Widget_Helper_Form_Element_Text('imgurl', NULL, NULL, _t('文章头图地址'), _t('在这里填入一个图片URL地址'));
    $layout->addItem($imgurl);
}



