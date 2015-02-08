$(document).ready(function() {
    var old_origin_type;
    var old_origin_id;
    globals.$fbar = $('#fbar_wrapper');

    $(document).on('click', '.profile_link', function(){

        old_origin_id = globals.origin_id;
        old_origin_type = globals.origin_type;
        //alert(globals.origin_id);
        globals.origin_id = $(this).attr('data-user_id');
        //alert(globals.user_id);
        globals.origin_type = 'user';
        globals.profile_open = true;
        open_profile(globals.base_url, $(this).attr('data-user_id'),$(this).hasClass('edit_profile'));
    });

    $(document).on('click', '.close_modal', function(){
        close_profile();
    });
    $(document).keyup(function(e) {
        if (e.keyCode == 27) {
            close_profile();
        }   // esc
    });
    function close_profile(){
        globals.origin_id = old_origin_id;
        globals.origin_type = old_origin_type;
        globals.profile_open = false;
        globals.$fbar = $('#fbar_wrapper');
        $('#profile_background_overlay').fadeOut(300);
        $("#page").removeClass("profile_stop_scroll");
        $("body").removeClass("profile_stop_scroll");
        $("body#body_home").removeClass("profile_stop_scroll");
    }
    function open_profile(base_url,user_id,edit_mode){
        //  var numShowcase;
        $.getJSON( base_url + "/profile/json",{id: user_id}, function( json_profile_data ) {
           
            $("#page").addClass("profile_stop_scroll");
            $("body").addClass("profile_stop_scroll");
            $("body#body_home").addClass("profile_stop_scroll");

            /*if($('#profile_wrapper').attr('data-user_id')==json_profile_data.user_id){


                if(edit_mode==true){
                    $('#edit_profile_button.not_editing').click();
                }
            }else */
            if($('#profile_wrapper').length){
                $('#profile_wrapper').remove();
                $('#profile_background_overlay').remove();


                render_profile(base_url,json_profile_data,edit_mode);

            }else{

                render_profile(base_url,json_profile_data,edit_mode);
            }

        });


    }
    function render_profile(base_url,data,edit_mode){

        $.ajax({ url: base_url + '/protected/views/profile/profile.html',
            dataType:'html',
            success: function(html) {

                //get fbar
                $.ajax({ url: base_url + '/profile/returnFbar?user='+data.user_id,
                    dataType:'html',
                    success: function(html) {
                        $('#profile_fbar_wrapper').append(html);
                        globals.$fbar.find('.menu_audience').dropit({});
                        globals.$fbar.find('.privacy_menu').dropit({});
                        populate_audience_select();
                        set_dropzone();
                        //get feed
                        $.getJSON( base_url + '/profile/'+data.user_id+'/feed', function( json_feed_data ) {
                            if(json_feed_data['success']){
                                if(json_feed_data['feed'].length == 0){
                                    var $posts_container = $("#profile_posts");
                                    $posts_container.html("<div class = 'no_posts_container'><div class = 'no_posts_icon small_icon_map'></div><div class = 'no_posts_message'><div class = 'message_header'>It is the very start of this feed.</div><div class = 'message_sub'>Be the first to make a post.</div></div></div>");
                                }else{
                                    render_posts(json_feed_data['feed']);
                                }
                            }else{
                                console.log('failed to get feed');
                            }
                        });
                    }
                });


                numShowcase=data.showcase_size;
                var template = Handlebars.compile(html);
                $('body').append(template(data));
                $('#profile_background_overlay').hide().fadeIn(300);
                $('#profile_wrapper').addClass('animated bounceInUp');

                globals.$fbar = $('#profile_fbar_wrapper');


                if(!data.minors || data.minors.length==0){
                    $('#minor_section').hide();
                }
                if(!data.majors ||data.majors.length==0){
                    $('.info_name.undeclared').show();
                }
                if(!data.research){
                    $('#research_section').hide();
                }
                if(!data.bio){
                    $('#bio_section').hide();
                }
                if(!data.year_name){
                    $('#level_section').hide();
                }
                if(!data.grad_year){
                    $('#year_section').hide();
                }

                if(data.gender=="M"){
                    $('#radio_male').prop('checked',true);
                }else if(data.gender=="F"){
                    $('#radio_female').prop('checked',true);
                }
                $('#name_input').val(data.firstname+" "+data.lastname);
                $('#email_input').val(data.email);
                if(numShowcase<=1){
                    $('.showcase_controls').hide();
                }else{
                    $('.showcase_arrow.left').hide();
                }
                if(edit_mode==true){

                        $('#edit_profile_button.not_editing').click();

                }
            }
        });
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
    function set_dropzone(){
        globals.profileDropzone = new Dropzone('form#profile_fbar_file_form', {
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
                    }


                });


                this.on("sendingmultiple", function(file, xhr, formData) {
                    last_file_count = globals.profileDropzone.files.length;
                    success_counter = 0;
                    var post_data = get_post_data();


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




                        // Remove the file preview


                        //alert(globals.myDropzone.files);
                        console.log(globals.profileDropzone.files);
                        for(var i = 0; i < globals.profileDropzone.files.length; i++){
                            var this_file = globals.profileDropzone.files[i];
                            //console.log(this_file);

                            console.log('last modified of this file from dropzone: ' + this_file.lastModified);
                            console.log('last modified of this file last shit fuck  : ' + last_modified.toString());


                            console.log('1 name: ' + this_file.name.toString());
                            console.log('2 name: ' + name.toString());

                            if(this_file.lastModified.toString() == last_modified.toString() && this_file.name.toString() == name.toString()){
                                globals.profileDropzone.removeFile(this_file);
                                $('.fbar_file[data-name="' + this_file.name + '"][data-last_modified="' + this_file.lastModified + '"]').remove();

                            }
                        }

                        console.log('Current dropzone files');
                        console.log(globals.profileDropzone.files);

                    });

                    globals.$fbar.find('.post_form_template').append($file);

                    // Capture the Dropzone instance as closure.
                    var _this = this;

                })

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
            add_embedly_to_replies(post['replies']);

            if(post['post_type'] == 'question' && post['question']['question_type'] == 'multiple_choice'){
                var alphabet= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

                for(i = 0; i < post['options'].length; i++){
                    post['options'][i]['the_choice_letter'] = alphabet.charAt(i);

                }
            }




            post['update_timestamp'] = moment(post['update_timestamp'], "X").fromNow();



            render_post(post, 'prepend');
        });
    }

    function add_embedly_to_replies(replies){
        $.each(replies,function(index,reply){
            if(findUrlInPost(reply['reply_msg'])) {
                var url = findUrlInPost(reply['reply_msg']);
                //  post['replies'][index]['reply_msg']=reply['reply_msg'].replace(url,'<a href="'+url+'">'+url+'</a>');
                $.embedly.oembed(url,{
                    key:'94c0f53c0cbe422dbc32e78d899fa4c5',
                    query:{
                        maxwidth: 400,
                        maxheight: 400,
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
        console.log(reply_id);
        console.log(globals.profile_open);
        if(globals.profile_open){
            $('#profile_wrapper').find('.comment_msg[id='+reply_id+']').append(template(embedly_info));
        }else{
            $('.comment_msg[id='+reply_id+']').append(template(embedly_info));
        }

    }
    function render_post_with_url(single_post){

        single_post.embed_link = findUrlInPost();

    }


    /*function profile_render_post(single_post){
        console.log('asdf');
        //Event Posts
        //Announcements
        //Oppurtunities

        if(findUrlInPost(single_post['text'])) {
            single_post.embed_link = findUrlInPost(single_post['text']);

        }
        if(single_post['post_type'] === "discussion"){
            var source   = $("#post_template").html();
            var template = Handlebars.compile(source);
            $("#profile_posts").append(template(single_post));
        }
        else if(single_post['post_type'] === "notes") {
            console.log('note');
            var source   = $("#post_note_template").html();
            var template = Handlebars.compile(source);
            $("#profile_posts").append(template(single_post));
        }
        else if(single_post['post_type'] === "question") {
            console.log("question");
            var source   = $("#post_question_template").html();
            var template = Handlebars.compile(source);
            $("#profile_posts").append(template(single_post));

        }
        else if(single_post['post_type'] === "discussion") {

        }
    }*/

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

    function get_post_data(){
        var $fbar_holder = globals.$fbar.find('#fbar_holder');

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


        //alert(JSON.stringify(post_data));


        return post_data;
    }
    $(document).on('click', '.profile_tab',function(){
        var $tab = $(this);
        var panel_id = $tab.attr('data-panel_id');
        //Change active tab
        $('.profile_tab.active').removeClass('active');
        $tab.addClass('active');


        //Find the current active panel and remove its active class
        $('.profile_panel.active').removeClass('active');
        $('#profile_panel_' + panel_id).addClass('active');
    });
    var numShowcase=0;
    $(document).on('click','.showcase_arrow.left',function(){
        var index=parseInt($('.showcase_item.center').attr('showcase_index'));

        if(index>0){
            index--;
            $('.showcase_arrow.right').show();
            $('.showcase_items').css('margin-left', 260 - (index)*496);
            $('.showcase_item.center').removeClass('center');
            $('.showcase_item[showcase_index='+(index)+']').addClass('center');
            if(index==0){
                $('.showcase_arrow.left').hide();
            }
        }
       // alert($('.showcase_item.center').attr('showcase_index'));
    });
    $(document).on('click','.showcase_arrow.right',function(){

        var index=parseInt($('.showcase_item.center').attr('showcase_index'));
        if(index<numShowcase-1){
            index++;
            $('.showcase_arrow.left').show();
            $('.showcase_items').css('margin-left', 260 - (index)*496);
            $('.showcase_item.center').removeClass('center');
            $('.showcase_item[showcase_index='+(index)+']').addClass('center');
            if(index==numShowcase-1){
                $('.showcase_arrow.right').hide();
            }
        }
        //alert($('.showcase_item.center').attr('showcase_index'));
    });
    $(document).on('click','.add_showcase_button',function(){
        $(".add_showcase_text").fadeOut(250);
        $(".showcase_items").fadeOut(250);
        $(".showcase_controls").fadeOut(250);
        $(this).fadeOut(150).delay(250).queue(function(next){
            $('#profile_overlay').fadeIn(300);
            $('#add_showcase_form').fadeIn(300);
            $("#title_entry").focus();
            next();
        });
        already_submitted = false;
       //$('.overlay').css('z-index',2500);

    });
    $(document).on('click','#cancel_showcase_form',function(){
        $(".showcase_items").fadeIn(250);
        $(".showcase_controls").fadeIn(250);
        $('#add_showcase_form').fadeOut(350).delay(150).queue(function(next){
            $('.add_showcase_text').fadeIn(200);
            $('.add_showcase_button').fadeIn(50);
            next();
        });
        
        //kinyi add showcase to showcase bar: data.title, data.desc, data.file_extension, data.preview_file
        //reset form
        $('#upload_file_name').text('');

        $('#title_entry').val('');
        $('#desc_entry').val('');
        if($('form#add_showcase').length){
            $('form#add_showcase')[0].reset();
        }
        upload_file = null;
    });


    function render_new_showcase(data){

        $.ajax({ url: base_url + '/protected/views/profile/showcase_template.html',
            dataType:'html',
            success: function(html) {
                var template = Handlebars.compile(html);
                var index=parseInt($('.showcase_item.center').attr('showcase_index'));
                //increment indices of entries in the center or after the center
                $('.showcase_item').each(function(){
                    $(this).attr('showcase_index',function(i,currValue){
                        currValue = parseInt(currValue);
                        return currValue>=index ? currValue+1 : currValue;
                    });
                });
                $('.showcase_item.center').removeClass('center');


                //add new showcase entry using the returned template
                if($('.showcase_item').length>0){
                    data.index = index;
                    if($('.showcase_item').length>=1){
                        $(".showcase_arrow.left").show();
                        $(".showcase_arrow.right").show();
                        $(".showcase_controls").fadeIn(250);
                        if(index==0){
                            $(".showcase_arrow.left").hide();
                        }
                    }
                    $('.showcase_item[showcase_index='+(index+1)+']').before(template(data));
                }else{
                    data.index=0;
                    $('.showcase_items').append(template(data));
                    //$('.showcase_controls').show();
                    //$('#modal_header').removeAttr('style');
                    $('.add_showcase_button').removeClass('empty');
                    $('.add_showcase_button').text('+ Update your Showcase');

                }
                numShowcase++;
            }
        });
    }
    $(document).on('click','.add_field_button',function(){
        var $section = $(this).parent();

        if($section.attr('id')=="major_section"){
            if($section.find('input.edit_field').length==3){
                return;
            }
            $section.append('<input type="text" class="edit_field major additional" style="display:inline-block">'+
            '<button class="delete_field_button delete_major_button"></button>');
        }else if($section.attr('id')=="minor_section"){
            if($section.find('input.edit_field').length==3){
                return;
            }
            $section.append('<input type="text" class="edit_field minor additional" style="display:inline-block">'+
            '<button class="delete_field_button delete_minor_button"></button>');
        }else if($section.attr('id')=="research_section"){
            $section.append('<input type="text" class="edit_field research additional" style="display:inline-block">'+
            '<button class="delete_field_button delete_research_button"></button>');
        }
    });
    $(document).on('click','.delete_field_button',function(){
        $(this).prev('span.ui-helper-hidden-accessible').remove();
        $(this).prev('input.edit_field').remove();
        if($(this).closest('.info_section').attr('id') == "major_section"){
            major_changed = true;
        }else if($(this).closest('.info_section').attr('id') == "minor_section"){
            minor_changed = true;
        }
        $(this).remove();
    });
    //add showcase code
    $(document).on('click','#upload_link_button',function(){
        $('#upfile').click();
    });
    var upload_file;
    $(document).on('change','#upfile', function (event)
    {

        upload_file = event.target.files[0];
        if($('#title_entry').val()==""){
            $('#title_entry').val(upload_file.name.substring(0,upload_file.name.lastIndexOf('.')));
        }
        $('#upload_file_name').text(upload_file.name);

    });
    var already_submitted = false;
    $(document).on('submit','form[id=add_showcase]', function (event) {
        event.stopPropagation(); // Stop stuff happening
        event.preventDefault(); // Totally stop stuff happening
        // START A LOADING SPINNER HE
        // Create a formdata object and add the files
        if(!already_submitted){
            var data = new FormData();
            if(upload_file) {
                data.append("file", upload_file);
            }else{
                alert('Please upload a file or provide a link to your file');
            }
            data.append("title", $('#title_entry').val());
            data.append("desc", $('#desc_entry').val());
            data.append("user", globals.user_id);
            $.ajax({
                url: base_url+'/profile/addShowcase',
                type: 'POST',
                data: data,
                cache: false,
                dataType: 'json',
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                success: function(data)
                {
                    if(data.status == "success"){
                        $('#add_showcase_form').hide();
                        $('#profile_overlay').hide();

                        //reset form
                        $('#upload_file_name').text('');
                        $('#title_entry').val('');
                        $('#desc_entry').val('');
                        $('#upfile').val('');
                        upload_file = null;

                        render_new_showcase(data);
                        $(".showcase_items").fadeIn(250);
                        $('#add_showcase_form').fadeOut(350).delay(150).queue(function(next){
                            $('.add_showcase_text').fadeIn(200);
                            $('.add_showcase_button').fadeIn(50);
                            next();
                        });
                        already_submitted = true;
                        if($('form#add_showcase').length){
                            $('form#add_showcase')[0].reset();
                        }
                        //alert(JSON.stringify(data));
                    }else{
                        alert(JSON.stringify(data));
                    }
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    alert('err'+jqXHR+textStatus+errorThrown);
                }
            });
        }

    });

    //delete showcase
    $(document).on('click','.showcase_delete',function(){
        var file_id = parseInt($('.showcase_item.center').attr('file_id'));
        if($(this).closest('.showcase_item').hasClass('center')){
            $.ajax({
                url: base_url+'/profile/deleteShowcase',
                type: 'POST',
                data: {file_id:file_id},
                dataType: 'json',
                success: function(result)
                {
                    if(result.status == "success"){
                        deleteShowcaseElement();
                    }else{
                        alert(result.status);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    alert(errorThrown);
                }
            });
        }

    });
    function deleteShowcaseElement(){
        var index=parseInt($('.showcase_item.center').attr('showcase_index'));
        //$('.showcase_item.center').hide();
        //$('.showcase_item.center').removeClass('center');
        $('.showcase_item.center').remove();
        if(index != numShowcase-1){
            $('.showcase_item').each(function(){
                $(this).attr('showcase_index',function(i,currValue){
                    return currValue>index ? currValue-1 : currValue;
                });
            })
            $('.showcase_item[showcase_index='+(index)+']').addClass('center');
        }else if(numShowcase>1){
            $('.showcase_items').css('margin-left', 260-(index-1)*496);
            $('.showcase_item[showcase_index='+(index-1)+']').addClass('center');
        }
        if(index==numShowcase-2){
            $('.showcase_arrow.right').hide();
        }
        numShowcase--;
        if(numShowcase==1){
            $('.showcase_controls').hide();
        }

    }

    //edit profile

    var any_research;
    var any_bio;

    $(document).on('click','#edit_profile_button.not_editing',function(){
        $('#profile_foreground_overlay').show();
        //$('#left_info_bar,#profile_picture_wrapper').css('z-index','3000');
        any_major=!$('#major_section >.info_name.undeclared').is(':visible');
        $('.info_name').hide();
        $('.headers').show();
        $('.edit_field').show();
        $(".edit_field.additional").remove();
        $(".delete_field_button").remove();
        $('.add_field_button').show();
        //school

        $.getJSON( base_url + "/profile/getSchools",{user: globals.user_id}, function( result) {
            $.each(result.schools,function(i,school){
                $('#school_dropdown').append($('<option/>').attr("value", school.id).text(school.name));
            });
            $('#school_dropdown').val(result.selected);
            schools_loaded=true;
        });


        //department
        $('#department_dropdown').empty();
        $.getJSON( base_url + "/profile/getDepartments",{user: globals.user_id}, function( result) {
            $.each(result.departments,function(i,department){
                $('#department_dropdown').append($('<option/>').attr("value", department.id).text(department.name+' '+department.tag));
            });
            $('#department_dropdown').val(result.selected);
        });
        //year and academic level
        $('#year_dropdown').val($('#year').text());
        any_year_name = $('#level_section').is(':visible');
        any_year = $('#year_section').is(':visible');
        $('#level_section').show();
        $('#year_section').show();
        $('#level_dropdown').val($('#level_name').text());
        //majors
        var major_text;
        $('.info_name.major').each(function(i){
            if(!$(this).hasClass('undeclared')){
                major_text = $(this).text();
                if(i==0){
                    $('.edit_field.major').val(major_text);
                }else{
                    $('#major_section').append('<input type="text" class="edit_field major additional"'+
                    ' value="'+major_text+'" style="display:inline-block">'+
                    '<button class="delete_field_button delete_major_button"></button>');
                }
            }
        });

        //minors
        any_minor=$('#minor_section').is(':visible');
        $('#minor_section').show();
        var minor_text;
        $('.info_name.minor').each(function(i){
            minor_text = $(this).text();
            if(i==0){
                $('.edit_field.minor').val(minor_text);
            }else{
                $('#minor_section').append('<input type="text" class="edit_field minor additional"'+
                ' value="'+minor_text+'" style="display:inline-block">'+
                '<button class="delete_field_button delete_minor_button"></button>');
            }
        });
        //research
        any_research=$('#research_section').is(':visible');
        $('#research_section').show();
        var research_text;
        $('.info_name.research').each(function(i){
            research_text = $(this).text();
            if(i==0){
                $('.edit_field.research').val(research_text);
            }else{
                $('#research_section').append('<input type="text" class="edit_field research additional"'+
                ' value="'+research_text+'" style="display:inline-block">'+
                '<button class="delete_field_button delete_research_button"></button>');
            }
        });

        //bio
        any_bio=$('#bio_section').is(':visible');
        $('#bio_section').show();
        $('#bio_input').attr('rows',Math.ceil($('#bio').text().length/$('#bio_input').attr('cols')));
        $('#bio_input').val($('#bio').text());
        $('.info_section.account').show();

        //office hours and location
        $('#office_input').val($('#office_location').text());
        $('#hours_input').val($('#office_hours').text());
        //buttons
        $('#edit_profile_button').css('margin-left','0');
        $('#edit_profile_button').text('Done Editing');
        $('#edit_profile_button').removeClass('not_editing');
        $('#edit_profile_button').addClass('editing');
        $('#cancel_edit_button').show();
        $('#cancel_edit_button').css('display','inline-block');
    });

    //autoexpand and autoshrink bio
    $(document).on('keyup','#bio_input',function(){
        $('#bio_input').attr('rows',Math.ceil($(this).val().length/$('#bio_input').attr('cols')));
    });
    var any_major;
    var any_minor;
    var any_year_name;
    var any_year;
    var any_research=false;
    var match;
    $(document).on('click','#edit_profile_button.editing',function(){  //submit changes
        //alert('done');
        var data = new FormData();
        if($('#school_dropdown').val()){
            data.append('school',$('#school_dropdown').val());
        }
        if($('#department_dropdown').val()){
            data.append('department',$('#department_dropdown').val());
        }
        data.append('user',globals.user_id);
        data.append('name',$('#name_input').val());
        data.append('email',$('#email_input').val());
        data.append('gender',$('.edit_field.gender:checked').val());
        data.append('bio',$('#bio_input').val());

        data.append('user_id', $('#profile_wrapper').attr('data-user_id'));

        if($('#year_section').length){
            if($('#year_dropdown').val()){
                data.append('year',$('#year_dropdown').val());
            }
            if($('#level_dropdown').val()){
                data.append('year_name',$('#level_dropdown').val());
            }

        }
        if($('#office_section').length){
            data.append('location',$('#office_input').val());
            data.append('hours',$('#hours_input').val());
        }
        any_research=false;
        $('.edit_field.research').each(function(index){
            if($(this).val()){
                any_research = true;
                data.append('research['+index+']', $(this).val());
            }
        });
        if(!any_research){
            data.append('research[0]', "none");
        }

        if(major_changed){
            any_major=false;
            $('.edit_field.major').each(function(index){
                if($(this).val()){
                    any_major = true;
                    data.append('majors['+index+']', $(this).val());
                }
            });
            if(!any_major){
                data.append('majors[0]', "none");
            }
        }
        if(minor_changed){
            any_minor = false;
            $('.edit_field.minor').each(function(index){
                if($(this).val()){
                    any_minor = true;
                    data.append('minors['+index+']', $(this).val());
                }
            });
            if(!any_minor){
                data.append('minors[0]', "none");
            }
        }
        any_bio = $.trim($('#bio_input').val()) != "";
        any_year_name = $.trim($('#level_dropdown').val()) != "";
        any_year = $.trim($('#year_dropdown').val()) != "";

        $('#major_section > .info_name.undeclared').hide();
        $.ajax({
            url: base_url+'/profile/editProfile',
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            success: function(result)
            {
                var any_errors = false;
                if(result.success == false){
                    alert('invalid user');
                    any_errors = true;
                }
                if(result.year_name == "success"){
                    $('#level_name').text($('#level_dropdown').val());
                    match =(new RegExp("at (.+)$")).exec($('#year_info').text());
                    if(match){
                        $('#year_info').text($('#level_dropdown').val()+' at '+match[1]);
                    }
                }else if(result.year_name){
                    alert(JSON.stringiy(result.year_name));
                    any_errors = true;
                }
                if(result.year == "success"){
                    $('#year').text($('#year_dropdown').val());
                    match =(new RegExp("([^0-9]+) ")).exec($('#name_info').text());
                    if(match) {
                        $('#name_info').text(match[1] + " " + (parseInt($('#year').text()) % 100));
                    }
                }else if(result.year){
                    alert(JSON.stringify(result.year));
                    any_errors = true;
                }
                if(result.bio == "success"){
                    $('#bio').text($('#bio_input').val());
                }else if(result.bio){
                    alert(JSON.stringify(result.bio));
                    any_errors = true;
                }
                if(result.gender && result.gender != "success"){
                    alert(JSON.stringify(result.gender));
                    any_errors = true;
                }
                if(result.major == "success"){
                    $('#major_section > .info_name.major').remove();
                    if(any_major){
                        $('.edit_field.major').each(function(index){
                            if($(this).val()){
                                $('#major_section').append('<div class= "info_name major">'+$(this).val()+'</div>');
                            }
                        });
                    }

                } else if(result.major){
                    alert(result.major);
                    any_errors = true;
                }
                if(result.research == "success"){
                    $('#research_section > .info_name.research').remove();
                    if(any_research){
                        $('.edit_field.research').each(function(index){
                            if($(this).val()){
                                $('#research_section').append('<div class= "info_name research">'+$(this).val()+'</div>');
                            }
                        });
                    }

                } else if(result.research){
                    alert(result.research);
                    any_errors = true;
                }
                if(result.minor == "success"){
                    $('#minor_section > .info_name.minor').remove();
                    if(any_minor){
                        $('#minor_section').show();
                        $('.edit_field.minor').each(function(index){
                            if($(this).val()){
                                $('#minor_section').append('<div class= "info_name minor">'+$(this).val()+'</div>');
                            }
                        });
                    }

                } else if(result.minor){
                    alert(result.minor);
                    any_errors = true;

                }
                if(result.name == "success"){
                    var new_name = $('#name_input').val();
                    if($('#office_section').length){
                        $('#name_info').text("Professor "+new_name);
                    }else{
                        match = (new RegExp("([0-9]+)$")).exec($('#name_info').text());
                        if(match){
                            $('#name_info').text(new_name+" "+match[1]);
                        }else{
                            $('#name_info').text(new_name);
                        }
                    }
                    match = (new RegExp("(.+) ").exec(new_name));
                    if(match){
                        $('.profile_tab.feed').find('.profile_tab_text').text(match[1]+"'s Feed");
                    }
                    $('.MyBox_ProfileLink').text(new_name);
                    $('.post_owner[data-user_id='+globals.user_id+']').text(new_name);
                    $('.comment_owner[data-user_id='+globals.user_id+']').text(new_name);
                    $('.members_card .user_main_info .name[data-user_id='+globals.user_id+']').text(new_name);

                }else if(result.name){
                    alert(result.name);
                    any_errors = true;
                }
                if(result.school == "success"){
                    $('#school_name').text(
                        $('#school_dropdown > option[value='+$('#school_dropdown').val()+']').text());
                    $('#school_name').attr('href',base_url+'/school/'+$('#school_dropdown').val());
                }
                else if(result.school){
                    alert(result.school);
                    any_errors = true;
                }
                if(result.department == "success"){
                    $('#department_name').text(
                        $('#department_dropdown > option[value='+$('#department_dropdown').val()+']').text());
                    $('#department_name').attr('href',base_url+'/department/'+$('#department_dropdown').val());
                }
                else if(result.department){
                    alert(result.department);
                    any_errors = true;
                }
                if(result.email && result.email !="success"){
                    alert(result.email);
                    any_errors = true;
                }
                if(result.location == "success"){
                    $('#office_location').text($('#office_input').val());
                }else if(result.location){
                    alert(result.location);
                    any_errors = true;
                }
                if(result.hours == "success"){
                    $('#office_hours').text($('#hours_input').val());
                    $('#office_hours_info').text($('#hours_input').val());
                }else if(result.hours){
                    alert(result.hours);
                    any_errors = true;
                }
                if(!any_errors){
                    closeEditProfile();
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                alert(errorThrown);
            }
        });

    });
    $(document).on('change','#school_dropdown',function(){
        $.getJSON( base_url + "/profile/getDepartments",{school: $('#school_dropdown').val()}, function( result) {
            $('#department_dropdown').empty();
            $.each(result.departments,function(i,department){
                $('#department_dropdown').append($('<option/>').attr("value", department.id).text(department.name+' '+department.tag));
                if(i==0){
                    $('#department_dropdown').val(department.id);
                }
            });
        });
    });

    $(document).on('click','#cancel_edit_button',function(){
        closeEditProfile();
    });
    function closeEditProfile(){
        if(!any_research){
            $("#research_section").hide();
        }
        if(!any_major){
            $('.undeclared').show();
        }
        if(!any_minor){
            $('#minor_section').hide();
        }
        if(!any_bio){
            $('#bio_section').hide();
        }
        if(!any_year_name){
            $('#level_section').hide();
        }
        if(!any_year){
            $('#year_section').hide();
        }


        $('.headers').hide();
        $('.info_section.account').hide();
        $('.info_name').not('.undeclared').show();
        $('.edit_field').hide();
        $('.add_field_button').hide();
        $('.delete_field_button').remove();
        //$('#edit_profile_button').css('margin-left','15px');
        $('#edit_profile_button').text('Edit Profile');
        $('#cancel_edit_button').hide();
        $('#profile_foreground_overlay').hide();
        //$('#profile_picture_wrapper').css('z-index','');
        $('#edit_profile_button').removeClass('editing');
        $('#edit_profile_button').addClass('not_editing');
    }

    //autocomplete majors
    var major_text;
    var major_changed = false;
    var minor_changed = false;
    var major_index;
    $(document).on('keyup','.edit_field.major', function () {
       // alert('asdf')
        major_index = $('.edit_field.major').index(this);
        major_changed = true;
        major_text = $(this).val();
       // alert(major_text);
        $.getJSON(base_url + '/profile/autoComplete',{major: major_text},function (result) {
            $('.edit_field.major:eq('+major_index+')').autocomplete({source: result});
        });
    });
    $(document).on('keyup','.edit_field.minor', function () {
        major_index = $('.edit_field.minor').index(this);
        minor_changed = true;
        major_text = $(this).val();
        $.getJSON(base_url + '/profile/autoComplete',{major: major_text},function (result) {
            $('.edit_field.minor:eq('+major_index+')').autocomplete({source: result});
        });
    });

    //change profile picture
    $(document).on('click','#change_picture_button',function(){
        $('#picture_upfile').click();
    });
    var upload_file;
    $(document).on('change', '#picture_upfile', function (event)
    {
        upload_file = event.target.files[0];
        var data = new FormData();

        data.append("file", upload_file);
        data.append('user_id', $('#profile_wrapper').attr('data-user_id'));
        //data.append("user", globals.user_id);
        $.ajax({
            url: base_url+'/profile/changeProfilePicture',
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            success: function(data)
            {
                if(data.status == "success"){
                    $('#profile_picture').css('background-image','url('+data.file_url+')');
                    $('.post_user_icon[data-user_id='+globals.user_id+']').css('background-image','url('+data.file_url+')');
                    $('img.MyBox_Picture').attr('src',data.file_url);
                    $('.members_card_img[data-user_id='+globals.user_id+']').css('background-image','url('+data.file_url+')');
                }else{
                    //alert(data.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                alert('err'+errorThrown);
            }
        });
    });
    $(document).on('click','#follow_button',function(){

        var follow;

        if($(this).hasClass('following')){
            follow=0; // want to unfollow
        }else{
            follow=1;  //want to follow
        }
        $.ajax({
            url: base_url+'/profile/followUser',
            type: 'POST',
            data: {user_to_follow:$('#profile_wrapper').attr('data-user_id'),user:globals.user_id,follow:follow},
            dataType: 'json',
            success: function(data)
            {
                if(data.status == "success"){
                    var follower_count = parseInt($('#num_followers').text());
                    if(follow){
                        $.ajax({ url: base_url + '/protected/views/profile/user_box.html',
                            dataType:'html',
                            success: function(html){
                                var template = Handlebars.compile(html);
                                $('#followers_list').append(template(data));
                                $('#num_followers').text(follower_count+1);
                            }
                        });
                        $('#follow_button').addClass('following');
                        $('#follow_button').text('Following');

                        $('#follow_button > .follow_icon_profile_page').hide();
                    }else{
                        $('#followers_list').find('.members_card_wrapper[data-user_id='+data.user_id+']').remove();
                        $('#follow_button').removeClass('following');
                        $('#follow_button').text('Follow');
                        $('#follow_button').prepend('<span class = "follow_icon_profile_page"></span>');
                        $('#num_followers').text(follower_count-1);
                        $('#follow_button > .follow_icon_profile_page').show();
                    }

                }else{
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                alert('err'+errorThrown);
            }
        });
    });
    $(document).on('click','.edit_showcase_button.edit',function(){

        var $showcase_item = $(this).closest('.showcase_item');
        if($showcase_item.hasClass('center')){
            $showcase_item.find('.showcase_title').hide();
            $showcase_item.find('.showcase_description').hide();
            $showcase_item.find('.showcase_edit_field').css('display','block');
            $showcase_item.find('.edit_showcase_button').show();
            $showcase_item.find('.edit_showcase_button.edit').hide();
            $showcase_item.find('.edit_showcase_title').val($.trim($showcase_item.find('.showcase_title').text()));
            $showcase_item.find('.edit_showcase_description').val($.trim($showcase_item.find('.showcase_description').text()));
        }

    });
    var new_showcase_desc;
    var new_showcase_title;
    $(document).on('click','.edit_showcase_button.submit',function(){
        var $showcase_item = $(this).closest('.showcase_item');
        new_showcase_desc = $showcase_item.find('.edit_showcase_description').val();
        new_showcase_title = $showcase_item.find('.edit_showcase_title').val();
        $.ajax({
            url: base_url+'/profile/editShowcase',
            type: 'POST',
            data: {title:new_showcase_title,desc:new_showcase_desc,file:$showcase_item.attr('file_id'),user: globals.user_id},

            dataType: 'json',
            success: function(data)
            {
                if(data.status == "success"){
                    $showcase_item.find('.showcase_title').show();
                    $showcase_item.find('.showcase_description').show();
                    $showcase_item.find('.showcase_edit_field').hide();
                    $showcase_item.find('.edit_showcase_button').hide();
                    $showcase_item.find('.edit_showcase_button.edit').show();
                    $showcase_item.find('.showcase_title').text($showcase_item.find('.edit_showcase_title').val());
                    $showcase_item.find('.showcase_description').text($showcase_item.find('.edit_showcase_description').val());
                }else{
                    alert(data.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                alert('err'+errorThrown);
            }
        });
    });
    $(document).on('click','.edit_showcase_button.cancel',function(){
        var $showcase_item = $(this).closest('.showcase_item');
        $showcase_item.find('.showcase_title').show();
        $showcase_item.find('.showcase_description').show();
        $showcase_item.find('.showcase_edit_field').hide();
        $showcase_item.find('.edit_showcase_button').hide();
        $showcase_item.find('.edit_showcase_button.edit').show();
    });
    $(document).on('keyup','.search_bar',function(){
        $tab_section = $(this).parent();
        var search_text = $.trim($(this).val());
        $tab_section.find('.members_card_wrapper').each(function(){
           $(this).hide();
           if(($(this).attr('data-name')).search(new RegExp(search_text,'i'))>-1){
               $(this).show();
           }
        });
    });
    $(document).on('keyup','.search_bar.users',function(){
        $tab_section = $(this).parent();
        var search_text = $.trim($(this).val());
        $tab_section.find('.members_card_wrapper').each(function(){
            $(this).hide();
            if(($(this).attr('data-name')).match(new RegExp(search_text,'i'))){
                $(this).show();
            }
        });
    });
    $(document).on('keyup','.search_bar.groups',function(){
        $tab_section = $(this).parent();
        var search_text = $.trim($(this).val());
        $tab_section.find('.group_box').each(function(){
            $(this).hide();
            if(($(this).attr('data-name')).match(new RegExp(search_text,'i'))){
                $(this).show();
            }
        });
    });
    $(document).on('click', '.user_follow_button.profile', function () {
        if($(this).hasClass('own_profile')){
            return;
        }
        var $user_follow_button = $(this);
        var $user_box =  $user_follow_button.closest('.members_card_wrapper');
        var user_id = $user_box.attr('data-user_id');


        var $follow_button_wrapper = $user_follow_button.parent('.follow_button_wrapper');

        var verb = '';
        if ($follow_button_wrapper.hasClass('unfollow')) {
            verb = 'unfollow';
        } else {
            verb = 'follow';
        }


        var post_url = base_url + '/user/' + user_id + '/' + verb;




        var post_data = {user_id: user_id};

        $.post(
            post_url,
            post_data,
            function (response) {
                if (response['success']) {
                    var own_profile = $('#profile_wrapper').attr('data-user_id') == globals.user_id;
                    var $other_follow_button;
                    var following_count;
                    if($follow_button_wrapper.closest('.user_wrapper').attr('id')=="followers_list"){
                        $other_follow_button = $('#following_list').find('.members_card_wrapper[data-user_id='+user_id+']').find('.user_follow_button');
                    }else if($follow_button_wrapper.closest('.user_wrapper').attr('id')=="following_list"){
                        $other_follow_button = $('#followers_list').find('.members_card_wrapper[data-user_id='+user_id+']').find('.user_follow_button');
                    }
                    if (verb == 'unfollow') {
                        $follow_button_wrapper.removeClass('unfollow');
                        $user_follow_button.removeClass('following');
                        $user_follow_button.text('Follow');
                        if($other_follow_button){
                            $other_follow_button.removeClass('following');
                            $other_follow_button.text('Follow');
                        }
                        if(own_profile){
                            $('#following_list').find('.members_card_wrapper[data-user_id='+user_id+']').remove();
                            following_count = parseInt($('#num_following').text());
                            $('#num_following').text(following_count-1);
                        }
                    } else {
                        $user_follow_button.addClass('following');
                        $user_follow_button.text('Following');
                        if($other_follow_button){
                            $other_follow_button.addClass('following');
                            $other_follow_button.text('Following');
                        }
                        if(own_profile){
                            $user_box.clone().appendTo('#following_list');
                            //increment count
                            following_count = parseInt($('#num_following').text());
                            $('#num_following').text(following_count+1);
                        }
                    }

                } else {
                }
            }, 'json'
        );


    });
    $(document).on('mouseenter', '.user_follow_button.following', function () {
        var $follow_button_wrapper = $(this).parent('.follow_button_wrapper');
        $follow_button_wrapper.addClass('unfollow');
        $(this).text('Unfollow');
    });
    $(document).on('mouseleave', '.user_follow_button.following', function () {
        var $follow_button_wrapper = $(this).parent('.follow_button_wrapper');
        $follow_button_wrapper.removeClass('unfollow');
        $(this).text('Following');
    });

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


        close_fbar();
    }
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
    function isScriptAlreadyIncluded(src){
        var scripts = document.getElementsByTagName("script");
        for(var i = 0; i < scripts.length; i++)
            if(scripts[i].getAttribute('src') == src) return true;
        return false;
    }
});

