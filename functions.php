<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

require_once("lib/G.class.php");

function themeConfig($form) {
    $favicon = new Typecho_Widget_Helper_Form_Element_Text('favicon', NULL, NULL, _t('站点 LOGO 地址'), _t('在这里填入一个图片 URL 地址, 以在网站标题前加上一个 LOGO'));
    $form->addInput($favicon);

    $cdn = new Typecho_Widget_Helper_Form_Element_Text('cdn', NULL, NULL, _t('是否开启静态资源cdn加速'), _t('填写加速域名或者jsdelivr，留空则使用本地文件'));
    $form->addInput($cdn);
}

/*
function themeFields($layout) {
    $logoUrl = new Typecho_Widget_Helper_Form_Element_Text('logoUrl', NULL, NULL, _t('站点LOGO地址'), _t('在这里填入一个图片URL地址, 以在网站标题前加上一个LOGO'));
    $layout->addItem($logoUrl);
}
*/

G::init();
