<?php
ob_start();
session_start();
include_once("include/includefiles.php");
$includepage = getInclucdePageFront(); 

?>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" /> 
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>	

<script language="javascript" type="text/javascript">
$(function() {
		
	//autocomplete
	$("#search_course").autocomplete({
		source: "department_autocomplete.php",
		minLength: 1,
		select: function(event, ui) {
		$("#course_id").val(ui.item.id)
		if(ui.item){
			$(event.target).val(ui.item.value);
		}}
	});	
});

</script>
<div class="contractor">
	<div class="popup_red_h">Add Classes</div>
<div class="inputarea">
<form id="frmcourseadd" action="" method="post" enctype="multipart/form-data">
  <table>
   <tr>
	<td colspan="2" align="center">
	<div id="message">
	</div>
  </td>
  <tr>
	<td width="150" align="right"><strong>Department:</strong></td>
	<td align="left">
	<?php 
	$department_sql="select * from  department_1";
	$department_res=$dbObj->fireQuery($department_sql,'select');
	?>
	<select id="dept_id" name="dept_id">
	<option value="">Select Department</option>
	<?php
	 if(isset($department_res) && count($department_res)>0 && $department_res!=false)
	 {
	 	for($d=0;$d<count($department_res);$d++)
		{
		?><option value="<?php echo $department_res[$d]['deptid'];  ?>"><?php echo $department_res[$d]['deptname'];  ?></option><?php
		}
	 }
	 ?>
	</select>
	</td>
  </tr>
  <tr>
  	<td width="150" align="right"><strong>Search Course :</strong></td>
	<td><input id="search_course" name="search_course" type="text" autocomplete="off" >
	<input type="hidden" name="course_id" id="course_id" value="" readonly="readonly" /></td>
  </tr>
   <tr>
  <td width="150" align="right" colspan="2">
  <input type="submit" name="btnsubmit" value="Add Course" id="btnsubmit">
  <input type="button" name="btncancel" value="Cancel" id="btncancel">
  </td>
  </tr>
  </tr>
  </table>
   </form>
</div>
