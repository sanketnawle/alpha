<!DOCTYPE html> 
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
</script>
<link href='https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/class/syla.css">


<script src="../protected/components/class/semantic/packaged/javascript/semantic.min.js">
</script>
<link rel="stylesheet" href="../protected/components/class/semantic/packaged/css/semantic.min.css">


<script src="../js/jquery-ui-1.10.2.custom.min.js"></script>

<script src="../js/jquery.timeAutocomplete.min.js" type="text/javascript"></script>

<script src="../js/ampm.js" type="text/javascript" ></script>

<script>
$(document).ready(function() {


var month_table = new Array();
month_table[0] = "Jan";
month_table[1] = "Feb";
month_table[2] = "Mar";
month_table[3] = "Apr";
month_table[4] = "May";
month_table[5] = "Jun";
month_table[6] = "Jul";
month_table[7] = "Aug";
month_table[8] = "Sept";
month_table[9] = "Oct";
month_table[10] = "Nov";
month_table[11] = "Dec";

var weekday_table = new Array(7);
weekday_table[0]=  "Sun";
weekday_table[1] = "Mon";
weekday_table[2] = "Tue";
weekday_table[3] = "Wed";
weekday_table[4] = "Thur";
weekday_table[5] = "Fri";
weekday_table[6] = "Sat";

	var fit_height=$(window).height()-80;
	$(".pdf_render").height(fit_height);
	$(".event_render").height(fit_height);
	$( window ).resize(function() {
		fit_height=$(window).height()-80;
		$(".pdf_render").height(fit_height);
		$(".event_render").height(fit_height);
	});

	var animation_interval= setInterval(function(){
		var c=0;
	
		$( ".adot" ).each(function( index ) {
			if (!$(this).hasClass("blockshow")) {
				$(this).addClass("blockshow");
				return false;
			}else{
				c++;
			}
		});
		if (c>2) {
			$( ".adot" ).removeClass("blockshow");
		};
	}, 500);

	$(".ui.dropdown").dropdown();

	/*side card js*/
	$(document).delegate(".add_to_cal","mouseenter",function(){
		$(this).closest(".ssc_col").find(".ssc_help").show();
	});
	$(document).delegate(".add_to_cal","mouseleave",function(){
		$(this).closest(".ssc_col").find(".ssc_help").hide();
	});

	$(".time_input").timeAutocomplete({
		                    increment: 10,
                            formatter: 'ampm',
                            start_hour: 0,
	});
	/*side card js end*/


	$(document).delegate(".syla_upload_btn","click",function(){
		$(this).closest(".syla_head").find(".upload_syla").click();
	});


	var iframe= $(".pdf_render");
	$(document).delegate(".upload_syla","change",function(){
		$ref=$(this);
		pdfcandidate_name= $(this).val();
		$(".pdf_loading_animation").show();


		var formData= new FormData( $ref.closest("form")[0]);
		$.ajax({
                type: "POST",
                url: "php/syla_upload.php",
                xhr: function () {  // Custom XMLHttpRequest
                        var myXhr = $.ajaxSettings.xhr();
                        if (myXhr.upload) { // Check if upload property exists
                            myXhr.upload.addEventListener('progress', progressHandlingFunction, false); // For handling the progress of the upload
                        }
                        return myXhr;
                    },

                    
                    dataType: "json",
                    data: formData,
					contentType: false,
                    processData: false,
                    success: function (jsonArr) {
                    	var route=jsonArr.uploadedfile;

                    	$.ajax({
			                url: "HighlightDates/web/viewer.php",
			                success: function () {
			                    iframe.attr("src","HighlightDates/web/viewer.php?pdf_target="+route);
			                    $(".pdf_loading_animation").hide();
			                    checkHighlight();
			                    
			                },
			                error: function () {
		                    	alert("a");
		                    }
            			});

                    	//alert(response.uploadedfile);

                    },
                    error: function (html) {
                    	alert(html);
                    }
                });

	});


	iframe.load(function(){
		var iframe_guts= iframe.contents();
		var doc_position_compensation= 75;
		var self_height=160;
		var small_correction=15;
		iframe_guts.delegate(".evt_seed_box", "mouseenter",function(){
               var p= $(this).offset();
               var tt= p.top+doc_position_compensation;
               var tl= p.left;
               $(".pup_title_input").focus();
               $(".syla_block_pup").css({"opacity":"1","z-index":"1"});
               $(".syla_block_pup").offset({top: tt-self_height+small_correction,left: tl});

               var tid=$(this).attr("id");
               var associate= $.inArray(tid,seed_list_id);
               var dt= date_process(seed_list_dt[associate]);
               $(".syla_block_pup").find(".ssc_date_block").text(dt);

               $(".syla_block_pup").show();
        });

        iframe_guts.delegate(".evt_seed_box", "mouseleave",function(){
               //$(".syla_block_pup").hide();
               $(".syla_block_pup").css({"opacity":"0","z-index":"-1"});
               
        });
	});

	$(document).delegate(".syla_block_pup","mouseenter",function(){
		$(".pup_title_input").focus();
		$(".syla_block_pup").css({"opacity":"1","z-index":"1"});
		$(this).show();
	});
	$(document).delegate(".syla_block_pup","mouseleave",function(){
		$(".syla_block_pup").css({"opacity":"0","z-index":"-1"});
		$(this).show();
	});


	var previous_flag="";
	function checkHighlight() {
		
		var timer_ch= 
		setInterval(function(){
			var myiframe= iframe.contents();
			var flag= myiframe.find("body").find(".EVT_SEED_REPO").text();
			//alert(flag);
			if(flag!=previous_flag){
				
				previous_flag= flag;
				
				grow_seed(flag);

				arrange_events_byweek();
			}
		}, 3000);
	}

	var seed_list_id=[];
	var seed_list_dt=[];
	function grow_seed(seed){
		var seeds= seed.split(";;");
		var total= seeds.length-1;
		$.each(seeds, function( index, value ) {
			if (index==total) {
				return false;
			};

			//alert(value);
			var seedinfo= value.split("::");
			var repeat_flag=0;
			$(".syla_side_card").each(function( index, value ) {
				if($(this).attr("id")==seedinfo[0]){
					repeat_flag++;
				}
			});

			if (repeat_flag==0){
				$(".event_render").append("<div class='syla_side_card green_bordered'><div class='ssc_col ssc_col0'><input type='checkbox' class='confirm_title'><input type='text' class='title_text' placeholder='Add a title to this event'></div><div class='ssc_col ssc_col1'><div class='ssc_help'><div class='ssc_help_wedge'></div><div class='ssc_help_content'>Add to Your Calendar</div></div><div class='add_to_cal'><div></div></div><div class='ssc_title'>Dummy Title</div></div><div class='ssc_col ssc_col2'><div class='ssc_date_block'>Wed, 15, Jan</div><div class='ui dropdown ssc_type_block'><div class='text'>Lecture</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='option1'>Lecture</div><div class='item' data-value='option2'>Exam</div><div class='item' data-value='option3'>Homework</div><div class='item' data-value='option4'>Project</div></div></div></div></div>");
				var $this_evt= $(".syla_side_card").last();
				$this_evt.find(".ssc_col1").hide();
				$this_evt.find(".ui.dropdown").dropdown();

				//var processed_dt= date_process(seedinfo[1]);
				
				var date_str=" ";
				//alert(seedinfo[1]);
				date_str=date_process(seedinfo[1]);


				$this_evt.attr("id",seedinfo[0]);

				$this_evt.find(".ssc_date_block").text(date_str);

				seed_list_id.push(seedinfo[0]);
				seed_list_dt.push(seedinfo[1]);
			}
		});
	}

	function date_process(dstr){
		//alert(dstr);
		parts = dstr.split('/');
		fyear= 20+""+parts[2];
		
		year = parseInt(fyear);
    	month = parseInt(parts[0]) - 1;
    	day = parseInt(parts[1]);
    	date = new Date(year, month, day);
    	new_dtstring= weekday_table[date.getDay()]+", "+month_table[date.getMonth()]+" "+date.getDate();

    	return new_dtstring;
	}

	function arrange_events_byweek(){

		var $rt=$(".event_render");
		var howmanyweek=0;
		var lastweek=new Date(1991, 11, 16);
		var dummyweek= new Date(1991, 11, 16);
		var weeknum=1;

		$(".syla_side_card").each(function( index ) {

			var $this= $(this);

			var tid= $(this).attr("id");

			var associate= $.inArray(tid,seed_list_id);
            var dt= seed_list_dt[associate];
            parts = dt.split('/');
			fyear= 20+""+parts[2];
			
			year = parseInt(fyear);
	    	month = parseInt(parts[0]) - 1;
	    	day = parseInt(parts[1]);
	    	date = new Date(year, month, day);
	    	//alert(tid);

	    	var thismonday= new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay()+1);
	    	var thissunday= new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay()+7);

	    	if (dummyweek==lastweek) {
	    		lastweek= thissunday;
	    		$this.before( "<div class='weekbreak'>Week "+weeknum+" ( "+month_table[thismonday.getMonth()]+" "+thismonday.getDate()+" - "+ month_table[thissunday.getMonth()]+" "+thissunday.getDate()+" )</div>" );
	    		weeknum++;
	    	}

	    	else if (date>lastweek) {
	    		lastweek= thissunday;
	    		$this.before( "<div class='weekbreak'>Week "+weeknum+" ( "+month_table[thismonday.getMonth()]+" "+thismonday.getDate()+" - "+ month_table[thissunday.getMonth()]+" "+thissunday.getDate()+" )</div>" );
	    		weeknum++;
	    	}




		});
	}


	/*progress handling function for ajax*/
	function progressHandlingFunction(e){
    	if(e.lengthComputable){
   			$('progress').attr({value:e.loaded,max:e.total});
    	}
	}


	});
</script>


</head>
<body>
	<div class="syla_head">
		<div class='syla_title'>Computer Science 171 Syllabus</div>
		<div class='syla_like'><div class='like_sign'></div><div class="like_num">4</div></div>
		<div class='syla_upload_btn blue_btn'>Upload Syllabus</div>
		<form>
            <input type="file" name='file' class="upload_syla">
        </form>

	</div>

	<div class="syla_body">
		<div class='pdf_loading_animation'><span>Loading</span><span class='adot'>.</span><span class='adot'>.</span><span class='adot'>.</span></div>
		<iframe class='pdf_render' src="" frameBorder="0" width="700" height="800">
		</iframe>

		<div class='syla_block_pup'>
			<div class='syla_popup'>
				<div class='pup_col0'><div class='pup_col0_0'><div class='green_circ'></div></div><input class='title_text pup_title_input' type='text' placeholder='Add a title to this event'></div>
				<div class='pup_col1'><div class='ssc_date_block'>loading...</div><input class='time_input' type='text' placeholder='Add a time'></div>
				<div class='pup_col2'><div class='pup_col2_0'>Category : </div><div class='ui dropdown ssc_type_block pup_type_block'><div class='text'>Lecture</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='option1'>Lecture</div><div class='item' data-value='option2'>Exam</div><div class='item' data-value='option3'>Homework</div><div class='item' data-value='option4'>Project</div></div></div></div>
				<div class='pup_col3'><div class='evt_btn blue_btn'>Add Event</div> <div class='pup_col3_1'>Cancel</div></div>
			</div>
			<div class='pup_wedge'></div>
			<div class='pup_wedge_border'></div>
		</div>

		<div class='event_render' src="" frameBorder="0" width="220" height="1000">
		</div>
	</div>
</body>
</html>