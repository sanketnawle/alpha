<?php 
ob_start();
session_start();
include_once("include/includefiles.php");
$includepage = getInclucdePageFront(); 
////////check if user login or not //////////
if(!isset($_SESSION['usertype']))
{
	header("Location:index.php?pg=login");
	exit;
}
if(isset($_GET['univid']) && $_GET['univid']!='' )
{
	$university_id=$_GET['univid'];
}else{
	$university_id=0;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="js/banner.js"></script>
<link rel="stylesheet" type="text/css" href="css/home.css">
<link rel="stylesheet" type="text/css" href="css/search.css">
<link rel="stylesheet" type="text/css" href="css/banner.css">
<script language="javascript" type="text/javascript">
$(document).ready(function() {

   var st2= $(".infofield").offset().left-70;
$("#searchborder").offset({ left: st2 });
$(window).on('resize', function(){
var st2= $(".infofield").offset().left-70;
$("#searchborder").offset({ left: st2 });
  });

$(document).delegate(".linqthis","mousedown",function(){
   
   var del=1;
   var thisname= $(this).closest(".itemtype").find(".itemname").text();
   var flag= $(this).val();
   var $linqid= $(this).attr("id").substring(2);
   action_vals=$linqid.split("_");
   
   var v00="";
   var v0="";
   var v1="";
   var v2="";
   if($(this).closest(".itemtype").hasClass("course")){
   v00="Add";
   v0="drop";
   v1="Drop";
   v2="I am in this class"
   }
   if($(this).closest(".itemtype").hasClass("community")){
   v00="Join";
   v0="drop";
   v1="Drop";
   v2="I am in this club"
   }
   if($(this).closest(".itemtype").hasClass("people")){
   v00="Linq";
   v0="drop";
   v1="Drop";
   v2="we are Linqed"
   }
  
   /*userid is the one who is viewing this page*/
   <?php 
   if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Student'){
   		?>
		var userid= <?php echo $_SESSION['student_id']; ?>;
     	var whoislogin='Student';
   		<?php
   }elseif(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Professor'){
   		?>
		var userid= <?php echo $_SESSION['professor_id']; ?>;
		var whoislogin='Professor';
		<?php
   }
   ?>
   var action= action_vals[0];
   var linqid= action_vals[1];														
   
   if(flag==0){
   var button_id=$(this).attr("id");
   $(this).val(1);
   $(this).text(v2);
   $(this).css({"background-color":"#60D62D","background-repeat":"repeat-x","background-image":"linear-gradient(#60D62D,#3DA50D)","color":"white","border":"1px solid #3B6E22"});
   /*Ajax , end info to backend, to inform that user and this object has linqed*/
   $.ajax({
		  url: 'linq.php',
		  data: 'user='+ userid +'&linqid='+ linqid +'&action=' + action +'&univ_id=<?php echo $university_id; ?>'+'&whoislogin='+whoislogin,
		  type: "POST",
		  success: function(msg) {
			result=msg.split("|||");
			if(result[0]==1){
				//alert(result[1]);
			}
			if(result[0]==0){
				alert(result[1]);
				/*change the button css*/
				$('#'+button_id).val(0);
 			    $('#'+button_id).text(v00);
				$('#'+button_id).css({"background":"linear-gradient(#fff,#ddd)","background-color":"#ddd","color":"black","border":"1px solid #ccc"});
   
			}
		  }
		  });
   

   }else{
  	 var pid= "kw="+$(this).attr("id");
   	 $("#blackcanvas").show();
   	 $(".dropconfirm").attr("id",pid);
   	 $("#dtext").text("Do you want to "+v0+" "+thisname+"?");
  	 //alert($linqid);	
   } });

$(document).delegate("#confirm-c","click",function(){
   
   var oid= $(".dropconfirm").attr("id").split("=");
   var $obj=$("#"+oid[1]);
   
   var v00="";
   var v0="";
   var v1="";
   var v2="";
   if($obj.closest(".itemtype").hasClass("course")){
   v00="Add";
   v0="drop";
   v1="Drop";
   v2="I am in this class"
   }
   if($obj.closest(".itemtype").hasClass("community")){
   v00="Join";
   v0="drop";
   v1="Drop";
   v2="I am in this club"
   }
   if($obj.closest(".itemtype").hasClass("people")){
   v00="Linq";
   v0="drop";
   v1="Drop";
   v2="we are Linqed"
   }
   
   $("#blackcanvas").hide();
   
   $obj.css({"background-color":"#60D62D","background-repeat":"repeat-x","background-image":"linear-gradient(#60D62D,#3DA50D)","color":"white","border":"1px solid #3B6E22"});
   $obj.text(v2);
   $obj.width("auto");
   });
$(document).delegate("#confirm-d","click",function(){  
   var oid= $(".dropconfirm").attr("id").split("=");
   var $obj=$("#"+oid[1]);
   var v00="";
   var v0="";
   var v1="";
   var v2="";
   if($obj.closest(".itemtype").hasClass("course")){
   v00="Add";
   v0="drop";
   v1="Drop";
   v2="I am in this class"
   }
   if($obj.closest(".itemtype").hasClass("community")){
   v00="Join";
   v0="drop";
   v1="Drop";
   v2="I am in this club"
   }
   if($obj.closest(".itemtype").hasClass("people")){
   v00="Linq";
   v0="drop";
   v1="Drop";
   v2="we are Linqed"
   }

   $("#blackcanvas").hide();
   $obj.val(0);
   $obj.text(v00);
   $obj.width("auto");
   $obj.css({"background":"linear-gradient(#fff,#ddd)","background-color":"#ddd","color":"black","border":"1px solid #ccc"});
   
   /*Ajax , end info to backend, to inform that user and this object has linqed*/
   var $linqid= $obj.attr("id").substring(2);
   action_vals=$linqid.split("_");
   /*userid is the one who is viewing this page*/
   <?php 
   if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Student'){
   ?>
   	var userid= <?php echo $_SESSION['student_id']; ?>;
   	var whoislogin='Student';
   <?php
   }elseif(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Professor'){
   ?>
   	var userid= <?php echo $_SESSION['professor_id']; ?>;
	var whoislogin='Professor';
   <?php
   }
   ?>

   var action= action_vals[0];
   var linqid= action_vals[1];	
   
   $.ajax({
		  url: 'drop.php',
		  data: 'user='+ userid +'&linqid='+ linqid +'&action=' + action +'&univ_id=<?php echo $university_id; ?>'+'&whoislogin='+whoislogin,
		  type: "POST",
		  success: function(json) {
		  //alert("Updated Successfully");
		  }
		  });
   });
$(document).delegate(".linqthis","mouseover",function(){
   
   var w = $(this).width();
  
   
   if($(this).val()==0){
   $(this).css({"background-color":"#88E062","background-repeat":"repeat-x","background-image":"linear-gradient(#88E062,#4FB91E)","color":"white","border":"1px solid #3B6E22","filter":"progid:DXImageTransform.Microsoft.gradient(startColorstr='#60D62D',endColorstr='#3DA50D',GradientType=0)"});
   }else{
   $(this).css({"background":"linear-gradient(#ff6666,#ff4d4d)","background-color":"#ff6666","color":"white","border":"1px solid #ff6666"});
	$(this).width(w);
	$(this).text("Drop");
   }
   
   
   
   });
$(document).delegate(".linqthis","mouseout",function(){
   var v00="";
   var v0="";
   var v1="";
   var v2="";
   if($(this).closest(".itemtype").hasClass("course")){
   v00="Add";
   v0="drop";
   v1="Drop";
   v2="I am in this class"
   }
   if($(this).closest(".itemtype").hasClass("community")){
   v00="Join";
   v0="drop";
   v1="Drop";
   v2="I am in this club"
   }
   if($(this).closest(".itemtype").hasClass("people")){
   v00="Linq";
   v0="drop";
   v1="Drop";
   v2="we are Linqed"
   }
   
   
   $(this).width("auto");
   
   
   if($(this).val()==0){
   $(this).css({"background":"linear-gradient(#fff,#ddd)","background-color":"#ddd","color":"black","border":"1px solid #ccc"});
   $(this).text(v00);
   }else{
   $(this).css({"background-color":"#60D62D","background-repeat":"repeat-x","background-image":"linear-gradient(#60D62D,#3DA50D)","color":"white","border":"1px solid #3B6E22"});
   $(this).text(v2);
   }
   
   
   
   });
   
$(document).delegate("#blackcanvas","click",function(e){
   
   if(($(e.target).is(".dropconfirm > *"))||($(e.target).is(".dropconfirm"))){return false;
   
   }
   
   $(this).hide();
   
   });
$(document).delegate("#dexit","mouseover",function(){
   
   $(this).css("opacity","1");
   });
$(document).delegate("#dexit","mouseout",function(){
   
   $(this).css("opacity","0.7");
   });
$(document).delegate("#dexit","click",function(){
   
   $("#blackcanvas").hide();
   });
});
</script>

</head>
<body>
<?php 
$search="";
if(isset($_POST['search']) && $_POST['search']!=''){
	$search=$_POST['search'];
}
?>

	<div id="searchborder" class="clubsearchborder">
	<form name="frmsearch" id="frmsearch" method="post" action="">
	<input type="text" id="searchbar" placeholder="search by keywords" name="search" value="<?php echo $search; ?>" />
	<a href="Javascript:void(0)" onClick="Javascript:document.getElementById('frmsearch').submit();"><img src="images/search.png" id="searchbutton"></a>
	</form>
	</div>

<div class="clear"></div>
<!-- Community section start here -->
<section class="midsec tabcommunity">
<?php
$search_group_cond="";
if(isset($_POST['search']) && $_POST['search']!='')
{
	$search_group_cond=" AND g.groupname LIKE '%".$_POST['search']."%'";
}
////////// Get all clubs and it president means admin group detail ///////////////
$clubssel_sql="SELECT g.*,ga.* FROM groups_1 g,groups_admin_1 ga WHERE g.groupid=ga.groupid and g.universityid='".$university_id."' ".$search_group_cond." ";
$clubsRes = $dbObj->fireQuery($clubssel_sql,'select');
if(isset($clubsRes) && count($clubsRes)>0 && $clubsRes!=false)
{
	for($c=0;$c<count($clubsRes);$c++)
	{
		$club_id=$clubsRes[$c]['groupid'];
		$clubname=$clubsRes[$c]['groupname'];
		$founded_on=date("Y",strtotime($clubsRes[$c]['founded_on']));
		$profid=$clubsRes[$c]['profid'];
		$name=$clubsRes[$c]['name'];
		$club_desc=$clubsRes[$c]['groupdesc'];
		$imagepath=$SITE_URL.'images/noimage.jpg';
		$isclubjoined=clubjoined($club_id);
		?>
		<div class="infofield community itemtype" id="clubs_<?php echo $club_id; ?>">
			<img src="<?php echo $imagepath; ?>" class="infopic">
			<div class="infotail">
				<div class="tailhead itemname"><a><?php echo $clubname; ?></a></div>
				<div class="moreinfo">president: <?php if($profid!=0){echo "<a href='professor_profile.php?profid=$profid'>".getprofessordetail($profid,'name')."</a>";}else{ echo $name;} ?></div>
				<div class="subinfo"><div class="subinfo_0">Founded in <?php echo $founded_on; ?></div>
				<div class="subinfo_1">Club Size: <?php echo gettotalclubmembercount($club_id); ?></div>
				<div class="subinfo_2"><?php echo $club_desc; ?></div></div>
				<?php if($isclubjoined==1){ ?>
				<button style="background: linear-gradient(rgb(96, 214, 45), rgb(61, 165, 13)) repeat-x scroll 0% 0% rgb(96, 214, 45); color: white; border: 1px solid rgb(59, 110, 34); width: auto;" class="linqthis" id="s-clubs_<?php echo $club_id; ?>" value="1">I am in this club</button>
				<?php }else{?>
				<button value="0" id="s-clubs_<?php echo $club_id; ?>" class="linqthis" style="background: linear-gradient(rgb(255, 255, 255), rgb(221, 221, 221)) repeat scroll 0% 0% rgb(221, 221, 221); color: black; border: 1px solid rgb(204, 204, 204); width: auto;">Join</button>
				<?php }?>
			</div>
		</div>
		<?php
	}
}
else
{?><div class="infofield community itemtype" style="height:50px !important;"><center style="margin-top:10px;"><strong>No clubs found.</strong></center></div><?php }
?>
</section>
<!-- Community section end here -->
<section id="blackcanvas">
  <div class="dropconfirm"><img src="images/exit-btn.png" id="dexit">
    <div id="dtext">Are you sure you want to</div>
    <button id="confirm-d" class="dbuttons-can" value="1">Drop</button>
    <button id="confirm-c" class="dbuttons" value="0">Cancel</button>
  </div>
</section>
</body>
</html>
<script language="javascript" type="text/javascript">
window.parent.$(".tabcontentiframe").css("width","100%");
window.parent.$(".tabcontentiframe").css('overflow','auto');
</script>