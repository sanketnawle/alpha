<!DOCTYPE html> 
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
</script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.0/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/topbar.css">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>

</head>
<script>
$( document ).ready(function() {

	
	var d = new Date();
	var t= d.getDate();              
	var nm= "'img/calendar-icons/"+t+".png'";
	$(".cal_icon").attr("src","img/calendar-icons/"+t+".png");




	$( document ).delegate( ".topbar_search_input", "click", function() {
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

			     		$(".topbar_search_input").removeClass("augged");
						$(".topbar_search_input").css({"width":w});
						$(".graph_search").hide();
						$(".topbar_search_input").css({"border-bottom-left-radius":"4px","border-bottom-right-radius":"4px"});
			     	}

				});

$(document).delegate(".topbar_qicon img","mouseover",function(){
	$(this).closest(".search_input_wrapper").find(".card-tag").stop().show();
});

/*
$(document).delegate(".card-tag","mouseover",function(){
	$(this).stop().show();
});
*/

$(document).delegate(".topbar_qicon img","mouseout",function(){
	$(this).closest(".search_input_wrapper").find(".card-tag").delay(1).hide(0);
});

/*
$(document).delegate(".card-tag","mouseout",function(){
	$(this).delay(1).hide(0);
});
*/



});
</script>

<body>

		<div class = "topbar">
			<div class = "topbar_wrapper">
				<div class='topbar_left'>
				<img class = "topbar_logo" src = "img/logo.png"/>
				<img class = "leftbar_close flip" src = "img/burger_closed.png"/>
				</div>
				


				<div class='topbar_righttool'>
					<div class='topbar_cal'><img class='cal_icon' src='img/calendar.png'></div>					
					<div class='topbar_noti'>
						<span class='noti_icon'><p>2</p></span>
						
					</div>
					<div class = "topbar_prof">
						<div style = "background-image: url(img/userPic.jpg);" class = "prof-limit">
						</div>
					</div>
				</div>


				<div class='topbar_search'>
					<div class = "topbar_search_container">
						<div class ="notop_padding">	
							<div class = "search_main_div">
								<form name = "search" method = "get">
									<div class = "search_input_wrapper">
										<input class='topbar_search_input' placeholder='Search groups and faculty...'>
										<!--
										<div class='topbar_qicon'><img src='src/question.png'>
										<div class = "card-tag">
											<div class = "tag-wedge"></div>
											<div class = "tag-box">
												<span>Show search options</span>
											</div>									
										</div>	
										</div>
										-->
									</div>
									
								</form>
							</div>
						</div>
						

					</div>
				</div>
				
				

			</div>
		</div>
		
</body>


</html>


						