/**
 * @author linbin
 * The register module
 */
Core.registerModule("register", function(sb){
	var info_tit = null, info_con = null, info_con_contain = null;
	return{
		init: function(){
			info_tit = $("#reel > .information > .info_tit > a");
			info_con = $("#reel > .information .info_con");
			info_con_contain = info_con.children().children();
			// listening the click event
			info_tit.click(function(){
				info_con.toggle("slow");
			});
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
		}
	}
});
