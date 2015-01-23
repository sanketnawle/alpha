<?php 
ob_start();
session_start();
include_once("include/includefiles.php");
$includepage = getInclucdePageFront(); 
$university_id=$_GET['univid'];
$searchdepartment='';
//////// Get all department for this university.
if(isset($_POST) && count($_POST)>0)
{
	
	$university_id=$_POST['univid'];
	$searchdepartment=$_POST['searchdepartment'];
	if($searchdepartment!='')
	{
		$departmentListQry = "select * from department_1 where universityid=".$university_id." and deptname like '%".$searchdepartment."%' order by deptname asc";	
	}
	else
	{
		$departmentListQry = "select * from department_1 where universityid=".$university_id." order by deptname asc";
	}
	
}
else
{
	$departmentListQry = "select * from department_1 where universityid=".$university_id." order by deptname asc";
}
$departmentListRes = $dbObj->fireQuery($departmentListQry,'select');
?>
<link rel="stylesheet" type="text/css" href="css/department.css">
<div id="midsec">
<?php 
if(isset($_SESSION['usertype']) && $_SESSION['usertype']!='')
{
?>
    <!--
    <div id="searchblock">
    <div id="searchborder">
	<form action="" method="post" name="frmsearch" id="frmsearch">
	<input type="hidden" name="univid" id="univid" value="<?php echo $university_id; ?>"/>
	<input type="text" id="searchbar" name="searchdepartment" placeholder="<?php if($searchdepartment!=''){ echo $searchdepartment; }else{ ?>Search the departments at your school<?php }?>" />
		<a href="Javascript:void(0)" onclick="searchdepartment();"><img src="images/search.png" id="searchbutton" style="margin-top:-43px;"></a>
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
		if(isset($departmentListRes) && count($departmentListRes)>0 && $departmentListRes!=false)
		{
			?><!--<div id="dochead">Departments (<?php echo count($departmentListRes); ?>)</div>--><?php
			for($i=0;$i<count($departmentListRes);$i++) 
			{
				$deptid = $departmentListRes[$i]['deptid'];
				$headid = $departmentListRes[$i]['headid'];
				$deptname   = $departmentListRes[$i]['deptname'];
				$deptpic   = $departmentListRes[$i]['deptpic'];
				$deptdesc   = $departmentListRes[$i]['deptdesc'];
				$location   = $departmentListRes[$i]['location'];
				$imagepath=$SITE_URL.'images/noimage.jpg';
				if(isset($deptpic) && $deptpic!='')
				{
					$filepath=$SITE_PATH.$location.'/'.$deptpic;
					if(file_exists($filepath))
					{
						$imagepath=$SITE_URL.$location.'/'.$deptpic;
					}
				}
				?>
				<div class="docmain">
            		<div class="iconframe">
                	    <img src="<?php echo $imagepath; ?>" class="docicon">
					</div>
                	<div class="docdes"><a target="_parent" href="<?php echo $SITE_URL.'index.php?pg=department&deptid='.$deptid.'&univid='.$university_id; ?>"><?php echo $deptname; ?></a></div>
                	<!--<div class="doctails">
                	<div>
                   	 < ?php echo $deptdesc; ?>
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
       <!-- <div class="docmain">
            <div class="doccircle">
                <img src="images/doc-icon-2.png" class="docicon">
                    </div>
            <div class="docdes"><a href="">Computer Organization</a></div>
            <div class="doctails">
                <div>
                    <span class="fileliken">12</span>
                    <a href=""><img src="images/like.png" class="like filelike"></a></div>
            </div>
        </div>
        
        <div class="docmain">
            <div class="doccircle">
                <img src="images/doc-icon-2.png" class="docicon">
                    </div>
            <div class="docdes"><a href="">Computer Organization</a></div>
            <div class="doctails">
                <div>
                    <span class="fileliken">12</span>
                    <a href=""><img src="images/like.png" class="like filelike"></a></div>
            </div>
        </div>
        <div class="docmain">
            <div class="doccircle">
                <img src="images/doc-icon-2.png" class="docicon">
                    </div>
            <div class="docdes"><a href="">Computer Organization</a></div>
            <div class="doctails">
                <div>
                    <span class="fileliken">12</span>
                    <a href=""><img src="images/like.png" class="like filelike"></a></div>
            </div>
        </div>
        <div class="docmain">
            <div class="doccircle">
                <img src="images/doc-icon-2.png" class="docicon">
                    </div>
            <div class="docdes"><a href="">Computer Organization</a></div>
            <div class="doctails">
                <div>
                    <span class="fileliken">12</span>
                    <a href=""><img src="images/like.png" class="like filelike"></a></div>
            </div>
        </div>
        <div class="docmain">
            <div class="doccircle">
                <img src="images/doc-icon-2.png" class="docicon">
                    </div>
            <div class="docdes"><a href="">Computer Organization</a></div>
            <div class="doctails">
                <div>
                    <span class="fileliken">12</span>
                    <a href=""><img src="images/like.png" class="like filelike"></a></div>
            </div>
        </div>
        <div class="docmain">
            <div class="doccircle">
                <img src="images/doc-icon-2.png" class="docicon">
                    </div>
            <div class="docdes"><a href="">Computer Organization</a></div>
            <div class="doctails">
                <div>
                    <span class="fileliken">12</span>
                    <a href=""><img src="images/like.png" class="like filelike"></a></div>
            </div>
        </div>
        <div class="docmain">
            <div class="doccircle">
                <img src="images/doc-icon-2.png" class="docicon">
                    </div>
            <div class="docdes"><a href="">Computer Organization</a></div>
            <div class="doctails">
                <div>
                    <span class="fileliken">12</span>
                    <a href=""><img src="images/like.png" class="like filelike"></a></div>
            </div>
        </div> --->
		</div>
		<script language="javascript" type="text/javascript">
	function searchdepartment()
	{
		document.frmsearch.submit();
	}
	</script>
<?php 
}
else
{
?><div>Please <a href='index.php' target="_parent">login</a> to view all departments and it's detail.</div><?php 
}	
?>        <div id="docend"></div>
    </div>
    <div id="mainend"></div>
    </body>
</html>
