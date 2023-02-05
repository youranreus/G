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

/**
 * 是否存在备份
 */
function hasBackup($db) {
    return $db->fetchRow($db->select()->from('table.options')->where('name = ?', 'theme:'.G::$themeBackup));
}

/**
 * 备份完成提示
 */
function backupNotice($msg, $refresh = true) {
    $content = $msg.''.($refresh ? '，即将自动刷新' : '');
    if ($refresh) {
        $url = Helper::options()->adminUrl.'options-theme.php';
        $content .= '
            <a href="'.$url.'">手动刷新</a>
            <script language="JavaScript">window.setTimeout("location=\''.$url.'\'", 2500);</script>
        ';
    }

    echo '<div class="backup-notice">'.$content.'</div>';
}

/**
 * 备份操作
 */
function makeBackup($db, $hasBackup) {
    $currentConfig = $db->fetchRow($db->select()->from('table.options')->where('name = ?', 'theme:G'))['value'];
    $query = $hasBackup
        ? $db->update('table.options')->rows(array('value' => $currentConfig))->where('name = ?', 'theme:'.G::$themeBackup)
        : $db->insert('table.options')->rows(array('name' => 'theme:'.G::$themeBackup, 'user' => '0', 'value' => $currentConfig));
    
    $rows = $db->query($query);
    
    return ['msg' => $hasBackup ? '备份已经成功更新' : '备份成功', 'refresh' => true];
}

/**
 * 恢复备份
 */
function restoreBackup($db, $hasBackup) {
    if (!$hasBackup) 
        return ['msg' => '没有模板备份数据，恢复不了哦！', 'refresh' => false];
    
    $backupConfig = $db->fetchRow($db->select()->from('table.options')->where('name = ?', 'theme:'.G::$themeBackup))['value'];
    $update = $db->update('table.options')->rows(array('value' => $backupConfig))->where('name = ?', 'theme:G');
    $updateRows = $db->query($update);

    return ['msg' => '恢复成功', 'refresh' => true];
}

/**
 * 删除备份
 */
function deleteBackup($db, $hasBackup) {
    if (!$hasBackup) 
        return ['msg' => '没有模板备份数据哦', 'refresh' => false];

    $delete = $db->delete('table.options')->where('name = ?', 'theme:'.G::$themeBackup);
    $deletedRows = $db->query($delete);
    
    return ['msg' => '删除成功', 'refresh' => true];
}

/**
 * 备份主方法
 */
function backup() {
    $db = Typecho_Db::get();
    $hasBackup = hasBackup($db);
    if (isset($_POST['type'])) {
        $result = [];
        switch($_POST['type']) {
            case '创建备份':
            case '更新备份':
                $result = makeBackup($db, $hasBackup);
                break;
            case '恢复备份':
                $result = restoreBackup($db, $hasBackup);
                break;
            case '删除备份':
                $result = deleteBackup($db, $hasBackup);
                break;
            default:
                $result = ["msg" => "", "refresh" => false];
                break;
        }
        if ($result["msg"])
            backupNotice($result["msg"], $result["refresh"]);
    }
    echo '
        <div id="backup">
            <form class="protected Data-backup" action="?'.G::$themeBackup.'" method="post">
                <h4>数据备份</h4>
                <p style="opacity: 0.5">'.($hasBackup ? '当前已有备份' : '当前暂无备份').'，你可以选择</p>
                <input type="submit" name="type" class="btn btn-s" value="'.($hasBackup ? '更新备份' : '创建备份').'" />&nbsp;&nbsp;
                '.($hasBackup ? '<input type="submit" name="type" class="btn btn-s" value="恢复备份" />&nbsp;&nbsp;' : '').'
                '.($hasBackup ? '<input type="submit" name="type" class="btn btn-s" value="删除备份" />' : '').'
            </form>
        </div>
    ';
}

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

    $icpUrl = new Typecho_Widget_Helper_Form_Element_Text('icpUrl', null, 'https://beian.miit.gov.cn', _t('备案号指向链接'), _t('默认指向工信部'));
    $form->addInput($icpUrl);

    $background = new Typecho_Widget_Helper_Form_Element_Text('background', null, null, _t('背景图片'), _t('可填颜色代码或者图片url'));
    $form->addInput($background);

    $repeatBackground = new Typecho_Widget_Helper_Form_Element_Radio('repeatBackground', array(
        '1' => _t('开启'),
        '0' => _t('关闭')
    ), '0', _t('重复元素背景图片'), _t('默认关闭'));
    $form->addInput($repeatBackground);

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

    $autoNightSpan = new Typecho_Widget_Helper_Form_Element_Text('autoNightSpan', null, '23-6', _t('自动夜间模式时间段'), _t('24小时制，当前晚上x点到第二天早上y点视为夜间，需要自动开启夜间模式，例: 23-6'));
    $form->addInput($autoNightSpan);

    $autoNightMode = new Typecho_Widget_Helper_Form_Element_Radio('autoNightMode', array(
        '3' => _t('跟随系统'),
        '2' => _t('自定义时间段'),
        '1' => _t('同时开启'),
        '0' => _t('关闭')
    ), '3', _t('自动夜间模式控制模式'), _t('默认为跟随系统'));
    $form->addInput($autoNightMode);

    $enableDefaultTOC = new Typecho_Widget_Helper_Form_Element_Radio('enableDefaultTOC', array(
        '1' => _t('开启'),
        '0' => _t('关闭')
    ), '0', _t('文章目录是否默认开启'), _t('默认否'));
    $form->addInput($enableDefaultTOC);

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

    $enableHeaderSearch = new Typecho_Widget_Helper_Form_Element_Radio('enableHeaderSearch', array(
        '1' => _t('开启'),
        '0' => _t('关闭')
    ), '0', _t('是否在头部添加搜索开关'), _t('默认不打开,需要配合exsearch插件使用'));
    $form->addInput($enableHeaderSearch);

    $articleStyle = new Typecho_Widget_Helper_Form_Element_Radio('articleStyle', array(
        '2' => _t('大图'),
        '1' => _t('单列'),
        '0' => _t('双列')
    ), '0', _t('首页样式'), _t('默认为双列'));
    $form->addInput($articleStyle);

    $defaultArticlePath = new Typecho_Widget_Helper_Form_Element_Text('defaultArticlePath', null, 'index.php/blog', _t('默认头部文章路径'), _t('前面不需要加/'));
    $form->addInput($defaultArticlePath);

    $customWidgets = new Typecho_Widget_Helper_Form_Element_Textarea('customWidgets', null, null, _t('侧边栏小组件配置'), _t(''));
    $form->addInput($customWidgets);

    $customCSS = new Typecho_Widget_Helper_Form_Element_Textarea('customCSS', null, null, _t('自定义CSS'), _t(''));
    $form->addInput($customCSS);

    $customHeaderJS = new Typecho_Widget_Helper_Form_Element_Textarea('customHeaderJS', null, null, _t('自定义头部JS'), _t('head标签中'));
    $form->addInput($customHeaderJS);

    $customFooterJS = new Typecho_Widget_Helper_Form_Element_Textarea('customFooterJS', null, null, _t('自定义底部JS'), _t('body结束前'));
    $form->addInput($customFooterJS);

    $customPjaxCallback = new Typecho_Widget_Helper_Form_Element_Textarea('customPjaxCallback', null, null, _t('自定义Pjax回调函数'), _t('如果你不知道这个是啥，留着就好'));
    $form->addInput($customPjaxCallback);

    $advanceSetting = new Typecho_Widget_Helper_Form_Element_Textarea('advanceSetting', null, null, _t('高级设置'), _t('看着就很高级'));
    $form->addInput($advanceSetting);

    backup();
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



