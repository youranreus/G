let makePrismLineNum = () => {
	let ele = document.getElementsByTagName("pre");
	if (ele.length > 0)
		for (let element of ele)
			element.className = element.className + " line-numbers";
	Prism.highlightAll();
};

//将ele元素集合的attribute属性移动至origin属性
let preLazy = (ele, attribute, origin) => {
	for (let element of ele) {
		element.setAttribute(origin, element.getAttribute(attribute));
		element.setAttribute(attribute, " ");
	}
};

let lazyBanner = () => {
	let ele = document.getElementsByClassName("article-banner");
	if (ele.length > 0) {
		let imgs = [...document.getElementsByClassName("article-banner")];
		const observe = new IntersectionObserver((entries) => {
			for (let element of entries) {
				if (element.isIntersecting) {
					let data_src = element.target.getAttribute("origin");
					new Promise((rs,rj)=>{
						let image = new Image();
						image.src = data_src.slice(22,-2);
						image.onload = function(){
							rs(data_src.slice(22,-2));
						};
					}).then((success)=>{
						console.log(success , '加载完成');
						element.target.setAttribute("style",data_src + "visibility: visible;animation: banner-show 1s;");
						observe.unobserve(element.target);
					});
				}
			}
		});

		for (let img of imgs) {
			observe.observe(img);
		}
	}
};

window.onload = function () {
	console.log("G.js onload");
	makePrismLineNum();
	lazyBanner();
};

window.ready(function() {
	preLazy(document.getElementsByClassName("article-banner"), "style", "origin");
});
