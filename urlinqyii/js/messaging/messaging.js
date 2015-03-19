$(document).ready(function() {
max_chat_boxes = 5;
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







last_send_message_id = 0;



socket.on('user_' + messaging_globals.user_id, function (message_data) {
    //alert(JSON.stringify(message_data));
    console.log("Received msg: ");
    console.log(message_data);

    if(message_data['id'] != last_send_message_id){
        console.log('RENDERING MSG: ' + JSON.stringify(message_data));
        render_message(message_data);
    }else{
        console.log('Not rendering this shit');
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
//;
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




function load_chat_box($chat_box, func){
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


//gets or creates chatbox DOM element
function get_or_create_chat_box(type, id, name){
    var $chat_box = $(".chat_box[data-type='" + type + "'][data-id='" + id + "']");

    if($chat_box.length){
        //alert('returning old chat box');
        return $chat_box;
    }else{
        var chat_box_data = {type: type, id: id, name: name};
        var source = $('#chat_box_template').html();
        var template = Handlebars.compile(source);
        var generated_html = template(chat_box_data);
        var $chat_box = $(generated_html);



        //Position this chatbox taking into consideration
        //the other chatboxes
        var $other_chat_boxes = $('.chat_box');
        //if($other_chat_boxes.length)

        var chat_box_count = $other_chat_boxes.length;





        var right_position = 30 + (chat_box_count * ($other_chat_boxes.first().width() + 10));


        $chat_box.css({'position':'fixed'});
        $chat_box.css({'z-index':'99999999'});
        $chat_box.css({'bottom':'0px'});
        $chat_box.css({'right': right_position.toString() + 'px'});



        //alert("appending chatbox");



        $('body').append($chat_box);

        //Make sure there arent too many chat boxes open
        var $chat_boxes = $('.chat_box');


        var $extra_chat_boxes = $("#extra_chat_boxes");
        if(!$extra_chat_boxes.length){
            var extra_chat_boxes_source = $('#extra_chat_boxes_template').html();
            var extra_chat_boxes_template = Handlebars.compile(extra_chat_boxes_source);
            var extra_chat_boxes_generated_html = extra_chat_boxes_template({});
            $('body').append($(extra_chat_boxes_generated_html));
        }



        if($chat_boxes.length > max_chat_boxes){

            var extra_chat_boxes_right_position = 30 + (max_chat_boxes * ($other_chat_boxes.first().width() + 10));

            //position extra chat boxes div
            $extra_chat_boxes.css({'position': 'fixed'});
            $extra_chat_boxes.css({'z-index':'99999999'});
            $extra_chat_boxes.css({'right': extra_chat_boxes_right_position.toString() + 'px'});
            $extra_chat_boxes.css({'bottom': '0px'});
            //Show the extra chat boxes div
            $extra_chat_boxes.show();




            //Hide chatbox 6 and on
            for(var x = max_chat_boxes; x < $chat_boxes.length; x++){
                var $this_chat_box = $($chat_boxes[x]);
                $this_chat_box.hide();


                var this_chat_box_type = $this_chat_box.attr('data-type');
                var this_chat_box_id = $this_chat_box.attr('data-id');
                var this_chat_box_name = $this_chat_box.attr('data-name');

                //Make sure this extra chat box doesnt already exist
                var $extra_chat_box_check = $('.extra_chat_box[data-type="' + this_chat_box_type + '"][data-id="' + this_chat_box_id + '"]');
                if($extra_chat_box_check.length){
                    //This extra chat box already exists in the list
                    //so skip
                    continue;
                }


                var extra_chat_box_data = {type: this_chat_box_type, id: this_chat_box_id, name: this_chat_box_name};
                //Add this to the xtra chat div
                var extra_chat_box_source = $('#extra_chat_box_template').html();
                var extra_chat_box_template = Handlebars.compile(extra_chat_box_source);
                var extra_chat_box_generated_html = extra_chat_box_template(extra_chat_box_data);


                var $extra_chat_box = $(extra_chat_box_generated_html);


                var $extra_chat_boxes_list = $extra_chat_boxes.find('#extra_chat_boxes_list');

                $extra_chat_boxes_list.append($extra_chat_box);


                //Update the extra chat box count




                $extra_chat_boxes.find('#extra_chat_boxes_count').text(($extra_chat_boxes_list.children('div').length).toString());

                //swap_chat_box($extra_chat_box);
            }


        }else{
            //Hide the extra chat boxes div
            $extra_chat_boxes.remove();
        }



        return $chat_box;

    }

}







$(document).on('click', '.messaging_list_item', function(){
    var $messaging_list_item = $(this);

    var type = $messaging_list_item.attr('data-type');
    var id = $messaging_list_item.attr('data-id');
    var name = $messaging_list_item.attr('data-name');


//load_chat_box($chat_box);


    //Check if this chat is already in the #extra_chat_boxes div
    var $extra_chat_box_check = $('.extra_chat_box[data-type="' + type + '"][data-id="' + id + '"]');
    if($extra_chat_box_check.length){
        //This chat is already in extra chat box, so
        //just swap it with the last chat visible
        swap_chat_box($extra_chat_box_check);
    }else{
        var $chat_box = get_or_create_chat_box(type, id, name);
    }


    //Add this chatbox to page
    //$('#LeftPanel_Holder').append($chat_box);

});



$(document).on('click', '#messaging_panel', function(){

});





function swap_chat_box($extra_chat_box){
    //Find the last chat box
    var $last_chat_box = $($('.chat_box').get(max_chat_boxes - 1));



    var extra_chat_box_type = $extra_chat_box.attr('data-type');
    var extra_chat_box_id = $extra_chat_box.attr('data-id');
    var extra_chat_box_name = $extra_chat_box.attr('data-name');



    var last_chat_box_type = $last_chat_box.attr('data-type');
    var last_chat_box_id = $last_chat_box.attr('data-id');
    var last_chat_box_name = $last_chat_box.attr('data-name');


    //Replace these values
    $last_chat_box.attr('data-type', extra_chat_box_type);
    $last_chat_box.attr('data-id', extra_chat_box_id);
    $last_chat_box.attr('data-name', extra_chat_box_name);

    $extra_chat_box.attr('data-type', last_chat_box_type);
    $extra_chat_box.attr('data-id', last_chat_box_id);
    $extra_chat_box.attr('data-name', last_chat_box_name);

    $extra_chat_box.text(last_chat_box_name);



    //clear the chat box
    $last_chat_box.find('.chat_box_text').empty();

    //load the recent text for this chat
    load_chat_box($last_chat_box);
}

$(document).on('click', '.extra_chat_box', function(e){
    e.stopPropagation();

    //Replace the last chat box with this extra chat box
    var $extra_chat_box = $(this);


    swap_chat_box($extra_chat_box);
});


$(document).on('click', '#extra_chat_boxes', function(){
    //Show the extra chat list

    var $extra_chat_boxes = $(this);

    var $extra_chat_boxes_list = $extra_chat_boxes.find('#extra_chat_boxes_list');

    $extra_chat_boxes_list.toggle();
});



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


    alert("rendering msg: " + JSON.stringify(message_json));

    var $chat_box = get_or_create_chat_box(message_json['target_type'], chat_box_id, message_json['origin']['name']);
    //var $chat_box = $('.chat_box');


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