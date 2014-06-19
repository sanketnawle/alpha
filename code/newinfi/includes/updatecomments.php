<?php

	require_once("dbconfig.php");
	session_start();
	include "feedchecks.php";

	// Uncomment the below 3 lines if you are testing this page alone
	// $_POST['post_id'] = "13";
	// $_POST['top_reply']="1401981625";
	// $_POST['reply_id']="1401981625";
	// $_POST['reply_msg']="reply by tester";
	// $_POST['anon']=1;

	$user_id=1;
	$univ_id=1;

	$up_id = "";

	if(isset($_FILES['file'])){
 		// echo $errorIndex = $_FILES["file"]["error"];
	    try {
        	echo $up_id = upload($con);
        	// echo '<p>Thank you for submitting</p>';
    	}
    	catch(Exception $e) {
	        echo '<h4>'.$e->getMessage().'</h4>';
	    }
	}

	function upload($con){
	/*** check if a file was uploaded ***/
	if($_FILES['file']['error'] == "UPLOAD_ERR_OK"               //checks for errors
      	&& is_uploaded_file($_FILES['file']['tmp_name'])) {
    
    		/*** assign our variables ***/
    		$file_size = $_FILES['file']['size'];
    		$file_type = $_FILES['file']['type'];
    		// $file_tmpname = $_FILES['file']['tmp_name'];
    		$file_name = $_FILES["file"]["name"];
    		$maxsize = 4294960000; //4294967295
    		$file_content = file_get_contents($_FILES['file']['tmp_name']);

    	/***  check the file is less than the maximum file size ***/
    	if($file_size < $maxsize) {

        	$file_ins = $con->prepare("INSERT INTO file_upload (file_type, file_content, file_name) VALUES (? ,?, ?)");
        	if($file_ins) {
        		$file_ins->bind_param('sss', $file_type, $file_content, $file_name);
        		if($file_ins->execute()){
					// echo "success";
					return $up_id = $con->insert_id;
	        		// $up_id = "success";
        		}
    		}
    	}
    	else {
			/*** throw an exception is file is not of type ***/
        	echo "Mazaak(lol): You exceeded the maximum size limit";
		}
	}
	else
	    {
	    // if the file is not less than the maximum allowed, print an error
	    throw new Exception("Unsupported file Format!");
	    }
	}

	if(isset($_POST['reply_msg'])||($up_id=="success")){

		$comment = $_POST['reply_msg'];
		$post_id = $_POST['post_id'];
		$anon = $_POST['anon'];
		// $user_id=$_SESSION['$user_id']; //when session variables are set
		// $univ_id=$_SESSION['$univ_id'];		//when session variables are set

		$replyquery = "INSERT INTO reply (post_id,user_id,reply_msg,file_id,anon) VALUES (?,?,?,?,?)";
		$replyres = $con->prepare($replyquery);
		if($replyres){
			$replyres->bind_param('iisii',$post_id,$user_id,$comment,$up_id,$anon);
			$replyres->execute();
			// echo "success";
			$replyres->close();
		}
		else {
			/* Error */
			printf("Mazaak: %s\n", $mysqli->error); //Prepared Statement Error
		}
	}

	if (!isset($_POST['top_reply'])) updatecomments($con);

	function updatecomments($con){

		if (isset($_POST['post_id'])){

			$post_id = $_POST['post_id'];
			$comment_time = date("Y-m-d H:i:s",$_POST['reply_id']);
			global $con;
		
			$query = mysqli_query($con,"SELECT * FROM reply WHERE post_id = '".$post_id."' AND update_timestamp > '".$comment_time."' ORDER BY update_timestamp");
			// $i=0;

			while($row1 = mysqli_fetch_array($query)){
				include "comments.php";
			}
		}

		// else{
			// echo "Mazaak: Give me the details to fetch data";
		// }
	}

	if(isset($_POST['top_reply'])){
		$post_id = $_POST['post_id'];
		$comment_time = date("Y-m-d H:i:s",$_POST['top_reply']);
		$query = mysqli_query($con,"SELECT * FROM reply WHERE post_id = '".$post_id."' AND update_timestamp < '".$comment_time."' ORDER BY update_timestamp");
			// $i=0;
		if($query){
			while($row1 = mysqli_fetch_array($query)){
				include "comments.php";
			}
			// echo "</div></div>";
		}
	}

	mysqli_close($con);
?>