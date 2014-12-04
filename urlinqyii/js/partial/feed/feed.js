$(document).ready(function(){


    //$ = jQuery.noConflict();
    //Handlebars helpers
    sample();
    function sample(){
        $.embedly.extract('http://fresconews.com/post/1286', {key: '110869001b274ee0a51767da08dafeef'}).progress(function(data){
           // console.log(data);
            jQuery('.link-text-title').text(data.title);
            jQuery('.link-text-about').text(data.description + " " + data.original_url);

        });
        $.embedly.defaults.key = '110869001b274ee0a51767da08dafeef';
        //console.log($(this).find(".f_hidden_p").text().trim());
          $(".new_fd").each(function (index) {
                
                $(this).removeClass("new_fd");
                if ($(this).find(".f_hidden_p").text().trim() != "") {
                    jQuery('#embed_link').embedly({
                          query: {
                            maxwidth: 500,
                            autoplay: true
                        },
                    display:function(data, elem){
                        console.log(data);
                        if(data.type != 'video') $('.play_btn').hide();
                        jQuery('.link-text-title').text(data.title);
                        if(data.thumbnail_url){
                            console.log('here');
                          if((data.thumbnail_width > 550) && (data.thumbnail_height> 270)) {
                               jQuery('.link-img').css({
                                    'background' :  'url(' + data.thumbnail_url + ')', 
                                    'height' : 273,
                                    'width' : 555,
                                    'background-size' : 'cover'
                                });

                                jQuery('.link-text-data').css({
                                    'position' : 'relative', 
                                    'top': 162,
                                    'left' : 1,
                                    'height' : 110,
                                    'width' : 414

                                });
                                 jQuery('.link-text-about').css({
                                    'position' : 'relative', 
                                    'top': -260,
                                    'left' :-140,
                                    'width' : 545
                                });
                                 jQuery('.link-text-title').css({
                                    'position' : 'relative',
                                    'top' : -265,
                                    'left' : -140
                                 })

                           //}
                                }
                                else {
                                    jQuery('.link-img').css({
                                        'background' :  'url(' + data.thumbnail_url + ')', 
                                        'height' : 139,
                                        'width' :150,
                                        'background-size' : 'cover'
                                    });

                                }
                                var thumbnail_url = data.thumbnail_url;
                                jQuery('.link-text-about').text(data.description + " " + data.original_url);
                            // jQuery('.post_msg .msg_span').append("<br> <a href=" + data.original_url + ">" + data.original_url + "</a>");
                           

                        }
                        else {
                            //this or 
                            jQuery('.link-img').css({
                                'background' :  'url(' + 'http://www.urlinq.com/beta/DefaultImages/anon.png' + ')', 
                                'height' : 139,
                                'width' :150,
                                'background-size' : 'cover'
                            });
                            
                           // jQuery('.link-img').removeClass();
                            if(data.description){
                                jQuery('.link-text-about').text(data.description + " " +data.original_url);
                            }
                            else {
                                jQuery('.link-text-about').text(data.original_url);
                            }
                            
                        }

                        $('.link-wrapper').on('click', function () {
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


    init();
    function init(){
        get_post_data(base_url,feed_url);
    }


    function get_post_data(base_url,feed_url){

        $.getJSON( base_url + feed_url, function( json_feed_data ) {
            if(json_feed_data['success']){
                //alert(JSON.stringify(json_feed_data));
//                alert(JSON.stringify(json_feed_data));
                render_posts(json_feed_data['feed']);
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
        if(single_post['post_type'] === "discussion"){
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







