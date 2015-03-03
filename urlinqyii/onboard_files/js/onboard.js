


$(document).ready(function () {



    Handlebars.registerHelper('ifCond', function (v1, operator, v2, options) {

        switch (operator) {
            case '==':
                return (v1 == v2) ? options.fn(this) : options.inverse(this);
            case '===':
                return (v1 === v2) ? options.fn(this) : options.inverse(this);
            case '<':
                return (v1 < v2) ? options.fn(this) : options.inverse(this);
            case '<=':
                return (v1 <= v2) ? options.fn(this) : options.inverse(this);
            case '>':
                return (v1 > v2) ? options.fn(this) : options.inverse(this);
            case '>=':
                return (v1 >= v2) ? options.fn(this) : options.inverse(this);
            case '&&':
                return (v1 && v2) ? options.fn(this) : options.inverse(this);
            case '||':
                return (v1 || v2) ? options.fn(this) : options.inverse(this);
            case '!=':
                return (v1 != v2) ? options.fn(this) : options.inverse(this);
            default:
                return options.inverse(this);
        }
    });

    /*if authority is professor, let progress flag to be 2, first two step is redundant for professor*/


    var progress_flag = 0;


    //If the onboarding step was set by the php,
    //go to that step at the start
    if(onboarding_step > -1){
        progress_flag = onboarding_step;
    }

    var progress_bar = ["14%", "28%", "43%", "57%", "71%", "86%", "100%"];
    var btn_text = ["Join your School", "Join your Major/Department","", "Continue", "Continue", "Continue", "Let's Get Started"];
    var hint_text = ["Select your School", "Select your Major/Department", "Verify .edu Email", "Sign up for Courses - Pick your Section", "Who inspires you on campus?", "Find your Group", "Add a Photo"];
    var progress_bar_color = ["rgb(186, 81, 228)", "#009ed3", "rgb(110, 56, 169)", "rgb(0, 173, 61)", "rgb(242, 110, 0)", "#ec3856", "rgb(39, 178, 78)"];

    var canvas_hint = ["", "", "", "Here are some of the most popular classes in your department.", "Share your notes, take part in discussions, and see what they are up to.", "These are some of the most active clubs at your school.", ""];


    var searchbar_hint = ["Search schools", "Search departments", "", "Search all classes", "Search people", "Search clubs", ""];

    /*the following lists should be retreived from php*/
    var school_list = [];


    original_course_list = [];




    var selected_data = {'clubs':[], 'classes':[], 'follow_users':[], 'gender':'','picture_file_id':'1'};

    var professor_classes = [];
    init();


    function init(){

        if(progress_flag == 3){


//            var $canvas = $('.progress_content');





            function get_course_data(){
                //Load the course/class data before initializing
                $.getJSON(base_url + '/department/getCourses?department_id=' + department_id.toString(),function(json_data){
                    if(json_data['success']){
                        course_list = json_data['courses'];
                        original_course_list = course_list;
                        start_onboarding();
                    }else{
                        alert('Error getting school data');
                    }
                });
            }


            get_course_data();


        }else if(progress_flag == 2){
            //If the flag starts at 2, send a verification email
            send_verification_email();
        }
        else{
            //Get university id based on email function call will be here in the future
            //When there are multiple univs
            var university_id = '1';
            //Get the schools at this university then start onboarding
            $.getJSON(base_url + '/university/getSchools?university_id=1',function(json_data){
                if(json_data['success']){
                    school_list = json_data['schools'];
                    start_onboarding();
                }else{
                    alert('Error getting school data');
                }
            });
        }


    }


    function start_onboarding(){
        /*initialize*/
        progress_check(progress_flag);
        content_paint(progress_flag);
    }


    function progress_check(curr) {
        var w = progress_bar[curr];
        var b = progress_bar_color[curr];
        $(".progress").css({ width: w, backgroundColor: b });
        $(".next_progress").text(btn_text[curr]);


        if ((progress_flag == 0) || (progress_flag == 1) || (progress_flag == 2) || (progress_flag == 6)) {
            $(".next_progress").removeClass("inactive_btn");
        } else {
            $(".next_progress").addClass("inactive_btn");
        }



        $(".onboard_textarea_t1").prop("placeholder", searchbar_hint[curr]);
        $(".onboard_textarea_t1").show();
        $(".progress_footer_glyph_0").show();

        if (curr == 6) {
            $(".next_progress").append("<div class='btn_glyph_0'></div>");
            $(".onboard_textarea_t1").hide();
            $(".progress_footer_glyph_0").hide();
        }

        if (curr <= 2) {
            $(".skip_progress").hide();
            $(".full_skip").hide();
        } else {
            if (curr != 6) {
                $(".skip_progress").show();
                $(".full_skip").show();
            } else {
                $(".skip_progress").hide();
                $(".full_skip").hide();
            }
        }

        if (curr == 2) {
            $(".onboard_textarea_t1").hide();
            $(".progress_footer_glyph_0").hide();
            $(".next_progress").addClass("hide");
        }

        if (curr == 3) {
            $(".next_progress").addClass("step_3_adjust");
        } else{
            $(".next_progress").removeClass("step_3_adjust");
        }

        if (curr < 2) {
            $(".next_progress").hide();
            $(".onboard_textarea_t1").addClass("onboard_textarea_t2");
            $(".progress_footer_glyph_0").addClass("progress_footer_glyph_1");
        } else {
            $(".next_progress").show();
            $(".onboard_textarea_t1").removeClass("onboard_textarea_t2");
            $(".progress_footer_glyph_0").removeClass("progress_footer_glyph_1");
        }


        $(".progress_hint_0").text(hint_text[curr]);
        var curr_act = parseInt(curr) + 1;
        if(curr == 3 || curr == 4 || curr == 5){
            $(".progress_hint_1").show();
            $(".progress_hint_1").html("Step <span class='curr_step'>" + curr_act + "</span> of <span>7</span>");
        }
        if (curr == 6) { $(".progress_hint_1").html("Last Step"); };

        if (curr == 6) {
            $(".next_progress").addClass("last_step_btn");
        } else {
            $(".next_progress").removeClass("last_step_btn");
        }

        if ((curr != 0) && (curr != 3) && (curr != 2)) { $(".progress_goback").show(); } else { $(".progress_goback").hide(); }

        //if ((curr!=0)&&(curr!=3))
    }

    $(".content_inner").slimScroll({ wrapperClass: "scroll-wrapper", barClass: "scroll-bar", railVisible: true, touchScrollStep: "140",size:"10px" });

    function content_paint(curr) {
        var $canvas = $(".content_canvas");

        $canvas.show();
        $canvas.empty();

        $inner = $(".content_inner");
        $frame = $(".progress_content");

        $canvas.removeClass("canvas_adjust");
        $inner.removeClass("canvas_adjust");
        $frame.removeClass().addClass("progress_content c" + curr);




        //Clear the search box
        $('.onboard_textarea_t1').val('');

        $inner[0].scrollTop = 0;


         $('.skip_progress').show();
         $(".full_skip").show();
         $(".canvas_banner").remove();

        console.log("CURR " + curr.toString());

        if (curr == 0) {
            console.log('inside curr = 0');



            for(i = 0; i < school_list.length; i++){

                school_list[i]['base_url'] = base_url;

                var source   = $("#school_template").html();
                var template = Handlebars.compile(source);
                var generated_html = template(school_list[i]);

                var $stepCard = $(generated_html);

                $canvas.append($stepCard).hide().fadeIn();
            }

            $('.skip_progress').hide();
            $(".full_skip").hide();


        }else if (curr == 1) {
            console.log('inside curr = 1');


            for(i = 0; i < department_list.length; i++){

                department_list[i]['base_url'] = base_url;

                var source   = $("#department_template").html();
                var template = Handlebars.compile(source);
                var generated_html = template(department_list[i]);

                var $stepCard = $(generated_html);

                $canvas.append($stepCard).hide().fadeIn();
            }

            $('.skip_progress').hide();
            $(".full_skip").hide();


        } else if (curr == 2) {
            $canvas.append("<div class='step_2_card'><a href = 'http://mail.google.com/a/nyu.edu'><h1>Check your email</h1></a><p>We sent you a confirmation email with a link to get you started on Urlinq.</p><img src='" + base_url + "/onboard_files/img/EmailConfirmIcon.png'><p class = 'confirm_link_wrapper'><span>Please confirm your email address</span><a href = 'http://mail.google.com/a/nyu.edu' class = 'confirm_links'>Check your inbox.</a><a class = 'next_progress confirm_links'>Resend email</a></p></div>");
            $('.skip_progress').hide();
            $(".full_skip").hide();
        } else if (curr == 3) {
            $canvas.show();
            $canvas.addClass("canvas_adjust");
            $inner.addClass("canvas_adjust");

            //hide skp button
            //$('.skip_progress').hide();


            $canvas.prepend("<div class='canvas_banner'><div class='left_txt'>" + canvas_hint[progress_flag] + "</div><div class='right_txt'><span>0</span> selected</div></div>");



            //If this user is a professor, check to see if we have any classes for them
            if(user_type == 'p'){
                $.getJSON(base_url + '/user/getClassesProfessor', function(json_data){
                    if(json_data['success']){
                        professor_classes = json_data['classes'];


                        for(var i = 0; i < professor_classes.length; i++){

                            professor_classes[i]['base_url'] = base_url;

                            var source   = $("#professor_class_template").html();
                            var template = Handlebars.compile(source);
                            var generated_html = template(professor_classes[i]);

                            var $professor_class = $(generated_html);

//                            alert(generated_html);

                            $canvas.prepend($professor_class);
                        }

                        if(professor_classes.length != 0){
                            $canvas.prepend($("<div id='professor_classes_label'>According to our records, you teach these classes: </div>"));
                        }else{
                            //$canvas.prepend($("<div id='professor_classes_label'></div>"));
                        }

                    }else{
                        alert('Error getting school data');
                    }
                });
            }



            $canvas.append("<div class='a_thread' id='thread_0'></div><div class='a_thread' id='thread_1'></div>");

            render_courses();

        }else if (curr == 4) {
            $('.skip_progress').show();
            $(".full_skip").show();
            $canvas.addClass("canvas_adjust");
            $inner.addClass("canvas_adjust");
            $frame.prepend("<div class='canvas_banner'><div class='left_txt'>" + canvas_hint[curr] + "</div><div class='right_txt right_txt_adjust'><span class='follow_all_btn'>Follow All</span></div></div>");

            $canvas.append("<div class='a_thread' id='thread_0'></div><div class='a_thread' id='thread_1'></div>");

            $thread0 = $("#thread_0");
            $thread1 = $("#thread_1");

            var ns = people_list.length;
            for (var i = 0; i < ns; i++) {
                if (i % 2 == 0) {
                    $tthread = $thread0;
                } else {
                    $tthread = $thread1;
                }
                var picture_url;
                if(people_list[i]['pictureFile']){
                    picture_url = base_url + people_list[i]['pictureFile']['file_url'];
                }else{
                    picture_url = base_url + "/onboard_files/img/defaultGlyph.png";
                }
                $tthread.append("<div class='step_4_card' data-user_name='" + people_list[i]['firstname'] + ' ' + people_list[i]['lastname'] + "' data-user_id='" + people_list[i]['user_id'].toString() + "'><div class='card_4_glyph' style='background-image:url(\"" + picture_url + "\")'></div><div class='card_4_txt'>" + people_list[i]['firstname'] + ' ' + people_list[i]['lastname'] + "</div><div class='follow_btn card_4_btn'><em class = 'follow_icon'></em><span>Follow</span></div></div>");

            }

        }else if (curr == 5) {

            $canvas.addClass("canvas_adjust");
            $inner.addClass("canvas_adjust");
            $('.skip_progress').show();
            $(".full_skip").show();
            $frame.prepend("<div class='canvas_banner'><div class='left_txt'>" + canvas_hint[curr] + "</div><div class='right_txt'><span>0</span> joined</div></div>");


            $canvas.append("<div class='a_thread' id='thread_0'></div><div class='a_thread' id='thread_1'></div>");

            $thread0 = $("#thread_0");
            $thread1 = $("#thread_1");

            var ns = clubs_list.length;
            for (var i = 0; i < ns; i++) {

                if (i % 2 == 0) {
                    $tthread = $thread0;
                } else {
                    $tthread = $thread1;
                }
                var picture_url;
                if(clubs_list[i]['picture_file_id']){
                    picture_url = base_url + clubs_list[i]['pictureFile']['file_url'];
                }else{
                    picture_url = base_url + "/onboard_files/img/defaultGlyph.png";
                }
                $tthread.append("<div class='step_3_card step_5_card' data-group_id='" + clubs_list[i]['group_id'] + "'><div class='step_3_show'><img class='card_3_glyph' src='"+picture_url+"'><div class='step_3_line_0 club_adjust'>" + clubs_list[i]['group_name'] + "</div><div class='step_3_line_1 club_adjust'> <div class='member_glyph'></div><div class='step_3_line_1_1'><span></span></div></div> <div class='club_join gray_join_btn'><em class = 'gray_plus_icon'></em>Join</div></div></div>");
            }


            if(clubs_list.length == 0){
                $('.next_progress').removeClass('inactive_btn');
            }

        }else if (curr == 6) {
            $('.skip_progress').hide();
            $(".full_skip").hide();

            var data = {base_url: base_url, user_type: user_type};


            var source   = $("#last_panel_template").html();
            var template = Handlebars.compile(source);
            var generated_html = template(data);

            var $content = $(generated_html);

            $canvas.append($content).hide().fadeIn();

//            if(user_type == 's'){
//                $canvas.append("<div class='step_6_card'><div class='step_6_card_r0'><img class='card_6_glyph' src='" + base_url + "/onboard_files/img/defaultGlyph.png'><div class='pt_upload_btn gray_btn'>Upload Profile Picture</div><form><input type='file' class='step_6_upload' style='display:none;'></form></div> </div></div></div>   <div class='step_6_card_r4'><div class='step_6_card_r4_txt'>Gender</div><input class='step_6_card_r4_input' type='radio' name='gender' value='M'><span>Male</span> <input class='step_6_card_r4_input' type='radio' name='gender'  value='F'><span>Female</span></div>");
//            }else if(user_type == 'p' || user_type == 'a'){
//                $canvas.append("<div class='step_6_card'><div class='step_6_card_r0'><img class='card_6_glyph' src='" + base_url + "/onboard_files/img/defaultGlyph.png'><div class='pt_upload_btn gray_btn'>Upload Profile Picture</div><form><input type='file' class='step_6_upload' style='display:none;'></form></div><div class='step_6_card_r1'><div class='step_6_card_r1_txt'>Faculty Type</div><div class='ui dropdown step_6_card_r1_choice'><div class='text'>Professor</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='option1'>Professor</div><div class='item' data-value='option2'>Administrator</div></div></div></div> <div class='step_6_card_r2'><div class='step_6_card_r2_txt'>Office Location</div><input type='text' class='ol onboard_textarea_t0'/></div> <div class='step_6_card_r3'><div class='step_6_card_r3_txt'>Research Interests</div><input type='text' class='as onboard_textarea_t0'/></div> <div class='step_6_card_r4'><div class='step_6_card_r4_txt'>Gender</div><input class='step_6_card_r4_input' type='radio' name='gender' value='M'><span>Male</span> <input class='step_6_card_r4_input' type='radio' name='gender' value='F'><span>Female</span></div>");
//            }

            $canvas.find(".ui.dropdown").dropdown();
        }

    }

    function is_active_btn(btn) {
        if (btn.hasClass("inactive_btn")) {
            return false;
        } else {
            return true;
        }
    }



    function render_courses(){
            $thread0 = $("#thread_0");


            //Only remove the classes that arent expanded and selected
            $thread0.find('.step_3_card').each(function(){
                if(!$(this).hasClass('expanded')){
                    $(this).remove();
                }
            });


            $thread1 = $("#thread_1");

            $thread1.find('.step_3_card').each(function(){
                if(!$(this).hasClass('expanded')){
                    $(this).remove();
                }
            });



            var ns = course_list.length;
            for (var i = 0; i < ns; i++) {

                if (i % 2 == 0) {
                    $tthread = $thread0;
                } else {
                    $tthread = $thread1;
                }

                var classes = course_list[i]['classes'];
                var cs = classes.length;


                course_list[i]['class_count'] = cs;
                course_list[i]['base_url'] = base_url;

                var id_from_php = course_list[i]['course_id'];

                var source   = $("#step_3_template").html();
                var template = Handlebars.compile(source);
                var generated_html = template(course_list[i]);

                var $card = $(generated_html);

                $tthread.append($card).hide().fadeIn();


                var $expand = $("#course_" + id_from_php).find(".step_3_card_section_detail");

                var sub_source   = $("#step_3_sub_template").html();
                for (var j = 0; j < classes.length; j++) {
                    var sub_template = Handlebars.compile(sub_source);
                    var sub_generated_html = sub_template(classes[j]);

                    var $sub_card = $(sub_generated_html);
                    $expand.append($sub_card);
                }
            }

    }




    $(document).on('click','.last_step_btn',function(e){

        //alert(JSON.stringify(selected_data));

        console.log(selected_data);

        var $this_btn = $(this);


        e.stopPropagation();

        var gender = $('input[name=gender]:checked').val();
        if(!gender){
            gender = null;
        }
        //Check if gender is null
        /*if(!gender){
            alert('Please select a gender');
            return;
        }*/

        /*
        if(selected_data["classes"].length == 0){
            if(user_type == 'p'){
                if(professor_classes.length == 0){
                    alert('Please select at least one class');
                }else{
                    selected_data['classes'] = null;
                }
            }else if(user_type == 's'){
                alert('Please select at least one class');
                return;
            }
        }
        */


        if(selected_data['classes'].length == 0){
            selected_data['classes'] = null;
        }
        if(selected_data['clubs'].length == 0){
            selected_data['clubs'] = null;
        }

        if(selected_data['follow_users'].length == 0){
            selected_data['follow_users'] = null;
        }




        $this_btn.addClass('inactive_btn');

        if(user_type == 'a' || user_type == 'p'){
            //Get office hours/location and research interests

            selected_data['admin_type'] = $('#admin_type_menu').attr('data-value');

            selected_data['office_hours'] = $('#office_hours_input').val();

            selected_data['office_location'] = $('#office_location_input').val();
            selected_data['research_interests'] = $('#research_interests_input').val();
        }else{
            //Get graduation date
            selected_data['graduation_date'] = $('#graduation_date_menu').attr('data-value')


        }

        var picture_file_id = '1';


        var $profile_image_form = $('#profile_image_upload_form');



        var post_url = base_url + '/finishOnboarding';

        var post_data = selected_data;
        post_data['gender'] = gender;

        post_data['picture_file_id'] = picture_file_id;


        console.log(JSON.stringify(post_data));
        //alert(JSON.stringify(post_data));



        //If an image was dragged in, do this
        if($profile_image_form.children('div.dz-preview').length){
            lol.myDropzone.processQueue();


             lol.myDropzone.on('success',function(file, response){
                $profile_image_form.attr('data-file_id', response['file_id']);
                post_data['picture_file_id'] = response['file_id'];


                send_finish_onboarding_post_request();
            });

        }else{
            send_finish_onboarding_post_request();
        }







        function send_finish_onboarding_post_request(){

             //alert(JSON.stringify(selected_data));

             $.post(
                post_url,
                post_data,
                function(response) {
                    if(response['success']){
                        window.location.href = base_url + '/home';
                    }else{
                        $this_btn.removeClass('inactive_btn');
                        alert(JSON.stringify(response));
                    }
                }, 'json'
            );
        }


    });





    //Time inbetween each verification email request
    var email_time = 15000; //15 seconds between each allowed resend


    function change_to_user_follow_panel(){
        selected_data['classes'] = [];
        $('.step_3_card_section_detail_card.section_selected').each(function(){
            var class_id = $(this).attr('data-class_id');
            selected_data['classes'].push(class_id);
            //alert('PUSHING CLASS ID  ' + class_id);
        });


        $.getJSON(base_url + '/user/getSuggestedUsers',function(json_data){
            if(json_data['success']){
                people_list = json_data['users'];

                progress_flag++;
                progress_check(progress_flag);
                content_paint(progress_flag);
                return;
            }else{
                alert('Error getting suggested users data');
            }
        });
        console.log(JSON.stringify(selected_data));
    }



    function change_to_club_panel(){
        selected_data['follow_users'] = [];
        $('.card_4_btn.followed').each(function(){
            //alert('FOLLOWED USER ID ' + $(this).closest('.step_4_card').attr('data-user_id'));
            var user_id = $(this).closest('.step_4_card').attr('data-user_id');
            selected_data['follow_users'].push(user_id);
        });



        $.getJSON(base_url + '/school/getClubs?school_id=' + school_id,function(json_data){
            if(json_data['success']){
                clubs_list = json_data['clubs'];

                progress_flag++;
                progress_check(progress_flag);
                content_paint(progress_flag);
                return;
            }else{
                alert('Error getting suggested users data');
            }
        });
        console.log(JSON.stringify(selected_data));
    }

    var lol = {};
    lol.myDropzone = null;


    function change_to_last_panel(){

        selected_data['clubs'] = [];
        $('.club_join.followed').each(function(){
            var user_id = $(this).closest('.step_5_card').attr('data-group_id');
            selected_data['clubs'].push(user_id);

        });


        progress_flag++;
        progress_check(progress_flag);
        content_paint(progress_flag);

        console.log(JSON.stringify(selected_data));



        Dropzone.autoDiscover = false;

        lol.myDropzone = new Dropzone('.dropzone', {
            url: base_url + '/user/uploadProfileImage',
            autoProcessQueue: false,
            parallelUploads: 4,
            maxFilesize: 16,
            maxFiles: 1,
            acceptedFiles: ".jpeg,.jpg,.png,.gif,.JPEG,.JPG,.PNG,.GIF",
            maxfilesexceeded: function(file) {
                this.removeAllFiles();
                this.addFile(file);
            },
            init: function() {
                this.on("success", function(file, response) {

                    console.log('FILE NAME');
                    console.log(response['original_name']);

                    if(response['success']){
                        //alert('success');
                    }

                });
            }
        });
    }





    $(document).delegate(".next_progress", "click", function (evt) {
        evt.stopPropagation();
        evt.preventDefault();


        var $this_button = $(this);

        if (is_active_btn($(this))) {
            if(progress_flag == 2){
                if(!$this_button.hasClass('inactive_btn')){
                    $this_button.addClass('inactive_btn');
                    send_verification_email();


                    //Set can_send to true in email_time milliseconds
                    setTimeout(function(){
                        $this_button.removeClass('inactive_btn')
                    }, email_time);
                }else{
                    console.log('cannot send another email yet');
                }
            }
            else if(progress_flag == 3){
                change_to_user_follow_panel();
            }else if(progress_flag == 4){

                change_to_club_panel();


            }else if(progress_flag == 5){
                change_to_last_panel();
            }
//            else if (progress_flag < 6) {
//                progress_flag++;
//                progress_check(progress_flag);
//                content_paint(progress_flag);
//                return;
//            }
        }
    });

    $(document).delegate(".skip_progress", "click", function () {


        if(progress_flag == 3){
            change_to_user_follow_panel();
        }else if(progress_flag == 4){
            change_to_club_panel();
        }else if(progress_flag == 5){
            change_to_last_panel();
        }
        else if (progress_flag < 6) {
            progress_flag++;
            progress_check(progress_flag);
            content_paint(progress_flag);
        }
    });

    $(document).delegate(".full_skip", "click", function () {
        if(progress_flag>2){
            if(!selected_data['classes']){
                selected_data['classes'] = [];
            }
            if(!selected_data['clubs']){
                selected_data['clubs'] = [];
            }

            $(".next_progress").addClass("last_step_btn");
            $('.last_step_btn').click();
        }
    });


    $(document).delegate(".progress_goback", "click", function () {
        if ((progress_flag > 0) && (progress_flag != 3)) {

            if(progress_flag == 1){
                delete selected_data["school_id"];
                school_click_count = 0;
            }

            if(progress_flag == 4){
                delete selected_data["classes"];
            }

            progress_flag--;
            progress_check(progress_flag);
            content_paint(progress_flag);
        };
    });


    var school_click_count = 0;

    $(document).delegate(".school", "click", function (e) {

        //Prevent this from being clicked again
        if(school_click_count == 0){
            school_click_count++;
                //e.stopPropagation();
    //        e.preventDefault();
            var $self = $(this);

            var school_id = $self.attr('data-school_id');
            $.getJSON(base_url + '/school/getDepartments?school_id=' + school_id,function(json_data){
                if(json_data['success']){
                    selected_data['school_id'] = school_id;

                    department_list = json_data['departments'];
                    $(".step_0_card").addClass("left");
                    $self.removeClass("left");
                    setTimeout(function () {
                        $self.addClass("right");
                        progress_flag++;
                        progress_check(progress_flag);
                        content_paint(progress_flag);
                        return;
                    }, 250);

                }else{
                    alert('Error getting school data');
                }
            });
        }



    });



    function send_verification_email(payload_function){
        var post_url = base_url + '/sendVerificationEmail';
        var post_data = {school_id: selected_data['school_id'], department_id: selected_data['department_id']};
        $.post(
            post_url,
            post_data,
            function(response) {

                if(response['success']){
                    try{
                        payload_function();
                    }catch(err) {
                        console.log(err);
                        console.log("error calling payload function");
                    }

                    //alert(JSON.stringify(response));
                }else{
                    window.location.replace(base_url);
                }
            }, 'json'
        );
    }



    var department_click_count = 0;

    $(document).delegate(".department", "click", function (e) {
        e.stopPropagation();
        e.preventDefault();


        if(department_click_count == 0){
            department_click_count++;
            var $self = $(this);



            var department_id = $self.attr('data-department_id');
            selected_data['department_id'] = department_id;


            function run_this(){
                $(".step_0_card").addClass("left");
                $self.removeClass("left");
                setTimeout(function () {
                    $self.addClass("right");
                    progress_flag++;
                    progress_check(progress_flag);
                    content_paint(progress_flag);
                    return;
                }, 250);
            }

            send_verification_email(run_this);
        }



    });



    $(document).on('change', '.section_check', function(e) {
        console.log('CHANGE');

//        e.preventDefault();
//         if ($(this).is(":checked")) {
//             console.log('CHANGE FALSE');
//             $(this).prop('checked', false);
//         }else{
//             console.log('CHANGE TRUE');
//             $(this).prop('checked', true);
//         }
//



//        console.log('SECTION CHECK CLICK');
//        var $this_section_check = $(this);
//
//
//        if(user_type == 'p' && $this_section_check.closest('.step_3_card_section_detail_card').attr('data-professor_id') != ''){
//            $this_section_check.prop('checked', false);
//            $this_section_check.parent().removeClass('section_selected');
//
//
//            alert('There is already a professor for this class');
//            return;
//        }
//
//        console.log($this_section_check.prop("checked"));
//
//        if(this.checked && $this_section_check.parent().hasClass('section_selected')){
//
//            $this_section_check.prop('checked', false);
//            $this_section_check.parent().removeClass('section_selected');
//            return;
//        }
//
//
//        var $step_3_card = $this_section_check.closest('.step_3_card');
//
//        //Go through all the other checkboxes and uncheck them
//        $step_3_card.find('.section_check').each(function(){
//            $(this).prop('checked', false);
//            $(this).parent().removeClass('section_selected');
//        });
//
//
//
//        //$this_section_check.prop('checked', true);
//        $this_section_check.parent().addClass('section_selected');


    });



    $(document).on('click','.section_check', function(e){
//        e.preventDefault();
//        e.stopPropagation();



//                 console.log('CLICK');
//
//        console.log('SECTION CHECK CLICK');

//
//
//        if(user_type == 'p' && $this_section_check.closest('.step_3_card_section_detail_card').attr('data-professor_id') != ''){
//
//            $this_section_check.prop('checked', false);
//            $this_section_check.parent().removeClass('section_selected');
//
//
//            alert('There is already a professor for this class');
//            return;
//        }
//
////        //since the checkbox automatically checks before this function gets called
////        //, check if its NOT checked
//
//        console.log($this_section_check.prop("checked"));
//
//        if($this_section_check.is(":checked") && $this_section_check.parent().hasClass('section_selected')){
//            $this_section_check.prop('checked', false);
//            $this_section_check.parent().removeClass('section_selected');
//            return;
//        }
//
//

        var $this_section_check = $(this);
        var $step_3_card = $this_section_check.closest('.step_3_card');

        //Go through all the other checkboxes and uncheck them
        $step_3_card.find('.section_check').each(function(){
            if(!$(this).is($this_section_check)){
                $(this).prop('checked', false);
                $(this).parent().removeClass('section_selected');
            }

        });

//
//
//        $this_section_check.prop('checked', true);
//        $this_section_check.parent().addClass('section_selected');
//
////
//        $this_section_check.prop('checked', true);
//        $this_section_check.parent().addClass('section_selected');
//        //alert($this_section_check.parent().attr('data-class_id'));

    });

    $(document).delegate(".step_3_card", "mouseenter", function () {
        $(this).addClass("expanded_pseudo");
    });

    $(document).delegate(".step_3_card", "mouseleave", function () {
        $(this).removeClass("expanded_pseudo");
    });

    $(document).delegate(".step_3_show", "click", function () {

        if(!$(this).hasClass('professor_class')){
            if (!$(this).closest(".step_3_card").hasClass("step_5_card")) {
                if ($(this).closest(".step_3_card").hasClass("expanded")) {
                    $(this).closest(".step_3_card").removeClass("expanded");
                    $(this).closest(".step_3_card").find(".step_3_hide").hide();
                } else {
                    $(this).closest(".step_3_card").addClass("expanded");
                    $(this).closest(".step_3_card").find(".step_3_hide").show();
                }
            }
        }


    });

    $(document).delegate(".step_5_card", "click", function (e) {
        if (!$(e.target).hasClass("club_join")) {
            if (!$(this).hasClass("club_join")) {
                $(this).find(".club_join").get(0).click();
            }
        }
    });

    $(document).delegate(".section_detail_right", "click", function () {
        $(this).closest(".step_3_card_section_detail_card").find(".section_check").click();
    });

    $(document).delegate(".section_check", "change", function () {
        var n = parseInt($(".canvas_banner").find(".right_txt").find("span").text());

        if ($(this).closest(".step_3_card_section_detail_card").hasClass("section_selected")) {
            $(this).closest(".step_3_card_section_detail_card").removeClass("section_selected");
            n--;
            $(".canvas_banner").find(".right_txt").find("span").text(n);
        } else {
            $(this).closest(".step_3_card_section_detail_card").addClass("section_selected");
            n++;
            $(".canvas_banner").find(".right_txt").find("span").text(n);
        }

        if (n == 0) {
            $(".next_progress").addClass("inactive_btn");
        } else {
            $(".next_progress").removeClass("inactive_btn");
        }
    });

    var flw_n = 0;
    $(document).delegate(".card_4_btn", "click", function () {
        if ($(this).hasClass("followed")) {
            $(this).removeClass("followed");
            $(this).find("span").text("Follow");
            flw_n--;
        } else {
            $(this).addClass("followed");
            $(this).find("span").text("Following");
            flw_n++;
        }

        if (flw_n == 0) {
            $(".next_progress").addClass("inactive_btn");
        } else {
            $(".next_progress").removeClass("inactive_btn");
        }
    });

    $(document).delegate(".follow_all_btn", "click", function () {



        $(".card_4_btn").removeClass("followed");
        $(".card_4_btn").addClass("followed");
        $(".card_4_btn").find("span").text("Following");




        //Loop thru all the card 4 buttons and get the user id from the parent
        $(".card_4_btn").each(function(){
            selected_data['follow_users'].push($(this).closest('.step_4_card').attr('data-user_id'));
        });

        $('.next_progress').removeClass('inactive_btn');
    });

    $(document).delegate(".club_join", "click", function () {
        var n = parseInt($(".canvas_banner").find(".right_txt").find("span").text());
        if ($(this).hasClass("followed")) {
            $(this).removeClass("followed");
            $(this).text("Join");
            n--;
            $(".canvas_banner").find(".right_txt").find("span").text(n);
            $(this).closest(".step_5_card").removeClass("expanded");
        } else {
            $(this).addClass("followed");
            $(this).text("Member");
            n++;
            $(".canvas_banner").find(".right_txt").find("span").text(n);
            $(this).closest(".step_5_card").addClass("expanded");
        }

        if (n == 0) {
            $(".next_progress").addClass("inactive_btn");
        } else {
            $(".next_progress").removeClass("inactive_btn");
        }
    });

    $(document).delegate(".pt_upload_btn", "click", function () {
        $(this).closest(".step_6_card_r0").find(".step_6_upload").click();
    });



    $(document).on('keyup','.onboard_textarea_t0', function(){
        if(progress_flag == 0){
            var $school_input = $(this);
            var input_string = $school_input.val().toLowerCase();

            var $content_canvas = $('.content_canvas');

            if(input_string == ''){
                $content_canvas.children('div').each(function(){
                    var $child = $(this);
                    $child.show();
                });
            }else{
                $content_canvas.children('div').each(function(){
                    var $child = $(this);


                    if($child.attr('data-school_name').toLowerCase().indexOf(input_string) > -1){

                        console.log('school_name: ' + $child.attr('data-school_name') + '    input_string: ' + input_string);

                        $child.show();
                    }else{
                        $child.hide();
                    }
                });
            }
        }else if(progress_flag == 3){
            var $user_name_input = $(this);
            var input_string = $user_name_input.val().toLowerCase();

            var $content_canvas = $('.content_canvas');

            if(input_string == ''){
                course_list = original_course_list;
                render_courses();
//                $content_canvas.find('div.step_3_card').each(function(){
//                    var $child = $(this);
//                    $child.show();
//                });
            }else{


                setTimeout(function() {

                    if($('.onboard_textarea_t0').val().toLowerCase() == input_string){
                        //Search for classes with a name or tag similar to this
                        $.getJSON(base_url + '/search/courses?q=' + input_string, function(json_data){
                            if(json_data['success']){

                                if(json_data['results'].length == 0){
                                    course_list = original_course_list;
                                    render_courses();
                                }else{
                                    course_list = json_data['results'];
                                    render_courses();
                                }


                            }else{
                                console.log('Error getting courses data with seach query ' + input_string);
                            }
                        });
                    }

                }, 700);

                 // Check the value searched is the latest one or not. This will help in making the ajax call work when client stops writing.









//                $content_canvas.find('div.step_3_card').each(function(){
//                    var $child = $(this);
//
//                    if(!$child.hasClass('professor_class')){
//                        if($child.attr('data-course_name').toLowerCase().indexOf(input_string) > -1){
//
//                            console.log('course_name: ' + $child.attr('data-course_name') + '    input_string: ' + input_string);
//
//                            $child.show();
//                        }else{
//                            $child.hide();
//                        }
//                    }
//
//
//                });
            }
        }else if(progress_flag == 4){
            var $user_name_input = $(this);
            var input_string = $user_name_input.val().toLowerCase();

            var $content_canvas = $('.content_canvas');

            if(input_string == ''){
                $content_canvas.find('div.step_4_card').each(function(){
                    var $child = $(this);
                    $child.show();
                });
            }else{
                $content_canvas.find('div.step_4_card').each(function(){
                    var $child = $(this);


                    if($child.attr('data-user_name').toLowerCase().indexOf(input_string) > -1){

                        console.log('user_name: ' + $child.attr('data-user_name') + '    input_string: ' + input_string);

                        $child.show();
                    }else{
                        $child.hide();
                    }
                });
            }
        }else if(progress_flag == 5){
            var $club_name_input = $(this);
            var input_string = $club_name_input.val().toLowerCase();

            var $content_canvas = $('.content_canvas');

            if(input_string == ''){
                $content_canvas.find('div.step_5_card').each(function(){
                    var $child = $(this);
                    $child.show();
                });
            }else{
                $content_canvas.find('div.step_5_card').each(function(){
                    var $child = $(this);
                    var club_name = $child.find('div.step_3_line_0').text();

                    if(club_name.toLowerCase().indexOf(input_string) > -1){

                        console.log('club_name: ' + club_name + '    input_string: ' + input_string);

                        $child.show();
                    }else{
                        $child.hide();
                    }
                });
            }
        }
    });





    $(document).on('click','.item', function(){
        var $this_item = $(this);
        //Set this value as the menu selected value

        $this_item.closest('.menu').attr('data-value',$this_item.attr('data-value'));

    });



    $(document).on('keyup','.onboard_textarea_t1', function(){
        if(progress_flag == 1){
            var $department_input = $(this);
            var input_string = $department_input.val().toLowerCase();

            var $content_canvas = $('.content_canvas');

            if(input_string == ''){
                $content_canvas.children('div').each(function(){
                    var $child = $(this);
                    $child.show();
                });
            }else{
                $content_canvas.children('div').each(function(){
                    var $child = $(this);


                    if($child.attr('data-department_name').toLowerCase().indexOf(input_string) > -1){

                        console.log('department_name: ' + $child.attr('data-department_name') + '    input_string: ' + input_string);

                        $child.show();
                    }else{
                        $child.hide();
                    }
                });
            }
        }
    });

});