$(document).on('click', '.profile_link', function(){
    //$(this).prepend("<img class='waiting_animation_circletype waiting_animation_circletype_sz10 circletype_animation_adjust_1' src='http://www.urlinq.com/beta/img/waiting_animation_circletype.GIF'>");

    open_profile(base_url,7);
});
$(document).on('click', '.close_modal', function(){
    //$(this).prepend("<img class='waiting_animation_circletype waiting_animation_circletype_sz10 circletype_animation_adjust_1' src='http://www.urlinq.com/beta/img/waiting_animation_circletype.GIF'>");
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

function open_profile(base_url,user_id){

    $.getJSON( base_url + "/profile/json",{id: user_id}, function( json_profile_data ) {
        /*if(json_profile_data['success']){
            //alert(JSON.stringify(json_feed_data));
//                alert(JSON.stringify(json_feed_data));
            render_profile(json_profile_data['feed']);
        }else{
            alert('failed to get profile data');
        }*/
        render_profile(base_url,json_profile_data);
    });

}
function render_profile(base_url,data){

    $.ajax({ url: base_url + '/protected/views/profile/profile.html',
            dataType:'html',
            success: function(html) {
             //   source = html('#profile_template').html();
                //source = html;
                var template = Handlebars.compile(html);
                // var id = $(this).parent(".master_comments").attr("id");
                $('body').append(template(data));
            }

    });

}