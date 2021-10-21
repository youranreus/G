let makePrismLineNum = () => {
	let ele = document.getElementsByTagName("pre");
	if (ele.length > 0)
		for (let element of ele)
			element.className = element.className + " line-numbers";
	Prism.highlightAll();
};

//将ele元素集合的attribute属性转移至origin属性
let preLazy = (ele, attribute, origin) => {
	for (let element of ele) {
		element.setAttribute(origin, element.getAttribute(attribute));
		element.setAttribute(attribute, " ");
	}
};

let lazyBanner = (element, observe) => {
	let data_src = element.target.getAttribute("origin");
	new Promise((rs, rj) => {
		let image = new Image();
		image.src = data_src.slice(22, -2);
		image.onload = function () {
			rs(data_src.slice(22, -2));
		};
	}).then((success) => {
		console.log(success, "加载完成");
		element.target.setAttribute(
			"style",
			data_src + "visibility: visible;animation: banner-show 1s;"
		);
		observe.unobserve(element.target);
	});
};

let lazyload = (ele, fn) => {
	if (ele.length > 0) {
		const observe = new IntersectionObserver((entries) => {
			for (let element of entries) 
				if (element.isIntersecting) 
					fn(element, observe);
		});

		for (let item of ele) {
			observe.observe(item);
		}
	}
};

window.onload = function () {
	console.log("G.js onload");
	makePrismLineNum();
};

window.ready(function () {
	let banners = document.getElementsByClassName("article-banner");
	preLazy(banners,"style","origin");
	lazyload(banners, function(element, observe) {
		lazyBanner(element, observe);
	});
});
