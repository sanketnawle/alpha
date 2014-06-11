$(document).ready(function() {
	$(document).delegate(".past_events_tab","click",function(){
		$(this).closest(".tabs").find(".active_pe_tab").removeClass("active_pe_tab");
		if(!$(this).hasClass("active_pe_tab")){
			$(this).find(".little-glyph").addClass("active_glyph");
			$(this).addClass("active_pe_tab");
			$(".past_events_tab").css("border-right-color","rgba(87, 87, 87, 0.7)");
		}
	});
	$(document).delegate(".active_pe_tab","click",function(){
			$(this).removeClass("active_pe_tab");
			$(this).find(".little-glyph").removeClass("active_glyph");
			$(".past_events_tab").css("border-right-color","#e9eaed");
		});
});   
