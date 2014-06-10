$(document).ready(function() {



	$(document).delegate(".post_like","click",function(){
		
			$(this).addClass("post_liked")
			$(this).find(".post_like_icon").css({"background":"center center no-repeat url(src/liked-button.png)","background-size":"cover"});
			$(this).find(".like_number").css("color","white");
	});

	$(document).delegate(".post_functions_showr","click",function(){
		if($(this).closest(".post_functions").hasClass("functions_active")){
			$(this).closest(".post_functions").find(".post_functions_box").stop().fadeOut();
			$(this).closest(".post_functions").removeClass("functions_active");
		}else{
		$(this).closest(".post_functions").find(".post_functions_box").show();
		$(this).closest(".post_functions").addClass("functions_active");
		}
	});

	$(document).click(function(event){
     	var $target= $(event.target);

     	//click outside hide event
     	var $container= $(".post_functions_box");
     	var $container2= $(".post_functions_showr");

     	if((!$container.is($target)&&($container.has($target).length===0))&&(!$container2.is($target)&&($container2.has($target).length===0))){
     		$container.stop().fadeOut(100);
     		$container.closest(".post_functions").removeClass('functions_active');
     	}

	});

	$(document).delegate(".form-control","focus",function(){
		$(this).css("height","70px");
		$(this).css("border-radius","0px 6px 6px 6px");
		$(this).closest(".reply_tawrapper").closest(".commentform").css("height","87px");
	});
});