/*
 * # Pulser Animation- Kuan Wang
 *
 * Copyright 2014 
 *
 */

(function ($) {

$.fn.pulse = function( my_pulser, options) {

	var compensation = $.extend({
	x: 0,
	y: 0
	}, options );

    
    var init_position_x= my_pulser.first().offset().left;
    var init_position_y= my_pulser.first().offset().top;

    var total= this.length;
    return this.each(function(index) {
    	var obj= $(this);
    	var $new_pulser= my_pulser.first().clone();

    	var dest_position_x= obj.offset().left+compensation.x;
     	var dest_position_y= obj.offset().top+compensation.y;

     	$new_pulser.offset({ top: init_position_y, left: init_position_x });
     	obj.append($new_pulser);
     	$new_pulser.animate({ "top": dest_position_y+"px","left": dest_position_x+"px" }, 1400, "swing" );

     	if(index==total-1){my_pulser.remove();}
    	
    });
};

}(jQuery));

