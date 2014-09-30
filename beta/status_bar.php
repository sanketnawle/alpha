<!DOCTYPE html> 
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="css/fbar.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
</script>
<link href='https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script> 
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


                $('.post').click(function(){
                	$('.fb').css('height','170px');
                	$('.postTxtarea').show();
                	$('.postTxtarea').focus();
                	$('.post').css('cursor','default');

                	$('.post').removeClass('fani');
                	$('.post-sec').show();
                	$('.share').addClass('fani');
                	$('.find').addClass('fani');
                	$('.share').css('cursor','pointer');
                	$('.find').css('cursor','pointer');
                	$('.fbtn-post ').css('color','#333');
                	$('.fbtn-post ').css('color','#333');
                	$('.fbtn-ask').css('color','#666');
                	$('.fbtn-upload ').css('color','#666');                	
                	$(".wedge1a").show();
                	$(".wedge1b").show();
	 				$(".wedge2a").hide();
	                $(".wedge2b").hide();
					$(".wedge3a").hide();
	                $(".wedge3b").hide(); 
	                $('.btmfbar2').hide();
	                 $('.btmfbar').show(); 
	                 $(".ask_state").hide();
	                 $('.uploadTxtarea').hide(); 
	                 $('.uploadMode').hide();

                 });

                $('.share').click(function(){
                	$('.fb').css('height','233px');
                	$('.share').css('cursor','default');
                	$('.find').css('cursor','pointer');

                	$('.post').css('cursor','pointer');
                	$('.share').removeClass('fani');
                	$('.post-sec').show();
                	$('.find').addClass('fani');
                	$('.post').addClass('fani');
                	$('.fbtn-upload ').css('color','#333');
                	$('.fbtn-post ').css('color','#666');
                	$('.fbtn-ask ').css('color','#666');                
                	$(".wedge2a").show();
                	$(".wedge2b").show();	
	 				$(".wedge1a").hide();
	                $(".wedge1b").hide();
					$(".wedge3a").hide();
					$(".ask_state").hide();
	                $(".wedge3b").hide();    
	                $('.postTxtarea').hide();           
	                 $('.btmfbar').hide();	
	                 $('.upload_state').show();
	                 $('.btmfbar2').show();
	                 $('.uploadTxtarea').show(); 
	                 $('.uploadTxtarea').focus();
	                 $('.uploadMode').show();
                 });

                $('.find').click(function(){
                	$('.fb').css('height','226px');
                	$('.find').css('cursor','default');
                	$('.find').removeClass('fani');
                	$('.post-sec').show();
                	$('.share').addClass('fani');
                	$('.post').addClass('fani');
                 	$('.share').css('cursor','pointer');
                	$('.post').css('cursor','pointer');
                	$('.fbtn-ask ').css('color','#333');
                	$('.fbtn-upload ').css('color','#666');
                	$('.fbtn-post ').css('color','#666');
                 	$(".wedge3a").show();
                	$(".wedge3b").show();               
	 				$(".wedge1a").hide();
	 				
	                $(".wedge1b").hide();                
	 				$(".wedge2a").hide();
	                $(".wedge2b").hide();	
	                $('.postTxtarea').hide();
	                $('.btmfbar').hide(); 
	                $('.uploadTxtarea').hide(); 
	                $('.uploadMode').hide();      
	                $('.btmfbar2').hide();         	                	
	                $(".ask_state").show();
	                $(".topfbar").focus();
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
					      $f = $(this).closest(".search-select").find('.field')
					      text = $t.text(),
					      icon = $t.find('i').attr('class');
					  $f.find('label').text(text);
					  $f.find('i').attr('class',icon)
					});
					$('.field').click(function(e){
					  e.preventDefault();
					  $('#open').click();
					});

					

				$(document).delegate(".field","click",function(){
					$(".select").stop().fadeIn(200);

					var cur= $(this).closest(".field").find("i").attr("class");
					
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
    $("textarea").mousemove(function(e) {
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
            			url: "../kk/newinfi/includes/fbarexp.php",
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

			$(".midfbar-exp").prepend("<div class='who-is-tagged' id='wit_"+tag+"'><div class='tag-name'>"+tagname+"</div><div class='tag-close'></div></div>");
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

	$(document).delegate(".flat7b","click",function(event){

		if(!$(this).hasClass("flat_checked")){
		$(this).css({"border":"1px solid #00A076","background-color":"#02e2a7"});
		$(this).closest(".check_wrap").find(".move").css({"margin-left":"19px"});
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
			$(this).closest(".field").find(".card-tag").show();
			}
		});

		$(document).delegate(".vstt_icon","mouseout",function(){
			$(this).closest(".field").find(".card-tag").hide();
		});

		$(document).delegate(".visi_functions_option","mouseover",function(){
			var src=$(this).closest("span").find(".visi_icon").css("background-image");
			srcarr=src.split("_");
			srcarr[srcarr.length-1]="hover.png)";
			//if($.browser.mozilla){srcarr[srcarr.length-1]="hover.png";}
			if(navigator.sayswho.split(" ")[0].toLowerCase()=="firefox"){srcarr[srcarr.length-1]="hover.png";}
			src=srcarr.join("_");
			//alert(src);
			$(this).closest("span").find(".visi_icon").css("background-image",src);
		});

		$(document).delegate(".visi_functions_option","mouseout",function(){
			var src=$(this).closest("span").find(".visi_icon").css("background-image");
			srcarr=src.split("_");
			srcarr[srcarr.length-1]="normal.png)";
			if(navigator.sayswho.split(" ")[0].toLowerCase()=="firefox"){srcarr[srcarr.length-1]="normal.png";}
			src=srcarr.join("_");
			//alert(src);
			$(this).closest("span").find(".visi_icon").css("background-image",src);
		});
	
		$(document).delegate('.field',"click", function(){
					if($(this).closest(".posttool-select").hasClass("privacy_canedit")){
					$(this).closest(".posttool-select").find(".visi_functions_box").show();
					cardtag_flag=1;
					$(this).closest(".field").find(".card-tag").hide();

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

			     		$container.find(".field").css({"border":"1px solid rgba(60,60,60,0)","background-color":"transparent"});
						$container.find(".vstt_wedgeDown").css({"opacity":"0"});
			     	}
			     	if($target.hasClass(".visi_functions_option")){
			     		$container.find(".visi_functions_box").stop().hide();
			     		cardtag_flag=0;
			     		$container.find(".field").css({"border":"1px solid rgba(60,60,60,0)","background-color":"transparent"});
						$container.find(".vstt_wedgeDown").css({"opacity":"0"});
			     	}
				});

			$(document).delegate(".visi_functions_option","click",function(){
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
			     	ref.find(".field").css({"border":"1px solid rgba(60,60,60,0)","background-color":"transparent"});
					ref.find(".vstt_wedgeDown").css({"opacity":"0"});

					var src_2=$(this).closest(".posttool-select").find(".visi_icon").css("background-image");
					var srcarr= src_2.split("_");
					srcarr[srcarr.length-1]="status.png";
					var subarr=srcarr[srcarr.length-2].split("/");
					srcarr[srcarr.length-2]="status/"+privacy;
					var src_2=srcarr.join("_").substring(4);
					if(navigator.sayswho.split(" ")[0].toLowerCase()=="firefox"){src_2=src_2.substring(1);}
					$(this).closest(".posttool-select").find(".vstt_icon").attr("src",src_2);
			     });


				//ajax
				$(document).delegate(".btn-1","click",function(){
					var fbar_type="status";
					var $ref=$(this).closest(".fbar_anchor");
					var post_status=$ref.find(".postTxtarea").val().trim();
					var anon=$ref.find(".post_anon_val").val();
					var privacy= $ref.find(".visi_val").val();
					//alert($ref.find(".visi_val").attr(""));
					
					if(post_status==""){

					}else{

					if($ref.find(".upload_hack").val()!=''){

					var formData= new FormData( $ref.find(".upload_hack").closest("form")[0]);
   					formData.append("fbar_type",fbar_type);
   					formData.append("anon",anon);
   					formData.append("post_status",post_status);
   					formData.append("privacy",privacy);
   					
   					//alert(fbar_type+","+post_status+","+anon+","+privacy);

						$.ajax({
	            			type: "POST",
            				url: "../kk/newinfi2/includes/fbarops.php",
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
            				success: function(html){ 

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
            				url: "../kk/newinfi2/includes/fbarops.php",
            				data: {fbar_type: fbar_type, post_status: post_status, anon: anon, privacy:privacy},
            				success: function(html){ 
            					//alert(privacy);
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

				var fileexistproof2=$ref.find(".drive_link").attr("title");

				//alert(fileexistproof);

				if((fileexistproof=="")&&(fileexistproof2=="")){

				}else{
					if(fileexistproof!=""){

					var formData= new FormData( $ref.find("._uplI").closest("form")[0]);
					formData.append("fbar_type",fbar_type);
   					formData.append("notes_desc",notes_desc);
   					formData.append("privacy",privacy);

   					$.ajax({
	            			type: "POST",
            				url: "../kk/newinfi2/includes/fbarops.php",
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
            				success: function(html){ 
            					alert(fbar_type+","+notes_desc+","+fileexistproof+","+privacy);
            					alert(html);

			            	}
						});
   					}else{
   						notes_desc=notes_desc+fileexistproof2;
   						$.ajax({
	            			type: "POST",
            				url: "../kk/newinfi2/includes/fbarops.php",
            				data: {fbar_type: fbar_type, notes_desc:notes_desc, privacy:privacy},
            				success: function(html){ 
            					alert(html);
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


   					$.ajax({
	            			type: "POST",
            				url: "../kk/newinfi2/includes/fbarops.php",
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
            				success: function(html){ 
            					alert(html);
			            	}
						});

				}else{
					//alert(fbar_type+","+que_title+","+que_desc+","+anon+","+privacy);
					$.ajax({
	            			type: "POST",
            				url: "../kk/newinfi2/includes/fbarops.php",
            				data: {fbar_type: fbar_type, que_title:que_title, que_desc:que_desc, anon:anon, privacy:privacy, experts:experts},
            				error: function(html){ 
            					alert(html);

			            	},
			            	success: function(html){ 
            					alert(html);
            					
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
								Post Status 
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
								<textarea name = "message" class = "postTxtarea"placeholder = "What have you read lately?" ></textarea>
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
										<div class='check_wrap'>
											<input type='checkbox' id='flat_0' class='flat7c'/>
												<label for='flat7' class='flat7b'>
									    			<span class='move'></span>
												</label>
												<span class = 'comment_anon_text'>Post Anonymously</span>
											<input type='hidden' value='0' class='post_anon_val'>
										</div>

										<div class='select_wrap'>
											<input type='hidden' class='visi_val' value='campus'>
											<div class='posttool-select privacy_canedit'>
								
												<span class='field'>
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
														<div class = 'visi_functions_option '><div class='visi_icon i_campus' style='background-image:url(img/privacy_icons/privacy_dropdown/campus_normal.png);'></div>Campus</div>
													<hr class = 'post_options_hr'>
													</span>
													<span>
													<div class = 'visi_functions_option '><div class='visi_icon i_student' style='background-image:url(img/privacy_icons/privacy_dropdown/class_normal.png);'></div>Only Students</div>
													<hr class = 'post_options_hr'>
													</span>
													<span>
														<div class = 'visi_functions_option '><div class='visi_icon i_faculty' style='background-image:url(img/privacy_icons/privacy_dropdown/faculty_normal.png);'></div>Only Faculty</div>
													<hr class = 'post_options_hr'>
													</span>
													<span>
													<div class = 'visi_functions_option '><div class='visi_icon i_connections' style='background-image:url(img/privacy_icons/privacy_dropdown/connections_normal.png);'></div>My Connections</div>
													</span>
												</div>
											</div>
										</div>

									</div>

								
								<div class = "post-btn btn-1">
									Post
								</div>
							</div>	
						</div>
						<div class = "upload_state fbar_anchor">						
							<div class ="textwrap">
								<textarea name = "file_desc" class = "uploadTxtarea"placeholder = "Say something about this file..." ></textarea>
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
									<div class = "upl_wrap">
										<span class = "iconText">
											<img class = "icon" src = "img/drive_icon.png" width = "16" height = "16">
											<div class = "upl_head">
												From Your Drive
											</div>	
											<div class = "upl_btn2">
												<a class = "upl_anc">
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

										<div class='select_wrap'>
											<input type='hidden' class='visi_val' value='campus'/>
											<div class='posttool-select privacy_canedit'>
								
												<span class='field'>
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
														<div class = 'visi_functions_option '><div class='visi_icon i_campus' style='background-image:url(img/privacy_icons/privacy_dropdown/campus_normal.png);'></div>Campus</div>
													<hr class = 'post_options_hr'>
													</span>
													<span>
													<div class = 'visi_functions_option '><div class='visi_icon i_student' style='background-image:url(img/privacy_icons/privacy_dropdown/class_normal.png);'></div>Only Students</div>
													<hr class = 'post_options_hr'>
													</span>
													<span>
														<div class = 'visi_functions_option '><div class='visi_icon i_faculty' style='background-image:url(img/privacy_icons/privacy_dropdown/faculty_normal.png);'></div>Only Faculty</div>
													<hr class = 'post_options_hr'>
													</span>
													<span>
													<div class = 'visi_functions_option '><div class='visi_icon i_connections' style='background-image:url(img/privacy_icons/privacy_dropdown/connections_normal.png);'></div>My Connections</div>
													</span>
												</div>
											</div>
										</div>

								</div>

								<div class = "post-btn btn-2">
									Post 
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
								<textarea name = "q_desc" class = "askTxtArea"placeholder = "Add more details about this question... (Optional)" ></textarea>
							</div>	
							<div class = "midfbar-wrap">
								<div class = "midfbar-wrap2">
									<div class = "who-wrap">
										<div class = "who-dyn"><div class = "who-icon"></div></div>
										<div class = "midfbar-exp">
											
											<input placeholder = "+ Ask experts" class = "add_who"></input>
										</div>
										

										<div class="tag-option">

											<div class="tag-section tagsec-r">
												<?php include "../kk/newinfi2/includes/fbarexp.php";?>
											</div>
										</div>

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
										<div class='check_wrap'>
											<input type='checkbox' id='flat_0' class='flat7c'/>
												<label for='flat7' class='flat7b'>
									    			<span class='move'></span>
												</label>
												<span class = 'comment_anon_text'>Post Anonymously</span>
												<input type='hidden' value='0' class='post_anon_val'>
										</div>


										<div class='select_wrap'>
											<input type='hidden' class='visi_val' value='campus'/>
											<div class='posttool-select privacy_canedit'>
								
												<span class='field'>
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
														<div class = 'visi_functions_option '><div class='visi_icon i_campus' style='background-image:url(img/privacy_icons/privacy_dropdown/campus_normal.png);'></div>Campus</div>
													<hr class = 'post_options_hr'>
													</span>
													<span>
													<div class = 'visi_functions_option '><div class='visi_icon i_student' style='background-image:url(img/privacy_icons/privacy_dropdown/class_normal.png);'></div>Only Students</div>
													<hr class = 'post_options_hr'>
													</span>
													<span>
														<div class = 'visi_functions_option '><div class='visi_icon i_faculty' style='background-image:url(img/privacy_icons/privacy_dropdown/faculty_normal.png);'></div>Only Faculty</div>
													<hr class = 'post_options_hr'>
													</span>
													<span>
													<div class = 'visi_functions_option '><div class='visi_icon i_connections' style='background-image:url(img/privacy_icons/privacy_dropdown/connections_normal.png);'></div>My Connections</div>
													</span>
												</div>
											</div>
										</div>

								</div>

								<div class = "post-btn btn-3">
									Post 
								</div>
							</div>	
						</div>									
					</div>
					</div>

</body>
</html>

