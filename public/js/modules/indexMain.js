/**
 *  @author linbin
 *  the index page main module
 */
Core.registerModule('indexmain', function(sb) {
	var scroll = null, plugins = null, nav_above = null, nav_below = null, pre_page = null, next_page = null;

	return {
		init : function() {

			var getPage = function() {
				var hash = location.hash, params;
				if (hash.length > 1) {
					hash = hash.substring(1);
					params = hash.split('&');
					for (var i = 0, param; param = params[i]; i++) {
						param = param.split('=');
						var key = param[0], value = param[1];

						if (key === 'page') {
							return parseInt(value);
						}
					}
				}
				return 1;
			}, prePage = function() {
				var page = getPage();
				location.hash = "#page=" + (page + 1);
			}, nextPage = function() {
				var page = getPage();
				location.hash = "#page=" + (page - 1);
			};

			window.onhashchange = function() {

			}
			sb.queue({
				fn : function() {
					scroll = document.getElementById("scroll");
					plugins = $("#plugs");
					window.scroll('scroll', ['panel', 'dis']);
					// 换页
					pre_page = document.getElementsByClassName('pre_page');
					next_page = document.getElementsByClassName('next_page');
					for (var i = 0; i < pre_page.length; i++) {
						var pre = pre_page[i], next = next_page[i];
						pre.onclick = prePage;
						next.onclick = nextPage;
					}
					// 添加插件
					var child = plugins.children();

					for (var i = 0, t; t = child[i]; i++) {
						var id = child[i].id, objs = "$('#" + id + "')." + id + "()";
						sb.eval(objs);
					}
				},
				time : 400
			});
		},

		destory : function() {
			scroll = null;
			plugins = null;
		}
	}

});
