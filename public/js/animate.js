/**
 * @author linbin
 * Index liader to run
 */
(function() {
	var dataElem = document.getElementById("page_data"), main = document.getElementById("Content"), background = document.getElementById("background");
	var contents = {
		content : dataElem
	};

	/**
	 * The fuction that change the style
	 * @param {String} id
	 *                 The element id
	 * @param {Array} clses
	 *                 clses {cls1: string cls2 string}
	 */
	window.scroll = function(id, clses) {
		if (!( clses instanceof Array)) {
			alert("Scroll: the clesses must be array");
		}
		if (clses.length !== 2) {
			alert("Scroll: the class length must be 2");
		}
		var cls1 = clses[0], cls2 = clses[1], j_scroll = eval("$('#" + id + "')");
		if (j_scroll.length > 0) {
			var scroll_top = j_scroll.offset().top;

			$(document).scroll(function() {
				var top = $(this).scrollTop();
				if (top > scroll_top) {
					j_scroll.addClass(cls1);
					j_scroll.removeClass(cls2);
				} else {
					j_scroll.addClass(cls2);
					j_scroll.removeClass(cls1);
				}
			});
		}
	}
	
	// 随机焕肤
	var backgrounds = ['lake', 'brazil', 'boats', 'land'], bgImg = backgrounds[parseInt(Math.random() * backgrounds.length)];
	var image = background.childNodes[1];

	image.src = "./image/theme/" + bgImg + ".jpg";
	// 删除待转换节点
	main.removeChild(dataElem);
	window.contents = contents;
	Core.startAll();
})();
