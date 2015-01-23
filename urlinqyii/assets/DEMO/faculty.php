<?php 
ob_start();
session_start();
include_once("include/includefiles.php");
$includepage = getInclucdePageFront(); 
$department_id=$_GET['deptid'];
$university_id=$_GET['univid'];
$searchfaculty='';
//////// Get all faculaty profressor for this department.
if(isset($_POST) && count($_POST)>0)
{
	$department_id=$_POST['deptid'];
	$university_id=$_POST['univid'];
	$searchfaculty=$_POST['searchfaculty'];
	if($searchfaculty!='')
	{
		$facultyListQry = "select * from professor_1 where deptid='".$department_id."' and name like '%".$searchfaculty."%' order by name asc";
	}
	else
	{
		$facultyListQry = "select * from professor_1 where deptid='".$department_id."' order by name asc";
	}
}
else
{
	$facultyListQry = "select * from professor_1 where deptid='".$department_id."' order by name asc";
}
$facultyListRes = $dbObj->fireQuery($facultyListQry,'select');

?>
<link rel="stylesheet" type="text/css" href="css/faculty.css">
<div id="facsec">
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
	<input type="text" id="searchbar" name="searchfaculty" placeholder="<?php if($searchfaculty!=''){ echo $searchfaculty; }else{ ?>Search the faculty in this department<?php }?>"/>
	<a href="Javascript:void(0)" onclick="searchfaculty();"><img src="images/search.png" id="searchbutton" style="margin-top:-58px;"></a>
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

        $(document).delegate(".memmain","mouseover",function(){
   $(this).find(".memicon").css({"width":"107%","height":"107%","opacity":"0.84"});
   
   $(this).find(".memicon").css({"margin-top":"-8px","margin-left":"-8px"});
   
   });
$(document).delegate(".memmain","mouseout",function(){
   $(this).find(".memicon").css({"width":"100%","height":"100%","opacity":"1"});
   
   $(this).find(".memicon").css({"margin-top":"0px","margin-left":"0px"});
   
   });

    });
    </script>
    </head>
    <body>

    <div id="members">
		<?php 
		if(isset($facultyListRes) && count($facultyListRes)>0 && $facultyListRes!=false)
		{
			for($i=0;$i<count($facultyListRes);$i++) 
			{
				$profid = $facultyListRes[$i]['profid'];
				$name   = $facultyListRes[$i]['name'];
				$email   = $facultyListRes[$i]['email'];
				$contact   = $facultyListRes[$i]['contact'];
				$profilepic   = $facultyListRes[$i]['profilepic'];
				$location   = $facultyListRes[$i]['location'];
				$profdesc   = $facultyListRes[$i]['profdesc'];
				$imagepath=$SITE_URL.'images/noimage.jpg';
				if(isset($profilepic) && $profilepic!='')
				{
					$filepath=$SITE_PATH.$location.'/'.$profilepic;
					if(file_exists($filepath))
					{
						$imagepath=$SITE_URL.$location.'/'.$profilepic;
					}
				}
				$me_text='';
				
				if($_SESSION['usertype']=='Professor' && $_SESSION['professor_id']==$profid)
				{
					$me_text='(ME)';
				}
				?>
				<div class="memmain">
					<div class="iconframe">
						<img src="<?php echo $imagepath;?>" class="memicon">
					</div>
					<div class="memdes"><a class="whitehref" href=""><?php echo $name; ?><?php echo $me_text;?></a></div>
					<div class="memtails"></div>
				</div>
      			<?php
			}
		}
		else
		{
			echo '<center>No Records Found.</center>';
		}
		?>
        <!--<div id="mem-1">
            <div class="memmain">
                <div class="memcircle">
                    <img src="images/professor-big-pic.png" class="memicon">              </div>
                <div id="memdes-1"><a href="">Professor Landsburg</a></div>
                <div class="memtails">                </div>
            </div>
        </div>
        <div id="mem-2">
            <div class="memmain">
                <div class="memcircle">
                    <img src="images/shaleen.png" class="memicon">              </div>
                <div id="memdes-2"><a href="">Shaleen</a></div>
                <div class="memtails">                </div>
            </div>
        </div>
        <div id="mem-3">
            <div class="memmain">
                <div class="memcircle">
                    <img src="images/kuan.png" class="memicon">              </div>
                <div id="memdes-3"><a href="">Kuan</a></div>
                <div class="memtails">                </div>
            </div>
        </div>
        <div id="mem-4">
            <div class="memmain">
                <div class="memcircle">
                    <img src="images/jing.png" class="memicon">              </div>
                <div id="memdes-4"><a href="">Jing</a></div>
                <div class="memtails">                </div>
            </div>
        </div>
        <div id="mem-5">
            <div class="memmain">
                <div class="memcircle">
                    <img src="images/jake.png" class="memicon">              </div>
                <div id="memdes-5"><a href="">Jake (ME)</a></div>
                <div class="memtails">                </div>
            </div>
        </div>
        <div id="mem-6">
            <div class="memmain">
                <div class="memcircle">
                    <img src="images/professor-big-pic.png" class="memicon">              </div>
                <div id="memdes-6"><a href="">Professor Landsburg</a></div>
                <div class="memtails">                </div>
            </div>
        </div>
        <div id="mem-7">
            <div class="memmain">
                <div class="memcircle">
                    <img src="images/shaleen.png" class="memicon">              </div>
                <div id="memdes-7"><a href="">Shaleen</a></div>
                <div class="memtails">                </div>
            </div>
        </div>
        <div id="mem-8">
            <div class="memmain">
                <div class="memcircle">
                    <img src="images/kuan.png" class="memicon">              </div>
                <div id="memdes-8"><a href="">Kuan</a></div>
                <div class="memtails">                </div>
            </div>
        </div>
        <div id="mem-9">
            <div class="memmain">
                <div class="memcircle">
                    <img src="images/jing.png" class="memicon">              </div>
                <div id="memdes-9"><a href="">Jing</a></div>
                <div class="memtails">                </div>
            </div>
        </div> -->

		<!--<div id="memberend"><button id="loadmore">View More Faculty</button></div>-->
    </div>
	<script language="javascript" type="text/javascript">
	function searchfaculty()
	{
		document.frmsearch.submit();
	}
	</script>
    <?php 
}
else
{
?><div>Please <a href='index.php' target='_parent'>login</a> to view all faculty and it's detail.</div><?php 
}	
?>
<div id="mainend"></div>
</div>

    </body>
</html>
