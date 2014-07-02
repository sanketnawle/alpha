<?php 
	include_once("includefiles.php");
	$search_string = "COMPUTER";
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
<link rel="stylesheet" type="text/css" href="backgroundSearch.css">
<link rel = "stylesheet" type = "text/css" href = "search.css"> 
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
</script>
<link href='https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="search.js"></script> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
  // Just call this to initialise the plugin
	$(function()
	{
		// Usage:
		var mySlider = new range_slider(
		{
			selector : '.scrubber_slider',
			unit 	: ' credits',
			min 	: 0,
			max	: 4,
     	 	left_scrubber_pos : 2,
      		right_scrubber_pos : 4,
			round_by : 1,
			rounded	: true,
			
			// Event during initialization
			release : function(e)
			{
				// custom function for this event
				console.log("Event happened, this object contains: \n\n { \n min : "+ e.min + ",\nmax : " + e.max + "\n");
			}
		});

		$(document).delegate(".subjects-results-dept","click", function(){
				alert("test");
				$("#subject_query").val($(this).find(".subject-match").text());
			});

		var search_string = <?php if (isset($search_string))
									echo "'".$search_string."'";
								  else
								  	echo "''"; 
							?>;
		var search_type = "All";
		var univ_id = <?php echo $_GET['univid'];?>;
		var filter = {};

		callFilter(search_type,search_string,univ_id,filter);
		callBookmarks();

		$(document).delegate(".fav","click",function(){
			if($(this).hasClass("selected"))
			{
				$(this).removeClass("selected");
			}
			callBookmarks($(this).attr('id'));
			alert($(this).attr('id'));
		});
		
		$(document).delegate("#search","click",function(){
			search_type= $(".activeType").data("value");
			search_string = $("#search_query").val();
			filter['minCredits'] = mySlider.getLeftScrubber();
			filter['maxCredits'] = mySlider.getRightScrubber();	
			callFilter(search_type,search_string,univ_id,filter);
		});

  function callBookmarks(class_id)
  {
	  if(class_id == null)
	  {
		  $.ajax({
				type: "POST",
				url: "bookmark.php",
				success: function(responseText){
					$("#bookmarks").html(responseText);
				}
			});
	  }
	  else
	  {
		  $.ajax({
				type: "POST",
				url: "bookmark.php",
				data: {'class':class_id},
				success: function(responseText){
					$("#bookmarks").html(responseText);
				}
			});
	  }
  }
  function callFilter(type, string, univ,filter)
  {
	  $.ajax({
			type: "POST",
			url: "search_filter.php",
			data:{search_type:type, search_string:string, univid:univ, filter:filter},
			success: function(responseText){
				var all_rows = getNumbers("<all_rows>",responseText);
				var professor_rows = getNumbers("<professor_rows>",responseText);
				var course_rows = getNumbers("<course_rows>",responseText);
				var group_rows = getNumbers("<group_rows>",responseText);
				var student_rows = getNumbers("<student_rows>",responseText);
				var credits = getNumbers("<credits>",responseText);
				responseText = responseText.slice(0,responseText.search("<all_rows>"));
				$("#category1").text(all_rows);
				$("#category2").text(course_rows);
				$("#category3").text(professor_rows);
				$("#category4").text(student_rows);
				$("#category5").text(group_rows);

				var count = 0; var key = "";
				
				if(course_rows > 0){
					count++;
					key = "#category2";
					$("#category2").parent().parent().show();
				}
				else
				{
					$("#category2").parent().addClass("inactiveType");
					$("#category2").parent().removeClass("activeType");
					$("#category2").parent().parent().hide();
				}
				
				if(professor_rows > 0){
					count++;
					key = "#category3";
					$("#category3").parent().parent().show();
				}
				else{
					$("#category3").parent().addClass("inactiveType");
					$("#category3").parent().removeClass("activeType");
					$("#category3").parent().parent().hide();
				}

				if(student_rows > 0){
					count++;
					key = "#category4";
					$("#category4").parent().parent().show();
				}
				else{
					$("#category4").parent().addClass("inactiveType");
					$("#category4").parent().removeClass("activeType");
					$("#category4").parent().parent().hide();
				}
				
				if(group_rows > 0){
					count++;
					key = "#category5";
					$("#category5").parent().parent().show();
				}
				else{
					$("#category5").parent().addClass("inactiveType");
					$("#category5").parent().removeClass("activeType");
					$("#category5").parent().parent().hide();
				}

				if(count != 1)
				{
					$("#category1").parent().addClass("activeType");
				}
				else
				{
					$("#category1").parent().removeClass("activeType");
					$("#category1").parent().addClass("inactiveType");
					$(key).parent().addClass("activeType");
				}	
				$("#result").html(responseText);
				mySlider.updateMax(credits);
			}
		});
  }
});
  function getNumbers(tag, data)
  {
	  var start_tag = tag;
	  var end_tag = tag.replace("<","</");
	  var start = data.search(start_tag) + start_tag.length;
	  var end = data.search(end_tag);
	  if(start == -1 || end == -1)
		  return "";
	  var all_rows = data.slice(start,end);
	  return all_rows;
  }
</script>
</head>
<body>
	<div class = "root">
		<div class = "top-bar">
			<div class = "top-bar-wrapper">
				<img class = "logo-h" src = "src/logo.png">
				</img>


			</div>
		</div>
		<div class = "main">
			<div class = "leftsec">
				<div class = "visible-lg">
					<div class = "searchType">
						<span class = "wedgeRight"></span>
						<div class = "search_category searchType">
							<a class = "type activeType"><span id="category1" class = "resultNum pull-right"></span>All Results</a>
						</div>
						<div class = "search_category searchType">
							<a class = "type inactiveType"><span id="category2" class = "resultNum pull-right"></span>Courses</a>
						</div>
						<div class = "search_category searchType">
							<a class = "type inactiveType"><span id="category3" class = "resultNum pull-right"></span>Professors</a>
						</div>
						<div class = "search_category searchType">
							<a class = "type inactiveType"><span id="category4" class = "resultNum pull-right"></span>Students</a>
						</div>
						<div class = "search_category searchType">
							<a class = "type inactiveType"><span id="category5" class = "resultNum pull-right"></span>Clubs</a>
						</div>		
						<div class = "search_category searchType">
							<a class = "type inactiveType"><span id="category6" class = "resultNum pull-right"></span>Posts</a>
						</div>											
					</div>
				</div>
				<hr class = "hr-divider">
				<div class = "form-group">
					<label class = "col-sm control-label" for = "search_query">Keywords:</label>
						<div class = "col-lg">
							<input class = "form-control" id = "search_query" name = "search[query]" type = "text" value = "">
						</div>
				</div>
				<div class = "form-group">
					<label class = "col-sm control-label" for = "subject_query">Subjects:</label>
					<div class = "col-lg">
						<input class = "form-control" id = "subject_query" name = "subject[query]" type = "text" value = "">
						<div class = "dropdown subjects">
						<ul class = "subject-results" id = "subject-drop">
					
<?php
/*get the list of departments in the university*/
	$deptsql="SELECT * FROM department where univ_id =".$_GET['univid'];
	if($deptListRes = $con->query($deptsql))
	{
		while ($deptRow = $deptListRes->fetch_array(MYSQLI_ASSOC))
		{
?>									<li class = "subject-results-dept" id = <?php echo "'".$deptRow['dept_id']."'";?>>
										<div class = "subject-result-label">
											<span class = "subject-match">
											</span>
											<?php echo $deptRow['dept_name'];?>
										</div>
									</li>
<?php 			
		}
		
	}
?>
								</ul>
							</div>
						</div>						
					</div>
					<div class = "form-group advancedToggle advancedShow">
						<span class = "FAcaret"></span>
						<a class= "collapsed" href = "#">
							Advanced Options
						</a>
					</div>
					<div class = "advancedOptions">
						<div class = "form-group">
							<label class = "col-sm control-label" for = "search_query">Credits:</label>
							<div class="scrubber_slider">

							</div>
						</div>
					</div>
					<button class = "search-btn" name = "commit" id ="search" >Search</button>

			</div>
			<div id = "result" class = "midsec">
<!-- insert the results here -->						
			</div>			
			<div class = "rightsec">
				<div class = "bookmarks-header">
					Bookmarks
				</div>
				<div id="bookmarks" class = "bookmarks-content">
<!-- insert the bookmarks here -->		
				</div>
			</div>
		</div>
	</div>
</body>


</html>