$(document).ready(function(){


    $('.nav_section').click(function(){
        var $this_section = $(this);

        //If this nav section is a dropdown, show the drop_down container
        if($this_section.hasClass('drop_down')){
            var $drop_down = $('#nav_drop_down_container');

            if($drop_down.css('display') == 'none'){
                $drop_down.show();
            } else {
                $drop_down.hide();
            }
        }else{
            window.location.replace(base_url + $this_section.attr('data-link_url'));
        }


    });





    $('.nav_arrow').click(function(){
        //Find the section to the left of this arrow
    });

});