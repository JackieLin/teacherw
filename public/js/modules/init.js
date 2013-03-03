/**
 * the login main module
 * sb container
 */
Core.registerModule("Content", function(sb) {
	var mainContent = null, container = sb.container, pageTransition = ["pop", "fade", "moveleft", "movedown", "spin"];
	return {
		init : function() {
			mainContent = contents.content;
			this.animate();
		},

		destory : function() {
			// 析构函数
			mainContent = null;
			container = null;
		},
		
		animate : function() {
			// 初始化时动画
			var pageTransitionCls = "main_content_out_" + pageTransition[parseInt(Math.random() * pageTransition.length)];
			sb.addClass(container, "main_content_out");
			sb.addClass(container, pageTransitionCls);
            //sb.removeClass(container, "main_content_out");
			sb.queue({
                fn : function () {
                	sb.removeClass(container, "main_content_out");
                    sb.removeClass(container, pageTransitionCls);
                    sb.addClass(container, "main_content_in");
                },
                time : 100
			},{
				fn : function (){
					//alert(mainContent.innerHTML);
					container.appendChild(mainContent);
					// 添加验证码的点击事件
					var imageChange = document.getElementById('imagechange'), checkImage = document.getElementById("checkimage"),
					    logButton = document.getElementsByClassName('submit-type'), divs = [],checkInit = sb.find('.check_init'),
					    /**
					     * @returns cDiv array the array that warn user
					     */
					    check = function() {
							var inputs = document.getElementsByTagName('input'),  cDiv = [];
							//init
							checkInit.onfocus = function(){
								if(checkInit.value === '学号/昵称'){
									checkInit.value = '';
									sb.removeClass(checkInit,'check_init');
								}
							}
							
							for(var i = 0,t;t = inputs[i];i++){
								var type = t.type, name = t.name;
								if(type === 'text' || type === 'password'){
									cDiv[name] = t.nextSibling.nextSibling;
									// onblur event
									t.onblur = function(event){
										var value = event.srcElement.value, name = event.srcElement.name;
										if(value === ""){
											cDiv[name].style.display = "block";
										}else{
											cDiv[name].style.display = "none";
										}
									}
								}
							}
							return cDiv;
						},
						/**
						 * @param divs array the elem that warn user
						 * @returns result
						 */
						postData = function(divs){
                            var input = document.getElementsByTagName("input"), result = "";
							for(var j = 0,k; k = input[j]; j++){
								var type = k.type, value = k.value, name = k.name;
							    if(type === 'text' || type === 'password'){
									// check
									if(value === "" || value === '学号/昵称'){
										result = "";
										divs[name].style.display = "block";
										return result;
									}else{
										divs[name].style.display = "none";
										result += k.name + "=" + value + "&";
									}
							    }
							}
							result = result.substring(0,result.length - 1);
							return result;
						},
						
						/**
						 * @param circles array
						 */
						triggerCircles = function(circles){
							for(var i = 0,t; t = circles[i]; i++){
								var display = t.style.display;
								if(display === 'none'){
									t.style.display = 'block';
								}else{
									t.style.display = 'none';
								}
							}
						};
	
					if(imageChange && checkImage){
						imageChange.onclick = function() {
							sb.ajax({
								'type' : 'GET',
								'url' : 'index/code',
								'success' : function(data) {
									checkImage.src = data + ".png";
								}
							})
						};
					}
					// 用户点击事件
					if(logButton){
						divs = check();
						for(var i = 0,t; t = logButton[i];i++) {
							    t.onclick = function(){
							    	    var result = postData(divs), circles = document.getElementsByClassName('circle');
							    	    if(result === ""){
							    	    	return;
							    	    }else{
							    	    	// show the circles
							    	    	triggerCircles(circles);
											sb.ajax({
												'type' : 'POST',
												'url' : 'index/login',
												'postdata' : result,
												'success' : function(data) {
													triggerCircles(circles);
													if(data === 'success'){
														// To main page
														location.href = 'main/main';
													}else{
														alert(data);
													}
//													message = document.getElementById('message');
//													message.innerHTML = data;
												}
			 								});
	//	    								logForm.action = "index/login";
	//										logForm.submit();
							    	    }
							    }
							}	
					}
				}
			},{
				fn : function () {
					sb.removeClass(container,"main_content_in");
				},
				time : 200
			});
		}
	};
});
