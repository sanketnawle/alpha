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
                        fd_store.append("class_id", globals.origin_id);

                        /*response_data = $.parseJSON(response);*/
                        $.ajax({
                                   url: "StoreSyllabus",
                                   type: "POST",
                                   data: fd_store,
                                   processData: false,
                                   contentType: false,
                                   success: function(response) {
                                      console.log(response);
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