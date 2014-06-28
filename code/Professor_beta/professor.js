$(document).ready(function() {
	$(document).delegate(".showcase-container","mouseover",function(){
		$(this).find(".showcase-link").stop().animate({opacity: "1",marginTop:"35px"},0);
	});
	$(document).delegate(".showcase-container","mouseout",function(){
		$(this).find(".showcase-link").stop().animate({opacity: "0",marginTop:"95px"},0);
	});

	$(document).on("pageload",function(){
		$(".no-showcase").hide();
		$(".no-showcase").fadeIn(900);
	});

	$(document).delegate(".link","click",function(){
		
			$(this).text("Following")
			$(this).removeClass("link");
			$(this).addClass("pre-linked");
		
	});

	var cl_cache=["rgba(165, 21, 221, 0.5)","rgba(14, 207, 161, 0.98)","rgba(253, 112, 45, 0.74)","rgba(28, 109, 230, 0.8)"];
	$(document).delegate(".tab-inactive","click",function(){
			$(".tab-active").addClass("tab-inactive");
			$(".tab-active").removeClass("tab-active");
			//alert("aa");
			$(this).removeClass("tab-inactive");
			$(this).addClass("tab-active");

			var activeTab = $(this);
			var activeTabposition = activeTab.position();
			var activeTabLeft = activeTabposition.left;
			var activeTabNew = activeTabLeft -27;
			//var activeColor = activeTab.
			$(".tab-indicator").css("margin-left",activeTabNew);

			//var cl=$(".tab-active").css("color");
			//alert(cl);
			var index=0;
			if($(this).hasClass("tab-1")){index=0;}
			if($(this).hasClass("tab-2")){index=1;}
			if($(this).hasClass("tab-3")){index=2;}
			if($(this).hasClass("tab-4")){index=3;}
			//$(".tab-indicator").css("background-color",cl_cache[index]);
			$(".caret-transform").css("border-bottom-color",cl_cache[index]);
			//alert(cl);
			//$(".caret-transform").css("border-bo",activeTabNew);
	});	

		$(document).delegate(".professor-tab","mouseover",function(){
			if($(this).hasClass("tab-1")){index=0;}
			if($(this).hasClass("tab-2")){index=1;}
			if($(this).hasClass("tab-3")){index=2;}
			if($(this).hasClass("tab-4")){index=3;}
			$(this).css("color",cl_cache[index]);
		});

		$(document).delegate(".professor-tab","mouseout",function(){
			
			$(this).css("color","rgba(127, 127, 127, 0.4)");
			$(this).find("tab-count").css("color","rgba(127, 127, 127, 0.4)");
		});

	$(document).delegate(".pre-linked","mouseout",function(){
			$(this).text("Following");
			$(this).removeClass("pre-linked");
			$(this).addClass("linked");		
	});

	$(document).delegate(".linked","mouseover",function(){
			$(this).text("Unfollow");
	});

	$(document).delegate(".linked","mouseout",function(){
			$(this).text("Following");
	});

	$(document).delegate(".linked","click",function(){
			$(this).text("Follow")
			$(this).removeClass("linked");
			$(this).addClass("link");
	});		

	$(document).delegate(".professor-tab","click",function(){
		if($(this).hasClass("tab-2")){
			$(".user-tab-following-content").hide();
			$(".user-tab-followers-content").hide();
			$(".user-tab-followers-content").animate({opacity:"0"},200);
			$(".user-tab-following-content").animate({opacity:"0"},200);
			$(".user-tab-dicussions-content").animate({opacity:"0"},200);
			$(".user-tab-discussions-content").hide();
			$(".user-tab-groups-content").show();
			$(".user-tab-groups-content").animate({opacity:"1"},200);
		}
		if($(this).hasClass("tab-1")){
			$(".user-tab-following-content").hide();
			$(".user-tab-followers-content").hide();
			$(".user-tab-followers-content").animate({opacity:"0"},200);
			$(".user-tab-following-content").animate({opacity:"0"},200);
			$(".user-tab-groups-content").hide();
			$(".user-tab-groups-content").animate({opacity:"0"},200);
			$(".user-tab-discussions-content").show();
			$(".user-tab-dicussions-content").animate({opacity:"1"},200);
		}
		if($(this).hasClass("tab-3")){
			$(".user-tab-groups-content").hide();
			$(".user-tab-followers-content").hide();
			$(".user-tab-followers-content").animate({opacity:"0"},200);
			$(".user-tab-groups-content").animate({opacity:"0"},200);
			$(".user-tab-discussions-content").hide();
			$(".user-tab-dicussions-content").animate({opacity:"0"},200);
			$(".user-tab-following-content").show();
			$(".user-tab-following-content").animate({opacity:"1"},200);			
		}
		if($(this).hasClass("tab-4")){
			$(".user-tab-groups-content").hide();
			$(".user-tab-groups-content").animate({opacity:"0"},200);
			$(".user-tab-discussions-content").hide();
			$(".user-tab-dicussions-content").animate({opacity:"0"},200);
			$(".user-tab-following-content").hide();
			$(".user-tab-following-content").animate({opacity:"0"},200);	
			$(".user-tab-followers-content").show();
			$(".user-tab-followers-content").animate({opacity:"1"},200);		
		}					
	});
	$(document).delegate(".oh-editor-fx","click",function(){
		$(this).hide();
		$(".blacksheet").fadeIn(200);
		$(".blacksheet-main").fadeIn(200);
	});
	$(document).delegate(".done-editing","click",function(){
		$(".blacksheet").hide();
		$(".oh-editor-fx").fadeIn(200);
		$(".blacksheet-main").fadeOut(200);
	});

	$(document).delegate(".edit-profile","click",function(){
		$(this).hide();
		$(".profpic-container-real").hide();
		$(".user-info-wrapper").css("opacity","0");
		$(".blacksheet-main").fadeIn(400);
		$(".main-2").show();
	});
	$(document).delegate(".cancel-edit-profile","click",function(){
		$(".blacksheet-main").fadeOut(400);
		$(".main-2").hide();
		$(".edit-profile").show();
		$(".profpic-container-real").show();
		$(".add_book_list").show()
		$(".user-info-wrapper").css("opacity","1");		
	});
	

	$(document).delegate(".add_book_list","click",function(){
		$(this).fadeOut(200);
	});
	$(document).delegate(".oh_checkbox","click",function(){
		$(".time_select_fx").hide();
		$(this).closest(".oh_day_select").find(".oh_checkbox_label").css({"background-position":"0 -15px","color":"rgba(55, 55, 55,1)"});
		$(this).addClass("oh_checkbox_checked");
		$(this).closest(".oh_day_select").find(".time_select_fx").show();
	});
	$(document).delegate(".oh_checkbox_checked","click",function(){
		$(this).closest(".oh_day_select").find(".oh_checkbox_label").css({"background-position":"0px 0px","color":"rgba(77, 77, 77,.6)"});
		$(this).removeClass("oh_checkbox_checked");
		$(this).closest(".oh_day_select").find(".time_select_fx").hide();
	});	

	 // to fade in on page load

});