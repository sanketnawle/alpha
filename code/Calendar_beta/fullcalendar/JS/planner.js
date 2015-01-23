$(document).ready(function () {

    $('.fa-caret-down').click(function () {
        $('.pl_options').toggleClass('unhider');
        $('.fa-caret-down').toggleClass('open_Menu');
    });
    $('.button-block button').on('click', function () {
        var $this = $(this).parent();
        var $a = $(this).parents(".wrapper");
        if ($a.hasClass("checked")) {
            $a.removeClass('checked');
        } else {
            $a.addClass('checked');
        }

        $this.toggleClass('canceled');
        return false;
    });

    $('.btn_canc').click(function () {
        $('.pl_add').css('height', '19px');
        $('.pl_addevnt').css('display', 'none');
        //$('.planner').css('height', '325px');
        $('.pl_add').attr("placeholder", "+ Add new Event");

    });
    
    $('.pl_add').click(function () {

        $('.pl_add').css('height', '34px');
        $('.pl_addevnt').css('display', 'block');
        //$('.planner').css('height', '409px');
        $('.pl_add').attr("placeholder", "Name this event...");

    });
    
    $(document).on("click", function (e) {
        var elem = $(e.target);
        if (!elem.hasClass("evnt_inps") &&
            !elem.hasClass("set_date"))
        {
            $('.calLayer').css('display', 'none');
        }
        if (elem.hasClass("days") ||
            elem.hasClass("m-prev") ||
            elem.hasClass("m-next") ||
            elem.hasClass("minical-header") ||
            elem.hasClass("minical-h1")) {
            $('.calLayer').css('display', 'block');
        }
    }); 
});


$(document).ready(function () {
    $(function () {
        $('#nevt-desc').autogrow();
        $('#nevt-desc').css('overflow', 'hidden').autogrow()
    });

    var renderEventAct0 = [];
    var renderEventAct1 = [];

    $("#edit-picture").hide();

    $(document).delegate("#profile-picture", "mouseover", function () {
        $("#edit-picture").show();
    });
    $(document).delegate("#edit-picture", "mouseover", function () {
        $("#edit-picture").show();
    });
    $(document).delegate("#edit-picture", "mouseout", function () {
        $("#edit-picture").hide();
    });
    $(document).delegate("#profile-picture", "mouseout", function () {
        $("#edit-picture").hide();
    });

    $(".class-name").each(function (index) {
        if ($(this).text().length > 21) {
            //alert($(this).attr("id"));
            $(this).text($(this).text().substr(0, 18) + "...");
        }
    });
    $(".club-name").each(function (index) {
        if ($(this).text().length > 21) {
            //alert($(this).attr("id"));
            $(this).text($(this).text().substr(0, 18) + "...");
        }
    });

    $(document).delegate(".editcolumn", "keyup", function () {
        if ($(this).attr("id") == "editcolumn-u") {
            ut = $(this).val();
        }

        if ($(this).attr("id") == "editcolumn-a") {
            mat = $(this).val();
        }
        if ($(this).attr("id") == "editcolumn-i") {
            mit = $(this).val();
        }
    });

    $(document).delegate(".editingbio", "keyup", function () {
        if ($(this).hasClass("emailtext")) {
            eml = $(this).val();
        }
        if ($(this).hasClass("loctext")) {
            eml = $(this).val();
        }
        if ($(this).hasClass("biotext")) {
            btx = $(this).val();
        }

    });

    $(document).delegate(".annbuttons", "click", function () {

        $("#blackcanvas2").fadeOut();

        if ($(this).hasClass("ann-submit")) {

            var tid = $(this).attr("id").split("=");
            var cid = tid[1];
            /*cid is the course/club id*/

            /*Ajax goes here*/
        }

    });

    //need slightly revise!!
    $(document).delegate(".acabuttons", "click", function () {



        if ($(this).hasClass("aca-submit")) {

            /*cid is the course/club id*/
            var tid = $(this).closest(".blackcanvas3").attr("id").split("=");
            var cid = tid[1];


            var t = "";
            var t = $("#nevt-title").val();
            var desc = $("#nevt-desc").val();

            var st = "";
            var tdate = "";
            var tdate = $(".stdate").text();


            var st = tdate + " " + $('#timepicker1').data("timepicker").getTime();
            var ed = tdate + " " + $('#timepicker2').data("timepicker").getTime();

            var repeatstt = $(".repeatstate").text();

            if ((t != "") && (tdate != "")) {
                alert(t + "," + desc + "," + st + "," + ed + "," + repeatstt + ". added, please remove me and add ajax here");
                /*ajax goes here*/
                /*
                 $.ajax({
                 url: "http://127.0.0.1/PhpProject/calendar_0114/fullcalendar/user/create_events.php",
                 data: "&id=" + gt+"&title=" + t+ "&start=" + dta+ "&end=" + dtb + "&description=" + desc,
                 type: "POST",
                 error: function(json){ alert('Error'); },
                 success: function(json) { alert('Added Successfully'); }
                 });
                 */





                //after ajax
                //appearance part

                //alter the event state from active1 to active0
                cleanBlinkActive1();
                cleanActive0();

                var tpid = $(".stdate").attr("id").split("=");
                var nid = tpid[1];

                $("#" + nid).removeClass("active1");

                renderEventAct0.push(nid + "::" + $m);

                //retreive active0
                $.each(renderEventAct0, function (index, value) {
                    var mth = value.split("::");
                    var ind = mth[1];
                    var dte = mth[0];
                    if (parseInt(ind) == parseInt($m)) {
                        $("#" + dte).addClass("active0");
                    }
                });

                $.each(renderEventAct1, function (index, value) {
                    var mth = value.split("::");
                    var ind = mth[1];
                    var dte = mth[0];
                    if (dte == nid) {
                        renderEventAct1.splice(index, value);
                    }
                });

                //after added, remove everything

                $(".sb").remove();
                $(".uploadevent").remove();
                //remove complete
                //pop up add more button
                $(".successinfo").fadeIn();
                $("#startdate-input").animate({
                    marginLeft: '+=70px'
                }, 500);
                moveflag = 0;

            }
        } else {
            $("#bc3content").animate({ marginRight: "-=700px" });

            $(".blackcanvas3").hide();
            animationflag = 0;

        }

    });

    $(document).delegate(".addmore", "click", function () {
        $(".successinfo").hide();

        //add back removed elements


        $(".uploadform").append("<div class='uploadevent'><input type='text' id='nevt-title' placeholder='Title' class='nevt-input'><input type='text' id='nevt-location' placeholder='Location' class='nevt-input'><textarea wrap id='nevt-desc' onkeypress='taHeight()' placeholder='Details' class='nevt-input'></textarea><hr><div class='pdateinfo'><span id = 'startdate-input'>Pick a Date &#187; <span class='stdate'></span></span><div class='frtext'>from:</div><div class='totext'>to:</div></div><div class='hourpick1'><div class='input-append bootstrap-timepicker'><input id='timepicker1' type='text' class='input-small'><span class='add-on'><i class='icon-time'></i></span></div></div><div class='hourpick2'><div class='input-append bootstrap-timepicker'><input id='timepicker2' type='text' class='input-small'><span class='add-on'><i class='icon-time'></i></span></div></div></div>");

        $(".uploadform").append("<div class='sb'><button class='acabuttons aca-submit'>Add Event</button></div>");

        $(".uploadevent").append("<div class='repeatc'><div class='repeathead'>Repeat:</div> <span class='repeatstate'>None</span><div class='repeatoption'><span class='repeatoptiont'>None</span><span class='repeatoptiont'>Daily</span><span class='repeatoptiont'>Weekly</span><span class='repeatoptiont'>Monthly</span></div></div>");

        $('#timepicker1').timepicker();
        $('#timepicker2').timepicker();

        //initiate the global vars
        moveflag = 0;
        blinkflag = 0;

    });


    $(document).delegate(".announce", "mousedown", function () {
        var tid = "";
        if ($(this).closest(".announcecolumn").hasClass("toolsforclass")) {
            tid = "ed=" + $(this).closest(".class-one").attr("id");
        }

        if ($(this).closest(".announcecolumn").hasClass("toolsforclub")) {
            tid = "ed=" + $(this).closest(".club-one").attr("id");
        }


        $(".annbuttons").attr("id", tid)
        $("#blackcanvas2").fadeIn();

    });

    var animationflag = 0;
    $(document).delegate(".addevent", "mousedown", function () {
        var tid = "";
        if ($(this).closest(".announcecolumn").hasClass("toolsforclass")) {
            tid = "ed=" + $(this).closest(".class-one").attr("id");
        }

        if ($(this).closest(".announcecolumn").hasClass("toolsforclub")) {
            tid = "ed=" + $(this).closest(".club-one").attr("id");
        }


        $(".blackcanvas3").attr("id", tid);
        $(".blackcanvas3").fadeIn();
        animationflag = 1;

        //$("#bc3content").css("margin-right","0px");
        $("#bc3content").animate({ marginRight: "+=700px" });
    });





    function retyear(t) {
        var t0 = t.split(" ");
        var t1 = t0[0].split("/");
        return t1[0];
    }
    function retmonth(t) {
        var t0 = t.split(" ");
        var t1 = t0[0].split("/");
        return t1[1];
    }
    function retday(t) {
        var t0 = t.split(" ");
        var t1 = t0[0].split("/");
        return t1[2];
    }
    function rethour(t) {
        var t0 = t.split(" ");
        var t1 = t0[1].split(":");
        return t1[0];
    }
    function retminute(t) {
        var t0 = t.split(" ");
        var t1 = t0[1].split(":");
        return t1[1];
    }




    /*JQ for mini calendar*/
    function daysInMonth(month, year) {
        return new Date(year, month + 1, 0).getDate();
    }

    function startAt(month, year) {
        return new Date(year, month, 1).getDay();
    }

    var date = new Date();
    var months = new Array();
    months[0] = "January";
    months[1] = "February";
    months[2] = "March";
    months[3] = "April";
    months[4] = "May";
    months[5] = "June";
    months[6] = "July";
    months[7] = "August";
    months[8] = "September";
    months[9] = "October";
    months[10] = "November";
    months[11] = "December";
    var $m = date.getMonth();
    var $M = months[$m];
    var $y = date.getFullYear();
    $(".minical-h1").text($M + " " + $y);

    var $ds = daysInMonth($m, $y);
    //alert(daysInMonth(m,y));

    var weekday = new Array(7);
    weekday[0] = "su";
    weekday[1] = "mo";
    weekday[2] = "tu";
    weekday[3] = "we";
    weekday[4] = "th";
    weekday[5] = "fr";
    weekday[6] = "sa";
    var $w = weekday[startAt($m, $y)];
    

    $(".calcell").each(function (index) {
        var tid = $(this).attr("id");
        var tidsp = tid.split("_");
        var idx = tidsp[2];
        var td = tidsp[1];
        if ((td == $w) && (idx <= 6)) {

            for (var i = idx; i < (parseInt(idx) + parseInt($ds)) ; i++) {

                $(".cl_" + i).removeClass("disable");
                $(".cl_" + i).text(parseInt(i) - parseInt(idx) + parseInt(1));
            } 
        }
        if ($(this).hasClass("disable") && (idx >= parseInt($ds))) {
            $(this).hide();
        }
        else {
            $(this).show();
        }
    });
    //mutated
    $(document).delegate(".m-next", "click", function () {
        /*archive event*/
        $(".calcell").each(function (index) {
            var iid = $(this).attr("id") + "::" + $m;
            var inact0 = jQuery.inArray(iid, renderEventAct0);
            var inact1 = jQuery.inArray(iid, renderEventAct1);


            if ($(this).hasClass("active0") && (inact0 == "-1")) { renderEventAct0.push(iid); }
            if ($(this).hasClass("active1") && (inact1 == "-1")) { renderEventAct1.push(iid); }


        });
        /*archive event end*/
        cleanCalendar();
        if ($m < 11) {
            $m = $m + 1;
        } else {
            $m = 0;
        }

        var $M = months[$m];
        var $ds = daysInMonth($m, $y);
        $(".minical-h1").text($M + " " + $y);

        var $ds = daysInMonth($m, $y);
        var $w = weekday[startAt($m, $y)];
        $(".calcell").each(function (index) {
            var tid = $(this).attr("id");
            var tidsp = tid.split("_");
            var idx = tidsp[2];
            var td = tidsp[1];
            if ((td == $w) && (idx <= 6)) {

                for (var i = idx; i < (parseInt(idx) + parseInt($ds)) ; i++) {
                    $(".cl_" + i).removeClass("disable");
                    $(".cl_" + i).text(parseInt(i) - parseInt(idx) + parseInt(1));
                } 
            }
            if ($(this).hasClass("disable") && (idx >= parseInt($ds))) {
                $(this).hide();
            }
            else {
                $(this).show();
            }
        });

        cleanActive0();
        cleanBlinkActive1();
        cleanBlinkActive2();

        /*retreive event*/
        $.each(renderEventAct0, function (index, value) {
            var mth = value.split("::");
            var ind = mth[1];
            var dte = mth[0];
            if (parseInt(ind) == parseInt($m)) {
                $("#" + dte).addClass("active0");
            }
        });
        $.each(renderEventAct1, function (index, value) {
            //alert(value);
            var mth = value.split("::");
            var ind = mth[1];
            var dte = mth[0];
            if (parseInt(ind) == parseInt($m)) {
                $("#" + dte).addClass("active1");

            }
        });

        /*retreive event end*/

    });
    //mutated
    $(document).delegate(".m-prev", "click", function () {
        /*archive event*/
        $(".calcell").each(function (index) {
            var iid = $(this).attr("id") + "::" + $m;
            var inact0 = jQuery.inArray(iid, renderEventAct0);
            var inact1 = jQuery.inArray(iid, renderEventAct1);


            if ($(this).hasClass("active0") && (inact0 == "-1")) { renderEventAct0.push(iid); }
            if ($(this).hasClass("active1") && (inact1 == "-1")) { renderEventAct1.push(iid); }


        });
        /*archive event end*/

        cleanCalendar();
        if ($m > 0) {
            $m = $m - 1;
        } else {
            $m = 11;
        }

        var $M = months[$m];
        var $ds = daysInMonth($m, $y);
        $(".minical-h1").text($M + " " + $y);

        var $ds = daysInMonth($m, $y);
        var $w = weekday[startAt($m, $y)];
        $(".calcell").each(function (index) {
            var tid = $(this).attr("id");
            var tidsp = tid.split("_");
            var idx = tidsp[2];
            var td = tidsp[1];
            if ((td == $w) && (idx <= 6)) {

                for (var i = idx; i < (parseInt(idx) + parseInt($ds)) ; i++) {

                    $(".cl_" + i).removeClass("disable");
                    $(".cl_" + i).text(parseInt(i) - parseInt(idx) + parseInt(1));
                } 
            }
            if ($(this).hasClass("disable") && (idx >= parseInt($ds))) {
                $(this).hide();
            }
            else {
                $(this).show();
            }
        });


        cleanActive0();
        cleanBlinkActive1();


        /*retreive event*/
        $.each(renderEventAct0, function (index, value) {
            var mth = value.split("::");
            var ind = mth[1];
            var dte = mth[0];
            if (parseInt(ind) == parseInt($m)) {
                $("#" + dte).addClass("active0");
            }
        });
        $.each(renderEventAct1, function (index, value) {
            //alert(value);
            var mth = value.split("::");
            var ind = mth[1];
            var dte = mth[0];
            if (parseInt(ind) == parseInt($m)) {
                $("#" + dte).addClass("active1");

            }
        });

        /*retreive event end*/


    });

    function cleanCalendar() {
        $(".calcell").each(function (index) {
            $(this).text("");
            $(this).addClass("disable");
        });
    }

    function cleanBlinkActive1() {
        $(".calcell").each(function (index) {
            $(this).removeClass("active1");
            $(this).removeClass("blink1");

        });
    }

    function cleanBlinkActive2() {
        $(".calcell").each(function (index) {
            $(this).removeClass("active2");
            $(this).removeClass("blink2");

        });
    }
    //mutated
    function cleanActive0() {
        $(".calcell").each(function (index) {
            $(this).removeClass("active0");

        });
    }

    function cleanBlink1() {
        $(".calcell").each(function (index) {

            $(this).removeClass("blink1");

        });
    }

    function cleanBlink2() {
        $(".calcell").each(function (index) {

            $(this).removeClass("blink2");

        });
    }

    var blinkflag = 0;
    var moveflag = 0;
    var param1 = new Date();
    var param2 = (param1.getMonth() + 1) + '/' + param1.getDate() + '/' + param1.getFullYear();
    $(".set_date").attr("value", param2);
    $startTime = 0;
    $(document).delegate(".calcell", "click", function () {
        if (!$(this).hasClass("disable")) {
            if (blinkflag == 0) {

                cleanBlinkActive1();
                $(this).addClass("active1");
                $(this).addClass("blink1");

                var ddd = $(this).text();
                $M = months[$m];

                var nid = "wk=" + $(this).attr("id")
                $(".set_date").attr("value", ($m + 1) + "/" + ddd + "/" + $y);
                

                $('.calLayer').toggle();

                // To reset the format of the timepicker
                if ((new Date().getMonth() + 1) >= $(".set_date").val().split('/')[0]) {                    
                    if (new Date().getDate() < $(".set_date").val().split('/')[1]) {
                        $('#set_time_24hr').timeAutocomplete({
                            increment: 15,
                            formatter: 'ampm',
                            start_hour: 0,
                            value: 'Add a time?'
                        });
                    }
                    else {
                        $('#set_time_24hr').timeAutocomplete({
                            increment: 15,
                            formatter: 'ampm',
                            start_hour: new Date().getHours(),
                            value: 'Add a time?'
                        });
                    }
                }
                else {
                    $('#set_time_24hr').timeAutocomplete({
                        increment: 15,
                        formatter: 'ampm',
                        start_hour: 0,
                        value: 'Add a time?'
                    });
                }                
            }
        }
    });
    
    $(document).delegate(".hp1cells", "mouseover", function () {
        $(this).css({ "background-color": "#44D37C", "color": "white" });
    });
    $(document).delegate(".hp1cells", "mouseout", function () {
        $(this).css({ "background-color": "transparent", "color": "black" });
    });

    $(document).delegate(".hp1cells", "click", function () {
        $(".hpdisplay1 span").text($(this).text());
        $(".hpdisplay1").attr("id", $(this).attr("id"));
    });

    //mutated
    $(document).delegate(".hp1ok", "click", function () {
        if ($(".hpdisplay1").attr("id") != "notime1") {

            $(".hp1content").remove();

            cleanBlink1();
            blinkflag = 2;


            //alert($m);
            var tid = $y + "-" + $m + "-" + $(".active1").text() + "-" + $(".hpdisplay1").attr("id");
            $(".hpdisplay1").attr("id", tid);


            createHourPicker2();
            var nid = "fnl=" + $(".active1").attr("id");
            $(".finalstep").css("margin-left", "170px");
            $(".finalstep").attr("id", nid);
        }
    });



    $(document).delegate(".hp2cells", "mouseover", function () {
        $(this).css({ "background-color": "#44D37C", "color": "white" });
    });
    $(document).delegate(".hp2cells", "mouseout", function () {
        $(this).css({ "background-color": "transparent", "color": "black" });
    });

    $(document).delegate(".hp2cells", "click", function () {
        $(".hpdisplay2 span").text($(this).text());
        $(".hpdisplay2").attr("id", $(this).attr("id"));
    });

    //mutated
    $(document).delegate(".hp2ok", "click", function () {
        if ($(".hpdisplay2").attr("id") != "notime2") {
            $(".hp2content").remove();
            blinkflag = 2;
        }
        //alert($m);
        var tid = $y + "-" + $m + "-" + $(".active2").text() + "-" + $(".hpdisplay2").attr("id");
        $(".hpdisplay2").attr("id", tid);
    });

    //mutated

    $('.set_date').click(function () {
//        $('.calLayer').css('display', 'block');
        $('.calLayer').toggle();
    });

    // set time options for time picker 24hr
    if ((new Date().getMonth() + 1) >= $(".set_date").val().split('/')[0]) {
        if (new Date().getDate() <= $(".set_date").val().split('/')[1]) {
            $startTime = new Date().getHours();
        }
    }
    $currentTime = new Date().getHours() + ':' + new Date().getMinutes() + ':00';
    $('#set_time_24hr').timeAutocomplete({
        increment: 15,
        formatter: 'ampm',
        start_hour: $startTime,
        value: $currentTime
    });
    
});