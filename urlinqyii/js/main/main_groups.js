$(document).ready(function(){

	$( "#page" ).scroll(function() {
		var $page = $(this);
		var $nav_bar_wedge = $('#nav_down_arrow');
		var $nav_text = $('.nav_section.drop_down .nav_text');
        var $nav_bar_dropdown = $('#nav_drop_down_container');
        var scroll_offset_top = $page.scrollTop();

        if(Math.floor(scroll_offset_top) >= 59){
        	$nav_bar_wedge.fadeOut();
            $nav_bar_dropdown.css({"visibility":"hidden"});
            $nav_text.css({"color":"#999!important"});
            $nav_text.css({"cursor":"default!important"});

        }
        if(Math.floor(scroll_offset_top) <= 59){
        	$nav_bar_wedge.fadeIn();
        	$nav_bar_dropdown.css({"visibility":"initial"});
            $nav_text.css({"color":"#999"});
            $nav_text.css({"cursor":"cursor"});        	
        }        
	});

});