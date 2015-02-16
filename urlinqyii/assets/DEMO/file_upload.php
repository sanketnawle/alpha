<?php
ob_start();
session_start();
include_once("include/includefiles.php");
$includepage = getInclucdePageFront(); 

$university_id=$_GET['univid'];;
$department_id=$_GET['deptid'];

if(isset($_POST['btnfileupload']) && $_POST['btnfileupload']=='Upload')
{
	$is_success =1;
	$file_name='';
	$file_description='';
	$visibility='';
	$university_id=$_POST['university_id'];
	$department_id=$_POST['department_id'];
	if(isset($_POST['file_name']) && $_POST['file_name']!=''){
		$file_name=$_POST['file_name'];
	}
	if(isset($_POST['file_description']) && $_POST['file_description']!=''){
		$file_description=$_POST['file_description'];
	}
	if(isset($_POST['visibility']) && $_POST['visibility']!=''){
		$visibility=$_POST['visibility'];
	}
	
	if($is_success ==1 && isset($_FILES['file']['name']))
	{
		if($is_success == 1 && $_FILES['file']['name'] != "")
		{
			$is_success = validateuploadfile("file");
		}
		if($is_success == 1 && $_FILES['file']['name'] != "")
		{
			$is_success = isuploadfile("file");
		}
	}
	if($is_success == 1  &&  isset($_FILES['file']['name']) && $_FILES['file']['name'] != "")
	{
		$orignalfilename=$_FILES['file']['name'];
		$uploadedfilename = moveuploadedfile("file",POSTSFILE_PATH);
		$ext=get_file_extension($uploadedfilename);
		if($uploadedfilename!='')
		{
			$student_id=0;
			$professor_id=0;
			if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Student')
			{
				$student_id=$_SESSION['student_id'];
				$userdetail=getstudentdetail($student_id);
			}
			elseif(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Professor')
			{
				$professor_id=$_SESSION['professor_id'];
				$userdetail=getprofessordetail($professor_id);
			}
			$message=$userdetail['name'].' uploaded a '.$ext.' file, <br />'.$orignalfilename.'';
			
			$update_timestamp=date("Y-m-d H:i:s");
			$sql="INSERT INTO department_posts_1 (studentid, profid,deptid,univid,message,visibility,update_timestamp,file,filelocation,file_ext,file_name,file_description) VALUES
			( ".$student_id.",".$professor_id.",".$department_id.",".$university_id.", '".addslashes($message)."', '".$visibility."','".$update_timestamp."','".$orignalfilename."','".$uploadedfilename."','".$ext."','".$file_name."','".$file_description."');";
			$insert_id =$dbObj->fireQuery($sql,'insert');
			$_SESSION["successmsg"] = 'File uploaded successfully.';
		}
			
	}
	redirect('file_upload.php?deptid='.$department_id.'&univid='.$university_id);
	exit;
}
$order_by='update_timestamp desc';
if(isset($_POST['sortby']) && $_POST['sortby']!='')
{
	$university_id=$_POST['university_id'];;
	$department_id=$_POST['department_id'];
	$order_by=$_POST['sortby'];
	
}
if(isset($_SESSION['usertype']) && $_SESSION['usertype']!='')
{
//////// Get all files list for this department.
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
$FilesListQry = "select * from department_posts_1 where deptid='".$department_id."' and file!='' and ((visibility='".$visibility."' OR visibility='Public') OR (`".$field_name."`='".$user_id."')) order by ".$order_by."";
$fileListRes = $dbObj->fireQuery($FilesListQry,'select');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Urlinq</title>
<link rel="stylesheet" type="text/css" href="css/files.css">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>
<script src="js/modernizr.custom.63321.js"></script>
<script type="text/javascript" src="js/jquery.dropdown.js"></script>
<link rel="stylesheet" type="text/css" href="css/dropdown.css">

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<script language="javascript" type="text/javascript">

    $(document).ready(function() {

        $(document).delegate(".docmain","mouseover",function(){
   $(this).find(".docicon").css({"opacity":"0.6"});
   $(this).find(".ifdiv").stop().fadeTo( 'fast', 0.85);
   });
$(document).delegate(".docmain","mouseout",function(){
   $(this).find(".docicon").css({"opacity":"1"});
   $(this).find(".ifdiv").stop().fadeTo( 'fast', 0);
   });


    $(document).delegate('.likepic',"mouseover", function(){
    	if($(this).hasClass('liked')){}else{
    	$(this).attr("src","images/liked-button.png");
    	$(this).css("opacity","1");
    	}
    });
        $(document).delegate('.likepic',"mouseout", function(){
        if($(this).hasClass('liked')){}else{
    	$(this).attr("src","images/like.png");
    	$(this).css("opacity","1");
    	}
    });


        $(document).delegate('.downloadfile',"mouseover", function(){
    	//if($(this).hasClass('liked')){}else{
    	$(this).attr("src","images/downloaded-button.png");
    	$(this).css("opacity","1");
    	//}
    });
        $(document).delegate('.downloadfile',"mouseout", function(){
        //if($(this).hasClass('liked')){}else{
    	$(this).attr("src","images/download-button.png");
    	$(this).css("opacity","1");
    	//}
    });



    });
</script>
</head>
<body>
 <div id="coursec">
 	<?php
	if(isset($_SESSION['usertype']) && $_SESSION['usertype']!='')
	{
	?>
	<div class="error_msg">
	<?php 	if(isset($_SESSION['errormsg']) && $_SESSION['errormsg']!=''){ echo $_SESSION['errormsg']; unset($_SESSION['errormsg']); } ?>
	</div>
	<div class="success_msg">
	<?php
	if(isset($_SESSION['successmsg']) && $_SESSION['successmsg']!=''){ echo $_SESSION['successmsg']; unset($_SESSION['successmsg']); } 
	?>
	</div>
	

	<!-- the upload form html, commented because may need a new one
	<div id="searchblock">
		<div id="searchborder">
		<form name="frmfileupd" id="frmfileupd" action="" method="post" enctype="multipart/form-data">
		<input type="hidden" name="department_id" id="department_id" value="<?php echo $department_id; ?>" />
		<input type="hidden" name="university_id" id="university_id" value="<?php echo $university_id; ?>" />
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
		  <tr>
			<td align="right" width="25%">Name:</td>
			<td><div id="form-input"><input type="text" name="file_name" id="file_name"></div></td>
		  </tr>
		  <tr>
			<td align="right" >Description:</td>
			<td><div id="form-input"><textarea id="file_description" name="file_description" ></textarea></div></td>
		  </tr>
		  <tr>
			<td align="right" >Visibility:</td>
			<td><div id="form-input">
		<select name="visibility" id="visibility">
		<option value="Public">Public</option>
		<option value="Student">Student</option>
		<option value="Faculty">Faculty</option>
		</select></div></td>
		  </tr>
		  <tr>
			<td align="right" >File:</td>
			<td><div id="form-input"><input type="file" name="file" id="file"></div></td>
		  </tr>
		  <tr>
			<td colspan="2" align="center"><div id="form-button"><input type="submit" name="btnfileupload" id="btnfileupload" value="Upload"></div></td>
		  </tr>
		</table>
		</form>
		</div>
    </div>
	-->

	<div id="documents">
 
 	<div class="dochead" >
		<form name="frmsort" id="frmsort" method="post" action="">
		<input type="hidden" name="department_id" id="department_id" value="<?php echo $department_id; ?>" />
		<input type="hidden" name="university_id" id="university_id" value="<?php echo $university_id; ?>" />
		<table width="100%" border="0" cellpadding="5">
  		<tr>
    		<td align="left" width="8.5%">Sort By &nbsp;</td>

    	<td class="sortoption"><select name="sortby" id="sortby" onchange="sortresult(this.value);">
		<option value="">Select</option>
		<option value="file_ext asc" <?php if($order_by=='file_ext asc'){ echo 'selected="selected"'; } ?> >File Type (Ascending)</option>
		<option value="file_ext desc" <?php if($order_by=='file_ext desc'){ echo 'selected="selected"'; } ?> >File Type (Descending)</option>
		<option value="update_timestamp asc" <?php if($order_by=='update_timestamp asc'){ echo 'selected="selected"'; }?>>Upload Time (Ascending)</option>
		<option value="update_timestamp desc" <?php if($order_by=='update_timestamp desc'){ echo 'selected="selected"'; }?>>Upload Time (Descending)</option>
		</select></td>

		</tr>
		</table>
		</form>
		</div>
 	<?php 
		  $img_exts=array("gif","png","jpg","jpeg")	;
		   if(isset($fileListRes) && $fileListRes!=false && count($fileListRes)>0)
		   {
		  	 for($i=0;$i<count($fileListRes);$i++)
			 {

			 	$file=$fileListRes[$i]['file'];
				$file_ext=$fileListRes[$i]['file_ext'];
				$file_name=$fileListRes[$i]['file_name'];
				$filelocation=$fileListRes[$i]['filelocation'];
				$file_description=$fileListRes[$i]['file_description'];
				$file_date=$fileListRes[$i]['update_timestamp'];

				$fd_temp=explode(' ',$file_date);
				$file_date=implode('/',explode('-',$fd_temp[0]));	
				
				$fd_year= substr($file_date,0,4);	
				$fd=substr($file_date,5);

				$file_date=$fd.'/'.$fd_year;


			


				?>
					<div class="docmain">
            		<div class="iconframe">

            			<div class="ifdiv">
                   		<a href="<?php echo $SITE_URL.'download.php?filename='.base64_encode($filelocation); ?>" class="external-link" target="_blank"><img src="images/download-button.png" class="like filelike downloadfile"></a>
                   		<a href="Javascript:void(0)" ><img class="likepic" id="leclike-1" src="images/like-button.png"></a><span class="likenum">10</span>

						</div>
                	     <?php 
						   if(in_array(strtolower($file_ext),$img_exts))
						   {
						   if($filelocation!='' && file_exists(POSTSFILE_PATH.$filelocation)){ ?>
						   <a href="Javascript:void(0);" onclick="opendetail('#file_detail_<?php echo $i; ?>');"><img  src="<?php echo POSTSFILE_URL.$filelocation; ?>"></a>
						   <?php }
						   }
						   else
						   {

								$icon_file='';
								if(strtolower($file_ext)=='pdf'){$icon_file='pdf_icon.jpg';}
								if(strtolower($file_ext)=='doc' || strtolower($file_ext)=='docx'){$icon_file='docx_icon.jpg';}
								if(strtolower($file_ext)=='xls' || strtolower($file_ext)=='xlsx'){$icon_file='xlsx_icon.jpg';}
								if(strtolower($file_ext)=='mp3'){$icon_file='mp3_icon.jpg';}
								if(strtolower($file_ext)=='rar'){$icon_file='rar_icon.jpg';}
								if(strtolower($file_ext)=='zip' || strtolower($file_ext)=="gzip"){$icon_file='zip_icon.jpg';}
								?> 
								
								<a href="Javascript:void(0);" onclick="opendetail('#file_detail_<?php echo $i; ?>');">
								<div class="docicon">
									<div class="circ">
									<img src="images/file_icons/<?php echo $icon_file; ?>">
									</div>
								</div>
								</a>
								
								<?php
						   }
						  ?>
					    
					</div>
                	<div class="docdes">
                		<!--<a class="whitehref" href="Javascript:void(0);" onclick="opendetail('#file_detail_<?php echo $i; ?>');"><?php if($file_name!=''){ echo substr($file_name,0,12);}else{ echo substr($file,0,12);} ?></a>-->
                	
                		This is a dummy description for the file
            		
						<br/>
             			<span class="f_date"><?php echo $file_date; ?></span> 
                	</div>

       			</div>
					<div style="width:auto;height:auto;overflow: auto;position:relative;display:none;">
					<div id="file_detail_<?php echo $i; ?>" >
					<div class="resource-content">
						<div class="title"><strong><?php if($file_name!=''){ echo $file_name;}else{ echo $file;} ?></strong></div>
						<div class="description"><?php echo $file_description; ?></div>
						<div class="download-link">
							<a href="<?php echo $SITE_URL.'download.php?filename='.base64_encode($filelocation); ?>" class="external-link" target="_blank"><img src="images/download-button.png" class="like filelike"></a>
						</div>
					</div>
					</div>
					</div>
				
				<?php
			 }
		   }
	 ?>
	 </div>
 	</div>
 	<?php }else{?>
	<div>Please <a href='index.php' target='_parent'>login</a> to upload & download documents.</div>
	<?php }?>
 </div> 

<script language="javascript" type="text/javascript">
function opendetail(contentid)
{
var content = $(contentid).html();
$.fancybox({
      'content': content,
      'padding' : 20
  });
}
function sortresult(sorttype)
{
if(sorttype!='')
{
	document.frmsort.submit();
}
}
</script>

</body>
</html>
