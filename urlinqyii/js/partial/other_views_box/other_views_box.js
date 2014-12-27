$(document).ready(function(){





    //Make the ... prompt appear
    $('#tab_more_button').click(function(e){
        e.stopPropagation();


        var $tab_more_button = $(this);

        var $other_views_box = $('#other_views_box');
        //Check if the popup is already active


        if($other_views_box.hasClass('active')){
            $other_views_box.removeClass('active');
        }else{
            //Get the tab button position
            var tab_more_button_position = $tab_more_button.offset();

            //Position the other_views_box near the tab button
            $other_views_box.css('top', tab_more_button_position['top'] + 40);
            $other_views_box.css('left', tab_more_button_position['left']);


            $other_views_box.addClass('active')
        }
    });



    $("body").click(function(e) {
        // Check for left button
        if (e.button == 0) {
            $('.popup').each(function(){
                $(this).removeClass('active');
            });
        }
    });
});
