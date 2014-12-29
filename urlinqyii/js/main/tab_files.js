
$(document).ready(function(){



    init();

    function init(){
        //Get all the files for this class
        get_files();
    }


    function show_files(files_list){
        //alert(JSON.stringify(files_list));
        for (i = 0; i < files_list.length; i++) {
            show_file(files_list[i]);
        }
    }


    function show_file(file_json){
        var source   = $("#file_template").html();
        var template = Handlebars.compile(source);
        var generated_html = template(file_json);
        $('.files_list').append(generated_html).hide().fadeIn();
    }


    function get_files(){
        $.getJSON( base_url + '/' + globals.origin_type + '/' + globals.origin_id + '/files', function( json_data ) {
            console.log(json_data);
            if(json_data['success']){
                show_files(json_data['files']);
            }else{
                return [];
            }

        });
    }




	$('.files_subtab').click(function(){
        var $tab = $(this);
        var panel_id = $tab.attr('data-panel_id');
        //Change active tab
        $('.files_subtab.active').removeClass('active');
        $tab.addClass('active');


        //Find the current active panel and remove its active class
        $('.files_sub_panel.active').removeClass('active');
        $('#files_sub_panel_' + panel_id).addClass('active');
    });


    Dropzone.autoDiscover = false;

    var myDropzone = new Dropzone('.dropzone', {
        url: base_url + '/class/fileUpload',
        autoProcessQueue: false,
        parallelUploads: 4,
        maxFilesize: 100,
        init: function() {
            this.on("success", function(file, response) {

                console.log('FILE NAME');
                console.log(response['original_name']);

                if(response['success']){
                    var $name = $("span[data-dz-name='']:contains('" + response['original_name'] + "')");
                    console.log($name);
                    $name.closest('.dz-preview').remove();

                    //Add the file to the list
                    show_file(response);
                }


                if($('.dz-preview').length == 0){
                    $('.bigbox_bigmessage').fadeIn();
                }
                console.log(response['success']);
            });
        }
    });


    myDropzone.on("addedfile", function(file) {
        $('.bigbox_bigmessage').fadeOut("fast");

        var $name = $("span[data-dz-name='']:contains('" + file['name'] + "')");
        var $img = $name.closest('.dz-details').find("img[data-dz-thumbnail='']");

        if(file['name'].indexOf('.docx') > -1){
            $img.css('background-image', 'url("' + base_url + "/assets/file_icons/file_type_doc.png" + '")');

        }else if(file['name'].indexOf('.pptx') > -1){
            $img.css('background-image', 'url("' + base_url + "/assets/file_icons/file_type_ppt.png" + '")');

        }else if(file['name'].indexOf('.pdf') > -1){
            $img.css('background-image', 'url("' + base_url + "/assets/file_icons/file_type_pdf.png" + '")');

        }else if(file['name'].indexOf('.xls') > -1){
            $img.css('background-image', 'url("' + base_url + "/assets/file_icons/file_type_xls.png" + '")');

        }else if(file['name'].indexOf('.zip') > -1){
            $img.css('background-image', 'url("' + base_url + "/assets/file_icons/file_type_zip.png" + '")');

        }else{
            //Check if the image background is alread set
            console.log('background-image');
            console.log($img.css('background-image'));

            console.log(typeof($img.css('background-image')));
            if($img.css('background-image') == 'none'){
                $img.css('background-image', 'url("' + base_url + "/assets/file_icons/file_type_none.png" + '")');
            }
        }

        //$("span[data-dz-name='']:contains('.docx')");


        //<span data-dz-name="">Alex_Lopez_resume.docx</span>

    });

    $('.dropzone').submit(function(event){
        event.preventDefault();
        myDropzone.processQueue();
        console.log("SUBMIT");
    });






//    Dropzone.options.class_upload_dropzone = { // The camelized version of the ID of the form element
//
//        // The configuration we've talked about above
//        autoProcessQueue: false,
//        uploadMultiple: true,
//        parallelUploads: 100,
//        maxFiles: 100,
//
//        // The setting up of the dropzone
//        init: function() {
//            var myDropzone = this;
//
//            // First change the button to actually tell Dropzone to process the queue.
//            this.element.querySelector("button[type=submit]").addEventListener("click", function(e) {
//                // Make sure that the form isn't actually being sent.
//                e.preventDefault();
//                e.stopPropagation();
//                myDropzone.processQueue();
//            });
//
//            // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
//            // of the sending event because uploadMultiple is set to true.
//            this.on("sendingmultiple", function() {
//                // Gets triggered when the form is actually being sent.
//                // Hide the success button or the complete form.
//            });
//            this.on("successmultiple", function(files, response) {
//                // Gets triggered when the files have successfully been sent.
//                // Redirect user or notify of success.
//            });
//            this.on("errormultiple", function(files, response) {
//                // Gets triggered when there was an error sending the files.
//                // Maybe show form again, and notify user of error
//            });
//        }
//
//    }




});