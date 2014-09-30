<?php
		$hidden=checkhidden($con,$row['post_id']);
		if($hidden!="true"){
			echo "<div id=".strtotime($row['update_timestamp']).">"; //div id stores unixtimestamp of the post

			echo "<div class='posts' id=".$row['post_id'].">";

			echo "<div class='post_main'>";
			//post head start
			echo "<div class='post_head'>";
			echo "<img src='dummy_pic/dummypic.png' class='post_user_icon'>";

			if($row['user_id']!=0){
				$powner_result=mysqli_query($con,"select firstname,lastname from user where user_id='".$row['user_id']."'");
				$owner_row=mysqli_fetch_array($powner_result);
				$post_owner=$owner_row['firstname']." ".$owner_row['lastname'];
			}

			else{
				$post_owner="Invalid User";
			}

			$pownership=checkpowner($con,$row['post_id']);
			echo "<div class='post_title'><span class='post_owner'>";
			
			if($pownership=="post"){
				if($row['anon']=="1") echo "Anonymous (ME)";
				else echo $post_owner;
			}
			else{
				if($row['anon']=="1") echo "Anonymous";
				else echo $post_owner;
			}

			echo "</span><span class='post_format'> started a discussion</span></div>";
			echo "<div class='post_time'>".$row['update_timestamp']."</div>";
			echo "</div>";
			//post head end

			//tag start
			echo "<div class='post_tag'><span>Computer Science</span></div><div class='tag_out'></div>";
			//tag end

			//msg start
			echo "<div class='post_msg'>".$row['text_msg']."</div>";
			//msg end
			//msg edit
			echo "<div class='post_edit'>";
			echo "<textarea class='edit_area'></textarea>";
			echo "<div class='edit_toolbar'><button class='edit_done'>Done</button><button class='edit_cancel'>Cancel</button></div>";
			echo "</div>";
			//msg edit


			//tools start
			echo "<div class='post_tools'>";

			echo "<div class='post_like'>";

			include "postlikes.php";
			// echo "<div class='like_number'>10</div>";
			echo "</div>";

			//setting 
			if($row['privacy']=="student") $iname="user";
			else if($row['privacy']=="faculty") $iname="list";
			else if($row['privacy']=="onlyme") $iname="accs";
			else $iname="stat";
			if($pownership=="post"){
			echo "<div class='posttool-select'><span class='field'><i class='icon ".$iname."'></i></span><input id='open' type='checkbox' /><ul class='select'><li class='icon arrow selitem'></li><li class='selitem'>Only Faculty<i class='icon candidate_icon list'></i></li><li class='selitem'>Only Students<i class='icon candidate_icon user'></i></li><li class='selitem'>Campus<i class='icon candidate_icon stat'></i></li><li class='selitem'>Only Me<i class='icon candidate_icon accs'></i></li></ul><div class = 'card-tag'>
				<div class = 'tag-wedge'></div><div class = 'tag-box'><span></span></div></div></div>";
			}
			else {
				echo "<div class='posttool-select'><span class='field'><i class='icon ".$iname."'></i></span><div class = 'card-tag'>
				<div class = 'tag-wedge'></div><div class = 'tag-box'><span></span></div></div></div>";
			}

			echo "<div class = 'post_functions'>";
				echo "<div class = 'post_functions_showr'>";
				
				echo "</div>";
				echo "<div class = 'post_functions_box'>";

				if($pownership!="post"){
					echo "<div class = 'post_functions_option option_report'>";
						echo "Report this Post";
					echo "</div>";	
					echo "<hr class = 'post_options_hr'>";
				}

				if($pownership=="post"){
					echo "<div class = 'post_functions_option option_edit'>";
						echo "Edit this Post";
					echo "</div>";	
					echo "<hr class = 'post_options_hr'>";
				}

				if($pownership!="post"){
					echo "<div class = 'post_functions_option option_hide'>";
						echo "Hide this Post";
					echo "</div>";
					// echo "<hr class = 'post_options_hr'>";
				}

				if($pownership=="post"){
					echo "<div class = 'post_functions_option option_delete'>";
						echo "Delete this Post";
					echo "</div>";
				}

				echo "</div>";	
			echo "</div>";
			echo "</div>";
			//tools end
			echo "</div>";
			//post main part end


			$reply_query = "select * from reply where post_id='".$row['post_id']."' ORDER BY update_timestamp";
			$reply_result = mysqli_query($con,$reply_query);

			echo "<div class='comments'>";

			if($reply_result->num_rows){

				while($row1 = mysqli_fetch_array($reply_result)){

					include "includes/comments.php";
				}
			}
			else{
				echo "<div id='0000000000'></div>";
			}
			echo "</div>";

			echo "<div class='postcomment'>";
			echo "<div class='commentform'>";
    		// need to supply post id with hidden field
    		echo "<input type='hidden' id='post_id' value='".$row['post_id']."'>";

    	    echo "<img src='dummy_pic/dummypic.png' class='reply_user_icon'>";

      		echo "<textarea class='form-control postval' rows='3' placeholder='Reply' required></textarea>";
    		echo "<img class='reply_attach' src='src/attach.png' >";
    		echo "<button class='submit reply_submit'>Reply</button>";

			echo "</div></div>";

			echo "</div> </div>";
		}
?>