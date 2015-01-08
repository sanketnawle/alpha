var user_id = 7;

$(document).on('click', '.profile_link', function(){
    if($('#profile_wrapper').length){
        $('#profile_wrapper').show();
        $('.overlay').show();
    }else{
        open_profile(base_url,user_id);
    }

});
$(document).on('click', '.close_modal', function(){
    $('#profile_wrapper').hide();
    $('.overlay').hide();
});

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
$(document).on('click','.cancel_showcase_form',function(){
    $('#add_showcase_form').hide();
    $('#profile_overlay').hide();

    //kinyi add showcase to showcase bar: data.title, data.desc, data.file_extension, data.preview_file
    //reset form
    $('#link_entry').val('');
    $('#title_entry').val('');
    $('#desc_entry').val('');
    $('#link_entry').prop('disabled',false);
});
function open_profile(base_url,user_id){
  //  var numShowcase;
    $.getJSON( base_url + "/profile/json",{id: user_id}, function( json_profile_data ) {
        //numShowcase=json_profile_data.showcase.length();
        render_profile(base_url,json_profile_data);
    });

}
function render_profile(base_url,data){

    $.ajax({ url: base_url + '/protected/views/profile/profile.html',
        dataType:'html',
        success: function(html) {
            numShowcase=data.showcase_size;
            var template = Handlebars.compile(html);
            $('body').append(template(data));
            if(data.minors.length==0){
                $('#minor_section').hide();
            }
            if(data.majors.length==0){
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
                $('.add_showcase_form').hide();
                $('.showcase_form_overlay').hide();

                //kinyi add showcase to showcase bar: data.title, data.desc, data.file_extension, data.preview_file
                //reset form
                $('#link_entry').val('');
                $('#title_entry').val('');
                $('#desc_entry').val('');
                $('#link_entry').prop('disabled',false);
                render_new_showcase(data);
                //alert(data.message);
            }else{
               // alert(data.message);
            }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            alert('err'+errorThrown);
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
$(document).on('click','#edit_profile_button.not_editing',function(){
    alert('edit');
    $('#profile_overlay').show();
    $('#left_info_bar,#profile_picture_wrapper').css('z-index','3000');
    $('.info_name').hide();
    $('.headers').show();
    $('.edit_field').show();
    //school
    $.getJSON( base_url + "/profile/getSchools",{user: user_id}, function( result) {
        $.each(result.schools,function(i,school){
            $('#school_dropdown').append($('<option/>').attr("value", school.id).text(school.name));
        });
        $('#school_dropdown').val(result.selected);
    });
    //department
    $.getJSON( base_url + "/profile/getDepartments",{user: user_id}, function( result) {
        $.each(result.departments,function(i,department){
            $('#department_dropdown').append($('<option/>').attr("value", department.id).text(department.name));
        });
        $('#department_dropdown').val(result.selected);
    });
    //majors
    $('.info_name.major').each(function(i){
        if(!$(this).hasClass('undeclared')){
            $('.edit_field.major:eq('+i+')').val($(this).text());
        }
    });
    //minors
    $('#minor_section').show();
    $('.info_name.minor').each(function(i){
        if(!$(this).hasClass('undeclared')){
            $('.edit_field.minor:eq('+i+')').val($(this).text());
        }
    });
    //research
    $('#research_section').show();
    $('#research_section').val($('#research_name').text());

    $('.info_section.account').show();

    //buttons
    $('#edit_profile_button').css('margin-left','0');
    $('#edit_profile_button').text('Done Editing');
    $('#edit_profile_button').removeClass('not_editing');
    $('#edit_profile_button').addClass('editing');
    $('#cancel_edit_button').show();
    $('#cancel_edit_button').css('display','inline-block');
});
$(document).on('click','#edit_profile_button.editing',function(){
    //alert('done');
    var data = new FormData();
    data.append('school',$('#school_dropdown').val());
    data.append('user',user_id);
    data.append('name',$('#name_input').val());
    data.append('department',$('#department_dropdown').val());
    data.append('email',$('#email_input').val());
    var any_major = false;
    $('.edit_field.major').each(function(index){
        if($(this).val()){
            any_major = true;
            data.append('majors['+index+']', $(this).val());
        }
    });
    if(!any_major){
        data.append('majors[0]', "none");
    }
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
            if(result.major == "success"){
                $('#major_section > .info_name.major').remove();
                if(!any_major){
                    $('#major_section > .info_name.undeclared').show();
                }else{
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
            }else{
                $('#major_section > .info_name.undeclared').hide();
            }
            if(result.minor == "success"){
                $('#minor_section > .info_name.minor').remove();
                if(!any_minor){
                    $('#minor_section').hide();
                }else{
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
    major_changed = true;
    major_text = $(this).val();
    $.getJSON(base_url + '/profile/autoComplete',{major: major_text},function (result) {
        $('.edit_field.minor:eq('+major_index+')').autocomplete({source: result});
    });
});