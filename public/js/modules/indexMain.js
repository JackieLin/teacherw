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
			}, 
			// 根据类型转换div的内容
			// types array id类型列表
			toggleType = function(types){
				if(!types){
					alert("The types must be exsist and an array!!");
					return;
				}
				var url = location.search, type = url.substring(url.indexOf('type') + 5);
				if(type){
					for(var i = 0, t; t = types[i]; i++){
						if(t === type){
							document.getElementById(t).style.display = 'block';
						} else {
							document.getElementById(t).style.display = 'none';
						}
					}
				} else {
					// main.html 时显示
					for (var i = 0, t; t = types[i]; i++) {
						(t === 'middle_content') ? (document.getElementById(t).style.display = 'block') 
								: (document.getElementById(t).style.display = 'none');
					}
				}
			},
		    parsesting = function(str){
				if(!str){
					alert("The str param must be exsist!!");
				}
				result = {};
				// /([^&]*)&nbsp;+排名:([^<]*)/i
				var name = /([^&]*)&nbsp;+/i, row = /([^<:]*)</i 
				var projectname = str.match(name), projectrow = str.match(row);
				if(projectname && projectrow){
					result['name'] = projectname[1];
					result['row'] = projectrow[1];
				}
				return result;
			};

			
			sb.queue({
				fn : function() {
					// 在主页中切换页面
					toggleType(['middle_content', 'teach', 'educate', 'teachnology', 'generation']);
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
					// 对teach模块的操作
				    var teachedit = document.getElementsByClassName('teach_edit'),
				    content_id = document.getElementById('content_id'), projectname = document.getElementById('projectname'), 
				    projectrow = document.getElementById('projectrow'), teach_edit = null, teach_div = null,
				    addupdate = document.getElementById("addupdate"), teachcontent = null, 
				    save = document.getElementsByClassName('save-type')[0], 
				    cancel = document.getElementsByClassName('cancel-type')[0], substring = null;
				    
				    // 对teach以及teachno模块的增加操作
				    var teachadd = document.getElementsByClassName('teach_add'), hassubchild = document.getElementById('hassubchildren'),
				    userid = document.getElementById('userid'), add_child = null, add_contentid = null,
				    add_user = null, teachdis = document.getElementById('teach').style.display, 
				    teachnodis = document.getElementById('teachnology').style.display;
				    
				    cancel.onclick = function(){
				    	addupdate.style.display = "none";
				    };
				    
				    save.onclick = function(){
				    	var proname = 'name=' + projectname.value,
					       prorow = 'condition=' + projectrow.value,
					       contentid = 'content_id=' + content_id.innerHTML,
					       uservalue = userid.innerHTML,
					       url = null,
					       substring = proname + "&" + prorow + "&" + contentid, 
					       user_id = null, hassubparent = null ;
				    	
				    	(teachdis === 'none') ? 
						         (url = (uservalue) ? 'main/addteachno' : 'main/updateteachno') : 
						         (url = (uservalue) ? 'main/addteach' : 'main/updateteach');
						
				        if(uservalue){
				        	 user_id = "user_id=" + userid.innerHTML;
				        	 
				        	 (teachdis === 'none') ? 
				        	   "" : (hassubparent = "hassubparent=" + hassubchild.innerHTML);
				        	 
				        	 (teachdis === 'none') ? 
				        	  (substring += "&" + user_id): (substring += "&" + user_id + "&" + hassubparent);
				        	  alert(url);
				        }
				       	// 编辑页面
						sb.ajax({
						   'type' : 'POST',
						   'url' : url,
						   'postdata' : substring,
						   'success' : function(data) {
						    	alert(data);
								if(data === '插入数据成功' || data === '更新数据成功'){
									(teachdis === 'none') ? 
						    	 	 (location.href = "main.html?type=teachnology"): (location.href = "main.html?type=teach");
							    }
						   }
						});
				    };
				    
				    // 监听编辑点击操作
				    for(var i = 0, t; t = teachedit[i]; i++){
				    	var child = t.children;
				    	teach_edit = child[0];
				    	
				    	teach_edit.onclick = function(event){
				    		var t = event.currentTarget;
				    		teach_div = t.nextSibling.nextSibling;
				    	   	content_id.innerHTML = teach_div.innerHTML;
				    	   	
				    	   	teachcontent = t.parentNode.innerHTML;
				    	   	var obj = parsesting(teachcontent);
				    	   	
				    	   	if(obj['name']){
				    	   		projectname.value = obj['name'];
				    	   		projectrow.value = obj['row'];
				    	   		// 清空userid的内容
				    	   		userid.innerHTML = "";
				    	   	}
				    	   	addupdate.style.display = 'block';
				    	};
				    }
				    
				    // 编辑添加按钮操作
				    for(var i = 0, t; t = teachadd[i]; i++){
				    	t.onclick = function(event){
				    		// 初始化值
				    		var t = event.currentTarget;
				    		add_user = t.previousSibling.previousSibling;
					    	add_contentid = add_user.previousSibling.previousSibling;
					    	
					    	(teachdis == 'none') ? 
					    	  '' : (add_child = add_contentid.previousSibling.previousSibling.innerHTML);
					    	
					    	add_user = add_user.innerHTML;
					    	add_contentid = add_contentid.innerHTML;
					    	
				    		addupdate.style.display = 'block';
				    		(teachdis == 'none') ? '' : (hassubchild.innerHTML = add_child);
				    		userid.innerHTML = add_user;
				    		content_id.innerHTML = add_contentid;
				    	};
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
