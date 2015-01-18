





$(document).ready(function() {
    //*starts* Code to make the post request for a post 
    //liking a post


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
        
        $.embedly.defaults.key = '110869001b274ee0a51767da08dafeef';
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
    $(document).on('click', '.post-btn', function() {
        var jsonData = {
                'origin_type': origin_type,
                'globals.origin_id': globals.origin_id,
                'post_type': post_type,
                'anon': anon,
                'privacy': privacy
        };
        //console.log(post_type);
            //Checks if all the bases types are satisfied 
        if (origin_type && globals.origin_id && post_type && (anon === 0 || anon === 1) && privacy) {
            //DISCUSSION POSTS
            if (post_type === "discussion") {
                var text = $('.postTxtarea').val();
                if (text) {
                    jsonData.text = text;
                   // console.log(jsonData);
                    //Makes the ajaxcall to postcontroller.php
                    postStatusAjax(jsonData);
                } else {
                    //If there is no text lets user know there isn't any
                    $('.postTxtarea').text("Add text before posting");
                }
            //EVENT POSTS
            } else if(post_type === "event"){
                var event_name = $('#event_name').val();
                var event_location = $("#event_location").val();
                var description = $("#event_description").val();
                if(event_name === '' || event_description === '' || event_location === ''){

                }
                else {

                    jsonData.event_name = event_name;
                    jsonData.location = event_location;
                    jsonData.description = description;
                    jsonData.title = event_name;
                    //Event Type hardcoded for now
                    jsonData.event_type = "exam";
                    start_date = $('add_event_date').val();

                    //Hard coded doris needs to fix front end 
                    end_date = start_date;
                    if(start_date === '') alert("Add Date please");
                    else{
                        jsonData.end_date = end_date;
                        jsonData.start_date = start_date; 
                    }
                    start_time = $('set_time_24hr').val();
                    //Hard coded Doris needs to fix front end
                    end_time = start_time;
                    if(start_time === '') alert("Add time please");
                    else{
                        jsonData.end_time = end_time;
                        jsonData.start_time = start_time; 

                        if(end_time != "" && end_date != ""){
                            var updatedJsonData = {
                                event : jsonData
                            }
                            //Send's it in the even't format Alex requested for events ONLY
                            postStatusAjax(updatedJsonData);
                        }
                    }


                }
            //NOTES POST 
            } else if(post_type === 'notes'){
                console.log("Ine nore");
                var fileSelect = $('._uplI').files;
                console.log(fileSelect);
                if(fileSelect){
                    var formData = new FormData();
                    $.each(fileSelect, function(key, value)
                        {
                            formData.append(key, value);
                        });
                    jsonData.files = formData;
                    postStatusAjax(jsonData);
                } else {
                    $('.uplName').css("color", "red");
                }
            //QUESTION POST
            } else if (post_type === 'question') {
                jsonData.question_type = question_type;
                var text = $('.topfbar').val();
                console.log(question_type);
                //REQULAR QUESTIONS TYPE
                if(question_type === "regular_type"){
                     var sub_text = $('.askTxtArea').val();
                     if(text === '') $('.topfbar').css("border-bottom", "solid 3px red");
                     else {
                        //if there is sub text set jsonData.sub_text = it
                        if(sub_text != '') jsonData.sub_text = sub_text;
                        //get the text
                        jsonData.text = text;
                        //make the AJAX Call
                        //alert(JSON.stringify(jsonData));
                        postStatusAjax(jsonData);

                     }
                //MULTIPLIC CHOICE QUESTION TYPE
                } else if(question_type === "multiple_type"){
                    if(text === '') $('.topfbar').css("border-bottom", "solid 3px red");
                    else {
                        var choice_a = $('#choice_a').val();
                        var choice_b = $('#choice_b').val();
                        console.log(choice_a);
                        console.log(choice_b);
                        if((choice_a != "") && (choice_b != "")){
                            question = {
                                'text' : text, 
                                'choices' : {'a' : choice_a,
                                             'b' : choice_b}
                                
                            }
                            var choice_c = $('#choice_c').val();
                            var choice_d = $('#choice_d').val()
                            if(choice_c != '') question['choices'].c = choice_c;
                            if(choice_d != '') question['choices'].d = choice_d;
                            correct_answer = 'a';
                            question.answer = correct_answer;
                            jsonData.question = question;
                            alert(JSON.stringify(jsonData));
                            postStatusAjax(jsonData);


                        } else{
                            if(choice_a === ''){
                              $('#choice_a').css('border-bottom', 'solid 2px red');
                            } else if(choice_b === ''){
                              $('#choice_b').css('border-bottom', 'solid 2px red');
                            } else{
                              $('#choice_a').css('border-bottom', 'solid 2px red');
                              $('#choice_b').css('border-bottom', 'solid 2px red');
                            }

                        }
                    }
                //TRUE OR FALSE QUESTION TYPE
                } else if(question_type === "truth_type"){
                    if(text === '') $('.topfbar').css("border-bottom", "solid 3px red");
                    else {
                         correct_answer = 'ture';
                         question = {
                                'text' : question, 
                                'answer' : correct_answer
                         };
                         jsonData.question = question;
                         postStatusAjax(jsonData);


                    }
                //QUESTION TYPE DOESN'T EXIST
                } else {
                    alert("Something is wrong");
                }
                //Adds all expert tags into the array experts
               /* var experts  = $(".midfbar-exp .tag-name").map(function() {
                    return $(this).text();
                }).get();
                //adds experts to jsonData
                if (experts.length > 0) jsonData.ask_experts = experts;*/
                //Gets the top text

           
            } //POST TYPE DOESNT EXIST
        } else {
          alert("Can't make a post yet");
        }

    });
    
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
        var $fbar_new = $("#fbar_new");

        $fbar_new.addClass("fbar_shadow");


        
        var button_selected_type = $button_selected.attr("data-post_button_type");
        $("#fbar_holder").addClass(button_selected_type);
        $("#fbar_holder").attr('data-post_type', button_selected_type);


        if($("#fbar_holder").hasClass("event")){
            $("#post_btn").text("Create Event");
        }

        if($("#fbar_holder").hasClass("discuss")){
            $("#post_btn").text("Post");
        }

        if($("#fbar_holder").hasClass("question")){
            $("#post_btn").text("Add Question");
        }

        if($("#fbar_holder").hasClass("question")){
            $("#post_btn").text("Add Question");
        }

        if($("#fbar_holder").hasClass("notes")){
            $("#post_btn").text("Add Files");
        }

        if($("#fbar_holder").hasClass("opportunity")){
            $("#post_btn").text("Share Opportunity");
        }


        var $button_section = $('#fbar_buttons');
        var $form_section = $('form#fbar_form')
        $button_section.addClass("faded").delay(150).queue(function(next){
            $button_section.addClass("hide");
            $form_section.addClass("show").delay(250).queue(function(next2){
                $form_section.addClass("fadeIn");
                
                $(".autofocus").focus();

                $("form#fbar_form").css({"overflow":"visible"});
                next2();
            });
            next();

        });
      
    });

    
    $(document).delegate('.event_more_options', "click", function () { 
        if($("#fbar_holder").hasClass("events_more_options")){
            $(this).closest("#fbar_holder").removeClass("events_more_options");
            $(this).text("More Options");
        }
        else{
            $(this).closest("#fbar_holder").addClass("events_more_options");
            $(this).text("Fewer Options");
        }
        
    });

    $(document).delegate('.opportunity_more_options', "click", function () { 
        if($("#fbar_holder").hasClass("opps_more_options")){
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
            var $audience_select_list = $("#audience_select_list");


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



        $('#fbar_holder').attr('data-post_type', $button_selected.attr('data-question_post_type'));
        $(this).addClass("active"); 
        var question_button_selected_type = $button_selected.attr("data-question_post_type"); 
        var parent_form = $button_selected.closest("#fbar_form");
        if(question_button_selected_type == "multiple_choice"){
            $(parent_form).addClass("mult_choice");
            $(parent_form).removeClass("true_or_false");
            $(".autofocus").focus();
            $(parent_form).removeClass("regular_question");
        }
        if(question_button_selected_type == "true_false"){
            $(parent_form).addClass("true_or_false");
            $(".autofocus").focus();
            $(parent_form).removeClass("mult_choice");
            $(parent_form).removeClass("regular_question");
        }
        if(question_button_selected_type == "hide_both"){
            $(parent_form).addClass("regular_question");
            $(parent_form).removeClass("mult_choice");
            $(".autofocus").focus();
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
            if($(".answer_check input").prop("checked", true)) {
                $(".answer_check input").prop("checked", false);
                $(".answer_check").removeClass("selected_answer");
                $(".answer_check").css("display", "none");
                $(this).prop("checked", true);
                $(this).parent().addClass("selected_answer");
                $(this).parent().css("display", "inline-block");
            }
        }
    }); 


    $('.menu_audience').dropit({
    });
    $('.privacy_menu').dropit({
    });

    $(".privacy_dropdown_link").click(function(){
        $("#privacy_tooltip").hide();
    });

    $("li.privacy_list").click(function(){
        $("li.privacy_list").removeClass("active");
        $(this).addClass("active");
    });

    

    $(".privacy_dropdown_link").mouseenter(function(){
        $("#privacy_tooltip").fadeIn(250);
    });

    $(".privacy_dropdown_link").mouseleave(function(){
        $("#privacy_tooltip").fadeOut(250);
    });




    function close_fbar(){


        var $button_section = $('#fbar_buttons');
        var $form_section = $('form#fbar_form');

        var $fbar_new = $("#fbar_new");

        $fbar_new.removeClass("fbar_shadow");

        $("#fbar_holder").attr('data-post_type','');

        $form_section.removeClass("fadeIn");
        $form_section.removeClass("show").delay(350).queue(function(next){
            $button_section.removeClass("faded");
            $button_section.removeClass("hide");
                    $("#fbar_holder").removeClass("discuss");
                    $("#fbar_holder").removeClass("opportunity");
                    $("#fbar_holder").removeClass("question");
                    $("#fbar_holder").removeClass("event");
                    $("#fbar_holder").removeClass("notes");

                    $form_section.removeClass("true_or_false");
                    $form_section.removeClass("mult_choice");
                    $form_section.removeClass("regular_question");
                    $(".question_type_button.active").removeClass("active");
                    $(".question_type_button.regular_question").addClass("active");
                    $("#fbar_holder").removeClass("events_more_options");
                    $(".event_more_options").text("More Options");
                    $("form#fbar_form").css({"overflow":"hidden"});
            next();

        });
    }

    $(document).delegate('#fbar_footer > #cancel_btn', "click", function () {
        reset_fbar();
    });

    $('textarea').autosize();

    $('.audience_name').click(function(){
        var $selected_audience = $(this);
        var selected_audience_text = $selected_audience.find("a").text();
        $(".selected_audience").text(selected_audience_text);
    });





    last_file_count = 0;
    success_counter = 0;
    Dropzone.autoDiscover = false;


    var $fbar_dropzone_form = $('.dropzone#fbar_file_form');
//    Dropzone.options.fbar_file_form = {
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
                        render_post(response['post']);

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
                var removeButton = $("<span class='file_x_icon'>Remove file</span>");

                // Add the button to the file preview element.
                $file.append(removeButton);

                var last_modified = $file.attr('data-last_modified');
                var name = $file.attr('data-name');

                $file.find('.file_x_icon').on('click',function(e) {
                    console.log('REMOVE');

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
//    }






    function reset_fbar(){
        var $fbar_holder = $('#fbar_holder');

        var post_type = $fbar_holder.attr('data-post_type');




        //Clear all dropzone files
        globals.myDropzone.files = [];


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


        close_fbar();
    }

    function get_post_data(){
        var $fbar_holder = $('#fbar_holder');

        var post_type = $fbar_holder.attr('data-post_type');


        var $post_text_area = $fbar_holder.find('.post_text_area');

        var post_text = $post_text_area.val();


        var post_data = {};



        post_data['text'] = post_text;
        post_data['post_type'] = post_type;


        post_data['origin_type'] = globals.origin_type;
        post_data['origin_id'] = globals.origin_id;


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



        post_data['anon'] = 0;

        post_data['like_count'] = 0;


        if(post_type == 'question' || post_type == 'true_false' || post_type == 'multiple_choice'){
            post_data['question'] = {};

            post_data['question']['anonymous'] = 0;
            post_data['question']['live_answers'] = 0;
            post_data['text'] = $('#post_title').val();
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
            var start_time = $('#start_time').attr('data-time');
            var end_date = $('#event_end_date').attr('data-date');
            var end_time = $('#event_end_time').attr('data-time');
            var location = $('#event_location').val();

            var description = $('.event_textarea').find('.post_text_area').val();





            post_data['event'] = {};
            post_data['event']['title'] = event_title;
            post_data['event']['start_date'] = (start_date) ? start_date : '';
            post_data['event']['start_time'] = (start_time) ? start_time : '';
            post_data['event']['end_date'] = (end_date) ? end_date : '';
            post_data['event']['end_time'] = (end_time) ? end_time : '';
            post_data['event']['description'] = description;
            post_data['event']['location'] = location;
            post_data['event']['origin_type'] = globals.origin_type;
            post_data['event']['origin_id'] = globals.origin_id;


        }


        alert(JSON.stringify(post_data));


        return post_data;
    }







    function post_data_is_valid(post_data){



    }



    $(document).on('click', '.post_btn', function(){
        var $fbar_holder = $('#fbar_holder');

        var post_type = $fbar_holder.attr('data-post_type');


        var $post_text_area = $fbar_holder.find('.post_text_area');




        //Check if there are any files
        var $file_form = $('#fbar_file_form');
        //alert($file_form.children('div.dz-preview').length);
        console.log(globals.myDropzone.files);


        var post_data = get_post_data();

//        alert(JSON.stringify(post_data));
        //Check if this data is good
        if(post_type == 'discuss'){
            if(post_data['text'] == ''){
                alert('Please input post text');
                return;
            }
        }else if(post_type == 'notes' || post_type == 'files'){
            //Check if there is atleast one file
            if(globals.myDropzone.files.length == 0){
                alert('Please upload atleast one file.');
                return;
            }
        }else if(post_type == 'question' ){

            if(post_data['text'] == ''){
                alert('Please input a question');
                return;
            }

            if(post_type == 'multiple_choice'){
                if(post_type['question']['options'].length < 2){
                    alert('Please input atleast 2 options for a question');
                    return;
                }
            }

        }


        if(post_type == 'event'){
            if(post_data['event']['title'] == ''){
                alert('Please input a title');
                return;
            }

            if(post_data['event']['start_date'] == ''){
                alert('Please input a start date');
                return;
            }

            if(post_data['event']['start_time'] == ''){
                alert('Please input a start time');
                return;
            }

            if(post_data['event']['end_date'] == ''){
                alert('Please input an end date');
                return;
            }

            if(post_data['event']['end_time'] == ''){
                alert('Please input an end time');
                return;
            }



            var start_datetime = new Date(post_data['event']['start_date'] + ' ' + post_data['event']['start_time']);
            var end_datetime = new Date(post_data['event']['end_date'] + ' ' + post_data['event']['end_time']);


            if(end_datetime < start_datetime){
                if(post_data['event']['start_date'] == post_data['event']['end']){
                    alert('Invalid end time');
                    return;
                }else{
                    alert('Invalid end date');
                    return;
                }
            }

        }




        console.log('SENDING FILES');


        //If there are any files, submit the post request through dropzone
        if(globals.myDropzone.files.length > 0){
            globals.myDropzone.processQueue();
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

                    console.log(JSON.stringify(response));

                    if(response['success']){
                        reset_fbar();
                        render_post(response['post']);
                    }else{

                    }
                }, 'json'
            );
        }




        //$file_form.submit();


    });




    $('#fbar_form').submit(function(e){
        e.preventDefault();
    });




    // .off('click', '#selector_id').
    $(document).on('click', '.upload_button', function(e){
        e.preventDefault();
        e.stopPropagation();

        $('.fbar_file_form.dropzone').click();
    });


    $(document).on('click', '#post_photos', function(e){
        e.preventDefault();
        e.stopPropagation();

        $('.fbar_file_form.dropzone').click();
    });



//    $('.upload_button').click(function(e){
//        e.stopPropagation();
//
//        $('.dropzone').click();
//    });

    $('#post_attachments').click(function(e){
        e.stopPropagation();
        $('.fbar_file_form.dropzone').click();
    });










});