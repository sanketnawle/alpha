

$(document).ready(function() {
	$(document).delegate(".add-event-box-dd","click",function(){
		$(this).addClass("dd-boxer-dn");
		$(this).closest(".header-inp-wrap").find(".dd-box").addClass("dd-box-show");

	});

	$(document).delegate(".dd-boxer-dn","click",function(){
		$(this).removeClass("dd-boxer-dn");
		$(this).closest(".header-inp-wrap").find(".dd-box").removeClass("dd-box-show");

	});

	$(document).delegate('.add-endtime',"click", function(){
		$(this).hide();
		$(".revert-end-time").show();
		$(".event-end-time").show();
		$(".event-end-time").focus();
		$(".down-arrow-2").show();
		$(".event-end-time").css("opacity","1");
	});
	$(document).delegate('.revert-end-time',"click", function(){
		$(this).hide();
		$(".event-end-time").hide();
		$(".down-arrow-2").hide();
		$(".add-endtime").show();
	});

});