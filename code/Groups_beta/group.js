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
			$(".about-tab-content").stop().animate({ opacity: "0"},300);
			$(".about-tab-content").hide();
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
        about_text= about_text.substring(0,70)+"..." + "<span class='bh-t2'> <a class = 'bh-t2' href=''>Read More</a></span>";
        $(".content-about").html(about_text);
    }
    $(document).delegate(".search-icon","click",function(){
			$(".inputText").focus();
	});
	$(document).delegate(".plusIcon","click",function(){
		$(".inviteInput").focus();
	});






});