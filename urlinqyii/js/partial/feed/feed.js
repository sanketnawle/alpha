
$(document).ready(ready(globals));
//$.embedly.defaults.key = '94c0f53c0cbe422dbc32e78d899fa4c5';

function ready(globals){

    //alert(globals.feed_url);
    //alert(JSON.stringify(globals));


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

    //$ = jQuery.noConflict();
    //Handlebars helpers


    globals.first_request = true;

    init();
    function init(){
        get_post_data(globals.base_url,globals.feed_url);
    }





    var last_created_at = '';
    var last_last_activity = '';

    function get_post_data(this_base_url,this_feed_url){

        //alert('feed url ' + this_feed_url);

        var get_data = {};

        //See if there are any posts on the page.
        //If there is, get the last one
        //and strip its created_at and last_activity data
        var $first_post = $('#posts').find('.post').last();


        var param_string = '';
        if($first_post.length){
            var created_at = $first_post.attr('data-created_at');
            var last_activity = $first_post.attr('data-last_activity');

            if(created_at === last_created_at){
                //console.log('returning request');
                //Dont remake the same request
                return;
            }

            get_data['created_at'] = created_at;
            get_data['last_activity'] = last_activity;

            last_created_at = created_at;
        }



        $.getJSON( this_base_url + this_feed_url, {params: JSON.stringify(get_data)}, function( json_feed_data ) {
            if(json_feed_data['success']){
                //alert(JSON.stringify(json_feed_data));
//                alert(JSON.stringify(json_feed_data));

                if(json_feed_data['feed'].length == 0 && globals.first_request){
                    var $posts_container = $("#posts");
                    $posts_container.html("<div class = 'no_posts_container'><div class = 'no_posts_icon small_icon_map'></div><div class = 'no_posts_message'><div class = 'message_header'>Welcome to the feed.</div><div class = 'message_sub'>Be the first to make a post.</div></div></div>");
                }else{
                    render_posts(json_feed_data['feed']);
                }


                globals.first_request = false;

            }else{
                //alert('failed to get feed');
            }
        });

    }
    var question_data = [];
    var closed_questions = [];
    var colors = ["#f04b5b","#4BAEF0","#FFFF4D","#8DEE6D"];
    var highlights = ["#f26370","#63b9f2","#FFFF80","#BEF5AB"];
    function show_question_data(post_id,options_data){
        var pi_0 = $(".pie_"+post_id).get(0).getContext("2d");
        var answer_data = [];
        var answers = options_data;

        for(var i=0;i<answers.length;i++) {
            answer_data[i]={
                label:answers[i]['option_text'],
                value: answers[i]['participants_count'],
                color: colors[i],
                highlight: highlights[i]
            }
        }
        question_data[post_id] = new Chart(pi_0).Doughnut(answer_data, {
            percentageInnerCutout : 0,
            segmentShowStroke : false,
            showTooltips: true,
            animationSteps : 50,
            animationEasing: "easeOutCubic"
        });

    }
    //function single_question_analytics()
    function render_posts(jsonData){

        $.each(jsonData ,function(key,post) {
            //alert(JSON.stringify(post));
            //jsonData['key'].jsonData[key]['replies'][0]);
            //if(jsonData[key]['anon'] === '0') jsonData[key]['anon'] = '';
            //if(jsonData[key]['user_id'] === '0') jsonData[key]['user_id'] = '';
            //var time = new Date(jsonData[key]['created_time']);
            //jsonData[key]['created_time'] = time








            for(i = 0; i < post['replies'].length; i++){
                post['replies'][i]['update_timestamp'] = moment(post['replies'][i]['update_timestamp'], "X").fromNow();
            }
            add_embedly_to_replies(post['replies']);
            if(post['reply_count'] >  2) {
                post.show_more = true;

                var post_id = post['post_id'];
                var theReplies = post['replies'];
                replies[post_id.toString()] = theReplies;
                post['replies'] = [post['replies'][0], post['replies'][1]];
            }



            if(post['post_type'] == 'question' && post['question']['question_type'] == 'multiple_choice'){
                var alphabet= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

                for(i = 0; i < post['options'].length; i++){
                    post['options'][i]['the_choice_letter'] = alphabet.charAt(i);

                }
            }


            if(post['post_type'] == 'multiple_choice' || post['post_type'] == 'true_false'){
                for(var i=0;i<post['question']['options'].length;i++){
                    post['question']['options'][i]['color'] = colors[i];
                    post['question']['options'][i]['percentage'] =
                        (post['question']['options'][i]['participants_count'] /
                        post['question']['total_answers']) * 100;
                    //post['question']['options'][i]['highlight'] = highlights[i];
                }
                //post['question']['closed'] = !post['question']['active'];
                post['question']['active'] = (post['question']['active'] == "1");
                post['question']['closed'] = !post['question']['active'];
                post['question']['show_stats'] = post['pownership'] || post['question']['public_stats'] == "1";
                console.log('show stats '+post['question']['show_stats'])
            }

            post['update_timestamp'] = moment(post['update_timestamp'], "X").fromNow();



            render_post(post);

            if(post['post_type'] == 'multiple_choice' || post['post_type'] == 'true_false'){
                if(post['question']['show_stats']){
                    show_question_data(post['post_id'],post['question']['options']);
                    closed_questions[post['post_id']]= post['question']['closed'];
                }else{
                    question_data[post['post_id']] = "none";
                }
            }
        });
    }


    Handlebars.registerHelper("theFileType", function(type, id){
        if(type === 'image') return new Handlebars.SafeString("class='post_attachment_review_img' src='https://urlinq.com/beta/includes/getimage.php?id={{file_id}}'>");
        var fileString  = "src=https://urlinq.com/beta/src/comment_attach.png class='post_attach_head_img'><a class = 'file-download' href='javascript:download(" + id + ")'>" +  id + "</a>"
        return new Handlebars.SafeString(fileString);
        //return new Handlebars.SafeString("hi");
    });

    function render_post_with_url(single_post){

        var url = findUrlInPost(single_post['text']);
        console.log(url);
        single_post['text'].replace(url,'<a href="'+url+'">'+url+'</a>');
        single_post.embed_link = url;

    }




    //findUrlInPost("hellllhttps://looooowww.sitepoint.com/jquery-basic-regex-selector-examples/chellll oasdfjlei'dfdfd'https://looooowww.sitepoint.com/jquery-basic-regex-selector-examples/chellll https://looooowww.sitepoint.com/jquery-basic-regex-selector-examples/chellll https://looooowww.sitepoint.com/jquery-basic-regex-selector-examples/chellll https://looooowww.sitepoint.com/jquery-basic-regex-selector-examples/chellll https://looooowww.sitepoint.com/jquery-basic-regex-selector-examples/chellll");


    //Parsess through a chunck of text to find an url the end is delimitted by a space and the front by either https
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




//    $('body').scroll(function() {
//
////       if($(window).scrollTop() + $(window).height() == $(document).height()) {
////           alert("bottom!");
////       }
//    });



    function update_question_data(post_id){

        var chart = question_data[post_id];

        var post_url = globals.base_url+"/post/getQuestionStats";
        var post_data = {post_id:post_id};
        $.post(
            post_url,
            post_data,
            function(response){
                if(response['success']){



                    var $post = $('.post[data-post_id='+post_id+']');
                    var $question_analytics_holder = $post.find('.question_analytics_holder');
                    if(!$post.find('.mc_question_one_choice').hasClass('closed') && response['closed']){
                        close_question($post,response['correct_answer'],response['your_answer']);
                    }
                    if(response['public_stats']=="1"){
                        if(!$question_analytics_holder.is(':visible')){
                            $question_analytics_holder.fadeIn(250);
                            show_question_data(post_id,response['results']);
                        }

                    }else if(response['owner'] == false){
                            $question_analytics_holder.fadeOut(250);

                    }
                    if($question_analytics_holder.is(':visible')){
                        var count = parseInt($question_analytics_holder.attr('data-answer_count'));
                        $question_analytics_holder.attr('data-answer_count', response['answer_count']);
                        if(response['answer_count']==0){
                            $post.find('.chart_overlay').fadeIn(250);
                        }else if(count == 0 && response['answer_count']>0){

                            show_question_data(post_id,response['results']);
                            $post.find('.chart_overlay').fadeOut(250);
                        }else{
                            for(var i=0;i<chart.segments.length;i++){
                                var count;
                                for(var j=0;j<response['results'].length;j++){

                                    if(response['results'][j]['option_text']==chart.segments[i].label){
                                        count=response['results'][j]['participants_count'];
                                    }
                                }
                                chart.segments[i].value = count;
                            }
                            chart.update();
                        }
                    }
                }
            }

        );


    }
    $(document).on('click', '.submit_answer', function() {
        var $question = $(this).closest('.mc_question');
        var $radio = $question.find('.mc_question_radio_button:checked');
        var post_id = $radio.closest('.post').attr('data-post_id');
        var option_id = $radio.closest('.mc_question_one_choice').attr('data-option_id');
        if($radio.length==0){
            $question.closest('.post').find('.submitted_answer').text('Select an answer');
            $question.closest('.post').find('.submitted_answer').fadeIn(250);
            return;
        }
        //alert(option_id);

        var post_url = globals.base_url + '/post/answerQuestion';

        var post_data = {option_id: option_id};

        $.post(
            post_url,
            post_data,
            function(response){
                console.log(response);
                $question.closest('.post').find('.submitted_answer').text('Submitted');
                $question.closest('.post').find('.submitted_answer').fadeIn(250);
                update_question_data(post_id);
                //alert(JSON.stringify(response));
            },'json'
        );
    });

    $(document).on('click','.clear_answer',function(){
        var $post = $(this).closest('.post');

        $post.find('.mc_question_radio_button:checked').prop('checked',false);
        $post.find('.submitted_answer').fadeOut(250);
        /*var post_id = $post.attr('data-post_id');
        var post_url = globals.base_url + '/post/clearQuestion';

        var post_data = {post_id: post_id};
        $.post(
            post_url,
            post_data,
            function(response){
                console.log(response);
                update_question_data(post_id);
                $post.find('.mc_question_radio_button:checked').prop('checked',false);
                $post.find('.submitted_answer').fadeOut(250);
                //alert(JSON.stringify(response));
            },'json'
        );*/
    });
    function close_question($post,correct_answer,your_answer){
        var post_id = $post.attr('data-post_id');
        closed_questions[post_id] = true;
        $post.find('.question_functions *').fadeOut(250);
        $post.find('.question_functions').text('This question is closed.');
        $post.find('.submitted_answer').fadeOut(250);
        $post.find('.mc_question_radio_button:checked').prop('checked',false);
        $post.find('.mc_question_radio_button').attr('disabled',true);
        $post.find('.mc_question_one_choice').addClass('closed');

        if(correct_answer){
            $post.find('.mc_question_radio_button[data-option_id='+correct_answer+']').addClass('green');
            // $post.find('span.correct_answer').text(response['correct_answer']);
        }
        if(your_answer){
            if(correct_answer && your_answer != correct_answer){
                $post.find('.mc_question_radio_button[data-option_id='+your_answer+']').addClass('red');
            }else{
                $post.find('.mc_question_radio_button[data-option_id='+your_answer+']').addClass('blue');
            }
        }
    }
    $(document).on('click','.close_question',function(){
        var $post = $(this).closest('.post');
        var post_id = $post.attr('data-post_id');
        var post_url = globals.base_url + '/post/closeQuestion';
        var post_data = {post_id: post_id};
        $.post(
            post_url,
            post_data,
            function(response){
                if(response['success']){
                    close_question($post,response['correct_answer'],response['your_answer']);
                }

            },'json'
        );
    });
    $(document).on('click','.show_hide_stats',function(){
        var checked = $(this).is(':checked');
        var $post = $(this).closest('.post');
        var post_id = $post.attr('data-post_id');
        var post_url = globals.base_url + '/post/showHideStats';
        var post_data = {post_id: post_id, checked:checked};
        $.post(
            post_url,
            post_data,
            function(response){
                console.log(response);
                //update_question_data(post_id);
               // $post.find('.mc_question').fadeOut(250);
                //$post.find('.mc_question').delete();
                //alert(JSON.stringify(response));
            },'json'
        );
    });



    var i = 0;
    var replies = {};


    $(document).on('click', '.lesscmt_bar', function(){
        if($(this).parent(".master_comments").hasClass('video_comments'))
            return;
        var source   = $("#reply_more_template").html();
        var template = Handlebars.compile(source);
        var id = $(this).parent(".master_comments").attr("id");
        var array = {'replies' : [replies[id][0],replies[id][1]]};
        $(this).parent(".master_comments").html(template(array));
        add_embedly_to_replies(replies[id]);
    });



    $(document).on('click', '.morecmt_bar', function(){
        if($(this).parent(".master_comments").hasClass('video_comments'))
            return;
        var source   = $("#reply_template").html();
        var template = Handlebars.compile(source);
        var id = $(this).parent(".master_comments").attr("id");
        var array = {'replies' : replies[id]};
        $(this).parent(".master_comments").html(template(array));
        add_embedly_to_replies(replies[id]);

    });


    $(document).on('click','.post_like', function(){


        var $post_like_button = $(this);
        var $like_number = $post_like_button.find('.like_number');


        var post_data;
        var post_url;
        if($(this).closest('.post').hasClass('video_box_post')){
            var video_id = $(this).closest('.post').attr('data-video_id');
            post_url = globals.base_url + '/video/like';
            post_data = {video_id: video_id, user_id: globals.user_id};
        }else{
            var post_id = $(this).closest('.post').attr('data-post_id');
            post_url = globals.base_url + '/post/like';
            post_data = {post_id: post_id, user_id: globals.user_id};
        }


        $.post(
            post_url,
            post_data,
            function(response) {
                if(response['success']){
                    if($like_number.length){
                        $like_number.text(parseInt($like_number.text())+1);
                    }else{
                        $post_like_button.append('<div class = "like_number">1</div>');
                    }
                    $post_like_button.find(".post_like_link").text("");
                    $post_like_button.removeClass('post_like');
                    $post_like_button.addClass('post_liked');

                }else{
                }
            }, 'json'
        );
    });


    $(document).on('click','.post_liked', function(){
        var $post_like_button = $(this);
        var $like_number = $post_like_button.find('.like_number');
        var post_data;

        var post_url;

        if($(this).closest('.post').hasClass('video_box_post')){
            var video_id = $(this).closest('.post').attr('data-video_id');
            post_url = globals.base_url + '/video/unlike';
            post_data = {video_id: video_id, user_id: globals.user_id};
        }else{
            var post_id = $(this).closest('.post').attr('data-post_id');
            post_url = globals.base_url + '/post/unlike';
            post_data = {post_id: post_id, user_id: globals.user_id};
        }

        $.post(
            post_url,
            post_data,
            function(response) {
                if(response['success']){
                    if($like_number){
                        if(parseInt($like_number.text())==1){
                            $like_number.remove();
                        }else{
                            $like_number.text(parseInt($like_number.text())-1);
                        }
                    }
                    $post_like_button.find(".post_like_link").text("Like");
                    $post_like_button.removeClass('post_liked');
                    $post_like_button.addClass('post_like');

                }else{
                }
            }, 'json'
        );
    });





    $(document).on('click', '.reply_delete_button', function(){
        if($(this).closest('.master_comments').hasClass('video_comments'))
            return;
        var $reply_delete_button = $(this);
        var $reply = $reply_delete_button.closest('.comment_main');

        var reply_id = $reply.attr('data-reply_id');

        var post_url = globals.base_url + '/reply/' + reply_id + '/delete';
        var post_data = {id: reply_id};


        //Start hiding reply immediately
        $reply.fadeOut('fast', function(){

        });


        $.post(
            post_url,
            post_data,
            function(response){
                if(response['success']){
                    //remove reply from html if success
                    var $reply_count = $reply_delete_button.closest(".post").find('.reply_number');

                    if(parseInt($reply_count.text())==1){
                        $reply_count.remove();

                    }else{
                        $reply_count.text(parseInt($reply_count.text())-1);
                    }
                    $reply.closest('.comments').remove();


                }else{
                    //Show the reply again since it wasnt
                    //sucessfully deleted
                    $reply.show();
                    alert(JSON.stringify(response));
                }
            }, 'json'
        );


    });




    $(document).on('click','.reply_button', function(){
        var $reply_form = $(this).closest('.reply_form');
        $reply_form.submit();
    });
    $(document).on('click','.post_like_btn', function(e){
        e.stopPropagation();
        var $post_like_btn = $(this);
        $post_like_btn.find("i").toggleClass("press", 1000);
        $post_like_btn.find("span").toggleClass("press", 1000);
        $post_like_btn.find(".like_number").toggleClass("press", 1000);
    });

    $(".post_like_btn").one( "click", function() {
      //alert();
    });


    $(document).on('click','.option_hide',function(){
        var $hide_button = $(this);

        var $post = $hide_button.closest('.post');

        var post_id = $post.attr('data-post_id');

        var post_data = {'post_id':post_id};

        $.post(
            globals.base_url + '/post/hide',
            post_data,
            function(response) {

                if(response['success']){
                    console.log('Successfully hid post ' + post_id);
                    $post.remove();
                }else{
                    alert('Error hiding this post');
                }
            }, 'json'
        );
    });
    $(document).on('click','.option_report',function(){
        var $report_button = $(this);

        var $post = $report_button.closest('.post');

        var post_id = $post.attr('data-post_id');

        var post_data = {'post_id':post_id};

        $.post(
            globals.base_url + '/post/report',
            post_data,
            function(response) {

                if(response['success']){
                    console.log('Successfully reported post ' + post_id);
                   // $post.remove();
                }else{
                    alert('Error reporting this post, please try again later');
                }
            }, 'json'
        );
    });
    $(document).on('click', '.option_delete', function(){

        var $delete_button = $(this);


        var $post = $delete_button.closest('.post');

        var post_id = $post.attr('data-post_id');

        var event_id=null;
        if($post.is('[data-event_id]')){
            event_id = $post.attr('data-event_id');
        }

        var post_data = {'post_id': post_id};

        if(event_id !=null){
            post_data.event_id = event_id;
        }

        $.post(
            globals.base_url + '/post/delete',
            post_data,
            function(response) {

                if(response['success']){
                    console.log('Successfully deleted post ' + post_id);
                    $post.remove();
                    if(event_id){
                        $('#planner_body_holder').find('.event[data-event_id='+event_id+']').remove();
                    }
                }else{
                    alert('Error deleting this post, please try again later');
                }
            }, 'json'
        );

    });


    var reply_form_lock = false;

    $(document).on('submit','.reply_form', function(event){
        event.preventDefault();
        if(!reply_form_lock){
            reply_form_lock = true;



            var $reply_form = $(this);
            var is_video_reply = $reply_form.hasClass('video_reply_form');

            var reply_text = $reply_form.find('.reply_text_textarea').val();

            if(reply_text.length == 0){
                alert('You must input something');
                reply_form_lock = false;
                return;
            }


            var anonymous = $reply_form.find('.check_wrap .flat7b').hasClass('flat_checked') ? 1:0;
            var reply_user_id = globals.user_id;
            var $reply_count = $reply_form.closest(".post").find('.reply_number');
            var post_data;
            var video_id;
            var post_url;
            var post_id;
            if(is_video_reply){
                video_id = $reply_form.attr('data-video_id');
                post_data = {video_id: video_id, reply_text: reply_text, reply_user_id: reply_user_id, anonymous: anonymous};
                post_url = globals.base_url + '/video/reply';
            }else{
                post_id = $reply_form.attr('data-post_id');
                post_data = {post_id: post_id, reply_text: reply_text, reply_user_id: reply_user_id, anonymous: anonymous};
                post_url = globals.base_url + '/post/reply';
            }
            if(findUrlInPost(post_data['reply_text'])) {
                var url = findUrlInPost(post_data['reply_text']);
                post_data['reply_text']=post_data['reply_text'].replace(url,'<a href="'+url+'" target = "_blank" >'+url+'</a>');
            }
            post_data['reply_text']=post_data['reply_text'].replace(/(?:\r\n|\r|\n)/g, '<br />');


            console.log('SENDING POST REPLY');
            console.log(post_data);

            $.post(
                post_url,
                post_data,
                function(response) {
                    if(response['success']){
                        reply_form_lock = false;
                        var source;
                        if(is_video_reply){
                            source = $("#video_one_reply_template").html();
                        }else{
                            source = $("#one_reply_template").html();
                        }

                        var template = Handlebars.compile(source);
                        response['reply']['update_timestamp'] = moment(response['reply']['update_timestamp'], "X").fromNow();
                        $reply_form.closest(".post").find('.master_comments').append(template(response['reply']));
                        $reply_form.find('.reply_text_textarea').val('');

                        if($reply_count.length){
                            $reply_count.text(parseInt($reply_count.text())+1);
                        }else{
                            $reply_form.closest(".post").find('.post_comment_btn').append('<div class = "reply_number">1</div>');
                        }
                        if(url){
                            $.embedly.oembed(url,{
                                key:'94c0f53c0cbe422dbc32e78d899fa4c5',
                                query:{
                                    maxwidth: 400,
                                    maxheight: 400,
                                    chars: 100
                                }}).done(function(results){
                                    if(!results.invalid){
                                        embedly_info = results[0];
                                        append_embedly(response['reply']['reply_id'],embedly_info);
                                    }
                                }
                            );
                        }

                    }else{
                        alert(JSON.stringify(response));
                    }
                }, 'json'
            );
        }

    });
    function add_embedly_to_replies(replies){
        $.each(replies,function(index,reply){
            if(findUrlInPost(reply['reply_msg'])) {
                var url = findUrlInPost(reply['reply_msg']);
                //  post['replies'][index]['reply_msg']=reply['reply_msg'].replace(url,'<a href="'+url+'">'+url+'</a>');
                $.embedly.oembed(url,{
                    key:'94c0f53c0cbe422dbc32e78d899fa4c5',
                    query:{
                        maxwidth: 200,
                        maxheight: 200,
                        chars: 100
                    }}).done(function(results){
                        if(!results.invalid){
                            embedly_info = results[0];
                            console.log(embedly_info);
                            append_embedly(reply['reply_id'],embedly_info);
                        }
                    }
                );
            }
        });
    }
    function append_embedly(reply_id, embedly_info){
        console.log('append embedly to reply '+reply_id);
        var source;



        if(embedly_info.type == "link"){
            source = $('#embedly_link_template').html();
        }else if(embedly_info.type == "video"){
            source = $('#embedly_video_template').html();

        }else if(embedly_info.type == "photo"){
            source = $('#embedly_photo_template').html();
        }
        var template = Handlebars.compile(source);

        if(globals.profile_open){
            $('#profile_wrapper').find('.comment_msg[id='+reply_id+']').append(template(embedly_info));
        }else{
            if($('.comment_msg[id='+reply_id+']').length){
                $('.comment_msg[id='+reply_id+']').append(template(embedly_info));
            }else{
                $('.comment_msg[data-video_reply_id='+reply_id+']').append(template(embedly_info));
            }

        }

    }

    $(document).on('click','.post_event_calendar_button.added',function(e){
        var $calendar_button = $(this);

        if($calendar_button.text()=="Added" || $calendar_button.hasClass('event_owner')){
            return;
        }else{
            e.stopPropagation();
        }

        $calendar_button.fadeOut(150);
        $calendar_button.next('.post_choose_attending').fadeIn(150);


    });

    $(document).on('click', '.add_to_calendar_button', function(e){


        var $calendar_button = $(this);

        if($calendar_button.hasClass('added')){
            return;
        }else{
            e.stopPropagation();
        }

//        var $event_post = $calendar_button.closest('.post[data-post_type="event"]');
//
//        if(!$event_post.length){
//            $event_post = $calendar_button.closest('.post[data-post_type="opportunity"]');
//        }

//        var event_id = $event_post.attr('data-event_id');
        var event_id = $calendar_button.attr('data-event_id');


        var post_url = globals.base_url + '/event/attend';

        var post_data = {event_id: event_id};


        $.post(
            post_url,
            post_data,
            function(response){
                if(response['success']){
                    $calendar_button.addClass('added');
                    //$calendar_button.fadeOut(150);
                    $calendar_button.next('.post_choose_attending').fadeIn(150);
                    $calendar_button.html('<span class = "add_to_cal_icon added"></span>Added');
                    add_event(response['event'])
                }else{
                    alert(JSON.stringify(response));
                }
            }
        );


    });
    $(document).on('mouseenter','.post_conflict_indicator',function(){
        $(this).next('.conflicting_event_popup').show();
    });
    $(document).on('mouseleave','.post_conflict_indicator',function(){
        $(this).next('.conflicting_event_popup').hide();
    });
    $(document).on('click','.post_choose_attending_button',function(){
        var $attend_button = $(this);
        var $attend_section = $attend_button.parent('.post_choose_attending');
        var event_id = $attend_section.attr('data-event_id');
        var attend_status = $attend_button.val();
        if(attend_status=="Yes"){
            attend_status='Attending';
        }else if(attend_status=="No"){
            attend_status='Not Attending';
        }else if(attend_status=="Maybe"){
            attend_status='Maybe Attending';
        }
        var post_url = globals.base_url + '/event/changeAttending';

        var post_data = {event_id: event_id, attend_status: attend_status};


        $.post(
            post_url,
            post_data,
            function(response){
                if(response['success']){
                  //  $attend_section.fadeOut(150);
                  //  var $calendar_button = $attend_section.prev('.post_event_calendar_button');
                  //  $calendar_button.html('<span class = "add_to_cal_icon added"></span>'+attend_status);

                 //   $calendar_button.show();


                }else{
                    alert(JSON.stringify(response));
                }
            }
        );
    });

    $(document).on('click','.event_link',function(e){
        e.preventDefault();
        e.stopPropagation();
        if($(this).hasClass('not_in_calendar')){
            return;
        }
        var start_date = $(this).attr('data-event_start_date');
        var event_id = $(this).attr('data-event_id');
        var re = /(\d+)-(\d+)-(\d+)/;
        var matches = start_date.match(re);
        var year, month, day;
        if(matches){
             year = parseInt(matches[1]);
             month = parseInt(matches[2]);
             day = parseInt(matches[3]);
        }

        console.log('asdf');
        window.name = event_id;
        window.location.href = globals.base_url + '/calendar#/day/'+day+'/'+month+'/'+year;

    });

    function isElementInViewport (el) {
        if(el === undefined){
            return;
        }

        //special bonus for those using jQuery
        if (typeof jQuery === "function" && el instanceof jQuery) {
            el = el[0];
        }

        var rect = el.getBoundingClientRect();

        return (
            rect.top >= 0
//            rect.top >= 0 &&
//            rect.left >= 0 &&
//            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && /*or $(window).height() */
//            rect.right <= (window.innerWidth || document.documentElement.clientWidth) /*or $(window).width() */
        );
    }


    $( "#page" ).scroll(function() {
        //Get the offset of the last post on the page
        var last_post = $('#posts').find('.post').last();


        if(last_post.length){
            //If the last post is in the viewport, load more posts
            if(last_post != undefined &&isElementInViewport(last_post)){
                //Loads more previous posts
                get_post_data(globals.base_url,globals.feed_url);
            }
        }


    });

    $(document).scroll(function(e) {
        e.preventDefault();
        e.stopPropagation();
//        console.log('height');
//        console.log($(document).height());
//        console.log('document scroll top');
//        console.log($(document).scrollTop());
//
//
//        console.log('window height');
//        console.log($(window).height());

//        if($(document).scrollTop() + $(window).height() >= $(document).height() - 50){
//            console.log('BOTTOM');
//        }



        //Get the offset of the last post on the page
        var last_post = $('#posts').find('.post').last();
        //console.log('LAST POST VISIBLE?');
        //console.log(isElementInViewport(last_post));


        if(last_post.length){
            //If the last post is in the viewport, load more posts
            if(last_post != undefined && isElementInViewport(last_post)){
                //Loads more previous posts
                get_post_data(globals.base_url,globals.feed_url);
            }
        }



    });

    /*$("div.master_comments").each(function() {
        var $master_comments_list = $(this);
        var $master_comments_comment = $(this).find("div.comments");
        $master_comments_comment.last().css({"border-bottom":"none"});
    });*/

    $("div.comments:last-of-type").css({"border-bottom":"none"});
    setInterval(function(){


        for(var i in question_data){

            if(!closed_questions[i]){
                update_question_data(i);
            }

        }
    },5000);

}
