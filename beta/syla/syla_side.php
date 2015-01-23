<!DOCTYPE html> 
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
</script>
<link href='https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/syla.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
</script>

<script src="semantic/packaged/javascript/semantic.min.js">
</script>


<link rel="stylesheet" href="semantic/packaged/css/semantic.min.css">


<script src="js/jquery-ui-1.10.2.custom.min.js"></script>

<script src="js/jquery.timeAutocomplete.min.js" type="text/javascript"></script>

<script src="js/ampm.js" type="text/javascript" ></script>



<script>
$(document).ready(function() {
	$(".ui.dropdown").dropdown();
	
	$(".time_input").timeAutocomplete({
		                    increment: 10,
                            formatter: 'ampm',
                            start_hour: 0,
	});

});
</script>
</head>
<body>
	<div class='syla_block_pup'>
	<div class='syla_popup'>
		<div class='pup_col0'><div class='pup_col0_0'><div class='green_circ'></div></div><input class='title_text pup_title_input' type='text' placeholder='Add a title to this event'></div>
		<div class='pup_col1'><div class='ssc_date_block'>Wed, 15, Jan</div><input class='time_input' type='text' placeholder='Add a time'></div>
		<div class='pup_col2'><div class='pup_col2_0'>Category : </div><div class='ui dropdown ssc_type_block pup_type_block'><div class='text'>Lecture</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='option1'>Lecture</div><div class='item' data-value='option2'>Exam</div><div class='item' data-value='option3'>HmWork</div><div class='item' data-value='option4'>Project</div></div></div></div>
		<div class='pup_col3'><div class='evt_btn'>Add Event</div> <div class='pup_col3_1'>Cancel</div></div>
	</div>
	<div class='pup_wedge'></div>
	</div>
</body>
</html>