

console.log(globals);

$(document).ready(fbar_ready(globals.origin_id));

function fbar_ready(origin_id) {



    return function(){
        //*starts* Code to make the post request for a post
        //liking a post

        //alert(origin_id);
        globals.$fbar = $('#fbar_wrapper');
        console.log(globals);

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





        setTimeout(function(){
            sample();
        }, 1000);

        function sample(){
            //var id = $(this).parents(".posts").attr("id");

          //  $.embedly.defaults.key = '110869001b274ee0a51767da08dafeef';
            //console.log($(this).find(".f_hidden_p").text().trim());
              $(".new_fd").each(function (index) {
                    //console.log("in");
                    //console.log();
                    var max = $(this);
                    $(this).removeClass("new_fd");

                    if ($(this).find(".f_hidden_p").children('a').text() != "") {
                        $(this).find(".f_hidden_p").children('a').embedly({
                              query: {
                                maxwidth: 500,
                                autoplay: true
                            },
                        display:function(data, elem){
                           // console.log(data);
                           // console.log($(this).find('.link-text-title').text());
                            //jQuery = $(this);
                            if(data.type != 'video') $('.play_btn').hide();
                            console.log(max);
                            max.find('.link-text-title').text(data.title);
                            if(data.thumbnail_url){

                              if((data.thumbnail_width > 550) && (data.thumbnail_height> 270)) {
                                    max.find('.link-img').css({
                                        'background' :  'url(' + data.thumbnail_url + ')',
                                        'height' : 273,
                                        'width' : 555,
                                        'background-size' : 'cover'
                                    });

                                    max.find('.link-text-data').css({
                                        'position' : 'relative',
                                        'top': 162,
                                        'left' : 1,
                                        'height' : 110,
                                        'width' : 414

                                    });
                                     max.find('.link-text-about').css({
                                        'position' : 'relative',
                                        'top': -260,
                                        'left' :-140,
                                        'width' : 545
                                    });
                                     max.find('.link-text-title').css({
                                        'position' : 'relative',
                                        'top' : -265,
                                        'left' : -140
                                     })

                               //}
                                    }
                                    else {
                                        max.find('.link-img').css({
                                            'background' :  'url(' + data.thumbnail_url + ')',
                                            'height' : 139,
                                            'width' :150,
                                            'background-size' : 'cover'
                                        });

                                    }
                                    var thumbnail_url = data.thumbnail_url;
                                    max.find('.link-text-about').text(data.description);
                                // jQuery('.post_msg .msg_span').append("<br> <a href=" + data.original_url + ">" + data.original_url + "</a>");


                            }
                            else {
                                //this or
                                max.find('.link-img').css({
                                    'background' :  'url(' + 'http://www.urlinq.com/beta/DefaultImages/anon.png' + ')',
                                    'height' : 139,
                                    'width' :150,
                                    'background-size' : 'cover'
                                });

                               // jQuery('.link-img').removeClass();
                                if(data.description){
                                    max.find('.link-text-about').text(data.description + " " +data.original_url);
                                }
                                else {
                                    max.find('.link-text-about').text(data.original_url);
                                }

                            }

                            max.find('.link-wrapper').on('click', function () {
            // Handles the click event and replaces the link with the video.


                                if (data.type === 'video') {
                                    $(this).closest(".post_lr_link_msg").find(".link-wrapper").replaceWith(data.html);
                                    return false;
                                } else {

                                    window.open(data.url, '_blank');
                                }

                            });


                            /*.on('click', function(){
                                console.log('clicked');
                                if(data.type == 'video'){
                                    //var htmlString = "<iframe src=" + data.original_url + "></iframe>";
                                    $('.link-wrapper').load(data.original_url);
                                }
                            });*/

                        }
                        })

                        /*$(this).find('.play').embedly({
                            query: {
                                maxwidth: 500,
                                autoplay: true
                            },
                            display: function (data, elem) {
                                console.log(data);

            //Adds the image to the a tag and then sets up the sizing.
                                $(elem).html('<img src="' + data.thumbnail_url + '"/>')
                                    .width(data.thumbnail_width)
                                    .height(data.thumbnail_height)
                                    .find('span').css('top', data.thumbnail_height / 2 - 36)
                                    .css('left', data.thumbnail_width / 2 - 36);
            ////alert($(elem).html());
                                var $elhtml = $(elem).html();
                                $(elem).closest(".post_lr_link_msg").find(".link-img").html($elhtml);

                                var t_title = data.title;
                                var t_des = data.description;
                                var t_url = data.url;
            ////alert(data.title+" , "+data.description+", "+data.url);
                                var ctt = t_title + "<span class='link-text-website'>" + t_url + "</span>";

                                $(elem).closest(".post_lr_link_msg").find(".link-text-title").html(ctt);
                                $(elem).closest(".post_lr_link_msg").find(".link-text-about").html(t_des);

                                if (data.type === 'video') {

                                } else {
                                    $(elem).closest(".post_lr_link_msg").find(".play_btn").hide();
                                }

                            }
                        }).on('click', function () {
            // Handles the click event and replaces the link with the video.
                            var data = $(this).data('embedly');

                            if (data.type === 'video') {
                                $(this).closest(".post_lr_link_msg").find(".link-wrapper").replaceWith(data.html);
                                return false;
                            } else {
                                window.open(data.url, '_blank');
                            }

                        });*/

                    }

                });


                $(document).delegate('.playable_wrap', "click", function () {
                    $(this).closest(".post_lr_link_msg").find(".play").click();
                });

        }




    //    $(document).on('click', '.post_like', function() {
    //         var id = $(this).parents(".posts").attr("id");
    //
    //         if(likeStatusAjax(id)) {
    //            var likes = $(this).children('.like_number').text().trim();
    //            $(this).removeClass('post_like');
    //            $(this).addClass('post_liked');
    //            if(likes != ''){
    //                 var likesInt = parseInt(likes, 10);
    //
    //                $(this).children('.like_number').text(likesInt+1)
    //            } else {
    //                $(this).children('.like_number').text(1)
    //            }
    //           //parseInt(likes)++;
    //        }
    //    });
    //
    //    $(document).on('click','.post_liked', function(){
    //        var likes = $(this).children('.like_number').text().trim();
    //            $(this).removeClass('post_liked');
    //            $(this).addClass('post_like');
    //            if(likes != '0'){
    //                 var likesInt = parseInt(likes, 10);
    //
    //                $(this).children('.like_number').text(likesInt-1);
    //            } else {
    //                $(this).children('.like_number').text("");
    //            }
    //    });

    //    function likeStatusAjax(id) {
    //        $.ajax({
    //            url: base_url + '/post/' + id + '/like',
    //            type: "POST",
    //            success: function(liked) {
    //                alert(JSON.stringify(liked));
    //                if(liked['success']) return true;
    //                else return false;
    //            },
    //            error: function() {
    //
    //                 $("#posts").prepend("Error Liking the post");
    //            }
    //        });
    //    return true;
    //
    //    }
        //Posting a Form
    //    $(document).on('click', '.post-btn', function() {
    //        var jsonData = {
    //                'origin_type': origin_type,
    //                'origin_id': origin_id,
    //                'post_type': post_type,
    //                'anon': anon,
    //                'privacy': privacy
    //        };
    //        //console.log(post_type);
    //            //Checks if all the bases types are satisfied
    //        if (origin_type && origin_id && post_type && (anon === 0 || anon === 1) && privacy) {
    //            //DISCUSSION POSTS
    //            if (post_type === "discussion") {
    //                var text = $('.postTxtarea').val();
    //                if (text) {
    //                    jsonData.text = text;
    //                   // console.log(jsonData);
    //                    //Makes the ajaxcall to postcontroller.php
    //                    postStatusAjax(jsonData);
    //                } else {
    //                    //If there is no text lets user know there isn't any
    //                    $('.postTxtarea').text("Add text before posting");
    //                }
    //            //EVENT POSTS
    //            } else if(post_type === "event"){
    //                var event_name = $('#event_name').val();
    //                var event_location = $("#event_location").val();
    //                var description = $("#event_description").val();
    //                if(event_name === '' || event_description === '' || event_location === ''){
    //
    //                }
    //                else {
    //
    //                    jsonData.event_name = event_name;
    //                    jsonData.location = event_location;
    //                    jsonData.description = description;
    //                    jsonData.title = event_name;
    //                    //Event Type hardcoded for now
    //                    jsonData.event_type = "exam";
    //                    start_date = $('add_event_date').val();
    //
    //                    //Hard coded doris needs to fix front end
    //                    end_date = start_date;
    //                    if(start_date === '') alert("Add Date please");
    //                    else{
    //                        jsonData.end_date = end_date;
    //                        jsonData.start_date = start_date;
    //                    }
    //                    start_time = $('set_time_24hr').val();
    //                    //Hard coded Doris needs to fix front end
    //                    end_time = start_time;
    //                    if(start_time === '') alert("Add time please");
    //                    else{
    //                        jsonData.end_time = end_time;
    //                        jsonData.start_time = start_time;
    //
    //                        if(end_time != "" && end_date != ""){
    //                            var updatedJsonData = {
    //                                event : jsonData
    //                            }
    //                            //Send's it in the even't format Alex requested for events ONLY
    //                            postStatusAjax(updatedJsonData);
    //                        }
    //                    }
    //
    //
    //                }
    //            //NOTES POST
    //            } else if(post_type === 'notes'){
    //                console.log("Ine nore");
    //                var fileSelect = $('._uplI').files;
    //                console.log(fileSelect);
    //                if(fileSelect){
    //                    var formData = new FormData();
    //                    $.each(fileSelect, function(key, value)
    //                        {
    //                            formData.append(key, value);
    //                        });
    //                    jsonData.files = formData;
    //                    postStatusAjax(jsonData);
    //                } else {
    //                    $('.uplName').css("color", "red");
    //                }
    //            //QUESTION POST
    //            } else if (post_type === 'question') {
    //                jsonData.question_type = question_type;
    //                var text = $('.topfbar').val();
    //                console.log(question_type);
    //                //REQULAR QUESTIONS TYPE
    //                if(question_type === "regular_type"){
    //                     var sub_text = $('.askTxtArea').val();
    //                     if(text === '') $('.topfbar').css("border-bottom", "solid 3px red");
    //                     else {
    //                        //if there is sub text set jsonData.sub_text = it
    //                        if(sub_text != '') jsonData.sub_text = sub_text;
    //                        //get the text
    //                        jsonData.text = text;
    //                        //make the AJAX Call
    //                        //alert(JSON.stringify(jsonData));
    //                        postStatusAjax(jsonData);
    //
    //                     }
    //                //MULTIPLIC CHOICE QUESTION TYPE
    //                } else if(question_type === "multiple_type"){
    //                    if(text === '') $('.topfbar').css("border-bottom", "solid 3px red");
    //                    else {
    //                        var choice_a = $('#choice_a').val();
    //                        var choice_b = $('#choice_b').val();
    //                        console.log(choice_a);
    //                        console.log(choice_b);
    //                        if((choice_a != "") && (choice_b != "")){
    //                            question = {
    //                                'text' : text,
    //                                'choices' : {'a' : choice_a,
    //                                             'b' : choice_b}
    //
    //                            }
    //                            var choice_c = $('#choice_c').val();
    //                            var choice_d = $('#choice_d').val()
    //                            if(choice_c != '') question['choices'].c = choice_c;
    //                            if(choice_d != '') question['choices'].d = choice_d;
    //                            correct_answer = 'a';
    //                            question.answer = correct_answer;
    //                            jsonData.question = question;
    //                            alert(JSON.stringify(jsonData));
    //                            postStatusAjax(jsonData);
    //
    //
    //                        } else{
    //                            if(choice_a === ''){
    //                              $('#choice_a').css('border-bottom', 'solid 2px red');
    //                            } else if(choice_b === ''){
    //                              $('#choice_b').css('border-bottom', 'solid 2px red');
    //                            } else{
    //                              $('#choice_a').css('border-bottom', 'solid 2px red');
    //                              $('#choice_b').css('border-bottom', 'solid 2px red');
    //                            }
    //
    //                        }
    //                    }
    //                //TRUE OR FALSE QUESTION TYPE
    //                } else if(question_type === "truth_type"){
    //                    if(text === '') $('.topfbar').css("border-bottom", "solid 3px red");
    //                    else {
    //                         correct_answer = 'ture';
    //                         question = {
    //                                'text' : question,
    //                                'answer' : correct_answer
    //                         };
    //                         jsonData.question = question;
    //                         postStatusAjax(jsonData);
    //
    //
    //                    }
    //                //QUESTION TYPE DOESN'T EXIST
    //                } else {
    //                    alert("Something is wrong");
    //                }
    //                //Adds all expert tags into the array experts
    //               /* var experts  = $(".midfbar-exp .tag-name").map(function() {
    //                    return $(this).text();
    //                }).get();
    //                //adds experts to jsonData
    //                if (experts.length > 0) jsonData.ask_experts = experts;*/
    //                //Gets the top text
    //
    //
    //            } //POST TYPE DOESNT EXIST
    //        } else {
    //          alert("Can't make a post yet");
    //        }
    //
    //    });

        //AJAX CALL TO posts/create with a passed in dictionary
        function postStatusAjax(jsonData) {
            //makes the ajax request to postcontroller.php
            //alert(base_url +'/post/create' );

            var post_data = {'post':jsonData};

            post_data['post']['post_type'] = 'multiple_type';
            console.log(post_data);
            $.ajax({
                url: base_url + '/post/create',
                type: "POST",
                data: post_data,
                dataType: 'json',
                success: function(json_data) {
                    //alert(JSON.stringify(json_data));
                    //code to add this post to the feed
                    var source = $("#post_template").html();
                    var template = Handlebars.compile(source);
                    console.log(json_data['post']['text']);
                    console.log(findUrlInPost(json_data['post']['text']));
                    if(findUrlInPost(json_data['post']['text']) != false) json_data['post'].embed_link = findUrlInPost(json_data['post']['text']);
                    $("#posts").prepend(template(json_data['post']));
                    sample();

                },
                error: function(xhr, status, error) {
                    var err = JSON.parse(xhr.responseText);
                    console.log(err);
                    alert(JSON.stringify(err));
                }
            });

        }




        function findUrlInPost( text ) {
            var source = (text || '').toString();
            var urlArray = [];
            var url;
            var matchArray;
            var regexToken = /(((ftp|https?):\/\/)[\-\w@:%_\+.~#?,&\/\/=]+)|((www:)?[_.\w-]+([\w][\w\-]+\.)+[a-zA-Z]{2,3})/g;
            while( (matchArray = regexToken.exec( source )) !== null ) {
                var token = matchArray[0];
                urlArray.push( token );
            }

            if(urlArray[0]) {
                if(urlArray[0][0] != 'h') urlArray[0] = "http://" + urlArray[0];
                return urlArray[0];
            }
            return false;
        }



        $(document).delegate('.fbar_buttonwrapper', "click", function () {
            var $button_selected = $(this);
            var $fbar_new = globals.$fbar.find("#fbar_new");

            $fbar_new.addClass("fbar_shadow");



            var button_selected_type = $button_selected.attr("data-post_button_type");
            globals.$fbar.find("#fbar_holder").addClass(button_selected_type);
            globals.$fbar.find("#fbar_holder").attr('data-post_type', button_selected_type);


            if(globals.$fbar.find("#fbar_holder").hasClass("event")){
                globals.$fbar.find("#post_btn").text("Create Event");
                //init();
                $('#event_title').val('');

                var datetime = new Date();

                var end_datetime_object = datetime;



                var $start_date_input = $('#event_start_date');
                $start_date_input.attr('data-date', date_to_string(datetime));
                $start_date_input.val(date_to_day_of_week_string(datetime));

                var end_time_hours = datetime.getHours() + 1;

                if(parseInt(end_time_hours) >= 24){
                    end_time_hours -= 24;
                    end_datetime_object.setDate(datetime.getDate() + 1);
                }



                var $end_date_input = $('#event_end_date');
                $end_date_input.attr('data-date', date_to_string(end_datetime_object));
                $end_date_input.val(date_to_day_of_week_string(end_datetime_object));


                //sql formatted timestring
                var start_time_string = ints_to_time(datetime.getHours(),datetime.getMinutes(),datetime.getSeconds());

                //Set the default time for the time_inputs
                var $start_time_input = $('#event_start_time');
                $start_time_input.attr('data-time',start_time_string);
                $start_time_input.val(time_string_to_am_pm_string(start_time_string));






                var end_time_string = ints_to_time(end_time_hours,datetime.getMinutes(),datetime.getSeconds());

                //Set the default time for the time_inputs
                var $end_time_input = $('#event_end_time');

                $end_time_input.attr('data-time',end_time_string);
                $end_time_input.val(time_string_to_am_pm_string(end_time_string));
            }

            if(globals.$fbar.find("#fbar_holder").hasClass("discuss")){
                globals.$fbar.find("#post_btn").text("Post");
            }

            if(globals.$fbar.find("#fbar_holder").hasClass("question")){
                globals.$fbar.find("#post_btn").text("Add Question");
            }

            if(globals.$fbar.find("#fbar_holder").hasClass("question")){
                globals.$fbar.find("#post_btn").text("Add Question");
            }

            if(globals.$fbar.find("#fbar_holder").hasClass("notes")){
                globals.$fbar.find("#post_btn").text("Add Files");
            }

            if(globals.$fbar.find("#fbar_holder").hasClass("opportunity")){
                globals.$fbar.find("#post_btn").text("Share Opportunity");
            }


            var $button_section = globals.$fbar.find('#fbar_buttons');
            var $form_section = globals.$fbar.find('form#fbar_form')
            $button_section.addClass("faded").delay(150).queue(function(next){
                $button_section.addClass("hide");
                $form_section.addClass("show").delay(250).queue(function(next2){
                    $form_section.addClass("fadeIn");

                    globals.$fbar.find(".autofocus").focus();

                    globals.$fbar.find("form#fbar_form").css({"overflow":"visible"});
                    next2();
                });
                next();

            });

        });


        $(document).delegate('.event_more_options', "click", function () {
            if(globals.$fbar.find("#fbar_holder").hasClass("events_more_options")){
                $(this).closest("#fbar_holder").removeClass("events_more_options");
                $(this).text("More Options");
            }
            else{
                $(this).closest("#fbar_holder").addClass("events_more_options");
                $(this).text("Fewer Options");
            }

        });

        $(document).delegate('.opportunity_more_options', "click", function () {
            if(globals.$fbar.find("#fbar_holder").hasClass("opps_more_options")){
                $(this).closest("#fbar_holder").removeClass("opps_more_options");
                $(this).text("More Options");
            }
            else{
                $(this).closest("#fbar_holder").addClass("opps_more_options");
                $(this).text("Fewer Options");
            }

        });


        if(globals.origin_type == 'user'){
            //Populate the audience select
            $.getJSON(base_url + '/user/getGroupData', function(json_data){
                var $audience_select_list = globals.$fbar.find("#audience_select_list");


                $audience_select_list.hide();

                $.each(json_data['classes'], function(index, class_json){
                    var source = $('#audience_template').html();
                    var template = Handlebars.compile(source);


                    class_json['name'] = class_json['class_name'];
                    class_json['id'] = class_json['class_id'];
                    class_json['audience'] = 'class';

                    var generated_html = template(class_json);
                    var $audience = $(generated_html);



                    $audience_select_list.append($audience.hide().fadeIn());
                });


                $.each(json_data['clubs'], function(index, club_json){
                    var source = $('#audience_template').html();
                    var template = Handlebars.compile(source);


                    club_json['name'] = club_json['group_name'];
                    club_json['id'] = club_json['group_id'];

                    club_json['audience'] = 'club';

                    var generated_html = template(club_json);
                    var $audience = $(generated_html);



                    $audience_select_list.append($audience.hide().fadeIn());
                });

                $.each(json_data['groups'], function(index, group_json){
                    var source = $('#audience_template').html();
                    var template = Handlebars.compile(source);


                    group_json['name'] = group_json['group_name'];
                    group_json['id'] = group_json['group_id'];

                    group_json['audience'] = 'group';

                    var generated_html = template(group_json);
                    var $audience = $(generated_html);



                    $audience_select_list.append($audience.hide().fadeIn());
                });




            });
        }

        $(document).on('click', '.audience_name', function(){
            var $audience = $(this);
            var $audience_select_list = $audience.closest('#audience_select_list');

            var audience = $audience.attr('data-audience');
            var audience_id = $audience.attr('data-audience_id');

            var audience_name = $audience.text();


            var $audience_select_div = $audience_select_list.closest('.menu_audience').find('#audience_select');
            $audience_select_div.attr('data-audience_id', audience_id);
            $audience_select_div.attr('data-audience', audience);



            var $audience_text = $audience_select_div.find('.selected_audience');


            $audience_text.text(audience_name);

            $audience_select_list.hide();

        });


        $(document).on('click', '.privacy_list', function(){
            var $privacy_list_option = $(this);

            //Remove the other active privacy option
            $('.privacy_list.active').removeClass('active');

            $privacy_list_option.addClass('active');

            var privacy_option = $privacy_list_option.attr('data-privacy');

            var $privacy_dropdown = $privacy_list_option.closest('.privacy_dropdown');

            $privacy_dropdown.attr('data-privacy', privacy_option);
        });

        $(document).on('click', '#audience_select', function(){

        });


        $(document).delegate('.question_type_button', "click", function () {
            var $button_selected = $(this);
            $(".question_type_button.active").removeClass("active");



            globals.$fbar.find('#fbar_holder').attr('data-post_type', $button_selected.attr('data-question_post_type'));
            $(this).addClass("active");
            var question_button_selected_type = $button_selected.attr("data-question_post_type");
            var parent_form = $button_selected.closest("#fbar_form");
            if(question_button_selected_type == "multiple_choice"){
                $(parent_form).addClass("mult_choice");
                $(parent_form).removeClass("true_or_false");
                globals.$fbar.find(".autofocus").focus();
                $(parent_form).removeClass("regular_question");
            }
            if(question_button_selected_type == "true_false"){
                $(parent_form).addClass("true_or_false");
                globals.$fbar.find(".autofocus").focus();
                $(parent_form).removeClass("mult_choice");
                $(parent_form).removeClass("regular_question");
            }
            if(question_button_selected_type == "hide_both"){
                $(parent_form).addClass("regular_question");
                $(parent_form).removeClass("mult_choice");
                globals.$fbar.find(".autofocus").focus();
                $(parent_form).removeClass("true_or_false");
            }
        });

        $(".tf_line").mouseenter(function() {
            $(this).find(".answer_check").css("display", "inline-block");
        });

        $(".tf_line").mouseleave(function() {
            if (!($(this).find(".answer_check").hasClass("selected_answer"))) {
                $(this).find(".answer_check").css("display", "none");
            }
        });

        $(".multiple_choice").delegate(".question_choice_line", "mouseenter", function() {
            $(this).find(".answer_check").css("display", "inline-block");
            $(this).find(".add_choice").css("display", "none");
            $(this).find(".letter_choice").css("display", "inline-block");
        });

        $(".multiple_choice").delegate(".question_choice_line", "mouseleave", function() {
            if (!($(this).find(".answer_check").hasClass("selected_answer"))) {
                $(this).find(".answer_check").css("display", "none");
            }
            if ($(this).find(".multiple_choice_answer").val() == "") {
                $(this).find(".letter_choice").css("display", "none");
                $(this).find(".add_choice").css("display", "inline-block");
            }
        });

        $(".answer_check").delegate("input", "click", function() {
            if ($(this).parent().hasClass("selected_answer")) {
                $(this).parent().removeClass("selected_answer");
                $(this).prop("checked", false);
            }
            else {
                if(globals.$fbar.find(".answer_check input").prop("checked", true)) {
                    globals.$fbar.find(".answer_check input").prop("checked", false);
                    globals.$fbar.find(".answer_check").removeClass("selected_answer");
                    globals.$fbar.find(".answer_check").css("display", "none");
                    $(this).prop("checked", true);
                    $(this).parent().addClass("selected_answer");
                    $(this).parent().css("display", "inline-block");
                }
            }
        });




        $(".privacy_dropdown_link").click(function(){
            globals.$fbar.find("#privacy_tooltip").hide();
        });

        $("li.privacy_list").click(function(){
            globals.$fbar.find("li.privacy_list").removeClass("active");
            $(this).addClass("active");
        });



        $(".privacy_dropdown_link").mouseenter(function(){
            globals.$fbar.find("#privacy_tooltip").fadeIn(250);
        });

        $(".privacy_dropdown_link").mouseleave(function(){
            globals.$fbar.find("#privacy_tooltip").fadeOut(250);
        });




        function close_fbar(){


            var $button_section = globals.$fbar.find('#fbar_buttons');
            var $form_section = globals.$fbar.find('form#fbar_form');

            var $fbar_new = globals.$fbar.find("#fbar_new");

            $fbar_new.removeClass("fbar_shadow");

            globals.$fbar.find("#fbar_holder").attr('data-post_type','');

            $form_section.removeClass("fadeIn");
            $form_section.removeClass("show").delay(350).queue(function(next){
                $button_section.removeClass("faded");
                $button_section.removeClass("hide");
                        globals.$fbar.find("#fbar_holder").removeClass("discuss");
                        globals.$fbar.find("#fbar_holder").removeClass("opportunity");
                        globals.$fbar.find("#fbar_holder").removeClass("question");
                        globals.$fbar.find("#fbar_holder").removeClass("event");
                        globals.$fbar.find("#fbar_holder").removeClass("notes");

                        $form_section.removeClass("true_or_false");
                        $form_section.removeClass("mult_choice");
                        $form_section.removeClass("regular_question");
                        globals.$fbar.find(".question_type_button.active").removeClass("active");
                        globals.$fbar.find(".question_type_button.regular_question").addClass("active");
                        globals.$fbar.find("#fbar_holder").removeClass("events_more_options");
                        globals.$fbar.find(".event_more_options").text("More Options");
                        globals.$fbar.find("form#fbar_form").css({"overflow":"hidden"});
                next();

            });
        }

        $(document).delegate('#fbar_footer > #cancel_btn', "click", function () {
            reset_fbar();
        });

        globals.$fbar.find('textarea').autosize();

        globals.$fbar.find('.audience_name').click(function(){
            var $selected_audience = $(this);
            var selected_audience_text = $selected_audience.find("a").text();
            globals.$fbar.find(".selected_audience").text(selected_audience_text);
        });





        last_file_count = 0;
        success_counter = 0;
        Dropzone.autoDiscover = false;


        var $fbar_dropzone_form = $('.dropzone#fbar_file_form');
    //    Dropzone.options.fbar_file_form = {


        try{
                globals.myDropzone = new Dropzone('form#fbar_file_form', {
                url: base_url + '/post/create',
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 4,
                maxFilesize: 16,
                maxFiles: 10,
                acceptedFiles: ".jpeg,.jpg,.png,.gif,.JPEG,.JPG,.PNG,.GIF,.doc,.docx,.ppt,.pptx,.zip,.xls,.xlsx,.pdf",
                maxfilesexceeded: function(file) {
                    this.removeAllFiles();
                    this.addFile(file);
                },
                init: function() {
                    this.on("success", function(file, response) {

                        console.log('RESPONSE');
                        console.log(response);

                        console.log('success counter: ' + success_counter.toString());
                        success_counter++;

                        if(success_counter == last_file_count){
                            console.log('LAST SUCCESS');

                            if(response['success']){
                                //alert('success');


                                reset_fbar();
                                render_post(response['post'],'prepend');

                            }
                            //globals.myDropzone.emit("addedfile", file);
                        }


                    });


                this.on("sendingmultiple", function(file, xhr, formData) {
                    last_file_count = globals.myDropzone.files.length;
                    success_counter = 0;
                    var post_data = get_post_data();

        //            $.each(post_data, function(key, value){
        //                alert(key + ' ' + value);
        //                formData.append(key, value);
        //            });

                    formData.append('post', JSON.stringify(post_data));
                    //formData.append('post_json', JSON.stringify(post_data));
                });


                    this.on('addedfile',function(file){
                        console.log(file);

                        var source = $('#post_file_template').html();

                        var template = Handlebars.compile(source);

                        var file_type = file['type'];

                        if(file['name'].indexOf('.doc') > -1){
                            file['file_type'] = 'doc';
                        }else if(file['name'].indexOf('.ppt') > -1){
                            file['file_type'] = 'ppt';
                        }else if(file['name'].indexOf('.pdf') > -1){
                            file['file_type'] = 'pdf';
                        }else if(file['name'].indexOf('.xls') > -1){
                            file['file_type'] = 'xls';
                        }else if(file['name'].indexOf('.zip') > -1){
                            file['file_type'] = 'doc';
                        }else if(file['name'].indexOf('.jpg') > -1){
                            file['file_type'] = 'jpg';
                        }else if(file['name'].indexOf('.png') > -1 ){
                            file['file_type'] = 'png';
                        }else if(file['name'].indexOf('.gif') > -1){
                            file['file_type'] = 'doc';
                        }

                        var generated_html = template(file);

                        var $file = $(generated_html);




                    // Create the remove button
                    var removeButton = $("<span class='file_x_icon'></span>");



                        // Add the button to the file preview element.
                        $file.append(removeButton);

                        var last_modified = $file.attr('data-last_modified');
                        var name = $file.attr('data-name');


                    $file.find('.file_x_icon').on('click',function(e) {


                            var $x_icon = $(this);

                            // Make sure the button click doesn't submit the form:
                            e.preventDefault();
                            e.stopPropagation();




        //                    $('.fbar_file').each(function(){
        //                        var $this_file = $(this);
        //
        //                        if($this_file.attr('data-last_modified') == last_modified.toString()){
        //                            globals.myDropzone.removeFile(this_file);
        //                        }
        //                    });



                            // Remove the file preview


                            //alert(globals.myDropzone.files);
                            console.log(globals.myDropzone.files);
                            for(var i = 0; i < globals.myDropzone.files.length; i++){
                                var this_file = globals.myDropzone.files[i];
                                //console.log(this_file);

                                console.log('last modified of this file from dropzone: ' + this_file.lastModified);
                                console.log('last modified of this file last shit fuck  : ' + last_modified.toString());


                                console.log('1 name: ' + this_file.name.toString());
                                console.log('2 name: ' + name.toString());

                                if(this_file.lastModified.toString() == last_modified.toString() && this_file.name.toString() == name.toString()){
                                    globals.myDropzone.removeFile(this_file);
                                    $('.fbar_file[data-name="' + this_file.name + '"][data-last_modified="' + this_file.lastModified + '"]').remove();

                                }
                            }


                            console.log('Current dropzone files');
                            console.log(globals.myDropzone.files);

                        });


                        $('.post_form_template').append($file);


                        // Capture the Dropzone instance as closure.
                        var _this = this;







                        //globals.myDropzone.files.push(file);












                    })

                }



        //        addedfile: function(file){
        //
        //            alert(JSON.stringify(file));
        //
        //            return file;
        //        }
            });
        }catch(err){
            console.log('ERROR LOADING FBAR DROPZONE');
        }

    //    }






        function reset_fbar(){
            var $fbar_holder = globals.$fbar.find('#fbar_holder');

            var post_type = $fbar_holder.attr('data-post_type');




            //Clear all dropzone files
            if(globals.profile_open){
                globals.profileDropzone.files = [];
            }else{
                globals.myDropzone.files = [];
            }




            //Clear the text input
            $fbar_holder.find('.post_text_area').val('');


            //Delete the previews from the hidden file field
            $fbar_holder.find('div.dz-preview').each(function(){
                $(this).remove();
            });


             //Delete the visible file barz
            $fbar_holder.find('div.fbar_file').each(function(){
                $(this).remove();
            });

            //Reset the privacy settings
            //Remove the other active privacy option
            $fbar_holder.find('.privacy_list.active').removeClass('active');


            var $privacy_dropdown = $fbar_holder.find('.privacy_dropdown');
            $privacy_dropdown.attr('data-privacy','');
            $privacy_dropdown.children().first().addClass('active');






            //Reset the post type
            $fbar_holder.attr('data-post_type','');

            $('#calLayer.fbar').hide();
            close_fbar();
        }

        function get_post_data(){
            if(globals.origin_type == 'home'){
                globals.origin_type = 'user';
            }


            var $fbar_holder = globals.$fbar.find('#fbar_holder');

            var post_type = $fbar_holder.attr('data-post_type');


            var $post_text_area = $fbar_holder.find('.post_text_area');

            var post_text = $post_text_area.val();


            var post_data = {};



            post_data['text'] = post_text;
            post_data['post_type'] = post_type;


            post_data['origin_type'] = globals.origin_type;
            post_data['origin_id'] = globals.origin_id;

            //alert(origin_id);

            //If we are on home or profile page, check if the
            //user has set a different audience
            if(globals.origin_type == 'user'){
                var $audience_select = $fbar_holder.find('#audience_select');
                var audience = $audience_select.attr('data-audience');


                if(audience != 'followers'){
                    var audience_id = $audience_select.attr('data-audience_id');
                    post_data['origin_type'] = audience;
                    post_data['origin_id'] = audience_id;
                }
            }



            post_data['sub_text'] = '';
            post_data['privacy'] = '';


            var privacy_setting = $fbar_holder.find('.privacy_dropdown').attr('data-privacy');

            if(privacy_setting && privacy_setting != ''){
                 //If privacy setting isnt empty, set it to the selected setting
                //Otherwise, put an empty string
                post_data['privacy'] = privacy_setting;
            }


            post_data['anon'] = $fbar_holder.find('#post_anon .flat7b').hasClass('flat_checked') ? 1:0;

            post_data['like_count'] = 0;


            if(post_type == 'question' || post_type == 'true_false' || post_type == 'multiple_choice'){
                post_data['question'] = {};

                post_data['question']['anonymous'] = 0;
                post_data['question']['live_answers'] = 0;
                post_data['text'] = globals.$fbar.find('#post_title').val();
                post_data['sub_text'] = $fbar_holder.find('.question_textarea').find('.post_text_area').val();

                if(post_type == 'multiple_choice'){
                    post_data['question']['options'] = [];

                    post_data['question']['answer_index'] = '';


                    //Get the options
                    $('.question_choice_line').each(function(index){
                        var $question_div = $(this);
                        var option_text = $question_div.find('.multiple_choice_answer').val();
                        if(option_text != ''){
                            //See if this is the right answer
                            var correct_answer = $question_div.find('.answer_check').find('input').is(":checked");


                            if(correct_answer){
                                post_data['question']['answer_index'] = index;
                            }

                            post_data['question']['options'].push(option_text);
                        }

                    });
                }

            }

            if(post_type == 'notes' || post_type == 'files'){
                post_data['text'] = $fbar_holder.find('.file_textarea').find('.post_text_area').val();
            }




            if(post_type == 'event'){
                //Get the event data from fbar

                var event_title = $('#event_title').val();
                var start_date = $('#event_start_date').attr('data-date');
                var start_time = $('#event_start_time').attr('data-time');
                var end_date = $('#event_end_date').attr('data-date');
                var end_time = $('#event_end_time').attr('data-time');
                var location = $('#event_location').val();

                var description = $('.event_textarea').find('.post_text_area').val();



                var start_datetime_object = local_to_utc(new_datetime(start_date + ' ' + start_time));
                var end_datetime_object = local_to_utc(new_datetime(end_date + ' ' + end_time));



                start_date = date_to_string(start_datetime_object);
                start_time = datetime_to_time_string(start_datetime_object);

                end_date = date_to_string(end_datetime_object);
                end_time = datetime_to_time_string(end_datetime_object);






                //Convert dates from local to UTC
//                var start_datetime = new_datetime(start_date + ' ' + start_time);
//                var end_datetime = new_datetime(end_date + ' ' + end_time);
//
//
//                start_datetime = local_to_utc(start_datetime);
//                end_datetime = local_to_utc(end_datetime);
//
//                start_date = date_to_string(start_datetime);
//                start_time = datetime_to_time_string(start_datetime);
//
//                end_date = date_to_string(end_datetime);
//                end_time = datetime_to_time_string(end_datetime);
//
//
//                console.log('UTC STARTTIME');
//                console.log(start_datetime);
//
//                console.log('UTC ENDTIME');
//                console.log(end_datetime);







                post_data['event'] = {};
                post_data['event']['title'] = event_title;
                post_data['event']['start_date'] = (start_date) ? start_date : '';
                post_data['event']['start_time'] = (start_time) ? start_time : '';
                post_data['event']['end_date'] = (end_date) ? end_date : '';
                post_data['event']['end_time'] = (end_time) ? end_time : '';
                post_data['event']['description'] = description;
                post_data['event']['location'] = location;
                post_data['event']['origin_type'] = globals.origin_type;
                post_data['event']['origin_id'] = origin_id;


            }



            if(post_type == 'opportunity'){
                post_data['opportunity'] = {};

                var end_date = $('#opportunity_due_date').attr('data-date');
                var end_time = $('#opportunity_start_time').attr('data-time');
                var title = $('#opportunity_title').val();
                var description = $('.opportunity_textarea').find('.post_text_area').val();


                var end_datetime_object = local_to_utc(new_datetime(end_date + ' ' + end_time));



                end_date = date_to_string(end_datetime_object);
                end_time = datetime_to_time_string(end_datetime_object);


                post_data['opportunity']['title'] = title;
                post_data['opportunity']['description'] = description;
                post_data['opportunity']['end_date'] = (end_date) ? end_date : '';
                post_data['opportunity']['end_time'] = (end_time) ? end_time : '';
                post_data['opportunity']['origin_type'] = globals.origin_type;
                post_data['opportunity']['origin_id'] = origin_id;
            }


            //alert(JSON.stringify(post_data));


            return post_data;
        }



        function populate_audience_select(){
            $.getJSON(base_url + '/user/getGroupData', function(json_data){
                var $audience_select_list = globals.$fbar.find("#audience_select_list");


                $audience_select_list.hide();

                $.each(json_data['classes'], function(index, class_json){
                    var source = $('#audience_template').html();
                    var template = Handlebars.compile(source);


                    class_json['name'] = class_json['class_name'];
                    class_json['id'] = class_json['class_id'];
                    class_json['audience'] = 'class';

                    var generated_html = template(class_json);
                    var $audience = $(generated_html);



                    $audience_select_list.append($audience.hide().fadeIn());
                });


                $.each(json_data['clubs'], function(index, club_json){
                    var source = $('#audience_template').html();
                    var template = Handlebars.compile(source);


                    club_json['name'] = club_json['group_name'];
                    club_json['id'] = club_json['group_id'];

                    club_json['audience'] = 'club';

                    var generated_html = template(club_json);
                    var $audience = $(generated_html);



                    $audience_select_list.append($audience.hide().fadeIn());
                });

                $.each(json_data['groups'], function(index, group_json){
                    var source = $('#audience_template').html();
                    var template = Handlebars.compile(source);


                    group_json['name'] = group_json['group_name'];
                    group_json['id'] = group_json['group_id'];

                    group_json['audience'] = 'group';

                    var generated_html = template(group_json);
                    var $audience = $(generated_html);



                    $audience_select_list.append($audience.hide().fadeIn());
                });




            });
        }



        function post_data_is_valid(post_data){



        }

        var post_button_lock = false;

        $(document).on('click', '.post_btn', function(){

            if(!post_button_lock){
                //Lock this action from happening again until we
                //say so by setting post_button_lock to false
                post_button_lock = true;


                console.log(globals);
                //alert(JSON.stringify(globals));


                var $fbar_holder = globals.$fbar.find('#fbar_holder');
                $(".no_posts_container").fadeOut(100);
                var dropzone;
                if(globals.profile_open){
                    dropzone = globals.profileDropzone;
                }else{
                    dropzone = globals.myDropzone;
                }
                var post_type = $fbar_holder.attr('data-post_type');


                var $post_text_area = $fbar_holder.find('.post_text_area');




                //Check if there are any files
                var $file_form = globals.$fbar.find('#fbar_file_form');
                //alert($file_form.children('div.dz-preview').length);
                console.log(dropzone.files);


                var post_data = get_post_data();

        //        alert(JSON.stringify(post_data));
                //Check if this data is good
                if(post_type == 'discuss'){
                    if(post_data['text'] == ''){
                        alert('Please input post text');
                        post_button_lock = false;
                        return;
                    }
                }else if(post_type == 'notes' || post_type == 'files'){
                    //Check if there is atleast one file
                    if(dropzone.files.length == 0){
                        alert('Please upload atleast one file.');
                        post_button_lock = false;
                        return;
                    }
                }else if(post_type == 'question' ){

                    if(post_data['text'] == ''){
                        alert('Please input a question');
                        post_button_lock = false;
                        return;
                    }

                    if(post_type == 'multiple_choice'){
                        if(post_type['question']['options'].length < 2){
                            alert('Please input atleast 2 options for a question');
                            post_button_lock = false;
                            return;
                        }
                    }

                }


                if(post_type == 'event'){
                    if(post_data['event']['title'] == ''){
                        alert('Please input a title');
                        post_button_lock = false;
                        return;
                    }

                    if(post_data['event']['start_date'] == ''){
                        alert('Please input a start date');
                        post_button_lock = false;
                        return;
                    }

                    if(post_data['event']['start_time'] == ''){
                        alert('Please input a start time');
                        post_button_lock = false;
                        return;
                    }

                    if(post_data['event']['end_date'] == ''){
                        alert('Please input an end date');
                        post_button_lock = false;
                        return;
                    }

                    if(post_data['event']['end_time'] == ''){
                        alert('Please input an end time');
                        post_button_lock = false;
                        return;
                    }



                    var start_datetime = new_datetime(post_data['event']['start_date'] + ' ' + post_data['event']['start_time']);
                    var end_datetime = new_datetime(post_data['event']['end_date'] + ' ' + post_data['event']['end_time']);


                    if(end_datetime < start_datetime){
                        if(post_data['event']['start_date'] == post_data['event']['end_date']){
                            alert('Invalid end time');
                            post_button_lock = false;
                            return;
                        }else{
                            alert('Invalid end date');
                            post_button_lock = false;
                            return;
                        }
                    }



                }




                if(post_type == 'opportunity'){
                    if(post_data['opportunity']['title'] == ''){
                        alert('Please input a title');
                        post_button_lock = false;
                        return;
                    }


                    if(post_data['opportunity']['end_date'] == ''){
                        alert('Please input an end date');
                        post_button_lock = false;
                        return;
                    }

                    if(post_data['opportunity']['end_time'] == ''){
                        alert('Please input an end time');
                        post_button_lock = false;
                        return;
                    }


                }





                console.log('SENDING FILES');


                //If there are any files, submit the post request through dropzone
                if(dropzone.files.length > 0){
                    dropzone.processQueue();
                }else{
                    //otherwise, make a post request to post/create manually
                    //alert('MANUAL POST REQUEST');


                    var post_request_data = {'post':post_data};


                    console.log(post_request_data);
                    //alert(JSON.stringify(post_data));
                    $.post(
                        base_url + '/post/create',
                        post_request_data,
                        function(response) {
                            post_button_lock = false;


                            console.log(JSON.stringify(response));

                            if(response['success']){
                                response['post']['update_timestamp'] = moment(response['post']['update_timestamp'], "X").fromNow();
                                reset_fbar();
                                render_post(response['post'],'prepend');


                                //Unlock the post action

                                if(response['post']['event']){
                                    add_event(response['post']['event']);
                                }
                            }else{

                                console.log(response);
                            }
                        }, 'json'
                    );
                }




                //$file_form.submit();


            }

        });







        globals.$fbar.find('#fbar_form').submit(function(e){
            e.preventDefault();
        });




        // .off('click', '#selector_id').
        $(document).on('click', '.upload_button', function(e){
            e.preventDefault();
            e.stopPropagation();

            globals.$fbar.find('.fbar_file_form.dropzone').click();
        });


        $(document).on('click', '#post_photos', function(e){
            e.preventDefault();
            e.stopPropagation();

            globals.$fbar.find('.fbar_file_form.dropzone').click();
        });



    //    $('.upload_button').click(function(e){
    //        e.stopPropagation();
    //
    //        $('.dropzone').click();
    //    });

        $(document).on('click', '#post_attachments',function(e){
            e.stopPropagation();
            globals.$fbar.find('.fbar_file_form.dropzone').click();
        });





        init();

        function init(){

            //if(globals.origin_type == 'club' || globals.origin_type == 'department' || globals.origin_type == 'group' || globals.origin_type == 'class'){
            if(globals.origin_type == 'home' || globals.origin_type == 'user'){
                populate_audience_select();
            }
            if(globals.origin_type != 'school'){
                //get the current datetime object
                var datetime = new Date();

                var end_datetime_object = datetime;



                var $start_date_input = $('#event_start_date');
                $start_date_input.attr('data-date', date_to_string(datetime));
                $start_date_input.val(date_to_day_of_week_string(datetime));

                var end_time_hours = datetime.getHours() + 1;

                if(parseInt(end_time_hours) >= 24){
                    end_time_hours -= 24;
                    end_datetime_object.setDate(datetime.getDate() + 1);
                }



                var $end_date_input = $('#event_end_date');
                $end_date_input.attr('data-date', date_to_string(end_datetime_object));
                $end_date_input.val(date_to_day_of_week_string(end_datetime_object));


                //sql formatted timestring
                var start_time_string = ints_to_time(datetime.getHours(),datetime.getMinutes(),datetime.getSeconds());

                //Set the default time for the time_inputs
                var $start_time_input = $('#event_start_time');
                $start_time_input.attr('data-time',start_time_string);
                $start_time_input.val(time_string_to_am_pm_string(start_time_string));






                var end_time_string = ints_to_time(end_time_hours,datetime.getMinutes(),datetime.getSeconds());

                //Set the default time for the time_inputs
                var $end_time_input = $('#event_end_time');

                $end_time_input.attr('data-time',end_time_string);
                $end_time_input.val(time_string_to_am_pm_string(end_time_string));


                function verify_date_inputs(){
                    var $event_start_date = $('#event_start_date');
                    var $event_start_time = $('#event_start_time');
                    var $event_end_date = $('#event_end_date');
                    var $event_end_time = $('#event_end_time');


                    var event_start_date = $event_start_date.attr('data-date');
                    var event_start_time = $event_start_time.attr('data-time');

                    var event_end_date = $event_end_date.attr('data-date');
                    var event_end_time = $event_end_time.attr('data-time');


                    //Make sure the start date is less than the end date
                    var start_datetime_object = new_datetime(event_start_date + ' ' + event_start_time);
                    var end_datetime_object = new_datetime(event_end_date + ' ' + event_end_time);


                    console.log('- start date time object -');
                    console.log(start_datetime_object);


                    console.log('- end date time object -');
                    console.log(end_datetime_object);


                    if(end_datetime_object < start_datetime_object){
                        //alert('end time must be after start time');


                        //Create just date objects
                        //so we can compare the date only
                        var start_date = new_date(date_to_string(start_datetime_object));
                        var end_date = new_date(date_to_string(end_datetime_object));



//                        console.log(start_date);
//                        console.log(end_date);
//                        alert('????');
                        if(start_date.getTime() == end_date.getTime()){
                            //alert('EUQLAAAA');
//                            var new_end_time_string = ints_to_time(start_datetime_object.getHours() + 1, start_datetime_object.getMinutes(), start_datetime_object.getSeconds());
//                            //make the time an hour from the start time
//                            $event_end_time.attr('data-time', new_end_time_string);
//                            $event_end_time.val(time_string_to_am_pm_string(new_end_time_string));


                            var end_time_hours = parseInt(start_datetime_object.getHours()) + 1;

                            if(end_time_hours >= 24){
                                end_time_hours -= 24;
                                end_datetime_object.setDate(end_datetime_object.getDate() + 1);


                                $event_end_date.val(date_to_day_of_week_string(end_datetime_object));
                                $event_end_date.attr('data-date', date_to_string(end_datetime_object));
                            }

                            var new_end_time_string = ints_to_time(end_time_hours, start_datetime_object.getMinutes(), start_datetime_object.getSeconds());

                            //make the time an hour from the start time
                            $event_end_time.attr('data-time', new_end_time_string);
                            $event_end_time.val(time_string_to_am_pm_string(new_end_time_string));


                        }else if(start_date > end_date){


                            end_datetime_object = start_datetime_object;

                            var end_time_hours = parseInt(end_datetime_object.getHours()) + 1;

                            if(end_time_hours >= 24){
                                end_time_hours -= 24;
                                end_datetime_object.setDate(end_datetime_object.getDate() + 1);
                            }

                            //If the start date is greater than the end date,
                            //make the end date the start date
                            $event_end_date.val(date_to_day_of_week_string(end_datetime_object));
                            $event_end_date.attr('data-date', date_to_string(end_datetime_object));




                            var new_end_time_string = ints_to_time(end_time_hours, end_datetime_object.getMinutes(), end_datetime_object.getSeconds());
                            //make the time an hour from the start time
                            $event_end_time.attr('data-time', new_end_time_string);
                            $event_end_time.val(time_string_to_am_pm_string(new_end_time_string));


    //                        $event_end_date.addClass('error');
    //                        $event_end_time.removeClass('error');
                        }else {
                            $event_end_time.addClass('error');
                            $event_end_date.removeClass('error');
                        }


                    }else{
                        $event_end_date.removeClass('error');
                        $event_end_time.removeClass('error');
                    }
                }



                jQuery(document).on('focusout', '.date_input', function(){
                    verify_date_inputs();
                });


                jQuery(document).on('click', '.calcell', function(e){
                    console.log('create event js');
                    verify_date_inputs();
                    console.log("IS THIS EVEN FIRING???");



                    e.stopPropagation();
                });

                jQuery(document).on('click', '.dates', function(){
                    verify_date_inputs();
                });


                jQuery(document).on('click', '.time_selector_div', function(){
                    verify_date_inputs();
                });

                jQuery(document).on('click', '.text_input', function(){
                    console.log('VERIFYING DATE INPUTS');
                    verify_date_inputs();
                });


                jQuery(document).on('click', function(){
                    console.log('VERIFYING DATE INPUTS');
                    verify_date_inputs();
                });
            }




        }

        globals.$fbar.find('.menu_audience').dropit({
        });
        globals.$fbar.find('.privacy_menu').dropit({
        });








    }

}
