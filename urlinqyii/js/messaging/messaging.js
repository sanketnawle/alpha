$(document).ready(function() {

// create object
var socket = new YiiNodeSocket();

// enable debug mode
socket.debug(true);

socket.on('*', function (data) {
    console.log(data);
});
socket.on('event.example', function (data) {
    console.log(data);
});

socket.on('message', function (data) {
    console.log('RECEIVING DATA: ');
    console.log(data);
});

socket.on('user_' + globals.user_id, function (data) {
    alert('DATA FROM THIS USER SOCKETT');
    console.log(alert(JSON.stringify(data))); // you will see in console `This is a test message`
});


//
//socket.on('connect', function(socket) {
//    console.log("CONNECTED TO SOCKET.IO");
//
//
//    socket.on('user_' + globals.user_id, function (data) {
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





function init(){







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
        type:"GET",
        dataType: "json",
        async: true,
        url: get_url,
        data: get_data,
        timeout: 1000000,
        cache: false,

        success: function(response) {
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
        },
        error: function(){
           console.log("ERROR POLLING MESSAGES");
        }
    });



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



        $.ajax({
            type:"POST",
            dataType: "json",
            async: true,
            url: post_url,
            data: post_data,
            cache: false,

            success: function(response) {
                alert(JSON.stringify(response));

                if(response['success']){
                    render_message(response['message']);
                }else{

                }
            },
            error: function(){
               console.log("ERROR SENDING MESSAGE");
            }
        });

    }
});





});