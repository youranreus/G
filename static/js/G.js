window.onload = function () {
	console.log("G.js onload");
	makePrismLineNum();
};

let makePrismLineNum = () => {
	let ele = document.getElementsByTagName("pre");
	if (ele.length > 0)
		for (let element of ele)
			element.className = element.className + " line-numbers";
    Prism.highlightAll();
};
