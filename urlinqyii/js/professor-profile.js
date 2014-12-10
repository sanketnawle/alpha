(function($) {
    var j$ = $.noConflict();
            $(document).ready(function () {

                

                //close description
                //add interest

                $(".visibility_new").change(function(){
                    var selected_val = $("#visibility_new").val();
                    //  alert (selected_val);
                    $.ajax({
                        type: "POST",
                        url: base_url + '/profile/updateHere',
                        data: {selected: selected_val},
                        success: function(data) {
                            alert("updated")
                        },
                        error: function(data) {
                            alert ("error")
                        }
                    });

                });

                var new_interests = new Array();
                $('input[name=interest_name]').bind('keypress', function(e) {

                    if(e.keyCode==13) {//if enter key is pressed
                        new_interests.push($('input[name=interest_name]').val());
                        $('#interest-section').append('<span class="interest-block">'+$('input[name=interest_name]').val()+'</span>\n')
                        $('input[name=interest_name]').val('');
                    }
                });

                //new add showcase code
                $('#upload-link-button').on('click',function(){

                    $('#upfile').click();
                });
                var upload_file;
                $('#upfile').on('change', function (event)
                {
                    upload_file = event.target.files[0];
                    $('#link-entry').val(upload_file.name);
                    $('#link-entry').prop("disabled", true);
                });


                $(".visibility_new").change(function(){
                var selected_val = $("#visibility_new").val();
                   //alert (selected_val);
                $.ajax({
                        type: "POST",
                        url: base_url + '/profile/updateHere',
                        data: {selected: selected_val},
                        success: function(data) {
                            alert("updated")
                        },
                        error: function(data) {
                            alert ("error")
                        }
                    });

                });

                $('form[id=add-showcase]').on('submit', function (event) {
                    event.stopPropagation(); // Stop stuff happening
                    event.preventDefault(); // Totally stop stuff happening
                    // START A LOADING SPINNER HE
                    // Create a formdata object and add the files
                    var data = new FormData();
                    if(upload_file){
                        data.append("uploadFile", upload_file);
                    }else if($('#link-entry').val() != ''){
                        data.append("link_url",$('#link-entry').val());
                    }else{
                        alert('Please upload a file or provide a link to your file');
                    }
                    data.append("title", $('#title-entry').val());
                    data.append("desc", $('#desc-entry').val());
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
                                //$('.showcase-bar').prepend('<img src="'+base_url+data.message+'">');
                                $('.showcase-form').hide();
                                $('.root').css('opacity', '1');

                                //kinyi add showcase to showcase bar: data.title, data.desc, data.file_extension, data.preview_file
                                //reset form
                                $('#link-entry').val('');
                                $('#title-entry').val('');
                                $('#link-entry').prop('disabled',false);
                                alert(data.message);
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
                //edit showcase
                var new_showcase_title;
                var new_showcase_desc;
                $('#edit-from-submit').on('click',function(){

                    new_showcase_desc = $('#showcase-link-edit').val();
                    new_showcase_title = $('#showcase-name-edit').val();
                    $('.root').css('opacity', '1');
                    $('.edit-showcase-form').css('display', 'none');
                    $.ajax({
                        url: base_url+'/profile/editShowcase',
                        type: 'POST',
                        data: {title:new_showcase_title,desc:new_showcase_desc,old_title:old_showcase_title},

                        dataType: 'json',
                        success: function(data)
                        {
                            if(data.status == "success"){
                                $('.showcase-image.center-image > .showcase-description-wrap > .showcase-title').text(new_showcase_title);
                                $('.showcase-image.center-image > .showcase-description-wrap > .showcase-description').text(new_showcase_desc);
                                //reset form
                                $('#showcase-desc-edit').val('');
                                $('#showcase-name-edit').val('');

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
                //follow or unfollow user
                var follow_unfollow;
                $('.follow_prof_button').on('click',function(){
                    if($.trim($(this).text()) == 'Follow'){
                        follow_unfollow = 'follow';
                    }else{
                        follow_unfollow = 'unfollow';
                    }
                    $.ajax({
                        url: base_url+'/profile/followUser',
                        type: 'POST',
                        data: {user_to_follow:user_profile_id,user:user_id,follow_unfollow:follow_unfollow},
                        dataType: 'json',
                        success: function(data)
                        {
                            if(data.status != "success"){
                                alert(data.message);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown)
                        {
                            alert('err'+errorThrown);
                        }
                    });
                });
                var follow_unfollow_user;

                $('.follow-btn').on('click',function(){
                    if($.trim($(this).find('a').text()) == 'Follow'){
                        follow_unfollow_user = 'follow';
                    }else{
                        follow_unfollow_user = 'unfollow';
                    }
                    var user_to_follow = $(this).parent().parent().parent().attr('id');
                    $.ajax({
                        url: base_url+'/profile/followUser',
                        type: 'POST',
                        data: {user_to_follow:user_to_follow,user:user_id,follow_unfollow:follow_unfollow_user},
                        dataType: 'json',
                        success: function(data)
                        {
                            if(data.status != "success"){
                                alert(data.message);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown)
                        {
                            alert('err'+errorThrown);
                        }
                    });
                });

              /*  $('.download-showcase-button').on('click',function(){
                    alert('download');
                    $type = $('.showcase-image.center-image').attr('data-file-type');
                    if($type == 'url'){
                        window.open()
                    }
                });*/
                //change profile pic
                $('.camera-icon-button,.camera-icon-button-before').on('click',function(){
                    $('#picture-upfile').click();
                });
                var upload_file;
                $('#picture-upfile').on('change', function (event)
                {
                    upload_file = event.target.files[0];

                    var data = new FormData();

                    data.append("uploadFile", upload_file);
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
                               $('.user-pic-div.user-pic-div-my').css('background','url('+base_url+data.file_url+') ' +
                               '    50% 50% / 100% no-repeat scroll rgb(51, 51, 51)');

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
                $("body").on("click", "#add-showcase-wrap-id button", function () {
                    $('.root').css('opacity', '0.1');
                    $('.showcase-form').css('display', 'initial');
                    $(".showcase-form").on("click", ".cancel-showcase-form", function () {
                        $('.root').css('opacity', '1');
                        $('.showcase-form').css('display', 'none');

                        //reset form
                        $('#link-entry').val('');
                        $('#title-entry').val('');
                        $('#link-entry').prop('disabled',false);
                        upload_file = null;
                    });

                    $(".showcase-form").on("click", ".close-description", function () {
                        $('.description-section').css('display', 'none');
                        $.post( base_url+"/profile/closeShowcaseInstructions", {user: user_id}, function( data ) {
                            if(data.status != "success"){
                                alert(data.status);
                            }
                        },"json");
                    });
                });
               /* $("body").on("mouseenter", ".profpic-container-real", function(){
                    $("#camera-icon-div").addClass("camera-icon-div");
                    $(".camera-icon-div button").addClass("camera-icon-button");
                    $(".camera-icon-div button").removeClass("camera-icon-button-before");
                });
                $("body").on("mouseleave", ".profpic-container-real", function(){
                    $("#camera-icon-div").removeClass("camera-icon-div");
                    $("#camera-icon-div button").removeClass("camera-icon-button");
                    $("#camera-icon-div button").addClass("camera-icon-button-before");
                });*/
                var school ='';
                var majors = new Array();
                var minors = new Array();

                var bio;
                var name;
                $("body").on("click", '.edit_prof_button', function(){
                    $('.user-information h1, .edit_prof_button').css('display', 'none');
                    $('.user-information .school-info').css('opacity', '0');
                    $('.edit-mode-control, .username-entry-field, .school-info-dropdown, .add-interest-button').css('display', 'initial');
                    $('#school-section').text('UPDATE YOUR SCHOOL');
                    $('#major-section').text('UPDATE YOUR MAJOR');
                    $('#minor-section').text('UPDATE YOUR MINOR');
                    $('#about-section h3').text('UPDATE YOUR BIO');
                    $('#about-section').css('margin-top', '50px');
                    $('h3 + i').addClass('add-major-minor');
                    $('#major-section + i').attr('id','major');
                    $('#minor-section + i').attr('id','minor');
                    $('h3').css('margin-left', '9px');
                    $('.info-block').css('margin-left', '5px');
                    $('.info-block input + i').addClass('delete-major-minor');
                    $('.info-block input').attr("readonly", false);
                    $('.info-block textarea').attr("readonly", false);
                    $('p.school-info').css('margin-top', '-20px');
                    $('.showcase-image-control').css('visibility', 'visible');
                    $('.user-groups, .showcase-image').addClass('blur_class');
                    $('.center-image').addClass('opacity_class');
                    $('.switch-image-panel').addClass('visible_class');
                    $('#circle-div-delete').addClass('hidden_class');
                    $('body').on('click', '#circle-div-switch-left, #circle-div-switch, #remove-showcase-button', function(){
                        $('.showcase-image').removeClass('opacity_class');
                        $('.showcase-image').addClass('blur_class');
                        $('.center-image').addClass('opacity_class');
                    });

                    $('input[name=username-entry]').val($('.info_username').text());

                    //save current info
                    school = $('input[name=school_name]').val();

                    $('input[name=major_name]').each(function(){
                        majors.push($(this).val());
                    });

                    $('input[name=minor_name]').each(function(){
                        minors.push($(this).val());
                    });
                    bio = $('.info-block textarea').val();
                    name = $('input[name=username-entry]').val();
                    new_interests = new Array();

                });
                $('body').on('click', '.cancel-edit-button', function(){
                    $('.user-information h1, .edit_prof_button').css('display', 'initial');
                    $('.user-information .school-info').css('opacity', '1');
                    $('.edit-mode-control, .username-entry-field, .school-info-dropdown, .add-interest-button').css('display', 'none');
                    $('.user-information').css('margin-top', '16px');
                    $('p.school-info').css('margin-top', '4px');
                    $('#school-section').text('SCHOOL');
                    $('#major-section').text('MAJOR');
                    $('#minor-section').text('MINOR');
                    $('#about-section h3').text('ABOUT');
                    $('#about-section').css('margin-top', '0px');
                    $('h3 + i').removeClass('add-major-minor');
                    $('h3').css('margin-left', '6px');
                    $('.info-block').css('margin-left', '2px');
                    $('.info-block input + i').removeClass('delete-major-minor');
                    $('.info-block input').attr("readonly", true);
                    $('.info-block textarea').attr("readonly", true);
                    $('.showcase-image-control').css('visibility', 'hidden');
                    // $('.user-groups').css('opacity', '1');
                    //$('.showcase-image').css('opacity', '1');
                    $('.user-groups').removeClass('blur_class');
                    $('.switch-image-panel').removeClass('visible_class');
                    $('#circle-div-delete').removeClass('hidden_class');
                    if(!$('input[name=major_name]').length){
                        $('#major-section').text('');
                    }
                    if(!$('input[name=minor_name]').length){
                        $('#minor-section').text('');
                    }

                    //load saved inputs
                    $('input[name=school_name]').val(school);

                    $('input[name=major_name]').parent().remove();
                    for(var i = 0;i<majors.length;i++){
                        $('#major-section').next().after( '<div class="info-block">'+
                        '<input name="major_name" value="'+majors[i]+'" title="'+majors[i]+'" readonly><i></i>'+
                        '</div>');
                    }
                    $('input[name=minor_name]').parent().remove();
                    for(var i = 0;i<minors.length;i++){
                        $('#minor-section').next().after( '<div class="info-block">'+
                        '<input name="minor_name" value="'+minors[i]+'" title="'+minors[i]+'" readonly><i></i>'+
                        '</div>');
                    }
                    majors=new Array();
                    minors=new Array();
                    $('.interest-block').each(function(){
                        if(new_interests.indexOf($(this).text()) != -1){
                            $(this).remove();
                        }
                    });
                    $('.info-block textarea').val(bio);
                    $('input[name=username-entry]').val(name);


                });
                //handle dropdowns
                var new_year;
                $('.yearpicker').on('change',function(){
                    new_year = $(this).val();
                });
                var new_year_name;
                $('.levelpicker').on('change',function(){
                    new_year_name = $(this).val();
                });
                //handle bio
                var new_bio;
                $('.info-block textarea').on('change',function(){
                    new_bio = $(this).val();
                });
                var new_name;
                $('input[name=username-entry]').on('change',function(){
                    new_name = $(this).val();
                });

                //autocomplete majors
                var major_text;
                var major_changed = false;
                var minor_changed = false;
                var index;
                $('body').on('keyup','input[name=major_name]', function () {
                    index = $('input[name=major_name]').index(this);
                    major_changed = true;
                    major_text = $(this).val();
                    $.ajax({
                        url: base_url + '/profile/autoComplete',
                        type: 'GET',
                        data: {major: major_text},
                        //  cache: false,
                        dataType: 'json',
                        // processData: false, // Don't process the files
                        // contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                        success: function (result) {

                            $('input[name=major_name]').eq(index).autocomplete({source: result});
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            alert(errorThrown);
                        }
                    });
                });
                $('body').on('keyup', 'input[name=minor_name]', function () {
                    index = $('input[name=minor_name]').index(this);
                    minor_changed = true;
                    major_text = $(this).val();
                    $.ajax({
                        url: base_url + '/profile/autoComplete',
                        type: 'GET',
                        data: {major: major_text},
                        //  cache: false,
                        dataType: 'json',
                        // processData: false, // Don't process the files
                        // contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                        success: function (result) {

                            $('input[name=minor_name]').eq(index).autocomplete({source: result});
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            alert(errorThrown);
                        }
                    });
                });

                var new_school;
                var school_text;
                $('input[name=school_name]').on('keyup',function(){
                    school_text = $(this).val();
                    $.ajax({
                        url: base_url+'/profile/autoComplete',
                        type: 'GET',
                        data: {school: school_text},
                        //  cache: false,
                        dataType: 'json',
                        // processData: false, // Don't process the files
                        // contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                        success: function(result)
                        {
                            $('input[name=school_name]').autocomplete({source:result});
                        },
                        error: function(jqXHR, textStatus, errorThrown)
                        {
                            alert(errorThrown);
                        }
                    });

                });
                //var deleted_majors = [];
                // var new_majors=[];
                $('body').on('click', '.finish-edit-button', function(){
                    $('.user-information h1, .edit_prof_button').css('display', 'initial');
                    $('.user-information .school-info').css('opacity', '1');
                    $('.edit-mode-control, .username-entry-field, .school-info-dropdown, .add-interest-button').css('display', 'none');
                    $('.user-information').css('margin-top', '16px');
                    $('p.school-info').css('margin-top', '4px');
                    $('#school-section').text('SCHOOL');
                    $('#major-section').text('MAJOR');
                    $('#minor-section').text('MINOR');
                    $('#about-section h3').text('ABOUT');
                    $('#about-section').css('margin-top', '0px');
                    $('h3 + i').removeClass('add-major-minor');
                    $('h3').css('margin-left', '6px');
                    $('.info-block').css('margin-left', '2px');
                    $('.info-block input + i').removeClass('delete-major-minor');
                    $('.info-block input').attr("readonly", true);
                    $('.info-block input[name=school_name]').attr("readonly", false);
                    $('.info-block textarea').attr("readonly", true);
                    $('.showcase-image-control').css('visibility', 'hidden');
                    // $('.user-groups').css('opacity', '1');
                    //  $('.showcase-image').css('opacity', '1');
                    $('.user-groups').removeClass('blur_class');
                    $('.switch-image-panel').removeClass('visible_class');
                    $('#circle-div-delete').removeClass('hidden_class');
                    if(!$('input[name=major_name]').length){
                        $('#major-section').text('');
                    }
                    if(!$('input[name=minor_name]').length){
                        $('#minor-section').text('');
                    }

                    var data = new FormData();
                    data.append('user',user_id);
                    if(new_year){
                        data.append('year',new_year);
                    }
                    if(new_bio){
                        data.append('bio',new_bio);
                    }
                    new_school = $('input[name=school_name]').val();
                    if($.trim(new_school) != $.trim(school)){
                        data.append('school',new_school);
                    }
                 //   $('input[name=major_name]')
                    if(major_changed == true){
                        if(!$('input[name=major_name]').length){
                            data.append('majors[0]', 'none');
                        }else{
                            $('input[name=major_name]').each(function(index){
                                data.append('majors['+index+']', $(this).val());
                            });
                        }
                    }
                    if(minor_changed == true){
                        if(!$('input[name=minor_name]').length){
                            data.append('minors[0]', 'none');
                        }else{
                            $('input[name=minor_name]').each(function(index){
                                data.append('minors['+index+']', $(this).val());
                            });
                        }
                    }
                    if(new_year_name){
                        data.append('year_name',new_year_name);
                    }

                    if(new_name){
                        data.append('name',new_name);
                    }
                    if(new_interests.length>0){
                        for(var i=0;i<new_interests.length;i++){
                            data.append('interests['+i+']',new_interests[i]);
                        }
                    }
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
                            if(result.year == "success"){
                                if(new_year){
                                    $('.school-info').text($('.school-info').text().replace(/\d{4}/,new_year));
                                }
                            }else if(result.year){
                                alert(result.year);
                            }
                            if(result.year_name == "success"){
                                $('.school-info').text($('.school-info').text().replace(/(Freshman|Sophomore|Junior|Senior|Master|PhD)/,new_year_name));
                            }else if(result.year_name){
                                alert(result.year_name);
                            }
                            if(result.bio && result.bio != "success"){
                                alert(result.bio);
                                $('.info-block textarea').val(bio);
                            }
                            if(result.major && result.major != "success"){
                                alert(result.major);
                                // $('input[name=major_name]').val(majors[0]);
                            }
                            if(result.minor && result.minor != "success"){
                                alert(result.minor);
                                // $('input[name=major_name]').val(majors[0]);
                            }
                            if(result.name == "success"){
                                $('#profile_name').text(new_name);
                            }else if(result.name){
                                alert(result.name);
                                $('input[name=username-entry]').val(name);
                            }
                            if(result.school == "success"){
                                $('input[name=school_name]').val(new_school);
                                $('input[name=school_name]').attr('id',result.new_school_id);
                            }
                            else if(result.school){
                                alert(result.school);
                                $('input[name=school_name]').val(school);
                            }

                            if(result.interests && result.interests != "success"){
                                alert(result.school);
                               // $('input[name=school_name]').val(school);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown)
                        {
                            alert(errorThrown);
                        }
                    });
                    $('.info-block input[name=school_name]').attr("readonly", true);
                    //alert(new_interests);

                    //add_interests(new_interests);
                    majors=new Array();
                    minors=new Array();

                });

                $('body').on('click', '.add-major-minor', function(){
                    var name = $(this).attr('id');
                    if(name == 'major'){
                        $(this).next().before("<div class=\"info-block\" style=\"margin-bottom: 20px; margin-left: 5px\"> <input name=\"major_name\"" +
                        " value=\"\"><i class=\"delete-major-minor\"></i></div>");
                    }else{
                        $(this).next().before("<div class=\"info-block\" style=\"margin-bottom: 20px; margin-left: 5px\"> <input name=\"minor_name\"" +
                        " value=\"\"><i class=\"delete-major-minor\"></i></div>");
                    }


                });

                $('body').on('click', '.delete-major-minor', function(){
                    minor_changed = true;
                    major_changed = true;
                    $(this).parent().remove();
                });
                var old_showcase_title;
                $('body').on('click', '#edit-showcase-button button', function(){
                    $('.root').css('opacity', '0.1');
                    $('.edit-showcase-form').css('display', 'initial');

                    var background = $(this).closest('.center-image').css('background-image');
                    var color = $(this).closest('.center-image').find('.showcase-label').css('background-color');
                    if(background != 'none'){
                        $('.edit-showcase-form').css('background-image', background );
                        $('.edit-showcase-form').css('background-color', 'none');
                    }
                    else{
                        $('.edit-showcase-form').css('background-image', 'none');
                        $('.edit-showcase-form').css('background-color', color );
                    }

                    var title = $(this).closest('.center-image').find('.showcase-title').text();
                    var description = $(this).closest('.center-image').find('.showcase-description').text();
                    $('.edit-showcase-form input[name=showcase-name]').val($.trim(title) );
                    $('.edit-showcase-form input[name=showcase-link]').val($.trim(description) );

                    $('body').on('click', '.edit-form-bottom span', function(){
                        $('.root').css('opacity', '1');
                        $('.edit-showcase-form').css('display', 'none');
                    });
                    old_showcase_title = $('.showcase-image.center-image > .showcase-description-wrap > .showcase-title').text();
                    $('#showcase-name-edit').val(old_showcase_title);
                    $('#showcase-desc-edit').val($('.showcase-image.center-image > .showcase-description-wrap > .showcase-description').text());
                });
                $("body").on("mouseenter", ".profpic-container-real", function(){
                    $("#camera-icon-div").addClass("camera-icon-div");

                    $(".camera-icon-div button").addClass("camera-icon-button");

                    setTimeout(function(){ $('.camera-icon-button span').text('Update Profile Picture'); }, 200);
                });
                $("body").on("mouseleave", ".profpic-container-real", function(){
                    $("#camera-icon-div").removeClass("camera-icon-div");
                    $("#camera-icon-div").addClass("camera-icon-div-before");
                    $("#camera-icon-div button").removeClass("camera-icon-button");
                    $("#camera-icon-div button").addClass("camera-icon-button-before");
                    $('.camera-icon-div-before span').text('');
                });
                $('body').on('mouseenter', '#circle-div-delete', function(){
                    $('#delete-on-hover-before').addClass('delete-on-hover');
                    $('#delete-on-hover-before').css('visibility', 'visible');
                    $('#hint_wedge-before').addClass('hint_wedge');
                });
                $('body').on('mouseleave', '#circle-div-delete', function(){
                    $('#delete-on-hover-before').removeClass('delete-on-hover');
                    $('#delete-on-hover-before').css('visibility', 'hidden');
                    $('#hint_wedge-before').removeClass('hint_wedge');
                });
                $('body').on('mouseenter', '.center-image', function(){
                    //$('.circle-div').css('visibility', 'visible');
                    $('.image-panel-wrapper').css('visibility', 'visible');
                });
                $('body').on('mouseleave', '.center-image', function(){
                    //$('.circle-div').css('visibility', 'hidden');
                    $('.image-panel-wrapper').css('visibility', 'hidden');
                });
                var index = 0;
                var frontImgIdx = getFrontImage(index);
                while( ($('#img-slot' + index).length) != 0){
                    var showcaseType = $('#img-slot' + index). attr('data-file-type');
                    if(showcaseType == '.pdf'){
                        $('#img-slot' + index + ' .showcase-label').css('background-color', '#f15c61');
                        $('#img-slot' + index + ' .showcase-label span').text('.pdf');
                    }
                    else if(showcaseType == 'url'){
                        $('#img-slot' + index + ' .showcase-label').css('background-color', 'transparent');
                        $('#img-slot' + index + ' .download-showcase-button').css('width', '48px');
                        $('#img-slot' + index + ' .download-showcase-button i').removeClass('download_button_icon');
                        $('#img-slot' + index + ' .download-showcase-button i').addClass('link_button_icon');
                        $('#img-slot' + index + ' .download-button-div').css('width','50px');
                        $('#img-slot' + index + ' .download-showcase-button').css('top','-1px');
                    }
                    else if(showcaseType == '.doc'){
                        $('#img-slot' + index + ' .showcase-label').css('background-color', '#2a5896');
                        $('#img-slot' + index + ' .showcase-label span').text('.doc');
                    }
                    else if(showcaseType == '.ppt'){
                        $('#img-slot' + index + ' .showcase-label').css('background-color', '#FD702D');
                        $('#img-slot' + index + ' .showcase-label span').text('.ppt');
                    }

                    var imgWidth = $('#img-slot' + index + ' img').width();
                    if(index == frontImgIdx){
                        $('#img-slot' + index).css( 'margin-left',  (($(window).width()/2) - (487/2)) );
                    }
                    else{
                        $('#img-slot' + index).css( 'margin-left', '7px' );
                    }
                    ++index;
                }
                $('body').on('click', '#circle-div-switch-left', function(){
                    var parentID = $(this).parents('.showcase-image').attr('id');
                    var siblingID = $(this).parents('.showcase-image').prev('.showcase-image').attr('id');
                    if( $('#' + siblingID).length != 0 ){
                        var parentWidth = $(this).parents('.showcase-image').width();
                        var prevImgWidth = $('#' + siblingID).width();
                        var originalMargin = parseInt( $('#img-slot'+frontImgIdx).css('margin-left') );
                        var newMargin = parentWidth/2 + 7 + prevImgWidth/2;
                        $('#' + parentID).removeClass('center-image');
                        $('#' + siblingID).addClass('center-image');
                        $('#img-slot'+frontImgIdx).css('margin-left', (originalMargin + newMargin) );
                        $('.image-panel-wrapper').detach().appendTo('#' + siblingID);
                        $('#download-showcase-button').css('background-position', '-28px -100px');
                        $('.showcase-image').removeClass('opacity_class');
                        $('.showcase-image').addClass('blur_class');
                        $('.center-image').addClass('opacity_class');
                    }
                });

                $('body').on('click', '#circle-div-switch', function(){
                    var parentID = $(this).parents('.showcase-image').attr('id');
                    var siblingID = $(this).parents('.showcase-image').next('.showcase-image').attr('id');
                    if( $('#' + siblingID).length != 0 ){
                        var parentWidth = $(this).parents('.showcase-image').width();
                        var nextImgWidth = $(this).parents('.showcase-image').next('.showcase-image').width();
                        var originalMargin = parseInt( $('#img-slot'+frontImgIdx).css('margin-left') );
                        var newMargin = parentWidth/2 + 7 + nextImgWidth/2;
                        $('#' + parentID).removeClass('center-image');
                        $('#' + siblingID).addClass('center-image');
                        $('#img-slot' + frontImgIdx).css('margin-left', (originalMargin - newMargin) );
                        $('.image-panel-wrapper').detach().appendTo('#' + siblingID);
                        $('#download-showcase-button').css('background-position', '-28px -100px');
                        $('.showcase-image').removeClass('opacity_class');
                        $('.showcase-image').addClass('blur_class');
                        $('.center-image').addClass('opacity_class');
                    }
                });
                $('body').on('click', '#circle-div-delete, #remove-showcase-button', function(){
                    var title = $('.showcase-image.center-image > .showcase-description-wrap > .showcase-title').text();
                    $.ajax({
                        url: base_url+'/profile/deleteShowcase',
                        type: 'POST',
                        data: {title:title},
                        dataType: 'json',
                        success: function(result)
                        {
                            if(result.status != "success"){
                                alert(result.status);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown)
                        {
                            alert(errorThrown);
                        }
                    });
                    var parentID = $(this).parents('.showcase-image').attr('id');
                    var siblingID = $(this).parents('.showcase-image').next('.showcase-image').attr('id');

                    if( $('#' + siblingID).length != 0 ){
                        if(parentID == 'img-slot' + frontImgIdx ){
                            var newFrontIdx = siblingID.replace( /[^\d.]/g, '' );
                            frontImgIdx =  parseInt(newFrontIdx);
                            var originalMargin = parseInt( $('#img-slot' + frontImgIdx).css('margin-left') );
                            $('#img-slot' + frontImgIdx).css('margin-left', (($(window).width()/2) - (480/2)) );
                            $('#img-slot' + frontImgIdx).addClass('center-image');
                            $('.image-panel-wrapper').detach().appendTo('#img-slot' + frontImgIdx);
                        }
                        else{
                            $('#' + siblingID).addClass('center-image');
                            $('.image-panel-wrapper').detach().appendTo('#' + siblingID);
                        }
                        $('#' + parentID).remove();
                    }
                    else{
                        var prevID = $(this).parents('.showcase-image').prev('.showcase-image').attr('id');
                        $('#' + prevID).addClass('center-image');
                        $('.image-panel-wrapper').detach().appendTo('#' + prevID);
                        var originalMargin = parseInt( $('#img-slot' + frontImgIdx).css('margin-left') );
                        $('#img-slot' + frontImgIdx).css('margin-left', (originalMargin + 480 + 'px') );
                        $('#' + parentID).remove();
                    }
                    $('.showcase-image').removeClass('opacity_class');
                    $('.showcase-image').addClass('blur_class');
                    $('.center-image').addClass('opacity_class');


                });

                $('body').on('click', '.follow_prof_button', function(){
                    $(this).addClass('following_prof_button');
                    $(this).next('i').remove();
                    $(this).text('Following');
                });
                $('body').on('click', '.following_prof_button', function(){
                    $(this).removeClass('following_prof_button');
                    $('.follow_prof_button').text('Follow');
                    $('<i></i>').appendTo('.follow_prof_button');
                });

                /*$(".user-class-visibility .container .current .drop").click(function(e){
                 $(e.target).parent().parent().trigger("click");
                 });*/
                $(".user-class-visibility .container .current").on("mouseover", function () {
                    $(this).addClass("mouseover");
                }); // When the user hovers on the privacy button the dropdown should be visible

                $(".user-class-visibility .container .current").on("mouseout", function (e) {
                    if (!$(e.target).parent().find(".options").is(":visible")) {
                        $(this).removeClass("mouseover");
                    }
                });// when the user mouse outs from the privacy button all other elements except the privacy label ( like public ) should be seen

                $(".user-class-visibility .container").click(function (e) {
                    var container = $(e.target);
                    while (!container.is(".user-class-visibility .container")) {
                        container = container.parent();
                    }
                    var addClass = true;
                    if (container.hasClass("active")) {
                        addClass = false;
                    }
                    $(".user-class-visibility .container").removeClass("active");
                    if (addClass) {
                        container.addClass("active");
                        $(".user-class-visibility .container .current").removeClass("mouseover");
                        container.find(".current").addClass("mouseover");
                    }
                });

                $(".user-class-visibility .option").click(function (e) {
                    e.stopPropagation();
                    e.preventDefault();
                    var visibility = $.trim($(this).text());
                    if(visibility == "Public"){
                        visibility =  "public";
                    }else if(visibility == "Just Me"){
                        visibility = "only_me";
                    }else if(visibility == "People I Follow"){
                        visibility = "following";
                    }
                    var class_id;
                    var group_id;
                    if($(this).parent().parent().parent().prev().attr('class')=='clublink'){
                        group_id = $(this).parent().parent().parent().prev().attr('id');
                    }else if($(this).parent().parent().parent().prev().attr('class')=='classlink'){
                        class_id = $(this).parent().parent().parent().prev().attr('id');
                    }

                    $.ajax({
                        url: base_url+'/profile/changeVisibility',
                        type: 'POST',
                        data: {class:class_id,visibility:visibility,user:user_id,group:group_id},
                        dataType: 'json',
                        success: function(result)
                        {
                            if(result.status != "success"){
                                alert(result.status);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown)
                        {
                            alert(errorThrown);
                        }
                    });
                    var container = $(this).closest(".container");
                    $(".current", container)[0].firstChild.data = $(this)[0].firstChild.data;
                    $(".option", container).removeClass("selected");
                    $(this).addClass("selected");
                    container.removeClass("active");
                    $(".user-class-visibility .container .current").removeClass("mouseover");

                    return false;
                });

                $(document).click(function (e) {
                    var container = $(".user-class-visibility .container")
                    if ((!container.is(e.target) && container.has(e.target).length === 0)) {
                        container.removeClass("active");
                        container.find(".current").removeClass("mouseover");
                    }
                    /*if(!(container.is(e.target) || container.has(e.target).length != 0 || container.hasClass("active"))) {
                     $(".user-class-visibility .container .current").removeClass("mouseover");
                     container.removeClass("active");
                     } */
                });

                /* Embedly for the showcase */
                //  j$.embedly.defaults.key = '110869001b274ee0a51767da08dafeef';
                function Embedly() {
                    // alert('ee');
                    j$("li.ddbox-invite-option").each(function (index) {
                        j$(this).find('div.content').embedly({
                            query: {
                                wmode: 'transparent',
                                autoplay: true
                            },
                            method: 'after',
                            display: function (data, elem) {

                                //Adds the image to the a tag and then sets up the sizing.
                                j$(elem).html('<div style="width:150px; height:122px;background: url(' + data.thumbnail_url + ') no-repeat scroll 50% 50% / 100% auto transparent;"></div>')
                                    .width('150')//(data.thumbnail_width)
                                    .height('122')//(data.thumbnail_height)
                                    .find('span').css('top', data.thumbnail_height / 2 - 36)
                                    .css('left', data.thumbnail_width / 2 - 36);
                                //alert($(elem).html());
                                var j$elhtml = j$(elem).html();
                                j$(elem).closest(".post_lr_link_msg").find(".link-img").html(j$elhtml);

                                var t_title = data.title;
                                var t_des = data.description;
                                var t_url = data.url;
                                //alert(data.title+" , "+data.description+", "+data.url);
                                var ctt = t_title + "<span class='link-text-website'>" + t_url + "</span>";

                                //j$(elem).closest(".post_lr_link_msg").find(".link-text-title").html(ctt);
                                //j$(elem).closest(".post_lr_link_msg").find(".link-text-about").html(t_des);

                                if (data.type === 'video') {
                                    $(this).append('<div style="background-position: 0% 0%; left: 25px; height: 50px; width: 50px; margin-top: -85px;" class="play_btn"></div>');
                                }
                                // else {
                                //    j$(elem).closest(".post_lr_link_msg").find(".play_btn").hide();
                                //}
                            }
                        });
                    });
                }
                $(document).delegate('.showcase-container', 'mouseover', function () {
                    $(this).find('.showcase-link').stop().animate({opacity: '1', marginTop: '35px'}, 0);
                });
                $(document).delegate('.showcase-container', 'mouseout', function () {
                    $(this).find('.showcase-link').stop().animate({opacity: '0', marginTop: '95px'}, 0);
                });

                $(document).on('pageload', function () {
                    $('.no-showcase').hide();
                    $('.no-showcase').fadeIn(900);
                });

                $(document).delegate('.link', 'click', function () {

                    $(this).text('Following');
                    $(this).removeClass('link');
                    $(this).addClass('pre-linked');

                });

                var cl_cache = ['#333', '#333', '#333', '#333', '#333'];
                $(document).delegate('.tab-inactive', 'click', function () {
                    $('.tab-active').addClass('tab-inactive');
                    $('.tab-active').removeClass('tab-active');
                    //alert('aa');
                    $(this).removeClass('tab-inactive');
                    $(this).addClass('tab-active');

                    var activeTab = $(this);
                    var activeTabposition = activeTab.position();
                    var activeTabLeft = activeTabposition.left;
                    var activeTabNew = activeTabLeft + 63;
                    //var activeColor = activeTab.
                    $('.tab-indicator').css('margin-left', activeTabNew);

                    //var cl=$('.tab-active').css('color');
                    //alert(cl);
                    var index = 0;
                    if ($(this).hasClass('tab-1')) {
                        index = 0;
                    }
                    if ($(this).hasClass('tab-2')) {
                        index = 1;
                    }
                    if ($(this).hasClass('tab-3')) {
                        index = 2;
                    }
                    if ($(this).hasClass('tab-4')) {
                        index = 3;
                    }
                    if ($(this).hasClass('tab-5')) {
                        index = 4;
                    }
                    //$('.tab-indicator').css('background-color',cl_cache[index]);
                    $('.caret-transform').css('border-bottom-color', cl_cache[index]);
                    //alert(cl);
                    //$('.caret-transform').css('border-bo',activeTabNew);
                });

                $(document).delegate('.professor-tab', 'mouseover', function () {
                    if ($(this).hasClass('tab-1')) {
                        index = 0;
                    }
                    if ($(this).hasClass('tab-2')) {
                        index = 1;
                    }
                    if ($(this).hasClass('tab-3')) {
                        index = 2;
                    }
                    if ($(this).hasClass('tab-4')) {
                        index = 3;
                    }
                    if ($(this).hasClass('tab-5')) {
                        index = 4;
                    }
                    $(this).css('color', cl_cache[index]);
                });

                $(document).delegate('.professor-tab', 'mouseout', function () {

                    $(this).css('color', '#acacac)');
                    $(this).find('tab-count').css('color', '#acacac');
                });

                $(document).delegate('.pre-linked', 'mouseout', function () {
                    $(this).text('Following');
                    $(this).removeClass('pre-linked');
                    $(this).addClass('linked');
                });

                $(document).delegate('.linked', 'mouseover', function () {
                    $(this).text('Unfollow');
                });

                $(document).delegate('.linked', 'mouseout', function () {
                    $(this).text('Following');
                });

                $(document).delegate('.linked', 'click', function () {
                    $(this).text('Follow');
                    $(this).removeClass('linked');
                    $(this).addClass('link');
                });

                $(document).delegate('.professor-tab', 'click', function () {
                    // Courses
                    if ($(this).hasClass('tab-2')) {
                        //if ($('.user-tab-groups-content').children().length <= 0) {
                        //    FetchCourses(user_type);
                        //}
                        $('.user-tab-following-content').hide();
                        $('.user-tab-followers-content').hide();
                        $('.user-tab-followers-content').animate({opacity: '0'}, 200);
                        $('.user-tab-following-content').animate({opacity: '0'}, 200);
                        $('.user-tab-dicussions-content').animate({opacity: '0'}, 200);
                        $('.user-tab-clubs-content').hide();
                        $('.user-tab-clubs-content').animate({opacity: '0'}, 200);
                        $('.user-tab-discussions-content').hide();
                        $('.user-tab-groups-content').show();
                        $('.user-tab-groups-content').animate({opacity: '1'}, 200);
                    }
                    // Feeds
                    if ($(this).hasClass('tab-1')) {
                        $('.user-tab-following-content').hide();
                        $('.user-tab-followers-content').hide();
                        $('.user-tab-followers-content').animate({opacity: '0'}, 200);
                        $('.user-tab-following-content').animate({opacity: '0'}, 200);
                        $('.user-tab-clubs-content').hide();
                        $('.user-tab-clubs-content').animate({opacity: '0'}, 200);
                        $('.user-tab-groups-content').hide();
                        $('.user-tab-groups-content').animate({opacity: '0'}, 200);
                        $('.user-tab-discussions-content').show();
                        $('.user-tab-dicussions-content').animate({opacity: '1'}, 200);
                    }
                    // Following
                    if ($(this).hasClass('tab-3')) {
                        //if ($('.user-tab-following-content').children().length <= 0) {
                        //   FetchConnections();
                        //}
                        $('.user-tab-groups-content').hide();
                        $('.user-tab-followers-content').hide();
                        $('.user-tab-followers-content').animate({opacity: '0'}, 200);
                        $('.user-tab-groups-content').animate({opacity: '0'}, 200);
                        $('.user-tab-clubs-content').hide();
                        $('.user-tab-clubs-content').animate({opacity: '0'}, 200);
                        $('.user-tab-discussions-content').hide();
                        $('.user-tab-dicussions-content').animate({opacity: '0'}, 200);
                        $('.user-tab-following-content').show();
                        $('.user-tab-following-content').animate({opacity: '1'}, 200);
                    }
                    // Followers
                    if ($(this).hasClass('tab-4')) {
                        //if ($('.user-tab-followers-content').children().length <= 0) {
                        //    FetchConnections();
                        //}
                        $('.user-tab-groups-content').hide();
                        $('.user-tab-groups-content').animate({opacity: '0'}, 200);
                        $('.user-tab-clubs-content').hide();
                        $('.user-tab-clubs-content').animate({opacity: '0'}, 200);
                        $('.user-tab-discussions-content').hide();
                        $('.user-tab-dicussions-content').animate({opacity: '0'}, 200);
                        $('.user-tab-following-content').hide();
                        $('.user-tab-following-content').animate({opacity: '0'}, 200);
                        $('.user-tab-followers-content').show();
                        $('.user-tab-followers-content').animate({opacity: '1'}, 200);
                    }
                    // Clubs
                    if ($(this).hasClass('tab-5')) {
                        //if ($('.user-tab-clubs-content').children().length <= 0) {
                        //    FetchClubs();
                        //}
                        $('.user-tab-groups-content').hide();
                        $('.user-tab-groups-content').animate({opacity: '0'}, 200);
                        $('.user-tab-discussions-content').hide();
                        $('.user-tab-dicussions-content').animate({opacity: '0'}, 200);
                        $('.user-tab-following-content').hide();
                        $('.user-tab-following-content').animate({opacity: '0'}, 200);
                        $('.user-tab-followers-content').hide();
                        $('.user-tab-followers-content').animate({opacity: '0'}, 200);
                        $('.user-tab-clubs-content').show();
                        $('.user-tab-clubs-content').animate({opacity: '1'}, 200);
                    }
                });

                $(document).delegate('.oh-editor-fx', 'click', function () {
                    $(this).hide();
                    $('.blacksheet').fadeIn(200);
                    $('.blacksheet-main').fadeIn(200);
                    //$('.office-hours').hide();
                });

                //Cancel the office hours edit
                $(document).delegate('.cancel-edit-officehrs', 'click', function () {
                    $('.blacksheet').hide();
                    $('.oh-editor-fx').fadeIn(200);
                    $('.blacksheet-main').fadeOut(200);
                    //$('.office-hours').show();
                    $('.resource-wrapper').css('z-index', '1');
                });

                // To edit the office hours and update the databsae
                $(document).delegate('.done-editing', 'click', function () {
                    UpdateOfficeHours();

                    $('.blacksheet').hide();
                    $('.oh-editor-fx').fadeIn(200);
                    $('.blacksheet-main').fadeOut(200);
                    //$('.office-hours').show();
                    $('.resource-wrapper').css('z-index', '1');
                });

                // edit profile event click
                $(document).delegate('.edit-profile', 'click', function () {

                    $(this).hide();
                    $('.profpic-container-real').hide();
                    $('.user-info-wrapper').css('opacity', '0');
                    $('.blacksheet-main').fadeIn(400);
                    $('.main-2').show();
                    //$('.ns-hide').hide();
                    //$('.user-website').hide();
                    $('.resource-wrapper').css('z-index', '9999');
                });

                // cancel the edit profile
                $(document).delegate('.cancel-edit-profile', 'click', function () {
                    $('.blacksheet-main').fadeOut(400);
                    $('.main-2').hide();
                    $('.edit-profile').show();
                    $('.profpic-container-real').show();
                    $('.add_book_list').show()
                    $('.user-info-wrapper').css('opacity', '1');
                    //$('.ns-hide').show();
                    //$('.user-website').show();
                    $('.resource-wrapper').css('z-index', '1');
                });

                // save the edit profile
                $(document).delegate('#user_fname', 'click', function () {
                    $(this).removeClass("error_box_log_color");
                });
                $(document).delegate('#user_lname', 'click', function () {
                    $(this).removeClass("error_box_log_color");
                });


                $(document).delegate('.save-edit-profile', 'click', function () {

                    $edit_allow_flag = false;
                    $edit_allow_flag = ($("#user_fname").val().trim() == "") || ($("#user_lname").val().trim() == "");

                    if ($edit_allow_flag) {
                        $("#user_fname").addClass("error_box_log_color");
                        $("#user_lname").addClass("error_box_log_color");

                    } else {
                        $('.blacksheet-main').fadeOut(400);
                        $('.main-2').hide();
                        $('.edit-profile').show();
                        $('.profpic-container-real').show();
                        $('.add_book_list').show()
                        $('.user-info-wrapper').css('opacity', '1');
                        //$('.ns-hide').show();
                        //$('.user-website').show();
                        $('.resource-wrapper').css('z-index', '1');

                        if (is_owner) {
                            InsertEditProfileData();
                        }

                    }


                });

                $(document).delegate('.add_book_list', 'click', function () {
                    $(this).fadeOut(200);
                });
                $(document).delegate('.oh_checkbox', 'click', function () {
                    $('.time_select_fx').hide();
                    $(this).closest('.oh_day_select').find('.oh_checkbox_label').css({
                        'background-position': '0 -15px',
                        'color': 'rgba(55, 55, 55,1)'
                    });
                    $(this).addClass('oh_checkbox_checked');
                    $(this).closest('.oh_day_select').find('.time_select_fx').show();
                });
                $(document).delegate('.oh_checkbox_checked', 'click', function () {
                    $(this).closest('.oh_day_select').find('.oh_checkbox_label').css({
                        'background-position': '0px 0px',
                        'color': 'rgba(77, 77, 77,.6)'
                    });
                    $(this).removeClass('oh_checkbox_checked');
                    $(this).closest('.oh_day_select').find('.time_select_fx').hide();
                });

                // to fade in on page load
                $(document).delegate('.ns-btn', 'click', function () {
                    $(this).closest('.no-showcase').hide();
                    $(this).closest('.resource-wrapper').find('.showcase_step2').show();
                    $('.showcase-photos').hide();
                });

                $(document).delegate('.add-more-showcase', 'click', function () {
                    $(this).closest('.no-showcase').hide();
                    $(this).closest('.resource-wrapper').find('.showcase_step2').show();
                    $('.showcase-photos').hide();
                    $('#showcase_file_error').hide();
                    $('#showcase_link_error').hide();
                    $('.sc_cancel').trigger('click');
                });

                var sc_click_flag = 0;
                $(document).delegate('.showcase_left_box', 'click', function () {
                    if (sc_click_flag == 0) {
                        sc_click_flag = 1;
                        $('#showcase_file_error').hide();
                        $('#showcase_link_error').hide();
                        $('.showcase_right_box > *').hide();
                        $('.showcase_left_box > *').hide();
                        $(this).closest('.showcase_step2').find('.step2_content_anchor_files').show();
                        $(this).closest('.showcase_step2').find('.step2_content_anchor_link').hide();
                    }
                });

                $(document).delegate('.showcase_right_box', 'click', function () {
                    if (sc_click_flag == 0) {
                        sc_click_flag = 1;
                        $('#showcase_file_error').hide();
                        $('#showcase_link_error').hide();
                        $('.showcase_left_box > *').hide();
                        $('.showcase_right_box > *').hide();
                        $(this).closest('.showcase_step2').find('.step2_content_anchor_link').show();
                        $(this).closest('.showcase_step2').find('.step2_content_anchor_files').hide();
                    }
                });

                /* Upload the showcase file */

                // Upload the file from the local computer or google drive file
                $(document).delegate("#addShowcaseFile", "click", function () {

                    var title = $('#titlefileupload').val().trim();
                    var fileexistproof = $('#fileUpload').val();
                    var fileexistproof2 = $(".googleuploadinfoarchive_fbar").val();

                    if ((fileexistproof != "") && (title != null)) {

                        var formData = new FormData($(".showcase_step2").find("form")[0]);
                        formData.append("title", title);

                        $.ajax({
                            type: "POST",
                            url: "php/profile/showcase.php",
                            xhr: function () {  // Custom XMLHttpRequest
                                var myXhr = $.ajaxSettings.xhr();
                                if (myXhr.upload) { // Check if upload property exists
                                    myXhr.upload.addEventListener('progress', progressHandlingFunction, false); // For handling the progress of the upload
                                }
                                return myXhr;
                            },
                            dataType: "json",
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function (responseText) {
                                $('.sc_cancel').trigger('click');
                                $('.showcase-photos').show();
                                $('.showcase_step2').hide();

                                if ((responseText.showcase_ele != null) && (responseText.showcase_ele.length > 0) && (responseText.showcase_ele[0].length > 0)) {
                                    $('#inviteConnections').children('li').remove();
                                    for (var i = 0; i < responseText.showcase_ele.length; i++) {
                                        for (var j = 0; j < responseText.showcase_ele[i].length; j++) {
                                            DisplayShowcase(responseText.showcase_ele[i][j]);
                                        }
                                    }
                                    Embedly();
                                    $('.sc_btn').trigger('click');
                                }
                            },
                            error: function (responseText) {
                                alert(responseText);
                            }
                        });
                    }
                    else if (fileexistproof2 != "") {
                        var fileinfo = $(".googleuploadinfoarchive_fbar").val().trim().split("||");
                        var gdrive_id = fileinfo[0].trim();
                        var gdrive_type = fileinfo[1].trim();
                        var gdrive_url = fileinfo[2].trim();
                        var gdrive_name = fileinfo[3].trim();

                        $.ajax({
                            type: "POST",
                            url: "php/profile/showcase.php",
                            dataType: "json",
                            data: {
                                title: title,
                                gdrive_id: gdrive_id,
                                gdrive_name: gdrive_name,
                                gdrive_url: gdrive_url,
                                gdrive_type: gdrive_type
                            },
                            success: function (responseText) {
                                $('.sc_cancel').trigger('click');
                                $('.showcase-photos').show();
                                $('.showcase_step2').hide();

                                //Embedly();

                                if ((responseText.showcase_ele != null) && (responseText.showcase_ele.length > 0) && (responseText.showcase_ele[0].length > 0)) {
                                    $('#inviteConnections').children('li').remove();
                                    for (var i = 0; i < responseText.showcase_ele.length; i++) {
                                        for (var j = 0; j < responseText.showcase_ele[i].length; j++) {
                                            DisplayShowcase(responseText.showcase_ele[i][j]);
                                        }
                                    }
                                    Embedly();
                                    $('.sc_btn').trigger('click');
                                }
                            },
                            error: function (responseText) {
                                alert(responseText);
                            }
                        });
                    }
                    else {
                        $('#showcase_file_error').show();
                    }

                    //reset
                    $("#titlefileupload").val("");
                    $(".cf_prompt").text("No file chosen");
                    $(".googleuploadinfoarchive_fbar").val("");
                    $("#fileUpload").val("");
                });

                /* Upload showcase file code ends here */

                // To upload a showcase link
                $(document).delegate('#addShowcaseLink', 'click', function () {

                    var title = $('#titlelinkupload').val().trim();
                    var link = $('#linkLocation').val().trim();

                    if ((link != "") && (title != "")) {

                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: "php/profile/showcase.php",
                            data: {title: title, link: link},
                            success: function (responseText) {

                                $('.sc_cancel').trigger('click');
                                $('.showcase-photos').show();
                                $('.showcase_step2').hide();
                                Embedly();
                                alert("q");
                                if ((responseText.showcase_ele != null) && (responseText.showcase_ele.length > 0) && (responseText.showcase_ele[0].length > 0)) {
                                    $('#inviteConnections').children('li').remove();
                                    for (var i = 0; i < responseText.showcase_ele.length; i++) {
                                        for (var j = 0; j < responseText.showcase_ele[i].length; j++) {
                                            DisplayShowcase(responseText.showcase_ele[i][j]);
                                        }
                                    }
                                    Embedly();

                                    $('.sc_btn').trigger('click');
                                }
                            },
                            error: function (responseText) {
                                alert(responseText);
                            }
                        });
                    }
                    else {
                        $('#showcase_link_error').show();
                    }

                    //reset
                    $("#titlelinkupload").val("");
                    $('#linkLocation').val("");
                });

                $(document).delegate('.sc_cancel', 'click', function () {
                    $(this).closest('.showcase_step2').addClass('clickable_showcase_step2');
                    //$(this).closest('.step2_content_anchor').empty();
                    alert("wqe");
                    $('.showcase_right_box').css({'width': '225px', 'opacity': '1'});
                    $('.showcase_left_box').css({'width': '225px', 'opacity': '1'});
                    $(this).closest('.showcase_step2').find('.step2_content_anchor_link').hide();
                    $(this).closest('.showcase_step2').find('.step2_content_anchor_files').hide();
                    $('.showcase_left_box > *').show();
                    $('.showcase_right_box > *').show();
                    sc_click_flag = 0;
                    $('#showcase_file_error').hide();
                    $('#showcase_link_error').hide();
                    //$(".sc_btn").trigger("click");
                });

                $(document).delegate('.sc_btn', 'click', function () {
                    //$(this).closest('.showcase_step2').addClass('clickable_showcase_step2');
                    //$(this).closest('.step2_content_anchor').empty();
                    //$('.showcase_right_box').css({ 'width': '225px', 'opacity': '1' });
                    //$('.showcase_left_box').css({ 'width': '225px', 'opacity': '1' });
                    //$('.showcase_left_box > *').show();
                    //$('.showcase_right_box > *').show();
                    $(this).closest('.showcase_step2').hide();
                    if ($('#inviteConnections').children('li').length > 0) {
                        $('.no-showcase').hide();
                        $('.showcase-photos').show();
                    }
                    else {
                        $('.no-showcase').show();
                        $('.showcase-photos').hide();
                    }

                    sc_click_flag = 0;
                    $('#showcase_file_error').hide();
                    $('#showcase_link_error').hide();
                });

                $(document).delegate('.cf_bt_normal', 'click', function () {
                    $(this).closest('.showcase_step2').find('.step2_file').click();
                    return false;
                });

                $(document).delegate('.step2_file', 'change', function () {
                    var $hack = $(this).closest('.showcase_step2').find('.step2_file');

                    var filename = $hack.val();

                    if (filename.length >= 18) {
                        filename = filename.substring(0, 15) + '...';
                    }
                    //alert(filename);
                    $('.cf_bt_normal').next('.cf_prompt').text(filename);
                    $('.cf_bt_normal').next('.cf_prompt').attr('title', $hack.val());
                });

                $(document).delegate('.upload-pic-btn', 'click', function () {
                    $(this).closest('.profpic-container').find('.photo_fileup').click();
                    return false;
                });

                $(document).delegate('.pic-text-icon', 'click', function () {
                    $('.photo_fileup').click();
                    return false;
                });

                $(document).delegate('.pic-text', 'click', function () {
                    $('.photo_fileup').click();
                    return false;
                });

                $(document).delegate('.photoup_simulator', 'click', function () {
                    $(this).closest('.profpic-container').find('.photo_fileup').click();
                    return false;
                });

                $(document).delegate('.photo_fileup', 'change', function () {
                    InsertProfilePicture();
                });

                /* Showcase delete */
                function DeleteShowcase(file_id, file_share_type) {
                    $.ajax({
                        type: "POST",
                        url: "php/profile/showcase.php",
                        dataType: "json",
                        data: {file_id: file_id, file_share_type: file_share_type, del_showcase: true},
                        success: function (responseText) {
                            if ((responseText.showcase_ele != null) && (responseText.showcase_ele.length > 0) && (responseText.showcase_ele[0].length > 0)) {
                                $('#inviteConnections').children('li').remove();
                                for (var i = 0; i < responseText.showcase_ele.length; i++) {
                                    for (var j = 0; j < responseText.showcase_ele[i].length; j++) {
                                        DisplayShowcase(responseText.showcase_ele[i][j]);
                                    }
                                }
                                Embedly();
                                $('.sc_btn').trigger('click');
                            }
                        },
                        error: function (responseText) {
                            alert(responseText);
                        }
                    });
                }

                $(document).delegate('.delete-showcase', 'click', function () {
                    var delete_id = $(this).parents('li.ddbox-invite-option').prop('id').split('_');
                    DeleteShowcase(delete_id[1], delete_id[2]);
                });

                /* Code for showcase delete ends here */

                /* Functions and events to fetch and edit the data */

                // Querystring split and fetch
                var qs = (function (a) {
                    if (a == "") return {};
                    var b = {};
                    for (var i = 0; i < a.length; ++i) {
                        var p = a[i].split('=');
                        if (p.length != 2) continue;
                        b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, " "));
                    }
                    return b;
                })(window.location.search.substr(1).split('&'));

                var is_owner = false;
                var user_type = "";
                if ((qs["user_id"] != null) && (qs["user_id"] != "")) {
                    FetchProfileDetails(qs["user_id"]);
                    FetchInterests();
                    FetchConnections();
                    FetchClubs();
                }

                // Fetch the profile info from the database
                function FetchProfileDetails(user_id) {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "php/profile/profile_fun.php",
                        data: {
                            user_info: user_id
                        },
                        success: function (responseText) {
                            // Gets both the basic profile and the showcase details

                            if ((responseText.prof_info != null) && (responseText.prof_info.length > 0)) {
                                for (var i = 0; i < responseText.prof_info.length; i++) {
                                    DisplayProfileDetails(responseText.prof_info[i]);
                                    if ((responseText.attribs != null) && (responseText.attribs.length > 0)) {
                                        console.log(responseText.attribs[i]);
                                        DisplayAttribsDetails(responseText.attribs[i], responseText.prof_info[i]['user_type'].toLowerCase());

                                        FetchDepartments(responseText.prof_info[i]['univ_id'], responseText.prof_info[i]['dept_id'], responseText.attribs[i]['show_major']);
                                    }
                                    // to set the univ ID
                                    $('#profile_teaches_at').data('univID', responseText.prof_info[i]['univ_id']);

                                    is_owner = responseText.prof_info[i]['is_owner'];
                                    if (!is_owner) {
                                        $('.ns-hide').hide();
                                        $('.showcase_step2').hide();
                                        $('.add-more-showcase').hide();
                                        $('.showcase-photos').show();
                                        $('#profile_status_bar').remove();
                                    }
                                    else {
                                        $('.ns-hide').show();
                                        $('.edit-profile-main-wrap').html("<a class = 'edit-profile'>Edit Profile</a>");
                                    }
                                    user_type = responseText.prof_info[i]['user_type'].toLowerCase();
                                    FetchCourses(user_type);
                                }
                            }
                            if ((responseText.showcase_ele != null) && (responseText.showcase_ele.length > 0) && (responseText.showcase_ele[0].length > 0)) {
                                $('#inviteConnections').children('li').remove();
                                for (var i = 0; i < responseText.showcase_ele.length; i++) {
                                    for (var j = 0; j < responseText.showcase_ele[i].length; j++) {
                                        DisplayShowcase(responseText.showcase_ele[i][j]);
                                    }
                                }
                                Embedly();
                                $('.sc_btn').trigger('click');
                            }
                        },
                        error: function (responseText) {
                            alert(responseText.responseText);
                        }
                    });
                }

                // Display the profile information
                function DisplayProfileDetails(ary) {
                    if ((ary['user_type'] != null) && (ary['user_type'].toLowerCase() == "p")) {
                        $('#profile_name').text("Professor " + ary['lastname']);

                        $('#user_task').text('Teaches at');

                        $('#profOfficeHrs').show();
                        $('#studentGradYear').hide();
                        if (ary['is_owner']) {
                            $('#edit_office_hours_btn').show();
                        }
                        $('#edit_office_loc').show();
                        $('#edit_grad_year').hide();
                        $('#display_office_loc').show();
                        $('#user_designation').show();
                        $('#display_designation').show();
                    }
                    else if ((ary['user_type'] != null) && (ary['user_type'].toLowerCase() == "s")) {
                        $('#profile_name').text(ary['firstname'] + " " + ary['lastname']);
                        $('#user_task').text('Studies at');

                        $('#graduatingOn').css('margin-top', '-25px');
                        $('#graduatingOn').css('margin-left', '90px');
                        $('#graduatingOn').css('float', 'left');
                        $('#graduatingOn').css('position', 'relative');

                        $('#profOfficeHrs').hide();
                        $('#studentGradYear').show();
                        $('#edit_grad_year').show();
                        $('#display_office_loc').hide();
                        $('#user_designation').hide();
                        $('#display_designation').hide();
                    }
                    $('#user_connection').hide();
                    if ((ary['user_bio'] != null) && (ary['user_bio'] != "")) {
                        $('#profile_about').text(ary['user_bio']);
                        $('#user_about').val(ary['user_bio']);
                    }
                    else {
                        $('#profile_about').text("Unavailable");
                    }
                    if ((ary['user_email'] != null) && (ary['user_email'] != "")) {
                        $('#profile_mail_id').text(ary['user_email']);

                        $('#user_email').val(ary['user_email']);
                    }
                    else {
                        $('#profile_mail_id').text("Unavailable");
                    }

                    if ((ary['puniv_name'] != null) && (ary['puniv_name'] != "")) {
                        $('#profile_goes_to').text(ary['puniv_name']);
                        //$('#univ_link').prop('href', "school/school.php?univ_id=" + ary['puniv_id']);
                        $('#user_univ').val(ary['puniv_name']);
                    }
                    else {
                        $('#profile_goes_to').text("Unavailable");
                    }

                    if ((ary['univ_name'] != null) && (ary['univ_name'] != "")) {
                        $('#profile_teaches_at').text(ary['univ_name']);
                        $('#school_link').prop('href', "school.php?univ_id=" + ary['univ_id']);

                        $('#user_school').val(ary['univ_name']);
                    }
                    else {
                        $('#profile_teaches_at').text("Unavailable");
                    }

                    // to link the department page
                    if ((ary['dept_id'] != null) && (ary['dept_id'] != "")) {
                        $('#dept_link').prop('href', "department.php?dept_id=" + ary['dept_id']);
                    }

                    if ((ary['univ_dp'] != null) && (ary['univ_dp'] != "")) {
                        $('#school_icon').css("background-image", "url(" + ary['univ_dp'] + ")");
                    }

                    if ((ary['puniv_dp'] != null) && (ary['puniv_dp'] != "")) {
                        $('#university_icon').css("background-image", "url(" + ary['puniv_dp'] + ")");
                    }
                    if ((ary['dept_dp'] != null) && (ary['dept_dp'] != "")) {
                        $('#dept_icon').css("background", "url(" + ary['dept_dp'] + ") no-repeat 0% 0% / cover transparent");
                    }

                    $('#user_fname').val(ary['firstname']);
                    $('#user_lname').val(ary['lastname']);

                    var path = 'url("' + ary['dp_blob'] + '") no-repeat scroll 50% center / 100% auto #333';
                    $('#profile_picture').css('background', path);
                    $('.user-pic-div-edit').css('background', path);

                    if (ary['is_owner']) {
                        $('.edit-profile-main-wrap').show();
                    }
                    else {
                        $('.edit-profile-main-wrap').hide();
                    }
                }

                // Display the user attribs
                function DisplayAttribsDetails(ary, user_type) {
                    if ((user_type != null) && (user_type == "p")) {
                        if ((ary['office_location'] != null) && (ary['office_location'] != "")) {
                            $('#profile_office_location').text(ary['office_location']);

                            $('#user_loc').val(ary['office_location']);
                        }
                        else {
                            $('#profile_office_location').text("Unavailable");
                        }

                        if ((ary['office_hours'] != null) && (ary['office_hours'] != "")) {
                            $('#profile_office_hours').text(ary['office_hours']);
                            OfficeHours(ary['office_hours']);
                        }
                        else {
                            //OfficeHours(ary['office_hours']); // to be removed after testing
                            $('#profile_office_hours').text("Unavailable");
                        }

                        if ((ary['designation'] != null) && (ary['designation'] != "")) {
                            $('#profile_designation').text(ary['designation']);

                            $('#user_designation').val(ary['designation']);
                        }
                        else {
                            $('#profile_designation').text("Unavailable");
                        }
                    }
                    else if ((user_type != null) && (user_type == "s")) {
                        if ((ary['year'] != null) && (ary['year'] != "")) {
                            $('#graduatingOn').text(ary['year']);

                            $('#stu_grad_year').val(ary['year']);
                        }
                        else {
                            $('#graduatingOn').text("Unavailable");
                        }
                        if ((ary['student_type'] != null) && (ary['student_type'] != "")) {
                            if (ary['student_type'].toLowerCase() == "phd") {
                                $('#student_type').text("Ph.D");
                            }
                            else {
                                $('#student_type').text(ary['student_type']);
                            }

                            $('#stu_type').val(ary['student_type']);
                            $('#' + ary['student_type']).trigger('click');
                        }
                        else {
                            $('#student_type').text("Unavailable");
                        }

                        if ((ary['major'] != null) && (ary['major'] != "")) {
                            $('#student_major').text(ary['major']);
                            $('#stu_major').val(ary['major']);
                        }
                        else {
                            $('#student_major').text("Unavailable");
                        }
                    }
                    if ((ary['website'] != null) && (ary['website'] != "")) {
                        $('#profile_link').text(ary['website']);
                        $('#profile_link').prop('title', ary['website']);
                        if (ary['website'].trim().substr(0, 7).toLowerCase() == "http://") {
                            $('#profile_link').parents('.user-website').prop('href', ary['website']);
                        }
                        else {
                            $('#profile_link').parents('.user-website').prop('href', "http://" + ary['website'].trim());
                        }

                        $('#user_website').val(ary['website']);
                    }
                    else {
                        $('#profile_link').parents('.user-website').hide();
                        $('.user-website').hide();
                    }
                }

                // To fetch the departments within the school
                function FetchDepartments(univ_id, current_dept_id, major) {
                    $('#school_departments').children().remove();
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "php/getdepartment.php",
                        data: {
                            univ_id: univ_id
                        },
                        success: function (responseText) {
                            if ((responseText != null) && (responseText.length > 0)) {
                                var departments = "";
                                $('#profile_dept_name').text("Unavailable");
                                for (var i = 0; i < responseText.length; i++) {
                                    departments += '<div class="status-repeatoptiont-1" id="dept_' + responseText[i].dept_id + '">' + responseText[i].dept_name + '</div>';
                                    if (current_dept_id == responseText[i].dept_id) {
                                        $('#profile_dept_name').text(responseText[i].dept_name);
                                        $('#user_dept').val(responseText[i].dept_id);

                                        if ((major == null) || (major == "")) {
                                            $('#student_major').text(responseText[i].dept_name);

                                            $('#stu_major').val(responseText[i].dept_name);
                                        }
                                    }
                                }
                                $('#school_departments').append(departments);
                                $("#dept_" + current_dept_id).trigger('click');
                            }
                        },
                        error: function (responseText) {
                            alert(responseText.responseText);
                        }
                    });
                }

                // Insert the profile information into the database
                function InsertProfilePicture() {
                    var file_exist_proof = $("#profile_pic_upload").val();
                    if (file_exist_proof != "") {
                        var formData = new FormData($("#profile_pic_upload").closest("form")[0]);
                        formData.append("update_profile", file_exist_proof);

                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: "php/profile/update_profile.php",//img_upload.php",
                            data: formData,
                            xhr: function () {  // Custom XMLHttpRequest
                                var myXhr = $.ajaxSettings.xhr();
                                if (myXhr.upload) { // Check if upload property exists
                                    myXhr.upload.addEventListener('progress', progressHandlingFunction, false); // For handling the progress of the upload
                                }
                                return myXhr;
                            },
                            contentType: false,
                            processData: false,
                            success: function (responseText) {
                                if ((responseText.user_dp != null) && (responseText.user_dp.length > 0)) {
                                    if ((responseText.user_dp[0]['error'] != null) && (responseText.user_dp[0]['error'] != "")) {
                                        alert(responseText.user_dp[0]['error']);
                                    }
                                    else {
                                        if ((responseText.user_dp[0]['img_url'] != null) && (responseText.user_dp[0]['img_url'] != "")) {
                                            var path = 'url("' + responseText.user_dp[0]['img_url'] + '") no-repeat scroll 50% center / 100% auto #333';
                                            $('#profile_picture').css('background', path);
                                            $('.user-pic-div-edit').css('background', path);
                                        }
                                    }
                                }
                            },
                            error: function (responseText) {
                                alert("profile picture update failed ");
                            }
                        });
                    }
                }

                // Update the profile details
                function InsertEditProfileData() {
                    var userFirstName = $('#user_fname').val();
                    var userLastName = $('#user_lname').val();
                    var website = $('#user_website').val();
                    var userID = qs['user_id'];
                    var about = $('#user_about').val();
                    var interests = $('#user_interest').val();
                    var university = $('#user_school').val();
                    var universityId = $('#profile_teaches_at').data('univID');
                    var department = $('#user_dept').text();
                    var departmentId = $('#user_dept').text();
                    var designation = $('#user_designation').val();
                    var email = $('#user_email').val();
                    var officeLocation = $('#user_loc').val();
                    var office_hrs = "";

                    if ($('#profile_office_hours').text().toLowerCase().trim() != "unavailable") {
                        office_hrs = $('#profile_office_hours').text();
                    }
                    $('#profile_office_hours').text();
                    var gradYear = $("#stu_grad_year").val();
                    var major = $("#stu_major").val();
                    var studentType = $("#stu_type").val();

                    console.log("I am called");
                    $.ajax({
                        type: "POST",
                        dataType: "text",
                        url: "php/profile/update_profile.php",
                        data: user_type == "p" ?
                        {
                            firstname: userFirstName,
                            lastname: userLastName,
                            website: website,
                            about: about,
                            interests: interests,
                            designation: designation,
                            update_profile: userID,
                            univ_name: university,
                            univ_id: universityId,
                            dept_name: department,
                            dept_id: departmentId,
                            mail: email,
                            office_loc: officeLocation,
                            office_hrs: office_hrs
                        } :
                        {
                            firstname: userFirstName,
                            lastname: userLastName,
                            website: website,
                            about: about,
                            interests: interests,
                            update_profile: userID,
                            univ_name: university,
                            univ_id: universityId,
                            dept_name: department,
                            dept_id: departmentId,
                            mail: email,
                            office_loc: officeLocation,
                            office_hrs: office_hrs,
                            year: gradYear,
                            major: major,
                            student_type: studentType
                        },
                        success: function (responseText) {
                            console.log(responseText);
                            FetchProfileDetails(userID);
                            //if ((responseText.user_dp != null) && (responseText.user_dp.length > 0)) {
                            //    DisplayProfileDetails(responseText.prof_info[0]);
                            //}
                        },
                        error: function (responseText) {
                            alert("Failed to edit the profile" + responseText);
                        }
                    });
                }

                // Format the office hours and add it to the edit boxes
                function OfficeHours(officeHrs) {
                    if ((officeHrs != null) && (officeHrs != "")) {

                        var everyDayTime = officeHrs.split(',');
                        var row = new Array();
                        for (var i = 0; i < 20; i++) {
                            row[i] = new Array(2);
                        }
                        var k = 0;
                        for (var i = 0; i < everyDayTime.length; i++) {
                            var day = everyDayTime[i].split('(')[0].trim();
                            var time = everyDayTime[i].split('(')[1].split(')')[0].trim();
                            var individualTimes = time.split('&');

                            for (var j = 0; j < individualTimes.length; j++) {
                                var stTime = individualTimes[j].split('-')[0].trim();
                                var endTime = individualTimes[j].split('-')[1].trim();
                                //if (individualTimes[j].trim() != row
                                row[k][1] = individualTimes[j];
                                row[k][0] = day;
                                k++;
                            }
                        }

                        $('.officeHrsContainer').each(function (index) {
                            for (var index = 0; index < row.length; index++) {
                                if ((row[index][0] != null) && (row[index][1] != null)) {
                                    if (row[index][1].trim() != ($(this).find('.startDate').val() + "-" + $(this).find('.endDate').val())) {
                                        if (!($(this).find('.oh_check_mon').prop('checked'))
                                            && !($(this).find('.oh_check_tue').prop('checked'))
                                            && !($(this).find('.oh_check_wed').prop('checked'))
                                            && !($(this).find('.oh_check_thu').prop('checked'))
                                            && !($(this).find('.oh_check_fri').prop('checked'))) {

                                            if (row[index][0].toLowerCase() == "mo") {
                                                $(this).find('.oh_check_mon').prop('checked', true);
                                                $(this).find('.oh_check_mon').next('.oh_checkbox_label').css('background-position', '0px -15px');
                                                $(this).find('.oh_check_mon').next('.oh_checkbox_label').css('color', '#373737');
                                                CheckOfficeHrs("Mon", row[index][1].trim().split('-')[0], row[index][1].trim().split('-')[1]);
                                            }
                                            if (row[index][0].toLowerCase() == "tu") {
                                                $(this).find('.oh_check_tue').prop('checked', true);
                                                $(this).find('.oh_check_tue').next('.oh_checkbox_label').css('background-position', '0px -15px');
                                                $(this).find('.oh_check_tue').next('.oh_checkbox_label').css('color', '#373737');
                                                CheckOfficeHrs("Tue", row[index][1].trim().split('-')[0], row[index][1].trim().split('-')[1]);
                                            }
                                            if (row[index][0].toLowerCase() == "we") {
                                                $(this).find('.oh_check_wed').prop('checked', true);
                                                $(this).find('.oh_check_wed').next('.oh_checkbox_label').css('background-position', '0px -15px');
                                                $(this).find('.oh_check_wed').next('.oh_checkbox_label').css('color', '#373737');
                                                CheckOfficeHrs("Wed", row[index][1].trim().split('-')[0], row[index][1].trim().split('-')[1]);
                                            }
                                            if (row[index][0].toLowerCase() == "th") {
                                                $(this).find('.oh_check_thu').prop('checked', true);
                                                $(this).find('.oh_check_thu').next('.oh_checkbox_label').css('background-position', '0px -15px');
                                                $(this).find('.oh_check_thu').next('.oh_checkbox_label').css('color', '#373737');
                                                CheckOfficeHrs("Thu", row[index][1].trim().split('-')[0], row[index][1].trim().split('-')[1]);
                                            }
                                            if (row[index][0].toLowerCase() == "fr") {
                                                $(this).find('.oh_check_fri').prop('checked', true);
                                                $(this).find('.oh_check_fri').next('.oh_checkbox_label').css('background-position', '0px -15px');
                                                $(this).find('.oh_check_fri').next('.oh_checkbox_label').css('color', '#373737');
                                                CheckOfficeHrs("Fri", row[index][1].trim().split('-')[0], row[index][1].trim().split('-')[1]);
                                            }

                                            $(this).find('.startDate').val(row[index][1].trim().split('-')[0]);
                                            $(this).find('.endDate').val(row[index][1].trim().split('-')[1]);
                                            row[index][0] = null;
                                            row[index][1] = null;
                                            ($(this).find('.addOfficeHrs')).trigger("click");
                                        }
                                    }
                                    else {
                                        if (row[index][0].toLowerCase() == "mo") {
                                            $(this).find('.oh_check_mon').prop('checked', true);
                                            $(this).find('.oh_check_mon').next('.oh_checkbox_label').css('background-position', '0px -15px');
                                            $(this).find('.oh_check_mon').next('.oh_checkbox_label').css('color', '#373737');
                                            CheckOfficeHrs("Mon", row[index][1].trim().split('-')[0], row[index][1].trim().split('-')[1]);
                                        }
                                        if (row[index][0].toLowerCase() == "tu") {
                                            $(this).find('.oh_check_tue').prop('checked', true);
                                            $(this).find('.oh_check_tue').next('.oh_checkbox_label').css('background-position', '0px -15px');
                                            $(this).find('.oh_check_tue').next('.oh_checkbox_label').css('color', '#373737');
                                            CheckOfficeHrs("Tue", row[index][1].trim().split('-')[0], row[index][1].trim().split('-')[1]);
                                        }
                                        if (row[index][0].toLowerCase() == "we") {
                                            $(this).find('.oh_check_wed').prop('checked', true);
                                            $(this).find('.oh_check_wed').next('.oh_checkbox_label').css('background-position', '0px -15px');
                                            $(this).find('.oh_check_wed').next('.oh_checkbox_label').css('color', '#373737');
                                            CheckOfficeHrs("Wed", row[index][1].trim().split('-')[0], row[index][1].trim().split('-')[1]);
                                        }
                                        if (row[index][0].toLowerCase() == "th") {
                                            $(this).find('.oh_check_thu').prop('checked', true);
                                            $(this).find('.oh_check_thu').next('.oh_checkbox_label').css('background-position', '0px -15px');
                                            $(this).find('.oh_check_thu').next('.oh_checkbox_label').css('color', '#373737');
                                            CheckOfficeHrs("Thu", row[index][1].trim().split('-')[0], row[index][1].trim().split('-')[1]);
                                        }
                                        if (row[index][0].toLowerCase() == "fr") {
                                            $(this).find('.oh_check_fri').prop('checked', true);
                                            $(this).find('.oh_check_fri').next('.oh_checkbox_label').css('background-position', '0px -15px');
                                            $(this).find('.oh_check_fri').next('.oh_checkbox_label').css('color', '#373737');
                                            CheckOfficeHrs("Fri", row[index][1].trim().split('-')[0], row[index][1].trim().split('-')[1]);
                                        }

                                        row[index][0] = null;
                                        row[index][1] = null;
                                        ($(this).find('.addOfficeHrs')).trigger("click");
                                    }
                                }
                            }
                        });
                    }
                }

                // insert the office hours into the database
                function UpdateOfficeHours() {
                    var officeHrs = "";
                    var mon = "";
                    var tue = "";
                    var wed = "";
                    var thu = "";
                    var fri = "";
                    $('.officeHrsContainer').each(function (index) {
                        if ($(this).find('.oh_check_mon').prop('checked')) {
                            mon += "&" + $(this).find('.startDate').val() + "-" + $(this).find('.endDate').val();
                        }
                        if ($(this).find('.oh_check_tue').prop('checked')) {
                            tue += "&" + $(this).find('.startDate').val() + "-" + $(this).find('.endDate').val();
                        }
                        if ($(this).find('.oh_check_wed').prop('checked')) {
                            wed += "&" + $(this).find('.startDate').val() + "-" + $(this).find('.endDate').val();
                        }
                        if ($(this).find('.oh_check_thu').prop('checked')) {
                            thu += "&" + $(this).find('.startDate').val() + "-" + $(this).find('.endDate').val();
                        }
                        if ($(this).find('.oh_check_fri').prop('checked')) {
                            fri += "&" + $(this).find('.startDate').val() + "-" + $(this).find('.endDate').val();
                        }
                    });

                    if (mon != "") {
                        mon = ", Mo (" + mon.substr(1, mon.length) + ")";
                        officeHrs += mon;
                    }
                    if (tue != "") {
                        tue = ", Tu (" + tue.substr(1, tue.length) + ")";
                        officeHrs += tue;
                    }
                    if (wed != "") {
                        wed = ", We (" + wed.substr(1, wed.length) + ")";
                        officeHrs += wed;
                    }
                    if (thu != "") {
                        thu = ", Th (" + thu.substr(1, thu.length) + ")";
                        officeHrs += thu;
                    }
                    if (fri != "") {
                        fri = ", Fr (" + fri.substr(1, fri.length) + ")";
                        officeHrs += fri;
                    }

                    officeHrs = officeHrs.substr(1, officeHrs.length).trim();

                    $.ajax({
                        type: "POST",
                        dataType: "text",
                        url: "php/profile/update_profile.php",
                        data: {office_hrs: officeHrs, update_profile: qs['user_id']},
                        success: function (responseText) {
                            $('.office-hours').find('b').text(officeHrs);
                            OfficeHours(officeHrs);
                        },
                        error: function (responseText) {
                            alert("office hours update failed ");
                        }
                    });
                }

                // File upload
                function progressHandlingFunction(e) {
                    if (e.lengthComputable) {
                        $('progress').attr({value: e.loaded, max: e.total});
                    }
                }

                // Fetch both followers and following list
                function FetchConnections() {
                    var userId = qs['user_id'];

                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "php/profile/user_connections.php",
                        data: {user_info: userId},
                        success: function (responseText) {
                            var followersList = "";
                            var followingList = "";

                            if (responseText.following.length > 0) {
                                followingList = DisplayConnections(responseText.following, responseText.fromuser_id);
                                $('#followingCount').text(responseText.following.length);
                            }

                            if (responseText.followers.length > 0) {
                                followersList = DisplayConnections(responseText.followers, responseText.fromuser_id);
                                $('#followersCount').text(responseText.followers.length);
                            }

                            if (responseText.following.length === 0) {

                                $('#followingCount').parent().css({
                                    "position": "relative",
                                    "top": "10"
                                });
                            }

                            if (responseText.followers.length === 0) {

                                $('#followersCount').parent().css({
                                    "position": "relative",
                                    "top": "10"
                                });
                            }


                            // To display the button to follow or unfollow based on the connection and owner type
                            if (!is_owner) {
                                if (responseText.isfollowing) {
                                    $('#user_connection').append('<a class = "follow1 unfollow1" id="' + responseText.touser_id + '_' + responseText.fromuser_id + '">'
                                    + 'Following'
                                    + '</a>');
                                    $('#user_connection').addClass('user_connection_unfollow');
                                }
                                else {
                                    $('#user_connection').append('<a class = "follow1" id="' + responseText.touser_id + '_' + responseText.fromuser_id + '">'
                                    + 'Follow'
                                    + '</a>');
                                    $('#user_connection').addClass('user_connection_follow');
                                }
                                $('#user_connection').show();
                            }
                            else {
                                $('#user_connection').hide();
                            }

                            $('.user-tab-following-content').append(followingList);
                            $('.user-tab-followers-content').append(followersList);
                        },
                        error: function (responseText) {
                            alert("followersfetch failed");
                        }
                    });
                }

                // Fisplay the connections both followers and following
                function DisplayConnections(ary, fromuser_id) {
                    var connectionsList = "";
                    for (var i = 0; i < ary.length; i++) {
                        var user_id = ary[i]['user_id'];
                        var fromUser = qs['user_id'];
                        connectionsList += '<div class = "member">'
                        + '<div class = "member-person prof-member-person">'
                        + '<div class = "member-wrap prof-member-wrap">'
                        + '<div class = "person-thumb">'
                        + '<div class = "picwrap" style = "background:url(' + ary[i]['dp_link'] + ') no-repeat scroll 50% center / 100% auto transparent;"></div>'
                        + '<div class = "member-bio userlink"  id="memberbio_' + user_id + '">'
                        + '<span>' + ary[i]['interests'] + '</span>'
                        + '<strong class="userlink" id="viewProfile_' + user_id + '">View Profile</strong>'
                        + '</div>'
                        + '</div>'
                        + '<h3 class = "person-title">'
                        + '<strong class="userlink" id="userlink_' + user_id + '">' + ary[i]['firstname'] + " " + ary[i]['lastname'] + '</strong>'
                        + '<span>'
                        + '<a>' + ary[i]['univ_name'] + '</a>'
                        + '</span>'
                        + '</h3>';
                        //if (is_owner) {
                        if (fromuser_id == user_id) {
                            //same user as viewer
                        } else {
                            connectionsList += '<div class = "follow-btn" >';
                            if (ary[i]['is_following']) {
                                connectionsList += '<a class = "follow unfollow" id="' + user_id + '_' + fromUser + '">'
                                + 'Following'
                                + '</a>';
                            }
                            else {
                                connectionsList += '<a class = "follow" id="' + user_id + '_' + fromUser + '">'
                                + 'Follow'
                                + '</a>';
                            }
                            connectionsList += '</div>';
                        }
                        //}
                        connectionsList += '</div>'
                        + '</div>'
                        + '</div>';
                    }
                    return connectionsList;
                }

                // Function to display the selected user
                $(document).delegate('.userlink', 'click', function () {
                    window.location = window.location.toString().split('?')[0].trim() + "?user_id=" + $(this).prop('id').split('_')[1].trim();
                });

                // To change the follow button text based on follow or unfollow
                $(document).delegate(".follow", "click", function () {
                    var targetID = $(this).prop('id').split('_')[0].trim();

                    if (targetID.trim().toLowerCase() != "user") {
                        if ($(this).hasClass('unfollow')) {
                            $(this).removeClass('unfollow');
                            $(this).prop('text', 'Follow');
                        }
                        else {
                            $(this).addClass('unfollow');
                            $(this).prop('text', 'Following');
                        }

                        // Ajax call to follow and unfollow a person
                        FollowUnfollow(targetID);
                    }
                });

                $(document).delegate(".follow", "mouseover", function () {
                    if ($(this).hasClass('unfollow')) {
                        $(this).prop('text', 'Unfollow');
                    }
                });
                $(document).delegate(".follow", "mouseout", function () {
                    if ($(this).hasClass('unfollow')) {
                        $(this).prop('text', 'Following');
                    }
                });

                $(document).delegate("#user_connection", "mouseover", function () {
                    if ($(this).hasClass('user_connection_unfollow')) {
                        $(this).children('a').prop('text', 'Unfollow');
                    }
                });
                $(document).delegate("#user_connection", "mouseout", function () {
                    if ($(this).hasClass('user_connection_unfollow')) {
                        $(this).children('a').prop('text', 'Following');
                    }
                });

                $(document).delegate('#user_connection', 'click', function () {
                    if ($(this).hasClass('user_connection_unfollow')) {
                        // $(this).children('.follow').removeClass('user_connection_unfollow');
                        $(this).removeClass('user_connection_unfollow');
                        $(this).children('a').prop('text', 'Follow');
                    }
                    else {
                        //$(this).children('.follow').addClass('unfollow');
                        $(this).addClass('user_connection_unfollow');
                        $(this).children('a').prop('text', 'Following');
                    }
                    var targetID = $(this).children('a').prop('id').split('_')[0].trim();

                    // Ajax call to follow and unfollow a person
                    FollowUnfollow(targetID);
                });

               /* function FollowUnfollow(targetID) {
                    // Ajax call to follow and unfollow a person
                    $.ajax({
                        type: "POST",
                        dataType: "text",
                        url: "includes/followunfollow.php",
                        data: {follow_user: targetID},
                        success: function (responseText) {

                        },
                        error: function (responseText) {
                            alert(responseText);
                        }
                    });
                }*/

                // Fetch the courses the current user is part of
                function FetchCourses(type) {
                    var userId = qs['user_id'];

                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "php/profile/user_courses.php",
                        data: {user_id: userId, user_type: type},
                        success: function (responseText) {
                            var courseList = "";

                            if (responseText.prof_courses.length > 0) {
                                courseList = DisplayCourses(responseText.prof_courses);
                            }


                            $('.user-tab-groups-content').append(courseList);


                            if (!(responseText.prof_courses)) {
                                $('#courseCount').parent().css({
                                    "position": "relative",
                                    "top": "10"
                                });
                            }

                            $('#courseCount').text(responseText.prof_courses.length);

                            bindControlsToFunctions();
                        },
                        error: function (responseText) {
                            alert("course fetch failed");
                        }
                    });
                }

                function bindControlsToFunctions() {

                    /*$(".user-class-visibility .container .current .drop").click(function(e){
                     $(e.target).parent().parent().trigger("click");
                     });*/
                    $(".user-class-visibility .container .current").on("mouseover",function(){
                        $(this).addClass("mouseover");
                    }); // When the user hovers on the privacy button the dropdown should be visible

                    $(".user-class-visibility .container .current").on("mouseout",function(e){
                        if ( !$(e.target).parent().find(".options").is(":visible")){
                            $(this).removeClass("mouseover");
                        }
                    });// when the user mouse outs from the privacy button all other elements except the privacy label ( like public ) should be seen

                    $(".user-class-visibility .container").click(function(e) {
                        var container = $(e.target);
                        while(!container.is(".user-class-visibility .container")){
                            container = container.parent();
                        }
                        var addClass = true;
                        if(container.hasClass("active")){
                            addClass = false;
                        }
                        $(".user-class-visibility .container").removeClass("active");
                        if(addClass){
                            container.addClass("active");
                            $(".user-class-visibility .container .current").removeClass("mouseover");
                            container.find(".current").addClass("mouseover");
                        }
                    });

                    $(".user-class-visibility .option").click(function(e) {
                        e.stopPropagation();
                        e.preventDefault();
                        var container = $(this).closest(".container");
                        $(".current", container)[0].firstChild.data = $(this)[0].firstChild.data;
                        $(".option", container).removeClass("selected");
                        $(this).addClass("selected");
                        container.removeClass("active");
                        $(".user-class-visibility .container .current").removeClass("mouseover");
                        var isItem  = $(this).closest(".user-groups-courses").length;

                        if(isItem === 0) {
                            console.log("Global");
                            /* Handle Global visibility AJAX here */
                        } else {
                            /* Handle Individual item visibility AJAX here */
                            console.log("Individual");
                        }

                        return false;
                    });

                    $(document).click(function(e) {
                        var container = $(".user-class-visibility .container")
                        if((!container.is(e.target) && container.has(e.target).length === 0)){
                            container.removeClass("active");
                            container.find(".current").removeClass("mouseover");
                        }
                        /*if(!(container.is(e.target) || container.has(e.target).length != 0 || container.hasClass("active"))) {
                         $(".user-class-visibility .container .current").removeClass("mouseover");
                         container.removeClass("active");
                         } */
                    })
                }

                function DisplayVisiButtons(club) {
                    return '<div class="user-class-visibility ' + club + '">' +
                    '<div class="container">' +
                    '<div class="current">' +
                    'Public' +
                    '<div class="drop"></div>' +
                    '<div class="hover"></div>' +
                    '</div>' +
                    '<div class="options">' +
                    '<div class="option">Public<div class="tick"></div></div>' +
                    '<div class="option">People I Follow<div class="tick"></div></div>' +
                    '<div class="option">Just Me<div class="tick"></div></div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
                }

                // Display the courses for the current user
                function DisplayCourses(ary) {
                    var courseList = "";
                    for (var i = 0; i < ary.length; i++) {
                        courseList += '<div class = "user-groups-courses">'
                        + '<div class = "professor-group course-group">'
                        + '<a class = "group-link">'
                        + '<div class = "group-pic classlink" id="groupPic_' + ary[i]['class_id']
                        + '" style="background: url(' + ary[i]['c_dp'] + ') no-repeat scroll center center / cover transparent">'
                        + '</div>';
                        if (ary[i]['c_name'] != null && ary[i]['c_name'] != "") {
                            courseList += '<h3 class="classlink" id="groupName_' + ary[i]['class_id'] + '">' + ary[i]['c_name'] + '</h3>';
                        }
                        else {
                            courseList += '<h3>Unavailable</h3>';
                        }
                        // courseList += '<div class="user-course-lock"><div class="hover"></div></div>';
                        if (is_owner) {
                            courseList += DisplayVisiButtons();
                        }
                        courseList += '</a>'
                        + '<div class = "admin-group-functions">'
                        + '<div class="gfunction"><span>' + ary[i]['c_id'] + ' (' + ary[i]['sec_id'] + ')</span></div>'
                        + '<div class="gfunction"><span>';
                        if ((ary[i]['timing'] != null) && (ary[i]['timing'] != "") && (ary[i]['timing'] != "null")) {
                            courseList += ary[i]['timing'];
                        }
                        else {
                            courseList += "Time: Unavailable";
                        }
                        courseList += '</span></div>'
                        + '<div class="gfunction"><span>' + ary[i]['count'] + ' students</span></div>'
                        + '</div>'
                        + '</div><br/>'
                        + '</div>';
                    }
                    return courseList;
                }

                // Function to display the selected class
                $(document).delegate('.classlink', 'click', function () {
                    window.location = "../class/" + $(this).prop('id').trim();
                });
                // Function to display the school page
               /* $(document).delegate('input[schoo', 'click', function () {
                    window.location = "../class/" + $(this).prop('id').trim();
                });*/

                // Fetch the clubs for the current user
                function FetchClubs() {
                    var userId = qs['user_id'];

                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "php/profile/user_clubs.php",
                        data: {user_id: userId},
                        success: function (responseText) {
                            var clubList = "";

                            if ((responseText.user_clubs != null) && (responseText.user_clubs.length > 0)) {
                                clubList = DisplayClubs(responseText.user_clubs);
                            }

                            $('.user-tab-clubs-content').append(clubList);

                            if (!(responseText.user_clubs)) {
                                $('#clubsCount').parent().css({
                                    "position": "relative",
                                    "top": "10"
                                });
                            }
                            $('#clubsCount').text(responseText.user_clubs.length);

                            bindControlsToFunctions();
                        },
                        error: function (responseText) {
                            alert("club fetch failed");
                        }
                    });
                }

                // Display the clubs the current user is part of
                function DisplayClubs(ary) {
                    var clubsList = "";
                    for (var i = 0; i < ary.length; i++) {
                        clubsList += '<div class = "user-groups-courses">'
                        + '<div class = "professor-group course-group">'
                        + '<a class = "group-link">'
                        + '<div class = "group-pic group-link" id="grpPic_' + ary[i]['group_id']
                        + '" style="background: url(' + ary[i]['cl_dp'] + ') no-repeat scroll center center / cover transparent">'
                        + '</div>'
                        + '<h3 class="group-link" id="grpName_' + ary[i]['group_id'] + '">' + ary[i]['group_name'] + '</h3>';
                        clubsList += DisplayVisiButtons("club") + '</a> '
                        + '<div class = "admin-group-functions">';
                        if (ary[i]['group_desc'].length > 220) {
                            clubsList += '<div class="gfunction"><span>' + ary[i]['group_desc'].substr(0, 220) + '...' + '</span></div>';
                        }
                        else {
                            clubsList += '<div class="gfunction"><span>' + ary[i]['group_desc'] + '</span></div>';
                        }
                        clubsList += '<div class="gfunction"><span>' + ary[i]['user_count'] + ' members</span></div>'
                        + '</div>'
                        + '</div><br/>'
                        + '</div>';
                    }
                    return clubsList;
                }

                // Function to display the selected class
                $(document).delegate('.clublink', 'click', function () {
                    window.location = "../club/" + $(this).prop('id').trim();
                });


                // To add more rows to edit the office hours
                $(document).delegate('.addOfficeHrs', 'click', function () {
                    $(this).hide();
                    $(this).parents('.officeHrsContainer').next('.officeHrsContainer').show();
                });

                // To display green signal if the current time falls within the office hours
                function CheckOfficeHrs(day, start, end) {
                    if ((new Date()).toUTCString().split(',')[0].toLowerCase() == day.toLowerCase()) {
                        var date = new Date();
                        date = new Date(date.getFullYear(), date.getMonth(), date.getDate(), date.getHours(), date.getMinutes(), 0, 0);
                        var startHr = Number(start.split(':')[0].trim());
                        var startMin = Number(start.split(':')[1].trim().split(' ')[0]);
                        var endHr = Number(end.split(':')[0].trim());
                        var endMin = Number(end.split(':')[1].trim().split(' ')[0]);

                        if (start.split(' ')[1].toLowerCase() == "pm") {
                            startHr = Number(start.split(':')[0].trim()) + 12;
                        }
                        if (end.split(' ')[1].toLowerCase() == "pm") {
                            endHr = Number(end.split(':')[0].trim()) + 12;
                        }
                        var startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate(), startHr, startMin, 0, 0);
                        var endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate(), endHr, endMin, 0, 0);

                        if ((date >= startDate) && (date <= endDate)) {
                            $('.in-office').show();
                        }
                    }
                }

                /* Code for the showcase scroll setup */

                $(document).delegate('.hor-scroller-right', "click", function () {

                    var $cardref = $(this).closest(".add-event-dd-box-invite").find(".dd-box-invite-scrollwrap");
                    var leftPos = $cardref.scrollLeft();
                    $cardref.stop().animate({scrollLeft: leftPos + 200}, 400);
                });

                $(document).delegate('.hor-scroller-left', "click", function () {

                    var $cardref = $(this).closest(".add-event-dd-box-invite").find(".dd-box-invite-scrollwrap");
                    var leftPos = $cardref.scrollLeft();
                    $cardref.stop().animate({scrollLeft: leftPos - 200}, 400);
                });

                $(document).delegate('.hor-scroller-right', "mouseover", function () {
                    var $cardref = $(this).closest(".add-event-dd-box-invite").find(".dd-box-invite-scrollwrap");
                    var leftPos = $cardref.scrollLeft();
                    $cardref.stop().animate({scrollLeft: leftPos + 15}, 400);
                    $(this).stop().show();
                });

                $(document).delegate('.hor-scroller-right', "mouseout", function () {
                    if (rightable == 1) {
                        var $cardref = $(this).closest(".add-event-dd-box-invite").find(".dd-box-invite-scrollwrap");
                        var leftPos = $cardref.scrollLeft();
                        $cardref.stop().animate({scrollLeft: leftPos - 15}, 400, function () {
                            $(this).find('.hor-scroller-right').hide();
                        });
                    }
                });

                $(document).delegate('.hor-scroller-left', "mouseover", function () {
                    var $cardref = $(this).closest(".add-event-dd-box-invite").find(".dd-box-invite-scrollwrap");
                    var leftPos = $cardref.scrollLeft();
                    $cardref.stop().animate({scrollLeft: leftPos - 15}, 400);
                    $(this).stop().show();
                });

                $(document).delegate('.hor-scroller-left', "mouseout", function () {
                    if (leftable == 1) {
                        var $cardref = $(this).closest(".add-event-dd-box-invite").find(".dd-box-invite-scrollwrap");
                        var leftPos = $cardref.scrollLeft();
                        $cardref.stop().animate({scrollLeft: leftPos + 15}, 400, function () {
                            $(this).find('.hor-scroller-left').hide();
                        });
                    }
                });

                var able_offset = 45;
                var leftable = 0;
                var rightable = 0;
                $('.dd-box-invite-scrollwrap').bind('scroll', function () {
                    var $ref = $(this).closest(".add-event-dd-box-invite");
                    //get scroll width

                    var scrollw = ($(this)[0].scrollWidth);

                    if ($(this).scrollLeft() <= 0) {
                        leftable = 0;
                        $ref.find(".hor-scroller-left").stop().hide();
                    }

                    if ($(this).scrollLeft() >= able_offset) {
                        if (leftable == 0) {
                            $ref.find(".hor-scroller-left").stop().show();
                            leftable = 1;
                        }
                    }

                    if ($(this).scrollLeft() + $(this).innerWidth() >= (scrollw - 40)) {
                        $ref.find(".hor-scroller-right").stop().hide();
                        rightable = 0;
                    }

                    if ($(this).scrollLeft() + $(this).innerWidth() <= (scrollw - 40)) {
                        if (rightable == 0) {
                            $ref.find(".hor-scroller-right").stop().show();
                            rightable = 1;
                        }
                    }
                });

                $(document).delegate('.dd-box-invite-scrollwrap', "mouseover", function () {
                    var $ref = $(this).closest(".add-event-dd-box-invite");
                    var scrollw = ($(this)[0].scrollWidth);

                    if ($(this).scrollLeft() + $(this).innerWidth() >= (scrollw - 40)) {

                    } else {

                        $ref.find(".hor-scroller-right").stop().show();
                        rightable = 1;
                    }

                    if ($(this).scrollLeft() >= able_offset) {
                        $ref.find(".hor-scroller-left").stop().show();
                        leftable = 1;
                    }
                });

                $(document).delegate('.add-event-dd-box-invite', "mouseleave", function () {
                    var $ref = $(this).closest(".add-event-dd-box-invite");
                    $ref.find(".hor-scroller-right").stop().hide();
                    $ref.find(".hor-scroller-left").stop().hide();
                });

                /* End of code for the showcase scroll setup */


                // Display the showcase for the current user
                function DisplayShowcase(ary) {
                    // file_share_type - gdrive or link or regular
                    // f_type - format
                    // f_url - url of the link or file to download
                    // f_name
                    // file_desc - description of the file
                    var showcaseContent = '<li class="ddbox-invite-option ddbox-option-invited" id="invitedetails_' + ary['file_id'] + '_' + ary['file_share_type'] + '">';
                    if (ary['file_share_type'].toLowerCase() == "link") {
                        showcaseContent += '<div class="content">'
                        + '<a href="' + ary['f_url'] + '" style="z-index:9999" targe="_blank">' + ary['file_desc'] + '</a>'
                        + '</div>';
                    }
                    else {
                        var url = "src/file_type_zip.png";
                        if (ary['f_type'].toLowerCase().trim() == "pdf") {
                            url = "src/file_type_pdf.png";
                        }
                        else if ((ary['f_type'].toLowerCase().trim() == "ppt") || (ary['f_type'].toLowerCase().trim() == "pptx")) {
                            url = "src/file_type_ppt.png";
                        }
                        else if ((ary['f_type'].toLowerCase().trim() == "doc") || (ary['f_type'].toLowerCase().trim() == "docx")) {
                            url = "src/file_type_doc.png";
                        }
                        else if ((ary['f_type'].toLowerCase().trim() == "xls") || (ary['f_type'].toLowerCase().trim() == "xlsx")) {
                            url = "src/file_type_xls.png";
                        }
                        showcaseContent += '<div class="content1">'
                        + '<div style="width:150px; height:122px;background: url('
                        + url + ') no-repeat scroll 50% 50% / auto 100% transparent;"></div>'
                        + '</div>';
                    }

                    showcaseContent += '<div class="invite-option-title-wrap" style="display:none;"  title="' + ary['f_url'] + '"> <p style="float: left;">' + ary['file_desc'] + '</p>';
                    if (is_owner) {
                        showcaseContent += '<img class="delete-showcase" title="delete showcase" src="img/hide.png"></img>';
                    }
                    showcaseContent += '</div></li>';

                    $('#inviteConnections').append(showcaseContent);
                }

                // Function to display the title on mouseover
                $(document).delegate('.ddbox-invite-option', 'mouseover', function () {
                    $(this).find('.invite-option-title-wrap').show();
                });

                $(document).delegate('.ddbox-invite-option', 'mouseout', function () {
                    $(this).find('.invite-option-title-wrap').hide();
                });

                $(document).delegate('.ddbox-invite-option', 'click', function () {
                    window.open($(this).find('.invite-option-title-wrap').prop('title'));
                });



                /* Embedly for showcase code ends here */

                /* Code for interests */

                // To insert a new interest if nothing was selected or no interset was found
                $(document).delegate('#user_interest', 'keydown', function (e) {
                    var code = (e.keyCode ? e.keyCode : e.which);
                    var interest = $('#user_interest').val().trim();
                    var userId = qs['user_id'];
                    var new_interest = false;
                    $(".tag-option").hide();

                    if (interest.length >= 2) {
                        var interestList = "";
                        var relatedSearchCount = 0; // To identify if there are any related searches and select the top search result and send it instead of creating a new record
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: "php/profile/user_interests.php",
                            data: {user_id: userId, interest_autosuggest: 1, query: interest},
                            success: function (responseText) {
                                if ((responseText.interests != null) && (responseText.interests.length > 0)) {
                                    relatedSearchCount++;
                                    for (var i = 0; i < responseText.interests.length; i++) {
                                        var interest_id = "'" + responseText.interests[i]['interest_id'] + "'";
                                        var interests = "'" + responseText.interests[i]['interest'] + "'";
                                        interestList += '<div id="interest_' + responseText.interests[i]['interest_id'] + '" class="interest-list" '
                                        + ' style="cursor:pointer;text-align: left; padding: 7px;">'
                                        + responseText.interests[i]['interest']
                                        + '</div>';
                                    }
                                    $(".tag-option").html(interestList);
                                    $(".tag-option").show();

                                    if ((code == 13) && (interest != "")) {
                                        // if enter is pressed half way through the auto suggest insert the 1st record
                                        if (!document.getElementById('myinterest_' + responseText.interests[0]['interest_id'])) {
                                            AddInterest(userId, responseText.interests[0]['interest_id']);
                                        }
                                        $('#user_interest').val("");
                                        $('.tag-option').hide();
                                    }
                                }
                                else if ((code == 13) && (interest != "")) {
                                    // if enter is pressed to enter and when there are no suggestions insert interests and user interests
                                    InsertInterests(interest, userId, new_interest);
                                    $('#user_interest').val("");
                                }
                            },
                            error: function (responseText) {
                                alert("add interest insert failed");
                            }
                        });
                    }
                    else {
                        $(".tag-option").hide();
                    }
                });

                $(document).on("click", function (e) {

                    var elem = $(e.target);
                    // To hide the interests options when clicked outside
                    if (!elem.hasClass("tag-option") || elem.parents().hasClass("tag-option")) {
                        $('.tag-option').hide();
                        $('#user_interest').val("");
                    }

                    if (elem.hasClass("status-repeatoptiont-1") || elem.hasClass("status-click-out") || elem.hasClass("status-event-repeat")
                        || elem.hasClass("status-dd-title") || elem.hasClass("down-arrow")) {
                        $(this).parents('.user-info-editable').children('#school_departments').show();
                        $(this).parents('.website-inp-wrap').children('#student_level').show();
                    }
                    else {
                        $('#school_departments').hide();
                        $('#student_level').hide();
                    }
                });
                var dropdownoption = -1;

                $("div.website-inp-wrap input").on("keyup", function (e) {
                    e = e || event;
                    var input = $(this);
                    var dropdown = input.siblings(".dropdown");
                    var list = $("li", dropdown);
                    if (e.keyCode == 40 || e.keyCode == 38) {
                        list.removeClass("active");

                        if (e.keyCode == 40 && ++dropdownoption == list.length) dropdownoption = 0;
                        else if (e.keyCode == 38 && --dropdownoption == -1) dropdownoption = list.length - 1;

                        $(list[dropdownoption]).addClass("active");
                        input.val($(list[dropdownoption]).html());
                        dropdown.scrollTop(0);
                        dropdown.scrollTop($(list[dropdownoption]).position().top);
                    } else if (e.keyCode == 13) {
                        input.trigger("blur");
                    }
                    else {
                        changeOptionInDropDown(input);
                    }
                }).on("focus", function () {
                    changeOptionInDropDown($(this))
                }).on("blur", function () {
                    var dropdown = $(this).siblings(".dropdown");
                    $(this).val($("li:hover", dropdown).html() || $("li.active", dropdown).html() || "");
                });

                function changeOptionInDropDown(input) {
                    var dropdown = input.siblings(".dropdown");
                    var list = $("li", dropdown);
                    list.removeClass("active").each(function (i, e) {
                        if (new RegExp('^' + input.val(), 'i').test($(e).html())) {
                            $(e).addClass("active");
                            dropdownoption = i;
                            dropdown.scrollTop(0);
                            dropdown.scrollTop($(list[dropdownoption]).position().top);
                            return false;
                        }
                    })
                }

                $(document).delegate('.interest-list', 'click', function () {
                    var interest_id = $(this).prop('id').split('_')[1].trim();

                    $("#user_interest").val("");
                    $("#user_interest").focus();
                    $(".tag-option").hide();
                    if (!document.getElementById('myinterest_' + interest_id)) {
                        AddInterest(qs['user_id'], interest_id);
                    }
                });

                function AddInterest(userId, interest_id) {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "php/profile/user_interests.php",
                        data: {user_id: userId, insert: true, interest_id: interest_id},
                        success: function (responseText) {
                            $("#user_interest").val("");
                            if ((responseText.interestsList != null) && (responseText.interestsList.length > 0)) {
                                DisplayEventsListToEdit(responseText.interestsList);
                            }
                            else {
                                if (!is_owner) {
                                    $('#profile_interests').hide();
                                    $('#profile_interests').prev('h5').css('display', 'none');
                                }
                            }
                        },
                        error: function (responseText) {
                            alert("interest insert failed");
                        }
                    });
                }

                function InsertInterests(interest, userId, new_interest) {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "php/profile/user_interests.php",
                        data: {user_id: userId, new_interest: true, interest: interest},
                        success: function (responseText) {
                            if ((responseText.interestsList != null) && (responseText.interestsList.length > 0)) {
                                DisplayEventsListToEdit(responseText.interestsList);
                            }
                            else {
                                if (!is_owner) {
                                    $('#profile_interests').hide();
                                    $('#profile_interests').prev('h5').css('display', 'none');
                                }
                            }
                        },
                        error: function (responseText) {
                            alert("interest insert failed");
                        }
                    });
                }

                function FetchInterests() {
                    var userId = qs['user_id'];
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "php/profile/user_interests.php",
                        data: {user_id: userId, fetch: true},
                        success: function (responseText) {
                            if ((responseText.interestsList != null) && (responseText.interestsList.length > 0)) {
                                DisplayEventsListToEdit(responseText.interestsList);
                            }
                            else {
                                if (!is_owner) {
                                    $('#profile_interests').hide();
                                    $('#profile_interests').prev('h5').css('display', 'none');
                                }
                            }
                        },
                        error: function (responseText) {
                            alert("interest insert failed");
                        }
                    });
                }

                function DisplayEventsListToEdit(ary) {
                    $('#profile_interests').text("");
                    $('#my_interests').children('.selected-interests').remove();
                    var interestsList = "";
                    var interestsCSV = "";
                    for (var i = 0; i < ary.length; i++) {
                        interestsList += '<div class="selected-interests" id="myinterest_' + ary[i]['interest_id'] + '" style="float: left;">'
                        + '<span class="myinterests-text">' + ary[i]['interest'] + '</span>'
                        + '<img class="myinterests-delete" title="delete interest" src="img/hide.png"></img>'
                        + '</div>';
                        interestsCSV += "<p class='single_interest'>" + ary[i]['interest'] + '</p>';

                    }
                    $('#my_interests').append(interestsList);

                    if (interestsCSV == "") {
                        if (!is_owner) {
                            $('#profile_interests').hide();
                            $('#profile_interests').prev('h5').css('display', 'none');
                        }
                    }
                    else {
                        $('#profile_interests').show();
                        $('#profile_interests').prev('h5 .secondh5').show();
                    }

                    if (interestsCSV == "") {
                        interestsCSV = ",Unavailable";
                    }
                    $('#profile_interests').append(interestsCSV.substr(0, interestsCSV.length));
                }

                // To delete the interest
                $(document).delegate('.myinterests-delete', 'click', function () {
                    var userId = qs['user_id'];
                    var interest_id = $(this).parent('.selected-interests').prop('id').split('_')[1].trim();
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "php/profile/user_interests.php",
                        data: {user_id: userId, delete_interest: true, interest_id: interest_id},
                        success: function (responseText) {
                            if ((responseText.interestsList != null) && (responseText.interestsList.length > 0)) {
                                DisplayEventsListToEdit(responseText.interestsList);
                            }
                            else {
                                $('#my_interests').html("");
                                if (!is_owner) {
                                    $('#profile_interests').hide();
                                    $('#profile_interests').prev('h5').css('display', 'none');
                                }
                            }
                        },
                        error: function (responseText) {
                            alert("interest insert failed");
                        }
                    });
                });
                /* End of code for interests */

                /* Code to manage the dropdowns */

                //$(document).delegate(".repeatoptiont", "mouseover", function () {
                //    $(this).css({ "color": "#30E680", "border-bottom": "1px solid #30E680" });
                //});

                //$(document).delegate(".repeatoptiont", "mouseout", function () {
                //    $(this).css({ "color": "rgba(0,0,0,0.7)", "border-bottom": "1px solid #ccc" });
                //});

                //$(document).delegate(".repeatstate", "mouseover", function () {
                //    $(this).css({ "opacity": "1" });
                //    $(".repeatoption").fadeIn();
                //});

                //$(document).delegate(".repeatstate", "mouseout", function () {
                //    $(this).css({ "opacity": "1" });
                //    $(".repeatoption").fadeOut();
                //});

                //$(document).delegate(".repeatoption", "mouseout", function () {
                //    $(".repeatoption").fadeOut();
                //});

                //$(document).delegate(".repeatstate", "mouseout", function () {
                //    $(this).css({ "opacity": "0.7" });
                //});

                //$(document).delegate(".repeatoption", "mouseover", function () {
                //    $(this).stop(true, true).show();
                //});

                $(document).delegate(".status-event-repeat", "click", function () {
                    $(this).next('.status-click-out').toggle();
                });

                //$(document).delegate(".status-dd-title", "click", function () {
                //    $(this).parent('.status-event-repeat').next('.status-click-out').toggle();
                //});

                $(document).delegate(".down-arrow", "click", function () {
                    $(this).parent('.status-event-repeat').next('.status-click-out').toggle();
                });

                $(document).delegate(".status-repeatoptiont-1", "click", function () {
                    $(this).parent('.status-click-out').prev(".status-event-repeat").children('.status-dd-title').text($(this).text());
                    $(this).parent(".status-click-out").hide();
                    var id = $(this).prop('id');
                    if (id.substr(0, 4) == "dept") {
                        id = id.split('_')[1];
                    }
                    $(this).parent('.status-click-out').prev(".status-event-repeat").children('.selected-value-to-send').text(id);
                });

                /* Code to manage the dropdowns end here*/

                /*Code that handles images on showcase bar*/
               // var imgList= ["../assets/nyu.jpg", "../assets/person3.jpg", "../assets/person4.jpg", "../assets/link_photo.jpg"];
             //   var centerImg = imgList[0];
               /* $(document).ready(function(){
                    $('.center-image img').attr('src', centerImg);
                    $('.center-image img').on('load', function(){
                        var newWidth = $(this).width();
                        $('.center-image').css({ 'width' : newWidth, 'margin-left' : 'calc( 50% - ' + newWidth/2 + 'px)' });
                    });
                    //Get the index
                    var centerImgIdx = $.inArray(centerImg, imgList);
                    var centerMargin = ( $('.center-image img').width() )/2;
                    if( centerImgIdx != -1 &&  centerImgIdx+1 < imgList.length ){
                        $('#img-slot1 img').attr('src', imgList[centerImgIdx+1] );
                        $('#img-slot1 img').on('load', function(){
                            var width1 = $(this).width();
                            $('#img-slot1').css('width', width1);
                            $('#img-slot1').css('margin-left', 'calc(50% + ' + (( $('.center-image img').width() )/2 + 7) + 'px)');
                        });
                    }
                });*/

            });

            (function ($) {
                $("div.website-inp-wrap .dropdown").mCustomScrollbar({
                    theme: 'minimal-dark',
                    scrollInertia: 10
                });
            })(jQuery);

            function slideShow(ul, ctrl, transdur) {
                var obj = {};
                transdur = transdur || 3000;

                while (ul.childElementCount < 5)
                    [].forEach.call(ul.children, function (e, i) {
                        ul.appendChild(e.cloneNode(true))
                    });

                obj.changeTitle = function () {
                    ctrl.getElementsByClassName("title")[0].innerHTML = ul.children[2].children[0].getAttribute("data-title");
                    ctrl.classList.remove("hide");
                }

                obj.rotate = function (ele, dir) {
                    if (dir === "l") ele.appendChild(ele.children[0]);
                    else if (dir === "r") ele.insertBefore(ele.children[ele.children.length - 1], ele.children[0]);
                    else throw "Invalid Option " + dir;
                }

                obj._animate = function (dir) {
                    ul.classList.remove("go" + (dir == "l" ? "left" : "right"));
                    obj.rotate(ul, dir);
                    obj.changeTitle();
                }

                obj.cancelAuto = function () {
                    clearInterval(obj.goLeftId);
                    clearInterval(obj.goRightId);
                    clearTimeout(obj.contLeftId);
                    clearTimeout(obj.contRightId);
                }

                obj.hideControls = function () {
                    ctrl.classList.add("hide");
                }

                obj.goLeft = function () {
                    obj.cancelAuto();
                    ul.classList.remove("goleft");
                    obj.goLeftId = setInterval(function () {
                        ul.classList.add("goleft");
                        obj.hideControls();
                        setTimeout(function () {
                            obj._animate("l");
                        }, 1050);
                    }, transdur);
                }

                obj.goRight = function () {
                    obj.cancelAuto();
                    ul.classList.remove("goright");
                    obj.goRightId = setInterval(function () {
                        ul.classList.add("goright");
                        obj.hideControls();
                        setTimeout(function () {
                            obj._animate("r");
                        }, 1050);
                    }, transdur);
                }

                obj.goStepRight = function () {
                    obj.cancelAuto();
                    ul.classList.add("goright");
                    obj.hideControls();
                    setTimeout(function () {
                        obj._animate("r");
                        obj.continueRight();
                    }, 1050);
                }

                obj.goStepLeft = function () {
                    obj.cancelAuto();
                    ul.classList.add("goleft");
                    obj.hideControls();
                    setTimeout(function () {
                        obj._animate("l");
                        obj.continueLeft();
                    }, 1050);
                }

                obj.continueLeft = function () {
                    obj.cancelAuto();
                    obj.contLeftId = setTimeout(function () {
                        obj.goLeft();
                    }, 10000);
                }

                obj.continueRight = function () {
                    obj.cancelAuto();
                    obj.contRightId = setTimeout(function () {
                        obj.goRight();
                    }, 10000);
                }

                obj.changeTitle();

                return obj;
            }

            $(function () {
                var wrapper = document.getElementsByClassName("showcase-wrapper")[0];
                var images = wrapper.getElementsByTagName("ul")[0];
                var controls = wrapper.getElementsByClassName("controls")[0];
                var ss = slideShow(images, controls, 6000);
                controls.getElementsByClassName("left")[0].addEventListener("click", function () {
                    ss.goStepLeft();
                });
                controls.getElementsByClassName("right")[0].addEventListener("click", function () {
                    ss.goStepRight();
                });
                ss.goLeft();
            });
            function getFile(){
                document.getElementById("upfile").click();
            }

        })(jQuery);
function getFrontImage(index){
    if( $('.showcase-image').length != 0){
        while(index < 999){
            if( $('#img-slot' + index).length != 0){
                return index;
            }
            ++index;
        }
    }
}

/*function download_file(url){
    $.ajax({
        url: base_url+'/profile/downloadShowcase',
        type: 'POST',
        data: {file_url:url},
        //dataType: 'json',
        success: function(result)
        {
            if(result.status != "success"){
                alert(result.status);
            }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            alert(errorThrown);
        }
    });
}
function alert(message) {
    var x = 'whatever';
}*/
function add_interests(new_interests){
    alert('hi');
    if(new_interests.length>0){
        alert('in');
        var interestData = new FormData();
        for(var i=0;i<new_interests.length;i++){
            interestData.append('interests['+i+']',new_interests[i]);
        }
        interestData.append('user_id',user_id);
        $.ajax({
            url: base_url+'/profile/addInterest',
            type: 'POST',
            data: interestData,
            //  cache: false,
            dataType: 'json',
            //   processData: false, // Don't process the files
            //  contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            success: function(result)
            {
                if(result.status == "success") {
                    alert('good');
                }else{
                    alert(result.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                alert(errorThrown);
            }
        });
        /*$.post(base_url + "/profile/addInterest", interestData, function (data) {
         if(!(/error/i.exec(data))){

         //  $('input[name=interest_name]').val('');
         }else{
         alert(data);
         }
         });*/
    }else{
        alert('no new interests');
    }
}

