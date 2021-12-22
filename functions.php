<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

require_once("libs/G.class.php");
require_once("libs/GEditor.class.php");
G::init();
Typecho_Plugin::factory('Widget_Abstract_Contents')->excerptEx = array('GEditor', 'reply2see');
Typecho_Plugin::factory('Widget_Abstract_Contents')->contentEx = array('GEditor', 'reply2see');
Typecho_Plugin::factory('admin/write-post.php')->bottom = array('GEditor', 'addButton');
Typecho_Plugin::factory('admin/write-page.php')->bottom = array('GEditor', 'addButton');
Typecho_Plugin::factory('admin/write-post.php')->bottom = array('GEditor', 'wordCounter');
Typecho_Plugin::factory('admin/write-page.php')->bottom = array('GEditor', 'wordCounter');


function themeConfig($form)
{
    echo "<link rel='stylesheet' href='".G::staticUrl('static/css/Admin/S.min.css')."'/>";
    echo "<h2>G主题设置</h2>";

    $favicon = new Typecho_Widget_Helper_Form_Element_Text('favicon', null, null, _t('站点 LOGO 地址'), _t('在这里填入一个图片 URL 地址, 以在网站标题前加上一个 LOGO'));
    $form->addInput($favicon);

    $buildYear = new Typecho_Widget_Helper_Form_Element_Text('buildYear', null, date('Y'), _t('建站年份'), _t('什么时候开始建站的呀'));
    $form->addInput($buildYear);

    $cdn = new Typecho_Widget_Helper_Form_Element_Text('cdn', null, null, _t('是否开启静态资源cdn加速'), _t("填写加速域名或者jsdelivr或者sourcestorage，留空则使用本地文件</br>注意: 新版本刚刚发布时，可能CDN不会及时更新"));
    $form->addInput($cdn);

    $icp = new Typecho_Widget_Helper_Form_Element_Text('icp', null, null, _t('ICP备案号'), _t('没有可以不填哟'));
    $form->addInput($icp);

    $background = new Typecho_Widget_Helper_Form_Element_Text('background', null, null, _t('背景图片'), _t('可填颜色代码或者图片url'));
    $form->addInput($background);

    $themeColor = new Typecho_Widget_Helper_Form_Element_Text('themeColor', null, '#07F', _t('主题色'), _t('一般在链接、按钮的颜色中体现'));
    $form->addInput($themeColor);

    $headerColor = new Typecho_Widget_Helper_Form_Element_Text('headerColor', null, '#6A6A6A', _t('头部色'), _t('想要一朵绿帽子不？'));
    $form->addInput($headerColor);

    $themeRadius = new Typecho_Widget_Helper_Form_Element_Text('themeRadius', null, '30px', _t('主题圆角'), _t('圆还是方，由你来定'));
    $form->addInput($themeRadius);

    $defaultBanner = new Typecho_Widget_Helper_Form_Element_Text('defaultBanner', null, null, _t('默认头图'), _t('填入图片API时，可以使用{random}来替换生成一个随机字符串以达到随机图片得效果'));
    $form->addInput($defaultBanner);

    $profileAvatar = new Typecho_Widget_Helper_Form_Element_Text('profileAvatar', null, null, _t('侧边栏头像'), _t('https://...'));
    $form->addInput($profileAvatar);

    $profileBG = new Typecho_Widget_Helper_Form_Element_Text('profileBG', null, null, _t('侧边栏背景'), _t('https://...'));
    $form->addInput($profileBG);

    $profileDes = new Typecho_Widget_Helper_Form_Element_Text('profileDes', null, null, _t('侧边栏简介'), _t('尽量简洁'));
    $form->addInput($profileDes);

    $profilePhoto = new Typecho_Widget_Helper_Form_Element_Text('profilePhoto', null, null, _t('侧边栏小相片'), _t('https://'));
    $form->addInput($profilePhoto);

    $profileVideo = new Typecho_Widget_Helper_Form_Element_Text('profileVideo', null, null, _t('侧边栏小视频'), _t('https://'));
    $form->addInput($profileVideo);

    $profilePhotoDes = new Typecho_Widget_Helper_Form_Element_Text('profilePhotoDes', null, null, _t('侧边栏图片描述'), _t('关于图片/视频的简短描述'));
    $form->addInput($profilePhotoDes);

    $footerLOGO = new Typecho_Widget_Helper_Form_Element_Text('footerLOGO', null, null, _t('底部左侧logo'), _t('填写logo图片链接，用,分割'));
    $form->addInput($footerLOGO);

    $sponsorIMG = new Typecho_Widget_Helper_Form_Element_Text('sponsorIMG', null, null, _t('赞助二维码图片'), _t('填写后会在文章底部添加一个赞助按钮'));
    $form->addInput($sponsorIMG);

    $headerBackground = new Typecho_Widget_Helper_Form_Element_Text('headerBackground', null, null, _t('头部背景图'), _t('填写后会在站点头部添加一个半透明的背景图'));
    $form->addInput($headerBackground);

    $enableUPYUNLOGO = new Typecho_Widget_Helper_Form_Element_Radio('enableUPYUNLOGO', array(
        '1' => _t('开启'),
        '0' => _t('关闭')
    ), '0', _t('是否开启又拍云联盟图标展示'), _t('默认关闭'));
    $form->addInput($enableUPYUNLOGO);

    $themeShadow = new Typecho_Widget_Helper_Form_Element_Radio('themeShadow', array(
        '1' => _t('开启'),
        '0' => _t('关闭')
    ), '1', _t('是否开启主题阴影'), _t('默认开启'));
    $form->addInput($themeShadow);

    $enableKatex = new Typecho_Widget_Helper_Form_Element_Radio('enableKatex', array(
        '1' => _t('开启'),
        '0' => _t('关闭')
    ), '0', _t('是否开启Katex数学公式解析'), _t('默认关闭'));
    $form->addInput($enableKatex);

    $autoBanner = new Typecho_Widget_Helper_Form_Element_Radio('autoBanner', array(
        '1' => _t('开启'),
        '0' => _t('关闭')
    ), '1', _t('自动获取第一张图片作为头图'), _t('默认开启'));
    $form->addInput($autoBanner);

    $enableIndexPage = new Typecho_Widget_Helper_Form_Element_Radio('enableIndexPage', array(
        '1' => _t('使用'),
        '0' => _t('不使用')
    ), '0', _t('是否使用独立页面作首页'), _t('默认不使用'));
    $form->addInput($enableIndexPage);

    $articleStyle = new Typecho_Widget_Helper_Form_Element_Radio('articleStyle', array(
        '2' => _t('大图'),
        '1' => _t('单列'),
        '0' => _t('双列')
    ), '0', _t('首页样式'), _t('默认为双列'));
    $form->addInput($articleStyle);

    $defaultArticlePath = new Typecho_Widget_Helper_Form_Element_Text('defaultArticlePath', null, 'index.php/blog', _t('默认头部文章路径'), _t('前面不需要加/'));
    $form->addInput($defaultArticlePath);

    $customCSS = new Typecho_Widget_Helper_Form_Element_Textarea('customCSS', null, null, _t('自定义CSS'), _t(''));
    $form->addInput($customCSS);

    $customHeaderJS = new Typecho_Widget_Helper_Form_Element_Textarea('customHeaderJS', null, null, _t('自定义头部JS'), _t('head标签中'));
    $form->addInput($customHeaderJS);

    $customFooterJS = new Typecho_Widget_Helper_Form_Element_Textarea('customFooterJS', null, null, _t('自定义底部JS'), _t('body结束前'));
    $form->addInput($customFooterJS);

    $advanceSetting = new Typecho_Widget_Helper_Form_Element_Textarea('advanceSetting', null, null, _t('高级设置'), _t('看着就很高级'));
    $form->addInput($advanceSetting);

    $db = Typecho_Db::get();
    $sjdq = $db->fetchRow($db->select()->from('table.options')->where('name = ?', 'theme:G'));
    $ysj = $sjdq['value'];
    if (isset($_POST['type'])) {
        if ($_POST["type"] == "备份模板数据") {
            if ($db->fetchRow($db->select()->from('table.options')->where('name = ?', 'theme:Gbf'))) {
                $update = $db->update('table.options')->rows(array('value' => $ysj))->where('name = ?', 'theme:Gbf');
                $updateRows = $db->query($update);
                echo '<div class="tongzhi">备份已更新，请等待自动刷新！如果等不到请点击';
                ?>
                <a href="<?php Helper::options()->adminUrl('options-theme.php'); ?>">这里</a></div>
                <script language="JavaScript">window.setTimeout("location=\'<?php Helper::options()->adminUrl('options-theme.php'); ?>\'", 2500);</script>
                <?php
            } else {
                if ($ysj) {
                    $insert = $db->insert('table.options')->rows(array('name' => 'theme:Gbf', 'user' => '0', 'value' => $ysj));
                    $insertId = $db->query($insert);
                    echo '<div class="tongzhi">备份完成，请等待自动刷新！如果等不到请点击';
                    ?>
                    <a href="<?php Helper::options()->adminUrl('options-theme.php'); ?>">这里</a></div>
                    <script language="JavaScript">window.setTimeout("location=\'<?php Helper::options()->adminUrl('options-theme.php'); ?>\'", 2500);</script>
                    <?php
                }
            }
        }
        if ($_POST["type"] == "还原模板数据") {

            if ($db->fetchRow($db->select()->from('table.options')->where('name = ?', 'theme:Gbf'))) {

                $sjdub = $db->fetchRow($db->select()->from('table.options')->where('name = ?', 'theme:Gbf'));
                $bsj = $sjdub['value'];
                $update = $db->update('table.options')->rows(array('value' => $bsj))->where('name = ?', 'theme:G');
                $updateRows = $db->query($update);
                echo '<div class="tongzhi">检测到模板备份数据，恢复完成，请等待自动刷新！如果等不到请点击';
                ?>
                <a href="<?php Helper::options()->adminUrl('options-theme.php'); ?>">这里</a></div>
                <script language="JavaScript">window.setTimeout("location=\'<?php Helper::options()->adminUrl('options-theme.php'); ?>\'", 2000);</script>
                <?php

            } else {

                echo '<div class="tongzhi">没有模板备份数据，恢复不了哦！</div>';

            }
        }
        if ($_POST["type"] == "删除备份数据") {
            if ($db->fetchRow($db->select()->from('table.options')->where('name = ?', 'theme:Gbf'))) {
                $delete = $db->delete('table.options')->where('name = ?', 'theme:Gbf');
                $deletedRows = $db->query($delete);
                echo '<div class="tongzhi">删除成功，请等待自动刷新，如果等不到请点击';
                ?>
                <a href="<?php Helper::options()->adminUrl('options-theme.php'); ?>">这里</a></div>
                <script language="JavaScript">window.setTimeout("location=\'<?php Helper::options()->adminUrl('options-theme.php'); ?>\'", 2500);</script>
                <?php
            } else {
                echo '<div class="tongzhi">不用删了！备份不存在！！！</div>';
            }
        }
    }
    echo '<div id="backup"><form class="protected Data-backup" action="?Gbf" method="post"><h4>数据备份</h4>
    <input type="submit" name="type" class="btn btn-s" value="备份模板数据" />&nbsp;&nbsp;<input type="submit" name="type" class="btn btn-s" value="还原模板数据" />&nbsp;&nbsp;<input type="submit" name="type" class="btn btn-s" value="删除备份数据" /></form></div>';
}


function themeFields($layout)
{
    $imgurl = new Typecho_Widget_Helper_Form_Element_Text('imgurl', null, null, _t('文章头图地址'), _t('在这里填入一个图片URL地址'));
    $layout->addItem($imgurl);

    $headerDisplay = new Typecho_Widget_Helper_Form_Element_Radio('headerDisplay', array(
        '1' => _t('显示'),
        '0' => _t('不显示')
    ), '0', _t('(独立页面)是否显示在头部导航栏'), _t('默认不显示'));
    $layout->addItem($headerDisplay);

    $enableComment = new Typecho_Widget_Helper_Form_Element_Radio('enableComment', array(
        '1' => _t('显示'),
        '0' => _t('不显示')
    ), '0', _t('(独立页面)是否显示评论框'), _t('默认不显示'));
    $layout->addItem($enableComment);
}



