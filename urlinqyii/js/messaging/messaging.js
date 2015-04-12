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





fullscreen = false;


//Determine if user is on /messaging\

if(document.URL.indexOf("/messages") > -1){
    fullscreen = true;
}



last_send_message_id = 0;



socket.on('user_' + messaging_globals.user_id, function (message_data) {

    try{
        //alert(JSON.stringify(message_data));
        console.log("Received msg: ");
        console.log(message_data);

        if(message_data['id'] != last_send_message_id){
            console.log('RENDERING MSG: ' + JSON.stringify(message_data));
            handle_render_message(message_data);
        }else{
            console.log('Not rendering this shit');
        }
    }catch(err){
        console.log('ERROR IN USER SOCKET LISTENER');
        console.log(err);   
    }
    


});




//
//
//
//

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

//            if(fullscreen){
//                //Click the first messaging_list_item
//                $('.messaging_list_item').get(0).click();
//            }


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
    //alert($.cookie('chat'));


    if(fullscreen){


    }else{


        $chat_cookie = $.cookie('chat');
        

        if($chat_cookie){
            var chat_data = JSON.parse($chat_cookie);


            for(var x = 0; x < chat_data['chat_boxes'].length; x++){
                var this_chat_data = chat_data['chat_boxes'][x];
                get_or_create_chat_box(this_chat_data['type'], this_chat_data['id'], this_chat_data['name']);
            }


            for(var i = 0; i < chat_data['extra_chat_boxes'].length; i++){
                var this_extra_chat_data = chat_data['extra_chat_boxes'][i];
                get_or_create_chat_box(this_extra_chat_data['type'], this_extra_chat_data['id'], this_extra_chat_data['name']);
            }    
        }

        
    }




}



function save_chat_cookie(){


    var chat_box_data = {
        'chat_boxes': [

        ],
        'extra_chat_boxes': [

        ]
    };


    //Get the current open chat_boxes
    var $chat_boxes = $(".chat_box");

    $chat_boxes.each(function(){
        var $this_chat_box = $(this);

        //Check if this chat_box is tabbed
        var tabbed = false;

        if($this_chat_box.hasClass('tabbed')){
            tabbed = true;
        }

        var this_chat_box_data = {
            type: $this_chat_box.attr('data-type'),
            id: $this_chat_box.attr('data-id'),
            name: $this_chat_box.attr('data-name'),
            tabbed: tabbed
        };


        chat_box_data['chat_boxes'].push(this_chat_box_data);
    });




    var $extra_chat_boxes = $('.extra_chat_box');

    $extra_chat_boxes.each(function(){
        var $this_extra_chat_box = $(this);


        var this_extra_chat_box_data = {
            type: $this_extra_chat_box.attr('data-type'),
            id: $this_extra_chat_box.attr('data-id'),
            name: $this_extra_chat_box.attr('data-name')
        };

        chat_box_data['extra_chat_boxes'].push(this_extra_chat_box_data);

    });



    //Save this chat box data dict as a json string
    $.cookie('chat', JSON.stringify(chat_box_data), { expires : 5 });

}


function clear_chat_box($chat_box){
    $chat_box.find('.chat_message_wrap').text('');
}




//Func is optional. Look at handle_render_message for structure
function load_chat_box($chat_box, func){
    var target_id = $chat_box.attr('data-id');
    var target_type = $chat_box.attr('data-type');



    $.getJSON(messaging_globals.base_url + '/message/recentChat', {target_id: target_id, target_type: target_type}, function(json_data){
        if(json_data['success']){


            if(fullscreen){
                var $chat_box_panel = $('#chat_panel');

                $.each(json_data['messages'], function(index, message_json){
                    render_message(message_json,$chat_box_panel);
                });
            }else{
                $.each(json_data['messages'], function(index, message_json){
                    handle_render_message(message_json);
                });
            }




            $('.chat_box_text').scrollTop(2000);



            try{
                func();
            }catch(err){
                //console.log(err);
            }

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
        return {'chat_box': $chat_box, 'existed': true};
    }else{
        var chat_box_data = {type: type, id: id, name: name};

        //alert('CREATING: ' + JSON.stringify(chat_box_data));


        var source = $('#chat_box_template').html();
        var template = Handlebars.compile(source);
        var generated_html = template(chat_box_data);
        var $chat_box = $(generated_html);



        //If there is an extra chat box of this type, remove it
        var $extra_chat_box_check = $(".extra_chat_box[data-type='" + type + "'][data-id='" + id + "']");
        if($extra_chat_box_check.length){
            $extra_chat_box_check.remove();
        }

        $('body').append($chat_box);

        position_chat_boxes();

        load_chat_box($chat_box);



        if(type != 'user'){
            //Start listening for messages on this group channel
            //socket.on(type + '_' + id, group_chat_function);


            //Only attach new listener if one doesnt exist already
            if(!socket.room_exists(type + '_' + id)){
                //alert("ATTATCHING CUSTOM SOCKET LISTENER");
                socket.room(type + '_' + id).join(group_chat_function);
            }




        }



        save_chat_cookie();



        return {'chat_box': $chat_box, 'existed': false};

    }

}

function position_chat_boxes(){
    //Make sure there arent too many chat boxes open
    var $chat_boxes = $('.chat_box');


    //Loop thru all chat boxes and position them
    for(var i = 0; i < $chat_boxes.length; i++){
        var $this_chat_box = $($chat_boxes.get(i));
        //Position this chatbox taking into consideration
        //the other chatboxes
        var $other_chat_boxes = $('.chat_box');

        var right_position = 30 + (i * ($other_chat_boxes.first().width() + 10));


        $this_chat_box.css({'position':'fixed'});
        $this_chat_box.css({'z-index':'99999999'});
        $this_chat_box.css({'bottom':'0px'});
        $this_chat_box.css({'right': right_position.toString() + 'px'});
    }




    var $extra_chat_boxes = $("#extra_chat_boxes");
    if(!$extra_chat_boxes.length){
        var extra_chat_boxes_source = $('#extra_chat_boxes_template').html();
        var extra_chat_boxes_template = Handlebars.compile(extra_chat_boxes_source);
        var extra_chat_boxes_generated_html = extra_chat_boxes_template({});
        $('body').append($(extra_chat_boxes_generated_html));
    }


    if($chat_boxes.length > max_chat_boxes){

        var extra_chat_boxes_right_position = 30 + (max_chat_boxes * ($chat_boxes.first().width() + 10));

        //position extra chat boxes div
        $extra_chat_boxes.css({'position': 'fixed'});
        $extra_chat_boxes.css({'z-index':'99999999'});
        $extra_chat_boxes.css({'right': extra_chat_boxes_right_position.toString() + 'px'});
        $extra_chat_boxes.css({'bottom': '0px'});
        //Show the extra chat boxes div
        $extra_chat_boxes.show();




        //remove chatbox 6 and on and create an extra_chat_box in its place
        for(var x = max_chat_boxes; x < $chat_boxes.length; x++){
            var $this_chat_box = $($chat_boxes[x]);



            var this_chat_box_type = $this_chat_box.attr('data-type');
            var this_chat_box_id = $this_chat_box.attr('data-id');
            var this_chat_box_name = $this_chat_box.attr('data-name');



            $this_chat_box.remove();

            //Make sure this extra chat box doesnt already exist
            var $extra_chat_box_check = $('.extra_chat_box[data-type="' + this_chat_box_type + '"][data-id="' + this_chat_box_id + '"]');
            if($extra_chat_box_check.length){
                //alert("CHAT BOX: type - " + this_chat_box_type + " , id - " + this_chat_box_id + " EXTRA ALRDY EXISTSSSS" );
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


    }
//    else{
//        //Hide the extra chat boxes div
//        $extra_chat_boxes.remove();
//    }
}





$(document).on('click', '.messaging_list_item', function(e){
    e.stopPropagation();

    var $messaging_list_item = $(this);

    var type = $messaging_list_item.attr('data-type');
    var id = $messaging_list_item.attr('data-id');
    var name = $messaging_list_item.attr('data-name');

    console.log("clicks on messaging list item");
    if(fullscreen){
        //Load this chat in the chat_panel
        var $chat_box_panel = $('#chat_panel');

        if(!$messaging_list_item.hasClass('active')){
            //Clear the current chat log
            clear_chat_box($chat_box_panel);

            //remove active from previous list item
            $('.messaging_list_item.active').removeClass('active');


            $messaging_list_item.addClass('active');

            //Add this chats data to chat_panel
            $chat_box_panel.attr('data-id', id);
            $chat_box_panel.attr('data-type', type);
            $chat_box_panel.attr('data-name', name);


            load_chat_box($chat_box_panel);
        }

    }else{

        console.log("OPENINGAAACHATBOX");
            //Check if this chat is already in the #extra_chat_boxes div
        var $extra_chat_box_check = $('.extra_chat_box[data-type="' + type + '"][data-id="' + id + '"]');
        if($extra_chat_box_check.length){
            //This chat is already in extra chat box, so
            //just swap it with the last chat visible
            swap_chat_box($extra_chat_box_check);
            return;
        }


        //alert('CREATING CHAT BOX FROM LIST ITEM ');

        var create_chat_box_data = get_or_create_chat_box(type, id, name);
        var $chat_box = create_chat_box_data['chat_box'];

        //Only load if the chatbox wasnt already open
        //    if(!create_chat_box_data['existed']){
        //        load_chat_box($chat_box);
        //    }




        //Add this chatbox to page
        //$('#LeftPanel_Holder').append($chat_box);


    }




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

    //If this is a group/custom, stop listening to socket channel
//    if(last_chat_box_type != 'user'){
//        socket.room(last_chat_box_type + "_" + last_chat_box_id).leave(group_chat_function);
//    }


    //Replace these values
    $last_chat_box.attr('data-type', extra_chat_box_type);
    $last_chat_box.attr('data-id', extra_chat_box_id);
    $last_chat_box.attr('data-name', extra_chat_box_name);
    $last_chat_box.find('.chat_box_name').text(extra_chat_box_name);


    //Make sure this extra box is not a duplicate before we create it
    var $extra_chat_box_check = $(".extra_chat_box[data-type='" + last_chat_box_type + "'][data-id='" + last_chat_box_id + "']");
    if(!$extra_chat_box_check.length){
        $extra_chat_box.attr('data-type', last_chat_box_type);
        $extra_chat_box.attr('data-id', last_chat_box_id);
        $extra_chat_box.attr('data-name', last_chat_box_name);

        $extra_chat_box.text(last_chat_box_name);
    }







    //clear the chat box
    $last_chat_box.find('.chat_box_text').empty();

    //load the recent text for this chat
    load_chat_box($last_chat_box);
}

$(document).on('click', '.extra_chat_box', function(e){
    e.stopPropagation();

    //Replace the last chat box with this extra chat box
    var $extra_chat_box = $(this);


    $('#extra_chat_boxes_list').toggle();


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

function handle_render_message(message_json){
    var chat_box_id = message_json['user_id'];

    //If this is an outbound message,
    //use the target_id to select the chatbox
    if(chat_box_id == messaging_globals.user_id){
        chat_box_id = message_json['target_id'];
    }

    //If this is a group/custom chat, use the target_id as chat_box_id
    if(message_json['target_type'] != 'user'){
        chat_box_id = message_json['target_id'];
    }


    //alert("rendering msg: " + JSON.stringify(message_json));

    var create_chat_box_data = get_or_create_chat_box(message_json['target_type'], chat_box_id, message_json['origin']['name']);
    var $chat_box = create_chat_box_data['chat_box'];

    function load_render_wrap(){
        init();
        function init(){
            render_message(message_json, $chat_box);
        }
    }
    //If the chat box didnt exist before we just got it back from create_chat_box,
    //be sure to load then previous messages THEN render the new message
    if(!create_chat_box_data['existed']){
        //alert('DIDNT EXIST');
        load_chat_box($chat_box, load_render_wrap);

    }else{
        //The chat box is already open and loaded so just
        //render the message
        render_message(message_json, $chat_box);
    }


    $('.chat_box_text').scrollTop(2000);

}


function formatAMPM(date) {
  var hours = date.getHours();
  var minutes = date.getMinutes();
  var ampm = hours >= 12 ? 'PM' : 'AM';
  hours = hours % 12;
  hours = hours ? hours : 12; // the hour '0' should be '12'
  minutes = minutes < 10 ? '0'+minutes : minutes;
  var strTime = hours + ':' + minutes + ' ' + ampm;
  return strTime;
}

var month = new Array();
    month[0] = "Jan";
    month[1] = "Feb";
    month[2] = "Mar";
    month[3] = "Apr";
    month[4] = "May";
    month[5] = "Jun";
    month[6] = "Jul";
    month[7] = "Aug";
    month[8] = "Sep";
    month[9] = "Oct";
    month[10] = "Nov";
    month[11] = "Dec";

var weekday = new Array(7);
    weekday[0]= "Sunday";
    weekday[1]= "Monday";
    weekday[2]= "Tuesday";
    weekday[3]= "Wednesday";
    weekday[4]= "Thursday";
    weekday[5]= "Friday";
    weekday[6]= "Saturday";

function render_message(message_json, $chat_box){
    //alert(JSON.stringify(message_json));

    var $chat_box_text = $chat_box.find('.chat_box_text');
    var $chat_message_wrap = $chat_box.find('.chat_message_wrap');




    var source = '';
    if(message_json['user_id'] == messaging_globals.user_id){
        source = $('#this_user_message_template').html();
    }else{
        source = $('#other_user_message_template').html();
    }

    var sent_datetime = new_datetime(message_json['sent_at']);
    var sent_formatted = weekday[sent_datetime.getDay()] + ', ' + month[sent_datetime.getMonth()] + ' ' + sent_datetime.getDate();
    var sent_time = formatAMPM(sent_datetime);
    var sent_date = sent_datetime.getDate() + sent_datetime.getMonth() + sent_datetime.getFullYear();
    var prev_date = $('.message').last().data("prev_sent");

    message_json['sent_at'] = sent_time;

    var template = Handlebars.compile(source);
    var generated_html = template(message_json);


    //alert('RENDERING MESSAGE: ' + JSON.stringify(message_json));

    if (sent_date !== prev_date) {
        chat_date_box = '<div class="chat_box_date_separator"><div class="chat_box_date">'+sent_formatted+'</div></div>';
        $chat_message_wrap.append(chat_date_box);
    }

    $chat_message_wrap.append($(generated_html));
    $chat_message_wrap.find('.message').last().data("prev_sent", sent_date );

}


function group_chat_function(success, numberOfRoomSubscribers) {


    if(success){

        this.on('join', function (newMembersCount) {
            // fire on client join
        });


        // fire when server send frame into this room with 'data' event
        this.on('message', function (message_data) {
//            alert('RECEIVING CUSTOM MSG ' + JSON.stringify(message_data));
//            alert(message_data['id'] + " --- " + last_send_message_id);
            if(message_data['id'] != last_send_message_id){
                handle_render_message(message_data);
            }
        });
    }else {
        console.log("ERROR CONNECTING TO ROOM");
    }




}


$(document).on('click', '.chat_box_close_button', function(e){
    var $close_button = $(this);

    var $chat_box = $close_button.closest('.chat_box');

    var chat_box_type = $chat_box.attr('data-type');
    var chat_box_id = $chat_box.attr('data-id');

    //Close this chat box
    $chat_box.remove();

    if(chat_box_type != 'user'){
//        socket.room(chat_box_type + "_" + chat_box_id).leave(group_chat_function);

    }


    position_chat_boxes();


    save_chat_cookie();







    //Get count of chatboxes
    var chat_box_count = $('.chat_box').length;


    if(chat_box_count < max_chat_boxes){
        //alert('CHAT BOX SPACE AVAILABLE');
        //check if there are any extra chat boxes
        var $extra_chat_boxes = $('.extra_chat_box');
        //If there are spot where extra chat boxes can go,
        //fill them up
        if($extra_chat_boxes.length){
            //alert(max_chat_boxes.toString() + " " + chat_box_count.toString());


            var empty_chat_box_spaces = max_chat_boxes - chat_box_count;

            for(var x = 0; x < empty_chat_box_spaces; x++){
                if(x < $extra_chat_boxes.length){
                    var $this_extra_chat_box = $($extra_chat_boxes.get(x));



                    var type = $this_extra_chat_box.attr('data-type');
                    var id = $this_extra_chat_box.attr('data-id');
                    var name = $this_extra_chat_box.attr('data-name');

                    var create_chat_box_data = get_or_create_chat_box(type, id, name);
                    var $new_chat_box = create_chat_box_data['chat_box'];




                    //Remove this extra chat box
                    $this_extra_chat_box.remove();

                    save_chat_cookie();

                    var current_extra_chat_box_count = $extra_chat_boxes.length - 1 - x;


                    if(current_extra_chat_box_count <= 0){
                        //alert('theres no more extra chat boxes ');
                        //remove the extra chat box
                        $('#extra_chat_boxes').remove();

                        save_chat_cookie();
                        continue;
                    }

                    //lower the extra chat box count
                    $('#extra_chat_boxes_count').text(current_extra_chat_box_count.toString());
                }
            }
        }
    }else{
        position_chat_boxes();
    }
});




$(document).on('keyup', '.chat_input', function(e){
    e.stopPropagation();
    e.preventDefault();


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
                    handle_render_message(response['message']);
                    $chat_input.val('');
                }else{

                }
            },'json'
        );


    }
});




    $(document).on('click', '#messaging_button', function(){

        window.location.href = globals.base_url + '/messages?url=' + document.URL.replace(globals.base_url, "");

    });


    $(document).on('click', '#messaging_back_button', function(){

        window.location.href = globals.base_url + globals.url;

    });

$(document).on('click', '.textarea_menubutton', function(e) {
    console.log('click');
    var $menu_button = $(this);
    var $textarea = $menu_button.parents('.chat_input_box');
    var $menu = $textarea.children('.chatbox_menu');

    if ($($menu_button).hasClass('closed')) {
        $menu.fadeIn(100);
        $menu_button.removeClass('closed');
    } else {
        $menu.fadeOut(100);
        $menu_button.addClass('closed');
    }
});

$(document).on('mouseenter', '#LeftPanel_Holder', function(e) {
    var isHovered = $('#messaging_panel').is(":hover");
    if (isHovered == false) {
        setTimeout(function(){
            var messaging_height = parseInt($('#messaging_panel').css('height'));
            var animation_height = (messaging_height - 60) * -1;
            $('#messaging_panel').animate({ bottom: animation_height });
            if (!$('#messaging_panel').hasClass('messaginghover')) {
                $('#messaging_panel').addClass('messaginghover')
            }
        },400);
    } 
});
$(document).on('mouseleave', '#LeftPanel_Holder', function(e) {
    setTimeout(function(){
        if ($('#messaging_panel').hasClass('messaginghover')) {
            $('#messaging_panel').animate({ bottom: "0px" }).removeClass('messaginghover');
        }
    },400);
});
$(document).on('mouseenter', '#messaging_panel', function(e) {
    setTimeout(function(){
        $('#messaging_panel').animate({ bottom: "0px" }).removeClass('messaginghover');
    },400);  
});
$(document).on('mouseleave', '#messaging_panel', function(e) {
    var isHovered = $('#LeftPanel_Holder').is(":hover");
    var messaging_height = parseInt($('#messaging_panel').css('height'));
    var animation_height = (messaging_height - 60) * -1;
    setTimeout(function(){
        if (isHovered == true) {
            $('#messaging_panel').animate({ bottom: animation_height });
            if (!$('#messaging_panel').hasClass('messaginghover')) {
                $('#messaging_panel').addClass('messaginghover')
            }
        }
    },400);
});

$(document).on('click', '.online_indicator.self', function(e) {
    var $online_button = $(this);
    var $menu = $online_button.children('.online_menu');

    if ($($online_button).hasClass('closed')) {
        $menu.fadeIn(100);
        $online_button.removeClass('closed');
    } else {
        $menu.fadeOut(100);
        $online_button.addClass('closed');
    }
});


$(window).load(function(){
    var slimScroll_height = parseInt($('#messaging_panel').css('height')) - 145;
    $('#messaging_list').slimScroll({
        height: slimScroll_height,
        railVisible:true,
        disableFadeOut:false,
        touchScrollStep: "20",
        size:"10px",
        allowPageScroll: true,
        distance: "3px"
    });
    $('.chat_box_text:not(#chat_panel_text)').slimScroll({
        height: "208px",
        railVisible:true,
        disableFadeOut:false,
        touchScrollStep: "20",
        size:"2px",
        allowPageScroll: true,
        distance: "3px",
        start: 'bottom'
    });

    var panel_height = $(window).height() - 70,
        chat_header_height = parseInt($('.chat_header').css('height')),
        chat_input_height = parseInt($('.chat_input_box').css('height')),
        chat_text_height = panel_height - chat_header_height - chat_input_height - 31;

    $('#chat_panel').css({ height: panel_height });
    $('#chat_panel_text').css({ height: chat_text_height });

});

});