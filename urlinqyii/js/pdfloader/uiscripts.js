$(document).on("click",'#btn_add_syllabus', function(event){
        event.preventDefault();
        $("#syllabus_pdf_upload").trigger("click");
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
                                      run_pdf_algo(true);
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

var load_events = function () {
  $.ajax({
         url: "GetEvents",
         type: "GET",
         data: {"class_id":globals.origin_id},
         success: function(response) {
          $.each(response,function(index,value){
            var d = new Date(value["event_date"]);
            html_text='<div id="'+value["event_id"]+'" class = "syllabus_event editable">\
                    <div class = "day_month_box day_box_color">\
                        <div class = "calendar_top_border"></div>\
                        <div class = "calendar_bottom_section">\
                            <span class = "day">'+d.getDate()+'</span>\
                            <span class = "month">'+month[d.getMonth()]+'</span>\
                        </div>\
                    </div>\
                    <div class = "event_name_buttons">\
                        <span class ="event_name_text">\
                            Midterm 1\
                        </span>\
                        <input class = "syla_tab_event_editor" type = "text" name = "event_name" value="'+value["event_title"]+'"">\
                        <div class = "done_editing_button">\
                            Done\
                        </div>\
                    </div>\
                </div>';
            $('div#events_list').append(html_text);
          });
         },
         error: function(jqXHR, textStatus, errorMessage) {
             console.log(errorMessage); // Optional
         }
      });
};