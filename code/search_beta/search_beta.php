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
      right_scrubber_pos : 7,
			round_by : 1,
			rounded	: true,
			
			// Event during initialization
			release : function(e)
			{
				// custom function for this event
				console.log("Event happened, this object contains: \n\n { \n min : "+ e.min + ",\nmax : " + e.max + "\n");
			}
		});

/*ajax call initial*/
		var search_string = <?php if (isset($search_string))
									echo "'".$search_string."'";
								  else
								  	echo "''"; 
							?>;
		var search_type = "All";
		var univ_id = <?php echo $_GET['univid'];?>;
		$.ajax({
			type: "POST",
			url: "search_filter.php",
			data:{search_type:search_type, search_string:search_string, univid: univ_id},
			success: function(data){
				var obj = JSON.parse(data);
				$("#category1").text(obj.all_rows);
				$("#category2").text(obj.course_rows);
				$("#category3").text(obj.student_rows);
				$("#category4").text(obj.professor_rows);
				$("#category5").text(obj.group_rows);
				$(
			}
		});					
  });
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
				<form accept-charset = "UTF-8" action = "/search" id = "new_search" class = "searchForm" method = "get" role = "form">
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
	if($deptListRes = $dbObj->query($deptsql))
	{
		while ($deptRow = $deptListRes->fetch_array(MYSQLI_ASSOC))
		{
?>									<li class = "subject-results-dept">
										<div class = "subject-result-label" id = <?php echo "'".$deptRow['dept_name']."'";?>>
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
					<input class = "search-btn" name = "commit" type = "submit" value = "Search">
				</form>

			</div>
			<div class = "midsec">
				<div class = "all_results_active">
					<div class = "horiz-area">
						<div class = "horiz-wrapper">
							<div class = "horiz-mask">
								<div class = "content-area">
									<div class = "ContentSlider">
										<div class = "slide">
											<div class = "slide-inner">
												<div class = "result-photo">
													<img src = "src/resultPic1.jpg">

													<h3>Professor Di Bartolo</h3>
													<p>Applied Physics</p>
												</div>			
												<div class = "person-bottom-functions">
													<div class = "link-button">
														<a class = "link link-up">
															Follow
														</a>
													</div>
												</div>	
											</div>
										</div>
										<div class = "slide">
											<div class = "slide-inner">
												<div class = "result-photo">
													<img src = "src/person-result-image.jpg">
													<h3>Matthew H. Tully</h3>
													<p>Applied Physics</p>
												</div>								
											</div>
										</div>
										<div class = "slide">
											<div class = "slide-inner">
												<div class = "result-photo">
													<img src = "src/resultPic1.jpg">
													<h3>Professor Di Bartolo</h3>
													<p>Applied Physics</p>
												</div>								
											</div>
										</div>
										<div class = "slide">
											<div class = "slide-inner">
												<div class = "result-photo">
													<img src = "src/resultPic1.jpg">
													<h3>Professor Di Bartolo</h3>
													<p>Applied Physics</p>
												</div>								
											</div>
										</div>
										<div class = "slide">
											<div class = "slide-inner">
												<div class = "result-photo">
													<img src = "src/resultPic1.jpg">
													<h3>Professor Di Bartolo</h3>
													<p>Applied Physics</p>
												</div>								
											</div>
										</div>
										<div class = "slide">
											<div class = "slide-inner">
												<div class = "result-photo">
													<img src = "src/resultPic1.jpg">
													<h3>Professor Di Bartolo</h3>
													<p>Applied Physics</p>
												</div>								
											</div>
										</div>
										<div class = "slide">
											<div class = "slide-inner">
												<div class = "result-photo">
													<img src = "src/resultPic1.jpg">
													<h3>Professor Di Bartolo</h3>
													<p>Applied Physics</p>
												</div>								
											</div>
										</div>
										<div class = "slide">
											<div class = "slide-inner">
												<div class = "result-photo">
													<img src = "src/resultPic1.jpg">
													<h3>Professor Di Bartolo</h3>
													<p>Applied Physics</p>
												</div>								
											</div>
										</div>
										<div class = "slide">
											<div class = "slide-inner">
												<div class = "result-photo">
													<img src = "src/resultPic1.jpg">
													<h3>Professor Di Bartolo</h3>
													<p>Applied Physics</p>
												</div>								
											</div>
										</div>
										<div class = "slide">
											<div class = "slide-inner">
												<div class = "result-photo">
													<img src = "src/resultPic1.jpg">
													<h3>Professor Di Bartolo</h3>
													<p>Applied Physics</p>
												</div>								
											</div>
										</div>
										<div class = "slide">
											<div class = "slide-inner">
												<div class = "result-photo">
													<img src = "src/resultPic1.jpg">
													<h3>Professor Di Bartolo</h3>
													<p>Applied Physics</p>
												</div>								
											</div>
										</div>
										<div class = "slide">
											<div class = "slide-inner">
												<div class = "result-photo">
													<img src = "src/resultPic1.jpg">
													<h3>Professor Di Bartolo</h3>
													<p>Applied Physics</p>
												</div>								
											</div>
										</div>
										<div class = "slide">
											<div class = "slide-inner">
												<div class = "result-photo">
													<img src = "src/resultPic1.jpg">
													<h3>Professor Di Bartolo</h3>
													<p>Applied Physics</p>
												</div>								
											</div>
										</div>
										<div class = "slide">
											<div class = "slide-inner">
												<div class = "result-photo">
													<img src = "src/resultPic1.jpg">
													<h3>Professor Di Bartolo</h3>
													<p>Applied Physics</p>
												</div>								
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class = "arrow-disabled arrow-container arrow-prev">
								<a class = "ar-disabled ar-left">

								</a>
							</div>
							<div class = "arrow-container arrow-next">
								<a id = "ar-right" class = "ar-right">
									
								</a>
							</div>
						</div>
					</div>
					<div class = "vert-area">
						<div class = "course vert-results-wrapper">
<!-- insert the courses here -->						

						</div>

						<div class = "person vert-results-wrapper">
							<a class = "person-result-image">
								<div style = "background-image: url(src/person-result-image.jpg);" class = "img"></div>
							</a>
							<div class = "person-main">
								<div class = "person-header">
									<div class = "result-header">
										<h2>Professor Tully</h2>
										<span>—</span>
										<p>Department of Mathematics</p>					
									</div>
									<div class = "result-header-right">
										<div class = "result-functions-wrapper">
											<div class = "prof-btn-small btn-small fav">
											</div>			
											<div class = "prof-tooltip tooltip">
												<div class = "tool-wedge"></div>
												<div class = "prof-tool-box tool-box">
													<span>Add This Professor To My Bookmarks</span>
												</div>
											</div>														
										</div>

									</div>
								</div>
								<div class = "person-result-main">
									<div class = "person-info">
										<div style = "background-image: url(src/nyu_poly.jpg);" class = "title-limit">
										</div>
										<h4>NYU Polytechnic School of Engineering</h4> 
									</div>
									<div class = "person-info">
										<div class = "title-limit mail">
										</div>
										<h4>matt.tully@poly.edu</h4>										
									</div>
									<div class = "person-info info-location">
										<div class = "title-limit location">
										</div>
										<h4>Metrotech 7-415</h4>				
									</div>
								</div>
								<div class = "person-bottom-functions">
									<div class = "link-button">
										<a class = "link link-up">
											Follow
										</a>
									</div>
								</div>									
							</div>
						</div>
					</div>
				</div>
				<div class = "course_results_active">
					<div class = "vert-area">
						<div class = "course vert-results-wrapper">
							<div class = "results-top-sec">
								<div class = "result-header">

									<div class = "title-limit"></div>
									<h2>Electromagnetism - Principles of Applied Physics I</h2>
									<p>k4300 —</p>
									<p>4.0 credits</p>
								</div>
								<div class = "result-header-right">
									<div class = "result-functions-wrapper">
										<div class = "btn-small fav">
										</div>			
										<div class = "tooltip">
											<div class = "tool-wedge"></div>
											<div class = "tool-box">
												<span>Add This Course To My Bookmarks</span>
											</div>
										</div>														
									</div>

								</div>
							</div>
							<div class = "results-main-sec">
								<div class = "description">
									Prerequisites: SPAN W3349 or SPAN W3350 and Language requirements 3300, 3330 This course will read Venezuela backwards in films, poems, novels and essays, from the present-tense struggle over the legacy of chavismo to the early days of independence.  The constant thread will be the conflict between development and nature with special attention to natural resources and eco-critical approaches.<span><a>More Info</a></span>
								</div>
								<div class = "lower-info-keys">
									<div class = "info-key instructor">
										Instructor
									</div>
									<div class = "info-key subject">
										Department
									</div>
									<div class = "info-key members">
										Members
									</div>
								</div>

								<div class = "lower-info">
									<div class = "info-piece instructor">
										Professor Di Bartolo
									</div>
									<div class = "info-piece subject">
										Applied Physics
									</div>
									<div class = "info-piece members">
										<div class = "member-pics-wrapper">
											<a class = "innerPic">
						                      <div class = "smallPic">
						                        <img class = "img" src = "src/person1.jpg" width = "29" height = "29">
						                      </div>
						                    </a>
						                    <a class = "innerPic">
						                      <div class = "smallPic">
						                        <img class = "img" src = "src/person2.jpg" width = "29" height = "29">
						                      </div>
						                    </a>
						                    <a class = "innerPic">
						                      <div class = "smallPic">
						                        <img class = "img" src = "src/person3.jpg" width = "29" height = "29">
						                      </div>
						                    </a>
						                    <a class = "innerPic">
						                      <div class = "smallPic">
						                        <img class = "img" src = "src/person4.jpg" width = "29" height = "29">
						                      </div>
						                    </a>
						                    <a class = "innerPic">
						                      <div class = "smallPic">
						                        <img class = "img" src = "src/person5.jpg" width = "29" height = "29">
						                      </div>
						                    </a>
						                    <a class = "rosterLink">
						                      <div class = "doubleBox">
						                        +67
						                      </div>
						                    </a>
										</div>
									</div>
								</div>	

								<div class = "result-bottom">
									<div class = "course-schedule">

									</div>
									<div class = "course-bottom-functions">
										<div class = "join-button">
											<a class = "join sign-up">
												Join Class
											</a>
										</div>
									</div>									
								</div>					
							</div>
						</div>

					</div>					
				</div>
				<div class ="prof_results_active">
					<div class ="vert-area">
						<div class = "person vert-results-wrapper">
							<a class = "person-result-image">
								<div style = "background-image: url(src/person-result-image.jpg);" class = "img"></div>
							</a>
							<div class = "person-main">
								<div class = "person-header">
									<div class = "result-header">
										<h2>Professor Tully</h2>
										<span>—</span>
										<p>Department of Mathematics</p>					
									</div>
									<div class = "result-header-right">
										<div class = "result-functions-wrapper">
											<div class = "prof-btn-small btn-small fav">
											</div>			
											<div class = "prof-tooltip tooltip">
												<div class = "tool-wedge"></div>
												<div class = "prof-tool-box tool-box">
													<span>Add This Professor To My Bookmarks</span>
												</div>
											</div>														
										</div>

									</div>
								</div>
								<div class = "person-result-main">
									<div class = "person-info">
										<div style = "background-image: url(src/nyu_poly.jpg);" class = "title-limit">
										</div>
										<h4>NYU Polytechnic School of Engineering</h4> 
									</div>
									<div class = "person-info">
										<div class = "title-limit mail">
										</div>
										<h4>matt.tully@poly.edu</h4>										
									</div>
									<div class = "person-info info-location">
										<div class = "title-limit location">
										</div>
										<h4>Metrotech 7-415</h4>				
									</div>
								</div>
								<div class = "person-bottom-functions">
									<div class = "link-button">
										<a class = "link link-up">
											Follow
										</a>
									</div>
								</div>									
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class = "rightsec">
				<div class = "bookmarks-header">
					Bookmarks
				</div>
				<div class = "bookmarks-content">
					<div class = "bookmark-piece">
						<div class = "bookmark-title-clear">
							<p class = "bookmark-title">Electromagnetism - Principles of Applied Physics I</p>
						</div>
						<div class = "bookmark-timing"><p>MWF 9:40 am</p></div>
					</div>

					<div class = "bookmark-piece">
						<div class = "bookmark-title-clear">
							<p class = "bookmark-title">Chili Con Carne</p>
						</div>
						<div class = "bookmark-timing busy"><p>MWF 9:40 am</p></div>
					</div>	

					<div class = "bookmark-piece">
						<div class = "bookmark-title-clear">
							<p class = "bookmark-title">Chili Con Carne</p>
						</div>
						<div class = "bookmark-timing busy"><p>MWF 9:40 am</p></div>
					</div>										
				</div>
			</div>
		</div>
	</div>
</body>


</html>