$(document).ready(function(){


    $ = jQuery.noConflict();
    //Handlebars helpers

    init();
    function init(){
        alert(base_url);
    }




    $.each(jsonData ,function(key) {

        //jsonData['key'].jsonData[key]['replies'][0]);
        //if(jsonData[key]['anon'] === '0') jsonData[key]['anon'] = '';
        //if(jsonData[key]['user_id'] === '0') jsonData[key]['user_id'] = '';
        //var time = new Date(jsonData[key]['created_time']);
        //jsonData[key]['created_time'] = time
        if(jsonData[key]['reply_count'] >  2) {
            jsonData[key].show_more = true;
            var post_id = jsonData[key]['post_id'];
            var theReplies = jsonData[key]['replies'];
            replies[post_id.toString()] = theReplies;
            jsonData[key]['replies'] = [jsonData[key]['replies'][0], jsonData[key]['replies'][1]];
        }

        render_post(jsonData[key]);
    });



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
        if(findUrlInPost(single_post['text_msg'])) {
            single_post.embed_link = findUrlInPost(single_post['text_msg']);
        }
        if(single_post['post_type'] === "status"){
            var source   = $("#post_template").html();
            var template = Handlebars.compile(source);
            $("#posts").append(template(single_post));
        }
        else if(single_post['post_type'] === "notes") {
            console.log('note');
            var source   = $("#post_note_template").html();
            var template = Handlebars.compile(source);
            $("#posts").append(template(single_post));
        }
        else if(single_post['post_type'] === "question") {
            var source   = $("#post_question_template").html();
            var template = Handlebars.compile(source);
            $("#posts").append(template(single_post));
        }
        else if(single_post['post_type'] === "discussion") {

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



    var jsonData = [{"post_id":"463","user_id":"350","target_type":null,"target_id":null,"target_univ_id":"1","post_type":"question",
        "multiple_choice" : 'true', "choices" :
            [{'the_choice_letter' : 'A', 'the_choice_text' : 'This is choice a', "percent_selected" : 67, 'anon' : 0, 'people_who_answered_len' : 3, 'people_who_answered' : [{name:'Mehul Patel'}, {name: 'Jacob L.'}, {name:"Alex Lopez"}]},
                {'anon' : 0, 'the_choice_letter' : 'B', 'the_choice_text' : 'This is choice b', 'percent_selected' : 25, 'people_who_answered_len' : 2, 'people_who_answered' : [{name:'Mehul Patel'}, {name: 'Jacob L.'}]},
                {'anon' : 0, 'the_choice_letter' : 'C', 'the_choice_text' : 'This is choice c', 'percent_selected' : 25, 'people_who_answered_len' : 5, 'people_who_answered' : [{name:'Mehul Patel'}, {name: 'Jacob L.'}, {name:"Alex Lopez"},{name:"Alex Lopez"}, {name:"Alex Lopez"}]},
                {'anon' : 0, 'the_choice_letter' : 'D', 'the_choice_text' : 'This is choice d', 'percent_selected' : 25, 'people_who_answered_len' : 3, 'people_who_answered' : [{name:"Alex Lopez"}, {name:"Alex Lopez"}, {name:"Alex Lopez"}]}],
                    "text_msg":"http://fresconews.com/post/967",
                    "sub_text":"asd","file_id":null,"file_share_type":null,"privacy":"campus","anon":0,"like_count":"0","last_activity":1410888325000,"update_timestamp":1409060403000,"inv_type":"posted","created_time":"2014-08-26 15:40:03","user_name":"Aditya Nenawati","pownership":true,"target_name":null,"reply_count":7,
                    "replies":[{"reply_id":"313","post_id":"463","user_id":"285","reply_msg":"final test of comment box","up_vote":"0","down_vote":"0","file_id":"319","anon":0,"update_timestamp":"2014-09-14 16:50:21","user_name":"Kuan Wang","cownership":true},{"reply_id":"327","post_id":"463","user_id":"285","reply_msg":"testing from phone","up_vote":"0","down_vote":"0","file_id":null,"anon":0,"update_timestamp":"2014-09-14 17:47:37","user_name":"Kuan Wang","cownership":true},{"reply_id":"328","post_id":"463","user_id":"285","reply_msg":"testing from mac chrome","up_vote":"0","down_vote":"0","file_id":null,"anon":0,"update_timestamp":"2014-09-14 17:54:53","user_name":"Kuan Wang","cownership":true},{"reply_id":"329","post_id":"463","user_id":"285","reply_msg":"testing from mac firefox","up_vote":"0","down_vote":"0","file_id":null,"anon":0,"update_timestamp":"2014-09-14 17:57:05","user_name":"Kuan Wang","cownership":true},{"reply_id":"330","post_id":"463","user_id":"285","reply_msg":"testing again from mac firefox","up_vote":"0","down_vote":"0","file_id":null,"anon":0,"update_timestamp":"2014-09-14 17:58:28","user_name":"Kuan Wang","cownership":true},{"reply_id":"331","post_id":"463","user_id":"285","reply_msg":"testing after fix","up_vote":"1","down_vote":"0","file_id":null,"anon":0,"update_timestamp":"2014-09-14 18:09:24","user_name":"Kuan Wang","cownership":true},{"reply_id":"332","post_id":"463","user_id":"285","reply_msg":"testing again after fix","up_vote":"1","down_vote":"0","file_id":null,"anon":0,"update_timestamp":"2014-09-14 18:10:13","user_name":"Kuan Wang","cownership":true}]}
            ];
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
        $(this).prepend("<img class='waiting_animation_circletype waiting_animation_circletype_sz10 circletype_animation_adjust_1' src='http://www.urlinq.com/beta/img/waiting_animation_circletype.GIF'>");
        var source   = $("#reply_template").html();
        var template = Handlebars.compile(source);
        var id = $(this).parent(".master_comments").attr("id");
        var array = {'replies' : replies[id]};
        $(this).parent(".master_comments").html(template(array));
    });












});




//var url = 'data.json';
//$.getJSON( url , function( data ) {
//Checks if the request was successful
//console.log("called");
//if(data['success']){

//else{

//alert("Error loading feed!");
//}
//});


