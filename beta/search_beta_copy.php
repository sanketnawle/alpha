<?php
	include('php/redirect.php');
	include_once("includes/dbconfig.php");
	if(!isset($_SESSION['univ_id']))
		$_SESSION['univ_id'] = 1;
	if(isset($_GET['q']) && $_GET['q'] != "")
		$search_string = $_GET['q'];
	else
	{
		echo "Enter a search string";
		exit();
	}
	if(isset($_GET['univid']) && $_GET['univid']!='' )
	{
		$university_id=$_GET['univid'];
	}else{
		$university_id=$_SESSION['univ_id'];
	}
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="css/backgroundSearch.css">
<link rel="stylesheet" type="text/css" href="css/tour_animations.css">
<link rel="stylesheet" type="text/css" href="css/feed.css">
<link rel = "stylesheet" type = "text/css" href = "css/search.css"> 
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
</script>
<link href='https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="js/search.js"></script> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
  // Just call this to initialise the plugin
		
		var search_type = "All";
		var show_cat = true;
		var page = 1;
		var search_string = <?php if (isset($search_string))
									echo "'".$search_string."'";
								  else
								  	echo "''"; 
							?>;
		var univ_id = <?php echo $university_id;?>;
		var filter = {};

  	$(document).ready(function() {
  				var load='yes';
  				var heightOffset= 550;
  				var last_time = 1;
				$(window).scroll(function(){
					if (load == 'yes'){
						if($(window).scrollTop()+heightOffset >= $(document).height() - $(window).height()){
							load = 'no';
							    last_time = last_time+1;
// 							var $ref=$("#posts");
							var pullrequest = $.ajax({
            					type: "POST",
            					url: "php/search_filter.php",
            					cache: false,
            					data: {search_type:search_type, search_string:search_string, univid:univ_id, filter:filter, page:last_time},
            					datatype: "html"
        					});
        					pullrequest.done(function( html ){
            					if(html.trim() == "false")
                				{
                    				load = 'no';
                				}
            					else
                				{
                    				load ='yes';
        							$("#result").append( html );
                				}
        					});
						}
					}
				});
  	});


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
				//console.log("Event happened, this object contains: \n\n { \n min : "+ e.min + ",\nmax : " + e.max + "\n");
			}
		});

		$(document).delegate(".subjects-results-dept","click", function(){
				$("#subject_query").val($(this).find(".subject-match").text());
			});
		$("#search_query").val(search_string);
		callFilter(search_type,search_string,univ_id,filter,page);
		mySlider.updateRange(mySlider.getMin(),mySlider.getMax());
/*
		callBookmarks();

		$(document).delegate(".fav","click",function(){
			if($(this).hasClass("selected"))
			{
				$(this).removeClass("selected");
			}
			callBookmarks($(this).attr('id'));
		});
*/
		
		$(document).delegate("#search","click",function(){
			page = 1;
			search_type= $(".activeType").data("value");
			search_string = $("#search_query").val();
			if(search_string != $("#search_query").data("oldValue"))
			{
				show_cat = true;
				search_type = "All";
			}
			filter['minCredits'] = mySlider.getLeftScrubber();
			filter['maxCredits'] = mySlider.getRightScrubber();	
			callFilter(search_type,search_string,univ_id,filter,page);
		});

		$(document).delegate(".search_category","click",function(){
			page = 1;
			show_cat = false;
			search_type= $(".activeType").data("value");
			search_string = $("#search_query").val();
			filter['minCredits'] = mySlider.getLeftScrubber();
			filter['maxCredits'] = mySlider.getRightScrubber();	
			callFilter(search_type,search_string,univ_id,filter,page);
		});

		function callFilter(type, string, univ,filter, page)
		  {
			  $("#search_query").data("oldValue", string);
			  $.ajax({
					type: "POST",
					url: "php/search_filter.php",
					data:{search_type:type, search_string:string, univid:univ, filter:filter, page:page, nocalc:show_cat},
					success: function(responseText){
						if(responseText.trim() == "false")
        					return;
    					if(show_cat)
    					{
							var all_rows = getNumbers("<all_rows>",responseText);
							var professor_rows = getNumbers("<professor_rows>",responseText);
							var course_rows = getNumbers("<course_rows>",responseText);
							var group_rows = getNumbers("<group_rows>",responseText);
							var student_rows = getNumbers("<student_rows>",responseText);
			 				var post_rows = getNumbers("<post_rows>",responseText);
							var credits = getNumbers("<credits>",responseText);
							responseText = responseText.slice(0,responseText.search("<all_rows>"));
							$("#category1").text(all_rows);
							$("#category2").text(course_rows);
							$("#category3").text(professor_rows);
							$("#category4").text(student_rows);
							$("#category5").text(group_rows);
							$("#category6").text(post_rows);
							
							if(course_rows > 0){
								$("#category2").parent().parent().show();
							}
							else
							{
								$("#category2").parent().parent().hide();
							}
							
							if(professor_rows > 0){
								$("#category3").parent().parent().show();
							}
							else{
								$("#category3").parent().parent().hide();
							}
	
							if(student_rows > 0){
								$("#category4").parent().parent().show();
							}
							else{
								$("#category4").parent().parent().hide();
							}
							
							if(group_rows > 0){
								$("#category5").parent().parent().show();
							}
							else{
								$("#category5").parent().parent().hide();
							}
	
							if(post_rows > 0){
								$("#category6").parent().parent().show();
							}
							else{
								$("#category6").parent().parent().hide();
							}
							// should change the credits only if the search consists of some new query.
							mySlider.updateMax(credits);
    					}		
						$("#result").html(responseText);
// 						alert(page);

					}
				});
		  }
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

<script>
/*BEGIN SEARCH PAGE TOUR JS */

$(document).ready(function() {



	$("#joinGroup_search_tip2_pulser")
		.delay(5000)

		.queue(function(next){

			var join_button_pos_top = $(".join-button").offset().top - 40;
			alert(join_button_pos_top);
			$(this).css({"top":join_button_pos_top,"left":"1010px"});
			next();
		});


	
});


/* END SEARCH PAGE TOUR JS */
</script>
</head>
<body>
	<div class = "root">
		<div class = "search-top-bar-wrap">
			<?php include 'topbar.php';?>
		</div>
		<!--START SEARCH PAGE TOUR PART 1 HERE -->
		<div class = "top_bar_footer_tour">
			Scroll down to browse all of the courses offered by the <a>Computer Science department</a>.
		</div>
		<!-- END SEARCH PAGE TOUR PART 1 HERE -->
		<div class = "main">
			<div class = "leftsec">
				<div class = "visible-lg">
					<div class = "searchType">
						<span class = "wedgeRight"></span>
						<div class = "search_category searchType">
							<a class = "type activeType" data-value="All"><span id="category1" class = "resultNum pull-right"></span>All Results</a>
						</div>
						<div class = "search_category searchType">
							<a class = "type inactiveType" data-value="Courses"><span id="category2" class = "resultNum pull-right"></span>Courses</a>
						</div>
						<div class = "search_category searchType">
							<a class = "type inactiveType" data-value="Professor"><span id="category3" class = "resultNum pull-right"></span>Professors</a>
						</div>
						<div class = "search_category searchType">
							<a class = "type inactiveType" data-value="Student"><span id="category4" class = "resultNum pull-right"></span>Students</a>
						</div>
						<div class = "search_category searchType">
							<a class = "type inactiveType" data-value="Clubs"><span id="category5" class = "resultNum pull-right"></span>Clubs</a>
						</div>		
						<div class = "search_category searchType">
							<a class = "type inactiveType" data-value="Posts"><span id="category6" class = "resultNum pull-right"></span>Posts</a>
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
<!-- 				<div class = "form-group">
					<label class = "col-sm control-label" for = "subject_query">Subjects:</label>
					<div class = "col-lg">
						<input class = "form-control" id = "subject_query" name = "subject[query]" type = "text" value = "">
						<div class = "dropdown subjects">
						<ul class = "subject-results" id = "subject-drop">
					
<?php
/*get the list of departments in the university*/
// 	$deptsql="SELECT * FROM department where univ_id =".$_GET['univid'];
// 	if($deptListRes = $con->query($deptsql))
// 	{
// 		while ($deptRow = $deptListRes->fetch_array(MYSQLI_ASSOC))
// 		{
?>
									<li class = "subject-results-dept" id = <?php //echo "'".$deptRow['dept_id']."'";?>>
										<div class = "subject-result-label">
											<span class = "subject-match">
											</span>
											<?php //echo $deptRow['dept_name'];?>
										</div>
									</li>
<?php 			
// 		}
		
// 	}
?>
							</ul>
							</div>
						</div>						
					</div>
-->					<!--
					<div class = "form-group advancedToggle advancedShow">
						<span class = "FAcaret"></span>
						<a class= "collapsed" href = "#">
							Advanced Options
						</a>
					</div>

					-->
					<div class = "advancedOptions">
						<div class = "form-group">
							<label class = "col-sm control-label" for = "search_query">Credits:</label>
							<div class="scrubber_slider">

							</div>
						</div>
					</div>
					<button class = "search-btn" name = "commit" id ="search" >Search</button>

			</div>
			<!--BEGIN TOUR PART2 HTML HERE -->
			<div class = "tour_fluid_row search_fluid_row">
				<div class = "tour_pulser pulsing" id = "members_search_tip1_pulser">
				</div>
				<div class = "tour_pulser pulsing" id = "joinGroup_search_tip2_pulser">
				</div>
			</div>
			<!-- END TOUR PART2 HTML HERE -->			
			<div id = "result" class = "midsec">

<!-- insert the results here -->						
			</div>			
<!-- 		<div class = "rightsec">
				<div class = "bookmarks-header">
					Bookmarks
				</div>
				<div id="bookmarks" class = "bookmarks-content">
insert the bookmarks here ->		
				</div>
			</div>
-->
		</div>
	</div>
</body>


</html>