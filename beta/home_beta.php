<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    <link href='http://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/planner.css">
    <link rel="stylesheet" type="text/css" href="css/datepicker.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>

    <script src='js/md5.js'></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>    
	<script src="js/jquery.min.js" type="text/javascript"></script>	
    <script src="js/jquery-ui-1.10.2.custom.min.js"></script>
</head>
<body>
    <div class="root">
        <div class="top-bar">
            <div class="top-bar-wrapper">
                
            </div>
        </div>
        <div class="main">
            <div class="wrapper">
                <div class="mainContainer">
                    <div class="leftsec">
                    </div>
                    <div class="content-wrap">

                        <div class="midsec">
                           
                        </div>
                        <div class="rightsec">
							<div class="n_pf_5" id="divPlanner">              
								<?php include('planner.php'); ?>
								<script src="js/jquery.timeAutocomplete.min.js" type="text/javascript"></script>
								<script src="js/ampm.js" type="text/javascript" ></script>
								<script src="js/calendar_selector.js" type="text/javascript"></script>
								<script src="js/planner.js" type="text/javascript"></script>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
