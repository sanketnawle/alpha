<?php 
require_once('includes/dbconfig.php');
$_SESSION['studentid']="1";
// include "includes/likes.php";
$result = mysqli_query($con,"SELECT * FROM home_posts ORDER BY update_timestamp DESC LIMIT 10");
?>

<!DOCTYPE html>

<html>

	<head>

		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<title>Urlinq</title>

		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<link href='css/feeds.css' rel='stylesheet' />
		<script>

    			
			$(document).ready(function(){

				
				var load='yes';
				var feeds = $("#posts");
				var last_time = 0;
				var heightOffset= 0;
				var commentUpdatePeriod=1000;
				var commentUpdateFlag=1;

				setInterval(function() {latest_feed(); }, 10000);
				setInterval(function() {commentUpdateFlag_mutate(); }, commentUpdatePeriod);


				$(window).scroll(function(){
					if (load == 'yes'){
						if($(window).scrollTop()+heightOffset >= $(document).height() - $(window).height()){
							load = 'no';
							var last_time = $("#posts").children().last().attr('id');
							// var latest = feeds.children().first().attr('id');
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
					var commentid= $owner.find(".comments div").first().attr("id");
					var postid= $owner.attr("id");
					var commentcontent= $owner.find(".postval").val().trim();
					//the proof of successfully getting ids
					//alert(commentid+", "+postid+", "+commentcontent);
					if(commentcontent!=""){
					$.ajax({
	            			type: "POST",
            				url: "includes/updatecomments.php",
            				data: {postid: postid, commentid: commentid, commentcontent: commentcontent},
            				success: function(html){ 
	                			$owner.find(".comments").html(html);
	                			$owner.find(".postval").val("");
			            	}
						});
						}
				});

				$(document).delegate('.posts',"mouseover", function(){
					if(commentUpdateFlag==1){
					var $owner= $(this).closest(".posts");
					var commentid= $owner.find(".comments div").first().attr("id");
					var postid= $owner.attr("id");

					$.ajax({
	            			type: "POST",
            				url: "includes/updatecomments.php",
            				data: {postid: postid, commentid: commentid},
            				success: function(html){ 
	                			$owner.find(".comments").html(html);
			            	}
						});
					}
				});	

				$(document).delegate('.comment_like img',"click", function(){
					$(this).attr("src","src/liked-button.png");
				});

				$(document).delegate('.post_like img',"click", function(){
					$(this).attr("src","src/liked-button.png");
				});


				function latest_feed() {

						var latest = feeds.children().first().attr('id');
						$.ajax({
	            			type: "POST",
            				url: "includes/latestfeed.php",
            				data: {latest: latest},
            				success: function(html){ 
	                			$("#posts").first().prepend( html );
			            	}
						});
				}

				function commentUpdateFlag_mutate() {

						if(commentUpdateFlag==0){
							commentUpdateFlag=1;
						}else{
							commentUpdateFlag=0;
						}
				}

			});

		</script>

	</head>

	<body>

		<div id='posts'>

		<?php
		while($row = mysqli_fetch_array($result)) {

			include "includes/posts.php";
		}
		?>

		</div>

	</body>

</html>

<?php
mysqli_close($con);
?>