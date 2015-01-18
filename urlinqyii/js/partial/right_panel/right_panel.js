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
        init();
    });
    function get_group_suggestions_data(base_url, suggest_type,$element_to_replace,group_type){
        var request_url = base_url+"/user/groupSuggestions";
        var request_data;
        var club_id_1 = $(".suggestion_block.group_suggestion.club_suggestion:eq(0)").attr('data-suggestion_id') || -1;
        var club_id_2 = $(".suggestion_block.group_suggestion.club_suggestion:eq(1)").attr('data-suggestion_id') || -1;
        var class_id = $(".suggestion_block.group_suggestion.class_suggestion").attr('data-suggestion_id') || -1;
        if(club_id_1 && club_id_2 && class_id){
            request_data = {suggestion_type: suggest_type,
                previous_club_id_1: club_id_1,
                previous_club_id_2: club_id_2,
                previous_class_id: class_id};
        }else{
            request_data = {suggestion_type: suggest_type};
        }

        var template = Handlebars.compile($('#suggestion_template').html());
        var $suggestion_container = $("#groups_to_join > .suggestion_unit_container")
        $.getJSON(request_url,request_data,function(group_data){
            if($element_to_replace){
                if(group_type == "club"){
                    if(group_data.clubs.length==0){
                        $element_to_replace.remove();
                    }else{
                        $element_to_replace.replaceWith(template(group_data.clubs[0]));
                    }

                }else if(group_type == "class"){
                    if(group_data.class){
                        $element_to_replace.replaceWith(template(group_data.class));
                    }else{
                        $element_to_replace.remove();
                    }
                }

            }else {
                $suggestion_container.empty();
                $.each(group_data.clubs, function (index, club_data) {
                    $suggestion_container.append(template(club_data));
                });
                if(group_data.class){
                    $suggestion_container.append(template(group_data.class));
                }

            }
        });
    }
    function get_user_suggestions_data(base_url, suggest_type, $element_to_replace){
        var request_url = base_url+"/user/userSuggestions";
        var request_data;
        var user_id_1 = $(".suggestion_block.user_suggestion:eq(0)").attr('data-suggestion_id') || -1;
        var user_id_2 = $(".suggestion_block.user_suggestion:eq(1)").attr('data-suggestion_id') || -1;
        if(user_id_1 && user_id_2){
            request_data = {suggestion_type: suggest_type,
                previous_user_id_1: user_id_1,
                previous_user_id_2: user_id_2};

        }else{
            request_data = {suggestion_type: suggest_type};
        }

        var template = Handlebars.compile($('#suggestion_template').html());
        var $suggestion_container = $("#who_to_follow > .suggestion_unit_container");
        $.getJSON(request_url,request_data,function(user_data){
            if($element_to_replace){
                if(user_data.length==0){
                    $element_to_replace.remove();
                }else{
                    $element_to_replace.replaceWith(template(user_data[0]));
                }

            }else{
                $suggestion_container.empty();
                $.each(user_data,function(index,single_user_data){
                    $suggestion_container.append(template(single_user_data));
                });
            }
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
    $(document).on('click','.group_join_button',function(){
        var $group_block = $(this).closest('.suggestion_block');
        var post_url;
        var post_data = {id:$group_block.attr('data-suggestion_id'),user_id:user_id};
        var suggest_type = $('.suggestion_type.active').attr('data-suggestion_type');
        if($group_block.hasClass('club_suggestion')){
            post_url = base_url+"/club/join";
            $.post(post_url,post_data,function(){
                var club_id = $group_block.attr('data-suggestion_id');
                var club_name = $.trim($group_block.find('.suggestion_title').text());
                $('#club_list').append(
                    '<li>'+
                        '<a data-club_id="'+club_id+'" href="http://localhost/alpha/urlinqyii/club/'+club_id+'">' +
                        club_name+'</a>'+
                    '</li>'
                );
                get_group_suggestions_data(base_url,suggest_type,$group_block,"club");
            });
        }else{
            post_url = base_url+"/class/join";
            $.post(post_url,post_data,function(){
                var class_id = $group_block.attr('data-suggestion_id');
                var class_name = $.trim($group_block.find('.suggestion_title').text());
                $('#class_list').append(
                    '<li>'+
                        '<a data-class_id="'+class_id+'" href="http://localhost/alpha/urlinqyii/class/'+class_id+'">' +
                        class_name+'</a>'+
                    '</li>'
                );
                get_group_suggestions_data(base_url,suggest_type,$group_block,"class");
            });
        }
    });
    $(document).on('click','.suggested_user_follow_button',function(){
        var $user_block = $(this).closest('.suggestion_block');
        var post_url = base_url+"/user/follow";
        var post_data = {user_id:$user_block.attr('data-suggestion_id'),from_user_id:user_id};
        var suggest_type = $('.suggestion_type.active').attr('data-suggestion_type');
        post_url
        $.post(post_url,post_data,function(){
            get_user_suggestions_data(base_url,suggest_type,$user_block);
        });

    });
});
