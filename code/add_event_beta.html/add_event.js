

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
	$(document).delegate('.event-invites',"mousedown", function(){
		$(this).focus();
		$(".add-event-dd-box-invite").show();
	});

	$(document).delegate('.ddbox-invite-option',"click", function(){
		$(this).addClass("ddbox-option-invited");
		$(this).find(".after-click-effect").show();
		$(this).find(".invite-option-checkwrap").css({"background-image":"url(src/checked-invite.png)","opacity":"1"});
	});

	$(document).delegate('.close-invite-ddbox',"click", function(){
		$(".add-event-dd-box-invite").hide();
	});

	$(document).delegate('.ddbox-option-invited',"click", function(){
		$(this).removeClass("ddbox-option-invited");
		$(this).find(".after-click-effect").hide();
		$(this).find(".invite-option-checkwrap").css({"background-image":"url(src/unchecked-invite.png)","opacity":".7"});
	});
});