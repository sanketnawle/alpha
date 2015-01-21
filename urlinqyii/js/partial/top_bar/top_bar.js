$(document).ready(function(){
    $(document).delegate(".menu_hider.menu_shown", "click", function() {
        $(this).removeClass("menu_shown");
        $(this).addClass("menu_hidden");
         $("body").addClass("left_panel_hidden").delay(175).queue(function(next){
            $("body").addClass("left_panel_hidden_p2");
            next();
        });
    });

    $(document).delegate(".menu_hider.menu_hidden", "click", function() {
        $(this).removeClass("menu_hidden");
        $(this).addClass("menu_shown");
         $("body").removeClass("left_panel_hidden_p2").delay(100).queue(function(next){
            $("body").removeClass("left_panel_hidden");
            next();
        });
    });

    $("#page").scroll(function() {
	        var y=$(this).scrollTop()*0.0045;
	        var opacityShift = y*1;
	        //alert(y);
	        $("div.menu_hider").css({"opacity":1-opacityShift});
	        if($(this).scrollTop() >= 290){
	        	$("div.menu_hider").css({"pointer-events":"none"});
	        }
	        else{
	        	$("div.menu_hider").css({"pointer-events":"auto"});
	        }
    }); 



});