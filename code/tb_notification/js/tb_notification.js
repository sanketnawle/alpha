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


});   
