/**
 * 为prism代码块初始化行号插件
 */
let makePrismLineNum = () => {
	let ele = document.getElementsByTagName("pre");
	if (ele.length > 0)
		for (let element of ele)
			element.className = element.className + " line-numbers";
	Prism.highlightAll();
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
	}).then((success) => {
		element.target.setAttribute("src", success);
		addClass(element.target, 'lazyload-done');
		observe.unobserve(element.target);
	}).catch((error)=>{
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
let collapseController = (target) =>{
	if(target.parentNode.getAttribute('data-collapsed') == "true")
	{
		expandSection(target.parentNode.children[1]);
		target.parentNode.setAttribute('data-collapsed', 'false');
	}
	else
	{
		target.parentNode.setAttribute('data-collapsed', 'true');
		target.parentNode.children[1].setAttribute('style','height: auto;');
		collapseSection(target.parentNode.children[1]);
	}
		
};

/**
 * 灯箱
 * 
 * @param {object} target 
 */
let lightbox = (target) => {
    let wrap = document.createElement('div');
    wrap.classList.add('lightbox-wrap');
    wrap.innerHTML = '<img alt="" style="max-width: 80%;max-height: 80%;" src="' + target.src + '">';
    wrap.setAttribute('onclick', 'closeLightbox(this)');
    document.body.appendChild(wrap);
}

/**
 * 灯箱关闭
 * 
 * @param {object} target 
 */
let closeLightbox = (target) => {
    target.setAttribute('style', 'animation: opacity-out .2s;opacity: 0;');
    setTimeout(()=>{
        document.body.removeChild(target);
    }, 200);
}

/**
 * 生成相册
 */
let makeGallery = () => {
	let base = 50;
	let galleries = document.getElementsByClassName('photos');
	for(let gallery of galleries)
		for(let pic of gallery.children)
		{
			let img = new Image();
			img.src = pic.children[0].children[0].getAttribute('src');
			img.onload = function () {
				let w = img.width;
				let h = img.width;
				pic.setAttribute('style','width: ' + w * base / h + 'px;flex-grow: ' + w * base / h);
				pic.children[0].setAttribute('style', 'padding-top: ' + h / w * 100 + '%');
			};
		}
}

/**
 * 夜间模式开关
 */
let darkModeToggle = () => {
	let night = document.cookie.replace(/(?:(?:^|.*;\s*)night\s*\=\s*([^;]*).*$)|^.*$/, "$1") || '0';
	if (night === '0') {
		document.querySelector('link[title="dark"]').disabled = true;
		document.querySelector('link[title="dark"]').disabled = false;
		document.cookie = "night=1;path=/";
	} else {
		document.querySelector('link[title="dark"]').disabled = true;
		document.cookie = "night=0;path=/";
	}
};

/**
 * 自动夜间模式判断
 */
let autoDarkMode = () => {
	if (document.cookie.replace(/(?:(?:^|.*;\s*)night\s*\=\s*([^;]*).*$)|^.*$/, "$1") === '') {
		if (new Date().getHours() > 22 || new Date().getHours() < 6) {
			document.querySelector('link[title="dark"]').disabled = true;
			document.querySelector('link[title="dark"]').disabled = false;
			document.cookie = "night=1;path=/";
		} else {
			document.cookie = "night=0;path=/";
		}
	} else {
		let night = document.cookie.replace(/(?:(?:^|.*;\s*)night\s*\=\s*([^;]*).*$)|^.*$/, "$1") || '0';
		if (night === '0') {
			document.querySelector('link[title="dark"]').disabled = true;
		} else if (night === '1') {
			document.querySelector('link[title="dark"]').disabled = true;
			document.querySelector('link[title="dark"]').disabled = false;
		}
	}
}

/**
 * toolbar按钮赋能
 */
let toolbarInit = () => {
	document.querySelector('#gototop').onclick = function(){
		console.log('yo');
		window.scroll({ top: 0, left: 0, behavior: 'smooth' });
	};
	document.querySelector('#darkmode').onclick = darkModeToggle;
};

/**
 * 表情控件开关
 */
let toggleOwO = () => {
	let OwOContainer = document.querySelector('#OwO-container');
	if(!OwOContainer.classList.contains('OwO-in') && !OwOContainer.classList.contains('OwO-out'))
		OwOContainer.classList.add('OwO-in');
	else
	{
		OwOContainer.classList.toggle('OwO-in');
		OwOContainer.classList.toggle('OwO-out');
	}
};

/**
 * 滑动OwO
 */
let slideOwO = (id) => {
	document.querySelector('#' + id).scrollIntoView({ behavior: 'smooth' });
};

/**
 * 表情配置
 */
Smilies = {
    dom: function(id) {
        return document.querySelector(id);
    },
    grin: function(tag) {
        tag = ' ' + tag + ' ';
        myField = this.dom("#comments-textarea");
        document.selection ? (myField.focus(), sel = document.selection.createRange(), sel.text = tag, myField.focus()) : this.insertTag(tag);
    },
    insertTag: function(tag) {
        myField = Smilies.dom("#comments-textarea");
        myField.selectionStart || myField.selectionStart === "0" ? (startPos = myField.selectionStart, endPos = myField.selectionEnd, cursorPos = startPos, myField.value = myField.value.substring(0, startPos) + tag + myField.value.substring(endPos, myField.value.length), cursorPos += tag.length, myField.focus(), myField.selectionStart = cursorPos, myField.selectionEnd = cursorPos) : (myField.value += tag, myField.focus());
    }
}

/**
 * 页面初始化
 */
let pageInit = () => {
	makePrismLineNum();
	let images = document.querySelectorAll('.PAP-content img');
	images.forEach(img=>{
		if(!img.classList.contains('bq')) {
			img.setAttribute("onclick", "lightbox(this)");
			let info = document.createElement('span');
			info.innerText = img.getAttribute('title');
			info.classList.add('imageinfo');
			img.after(info);
		}
	});
	makeGallery();
};

/**
 * lazyload加载
 */
let doLazyload = () => {
	let banners = document.getElementsByClassName("article-banner");
	let pics = document.getElementsByTagName("img");
	preLazy(banners, "style", "origin");
	preLazy(pics, "src", "origin", "https://cdn.jsdelivr.net/gh/youranreus/R@v1.2.6/G/IMG/loading2.gif");
	lazyload(banners, function (element, observe) {
		lazyBanner(element, observe);
	});
	lazyload(pics, function (element, observe) {
		lazyPic(element, observe);
	});
};

window.onload = function () {
	console.log("G.js onload");
	let pjax = new Pjax({
		elements: "a:not(a[target='_blank'], a[no-pjax])", // default is "a[href], form[action]"
		selectors: ["#main", "title"],
		timeout: 10000,
    	cacheBust: false,
    	scrollRestoration: true
	});
	pageInit();
	autoDarkMode();
	toolbarInit();
};

/**
 * pjax发送回调
 */
document.addEventListener('pjax:send', () => {
	if (typeof aplayers !== 'undefined') {
		for (let i = 0; i < aplayers.length; i++) {
			try {
				aplayers[i].destroy();
			} catch (e) {
				console.log(e);
			}
		}
	}
});

/**
 * pjax完成回调
 */
document.addEventListener('pjax:complete', () => {
	if (typeof Prism !== 'undefined') {
		Prism.highlightAll(true, null);
	};
	if (typeof (loadMeting) === "function") {
		loadMeting();
	};
	pageInit();
	doLazyload();
});

window.ready(function () {
	doLazyload();
});

window.onbeforeunload = function() {
	let main = document.querySelector('#container') || document.querySelector('.PAP') || document.querySelector('#Lyrics');
	if(main)
	{
		main.setAttribute('style','animation: opacity-out var(--theme-animation-out-duration, .2s) ease;opacity: 0;');
		let duration  = parseFloat(getComputedStyle(main).getPropertyValue('--theme-animation-out-duration'))*1000;
		setTimeout(function(){
			main.style.opacity = '0';
		}, duration);
	}
};
