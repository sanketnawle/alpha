;(function($){
    $.fn.extend({
        donetyping: function(callback,timeout){
            timeout = timeout || 1e3; // 1 second default timeout
            var timeoutReference,
                doneTyping = function(el){
                    if (!timeoutReference) return;
                    timeoutReference = null;
                    callback.call(el);
                };
            return this.each(function(i,el){
                var $el = $(el);
                // Chrome Fix (Use keyup over keypress to detect backspace)
                // thank you @palerdot
                $el.is(':input') && $el.on('keyup keypress',function(e){
                    // This catches the backspace button in chrome, but also prevents
                    // the event from triggering too premptively. Without this line,
                    // using tab/shift+tab will make the focused element fire the callback.
                    if (e.type=='keyup' && e.keyCode!=8) return;
                    
                    // Check if timeout has been set. If it has, "reset" the clock and
                    // start over again.
                    if (timeoutReference) clearTimeout(timeoutReference);
                    timeoutReference = setTimeout(function(){
                        // if we made it here, our timeout has elapsed. Fire the
                        // callback
                        doneTyping(el);
                    }, timeout);
                }).on('blur',function(){
                    // If we can, fire the event since we're leaving the field
                    doneTyping(el);
                });
            });
        }
    });
})(jQuery);

$('#search_text').donetyping(function(){
  search_calendar();
});

$(document).on('focus','#txt_initial_search', function(){

    $(".left_panel_create_button.left_panel_create_button").addClass("disabled");
    $(".mini_calendar_cover").addClass("enabled");
    $('#events_results_found').html("");
    $('#search_dialog').show();
    $('#search_text').focus();

});

var search_calendar = function(event){
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
                if(response["events"]){
                    $.each(response["events"],function(index, item){
                         date_split = item['start_date'].split("-")
                         redirect_date = date_split[1]+"/"+date_split[2]+"/"+date_split[0]
                         var d = new Date(redirect_date);
                         html_content+= '<div style="padding-left:40px" class="post">\
                                    <div class="post_main event_post">\
                                    <div class="post_head">\
                                        <div class="post_event_date_box" style="background-color:aqua;">\
                                            <div class="top_dark_area"></div>\
                                            <div class="post_event_month post_event_date_box_text">'+month[d.getMonth()]+'</div>\
                                            <div class="post_event_day post_event_date_box_text">'+date_split[2]+'</div>\
                                        </div>\
                                        <div class="event_post_toparea">\
                                            <div class="post_event_title"><a class="go_to_event" start_date="'+item["start_date"]+'" start_time="'+item["start_time"]+'" end_date="'+item["end_date"]+'" end_time="'+item["end_time"]+'" all_day="'+item["all_day"]+'" title="'+item["title"]+'">'+item["title"]+'</a></div>\
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
};


$(document).on('click','#search_back_button',function(e){
    $(".left_panel_create_button.left_panel_create_button").removeClass("disabled");
    $(".mini_calendar_cover").removeClass("enabled");
    $('#events_results_found').html('');
    $('#search_dialog').hide();
});


$(document).on('click','.go_to_event',function(event){
     jQuery(".left_panel_create_button.left_panel_create_button").removeClass("disabled");
        jQuery(".mini_calendar_cover").removeClass("enabled");
   event.preventDefault(); 
   item = {};
   item['start_date'] = $(this).attr('start_date');
    item['start_time'] = $(this).attr('start_time');
    item['end_date'] = $(this).attr('end_date');
    item['end_time'] = $(this).attr('end_time');
    item['all_day'] = $(this).attr('all_day');
    item['title'] = $(this).attr('title');
    item_color = {}
    item_color["hex"] = "#669999";
    item['color'] = item_color;
    console.log(item['start_date']);
    $('#search_back_button').trigger('click');
    //show_day_event(item);
    date_split = item['start_date'].split("-")
    redirect_date = date_split[2]+"/"+date_split[1]+"/"+date_split[0]
    window.location.replace("calendar#/day/"+redirect_date);
});

