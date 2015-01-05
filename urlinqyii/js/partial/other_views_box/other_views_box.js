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
            $other_views_box.addClass('active'); 
            //Position the other_views_box near the tab button
            


            
            $( "#page" ).scroll(function() {
        //        alert('SCROLL');

                var $page = $(this);
                var scroll_offset_top = $page.scrollTop();
                if(Math.floor(scroll_offset_top) >= 302){
                    var tab_more_button_position = $tab_more_button.offset();
                    $other_views_box.css("position","fixed");
                    $other_views_box.css('margin-left','0px');
                }

                else{
                    $other_views_box.css("position","absolute");
                    $other_views_box.css('margin-left','0px');
               }


            }); 
                       
        }


    });

    $('a#settings_link').mouseover(function(){
        $(this).closest("#other_views_box").addClass("top_row_hover");
    });

    $('a#settings_link').mouseleave(function(){
        $(this).closest("#other_views_box").removeClass("top_row_hover");
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
