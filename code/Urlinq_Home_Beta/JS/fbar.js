$(document).ready(function() {
				$(".wedge1a").hide();
                $(".wedge1b").hide();
				$(".wedge2a").hide();
                $(".wedge2b").hide();
				$(".wedge3a").hide();
                $(".wedge3b").hide();
                $(".ask_state").hide();
                $('.upload_state').hide();
                $('.postTxtarea').hide();
                $('.btmfbar').hide();   
                $('.uploadMode').hide();     

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
                	$('.fb').css('height','193px');
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



                 $('.select').on('click','li',function(){
					  $('#open').click();
					  var $t = $(this),
					      $f = $('.field')
					      text = $t.text(),
					      icon = $t.find('i').attr('class');
					  $f.find('label').text(text);
					  $f.find('i').attr('class',icon)
					});
					$('.field').click(function(e){
					  e.preventDefault();
					  $('#open').click();
					});

					$('.anon-checker').click(function(){
						$('.anon-setting').text("Posted by Anonymous");
						$('.anon-checker').click(function(){
							$('.anon-setting').text("Posted by Jacob Lazarus");
						});
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
				});



     });   
