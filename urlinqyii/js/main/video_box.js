$(document).ready(function(){
    console.log('javascript running now');
    var post_url = globals.base_url + '/video/getVideos';
    var videos=[];
    var index=0;
    $.post(
        post_url,
        {},
        function(response){
            if(response['success']){
                videos=response['videos'];
                if(videos.length>0){
                    render_videos();
                    $('#video_box_wrapper').fadeIn(250);
                }else{
                    $('#video_box_wrapper').remove();
                }


              //  set_videos_variable(videos);
            }
        }
    );

    function render_videos(){
        console.log(videos);
        var source = $('#video_box_template').html();
        var template = Handlebars.compile(source);
        var video;
        for(var i=0;i<videos.length;i++){
            video=videos[i];
            $.embedly.oembed(video['video_url'], {
                key: '94c0f53c0cbe422dbc32e78d899fa4c5',
                query: {
                    maxwidth: 500,
                    maxheight: 500,
                    chars: 200
                }
            }).done(function (results) {
                    if (!results.invalid) {
                        embedly_info = results[0];
                        console.log(embedly_info.url+"embedly");
                        for(var j=0;j<videos.length;j++){
                            console.log(videos[j].video_url+"video");
                            if(embedly_info.url && videos[j].video_url.substring(videos[j].video_url.indexOf(':'))
                                == embedly_info.url.substring(embedly_info.url.indexOf(':'))){
                                embedly_info.topic = videos[j].department.department_name;
                                if(videos[j].subtopic){
                                    embedly_info.subtopic = videos[j].subtopic;
                                }

                            }
                        }
                        //  embedly_info.position = "focus";
                        //append_embedly(single_post['post_id'],embedly_info,single_post['post_type']);
                       // $video_box=template(embedly_info);
                        $('.video_boxes').append(template(embedly_info));
                        $('.video_box').removeClass('focus').removeClass('next');
                        $('.video_box:eq(0)').addClass('focus');
                        $('.video_box:eq(1)').addClass('next');
                       // $('.video_description.desc_truncated').dotdotdot();
                        $('.video_description.desc_truncated').text(function(index, currentText) {
                            return currentText.substr(0, 100);
                        });
                        $('.video_description.desc_truncated').append('<span class="expand_video_description">...</span>');


                    }
                }
            );
        }

        //render_replies(videos[0]);
        set_comments_and_likes();


    }

    function set_comments_and_likes(){
        var $video_post = $('.post.video_box_post');
        $('.video_reply_form').attr('data-video_id',videos[index].video_id);
        $video_post.attr('data-video_id',videos[index].video_id);
        $video_post.find('.post_comment_btn .reply_number').remove();
        if(videos[index]['replies'].length>0){
            $video_post.find('.post_comment_btn').append('<div class = "reply_number">'+videos[index]['replies'].length+'</div>');
        }
        if(videos[index]['liked']){
            $video_post.find('.post_liked').show();
            $video_post.find('.post_like').hide();
        }else{
            $video_post.find('.post_liked').hide();
            $video_post.find('.post_like').show();
        }
        $video_post.find('.post_like_btn .like_number').remove();
        if(videos[index]['like_count']>0){
            $video_post.find('.post_like_btn').append('<div class = "like_number">'+videos[index]['like_count']+'</div>');
        }
    }
    function render_replies(video){
        var source   = $("#video_reply_template").html();
        var template = Handlebars.compile(source);
        //var id = $(this).parent(".master_comments").attr("id");
        for(i = 0; i < video['replies'].length; i++){
            video['replies'][i]['update_timestamp'] = moment(video['replies'][i]['update_timestamp'], "X").fromNow();
        }
        var array = {'replies' : video['replies']};
        console.log(array);
        $(".master_comments.video_comments").html(template(array));
        //add_embedly_to_replies(video['replies']);
    }

    $(document).on('click', '.morecmt_bar', function(){
        if($(this).parent(".master_comments").hasClass('video_comments')){
            render_replies(videos[index])
            add_embedly_to_replies(videos[index]['replies']);
        }
    });
    $(document).on('click', '.lesscmt_bar', function(){
        if($(this).parent(".master_comments").hasClass('video_comments')){
            $(".master_comments.video_comments").html("<div id='show_more' class='morecmt_bar'>"
            +"Read Comments"
            +"</div>");
        }
    });

    $(document).on('click','.expand_video_description',function(){
        $video_desc_trunc=$(this).parent('.video_description.desc_truncated');
        $video_desc_trunc.hide();
        $video_desc_trunc.parent().find('.video_description.desc_full').show();
    });
    $(document).on('click','.close_video_description',function(){
        $video_desc_full = $(this).parent('.video_description.desc_full');
        $video_desc_full.hide();
        $video_desc_full.parent().find('.video_description.desc_truncated').show();
    });

    $(document).on('mouseenter','.info_icon',function(){
    });



    $(document).on('click', '.reply_delete_button', function(){
        if($(this).closest('.master_comments').hasClass('video_comments')){


            var $reply_delete_button = $(this);
            var $reply = $reply_delete_button.closest('.comment_main');

            var video_reply_id = $reply.attr('data-video_reply_id');

            var post_url = globals.base_url + '/video/deleteReply';
            var post_data = {id: video_reply_id};


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
                            append_embedly(reply['video_reply_id'],embedly_info);
                        }
                    }
                );
            }
        });
    }

    function append_embedly(video_reply_id, embedly_info){
        console.log('append embedly to video reply '+video_reply_id);
        var source;



        if(embedly_info.type == "link"){
            source = $('#embedly_link_template').html();
        }else if(embedly_info.type == "video"){
            source = $('#embedly_video_template').html();

        }else if(embedly_info.type == "photo"){
            source = $('#embedly_photo_template').html();
        }
        var template = Handlebars.compile(source);


            $('.comment_msg[data-video_reply_id='+video_reply_id+']').append(template(embedly_info));
    }


    $(document).on('click','.video_box.next , .skip_video',function(){

        $video_desc_full = $('.video_box.focus').find('.video_description.desc_full');
        $video_desc_full.hide();
        $video_desc_full.parent().find('.video_description.desc_truncated').show();

        if ($('.video_box_wrapper').hasClass('expandedvideo')) {
            $('.video').animate({
                marginTop: "0px"
            }).fadeOut(250);
            $('.embedly-embed.expandedvideoplayer').animate({
                height: "124px",
                width: "220px",
            }).fadeOut(250).removeClass('expandedvideoplayer');
            $('.video_boxes').animate({
                height: "140px"
            });
            $('.video_left_column').animate({
                width: "260px",
                marginLeft: "240px"
            });
            $('.video_categories, .video_box_functions').fadeIn(250);
            setTimeout(function(){
                $('.video_thumbnail').fadeIn(250);
                $('.video_box').fadeIn(250);
            },250);
            $('.video_box_wrapper').animate({
                height: "128px"
            }).removeClass('expandedvideo'); 
            setTimeout(function(){
                $video_box_next = $('.video_box.next');
                $('.video_box.focus').removeClass('focus');
                $video_box_next.removeClass('next');
                $video_box_next.addClass('focus');
                $video_box_next.next('.video_box').addClass('next');

                var margin_left = parseInt($('.video_boxes').css('margin-left'));
                
                $('.video_boxes').css('margin-left',margin_left-$video_box_next.outerWidth());
                index++;

                set_comments_and_likes()

                $(".master_comments.video_comments").html("<div id='show_more' class='morecmt_bar'>"
                +"Read Comments</div>");
            },100)  
        } else { 
            $video_box_next = $('.video_box.next');
            $('.video_box.focus').removeClass('focus');
            $video_box_next.removeClass('next');
            $video_box_next.addClass('focus');
            $video_box_next.next('.video_box').addClass('next');

            var margin_left = parseInt($('.video_boxes').css('margin-left'));
            
            $('.video_boxes').css('margin-left',margin_left-$video_box_next.outerWidth()-1);
            index++;

            set_comments_and_likes()

            $(".master_comments.video_comments").html("<div id='show_more' class='morecmt_bar'>"
            +"Read Comments</div>");
        }

    });

    $(document).on('click','.video_thumbnail , .watch_video',function(){
        $video_box = $(this).closest('.video_box');
        if(!$video_box.hasClass('focus'))
            return;
        $video_box.find('.video_thumbnail').fadeOut(100);
        $('.video_boxes').animate({
            height: "415px"
        },100)
        setTimeout(function(){
            $video_box.find('.video').fadeIn(250);
            $video_box.find('.embedly-embed').animate({
                height: "281px",
                width: "520px"
            }).addClass('expandedvideoplayer');
        },100);
        setTimeout(function(){
            $video_box.find('.video_left_column').animate({
                marginTop: "0px",
                marginLeft: "10px",
                width: "100%"
            });
            $video_box.find('.video_categories, .video_box_functions').fadeOut(250);
            $video_desc_trunc=$video_box.find('.video_description.desc_truncated');
            $video_desc_trunc.hide();
            $video_desc_trunc.parent().find('.video_description.desc_full').show();
            $video_box.find('.video').animate({
                marginTop: "100px"
            });
        },200);
        $('.video_box:gt('+$video_box.index()+')').fadeOut(250);
        $('.video_box_wrapper').animate({
            height: "415px"
        }).addClass('expandedvideo');
    });
});


