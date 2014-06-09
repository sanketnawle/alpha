<?php 
require_once('includes/dbconfig.php');
$_SESSION['studentid']="1";
$result = mysqli_query($con,"SELECT * FROM home_posts ORDER BY update_timestamp DESC LIMIT 10");

require_once('includes/feedchecks.php');
?>

<!DOCTYPE html>

<html>

	<head>

		<meta https-equiv="content-type" content="text/html; charset=UTF-8">
		<title>Urlinq</title>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<link href='css/feeds.css' rel='stylesheet' />
		<script>

    			
			$(document).ready(function(){

				
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
			     		$(".post_functions_box").stop().fadeOut(100);
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

				//post like
				$(document).delegate('.post_like img',"click", function(){
					var postid= $(this).closest(".posts").attr("id"); 

					var lk= $(this).closest(".posts").find(".like_number");
					var afterlike= lk.text().trim();
					if(afterlike==''){afterlike=0;}else{afterlike=parseInt(afterlike);}
					addlike=afterlike+1;
					minuslike=afterlike-1;
					if(minuslike=='0'){minuslike=' ';}
					
					//alert(postid);

					if($(this).hasClass("-liked")){
						//de-like
						$(this).attr("src","src/like-button.png");
						$(this).removeClass("-liked");

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
						$(this).attr("src","src/liked-button.png");
						$(this).addClass("-liked");

						$.ajax({
	            			type: "POST",
            				url: "includes/feedops.php",
            				data: {postid: postid, like: 1},
            				success: function(html){ 
	                			//alert("success");
	                			lk.text(addlike);
			            	}
						});

					}
				});

				$(document).delegate('.post_like img',"mouseover", function(){
					if(!$(this).hasClass("-liked")){
					$(this).attr("src","src/liked-button.png");
					}
				});

				$(document).delegate('.post_like img',"mouseout", function(){
					if(!$(this).hasClass("-liked")){
					$(this).attr("src","src/like-button.png");
					}
				});

				$(document).delegate('.comment_like img',"mouseover", function(){
					if(!$(this).hasClass("-liked")){
					$(this).attr("src","src/liked-button.png");
					}
				});

				$(document).delegate('.comment_like img',"mouseout", function(){
					if(!$(this).hasClass("-liked")){
					$(this).attr("src","src/like-button.png");
					}
				});

				$(document).delegate('.post_comment',"mouseover", function(){
					$(this).find(".comment_delete").show();
				});

				$(document).delegate('.post_comment',"mouseout", function(){
					$(this).find(".comment_delete").hide();
				});

				$('.select').on('click','li',function(){
					  var postid= $(this).closest(".posts").attr("id");
					  var $t = $(this),
					      $f = $(this).closest(".posttool-select").find('.field')
					      text = $t.text(),
					      icon = $t.find('i').attr('class');
					  $f.find('label').text(text);
					  $f.find('i').attr('class',icon);
					  
					  var flag= text.toLowerCase().split(" ").join("").trim();
					  //alert(flag);
					  if(flag=='onlystudents'){flag='student';}
					  if(flag=='onlyfaculty'){flag='faculty';}
					  if(flag=='onlyme'){flag='onlyme';}
					  if(flag=='campus'){flag='campus';}

					  $.ajax({
	            			type: "POST",
            				url: "includes/feedops.php",
            				data: {postid: postid, privacy: flag},
            				success: function(html){ 
            					
			            	}
						});

					});

					$('.field').click(function(e){
					  e.preventDefault();
					  $('#open').click();
					});

					
				var tagbox_flag=0;

				$(document).delegate(".field","click",function(){
					tagbox_flag=1;
					$(".card-tag").hide();
					$(this).closest(".posttool-select").find(".select").stop().fadeIn(200);


					var cur= $(this).closest(".field").find("i").attr("class");
					
					$( ".select li" ).each(function( index ) {
						if($(this).find("i").attr("class")==cur){
							$(this).hide();
						}else{
							$(this).show();
						}
					});	
					
				});    
				
			     $(document).click(function(event){

			     	var $target= $(event.target);
			     	var $container= $(".posttool-select");
			     	if(!$container.is($target)&&($container.has($target).length===0)){
			     		$container.find(".select").stop().fadeOut(150);
			     		tagbox_flag=0;
			     	}

			     	if($target.hasClass("selitem")){
			     		$container.find(".select").stop().fadeOut(150);
			     		tagbox_flag=0;
			     	}
				});

	$(document).delegate(".posttool-select","mouseover",function(){
		if(tagbox_flag==0){
		var icon= $(this).find(".field .icon");
		var tagtext='';
		if(icon.hasClass("user")){tagtext="Seen by: <span style='font-weight:bold;'>Students</span>";}
		if(icon.hasClass("list")){tagtext="Seen by: <span style='font-weight:bold;'>Faculty</span>";}
		if(icon.hasClass("stat")){tagtext="Seen by: <span style='font-weight:bold;'>Campus</span>";}
		if(icon.hasClass("accs")){tagtext="Seen by: <span style='font-weight:bold;'>Only Me</span>";}

		$(this).find(".tag-box span").html(tagtext);
		$(this).find(".card-tag").stop().fadeIn();
		}
	});

	$(document).delegate(".posttool-select","mouseout",function(){
		$(this).find(".card-tag").hide();
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
		var txt= $(this).closest(".posts").find(".post_msg").text();

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
		$(this).closest(".posts").find(".post_msg").text(txt);
		$(this).closest(".posts").find(".post_msg").show();
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

				/*
				function commentUpdateFlag_mutate() {

						if(commentUpdateFlag==0){
							commentUpdateFlag=1;
						}else{
							commentUpdateFlag=0;
						}
				}
				*/

			});

		</script>

	</head>

	<body>

		<div id='upload'>

			<form action="includes/fbarops.php" method="post"
				enctype="multipart/form-data">
				<label for="file">Filename:</label>
				<input type="file" name="file" id="file"><br>
				<input type="submit" name="submit" value="Submit">
			</form>

		</div>

		<div id='posts'>

		<?php

		while($row = mysqli_fetch_array($result)) {

			include "includes/posts.php";
		}
		?>

		</div>


		<section class='blackcanvas'>
			<div class='popup_box'>
				<div class='popup_header'><div>Spam Report</div></div>
				<div class='popup_content'><div class='content_text'>Do you want to report this post?</div></div>
				<div class='popup_footer'><button class='bt_success'>Report</button><button class='bt_cancel'>Cancel</button></div>
			</div>
		</section>

	</body>

</html>

<?php
mysqli_close($con);
?>