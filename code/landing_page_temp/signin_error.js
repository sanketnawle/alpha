$(document).ready(function() {
	$(document).delegate(".more_options_btn","click",function(){
		$(this).addClass("more_options_btn_clicked");
		$(".signin_err_box_moreoptions").stop().animate({ opacity: "1",height:"60px"},350,'swing', function() {});
		$(".signin_err_box_moreoptions").addClass("signin_err_box_moreoptions_open");
		return false;
	});
	$(document).delegate(".more_options_btn_clicked","click",function(){
		$(this).removeClass("more_options_btn_clicked");
		$(".signin_err_box_moreoptions").stop().animate({ opacity: "0",height:"0px"},350,'swing', function() {});
		$(".signin_err_box_moreoptions").removeClass("signin_err_box_moreoptions_open");

	});

	$(document).delegate(".change_to_input","click",function(){
		$(this).closest(".parent_hider").hide();
		$(this).closest(".parent_hider").animate({ opacity: "0"},750,'swing', function() {});
		$(this).closest(".parent_form").find(".child_input_showr").show();
		$(this).closest(".parent_hider").find(".child_input_showr").animate({ opacity: "1"},750,'swing', function() {});
		$(".child_input_showr").removeClass("input_null");
		$(".child_input_showr").focus();
	});
});

