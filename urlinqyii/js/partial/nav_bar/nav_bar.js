$(document).ready(function(){




    $('.nav_section').mouseenter(function(){
        var $this_section = $(this);

        if($this_section.hasClass('drop_down')){
            var $drop_down = $(this).find('#nav_drop_down_container');
            $drop_down.show();
        }
    });

    $('.nav_section').mouseleave(function(){
        var $this_section = $(this);
        if($this_section.hasClass('drop_down')){
            var $drop_down = $(this).find('#nav_drop_down_container');
            $drop_down.hide();
        }
    });

//    var $this_section = $(this);
//
//    if($this_section.hasClass('drop_down')){
//        var $drop_down = $('#nav_drop_down_container');
//
//        if($drop_down.css('display') == 'none'){
//            $drop_down.show();
//        } else {
//            $drop_down.hide();
//        }
//    }




    $('.nav_section').click(function(){
        var $this_section = $(this);

        //If this nav section is a dropdown, show the drop_down container
        if($this_section.hasClass('drop_down')){
            var $drop_down = $(this).find('#nav_drop_down_container');

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


    $('.nav_drop_down_section').click(function(){
        var $this_drop_down_section = $(this);
        //Get the type of this link from the parent drop down
        var $nav_section = $this_drop_down_section.closest('.nav_section');
        var link_type = $nav_section.attr('data-link_type');
        //Gets the id of what we are trying to link to from this section
        var link_id = $this_drop_down_section.attr('data-id');

//        alert(link_type);
        window.location.replace(base_url + '/' + link_type + '/' + link_id);
    });

    $(function(){
        $('.nav_drop_down_scrollable').slimScroll();
    });



});