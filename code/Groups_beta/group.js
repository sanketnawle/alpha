$(document).ready(function() {

	$(document).delegate(".joined","mouseover",function(){
			$(this).text("Withdraw");
	});

	$(document).delegate(".joined","mouseout",function(){
			$(this).text("Enrolled");
	});
	$(document).delegate(".tab-inactive","click",function(){
		if($(this).hasClass("tab2")){
			if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tabc-icon-active")){
				$(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tabc-icon-active");
				$(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tabc-icon-inactive");
			}
			if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab1-icon-active")){
				$(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab1-icon-active");
				$(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab1-icon-inactive");
			}
			if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab3-icon-active")){
				$(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab3-icon-active");
				$(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab3-icon-inactive");
			}
			$(this).find(".tab-title").find(".tab-icon").removeClass("tab2-icon-inactive");
			$(this).find(".tab-title").find(".tab-icon").addClass("tab2-icon-active");
			$(".group-tab-active").addClass("tab-inactive");
			$(".group-tab-active").removeClass("group-tab-active");
			$(".tab-wedge-down").css("left","460px");
			$(this).removeClass("tab-inactive");
			$(this).addClass("group-tab-active");
			$(".feed-tab-content").hide();
			$(".feed-tab-content").stop().animate({ opacity: "0"},300);
			$(".syllabus-tab-content").stop().animate({ opacity: "0"},300);
			$(".syllabus-tab-content").hide();
			$(".about-content").stop().animate({ opacity: "0"},300);
			$(".about-content").hide();
			$(".files-tab-content").stop().animate({ opacity: "0"},300);
			$(".files-tab-content").hide()
			$(".members-tab-content").animate({ opacity: "1"},300);
			$(".members-tab-content").show();
		}
		if($(this).hasClass("tab1")){
			
			
			
			if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tabc-icon-active")){
				$(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tabc-icon-active");
				$(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tabc-icon-inactive");
			}
			if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab2-icon-active")){
				$(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab2-icon-active");
				$(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab2-icon-inactive");
			}
			if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab3-icon-active")){
				$(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab3-icon-active");
				$(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab3-icon-inactive");
			}
			$(this).find(".tab-title").find(".tab-icon").removeClass("tab1-icon-inactive");
			$(this).find(".tab-title").find(".tab-icon").addClass("tab1-icon-active");
			$(".group-tab-active").addClass("tab-inactive");
			$(".group-tab-active").removeClass("group-tab-active");
			$(".tab-wedge-down").css("left","310px");
			$(this).removeClass("tab-inactive");
			$(this).addClass("group-tab-active");
			
			$(".syllabus-tab-content").stop().animate({ opacity: "0"},300);
			$(".syllabus-tab-content").hide();
			$(".about-content").stop().animate({ opacity: "0"},300);
			$(".about-content").hide();
			$(".files-tab-content").stop().animate({ opacity: "0"},300);
			$(".files-tab-content").hide()
			$(".members-tab-content").stop().animate({ opacity: "0"},300);
			$(".members-tab-content").hide();
			$(".feed-tab-content").show();
			$(".feed-tab-content").animate({ opacity: "1"},300);
			
		}
		if($(this).hasClass("tab3")){
			
			
			
			if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tabc-icon-active")){
				$(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tabc-icon-active");
				$(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tabc-icon-inactive");
			}
			if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab2-icon-active")){
				$(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab2-icon-active");
				$(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab2-icon-inactive");
			}
			if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab1-icon-active")){
				$(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab1-icon-active");
				$(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab1-icon-inactive");
			}
			$(this).find(".tab-title").find(".tab-icon").removeClass("tab3-icon-inactive");
			$(this).find(".tab-title").find(".tab-icon").addClass("tab3-icon-active");
			$(".group-tab-active").addClass("tab-inactive");
			$(".group-tab-active").removeClass("group-tab-active");
			$(".tab-wedge-down").css("left","591px");
			$(this).removeClass("tab-inactive");
			$(this).addClass("group-tab-active");

			$(".feed-tab-content").stop().animate({ opacity: "0"},300);
			$(".feed-tab-content").hide();
			$(".syllabus-tab-content").stop().animate({ opacity: "0"},300);
			$(".syllabus-tab-content").hide();
			$(".about-content").stop().animate({ opacity: "0"},300);
			$(".about-content").hide();
			
			$(".members-tab-content").stop().animate({ opacity: "0"},300);
			$(".members-tab-content").hide();
			$(".files-tab-content").show()
			$(".files-tab-content").animate({ opacity: "1"},300);
			
			
			
		}			
		if($(this).hasClass("tabc")){
			
			
			
			if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab3-icon-active")){
				$(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab3-icon-active");
				$(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab3-icon-inactive");
			}
			if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab2-icon-active")){
				$(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab2-icon-active");
				$(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab2-icon-inactive");
			}
			if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab1-icon-active")){
				$(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab1-icon-active");
				$(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab1-icon-inactive");
			}
			$(this).find(".tab-title").find(".tab-icon").removeClass("tabc-icon-inactive");
			$(this).find(".tab-title").find(".tab-icon").addClass("tabc-icon-active");
			$(".group-tab-active").addClass("tab-inactive");
			$(".group-tab-active").removeClass("group-tab-active");
			$(".tab-wedge-down").css("left","710px");
			$(this).removeClass("tab-inactive");
			$(this).addClass("group-tab-active");
			$(".feed-tab-content").stop().animate({ opacity: "0"},300);
			$(".feed-tab-content").hide();
			
			$(".about-content").stop().animate({ opacity: "0"},300);
			$(".about-content").hide();
			
			$(".members-tab-content").stop().animate({ opacity: "0"},300);
			$(".members-tab-content").hide();
			$(".files-tab-content").stop().animate({ opacity: "0"},300);
			$(".files-tab-content").hide()
			$(".syllabus-tab-content").show();
			$(".syllabus-tab-content").animate({ opacity: "1"},300);
			
		}	
	});
	$(document).delegate("#group-about-link","click",function(){
			$(".feed-tab-content").stop().animate({ opacity: "0"},300);
			$(".feed-tab-content").hide();
			
			
			if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tabc-icon-active")){
				$(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tabc-icon-active");
				$(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tabc-icon-inactive");
			}
			if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab3-icon-active")){
				$(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab3-icon-active");
				$(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab3-icon-inactive");
			}
			if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab2-icon-active")){
				$(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab2-icon-active");
				$(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab2-icon-inactive");
			}
			if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab1-icon-active")){
				$(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab1-icon-active");
				$(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab1-icon-inactive");
			}
			$(".tab-wedge-down").css("left","-400px");
			$(".group-tab-active").addClass("tab-inactive");
			$(".group-tab-active").removeClass("group-tab-active");
			$(".members-tab-content").stop().animate({ opacity: "0"},300);
			$(".members-tab-content").hide();
			$(".files-tab-content").stop().animate({ opacity: "0"},300);
			$(".files-tab-content").hide()
			
			$(".syllabus-tab-content").stop().animate({ opacity: "0"},300);
			$(".syllabus-tab-content").hide();
			$(".about-content").show();
			$(".about-content").animate({ opacity: "1"},300);
			
	});

	$(window).scroll(function(){ 
		var lastScrollTop= 47;
    	var scrollTop = $(this).scrollTop();
    	//alert(scrollTop);
    	$(".group-head-footer").each(function(){
    		var topDistance = $(this).offset().top;
    		
    			//alert(topDistance);
    			//alert(scrollTop);
    			if((topDistance-48) < scrollTop ){		
	            	$(".urGroupStickyHeader").stop().css({"top": "47px"});
	            	//alert("a");
            	}else{
            		//alert("a");
            		$(".urGroupStickyHeader").stop().css({"top": "-2px"});
            	}
            	//alert("a");
       		

    	});

    		

    	lastScrollTop = scrollTop;

	});

	var about_text = $(".content-about").text();
	//alert(about_text);
	if(about_text.length>=73){
        about_text= about_text.substring(0,70)+"..." + "<span class='bh-t2'> <a id = 'group-about-link' class = 'bh-t2'>Read More</a></span>";
        $(".content-about").html(about_text);
    }
    $(document).delegate(".search-icon","click",function(){
			$(".inputText").focus();
	});
	$(document).delegate(".plusIcon","click",function(){
		$(".inviteInput").focus();
	});


	$(document).delegate('.hor-scroller-right',"click", function(){

		var $cardref=$(this).closest(".tab-block-content-scroll").find(".members-scrollwrap");
		var leftPos = $cardref.scrollLeft();
		$cardref.stop().animate({scrollLeft: leftPos + 200}, 400);
	});

	$(document).delegate('.hor-scroller-left',"click", function(){

		var $cardref=$(this).closest(".tab-block-content-scroll").find(".members-scrollwrap");
		var leftPos = $cardref.scrollLeft();
		$cardref.stop().animate({scrollLeft: leftPos - 200}, 400);
	});

	$(document).delegate('.hor-scroller-right',"mouseover", function(){
		var $cardref=$(this).closest(".tab-block-content-scroll").find(".members-scrollwrap");
		var leftPos = $cardref.scrollLeft();
		$cardref.stop().animate({scrollLeft: leftPos + 15}, 400);
		$(this).stop().show();
	});

	$(document).delegate('.hor-scroller-right',"mouseout", function(){
		if(rightable==1){
		var $cardref=$(this).closest(".tab-block-content-scroll").find(".members-scrollwrap");
		var leftPos = $cardref.scrollLeft();
		$cardref.stop().animate({scrollLeft: leftPos - 15}, 400, function(){
			$(this).find('.hor-scroller-right').hide();
		});
		}
	});

	$(document).delegate('.hor-scroller-left',"mouseover", function(){
		var $cardref=$(this).closest(".tab-block-content-scroll").find(".members-scrollwrap");
		var leftPos = $cardref.scrollLeft();
		$cardref.stop().animate({scrollLeft: leftPos - 15}, 400);
		$(this).stop().show();
	});

	$(document).delegate('.hor-scroller-left',"mouseout", function(){
		if(leftable==1){
		var $cardref=$(this).closest(".tab-block-content-scroll").find(".members-scrollwrap");
		var leftPos = $cardref.scrollLeft();
		$cardref.stop().animate({scrollLeft: leftPos + 15}, 400, function(){
			$(this).find('.hor-scroller-left').hide();
		});
	}
	});


	var able_offset=45;
	var leftable=0;
	var rightable=0;
	$('.members-scrollwrap').bind('scroll', function(){
		var $ref=$(this).closest(".tab-block-content-scroll");
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


	$(document).delegate('.members-scrollwrap',"mouseover", function(){
		var $ref=$(this).closest(".tab-block-content-scroll");
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

	$(document).delegate('.tab-block-content-scroll',"mouseleave", function(){
		var $ref=$(this).closest(".tab-block-content-scroll");
		$ref.find(".hor-scroller-right").stop().hide();
		$ref.find(".hor-scroller-left").stop().hide();
	});
	
	$(document).delegate('.rating_star_empty1',"mouseenter", function(){
		$(".rating_star_unrated1").css("display","inline-block");
		$(".rating_star_unrated1").removeClass("rating_star_unrated");
	});
	$(document).delegate('.rating_star_unrated1',"mouseenter", function(){
		$(".rating_star_unrated1").css("display","inline-block");
		$(".rating_star_unrated1").removeClass("rating_star_unrated");
	});
	$(document).delegate('.rating_star_unrated1',"mouseleave", function(){
		$(".rating_star_unrated1").addClass("rating_star_unrated");
	});
	$(document).delegate('.rating_star_empty1',"mouseleave", function(){
		$(".rating_star_unrated1").addClass("rating_star_unrated");
	});

	$(document).delegate('.rating_star_empty2',"mouseenter", function(){
		$(".rating_star_unrated1").css("display","inline-block");
		$(".rating_star_unrated1").removeClass("rating_star_unrated");
		$(".rating_star_unrated2").css("display","inline-block");
		$(".rating_star_unrated2").removeClass("rating_star_unrated");
	});
	$(document).delegate('.rating_star_unrated2',"mouseenter", function(){
		$(".rating_star_unrated1").css("display","inline-block");
		$(".rating_star_unrated1").removeClass("rating_star_unrated");
		$(".rating_star_unrated2").css("display","inline-block");
		$(".rating_star_unrated2").removeClass("rating_star_unrated");
	});
	$(document).delegate('.rating_star_unrated2',"mouseleave", function(){
		$(".rating_star_unrated1").addClass("rating_star_unrated");
		$(".rating_star_unrated2").addClass("rating_star_unrated");
	});
	$(document).delegate('.rating_star_empty2',"mouseleave", function(){
		$(".rating_star_unrated1").addClass("rating_star_unrated");
		$(".rating_star_unrated2").addClass("rating_star_unrated");
	});
	$(document).delegate('.rating_star_empty3',"mouseenter", function(){
		$(".rating_star_unrated1").css("display","inline-block");
		$(".rating_star_unrated1").removeClass("rating_star_unrated");
		$(".rating_star_unrated2").css("display","inline-block");
		$(".rating_star_unrated2").removeClass("rating_star_unrated");
		$(".rating_star_unrated3").css("display","inline-block");
		$(".rating_star_unrated3").removeClass("rating_star_unrated");
	});
	$(document).delegate('.rating_star_unrated3',"mouseenter", function(){
		$(".rating_star_unrated1").css("display","inline-block");
		$(".rating_star_unrated1").removeClass("rating_star_unrated");
		$(".rating_star_unrated2").css("display","inline-block");
		$(".rating_star_unrated2").removeClass("rating_star_unrated");
		$(".rating_star_unrated3").css("display","inline-block");
		$(".rating_star_unrated3").removeClass("rating_star_unrated");
	});
	$(document).delegate('.rating_star_unrated3',"mouseleave", function(){
		$(".rating_star_unrated1").addClass("rating_star_unrated");
		$(".rating_star_unrated2").addClass("rating_star_unrated");
		$(".rating_star_unrated3").addClass("rating_star_unrated");
	});
	$(document).delegate('.rating_star_empty3',"mouseleave", function(){
		$(".rating_star_unrated1").addClass("rating_star_unrated");
		$(".rating_star_unrated2").addClass("rating_star_unrated");
		$(".rating_star_unrated3").addClass("rating_star_unrated");
	});
	$(document).delegate('.rating_star_empty4',"mouseenter", function(){
		$(".rating_star_unrated1").css("display","inline-block");
		$(".rating_star_unrated1").removeClass("rating_star_unrated");
		$(".rating_star_unrated2").css("display","inline-block");
		$(".rating_star_unrated2").removeClass("rating_star_unrated");
		$(".rating_star_unrated3").css("display","inline-block");
		$(".rating_star_unrated3").removeClass("rating_star_unrated");
		$(".rating_star_unrated4").css("display","inline-block");
		$(".rating_star_unrated4").removeClass("rating_star_unrated");
	});
	$(document).delegate('.rating_star_unrated4',"mouseenter", function(){
		$(".rating_star_unrated1").css("display","inline-block");
		$(".rating_star_unrated1").removeClass("rating_star_unrated");
		$(".rating_star_unrated2").css("display","inline-block");
		$(".rating_star_unrated2").removeClass("rating_star_unrated");
		$(".rating_star_unrated3").css("display","inline-block");
		$(".rating_star_unrated3").removeClass("rating_star_unrated");
		$(".rating_star_unrated4").css("display","inline-block");
		$(".rating_star_unrated4").removeClass("rating_star_unrated");
	});
	$(document).delegate('.rating_star_unrated4',"mouseleave", function(){
		$(".rating_star_unrated1").addClass("rating_star_unrated");
		$(".rating_star_unrated2").addClass("rating_star_unrated");
		$(".rating_star_unrated3").addClass("rating_star_unrated");
		$(".rating_star_unrated4").addClass("rating_star_unrated");
	});
	$(document).delegate('.rating_star_empty4',"mouseleave", function(){
		$(".rating_star_unrated1").addClass("rating_star_unrated");
		$(".rating_star_unrated2").addClass("rating_star_unrated");
		$(".rating_star_unrated3").addClass("rating_star_unrated");
		$(".rating_star_unrated4").addClass("rating_star_unrated");
	});
	$(document).delegate('.rating_star_empty5',"mouseenter", function(){
		$(".rating_star_unrated1").css("display","inline-block");
		$(".rating_star_unrated1").removeClass("rating_star_unrated");
		$(".rating_star_unrated2").css("display","inline-block");
		$(".rating_star_unrated2").removeClass("rating_star_unrated");
		$(".rating_star_unrated3").css("display","inline-block");
		$(".rating_star_unrated3").removeClass("rating_star_unrated");
		$(".rating_star_unrated4").css("display","inline-block");
		$(".rating_star_unrated4").removeClass("rating_star_unrated");
		$(".rating_star_unrated5").css("display","inline-block");
		$(".rating_star_unrated5").removeClass("rating_star_unrated");
	});
	$(document).delegate('.rating_star_unrated5',"mouseenter", function(){
		$(".rating_star_unrated1").css("display","inline-block");
		$(".rating_star_unrated1").removeClass("rating_star_unrated");
		$(".rating_star_unrated2").css("display","inline-block");
		$(".rating_star_unrated2").removeClass("rating_star_unrated");
		$(".rating_star_unrated3").css("display","inline-block");
		$(".rating_star_unrated3").removeClass("rating_star_unrated");
		$(".rating_star_unrated4").css("display","inline-block");
		$(".rating_star_unrated4").removeClass("rating_star_unrated");
		$(".rating_star_unrated5").css("display","inline-block");
		$(".rating_star_unrated5").removeClass("rating_star_unrated");
	});
	$(document).delegate('.rating_star_unrated5',"mouseleave", function(){
		$(".rating_star_unrated1").addClass("rating_star_unrated");
		$(".rating_star_unrated2").addClass("rating_star_unrated");
		$(".rating_star_unrated3").addClass("rating_star_unrated");
		$(".rating_star_unrated4").addClass("rating_star_unrated");
		$(".rating_star_unrated5").addClass("rating_star_unrated");
	});
	$(document).delegate('.rating_star_empty5',"mouseleave", function(){
		$(".rating_star_unrated1").addClass("rating_star_unrated");
		$(".rating_star_unrated2").addClass("rating_star_unrated");
		$(".rating_star_unrated3").addClass("rating_star_unrated");
		$(".rating_star_unrated4").addClass("rating_star_unrated");
		$(".rating_star_unrated5").addClass("rating_star_unrated");
	});
	




});