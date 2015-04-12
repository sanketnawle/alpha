<?php 
if(isset($_GET['deptid']) && isset($_GET['univid']))
{
	$university_id=$_GET['univid'];
	$department_id=$_GET['deptid'];
	$fromwhere='';
}
elseif(isset($_GET['fromwhere']) && isset($_GET['univid']))
{
	$university_id=$_GET['univid'];
	$fromwhere=$_GET['fromwhere'];
	$department_id=0;
	
}
else
{
	$university_id=0;
	$department_id=0;
	$fromwhere='';
}
?>
<script src="js/jquery.js" language="javascript" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="css/modal.css">
<script src="js/jquery.form.js" language="javascript" type="text/javascript"></script>
<div class="contractor">
<div class="inputarea">
<form id="uploadfrm" action="upload.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="university_id" id="university_id" value="<?php  echo $university_id; ?>" />
<input type="hidden" name="department_id" id="department_id" value="<?php  echo $department_id; ?>" />
<input type="hidden" name="fromwhere" id="fromwhere" value="<?php  echo $fromwhere; ?>" />
  <table>
   <tr>
	<td colspan="2" align="center">
	<div id="message">
	</div>
  </td>
  <tr>
	<td class = "parameter" width="150" >File Name :</td>
	<td align="left"><input type="text" name="file_name" id="file_name" value="" /></td>
  </tr>
  <tr>
  	<td class = "parameter" id= "description" width ="300">File Description :</td>
	<td><textarea id="file_description" name="file_description" spellcheck= "true" ></textarea></td>
  </tr>
   <tr>
  	<td  class = "parameter" id ="visibility" width="150" >Visibility :</td>
	<td class = "radio">
	<form>
		<input class = "button" name = "visibility" type = "radio" value="Public">
		<label for "Public">Public</label>
		<input class = "button" name = "visibility" type = "radio" value="Student">
		<label for "Student">Student</label>
		<input class = "button" name = "visibility" type = "radio" value="Faculty">
		<label for "Faculty">Faculty</label>
	</form>
	</td>
  </tr>
  <tr>
  <td  class = "parameter"  width="150" >Attachment :</td>
  <td><input type="file" name="Image" id="image">&nbsp;<input id = "upload" type="submit" value="Upload"></td>
  </tr>
  </tr>
  </table>
   </form>
</div>
<script>
$(document).ready(function()
{
	var options = { 
  	complete: function(response) 
	{
		var result=response.responseText.split('|||');
		if(result[0]==0)
		{
			document.getElementById('Image').value='';
			$("#message").html("<font color='red'>"+result[1]+"</font>");
		}
		else if(result[0]==1)
		{
			parent.$.fancybox.close();
			/*document.getElementById('fancybox-overlay').style.display='none';
			document.getElementById('fancybox-wrap').style.display='none';*/
			window.parent.Forum();
			$("#message").html("<font color='green'>"+result[1]+"</font>");
		}
	},
	error: function()
	{
		$("#message").html("<font color='red'> ERROR: unable to upload files</font>");

	}
}; 
$("#uploadfrm").ajaxForm(options);
});
</script>