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
					    message = sb.find('.message'), registerButton = document.getElementsByClassName('register-type'),
					    ch_email = /^[^\.@]+@([^\.@]+\.){1,}[a-z]+$/, ch_number = /^\d+$/g,
					    /**
					     * @returns cDiv array the array that warn user
					     */
					    check = function(check_display) {
							var inputs = document.getElementsByTagName('input'),  cDiv = [];
							//init
							if(checkInit){
								checkInit.onfocus = function(){
									if(checkInit.value === '学号/昵称'){
										checkInit.value = '';
										sb.removeClass(checkInit,'check_init');
									}
								}
							}
							
							for(var i = 0,t;t = inputs[i];i++){
								var type = t.type, name = t.name;
								if(type === 'text' || type === 'password'){
									cDiv[name] = t.nextSibling.nextSibling;
									// onblur event
									t.onblur = function(event){
										var value = event.currentTarget.value, name = event.currentTarget.name;
										if(value === ""){
											cDiv[name].style.display = check_display;
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
									} else{
										divs[name].style.display = "none";
										result += k.name + "=" + value + "&";
									}
							    } else if(type === 'checkbox'){
							    	var checked = k.checked;
							        if(checked){
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
					
					if(message){
						var hash = location.hash,result = hash.substring(1),num = result.indexOf("="),
						param = result.substring(num + 1, result.length);
						if(param === 'nologin'){
							message.style.display = "block";
						}
						
					}
					
					// 处理用户注册提交
					if(registerButton && registerButton.length !== 0){
						divs = check('inline');
						var inputObj = document.getElementsByTagName('input'), email, number;
						
						for(var i = 0,t;t = registerButton[i];i++){
							t.onclick = function(){
								// 验证邮箱以及学号的正确性
								email = inputObj[4].value.match(ch_email);
								number = inputObj[0].value.match(ch_number);
								if(!email){
									alert("邮箱格式有误,请重新输入!!");
									return;
								}
								if(!number){
									alert("学号应该全部是数字!!");
									return;
								}
								var result = postData(divs),circles = document.getElementsByClassName('circle');
								triggerCircles(circles);
								// 提交数据
								sb.ajax({
									'type' : 'POST',
									'url'  : 'register/registercomm',
									'postdata' : result,
									'success' : function(data){
										triggerCircles(circles);
										if(data === 'userexsist'){
											alert("用户已存在,请用不同的学号重新注册");
										}else if(data === "senderror"){
											alert("邮件发送错误");
										}else{
											alert("验证邮件已发到对应邮箱,请到对应的邮箱确认");
											location.href = "index.html";
										}
									}
								});
							}
						}
					}
					
					// 用户登录点击事件
					if(logButton && logButton.length !== 0){
						divs = check('block');
						var arr = sb.getcookie('user'), filter = /\W+(\w+)\W+/, result = [], 
						inputs = document.getElementsByTagName('input'), elems = [inputs[0], inputs[1]], temp;
						// 如果cookie存在,添加cookie
						if(!arr[elems[0].name]){
	                        for(var str in arr){
	                           	temp = str.match(filter);
	                           	result[temp[1]] = arr[str];
	                        }	
	                    }
						if(result[elems[0].name]){
	                        sb.fillFrom(result, elems);
						}
                        
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
														location.href = 'main.html';
													}else{
														alert(data);
													}
												}
			 								});
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
