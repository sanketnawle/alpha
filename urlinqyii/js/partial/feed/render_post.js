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

function render_post(single_post, prepend){


    if (prepend === undefined) prepend = "append";
    console.log(prepend);

    //Event Posts
    //Announcements
    //Oppurtunities'

    //convert file types to a more simple form
    if(single_post['files']){
        for(var i = 0; i < single_post['files'].length; i++){
            
            if(single_post['files'][i]['original_name'].indexOf('.doc') > -1){
                single_post['files'][i]['file_type'] = 'doc';
            }else if(single_post['files'][i]['original_name'].indexOf('.ppt') > -1){
                single_post['files'][i]['file_type'] = 'ppt';
            }else if(single_post['files'][i]['original_name'].indexOf('.pdf') > -1){
                single_post['files'][i]['file_type'] = 'pdf';

            }else if(single_post['files'][i]['original_name'].indexOf('.xls') > -1){
                single_post['files'][i]['file_type'] = 'xls';
            }else if(single_post['files'][i]['original_name'].indexOf('.zip') > -1){
                single_post['files'][i]['file_type'] = 'zip';

            }else if(single_post['files'][i]['original_name'].indexOf('.jpg') < 0 && single_post['files'][i]['original_name'].indexOf('.png') < 0 && single_post['files'][i]['original_name'].indexOf('.gif') < 0){
                single_post['files'][i]['file_type'] = 'img';
            }

        }
    }


    if(findUrlInPost(single_post['text'])) {
        single_post.embed_link = findUrlInPost(single_post['text']);

    }
    if(single_post['post_type'] === "discuss" || single_post['post_type'] === "discussion"){
        var source   = $("#post_template").html();
        var template = Handlebars.compile(source);
        if(globals.profile_open){

            if(prepend == 'prepend'){
                $("#profile_posts").prepend($(template(single_post)).hide().fadeIn());
            }else{
                $("#profile_posts").append($(template(single_post)).hide().fadeIn());
            }


        }else{
            if(prepend == 'prepend'){
                $("#posts").prepend($(template(single_post)).hide().fadeIn());

            }else{
                $("#posts").append($(template(single_post)).hide().fadeIn());

            }
        }

    }
    else if(single_post['post_type'] === "notes" || single_post['post_type'] === "files") {
        console.log('note');
        var source   = $("#post_note_template").html();
        var template = Handlebars.compile(source);
        if(globals.profile_open){

            if(prepend == 'prepend'){
                $("#profile_posts").prepend($(template(single_post)).hide().fadeIn());
            }else{
                $("#profile_posts").append($(template(single_post)).hide().fadeIn());
            }


        }else{

            if(prepend == 'prepend'){
                $("#posts").prepend($(template(single_post)).hide().fadeIn());
            }else{
                $("#posts").append($(template(single_post)).hide().fadeIn());
            }

        }
    }
    else if(single_post['post_type'] === "question" || single_post['post_type'] === "multiple_choice" || single_post['post_type'] === "true_false") {
        console.log("question");
        var source   = $("#post_question_template").html();
        var template = Handlebars.compile(source);
        if(globals.profile_open){


            if(prepend == 'prepend'){
                $("#profile_posts").prepend($(template(single_post)).hide().fadeIn());

            }else{
                $("#profile_posts").append($(template(single_post)).hide().fadeIn());

            }

        }else{


            if(prepend == 'prepend'){
               $("#posts").prepend($(template(single_post)).hide().fadeIn());
            }else{
                $("#posts").append($(template(single_post)).hide().fadeIn());
            }
        }

    }
    else if (single_post['post_type'] == 'event' || single_post['post_type'] == 'opportunity'){

        var event_start_date = new_date(single_post['event']['start_date']);


        single_post['event']['date_obj'] = event_start_date;
        single_post['event']['month'] = date_to_month_string(event_start_date);
        single_post['event']['day_number'] = event_start_date.getDate();
        single_post['event']['start_time_string'] = time_string_to_am_pm_string(single_post['event']['start_time']);
        single_post['event']['end_time_string'] = time_string_to_am_pm_string(single_post['event']['end_time']);


        var source = $("#post_event_template").html();
        var template = Handlebars.compile(source);

        if(prepend == 'prepend'){
           $("#posts").prepend($(template(single_post)).hide().fadeIn());
        }else{
            $("#posts").append($(template(single_post)).hide().fadeIn());
        }


    }
    else {
        var source   = $("#post_template").html();
        var template = Handlebars.compile(source);
        if(globals.profile_open){

            if(prepend == 'prepend'){
               $("#profile_posts").prepend($(template(single_post)).hide().fadeIn());
            }else{
                $("#profile_posts").append($(template(single_post)).hide().fadeIn());
            }


        }else{

            if(prepend == 'prepend'){
               $("#posts").prepend($(template(single_post)).hide().fadeIn());
            }else{
                $("#posts").append($(template(single_post)).hide().fadeIn());
            }

        }
    }
}




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