/**
 *  @author linbin
 *  the index page main module
 */
Core.registerModule('indexmain', function(sb) {
	var scroll = null, plugins = null, nav_above = null, nav_below = null, pre_page = null, next_page = null,
	url = /\w+:\/\/[\w.]+\/main-news(\d+)\.html/, history = window.history;

	return {
		init : function() {

			var getPage = function() {
				var href = window.location.href, result = href.match(url),page;
				
				if (result != null) {
					page = result[1];
				} else {
					page = 1;
				}
				return page;
			}, prePage = function() {
				var page = parseInt(getPage()) + 1;
				
				// To put a history
				history.pushState('main','news',"http://teacherw.sinaapp.com/main-news" + page + ".html");
				ajaxRedirect(page);
				
			}, nextPage = function() {
				var page = parseInt(getPage()) - 1;
				history.pushState('main','news',"http://teacherw.sinaapp.com/main-news" + page + ".html");
				ajaxRedirect(page);
				
			}, ajaxRedirect = function(page){
				if(!page){
					alert("The page is not exsist!!");
				}
				var url = "main/page?page=" + page;
				sb.ajax({
					'type' : 'GET',
					'url' : url,
					'success' : function(data) {
					   var arr = JSON.parse(data);
					   //
					}
				});
			};

			
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
