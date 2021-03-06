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

            var promptHeader1=["Your Account Menu"];
            var promptHeader2 = ["The Planner"];
            var promptHeader3 = ["Collaboration Bar"];
            var promptContent=["As you add your classes and groups all of the events will automatically sync into your planner so that you stay up-to-date with the things that you most care about on campus and in your classes"];
            var promptContent2=["Now you can share content and crowdsource answers to questions you have among your peers from your department and school. You choose your audience and you can even post things anonymously so that no question goes unanswered!"];

            var footer= "<p>Seen this before? <a>Opt out of these tips</a></p>";
/*
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
            }*/
            if($tutorial_starter_button.hasClass('show_planner_tutorial')){
                $(".intro_div_2").addClass('show_tutorial');
                $(".intro_div_2").tooltip({x:-525, y:-300, promptHeader: promptHeader2, promptContent: promptContent, footer:footer, wedge:'right'});
            }
            if($tutorial_starter_button.hasClass('show_fbar_tutorial')){
                $(".intro_div_3").addClass('show_tutorial');
                $(".intro_div_3").tooltip({x:12, y:23, promptHeader: promptHeader3, promptContent: promptContent2, footer:footer, wedge:'top'});
            }
            $(".intro_div.show_tutorial").pulse($(".pulse_tp_0"),{x:10,y:10});
            if(already_clicked){
                $(".pulse_tp_0").fadeIn(150);
                $(".pulse_tp_0").css({'opacity':'1'});
            }

        }, 200);




	});
    if((!$('#tutorial_starter').hasClass('show_planner_tutorial')||
        !$('#tutorial_starter').hasClass('show_fbar_tutorial'))&&
        ($('#tutorial_starter').hasClass('show_planner_tutorial')||
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

    $(document).on('click','.post_add_office_hours_button',function(){
        var $office_hours_row = $(this).closest('.post_office_hours_day_holder');
        $('.post_office_hours_section').append($office_hours_row.clone());
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
            post_data.location=$.trim($('.post_office_input').val());
        }
        if($('.post_office_hours_input').length && $.trim($('.post_office_hours_input').val()) != ''){
            post_data.hours=$.trim($('.post_office_hours_input').val());
        }
        /*if($('.post_office_hours_section').length && $('.post_office_hours_input.start_time').attr('data-start_time')
            && $('.post_office_hours_input.start_time').attr('data-end_time')){
            post_data.office_hours= [];
            $('.post_office_hours_time_input.start_time').each(function(index,elt){
                post_data.office_hours[index]={};
                post_data.office_hours[index]['start_time'] = $(this).attr('data-time');
            });
            $('.post_office_hours_time_input.end_time').each(function(index,elt){

                post_data.office_hours[index]['end_time'] = $(this).attr('data-time');
            });
            $('.post_office_hours_day_input').each(function(index,elt){
                post_data.office_hours[index]['day'] = $(this).val();
            });

        }*/

        
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