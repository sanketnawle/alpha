jQuery(document).ready(function(){




    jQuery(document).on('keyup','.time_input', function(){
        var $time_input = $(this);
        var time_input_string = $time_input.val();
        if(time_input_string == ''){
            if($time_input.hasClass('error')){
                $time_input.removeClass('error');
            }
        }
    });


    //Takes in the time_input div object
    function update_time_input($time_input){

        var time_input_string = $time_input.val();
        console.log('time input string: ' + time_input_string);


        if($time_input.hasClass('error')){
            $time_input.removeClass('error');
        }

        //Formatted time string
        //This will be stored as the data attribute of the time input
        //for ez access
        var time = '00:00:00';


        if(time_input_string == ''){
            $time_input.attr('data-time',time);
            return;
        }


        //Check if this time looks like
        // 12:00pm or 1:30am
        var regex_match = time_input_string.match(/([1-9]|1[0-2]):[0-9][0-9](pm|am)/g);
        if(regex_match){
            console.log('REGEX MATCHES 12:00pm');

            var res = time_input_string.split(":");
            var hours = parseInt(res[0]);
            var minutes = res[1].substring(0,2);
            var am_pm = res[1].substring(2,res[1].length);

            if(hours < 12 && am_pm == 'pm'){
                hours += 12;
            }else if(hours == 12 && am_pm == 'am'){
                hours = 0;
            }

            if(hours.toString().charAt(0) == '0'){
                hours = hours.toString().charAt(1);
            }

            if(minutes.toString().charAt(0) == '0'){
                minutes = minutes.toString().charAt(1);
            }

            //The start time is now in SQL time format
            // 00:00:00
            time = addZero(hours) + ':' + addZero(minutes) + ':00';
            $time_input.attr('data-time',time);
            return;
        }


        //Check if this time is just an hour with am or pm
        //like 9am or 12pm
        var regex_match = time_input_string.match(/([1-9]|1[0-2])(pm|am)/g);
        if(regex_match){
            console.log('REGEX MATCHES 9am');
            time = time_input_string;
            am_pm = time.substring(time.length - 2,time.length);
            hours = parseInt(time.substring(0,time.length - 2));


            if(hours < 12 && am_pm == 'pm'){
                hours += 12;
            }else if(hours == 12 && am_pm == 'am'){
                hours = 0;
            }

            if(hours.toString().charAt(0) == '0'){
                hours = hours.toString().charAt(1);
            }


            //The start time is now in SQL time format
            // 00:00:00
            time = addZero(hours) + ':00:00';
            $time_input.attr('data-time',time);
            return;
        }




        if(time_input_string.indexOf(':') < 0){
            //Check if this time is just a number
            //default it to am
            //like 9 or 11 -> 9am or 11am
            var regex_match = time_input_string.match(/([1-9]|1[0-2])/g);
            if(regex_match){
                console.log('REGEX MATCHES 9am');
                time = time_input_string;
                hours = parseInt(time);

                //The start time is now in SQL time format
                // 00:00:00
                time = addZero(hours) + ':00:00';
                $time_input.attr('data-time',time);

                //Set add the AM to the input so users are encouraged to just type it next time
                $time_input.val(hours.toString() + 'am');

                return;
            }
        }




        //If it didnt match any of those, show this input as an error
        //$time_input.addClass('error');
    }

    jQuery(document).on('focusout','.time_input', function(){
        update_time_input($(this));
    });

    jQuery(document).on('click','.time_input', function(){
        update_time_input($(this));
    });


    jQuery(document).on('scroll','.time_input', function(e){
        e.stopPropagation();
    });


    $( "#page" ).scroll(function() {
        console.log('WINDOW SCROLL');
        $('#time_selector').removeClass('active');
    });

//    jQuery(document).on('keyup','.time_input', function(){
//        update_time_input($(this));
//    });




    var $last_selected_time_input = null;

    jQuery(document).on('click','.time_input', function(e){

        e.stopPropagation();
        var $time_input = $(this);
        var $time_selector = $('#time_selector');


        if($time_selector.is(':visible') && $last_selected_time_input.is($time_input)){
            $time_selector.removeClass('active');
            return;
        }





        //Close the time input if there is one
        try{
            $('#calLayer').hide();
        }catch(err){
            console.log('Clicked time_input with no calLayer to hide');
        }


        //Get the position of this time input
        var input_position = $time_input.offset();

        //Set the position of the time selector to underneath this time input
        $time_selector.css({'position': 'absolute'});
        $time_selector.css({'top': (input_position.top + $time_input.height()).toString() + 'px'});
        $time_selector.css({'left': input_position.left.toString() + 'px'});
        $time_selector.css({'z-index': '9999'});
        //Set the time_selector to active
        $time_selector.addClass('active');

        //store the last selected element
        $last_selected_time_input = $time_input;
    });



    jQuery(document).on('click','.time_selector_div',function(e){
        e.stopPropagation();

        var $time_selector_div = $(this);
        var $time_selector = $time_selector_div.closest('#time_selector');

        var time_string = $time_selector_div.attr('data-time');

        //Set 'active' time input field value to the selected time
        $last_selected_time_input.val(time_string_to_am_pm_string(time_string));


        //alert(time_string_to_am_pm_string(time_string));

        //Set the data attribute to the time_string to make it easy to pull off
        $last_selected_time_input.attr('data-time', time_string);


        //Hide the time selector
        $time_selector.removeClass('active');

    });




    jQuery(document).on("click", function() {
        var $time_selector = $('#time_selector');
        //Hide the selector
        $time_selector.removeClass('active');
    });


    jQuery(document).on('keydown','.time_input', function(){
        var $time_selector = $('#time_selector');
        //Hide the selector
        $time_selector.removeClass('active');
    });





});