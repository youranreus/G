window.ready = function (fn) {
	if (document.addEventListener)
		document.addEventListener("DOMContentLoaded", fn, false);
	else IEContentLoaded(fn);

	function IEContentLoaded(fn) {
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
				d.documentElement.doScroll("left");
			} catch (e) {
				setTimeout(arguments.callee, 50);
				return;
			}
			init();
		})();

		d.onreadystatechange = function () {
			if (d.readyState == "complete") {
				d.onreadystatechange = null;
				init();
			}
		};
	}
};

/**
 * 查询元素是否含某类
 *
 * @param {object} element 元素
 * @param {string} classname 查询类名
 * @returns {boolean}
 */
let hasClass = (element, classname) => {
	return element.classList.contains(classname);
};

/**
 * 为元素添加类
 * 
 * @param {object} element 元素
 * @param {string} classname 类名
 */
let addClass = (element, classname) => {
	element.classList.add(classname);
};

/**
 * 为元素移除类
 * 
 * @param {object} element 元素
 * @param {string} classname 类名
 */
let removeClass = (element, classname)=>{
	element.classList.remove(classname);
}

/**
 * 收合动画
 * modified from https://css-tricks.com/using-css-transitions-auto-dimensions/
 * 
 * @param {object} element 元素
 */
function collapseSection(element) {
	let sectionHeight = element.scrollHeight;
	let elementTransition = element.style.transition;
	element.style.transition = '';
	
	requestAnimationFrame(function() {
	  element.style.height = sectionHeight + 'px';
	  element.style.transition = elementTransition;
	  
	  requestAnimationFrame(function() {
		element.style.height = 0 + 'px';
	  });
	});
}

/**
 * 扩张动画
 * 
 * @param {object} element 元素
 */
 function expandSection(element) {
	let sectionHeight = element.scrollHeight;
	element.style.height = sectionHeight + 'px';
	element.addEventListener('transitionend', function(e) {
	  element.removeEventListener('transitionend', arguments.callee);
	});
  }
