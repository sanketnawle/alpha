<?php
	$pg_src = substr(strrchr($_SERVER['SCRIPT_NAME'], "/"), 1);
	if($pg_src == "profile.php" && isset($_GET['user_id'])) {
		$target_type = "profile";
		$target_id = $_GET['user_id'];
	}
	elseif($pg_src == "class.php" && isset($_GET['class_id'])) {
		$target_type = "class";
		$target_id = $_GET['class_id'];
	}
	elseif($pg_src == "courses.php" && isset($_GET['course_id'])) {
		$target_type = "course";
		$target_id = $_GET['course_id'];
	}
	elseif($pg_src == "clubs.php" && isset($_GET['group_id'])) {
		$target_type = "group";
		$target_id = $_GET['group_id'];
	}
	elseif($pg_src == "department.php" && isset($_GET['dept_id'])) {
		$target_type = "department";
		$target_id = $_GET['dept_id'];
	}
	elseif($pg_src == "school.php" && isset($_GET['univ_id'])) {
		$target_type = "school";
		$target_id = $_GET['univ_id'];
	}
	else{
		$target_type = NULL;
		$target_id = NULL;
	}
?>

<!DOCTYPE html> 
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="css/fbar.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
</script>

<script type="text/javascript" src="https://apis.google.com/js/api.js"></script>
<script src="filepicker.js"></script>
	<script>
		init = function(appID,fileID) {
        s = new gapi.drive.share.ShareClient(appID);
        s.setItemIds([fileID]);
    }

		function initPicker() {
			var picker = new FilePicker({
				apiKey: 'AIzaSyDXcdGwlZUFArSbExSC81-g4PIlAA6vzD4',
				clientId: '648831685142-djuu0p1kanvmn751rnj189avhde81ckt',
				buttonEl: document.getElementById('pick'),
				onSelect: function(file) {
					console.log(file);
					//alert(file);
					$(".googleuploadinfoarchive_fbar").val(file);
					var nm= file.split("||")[3].trim();
					var shortnm=nm;
					if(shortnm.length>=18){
                              		shortnm= shortnm.substring(0,15)+"...";
                              	}

					$(".googleuploadinfoarchive_fbar").closest(".driveUpload").find(".drive_link").attr("title",nm);
					$(".googleuploadinfoarchive_fbar").closest(".driveUpload").find(".drive_link").text(shortnm);
					//alert($(".googleuploadinfoarchive_fbar").val());
					// gapi.load('drive-share', init('648831685142',file));
					gapi.client.request({
						'path': '/drive/v2/files/'+file,
       					'method': 'GET',
       					callback: function (responsejs, responsetxt){
           				var downloadUrl = responsejs.downloadUrl;
       }
					})
				}
			});	
		}
	</script>
	
	<script src="https://www.google.com/jsapi?key='AIzaSyDXcdGwlZUFArSbExSC81-g4PIlAA6vzD4'"></script>
	<script src="https://apis.google.com/js/client.js?onload=initPicker"></script>

<script>
		navigator.sayswho= (function(){
    		var ua= navigator.userAgent, tem, 
   			 M= ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
    		if(/trident/i.test(M[1])){
        		tem=  /\brv[ :]+(\d+)/g.exec(ua) || [];
     		   return 'IE '+(tem[1] || '');
    			}
    		if(M[1]=== 'Chrome'){
        		tem= ua.match(/\bOPR\/(\d+)/)
        		if(tem!= null) return 'Opera '+tem[1];
    			}
    		M= M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
    		if((tem= ua.match(/version\/(\d+)/i))!= null) M.splice(1, 1, tem[1]);
    		return M.join(' ');
			})();
</script>
<script>
$(document).ready(function() {

    $(".multiple_type").on("click", function() {
        $(".multiple_type").css("color", "#4697C2");
        $(".truth_type").css("color", "rgba(153, 153, 153, 0.64)");
        $(".textwrap2").css("display", "none");
        $(".multiple_choice").css("display", "block");
        $(".true_false").css("display", "none");
    });

    $(".truth_type").on("click", function() {
        $(".truth_type").css("color", "#4697C2");
        $(".multiple_type").css("color", "rgba(153, 153, 153, 0.64)");
        $(".textwrap2").css("display", "none");
        $(".true_false").css("display", "block");
        $(".multiple_choice").css("display", "none");
    });

    $(".answer_check").delegate("input", "click", function() {
        if ($(this).parent().hasClass("selected_answer")) {
            $(this).parent().removeClass("selected_answer");
            $(this).prop("checked", false);
        }
        else {
            if($(".answer_check input").prop("checked", true)) {
                $(".answer_check input").prop("checked", false);
                $(".answer_check").removeClass("selected_answer");
                $(".answer_check").css("display", "none");
                $(this).prop("checked", true);
                $(this).parent().addClass("selected_answer");
                $(this).parent().css("display", "inline-block");
            }
        }
    });

    $(".tf_line").mouseenter(function() {
        $(this).find(".answer_check").css("display", "inline-block");
    });

    $(".tf_line").mouseleave(function() {
        if (!($(this).find(".answer_check").hasClass("selected_answer"))) {
            $(this).find(".answer_check").css("display", "none");
        }
    });

    $(".multiple_choice").delegate(".question_choice_line", "mouseenter", function() {
        $(this).find(".answer_check").css("display", "inline-block");
        $(this).find(".add_choice").css("display", "none");
        $(this).find(".letter_choice").css("display", "inline-block");
    });

    $(".multiple_choice").delegate(".question_choice_line", "mouseleave", function() {
        if (!($(this).find(".answer_check").hasClass("selected_answer"))) {
            $(this).find(".answer_check").css("display", "none");
        }
        if ($(this).find(".multiple_choice_answer").val() == "") {
            $(this).find(".letter_choice").css("display", "none");
            $(this).find(".add_choice").css("display", "inline-block");
        }
    });

    function nextChar(c) {
        return String.fromCharCode(c.charCodeAt(0) + 1);
    }


    $(".multiple_choice").delegate(".multiple_choice_answer", "change", function() {
        var mult_q_box = $(this).parent().parent();
        if ($(this).val() != "") {
            $(this).parent().find(".fixed_choice_prefix .letter_choice").css("display", "inline-block");
            $(this).parent().find(".fixed_choice_prefix .add_choice").css("display", "none");
        }
        var all_filled = true;
        mult_q_box.find(".multiple_choice_answer").each(function() {
            if ($(this).val() == "") {
                all_filled = false;
                //return false;
            }
        });
        if ($(".multiple_choice").children().length == 26) {
            all_filled = false;
        }
        if (all_filled) {
            var last_letter = $(".multiple_line").last().find(".letter_choice span").text();
            var letter = nextChar(last_letter);
            var multiple_line_copy = mult_q_box.find(".multiple_line").last().clone();
            mult_q_box.append(multiple_line_copy);
            var last_choice = $(".multiple_choice_answer").last();
            last_choice.val("");
            last_choice.attr("placeholder", "Add choice " + letter + "...(optional)");
            multiple_line_copy.find(".letter_choice span").text(letter);
            multiple_line_copy.find(".answer_check").removeClass("selected_answer");
            multiple_line_copy.find(".answer_check input").prop("checked", false);
            multiple_line_copy.find(".answer_check").css("display", "none");
            var new_id = multiple_line_copy.find(".answer_check input").attr("id");
            new_id = new_id.substring(0, new_id.length-1)+letter;
            multiple_line_copy.find(".answer_check input").attr("id", new_id);
        }
    });

                $('.post').click(function(){

                	$('#fbar').css('height','auto');
                	$("#fbar").find('.postTxtarea').show();
                	$("#fbar").find('.postTxtarea').focus();
                	$("#fbar").find('.post').css('cursor','default');

                	$("#fbar").find('.post').removeClass('fani');
                	$("#fbar").find('.post-sec').show();
                	$("#fbar").find('.share').addClass('fani');
                	$("#fbar").find('.find').addClass('fani');
                	$("#fbar").find('.share').css('cursor','pointer');
                	$("#fbar").find('.find').css('cursor','pointer');
                	$("#fbar").find('.fbtn-post ').css('color','#333');
                	$("#fbar").find('.fbtn-post ').css('color','#333');
                	$("#fbar").find('.fbtn-ask').css('color','#666');
                	$("#fbar").find('.fbtn-upload ').css('color','#666');                	
                	$("#fbar").find(".wedge1a").show();
                	$("#fbar").find(".wedge1b").show();
	 				$("#fbar").find(".wedge2a").hide();
	                $("#fbar").find(".wedge2b").hide();
					$("#fbar").find(".wedge3a").hide();
	                $("#fbar").find(".wedge3b").hide(); 
	                $("#fbar").find('.btmfbar2').hide();
	                 $("#fbar").find('.btmfbar').show(); 
	                 $("#fbar").find(".ask_state").hide();
	                 $("#fbar").find('.uploadTxtarea').hide(); 
	                 $("#fbar").find('.uploadMode').hide();

	                 /*clean text rendering*/
	                 $(".postTxtarea").val("");
	                 $(".uploadTxtarea").val("");
	                 $(".questtxt").val("");
	                 $(".askTxtArea").val("");
	                 /*clean text rendering end*/
                 });

                $('.share').click(function(){
                	$('#fbar').css('height','auto');
                	$("#fbar").find('.share').css('cursor','default');
                	$("#fbar").find('.find').css('cursor','pointer');

                	$("#fbar").find('.post').css('cursor','pointer');
                	$("#fbar").find('.share').removeClass('fani');
                	$("#fbar").find('.post-sec').show();
                	$("#fbar").find('.find').addClass('fani');
                	$("#fbar").find('.post').addClass('fani');
                	$("#fbar").find('.fbtn-upload ').css('color','#333');
                	$("#fbar").find('.fbtn-post ').css('color','#666');
                	$("#fbar").find('.fbtn-ask ').css('color','#666');                
                	$("#fbar").find(".wedge2a").show();
                	$("#fbar").find(".wedge2b").show();	
	 				$("#fbar").find(".wedge1a").hide();
	                $("#fbar").find(".wedge1b").hide();
					$("#fbar").find(".wedge3a").hide();
					$("#fbar").find(".ask_state").hide();
	                $("#fbar").find(".wedge3b").hide();    
	                $("#fbar").find('.postTxtarea').hide();           
	                 $("#fbar").find('.btmfbar').hide();	
	                 $("#fbar").find('.upload_state').show();
	                 $("#fbar").find('.btmfbar2').show();
	                 $("#fbar").find('.uploadTxtarea').show(); 
	                 $("#fbar").find('.uploadTxtarea').focus();
	                 $("#fbar").find('.uploadMode').show();

	                 /*clean text rendering*/
	                 $(".postTxtarea").val("");
	                 $(".uploadTxtarea").val("");
	                 $(".questtxt").val("");
	                 $(".askTxtArea").val("");
	                 /*clean text rendering end*/
                 });

                $('.find').click(function(){
                	$('#fbar').css('height','auto');
                	$("#fbar").find('.find').css('cursor','default');
                	$("#fbar").find('.find').removeClass('fani');
                	$("#fbar").find('.post-sec').show();
                	$("#fbar").find('.share').addClass('fani');
                	$("#fbar").find('.post').addClass('fani');
                 	$("#fbar").find('.share').css('cursor','pointer');
                	$("#fbar").find('.post').css('cursor','pointer');
                	$("#fbar").find('.fbtn-ask ').css('color','#333');
                	$("#fbar").find('.fbtn-upload ').css('color','#666');
                	$("#fbar").find('.fbtn-post ').css('color','#666');
                 	$("#fbar").find(".wedge3a").show();
                	$("#fbar").find(".wedge3b").show();               
	 				$("#fbar").find(".wedge1a").hide();
	 				
	                $("#fbar").find(".wedge1b").hide();                
	 				$("#fbar").find(".wedge2a").hide();
	                $("#fbar").find(".wedge2b").hide();	
	                $("#fbar").find('.postTxtarea').hide();
	                $("#fbar").find('.btmfbar').hide(); 
	                $("#fbar").find('.uploadTxtarea').hide(); 
	                $("#fbar").find('.uploadMode').hide();      
	                $("#fbar").find('.btmfbar2').hide();         	                	
	                $("#fbar").find(".ask_state").show();
	                $("#fbar").find(".topfbar").focus();

	                /*clean text rendering*/
	                 $(".postTxtarea").val("");
	                 $(".uploadTxtarea").val("");
	                 $(".questtxt").val("");
	                 $(".askTxtArea").val("");
	                 /*clean text rendering end*/
                 }); 


				$('.who-dyn').mouseover(function(){
					$('.who-explain').css('visibility','visible');
					$('.who-explain').mouseover(function(){
						$('.who-explain').css('visibility','visible');
					});
					$('.who-explain').mouseout(function(){
						$('.who-explain').css('visibility','hidden');
					});
					$('.who-dyn').mouseout(function(){
						$('.who-explain').css('visibility','hidden');
					});
				});

				$(document).delegate(".fani","mouseover",function(){
					$(this).find(".fbtn").css({"color":"#333"});
				});

				$(document).delegate(".fani","mouseout",function(){
					$(this).find(".fbtn").css({"color":"#666"});
				});

                 $('.select').on('click','li',function(){
					  var $t = $(this),
					      $f = $(this).closest(".search-select").find('.field_fbar');
					      text = $t.text(),
					      icon = $t.find('i').attr('class');
					  $f.find('label').text(text);
					  $f.find('i').attr('class',icon)
					});
					$('.field_fbar').click(function(e){
					  e.preventDefault();
					  $('#open').click();
					});

					

				$(document).delegate(".field_fbar","click",function(){
					$(".select").stop().fadeIn(200);

					var cur= $(this).closest(".field_fbar").find("i").attr("class");
					
					$( ".select li" ).each(function( index ) {
						if($(this).find("i").attr("class")==cur){
							$(this).hide();
						}else{
							$(this).show();
						}
					});	
					
				});    

			     $(document).click(function(event){
			     	var $target= $(event.target);
			     	var $container= $(".search-select");
			     	if(!$container.is($target)&&($container.has($target).length===0)){
			     		$(".select").stop().fadeOut(150);
			     	}

			     	if($target.hasClass("selitem")){
			     		$(".select").stop().fadeOut(150);
			     	}

			     	var $container2= $(".tag-option");
			     	var $container3= $(".midfbar-exp");
			     	if(!$container2.is($target)&&($container2.has($target).length===0)){
			     		if(!$container3.is($target)&&($container3.has($target).length===0)){
			     		$(".tag-option").stop().fadeOut(150);
			     		}
			     	}

				});


			   /*upload hack process.*/
			   $(document).delegate(".attach-mod","click",function(){
			   
                                $(this).closest(".controlpad").find('.upload_hack').click();

                                return false;
                              });

			   /*The following process need to be further modified according to backend*/

			   /*
			   $(".upload_button").click(function() {
                                    $(".upload_hack").click(); 
                                    });
			   */
			   $(document).delegate(".upload_hack","change",function(){
			   					var $hack=$(this).closest(".controlpad").find('.upload_hack');
                              	//alert($hack.val());

                              	var filename= $hack.val();

                              	if(filename.length>=18){
                              		filename= filename.substring(0,15)+"...";
                              	}

                              	$(this).closest(".controlpad").find(".upload_textprompt").text(filename);
                              	$(this).closest(".controlpad").find(".upload_textprompt").attr("title",$hack.val());
                                    //need to modify
                                    //$('.attach_form').submit();
                                }); 




				

				$(document).delegate("._uplI","change",function(){
			   					var $hack=$(this).closest(".upl_wrap").find('._uplI');
                              	//alert($hack.val());

                              	$(this).closest(".upl_wrap").find(".uplName").text($hack.val());
                              	$(this).closest(".upl_wrap").find(".uplName").attr("title",$hack.val());
                                    //need to modify
                                    //$('.attach_form').submit();
                                }); 



	//textara auto growth
    $(".autogrowth_textarea").mousemove(function(e) {
        var myPos = $(this).offset();
        myPos.bottom = $(this).offset().top + $(this).outerHeight();
        myPos.right = $(this).offset().left + $(this).outerWidth();
        
        if (myPos.bottom > e.pageY && e.pageY > myPos.bottom - 16 && myPos.right > e.pageX && e.pageX > myPos.right - 16) {
            $(this).css({ cursor: "nw-resize" });
        }
        else {
            $(this).css({ cursor: "" });
        }
    })
    //  the following simple make the textbox "Auto-Expand" as it is typed in
    .keyup(function(e) {
        //  the following will help the text expand as typing takes place
        while($(this).outerHeight() < this.scrollHeight + parseFloat($(this).css("borderTopWidth")) + parseFloat($(this).css("borderBottomWidth"))) {
            $(this).height($(this).height()+1);
        };
    });




    /*tagging function*/

    var tags=new Array();

    
    $(document).delegate(".midfbar-exp","click",function(e){
    	$(".add_who").focus();
    });

    /*
    $(document).delegate(".add_who","keydown",function(e){
    	$(".tag-option").show();
    });
	*/

    $(document).delegate(".add_who","keyup",function(e){
    	var code = e.keyCode || e.which;
    	var $input= $(this);
    	var len_detect=$(this).val().trim().length;
    	var query=$(this).val().trim();
    	//alert(len_detect);

    	if(len_detect>=2){
    		$.ajax({
	            		type: "POST",
            			url: "includes/fbarexp.php",
            			data: {query:query},
            			success: function(html){ 
            					$(".tag-option").html(html);
            					$(".tag-option").show();
			          	}
					});
    	}else{
    		$(".tag-option").hide();
    	}
    	/*
    	if(code==32){
    		var tag= $input.val().split(" ").join("").trim().toLowerCase();

    		if(tag!=""){
    			$(".midfbar-exp").prepend("<div class='who-is-tagged' id='wit_"+tag+"'><div class='tag-name'>"+tag+"</div><div class='tag-close'></div></div>");
    			tags.push(tag);
    			$input.val(" ");
    		}
    	}
		*/
    	
    	if(code==8){
    		if($input.val()==""){
    			var tag= tags[0];
    			tags.shift();
    			$("#wit_"+tag).remove();
    		}
    	}
    });


	var tags_type=new Array();
	$(document).delegate(".tag-col","click",function(e){
		var tagname=$(this).text();
		var tag= $(this).attr("id").trim();
		var tp= "";
		if($(this).hasClass("user")){tp="user";}
		if($(this).hasClass("courses")){tp="courses";}
		var isin=$.inArray(tag, tags);
		
		if(isin==-1){
			tags.push(tag);
			tags_type.push(tp);

			$(".midfbar-exp").find(".add_who").remove();
			$(".midfbar-exp").append("<div class='who-is-tagged' id='wit_"+tag+"'><div class='tag-name'>"+tagname+"</div><div class='tag-close'></div></div>");
			$(".midfbar-exp").append("<input placeholder = '+ Ask experts' class = 'add_who'></input>");
			$(".add_who").val("");
			$(".add_who").focus();
			$(".tag-option").hide();
		}

	});    



	$(document).delegate(".tag-close","click",function(e){
		var tag= $(this).closest(".who-is-tagged").attr("id").trim().substring(4);
		//alert("a");
		var isin=tags.indexOf(tag);
		
		if(isin>-1){
			tags.splice(isin,1);
			tags_type.splice(isin,1);
			$("#wit_"+tag).remove();
		}
		return false;

	});

	$(document).delegate(".flat7b_fbar","click",function(event){

		if(!$(this).hasClass("flat_checked")){
			
		$(this).css({"border":"1px solid #00A076","background-color":"#02e2a7"});
		$(this).closest(".check_wrap").find(".move").css({"margin-left":"14px"});
		$(this).addClass("flat_checked");
		$(this).closest(".check_wrap").find(".comment_anon_text").css("color","rgba(33,33,33,.85)");
		$(this).closest(".controlpad").find(".post_anon_val").val("1");
		}else{
		$(this).css({"border":"1px solid #C9C9C9","background-color":"#E8E8E8"});
		$(this).closest(".check_wrap").find(".move").css({"margin-left":"0px"});
		$(this).removeClass("flat_checked");
		$(this).closest(".check_wrap").find(".comment_anon_text").css("color","rgba(153, 153, 153, 0.64)");
		$(this).closest(".controlpad").find(".post_anon_val").val("0");
		}
	});

		var cardtag_flag=0;
		$(document).delegate(".vstt_icon","mouseover",function(){
			if(cardtag_flag==0){
			$(this).closest(".field_fbar").find(".card-tag").show();
			}
		});

		$(document).delegate(".vstt_icon","mouseout",function(){
			$(this).closest(".field_fbar").find(".card-tag").hide();
		});

		$(document).delegate(".visi_functions_option_fbar","mouseover",function(){
			var src=$(this).closest("span").find(".visi_icon").css("background-image");
			srcarr=src.split("_");
			srcarr[srcarr.length-1]="hover.png)";
			//if($.browser.mozilla){srcarr[srcarr.length-1]="hover.png";}
			if(navigator.sayswho.split(" ")[0].toLowerCase()=="firefox"){srcarr[srcarr.length-1]="hover.png";}
			src=srcarr.join("_");
			//alert(src);
			$(this).closest("span").find(".visi_icon").css("background-image",src);
		});

		$(document).delegate(".visi_functions_option_fbar","mouseout",function(){
			var src=$(this).closest("span").find(".visi_icon").css("background-image");
			srcarr=src.split("_");
			srcarr[srcarr.length-1]="normal.png)";
			if(navigator.sayswho.split(" ")[0].toLowerCase()=="firefox"){srcarr[srcarr.length-1]="normal.png";}
			src=srcarr.join("_");
			//alert(src);
			$(this).closest("span").find(".visi_icon").css("background-image",src);
		});
	
		$(document).delegate('.field_fbar',"click", function(){
					if($(this).closest(".posttool-select").hasClass("privacy_canedit")){
					$(this).closest(".posttool-select").find(".visi_functions_box").show();
					cardtag_flag=1;
					$(this).closest(".field_fbar").find(".card-tag").hide();

					$(this).css({"border":"1px solid rgba(60,60,60,0.23)","background-color":"rgba(60,60,60,0.03)"});

					$(this).find(".vstt_wedgeDown").css({"opacity":"1"});
					}
				});

		$(document).click(function(event){

			     	var $target= $(event.target);
			     	var $container= $(".posttool-select");
			     	if(!$container.is($target)&&($container.has($target).length===0)){
			     		$container.find(".visi_functions_box").stop().hide();
			     		cardtag_flag=0;

			     		$container.find(".field_fbar").css({"border":"1px solid rgba(60,60,60,0)","background-color":"transparent"});
						$container.find(".vstt_wedgeDown").css({"opacity":"0"});
			     	}
			     	if($target.hasClass(".visi_functions_option_fbar")){
			     		$container.find(".visi_functions_box").stop().hide();
			     		cardtag_flag=0;
			     		$container.find(".field_fbar").css({"border":"1px solid rgba(60,60,60,0)","background-color":"transparent"});
						$container.find(".vstt_wedgeDown").css({"opacity":"0"});
			     	}
				});

			$(document).delegate(".visi_functions_option_fbar","click",function(){
                //student campus connections faculty
                var ref=$(this).closest(".posttool-select");
                var privacy= "campus";
                if($(this).find(".visi_icon").hasClass("i_campus")){privacy="campus";}
                if($(this).find(".visi_icon").hasClass("i_student")){privacy="students";}
                if($(this).find(".visi_icon").hasClass("i_faculty")){privacy="faculty";}
                if($(this).find(".visi_icon").hasClass("i_connections")){privacy="connections";}


                ref.find(".tag-box").text("Visible to "+privacy);
                ref.closest(".select_wrap").find(".visi_val").val(privacy);
                //alert(ref.closest(".select_wrap").find(".visi_val").val());

                $(this).closest(".visi_functions_box").hide();
                cardtag_flag=0;
                ref.find(".field_fbar").css({"border":"1px solid rgba(60,60,60,0)","background-color":"transparent"});
                ref.find(".vstt_wedgeDown").css({"opacity":"0"});

                var src_2=$(this).closest(".posttool-select").find(".visi_icon").css("background-image");
                var srcarr= src_2.split("_");
                srcarr[srcarr.length-1]="status.png";
                var subarr=srcarr[srcarr.length-2].split("/");
                srcarr[srcarr.length-2]="status/"+privacy;
                var src_2=srcarr.join("_").substring(4);
                if(navigator.sayswho.split(" ")[0].toLowerCase()=="firefox"){src_2=src_2.substring(1);}

                var takeout = src_2.indexOf("visi_status");
                src_2 = src_2.substring(takeout+12, src_2.length);
                var src = "img/privacy_icons/privacy_status/";
                src_2 = src + src_2;
                $(this).closest(".posttool-select").find(".vstt_icon").attr("src",src_2);
             });

				
				// setting target page vars for AJAX calls
				<?php if(isset($target_type) AND isset($target_id)){ ?>

					var target_type = <?php echo json_encode($target_type); ?>;
					var target_id = <?php echo json_encode($target_id); ?>;
					// alert(target_type);

				<?php }
				else{ ?>
					var target_type = null;
					var target_id = null;
				<?php }?>
				// setting target vars closed

				//ajax
				$(document).delegate(".btn-1","click",function(){
					var fbar_type="status";
					var $ref=$(this).closest(".fbar_anchor");
					var post_status=$ref.find(".postTxtarea").val().trim();
					var anon=$ref.find(".post_anon_val").val();
					var privacy= $ref.find(".visi_val").val();
					
					// var target_type = "class";
					// var target_id = "924c83c4-f589-11e3-b732-00259022578e";
					//alert($ref.find(".visi_val").attr(""));
					
					if(post_status==""){
					
					}else{

					if($ref.find(".upload_hack").val()!=''){
					alert("we");
					var formData= new FormData( $ref.find(".upload_hack").closest("form")[0]);
   					formData.append("fbar_type",fbar_type);
   					formData.append("anon",anon);
   					formData.append("post_status",post_status);
   					formData.append("privacy",privacy);
   					formData.append("target_type",target_type);
   					formData.append("target_id",target_id);

   					alert(fbar_type+","+post_status+","+anon+","+privacy);

						$.ajax({
	            			type: "POST",
            				url: "includes/fbarops.php",
            				xhr: function() {  // Custom XMLHttpRequest
            					var myXhr = $.ajaxSettings.xhr();
            					if(myXhr.upload){ // Check if upload property exists
                					myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // For handling the progress of the upload
            						}
           					 return myXhr;
        					},

            				data: formData,
            				dataType: "json",
            				contentType: false,
        					processData: false,
            				success: function(html){
					            <?php if($pg_src != "home.php") { ?>
            					alert(html.pid);
            					var pid= html.pid;
								
								$.ajax({
			            			type: "POST",
		            				url: "latestfeed.php",

		            					data: {latest_feed_id: pid},
			            				
		            				success: function(html){ 
		            					$("#posts").prepend(html);

					            	},
					            	error:function(html){ 
					            		alert(html.statusText);
					            	}
								});
					            <?php } ?>
			            	}
						});

						//reset
						$ref.find(".postTxtarea").val("");
            			$ref.find(".upload_hack").val("");
            			$ref.find(".upload_textprompt").attr("title","");
            			$ref.find(".upload_textprompt").text("");
					}else{

						$.ajax({
	            			type: "POST",
            				url: "includes/fbarops.php",

            					data: {fbar_type: fbar_type, post_status: post_status, anon: anon, privacy:privacy,
	            					target_id:target_id, target_type:target_type},
	            				dataType: "json",
            				success: function(html){ 
            					alert(html.pid);
            					var pid= html.pid;
					            <?php if($pg_src != "home.php") { ?>
								$.ajax({
			            			type: "POST",
		            				url: "latestfeed.php",

		            					data: {latest_feed_id: pid},
			            				
		            				success: function(html){ 
		            					$("#posts").prepend(html);

					            	},
					            	error:function(html){ 
					            		alert(html.statusText);
					            	}
								});
					            <?php } ?>
			            	},
			            	error:function(html){ 
			            		alert(html.statusText);
			            	}
						});
						$ref.find(".postTxtarea").val("");
            			$ref.find(".upload_hack").val("");
            			$ref.find(".upload_textprompt").attr("title","");
            			$ref.find(".upload_textprompt").text("");

					}
					}
				});


			$(document).delegate(".btn-2","click",function(){
				var fbar_type="notes";
				var $ref=$(this).closest(".fbar_anchor");
				var notes_desc=$ref.find(".uploadTxtarea").val().trim();
				var fileexistproof=$ref.find("._uplI").val();
				var privacy= $ref.find(".visi_val").val();

				var fileexistproof2=$(".googleuploadinfoarchive_fbar").val();

				//alert(fileexistproof);

				if((fileexistproof=="")&&(fileexistproof2=="")){

				}else{
					if(fileexistproof!=""){

					var formData= new FormData( $ref.find("._uplI").closest("form")[0]);
					formData.append("fbar_type",fbar_type);
   					formData.append("notes_desc",notes_desc);
   					formData.append("privacy",privacy);
   					formData.append("target_type",target_type);
   					formData.append("target_id",target_id);

   					$.ajax({
	            			type: "POST",
            				url: "includes/fbarops.php",
            				xhr: function() {  // Custom XMLHttpRequest
            					var myXhr = $.ajaxSettings.xhr();
            					if(myXhr.upload){ // Check if upload property exists
                					myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // For handling the progress of the upload
            						}
           					 return myXhr;
        					},

            				data: formData,
            				contentType: false,
        					processData: false,
        					dataType: "json",
            				success: function(html){
					            <?php if($pg_src != "home.php") { ?>
            					alert(html.pid);
            					var pid= html.pid;
								
								$.ajax({
			            			type: "POST",
		            				url: "latestfeed.php",

		            					data: {latest_feed_id: pid},
			            				
		            				success: function(html){ 
		            					$("#posts").prepend(html);

					            	},
					            	error:function(html){ 
					            		alert(html.statusText);
					            	}
								});
					            <?php } ?>
			            	}

						});
   					}else{
   						var fileinfo= $(".googleuploadinfoarchive_fbar").val().trim().split("||");
   						var gdrive_id= fileinfo[0].trim();
   						var gdrive_type= fileinfo[1].trim();
   						var gdrive_url= fileinfo[2].trim();
   						var gdrive_name= fileinfo[3].trim();

   						$.ajax({
	            			type: "POST",
            				url: "includes/fbarops.php",
            				data: {fbar_type: fbar_type, notes_desc:notes_desc, privacy:privacy, gdrive_id:gdrive_id, gdrive_name:gdrive_name,gdrive_url:gdrive_url,gdrive_type:gdrive_type,
	            				target_id:target_id, target_type:target_type},
	            			dataType: "json",

            				success: function(html){
					            <?php if($pg_src != "home.php") { ?>
            					alert(html.pid);
            					var pid= html.pid;
								
								$.ajax({
			            			type: "POST",
		            				url: "latestfeed.php",

		            					data: {latest_feed_id: pid},
			            				
		            				success: function(html){ 
		            					$("#posts").prepend(html);

					            	},
					            	error:function(html){ 
					            		alert(html.statusText);
					            	}
								});
					            <?php } ?>
			            	}
						});
   					}
   					


            					//reset
								$ref.find(".uploadTxtarea").val("");
								$ref.find(".uplName").text("No file chosen");
								$ref.find("._uplI").val("");
				}


			});				


			$(document).delegate(".btn-3","click",function(){
				var fbar_type="question";
				var $ref=$(this).closest(".fbar_anchor");
				var privacy= $ref.find(".visi_val").val();
				var que_title=$ref.find(".questtxt").val().trim();
				var que_desc=$ref.find(".askTxtArea").val().trim();

				/*
				$.each( tags_type, function( key, value ) {
					alert(value);
				});*/
				

				
				$.each( tags, function( key, value ) {
					tags[key]=tags_type[key]+"$$"+value;
				});
				
				/*
				$.each( tags, function( key, value ) {
					alert(value);
				});
				*/
				//tags=['1','2','3'];
				$.each( tags, function( key, value ) {
					alert(value);
				});

				var experts = JSON.stringify(tags);
				var anon=$(this).closest(".controlpad").find(".post_anon_val").val();
				

				var fileexistproof=$ref.find(".upload_hack").val();

				if(que_title==""){

				}else{

				
				if(fileexistproof!=""){
					var formData= new FormData( $ref.find(".upload_hack").closest("form")[0]);
					formData.append("fbar_type",fbar_type);
   					formData.append("que_title",que_title);
   					formData.append("que_desc",que_desc);
   					formData.append("experts",experts);
   					formData.append("anon",anon);
   					formData.append("privacy",privacy);
   					formData.append("target_type",target_type);
   					formData.append("target_id",target_id);


   					$.ajax({
	            			type: "POST",
            				url: "includes/fbarops.php",
            				xhr: function() {  // Custom XMLHttpRequest
            					var myXhr = $.ajaxSettings.xhr();
            					if(myXhr.upload){ // Check if upload property exists
                					myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // For handling the progress of the upload
            						}
           					 return myXhr;
        					},

            				data: formData,
            				contentType: false,
        					processData: false,
        					dataType: "json",
            				success: function(html){
					            <?php if($pg_src != "home.php") { ?>
            					alert(html.pid);
            					var pid= html.pid;
								
								$.ajax({
			            			type: "POST",
		            				url: "latestfeed.php",

		            					data: {latest_feed_id: pid},
			            				
		            				success: function(html){ 
		            					$("#posts").prepend(html);

					            	},
					            	error:function(html){ 
					            		alert(html.statusText);
					            	}
								});
					            <?php } ?>
			            	}
						});

				}else{
					//alert(fbar_type+","+que_title+","+que_desc+","+anon+","+privacy);
					$.ajax({
	            			type: "POST",
            				url: "includes/fbarops.php",
            				data: {fbar_type: fbar_type, que_title:que_title, que_desc:que_desc, anon:anon, privacy:privacy, experts:experts,
	            				target_id:target_id, target_type:target_type},
            				dataType: "json",
            				success: function(html){
					            <?php if($pg_src != "home.php") { ?>
            					alert(html.pid);
            					var pid= html.pid;
								$.ajax({
			            			type: "POST",
		            				url: "latestfeed.php",

		            					data: {latest_feed_id: pid},
			            				
		            				success: function(html){ 
		            					$("#posts").prepend(html);

					            	},
					            	error:function(html){ 
					            		alert(html.statusText);
					            	}
								});
					            <?php } ?>
			            	}
						});
					
				}

								//reset
								while(tags.length > 0) {
    								tags.pop();
								}
								while(tags_type.length > 0) {
    								tags_type.pop();
								}
								$(".who-is-tagged").remove();
								$ref.find(".add_who").val("");
								$ref.find(".askTxtArea").val("");
								$ref.find(".topfbar").val("");
								$ref.find(".upload_hack").val("");
								$ref.find(".upload_textprompt").text("");
								$ref.find(".upload_textprompt").attr("title","");

				}
			});


			var curkeypos=$(".tag-col").first();
			$(document).delegate(".add_who","keydown",function(e){
				//alert(curkeypos.attr("id"));
				//down
				if(e.which=='40'){
					curkeypos.next().addClass("opt_jshover");
				}

				//up
				if(e.which=='38'){

				}
			});



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

				<div id = "fbar" class = "fb">
					<div class='fbar-head'>
						<div class = "post fani fani-hover">
							<div class = "fbtn fbtn-post">
								<?php
								$pg_src = substr(strrchr($_SERVER['SCRIPT_NAME'], "/"), 1);
								if($pg_src == "home.php" || $pg_src=="profile.php")	echo "Post Status";
								else echo "Start Discussion";
								?>
							</div>
						</div>
						<div class = "share fani fani-hover">
							<div class = "fbtn fbtn-upload">
								Share Notes
							</div>							
						</div>
						<div class = "find fani fani-hover">
							<div class = "fbtn fbtn-ask">
								Ask Question
							</div>							
						</div>
					</div>

					<div class = "post-sec">
						<div class = "wedge1a">
						</div>

						<div class = "wedge2a">
						</div>

						<div class = "wedge3a">
						</div>

						<div class = "post_state fbar_anchor">						
							<div class ="textwrap">
								<textarea name = "message" class = "postTxtarea autogrowth_textarea"placeholder = "What have you read lately?" ></textarea>
							</div>	
							<div class = "btmfbar controlpad">
								<div class='fbar_errorprompt'></div>
								<div class = "lfloat-mods">
									<div class = "lfloat-attach">
										<a class = "attach-mod" href = "#" title = "Attach a file to your post">
											<span class = "attach-icon">
											</span>
										</a>
									</div>
									<div class="upload_textprompt"></div>

                <form class="attach_form">
                  <input type="file" name='file' class="upload_hack">
                  <button class="upload_button">Upload</button>
              </form>

								</div>

									<div class = "lfloat-anon">
										<div class='check_wrap fbarcheck_wrap' id="post_status_check">
											<input type='checkbox' id='flat_0' class='flat7c'/>
												<label for='flat7' class='flat7b_fbar'>
									    			<span class='move'></span>
												</label>
												<span class = 'comment_anon_text'>Post Anonymously</span>
											<input type='hidden' value='0' class='post_anon_val'>
										</div>
										<div class = "post-btn btn-1">Post</div>
										<div class='select_wrap'>
											<input type='hidden' class='visi_val' value='campus'>
											<div class='posttool-select privacy_canedit'>
								
												<span class='field_fbar'>
													<img class='vstt_icon' src='img/privacy_icons/privacy_status/campus_status.png'>
                                                    <div class='vstt_wedgeDown'></div>
                                                    <div class = 'card-tag'>
                                                        <div class = 'tag-wedge'></div>
                                                        <div class = 'tag-box'>
                                                            <span>Visible to campus</span>
                                                        </div>
                                                    </div>
												</span>
												<div class = 'visi_functions_box'>
													<span>
														<div class = 'visi_functions_option_fbar'><div class='visi_icon i_campus'></div>Campus</div>
													<hr class = 'post_options_hr'>
													</span>
													<span>
													<div class = 'visi_functions_option_fbar'><div class='visi_icon i_student'></div>Only Students</div>
													<hr class = 'post_options_hr'>
													</span>
													<span>
														<div class = 'visi_functions_option_fbar'><div class='visi_icon i_faculty'></div>Only Faculty</div>
													<hr class = 'post_options_hr'>
													</span>
													<span>
													<div class = 'visi_functions_option_fbar'><div class='visi_icon i_connections'></div>My Connections</div>
													</span>
												</div>
											</div>
										</div>

									</div>
							</div>	
						</div>
						<div class = "upload_state fbar_anchor">						
							<div class ="textwrap">
								<textarea name = "file_desc" class = "uploadTxtarea autogrowth_textarea" placeholder = "Say something about this file..." ></textarea>
							</div>	
							<div class = "uploadMode">
								<div class = "localUpload">
									<div class = "upl_wrap">
										<form>
										<div class = "upl_head">
											From Your Computer
										</div>
										<div class = "upl_btn">
											<a class = "upl_anc">
												<span class = "uplbtnText">Choose File</span>
												<div class = "_upl">
													<input type = "file" class = "_uplI" title = "Choose a file to upload" name = "file">
												</div>
											</a>
										</div>
										<div class = "uplName">
											No file chosen
										</div>
									</form>
									</div>
								</div>
								<div class = "driveUpload">
									<input type='hidden' val='' class='googleuploadinfoarchive_fbar'>
									<div class = "upl_wrap">
										<span class = "iconText">
											<img class = "icon" src = "img/drive_icon.png" width = "16" height = "16">
											<div class = "upl_head">
												From Your Drive
											</div>	
											<div class = "upl_btn2">
												<a class = "upl_anc" id='pick'>
													<span class = "uplbtnText">Choose File</span>
												</a>
											</div>
											<div class = "uplName drive_link" title=''>
												No file chosen
											</div>															
										</span>	
									</div>							
								</div>
							</div>
							<div class = "btmfbar2 controlpad">
								<div class='fbar_errorprompt'></div>
								<div class="search-select">
									
								</div>
								<div class = "lfloat-anon">
										<div class = "post-btn btn-2">Post</div>
										<div class='select_wrap'>
											<input type='hidden' class='visi_val' value='campus'/>
											<div class='posttool-select privacy_canedit'>
								
												<span class='field_fbar'>
													<img class='vstt_icon' src='img/privacy_icons/privacy_status/campus_status.png'>
												<div class='vstt_wedgeDown'></div>
												<div class = 'card-tag'>
													<div class = 'tag-wedge'></div>
													<div class = 'tag-box'>
														<span>Visible to campus</span>
													</div>									
												</div>
												</span>
												<div class = 'visi_functions_box'>
													<span>
														<div class = 'visi_functions_option_fbar'><div class='visi_icon i_campus'></div>Campus</div>
													<hr class = 'post_options_hr'>
													</span>
													<span>
													<div class = 'visi_functions_option_fbar'><div class='visi_icon i_student'></div>Only Students</div>
													<hr class = 'post_options_hr'>
													</span>
													<span>
														<div class = 'visi_functions_option_fbar'><div class='visi_icon i_faculty'></div>Only Faculty</div>
													<hr class = 'post_options_hr'>
													</span>
													<span>
													<div class = 'visi_functions_option_fbar'><div class='visi_icon i_connections'></div>My Connections</div>
													</span>
												</div>
											</div>
										</div>

								</div>
							</div>	
						</div>	
						<div class = "ask_state fbar_anchor">
							<div class = "topfbar-wrap">
								<div class = "quest-wrap">
									<input placeholder = "What's your question? Be specific" class = "topfbar questtxt"></input>
								</div>
							</div>

							<div class ="textwrap2">
								<textarea name = "q_desc" class = "askTxtArea autogrowth_textarea"placeholder = "Add more details about this question... (Optional)" ></textarea>
							</div>

                            <div class="multiple_choice">
                                <div class="question_choice_line multiple_line">
                                    <div class="fixed_choice_prefix">
                                        <div class="letter_choice"><span>A</span></div>
                                        <div class="add_choice"><span>+</span></div>
                                    </div>
                                    <input class="multiple_choice_answer" placeholder="Add choice A...">
                                    <div class="answer_check">
                                        <input id="check_A" type="radio" value="false">
                                        <label></label>
                                        <span>Correct Answer</span>
                                    </div>
                                </div>
                                <div class="question_choice_line multiple_line">
                                    <div class="fixed_choice_prefix">
                                        <div class="letter_choice"><span>B</span></div>
                                        <div class="add_choice"><span>+</span></div>
                                    </div>
                                    <input class="multiple_choice_answer" placeholder="Add choice B...">
                                    <div class="answer_check">
                                        <input id="check_B" type="radio" value="false">
                                        <label></label>
                                        <span>Correct Answer</span>
                                    </div>
                                </div>
                                <div class="question_choice_line multiple_line">
                                    <div class="fixed_choice_prefix">
                                        <div class="letter_choice"><span>C</span></div>
                                        <div class="add_choice"><span>+</span></div>
                                    </div>
                                    <input class="multiple_choice_answer" placeholder="Add choice C...(optional)">
                                    <div class="answer_check">
                                        <input id="check_C" type="radio" value="false">
                                        <label></label>
                                        <span>Correct Answer</span>
                                    </div>
                                </div>
                                <div class="question_choice_line multiple_line">
                                    <div class="fixed_choice_prefix">
                                        <div class="letter_choice"><span>D</span></div>
                                        <div class="add_choice"><span>+</span></div>
                                    </div>
                                    <input class="multiple_choice_answer" placeholder="Add choice D...(optional)">
                                    <div class="answer_check">
                                        <input id="check_D" type="radio" value="false">
                                        <label></label>
                                        <span>Correct Answer</span>
                                    </div>
                                </div>
                            </div>

                            <div class="true_false">
                                <div class="question_choice_line tf_line">
                                    <span>True</span>
                                    <div class="answer_check">
                                        <input id="check_true" type="radio" value="true">
                                        <label></label>
                                        <span>Correct Answer</span>
                                    </div>
                                </div>
                                <div class="question_choice_line tf_line">
                                    <span>False</span>
                                    <div class="answer_check">
                                        <input id="check_false" type="radio" value="false">
                                        <label></label>
                                        <span>Correct Answer</span>
                                    </div>
                                </div>
                            </div>

							<div class = "btmfbar3 controlpad">
								<div class='fbar_errorprompt'></div>
								<div class = "lfloat-mods">
									<div class = "lfloat-attach">
										<a class = "attach-mod" href = "#" title = "Attach a file to your post">
											<span class = "attach-icon">
											</span>
										</a>
									</div>
									<div class="upload_textprompt"></div>
			  <form class="attach_form">
                  <input type="file" name='file' class="upload_hack">
                  <button class="upload_button">Upload</button>
              </form>
									
								</div>
								<div class = "lfloat-anon">
                                    <div class='check_wrap fbarcheck_wrap' id="live_answers_check">
                                        <input type='checkbox' id='flat_1' class='flat7c'/>
                                        <label for='flat7' class='flat7b_fbar'>
                                            <span class='move'></span>
                                        </label>
                                        <span class = 'comment_anon_text'>Live Answers</span>
                                        <input type='hidden' value='0' class='post_anon_val'>
                                    </div>
                                    <div class='check_wrap fbarcheck_wrap'>
                                        <input type='checkbox' id='flat_0' class='flat7c'/>
                                            <label for='flat7' class='flat7b_fbar'>
                                                <span class='move'></span>
                                            </label>
                                            <span class = 'comment_anon_text'>Anonymous</span>
                                            <input type='hidden' value='0' class='post_anon_val'>
                                    </div>
                                    <div class="question_type_wrapper">
                                        <div class="question_type multiple_type">
                                            <span>Multiple Choice</span>
                                        </div>
                                        <div class="question_type truth_type">
                                            <span>True or False</span>
                                        </div>
                                    </div>
                                    <div class = "post-btn btn-3">Post</div>

                                    <div class='select_wrap'>
                                        <input type='hidden' class='visi_val' value='campus'/>
                                        <div class='posttool-select privacy_canedit' id="question_privacy">

                                            <span class='field_fbar'>
                                                <img class='vstt_icon' src='img/privacy_icons/privacy_status/campus_status.png'>
                                            <div class='vstt_wedgeDown'></div>
                                            <div class = 'card-tag'>
                                                <div class = 'tag-wedge'></div>
                                                <div class = 'tag-box'>
                                                    <span>Visible to campus</span>
                                                </div>
                                            </div>
                                            </span>
                                            <div class = 'visi_functions_box'>
                                                <span>
                                                    <div class = 'visi_functions_option_fbar'><div class='visi_icon i_campus'></div>Campus</div>
                                                <hr class = 'post_options_hr'>
                                                </span>
                                                <span>
                                                <div class = 'visi_functions_option_fbar'><div class='visi_icon i_student'></div>Only Students</div>
                                                <hr class = 'post_options_hr'>
                                                </span>
                                                <span>
                                                    <div class = 'visi_functions_option_fbar'><div class='visi_icon i_faculty'></div>Only Faculty</div>
                                                <hr class = 'post_options_hr'>
                                                </span>
                                                <span>
                                                <div class = 'visi_functions_option_fbar'><div class='visi_icon i_connections'></div>My Connections</div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

								</div>
							</div>	
						</div>									
					</div>
					</div>

</body>
</html>

