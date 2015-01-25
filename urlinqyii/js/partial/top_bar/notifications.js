$ = jQuery;

$(document).ready(function(){
    Handlebars.registerHelper('ifCond', function (v1, operator, v2, options) {

        switch (operator) {
            case '==':
                return (v1 == v2) ? options.fn(this) : options.inverse(this);
            case '===':
                return (v1 === v2) ? options.fn(this) : options.inverse(this);
            case '<':
                return (v1 < v2) ? options.fn(this) : options.inverse(this);
            case '<=':
                return (v1 <= v2) ? options.fn(this) : options.inverse(this);
            case '>':
                return (v1 > v2) ? options.fn(this) : options.inverse(this);
            case '>=':
                return (v1 >= v2) ? options.fn(this) : options.inverse(this);
            case '&&':
                return (v1 && v2) ? options.fn(this) : options.inverse(this);
            case '||':
                return (v1 || v2) ? options.fn(this) : options.inverse(this);
            case '!=':
                return (v1 != v2) ? options.fn(this) : options.inverse(this);
            default:
                return options.inverse(this);
        }
    });


    init();

    function init(){
        get_notifications();
    }


    var notification_timeout_milliseconds = 30000;

    var $notifications_button = $('.notify.board');

    var notifications = [];


    var $notifications = $('#notifications');



    function get_notifications(){
        $.getJSON(globals.base_url + "/user/notifications", function(json_data){
            if(json_data['success']){
                notifications = json_data['notifications'];

                if(notifications.length){
                    update_notifications_div();
                    poll_notifications();
                }

            }else{
                console.log('Error getting notifications.');
            }
        });
    }





    function poll_notifications(){

        var last_notification_id = notifications[0]['notification_id'];

        console.log("last_notification_id = " + last_notification_id);

        $.getJSON(globals.base_url + "/user/newNotifications", {last_notification_id: last_notification_id},function(json_data){

            if(json_data['success']){
                console.log(JSON.stringify(json_data));
                if(json_data['notifications'].length > 0){

                    for(var i = 0; i < json_data['notifications'].length; i++){
                        notifications.unshift(json_data['notifications'][i]);
                    }

                    update_notifications_div();
                }else{
                    console.log('No new notifications');
                }
            }else{
                console.log(JSON.stringify(json_data));
            }

        });


        setTimeout(function() {
            poll_notifications();
        }, notification_timeout_milliseconds);
    }

    var template_source = $('#notification_template').html();


    //Holds the # of new notifications user hasnt viewed yet
    var new_count = 0;

    //Clears the notifications and adds the latest ones
    function update_notifications_div(){
        var $notifications_holder = $notifications.find('.entries');

        $notifications_holder.empty();



        for(var i = 0; i < notifications.length; i++){
            var template = Handlebars.compile(template_source);



            if(notifications[i]['status'] == 'new'){
                new_count++;
            }

            var date = new Date(notifications[i]['created_time']);
            //Database stores datetime's as UTC
            //so always convert the UTC date to local date for the users timezone
            date = utc_to_local(date);

            notifications[i]['formatted_created_time'] = moment(date).fromNow();

            var generated_html = template(notifications[i]);


            $notifications_holder.append(generated_html).hide().fadeIn();
        }


        //Show the new notification count
        if(new_count > 0){
            $notifications_button.addClass('new_notifications');
            $notifications_button.find('#new_notification_count').text(new_count);
        }

    }



    //Passes the notifications id's visible on this page and
    //sets their statuses to 'seen'
    function notifications_seen(){
        var notification_id_list = [];

        for(var i = 0; i < notifications.length; i++){
            notification_id_list.push(notifications[i]['notification_id']);
        }


        var post_url = base_url + '/user/notificationsSeen';

        var post_data = {notification_id_list: notification_id_list};


        $.post(
            post_url,
            post_data,
            function(response){
                alert(JSON.stringify(response));
            }, 'json'
        );
    }




    function position_notifications(){

        //get the noti button
        var $notification_button = $('.notify.board');

        //var $notifications = $('#notifications');
//        $notifications.css({'top': $notification_button.position().top});
//        $notifications.css({'left': $notification_button.position().left});
        $notifications.css({'position': 'absolute'});

        var x = $notifications_button.width();

        var left_position = ((116/83) * x) - 186;

        $notifications.css({'left': left_position});


        // 126 : -20  126/-20 = -6.3

        // 43 : -136 =


    }



    $(document).on('click', '.accept_invite_button', function(){
        var $accept_invite_button = $(this);

        var origin_type = $accept_invite_button.attr('data-origin_type');
        var origin_id = $accept_invite_button.attr('data-origin_id');

        var invite_id = $accept_invite_button.attr('data-invite_id');


        var post_data = {origin_type: origin_type, origin_id: origin_id, invite_id: invite_id};

        var post_url = globals.base_url + '/invite/accept';

        $.post(
            post_url,
            post_data,
            function (response){
                alert(JSON.stringify(response));
            }, 'json'
        );


    });



    $(document).on('click', '.notify.board', function(){
        $notifications_button.removeClass('new_notifications');
        $notifications_button.find('#new_notification_count').text('');
        new_count = 0;


        position_notifications();


        //If the latest notification has not been seen,
        //update notifications to seen

        //first notification
        var first_status = $notifications.find('.entries').children().first().attr('data-status');
        if(first_status == 'new'){
            notifications_seen();
        }



        var $notify = $('#notifications');



        if($notify.is(":visible")){
            $notify.hide();
        }else{
            $notify.show();

            $('#reminders').hide();

            //Loop thru all the notifications that have status "new"
            //and set them to "seen"
            $('.notification[data-status="new"]').each(function(){
                $(this).attr('data-status', 'seen');
            });

        }

    });














});