$(document).ready(function() {

$(document).delegate(".c_noti_gen","mouseover",function(e){
	$(this).find(".c_notievent_time").hide();
	$(this).find(".c_noti_remove").show();
});

$(document).delegate(".c_noti_gen","mouseout",function(e){
	$(this).find(".c_noti_remove").hide();
	$(this).find(".c_notievent_time").show();
});


$(document).delegate(".c_noti_remove","mouseover",function(){
	$(this).find(".c_card-tag").stop().show();
});

$(document).delegate(".c_noti_remove","mouseout",function(){
	$(this).find(".c_card-tag").delay(1).hide(0);
});

$(document).delegate(".c_remove_icon","click",function(){
	$(this).closest(".c_noti_gen").hide();
});

$(document).delegate(".c_remove_icon","mouseover",function(){
	$(this).css({"background-image":"url(img/hide-hover.png)"});
});	

$(document).delegate(".c_remove_icon","mouseout",function(){
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

	$(document).delegate(".c_follow_bt","click",function(){
		//alert("a");
		return false;
	});

});   
