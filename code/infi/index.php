<?php 

require_once('includes/dbconfig.php');

$result = mysqli_query($con,"SELECT * FROM home_posts ORDER BY update_timestamp DESC LIMIT 0,8");

?>

<!DOCTYPE html>
<html>
<head>
	<title> Urlinq </title>
</head>
<body>
	<div class='posts'>
		<?php
		while($row = mysqli_fetch_array($result)) {
			echo "<div id=".strtotime($row['update_timestamp']).">"; //This shows no.of secs since Jan1,1970
			echo $row['messageid'] . ".  " . $row['message'];
			echo "<br><br><br><br><br> </div>";
		}
		?>
	</div>


	<script>
		$(document).ready(function(){
			var load = 0;
			$(window).scroll(function(){
				if($(window).scrollTop() == $(document).height() - $(window).height()){
				// 	load++;
				// 	$.post("ajax.php",
				// 		{load:load},
				// 		function(data){
				// 			$('.posts').append(data);
				// 		});
					alert("test");
				}
			});
		});
	</script>
	<script src='js/jquery.min.js'></script>	
<?php
mysqli_close($con);
?>
</body>
</html>