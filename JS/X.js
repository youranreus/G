/**
 * @file X.js
 * @author youranreus
 */
console.info("%c Theme by youranreus ", 'color:#fadfa3;background:#030307;padding:5px 0;');
console.info("%c Powered by Typecho ", 'color:#fadfa3;background:#030307;padding:5px 0;');
//返回顶部
$(document).ready(function() {
    $(window).scroll(function() {
        var scroTop = $(window).scrollTop();
        if (scroTop > 100) {
            $('#gototop').fadeIn(500);
        } else {
            $('#gototop').fadeOut(500);
        }
    });
});
//移动端Hover补偿
var mobileHover = function() {  
    $('*').on('touchstart', function() {    
        $(this).trigger('hover');  
    }).on('touchend', function() {    
        $(this).trigger('hover');  
    });
};
// InstantClick加载
InstantClick.on('wait', function() {
    $("#M").addClass("opacity-disappear");
});
InstantClick.on('change', function() {
    //显示主页面
    $("#M").removeClass("opacity-disappear").addClass("opacity-show");
    $("pre code").each(function(i, block) {
        hljs.highlightBlock(block);
        $(this).html("<ul><li>" + $(this).html().replace(/\n/g, "\n</li><li>") + "\n</li></ul>");
    });
    PreFancybox();
    ajaxc();
    OwOInsert();
    $('#gototop').click(function() {
        $("html,body").animate({
            scrollTop: 0
        }, "fast");
    });
    _hmt.push(['_trackPageview', location.pathname + location.search]);
});
InstantClick.init('mousedown');
// OwO表情
function OwOInsert() {
    if ($('#OwO-container').length == 1 && $('#qaq').length == 0) {
        if (!this.OwOHtml) {
            console.log('init OwO HTML');
            var OwOArr = ['chaiquan', 'chaiquanbugaoxin', 'chaiquanzaijian', 'chaiquanku', 'hehe', 'haha', 'tushe', 'taikaixin', 'xiaoyan', 'huaxin', 'xiaoguai', 'guai', 'wuzuixiao', 'huaji', 'nidongde', 'bugaoxin', 'nu', 'han', 'heixian', 'lei', 'zhenbang', 'pen', 'jingku', 'yinxian', 'bishi', 'ku', 'a', 'kuanghan', 'what', 'yiwen', 'suanshuang', 'yamiedie', 'weiqu', 'jingya', 'shuijiao', 'xiaoniao', 'wabi', 'tu', 'xili', 'xiaohonglian', 'landeli', 'mianqiang', 'aixin', 'xinsui', 'meigui', 'liwu', 'caihong', 'taiyang', 'xinxinyueliang', 'qianbi', 'chabei', 'dangao', 'damuzhi', 'shengli', 'haha', 'OK', 'shafa', 'shouzhi', 'xiangjiao', 'bianbian', 'yaowan', 'hlj', 'lazhu', 'yingyue', 'dengpao'];
            this.OwOHtml = '';
            $.each(OwOArr, function(i, v) {
                OwOHtml += '<li class="OwO-item" onclick="Smilies.grin(\'@(' + v + ')\');"><img src="https://res.cloudinary.com/mingye/image/upload/v1565200913/img/bq/' + v + '.png"/></li>';
            });
        }
        $('#OwO-container').html('<div class="OwO OwO-open" id="qaq"><div class="OwO-body" id="OwO-body"><ul class="OwO-items OwO-items-emoticon OwO-items-show" id="OwO-pp" style="max-height: 197px;">' + OwOHtml + '</ul></div></div>');
    }
}
// 灯箱
function PreFancybox() {
    $("#post img").each(function() {
        $(this).wrap(function() {
            if ($(this).is(".bq")) {
                return '';
            }
            if ($(this).is("#feedme-content img")) {
                return '';
            }
            return '<a data-fancybox="gallery" data-type="image" href="' + $(this).attr("src") + '" class="light-link"></a>';
        })
    });
}
//赞赏按钮
function feedme_show() {
    if ($("#feedme-content").css("display") == 'none') {
        $("#feedme-content").slideDown();
    } else {
        $("#feedme-content").slideUp();
    }
}
//OwO设置
Smilies = {
    dom: function(id) {
        return document.getElementById(id);
    },
    grin: function(tag) {
        tag = ' ' + tag + ' ';
        myField = this.dom("textarea");
        document.selection ? (myField.focus(), sel = document.selection.createRange(), sel.text = tag, myField.focus()) : this.insertTag(tag);
    },
    insertTag: function(tag) {
        myField = Smilies.dom("textarea");
        myField.selectionStart || myField.selectionStart == "0" ? (startPos = myField.selectionStart, endPos = myField.selectionEnd, cursorPos = startPos, myField.value = myField.value.substring(0, startPos) + tag + myField.value.substring(endPos, myField.value.length), cursorPos += tag.length, myField.focus(), myField.selectionStart = cursorPos, myField.selectionEnd = cursorPos) : (myField.value += tag, myField.focus());
    }
}
//OwO开关
function OwO_show() {
    if ($("#OwO-container").css("display") == 'none') {
        $("#OwO-container").slideDown();
    } else {
        $("#OwO-container").slideUp();
    }
}
(function() {
    window.TypechoComment = {
        reply: function(cid, coid) {
            var comment = $("#" + cid)[0],
                response = $(".comments-header"),
                input = $("#comment-parent"),
                form = response.find("form"),
                textarea = response.find("textarea");
            if (input.length == 0) {
                form.append('<input type="hidden" name="parent" id="comment-parent">')
            }
            $("#comment-parent").attr("value", coid);
            if ($("#comment-form-place-holder").length == 0) {
                $(".comments-header").before('<div id="comment-form-place-holder"></div>')
            }
            $("#" + cid).append($(".comments-header"));
            $('#response').text('向' + response.prevAll('.comment-inner').find('span').eq(0).text() + '进行回复');
            $("#cancel-comment-reply-link").show();
            if (textarea.length != 0 && textarea.attr("name") == "text") {
                textarea.focus()
                textarea.val('');
            }
            return false
        },
        cancelReply: function() {
            var input = $("#comment-parent"),
                response = $(".comments-header");
            input.length != 0 && input.remove();
            $("#cancel-comment-reply-link").hide();
            response.insertBefore("#comment-form-place-holder");
            $('#response').text("添加新评论");
            response.find("textarea").val('');
            return false
        }
    }
})();

function ajaxc() {
    var replyTo = '', //回复评论时候的ID
        submitButton = $(".submit").eq(0), //提交评论按钮
        commentForm = $("#comment-form"), //评论表单
        newCommentId = ""; //新评论的ID
    var bindButton = function() {
        $(".comment-reply a").click(function() {
            replyTo = $(this).parent().parent().parent().attr("id");
        });
        $(".cancel-comment-reply a").click(function() {
            replyTo = '';
        });
    };
    bindButton();
    /**
     * 发送前的处理
     */
    function beforeSendComment() {
        $("#comment-loading").fadeIn();
        $(".submit").fadeOut();
        $("#OwO-container").slideUp();
    }
    /**
     * 发送后的处理
     * @param {boolean} ok
     */
    function afterSendComment(ok) {
        if (ok) {
            $("#textarea").val('');
            replyTo = '';
        }
        bindButton();
    }
    $("#comment-form").submit(function() {
        commentData = $(this).serializeArray();
        beforeSendComment();
        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: commentData,
            error: function(e) {
                console.log('Ajax Comment Error');
                window.location.reload();
            },
            success: function(data) {
                if (!$('#comments', data).length) {
                    afterSendComment(false);
                    alert($.trim($($(data)[7]).text()));
                    return false;
                }
                $("input,textarea", commentForm).attr('disabled', false);
                $("#textarea").val('');
                var newComment;
                newCommentId = $(".comment-list", data).html().match(/id=\"?comment-\d+/g).join().match(/\d+/g).sort(function(a, b) {
                    return a - b
                }).pop();
                if ('' === replyTo) {
                    if (!$('.comment-list').length) {
                        newComment = $("#li-comment-" + newCommentId, data);
                        $('.comments-header').after('<ol class="comment-list"></ol>');
                        $('.comment-list').first().prepend((newComment).addClass('animated fadeInUp'));
                    } else if ($('.prev').length) {
                        $('#page-nav ul li a').eq(1).click();
                    } else {
                        newComment = $("#li-comment-" + newCommentId, data);
                        $('.comment-list').first().prepend((newComment).addClass('animated fadeInUp'));
                    }
                    $('html,body').animate({
                        scrollTop: $('#response').offset().top - 100
                    }, 1000);
                } else {
                    newComment = $("#li-comment-" + newCommentId, data);
                    if ($('#' + replyTo).find('.comment-children').length) {
                        $('#' + replyTo + ' .comment-children .comment-list').first().prepend((newComment).addClass('animated fadeInUp'));
                        TypechoComment.cancelReply();
                    } else {
                        $('#' + replyTo).append('<div class="comment-children"><ol class="comment-list"></ol></div>');
                        $('#' + replyTo + ' .comment-children .comment-list').first().prepend((newComment).addClass('animated fadeInUp'));
                        TypechoComment.cancelReply();
                    }
                }
                afterSendComment(true);
            },
            error:function(){
                $("#comment-loading").fadeOut();
                $(".submit").fadeIn();
            },
            complete:function(){
                $("#comment-loading").fadeOut();
                $(".submit").fadeIn();
            }
        });
        return false;
    });
}
