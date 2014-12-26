$(document).ready(function(){

    $(document).on('click','html',function(){

    });



    //Make the ... prompt appear
    $(document).on('click', '#tab_more_button', function(){
        var $tab_more_button = $(this);
        var $other_views_box = $('#other_views_box');
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
});
