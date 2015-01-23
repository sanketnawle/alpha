<?php 
ob_start();
session_start();
include_once("include/includefiles.php");
$includepage = getInclucdePageFront(); 
$department_id=$_GET['deptid'];
$university_id=$_GET['univid'];
$searchcourse='';
//////// Get all courses for this department.
if(isset($_POST) && count($_POST)>0)
{
	$department_id=$_POST['deptid'];
	$university_id=$_POST['univid'];
	$searchcourse=$_POST['searchcourse'];
	if($searchcourse!='')
	{
		$coursesListQry = "select * from course_1 where deptid='".$department_id."' and universityid='".$university_id."' and name like '%".$searchcourse."%' order by name asc";	
	}
	else
	{
		$coursesListQry = "select * from course_1 where deptid='".$department_id."' and universityid='".$university_id."' order by name asc";
	}
	
}
else
{
	$coursesListQry = "select * from course_1 where deptid='".$department_id."' and universityid='".$university_id."' order by name asc";
}
$coursesListRes = $dbObj->fireQuery($coursesListQry,'select');
?>
<link rel="stylesheet" type="text/css" href="css/course.css">
<div id="coursec">
<?php 
if(isset($_SESSION['usertype']) && $_SESSION['usertype']!='')
{
?>
	<!--
    <div id="searchblock">
		<div id="searchborder">
		<form action="" method="post" name="frmsearch" id="frmsearch">
		<input type="hidden" name="deptid" id="deptid" value="<?php echo $department_id; ?>"/>
		<input type="hidden" name="univid" id="univid" value="<?php echo $university_id; ?>"/>
		<input type="text" id="searchbar" name="searchcourse" placeholder="<?php if($searchcourse!=''){ echo $searchcourse; }else{ ?>Search the courses in this department <?php }?>" />
		<a href="Javascript:void(0)" onclick="searchcourse();"><img src="images/search.png" id="searchbutton"></a>
		</form>
		</div>
    </div>
    -->
        <!DOCTYPE html>
    <html>
    <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>

    <script language="javascript" type="text/javascript">
    $(document).ready(function() {

        $(document).delegate(".docmain","mouseover",function(){
   $(this).find(".docicon").css({"width":"107%","height":"107%","opacity":"0.84"});
   
   $(this).find(".docicon").css({"margin-top":"-8px","margin-left":"-8px"});
   
   });
$(document).delegate(".docmain","mouseout",function(){
   $(this).find(".docicon").css({"width":"100%","height":"100%","opacity":"1"});
   
   $(this).find(".docicon").css({"margin-top":"0px","margin-left":"0px"});
   
   });

    });
    </script>
    </head>
    <body>
    	

	<div id="documents">
		<?php 
		if(isset($coursesListRes) && count($coursesListRes)>0 && $coursesListRes!=false)
		{
			?><!--<div id="dochead">COURSES (<?php echo count($coursesListRes); ?>)</div>--><?php
			for($i=0;$i<count($coursesListRes);$i++) 
			{
				$profid = $coursesListRes[$i]['profid'];
				$courseid 	=$coursesListRes[$i]['courseid'];
				$name   = $coursesListRes[$i]['name'];
				$coursepic   = $coursesListRes[$i]['coursepic'];
				$location   = $coursesListRes[$i]['imagepath'];
				$coursedesc   = $coursesListRes[$i]['desc'];
				$imagepath=$SITE_URL.'images/noimage.jpg';
				if(isset($coursepic) && $coursepic!='')
				{
					$filepath=$SITE_PATH.$location.'/'.$coursepic;
					if(file_exists($filepath))
					{
						$imagepath=$SITE_URL.$location.'/'.$coursepic;
					}
				}
				?>
				<div class="docmain">
            		<div class="iconframe">
                	    <img src="<?php echo $imagepath; ?>" class="docicon">
					</div>
                	<div class="docdes"><a href=""><?php echo $name; ?></a></div>
                	<!--<div class="doctails">
                	<div>
                   	 <span class="fileliken">12</span>
                    	<a href=""><img src="images/like.png" class="like filelike"></a>
					</div>
            		</div>-->
       			</div>
				<?php
			}
		}
		else{
		echo '<center>No Records Found.</center>';
		}
		?>
        <!--<div class="docmain">
            <div class="doccircle">
                <img src="src/doc-icon-2.png" class="docicon">
          </div>
            <div class="docdes"><a href="">Computer Organization</a></div>
            <div class="doctails">
                <div>
                    <span class="fileliken">12</span>
                    <a href=""><img src="src/like.png" class="like filelike"></a></div>
            </div>
        </div>-->
    </div>
	<script language="javascript" type="text/javascript">
	function searchcourse()
	{
		document.frmsearch.submit();
	}
	</script>
<?php 
}
else
{
?><div>Please <a href='index.php' target='_parent'>login</a> to view all courses and it's detail.</div><?php 
}	
?>
    <div id="mainend"></div>
</div>
    </body>
</html>