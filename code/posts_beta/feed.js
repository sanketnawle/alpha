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
		$(this).css({"height":"53px","width":"93.82%","margin-left":"6px","margin-top":"9px","border-radius":"4px"});
		$(this).closest(".reply_tawrapper").closest(".commentform").css("height","96px");
		$(this).closest(".commentform").find(".reply_user_icon").hide();
		$(this).closest(".commentform").find(".reply_functions").show();
		$(this).closest(".reply_tawrapper").find(".reply_attach").css({"margin-top":"-31px","padding-right":"82px"});
	});

	$(document).delegate(".post_comment_btn","click",function(){
		$(this).closest(".posts").find(".form-control").focus();
	});

	$(document).delegate(".flat7b","click",function(event){
		//alert("a");
		//event.preventDefault();
		//alert($(this).attr("id"));
		if(!$(this).hasClass("flat_checked")){
		$(this).css({"border":"1px solid #00A076","background-color":"#02e2a7"});
		$(this).closest(".check_wrap").find(".move").css({"margin-left":"19px"});
		$(this).addClass("flat_checked");
		$(this).closest(".check_wrap").find(".comment_anon_text").css("color","rgba(33,33,33,.85)");
		}else{
		$(this).css({"border":"1px solid #C9C9C9","background-color":"#f5f5f5"});
		$(this).closest(".check_wrap").find(".move").css({"margin-left":"0px"});
		$(this).removeClass("flat_checked");
		$(this).closest(".check_wrap").find(".comment_anon_text").css("color","rgba(153, 153, 153, 0.64)");

		}
	});



});