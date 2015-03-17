$(document).ready(function() {

    //alert(JSON.stringify(messaging_globals));
// create object
var socket = new YiiNodeSocket();

// enable debug mode
socket.debug(true);

//socket.on('*', function (data) {
//    console.log(data);
//});
//socket.on('event.example', function (data) {
//    console.log(data);
//});

//socket.on('message', function (data) {
//    console.log('RECEIVING DATA: ');
//    console.log(data);
//});

socket.on('user_' + messaging_globals.user_id, function (message_data) {
    //alert(JSON.stringify(message_data));
    console.log("Received msg: ");
    console.log(message_data);
    if(message_data['id'] != last_send_message_id){
        render_message(message_data);
    }
});




//
//
//
//
//socket.on('custom_1', function (message_data) {
//    alert(message_data);
//    //alert('DATA FROM THIS USER SOCKETT');
////    alert(JSON.stringify(message_data)); // you will see in console `This is a test message`
//
//    render_message(message_data);
//
//
//});
//










//
//socket.on('connect', function(socket) {
//    console.log("CONNECTED TO SOCKET.IO");
//
//
//    socket.on('user_' + messaging_globals.user_id, function (data) {
//        alert('DATA FROM THIS USER SOCKETT');
//        console.log(data.message); // you will see in console `This is a test message`
//    });
//
//
//    socket.on('message', function (data) {
//        console.log('RECEIVING DATA: ');
//        console.log(data);
//    });
//
//
//    socket.emit('global.event', {
//        message : {
//            id : 12,
//            title : 'This is a test message'
//        }
//    });
//
//    socket.on('global.event', function (data) {
//        console.log(data.message); // you will see in console `This is a test message`
//    });
//
//
//
//
//});
//



init();

//Renders user/group in the messaging panel
function render_messaging_list_item(item_json){

    var source = $('#messaging_list_item_template').html();


    var template = Handlebars.compile(source);
    var generated_html = template(item_json);


    //alert(generated_html);


    //alert('RENDERING MESSAGE: ' + JSON.stringify(message_json));
    if(item_json['recent']){
        $('#messaging_list_recent').append($(generated_html));
    }else{
        $('#messaging_list_' + item_json['type']).append($(generated_html));
    }

}


function init(){


    //Get the users and groups this user can message
    $.getJSON(messaging_globals.base_url + '/message/loadout', function(json_data){
        //Populate message panel with these users/groups
        if(json_data['success']){
            //Loop through the recent chats
             //Loop through the recent chats
            $.each(json_data['recent'], function(index, item_json){
                item_json['recent'] = true;
                render_messaging_list_item(item_json);
            });



            $.each(json_data['users'], function(index, user_json){
                user_json['id'] = user_json['user_id'];
                user_json['type'] = 'user';
                if(user_json['user_type'] == 'p'){
                    user_json['type'] = 'professor';
                }
                render_messaging_list_item(user_json);
            });




        }else{

        }
    });








//    var socket = new YiiNodeSocket();
//    // catch global event
//    socket.on('test.event', function () {
//        console.log('Trigger test.event, is a global event, for all clients');
//        console.log(arguments);
//    });
//
//    // catch room event
//    socket.room('testRoom').join(function (isConnected, numberOfRoomClients) {
//        if (isConnected) {
//            // catch test.event only for this rooom
//            this.on('test.event', function () {
//                 console.log('arguments');
//            });
//        }
//    });


    //Load recent messages for the active chats

    $('.chat_box').each(function(){
        load_chat_box($(this));
    });


}


//gets or creates chatbox DOM element
function get_or_create_chat_box(type, id){
    var $chat_box = $(".chat_box[data-type='" + type + "'][data-id='" + id + "']");

    if($chat_box.length){
        return $chat_box;
    }else{
        var chat_box_data = {type: type, id: id};
        var source = $('#chat_box_template').html();
        var template = Handlebars.compile(source);
        var generated_html = template(chat_box_data);
        var $chat_box = $(generated_html);
        load_chat_box($chat_box);
        $('#LeftPanel_Holder').append($chat_box);
        return $chat_box;
    }
}







$(document).on('click', '.messaging_list_item', function(){
    var $messaging_list_item = $(this);

    var type = $messaging_list_item.attr('data-type');
    var id = $messaging_list_item.attr('data-id');



    var $chat_box = get_or_create_chat_box(type, id);

    //Add this chatbox to page
    $('#LeftPanel_Holder').append($chat_box);

});



$(document).on('click', '#messaging_panel', function(){

});



function load_chat_box($chat_box){
    var target_id = $chat_box.attr('data-id');
    var target_type = $chat_box.attr('data-type');



    $.getJSON(messaging_globals.base_url + '/message/recentChat', {target_id: target_id, target_type: target_type}, function(json_data){
        if(json_data['success']){
            $.each(json_data['messages'], function(index, message_json){
                render_message(message_json);
            });

            $('.chat_box_text').scrollTop(2000);


            //poll(json_data['last_update']);
        }else{
            console.log("Error loading messages");
            console.log(json_data);
        }

    });
}



//function poll(last_update){
//
//    var get_url = messaging_globals.base_url + '/message/poll';
//    var get_data = {last_update: last_update};
//
//
//
//
//    $.ajax({
//        type:"GET",
//        dataType: "json",
//        async: true,
//        url: get_url,
//        data: get_data,
//        timeout: 1000000,
//        cache: false,
//
//        success: function(response) {
//            console.log('Polling complete.');
//            console.log(response);
//            if(response['success']){
//                $.each(response['messages'], function(index, message_json){
//                    render_message(message_json);
//                });
//
//                poll(response['last_update']);
//            }else{
//                console.log("Error polling messages");
//                console.log(response);
//            }
//        },
//        error: function(){
//           console.log("ERROR POLLING MESSAGES");
//        }
//    });
//
//
//
//}





function render_message(message_json){

    var chat_box_id = message_json['user_id'];

    //If this is an outbound message,
    //use the target_id to select the chatbox
    if(chat_box_id == messaging_globals.user_id){
        chat_box_id = message_json['target_id'];
    }



    //var $chat_box = get_or_create_chat_box(message_json['target_type'], chat_box_id);
    var $chat_box = $('.chat_box');


    var $chat_box_text = $chat_box.find('.chat_box_text');
    var $chat_message_wrap = $chat_box.find('.chat_message_wrap');


    var source = '';
    if(message_json['user_id'] == messaging_globals.user_id){
        source = $('#this_user_message_template').html();
    }else{
        source = $('#other_user_message_template').html();
    }


    var template = Handlebars.compile(source);
    var generated_html = template(message_json);


    //alert('RENDERING MESSAGE: ' + JSON.stringify(message_json));

    $chat_message_wrap.append($(generated_html));


}








var last_send_message_id = null;



$(document).on('keyup', '.chat_input', function(e){
    var $chat_input = $(this);
    var $chat_box = $chat_input.closest('.chat_box');

    var target_type = $chat_box.attr('data-type');
    var target_id = $chat_box.attr('data-id');

    var text = $chat_input.val();



    var code = e.keyCode || e.which;
    if(code == 13) { //Enter keycode

        var post_url = messaging_globals.base_url + '/message/send';


        var post_data = {
            target_type: target_type,
            target_id: target_id,
            text: text
        };


        $chat_input.val('');


//        socket.emit('message', {
//            message : {
//                id : 12,
//                text : text
//            }
//        });
//
//        socket.emit('event.example', {
//            message : {
//                id : 12,
//                text : text
//            }
//        });

        $.post(
            post_url,
            post_data,
            function(response){
                if(response['success']){
                    last_send_message_id = response['message']['id'];
                    console.log(response['message']);
                    render_message(response['message']);
                    $chat_input.val('');
                }else{

                }
            },'json'
        );


    }
});





});