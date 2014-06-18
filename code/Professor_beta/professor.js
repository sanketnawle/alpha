$(document).ready(function() {
	$(document).delegate(".showcase-container","mouseover",function(){
		$(this).find(".showcase-link").stop().animate({opacity: "1",marginTop:"35px"},0);
	});
	$(document).delegate(".showcase-container","mouseout",function(){
		$(this).find(".showcase-link").stop().animate({opacity: "0",marginTop:"95px"},0);
	});

	$(document).delegate(".link","click",function(){
		
			$(this).text("Following")
			$(this).removeClass("link");
			$(this).addClass("pre-linked");
		
	});
	$(document).delegate(".tab-inactive","click",function(){
			$(".tab-active").addClass("tab-inactive");
			$(".tab-active").removeClass("tab-active");

			$(this).removeClass("tab-inactive");
			$(this).addClass("tab-active");

			var activeTab = $(this);
			var activeTabposition = activeTab.position();
			var activeTabLeft = activeTabposition.left;
			var activeTabNew = activeTabLeft -27;
			$(".tab-indicator").css("margin-left",activeTabNew);

		
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
			$(".user-tab-groups-content").show();
			$(".user-tab-dicussions-content").animate({opacity:"0"},200);
			$(".user-tab-discussions-content").hide();
			$(".user-tab-groups-content").animate({opacity:"1"},200);
		}
		if($(this).hasClass("tab-1")){
			$(".user-tab-groups-content").hide();
			$(".user-tab-discussions-content").show();
			$(".user-tab-groups-content").animate({opacity:"0"},200);
			$(".user-tab-dicussions-content").animate({opacity:"1"},200);
		}
	});



	 // to fade in on page load

});