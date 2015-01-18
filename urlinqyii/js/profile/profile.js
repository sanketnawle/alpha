$(document).ready(function() {
    $(document).on('click', '.profile_link', function(){
        open_profile(base_url, $(this).attr('data-user_id'),$(this).hasClass('edit_profile'));
    });

    $(document).on('click', '.close_modal', function(){
        $('#profile_background_overlay').fadeOut(300);
        $("#page").removeClass("profile_stop_scroll");
        $("body").removeClass("profile_stop_scroll");
        $("body#body_home").removeClass("profile_stop_scroll");
    });
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
            $('#profile_background_overlay').fadeIn(300);
        });


    }
    function render_profile(base_url,data,edit_mode){

        $.ajax({ url: base_url + '/protected/views/profile/profile.html',
            dataType:'html',
            success: function(html) {

                $.getJSON( base_url + '/profile/'+data.user_id+'/feed', function( json_feed_data ) {
                    if(json_feed_data['success']){
                        //alert(JSON.stringify(json_feed_data));
//                alert(JSON.stringify(json_feed_data));
                        render_posts(json_feed_data['feed']);
                    }else{
                        console.log('failed to get feed');
                    }
                });
                $.ajax({ url: base_url + '/profile/returnFbar?user='+data.user_id,
                    dataType:'html',
                    success: function(html) {
                        $('#profile_fbar_wrapper').append(html);
                    }
                });
                numShowcase=data.showcase_size;
                var template = Handlebars.compile(html);
                $('body').append(template(data));
                if(!data.minors || data.minors.length==0){
                    $('#minor_section').hide();
                }
                if(!data.majors ||data.majors.length==0){
                    $('.info_name.undeclared').show();
                }
                if(!data.research){
                    $('#research_section').hide();
                }

                if(data.gender=="M"){
                    $('#radio_male').prop('checked',true);
                }else if(data.gender=="F"){
                    $('#radio_female').prop('checked',true);
                }
                $('#name_input').val(data.firstname+" "+data.lastname);
                $('#email_input').val(data.email);
                if(edit_mode==true){

                        $('#edit_profile_button.not_editing').click();

                }
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



            profile_render_post(post);
        });
    }

    function render_post_with_url(single_post){

        single_post.embed_link = findUrlInPost();

    }

    function profile_render_post(single_post){
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
            $('.showcase_items').css('margin-left', 260 - (index)*495);
            $('.showcase_item.center').removeClass('center');
            $('.showcase_item[showcase_index='+(index)+']').addClass('center');
        }
       // alert($('.showcase_item.center').attr('showcase_index'));
    });
    $(document).on('click','.showcase_arrow.right',function(){

        var index=parseInt($('.showcase_item.center').attr('showcase_index'));
        if(index<numShowcase-1){
            index++;
            $('.showcase_arrow.left').show();
            $('.showcase_items').css('margin-left', 260 - (index)*495);
            $('.showcase_item.center').removeClass('center');
            $('.showcase_item[showcase_index='+(index)+']').addClass('center');
        }
        //alert($('.showcase_item.center').attr('showcase_index'));
    });
    $(document).on('click','.add_showcase_button',function(){
        $(".add_showcase_text").fadeOut(250);
        $(".showcase_items").fadeOut(250);
        $(this).fadeOut(150).delay(250).queue(function(next){
            $('#profile_overlay').fadeIn(300);
            $('#add_showcase_form').fadeIn(300);
            $("#title_entry").focus();
            next();
        });
       //$('.overlay').css('z-index',2500);

    });
    $(document).on('click','#cancel_showcase_form',function(){
        $(".showcase_items").fadeIn(250);
        $('#add_showcase_form').fadeOut(350).delay(150).queue(function(next){
            $('.add_showcase_text').fadeIn(200);
            $('.add_showcase_button').fadeIn(50);
            next();
        });
        
        //kinyi add showcase to showcase bar: data.title, data.desc, data.file_extension, data.preview_file
        //reset form
        $('#link_entry').val('');
        $('#title_entry').val('');
        $('#desc_entry').val('');

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

                data.index = index;
                //add new showcase entry using the returned template
                if($('.showcase_item').length>0){
                    $('.showcase_item[showcase_index='+(index+1)+']').before(template(data));
                }else{
                    $('.showcase_items').append(template(data));
                    $('.showcase_controls').show();
                    $('#modal_header').removeAttr('style');
                    $('.add_showcase_button').removeClass('empty');
                    $('.add_showcase_button').text('+ Add a Showcase');

                }
                numShowcase++;
            }
        });
    }
    //add showcase code
    $(document).on('click','#upload_link_button',function(){
        $('#upfile').click();
    });
    var upload_file;
    $(document).on('change','#upfile', function (event)
    {

        upload_file = event.target.files[0];

        $('#link_entry').val(upload_file.name);
        $('#link_entry').prop("disabled", true);
    });

    $(document).on('submit','form[id=add_showcase]', function (event) {
        event.stopPropagation(); // Stop stuff happening
        event.preventDefault(); // Totally stop stuff happening
        // START A LOADING SPINNER HE
        // Create a formdata object and add the files
        var data = new FormData();
        if(upload_file){
            data.append("file", upload_file);
        }else if($('#link_entry').val() != ''){
            data.append("link_url",$('#link_entry').val());
        }else{
            alert('Please upload a file or provide a link to your file');
        }
        data.append("title", $('#title_entry').val());
        data.append("desc", $('#desc_entry').val());
        data.append("user", user_id);
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
                    $('#link_entry').val('');
                    $('#title_entry').val('');
                    $('#desc_entry').val('');
                    $('#upfile').val('');
                    upload_file = null;

                    render_new_showcase(data);
                    //alert(JSON.stringify(data));
                }else{
                    //alert(JSON.stringify(data));
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                alert('err'+jqXHR+textStatus+errorThrown);
            }
        });
    });

    //delete showcase
    $(document).on('click','.showcase_delete',function(){
        var file_id = parseInt($('.showcase_item.center').attr('file_id'));
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
            $('.showcase_items').css('margin-left', 260-(index-1)*495);
            $('.showcase_item[showcase_index='+(index-1)+']').addClass('center');
        }
        numShowcase--;
        if(numShowcase==0){
            $('.showcase_controls').hide();
        }
    }

    //edit profile

    var any_research;
    var schools_loaded = false;
    $(document).on('click','#edit_profile_button.not_editing',function(){
        $('#profile_overlay').show();
        $('#left_info_bar,#profile_picture_wrapper').css('z-index','3000');
        any_major=!$('#major_section >.info_name.undeclared').is(':visible');
        $('.info_name').hide();
        $('.headers').show();
        $('.edit_field').show();
        //school
        if(!schools_loaded){
            $.getJSON( base_url + "/profile/getSchools",{user: user_id}, function( result) {
                $.each(result.schools,function(i,school){
                    $('#school_dropdown').append($('<option/>').attr("value", school.id).text(school.name));
                });
                $('#school_dropdown').val(result.selected);
                schools_loaded=true;
            });
        }

        //department
        $('#department_dropdown').empty();
        $.getJSON( base_url + "/profile/getDepartments",{user: user_id}, function( result) {
            $.each(result.departments,function(i,department){
                $('#department_dropdown').append($('<option/>').attr("value", department.id).text(department.name));
            });
            $('#department_dropdown').val(result.selected);
        });
        //year and academic level
        $('#year_dropdown').val($('#year').text());
        $('#level_dropdown').val($('#level_name').text());
        //majors
        $('.info_name.major').each(function(i){
            if(!$(this).hasClass('undeclared')){
                $('.edit_field.major:eq('+i+')').val($(this).text());
            }
        });

        //minors
        any_minor=$('#minor_section').is(':visible');
        $('#minor_section').show();
        $('.info_name.minor').each(function(i){
            $('.edit_field.minor:eq('+i+')').val($(this).text());
        });
        //research
        any_research=$('#research_section').is(':visible');
        $('#research_section').show();

        $('.info_name.research').each(function(i){
            $('.edit_field.research:eq('+i+')').val($(this).text());
        });

        //bio
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
    var any_major;
    var any_minor;
    var any_research=false;
    var match;
    $(document).on('click','#edit_profile_button.editing',function(){  //submit changes
        //alert('done');
        var data = new FormData();
        data.append('school',$('#school_dropdown').val());
        data.append('user',user_id);
        data.append('name',$('#name_input').val());
        data.append('department',$('#department_dropdown').val());
        data.append('email',$('#email_input').val());
        data.append('bio',$('#bio_input').val());
        data.append('gender',$('.edit_field.gender:checked').val());
        if($('#year_section').length){
            data.append('year',$('#year_dropdown').val());
            data.append('year_name',$('#level_dropdown').val());
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
                if(result.year_name == "success"){
                    $('#level_name').text($('#level_dropdown').val());
                    match =(new RegExp("at (.+)$")).exec($('#year_info').text());
                    if(match){
                        $('#year_info').text($('#level_dropdown').val()+' at '+match[1]);
                    }
                }else if(result.year_name){
                    alert(result.year_name);
                    any_errors = true;
                }
                if(result.year == "success"){
                    $('#year').text($('#year_dropdown').val());
                    match =(new RegExp("([^0-9]+) ")).exec($('#name_info').text());
                    if(match) {
                        $('#name_info').text(match[1] + " " + (parseInt($('#year').text()) % 100));
                    }
                }else if(result.year){
                    alert(result.year);
                    any_errors = true;
                }
                if(result.bio == "success"){
                    $('#bio').text($('#bio_input').val());
                }else if(result.bio){
                    alert(result.bio);
                    any_errors = true;
                }
                if(result.gender && result.gender != "success"){
                    alert(result.gender);
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
                    if($('#office_section').length){
                        $('#name_info').text("Professor "+$('#name_input').val());
                    }else{
                        match = (new RegExp("([0-9]+)$")).exec($('#name_info').text());
                        if(match){
                            $('#name_info').text($('#name_input').val()+" "+match[1]);
                        }
                    }
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
                $('#department_dropdown').append($('<option/>').attr("value", department.id).text(department.name));
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
        $('.headers').hide();
        $('.info_section.account').hide();
        $('.info_name').not('.undeclared').show();
        $('.edit_field').hide();
        $('#edit_profile_button').css('margin-left','15px');
        $('#edit_profile_button').text('Edit Profile');
        $('#cancel_edit_button').hide();
        $('#profile_overlay').hide();
        $('#profile_picture_wrapper').css('z-index','');
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
        data.append("user", user_id);
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
                    $('.post_user_icon[data-user_id='+user_id+']').css('background-image','url('+data.file_url+')');
                    $('img.MyBox_Picture').attr('src',data.file_url);
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
            data: {user_to_follow:$('#profile_wrapper').attr('data-user_id'),user:user_id,follow:follow},
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
                    alert(data.message);
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
            data: {title:new_showcase_title,desc:new_showcase_desc,file:$showcase_item.attr('file_id'),user:user_id},

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


        alert(post_url);


        var post_data = {user_id: user_id};

        $.post(
            post_url,
            post_data,
            function (response) {
                if (response['success']) {
                    var own_profile = $('#profile_wrapper').attr('data-user_id');
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
                    alert(JSON.stringify(response));
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
});

