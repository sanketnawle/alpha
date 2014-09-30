$(function() {

	
	var d = new Date();
	var t= d.getDate();              
	var nm= "'src/calendar-icons/"+t+".png'";


	$(".cal_icon").attr("src","img/calendar-icons/"+t+".png");


	var pw_final=740;
	var ban_aug=0;
	$( window ).resize(function() {
		$(".topbar_search_input").removeClass("augged");
		$(".topbar_search_input").css({"width":"300px"});


		if($(window).width()<=1080){
			ban_aug=1;
		}else{
			ban_aug=0;
		}
		if($(window).width()<=740){
			
		$( ".topbar_search_input" ).css( "width", ( $( window ).width() * 0.4 | 0 ) + "px" );
		

		if($( ".topbar_search_input" ).width()<=268){$( ".topbar_search_input" ).css( "width", 220 + "px" );}
		}else{
		
		$( ".topbar_search_input" ).css( "width", 300 + "px" );	
		}
	});

	$( document ).delegate( ".topbar_search_input", "click", function() {
		//$(this).css({"background-color":"white"});
		if(ban_aug==0){
			if(!$(this).hasClass("augged")){
			$(this).addClass("augged");
			$(this).css({"width":"430px"});
			$(".topbar_qicon").hide();

			}
			
		}
		
		//$(".graph_search").show();
	});


		$( document ).delegate( ".topbar_search_input", "keydown", function() {
			$(".graph_search").show();
			$(".topbar_search_input").css({"border-bottom-left-radius":"0px","border-bottom-right-radius":"0px"});
		});

		$( document ).delegate( ".topbar_qicon img", "click", function() {
			$(".graph_search").show();
			$(".card-tag").hide();
			$(".topbar_search_input").css({"border-bottom-left-radius":"0px","border-bottom-right-radius":"0px"});
		});

		$( document ).delegate( ".gs_col", "mousedown", function() {
			$(this).addClass("gs_on_active");
		});

		$( document ).delegate( ".gs_col", "mouseup", function() {
			$(this).removeClass("gs_on_active");
		});

				$(document).click(function(event){
			     	var $target= $(event.target);
			     	var $container= $(".topbar");
			     	if(!$container.is($target)&&($container.has($target).length===0)){
			     		$(".topbar_qicon").show();
			     		var w= $(".topbar_search_input").width();
			     		if(w>=300){w=300;}

			     		$(".topbar_search_input").removeClass("augged");
						$(".topbar_search_input").css({"width":w});
						$(".graph_search").hide();
						$(".topbar_search_input").css({"border-bottom-left-radius":"4px","border-bottom-right-radius":"4px"});
			     	}

				});

$(document).delegate(".topbar_qicon img","mouseover",function(){
	$(this).closest(".search_input_wrapper").find(".card-tag").stop().show();
});

$(document).delegate(".card-tag","mouseover",function(){
	$(this).stop().show();
});

$(document).delegate(".topbar_qicon img","mouseout",function(){
	$(this).closest(".search_input_wrapper").find(".card-tag").delay(1).hide(0);
});
$(document).delegate(".card-tag","mouseout",function(){
	$(this).delay(1).hide(0);
});

 $(document).delegate(".lftbar_ctr","click",function(){

 	if($(this).hasClass("flip")){
 		$(this).removeClass("flip");
 		$(this).css({"margin-right":"10px;"});
 		}else{
 		$(this).addClass("flip");	
 	}
 });

});