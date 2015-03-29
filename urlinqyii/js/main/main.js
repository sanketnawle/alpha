//alert(JSON.stringify(globals));
$(document).ready(start(globals.origin_id));


    function start(origin_id){


        return function(){

            globals.origin_id = origin_id;

    $(function(){
        $('body.body_club div#fixed_element div.about_box').slimScroll({
            height: 'auto',
            railVisible: true,
            touchScrollStep: "20",
            size:"10px",
            allowPageScroll: true,
            distance: "3px"
        });
        $(".entries").slimScroll({ 
            height: 'auto',
            wrapperClass: "noti-scrollable",
            railVisible: true,
            touchScrollStep: "20",
            size:"10px",
            allowPageScroll: true,
            distance: "3px" 
        });  
        $('div.about_box p.school_about').slimScroll({
            height: '300px',
            railVisible: true,
            touchScrollStep: "20",
            size:"10px",
            allowPageScroll: true,
            distance: "3px"
        });
        $('body.body_club #group_about_box > .class_description_holder').slimScroll({
            height: '120px',
            railVisible: true,
            touchScrollStep: "20",
            size:"10px",
            allowPageScroll: true,
            distance: "3px"
        });
        $('body.body_class #group_about_box > .class_description_holder').slimScroll({
            height: '340',
            railVisible: true,
            touchScrollStep: "20",
            size:"10px",
            allowPageScroll: true,
            distance: "3px"
        });
    });



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


    $('.tab').click(function(){
        var $tab = $(this);
        var panel_id = $tab.attr('data-panel_id');
        //Change active tab
        $('.tab.active').removeClass('active');
        $('.other_views_tab').removeClass('active');
        $tab.addClass('active');
        //Find the current active panel and remove its active class
        $('.panel.active').removeClass('active');
        $('#panel_' + panel_id).addClass('active');
    });

    $('#nav_drop_down_see_all_button.courses').click(function(){
        $('.tab.active').removeClass('active');
        $(".tab.courses").addClass('active');
        $('.panel.active').removeClass('active');
        $('#panel_2').addClass('active');
    });

    $('#nav_drop_down_see_all_button.departments').click(function(){
        $('.tab.active').removeClass('active');
        $(".tab.departments").addClass('active');
        $('.panel.active').removeClass('active');
        $('#panel_2').addClass('active');
    });

    $('#nav_drop_down_see_all_button.clubs').click(function(){
        $('.tab.active').removeClass('active');
        $(".tab.clubs").addClass('active');
        $('.panel.active').removeClass('active');
        $('#panel_3').addClass('active');
    });


    //CUSTOM ADMIN FUNCTION
    $(document).on('click','#set_to_parents_photo', function(e){
        e.preventDefault();
        e.stopPropagation();
        var post_url = globals.base_url + '/admin/setToParentsPhoto';
        var post_data = {
            origin_type: globals.origin_type,
            origin_id: globals.origin_id
        };

        $.post(
            post_url,
            post_data,
            function(response){
                if(response['success']){
                    $('#cover_photo').css({'background-image': 'url("' + globals.base_url + response['file']['file_url'] + '")'});
                }else{

                }
            },'json'
        );

    });


    //stores type and true or false depending if
    //we want to block additonal requests to server to load more
    var type_locks = {};


    $( "#page" ).scroll(function() {
//        alert('SCROLL');

        var $page = $(this);
        var $tab_bar = $('#tab_bar');
        var $tab_wedge = $('.tab_wedge');
        var $nav_bar = $('#nav_bar');
        var $panel = $('.panel');
        var $panel_feed = $('.panel.panel_feed');
        var $cover_photo = $('#cover_photo');

        //$tab_bar_position.left + ", top: " + $tab_bar_position.top
        var tab_bar_width = '100%';
        //alert(tab_bar_position.top);

        var scroll_offset_top = $page.scrollTop();
        ////console.log("OFFSET");
//        alert(scroll_offset_top);

        var y = $page.scrollTop()*0.32;
        var x = $page.scrollTop() * 1;


        //Get the width of the content panel. The bar should always be the same width
        //as content panel
        var content_panel_width = $("#content_panel").width();
        console.log(scroll_offset_top);

        if(Math.floor(scroll_offset_top) >= 189.5){

            ////console.log("SETTING TO FIXED");

            //alert(y);
            //$("#cover_photo").css({"transform":"translateY("+ -y+"px)"});



            //            $(".em_hide").css({
            //                "width":"12px",
            //                "opacity":"1"
            //            });


            $nav_bar.css({'position':'relative'});
            $nav_bar.css({'top':'200.5px'});





        }

        if(Math.floor(scroll_offset_top) >= 233){
            $tab_bar.css({'background-color': 'rgba(18, 19, 20, .92)'});
            $tab_bar.css({'border-radius': '2px'});
            $tab_bar.css({position: 'fixed', top: '55px',width: content_panel_width});
            $panel.css({'margin-top':'32px'});
            $panel_feed.css({'margin-top':'41px'});
            $tab_wedge.css({'opacity':'0'});
            $tab_wedge.css({'margin-top':'15px'});
            $tab_wedge.css({'height':'0px'});
            $cover_photo.css({'opacity':'0'});
            $("#fixed_element.planner_group").css({'position':'fixed'});
            $("#fixed_element.planner_group").css({'top':'130px'});
            $("#fixed_element.planner_group.planner_club").css({'position':'relative'});
            $("#fixed_element.planner_group.planner_club").css({'top':'0px'});

        }if(Math.floor(scroll_offset_top) <= 191){
            $nav_bar.css({'position':'fixed'});
            $nav_bar.css({'top':'56px'});
        }

        if(Math.floor(scroll_offset_top) <= 234){
            //console.log("SETTING TO RELATIVE");
            //$tab_bar.css({position: 'relative', top: '0',width: tab_bar_width});
//            $("#cover_photo").css({"transform":"translateY("+ y+"px)"});

            $tab_bar.css({position: 'relative', top: '-50px',width: content_panel_width});
            $tab_bar.css({'border-radius': '0px'});
            $tab_bar.css({'background-color': 'rgba(18, 19, 20, 0.92)'});
            $panel.css({'margin-top':'-20px'});
            $cover_photo.css({'opacity':'1'});
            $tab_wedge.css({'opacity':'1'});
            $tab_wedge.css({'margin-top':'-6px'});
            $tab_wedge.css({'height':'10px'});
            $("#fixed_element.planner_group").css({'position':'relative'});
            $("#fixed_element.planner_group").css({'top':'0px'});

            //$("#cover_photo").css({"transform":"translateY("+y+"px)"});


        }

        if(Math.floor(scroll_offset_top) <= 235){
            //console.log("SETTING TO RELATIVE");
            //$tab_bar.css({position: 'relative', top: '0',width: tab_bar_width});
//            $("#cover_photo").css({"transform":"translateY("+ y+"px)"});

            $tab_bar.css({position: 'relative', top: '-50px',width: content_panel_width});
            $tab_bar.css({'border-radius': '0px'});
            $tab_bar.css({'background-color': 'rgba(18, 19, 20, 0.92)'});
            $panel.css({'margin-top':'-20px'});
            $cover_photo.css({'opacity':'1'});
            $tab_wedge.css({'opacity':'1'});
            $tab_wedge.css({'margin-top':'-6px'});
            $tab_wedge.css({'height':'10px'});
            $("#fixed_element.planner_group").css({'position':'relative'});
            $("#fixed_element.planner_group").css({'top':'0px'});

            //$("#cover_photo").css({"transform":"translateY("+y+"px)"});


        }





        //Detect if there are any visible data_box elements on the page
        var $data_boxes = $('.data_box:visible');
//        console.log("CHAT BOXES");
//        console.log($data_boxes);




        if($data_boxes.length > 0){
            //Check if the last data_box is visible
            var $last_data_box = $data_boxes.last();

            //Use this for checking if visible in frame so data starts loading before user hits
            //very bottom
            var $10nth_from_last = $($data_boxes.get($data_boxes.length - 10));

            if($last_data_box != undefined && isElementInViewport($10nth_from_last)){
                //alert('last data box is visible');
                //If this isnt marked as the last item, make a request for
                //more of its type
                if(!$last_data_box.hasClass('last_data_box')){
                    var data_box_type = $last_data_box.attr('data-type');
                    var $data_box_parent = $last_data_box.parent();
                    var load_url = $data_box_parent.attr('data-load_url');

                    load_url += "&last_id=" + $last_data_box.attr('data-id');

                    //alert(load_url);
                    //Only run if we havent locked this type from loading again
                    if(!type_locks[data_box_type]){
                        type_locks[data_box_type] = true;


                        $.getJSON(globals.base_url + load_url, function(json_data){
                            if(json_data['success']){
                                var data_type = json_data['data_type'];
                                if(json_data[data_type].length > 0){
                                    render_data_boxes(json_data);

                                    if(json_data[data_type].length < 50){
                                        //Get the new last box
                                        $('.data_box:visible').last().addClass('last_data_box');
                                    }else{
                                        //Unlock requests for this data type
                                        type_locks[data_box_type] = false;
                                    }

                                }else{
                                    //There is nothing else to load, so add
                                    //'last_data_box' class to last data box
                                    //so we dont make any more useless requests
                                    $last_data_box.addClass('last_data_box');
                                }
                            }else{
                                console.log(json_data);
                            }
                        });
                    }

                }


            }

        }else{
            //alert('There are no visible data boxes');
        }



    });

    init();

    function init(){
        if(globals.origin_type == 'school'){
            //Load the initial departments/groups/members
            var departments_url = $('.tab_content[data-data_type="departments"]').attr('data-load_url');
            //alert('making request to ' + globals.base_url + departments_url);
            $.getJSON(globals.base_url + departments_url, function(json_data){
                render_data_boxes(json_data);
            });


            var groups_url = $('.tab_content[data-data_type="groups"]').attr('data-load_url');
            $.getJSON(globals.base_url + groups_url, function(json_data){
                render_data_boxes(json_data);
            });


             var users_url = $('.tab_content[data-data_type="users"]').attr('data-load_url');
             $.getJSON(globals.base_url + users_url, function(json_data){
                 render_data_boxes(json_data);
             });

        }
    }

    function render_data_box(data_type, data_json){
        var $tab_content = null;
        var source = '';
        console.log(data_type);
        if(data_type == 'departments'){
            $tab_content = $('.tab_content[data-data_type="departments"]');
            source = $("#department_template").html();


            data_json['admin_count'] = data_json['admins'].length;
            data_json['student_count'] = data_json['students'].length;
            data_json['course_count'] = data_json['courses'].length;


        }else if(data_type == 'users'){
            $tab_content = $('.tab_content[data-data_type="users"]');
            source = $("#user_template").html();


//            data_json['admin_count'] = data_json['admins'].length;
//            data_json['student_count'] = data_json['students'].length;
//            data_json['course_count'] = data_json['courses'].length;


        }else if(data_type == 'groups'){
            $tab_content = $('.tab_content[data-data_type="groups"]');
            source = $("#group_template").html();


            data_json['member_count'] = data_json['members'].length;
            data_json['event_count'] = data_json['events'].length;
        }


        var template = Handlebars.compile(source);

        var $new_html_element = $(template(data_json));


        //console.log($new_html_element);

        $tab_content.append($new_html_element.hide().fadeIn(500));

    }

    function render_data_boxes(json_data){

        var data_type = json_data['data_type'];

        $.each(json_data[data_type],function(index, data_json){
            render_data_box(data_type, data_json);
        });

    }

    //Admin members tab controls in class and club to remove group members

    $("#remove_button").click(function(){
        var $remove_button = $(".admin_member_controls");
        var $add_button = $(".add_people_button.invite");
        var $members_tab = $(".members_tab_content");
        var $remove_state_controls = $(".remove_state_controls");

        $add_button.hide();
        $remove_button.hide();
        $remove_state_controls.css({"display":"inline-block"});
        $members_tab.addClass("remove_members_state");
        $('.members_card').not('.admin').find('.remove_member_button').show();

        $('.members_card').not('.admin').find('.follow_button_wrapper').not('.own_profile').hide();

    });

    $(".remove_member_button").click(function(){
        var $member_card = $(this).closest(".regular_member");
        var user_card_id = $member_card.attr('data-user_id');

        var post_url = globals.base_url + '/' + globals.origin_type + '/removeMember';
        var post_data = {user_id:user_card_id, group_id: globals.origin_id};
        $.post(
            post_url,
            post_data,
            function(response){
                if(response['success']){
                    $member_card.fadeOut(250);
                }else{
                    alert(JSON.stringify(response));
                }
            }, 'json'

        );
        //$(this).closest(".regular_member").fadeOut(250);
    });

    $("#done_removing_button").click(function(){
        var $remove_button = $(".admin_member_controls");
        var $add_button = $(".add_people_button.invite");
        var $members_tab = $(".members_tab_content");
        var $remove_state_controls = $(".remove_state_controls");

        $remove_state_controls.hide();
        $add_button.show();
        $remove_button.show();
        $members_tab.removeClass("remove_members_state");
        $('.regular_member').find('.remove_member_button').hide();
        $('.regular_member').find('.follow_button_wrapper').show();

    });

    //For group info boxes, if about div text overflows div show scroll icon

    $('.group_box').mouseenter(function(){

        var $about_section = $(this).find(".about_scroll_container");
        var $about_section_span_height = $(this).find("div.about").height();

        if($about_section_span_height >= 50){
            $about_section.addClass("scroller");
        }

    });

    $('.group_box').mouseleave(function(){
        var $about_section = $(this).find(".about_scroll_container");
        var $about_section_span_height = $(this).find("div.about").height();

        if($about_section_span_height >= 50){
            $about_section.removeClass("scroller");
        }
    });

    $("#page").scroll(function() {
        var y=$(this).scrollTop()*0.0072;
        var opacityShift = y*1;
        //alert(y);
        $("div.group_info_block").css({"opacity":1-opacityShift});
    });

    //Handles the member leave/join/follow button
    $('#group_user_action_button').mouseenter(function(){
        var $action_button = $(this);
        if($action_button.hasClass('member')){
            if(globals.origin_type === "department"){
                $action_button.find("#group_user_action_button_text").text('Unfollow');
            }else{
                $action_button.find("#group_user_action_button_text").text('Leave');
            }


        }
    });

    $('#group_user_action_button').mouseleave(function(){
        var $action_button = $(this);
        if($action_button.hasClass('member')){
            if(globals.origin_type === "department"){
                $action_button.find("#group_user_action_button_text").text('Following');
            }else{
                $action_button.find("#group_user_action_button_text").text('Member');
            }
        }
    });

    //Handles the user follow/following/unfollow button

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








            $(window).on('resize', function(){
                var group_name_left = $("p#group_name").position().left;
                $("div.center_admin").css({"left":group_name_left})
            });

            setTimeout(function(){
                var $quote = $("#group_name > #name_title");
                var $class_title_info = $(".class_title_info");

                var $numWords = $quote.text().split("").length;

                if (($numWords >= 1) && ($numWords < 10)) {
                    $quote.css("font-size", "48.5px");
                    $quote.css("letter-spacing", "1.55px;");
                }
                else if (($numWords >= 10) && ($numWords < 20)) {
                    $quote.css("font-size", "46px");
                    $quote.css("letter-spacing", "1.35px;");
                    $class_title_info.css("font-size","15.6px");
                    $class_title_info.css("margin-top","7px");
                    $class_title_info.css("line-height","18.4px");
                }
                else if (($numWords >= 20) && ($numWords < 30)) {
                    $quote.css("font-size", "37.6px");
                    $quote.css("letter-spacing", "1.18px;");
                    $class_title_info.css("font-size","14px");
                    $class_title_info.css("margin-top","7px");
                    $class_title_info.css("line-height","16.2px");
                }
                else if (($numWords >= 30) && ($numWords < 38)) {
                    $quote.css("font-size", "32.5px");
                }
                else {
                    $quote.css("font-size", "27.5px");
                    $class_title_info.css("font-size","10.4px");
                    $class_title_info.css("margin-top","4px");
                    $class_title_info.css("line-height","12.8px");
                }

                var group_name_left = $("p#group_name").position().left;
                var group_name_left = $("p#group_name").position().left;
                $("div.center_admin").css({"left":group_name_left});
                setTimeout(function(){
                    $("div.group_name").css({"opacity":"1"});
                }, 200);
            }, 450);






    //$('#create_todo_form').submit(function (e) {
//    $(document).on('click','#create_todo_form',function(e){
//        //Send post request to event/create
//        e.preventDefault();
//
//        //alert($('.event_date').val());
//
//        var $form = $(this);
//        var post_url = $form.attr('action');
//        var post_data = $(this).serializeArray();
//        var errors = [];
//
//        var todo_name = $('#event_name').val();
//
//        //Check if user input a name for todo
//        if($('#event_name').val().length == 0){
//            errors.push({name:'event_name_error',value:'You must give a name for this todo'});
//        }
//
//        //Make sure the date is converted to UTC before passing to database
//        var todo_date = new Date($('.event_date').attr('data-date'));
//        todo_date = local_to_utc(todo_date);
//        todo_date = todo_date.getUTCFullYear().toString() + "-" + (todo_date.getMonth()+ 1).toString() + "-" + todo_date.getDate().toString();
//
//        var todo_time = $('.event_time').attr('data-time');
//
//
//        if(errors.length > 0){
////        alert(JSON.stringify(errors));
//            $('#new_listing_text').text(JSON.stringify(errors));
//            return false;
//        }
//
//        post_data = { todo_name: todo_name, todo_date: todo_date, todo_time: todo_time, origin: globals.origin_type, origin_id: globals.origin_id};
//        //alert(JSON.stringify(post_data));
//        $.post(
//            post_url,
//            post_data,
//            function(response) {
//                if(response['success']){
//                    //alert(JSON.stringify(response));
//                    add_event(response['event']);
//                    //show_event(response['event'],'#todays_events');
//                }else{
//                    alert(JSON.stringify(response));
//                }
//            }, 'json'
//        );
//    });

 /*   $(document).on('click', '.profile_link', function(){
        //$(this).prepend("<img class='waiting_animation_circletype waiting_animation_circletype_sz10 circletype_animation_adjust_1' src='http://www.urlinq.com/beta/img/waiting_animation_circletype.GIF'>");

        open_profile(globals.base_url,7);
    });
    $(document).on('click', '.close_modal', function(){
        //$(this).prepend("<img class='waiting_animation_circletype waiting_animation_circletype_sz10 circletype_animation_adjust_1' src='http://www.urlinq.com/beta/img/waiting_animation_circletype.GIF'>");
        $('#profile_wrapper').hide();
        $('.overlay').hide();
    });
    function open_profile(base_url,user_id){

        $.getJSON( base_url + "/profile/json",{id: user_id}, function( json_profile_data ) {
            /*if(json_profile_data['success']){
             //alert(JSON.stringify(json_feed_data));
             //                alert(JSON.stringify(json_feed_data));
             render_profile(json_profile_data['feed']);
             }else{
             alert('failed to get profile data');
             }
            render_profile(base_url,json_profile_data);
        });

    }
    function render_profile(base_url,data){

        $.ajax({ url: base_url + '/protected/views/profile/profile.html',
            dataType:'html',
            success: function(html) {
                //   source = html('#profile_template').html();
                //source = html;
                var template = Handlebars.compile(html);
                // var id = $(this).parent(".master_comments").attr("id");
                $('body').append(template(data));
            }

        });

    }*/

    //Perform group member action
    // For clubs - join/leave
    // class - join/leave
    // department - follow/unfollow
    // To simplify this, follow is join and unfollow is leave for departments as well
//    $('#group_user_action_button').click(function(){
    $(document).on('click','.group_user_action_button, #group_user_action_button',function(e){
        e.stopPropagation();

        var $group_user_action_button = $(this);

        if($group_user_action_button.hasClass('own_department')){
            return;
        }
        var verb = '';
        if($group_user_action_button.hasClass('member')){
            verb = 'leave';
        }else{
            verb = 'join';
        }



        if(verb == 'leave' && globals.origin_type != 'department'){
            var r = confirm("Are you sure you want to leave?");
            if (r == false) {
                return;
            }
        }

        var post_url = globals.base_url + '/' + globals.origin_type + '/' + globals.origin_id + '/' + verb;




        var post_data = {id: globals.origin_id};

        $.post(
            post_url,
            post_data,
            function(response) {
                if(response['success']){
                    var $group_user_action_button_text_div = $('#group_user_action_button_text');
                    if(verb == 'join'){
                        if(globals.origin_type == 'department'){
                            $group_user_action_button_text_div.text('Following');
                        }else{
                            $group_user_action_button_text_div.text('Member');
                        }
                        $group_user_action_button.removeClass('non_member');
                        $group_user_action_button.addClass('member');

                        //If you joined a new class or club, add it to the leftpanel
                        if(globals.origin_type == 'class'){
                            $('#class_list').append('<li><a href="' + globals.base_url + '/class/' + globals.origin_id + '" data-class_id="' + globals.origin_id + '">' + globals.origin_name + '</a></li>');
                        }else if(globals.origin_type == 'club'){
                            $('#club_list').append('<li><a href="' + globals.base_url + '/club/' + globals.origin_id + '" data-club_id="' + globals.origin_id + '">' + globals.origin_name + '</a></li>');
                        }

                    }else if(verb == 'leave'){
                        if(globals.origin_type == 'department'){
                            $group_user_action_button_text_div.text('Follow');
                        }else{
                            $group_user_action_button_text_div.text('Join');
                        }
                        $group_user_action_button.removeClass('member');
                        $group_user_action_button.addClass('non_member');

                        var data_group = 'clubs';
                        if(globals.origin_type == 'class'){
                            data_group = 'classes';
                        }
                        $("ul[data-group='" + data_group + "'] a[data-" + globals.origin_type + "_" + "id='" + globals.origin_id + "']").remove();

                    }


                    location.reload();
                }else{
                    alert(JSON.stringify(response));
                }
            }, 'json'
        );
    });



    last_file_count = 0;
    success_counter = 0;
    Dropzone.autoDiscover = false;

    //Try to bind this, if it fails, thats because
    //the element is not on the page because they arent an admin
    try{

        globals.myDropzone = new Dropzone('form#cover_photo_form', {

            url: globals.base_url + '/api/uploadCoverPhoto',
            autoProcessQueue: true,
            uploadMultiple: false,
            parallelUploads: 4,
            maxFilesize: 30,
            maxFiles: 1,
            createImageThumbnails: false,
            acceptedFiles: ".jpeg,.jpg,.png,.gif,.JPEG,.JPG,.PNG,.GIF",
            maxfilesexceeded: function(file) {
                this.removeAllFiles();
                this.addFile(file);
            },
            init: function() {
                this.on("success", function(file, response) {


                    if(response['success']){
                        $('#cover_photo').css({'background-image': 'url("' + globals.base_url + response['file']['file_url'] + '")'});
                    }else{
                        alert("Error uploading cover photo");
                    }

                });


                this.on("sending", function(file, xhr, formData) {



                    formData.append('origin_type', globals.origin_type);
                    formData.append('origin_id', globals.origin_id);
                });


                this.on('addedfile',function(file){

                })
            }

        });


        $(document).on('click', '.upload_cover_photo_button', function(){
            $('form#cover_photo_form').click();
        });



    }catch(err){
    }



    if($("body").hasClass("body_class") == true){

        $("span.create_planner_message").css({"left":"27px"}).text("Plan this class's schedule");
        $("span.create_planner_message").css({"left":"18px", "width":"192px"});
    }

    if($("body").hasClass("body_department") == true){

        $("span.create_planner_message").css({"left":"27px"}).text("Schedule group events");
        $("span.create_planner_message").css({"left":"22px", "width":"192px"});
    }
    if($("body").hasClass("body_club") == true){

        $("span.create_planner_message").css({"left":"27px"}).text("Plan this group's schedule");
        $("span.create_planner_message").css({"left":"12px", "width":"202px"});
    }

    $(document).on('click','.edit_about',function(){
        $('.panel.active').removeClass('active');
        $('.tab.active').removeClass('active');
        $('#panel_6').addClass('active'); //about tab
        $('#edit_club_description').click();
    });
    $(document).on('click','#edit_club_description',function(){
        var $edit_button = $(this);
        if($edit_button.hasClass('editing')){
            var post_url = globals.base_url+"/club/editDescription";
            var description = $('#group_description_input').val();
            var post_data = {description: description, club_id: globals.origin_id};
            $.post(
                post_url,
                post_data,
                function(response){
                    if(response['success']){
                        if(description.length){
                            $edit_button.parent().html('Description <p id = "edit_club_description"><span class = "edit_icon small_icon_map"></span>Edit</p>')
                            $('#group_description').text(description);
                        }else{
                            $edit_button.parent().html('<p id = "edit_club_description"><span class = "add_icon small_icon_map"></span>Edit Description</p>');
                            $('#group_description').text("Provide a description of this group.");
                        }
                    }else{
                        alert(JSON.stringify(response));
                    }
                }
            )

            $('#group_description_input').hide();
            $('#group_description').fadeIn(250);
            $edit_button.removeClass('editing');
        }else{
            $edit_button.text('Done Editing');
            $('#group_description').hide();
            $('#group_description_input').fadeIn(250);
            var description = $.trim($('#group_description').text());
            if(description != "Provide a description of this group.") {
                $('#group_description_input').val(description);
            }
            $edit_button.addClass('editing');
        }
    });
    $(document).on('click','#edit_club_mission',function(){
        var $edit_button = $(this);
        if($edit_button.hasClass('editing')){
            var post_url = globals.base_url+"/club/editMission";
            var mission = $('#group_mission_input').val();
            var post_data = {mission: mission, club_id: globals.origin_id};
            $.post(
                post_url,
                post_data,
                function(response){
                    if(response['success']){
                        if(mission.length){
                            $edit_button.parent().html(' Purpose <p id = "edit_club_mission"><span class = "edit_icon small_icon_map"></span>Edit</p>')
                            $('#group_mission').text(mission);
                        }else{
                            $edit_button.parent().html('<p id = "edit_club_mission"><span class = "add_icon small_icon_map"></span>Edit Group Purpose</p>');
                            $('#group_mission').text("Give your group a 240-character purpose that describes what it will be used for.");
                        }
                    }else{
                        alert(JSON.stringify(response));
                    }
                }
            )
            $('#group_mission_input').hide();
            $('#group_mission').fadeIn(250);



            $edit_button.removeClass('editing');
        }else{
            $edit_button.text('Done Editing');
            $('#group_mission').hide();
            $('#group_mission_input').fadeIn(250);
            var mission = $.trim($('#group_mission').text());
            if(mission != "Give your group a 240-character purpose that describes what it will be used for."){
                $('#group_mission_input').val(mission);
            }

            $edit_button.addClass('editing');
        }
    });

    var picking_file=false;
    $(document).on('click', '#edit_club_icon',function(e){
        e.preventDefault();
        e.stopPropagation();
        console.log('upload file');
        if(picking_file==false){
            picking_file=true;
            $('#club_picture_upfile').click();
           // picking_file=false;
        }

    });


    var upload_file;
    $(document).on('change', '#club_picture_upfile', function (event)
    {
        picking_file=false;
        console.log('yo');
        upload_file = event.target.files[0];
        console.log(upload_file);
        var post_data = new FormData();

        post_data.append("file", upload_file);
        post_data.append("club_id",globals.origin_id);

        $.ajax({
            url: globals.base_url+'/club/changeClubIcon',
            type: 'POST',
            data: post_data,
            cache: false,
            dataType: 'json',
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            success: function(response)
            {
                if(response['success']){
                    $('.group_display_icon').css('background-size','cover');
                    $('.group_display_icon').css('background-image',"url('"+globals.base_url+response['file_url']+"')");

                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                alert('err'+errorThrown);
            }
        });
        picking_file=false;
    });
    $('#welcome_post, #welcome_post_2').hide().fadeIn(250);


    function isElementInViewport (el) {
        if(el === undefined){
            return;
        }

        //special bonus for those using jQuery
        if (typeof jQuery === "function" && el instanceof jQuery) {
            el = el[0];
        }

        var rect = el.getBoundingClientRect();


        console.log("BOUNDING RECT FOR LAST DATA_BOX");
        console.log(rect);

        return (
//            rect.top >= 0
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && /*or $(window).height() */
            rect.right <= (window.innerWidth || document.documentElement.clientWidth) /*or $(window).width() */
        );
    }





}

}



