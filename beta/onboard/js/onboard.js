$(document).ready(function () {

    /*if authority is professor, let progress flag to be 2, first two step is redundant for professor*/
    var progress_flag = 0;

    var progress_bar = ["14%", "28%", "43%", "57%", "71%", "86%", "100%"];
    var btn_text = ["Join your School", "Join your Department", "Resend Verification", "Join these Classes", "Continue", "Continue", "Let's Get Started"];
    var hint_text = ["Select your School", "Join your Department", "Verify your Email", "Join your Classes", "Who do you know on campus?", "Find your Clubs", "Complete your Profile"]
    var progress_bar_color = ["rgb(186, 81, 228)", "#009ed3", "rgb(110, 56, 169)", "rgb(0, 173, 61)", "rgb(242, 110, 0)", "#ec3856", "rgb(39, 178, 78)"];

    var canvas_hint = ["", "", "", "Here are some of the most popular classes in your department.", "Share your notes, take part in discussions, and see what they’re up to.", "These are some of the most active clubs at your school.", ""];

    var searchbar_hint = ["Search schools", "Search departments", "", "Search classes", "Search people", "Search clubs", ""];

    /*the following lists should be retreived from php*/
    var school_list = ["NYU Stern School of Business", "NYU Polytechnic School of Engineering", "NYU Steinhardt School of Education"];
    var department_list = ["Department of Computer Science", "Department of Chemistry", "Department of Mathematics", "Department of Biology", "Department of Physics"];
    var course_list = ["Web Programming", "Data Mining", "Computer Organization", "Dynamic Languages", "Machine Vision"];
    var course_id_list = ["cid0", "cid1", "cid2", "cid3", "cid4"];
    var people_list = ["Ross Kopelman", "Jake Lazarus", "Kuan Wang", "Alex Lopez"];
    var clubs_list = ["Archery Club", "Kendo Club", "Boxing Club"];

    /*initialize*/
    progress_check(progress_flag);
    content_paint(progress_flag);


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

        if (curr <= 2) { $(".skip_progress").hide(); } else {
            if (curr != 6) {
                $(".skip_progress").show();
            } else {
                $(".skip_progress").hide();
            }
        }

        if (curr == 2) {
            $(".onboard_textarea_t1").hide();
            $(".progress_footer_glyph_0").hide();
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

        var curr_act = curr + 1;
        $(".progress_hint_1").html("Step <span class='curr_step'>" + curr_act + "</span> of <span>7</span>");
        if (curr == 6) { $(".progress_hint_1").html("Last Step"); };

        if (curr == 6) {
            $(".next_progress").addClass("last_step_btn");
        } else {
            $(".next_progress").removeClass("last_step_btn");
        }

        if ((curr != 0) && (curr != 3) && (curr != 2)) { $(".progress_goback").show(); } else { $(".progress_goback").hide(); }

        //if ((curr!=0)&&(curr!=3))
    }

    $(".content_inner").slimScroll({ wrapperClass: "scroll-wrapper", barClass: "scroll-bar" });

    function content_paint(curr) {
        $canvas = $(".content_canvas");
        $canvas.html("");
        $inner = $(".content_inner");
        $frame = $(".progress_content");

        $canvas.removeClass("canvas_adjust");
        $inner.removeClass("canvas_adjust");
        $frame.removeClass().addClass("progress_content c" + curr);

        $inner[0].scrollTop = 0;

        $(".canvas_banner").remove();

        if (curr == 0) {
            var ns = school_list.length, i = 0;

            function repeat(i) {
                if (i == ns) return;
                $stepCard = $("<div class='step_0_card y' />")
                $stepCard.html("<div class='card_0_info'>" + "<img class='card_0_glyph' src='img/defaultGlyph.png'>" + "<div class='card_0_text'><div class='card_0_text_0'>" + school_list[i] + "</div><div class='card_0_text_1'>32 people</div></div><div class='green_join_btn'><span>Join</span></div></div>");
                $canvas.append($stepCard);
                setTimeout(function () {
                    $stepCard.removeClass("y");
                    repeat(++i);
                }, 250);
            }
            repeat(i);
        }

        if (curr == 1) {
            var ns = department_list.length, i = 0;
            function repeat(i) {
                if (i == ns) return;
                $stepCard = $("<div class='step_0_card y' />")
                $stepCard.html("<div class='card_0_info'><div class='card_0_text'><div class='card_0_text_0'>" + department_list[i] + "</div><div class='card_0_text_1'>32 people</div></div><div class='green_join_btn'><span>Join</span></div></div>");
                $canvas.append($stepCard);
                setTimeout(function () {
                    $stepCard.removeClass("y");
                    repeat(++i);
                }, 250);
            }
            repeat(i);
        }

        if (curr == 2) {
            $canvas.append("<div class='step_2_card'><h1>Check your email</h1><p>We sent you a confirmation email with a link to get you started on Urlinq.</p><img src='img/EmailConfirmIcon.png'></div>");
        }

        if (curr == 3) {
            $canvas.addClass("canvas_adjust");
            $inner.addClass("canvas_adjust");

            $frame.prepend("<div class='canvas_banner'><div class='left_txt'>" + canvas_hint[curr] + "</div><div class='right_txt'><span>0</span> selected</div></div>");


            $canvas.append("<div class='a_thread' id='thread_0'></div><div class='a_thread' id='thread_1'></div>");

            $thread0 = $("#thread_0");
            $thread1 = $("#thread_1");

            var ns = course_list.length;
            for (var i = 0; i < ns; i++) {

                if (i % 2 == 0) {
                    $tthread = $thread0;
                } else {
                    $tthread = $thread1;
                }

                var id_from_php = course_id_list[i];
                $tthread.append("<div class='step_3_card' id=" + id_from_php + "><div class='step_3_show'><img class='card_3_glyph' src='img/defaultGlyph.png'><div class='step_3_line_0'>" + course_list[i] + "</div><div class='step_3_line_1'><div class='step_3_line_1_0'><span>2</span> sections</div>  	<span class='adot'>&#8226;</span> <div class='member_glyph'></div><div class='step_3_line_1_1'><span>125</span> members</div></div></div><div class='step_3_hide'><div class='cover_line'>choose your section</div><div class='step_3_card_section_detail'></div></div></div>");

                var $expand = $("#" + id_from_php).find(".step_3_card_section_detail");

                var classes = ["c1", "c2"];
                var cs = classes.length;
                for (var j = 0; j < cs; j++) {
                    $expand.append("<div class='step_3_card_section_detail_card' id=" + cs[j] + "><input type='checkbox' class='section_check' ><div class='section_detail_right'>Thu 10:00-11:30pm, Fri 12:30-01:00pm - Lenhart Schubert</div></div>");
                }
            }

        }

        if (curr == 4) {
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

                $tthread.append("<div class='step_4_card'><img class='card_4_glyph' src='img/defaultGlyph.png'><div class='card_4_txt'>" + people_list[i] + "</div><div class='gray_btn card_4_btn'> <span>Follow</span></div></div>");

            }

        }

        if (curr == 5) {
            $canvas.addClass("canvas_adjust");
            $inner.addClass("canvas_adjust");

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

                $tthread.append("<div class='step_3_card step_5_card'><div class='step_3_show'><img class='card_3_glyph' src='img/defaultGlyph.png'><div class='step_3_line_0 club_adjust'>" + clubs_list[i] + "</div><div class='step_3_line_1 club_adjust'> <div class='member_glyph'></div><div class='step_3_line_1_1'><span>125</span> members</div></div> <div class='club_join green_join_btn'>Join</div></div></div>");
            }

        }

        if (curr == 6) {
            $canvas.append("<div class='step_6_card'><div class='step_6_card_r0'><img class='card_6_glyph' src='img/defaultGlyph.png'><div class='pt_upload_btn gray_btn'>Upload Profile Picture</div><form><input type='file' class='step_6_upload' style='display:none;'></form></div><div class='step_6_card_r1'><div class='step_6_card_r1_txt'>Faculty Type</div><div class='ui dropdown step_6_card_r1_choice'><div class='text'>Professor</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='option1'>Professor</div><div class='item' data-value='option2'>Administrator</div></div></div></div> <div class='step_6_card_r2'><div class='step_6_card_r2_txt'>Office Location</div><input type='text' class='ol onboard_textarea_t0'/></div> <div class='step_6_card_r3'><div class='step_6_card_r3_txt'>Research Interests</div><input type='text' class='as onboard_textarea_t0'/></div> <div class='step_6_card_r4'><div class='step_6_card_r4_txt'>Gender</div><input class='step_6_card_r4_input' type='radio' name='gender'><span>Male</span> <input class='step_6_card_r4_input' type='radio' name='gender'><span>Female</span></div>");

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


    $(document).delegate(".next_progress", "click", function () {
        if (is_active_btn($(this))) {
            if (progress_flag < 6) {
                progress_flag++;
                progress_check(progress_flag);
                content_paint(progress_flag);
            }
        }
    });

    $(document).delegate(".skip_progress", "click", function () {
        if (progress_flag < 6) {
            progress_flag++;
            progress_check(progress_flag);
            content_paint(progress_flag);
        }
    });

    $(document).delegate(".progress_goback", "click", function () {
        if ((progress_flag > 0) && (progress_flag != 3)) {
            progress_flag--;
            progress_check(progress_flag);
            content_paint(progress_flag);
        };
    });

    $(document).delegate(".step_0_card", "click", function () {
        var $self = $(this);
        $(".step_0_card").addClass("left");
        $self.removeClass("left");
        setTimeout(function () {
            $self.addClass("right");
            setTimeout(function () {
                $(".next_progress").click();
            }, 750);
        }, 250);
    });

    $(document).delegate(".step_3_card", "mouseenter", function () {
        $(this).addClass("expanded_pseudo");
    });

    $(document).delegate(".step_3_card", "mouseleave", function () {
        $(this).removeClass("expanded_pseudo");
    });

    $(document).delegate(".step_3_show", "click", function () {
        if (!$(this).closest(".step_3_card").hasClass("step_5_card")) {
            if ($(this).closest(".step_3_card").hasClass("expanded")) {
                $(this).closest(".step_3_card").removeClass("expanded");
                $(this).closest(".step_3_card").find(".step_3_hide").hide();
            } else {
                $(this).closest(".step_3_card").addClass("expanded");
                $(this).closest(".step_3_card").find(".step_3_hide").show();
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
            $(this).text("Joined");
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

});