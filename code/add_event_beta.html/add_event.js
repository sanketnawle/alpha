

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


	$(document).delegate('.hor-scroller-right',"click", function(){

		var $cardref=$(this).closest(".add-event-dd-box-invite").find(".dd-box-invite-scrollwrap");
		var leftPos = $cardref.scrollLeft();
		$cardref.stop().animate({scrollLeft: leftPos + 200}, 400);
	});

	$(document).delegate('.hor-scroller-left',"click", function(){

		var $cardref=$(this).closest(".add-event-dd-box-invite").find(".dd-box-invite-scrollwrap");
		var leftPos = $cardref.scrollLeft();
		$cardref.stop().animate({scrollLeft: leftPos - 200}, 400);
	});

	$(document).delegate('.hor-scroller-right',"mouseover", function(){
		var $cardref=$(this).closest(".add-event-dd-box-invite").find(".dd-box-invite-scrollwrap");
		var leftPos = $cardref.scrollLeft();
		$cardref.stop().animate({scrollLeft: leftPos + 15}, 400);
		$(this).stop().show();
	});

	$(document).delegate('.hor-scroller-right',"mouseout", function(){
		if(rightable==1){
		var $cardref=$(this).closest(".add-event-dd-box-invite").find(".dd-box-invite-scrollwrap");
		var leftPos = $cardref.scrollLeft();
		$cardref.stop().animate({scrollLeft: leftPos - 15}, 400, function(){
			$(this).find('.hor-scroller-right').hide();
		});
		}
	});

	$(document).delegate('.hor-scroller-left',"mouseover", function(){
		var $cardref=$(this).closest(".add-event-dd-box-invite").find(".dd-box-invite-scrollwrap");
		var leftPos = $cardref.scrollLeft();
		$cardref.stop().animate({scrollLeft: leftPos - 15}, 400);
		$(this).stop().show();
	});

	$(document).delegate('.hor-scroller-left',"mouseout", function(){
		if(leftable==1){
		var $cardref=$(this).closest(".add-event-dd-box-invite").find(".dd-box-invite-scrollwrap");
		var leftPos = $cardref.scrollLeft();
		$cardref.stop().animate({scrollLeft: leftPos + 15}, 400, function(){
			$(this).find('.hor-scroller-left').hide();
		});
	}
	});


	var able_offset=45;
	var leftable=0;
	var rightable=0;
	$('.dd-box-invite-scrollwrap').bind('scroll', function(){
		var $ref=$(this).closest(".add-event-dd-box-invite");
		//get scroll width

		var scrollw= ($(this)[0].scrollWidth);
		

		if($(this).scrollLeft()<=0){
			leftable=0;
			$ref.find(".hor-scroller-left").stop().hide();
		}

		if($(this).scrollLeft()>=able_offset)
		{
			if(leftable==0){
				$ref.find(".hor-scroller-left").stop().show();
				leftable=1;
			}
		}
		

		if($(this).scrollLeft()+$(this).innerWidth()>=(scrollw-40)){
			$ref.find(".hor-scroller-right").stop().hide();
			rightable=0;
		}
		
		if($(this).scrollLeft()+$(this).innerWidth()<=(scrollw-40)){
			if(rightable==0){
				$ref.find(".hor-scroller-right").stop().show();
				rightable=1;
			}
		}
	});


	$(document).delegate('.dd-box-invite-scrollwrap',"mouseover", function(){
		var $ref=$(this).closest(".add-event-dd-box-invite");
		var scrollw= ($(this)[0].scrollWidth);

		if($(this).scrollLeft()+$(this).innerWidth()>=(scrollw-40)){

		}else{
			
			$ref.find(".hor-scroller-right").stop().show();
			rightable=1;
			
		}

		if($(this).scrollLeft()>=able_offset)
		{
				$ref.find(".hor-scroller-left").stop().show();
				leftable=1;
		}


	});

	$(document).delegate('.add-event-dd-box-invite',"mouseleave", function(){
		var $ref=$(this).closest(".add-event-dd-box-invite");
		$ref.find(".hor-scroller-right").stop().hide();
		$ref.find(".hor-scroller-left").stop().hide();
	});
	

});


