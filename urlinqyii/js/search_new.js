
$(document).ready(function() {
    $(".slide").each(function( index ) {
        var x= 185*index;
        
        var para= "matrix(1,0,0,1,"+x+",0)";
        $(this).css({"transform":para,"-webkit-transform":para});
    });

    var matrix_x = 0;
    $(document).delegate(".ar_right","click",function(){

        if(matrix_x <=0){
            matrix_x = matrix_x - 660;
            var SliderMatrix= "matrix(1,0,0,1,"+matrix_x+",0)";
            $(".ContentSlider").css({"transform":SliderMatrix,"-webkit-transform":SliderMatrix});
            $(".arrow_prev").removeClass("arrow_disabled");
            $(".ar_left").removeClass("ar_disabled");
        }
    });

    $(document).delegate(".ar_left","click",function(){

        if(matrix_x <0){
            matrix_x = matrix_x + 660;
            var SliderMatrix= "matrix(1,0,0,1,"+matrix_x+",0)";
            $(".ContentSlider").css({"transform":SliderMatrix,"-webkit-transform":SliderMatrix});
            if(matrix_x == 0){
                    $(".arrow_prev").addClass("arrow_disabled");
                    $(".ar_left").addClass("ar_disabled");
            }   
        }
    });

    $("#page").scroll(function() {
        var y=$(this).scrollTop()*0.0072;
        var opacityShift = y*1;
        //alert(y);
        $(".horizontal_scroll_holder").css({"opacity":1-opacityShift});
    }); 

    $('.filter_section').click(function(){

        var $filter = $(this);
        var filter_id = $filter.attr('data-filter_id');
        //Change active tab
        $('.filter_section.active').removeClass('active');
        $filter.addClass('active');
        if($(this).hasClass("not_members_all_filter")){
            $("#page").removeClass("page_search_all_members_results");
            $('#page').animate({ scrollTop: 0 }, 0);
        }
        else{
            $("#page").addClass("page_search_all_members_results");
            $('#page').animate({ scrollTop: 0 }, 0);
        }

    });    
    $('.user_follow_button').mouseenter(function(){
        var $follow_button = $(this);
        var $follow_button_container = $(this).parent();
        if($follow_button.hasClass('following')){
            $follow_button.text('Unfollow');
            $follow_button_container.addClass("unfollow");
        }
    });

    $('.user_follow_button').mouseleave(function(){
        var $follow_button = $(this);
        var $follow_button_container = $(this).parent();
        if($follow_button.hasClass('following')){
            $follow_button.text('Following');
            $follow_button_container.removeClass("unfollow");
        }
    });








    $(document).on('click', '.user_follow_button', function(){

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



});
