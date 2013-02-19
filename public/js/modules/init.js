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
