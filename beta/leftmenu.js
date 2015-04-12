$(document).ready(function() {
	$(document).delegate(".burger-wrap","click",function(){
		if(!$(".burger").hasClass("flipBurger")){
			$(".burger").addClass("flipBurger");
			$(".leftmenu").animate({ opacity: "0", marginLeft: "-300px"},200);
			$(".mid_right_sec").css({"float":"none","padding-left":"0px","right":"0px"});
			$(".urGroupStickyHeader").css("left","179px");
		}
		else{
			$(".burger").removeClass("flipBurger");
			$(".leftmenu").animate({ opacity: "1", marginLeft: "0px"},200);
			$(".mid_right_sec").css({"float":"left","padding-left":"318px","right":"0px"});
			$(".urGroupStickyHeader").css("left","319px");
		}
	});

	

		

});
/*$(".see_profile_menu_image").css({
				background: "url('imgs/left_side_menu_image_map.png') no-repeat -61px -119px",
				width: '15px',
				height: '15px',
			});*/