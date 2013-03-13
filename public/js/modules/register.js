/**
 * @author linbin
 * The register module
 */
Core.registerModule("register", function(sb){
	var info_tit = null, info_con = null, info_con_contain = null, elements = {}, 
	subelems = ['midContent'], hlinks = document.getElementsByClassName('link'),
	savebutton = null, midcontent = null, datepicker = null, live_province = null
	live_city = null, live_area = null, home_province = null, home_city = null, home_area = null,
	province = null, city = null, area = null, save_button = null, result = null, inputs = null;
	
	return{
		init: function(){
			this.toggle();
			this.hover();
			 /**
			  * To return the elem id by link
			  * @param href
			  * @returns
			  */
			var getIdBylink = function(href){
			    	var number = href.indexOf('#'), size = href.length;
			    	return href.substring(number + 1, size);
			}, 
			/**
			 * The left side click function
			 * @param string target         The target element
			 * @param object elems           The elements
			 * @returns
			 */
		    left = function(target, elems){
		         var targetelem = elems[target];
		         for(var elem in elems){
		        	 var current = elems[elem];
		        	 if(elem !== target){
		        		 current.style.display = "none";
		        	 }
		         }
		         targetelem.style.display = "block";
		    };
			    
			// init the elements
			for(var i = 0, t; t = subelems[i]; i++){
				elements[t] = document.getElementById(t);
			}
			// 添加监听
			for(var i = 0, t; t = hlinks[i]; i++){
				t.onclick = function(event){
					var id = getIdBylink(event.target.href);
					left(id, elements);
				};
			}
			this.queue();
		},
		
		queue: function(){
			sb.queue({
			   fn: function(){
				   /**
				     * To create option document
				     */
				   var createOptions = function(arr, elem){
				    	 if(!arr || !elem){
				    		 alert("The arr and elem must be exsist!!");
				    	 }
				    	 var fragment = document.createDocumentFragment();
			        	 for(var i = 0, t; t = arr[i]; i++){
			        		 var op = document.createElement("option");
			        		 op.value = op.innerHTML = t;
			        		 fragment.appendChild(op);
			        	 }
			        	 elem.appendChild(fragment);
				   };
				   savebutton = document.getElementById('savebutton');
				   midcontent = document.getElementsByClassName('mid_content');
				   datepicker = $('#datepicker');
				   live_province = document.getElementById("live_prodvince");
				   live_city = document.getElementById("live_city");
				   live_area = document.getElementById("live_area");
				   home_province = document.getElementById("home_prodvince");
				   home_city = document.getElementById("home_city");
				   home_area = document.getElementById("home_area");
				   save_button = sb.find(".save-type");
				   inputs = document.getElementsByTagName('input');
				   
					// 添加修改按钮监听
				   if(savebutton){
						savebutton.onclick = function(){
							midcontent[0].style.display = 'none';
							midcontent[1].style.display = 'block';
						};
					}
				    if(datepicker){
				    	datepicker.datepicker({
				    	    showOn: "button",
				    		buttonImage: "image/calendar.gif",
				    		buttonImageOnly: true
				    	});
				    	datepicker.datepicker('option', 'dateFormat', 'yy-mm-dd');
				    }
				    
				    live_province.onclick = home_province.onclick = function(event){
				         if(!province){
				        	 // 省市联动
				        	 province = sb.getLocation("http://teacherw.sinaapp.com/js/location.json", 
					    		       {'location': '', 'type': 'province'});
				        	 createOptions(province, live_province);
				        	 createOptions(province, home_province);
				         }
				    };
				    
				    live_province.onchange = home_province.onchange = function(event){
				    	var value = event.target.value, sub = event.target.nextSibling.nextSibling;
				    	city = sb.getLocation("http://teacherw.sinaapp.com/js/location.json", 
				    		       {'location': value, 'type': 'city'});
				    	createOptions(city, sub);
				    };
				    
				    live_city.onchange = home_city.onchange = function(event){
				    	var value = event.target.value, sub = event.target.nextSibling.nextSibling;
				    	area = sb.getLocation("http://teacherw.sinaapp.com/js/location.json", 
				    		       {'location': value, 'type': 'area'});
				    	createOptions(area, sub);
				    };
				    // 添加保存提交
//				    if(save_button){
//				    	save_button.onclick = function(){
//				    		for(var i = 0, t;t = inputs[i]; i++){
//					        	alert(t.value);
//					        } 	
//				    	};
//				        
//				    }
			   },
			   time: 400
			});
		},
		
	    /**
	     * make the elements toggle
	     */
		toggle: function(){
			info_tit = $("#reel > .information > .info_tit > a");
			info_con = $("#reel > .information .info_con");
			info_con_contain = info_con.children().children();
			// listening the click event
			info_tit.click(function(){
				info_con.toggle("slow");
			});
		},
		
		hover: function(){
			// change the color and transition
			info_con_contain.hover(
				function(){
					var offsetParent = $(this).parent().parent(), parent = $(this).parent();
					offsetParent.addClass('left_bottom_right');
					offsetParent.addClass('left_bottom_color_right');
					parent.addClass('left_bottom_right');
					parent.addClass('left_bottom_move_right');
				},
				function(){
					var offsetParent = $(this).parent().parent(), parent = $(this).parent();
					offsetParent.removeClass('left_bottom_color_right');
					parent.removeClass('left_bottom_move_right');
					
					// remove the class
					setTimeout(function(){
						offsetParent.removeClass('left_bottom_right');
						parent.removeClass('left_bottom_right');
					},2000);
				}
			);
			window.scroll('scroll',['panel','dis']);
		},
		
		/**
		 * To get element value
		 * @param elem
		 * @returns
		 */
		getValue: function(elem){
		    return elem.value;
		}
	};
});
