let makePrismLineNum = () => {
	let ele = document.getElementsByTagName("pre");
	if (ele.length > 0)
		for (let element of ele)
			element.className = element.className + " line-numbers";
	Prism.highlightAll();
};

let lazyBanner = () => {
	let ele = document.getElementsByClassName("article-banner");
	if (ele.length > 0) {
		for (let element of ele) {
			element.setAttribute("origin", element.getAttribute("style"));
			element.setAttribute("style", " ");
		}

		let imgs = [...document.getElementsByClassName("article-banner")];
		const observe = new IntersectionObserver((entries) => {
			for (let element of entries) {
				if (element.isIntersecting) {
					let data_src = element.target.getAttribute("origin");
					new Promise((rs,rj)=>{
						let image = new Image();
						image.src = data_src.slice(22,-2);
						image.onload = function(){
							rs(data_src.slice(22,-2))
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

function myReady(fn){
    if ( document.addEventListener ) 
        document.addEventListener("DOMContentLoaded", fn, false);
	else 
        IEContentLoaded(fn);
	
    function IEContentLoaded (fn) {
        let d = window.document;
        let done = false;

        let init = function () {
            if (!done) {
                done = true;
                fn();
            }
        };

        (function () {
            try {
                d.documentElement.doScroll('left');
            } catch (e) {
                setTimeout(arguments.callee, 50);
                return;
            }
            init();
        })();

        d.onreadystatechange = function() {
            if (d.readyState == 'complete') {
                d.onreadystatechange = null;
                init();
            }
        }
    }
}

window.onload = function () {
	console.log("G.js onload");
	makePrismLineNum();
};

myReady(lazyBanner);
