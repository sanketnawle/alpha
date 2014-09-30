$(document).ready(function() {
	$(document).delegate(".eventbook-discuss-btn","click",function(){
		$(this).addClass("eventbook-discuss-hider");
		$(this).text("Hide this discussion");
		$(this).closest(".eventbook-groupevent-cont").closest(".eb-groupevent-wrap").find(".eb-event-discussion").animate({ opacity: "1", height: "120"},200);
	});
	$(document).delegate(".eventbook-discuss-hider","click",function(){
		$(this).closest(".eventbook-groupevent-cont").closest(".eb-groupevent-wrap").find(".eb-event-discussion").animate({ opacity: "0", height: "0"},250).stop();
		$(this).text("View the full discussion (10)");
		$(this).removeClass("eventbook-discuss-hider");
	});

	$(document).delegate(".event-attend-status","click",function(){
		$(this).addClass("event-attend-status-hider");
		$(this).closest(".eventbook-event-cont").find(".dd-box-attending").addClass("dd-box-show");
	});
	$(document).delegate(".fx-cont-right","click",function(){
		$("html, body").animate({ scrollTop: $('#date-2').offset().top }, 900);
		$(".eb-current-day").animate({ marginTop: "-40"},500);

		$(".eb-current-day").addClass("eb-prev-day");
		$(".eb-prev-day").removeClass("eb-current-day");

		$(".eb-next-day").addClass("eb-current-day");
		$(".eb-next-day").removeClass("eb-next-day");
	});

	$(document).delegate(".fx-cont-left","click",function(){

		$(".eb-prev-day").animate({ marginTop: "0"},500);
		$(".eb-current-day").addClass("eb-next-day");
		$(".eb-prev-day").addClass("eb-current-day");
		$(".eb-prev-day").removeClass("eb-prev-day");
		$(".eb-next-day").removeClass("eb-current-day");
		$(".eb-current-day").addClass("eb-current-day");

		
	});

	$(document).delegate(".event-attend-status-hider","click",function(){
		$(this).removeClass("event-attend-status-hider");
		$(this).closest(".eventbook-event-cont").find(".dd-box-attending").removeClass("dd-box-show");
	});
	 $(document).on("click", function (e) {
        var elem = $(e.target);
        if (elem.hasClass("dd-box-attending") || elem.hasClass("attending-option") || elem.hasClass("event-attend-status") || elem.hasClass("attend-icon") || elem.hasClass("attend-title-toggler") || elem.hasClass("remove-icon")) {
            return;
        }
        else {
            $('.dd-box-attending').removeClass("dd-box-show");
            $(".event-attend-status-hider").removeClass("event-attend-status-hider");
        }
	});
	 if ( (window).innerWidth < 941) {
		    $(".eb-event-type").text("TO-DO");
		}
	if ( (window).innerWidth > 942) {
	    $(".eb-event-type").text("PERSONAL TO-DO");
	}
	 $(window).resize(function() {
		if ( (window).innerWidth < 941) {
		    $(".eb-event-type").text("TO-DO");
		}
		if ( (window).innerWidth > 942) {
		    $(".eb-event-type").text("PERSONAL TO-DO");
		}

	});
	


	 

});