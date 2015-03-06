$(document).ready(function() {


init();


function init(){

    $.getJSON(globals.base_url + '/message/load', {}, function(json_data){
        if(json_data['success']){
            $.each(json_data['messages'], function(index, message_json){
                render_message(message_json);
            });


            //poll(json_data['last_update']);
        }else{
            console.log("Error loading messages");
            console.log(json_data);
        }

    });



}



function poll(last_update){

    var get_url = globals.base_url + '/message/poll';
    var get_data = {last_update: last_update};


    $.ajax({
        dataType: "json",
        async: true,
        url: get_url,
        data: get_data,
        timeout: 10000,
        cache: false
    }).done(function(response){
        console.log('Polling complete.');
        console.log(response);
        if(response['success']){
            $.each(response['messages'], function(index, message_json){
                render_message(message_json);
            });

            poll(response['last_update']);
        }else{
            console.log("Error polling messages");
            console.log(response);
        }
    }).always(poll(last_update));

}


function render_message(message_json){
    var $chat_box = $(".chat_box[data-target_type='" + message_json['target_type'] + "'][data-target_id='" + message_json['target_id'] + "']");

    var source = '';
    if(message_json['user_id'] == globals.user_id){
        source = $('#this_user_message_template').html();
    }else{
        source = $('#other_user_message_template').html();
    }


    var template = Handlebars.compile(source);
    var generated_html = template(message_json);


    $chat_box.find('.chat_box_text').append($(generated_html).hide().fadeIn());
}












$(document).on('keydown', '.chat_input', function(e){
    var $chat_input = $(this);
    var $chat_box = $chat_input.closest('.chat_box');

    var target_type = $chat_box.attr('data-target_type');
    var target_id = $chat_box.attr('data-target_id');

    var text = $chat_input.val();



    var code = e.keyCode || e.which;
    if(code == 13) { //Enter keycode

        var post_url = globals.base_url + '/message/send';


        var post_data = {
            target_type: target_type,
            target_id: target_id,
            text: text
        };

        $.post(
            post_url,
            post_data,
            function(response){
                alert(JSON.stringify(response));


                if(response['success']){
                    render_message(response['message']);
                }else{

                }
            },'json'
        );

    }
});





});