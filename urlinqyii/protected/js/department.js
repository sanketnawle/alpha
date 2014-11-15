//I couldn't find the code for faculty and students but for when it's written I am assuming master div's would be named
//.department_students_tab and .department_faculty_tab

$(document).ready(function(){
	
	$('.tabFeed').on('click', function(){
		$('.department_courses_tab').hide();
		$('.department_faculty_tab').hide();
		$('.department_students_tab').hide();
		$('.department_feed_tab').show();
		$('.department_feed_right_about').show();
	});

	$('.tabDepartments').on('click', function() {
		$('.department_faculty_tab').hide();
		$('.department_students_tab').hide();
		$('.department_feed_tab').hide();
		$('.department_feed_right_about').hide();
		$('.department_courses_tab').show();
		
	});

	$('.tabmembers').on('click', function() {
		$('.department_students_tab').hide();
		$('.department_feed_tab').hide();
		$('.department_feed_right_about').hide();
		$('.department_courses_tab').hide();
		$('.department_faculty_tab').show();
	});

	$('.tabstudents').on('click', function() {
		$('.department_feed_tab').hide();
		$('.department_feed_right_about').hide();
		$('.department_courses_tab').hide();
		$('.department_faculty_tab').hide();
		$('.department_students_tab').show();
	});


});