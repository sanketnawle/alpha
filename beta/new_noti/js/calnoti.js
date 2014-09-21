$(document).ready(function () {
	$(document).delegate(".button-block", "click", function () {
		if($(this).find("button").hasClass("flag_checked")){
			$(this).find("button").removeClass("flag_checked");
		}else{
			$(this).find("button").addClass("flag_checked");
		}
	});  

	$(document).delegate(".plus_btn", "mouseenter", function () {
		$(this).closest(".ivt_rightbox").find(".tooltipwrap").show();
	});  
	$(document).delegate(".plus_btn", "mouseleave", function () {
		$(this).closest(".ivt_rightbox").find(".tooltipwrap").hide();
	});
});