$(document).ready(function() {
    
    // Now we deal with removing active class from tab from 'tab_bar' and adding 'active' to other_view_tab
    $('.other_views_tab').click(function(){
        var other_views_tab = $(this);
        var panel_id        = other_views_tab.attr('data-panel_id');
  
        //Change active tab
        $('.tab.active').removeClass('active');
        $('.other_views_tab.active').removeClass('active');
        other_views_tab.addClass('active');


        //Find the current active panel and remove its active class
        $('.panel.active').removeClass('active');
        $('#panel_' + panel_id).addClass('active');
    });
    
    
    $('.row').hover(
    	function() {
	    	$(this).css("background-color","#fafafa");
	    	$(this).children('.admins_delete').css("visibility","visible");  
	    	$(this).children('.edit').children('.edit_img').css("visibility","visible");	
	    },
	    function() {
	   		$(this).css("background-color","#ffffff");
	   		$(this).children('.admins_delete').css("visibility","hidden");
	   		$(this).children('.edit').children('.edit_img').css("visibility","hidden");
	    }
    );
    
    // Display radio Buttons for settings
    $('.admin_settings').children('.row').click(function() {
    	if ($(this).children(".status").children('.status_form').hasClass("active") == false) {
	    	$(this).children(".status").children('.status_form').addClass("active");
	    	$(this).children(".status").children('.status_form').css("display","block");
	    }
	    else {
		    $(this).children(".status").children('.status_form').removeClass("active");
		    $(this).children(".status").children('.status_form').css("display","none");
	    }
    });
    
    
    // Adjsut display text to whatever is checked
/*     checkForms(); */
/*     function checkForms() { */
/* 	    var form1 = $(') */
/*     } */


    
});
