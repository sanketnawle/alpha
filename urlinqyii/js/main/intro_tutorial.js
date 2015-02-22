$(document).ready(function(){

	$('#tutorial_starter').click(function(){
        var $tutorial_starter_button = $(this);
        $tutorial_starter_button.addClass("tutorial_started");

		setTimeout(function() {
            $(".pulse_tp_0").css({'opacity':'1'});
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
                    y: -327,
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
        }, 200);



	});

	$(".intro_div").click(function(){
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
	});



});