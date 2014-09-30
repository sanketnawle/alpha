$(document).ready(function() {     
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

    var weekday = new Array(7);
    weekday[0] = "su";
    weekday[1] = "mo";
    weekday[2] = "tu";
    weekday[3] = "we";
    weekday[4] = "th";
    weekday[5] = "fr";
    weekday[6] = "sa";
    var $w = weekday[startAt($m, $y)];


    var renderEventAct0 = [];
    var renderEventAct1 = [];


    $(".calcell").each(function(index) {
        var tid = $(this).attr("id");
        var tidsp = tid.split("_");
        var idx = tidsp[2];
        var td = tidsp[1];
        if ((td == $w) && (idx <= 6)) {

            for (var i = idx; i < (parseInt(idx) + parseInt($ds)); i++) {

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
    $(document).delegate(".m-next", "click", function() {
        /*archive event*/
        $(".calcell").each(function(index) {
            var iid = $(this).attr("id") + "::" + $m;
            var inact0 = jQuery.inArray(iid, renderEventAct0);
            var inact1 = jQuery.inArray(iid, renderEventAct1);


            if ($(this).hasClass("active0") && (inact0 == "-1")) {
                renderEventAct0.push(iid);
            }
            if ($(this).hasClass("active1") && (inact1 == "-1")) {
                renderEventAct1.push(iid);
            }


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
        $(".calcell").each(function(index) {
            var tid = $(this).attr("id");
            var tidsp = tid.split("_");
            var idx = tidsp[2];
            var td = tidsp[1];
            if ((td == $w) && (idx <= 6)) {

                for (var i = idx; i < (parseInt(idx) + parseInt($ds)); i++) {
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
        $.each(renderEventAct0, function(index, value) {
            var mth = value.split("::");
            var ind = mth[1];
            var dte = mth[0];
            if (parseInt(ind) == parseInt($m)) {
                $("#" + dte).addClass("active0");
            }
        });
        $.each(renderEventAct1, function(index, value) {
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
    $(document).delegate(".m-prev", "click", function() {
        /*archive event*/
        $(".calcell").each(function (index) {
            
            var iid = $(this).attr("id") + "::" + $m; 
            var inact0 = jQuery.inArray(iid, renderEventAct0);
            var inact1 = jQuery.inArray(iid, renderEventAct1);
            

            if ($(this).hasClass("active0") && (inact0 == "-1")) {
                renderEventAct0.push(iid);
            }
            if ($(this).hasClass("active1") && (inact1 == "-1")) {
                renderEventAct1.push(iid);
            }


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
        $(".calcell").each(function(index) {
            var tid = $(this).attr("id");
            var tidsp = tid.split("_");
            var idx = tidsp[2];
            var td = tidsp[1];
            if ((td == $w) && (idx <= 6)) {

                for (var i = idx; i < (parseInt(idx) + parseInt($ds)); i++) {

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
        $.each(renderEventAct0, function(index, value) {
            var mth = value.split("::");
            var ind = mth[1];
            var dte = mth[0];
            if (parseInt(ind) == parseInt($m)) {
                $("#" + dte).addClass("active0");
            }
        });
        $.each(renderEventAct1, function(index, value) {
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
        $(".calcell").each(function(index) {
            $(this).text("");
            $(this).addClass("disable");
        });
    }

    function cleanBlinkActive1() {
        $(".calcell").each(function(index) {
            $(this).removeClass("active1");
            $(this).removeClass("blink1");

        });
    }

    function cleanBlinkActive2() {
        $(".calcell").each(function(index) {
            $(this).removeClass("active2");
            $(this).removeClass("blink2");

        });
    }
    //mutated
    function cleanActive0() {
        $(".calcell").each(function(index) {
            $(this).removeClass("active0");

        });
    }

    function cleanBlink1() {
        $(".calcell").each(function(index) {

            $(this).removeClass("blink1");

        });
    }

    function cleanBlink2() {
        $(".calcell").each(function(index) {

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

                var nid = "wk=" + $(this).attr("id");
                ($(this).parents(".calLayer").parent()).children(".set_date").attr("value", ($m + 1) + "/" + ddd + "/" + $y);

                $(this).parents(".calLayer").toggle();
            }
        }
    });


    $(document).delegate(".hp1cells", "mouseover", function() {
        $(this).css({"background-color": "#44D37C", "color": "white"});
    });
    $(document).delegate(".hp1cells", "mouseout", function() {
        $(this).css({"background-color": "transparent", "color": "black"});
    });

    $(document).delegate(".hp1cells", "click", function() {
        $(".hpdisplay1 span").text($(this).text());
        $(".hpdisplay1").attr("id", $(this).attr("id"));
    });

    //mutated
    $(document).delegate(".hp1ok", "click", function() {
        if ($(".hpdisplay1").attr("id") != "notime1") {

            $(".hp1content").remove();

            cleanBlink1();
            blinkflag = 2;

            var tid = $y + "-" + $m + "-" + $(".active1").text() + "-" + $(".hpdisplay1").attr("id");
            $(".hpdisplay1").attr("id", tid);
            
            createHourPicker2();
            var nid = "fnl=" + $(".active1").attr("id");
            $(".finalstep").css("margin-left", "170px");
            $(".finalstep").attr("id", nid);
        }
    });
    
    $(document).delegate(".hp2cells", "mouseover", function() {
        $(this).css({"background-color": "#44D37C", "color": "white"});
    });
    $(document).delegate(".hp2cells", "mouseout", function() {
        $(this).css({"background-color": "transparent", "color": "black"});
    });

    $(document).delegate(".hp2cells", "click", function() {
        $(".hpdisplay2 span").text($(this).text());
        $(".hpdisplay2").attr("id", $(this).attr("id"));
    });

    //mutated
    $(document).delegate(".hp2ok", "click", function() {
        if ($(".hpdisplay2").attr("id") != "notime2") {
            $(".hp2content").remove();
            blinkflag = 2;
        }
        //alert($m);
        var tid = $y + "-" + $m + "-" + $(".active2").text() + "-" + $(".hpdisplay2").attr("id");
        $(".hpdisplay2").attr("id", tid);
    });    
});