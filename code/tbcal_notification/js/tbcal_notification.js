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

	$(document).delegate(".cal_noti_see","click",function(){
		$(".active_pe_tab").removeClass("active_pe_tab");
		$(".little-glyph").removeClass("active_glyph");
		$(".past_events_tab").css("border-right-color","#e9eaed");
	});

	$(document).delegate(".calnoti_gen","mouseover",function(){
		$(this).find(".noti_remove").show();
	});

	$(document).delegate(".calnoti_gen","mouseout",function(){
		$(this).find(".noti_remove").hide();
	});

	$(document).delegate(".calnoti_gen","click",function(){
		$(this).removeClass("calnoti_unseen");
	});


	$(document).delegate(".noti_remove","mouseover",function(){
		$(this).find(".card-tag").stop().show();
	});

	$(document).delegate(".noti_remove","mouseout",function(){
		$(this).find(".card-tag").delay(1).hide(0);
	});

	$(document).delegate(".remove_icon","click",function(){
		$(this).closest(".calnoti_gen").hide();
	});

});   
