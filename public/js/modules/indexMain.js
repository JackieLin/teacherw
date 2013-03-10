/**
 *  @author linbin
 *  the index page main module
 */
Core.registerModule('indexmain', function(sb) {
	var scroll = null, plugins = null, nav_above = null, nav_below = null, pre_page = null, next_page = null,
	url = /\w+:\/\/[\w.]+\/main-news(\d+)\.html/, history = window.history,
	artiles = document.getElementsByClassName('articles');

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
			}, prePage = function(pre,next) {
				var page = parseInt(getPage()) + 1;
				
				// To put a history
				history.pushState('main','news',"http://teacherw.sinaapp.com/main-news" + page + ".html");
				ajaxRedirect(page, pre,next);
				
			}, nextPage = function(page,pre,next) {
				history.pushState('main','news',"http://teacherw.sinaapp.com/main-news" + page + ".html");
				ajaxRedirect(page,pre,next);
				
			}, ajaxRedirect = function(page,pre,next){
				if(!page || !pre || !next){
					alert("The page or target is not exsist!!");
				}
				var url = "main/page?page=" + page;
				sb.ajax({
					'type' : 'GET',
					'url' : url,
					'success' : function(data) {
					   var arr,tag = data.indexOf('nodisplay'),length;
					   if(tag > 0){
						   data = data.substring(0,tag);
						   pre.style.display = "none";
						   next.style.display = "none";
					   }
					   arr = JSON.parse(data);
					   length = arr.length;
					   for(var i = 0,t; t = arr[i]; i++){
						   var artile = artiles[i], children = artile.children, title = t['title'],
						   content = t['content'], num = t['commNum'], ar_url = "article-" + t['id'] + ".html",
						   ar_comm = ar_url + "#comment", display = artile.style.display;
						   // 数据库不足时删除节点
						   if(length < 5){
							   for(var j = length,q; q = artiles[j]; j++){
								   q.style.display = "none";
							   }
						   }
						   
						   if(length === 5 && display === "none"){
						       artile.style.display = "block";
						   }
						   
						   children[0].innerHTML = 
							   "<a href='"+ ar_url +"' style='color: #000;text-decoration: none;'>" +title + "</a>";
						   children[1].innerHTML = content;
						   children[2].innerHTML =
							   "<a href='"+ ar_comm +"' style='color: hsl(206, 79%, 46%);'> <span>评论"+ num +"</span> </a>";
					   }
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
						var pre = pre_page[i], next = next_page[i], page = parseInt(getPage()),
						next_style = next.style.display;
						if(page !== 1){
							next.style.display = "block";
						} 
						
						if(!pre.onclick || !next.onclick){
						    pre.onclick = function(event){
						    	if(next_style === 'none'){
						    		next_page[0].style.display = "block";
						    		next_page[1].style.display = "block";
						    	}
						    	prePage(pre_page[0],pre_page[1]);
						    };
						    next.onclick = function(event){
						    	var page = parseInt(getPage()) - 1,pre_display = pre.style.display;
						    	if(pre_display === "none"){
						    	   // 显示向前链接
						    		pre_page[0].style.display = "block";
						    		pre_page[1].style.display = "block";
						    	}
						    	
								if(page === 0){
									next_page[0].style.display = "none";
						    		next_page[1].style.display = "none";
									return;
								}
						    	nextPage(page,pre_page[0],pre_page[1]);
						    };
						}
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
