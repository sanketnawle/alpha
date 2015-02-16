<?php 
ob_start();
session_start();
include_once("include/includefiles.php");
$includepage = getInclucdePageFront(); 
$forumList=array();
if(isset($_SESSION['usertype']) && $_SESSION['usertype']!='')
{
if(isset($_POST['univid']) && $_POST['univid']!='')
{
	$univid=$_POST['univid'];
	if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Student')
	{
		$visibility='Student';
		$user_id=$_SESSION['student_id'];
		$field_name='studentid';
	}
	elseif(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Professor')
	{
		$visibility='Faculty';
		$user_id=$_SESSION['professor_id'];
		$field_name='profid';
	}
	///////// get all forums for professor /////////
	$forumListQry = "select * from  home_posts where univid='".$univid."' and (visibility='".$visibility."' OR visibility='Public') OR (`".$field_name."`='".$user_id."') order by update_timestamp desc ";
	$forumListRes = $dbObj->fireQuery($forumListQry,'select');
	if(isset($forumListRes) && count($forumListRes)>0 && $forumListRes!=false)
	{
		for($i=0;$i<count($forumListRes);$i++){
		$messageid=$forumListRes[$i]['messageid'];
			$studentid=$forumListRes[$i]['studentid'];
			$profid=$forumListRes[$i]['profid'];
			$univid=$forumListRes[$i]['univid'];
			$message=$forumListRes[$i]['message'];
			
			$file=$forumListRes[$i]['file'];
			$file_ext=$forumListRes[$i]['file_ext'];
			$file_name=$forumListRes[$i]['file_name'];
			$filelocation=$forumListRes[$i]['filelocation'];
			$file_description=$forumListRes[$i]['file_description'];
				
			$update_timestamp=$forumListRes[$i]['update_timestamp'];
			$like_cnt=$forumListRes[$i]['like_cnt'];
			if($profid>0)
			{
				$userdetail=getprofessordetail($profid);
			}
			elseif($studentid>0)
			{
				$userdetail=getstudentdetail($studentid);
			}
			$imagepath=$SITE_URL.'images/noimage.jpg';
			if(isset($userdetail) && count($userdetail)>0)
			{
				$username= $userdetail['name'];
				$profilepic= $userdetail['profilepic'];
				$location   = $userdetail['location'];
				if(isset($profilepic) && $profilepic!='')
				{
					$filepath=$SITE_PATH.$location.'/'.$profilepic;
					if(file_exists($filepath))
					{
						$imagepath=$SITE_URL.$location.'/'.$profilepic;
					}
				}
			}
		//////////// get all replay of the post update desc
		$forumreplyListQry = "select * from  home_reply where messageid='".$messageid."' order by update_timestamp desc ";
		$forumreplyListRes = $dbObj->fireQuery($forumreplyListQry,'select');
			if(isset($file) && $file!=''){ ?>		
			<div class="post">
				<?php if(($_SESSION['usertype']=='Student' && $user_id==$studentid) || ($_SESSION['usertype']=='Professor' && $user_id==$profid)){?>
				<a href="javascript:void(0)" onclick="deletepost('<?php echo $messageid; ?>');"><img class="p-hide" src="images/exit-btn.png"></a>
				<?php }?>
                 <button class="post_tag tags">Document<div class="outpart"></div></button>
				 <div class="post_head">
            		<img width="52" height="52" src="<?php echo $imagepath; ?>" class="post_photo">
            			<div class="post_name"><?php echo $username; ?></div>
            		<div class="post_des">Posted <?php echo time_passed(strtotime($update_timestamp));?></div>
        		</div>
				 <div class="post_text">
					<div class="post_say">
					<div class="doc">
                    <img src="images/doc-icon-2.png" class="docicon">
                        <div class="docdes"><?php if($file_name!=''){ echo $file_name;}else{ echo $file;} ?></div>
                        <div class="doctail">
						<?php 
						//////// Check if user already like this post then unlike it 
						$sel_sql="SELECT count(*) as total_likes,home_post_lkid  FROM `home_posts_likes` where postid='".$messageid."' and studentid='".$studentid."' and profid='".$profid."' and univid='".$univid."'";
						$sel_cnt=$dbObj->fireQuery($sel_sql,'select');
						if($sel_cnt[0]['total_likes']>0)
						{
							$like_img='<img class="likepic likeinfile liked" id="leclike-1" src="images/liked-button.png">';
						}
						else
						{
							$like_img='<img src="images/like.png" id="leclike-1" class="likepic likeinfile" alt="">';
						}
						?>
						<a href="Javascript:void(0)" onclick="likethepost('<?php echo $messageid; ?>','post');" ><?php echo $like_img; ?></a>
						<a href="<?php echo $SITE_URL.'download.php?filename='.base64_encode($filelocation); ?>" class="external-link" target="_blank"><img src="images/download-button.png" class="download" id="docdown_0"></a>
						<br class="clear" />&nbsp;&nbsp;
						</div>
                        <div class="clear"></div>
              			</div>
			  		</div>
               </div>
			   
            <div class="post_content">
			<div class="like"></div>
			<?php 
				if(isset($forumreplyListRes) && $forumreplyListRes!=false && count($forumreplyListRes)>0)
				{
					$cmt=0;
					?><div class="comment"><?php
					foreach($forumreplyListRes as $repcnt=>$replymsg)
					{
						$replyid=$replymsg['replyid'];
						$reply_msg=$replymsg['replymessage'];
						$reply_update_timestamp=$replymsg['update_timestamp'];
						$reply_studid=$replymsg['studentid'];
						$reply_profid=$replymsg['profid'];
						$reply_like_cnt=$replymsg['like_cnt'];
						if($reply_profid>0)
						{
							$reply_userdetail=getprofessordetail($reply_profid);
						}
						elseif($reply_studid>0)
						{
							$reply_userdetail=getstudentdetail($reply_studid);
						}
						$reply_imagepath=$SITE_URL.'images/noimage.jpg';
						if(isset($userdetail) && count($userdetail)>0)
						{
							
							$profilepic= $reply_userdetail['profilepic'];
							$location   = $reply_userdetail['location'];
							if(isset($profilepic) && $profilepic!='')
							{
								$filepath=$SITE_PATH.$location.'/'.$profilepic;
								if(file_exists($filepath))
								{
									$reply_imagepath=$SITE_URL.$location.'/'.$profilepic;
								}
							}
						}
						?>
						<?php if($cmt==1){ ?>
						<div id="comment_<?php echo $messageid; ?>" style="display:none;">
						<?php }?>
							<div class="cmt-view">
								<div class="cmt_head">
									<img src="<?php echo $reply_imagepath;?>" width="52" height="52" class="cmt-photo"><span class="cmt-name"><?php echo $reply_userdetail['name']; ?></span>
									<span class="time"><?php echo time_passed(strtotime($reply_update_timestamp));?></span>
								</div>
								<div class="cmt-tail">
								<?php echo $reply_msg; ?>
								
								<?php
								/////// Check if user already like this comment then unlike it 
								$sel_sql="SELECT count(*) as total_likes,home_reply_lkid FROM `home_reply_likes` where replyid='".$replyid."' and studentid='".$studentid."' and profid='".$profid."'  and univid='".$univid."'";
								$sel_cnt=$dbObj->fireQuery($sel_sql,'select');
								if($sel_cnt[0]['total_likes']>0)
								{
									$like_img='<img class="like liked" id="likecomment_0" style="width:25px !important; height:25px !important;margin-left:0px !important; margin-top:0px !important;" src="images/liked-button.png">';
								}
								else
								{
									$like_img='<img src="images/like.png" id="likecomment_0" style="width:25px !important; height:25px !important;margin-left:0px !important; margin-top:0px !important" class="like" alt="">';
								}
								?>
								<br class="clear" />
								<a href="Javascript:void(0)" onclick="likethepost('<?php echo $replyid; ?>','reply');"><?php echo $like_img; ?></a> 
								<span><?php echo $reply_like_cnt; ?></span>
								</div>
							</div>
						<?php
						$cmt++;
					}
					if($cmt>1){?></div><?php } ?></div><?php
				}
			?>
			
			<?php if(count($forumreplyListRes)>1){ ?>
			<div class="view_more">
				<a href="Javascript:void(0);" id="message_<?php echo $messageid; ?>"><div class="viewmore">View More</div></a>
				<script language="javascript" type="text/javascript">
				$("#message_<?php echo $messageid; ?>").click(function(){
					//$(".pastclasslink").val()='See my current classes &#9652;';
					$("#comment_<?php echo $messageid; ?>").slideToggle("slow");
				});
				</script>
			</div>
			<?php }?>
			<div class="p-comment-1">
				<div class="makecomment_1">
					<input name="comment" class="comment-textarea mc_1" type="text" id="mc_<?php echo $messageid; ?>" placeholder="Add a comment..."/>
					<div class="mcp_1"><a href="Javascript:void(0)" onclick="savecomments('<?php echo $messageid; ?>')" class="greyhref2">Post</a></div>
				</div>
			</div>
			</div>
           
    		</div>
			
			<?php }else{?>
			
			<div class="post">
				<?php if(($_SESSION['usertype']=='Student' && $user_id==$studentid) || ($_SESSION['usertype']=='Professor' && $user_id==$profid)){?>
				<a href="javascript:void(0)" onclick="deletepost('<?php echo $messageid; ?>');"><img class="p-hide" src="images/exit-btn.png"></a>
				<?php }?>
				<button class="post_tag tags">Urlinq Event<div class="outpart"></div></button>
			
			<div class="post_head">
            	<img width="52" height="52" src="<?php echo $imagepath; ?>" class="post_photo">
            	<div class="post_name"><?php echo $username; ?></div>
            	<div class="post_des">Posted <?php echo time_passed(strtotime($update_timestamp));?></div>
        	</div>
			<div class="post_text">
            <div class="post_say"><?php echo $message;?></div>
			</div>
			<div class="post_content">
			<?php 
				$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
				if(preg_match($reg_exUrl, $message, $url)) 
				{
					if($url[0]!='')
					{
						echo '<a class="play" href="'.$url[0].'"></a>';
					}
				}
				
				?>
            <!--<a class="play" href="http://www.youtube.com/watch?v=K305Vu7hFg0"></a>-->
			
			<div class="like">
			<?php 
			//////// Check if user already like this post then unlike it 
			$sel_sql="SELECT count(*) as total_likes,home_post_lkid  FROM `home_posts_likes` where postid='".$messageid."' and studentid='".$studentid."' and profid='".$profid."' and univid='".$univid."'";
			$sel_cnt=$dbObj->fireQuery($sel_sql,'select');
			if($sel_cnt[0]['total_likes']>0)
			{
				$like_img='<img class="likepic liked" id="leclike-1" src="images/liked-button.png">';
			}
			else
			{
				$like_img='<img src="images/like.png" id="leclike-1" class="likepic" alt="">';
			}
			?>
			<a href="Javascript:void(0)" onclick="likethepost('<?php echo $messageid; ?>','post');"><?php echo $like_img; ?></a> 
			<div class="likes"><?php echo $like_cnt; ?></div>
			</div>
			<?php 
				if(isset($forumreplyListRes) && $forumreplyListRes!=false && count($forumreplyListRes)>0)
				{
					$cmt=0;
					?><div class="comment"><?php
					foreach($forumreplyListRes as $repcnt=>$replymsg)
					{
						$replyid=$replymsg['replyid'];
						$reply_msg=$replymsg['replymessage'];
						$reply_update_timestamp=$replymsg['update_timestamp'];
						$reply_studid=$replymsg['studentid'];
						$reply_profid=$replymsg['profid'];
						$reply_like_cnt=$replymsg['like_cnt'];
						if($reply_profid>0)
						{
							$reply_userdetail=getprofessordetail($reply_profid);
						}
						elseif($reply_studid>0)
						{
							$reply_userdetail=getstudentdetail($reply_studid);
						}
						$reply_imagepath=$SITE_URL.'images/noimage.jpg';
						if(isset($userdetail) && count($userdetail)>0)
						{
							
							$profilepic= $reply_userdetail['profilepic'];
							$location   = $reply_userdetail['location'];
							if(isset($profilepic) && $profilepic!='')
							{
								$filepath=$SITE_PATH.$location.'/'.$profilepic;
								if(file_exists($filepath))
								{
									$reply_imagepath=$SITE_URL.$location.'/'.$profilepic;
								}
							}
						}
						?>
						<?php if($cmt==1){ ?>
						<div id="comment_<?php echo $messageid; ?>" style="display:none;">
						<?php }?>
							<div class="cmt-view">
								<div class="cmt_head">
									<img src="<?php echo $reply_imagepath;?>" width="52" height="52" class="cmt-photo"><span class="cmt-name"><?php echo $reply_userdetail['name']; ?></span>
									<span class="time"><?php echo time_passed(strtotime($reply_update_timestamp));?></span>
								</div>
								<div class="cmt-tail">
								<?php echo $reply_msg; ?>
								
								<?php
								/////// Check if user already like this comment then unlike it 
								$sel_sql="SELECT count(*) as total_likes,home_reply_lkid FROM `home_reply_likes` where replyid='".$replyid."' and studentid='".$studentid."' and profid='".$profid."'  and univid='".$univid."'";
								$sel_cnt=$dbObj->fireQuery($sel_sql,'select');
								if($sel_cnt[0]['total_likes']>0)
								{
									$like_img='<img class="like liked" id="likecomment_0" style="width:25px !important; height:25px !important;margin-left:0px !important; margin-top:0px !important;" src="images/liked-button.png">';
								}
								else
								{
									$like_img='<img src="images/like.png" id="likecomment_0" style="width:25px !important; height:25px !important;margin-left:0px !important; margin-top:0px !important" class="like" alt="">';
								}
								?>
								<br class="clear" />
								<a href="Javascript:void(0)" onclick="likethepost('<?php echo $replyid; ?>','reply');"><?php echo $like_img; ?></a> 
								<span><?php echo $reply_like_cnt; ?></span>
								</div>
							</div>
						<?php
						$cmt++;
					}
					if($cmt>1){?></div><?php } ?></div><?php
				}
			?>
			<?php if(count($forumreplyListRes)>1){ ?>
			<div class="view_more">
				<a href="Javascript:void(0);" id="message_<?php echo $messageid; ?>"><div class="viewmore">View More</div></a>
				<script language="javascript" type="text/javascript">
				$("#message_<?php echo $messageid; ?>").click(function(){
					//$(".pastclasslink").val()='See my current classes &#9652;';
					$("#comment_<?php echo $messageid; ?>").slideToggle("slow");
				});
				</script>
			</div>
			<?php }?>
			<div class="p-comment-1">
				<div class="makecomment_1">
					<input name="comment" class="comment-textarea mc_1" type="text" id="mc_<?php echo $messageid; ?>" placeholder="Add a comment..."/>
					<div class="mcp_1"><a href="Javascript:void(0)" onclick="savecomments('<?php echo $messageid; ?>')" class="greyhref2">Post</a></div>
				</div>
			</div>
			</div>

			</div>
   			<div class="clear"></div>
			<?php
		  }
		}
	}
 }
}
else
{
	echo 'not_login';
}
?>