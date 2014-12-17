
$(document).ready(function(){

    $('.tab').click(function(){
        var $tab = $(this);
        var panel_id = $tab.attr('data-panel_id');
        //Change active tab
        $('.tab.active').removeClass('active');
        $tab.addClass('active');


        //Find the current active panel and remove its active class
        $('.panel.active').removeClass('active');
        $('#panel_' + panel_id).addClass('active');
    });


    $( "#page" ).scroll(function() {
//        alert('SCROLL');

        var $page = $(this);

        var $tab_bar = $('#tab_bar');

        //$tab_bar_position.left + ", top: " + $tab_bar_position.top
        var tab_bar_width = '100%';
        //alert(tab_bar_position.top);

        var scroll_offset_top = $page.scrollTop();
        console.log("OFFSET");
        console.log(scroll_offset_top);
//        alert(scroll_offset_top);

        var y = $page.scrollTop()*0.32;
        var x = $page.scrollTop() * 1;


        //Get the width of the content panel. The bar should always be the same width
        //as content panel
        var content_panel_width = $("#content_panel").width();


        if(Math.floor(scroll_offset_top) >= 261){

            console.log("SETTING TO FIXED");
            $tab_bar.css({position: 'fixed', top: '87px',width: content_panel_width});
            //alert(y);
            //$("#cover_photo").css({"transform":"translateY("+ -y+"px)"});



            //            $(".em_hide").css({
            //                "width":"12px",
            //                "opacity":"1"
            //            });

            $tab_bar.css({'transition': 'background-color 0.1s ease'});


            $tab_bar.css({'background-color': 'rgba(18, 19, 20, 1)'});



        }else if(Math.floor(scroll_offset_top) <= 260){
            console.log("SETTING TO RELATIVE");
            //$tab_bar.css({position: 'relative', top: '0',width: tab_bar_width});
//            $("#cover_photo").css({"transform":"translateY("+ y+"px)"});

            $tab_bar.css({position: 'relative', top: '-57px',width: content_panel_width});

            $tab_bar.css({'background-color': 'rgba(18, 19, 20, 0.9)'});
            //$("#cover_photo").css({"transform":"translateY("+y+"px)"});


        }


        //alert(y);

    });



    //Handles the member leave/join/follow button
    $('#group_user_action_button').mouseenter(function(){
        var $action_button = $(this);
        if($action_button.hasClass('member')){
            $action_button.find("#group_user_action_button_text").text('Leave');
        }
    });

    $('#group_user_action_button').mouseleave(function(){
        var $action_button = $(this);
        if($action_button.hasClass('member')){
            $action_button.find("#group_user_action_button_text").text('Member');
        }
    });


    //$('#create_todo_form').submit(function (e) {
    $(document).on('click','#create_todo_form',function(e){
        //Send post request to event/create
        e.preventDefault();

        //alert($('.event_date').val());

        var $form = $(this);
        var post_url = $form.attr('action');
        var post_data = $(this).serializeArray();
        var errors = [];

        var todo_name = $('#event_name').val();

        //Check if user input a name for todo
        if($('#event_name').val().length == 0){
            errors.push({name:'event_name_error',value:'You must give a name for this todo'});
        }

        //Make sure the date is converted to UTC before passing to database
        var todo_date = new Date($('.event_date').attr('data-date'));
        todo_date = local_to_utc(todo_date);
        todo_date = todo_date.getUTCFullYear().toString() + "-" + (todo_date.getMonth()+ 1).toString() + "-" + todo_date.getDate().toString();

        var todo_time = $('.event_time').attr('data-time');


        if(errors.length > 0){
//        alert(JSON.stringify(errors));
            $('#new_listing_text').text(JSON.stringify(errors));
            return false;
        }

        post_data = { todo_name: todo_name, todo_date: todo_date, todo_time: todo_time, origin: origin, origin_id: origin_id};
        //alert(JSON.stringify(post_data));
        $.post(
            post_url,
            post_data,
            function(response) {
                if(response['success']){
                    //alert(JSON.stringify(response));
                    add_event(response['event']);
                    //show_event(response['event'],'#todays_events');
                }else{
                    alert(JSON.stringify(response));
                }
            }, 'json'
        );
    });


});
