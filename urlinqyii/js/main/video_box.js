$(document).ready(function(){
    var post_url = globals.base_url + '/user/getVideos';
    var videos=[];
    $.post(
        post_url,
        {},
        function(response){
            if(response['success']){
                videos=response['videos'];
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
                                embedly_info.topic = video.department.department_name;
                                embedly_info.subtopic = video.subtopic;
                                //  embedly_info.position = "focus";
                                //append_embedly(single_post['post_id'],embedly_info,single_post['post_type']);
                                $('.video_boxes').append(template(embedly_info));
                                $('.video_box').removeClass('focus').removeClass('next');
                                $('.video_box:eq(0)').addClass('focus');
                                $('.video_box:eq(1)').addClass('next');
                            }
                        }
                    );
                }
            }
        }
    );









    $(document).on('click','.video_box.next , .skip_video',function(){
        $('.video').fadeOut(250);
        $('.video_thumbnail').fadeIn(250);
        $('.video_left_column').fadeIn(250);
        $('.video_box').fadeIn(250);
        $video_box_next = $('.video_box.next');
        $('.video_box.focus').removeClass('focus');
        $video_box_next.removeClass('next');
        $video_box_next.addClass('focus');
        $video_box_next.next('.video_box').addClass('next');

        var margin_left = parseInt($('.video_boxes').css('margin-left'));


        $('.video_boxes').css('margin-left',margin_left-$video_box_next.outerWidth());

    });

    $(document).on('click','.video_thumbnail , .watch_video',function(){
        $video_box = $(this).closest('.video_box');
        if(!$video_box.hasClass('focus'))
            return;
        $video_box.find('.video_thumbnail').fadeOut(250);
        $video_box.find('.video_left_column').fadeOut(250);
        $video_box.find('.video').fadeIn(250);
        $('.video_box:gt('+$video_box.index()+')').fadeOut(250);
    });
});


