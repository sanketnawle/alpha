<?php
	require_once("dbconfig.php");
	// $pid='209';
	// $cid='13';

	function checkpowner($con,$pid){
		$pownerquery="SELECT * FROM posts WHERE post_id= '".$pid."' and user_id = ".$_SESSION['user_id'] ;
		$pownerresult=$con->query($pownerquery);
		// echo "*".mysqli_num_rows($pownerresult)."*";
		if($pownerresult->num_rows>0) return $pownership='post';
		// else echo 'none';

		return $pownership='none';
	}

		// echo $pownerquery="SELECT COUNT(post_id) FROM posts WHERE post_id= ? and user_id = ?" ; // $pid $_SESSION['user_id']
		// $pownerresult=mysqli_prepare($con,$pownerquery);
		// mysqli_bind_param($pownerresult, 'ii', $pid,$_SESSION['user_id']);
		// mysqli_execute($pownerresult);
		// mysqli_bind_result($pownerresult,$pownercount);

		// if($pownercount>0) return $pownership='post';

	function checkcowner($con,$cid){
		$cownerquery="SELECT * FROM reply WHERE reply_id= '".$cid."' and user_id = ".$_SESSION['user_id'] ;
		$cownerresult=$con->query($cownerquery);

		if($crow = $cownerresult->fetch_array()){
			if(checkpowner($con, $crow['post_id']) == "post") return 'post';
		}
		
		if(($cownerresult->num_rows)>0){
			return $cownership='reply';
		}
		// else echo 'none';

		return $cownership='none';
	}

	function checkhidden($con,$pid){
		$hidque="SELECT * FROM posts_hide WHERE post_id= '".$pid."' and user_id = ".$_SESSION['user_id'] ;
		if($hidres=$con->query($hidque))
			if($hidres->num_rows>0) return $hidden='true';
		// else echo 'none';

		return $hidden='false';
	}

	function rvotestatus($con,$replyid){
		$votestatus = "none"; //setting up default value

		// checking if user has voted
		$upstatusquery = "SELECT * FROM reply_votes WHERE user_id='".$_SESSION['user_id']."' AND reply_id='".$replyid."' AND vote_type = 'upvote'";
		$userupvotes = $con->query($upstatusquery); //Checks if currently loggedin user liked this status or not
		if($userupvotes){
			$upcount = $userupvotes->num_rows;
			if($upcount!=0) return $votestatus="upvoted";
		}
	
		// checking if user has downvoted
		if($votestatus!="upvoted"){
			$downstatusquery = "SELECT * FROM reply_votes WHERE user_id='".$_SESSION['user_id']."' AND reply_id='".$replyid."' AND vote_type = 'downvote'";
			$userdownvotes = $con->query($downstatusquery); //Checks if currently loggedin user liked this status or not
			if($userdownvotes){
				$downcount = $userdownvotes->num_rows;
					if($downcount!=0) return $votestatus="downvoted";
			}
		}
		return $votestatus;
	}

	function tar_tag($con,$target_type,$target_id){

		if(isset($target_tag)) $target_tag = NULL;
		
		if($target_type=="user"){
			$tar_q = $con->query("SELECT firstname, lastname FROM user WHERE user_id = ".$target_id);
			if($tar_q) {
				while ($tar_row = $tar_q->fetch_array()) {
					return $target_tag = $tar_row['firstname']." ".$tar_row['lastname'];
				}
			}
		}

		if($target_type=="courses"){
			$tar_q = $con->query("SELECT course_name FROM courses WHERE course_id = '".$target_id."'");
			if($tar_q) {
				while ($tar_row = $tar_q->fetch_array()) {
					return $target_tag = $tar_row['course_name'];
				}
			}
		}
	}

	function que_tag_list($con,$pid){
		// return $pid;
		$qtl_list = NULL;
		if(isset($qtl_list)) unset($qtl_list);
		$tag_list_q = $con->query("SELECT * FROM posts_questions WHERE post_id = ".$pid);
		if($tag_list_q){
			while ($qtl_row = $tag_list_q->fetch_array()){
				$qtl_list[] = $qtl_row;
				// echo $qtl_row['tag_type']." ".$qtl_row['tag_id'];
			}
			return $qtl_list;
		}
		else return $qtl_list = NULL;
	}

	function file_up_desc($con,$file_id){
		$ftype_q = $con->prepare("SELECT file_name,file_type FROM file_upload WHERE file_id = ?");
		$ftype_q->bind_param('i',$file_id);
		if($ftype_q->execute()){
			$ftype_q->bind_result($file_up['name'], $file_up['type']);
			$ftype_q->fetch();
			return $file_up;
		}
		return "Mazaak:lol";
	}

	// function file_content($con,$file_id){
	// 	$fcon_q = $con->prepare("SELECT file_content FROM file_upload WHERE file_id = ?");
	// 	$fcon_q->bind_param('s',$file_id);
	// 	if($fcon_q->execute()){
	// 		$fcon_q->bind_result($fcon);
	// 		$fcon_q->fetch();
	// 		echo $fcon;
	// 	}
	// }

	function file_content($con,$file_id){
		// echo "test";
		$fcon_q = $con->query("SELECT file_content FROM file_upload WHERE file_id =".$file_id);
		if($fcon_q){
			while($fcon = $fcon_q->fetch_array()){
				return $fcon['file_content'];
				// echo "<img src='data:image/jpeg;base64,".base64_encode($fcon['file_content'])."'>";
			}
		}
	}

	function autolink($string){
		/*** make sure there is an http:// on all URLs ***/
		$string = preg_replace("/([^\w\/])(www\.[a-z0-9\-]+\.[a-z0-9\-]+)/i", "$1http://$2"," ".$string);
		/*** make all URLs links ***/
		$string = preg_replace("/([\w]+:\/\/[\w-?&;#~=\.\/\@]+[\w\/])/i","<a target=\"_blank\" href=\"$1\">$1</A>",$string);
		/*** make all emails hot links ***/
		$string = preg_replace("/([\w-?&;#~=\.\/]+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?))/i","<A HREF=\"mailto:$1\">$1</A>",$string);

		return $string;
	}

	// Input should always have http or https, so this must be processed in autolink before it is fed into this function
	function detect_embed($string){
		preg_match("/([\w]+:\/\/[\w-?&;#~=\.\/\@]+[\w\/])/i",$string,$match);
		if(isset($match[0])){
			$string = preg_replace("/([\w]+:\/\/[\w-?&;#~=\.\/\@]+[\w\/])/i","<a class=\"play\" href=\"$1\">$1</A>",$match[0]);
			if(!is_null($string)) return $string;
		}
		else return NULL;
	}

// echo detect_embed("http://www.php.net/manual/en/function.preg-match.php hukk www.urlinq.com");
// file_content($con,1);
// echo $ftype=file_type($con,1);
// echo $pownership=checkpowner($con,$pid);
// echo $cownership=checkcowner($con,$cid);
// echo $hidden=checkhidden($con,$pid);
// echo $vs = rvotestatus($con,$cid);
// echo tar_tag($con, "courses", "AE4613");
// echo tar_tag($con, "user", 284);

?>