jQuery(document).ready(function(){

    var $last_selected_time_input = null;

    jQuery(document).on('click','.time_input', function(){
        var $time_input = $(this);
        var $time_selector = $('#time_selector');


        if($time_selector.is(':visible') && $last_selected_time_input.is($time_input)){
            $time_selector.removeClass('active');
            return;
        }



        //Get the position of this time input
        var input_position = $time_input.offset();

        //Set the position of the time selector to underneath this time input
        $time_selector.css({'position': 'absolute'});
        $time_selector.css({'top': (input_position.top + $time_input.height()).toString() + 'px'});
        $time_selector.css({'left': input_position.left.toString() + 'px'});
        $time_selector.css({'z-index': '1000'});
        //Set the time_selector to active
        $time_selector.addClass('active');

        //store the last selected element
        $last_selected_time_input = $time_input;
    });



    jQuery(document).on('click','.time_selector_div',function(){
        var $time_selector_div = $(this);
        var $time_selector = $time_selector_div.closest('#time_selector');

        var time_string = $time_selector_div.attr('data-time');


        //Set 'active' time input field value to the selected time
        $last_selected_time_input.val(time_string_to_am_pm_string(time_string));

        //Set the data attribute to the time_string to make it easy to pull off
        $last_selected_time_input.attr('data-time', time_string);


        //Hide the time selector
        $time_selector.removeClass('active');

    });


    jQuery(document).on('click','',function(){

    });


});