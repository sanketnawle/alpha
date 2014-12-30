
$(document).ready(function(){



    init();

    function init(){
        //Get all the files for this class

        if(globals.origin_type == 'class'){
            get_files('class');
            get_files('student');
        }else if(globals.origin_type == 'club'){
            get_files('club');
        }




    }



    function show_files(files_list,files_list_class){
        //alert(JSON.stringify(files_list));
        for (i = 0; i < files_list.length; i++) {
            show_file(files_list[i],files_list_class);
        }
    }


    function show_file(file_json,files_list_class){

        var file_upload_date = utc_to_local(new Date(file_json['created_timestamp']));

        file_json['created_timestamp'] = file_upload_date.getFullYear() + '/' + (file_upload_date.getMonth() + 1) + '/' + file_upload_date.getDate();


        var source   = $("#file_template").html();
        var template = Handlebars.compile(source);
        var generated_html = template(file_json);
        $('.files_list.' + files_list_class).append(generated_html).hide().fadeIn();
    }


    function get_files(files_list_class){
        $.getJSON( globals.base_url + '/' + globals.origin_type + '/' + globals.origin_id + '/' + files_list_class + 'Files', function( json_data ) {
            console.log(json_data);
            if(json_data['success']){
                show_files(json_data['files'],files_list_class);
            }else{
                return [];
            }

        });
    }


    //Increase the download count for this file
    $(document).on('click','.filename', function(){
        var $file_name_a = $(this);
        var file_type = $file_name_a.attr('data-file_type');

        if(file_type != 'folder'){
            var file_id = $file_name_a.closest('.file').attr('data-file_id');
            console.log('Incrementing download count for file id: ' + file_id);


            var post_url = globals.base_url + '/file/incrementDownloadCount';


            var post_data = {file_id: file_id};
            $.post(
                post_url,
                post_data,
                function(response) {
                    if(response['success']){
                        $file_name_a.closest('.file').find('.viewcount').text(response['download_count']);
                        $file_name_a.closest('.file').attr('data-download_count',response['download_count']);
                    }else{
                        alert(JSON.stringify(response));
                    }
                }, 'json'
            );


        }
    });




	$('.files_subtab').click(function(){
        var $tab = $(this);
        var panel_id = $tab.attr('data-panel_id');
        //Change active tab
        $('.files_subtab.active').removeClass('active');
        $tab.addClass('active');


        //Find the current active panel and remove its active class
        $('.files_sub_panel.active').removeClass('active');
        $('#files_sub_panel_' + panel_id).addClass('active');


        //Clear the search input
        $('.files_search_input').val('');
    });

    //Returns the active file list. For classes, class files and students files are the two options
    //so the value could either be class or student
    function get_current_file_list_type(){
        return $('.files_sub_panel.active').find('.files_list').attr('data-file_list_type');
    }


    Dropzone.autoDiscover = false;

    var myDropzone = new Dropzone('.dropzone', {
        url: base_url + '/' + origin_type + '/fileUpload',
        autoProcessQueue: false,
        parallelUploads: 4,
        maxFilesize: 16,
        init: function() {
            this.on("success", function(file, response) {

                console.log('FILE NAME');
                console.log(response['original_name']);

                if(response['success']){

                    $('.files_upload_bigbox').css({'background':'#ddd'});
                    var $name = $("span[data-dz-name='']:contains('" + response['original_name'] + "')");
                    console.log($name);
                    $name.closest('.dz-preview').remove();

                    //Add the file to the list

                    if(globals.origin_type == 'class'){
                        if(globals.is_admin == 'true'){
                            show_file(response,globals.admin_file_panel_class);
                            //Make sure the admin file tab is active
                            $('.files_sub_panel.active').removeClass('active');
                            $(".files_sub_panel[data-file_list_type='" + globals.admin_file_panel_class + "']").addClass('active');


                            //Active the tab as well
                            $('.files_subtab.active').removeClass('active');
                            $(".files_subtab[data-file_list_type='" + globals.admin_file_panel_class + "']").addClass('active');
                        }else{
                            show_file(response,'student');
                            //Make sure the class file tab is active
                            $('.files_sub_panel.active').removeClass('active');
                            $('.files_sub_panel[data-file_list_type="student"]').addClass('active');


                            //Active the tab as well
                            $('.files_subtab.active').removeClass('active');
                            $(".files_subtab[data-file_list_type='student']").addClass('active');
                        }
                    }else if(globals.origin_type == 'club'){
                        show_file(response,'club');
                    }
                }


                if($('.dz-preview').length == 0){
                    $('.bigbox_bigmessage').fadeIn();
                }
                console.log(response['success']);
            });
        }
    });


    $('.file_search_input').keyup(function(){

        var $people_search_input = $(this);
        var search_string = $people_search_input.val();



        search_string = search_string.toLowerCase();
        console.log(search_string);



        if(search_string !== ''){
            console.log($('.files_sub_panel.active').find(".files_list"));
            $('.files_sub_panel.active').find(".files_list").children('li').each(function () {

                var $item = $(this);
                $item.show();
                if($item.data('name').toLowerCase().indexOf(search_string) == -1){
                    $item.hide();
                }
            });
        }else{
            $('.files_sub_panel.active').find(".files_list").children('li').each(function () {
                var $item = $(this);
                console.log($item);
                $item.show();
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

        }else if(file['name'].indexOf('.jpg') < 0 && file['name'].indexOf('.png') < 0 && file['name'].indexOf('.gif') < 0){
            //Check if the image background is alread set
            console.log('background-image');
            console.log($img.css('background-image'));

            console.log(typeof($img.css('background-image')));
            if($img.css('background-image') == 'none'){
                $img.css('background-image', 'url("' + base_url + "/assets/file_icons/file_type_na.png" + '")');
            }
        }

        //$("span[data-dz-name='']:contains('.docx')");


        //<span data-dz-name="">Alex_Lopez_resume.docx</span>

    });

    myDropzone.on("dragenter", function(file) {
        console.log('ENTER');
        $('.files_upload_bigbox').css({'background':'red'});

    });

    myDropzone.on("dragleave", function(file) {
        console.log('LEAVE');
        $('.files_upload_bigbox').css({'background':'#ddd'});
    });

    myDropzone.on("drop", function(file) {
        console.log('DROP');
        $('.files_upload_bigbox').css({'background':'#ddd'});
    });


    $('.dropzone').submit(function(event){
        event.preventDefault();
        myDropzone.processQueue();
        console.log("SUBMIT");
    });

    $(document).on('click','#upload_text_button', function(){
        //activate the dropzone file prompt
        $('.dropzone').click();
    });



   //HANDLE THE SORTING OF FILES


    $(document).on('click','#name_sorter', function(){
        sort_files_by_name();
    });

    last_sort = '';

    //Sorts the current active files by name
    function sort_files_by_name(){
        if(last_sort == 'name'){
            $('.files_sub_panel.active').find(".files_list").children('li').sort(dec_sort).appendTo($('.files_sub_panel.active').find(".files_list"));
            last_sort = '';
        }else{
            $('.files_sub_panel.active').find(".files_list").children('li').sort(asc_sort).appendTo($('.files_sub_panel.active').find(".files_list"));
            last_sort = 'name';
        }


        function asc_sort(a, b){
            return ($(b).attr('data-name')) < ($(a).attr('data-name')) ? 1 : -1;
        }

        function dec_sort(a, b){
            return ($(b).attr('data-name')) > ($(a).attr('data-name')) ? 1 : -1;
        }

    }

    //SORT BY TYPE

    $(document).on('click','#kind_sorter', function(){
        sort_files_by_type();
    });

    last_sort = '';

    //Sorts the current active files by name
    function sort_files_by_type(){
        if(last_sort == 'type'){
            $('.files_sub_panel.active').find(".files_list").children('li').sort(dec_sort).appendTo($('.files_sub_panel.active').find(".files_list"));
            last_sort = '';
        }else{
            $('.files_sub_panel.active').find(".files_list").children('li').sort(asc_sort).appendTo($('.files_sub_panel.active').find(".files_list"));
            last_sort = 'type';
        }

        function asc_sort(a, b){
            return ($(b).attr('data-file_type')) < ($(a).attr('data-file_type')) ? 1 : -1;
        }

        function dec_sort(a, b){
            return ($(b).attr('data-file_type')) > ($(a).attr('data-file_type')) ? 1 : -1;
        }

    }



    //SORT BY DOWNLOAD COUNT

    $(document).on('click','#views_sorter', function(){
        sort_files_by_download_count();
    });

    last_sort = '';

    //Sorts the current active files by name
    function sort_files_by_download_count(){
        if(last_sort == 'download_count'){
            $('.files_sub_panel.active').find(".files_list").children('li').sort(dec_sort).appendTo($('.files_sub_panel.active').find(".files_list"));
            last_sort = '';
        }else{
            $('.files_sub_panel.active').find(".files_list").children('li').sort(asc_sort).appendTo($('.files_sub_panel.active').find(".files_list"));
            last_sort = 'download_count';
        }

        function asc_sort(a, b){
            return (parseInt($(b).attr('data-download_count'))) < (parseInt($(a).attr('data-download_count'))) ? 1 : -1;
        }

        function dec_sort(a, b){
            return (parseInt($(b).attr('data-download_count'))) > (parseInt($(a).attr('data-download_count'))) ? 1 : -1;
        }

    }



    //SORT BY DATE

    $(document).on('click','#date_sorter', function(){
        sort_files_by_date();
    });

    last_sort = '';

    //Sorts the current active files by name
    function sort_files_by_date(){
        if(last_sort == 'date'){
            $('.files_sub_panel.active').find(".files_list").children('li').sort(dec_sort).appendTo($('.files_sub_panel.active').find(".files_list"));
            last_sort = '';
        }else{
            $('.files_sub_panel.active').find(".files_list").children('li').sort(asc_sort).appendTo($('.files_sub_panel.active').find(".files_list"));
            last_sort = 'date';
        }

        function asc_sort(a, b){
            return (new Date($(b).attr('data-date'))) < new Date(($(a).attr('data-date'))) ? 1 : -1;
        }

        function dec_sort(a, b){
            return (new Date($(b).attr('data-date'))) > (new Date($(a).attr('data-date'))) ? 1 : -1;
        }

    }



    //DELETE FILE - ONLY FOR ADMINS


    $(document).on('click','.remove_file_div', function(){
        var $remove_file_div = $(this);
        var $file = $remove_file_div.closest('.file');
        var file_id = $file.attr('data-file_id');

        alert(file_id);

    });






});