$(document).ready(function() {

$(document).delegate(".h_noti_gen","mouseover",function(e){
	$(this).find(".h_notievent_time").hide();
	$(this).find(".h_noti_remove").show();
});

$(document).delegate(".h_noti_gen","mouseout",function(e){
	$(this).find(".h_noti_remove").hide();
	$(this).find(".h_notievent_time").show();
});


$(document).delegate(".h_noti_remove","mouseover",function(){
	$(this).find(".h_card-tag").stop().show();
});

$(document).delegate(".h_noti_remove","mouseout",function(){
	$(this).find(".h_card-tag").delay(1).hide(0);
});

$(document).delegate(".h_remove_icon","click",function(){
	$(this).closest(".h_noti_gen").hide();
});

$(document).delegate(".h_remove_icon","mouseover",function(){
	$(this).css({"background-image":"url(img/hide-hover.png)"});
});	

$(document).delegate(".h_remove_icon","mouseout",function(){
	$(this).css({"background-image":"url(img/hide.png)"});
});	

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

	$(document).delegate(".cal_noti_see","click",function(){
		$(".active_pe_tab").removeClass("active_pe_tab");
		$(".little-glyph").removeClass("active_glyph");
		$(".past_events_tab").css("border-right-color","#e9eaed");
	});



});   
