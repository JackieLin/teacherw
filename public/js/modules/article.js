
Core.registerModule('article', function(sb){
	var article_tran = document.querySelector('.article_tran'), tran_text = article_tran.children, 
	tran_time = tran_text[1].value, tran_con = tran_text[0], date = new Date(), 
	comment_top = document.getElementsByClassName('commit_content_top'), top_children = null, top_span = null,
	top_input = null, commentform = document.getElementById("commentform"), button = document.getElementById("addcomment"),
	text = document.getElementById("text");
	
	return{
		init: function(){
			var now = parseInt(date.getTime()/1000);
			tran_con.innerHTML = this.setTime(tran_time, now);
			
			if(comment_top){
				for(var i = 0, comm; comm = comment_top[i]; i++){
					top_children = comm.children;
					top_span = top_children[1];
					top_input = top_children[2].value;
					top_span.innerHTML = this.setTime(top_input, now);
				}
			}
			
			// 添加点击事件
			button.onclick = function(){
				if(!text.value){
					alert("You should be input something");
					return;
				}
				commentform.action = 'main/addcomment';
				commentform.submit();
			}
		},
		
		/**
		 * @param time   The time update
		 * @param now    The time now
		 * @returns
		 */
		setTime: function(time, now){
			var gap = now - time, day_gap = 3600*24, temp = parseInt(gap/day_gap);
			return temp + " days ago";
		}
	};
});