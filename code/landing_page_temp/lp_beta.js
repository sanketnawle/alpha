$(document).ready(function() {
	$(document).delegate(".pagination-item","click",function(){
		if($(this).hasClass("flag-active")){
			return false;
		}
		var nb_origin=$(".flag-active").attr("id").split("_")[1];
		//alert(nb_origin);
		var $original=$(".state"+nb_origin);

		$( ".pagination-item" ).removeClass("flag-active");
		$(this).addClass("flag-active");
		$( ".pagination-item" ).each(function() {
			if(!$(this).hasClass("flag-inactive")){
				$(this).addClass("flag-inactive");
			}
		});

		var nb= $(this).attr("id").split("_")[1];

		var $newob=$(".state"+nb);
		//$newob.show();
		 $original.animate({
			opacity: 0,
			left:200
			}, 650,'easeInOutQuart', function() {
				$original.css({"left":"0px"});
				$original.removeClass("text-grabber-active");
				$original.addClass("text-grabber-inactive");

				$newob.show();
				$newob.animate({
					opacity: 1,
					left:200
					}, 600,'easeInOutQuart', function() {
						$newob.css({"left":"0px"});
						$newob.addClass("text-grabber-active");
						$newob.removeClass("text-grabber-inactive");
					});

			});

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

