<?php
require_once('includes/dbconfig.php');
require_once('includes/time.php');

if(!isset($_GET['user_id'])){
	session_start();
}

if(isset($_GET['user_id'])){
	// echo "test";
	$_GET['user_id'] = 1;
	$result = mysqli_query($con,"SELECT * FROM posts WHERE user_id = ".$_GET['user_id']." ORDER BY update_timestamp DESC LIMIT 5");
}
else{
	$result = mysqli_query($con,"SELECT * FROM posts ORDER BY update_timestamp DESC LIMIT 5");
	// echo mysqli_num_rows($result);
}

require_once('includes/feedchecks.php');
?>

<!DOCTYPE html> 
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">

		<link rel = "stylesheet" type = "text/css" href = "feed.css">
		<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		

		<link href='https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>

		<!--<script src="//code.jquery.com/jquery-1.10.2.js"></script>-->
		<!--<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>-->
 		<!--<script src="feed.js"></script>--> 
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="https://cdn.embed.ly/jquery.embedly-3.1.1.min.js" type="text/javascript"></script>
		<!-- // <script src="js/timeago.js" type="text/javascript"></script> -->
	</head>

		<script>

		// $(document).ready(function(){
		// 	 jQuery.timeago.settings.allowFuture = true;
  //               jQuery("time.timeago").timeago();
		// });
		navigator.sayswho= (function(){
    		var ua= navigator.userAgent, tem, 
   			 M= ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
    		if(/trident/i.test(M[1])){
        		tem=  /\brv[ :]+(\d+)/g.exec(ua) || [];
     		   return 'IE '+(tem[1] || '');
    			}
    		if(M[1]=== 'Chrome'){
        		tem= ua.match(/\bOPR\/(\d+)/)
        		if(tem!= null) return 'Opera '+tem[1];
    			}
    		M= M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
    		if((tem= ua.match(/version\/(\d+)/i))!= null) M.splice(1, 1, tem[1]);
    		return M.join(' ');
			})();
		</script>
		<script>

            function download (id)
            {
                window.open ("includes/download_file.php?file_id="+id, "hiddenFrame");
            }
			
var j$=$.noConflict();
$(document).ready(function() {

	j$.embedly.defaults.key = '110869001b274ee0a51767da08dafeef';

j$( ".new_fd" ).each(function( index ) {

			j$(this).removeClass("new_fd");
			if(j$(this).find(".f_hidden_p").text().trim()!=""){
			j$(this).find('.play').embedly({
				query: {
				maxwidth:500,
				autoplay:true
			},
display: function(data, elem){
	
//Adds the image to the a tag and then sets up the sizing.
j$(elem).html('<img src="'+data.thumbnail_url+'"/>')
.width(data.thumbnail_width)
.height(data.thumbnail_height)
.find('span').css('top', data.thumbnail_height/2-36)
.css('left', data.thumbnail_width/2 - 36);
//alert($(elem).html());
var j$elhtml=  j$(elem).html();
j$(elem).closest(".post_lr_link_msg").find(".link-img").html(j$elhtml);

var t_title=data.title;
var t_des=data.description;
var t_url=data.url;
//alert(data.title+" , "+data.description+", "+data.url);
var ctt= t_title+"<span class='link-text-website'>"+t_url+"</span>";

j$(elem).closest(".post_lr_link_msg").find(".link-text-title").html(ctt);
j$(elem).closest(".post_lr_link_msg").find(".link-text-about").html(t_des);

if(data.type==='video'){

}else{
	j$(elem).closest(".post_lr_link_msg").find(".play_btn").hide();
}

}
}).on('click', function(){
// Handles the click event and replaces the link with the video.
var data = j$(this).data('embedly');

if(data.type==='video'){
j$(this).closest(".post_lr_link_msg").find(".link-wrapper").replaceWith(data.html);
return false;
}else{
	window.open(data.url, '_blank');
}

});

}

});



j$(document).delegate('.playable_wrap',"click", function(){
	j$(this).closest(".post_lr_link_msg").find(".play").click();
});




	setTimeout(function() {latest_feed(); }, 5000);


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
		$(this).css({"height":"53px","border-radius":"4px","margin-left":"10px","width":"545px","margin-top":"10px"});
		$(this).closest(".reply_tawrapper").closest(".commentform").css("height","96px");
		$(this).closest(".commentform").find(".reply_user_icon").hide();
		$(this).closest(".commentform").find(".reply_functions").show();
		$(this).closest(".reply_tawrapper").find(".reply_attach").css({"margin-top":"-31px","margin-right":"82px"});
		$(this).closest(".posts").find(".feed_upload_textprompt").show();
	});

	$(document).delegate(".flat7b","click",function(event){

		if(!$(this).hasClass("flat_checked")){
		$(this).css({"border":"1px solid #00A076","background-color":"#02e2a7"});
		$(this).closest(".check_wrap").find(".move").css({"margin-left":"19px"});
		$(this).addClass("flat_checked");
		$(this).closest(".check_wrap").find(".comment_anon_text").css("color","rgba(33,33,33,.85)");
		$(this).closest(".posts").find(".post_anon_val").val("1");
		}else{
		$(this).css({"border":"1px solid #C9C9C9","background-color":"#f5f5f5"});
		$(this).closest(".check_wrap").find(".move").css({"margin-left":"0px"});
		$(this).removeClass("flat_checked");
		$(this).closest(".check_wrap").find(".comment_anon_text").css("color","rgba(153, 153, 153, 0.64)");
		$(this).closest(".posts").find(".post_anon_val").val("0");
		}
	});

	$(document).delegate(".post_comment_btn","click",function(){
		$(this).closest(".posts").find(".form-control").focus();
	});

				var load='yes';
				var feeds = $("#posts");
				var last_time = 0;
				var heightOffset= 550;


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
							//alert(heightOffset);
							load = 'no';
							    last_time = $("#posts").children().last().attr('id');
							var $ref=$("#posts");
							var pullrequest = $.ajax({
            					type: "POST",
            					url: "includes/oldfeed.php",
            					cache: false,
            					data: {last_time: last_time},
            					datatype: "html"
        					});
        					pullrequest.done(function( html ){
        						$ref.last().append( html );
        						load = 'yes';

j$( ".new_fd" ).each(function( index ) {

			j$(this).removeClass("new_fd");
			if(j$(this).find(".f_hidden_p").text().trim()!=""){
			j$(this).find('.play').embedly({
				query: {
				maxwidth:500,
				autoplay:true
			},
display: function(data, elem){
	
//Adds the image to the a tag and then sets up the sizing.
j$(elem).html('<img src="'+data.thumbnail_url+'"/>')
.width(data.thumbnail_width)
.height(data.thumbnail_height)
.find('span').css('top', data.thumbnail_height/2-36)
.css('left', data.thumbnail_width/2 - 36);
//alert($(elem).html());
var j$elhtml=  j$(elem).html();
j$(elem).closest(".post_lr_link_msg").find(".link-img").html(j$elhtml);

var t_title=data.title;
var t_des=data.description;
var t_url=data.url;
//alert(data.title+" , "+data.description+", "+data.url);
var ctt= t_title+"<span class='link-text-website'>"+t_url+"</span>";

j$(elem).closest(".post_lr_link_msg").find(".link-text-title").html(ctt);
j$(elem).closest(".post_lr_link_msg").find(".link-text-about").html(t_des);

if(data.type==='video'){

}else{
	j$(elem).closest(".post_lr_link_msg").find(".play_btn").hide();
}

}
}).on('click', function(){
// Handles the click event and replaces the link with the video.
var data = j$(this).data('embedly');

if(data.type==='video'){
j$(this).closest(".post_lr_link_msg").find(".link-wrapper").replaceWith(data.html);
return false;
}else{
	window.open(data.url, '_blank');
}

});

}

});


        						
        					});
						}
					}
				});

/*
				$(document).delegate('.submit',"click", function(){
					var $owner= $(this).closest(".posts");
					var commentid= $owner.find(".comments .post_comment").last().attr("id");
					var postid= $owner.attr("id");
					var commentcontent= $owner.find(".postval").val().trim();

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




				//post like
				setInterval(function() {flagSetBack(); }, 2000);

				var likepost_flag=0;

				$(document).delegate('.post_like',"click", function(){
					if(likepost_flag==0){
					likepost_flag=1;
					var postid= $(this).closest(".posts").attr("id"); 
					//alert("b");
					var lk= $(this).find(".like_number");
					var afterlike= lk.text().trim();
					if(afterlike==''){afterlike=0;}else{afterlike=parseInt(afterlike);}
					addlike=afterlike+1;
					minuslike=afterlike-1;
					if(minuslike=='0'){minuslike=' ';}

					if($(this).hasClass("post_liked")){
						//de-like
						$(this).removeClass("post_liked");
						$(this).find(".post_like_icon").attr("src","src/liking-button.png");
						$(this).find(".like_number").css("color","white");
						

						$.ajax({
	            			type: "POST",
            				url: "includes/feedops.php",
            				data: {post_id: postid, unlike: 1},
            				success: function(html){ 
	                			lk.text(minuslike);
	                			
			            	}
						});

					}else{
						//like
						//alert("a");
						$(this).find(".post_like_icon").attr("src","src/liked-button.png");
						$(this).find(".like_number").css("color","white");
						$(this).addClass("post_liked");
						
						$.ajax({
	            			type: "POST",
            				url: "includes/feedops.php",
            				data: {post_id: postid, like: 1},
            				success: function(html){ 
	                			lk.text(addlike);
			            	}
						});
						
					}
					}
				});

				$(document).delegate('.post_like',"mouseover", function(){

					if($(this).hasClass("post_liked")){

					$(this).attr("src","src/liked-button.png");
					}else{
						
					$(this).find(".post_like_icon").attr("src","src/liking-button.png");	
					$(this).find(".like_number").css({"color":"white"});
					}

				});



				$(document).delegate('.post_like',"mouseout", function(){
					if($(this).hasClass("post_liked")){
					$(this).attr("src","src/like-button.png");
					}else{
					$(this).find(".post_like_icon").attr("src","src/like-button.png");
					$(this).find(".like_number").css({"color":"#666"});	
					}

				});





				/*
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
				*/

				$(document).delegate('.post_comment',"mouseover", function(){
					$(this).find(".comment_delete").show();
				});

				$(document).delegate('.post_comment',"mouseout", function(){
					$(this).find(".comment_delete").hide();
				});

				$(document).delegate('.field',"click", function(){
					if($(this).closest(".posttool-select").hasClass("privacy_canedit")){
					$(this).closest(".posttool-select").find(".visi_functions_box").show();
					cardtag_flag=1;
					$(this).closest(".field").find(".card-tag").hide();

					$(this).css({"border":"1px solid rgba(60,60,60,0.23)","background-color":"rgba(60,60,60,0.03)"});

					$(this).find(".vstt_wedgeDown").css({"opacity":"1"});
					}
				});

				
			     $(document).click(function(event){

			     	var $target= $(event.target);
			     	var $container= $(".posttool-select");
			     	if(!$container.is($target)&&($container.has($target).length===0)){
			     		$container.find(".visi_functions_box").stop().hide();
			     		cardtag_flag=0;

			     		$container.find(".field").css({"border":"1px solid rgba(60,60,60,0)","background-color":"white"});
						$container.find(".vstt_wedgeDown").css({"opacity":"0"});
			     	}
			     	if($target.hasClass(".visi_functions_option")){
			     		$container.find(".visi_functions_box").stop().hide();
			     		cardtag_flag=0;
			     		$container.find(".field").css({"border":"1px solid rgba(60,60,60,0)","background-color":"white"});
						$container.find(".vstt_wedgeDown").css({"opacity":"0"});
			     	}
				});

			     $(document).delegate(".visi_functions_option","click",function(){
			     	//student campus connections faculty
			     	var ref=$(this).closest(".posttool-select");
			     	var privacy= "campus";
			     	if($(this).find(".visi_icon").hasClass("i_campus")){privacy="campus";}
			     	if($(this).find(".visi_icon").hasClass("i_student")){privacy="students";}
			     	if($(this).find(".visi_icon").hasClass("i_faculty")){privacy="faculty";}
			     	if($(this).find(".visi_icon").hasClass("i_connections")){privacy="connections";}

			     	

			     	var post_id= $(this).closest(".posts").attr("id");

			     	$.ajax({
	            			type: "POST",
            				url: "includes/feedops.php",
            				data: {privacy: privacy, post_id: post_id},
            				success: function(html){ 
            					ref.find(".tag-box").text("Visible to "+privacy);
			            	}
						});

			     	$(this).closest(".visi_functions_box").hide();
			     	cardtag_flag=0;
			     	ref.find(".field").css({"border":"1px solid rgba(60,60,60,0)","background-color":"white"});
					ref.find(".vstt_wedgeDown").css({"opacity":"0"});

					var src_2=$(this).closest(".posttool-select").find(".visi_icon").css("background-image");
					var srcarr= src_2.split("_");
					srcarr[srcarr.length-1]="status.png";
					var subarr=srcarr[srcarr.length-2].split("/");
					srcarr[srcarr.length-2]="status/"+privacy;
					var src_2=srcarr.join("_").substring(4);
					//alert(src_2);
					$(this).closest(".posttool-select").find(".vstt_icon").attr("src",src_2);
			     });
	


	$(document).delegate(".option_delete","click",function(){

					var post_id= $(this).closest(".posts").attr("id");
					$(this).closest(".posts").animate({ opacity: "0", height: "0", marginTop: "0px", marginBottom: "0px", paddingTop:"0px", paddingBottom:"0px"},400);
					//alert(post_id);
					$.ajax({
	            			type: "POST",
            				url: "includes/feedops.php",
            				data: {post_id: post_id, delete: 1},
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
            				data: {post_id: postid, hide: 1},
            				success: function(html){ 
            					
			            	}
						});
	});


	$(document).delegate(".option_report","click",function(){

					var postid= $(this).closest(".posts").attr("id");
					//alert(postid);

					$(".report_popup").attr("id",postid);
					$(".blackcanvas").stop().show();
					/*
					$.ajax({
	            			type: "POST",
            				url: "includes/feedops.php",
            				data: {post_id: postid, report: 1},
            				success: function(html){ 
            					
			            	}
						});
					*/
	});

	$(document).delegate(".popup_btn_1","click",function(){
		if($(this).closest(".popup_window").hasClass("report_popup")){
			$(".blackcanvas").hide();
		}
	});

	$(document).delegate(".popup_btn_0","click",function(){
		if($(this).closest(".popup_window").hasClass("report_popup")){
			var post_id=$(this).closest(".popup_window").attr("id");
			//alert(post_id);
			$.ajax({
	            		type: "POST",
            			url: "includes/feedops.php",
            			data: {post_id: post_id, report: 1},
            			success: function(html){ 
            					$(".blackcanvas").hide();
			        }
			});
		}
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
            		data: {post_id: postid, edit: txt},
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

		$(document).delegate(".reply_attach","click",function(){
			$(this).closest(".posts").find(".form-control").focus();   
            $(this).closest(".posts").find('.upload_feed_hack').click();
        });

		$(document).delegate(".upload_feed_hack","change",function(){
			   		var $hack=$(this);

                    var filename= $hack.val();
                    //alert(this.files[0].size);
                    //alert(filename);
                    if(filename.length>=18){
                            filename= filename.substring(0,15)+"...";
                        }

                    $(this).closest(".posts").find(".feed_upload_textprompt").text(filename);
                    $(this).closest(".posts").find(".feed_upload_textprompt").attr("title",$hack.val());
        }); 


		//ajax send form tech
        $(document).delegate(".reply_button","click",function(){
        			var ref=$(this).closest(".posts");

        			var reply_msg=$(this).closest(".posts").find(".form-control").val().trim();
        			var anon=$(this).closest(".posts").find(".post_anon_val").val();
        			var reply_id=$(this).closest(".posts").find(".post_comment").last().attr("id");
        			var post_id=$(this).closest(".posts").attr("id");


        			var file_exist_proof=$(this).closest(".posts").find(".upload_feed_hack").val();

        			if((file_exist_proof=="")&&(reply_msg=="")){

        			}else{
        			if(file_exist_proof!=""){

   					var formData= new FormData( $(this).closest(".posts").find(".upload_feed_hack").closest("form")[0]);
   					formData.append("reply_msg",reply_msg);
   					formData.append("anon",anon);
   					formData.append("reply_id",reply_id);
   					formData.append("post_id",post_id);


        			var $ref=$(this).closest(".posts").find(".comments");
        			$ref.find(".form-control").val("");
        			
						$.ajax({
	            			type: "POST",
            				url: "includes/updatecomments.php",
            				xhr: function() {  // Custom XMLHttpRequest
            					var myXhr = $.ajaxSettings.xhr();
            					if(myXhr.upload){ // Check if upload property exists
                					myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // For handling the progress of the upload
            						}
           					 return myXhr;
        					},

            				data: formData,
            				contentType: false,
        					processData: false,
            				success: function(html){ 
            					ref.find(".form-control").val("");
            					ref.find(".feed_upload_textprompt").text("");
            					ref.find(".feed_upload_textprompt").attr("title","");
            					ref.find(".comments").append(html);
			            	}
						});
					
					}else{
						$.ajax({
	            			type: "POST",
            				url: "includes/updatecomments.php",
            				data: {reply_msg: reply_msg, reply_id: reply_id, anon: anon, post_id:post_id},
            				success: function(html){ 
            					ref.find(".form-control").val("");
            					ref.find(".feed_upload_textprompt").text("");
            					ref.find(".feed_upload_textprompt").attr("title","");
            					ref.find(".comments").append(html);
			            	}
						});
					}
        	}	
        });

		function progressHandlingFunction(e){
    		if(e.lengthComputable){
        		$('progress').attr({value:e.loaded,max:e.total});
    		}
		}

		function flagSetBack(e){
			likepost_flag=0;
		}

		var cmtmore_flag=0;
		$(document).delegate(".morecmt_bar","click",function(){
				if(cmtmore_flag==0){
				cmtmore_flag=1;
				var top_reply=$(this).closest(".posts").find(".post_comment").first().attr("id");
				var post_id=$(this).closest(".posts").attr("id");
				var $ref=$(this).closest(".posts").find(".comments");
				var $this=$(this);
				
				$.ajax({
	            			type: "POST",
            				url: "includes/updatecomments.php",
            				data: {top_reply: top_reply, post_id:post_id},
            				success: function(html){ 
            					$this.hide();
	                			$ref.prepend(html);
	                			cmtmore_flag=0;
			            	}
						});
			}
		});


		var cardtag_flag=0;
		$(document).delegate(".vstt_icon","mouseover",function(){
			if(cardtag_flag==0){
			$(this).closest(".field").find(".card-tag").show();
			}
		});

		$(document).delegate(".vstt_icon","mouseout",function(){
			$(this).closest(".field").find(".card-tag").hide();
		});

		$(document).delegate(".visi_functions_option","mouseover",function(){
			var src=$(this).closest("span").find(".visi_icon").css("background-image");
			srcarr=src.split("_");
			srcarr[srcarr.length-1]="hover.png)";
			//if($.browser.mozilla){srcarr[srcarr.length-1]="hover.png";}
			if(navigator.sayswho.split(" ")[0].toLowerCase()=="firefox"){srcarr[srcarr.length-1]="hover.png";}
			src=srcarr.join("_");
			//alert(src);
			$(this).closest("span").find(".visi_icon").css("background-image",src);
		});

		$(document).delegate(".visi_functions_option","mouseout",function(){
			var src=$(this).closest("span").find(".visi_icon").css("background-image");
			srcarr=src.split("_");
			srcarr[srcarr.length-1]="normal.png)";
			if(navigator.sayswho.split(" ")[0].toLowerCase()=="firefox"){srcarr[srcarr.length-1]="normal.png";}
			src=srcarr.join("_");
			//alert(src);
			$(this).closest("span").find(".visi_icon").css("background-image",src);
		});


		$(document).delegate(".cmt_vote","click",function(){

						//post_id vote : upvote downvote
						var reply_id=$(this).closest(".post_comment").find(".comment_msg").attr("id");
						var vote="";

						if($(this).hasClass("comment_upvote")){
							vote="upvote";
							//$(this).css({"background-image":"url(img/upvote_active.png)"});
							//$(this).closest(".comment_updown").find(".comment_downvote").css({"opacity":"0.4"});
						}
						if($(this).hasClass("comment_downvote")){
							vote="downvote";
							//$(this).closest(".comment_updown").find(".comment_upvote").css({"background-image":"url(src/upvote.png)"});
							//$(this).css({"opacity":"1"});
						}
						var score=parseInt($(this).closest(".post_comment").find(".score").text());

						if($(this).closest(".comment_updown").hasClass("upvoted")){
							if(vote=="upvote"){score=score-1;$(this).closest(".comment_updown").removeClass("upvoted");}
							if(vote=="downvote"){score=score-2;$(this).closest(".comment_updown").removeClass("upvoted");$(this).closest(".comment_updown").addClass("downvoted");}
							
						}else{
							if($(this).closest(".comment_updown").hasClass("downvoted")){
							if(vote=="upvote"){score=score+2;$(this).closest(".comment_updown").removeClass("downvoted");$(this).closest(".comment_updown").addClass("upvoted");}
							if(vote=="downvote"){score=score+1;$(this).closest(".comment_updown").removeClass("downvoted");}

							}else{
								if(vote=="upvote"){score=score+1;$(this).closest(".comment_updown").addClass("upvoted");}
								if(vote=="downvote"){score=score-1;$(this).closest(".comment_updown").addClass("downvoted");}
							}
						}

						
						//alert(score);
						$(this).closest(".comment_updown").find(".score").text(score);

						//alert(vote);
						$.ajax({
	            			type: "POST",
            				url: "includes/feedops.php",
            				data: {reply_id:reply_id, vote:vote},
            				success: function(html){ 
	                			
			            	}
						});
		});


		$(document).delegate(".pst_seemore","click",function(){
				
					$(this).closest(".seemore_anchor").find(".txt_tail").hide();
					$(this).closest(".seemore_anchor").find(".text_hidden").show();
					$(this).hide();
		});

				/*link post animation*/
		$(document).delegate(".playable_wrap > *","mouseover",function(){
			$(this).closest(".playable_wrap").find(".play_btn").css({"background-position":"0% 100%"});
		});

		$(document).delegate(".playable_wrap > *","mouseout",function(){
			$(this).closest(".playable_wrap").find(".play_btn").css({"background-position":"0% 0%"});
		});



						//new functions

				$(document).delegate('.q_viewmore',"mouseover", function(){
					var t=$(this).position().top;
					var l=$(this).position().left;
					//alert(t+","+l);
					$(this).find(".card-tag").css({"margin-left":l-100});

					$(this).find(".card-tag").stop().show();
				});				

				$(document).delegate('.q_viewmore',"mouseleave", function(){
					$(this).find(".card-tag").delay(1).hide(0);
				});
				
				$(document).delegate('.mf_liked',"mouseover", function(){
					var t=$(this).closest(".q_viewmore").position().top;
					var l=$(this).closest(".q_viewmore").position().left;
					$(this).closest(".q_viewmore").find(".mf_name").css({"margin-left":l-95});
					$(this).closest(".q_viewmore").find(".mf_name").text($(this).attr("id"));
					$(this).closest(".q_viewmore").find(".mf_name").stop().show();
				});

				$(document).delegate('.mf_liked',"mouseleave", function(){
					$(this).closest(".q_viewmore").find(".mf_name").delay(1).hide();
				});
				
				$(document).delegate('.mf_name',"mouseover", function(){
					$(this).stop().show();
					//$(this).closest(".post_lc").find(".card-tag").stop().show();
				});			

				$(document).delegate('.mf_name',"mouseout", function(){
					$(this).stop().delay(1).hide();
					//$(this).closest(".post_lc").find(".card-tag").delay(1).hide(0);
				});			

				


				function latest_feed() {
					var feeds=$("#posts");

j$( ".new_fd" ).each(function( index ) {

			j$(this).removeClass("new_fd");
			if(j$(this).find(".f_hidden_p").text().trim()!=""){
			j$(this).find('.play').embedly({
				query: {
				maxwidth:500,
				autoplay:true
			},
display: function(data, elem){
	
//Adds the image to the a tag and then sets up the sizing.
j$(elem).html('<img src="'+data.thumbnail_url+'"/>')
.width(data.thumbnail_width)
.height(data.thumbnail_height)
.find('span').css('top', data.thumbnail_height/2-36)
.css('left', data.thumbnail_width/2 - 36);
//alert($(elem).html());
var j$elhtml=  j$(elem).html();
j$(elem).closest(".post_lr_link_msg").find(".link-img").html(j$elhtml);

var t_title=data.title;
var t_des=data.description;
var t_url=data.url;
//alert(data.title+" , "+data.description+", "+data.url);
var ctt= t_title+"<span class='link-text-website'>"+t_url+"</span>";

j$(elem).closest(".post_lr_link_msg").find(".link-text-title").html(ctt);
j$(elem).closest(".post_lr_link_msg").find(".link-text-about").html(t_des);

if(data.type==='video'){

}else{
	j$(elem).closest(".post_lr_link_msg").find(".play_btn").hide();
}

}
}).on('click', function(){
// Handles the click event and replaces the link with the video.
var data = j$(this).data('embedly');

if(data.type==='video'){
j$(this).closest(".post_lr_link_msg").find(".link-wrapper").replaceWith(data.html);
return false;
}else{
	window.open(data.url, '_blank');
}

});

}

});


//alert("a");					
						
						var latest = feeds.children().first().attr('id');
						var $ref=$("#posts");
						//alert(latest);
						$.ajax({
	            			type: "POST",
            				url: "includes/latestfeed.php",
            				data: {latest: latest},
            				//timeout: 50000,
            				success: function(html){ 
            					// alert(html);
            					// alert("a");
	                			$ref.first().prepend( html );
	                			setTimeout(function() {latest_feed(); }, 1000);
			            		//alert($(".new_fd").attr("id"));

				//success end
								},
							error: function(x,t,e){
								// alert(t);
								setTimeout(function() {latest_feed(); }, 1000);
							} 
				});


				//ajax end

			}


});
</script>



	<body>
		
		<div id = "posts">
			<!--a post start-->

			<?php
				if($result){
					while($row = mysqli_fetch_array($result)) {
						$create_ts_arr = explode(" ", $row['update_timestamp']);
						$create_time = $create_ts_arr[0]."T".$create_ts_arr[1]."Z";
						
						if($row['post_type']=="status")	include "includes/posts.php";
						else if($row['post_type']=="notes") include "includes/posts_notes.php";
						else if($row['post_type']=="question") include "includes/posts_question.php";
					}
				}
			?>
			<!--a post end-->
		</div>
	</body>

</html>

<?php
mysqli_close($con);
?>
