<?php 
ob_start();
session_start();
include_once("include/includefiles.php");
$includepage = getInclucdePageFront(); 
$forumList=array();
if(isset($_SESSION['usertype']) && $_SESSION['usertype']!='')
{
if(isset($_POST['deptid']) && $_POST['deptid']!='' && isset($_POST['univid']) && $_POST['univid']!='')
{
	$deptid=$_POST['deptid'];
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
	$forumListQry = "select * from  department_posts_1 where deptid='".$deptid."' and univid='".$univid."' and (visibility='".$visibility."' OR visibility='Public') OR (`".$field_name."`='".$user_id."') order by update_timestamp desc ";
	$forumListRes = $dbObj->fireQuery($forumListQry,'select');
	if(isset($forumListRes) && count($forumListRes)>0 && $forumListRes!=false)
	{
		for($i=0;$i<count($forumListRes);$i++){
		$messageid=$forumListRes[$i]['messageid'];
			$studentid=$forumListRes[$i]['studentid'];
			$profid=$forumListRes[$i]['profid'];
			$deptid=$forumListRes[$i]['deptid'];
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
		$forumreplyListQry = "select * from  department_reply_".$deptid." where messageid='".$messageid."' order by update_timestamp desc ";
		$forumreplyListRes = $dbObj->fireQuery($forumreplyListQry,'select');
			if(isset($file) && $file!=''){ ?>		
			<div class="post_0">
            <div class="p_0">
				<a href="" id="pb_0" class="pb">
					<img class="p-photo" src="<?php echo $imagepath; ?>">
				</a>
            <div class="p-main">
                <button id="post_tag_0" class="tags">Document<div class="outpart"></div></button>
                
                <div class="p-mainhead">
				<a href="" id="pb_1" class="pb"><span><?php echo $username; ?></span></a> uploaded <?php echo time_passed(strtotime($update_timestamp));?>
				</div>
                <div class="doc">
                    <img src="images/doc-icon-2.png" id="docicon">
                        <div class="docdes"><?php if($file_name!=''){ echo $file_name;}else{ echo $file;} ?></div>
                        <div class="doctail">
						<?php 
						//////// Check if user already like this post then unlike it 
						$sel_sql="SELECT count(*) as total_likes,dep_post_lkid  FROM `department_posts_likes_1` where postid='".$messageid."' and studentid='".$studentid."' and profid='".$profid."'";
						$sel_cnt=$dbObj->fireQuery($sel_sql,'select');
						if($sel_cnt[0]['total_likes']>0)
						{
							$like_img='<img class="like liked" id="doclike_0" src="images/liked-button.png">';
						}
						else
						{
							$like_img='<img src="images/like.png" id="doclike_0" class="like" alt="">';
						}
						?>
						<a href="Javascript:void(0)" onclick="likethepost('<?php echo $messageid; ?>','post');" ><?php echo $like_img; ?></a>
						<a href="<?php echo $SITE_URL.'download.php?filename='.base64_encode($filelocation); ?>" class="external-link" target="_blank"><img src="images/download-button.png" class="download" id="docdown_0"></a>
						<br class="clear" />&nbsp;&nbsp;
						<?php if(($_SESSION['usertype']=='Student' && $user_id==$studentid) || ($_SESSION['usertype']=='Professor' && $user_id==$profid)){?>
						<a href="javascript:void(0)" onclick="deletepost('<?php echo $messageid; ?>');"><img src="images/delete.png" /></a>
						<?php }?>
						</div>
                        <div class="clear"></div>
              </div>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
			<?php 
				if(isset($forumreplyListRes) && $forumreplyListRes!=false && count($forumreplyListRes)>0)
				{
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
						<div class="p-comment">
               			 <a href="" id="pb_2" class="pb"><img width="52" height="52" id="c-photo" src="<?php echo $reply_imagepath;?>"></a>
                			<div class="c-main"><a href="" id="pb_3" class="pb"><span class="spanhead"><?php echo $reply_userdetail['name']; ?></span></a>
                    		<?php echo $reply_msg; ?>
                    		<br><span class="spanfoot"><?php echo time_passed(strtotime($reply_update_timestamp));?></span>
							<?php
							/////// Check if user already like this comment then unlike it 
							$sel_sql="SELECT count(*) as total_likes,dep_reply_lkid FROM `department_reply_likes_1` where replyid='".$replyid."' and studentid='".$studentid."' and profid='".$profid."'";
							$sel_cnt=$dbObj->fireQuery($sel_sql,'select');
							if($sel_cnt[0]['total_likes']>0)
							{
								$like_img='<img class="like liked" id="likecomment_0" src="images/liked-button.png">';
							}
							else
							{
								$like_img='<img src="images/like.png" id="likecomment_0" class="like" alt="">';
							}
							?>
							<a href="Javascript:void(0)" onclick="likethepost('<?php echo $replyid; ?>','reply');"><?php echo $like_img; ?></a><span>(<?php echo $reply_like_cnt; ?>)</span>
                			</div>
            			</div>
           				<div class="clear"></div>
						<?php
					}
				}
			?>
            <div class="makecomment_0">
                	<input name="comment" class="comment-textarea mc_0" type="text" id="mc_<?php echo $messageid; ?>" placeholder="Write a comment..."/>
					<div class="mcp_0"><a href="Javascript:void(0)" onclick="savecomments('<?php echo $messageid; ?>')" class="greyhref2">Post</a></div>
                    <div class="clear"></div>
           </div>
            <div class="clear"></div>
    		</div>
			</div>
			<div class="clear"></div>
			<?php }
			else{?>
			<div class="post_1">
				<a href="" id="pb_0" class="pb">
					<img class="p-photo" width="52" height="52" src="<?php echo $imagepath; ?>">
				</a>
			<div class="p-main-1">
				<button id="post_tag_1" class="tags">Lecture<div class="outpart"></div></button>
				<div class="p-mainhead-1"><a href="" id="pb_1" class="pb"><span><?php echo $username; ?></span></a> posted <?php echo time_passed(strtotime($update_timestamp));?> </div>
				<div class="maincontent-1"><span><?php echo $message;?></span>
				<?php 
						//////// Check if user already like this post then unlike it 
						$sel_sql="SELECT count(*) as total_likes,dep_post_lkid  FROM `department_posts_likes_1` where postid='".$messageid."' and studentid='".$studentid."' and profid='".$profid."'";
						$sel_cnt=$dbObj->fireQuery($sel_sql,'select');
						if($sel_cnt[0]['total_likes']>0)
						{
							$like_img='<img class="like liked" id="leclike-1" src="images/liked-button.png">';
						}
						else
						{
							$like_img='<img src="images/like.png" id="leclike-1" class="like" alt="">';
						}
						?>
				<a href="Javascript:void(0)" onclick="likethepost('<?php echo $messageid; ?>','post');">
					<?php echo $like_img; ?>
					</a><span>(<?php echo $like_cnt; ?>)</span>
				<?php if(($_SESSION['usertype']=='Student' && $user_id==$studentid) || ($_SESSION['usertype']=='Professor' && $user_id==$profid)){?>
				<a href="javascript:void(0)" onclick="deletepost('<?php echo $messageid; ?>');"><img src="images/delete.png" /></a>
				<?php }?>
				</div>
			</div>
			<?php 
				if(isset($forumreplyListRes) && $forumreplyListRes!=false && count($forumreplyListRes)>0)
				{
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
						<div class="p-comment">
               			 <a href="" id="pb_2" class="pb"><img width="52" height="52" id="c-photo" src="<?php echo $reply_imagepath;?>"></a>
                			<div class="c-main"><a href="" id="pb_3" class="pb"><span class="spanhead"><?php echo $reply_userdetail['name']; ?></span></a>
                    		<?php echo $reply_msg; ?>
                    		<br><span class="spanfoot"><?php echo time_passed(strtotime($reply_update_timestamp));?></span>
							<?php
							/////// Check if user already like this comment then unlike it 
							$sel_sql="SELECT count(*) as total_likes,dep_reply_lkid FROM `department_reply_likes_1` where replyid='".$replyid."' and studentid='".$studentid."' and profid='".$profid."'";
							$sel_cnt=$dbObj->fireQuery($sel_sql,'select');
							if($sel_cnt[0]['total_likes']>0)
							{
								$like_img='<img class="like liked" id="likecomment_0" src="images/liked-button.png">';
							}
							else
							{
								$like_img='<img src="images/like.png" id="likecomment_0" class="like" alt="">';
							}
							?>
							<a href="Javascript:void(0)" onclick="likethepost('<?php echo $replyid; ?>','reply');"><?php echo $like_img; ?></a><span>(<?php echo $reply_like_cnt; ?>)</span>
                			</div>
            			</div>
           				<div class="clear"></div>
						<?php
					}
				}
			?>
			<div class="p-comment-1">
				<div class="makecomment_1">
					<input name="comment" class="comment-textarea mc_1" type="text" id="mc_<?php echo $messageid; ?>" placeholder="Write a comment..."/>
					<div class="mcp_1"><a href="Javascript:void(0)" onclick="savecomments('<?php echo $messageid; ?>')" class="greyhref2">Post</a></div>
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