$(document).ready(function() {
    init();
    function init(){
        var suggest_type = $('.suggestion_type.active').attr('data-suggestion_type');
        get_group_suggestions_data(base_url, suggest_type);
        get_user_suggestions_data(base_url, suggest_type);
    }
    $('.suggestion_type').click(function(){
        var $suggestion_type = $(this);
        var suggest_type_value = $suggestion_type.attr('data-suggestion_type');
        //Change active tab
        $('.suggestion_type.active').removeClass('active');
        $suggestion_type.addClass('active');
    });
    function get_group_suggestions_data(base_url, suggest_type){
        var request_url = base_url+"/user/groupSuggestions";
        var request_data;
        var class_id_1 = $(".suggestion_block.group_suggestion:eq(0)").attr('data-suggestion_id');
        var class_id_2 = $(".suggestion_block.group_suggestion:eq(1)").attr('data-suggestion_id');
        var club_id = $(".suggestion_block.group_suggestion:eq(2)").attr('data-suggestion_id');
        if(class_id_1 && class_id_2 && club_id){
            request_data = {suggestion_type: suggest_type,
                previous_class_id_1: class_id_1,
                previous_class_id_2: class_id_1,
                previous_club_id: club_id};
        }else{
            request_data = {suggestion_type: suggest_type};
        }

        var template = Handlebars.compile($('#suggestion_template').html());
        var $suggestion_container = $("#groups_to_join > .suggestion_unit_container")
        $.getJSON(request_url,request_data,function(group_data){
            $suggestion_container.empty();
            $.each(group_data.classes,function(index,class_data){
                $suggestion_container.append(template(class_data));
            });
            $suggestion_container.append(template(group_data.club));
        });
    }
    function get_user_suggestions_data(base_url, suggest_type){
        var request_url = base_url+"/user/userSuggestions";
        var request_data;
        var user_id_1 = $(".suggestion_block.user_suggestion:eq(0)").attr('data-suggestion_id');
        var user_id_2 = $(".suggestion_block.user_suggestion:eq(1)").attr('data-suggestion_id');
        if(user_id_1 && user_id_2){
            request_data = {suggestion_type: suggest_type,
                previous_user_id_1: user_id_1,
                previous_user_id_2: user_id_2};

        }else{
            request_data = {suggestion_type: suggest_type};
        }

        var template = Handlebars.compile($('#suggestion_template').html());
        var $suggestion_container = $("#who_to_follow > .suggestion_unit_container")
        $.getJSON(request_url,request_data,function(user_data){
            $suggestion_container.empty();
            $.each(user_data,function(index,class_data){
                $suggestion_container.append(template(class_data));
            });
        });
    }
    $(document).on('click','#groups_refresh',function(){
        var suggest_type = $('.suggestion_type.active').attr('data-suggestion_type');
        get_group_suggestions_data(base_url, suggest_type);
    });
    $(document).on('click','#users_refresh',function(){
        var suggest_type = $('.suggestion_type.active').attr('data-suggestion_type');
        get_user_suggestions_data(base_url, suggest_type);
    });
});