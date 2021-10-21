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
