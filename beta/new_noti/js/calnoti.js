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

	$(document).delegate(".dld_btn", "mouseenter", function () {
		$(this).closest(".ivt_rightbox").find(".tooltipwrap").show();
	});  
	$(document).delegate(".dld_btn", "mouseleave", function () {
		$(this).closest(".ivt_rightbox").find(".tooltipwrap").hide();
	});


	$(document).delegate(".cn_row", "mouseenter", function () {
		$(this).addClass("cn_row_hover");
		$(this).find(".close_ivt").show();
	});  
	$(document).delegate(".cn_row", "mouseleave", function () {
		$(this).removeClass("cn_row_hover");
		$(this).find(".close_ivt").hide();
	});  

	$(document).delegate(".f_row", "mouseenter", function () {
		$(this).addClass("cn_row_hover");
	});  
	$(document).delegate(".f_row", "mouseleave", function () {
		$(this).removeClass("cn_row_hover");
	});  


	$(document).delegate(".ds_row", "mouseenter", function () {
		$(this).addClass("ds_row_hover");
	});  
	$(document).delegate(".ds_row", "mouseleave", function () {
		$(this).removeClass("ds_row_hover");
	});  

	$(document).delegate(".cn_unseen", "click", function () {
		$(this).removeClass("cn_unseen");
	});  	
});