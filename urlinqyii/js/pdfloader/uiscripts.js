$(document).ready(function(){
    
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

$('#txt_initial_search').donetyping(function(){
  search_events();
});
});


var events_length = 0;
$(document).on("click",'#btn_add_syllabus', function(event){
        event.preventDefault();
        
        $("#syllabus_pdf_upload").trigger("click");
});
$(document).ready(function(){

  $(document).on("click", "#btn_view_syllabus", function() {
      $('html, body').animate({
          scrollTop: $("div#pdfContainer").offset().top
      }, 1000);
  });
  $(document).on("click", ".add_event_button", function() {
      $('.tab.active').removeClass('active');
      $(".tab.feed").addClass('active');
      $('.panel.active').removeClass('active');
      $('#panel_1').addClass('active');
  });



});




$(document).on("change",'#syllabus_pdf_upload', function(event){
        event.preventDefault();

        filevalue = $("#syllabus_pdf_upload").val().split(".");
        file_length = filevalue.length;
        if(filevalue[file_length-1]=="pdf"){
            fd = new FormData();
            if ($('#syllabus_pdf_upload')[0].files[0]){
            fd.append("file", $('#syllabus_pdf_upload')[0].files[0]);
            fd.append("id", globals.origin_id);
            }
            $.ajax({
                       url: "FileUpload",
                       type: "POST",
                       data: fd,
                       processData: false,
                       contentType: false,
                       success: function(response) {
                       fd_store = new FormData();
                        fd_store.append("file_id", response["file_id"]);
                        file_id = response["file_id"];
                        fd_store.append("class_id", globals.origin_id);

                        /*response_data = $.parseJSON(response);*/
                        $.ajax({
                                   url: "StoreSyllabus",
                                   type: "POST",
                                   data: fd_store,
                                   processData: false,
                                   contentType: false,
                                   success: function(response) {
                                      $('#pdfContainer').html("");
                                      previous = "";
                                      events={};
                                      added_events = [];
                                      $('div#events_list').html("");
                                      pdf_year= (new Date()).getFullYear();
                                      file_resp = get_pdf();
                                      run_pdf_algo(true, globals.base_url+file_resp["file_url"]);
                                   },
                                   error: function(jqXHR, textStatus, errorMessage) {
                                       console.log(errorMessage); // Optional
                                   }
                                });
                         
                       },
                       error: function(jqXHR, textStatus, errorMessage) {
                           console.log(errorMessage); // Optional
                       }
                    });
        }
        else{
            alert("Invalid file! Please upload .pdf format");
        }
});

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

var load_events = function (pdf_id) {
  var event_array_list = new Array();
  var resp = $.ajax({
         url: "GetEvents",
         type: "GET",
         async: false,
         data: {"class_id":globals.origin_id, "file_id":pdf_id},
         success: function(response) {
          $.each(response, function(index,value){
                var d = new Date(value["start_date"]+" "+ value["start_time"]);
                var dt = new Date(value["end_date"]+" "+ value["end_time"]);
                if(d.getHours()!="0" && dt.getHours()!="0"){
                  time = "from "+formatAMPM(d)+" to "+formatAMPM(dt);
                }
                else if(d.getHours()!="0"){
                  time="@ " + formatAMPM(d);
                }
                else{
                  time="";
                }
                if(value["location"]==""){
                  event_location = "Add location";
                }
                else{
                  event_location = value["location"];
                }
                if(value["description"]==""){
                  description = "Add description";
                }
                else{
                  description = value["description"];
                }
                
                var event_value ={
                  title: value["title"],
                  location: event_location,
                  description: description,
                  event_id: value["event_id"],
                  day: d.getDate(),
                  month: month[d.getMonth()],
                  event_id: value["event_id"],
                  time: time,
                  color: class_color,
                  origin_type: value["event_type"],
                };
                  event_array_list.push(event_value);
               
              });
         },
         error: function(jqXHR, textStatus, errorMessage) {
             console.log(errorMessage); // Optional
         }
      });
      
         return event_array_list;
};


$(document).on("click",'.done_editing_button', function(){

var title = $(this).siblings().closest('input').val();
var id = $(this).parent().parent().attr('id');
$.ajax({
       url: "UpdateSyllabusEvent",
       type: "POST",
       data: {"id":id,"title":title},
       success: function(response) {
       },
       error: function(jqXHR, textStatus, errorMessage) {
           console.log(errorMessage); // Optional
       }
    });
});

var get_class_color = function(){
  var resp = $.ajax({
               url: "GetClassColor",
               type: "POST",
               data: {"class_id":globals.origin_id},
               async: false,
               success: function(response) {

               },
               error: function(jqXHR, textStatus, errorMessage) {
                   console.log(errorMessage); // Optional
               }
            });
  return resp.responseText;
}

function formatAMPM(date) {
  var hours = date.getHours();
  var minutes = date.getMinutes();
  var ampm = hours >= 12 ? 'pm' : 'am';
  hours = hours % 12;
  hours = hours ? hours : 12; // the hour '0' should be '12'
  minutes = minutes < 10 ? '0'+minutes : minutes;
  var strTime = hours + ':' + minutes + ' ' + ampm;
  return strTime;
}


function display_events(events, is_root){
  $("#events_template_loc").data('data-form', events);
  $("#events_template_loc").attr('current_page', 0);
  $("#events_template_loc").attr('pagecount', Math.ceil(events.length/4));
  events_length = events.length;
  right = "block";
  if(events_length<=4){
    right = "none";
  }
  if(is_root){
    search_text = " Total events this semester";
  }
  else{
    search_text = " Total events found";
  }
  list_events(events.slice(0,4), "none", right, 0, search_text);
}

function list_events(events, img_left, img_right, page_value, result_text){
  display_text = '\
                  <div id="event_count">'+events_length+ result_text+'</div>\
                    <div class = "syllabus_tab_add_event_wrapper">\
                      <div class = "add_event_button fbar_buttonwrapper" id = "fbar_button_event" data-post_button_type="event">\
                      </div>\
                      <div class = "add_event_hint">\
                          <div class = "wedge">\
                          </div>\
                          <div class = "box">Add New Event</div>\
                      </div>\
                    </div>\
                    <div class="chip-container" id="chip_div">';

      for(i=0;i<events.length; i++){
                    display_text+='<div class="chip_content">\
                      <div class="chip"  style="display:none;right:-100px;" index="'+(page_value*4+i)+'" hero-id="'+events[i]["event_id"]+'">\
                        <div class="chip-top" style="background:'+events[i]["color"]+';">\
                          <div class="month">\
                            <span class = "month_text">'+events[i]["month"]+'</span>\
                            <span class = "day_text">'+events[i]["day"]+'</span>\
                          </div>\
                          <div class="time">\
                            <span>'+events[i]["time"]+'</span>\
                          </div>\
                        </div>\
                        <div class="collapse-date">'+events[i]["month"]+' '+events[i]["day"]+'</div>\
                        <div class="chip-bottom">\
                          <div class="chip-album-title">'+events[i]["title"]+'</div>\
                          <div class="chip-artist">'+events[i]["origin_type"]+'</div>\
                        </div>\
                        <div class="collapse-info"><div class="collapse-info-hover"></div></div>\
                      </div>\
                    </div>';
        };
    display_text+='</div>\
                    <span style="display:'+img_right+'" class="img_arrows img_rt"><img src="../assets/arrow-28-512.png"></span>\
                    <span style="display:'+img_left+'" class="img_arrows img_lt"><img src="../assets/arrow-28-51-lt.png"></span>';
    $("#events_template_loc").html(display_text);
    $(".chip").each(function(){
      $(this).fadeIn({
        queue: false,
        duration: 'slow'
      }).animate({
        right: "0px"
      });
    });
}

function list_events_left(events, img_left, img_right, page_value, result_text){
  display_text = '\
                  <div id="event_count">'+events_length+ result_text+'</div>\
                    <div class = "syllabus_tab_add_event_wrapper">\
                      <div class = "add_event_button fbar_buttonwrapper" id = "fbar_button_event" data-post_button_type="event">\
                      </div>\
                      <div class = "add_event_hint">\
                          <div class = "wedge">\
                          </div>\
                          <div class = "box">Add New Event</div>\
                      </div>\
                    </div>\
                    <div class="chip-container" id="chip_div">';

      for(i=0;i<events.length; i++){
                    display_text+='<div class="chip_content">\
                      <div class="chip"  style="display:none;left:-100px;" index="'+(page_value*4+i)+'" hero-id="'+events[i]["event_id"]+'">\
                        <div class="chip-top" style="background:'+events[i]["color"]+';">\
                          <div class="month">\
                            <span class = "month_text">'+events[i]["month"]+'</span>\
                            <span class = "day_text">'+events[i]["day"]+'</span>\
                          </div>\
                          <div class="time">\
                            <span>'+events[i]["time"]+'</span>\
                          </div>\
                        </div>\
                        <div class="collapse-date">'+events[i]["month"]+' '+events[i]["day"]+'</div>\
                        <div class="chip-bottom">\
                          <div class="chip-album-title">'+events[i]["title"]+'</div>\
                          <div class="chip-artist">'+events[i]["origin_type"]+'</div>\
                        </div>\
                        <div class="collapse-info"><div class="collapse-info-hover"></div></div>\
                      </div>\
                    </div>';
        };
    display_text+='</div>\
                    <span style="display:'+img_right+'" class="img_arrows img_rt"><img src="../assets/arrow-28-512.png"></span>\
                    <span style="display:'+img_left+'" class="img_arrows img_lt"><img src="../assets/arrow-28-51-lt.png"></span>';
    $("#events_template_loc").html(display_text);
    $(".chip").each(function(){
      $(this).fadeIn({
        queue: false,
        duration: 'slow'
      }).animate({
        left: "0px"
      });
    });
}


function getPosition(element) {
      var xPosition = 0;
      var yPosition = 0;
    
      while(element) {
          xPosition += (element.offsetLeft - element.scrollLeft + element.clientLeft);
          yPosition += (element.offsetTop - element.scrollTop + element.clientTop);
          element = element.offsetParent;
      }
      return { x: xPosition, y: yPosition };
}



$(document).on("click", ".chip", function(event){
var $chip = $(this);

  event.preventDefault();
    index = $(this).attr("index");
    files_html = '';

    form_data = $("#events_template_loc").data('data-form')[parseInt(index)];
    files_html += get_files(form_data["event_id"]);
    card_content_temp = $('<div class="card-content"></div>');
    card_html = '<div class="card-header">\
                    <div class="card-icon" style="background:'+form_data["color"]+';"><span class="card-close"><img src="../assets/arrow-28-512.png"></span></div>\
                    <div class="card-title"><h2>'+form_data["title"]+'</h2><h3>'+form_data["origin_type"]+'</h3></div>\
                </div>\
                <div class="card-description">\
                    <div style="width:100%" title="Click to edit">\
                      Description: <br> <a href="#" id="edit_description">'+form_data["description"]+'</a>\
                      <div id="event_description_input" style="width:100%;display:none;">\
                        <div style="width:75%;float:left;">\
                          <textarea type="text" id="txt_desc" class="input_text" value="'+form_data["description"]+'"></textarea>\
                        </div>\
                        <div style="width:25%;float:right;">\
                          <button class="btn_update" id="btn_update_description">Update</button>\
                        </div>\
                      </div><br>\
                    </div><br>\
                    <div style="width:100%" title="Click to edit">\
                      Location: <br><a href="#" id="edit_location">'+form_data["location"]+'</a>\
                      <div id="edit_location_input" style="width:100%;display:none;">\
                        <div style="width:75%;float:left;">\
                          <textarea type="text" id="txt_loc" class="input_text" value="'+form_data["location"]+'"></textarea>\
                        </div>\
                        <div style="width:25%;float:right;">\
                          <button class="btn_update" id="btn_update_location">Update</button>\
                        </div>\
                      </div><br>\
                    </div>\
                  <div class="people-attending">'+get_people_attending(form_data["event_id"])+'</div>\
                </div>\
                <div class="card-upload">Materials <button id="btn_event_file_upload">Upload</button><button>Import from drive</button></div>';
    card_content = $(card_content_temp).html(card_html);

    if (!$($chip).hasClass('expanded')) {
        $($chip).addClass('expanded');

        //inactive
        $('.chip').not(this).animate({
          width: "5%"
        }).removeClass('expanded');
        $('.chip').not(this).children('.chip-top').animate({
          width: "100%",
          height: "264px"
        });
        $('.chip').not(this).children('.chip-bottom').css({
          "display": "none"
        });
        $('.chip').not(this).find('.month, .time').fadeOut();
        $('.chip').not(this).children('.card-content').detach();
        setTimeout(function(){
          $('.chip').not($chip).children('.collapse-info').fadeIn();
          $('.chip').not($chip).children('.collapse-date').fadeIn();
        }, 400);

        //active chip
        $($chip).animate({
          width: "81%"
        });
        $($chip).children('.chip-top').animate({
          width: "35%",
          height: "100%",
        });
        $($chip).children('.chip-bottom').css({
          "display": "none"
        });
        $($chip).find('.month, .time').fadeIn();
        setTimeout(function(){
          $($chip).append(card_content);
        }, 400);
        $($chip).children('.collapse-info').css({
          "display": "none"
        });
        $($chip).children('.collapse-date').css({
          "display": "none"
        });


    } else {
        
    }
});

$(document).on("click", "span.card-close", function(event){
  event.preventDefault();
  $chip = $(this).parents('.chip');
    $('.chip').animate({
      width: "24%"
    });
    $('.chip').children('.chip-top').animate({
      width: "100%",
      height: "200px"
    });
    $('.chip').children('.chip-bottom').css({
      "display": "block"
    });
    $('.chip').find('.month, .time').fadeIn();
    $('.chip').children('.collapse-info').css({
      "display": "none"
    });
    $('.chip').children('.collapse-date').css({
      "display": "none"
    });
    $($chip).children('.card-content').detach();
    setTimeout(function(){
      $($chip).removeClass('expanded');
    },400);
    
});

$(document).on("click", "#edit_description", function(event){
  event.preventDefault();
  $("#event_description_input").show();
  $(this).hide();
});


$(document).on("click", "#edit_location", function(event){
  event.preventDefault();
  $("#edit_location_input").show();
  $(this).hide();
});

$(document).on("click", "#btn_update_description", function(event) {
              $("#event_description_input").hide();
              desc_text_value = $("#txt_desc").val();
              desc_event_id = $("#card").attr("event_id");
              $.ajax({
                   url: "UpdateSyllabusEvent",
                   type: "POST",
                   data: {"id":desc_event_id,"description":desc_text_value},
                   success: function(response) {
                   },
                   error: function(jqXHR, textStatus, errorMessage) {
                       console.log(errorMessage); // Optional
                   }
              });
              $("#edit_description").html(desc_text_value);
              $("#edit_description").show("slow");
            });



$(document).on("click", "#btn_update_location", function(event){
              $("#edit_location_input").hide();
              location_text_value = $("#txt_loc").val();
              location_event_id = $("#card").attr("event_id");
              $.ajax({
                   url: "UpdateSyllabusEvent",
                   type: "POST",
                   data: {"id":location_event_id,"location":location_text_value},
                   success: function(response) {
                   },
                   error: function(jqXHR, textStatus, errorMessage) {
                       console.log(errorMessage); // Optional
                   }
              });
              $("#edit_location").html(location_text_value);
              $("#edit_location").show("slow")
            });

$(document).on("click",'#btn_event_file_upload', function(event){
        event.preventDefault();
        
        $("#event_file_upload").trigger("click");
});

$(document).on("change",'#event_file_upload', function(event){
        event.preventDefault();

        filevalue = $(this).val().split(".");
        file_length = filevalue.length;
            fd = new FormData();
            if ($('#event_file_upload')[0].files[0]){
            fd.append("file", $('#event_file_upload')[0].files[0]);
            fd.append("id", globals.origin_id);
            fd.append("event_id", $("#card").attr("event_id"))
            }
            $.ajax({
                       url: "EventFileUpload",
                       type: "POST",
                       data: fd,
                       processData: false,
                       contentType: false,
                       success: function(response) {
                        file_html = '<div style="width:100%;margin:5px;">\
                                        <a class="filename" href="'+globals.base_url+response["file_url"]+'" download>'+response["original_name"]+'</a>\
                                      </div>\
                                      <br>';
                        $("#materials_container").prepend(file_html);
                        /*response_data = $.parseJSON(response);*/
                         
                       },
                       error: function(jqXHR, textStatus, errorMessage) {
                           console.log(errorMessage); // Optional
                       }
                    });
});

function get_files(event_id){
  var resp = $.ajax({
                   url: "GetEventFiles",
                   type: "GET",
                   async: false,
                   data: {"id":event_id, "origin_id":globals.origin_id},
                   success: function(response) {

                   },
                   error: function(jqXHR, textStatus, errorMessage) {
                       console.log(errorMessage); // Optional
                   }
              });
  files_html = "";
   $.each($.parseJSON(resp.responseText), function(index, value){

                    files_html += '<div style="width:100%;margin:5px;">\
                                        <a class="filename" href="'+globals.base_url+value["file_url"]+'" download>'+value["original_name"]+'</a>\
                                   </div>\
                                   <br>';
                    });
   return files_html;
}

$(document).on("click", ".img_lt", function(event){
              $(".chip").each(function(){
                $(this).fadeOut({
                  queue: false,
                  duration: 'slow'
                }).animate({
                  right: "-100px"
                });
              });
              setTimeout(function(){
                var page_value = parseInt($("#events_template_loc").attr("current_page"));
                  $("#events_template_loc").attr("current_page", parseInt($("#events_template_loc").attr("current_page")) - 1);
                  show_left = "block";
                  if(page_value-1==0){
                  show_left = "none";
                  }
                  start = (page_value)*4;
                  events = $("#events_template_loc").data('data-form').slice(start-4,start);
                  list_events_left(events, show_left, "block", page_value-1, " Total events this semester");
              },200);
              
});

$(document).on("click", ".img_rt", function clicked_next(event){
              $(".chip").each(function(){
                $(this).fadeOut({
                  queue: false,
                  duration: 'slow'
                }).animate({
                  left: "-100px"
                });
              });
              setTimeout(function(){
                var page_value = parseInt($("#events_template_loc").attr("current_page"));
                  $("#events_template_loc").attr("current_page", parseInt($("#events_template_loc").attr("current_page")) + 1);
                  show_right = "block";
                  if(page_value+2==parseInt($("#events_template_loc").attr("pagecount"))){
                  show_right = "none";
                  }
                  start = (page_value+1)*4;
                  events = $("#events_template_loc").data('data-form').slice(start,start+4);
                  list_events(events, "block", show_right, page_value+1, " Total events this semester");
                },200);
              
});

var search_events = function(){
    var event_array_list = new Array();
    keyword = $("#txt_initial_search").val();
    var resp = $.ajax({
               url: "SearchEvents",
               type: "POST",
               data: {"origin_id":globals.origin_id, "keyword": keyword},
               async: false,
               success: function(response) {
                  $.each(response, function(index,value){
                    var d = new Date(value["start_date"]+" "+ value["start_time"]);
                    var dt = new Date(value["end_date"]+" "+ value["end_time"]);
                    if(d.getHours()!="0" && dt.getHours()!="0"){
                      time = "from "+formatAMPM(d)+" to "+formatAMPM(dt);
                    }
                    else if(d.getHours()!="0"){
                      time="@ " + formatAMPM(d);
                    }
                    else{
                      time="";
                    }
                    if(value["location"]==""){
                      event_location = "Add location";
                    }
                    else{
                      event_location = value["location"];
                    }
                    if(value["description"]==""){
                      description = "Add description";
                    }
                    else{
                      description = value["description"];
                    }
                    
                    var event_value ={
                      title: value["title"],
                      location: event_location,
                      description: description,
                      event_id: value["event_id"],
                      day: d.getDate(),
                      month: month[d.getMonth()],
                      event_id: value["event_id"],
                      time: time,
                      color: class_color,
                      origin_type: value["origin_type"],
                    };
                      event_array_list.push(event_value);
                   
                  });
               },
               error: function(jqXHR, textStatus, errorMessage) {
                   console.log(errorMessage); // Optional
               }
            });
    if(keyword==""){
      is_root = 1;
    }
    else{
      is_root = 0;
    }
    display_events(event_array_list, is_root);
    
};

function get_people_attending(event_id){
  console.log(event_id);
  var people_attending_html = "";
 var resp = $.ajax({
               url: "GetPeopleAttending",
               type: "POST",
               data: {"event_id":event_id},
               async: false,
               success: function(response) {
                $.each(response, function(index, value){
                    people_attending_html+='<div class="card-icon" title="'+value["firstname"]+" "+value["lastname"]+'" style="background-size: contain;background:url('+globals.base_url+value["file_url"]+');"></div>';
                });
               },
               error: function(jqXHR, textStatus, errorMessage) {
                   console.log(errorMessage); // Optional
               }
            });
 return people_attending_html;
}

$(document).on("click", "#_syllabus_tab", function(event){
  events_list = load_events(file_id);
  display_events(events_list, 1);
});