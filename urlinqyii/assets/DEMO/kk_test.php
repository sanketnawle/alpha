<?php

	// include_once 'db_connect.php';
	// include_once 'db_config.php';

	include_once('include/header.php');

	session_start();
	$_SESSION['user_type']='Student';
	$_SESSION['student_id']='1';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">


    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Kaushik">
        <link rel="shortcut icon" href="../images/experiments.ico">

        <title>urlinq</title>

        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <script type="text/javascript" src="http://www.google.com/jsapi"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
    </head>

    <body>
    	<div class="well">
			<?php
				echo "test";
				echo $user_type=$_SESSION['user_type'];
				echo $student_id=$_SESSION['student_id'];
			?>
		</div>

		<div class="well">

			<?php
				
				echo "test";
  					$sem_sql="SELECT * from home_posts";
					$sem_res=$dbObj->fireQuery($sem_sql,'select');

					if(isset($sem_res) && $sem_res!=false && count($sem_res)>0)
						{
							echo "test";
						}
				





  		// 				    global $mysqli;
    // $class_id = $_SESSION['class_id'];
    // $sql = "select * from home_posts where studentid='".$student_id."' ORDER BY update_timestamp DESC";
    // echo '<ul class="media-list well">';
    // $result=$mysqli->query($sql);
    //         echo "pass2";
    // if($result){
    // 	echo "pass";
    // }
    // else{echo "test3";}
    // 	}




//   					global $mysqli;
// $result = mysqli_query($mysqli,"SELECT * FROM home_posts");

// while($row = mysqli_fetch_array($result))
//   {
//   echo $row['messageid'] . " " . $row['univid'];
//   echo "<br>";
//   }
// }


				// global $mysqli;
				// $sql = "select * from home_posts where studentid='".$student_id."' ORDER BY update_timestamp DESC";
				// $result=$mysqli->query($sql)
				// 	or die('Query failed');
				// if($result->num_rows){
				// 	echo "test1";
				// }

			?>

		</div>

	</body>

</html>