$(document).ready(function(){



    $('.name_search_input').keyup(function(){

        var $people_search_input = $(this);
        var search_string = $people_search_input.val();



        search_string = search_string.toLowerCase();
        console.log(search_string);


        if(search_string !== ''){
            $people_search_input.closest(".tab_content_holder").find(".tab_content").children('div').each(function () {
                var $item = $(this);
                $item.show();
                if($item.data('name').toLowerCase().indexOf(search_string) == -1){
                    $item.hide();
                }
            });
        }else{
            $people_search_input.closest(".tab_content_holder").find(".tab_content").children('div').each(function () {
                var $item = $(this);
                $item.show();
            });
        }

    });



    $('.user_follow_button').click(function(){

        var $user_follow_button = $(this);

        var user_id = $user_follow_button.closest('.members_card_wrapper').attr('data-user_id');



        var $follow_button_wrapper = $user_follow_button.parent('.follow_button_wrapper');

        var verb = '';
        if($follow_button_wrapper.hasClass('unfollow')){
            verb = 'unfollow';
        }else{
            verb = 'follow';
        }


        var post_url = globals.base_url + '/user/' + user_id + '/' + verb;


        alert(post_url);


        var post_data = {user_id:user_id};

        $.post(
            post_url,
            post_data,
            function(response) {
                if(response['success']){

                    if(verb == 'unfollow'){
                        $follow_button_wrapper.removeClass('unfollow');
                        $user_follow_button.removeClass('following');
                        $user_follow_button.text('Follow');
                    }else{
                        $user_follow_button.addClass('following');
                        $user_follow_button.text('Following');
                    }

                }else{
                    alert(JSON.stringify(response));
                }
            }, 'json'
        );




    });


    $('.user_message_button').click(function(){
        alert('MESSAGE');
    });




});
