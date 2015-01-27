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
        get_reminders();
    }



    var $reminders_button = $('.notify.calendar');

    var reminders = [];


    var $reminders = $('#reminders');



    function get_reminders(){
        $.getJSON(globals.base_url + "/user/reminders", function(json_data){
            if(json_data['success']){
                reminders = json_data['reminders'];
                update_reminders_div();
            }else{
                console.log('Error getting reminders.');
            }
        });
    }




    var template_source = $('#reminder_template').html();
    //Clears the reminders and adds the latest ones
    function update_reminders_div(){
        var $reminders_holder = $reminders.find('.reminder_entries');

        $reminders_holder.empty();



        for(var i = 0; i < reminders.length; i++){
            var template = Handlebars.compile(template_source);




            var end_date = new Date(reminders[i]['end_date']);

            end_date = utc_to_local(end_date);
            reminders[i]['formatted_end_time'] = moment(end_date).fromNow();


            reminders[i]['day_of_week'] = date_to_day_name(end_date);


            reminders[i]['month'] = date_to_month_string(end_date);
            reminders[i]['day'] = end_date.getDate();


            var generated_html = template(reminders[i]);


            $reminders_holder.append(generated_html).hide().fadeIn();
        }



    }






    function position_reminders(){

        //get the noti button
        var $reminders_button = $('.notify.calendar');

        //var $reminders = $('#reminders');
//        $reminders.css({'top': $notification_button.position().top});
//        $reminders.css({'left': $notification_button.position().left});
        $reminders.css({'position': 'absolute'});

        var x = $reminders_button.width();



        var slope = (-172.0 + 134.0)/(45.0 - 120.0);
        var left_position = (slope * x) - 188;
        //alert(left_position); //- $reminders_button.width()
        $reminders.css({'left': left_position });

        //x1     y1
        //120 : -134

        //x2     y2
        //37 : -172





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



    $(document).on('click', '.notify.calendar', function(){
        $reminders_button.removeClass('new_reminders');
        $reminders_button.find('#new_notification_count').text('');



        //Hide the notifications drop down
        $('#notifications').hide();

        position_reminders();




        var $reminders = $('#reminders');



        if($reminders.is(":visible")){
            $reminders.hide();
        }else{
            $reminders.show();

        }

    });














});