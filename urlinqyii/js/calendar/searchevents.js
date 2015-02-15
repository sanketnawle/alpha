

$(document).on('focus','#txt_initial_search', function(){

    $(".left_panel_create_button.left_panel_create_button").addClass("disabled");
    $(".mini_calendar_cover").addClass("enabled");
    $('#events_results_found').html("");
    $('#search_dialog').show();
    $('#search_text').focus();

});

$('#search_text').keyup(function(event){
     var month = new Array();
    month[0] = "Jan";
    month[1] = "Feb";
    month[2] = "Mar";
    month[3] = "Apr";
    month[4] = "May";
    month[5] = "Jun";
    month[6] = "Jul";
    month[7] = "Aug";
    month[8] = "Sep";
    month[9] = "Oct";
    month[10] = "Nov";
    month[11] = "Dec";
    txt = $('#search_text').val();
    if(txt.length>1){
        html_content = '';
        $.ajax({
               url: "event/SearchEvents",
               type: "GET",
               data: {"search_text":txt},
               success: function(response) {
                console.log(response);
                if(response["events"]){
                    $.each(response["events"],function(index, item){
                         var d = new Date(item["start_date"]);
                         html_content+= '<div style="padding-left:40px" class="post" id="">\
                                    <div class="post_main event_post">\
                                    <div class="post_head">\
                                        <div class="post_event_date_box" style="background-color:aqua;">\
                                            <div class="top_dark_area"></div>\
                                            <div class="post_event_month post_event_date_box_text">'+d.getMonth()+'</div>\
                                            <div class="post_event_day post_event_date_box_text">'+month[d.getDay()]+'</div>\
                                        </div>\
                                        <div class="event_post_toparea">\
                                            <div class="post_event_title">'+item["title"]+'</div>\
                                                <div class="event_context">\
                                                    <div class="post_event_time_holder">\
                                                    <div class="post_event_start_time">1:49 PM</div> to <div class="post_event_end_time">2:49 PM</div>\
                                                    </div>\
                                                </div>\
                                        </div>\
                                    </div>\
                                    </div>\
                                </div>';
                    });
                $('#events_results_found').html(html_content);
                }
               },
               error: function(jqXHR, textStatus, errorMessage) {
                   console.log(errorMessage); // Optional
               }
        });
    }
    else{

        $('#events_results_found').html("");
    }
});


$(document).on('click','#search_back_button',function(e){
    $(".left_panel_create_button.left_panel_create_button").removeClass("disabled");
    $(".mini_calendar_cover").removeClass("enabled");
    $('#events_results_found').html('');
    $('#search_dialog').hide();
});
