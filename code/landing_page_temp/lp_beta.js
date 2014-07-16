$(document).ready(function() {
	var pcount=0;
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

		
		pcount=parseInt(nb);
		clearInterval(mytimer);
		mytimer=setInterval(function() {pinclick_trigger(); }, 7000);
		//alert(nb);

		var $newob=$(".state"+nb);
		//$newob.show();
		 $original.animate({
			opacity: 0,
			left:180
			}, 650,'swing', function() {
				$original.css({"left":"0px"});
				$original.removeClass("text-grabber-active");
				$original.addClass("text-grabber-inactive");

				$newob.show();
				$newob.animate({
					opacity: 1,
					left:200
					}, 500,'swing', function() {
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

	
	function pinclick_trigger(){
		pcount=pcount+1;
		if(pcount>=3){pcount=0;}
		//alert(pcount);
		$("#lgnavi_"+pcount).click();
		//alert("a");
	}
	var mytimer=setInterval(function() {pinclick_trigger(); }, 7000);
	
});

