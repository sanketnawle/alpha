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
var numShowcase=3;
$(document).on('click','.showcase_arrow.left',function(){
    var index=parseInt($('.showcase_item.center').attr('showcase_index'));
    if(index>0){
        index--;
       /* $('.showcase_items').css('margin-left', function (index, curValue) {
            return parseInt(curValue, 10) + 495 + 'px';
        });*/
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
        /*$('.showcase_items').css('margin-left', function (index, curValue) {
            return parseInt(curValue, 10) - 495 + 'px';
        });*/
        $('.showcase_items').css('margin-left', 260 - (index)*495);
        $('.showcase_item.center').removeClass('center');
        $('.showcase_item[showcase_index='+(index)+']').addClass('center');
    }
    //alert($('.showcase_item.center').attr('showcase_index'));
});
$(document).on('click','.add_showcase_button',function(){

   //$('.overlay').css('z-index',2500);
    $('.showcase_form_overlay').show();
    $('.add_showcase_form').show();

});
$(document).on('click','.cancel_showcase_form',function(){
    $('.add_showcase_form').hide();
    $('.showcase_form_overlay').hide();

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
            $('.showcase_item[showcase_index='+(index+1)+']').before(template(data));
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
}