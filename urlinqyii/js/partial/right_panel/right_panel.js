$(document).ready(function() {
    $('.suggestion_type').click(function(){
        var $suggestion_type = $(this);
        var suggest_type_value = $suggestion_type.attr('data-suggestion_type');
        //Change active tab
        $('.suggestion_type.active').removeClass('active');
        $suggestion_type.addClass('active');
    });
});