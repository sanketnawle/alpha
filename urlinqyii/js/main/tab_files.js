
$(document).ready(function(){
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
        autoProcessQueue: false
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