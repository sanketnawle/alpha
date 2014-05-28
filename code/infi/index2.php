<?php 
require_once('includes/dbconfig.php');

$result = mysqli_query($con,"SELECT * FROM home_posts ORDER BY update_timestamp DESC LIMIT 10");
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<title>Urlinq</title>

		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script>

			$(document).ready(function(){
				var load='yes';
				var feeds = $("#posts");
				var last_time = 0;
				var last_time = feeds.children().last().attr('id');
				var heightOffset= 0;
				// var load=0;

    			// recurring refresh every 10 seconds
    			setInterval(function() {latest_feed(); }, 10000);

				$(window).scroll(function(){
					if (load == 'yes'){
						if($(window).scrollTop()+heightOffset >= $(document).height() - $(window).height()){

							load = 'no';

							var last_time = feeds.children().last().attr('id');
							var latest = feeds.children().first().attr('id');
							alert(latest);
							
							var pullrequest = $.ajax({
            					type: "POST",
            					url: "includes/oldfeed.php",
            					cache: false,
            					data: {last_time: last_time},
            					datatype: "html"
        					});
        					pullrequest.done(function( html ){
        						$("#posts").last().append( html );
        					});
        					load = 'yes';				
						}
					}
				});

				function latest_feed() {
					// var data = 'refresh=1';
					var latest = feeds.children().first().attr('id');  
					var pullrequest = $.ajax({
            			type: "POST",
            			url: "includes/latestfeed.php",
            			data: {latest: latest},
            			success: function(html){ 
                			$("#posts").first().prepend( html );
					});
				}
				/*
				function latest_feed() {
					alert("a");
				}
				*/
				
			});
		</script>
	</head>

	<body>
		<div id='posts'>
		<?php
		while($row = mysqli_fetch_array($result)) {
			echo "<div id=".strtotime($row['update_timestamp']).">"; //strtotime shows no.of secs since Jan1,1970 and is set as DIV id
			echo $row['messageid'] . ".  " . $row['message'];
			echo "<br><br><br><br><br> </div>";
		}
		?>
		</div>
	</body>
</html>

<?php
mysqli_close($con);
?>