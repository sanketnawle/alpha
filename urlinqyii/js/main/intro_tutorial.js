$(document).ready(function(){
    var already_clicked=false;

	$('#tutorial_starter').click(function(){
        var $tutorial_starter_button = $(this);
        $tutorial_starter_button.addClass("tutorial_started");

		setTimeout(function() {

            if(!already_clicked){
                $(".pulse_tp_0").show();
                $(".pulse_tp_0").css({'opacity':'1'});
            }

            //$(".intro_div_1").pulse($(".pulse_tp_0"),{x:10,y:10});

            var promptHeader1=["Your Account Menu","Your Account Menu"];
            var promptHeader2 = ["Planner","Planner"];
            var promptHeader3 = ["Collaboration Bar","Collaboration Bar"];
            var promptContent=["On your account menu you can edit your profile and account settings, change your online status, and set preferences for things like notifications, message display settings, and more.","This is the final step prompt"];
            var footer= "<p>Seen this before? <a>Opt out of these tips</a></p>";

            if($tutorial_starter_button.hasClass('show_profile_tutorial')) {
                $(".intro_div_1").addClass('show_tutorial');
                $(".intro_div_1").tooltip({
                    x: 274,
                    y: -243,
                    promptHeader: promptHeader1,
                    promptContent: promptContent,
                    footer: footer,
                    wedge: 'left'
                });
            }
            if($tutorial_starter_button.hasClass('show_planner_tutorial')){
                $(".intro_div_2").addClass('show_tutorial');
                $(".intro_div_2").tooltip({x:-525, y:-300, promptHeader: promptHeader2, promptContent: promptContent, footer:footer, wedge:'right'});
            }
            if($tutorial_starter_button.hasClass('show_fbar_tutorial')){
                $(".intro_div_3").addClass('show_tutorial');
                $(".intro_div_3").tooltip({x:12, y:23, promptHeader: promptHeader3, promptContent: promptContent, footer:footer, wedge:'top'});
            }
            $(".intro_div.show_tutorial").pulse($(".pulse_tp_0"),{x:10,y:10});
            if(already_clicked){
                $(".pulse_tp_0").fadeIn(150);
                $(".pulse_tp_0").css({'opacity':'1'});
            }

        }, 200);




	});
    if((!$('#tutorial_starter').hasClass('show_profile_tutorial')||
        !$('#tutorial_starter').hasClass('show_planner_tutorial')||
        !$('#tutorial_starter').hasClass('show_fbar_tutorial'))&&
        ($('#tutorial_starter').hasClass('show_profile_tutorial')||
        $('#tutorial_starter').hasClass('show_planner_tutorial')||
        $('#tutorial_starter').hasClass('show_fbar_tutorial'))){
        already_clicked=true;
        $('#tutorial_starter').click();
    }
	$(".intro_div").click(function(){
        if($('#tutorial_starter').hasClass('tutorial_started')){
            $(this).find(".pulse_tp_0").fadeOut(300);
            $(this).removeClass("intro_div");
            var tutorial_num;
            if($(this).hasClass("intro_div_1")){
                tutorial_num = 1;
            }else if($(this).hasClass("intro_div_2")){
                tutorial_num = 2;
            }else if($(this).hasClass("intro_div_3")){
                tutorial_num = 3;
            }
            $.post(globals.base_url+'/completeTutorial',{tutorial_num:tutorial_num});
        }

	});

    $(document).on('click','.post_submit_edit_profile',function(){
        var $submit_button = $(this);
        var post_data = {};
        if($('.post_major_input').length && $.trim($('.post_major_input').val()) != ''){
            post_data.majors =[$.trim($('.post_major_input').val())];
        }
        if($('.post_year_input').length && $.trim($('.post_year_input').val()) != ''){
            post_data.year=$.trim($('.post_year_input').val());
        }
        if($('.post_year_name_input').length && $.trim($('.post_year_name_input').val()) != ''){
            post_data.year_name=$.trim($('.post_year_name_input').val());
        }
        if($('.post_office_input').length && $.trim($('.post_office_input').val()) != ''){
            post_data.office_location=$.trim($('.post_office_input').val());
        }
        if($('.post_office_hours_input').length && $.trim($('.post_office_hours_input').val()) != ''){
            post_data.office_hours=$.trim($('.post_office_hours_input').val());
        }
        if($('.post_bio_input').length && $.trim($('.post_bio_input').val()) != ''){
            post_data.bio=$.trim($('.post_bio_input').val());
        }
        $.post(
            globals.base_url+'/profile/editProfile',
            post_data,
            function(response){
                if(response['success']){
                    //$submit_button.closest('.msg_span').fadeOut(150);
                    //$submit_button.closest('.msg_span').empty();
                    $submit_button.closest('.msg_span').text('Your profile has been updated');
                    $submit_button.closest('.msg_span').show();
                }

            }
        )
    });

    $('#welcome_post, #welcome_post_2').hide().fadeIn(150);
    $(document).on('keyup','.post_bio_input',function(){
        $('.post_bio_input').attr('rows',Math.ceil($(this).val().length/$('.post_bio_input').attr('cols')));
    });


});