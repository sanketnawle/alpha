$(document).ready(function() {

$(document).delegate(".noti_gen","mouseover",function(e){
	$(this).find(".notievent_time").hide();
	$(this).find(".noti_remove").show();
});

$(document).delegate(".noti_gen","mouseout",function(e){
	$(this).find(".noti_remove").hide();
	$(this).find(".notievent_time").show();
});


$(document).delegate(".noti_remove","mouseover",function(){
	$(this).find(".card-tag").stop().show();
});

$(document).delegate(".noti_remove","mouseout",function(){
	$(this).find(".card-tag").delay(1).hide(0);
});

$(document).delegate(".remove_icon","click",function(){
	$(this).closest(".noti_gen").hide();
});

});   
