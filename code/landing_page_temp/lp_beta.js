$(document).ready(function() {
	$(document).delegate(".pagination-item","click",function(){
		if($(this).hasClass("flag-active")){
			return
		}
		if($(this).hasClass("page-item-2") && $(this).hasClass("flag-inactive")){
			$(".text-grabber-active").animate({ opacity: "0",left:"500px",right:"-500px"},800).hide(0);
			$(".state2").show();

			$(".state2").addClass("text-grabber-active");
			$(".state2").animate({ opacity: "1",left:"0px",right:"0px"},800);
			$(".page-item-1").removeClass("flag-active").addClass("flag-inactive");
			$(".page-item-3").removeClass("flag-active").addClass("flag-inactive");

			$(this).addClass("flag-active");

			$(this).removeClass("flag-inactive");
		}
		if($(this).hasClass("page-item-1") && $(this).hasClass("flag-inactive")){
			$(".text-grabber-active").stop().animate({ opacity: "0",left:"500px",right:"-500px"},800).hide(0);
			$(".state1").show();

			$(".state1").addClass("text-grabber-active");
			$(".state1").animate({ opacity: "1",left:"0px",right:"0px"},800);
			$(".page-item-2").removeClass("flag-active").addClass("flag-inactive");;
			$(".page-item-3").removeClass("flag-active").addClass("flag-inactive");;

			$(this).addClass("flag-active");

			$(this).removeClass("flag-inactive");
		}

	});
	$(document).delegate(".account-type","click",function(){
		if($(this).hasClass("student")){
			$(".faculty").removeClass("account-type-chosen");
			$(this).addClass("account-type-chosen");
			$("#student").prop("checked", true);
			$("#faculty").prop("checked", false);
		}
		if($(this).hasClass("faculty")){
			$(".student").removeClass("account-type-chosen");
			$(this).addClass("account-type-chosen");
			$("#faculty").prop("checked", true);
			$("#student").prop("checked", false);
						
			
		}
	});
});

