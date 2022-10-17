/**
 * @file X.js
 * @author youranreus
 */

//夜间模式开关
let switchNightMode = () => {
	let night = document.cookie.replace(/(?:(?:^|.*;\s*)night\s*\=\s*([^;]*).*$)|^.*$/, "$1") || '0';
	if (night === '0') {
		document.querySelector('link[title="dark"]').disabled = true;
		document.querySelector('link[title="dark"]').disabled = false;
		document.cookie = "night=1;path=/";
		Qmsg.info("夜间模式开启", QMSG_GLOBALS.DEFAULTS);
	} else {
		document.querySelector('link[title="dark"]').disabled = true;
		document.cookie = "night=0;path=/";
		Qmsg.info("夜间模式关闭", QMSG_GLOBALS.DEFAULTS);
	}
}

//自动判断夜间模式
let autoNight = () => {
	if (document.cookie.replace(/(?:(?:^|.*;\s*)night\s*\=\s*([^;]*).*$)|^.*$/, "$1") === '') {
		if (new Date().getHours() > 22 || new Date().getHours() < 6) {
			document.querySelector('link[title="dark"]').disabled = true;
			document.querySelector('link[title="dark"]').disabled = false;
			document.cookie = "night=1;path=/";
			Qmsg.info("夜间模式开启", QMSG_GLOBALS.DEFAULTS);
		} else {
			document.cookie = "night=0;path=/";
			console.log('还不是晚上哦');
		}
	} else {
		let night = document.cookie.replace(/(?:(?:^|.*;\s*)night\s*\=\s*([^;]*).*$)|^.*$/, "$1") || '0';
		if (night === '0') {
			document.querySelector('link[title="dark"]').disabled = true;
			console.log('还不是晚上哦');
		} else if (night === '1') {
			document.querySelector('link[title="dark"]').disabled = true;
			document.querySelector('link[title="dark"]').disabled = false;
			Qmsg.info("夜间模式开启", QMSG_GLOBALS.DEFAULTS);
		}
	}
}

//相册排版by 熊猫小A
let makeGallery = () => {
	let base = 50;
	$.each($('.photos'), function (i, photoSet) {
		$.each($(photoSet).children(), function (j, item) {
			let img = new Image();
			img.src = $(item).find('img').attr('src');
			img.onload = function () {
				let w = img.width;
				let h = img.width;
				$(item).css('width', w * base / h + 'px');
				$(item).css('flex-grow', w * base / h);
				$(item).find('div').css('padding-top', h / w * 100 + '%');
			};
		});
	});
}



//pjax 刷新
$(document).pjax('a:not(a[target="_blank"], a[no-pjax])', {
	container: '#pjax-container',
	fragment: '#pjax-container',
	timeout: 8000
}).on('pjax:send', () => {
	pjax_send();
}).on('pjax:complete', () => {
	pjax_complete();
}).on('pjax:click', () => {
	pjax_click();
});

let pjax_click = () => {
	//结束aplayer进程
	if (typeof aplayers !== 'undefined') {
		for (let i = 0; i < aplayers.length; i++) {
			try {
				aplayers[i].destroy();
			} catch (e) {
				console.log(e);
			}
		}
	}
}

let pjax_send = () => {
	$("#M").addClass("opacity-disappear");
	if ($('.toc').length)
		tocbot.destroy();
	if (typeof (NProgress) !== "undefined")
		NProgress.start();
}

let pjax_complete = () => {
	//Prism重启
	if (typeof Prism !== 'undefined') {
		Prism.highlightAll(true, null);
	}
	//跑完加载进度条
	if (typeof (NProgress) !== "undefined") {
		NProgress.done();
	}
	//Meting重启
	if (typeof (loadMeting) === "function") {
		loadMeting();
	}

	//显示主页面
	$("#M").addClass("opacity-show");
	PreFancybox();
	imageinfo();
	generateTiptools();
	toc();
	makeGallery();
	agree();
	collapse_toggle();
	if (document.getElementById('post-content-article')) {
		renderMathInElement(document.getElementById('post-content-article'), {
			delimiters: [
				{left: '$$', right: '$$', display: true},
				{left: '$', right: '$', display: false}
			],
			throwOnError: true
		});
	}

	$(document).ready(function ($) {
		$(".lazyload").lazyload({
			threshold: 100,
			effect: "fadeIn"
		});
	});
	ajaxc();
}

//配置Fancybox灯箱插件
let PreFancybox = () => {
	$("#post img").each(function () {
		$(this).wrap(function () {
			if ($(this).is(".bq") || $(this).is("#feedme-content img")) {
				return '';
			}
			return '<a data-fancybox="gallery" no-pjax data-type="image" href="' + $(this).attr("src") + '" class="light-link"></a>';
		});
	});
}

//配置图片懒加载&Title显示
let imageinfo = () => {
	$("#post img").each(function () {
		$(this).wrap(function () {
			if ($(this).is(".bq") || $(this).is("#feedme-content img")) {
				return '';
			}

			if (enableLazyload) {
				$(this).addClass("lazyload");
				$(this).attr('data-original', $(this).attr("src"));
				$(this).attr('src', window.G_CONFIG.theme_url + '/IMG/loading2.gif');
			}

			if (!$(this).is("div.photos figure div img")) {
				$(this).after('<span class="imageinfo">' + $(this).attr("title") + '</span>');
			}
		});
	});

	if (enableLazyload) {
		$("#post-header,.card-cover").each(function () {
			console.log($(this).attr("style"))
			if ($(this).attr("style") !== 'background-image:url()') {
				$(this).addClass("lazyload");
				$(this).attr('data-original', $(this).css("background-image").slice(5, -2));
				$(this).css('background-image', `url(${window.G_CONFIG.theme_url}/IMG/loading-banner.gif)`);
			}
		});
	}
}

//网站运行时间
let show_site_runtime = (bdate) => {
	window.setTimeout("show_site_runtime('" + bdate + "')", 1000);
	let Y = new Date();
	let T = (Y.getTime() - Date.parse(bdate));
	let i = 24 * 60 * 60 * 1000;
	let d = T / i;
	let D = Math.floor(d);
	let h = (d - D) * 24;
	let H = Math.floor(h);
	let m = (h - H) * 60;
	let M = Math.floor(m);
	let s = (m - M) * 60;
	let S = Math.floor(s);
	let site_runtime = document.getElementById('site_runtime');
	site_runtime.innerHTML = D + "<span>天</span>" + H + "<span>小时</span>" + M + "<span>分</span>" + S + "<span>秒</span>";
}

//滑动显示开关
let slideToggle = (obj) => {
	if (obj.css("display") === 'none') {
		obj.slideDown();
	} else {
		obj.slideUp();
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
        myField.selectionStart || myField.selectionStart === "0" ? (startPos = myField.selectionStart, endPos = myField.selectionEnd, cursorPos = startPos, myField.value = myField.value.substring(0, startPos) + tag + myField.value.substring(endPos, myField.value.length), cursorPos += tag.length, myField.focus(), myField.selectionStart = cursorPos, myField.selectionEnd = cursorPos) : (myField.value += tag, myField.focus());
    }
}

//侧栏菜单开关
let sideMenu_toggle = () => {
	$("#sliderbar").toggleClass("move_left").toggleClass("move_right");
	$("#sliderbar-cover,#m_search").toggle();
	$("#pjax-container").toggleClass("main_display");
	if ($("#sliderbar-toc").hasClass("move_left")) {
		toc_toggle();
	}
}

//侧栏目录开关
let toc_toggle = () => {
	$("#sliderbar-toc").toggleClass("move_left").toggleClass("move_right");
	$('#m_search').removeClass('m_search_c');
	$("#sliderbar-toc-cover").toggle();
}

//折叠框开关
let collapse_toggle = () => {
	$('.collapse-title').click(function(){
			if($(this).next().css("display")=='none'){
				 $(this).next().slideDown();
			}else{
				 $(this).next().slideUp();
			 }
	})
}

let generateTiptools = () => {
    Tipped.create('.post-content-tooltip');
}

//点赞
let agree = () => {
  //  点赞按钮点击
  $("#agree-btn").on("click", function() {
    $("#agree-btn").get(0).disabled = true; //  禁用点赞按钮
    //  发送 AJAX 请求
    $.ajax({
      //  请求方式 post
      type: "post",
      //  url 获取点赞按钮的自定义 url 属性
      url: $("#agree-btn").attr("data-url"),
      //  发送的数据 cid，直接获取点赞按钮的 cid 属性
      data: "agree=" + $("#agree-btn").attr("data-cid"),
      async: true,
      timeout: 30000,
      cache: false,
      //  请求成功的函数
      success: function(data) {
        var re = /\d/; //  匹配数字的正则表达式
        //  匹配数字
        if (re.test(data)) {
          //  把点赞按钮中的点赞数量设置为传回的点赞数量
          $("#agree-btn .agree-num").html(data);
          $("#agree-btn").addClass("agreed");
        }
      },
      error: function() {
        //  如果请求出错就恢复点赞按钮
        $("#agree-btn").get(0).disabled = false;
        Qmsg.info("点赞失败惹", QMSG_GLOBALS.DEFAULTS);
      }
    });
  });
};



//目录
let toc = () => {
	let contentSelector = "#post-content-article";
  if ($(contentSelector).length > 0) {
		let content = $(contentSelector);
    let headerEl = "h1,h2,h3,h4"; //headers
    let idArr = {}; //标题数组以确定是否增加索引id
    let status = false;

    content.children(headerEl).each(function() {
        //去除空格以及多余标点
        let headerId = $(this).text().replace(
            /[\s|\~|`|\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\_|\+|\=|\||\|\[|\]|\{|\}|\;|\:|\"|\'|\,|\<|\.|\>|\/|\?|\：|\，|\。]/g,
            ""
          );

        headerId = headerId.toLowerCase();
        if (idArr[headerId]) {
          //id已经存在
          $(this).attr("id", headerId + "-" + idArr[headerId]);
          idArr[headerId]++;
          status = true;
        } else {
          //id未存在
          idArr[headerId] = 1;
          $(this).attr("id", headerId);
          status = true;
        }
      });

    if (status === true) {
      $("#sliderbar-toc").show();
      $("#m_toc").show();
      $("#m_search").removeClass("m_search_c");
    }
		tocbot.init({
      tocSelector: ".toc",
      contentSelector: contentSelector,
      headingSelector: headerEl,
      positionFixedSelector: "#sliderbar-toc",
      positionFixedClass: "is-position-fixed",
      fixedSidebarOffset: "auto",
      scrollSmooth: true,
      scrollSmoothOffset: 0,
      headingsOffset: -200
    });
  } else {
    $("#sliderbar-toc").hide();
    $("#m_toc").hide();
    $("#m_search").addClass("m_search_c");
  }
};


let gototop = () => {
  $("body,html").animate({scrollTop: 0}, 500);
};



//ajax评论
let ajaxc = () => {
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
