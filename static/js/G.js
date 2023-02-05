/**
 * 为prism代码块初始化行号插件
 */
let makePrismLineNum = () => {
	let ele = document.getElementsByTagName("pre");
	if (ele.length > 0)
		for (let element of ele)
			element.className = element.className + " line-numbers";
	
	// 适配c++
	// 真的是吐了，把+号塞类名里，就这样吧
	document.querySelectorAll('code[class="c++"]')?.forEach((cpp) => {
		cpp.className = 'lang-cpp';
	})

	if (typeof Prism !== "undefined") {
		Prism.highlightAll(true, null);
	}
};

/**
 * 将ele元素集合的attribute属性转移至origin属性
 *
 * @param {HTMLCollection} ele 需要处理的元素集合
 * @param {string} attribute 源属性
 * @param {string} origin 目标属性
 */
let preLazy = (ele, attribute, origin, instead = "") => {
	for (let element of ele) {
		element.setAttribute(origin, element.getAttribute(attribute));
		element.setAttribute(attribute, instead);
	}
};

/**
 * 封面懒加载
 *
 * @param {object} element 目标元素
 * @param {object} observe IntersectionObserver
 */
let lazyBanner = (element, observe) => {
	let data_src = element.target.getAttribute("origin");
	new Promise((rs, rj) => {
		let image = new Image();
		image.onload = function () {
			rs(data_src.slice(22, -2));
		};
		image.src = data_src.slice(22, -2);
	}).then((success) => {
		element.target.setAttribute(
			"style",
			data_src + "visibility: visible;animation: banner-show 1s;"
		);
		observe.unobserve(element.target);
	});
};

/**
 * 图片懒加载
 *
 * @param {object} element 目标元素
 * @param {object} observe IntersectionObserver
 */
let lazyPic = (element, observe) => {
	new Promise((rs, rj) => {
		let image = new Image();
		image.onload = function () {
			rs(image.src);
		};
		image.src = element.target.getAttribute("origin");
	})
		.then((success) => {
            element.target.setAttribute("src", success);
			addClass(element.target, "lazyload-done");
			observe.unobserve(element.target);
		})
		.catch((error) => {
			console.log("图片加载失败", error);
		});
};

/**
 * lazyload处理函数
 *
 * @param {object} ele 需要处理的元素集合
 * @param {function} fn 处理函数
 */
let lazyload = (ele, fn) => {
	if (ele.length > 0) {
		const observe = new IntersectionObserver((entries) => {
			for (let element of entries)
				if (element.isIntersecting) fn(element, observe);
		});

		for (let item of ele) {
			observe.observe(item);
		}
	}
};

/**
 * 折叠开关控制器
 *
 * @param {object} target 元素
 */
let collapseController = (target) => {
	if (target.parentNode.getAttribute("data-collapsed") == "true") {
		expandSection(target.parentNode.children[1]);
		target.parentNode.setAttribute("data-collapsed", "false");
	} else {
		target.parentNode.setAttribute("data-collapsed", "true");
		target.parentNode.children[1].setAttribute("style", "height: auto;");
		collapseSection(target.parentNode.children[1]);
	}
};

/**
 * 赞助开关
 */
let sponsorToggle = () => {
	let item = document.querySelector("#post-sponsor");
	if (item.dataset.collapsed == "true") {
		expandSection(item);
		item.dataset.collapsed = "false";
	} else {
		item.dataset.collapsed = "true";
		item.setAttribute("style", "height: auto;");
		collapseSection(item);
	}
};

/**
 * 灯箱
 *
 * @param {object} target
 */
let lightbox = (target) => {
	let wrap = document.createElement("div");
	wrap.classList.add("lightbox-wrap");
	wrap.innerHTML =
		'<img alt="" style="max-width: 80%;max-height: 80%;" src="' +
		target.src +
		'">';
	wrap.setAttribute("onclick", "closeLightbox(this)");
	document.body.appendChild(wrap);
};

/**
 * 灯箱关闭
 *
 * @param {object} target
 */
let closeLightbox = (target) => {
	target.setAttribute("style", "animation: opacity-out .2s;opacity: 0;");
	setTimeout(() => {
		document.body.removeChild(target);
	}, 200);
};

/**
 * 生成相册
 */
let makeGallery = () => {
	let base = 50;
	let galleries = document.getElementsByClassName("photos");
	for (let gallery of galleries)
		for (let pic of gallery.children) {
			let img = new Image();
			img.src = pic.children[0].children[0].getAttribute("src");
			img.onload = function () {
				let w = img.width;
				let h = img.width;
				pic.setAttribute(
					"style",
					"width: " + (w * base) / h + "px;flex-grow: " + (w * base) / h
				);
				pic.children[0].setAttribute(
					"style",
					"padding-top: " + (h / w) * 100 + "%"
				);
			};
		}
};

/**
 * 夜间模式开关
 */
let darkModeToggle = () => {
	document.querySelector('link[title="dark"]').disabled = !document.querySelector('link[title="dark"]').disabled;
};

/**
 * 自动夜间模式判断
 */
let autoDarkMode = () => {
	const [start, end] = window.G_CONFIG.nightSpan.split('-');
	const nightMode = window.G_CONFIG.nightMode;
	const nightModeMap = {
		'3': window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches,
		'2': new Date().getHours() >= parseInt(start) || new Date().getHours() < parseInt(end),
		'1': (new Date().getHours() >= parseInt(start) || new Date().getHours() < parseInt(end)) || (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches),
	};

	if (nightMode === '0' || !Object.keys(nightModeMap).includes(nightMode)) return;

	if (nightModeMap[nightMode])
		document.querySelector('link[title="dark"]').disabled = false;
	else 
		document.querySelector('link[title="dark"]').disabled = true;
};

/**
 * toolbar按钮赋能
 */
let toolbarInit = () => {
	document.querySelector("#gototop").onclick = function () {
		window.scroll({ top: 0, left: 0, behavior: "smooth" });
	};
	document.querySelector("#darkmode").onclick = darkModeToggle;
	document.querySelector("#sidebar-btn").onclick = toggleSidebar;
};

/**
 * 表情控件开关
 */
let toggleOwO = () => {
	let OwOContainer = document.querySelector("#OwO-container");
	if (
		!OwOContainer.classList.contains("OwO-in") &&
		!OwOContainer.classList.contains("OwO-out")
	)
		OwOContainer.classList.add("OwO-in");
	else {
		OwOContainer.classList.toggle("OwO-in");
		OwOContainer.classList.toggle("OwO-out");
	}
};

/**
 * 关闭OwO
 */
let closeOwO = () => {
	if (
		document.getElementById("OwO-container").classList.contains("OwO-in") ||
		(!document.getElementById("OwO-container").classList.contains("OwO-out") &&
			document.getElementById("OwO-container").classList.length === 1)
	)
		toggleOwO();
};

/**
 * 目录开关
 */
let toggleToc = () => {
	document.getElementById("toc").classList.toggle("toc-show");
	document.getElementById("main").classList.toggle("toc-show-main");
};

/**
 * 侧边栏开关
 */
let toggleSidebar = () => {
	document.getElementById("sliderbar").classList.toggle("move-left");
	document.getElementById("sliderbar").classList.toggle("move-right");
	if (document.getElementById("sliderbar-cover").style.display == "block")
		document.getElementById("sliderbar-cover").style.display = "none";
	else document.getElementById("sliderbar-cover").style.display = "block";
};

/**
 * 滑动OwO
 */
let slideOwO = (id) => {
	document.querySelector("#" + id).scrollIntoView({ behavior: "smooth" });
};

/**
 * ajax评论
 */
let ajaxComment = () => {
	let replyTo = "",
		commentForm = document.querySelector("#comment_form");
	let bindButton = () => {
		document.querySelectorAll(".comment-reply a").forEach((reply) => {
			reply.onclick = function () {
				replyTo = reply.parentNode.parentNode.parentNode.parentNode.id;
				//console.log('回复绑定成功，当前回复id为', replyTo);
				return TypechoComment.reply(replyTo, parseInt(replyTo.slice(8)));
			};
		});
		document.querySelectorAll(".cancel-comment-reply a").forEach((cancel) => {
			cancel.onclick = () => {
				replyTo = "";
				//console.log('取消绑定，当前回复id重置为', replyTo);
				return TypechoComment.cancelReply();
			};
		});
	};
	bindButton();

	/**
	 * 发送前的处理
	 */
	function beforeSendComment() {
		closeOwO();
	}

	/**
	 * 发送后的处理
	 * @param {boolean} status
	 */
	function afterSendComment(status) {
		if (status) {
			document.getElementById("comments-textarea").value = "";
			replyTo = "";
			showToast("发送成功");
		}
		bindButton();
	}

	commentForm.onsubmit = function () {
		commentData = objSerialize(commentForm);
		beforeSendComment();
		Ajax.post(commentForm.getAttribute("action"), commentData)
			.then((result) => {
				let newComment = document.createElement("div");
				newComment.innerHTML = result;
				if (
					newComment.getElementsByTagName("title").length > 0 &&
					newComment.getElementsByTagName("title")[0].innerText ===
						document.title
				) {
					afterSendComment(true);
					TypechoComment.cancelReply();
					document
						.querySelector("#comments")
						.removeChild(document.querySelector(".comment-list"));
					document
						.querySelector("#comments")
						.appendChild(newComment.querySelector(".comment-list"));
					replyTo = "";
				} else {
					afterSendComment(false);
					let msg = newComment.querySelector(".container")
						? newComment.querySelector(".container").innerText
						: newComment.childNodes[0].childNodes[0].childNodes[0].innerText;
					showToast("评论失败，" + msg);
				}
			})
			.catch((error) => {
				let newComment = document.createElement("div");
				newComment.innerHTML = error;
				let msg = newComment.querySelector(".container")
					? newComment.querySelector(".container").innerText
					: newComment.childNodes[0].childNodes[0].childNodes[0].innerText;
				showToast("评论失败，" + msg.replaceAll("<br>", ""));
			});
		return false;
	};
};

/**
 * 表情配置
 */
Smilies = {
	dom: function (id) {
		return document.querySelector(id);
	},
	grin: function (tag) {
		tag = " " + tag + " ";
		myField = this.dom("#comments-textarea");
		document.selection
			? (myField.focus(),
			  (sel = document.selection.createRange()),
			  (sel.text = tag),
			  myField.focus())
			: this.insertTag(tag);
	},
	insertTag: function (tag) {
		myField = Smilies.dom("#comments-textarea");
		myField.selectionStart || myField.selectionStart === "0"
			? ((startPos = myField.selectionStart),
			  (endPos = myField.selectionEnd),
			  (cursorPos = startPos),
			  (myField.value =
					myField.value.substring(0, startPos) +
					tag +
					myField.value.substring(endPos, myField.value.length)),
			  (cursorPos += tag.length),
			  myField.focus(),
			  (myField.selectionStart = cursorPos),
			  (myField.selectionEnd = cursorPos))
			: ((myField.value += tag), myField.focus());
	},
};

/**
 * 目录初始化
 */
let TocInit = () => {
	let titles = document.querySelectorAll(
		".PAP-content h1, .PAP-content h2, .PAP-content h3"
	);
	if (titles.length > 0) {
		titles.forEach((title) => {
			title.onclick = () => {
				toggleToc();
			};
			title.id = title.innerHTML;
		});
		tocbot.init({
			tocSelector: "#toc-content",
			contentSelector: ".PAP-content",
			headingSelector: "h1, h2, h3",
			hasInnerContainers: true,
			headingsOffset: 40,
			scrollSmoothOffset: -40,
		});

		if (window.G_CONFIG.autoTOC && document.body.clientWidth > 830)
			toggleToc();
	}
};

/**
 * 页面初始化
 */
let pageInit = () => {
	let images = document.querySelectorAll(".PAP-content img");
	images.forEach((img) => {
		if (!img.classList.contains("bq")) {
			//img.setAttribute("onclick", "lightbox(this)");
            img.dataset.src = img.getAttribute("origin");
            img.classList.add("spotlight");
			let info = document.createElement("span");
			info.innerText = img.getAttribute("title");
			info.classList.add("imageinfo");
			img.after(info);
		}
	});
	makeGallery();
	TocInit();
	if (document.getElementById("comment_form") !== null) ajaxComment();
	makePrismLineNum();
	if (window.G_CONFIG.katex && document.querySelector(".PAP-content")) {
		renderMathInElement(document.querySelector(".PAP-content"), {
			delimiters: [
				{ left: "$$", right: "$$", display: true },
				{ left: "$", right: "$", display: false },
			],
			throwOnError: true,
		});
	}
	custom_callback();
};

/**
 * lazyload加载
 */
let doLazyload = () => {
	let banners = document.getElementsByClassName("article-banner");
	let pics = document.querySelectorAll(
		"img:not(#header-background):not(#profile-avatar)"
	);
	preLazy(banners, "style", "origin");
	preLazy(pics, "src", "origin", window.G_CONFIG.imgUrl + "loading2.gif");
	lazyload(banners, function (element, observe) {
		lazyBanner(element, observe);
	});
	lazyload(pics, function (element, observe) {
		lazyPic(element, observe);
	});
};

/**
 * 文章点赞
 */
let sendLike = () => {
	let btn = document.querySelector("#agree-btn");
	btn.style.disabled = true;
	Ajax.post(btn.dataset.url, "agree=" + btn.dataset.cid).then((res) => {
		let re = /\d/;
		if (re.test(res)) {
			let counter = btn.childNodes[3];
			if (parseInt(res) == parseInt(counter.innerHTML))
				showToast("已经点过赞咯");
			else showToast("点赞成功");
			counter.innerHTML = res;
			counter.parentNode.childNodes[1].innerHTML = "😍";
		} else showToast("出了点小问题");
	});
};

/**
 * 点赞小组件
 */
let DYLM = throttle((url) => {
	let cnt = document.querySelector("#DoYouLikeMe p span");
	Ajax.post(url, "DYLM=add").then((res) => {
		if (res === "success") {
			cnt.innerText = parseInt(cnt.innerText) + 1;
			showToast("感谢喜欢~");
		} else {
			showToast(res);
		}
	});
}, 1000);

/**
 * pjax发送回调
 */
document.addEventListener("pjax:send", () => {
	if (typeof aplayers !== "undefined") {
		for (let i = 0; i < aplayers.length; i++) {
			try {
				aplayers[i].destroy();
			} catch (e) {
				console.log(e);
			}
		}
	}
	tocbot.destroy();
    if(document.getElementById("spotlight"))
        Spotlight.close();
	if (document.getElementById("main").classList.contains("toc-show-main"))
		toggleToc();
	window.scroll({ top: 0, left: 0, behavior: "smooth" });
	let main =
		document.querySelector("#container") ||
		document.querySelector(".PAP") ||
		document.querySelector("#lyrics");
	if (main) {
		main.setAttribute(
			"style",
			"animation: opacity-out var(--theme-animation-out-duration, 1s) ease;opacity: 0;"
		);
		let duration =
			parseFloat(
				getComputedStyle(main).getPropertyValue(
					"--theme-animation-out-duration"
				)
			) * 1000;
		setTimeout(function () {
			main.style.opacity = "0";
		}, duration);
	}
});

/**
 * pjax完成回调
 */
document.addEventListener("pjax:complete", () => {
	if (typeof Prism !== "undefined") {
		Prism.highlightAll(true, null);
	}

	if (typeof loadMeting === "function") {
		loadMeting();
	}

    doLazyload();
	pageInit();
});

/**
 * Exsearch回调
 *
 * @param {*} item event target
 */
function ExSearchCall(item) {
	if (item && item.length) {
		document.querySelector(".ins-close").click();
		pjax.loadUrl(item[0].dataset.url);
	}
}

window.ready(function () {
	doLazyload();
	console.log("G.js ready");
	window.pjax = new Pjax({
		elements: "a:not([target='_blank']):not([no-pjax])", // default is "a[href], form[action]"
		selectors: ["#main", "title"],
		timeout: 10000,
		cacheBust: false,
		scrollRestoration: true,
	});

	autoDarkMode();
	toolbarInit();
	pageInit();
});

window.onbeforeunload = function () {};
