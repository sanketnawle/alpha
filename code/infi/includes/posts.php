<?php

			echo "<div id=".strtotime($row['update_timestamp']).">"; //div id stores unixtimestamp of the post

			echo "<div class='posts' id=".$row['messageid'].">";

			echo "<div class='post_main'>";
			//post head start
			echo "<div class='post_head'>";
			echo "<img src='dummy_pic/dummypic.png' class='post_user_icon'>";

			if($row['studentid']!=0){
				$powner_result=mysqli_query($con,"select name from student_1 where studentid='".$row['studentid']."'");
				$owner_row=mysqli_fetch_array($powner_result);
				$post_owner=$owner_row['name'];
			}
			else if($row['profid']!=0){
				$powner_result=mysqli_query($con,"select name from professor_1 where profid='".$row['profid']."'");
				$owner_row=mysqli_fetch_array($powner_result);
				$post_owner=$owner_row['name'];
			}
			else{
				$post_owner="Invalid User";
			}

			echo "<div class='post_title'><span class='post_owner'>".$post_owner."</span><span class='post_format'> posted a news</span></div>";
			echo "<div class='post_time'>".$row['update_timestamp']."</div>";
			echo "</div>";
			//post head end

			//tag start
			echo "<div class='post_tag'><span>Computer Science</span></div><div class='tag_out'></div>";
			//tag end

			//msg start
			echo "<div class='post_msg'>".$row['message']."</div>";
			//msg end

			//tools start
			echo "<div class='post_tools'>";
			echo "<div class='post_like'><img src='src/like-button.png'><div class='like_number'>10</div></div>";
			echo "<button class='post_follow'>Follow</button>";
			echo "</div>";
			//tools end
			echo "</div>";
			//post main part end


			$reply_query = "select * from home_reply where messageid='".$row['messageid']."' ORDER BY update_timestamp";
			$reply_result = mysqli_query($con,$reply_query);

			echo "<div class='comments'>";

			if($reply_result->num_rows){

				while($row1 = mysqli_fetch_array($reply_result)){

					echo "<div class='post_comment' id='".strtotime($row1['update_timestamp'])."'>";
					echo "<img src='dummy_pic/dummypic.png' class='comment_user_icon'>";

			if($row1['studentid']!=0){
				$cowner_result=mysqli_query($con,"select name from student_1 where studentid='".$row1['studentid']."'");
				$cowner_row=mysqli_fetch_array($cowner_result);
				$comment_owner=$cowner_row['name'];
			}
			else if($row1['profid']!=0){
				$cowner_result=mysqli_query($con,"select name from professor_1 where profid='".$row1['profid']."'");
				$cowner_row=mysqli_fetch_array($cowner_result);
				$comment_owner=$cowner_row['name'];
			}
			else{
				$comment_owner="Invalid User";
			}

					echo "<div class='comment_main'><span class='comment_owner'>".$comment_owner."</span> "."<span class='comment_msg'>".$row1['replymessage']."</span></div>";
					
					echo "<br><div class='comment_time'>".$row1['update_timestamp']."</div>";
					echo "<div class='comment_like'><img src='src/like-button.png'><div class='comment_like_number'>10</div></div>";

					echo "</div>";
				}
			}
			else{
				echo "<div id='0000000000'></div>";
			}
			echo "</div>";

			echo "<div class='postcomment'>";
			echo "<div class='commentform'>";
    		// need to supply post id with hidden fild
    		echo "<input type='hidden' id='messageid' value='".$row['messageid']."'>";

    	    echo "<img src='dummy_pic/dummypic.png' class='reply_user_icon'>";

      		echo "<textarea class='form-control postval' rows='3' placeholder='Reply' required></textarea>";
    		echo "<img class='reply_attach' src='src/attach.png' >";
    		echo "<button class='submit reply_submit'>reply</button>";

			echo "</div></div>";

			echo "</div> </div>";
?>