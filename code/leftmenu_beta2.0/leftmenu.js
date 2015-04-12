$(document).ready(function() {
	$(document).delegate(".burger-wrap","click",function(){
		if(!$(".burger").hasClass("flipBurger")){
			$(".burger").addClass("flipBurger");
			$(".leftmenu").animate({ opacity: "0", marginLeft: "-300px"},200);
		}
		else{
			$(".burger").removeClass("flipBurger");
			$(".leftmenu").animate({ opacity: "1", marginLeft: "0px"},200);
		}
	});
});