

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

	$(document).delegate('.close-invite-ddbox',"click", function(){
		$(".add-event-dd-box-invite").hide();
	});

	var theme_pic_index = 0;
	$(document).delegate("#addEvent", "click", function () {
	    $(".blackcanvas30").fadeIn();
	    $("#bc3contentAddEvent").css('display', 'block');
	    $('.add-event-pic-actual').children().remove();
	    if ($('.add-event-pic-actual').length == 1) {
	        $.ajax({
	            url: "php/fetch_themes.php",
	            type: "POST",
	            dataType: "text",
	            success: function (responseText) {
	                $('.add-event-pic-actual').append(responseText);
	                var index = 0;
	                var jumpTo = 0;
	                if ($('#theme_id').text() != "") {
	                    $('.theme_pic').each(function () {
	                        if ($('#theme_id').text() == $(this).prop('id')) {
	                            $('#theme_id').text($(this).prop('id'));
	                            jumpTo = index;
	                            theme_pic_index = jumpTo;
	                        }
	                        index++;
	                    });

	                    $(".add-event-pic").scrollTop((jumpTo * 125));
	                }
	                else {
	                    theme_pic_index = 0;
	                    $(".add-event-pic").scrollTop(0);
	                }
	            },
	            error: function (responseText) {
	                alert("theme fetch failed");
	            }
	        });	        
	    }

	    $('#invitedConnections').parent('.add-event-box-main-row').show();
	    $('#nevt-location-1').parent('.add-event-box-main-row').show();
	    $('#nevt-desc-1').css('margin-top', '0px');
	    $('.event-repeat').css('display', 'block');
	    $('#fileAttach').hide();
	    $('#btnDeleteEvent').hide();
	    $('.add-event-box-edit-header').hide();
	    $('#btnAddThisEvent').text('Add Event');
	    /*$("#bc3contentAddEvent").animate({ marginTop: "+=600px" });*/
	});

	var clickCount = 0;
	function flagSetClickCount(e) {
	    clickCount = 0;
	}
	
	setInterval(function () { flagSetClickCount(); }, 1500);
	$(document).delegate('.add-event-right', "click", function () {	    
	    if (clickCount == 0) {	        
	        clickCount = 1;
	        var $cardref = $(this).parents(".add-event-header").children(".add-event-pic");
	        var topPos = $cardref.scrollTop();

	        $cardref.stop().animate({ scrollTop: topPos + 125 }, 400);
	        if (theme_pic_index < $cardref.children('.add-event-pic-actual').prop('childElementCount')) {
	            theme_pic_index++;
	        }
	        if (theme_pic_index == $cardref.children('.add-event-pic-actual').prop('childElementCount')) {
	            $cardref.stop().animate({ scrollTop: 0 }, 400);
	            theme_pic_index = 0;
	        }
	        var index = 0;
	        var flag = true;
	        $('.theme_pic').each(function () {
	            if (theme_pic_index.toString() == index.toString()) {
	                if (flag) {
	                    $('#theme_id').text($(this).prop('id'));
	                    flag = false;
	                    return;
	                }
	            }
	            index++;
	        });
	    }	    
	});

	$(document).delegate('.add-event-left', "click", function () {
	    if (clickCount == 0) {
	        clickCount = 1;
	        var $cardref = $(this).parents(".add-event-header").children(".add-event-pic");
	        var topPos = $cardref.scrollTop();
	        $cardref.stop().animate({ scrollTop: topPos - 125 }, 400);
	        if (theme_pic_index > 0) {
	            theme_pic_index--;
	        }
	        if (theme_pic_index == 0) {
	            $cardref.stop().animate({ scrollTop: ($cardref.children('.add-event-pic-actual').prop('childElementCount') * 125) }, 400);
	            theme_pic_index = $cardref.children('.add-event-pic-actual').prop('childElementCount');
	        }
	        var index = 0;
	        var flag = true;
	        $('.theme_pic').each(function () {
	            if (theme_pic_index.toString() == index.toString()) {
	                if (flag) {
	                    $('#theme_id').text($(this).prop('id'));
	                    flag = false;
	                    return;
	                }
	            }
	            index++;
	        });
	    }
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


