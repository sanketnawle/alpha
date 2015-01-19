$(document).ready(function(){



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

                update_notifications_div();

                poll_notifications();
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
                    $notifications_button.addClass('notifications');

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

    //Clears the notifications and adds the latest ones
    function update_notifications_div(){
        var $notifications_holder = $notifications.find('.entries');

        $notifications_holder.empty();


        for(var i = 0; i < notifications.length; i++){
            var template = Handlebars.compile(template_source);


            var date = new Date(notifications[i]['created_time']);
            //Database stores datetime's as UTC
            //so always convert the UTC date to local date for the users timezone
            date = utc_to_local(date);

            notifications[i]['formatted_created_time'] = moment(date).fromNow();

            var generated_html = template(notifications[i]);


            $notifications_holder.append(generated_html).hide().fadeIn();
        }
    }




    $(document).on('click', '.notify.board', function(){
        $notifications_button.removeClass('new_notifications');

        var $notify = $('#notifications');



        if($notify.is(":visible")){
            $notify.hide();
        }else{



            $notify.show();
        }

    });














});