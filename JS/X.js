/**
 * @file X.js
 * @author youranreus
 */

//移动端Hover补偿
var mobileHover = function () {
    $('*').on('touchstart', function () {
        $(this).trigger('hover');
    }).on('touchend', function () {
        $(this).trigger('hover');
    });
};

//夜间模式开关
function switchNightMode(){
    var night = document.cookie.replace(/(?:(?:^|.*;\s*)night\s*\=\s*([^;]*).*$)|^.*$/, "$1") || '0';
    if(night == '0'){
        document.querySelector('link[title="dark"]').disabled = true;
        document.querySelector('link[title="dark"]').disabled = false;
        document.cookie = "night=1;path=/"
        Qmsg.info("夜间模式开启",QMSG_GLOBALS.DEFAULTS);
    }else{
        document.querySelector('link[title="dark"]').disabled = true;
        document.cookie = "night=0;path=/"
        Qmsg.info("夜间模式关闭",QMSG_GLOBALS.DEFAULTS);
    }
}

//自动判断夜间模式
(function(){
    if(document.cookie.replace(/(?:(?:^|.*;\s*)night\s*\=\s*([^;]*).*$)|^.*$/, "$1") == ''){
        if(new Date().getHours() > 22 || new Date().getHours() < 6){
        document.querySelector('link[title="dark"]').disabled = true;
        document.querySelector('link[title="dark"]').disabled = false;
        document.cookie = "night=1;path=/"
        Qmsg.info("夜间模式开启",QMSG_GLOBALS.DEFAULTS);
        }else{
        document.cookie = "night=0;path=/"
        }
    }else{
        var night = document.cookie.replace(/(?:(?:^|.*;\s*)night\s*\=\s*([^;]*).*$)|^.*$/, "$1") || '0';
        if(night == '0'){
        document.querySelector('link[title="dark"]').disabled = true;
        }else if(night == '1'){
        document.querySelector('link[title="dark"]').disabled = true;
        document.querySelector('link[title="dark"]').disabled = false;
        Qmsg.info("夜间模式开启",QMSG_GLOBALS.DEFAULTS);
        }
    }
})();

//相册排版by 熊猫小A
function makeGallery(){
  var base = 50;
  $.each($('.photos'), function(i, photoSet){
    $.each($(photoSet).children(), function(j, item){
      var img = new Image();
      img.src = $(item).find('img').attr('src');
      img.onload = function(){
        var w = parseFloat(img.width);
        var h = parseFloat(img.height);
        $(item).css('width', w*base/h +'px');
        $(item).css('flex-grow', w*base/h);
        $(item).find('div').css('padding-top', h/w*100+'%');
      };
    });
  });
}



//pjax 刷新
$(document).pjax('a:not(a[target="_blank"], a[no-pjax])', {
		container: '#pjax-container',
		fragment: '#pjax-container',
		timeout: 8000
}).on('pjax:send',function () {pjax_send();}).on('pjax:complete',function() {pjax_complete();}).on('pjax:click',function() {pjax_click();});

function pjax_click(){
	//结束aplayer进程
	if (typeof aplayers !== 'undefined'){
    for (var i = 0; i < aplayers.length; i++) {
        try {aplayers[i].destroy()} catch(e){}
    }
	}

}

function pjax_send(){
	$("#M").addClass("opacity-disappear");
	if ($('.toc').length) tocbot.destroy();

  if(typeof(NProgress)!=="undefined"){
    NProgress.start();
  }
}

function pjax_complete(){
	//Prism重启
	if (typeof Prism !== 'undefined') {
		Prism.highlightAll(true,null);
	}
	//Meting重启
	var isFunction =false;
	try{
  isFunction = typeof(eval('loadMeting'))=="function";
	}catch(e){}
		if(isFunction) {
  	loadMeting();
	}else{}

	//显示主页面
	$("#M").addClass("opacity-show");
	PreFancybox();
	imageinfo();
	toc();
  makeGallery();
	collapse_toggle();
	jQuery(document).ready(function ($) {
			$("img.lazyload").lazyload({
						threshold: 100,
						effect: "fadeIn"
			});
	});
	ajaxc();
  if(typeof(NProgress) !== "undefined"){
    NProgress.done();
  }
}

function PreFancybox(){
	$("#post img").each(function(){
				$(this).wrap(function(){
					if($(this).is(".bq") || $(this).is("#feedme-content img"))
					{
						 return '';
					}
				return '<a data-fancybox="gallery" no-pjax data-type="image" href="' + $(this).attr("src") + '" class="light-link"></a>';
		 });
	});
}

function imageinfo(){
	$("#post img").each(function(){
				$(this).wrap(function(){
					if($(this).is(".bq") || $(this).is("#feedme-content img"))
					{
						 return '';
					}
					if($(this).is("div.photos figure div img"))
					{
            $(this).addClass("lazyload");
  					$(this).attr('data-original',$(this).attr("src"));
  					$(this).attr('src','https://cdn.jsdelivr.net/gh/youranreus/R@v1.1.5/G/IMG/loading2.gif');
						return '';
					}
					$(this).addClass("lazyload");
					$(this).attr('data-original',$(this).attr("src"));
					$(this).attr('src','https://cdn.jsdelivr.net/gh/youranreus/R@v1.1.5/G/IMG/loading2.gif');
					$(this).after('<span class="imageinfo">'+ $(this).attr("title") +'</span>');
		 });
	});
}


function show_site_runtime(bdate){
	window.setTimeout("show_site_runtime('" +bdate + "')",1000);
	X=new Date(bdate);
	Y=new Date();
	T=(Y.getTime()-X.getTime());
	i=24*60*60*1000;
	d=T/i;
	D=Math.floor(d);
	h=(d-D)*24;
	H=Math.floor(h);
	m=(h-H)*60;
	M=Math.floor(m);
	s=(m-M)*60
	S=Math.floor(s);
	site_runtime.innerHTML= D + "<span>天</span>" + H + "<span>小时</span>" + M + "<span>分</span>" + S + "<span>秒</span>"
}



//赞赏按钮
function feedme_show(){
	if($("#feedme-content").css("display")=='none'){
		 $("#feedme-content").slideDown();
	}else{
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
function OwO_show(){
	if($("#OwO-container").css("display")=='none'){
		 $("#OwO-container").slideDown();
	}else{
		 $("#OwO-container").slideUp();
	 }
}

//侧栏菜单开关
function sideMenu_toggle(){
	$("#sliderbar").toggleClass("move_left");
	$("#sliderbar").toggleClass("move_right");
	$("#sliderbar-cover").toggle();
	$("#m_search").toggle();
	$("#pjax-container").toggleClass("main_display");
	if($("#sliderbar-toc").hasClass("move_left")){
		toc_toggle();
	}
}

//侧栏目录开关
function toc_toggle(){
	$("#sliderbar-toc").toggleClass("move_left");
	$("#sliderbar-toc").toggleClass("move_right");
	$('#m_search').removeClass('m_search_c');
	$("#sliderbar-toc-cover").toggle();
}

//折叠框开关
function collapse_toggle(){
	$('.collapse-title').click(function(){
			if($(this).next().css("display")=='none'){
				 $(this).next().slideDown();
			}else{
				 $(this).next().slideUp();
			 }
	})
}


//目录
function toc(){
	if($("#post-content-article").length>0){
		var headerEl = 'h1,h2,h3,h4',  //headers
	    	content = '#post-content-article',//文章容器
	    	idArr = {},  //标题数组以确定是否增加索引id
				status = false;

			$(content).children(headerEl).each(function () {
			    //去除空格以及多余标点
			    var headerId = $(this).text().replace(/[\s|\~|`|\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\_|\+|\=|\||\|\[|\]|\{|\}|\;|\:|\"|\'|\,|\<|\.|\>|\/|\?|\：|\，|\。]/g, '');

			    headerId = headerId.toLowerCase();
			    if (idArr[headerId]) {
			        //id已经存在
			        $(this).attr('id', headerId + '-' + idArr[headerId]);
			        idArr[headerId]++;
							status = true;
			    }
			    else {
			        //id未存在
			        idArr[headerId] = 1;
			        $(this).attr('id', headerId);
							status = true;
			    }
			});

				if(status == true){
					$('#sliderbar-toc').show();
					$('#m_toc').show();
					$('#m_search').removeClass('m_search_c');
				}
				tocbot.init({
					tocSelector: '.toc',
					contentSelector: content,
					headingSelector: headerEl,
					positionFixedSelector: '#sliderbar-toc',
					positionFixedClass: 'is-position-fixed',
					fixedSidebarOffset: 'auto',
					scrollSmooth: true,
					scrollSmoothOffset: 0,
					headingsOffset: -200
				});
	}else{
		$('#sliderbar-toc').hide();
		$('#m_toc').hide();
		$('#m_search').addClass('m_search_c');
	}



}

function gototop(){
	$('body,html').animate({scrollTop:0},500);
	return false;
}


//侧栏内容开关
function show_slide_content(id){

	var rotate = {
		"-webkit-transition":" .3s ease all",
		"-moz-transition": ".3s ease all",
		"-ms-transition": ".3s ease all",
		"-o-transition": ".3s ease all",
		transition: ".3s ease all",
		"-webkit-transform":" rotate(180deg)",
		"-moz-transform":" rotate(180deg)",
		"-ms-transform": "rotate(180deg)",
		"-o-transform": "rotate(180deg)",
	  transform: "rotate(180deg)"
	};

	var rotate2 = {
		"-webkit-transition":" .3s ease all",
		"-moz-transition": ".3s ease all",
		"-ms-transition": ".3s ease all",
		"-o-transition": ".3s ease all",
		transition: ".3s ease all",
		"-webkit-transform":" rotate(0deg)",
		"-moz-transform":" rotate(0deg)",
		"-ms-transform": "rotate(0deg)",
		"-o-transform": "rotate(0deg)",
	  transform: "rotate(0deg)"
	};

	if($("#Sliderbar-content-"+id).css("display")=='none'){
		 $("#Sliderbar-content-"+id).slideDown();
		 $("#Sliderbar-content-"+id).prev().find('i').css(rotate);
	}else{
		 $("#Sliderbar-content-"+id).slideUp();
		 $("#Sliderbar-content-"+id).prev().find('i').css(rotate2);
	 }
}

//ajax评论
function ajaxc(){
		var replyTo = '',   //回复评论时候的ID
		submitButton = $(".submit").eq(0),  //提交评论按钮
		commentForm = $("#comment-form"),   //评论表单
		newCommentId = "";   //新评论的ID
		var bindButton = function () {
			$(".comment-reply a").click(function () {
					replyTo = $(this).parent().parent().parent().attr("id");
			});
			$(".cancel-comment-reply a").click(function () { replyTo = ''; });
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
            Qmsg.success("发送成功",QMSG_GLOBALS.DEFAULTS);
				}
				bindButton();
		}
		$("#comment-form").submit(function () {
				commentData = $(this).serializeArray();
				beforeSendComment();
				$.ajax({
						type: $(this).attr('method'),
						url: $(this).attr('action'),
						data: commentData,
						error: function (e) {
								console.log('Ajax Comment Error');
								window.location.reload();
						},
						success: function (data) {
								if (!$('#comments', data).length) {
                    var msg = $(data)[7].innerText.replace(/[\r\n]/g,"").replace(/[ ]/g,"");
                    Qmsg.warning(msg,QMSG_GLOBALS.DEFAULTS);
										$("#comment-loading").fadeOut();
										$(".submit").fadeIn();
										afterSendComment(false);
										return false;
								}

								$("input,textarea", commentForm).attr('disabled', false);
								$("#textarea").val('');

								var newComment;
								newCommentId = $(".comment-list", data).html().match(/id=\"?comment-\d+/g).join().match(/\d+/g).sort(function (a, b) { return a - b }).pop();
								if('' === replyTo) {
										if(!$('.comment-list').length) {
												newComment  = $("#li-comment-" + newCommentId, data);
												$('.comments-header').after('<ol class="comment-list"></ol>');
												$('.comment-list').first().prepend((newComment).addClass('animated fadeInUp'));
										}
										else if($('.prev').length) {
												$('#page-nav ul li a').eq(1).click();
										}
										else {
												newComment  = $("#li-comment-" + newCommentId, data);
												$('.comment-list').first().prepend((newComment).addClass('animated fadeInUp'));
										}
										$('html,body').animate({scrollTop:$('#response').offset().top - 100},1000);
								}
								else {
										newComment = $("#li-comment-" + newCommentId, data);
										if ($('#' + replyTo).find('.comment-children').length) {
												$('#' + replyTo + ' .comment-children .comment-list').first().prepend((newComment).addClass('animated fadeInUp'));
												TypechoComment.cancelReply();
										}
										else {
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
console.info(" %c Powered by Typecho ", 'color:#fadfa3;background:#030307;padding:5px 0;');
console.info(" %c made with ❤ by youranreus ",'color: #fadfa3; background: #030307; padding:5px 0;')
