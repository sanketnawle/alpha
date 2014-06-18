$(document).ready(function() {


	$(document).delegate(".post_functions_showr","click",function(){
		if($(this).closest(".post_functions").hasClass("functions_active")){
			$(this).closest(".post_functions").find(".post_functions_box").hide();
			$(this).closest(".post_functions").removeClass("functions_active");
		}else{
		$(this).closest(".post_functions").find(".post_functions_box").show();
		$(this).closest(".post_functions").addClass("functions_active");
		}
	});




	$(document).delegate(".form-control","focus",function(){
		$(this).css({"height":"53px","width":"93.82%","margin-left":"6px","margin-top":"41px","border-radius":"4px"});
		$(this).closest(".reply_tawrapper").closest(".commentform").css("height","96px");
		$(this).closest(".commentform").find(".reply_user_icon").hide();
		$(this).closest(".commentform").find(".reply_functions").show();
		$(this).closest(".reply_tawrapper").find(".reply_attach").css({"margin-top":"-31px","margin-right":"82px"});
	});

	$(document).delegate(".flat7b","click",function(event){
		//alert("a");
		//event.preventDefault();
		//alert($(this).attr("id"));
		if(!$(this).hasClass("flat_checked")){
		$(this).css({"border":"1px solid #00A076","background-color":"#02e2a7"});
		$(this).closest(".check_wrap").find(".move").css({"margin-left":"18px"});
		$(this).addClass("flat_checked");
		$(this).closest(".check_wrap").find(".comment_anon_text").css("color","rgba(33,33,33,.85)");
		}else{
		$(this).css({"border":"1px solid #C9C9C9","background-color":"#f5f5f5"});
		$(this).closest(".check_wrap").find(".move").css({"margin-left":"0px"});
		$(this).removeClass("flat_checked");
		$(this).closest(".check_wrap").find(".comment_anon_text").css("color","rgba(153, 153, 153, 0.64)");

		}
	});

	$(document).delegate(".post_comment_btn","click",function(){
		$(this).closest(".posts").find(".form-control").focus();
	});





				var load='yes';
				var feeds = $("#posts");
				var last_time = 0;
				var heightOffset= 0;
				//var commentUpdatePeriod=3000;
				//var commentUpdateFlag=1;

				setInterval(function() {latest_feed(); }, 1000);
				//setInterval(function() {commentUpdateFlag_mutate(); }, commentUpdatePeriod);

				$(document).delegate('.post_functions',"click", function(){
					$(this).find('.post_functions_box').show();
					$(this).addClass('functions_active');
				});

				$(document).delegate('.functions_active',"click", function(){

						//ajax add here

						//appearance change when click
						$(this).find('.post_functions_box').hide();
						$(this).removeClass('functions_active');
					});

				$(window).scroll(function(){
					if (load == 'yes'){
						if($(window).scrollTop()+heightOffset >= $(document).height() - $(window).height()){
							load = 'no';
							var last_time = $("#posts").children().last().attr('id');
							// var latest = feeds.children().first().attr('id');

							//alert(last_time);
							var pullrequest = $.ajax({
            					type: "POST",
            					url: "includes/oldfeed.php",
            					cache: false,
            					data: {last_time: last_time},
            					datatype: "html"
        					});
							// alert(last_time);
        					pullrequest.done(function( html ){
        						$("#posts").last().append( html );
        					});

        					load = 'yes';
						}
					}
				});


				$(document).delegate('.submit',"click", function(){
					var $owner= $(this).closest(".posts");
					//commentUpdateFlag=0;
					var commentid= $owner.find(".comments .post_comment").last().attr("id");
					var postid= $owner.attr("id");
					var commentcontent= $owner.find(".postval").val().trim();

					//alert(commentid);
					//alert(postid);
					//the proof of successfully getting ids
					//alert(commentid+", "+postid+", "+commentcontent);
					if(commentcontent!=""){
					$.ajax({
	            			type: "POST",
            				url: "includes/updatecomments.php",
            				data: {postid: postid, commentid: commentid, commentcontent: commentcontent},
            				success: function(html){ 
            					//alert("sad");
	                			$owner.find(".comments").last().append(html);
	                			$owner.find(".postval").val("");
			            	}
						});
						}
				});

				/*
				$(document).delegate('.posts',"mouseover", function(){
					if(commentUpdateFlag==1){
					var $owner= $(this).closest(".posts");
					var commentid= $owner.find(".comments .post_comment").last().attr("id");
					var postid= $owner.attr("id");

					$.ajax({
	            			type: "POST",
            				url: "includes/updatecomments.php",
            				data: {postid: postid, commentid: commentid},
            				success: function(html){ 
            					//alert(commentid);
	                			$owner.find(".comments").last().append(html);
			            	}
						});
					}
				});	
				*/

				$(document).click(function(event){
			     	var $target= $(event.target);

			     	//click outside hide event
			     	var $container= $(".post_functions");
			     	if(!$container.is($target)&&($container.has($target).length===0)){
			     		$(".post_functions_box").stop().hide();
			     		$(".post_functions").removeClass('functions_active');
			     	}

				});


				//comment like
				$(document).delegate('.comment_like img',"click", function(){

					var replyid= $(this).closest(".post_comment").find(".comment_msg").attr("id"); 

					var lk= $(this).closest(".post_comment").find(".comment_like_number");
					var afterlike= lk.text().trim();
					if(afterlike==''){afterlike=0;}else{afterlike=parseInt(afterlike);}
					addlike=afterlike+1;
					minuslike=afterlike-1;
					if(minuslike=='0'){minuslike=' ';}

					if($(this).hasClass("-liked")){
						//de-like
						$(this).attr("src","src/like-button.png");
						$(this).removeClass("-liked");

						$.ajax({
	            			type: "POST",
            				url: "includes/feedops.php",
            				data: {replyid: replyid, unlike: 1},
            				success: function(html){ 
	                			//alert(minuslike);
	                			lk.text(minuslike);
			            	}
						});

					}else{
						//like
						$(this).attr("src","src/liked-button.png");
						$(this).addClass("-liked");

						$.ajax({
	            			type: "POST",
            				url: "includes/feedops.php",
            				data: {replyid: replyid, like: 1},
            				success: function(html){ 
            					//alert(replyid);
	                			//alert(addlike);
	                			lk.text(addlike);
			            	}
						});

					}
				});
/*
	$(document).delegate(".post_like","click",function(){
		
			$(this).addClass("post_liked")
			$(this).find(".post_like_icon").css({"background":"center center no-repeat url(src/liked-button.png)","background-size":"cover"});
			$(this).find(".like_number").css("color","white");
	});
*/
				//post like
				$(document).delegate('.post_like',"click", function(){
					var postid= $(this).closest(".posts").attr("id"); 
					//alert("b");
					var lk= $(this).find(".like_number");
					var afterlike= lk.text().trim();
					if(afterlike==''){afterlike=0;}else{afterlike=parseInt(afterlike);}
					addlike=afterlike+1;
					minuslike=afterlike-1;
					if(minuslike=='0'){minuslike=' ';}
					
					//alert(postid);

					if($(this).hasClass("post_liked")){
						//de-like
						$(this).removeClass("post_liked");
						$(this).find(".post_like_icon").attr("src","src/liking-button.png");
						$(this).find(".like_number").css("color","white");
						

						$.ajax({
	            			type: "POST",
            				url: "includes/feedops.php",
            				data: {postid: postid, unlike: 1},
            				success: function(html){ 
	                			//alert(minuslike);
	                			lk.text(minuslike);
			            	}
						});

					}else{
						//like
						//alert("a");
						$(this).find(".post_like_icon").attr("src","src/liked-button.png");
						$(this).find(".like_number").css("color","white");
						$(this).addClass("post_liked");
						/*
						$.ajax({
	            			type: "POST",
            				url: "includes/feedops.php",
            				data: {postid: postid, like: 1},
            				success: function(html){ 
	                			//alert("success");
	                			lk.text(addlike);
			            	}
						});
						*/
					}
				});

				$(document).delegate('.post_like',"mouseover", function(){

					if($(this).hasClass("post_liked")){

					$(this).attr("src","src/liked-button.png");
					}else{
						
					$(this).find(".post_like_icon").attr("src","src/liking-button.png");	
					$(this).find(".like_number").css({"color":"white"});
					}

					$(this).closest(".post_lc").find(".card-tag").stop().show();
				});

				$(document).delegate('.post_lc .card-tag',"mouseover", function(){
					$(this).stop().show();
				});

				$(document).delegate('.post_like',"mouseout", function(){
					if($(this).hasClass("post_liked")){
					$(this).attr("src","src/like-button.png");
					}else{
					$(this).find(".post_like_icon").attr("src","src/like-button.png");
					$(this).find(".like_number").css({"color":"#666"});	
					}

					$(this).closest(".post_lc").find(".card-tag").delay(1).hide(0);
				});

				$(document).delegate('.post_lc .card-tag',"mouseout", function(){
					$(this).delay(1).hide(0);
				});



				$(document).delegate('.mf_liked',"mouseover", function(){
					$(this).closest(".post_lc").find(".mf_name").text($(this).attr("id"));
					$(this).closest(".post_lc").find(".mf_name").stop().show();
				});

				$(document).delegate('.mf_liked',"mouseout", function(){
					$(this).closest(".post_lc").find(".mf_name").delay(1).hide();
				});

				$(document).delegate('.mf_name',"mouseover", function(){
					$(this).stop().show();
					$(this).closest(".post_lc").find(".card-tag").stop().show();
				});			

				$(document).delegate('.mf_name',"mouseout", function(){
					$(this).stop().delay(1).hide();
					$(this).closest(".post_lc").find(".card-tag").delay(1).hide(0);
				});			
				

				$(document).delegate('.post_comment',"mouseover", function(){
					$(this).find(".comment_delete").show();
				});

				$(document).delegate('.post_comment',"mouseout", function(){
					$(this).find(".comment_delete").hide();
				});

				$(document).delegate('.field',"click", function(){
					$(".visi_functions_box").show();
					$(this).css({"text-decoration":"underline"});
				});

				
			     $(document).click(function(event){

			     	var $target= $(event.target);
			     	var $container= $(".posttool-select");
			     	if(!$container.is($target)&&($container.has($target).length===0)){
			     		$container.find(".visi_functions_box").stop().hide();
			     		$container.find(".field").css({"text-decoration":"none"});
			     	}
			     	if($target.hasClass(".visi_functions_option")){
			     		$container.find(".visi_functions_box").stop().hide();
			     		$container.find(".field").css({"text-decoration":"none"});
			     	}


				});

	


	$(document).delegate(".option_delete","click",function(){

					var postid= $(this).closest(".posts").attr("id");
					$(this).closest(".posts").animate({ opacity: "0", height: "0", marginTop: "0px", marginBottom: "0px", paddingTop:"0px", paddingBottom:"0px"},400);
					//alert(postid);
					$.ajax({
	            			type: "POST",
            				url: "includes/feedops.php",
            				data: {postid: postid, delete: 1},
            				success: function(html){ 
            					
			            	}
						});
	});

		$(document).delegate(".comment_delete","click",function(){

					var replyid= $(this).closest(".post_comment").find(".comment_msg").attr("id");
					$(this).closest(".post_comment").animate({ opacity: "0", height: "0", marginTop:"0px", marginBottom:"0px", paddingTop:"0px", paddingBottom:"0px", border:"none"},400);
					//alert(replyid);
					$.ajax({
	            			type: "POST",
            				url: "includes/feedops.php",
            				data: {replyid: replyid, delete: 1},
            				success: function(html){ 
            					
			            	}
						});
	});
				
	$(document).delegate(".option_hide","click",function(){

					var postid= $(this).closest(".posts").attr("id");
					$(this).closest(".posts").animate({ opacity: "0", height: "0", marginTop: "0px", marginBottom: "0px", paddingTop:"0px", paddingBottom:"0px"},400);
					//alert(postid);
					$.ajax({
	            			type: "POST",
            				url: "includes/feedops.php",
            				data: {postid: postid, hide: 1},
            				success: function(html){ 
            					
			            	}
						});
	});


	$(document).delegate(".option_report","click",function(){

					var postid= $(this).closest(".posts").attr("id");
					//alert(postid);

					$(".popup_box").attr("id",postid);
					$(".blackcanvas").stop().fadeIn();
					/*
					$.ajax({
	            			type: "POST",
            				url: "includes/feedops.php",
            				data: {postid: postid, report: 1},
            				success: function(html){ 
            					
			            	}
						});
					*/
	});


	$(document).delegate(".bt_success","click",function(){
		var postid= $(this).closest(".popup_box").attr("id");
		$.ajax({
	            			type: "POST",
            				url: "includes/feedops.php",
            				data: {postid: postid, report: 1},
            				success: function(html){ 
            					$(".blackcanvas").hide();	
			            	}
						});
	});

	$(document).delegate(".bt_cancel","click",function(){
		$(".blackcanvas").hide();	
	});

	$(document).delegate(".option_edit","click",function(){
		var postid= $(this).closest(".posts").attr("id");
		var txt= $(this).closest(".posts").find(".msg_span").text().trim();

		$(this).closest(".posts").find(".post_msg").hide();
		$(this).closest(".posts").find(".edit_area").val(txt);
		$(this).closest(".posts").find(".post_edit").show();

	});

	$(document).delegate(".edit_cancel","click",function(){
		$(this).closest(".posts").find(".post_edit").hide();
		$(this).closest(".posts").find(".post_msg").show();
		$(this).closest(".posts").find(".edit_area").val("");
	});

	$(document).delegate(".edit_done","click",function(){
		var postid= $(this).closest(".posts").attr("id");
		var txt= $(this).closest(".posts").find(".edit_area").val();

		$.ajax({   
		  			type: "POST",
            		url: "includes/feedops.php",
            		data: {postid: postid, edit: txt},
          			success: function(html){ 
            				
			        }
				});

		
		$(this).closest(".posts").find(".edit_area").val("");
		$(this).closest(".posts").find(".post_edit").hide();
		$(this).closest(".posts").find(".msg_span").text(txt);
		$(this).closest(".posts").find(".post_msg").show();
	});

		$(document).delegate(".post_seen","mouseover",function(){
			var p=$(this).find("span").text().trim();
			$(this).find(".tag-box").text("Seen by "+p);
			$(this).find(".card-tag").stop().show();
		});

		$(document).delegate(".post_seen","mouseout",function(){
			$(this).find(".card-tag").delay(1).hide();
		});


				function latest_feed() {

						var latest = feeds.children().first().attr('id');
						//alert(latest);
						$.ajax({
	            			type: "POST",
            				url: "includes/latestfeed.php",
            				data: {latest: latest},
            				success: function(html){ 
            					//alert("a");
	                			$("#posts").first().prepend( html );
			            	}
						});
				}







});