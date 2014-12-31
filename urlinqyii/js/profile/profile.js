$(document).on('click', '.profile_link', function(){
    if($('#profile_wrapper').length){
        $('#profile_wrapper').show();
        $('.overlay').show();
    }else{
        open_profile(base_url,7);
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
        $('.showcase_items').css('margin-left', function (index, curValue) {
            return parseInt(curValue, 10) + 495 + 'px';
        });
        $('.showcase_item.center').removeClass('center');
        $('.showcase_item[showcase_index='+(index-1)+']').addClass('center');
    }
   // alert($('.showcase_item.center').attr('showcase_index'));
});
$(document).on('click','.showcase_arrow.right',function(){
    var index=parseInt($('.showcase_item.center').attr('showcase_index'));
    if(index<numShowcase-1){
        $('.showcase_items').css('margin-left', function (index, curValue) {
            return parseInt(curValue, 10) - 495 + 'px';
        });
        $('.showcase_item.center').removeClass('center');
        $('.showcase_item[showcase_index='+(index+1)+']').addClass('center');
    }
    //alert($('.showcase_item.center').attr('showcase_index'));
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
            var template = Handlebars.compile(html);
            $('body').append(template(data));
        }

    });

}