
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

    //$ = jQuery.noConflict();
    //Handlebars helpers

    init();
    function init(){
        get_post_data(base_url,feed_url);
    }


    function get_post_data(base_url,feed_url){

        $.getJSON( base_url + feed_url, function( json_feed_data ) {
            if(json_feed_data['success']){
                //alert(JSON.stringify(json_feed_data));
//                alert(JSON.stringify(json_feed_data));
                render_posts(json_feed_data['feed'].reverse());
            }else{
                alert('failed to get feed');
            }
        });

    }

    function render_posts(jsonData){
        
        $.each(jsonData ,function(key,post) {
            //alert(JSON.stringify(post));
            //jsonData['key'].jsonData[key]['replies'][0]);
            //if(jsonData[key]['anon'] === '0') jsonData[key]['anon'] = '';
            //if(jsonData[key]['user_id'] === '0') jsonData[key]['user_id'] = '';
            //var time = new Date(jsonData[key]['created_time']);
            //jsonData[key]['created_time'] = time
            if(post['reply_count'] >  2) {
                post.show_more = true;

                var post_id = post['post_id'];
                var theReplies = post['replies'];
                replies[post_id.toString()] = theReplies;
                post['replies'] = [post['replies'][0], post['replies'][1]];
            }



            for(i = 0; i < post['replies'].length; i++){
                post['replies'][i]['update_timestamp'] = moment(post['replies'][i]['update_timestamp'], "X").fromNow(true);

            }

            if(post['post_type'] == 'question' && post['question']['question_type'] == 'multiple_choice'){
                var alphabet= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            
                for(i = 0; i < post['options'].length; i++){
                    post['options'][i]['the_choice_letter'] = alphabet.charAt(i);

                }    
            }
            



            post['update_timestamp'] = moment(post['update_timestamp'], "X").fromNow();

            

            render_post(post);
        });
    }



    Handlebars.registerHelper("theFileType", function(type, id){
        if(type === 'image') return new Handlebars.SafeString("class='post_attachment_review_img' src='https://urlinq.com/beta/includes/getimage.php?id={{file_id}}'>");
        var fileString  = "src=https://urlinq.com/beta/src/comment_attach.png class='post_attach_head_img'><a class = 'file-download' href='javascript:download(" + id + ")'>" +  id + "</a>"
        return new Handlebars.SafeString(fileString);
        //return new Handlebars.SafeString("hi");
    });

    function render_post_with_url(single_post){
        
        single_post.embed_link = findUrlInPost();

    }

    function render_post(single_post){
        //Event Posts
        //Announcements
        //Oppurtunities

        if(findUrlInPost(single_post['text'])) {
            single_post.embed_link = findUrlInPost(single_post['text']);

        }
        if(single_post['post_type'] === "discuss" || single_post['post_type'] === "discussion"){
            var source   = $("#post_template").html();
            var template = Handlebars.compile(source);
            $("#posts").prepend(template(single_post)).hide().fadeIn();;
        }
        else if(single_post['post_type'] === "notes" || single_post['post_type'] === "files") {
            console.log('note');
            var source   = $("#post_note_template").html();
            var template = Handlebars.compile(source);
            $("#posts").prepend(template(single_post)).hide().fadeIn();;
        }
        else if(single_post['post_type'] === "question" || single_post['post_type'] === "multiple_choice" || single_post['post_type'] === "true_false") {
            console.log("question");
            var source   = $("#post_question_template").html();
            var template = Handlebars.compile(source);
            $("#posts").prepend(template(single_post)).hide().fadeIn();;

        }
        else {
            var source   = $("#post_template").html();
            var template = Handlebars.compile(source);
            $("#posts").prepend(template(single_post)).hide().fadeIn();;
        }
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


    var i = 0;
    var replies = {};


    $(document).on('click', '.lesscmt_bar', function(){
        var source   = $("#reply_more_template").html();
        var template = Handlebars.compile(source);
        var id = $(this).parent(".master_comments").attr("id");
        var array = {'replies' : [replies[id][0],replies[id][1]]};
        $(this).parent(".master_comments").html(template(array));
    });



    $(document).on('click', '.morecmt_bar', function(){
        var source   = $("#reply_template").html();
        var template = Handlebars.compile(source);
        var id = $(this).parent(".master_comments").attr("id");
        var array = {'replies' : replies[id]};
        $(this).parent(".master_comments").html(template(array));
    });


    $(document).on('click','.post_like', function(){
        var $post_like_button = $(this);
        var post_id = $(this).closest('.post').attr('data-post_id');

        var post_data = {post_id: post_id, user_id: user_id};

        var post_url = base_url + '/post/like';

        $.post(
            post_url,
            post_data,
            function(response) {
                if(response['success']){
                    $post_like_button.find(".post_like_link").text("Unlike");
                    $post_like_button.removeClass('post_like');
                    $post_like_button.addClass('post_liked');

                }else{
                }
            }, 'json'
        );
    });


    $(document).on('click','.post_liked', function(){
        var $post_like_button = $(this);
        var post_id = $(this).closest('.post').attr('data-post_id');

        var post_data = {post_id: post_id, user_id: user_id};

        var post_url = base_url + '/post/unlike';

        $.post(
            post_url,
            post_data,
            function(response) {
                if(response['success']){
                    $post_like_button.find(".post_like_link").text("Like");
                    $post_like_button.removeClass('post_liked');
                    $post_like_button.addClass('post_like');

                }else{
                }
            }, 'json'
        );
    });



    $(document).on('click','.reply_button', function(){
        var $reply_form = $(this).closest('.reply_form');
        $reply_form.submit();
    });



    $(document).on('click', '.option_delete', function(){

        var $delete_button = $(this);



        var $post = $delete_button.closest('.post');

        var post_id = $post.attr('data-post_id');


        var post_data = {'post_id': post_id};


        $.post(
            globals.base_url + '/post/delete',
            post_data,
            function(response) {

                if(response['success']){
                    console.log('Successfully deleted post ' + post_id);
                    $post.remove();
                }else{
                    alert('Error deleting this post, please try again later');
                }
            }, 'json'
        );

    });

    $(document).on('submit','.reply_form', function(event){
        event.preventDefault();
        var $reply_form = $(this);
        var post_id = $reply_form.attr('data-post_id');
        var reply_text = $reply_form.find('.reply_text_textarea').val();

        if(reply_text.length == 0){
            alert('You must input something');
            return;
        }


        var anonymous = false;
        var reply_user_id = user_id;


        var post_data = {post_id: post_id, reply_text: reply_text, reply_user_id: reply_user_id, anonymous: anonymous};

        var post_url = base_url + '/post/reply';

        $.post(
            post_url,
            post_data,
            function(response) {
                if(response['success']){
                    var source   = $("#one_reply_template").html();
                    var template = Handlebars.compile(source);
                    $reply_form.closest(".post").find('.master_comments').append(template(response['reply']));
                    $reply_form.find('.reply_text_textarea').val('');
                }else{
                    alert(JSON.stringify(response));
                }
            }, 'json'
        );
    });



    /*$("div.master_comments").each(function() {
        var $master_comments_list = $(this);
        var $master_comments_comment = $(this).find("div.comments");
        $master_comments_comment.last().css({"border-bottom":"none"});
    });*/

    $("div.comments:last-of-type").css({"border-bottom":"none"});




});







