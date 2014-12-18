$(document).ready(function(){

    $('.nav_section').click(function(){
        var $this_section = $(this);
        window.location.replace(base_url + $this_section.attr('data-link_url'));
    });


    $('.nav_arrow').click(function(){
        //Find the section to the left of this arrow
    });

});