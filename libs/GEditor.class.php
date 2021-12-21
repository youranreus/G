<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
require_once("G.class.php");


class GEditor
{

    /**
     * 回复可见代码替换
     */
    public static function reply2see($con, $obj, $text)
    {
        $text = empty($text) ? $con : $text;
        if (!$obj->is('single')) {
            $text = preg_replace("/\[hide](.*?)\[\/hide]/sm", '', $text);
        }
        return $text;
    }

    /**
     * 文章编辑器插入按钮
     */
    public static function addButton()
    {
        echo '  <link rel="stylesheet" href="'.G::staticUrl('static/css/Admin/OwO.min.css').'" rel="stylesheet" />';

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
        <script>
            window.G_CONFIG = {
                bqb: {
                    ys: "'.G::staticUrl('static/img/bq/ys/').'",
                    xhl: "'.G::staticUrl('static/img/bq/xiaohuanglian/').'",
                    paopao: "'.G::staticUrl('static/img/bq/paopao/').'"
                }
            };
        </script>
        ';

        echo '<script src="'.G::staticUrl('static/js/editor.js').'"></script>';
    }

    public static function wordCounter()
    {
        ?>
        <style>
            .field.is-grouped {
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -webkit-box-pack: start;
                -ms-flex-pack: start;
                justify-content: flex-start;
                -ms-flex-wrap: wrap;
                flex-wrap: wrap;
                margin-top: 10px;
            }

            .field.is-grouped > .control {
                -ms-flex-negative: 0;
                flex-shrink: 0
            }

            .field.is-grouped > .control:not(:last-child) {
                margin-bottom: .5rem;
                margin-right: .75rem
            }

            .field.is-grouped > .control.is-expanded {
                -webkit-box-flex: 1;
                -ms-flex-positive: 1;
                flex-grow: 1;
                -ms-flex-negative: 1;
                flex-shrink: 1
            }

            .field.is-grouped.is-grouped-centered {
                -webkit-box-pack: center;
                -ms-flex-pack: center;
                justify-content: center
            }

            .field.is-grouped.is-grouped-right {
                -webkit-box-pack: end;
                -ms-flex-pack: end;
                justify-content: flex-end
            }

            .field.is-grouped.is-grouped-multiline {
                -ms-flex-wrap: wrap;
                flex-wrap: wrap
            }

            .field.is-grouped.is-grouped-multiline > .control:last-child, .field.is-grouped.is-grouped-multiline > .control:not(:last-child) {
                margin-bottom: .75rem
            }

            .field.is-grouped.is-grouped-multiline:last-child {
                margin-bottom: -.75rem
            }

            .field.is-grouped.is-grouped-multiline:not(:last-child) {
                margin-bottom: 0
            }

            .tags {
                -webkit-box-align: center;
                -ms-flex-align: center;
                align-items: center;
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -ms-flex-wrap: wrap;
                flex-wrap: wrap;
                -webkit-box-pack: start;
                -ms-flex-pack: start;
                justify-content: flex-start
            }

            .tags .tag {
                margin-bottom: .5rem
            }

            .tags .tag:not(:last-child) {
                margin-right: .5rem
            }

            .tags:last-child {
                margin-bottom: -.5rem
            }

            .tags:not(:last-child) {
                margin-bottom: 1rem
            }

            .tags.has-addons .tag {
                margin-right: 0
            }

            .tags.has-addons .tag:not(:first-child) {
                border-bottom-left-radius: 0;
                border-top-left-radius: 0
            }

            .tags.has-addons .tag:not(:last-child) {
                border-bottom-right-radius: 0;
                border-top-right-radius: 0
            }

            .tag {
                -webkit-box-align: center;
                -ms-flex-align: center;
                align-items: center;
                background-color: #f5f5f5;
                border-radius: 3px;
                color: #4a4a4a;
                display: -webkit-inline-box;
                display: -ms-inline-flexbox;
                display: inline-flex;
                font-size: .75rem;
                height: 2em;
                -webkit-box-pack: center;
                -ms-flex-pack: center;
                justify-content: center;
                line-height: 1.5;
                padding-left: .75em;
                padding-right: .75em;
                white-space: nowrap
            }

            .tag .delete {
                margin-left: .25em;
                margin-right: -.375em
            }

            .tag.is-white {
                background-color: #fff;
                color: #0a0a0a
            }

            .tag.is-black {
                background-color: #0a0a0a;
                color: #fff
            }

            .tag.is-light {
                background-color: #fff;
                color: #363636
            }

            .tag.is-dark {
                background-color: #363636;
                color: #f5f5f5
            }

            .tag.is-primary {
                background-color: #00d1b2;
                color: #fff
            }

            .tag.is-info {
                background-color: #3273dc;
                color: #fff
            }

            .tag.is-success {
                background-color: #23d160;
                color: #fff
            }

            .tag.is-warning {
                background-color: #ffdd57;
                color: rgba(0, 0, 0, .7)
            }

            .tag.is-danger {
                background-color: #ff3860;
                color: #fff
            }

            .tag.is-large {
                font-size: 1.25rem
            }

            .tag.is-delete {
                margin-left: 1px;
                padding: 0;
                position: relative;
                width: 2em
            }

            .tag.is-delete:after, .tag.is-delete:before {
                background-color: currentColor;
                content: "";
                display: block;
                left: 50%;
                position: absolute;
                top: 50%;
                -webkit-transform: translateX(-50%) translateY(-50%) rotate(45deg);
                transform: translateX(-50%) translateY(-50%) rotate(45deg);
                -webkit-transform-origin: center center;
                transform-origin: center center
            }

            .tag.is-delete:before {
                height: 1px;
                width: 50%
            }

            .tag.is-delete:after {
                height: 50%;
                width: 1px
            }

            .tag.is-delete:focus, .tag.is-delete:hover {
                background-color: #e8e8e8
            }

            .tag.is-delete:active {
                background-color: #dbdbdb
            }

            .tag.is-rounded {
                border-radius: 290486px
            }

            #panel-toggle {
                border: 0;
                height: 20px;
                position: relative;
                top: 7px;
                cursor: pointer;
            }
        </style>
        <script language="javascript">
            var EventUtil = function () {
            };
            EventUtil.addEventHandler = function (obj, EventType, Handler) {
                if (obj.addEventListener) {
                    obj.addEventListener(EventType, Handler, false);
                } else if (obj.attachEvent) {
                    obj.attachEvent('on' + EventType, Handler);
                } else {
                    obj['on' + EventType] = Handler;
                }
            }
            if (document.getElementById("text")) {
                EventUtil.addEventHandler(document.getElementById('text'), 'propertychange', CountChineseCharacters);
                EventUtil.addEventHandler(document.getElementById('text'), 'input', CountChineseCharacters);
            }

            function showit(Word) {
                alert(Word);
            }

            function CountChineseCharacters() {
                Words = document.getElementById('text').value;
                var W = new Object();
                var Result = new Array();
                var iNumwords = 0;
                var sNumwords = 0;
                var sTotal = 0;
                var iTotal = 0;
                var eTotal = 0;
                var otherTotal = 0;
                var bTotal = 0;
                var inum = 0;
                var znum = 0;
                var gl = 0;
                var paichu = 0;
                for (i = 0; i < Words.length; i++) {
                    var c = Words.charAt(i);
                    if (c.match(/[\u4e00-\u9fa5]/) || c.match(/[\u0800-\u4e00]/) || c.match(/[\uac00-\ud7ff]/)) {
                        if (isNaN(W[c])) {
                            iNumwords++;
                            W[c] = 1;
                        }
                        iTotal++;
                    }
                }
                for (i = 0; i < Words.length; i++) {
                    var c = Words.charAt(i);
                    if (c.match(/[^\x00-\xff]/)) {
                        if (isNaN(W[c])) {
                            sNumwords++;
                        }
                        sTotal++;
                    } else {
                        eTotal++;
                    }
                    if (c.match(/[0-9]/)) {
                        inum++;
                    }
                    if (c.match(/[a-zA-Z]/)) {
                        znum++;
                    }
                    if (c.match(/[\s]/)) {
                        gl++;
                    }
                    if (c.match(/[　◕‿↑↓←→↖↗↘↙↔↕。《》、【】“”•‘’❝❞′……—―‐〈〉„╗╚┐└‖〃「」‹›『』〖〗〔〕∶〝〞″≌∽≦≧≒≠≤≥㏒≡≈✓✔◐◑◐◑✕✖★☆₸₹€₴₰₤₳र₨₲₪₵₣₱฿₡₮₭₩₢₧₥₫₦₠₯○㏄㎏㎎㏎㎞㎜㎝㏕㎡‰〒々℃℉ㄅㄆㄇㄈㄉㄊㄋㄌㄍㄎㄏㄐㄑㄒㄓㄔㄕㄖㄗㄘㄙㄚㄛㄜㄝㄞㄟㄠㄡㄢㄣㄤㄥㄦㄧㄨㄩ]/)) {
                        paichu++;
                    }
                }
                document.getElementById('hanzi').innerText = iTotal - paichu;
                document.getElementById('zishu').innerText = inum + iTotal - paichu;
                document.getElementById('biaodian').innerText = sTotal - iTotal + eTotal - inum - znum - gl + paichu;
                document.getElementById('zimu').innerText = znum;
                document.getElementById('shuzi').innerText = inum;
                document.getElementById("zifu").innerHTML = iTotal * 2 + (sTotal - iTotal) * 2 + eTotal;
            }
        </script>
        <script>
            $(document).ready(function () {
                $("#wmd-editarea").append('<div class="field is-grouped"><span class="tag">共计：</span><div class="control"><div class="tags has-addons"><span class="tag is-dark" id="zishu">0</span> <span class="tag is-primary">个字数</span></div></div><div class="control"><div class="tags has-addons"><span class="tag is-dark" id="zifu">0</span> <span class="tag is-primary">个字符</span></div></div><span class="tag">包含：</span><div class="control"><div class="tags has-addons"><span class="tag is-light" id="hanzi">0</span> <span class="tag is-danger">个文字</span></div></div><div class="control"><div class="tags has-addons"><span class="tag is-light" id="biaodian">0</span> <span class="tag is-info">个符号</span></div></div><div class="control"><div class="tags has-addons"><span class="tag is-light" id="zimu">0</span> <span class="tag is-success">个字母</span></div></div><div class="control"><div class="tags has-addons"><span class="tag is-light" id="shuzi">0</span> <span class="tag is-warning">个数字</span></div></div></div>');
                CountChineseCharacters();
            });
        </script>
        <?php
    }

}
