
$(document).on('click', '.profile_link', function(){
        open_profile(base_url, $(this).attr('user_id'),$(this).text());

});
$(document).on('click', '.close_modal', function(){
    $('#profile_wrapper').hide();
    $('#profile_background_overlay').hide();
});
function open_profile(base_url,user_id){
    //  var numShowcase;
    $.getJSON( base_url + "/profile/json",{id: user_id}, function( json_profile_data ) {
        if($('#profile_wrapper').attr('user_id')==json_profile_data.user_id){
            $('#profile_wrapper').show();
            $('#profile_background_overlay').show();
        }else if($('#profile_wrapper').length){
            $('#profile_wrapper').remove();
            $('#profile_background_overlay').remove();
            render_profile(base_url,json_profile_data);
        }else{
            render_profile(base_url,json_profile_data);
        }
    });


}
function render_profile(base_url,data){

    $.ajax({ url: base_url + '/protected/views/profile/profile.html',
        dataType:'html',
        success: function(html) {
            $.ajax({ url: base_url + '/profile/returnFeed?user='+data.user_id,
                dataType:'html',
                success: function(html) {
                    $('#profile_panel_1 > #feed_wrapper').append(html);
                }
            });
            $.ajax({ url: base_url + '/profile/returnFbar?user='+data.user_id,
                dataType:'html',
                success: function(html) {
                    $('#profile_panel_1 > #fbar_wrapper').append(html);
                    $('#profile_panel_1').find('#fbar_new').addClass('profile');
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

            $('#name_input').val(data.firstname+" "+data.lastname);
            $('#email_input').val(data.email);
        }
    });
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

        $('.showcase_items').css('margin-left', 260 - (index)*495);
        $('.showcase_item.center').removeClass('center');
        $('.showcase_item[showcase_index='+(index)+']').addClass('center');
    }
    //alert($('.showcase_item.center').attr('showcase_index'));
});
$(document).on('click','.add_showcase_button',function(){

   //$('.overlay').css('z-index',2500);
    $('#profile_overlay').show();
    $('#add_showcase_form').show();
});
$(document).on('click','#cancel_showcase_form',function(){
    $('#add_showcase_form').hide();
    $('#profile_overlay').hide();

    //kinyi add showcase to showcase bar: data.title, data.desc, data.file_extension, data.preview_file
    //reset form
    $('#link_entry').val('');
    $('#title_entry').val('');
    $('#desc_entry').val('');
    $('#link_entry').prop('disabled',false);
});


function render_new_showcase(data){

    $.ajax({ url: base_url + '/protected/views/profile/showcase_template.html',
        dataType:'html',
        success: function(html) {
            var template = Handlebars.compile(html);
            var index=parseInt($('.showcase_item.center').attr('showcase_index'));
            $('.showcase_item').each(function(){
                $(this).attr('showcase_index',function(i,currValue){
                    currValue = parseInt(currValue);
                    return currValue>=index ? currValue+1 : currValue;
                });
            });
            $('.showcase_item.center').removeClass('center');

            data.index = index;
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
                $('#link_entry').prop('disabled',false);
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
var any_major;
var any_research;
var schools_loaded = false;
$(document).on('click','#edit_profile_button.not_editing',function(){
    $('#profile_overlay').show();
    $('#left_info_bar,#profile_picture_wrapper').css('z-index','3000');
    any_major=$()
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
    any_major=!$('#major_section >.info_name.undeclared').is(':visible');
    //minors
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
var any_research=false;
$(document).on('click','#edit_profile_button.editing',function(){  //submit changes
    //alert('done');
    var data = new FormData();
    data.append('school',$('#school_dropdown').val());
    data.append('user',user_id);
    data.append('name',$('#name_input').val());
    data.append('department',$('#department_dropdown').val());
    data.append('email',$('#email_input').val());
    data.append('year',$('#year_dropdown').val());
    data.append('year_name',$('#level_dropdown').val());
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
        var any_minor = false;
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
          /* if(result.year == "success"){
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
            }*/
            var any_errors = false;
            if(result.year_name == "success"){
                $('#level_name').text($('#level_dropdown').val());
            }else if(result.year_name){
                alert(result.year_name);
            }
            if(result.year == "success"){
                $('#year').text($('#year_dropdown').val());
            }else if(result.year){
                alert(result.year);
            }
            if(!any_major){
                alert('why');
                $('#major_section > .info_name.undeclared').show();
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
                // $('input[name=major_name]').val(majors[0]);
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
                // $('input[name=major_name]').val(majors[0]);
            }
            if(!any_research){
                $('#research_section').hide();
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
                // $('input[name=major_name]').val(majors[0]);
            }
            if(!any_minor){
                $('#minor_section').hide();
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
                $('#name_info').text($('#name_input').val());
            }else if(result.name){
                alert(result.name);
                any_errors = true;
            }
            if(result.school == "success"){
                $('#school_name').text(
                    $('#school_dropdown > option[value='+$('#school_dropdown').val()+']').text());
            }
            else if(result.school){
                alert(result.school);
                any_errors = true;
            }
            if(result.department == "success"){
                $('#department_name').text(
                    $('#department_dropdown > option[value='+$('#department_dropdown').val()+']').text());
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
    if(!any_research){
        $("#research_section").hide();
    }

    closeEditProfile();
});
function closeEditProfile(){
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
        data: {user_to_follow:$('#profile_wrapper').attr('user_id'),user:user_id,follow:follow},
        dataType: 'json',
        success: function(data)
        {
            if(data.status == "success"){
                if(follow){

                    $('#follow_button').addClass('following');
                    $('#follow_button').text('Following');
                }else{

                    $('#follow_button').removeClass('following');
                    $('#follow_button').text('Follow');
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