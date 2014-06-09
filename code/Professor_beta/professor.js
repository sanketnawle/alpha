$(document).ready(function() {



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



	 // to fade in on page load

});