
if (origin_type == "club"){
    $("ul[data-group='clubs'] a[data-group_id='" + origin_id + "']").addClass("current_group");
}

if (origin_type == "class"){
    $("ul[data-group='classes'] a[data-class_id='" + origin_id + "']").addClass("current_group");
}

//change profile picture
var picking_file=false;
$(document).on('click','#left_panel_change_picture_button',function(e){
    e.preventDefault();
    e.stopPropagation();
    if(picking_file==false){
        picking_file=true;
        $('#left_panel_picture_upfile').click();

    }

});
var upload_file;
$(document).on('change', '#left_panel_picture_upfile', function (event)
{
    picking_file=false;
    upload_file = event.target.files[0];
    var data = new FormData();

    data.append("file", upload_file);
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
                //$('#profile_picture').css('background-image','url('+data.file_url+')');
                $('.post_user_icon[data-user_id='+globals.user_id+']').css('background-image','url("'+data.file_url+'")');
                $('.comment_owner_container[data-user_id='+globals.user_id+']').css('background-image','url("'+data.file_url+'")');
                $('.MyBox_Picture').css('background-image','url("'+data.file_url+'")');
                $('.members_card_img[data-user_id='+globals.user_id+']').css('background-image','url("'+data.file_url+'")');
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
