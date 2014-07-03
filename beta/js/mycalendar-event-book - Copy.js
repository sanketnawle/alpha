$(document).ready(function () {
    var tdt = $(".fc-header-left .fc-header-title h2").text();
    var tdtarr = tdt.split(" ");
    var tdtarr1 = "<span class='tdt_0'>" + tdtarr[0] + "</span>";
    var tdtarr2 = "<span class='tdt_1'>" + tdtarr[1] + "</span>";
    var tdt = tdtarr1 + " " + tdtarr2;
    $(".fc-header-left .fc-header-title h2").html(tdt);


    $(document).delegate(".cal-group-toggle-checked", "click", function () {
        $(this).closest(".cal-group").css("opacity", ".65");
        $(this).removeClass("cal-group-toggle-checked");
        $(this).addClass("cal-group-toggle-unchecked");
        $(this).find(".cal-group-checkmark").removeClass("cal-group-checkmark-checked");
        $(this).find(".cal-group-checkmark").addClass("cal-group-checkmark-unchecked");
    });
    $(document).delegate(".cal-group-toggle-unchecked", "click", function () {
        $(this).closest(".cal-group").css("opacity", "1");
        $(this).removeClass("cal-group-toggle-unchecked");
        $(this).addClass("cal-group-toggle-checked");
        $(this).find(".cal-group-checkmark").removeClass("cal-group-checkmark-unchecked");
        $(this).find(".cal-group-checkmark").addClass("cal-group-checkmark-checked");
    });

});



$(function () {

    $('#popupDatepicker').datepick();

    $('#clickEvent1').bind('click', function (event) {

        $('#button1').empty();

        var eventContent = $('#clickEvent1').text();

        console.log(eventContent);

        var node1 = "<span id='eventIn1'>";

        $('#button1').text(eventContent);

        $('#button1').prepend(node1);



    });

    $('#popupDatepicker').datepick();

    $('#clickEvent2').bind('click', function (event) {

        $('#button1').empty();

        var eventContent = $('#clickEvent2').text();

        console.log(eventContent);

        var node1 = "<span id='eventIn2'>";

        $('#button1').text(eventContent);

        $('#button1').prepend(node1);



    });

    $('#popupDatepicker').datepick();

    $('#clickEvent3').bind('click', function (event) {

        $('#button1').empty();

        var eventContent = $('#clickEvent3').text();

        console.log(eventContent);

        var node1 = "<span id='eventIn3'>";

        $('#button1').text(eventContent);

        $('#button1').prepend(node1);



    });

    $('#popupDatepicker').datepick();

    $('#clickEvent4').bind('click', function (event) {

        $('#button1').empty();

        var eventContent = $('#clickEvent4').text();

        console.log(eventContent);

        var node1 = "<span id='eventIn4'>";

        $('#button1').text(eventContent);

        $('#button1').prepend(node1);



    });

    $('#popupDatepicker').datepick();

    $('#clickEvent5').bind('click', function (event) {

        $('#button1').empty();

        var eventContent = $('#clickEvent5').text();

        console.log(eventContent);

        var node1 = "<span id='eventIn5'>";

        $('#button1').text(eventContent);

        $('#button1').prepend(node1);



    });

});

$.fn.autogrow = function (options) {

    return this.filter('textarea').each(function () {

        var self = this;

        var $self = $(self);

        var minHeight = $self.height();

        var noFlickerPad = $self.hasClass('autogrow-short') ? 0 : parseInt($self.css('lineHeight')) || 0;



        var shadow = $('<div></div>').css({

            position: 'absolute',

            top: -10000,

            left: -10000,

            width: $self.width(),

            fontSize: $self.css('fontSize'),

            fontFamily: $self.css('fontFamily'),

            fontWeight: $self.css('fontWeight'),

            lineHeight: $self.css('lineHeight'),

            resize: 'none',

            'word-wrap': 'break-word'

        }).appendTo(document.body);



        var update = function (event) {

            var times = function (string, number) {

                for (var i = 0, r = ''; i < number; i++) r += string;

                return r;

            };



            var val = self.value.replace(/</g, '&lt;')

                                .replace(/>/g, '&gt;')

                                .replace(/&/g, '&amp;')

                                .replace(/\n$/, '<br/>&nbsp;')

                                .replace(/\n/g, '<br/>')

                                .replace(/ {2,}/g, function (space) { return times('&nbsp;', space.length - 1) + ' ' });



            // Did enter get pressed?  Resize in this keydown event so that the flicker doesn't occur.

            if (event && event.data && event.data.event === 'keydown' && event.keyCode === 13) {

                val += '<br />';

            }



            shadow.css('width', $self.width());

            shadow.html(val + (noFlickerPad === 0 ? '...' : '')); // Append '...' to resize pre-emptively.

            $self.height(Math.max(shadow.height() + noFlickerPad, minHeight));

        }



        $self.change(update).keyup(update).keydown({ event: 'keydown' }, update);

        $(window).resize(update);

        update();

    });

};

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















    $(document).delegate(".x-icon", "mouseover", function () {

        $(this).closest(".class-buttons").find(".xdescription").show();

    });

    $(document).delegate(".x-icon", "mouseout", function () {

        $(this).closest(".class-buttons").find(".xdescription").hide();

    });





    $(document).delegate(".edit-classes", "mousedown", function () {

        $(".edit-classes").hide();

        $("#done-edit-classes").show();

        $(".class-buttons").show();

    });



    $(document).delegate(".announce", "mouseover", function () {

        $(this).closest(".announcecolumn").find(".anndescription").show();

    });

    $(document).delegate(".announce", "mouseout", function () {

        $(this).closest(".announcecolumn").find(".anndescription").hide();

    });



    $(document).delegate(".addevent", "mouseover", function () {

        $(this).closest(".announcecolumn").find(".adedescription").show();

    });

    $(document).delegate(".addevent", "mouseout", function () {

        $(this).closest(".announcecolumn").find(".adedescription").hide();

    });





    $(document).delegate(".edit-classes", "mousedown", function () {

        $(".edit-classes").hide();

        $("#done-edit-classes").show();

        $(".class-buttons").show();

    });



    $(document).delegate("#done-edit-classes", "mousedown", function () {

        $(this).hide();

        $(".edit-classes").show();

        $(".class-buttons").hide();

    });







    $(document).delegate(".x-icon", "click", function () {

        var pid = "kw=" + $(this).closest(".class-one").attr("id");

        $("#blackcanvas").show();

        $(".dropconfirm").attr("id", pid);



    });





    $(document).delegate("#blackcanvas", "click", function (e) {



        if (($(e.target).is(".dropconfirm > *")) || ($(e.target).is(".dropconfirm"))) {

            return false;



        }



        $(this).hide();



    });





    $(document).delegate(".bc3cancel", "click", function (e) {



        $(".blackcanvasNew").fadeOut();

        if (animationflag == 1) {

            $("#newbc3content").animate({ marginRight: "-=700px" });

            animationflag = 0;

        }



    });









    $(document).delegate(".dbuttons", "click", function () {

        var v = $(this).val();

        $("#blackcanvas").hide();

        if (v == 1) {

            var tid = $(".dropconfirm").attr("id").split("=");

            $("#" + tid[1]).hide();

        }

        $("#blackcanvas").hide();



    });





    $(document).delegate(".dexit", "mouseover", function () {



        $(this).css("opacity", "1");

    });



    $(document).delegate(".dexit", "mouseout", function () {



        $(this).css("opacity", "1");

    });





    $(document).delegate(".dexit", "click", function () {



        $("#blackcanvas").hide();

        $("#blackcanvas2").fadeOut();





        $(".blackcanvasNew").fadeOut();

        if (animationflag == 1) {

            $("#newbc3content").animate({ marginRight: "-=700px" });

            animationflag = 0;

        }



    });







    $(document).delegate(".dexit-p", "mouseover", function () {



        $(this).css("opacity", "1");

    });



    $(document).delegate(".dexit-p", "mouseout", function () {



        $(this).css("opacity", "1");

    });





    $(document).delegate(".dexit-p", "click", function () {



        $("#blackcanvas").hide();

        $("#blackcanvas2").fadeOut();





        $(".blackcanvasNew").fadeOut();

        if (animationflag == 1) {

            $("#newbc3content").animate({ marginRight: "-=700px" });

            animationflag = 0;

        }



    });





    $(document).delegate(".edit-clubs", "mousedown", function () {

        $(".edit-clubs").hide();

        $("#done-edit-clubs").show();

        $(".club-buttons").show();

    });



    $(document).delegate("#done-edit-clubs", "mousedown", function () {

        $(this).hide();

        $(".edit-clubs").show();

        $(".club-buttons").hide();

    });



    var ut = $("#university-title").text();

    var st = $("#school-title").text();

    var mat = $("#study-title").text();

    var mit = $("#minor-title").text();

    var eml = $("#user-email").text();

    var btx = $("#bio-contents").text();

    var loc = $("#user-location").text();

    $(document).delegate(".edit-profile", "click", function () {

        $(this).addClass("pediting");

        $(this).text("Done Editing");



        $("#user-profile-info").hide();

        $("#editcolumn-u").val(ut);



        $("#editcolumn-a").val(mat);

        $("#editcolumn-i").val(mit);

        $(".editprofile").show();



        $(".peditable").hide();



        $(".emailtext").val(eml);

        $(".loctext").val(loc);

        $(".biotext").val(btx);

        $(".editingbio").show();



    });

    $(document).delegate(".peditable", "click", function () {

        $(this).hide();

        $('.biotext').contentEditable = true;



        $(".biotext").show();

        $('.biotext').contentEditable = true;



    });



    $(document).delegate(".pediting", "click", function () {



        $(this).removeClass("pediting");

        $(this).text("Edit Profile");



        $(".editprofile").hide();

        $("#university-title").text(ut);

        $("#school-title").text(st);

        $("#study-title").text(mat);

        $("#minor-title").text(mit);

        $("#user-profile-info").show();



        $(".editingbio").hide();

        $("#user-email").text(eml);

        $("#bio-contents").text(btx);

        $(".peditable").show();

        $(".peditable2").show();



        /*Ajax goes here*/

        /*ut= university title; 

         st= school title

         mat= major title

         mit= minor title

         eml= email address

         btx= bio text

         */

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

            var tid = $(this).closest(".blackcanvasNew").attr("id").split("=");

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

                $("#newstardate-input").animate({

                    marginLeft: '+=70px'

                }, 500);

                moveflag = 0;



            }







        } else {

            $("#newbc3content").animate({ marginRight: "-=700px" });



            $(".blackcanvasNew").hide();

            animationflag = 0;



        }



    });







    $(document).delegate(".addmore", "click", function () {

        $(".successinfo").hide();



        //add back removed elements





        $(".uploadform").append("<div class='uploadevent'><input type='text' id='nevt-title' placeholder='Title' class='nevt-input'><input type='text' id='nevt-location' placeholder='Location' class='nevt-input'><textarea wrap id='nevt-desc' onkeypress='taHeight()' placeholder='Details' class='nevt-input'></textarea><hr><div class='pdateinfo'><span id = 'newstardate-input'>Pick a Date &#187; <span class='stdate'></span></span><div class='frtext'>from:</div><div class='totext'>to:</div></div><div class='hourpick1'><div class='input-append bootstrap-timepicker'><input id='timepicker1' type='text' class='input-small'><span class='add-on'><i class='icon-time'></i></span></div></div><div class='hourpick2'><div class='input-append bootstrap-timepicker'><input id='timepicker2' type='text' class='input-small'><span class='add-on'><i class='icon-time'></i></span></div></div></div>");



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





        $(".blackcanvasNew").attr("id", tid);

        $(".blackcanvasNew").fadeIn();

        animationflag = 1;



        //$("#newbc3content").css("margin-right","0px");

        $("#newbc3content").animate({ marginRight: "+=700px" });

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

    //alert(w);



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

    $(document).delegate(".calcell", "click", function () {

        if (!$(this).hasClass("disable")) {

            if (blinkflag == 0) {



                cleanBlinkActive1();

                $(this).addClass("active1");

                $(this).addClass("blink1");



                var ddd = $(this).text();

                $M = months[$m];

                if (moveflag == 0) {

                    $("#newstardate-input").animate({

                        marginLeft: '-=70px'

                    }, 500);

                    moveflag = 1;

                }



                var nid = "wk=" + $(this).attr("id")

                $(".stdate").text($M + " " + ddd);

                $(".stdate").attr("id", nid);

                /*

                $(".stdate").fadeIn( 'slow', function(){ 

                                    

                                    });

                

                */





            }

            /*

            if(blinkflag==1){

            cleanBlinkActive2();

            $(this).addClass("active2");

            $(this).addClass("blink2");

            if(hp2exists==0){

            createHourPicker2();

            

            }

            }

            */

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

    $(".connect-text-linqd").hide();

    $(".connect-text-unlinq").hide();

    $(document).delegate(".connect-button", "mouseup", function () {

        $(".cb1").removeClass("connect-button");

        $(".cb1").addClass("connect-button-linqd");

        $(".connect-text").hide();

        $(".connect-icon").hide();

        $(".connect-text-linqd").show();

    });

    $(document).delegate(".connect-button-linqd", "mouseenter", function () {

        $(".cb1").removeClass("connect-button-linqd");

        $(".cb1").addClass("connect-button-unlinq");

        $(".connect-text-linqd").hide();

        $(".connect-text-unlinq").show();

    });



    $(document).delegate(".connect-button-unlinq", "mouseleave", function () {

        $(".cb1").removeClass("connect-button-unlinq");

        $(".cb1").addClass("connect-button-linqd");

        $(".connect-text-unlinq").hide();

        $(".connect-text-linqd").show();

    });

    $(document).delegate(".connect-button-unlinq", "mouseup", function () {

        $(".cb1").removeClass("connect-button-unlinq");

        $(".cb1").addClass("connect-button");

        $(".connect-text-unlinq").hide();

        $(".connect-icon").show();

        $(".connect-text").show();

    });



    var curHeight = 0;

    $(document).delegate(".cal-group-hider", "click", function () {

        //curHeight = $('.cal-groups').height();

        //$('.cal-groups').animate({ height: '0px', opacity: '0' }, "medium");

        //$('.cal-group-hider').text("Show");



        //$('.cal-group-hider').addClass('cal-group-showr');

        //$('.cal-group-hider').removeClass('cal-group-hider');



        curHeight = $(this).parent().parent().children('.cal-groups').height();

        $(this).parent().parent().children('.cal-groups').animate({ height: '0px', opacity: '0' }, "medium");

        $(this).text("Show");



        $(this).addClass('cal-group-showr');

        $(this).removeClass('cal-group-hider');

    });



    $(document).delegate(".cal-group-showr", "click", function () {

        //$('.cal-groups').animate({ height: curHeight, opacity: '1' }, "medium");

        //$('.cal-group-showr').text("Hide");

        //$('.cal-group-showr').addClass('cal-group-hider');

        //$('.cal-group-showr').removeClass('cal-group-showr');

        $(this).parent().parent().children('.cal-groups').animate({ height: curHeight, opacity: '1' }, "medium");

        $(this).text("Hide");

        $(this).addClass('cal-group-hider');

        $(this).removeClass('cal-group-showr');

    });


    $('.fixed-events-tabs').css("display", "none");
    $(document).delegate(".cal_view_events", "click", function () {

        if ($('.cal_view_events').text().trim() == "Event Book") {
            $('.fc-content').animate({ height: '0px', opacity: '0' }, "fast", function () {
                $('.fc-content').delay(400).css('display', 'none');
                $('.fc-header').delay(400).css('display', 'none');
                $('.month-fbtns').delay(0).css('display', 'none');
                $('.incomplete-wrap').delay(0).css('display', 'none');
                $('.fixed-cal-fbar').delay(100).css('display', 'none');
                $('.fixed-cal-fbar').delay(0).css('display', 'none');
            });
            $('.fixed-events-tabs').css('display', 'block');
            $('.event-tabs-border').css('display', 'block');
            $('.event_view').css('display', 'inline-block');
            // toggle for button type
            $('.fixed-events-tabs').css({ "display": "block", "opacity": "1" });
            $('.event_view').animate({ opacity: '1' }, "medium");
            //$('.midsec').css({ "height": "540px", "margin-bottom": "20px" });
            //$('.leftsec').css('height', '574px');
            //$('.rightsec').css('height', '575px');
            $('.cal_view_events').text("Monthly Planner");
            $('.cal_view_monthly').text("Event Book");

            DisplayEventBook();
        }
        else {
            $('.fc-content').animate({ height: 'auto', opacity: '1' }, "fast", function () {
                $('.fc-content').delay(400).css('display', 'block');
                $('.fc-header').delay(400).css('display', 'block');
                $('.month-fbtns').delay(0).css('display', 'block');
                $('.incomplete-wrap').delay(0).css('display', 'block');
                $('.fixed-cal-fbar').delay(100).css('display', 'block');
                $('.fixed-cal-fbar').delay(0).css('display', 'block');
            });

            $('.fixed-events-tabs').css('display', 'none');
            $('.event-tabs-border').css('display', 'none');
            $('.event_view').css('display', 'none');

            // toggle for button type
            $('.fixed-events-tabs').css({ "opacity": "0" });
            $('.event_view').animate({ opacity: '0' }, "medium");
            //$('.midsec').css({ "height": "540px", "margin-bottom": "20px" });
            //$('.leftsec').css('height', '574px');
            //$('.rightsec').css('height', '575px');
            $('.cal_view_events').text("Event Book");
            $('.cal_view_monthly').text("Monthly Planner");
        }
    });

    $(document).delegate(".repeatoptiont", "mouseover", function () {
        $(this).css({ "color": "#30E680", "border-bottom": "1px solid #30E680" });
    });

    $(document).delegate(".repeatoptiont", "mouseout", function () {
        $(this).css({ "color": "rgba(0,0,0,0.7)", "border-bottom": "1px solid #ccc" });
    });
    $(document).delegate(".repeatstate", "mouseover", function () {
        $(this).css({ "opacity": "1" });
        $(".repeatoption").fadeIn();
    });

    $(document).delegate(".repeatstate", "mouseout", function () {
        $(this).css({ "opacity": "1" });
        $(".repeatoption").fadeOut();
    });

    $(document).delegate(".repeatoption", "mouseout", function () {
        $(".repeatoption").fadeOut();
    });

    $(document).delegate(".repeatstate", "mouseout", function () {
        $(this).css({ "opacity": "0.7" });
    });

    $(document).delegate(".repeatoption", "mouseover", function () {
        $(this).stop(true, true).show();
    });

    $(document).delegate(".repeatstate-1", "click", function () {
        $(this).parent().children(".repeatoption-1").toggle();
    });

    $(document).delegate(".repeatoptiont-1", "click", function () {
        $(this).parent().parent().children(".repeatstate-1").text($(this).text());
        $(this).parent().children(".repeatoption-1").hide();
        if ($(this).text().trim() != "None") {
            $('.repeat_date').show();
        }
        else {
            $('.repeat_date').hide();
        }
    });

    $(document).on("click", function (e) {
        var elem = $(e.target);
        if (elem.hasClass("repeatstate-1")) {
            //alert();
            //$('.repeatoption-1').css('display', 'none');
            $(this).children('.repeatoption-1').css('display', 'block');
        }
        else {
            $('.repeatoption-1').css('display', 'none');
        }

        if (elem.hasClass('blackcanvas30')) {
            $(".blackcanvas30").fadeOut();
            $("#bc3contentAddEvent").css('display', 'none');
            /*$("#bc3contentAddEvent").css('margin-top', '-600px');
            $("#bc3contentAddEvent").animate({ marginTop: "-=600px", marginTop: "transition: all 0.5s ease-in-out;" });*/
        }

        if (!elem.hasClass("fa fa-caret-down open_Menu")) {
            //alert();
            if ($('.pl_options').is(':visible')) {
                $('.pl_options').toggleClass('unhider');
                $('.fa-caret-down').toggleClass('open_Menu');
            }
        }
    });

    $('#timepicker1').timepicker();
    $('#timepicker2').timepicker();
    $('.incomplete-wrap').mouseover(function () {
        $('.explain-2').css('visibility', 'visible');
        $('.explain-2').mouseover(function () {
            $('.explain-2').css('visibility', 'visible');
        });
        $('.explain-2').mouseout(function () {
            $('.explain-2').css('visibility', 'hidden');
        });
        $('.incomplete-wrap').mouseout(function () {
            $('.explain-2').css('visibility', 'hidden');
        });
    });

    var lastScrollTop = 0;

    $(window).scroll(function (event) {
        //scroll function part
        var st = $(this).scrollTop();
        if (st > lastScrollTop) {
            var inc = st - lastScrollTop;
            var offset_fcheader = $(".fc-header").offset();
            var offset_fixedcalfbar = $(".fixed-cal-fbar").offset();
            var offset_monthfbtns = $(".month-fbtns").offset();
            var offset_incompletewrap = $(".incomplete-wrap").offset();
            var offset_explain2 = $(".explain-2").offset();
            $(".fc-header").offset({ top: inc + offset_fcheader.top });
            $(".fixed-cal-fbar").offset({ top: inc + offset_fixedcalfbar.top });
            $(".month-fbtns").offset({ top: inc + offset_monthfbtns.top });
            $(".incomplete-wrap").offset({ top: inc + offset_incompletewrap.top });
            $(".explain-2").offset({ top: inc + offset_explain2.top });
        } else {
            var inc = st - lastScrollTop;
            var offset_fcheader = $(".fc-header").offset();
            var offset_fixedcalfbar = $(".fixed-cal-fbar").offset();
            var offset_monthfbtns = $(".month-fbtns").offset();
            var offset_incompletewrap = $(".incomplete-wrap").offset();
            var offset_explain2 = $(".explain-2").offset();
            $(".fc-header").offset({ top: inc + offset_fcheader.top });
            $(".fixed-cal-fbar").offset({ top: inc + offset_fixedcalfbar.top });
            $(".month-fbtns").offset({ top: inc + offset_monthfbtns.top });
            $(".incomplete-wrap").offset({ top: inc + offset_incompletewrap.top });
            $(".explain-2").offset({ top: inc + offset_explain2.top });
        }
        lastScrollTop = st;

        //scroll appearance part
        if (st != 0) {
            $(".fixed-cal-fbar").css({ "box-shadow": "0 2px 2px -1px rgba(0,0,0,.1)" });
        } else {
            $(".fixed-cal-fbar").css({ "box-shadow": "none" });
        }
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
});

$(document).ready(function () {
    var date = new Date();
    var d = ("0" + date.getDate()).slice(-2);
    var m = ("0" + (date.getMonth() + 1)).slice(-2);
    var y = date.getFullYear();
    var monthdate = (y + "-" + m + "-" + d);
    var eventString = "";
    $.ajax({
        url: "php/calendar_fetch.php",
        data: { month_date: monthdate },
        type: "POST",
        dataType: "json",
        success: function (responseText) {
            for (var i = 0; i < responseText.events_array.length; i++) {
                var locn = "";
                if (responseText.events_array[i]["location"] != "null"){
                    locn = responseText.events_array[i]["location"];
                }
                var starttoendtime = "";
                if (responseText.events_array[i]["start_time"] != null) {
                    var hours = responseText.events_array[i]["start_time"].substr(0, 2) == 0 ? "12" :
                        responseText.events_array[i]["start_time"].substr(0, 2) > 12 ? ("0" + (responseText.events_array[i]["start_time"].substr(0, 2) - 12)).slice(-2)
                        : ("0" + responseText.events_array[i]["start_time"].substr(0, 2)).slice(-2);
                    var minutes = responseText.events_array[i]["start_time"].substr(3, 2);
                    var ampm = responseText.events_array[i]["start_time"].substr(0, 2) < 12 ? "am" : "pm";
                    starttoendtime = hours + ":" + minutes + " " + ampm;
                }
                if (responseText.events_array[i]["end_time"] != null) {
                    var hours = responseText.events_array[i]["end_time"].substr(0, 2) == 0 ? "12" :
                        responseText.events_array[i]["end_time"].substr(0, 2) > 12 ? ("0" + (responseText.events_array[i]["end_time"].substr(0, 2) - 12)).slice(-2)
                        : ("0" + responseText.events_array[i]["end_time"].substr(0, 2)).slice(-2);
                    var minutes = responseText.events_array[i]["end_time"].substr(3, 2);
                    var ampm = responseText.events_array[i]["end_time"].substr(0, 2) < 12 ? "am" : "pm";
                    if (starttoendtime != (hours + ":" + minutes + " " + ampm))
                    {
                        starttoendtime += " to " + (hours + ":" + minutes + " " + ampm);
                    }                    
                }

                $('#calendar').fullCalendar('renderEvent',
                 {                     
                     id: responseText.events_array[i]["event_id"],
                     title: responseText.events_array[i]["title"],
                     start: responseText.events_array[i]["start_date"],
                     end: responseText.events_array[i]["end_date"],
                     allDay: true,
                     type: responseText.events_array[i]["type"],
                     editable: responseText.events_array[i]["editable"],
                     location: locn,
                     startendtime: starttoendtime
                     //"startEditable: " + "true" + "," +
                     //"durationEditable: " + "true" + "," +
                     //"allDay: " + "false" 
                     //url: 
                 },
                 true // make the event "stick"
               );
            }
        },
        error: function (responseText) {
            alert("error " + responseText);
        }
    });
    var calendar = $('#calendar').fullCalendar({
        height: 700,
        aspectRatio: 1.3,
        weekMode: 'variable',
        header: {
            left: 'prev,title,next',
            center: 'month,agendaWeek,agendaDay',
            right: 'prevYear,today,nextYear'
        },
        buttonText: {
            prevYear: '&lt;',
            nextYear: '&gt;'
        },
        selectable: true,
        selectHelper: true,
        viewRender: function (view, element) {
            console.log(view);
            console.log(element);
            if (view.name === 'month') {
                $('#calendar').fullCalendar('option', 'contentHeight', 700);
            } else {
                $('#calendar').fullCalendar('option', 'contentHeight', 600);
            }
        },
        select: function (start, end, allDay) {
            var param1 = new Date(start);
            var param2 = (param1.getMonth() + 1) + '/' + param1.getDate() + '/' + param1.getFullYear();
            $("#event_date").attr("value", param2);
            $('#addEvent').trigger("click");
        },
        events: [eventString],
        eventClick: function (calEvent, jsEvent, view) {
            $('#calendar').fullCalendar('updateEvent', calEvent);
        },
    });

    $('input[name="check-box"]').wrap('<div class="check-box"><i></i></div>');

    $.fn.toggleCheckbox = function () {
        this.attr('checked', !this.attr('checked'));
    }

    $(document).delegate(".check-box", "click", function () {
        $(this).find(':checkbox').toggleCheckbox();
        $(this).toggleClass('checkedBox');
    });

    var tab_active = $(".event_tab_active");
    var active_width = tab_active.width();
    //$(".tab-indicator").css("width",active_width);

    $(document).delegate(".event_tab", "click", function () {
        $(".event_tab_active").removeClass("event_tab_active");
        $(this).addClass("event_tab_active");
        var el = $(this);
        var position = el.position();
        var width = el.width();
        var pos_left = position.left;
        var pos_tab_indicator = pos_left + 18;
        $(".tab-indicator").css("left", pos_tab_indicator);
        $(".tab-indicator").css("width", width);
    });

    $(".fc-today").parent().addClass("fc-current-week");
    $(document).delegate(".fc-button-today, .fc-button-prev, .fc-button-next", "click", function () {
        if ($('.fc-today').is(':visible')) {
            $(".fc-today").parent().addClass("fc-current-week");
        }
    });
});

$(document).ready(function () {
    $(function () {
        $('#nevt-desc-1').autogrow();
        $('#nevt-desc-1').css('overflow', 'hidden').autogrow()

    });

    $.fn.autogrow = function (options) {
        return this.filter('textarea').each(function () {
            var self = this;
            var $self = $(self);
            var minHeight = $self.height();
            var noFlickerPad = $self.hasClass('autogrow-short') ? 0 : parseInt($self.css('lineHeight')) || 0;
            var shadow = $('<div></div>').css({
                position: 'absolute',
                top: -10000,
                left: -10000,
                width: $self.width(),
                fontSize: $self.css('fontSize'),
                fontFamily: $self.css('fontFamily'),
                fontWeight: $self.css('fontWeight'),
                lineHeight: $self.css('lineHeight'),
                resize: 'none',
                'word-wrap': 'break-word'
            }).appendTo(document.body);

            var update = function (event) {
                var times = function (string, number) {
                    for (var i = 0, r = ''; i < number; i++) r += string;
                    return r;
                };

                var val = self.value.replace(/</g, '&lt;')
                                    .replace(/>/g, '&gt;')
                                    .replace(/&/g, '&amp;')
                                    .replace(/\n$/, '<br/>&nbsp;')
                                    .replace(/\n/g, '<br/>')
                                    .replace(/ {2,}/g, function (space) { return times('&nbsp;', space.length - 1) + ' ' });

                // Did enter get pressed?  Resize in this keydown event so that the flicker doesn't occur.
                if (event && event.data && event.data.event === 'keydown' && event.keyCode === 13) {
                    val += '<br />';
                }
                shadow.css('width', $self.width());
                shadow.html(val + (noFlickerPad === 0 ? '...' : '')); // Append '...' to resize pre-emptively.
                $self.height(Math.max(shadow.height() + noFlickerPad, minHeight));
            }
            $self.change(update).keyup(update).keydown({ event: 'keydown' }, update);
            $(window).resize(update);
            update();
        });
    };

    $(document).delegate("#divCancel", "click", function (e) {
        $(".blackcanvas30").fadeOut();
        $("#bc3contentAddEvent").css('display', 'none');
        /*$("#bc3contentAddEvent").css('margin-top', '-600px');
        $("#bc3contentAddEvent").animate({ marginTop: "-=600px", marginTop: "transition: all 0.5s ease-in-out;" });*/
    });

    $(document).delegate("#divClose", "click", function (e) {
        $("#divInviteConnections").hide();
    });

    $(document).delegate("#addEvent", "click", function () {
        $(".blackcanvas30").fadeIn();
        $("#bc3contentAddEvent").css('display', 'block');
        /*$("#bc3contentAddEvent").animate({ marginTop: "+=600px" });*/
    });

    $currentTime = new Date().getHours() + ':' + new Date().getMinutes() + ':00';
    $('#set_from_time_24hr').timeAutocomplete({
        increment: 15,
        formatter: 'ampm',
        start_hour: 0,
        value: $currentTime
    });
    $('#set_to_time_24hr').timeAutocomplete({
        increment: 15,
        formatter: 'ampm',
        start_hour: 0,
        value: $currentTime
    });



    $('#btnAddThisEvent').click(function () {
        var start = new Date($('#event_date').val());
        start = start.getFullYear() + '-' + ('0' + (start.getMonth() + 1)).substr(-2, 2) + '-' + ('0' + start.getDate()).substr(-2, 2);
        var end = start;
        var locn = $('#nevt-location-1').val().toString();
        var title = $('#nevt-title-1').val().toString();
        var desc = $('#nevt-desc-1').val().toString();
        var fromtime = $('#set_from_time_24hr').val().toString();
        var totime = $('#set_to_time_24hr').val().toString();
        var repeat = $('.repeatstate-1').text().toString().toLowerCase();
        var event_id = $('#event_id').text();
        var event_type = $('#event_type').text();
        var phpFilePath = "php/event_insert.php";
        var dataString = "";

        var starttoendtime = fromtime;
        if (fromtime != totime)
        {
            starttoendtime += " to " + totime;
        }
        if (event_id == "") {
            if (title) {
                $('#calendar').fullCalendar('renderEvent',
                  {
                      title: title,
                      start: start,
                      end: end,                      
                      allDay: true,                      
                      editable: true,
                      location: locn,
                      startendtime: starttoendtime
                  },
                  true // make the event "stick"
                );
            }
            dataString = "{ title: " + title + ", location: " + locn + ", details:" + desc + ", start_date:" + start + ", end_date:" + end + ", start_time:" + fromtime
                + ", end_time: " + totime + ", repeat: " + repeat + ", connections: " + allVals + "}";
        }
        else {
            phpFilePath = "php/edit_event_insert.php";
            dataString = "{ title: " + title + ", location: " + locn + ", details:" + desc + ", start_date:" + start + ", end_date:" + end + ", start_time:" + fromtime
                + ", end_time: " + totime + ", repeat: " + repeat + ", connections: " + allVals + ", event_id: " + event_id + ", type: " + event_type + "}";
        }
        $('#calendar').fullCalendar('unselect');
        $('#divCancel').trigger("click");

        //To fetch the details of the invitees
        var allVals = [];
        $('#inviteConnections :checked').each(function () {
            allVals.push($(this).val());
        });

        var file_exist_proof = $("#upload_feed_hack").val();
        if (file_exist_proof != "") {
            var formData = new FormData($("#upload_feed_hack").closest("form")[0]);
            formData.append("title", title);
            formData.append("location", locn);
            formData.append("details", desc);
            formData.append("start_date", start);
            formData.append("end_date", end);
            formData.append("start_time", fromtime);
            formData.append("end_time", totime);
            formData.append("repeat", repeat);
            formData.append("connections", allVals);
            if (event_id != "")
            {
                formData.append("event_id", event_id);
                formData.append("type", event_type);
            }
            $.ajax({
                type: "POST",
                url: phpFilePath,
                xhr: function () {  // Custom XMLHttpRequest
                    var myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) { // Check if upload property exists
                        myXhr.upload.addEventListener('progress', progressHandlingFunction, false); // For handling the progress of the upload
                    }
                    return myXhr;
                },
                data: formData,
                contentType: false,
                processData: false,
                success: function (responseText) {
                    alert("event added");
                    clearInsertFields();
                },
                error: function (responseText) {
                    alert("event creation falied");
                }
            });
        }
        else {
            $.ajax({
                url: phpFilePath,
                data: dataString,
                //    {
                //        title: title, location: locn, details: desc, start_date: start, end_date: end, start_time: fromtime
                // , end_time: totime , repeat:  repeat , connections:  allVals   
                //},
                type: "POST",
                dataType: "text",
                success: function (responseText) {
                    alert(responseText);
                    clearInsertFields();
                },
                error: function (responseText) {
                    alert("failure");
                }
            });
        }
    });
    
    //when scroll
    $(window).scroll(function () { 
        if ($('.cal_view_monthly').text() == "Event Book") {
            var id = "";
            var daytime = "";
            var time = "";
            var type = "";
            $("li").each(function (index) {
                var scrollWindow = ((($(this).children(":first")).offset()).top - $(window).scrollTop());
                if ((scrollWindow >= 100) && (scrollWindow <= 140)) {
                    document.getElementById('currentEvent').innerHTML = ($(this).children(":first")).text();
                    ($(this).children(":first")).addClass("fade-out");
                    ($(this).children(":first")).removeClass("fade-in");
                }
                else {
                    if (!($(this).children(":first")).hasClass("hide")) {
                        ($(this).children(":first")).addClass("fade-in");
                        ($(this).children(":first")).removeClass("fade-out");
                    }
                }
                //if ($(window).scrollTop() >= 10) {
                //    $('.fixed-events-tabs').addClass("fade-in");
                //    $('.fixed-events-tabs').removeClass("fade-out");
                //}
                //else {
                //    $('.fixed-events-tabs').addClass("fade-out");
                //    $('.fixed-events-tabs').removeClass("fade-in");
                //}      
                id = ($(this).prop('id')).split('_')[0];
                type = ($(this).prop('id')).split('_')[1];
                time = $(this).find(".event-data1").text();
                daytime = ($(this).prop('id')).split('_')[2];
            });
            var documentHeight = $(document).height();
            var scrollDifference = $(window).height() + $(window).scrollTop();
            if (documentHeight == scrollDifference) {
                InfiniteScrollEventBook(id, daytime, type, time);    
                //alert(id + " " + daytime + " " + type + " " + time);
            }
        }
    });

    $(document).delegate('#event_date', 'click', function () {
        //        $('.calLayer').css('display', 'block');
        $(this).parents("#startdate-input-1").children('.calLayer').toggle();
    });

    $(document).delegate('#img_cal_filter', 'click', function () {
        //        $('.calLayer').css('display', 'block');
        $(this).parents(".event_view_cal").children('.calLayer').toggle();
    });

    $(document).delegate('#repeat_end_date', 'click', function () {
        //        $('.calLayer').css('display', 'block');
        $(this).parents(".repeat_date").children('.calLayer').toggle();
    });

    $(document).delegate(".reply_attach", "click", function () {
        $(this).closest(".lfloat-mods").find('.upload_feed_hack').click();
    });

    $(document).delegate(".upload_feed_hack", "change", function () {
        var $hack = $(this);

        var filename = $hack.val();
        if (filename.length >= 18) {
            filename = filename.substring(0, 15) + "...";
        }

        $(this).closest(".lfloat-mods").find(".feed_upload_textprompt").text(filename);
        $(this).closest(".lfloat-mods").find(".feed_upload_textprompt").attr("title", $hack.val());
    });


    $(document).delegate("#btn_select_event", "click", function () {
        window.location.hash = ((new Date()).toUTCString()).substr(0, 11);
        $(window).scrollTop(($(window).scrollTop() - 120));
    });

    $(document).delegate(".attachment_img", "mouseover", function () {
        $(this).parent().children('.tooltip').stop().show();
    });

    $(document).delegate(".attachment_img", "mouseout", function () {
        $(this).parent().children('.tooltip').delay(300).hide(0);
    });

    $(document).delegate(".tooltip", "mouseover", function () {
        $(this).parents('.header_wrapper').children('.tooltip').stop().show();
    });
    $(document).delegate(".tooltip", "mouseout", function () {
        $(this).parents('.header_wrapper').children('.tooltip').delay(300).hide(0);
    });

});

// to show the tooltip for the events
var timer;
function showTooltip(sender) {
    if (!$(sender).parent().hasClass("ui-draggable-dragging")) {
        var tooltip = $(sender).children('.editTooltip');
       // tooltip.offset({ top: ($(sender).offset().top - (tooltip.height() / 2)), left: ($(sender).offset().left + $(sender).width()) });                

        var $this = $(sender);
        clearTimeout(timer);
        timer = setTimeout(function () {
            if ($(sender).parent().css('left').slice(0, -2) > 700) {
                tooltip.css('left', -(tooltip.width() + 5));
            }
            else {
                tooltip.css('left', 146);
            }
            tooltip.css('display', 'block');
            tooltip.css('top', (-(tooltip.height() / 2)));
            tooltip.css('z-index', '1000');
            tooltip.css("position", "absolute");
        }, 500);
    }
}

function hideTooltip(sender) {
    $(sender).children('.editTooltip').delay(300).hide(0);
    clearTimeout(timer);
}

function tooltipShow(sender) {
    $(sender).stop().show();
}

function tooltipHide(sender) {
    if (!($(sender).parents('.fc-event-inner'))) {
        $(sender).delay(300).hide(0);
    }
}

//File upload
function progressHandlingFunction(e) {
    if (e.lengthComputable) {
        $('progress').attr({ value: e.loaded, max: e.total });
    }
}

// Implement the show and hide functionality for the description
function showHide(sender) {
    var more = $(sender).closest('.event_info').children('.more');
    var show = $(sender).closest('.event_info').children('.showLink');
    var hide = $(sender).closest('.event_info').children('.hideLink');
    if (more.is(':visible')) {
        more.css('display', 'none');
        hide.css('display', 'none');
        show.css('display', 'inline-block');
    }
    else {
        more.css('display', 'inline');
        show.css('display', 'none');
        hide.css('display', 'inline-block');
    }
}

function FilterEvents(sender) {
    var date = sender.innerHTML + " " + $(sender).parents('.mounth').children('.minical-header').children('.minical-h1').text();
    window.location.hash = ((new Date(date)).toUTCString()).substr(0, 11);
    $(window).scrollTop(($(window).scrollTop() - 120));
}

function FetchFile(fileID) {
    window.open("php/download_file.php?file_id=" + fileID, "hiddenFrame");
}

function toggleDiscussion(sender) {
    $(".qa_scrollcontainer").animate({ scrollTop: 1000 }, 1);
    var discussions = $(sender).closest('.desc').children('.event_qa');
    if (discussions.is(':visible')) {
        discussions.css('display', 'none');
        $(sender).text("Show Discussions");
    }
    else {
        discussions.css('display', 'inline-block');
        $(sender).text("Hide Discussions");
    }
}

function toggleInviteConnections(sender) {
    $('#divInviteConnections').show();
    if ($("#inviteConnections").children('.invite_content').length == 0) {
        $.ajax({
            url: "php/connections.php",
            data: {
                user_id: 1, event_id: 17
            },

            type: "POST",
            dataType: "json",
            success: function (responseText) {
                //0 - id
                //1 - first name 
                //2 - last name
                //3 - pic name 
                //4 - pic location
                //alert(responseText);//.people_array.length);
                //7 - invitee 0 yes 1 no
                var floatVal = "left";
                for (var i = 0; i < responseText.people_array.length; i++) {
                    if (i % 2 == 0) {
                        floatVal = "left";
                    }
                    else {
                        floatVal = "right";
                    }
                    $("#inviteConnections").append('<div class="invite_content '
                        + floatVal + '">' +
                        '<div class="invite_box" id="invite_details_box' + i + '">' +
                            '<div class="invite_image" id="inviteeImg' + i + '">' +
                            '</div>' +
                            '<div class="invite_details_box">' +
                                '<a href="#" class="ibNameLink">' +
                                '<div class="invitee_name">' + responseText.people_array[i][1] + ' ' +
                                responseText.people_array[i][2] + '</div>' +
                                '<div class="invitee_major">' + responseText.people_array[i][6] + '</div>' +
                                '<div class="invitee_school">' + responseText.people_array[i][5] + '</div>' +
                                '</a>' +
                            '</div>'
                            + '<input type="checkbox" class="invite-check-box" id="invite-check-box' + i + '" value="' + responseText.people_array[i][0] + '" />' +
                            '<div class="invite">&nbsp;</div>' +
                        '</div>' +
                    '</div>');

                    var path = 'url("' + '/DEMO/' + responseText.people_array[i][4] + '/' + responseText.people_array[i][3] + '")';
                    $('#inviteeImg' + i).css('background', path);
                    $('#inviteeImg' + i).css('background-size', '100% 100%');

                    if (responseText.people_array[i][7] == "1") {
                        //$('#invite_details_box' + i).css('opacity', '0.5');
                        $('#invite_details_box' + i).css('cursor', 'default');
                        $('#invite_details_box' + i).children('.ibNameLink').css('cursor', 'default');
                        $('#invite_details_box' + i).parent('.invite_content').addClass('invited_content');
                        $('#invite_details_box' + i).parent('.invite_content').removeClass('invite_content');//css('background-color', '#EBEBEB');                            
                        $('#invite_details_box' + i).children('.invite_details_box').children('.ibNameLink').css('color', '#FFF');
                        $('#invite-check-box' + i).prop('checked', true);
                        $('#invite_details_box' + i).children('.invite').addClass('invited');
                        connectionsInvited += 1;
                    }
                    else {
                        $('#invite_details_box' + i).css('cursor', 'pointer');
                        $('#invite_details_box' + i).children('.invite').addClass('toinvite');
                        $('#invite_details_box' + i).children('.ibNameLink').css('cursor', 'pointer');
                        $('#invite_details_box' + i).click(function () { invite(this); });
                    }
                }
                $('#invitedConnections').text(connectionsInvited + ' connections invited');
            },
            error: function (responseText) {
                alert("failure");
            }
        });
    }
    else {
        $('.invite_connections').css('position', 'relative');
    }
}

function UpdateDragableEvents(id, type, n) {
    $.ajax({
        url: "php/drag_update_calendar.php",
        data: {
            user_id: 1, event_id: id, type: type, changed_days: n
        },
        type: "POST",
        dataType: "text",
        success: function (responseText) {
            //alert(responseText);
        },
        error: function (responseText) {
            alert(responseText);
        }
    });
}

var connectionsInvited = 0;
function invite(sender) {
    var checkbox = $(sender).children('.invite-check-box');
    if (checkbox.prop('checked')) {
        connectionsInvited -= 1;
        checkbox.prop('checked', false);
        $(sender).children('.invite_details_box').css('opacity', '1');
        $(sender).children('.invite_details_box').css('background-color', 'transparent');
        $(sender).children('.invite_details_box').children('.ibNameLink').css('color', '#424141');
        $(sender).children('.invite').addClass('toinvite');
        $(sender).children('.invite').removeClass('invited');
    }
    else {
        connectionsInvited += 1;
        checkbox.prop('checked', true);
        //$(sender).children('.invite_details_box').css('opacity', '0.5');
        $(sender).children('.invite_details_box').css('background-color', '#759E96');
        $(sender).children('.invite_details_box').children('.ibNameLink').css('color', '#FFF');
        $(sender).children('.invite').addClass('invited');
        $(sender).children('.invite').removeClass('toinvite');
    }
    $('#invitedConnections').text(connectionsInvited + ' connections invited');
}

var prevEventDate = "";
function DisplayEventBook() {
    // 1 to do 	-	title date time 
    // 2 personal	- 	title date time - if - desc locn attachments
    // 3 personal invited -	title date time - if - desc locn invited by accepted cnt atchmnts
    // 4 group personal 	-	title date time pic  - if - desc locn atchmnts
    // 5 group 	-	title date time pic  - if - desc locn invited by accepted cnt atchmnts
    // 6 course personal
    // 7 course

    var date = new Date();
    date = (date.getFullYear() + "-" + ("0" + (date.getMonth())).slice(-2) + "-" + ("0" + date.getDate()).slice(-2));    
    $.ajax({
        url: "php/event_book_fetch.php",
        data: { event_id: null, time: "00:00:00", date: date, type: null }, // event_id  time date  yyyy-mm-dd
        type: "POST",
        dataType: "json",
        success: function (responseText) {
            if ($(".timeline").children("li").length == 1) {
                DisplayEvents(responseText.events_array);                
            }
        },
        error: function (responseText) {
            alert("error " + responseText);
        }
    });
}

function DisplayToDo(ary, formattedTime) {
    var appendVal = "";
    if (prevEventDate != (new Date(ary['start_date'])).toUTCString().substr(0, 11)) {
        prevEventDate = (new Date(ary['start_date'])).toUTCString().substr(0, 11);
        appendVal += '<li id="' + ary['event_id'] + "_" + ary['type'] + "_" + (new Date(ary['start_date'])).toUTCString().substr(0, 16) + '"><div class="event_day_time" id="' + prevEventDate + '">' + prevEventDate + '</div>'
    }
    else {
        appendVal += '<li id="' + ary['event_id'] + "_" + ary['type'] + "_" + (new Date(ary['start_date'])).toUTCString().substr(0, 16) + '" style="position:relative; top:-35px;padding:0px;"><div class="event_day_time fade-out hide">' + prevEventDate + '</div>'
    }
    appendVal += '<div class="flag-wrapper direction-r">'
                + '<span class="flag1"></span>'
                + '<span class="arrow_box">'
                    + '<div class="left_data1">'
                        + '<img class="event_icons1" src="img/time_icon.png">'
                        + '<div class="event-data1">'
                        + formattedTime
                    + '</div>'
                + '</div>'
            + '</span>'
        + '</div>'
        + '<div class="direction-r">'
            + '<div class="desc">'
                + '<div class="event_main_header">'
                    + '<div class="event-content">'
                            + '<div class="header_wrapper" style="border:none;">'
                                + '<div class="event-header-left">'
                                    + '<div class="event_title">';
    if ((ary['title'] != null)) {
        appendVal += ary['title'];
    }
    appendVal += '</div></div></div></div></div></div></div></li>';
    return appendVal;
}

function DisplayPersonalInvited(ary, formattedTime) {
    var appendVal = "";
    if (prevEventDate != (new Date(ary['start_date'])).toUTCString().substr(0, 11)) {
        prevEventDate = (new Date(ary['start_date'])).toUTCString().substr(0, 11);
        appendVal += '<li id="' + ary['event_id'] + "_" + ary['type'] + "_" + (new Date(ary['start_date'])).toUTCString().substr(0, 16) + '"><div class="event_day_time" id="' + prevEventDate + '">' + prevEventDate + '</div>'
    }
    else {
        appendVal += '<li id="' + ary['event_id'] + "_" + ary['type'] + "_" + (new Date(ary['start_date'])).toUTCString().substr(0, 16) + '" style="position:relative; top:-35px;padding:0px;"><div class="event_day_time fade-out hide">' + prevEventDate + '</div>'
    }
    appendVal += '<div class="flag-wrapper direction-r">'
                                                   + '<span class="flag1"></span>'
                                                   + '<span class="arrow_box">'
                                                       + '<div class="left_data1">'
                                                           + '<img class="event_icons1" src="img/time_icon.png">'
                                                           + '<div class="event-data1">'
                           + formattedTime
                           + '</div>'
                       + '</div>'
                   + '</span>'
               + '</div>'
               + '<div class="direction-r">'
                   + '<div class="desc">'
                       + '<div class="event_main_header">'
                           + '<div class="event-content">'
                            //+ '<div class="event_right">'
                                + '<div class="header_wrapper">'
                                    + '<div class="event-header-left">'
                                        + '<div class="event_title">';
    if ((ary['title'] != null)) {
        appendVal += ary['title'];
    }
    appendVal += '</div>'
    + '</div>';
    if (ary['file_id'] != null) {
        appendVal += '<div class="attachment_img">&nbsp;</div>'
            + '<div class="tooltip">'
                + '<div class="explain-2-box" style="top:0px;">'
                    + '<div class="explain-wedge">'
                    + '</div>'
                    + '<b class="file_link">'
                                            + '<a onclick="FetchFile(' + ary['file_id'] + ');">'
                                                + ary['file_name'] + '</a>'
                                        + '</b>'
                + '</div>'
            + '</div>';
    }
    appendVal += '</div>';
    if ((ary['location'] != null)) {
        appendVal += '<div class="info_wrapper" style="border-bottom: 1px solid #E9EAED;width:100%;">'
            + '<div class="right_data" style="border-right:none;">'
                + '<img class="event_icons" src="img/location_icon.png">'
                + '<div class="event-data">'
                + ary['location']
        + '</div></div>';
        if (ary['created_by'] != null) {
            if (ary['created_by'] == "0") {
                appendVal += '<div class="event_join">'
                                + '<div class="left_btn event_status_btn">'
                                    + 'Accept'     // choice 0 nothing 1 accept 2 maybe 3 decline
                                + '</div>'
                                + '<div class="center_btn event_status_btn">'
                                    + 'Maybe'
                                + '</div>'
                                + '<div class="right_btn event_status_btn">'
                                    + 'Decline'
                                + '</div>'
                            + '</div>';
            }
        }
        appendVal += '</div>';
    }
    else {
        if (ary['created_by'] != null) {
            if (ary['created_by'] == "0") {
                appendVal += '<div class="info_wrapper" style="border-bottom: 1px solid #E9EAED;width:100%;">';
                appendVal += '<div class="event_join">'
                                + '<div class="left_btn event_status_btn">'
                                    + 'Accept'     // choice 0 nothing 1 accept 2 maybe 3 decline
                                + '</div>'
                                + '<div class="center_btn event_status_btn">'
                                    + 'Maybe'
                                + '</div>'
                                + '<div class="right_btn event_status_btn">'
                                    + 'Decline'
                                + '</div>'
                            + '</div>';
                appendVal += '</div>';
            }
        }
    }
    if ((ary['description'] != null)) {
        appendVal += '<div class="info_wrapper bottom_right_data" style="border-top:none;">'
                + '<div class="event_info">';
        if (ary['description'].toString().length <= 220) {
            appendVal += ary['description'].toString() + '</div>';
        }
        else {
            appendVal += ary['description'].toString().substr(0, 220)
                + '<a href="#" id="description-show" class="showLink"'
                  + 'onclick="showHide(this);return false;">&nbsp;See more.</a>'
              + '<div id="description" class="more">';
            appendVal += ary['description'].toString().substr(221, ary['description'].toString().length)
                + '<a href="#" id="A7" class="hideLink"'
                + 'onclick="showHide(this);return false;">&nbsp;hide.</a>'
                + '</div>'
            + '</div>';
        }
        appendVal += '</div>';
    }
    if (ary['invites'] != 0) {
        if ((ary['description'] != null)) {
            appendVal += '<div class="attendees_wrapper">';
        }
        else {
            appendVal += '<div class="attendees_wrapper" style="border-top:none;margin-top:0px;">';
        }
        appendVal += '<div class="creator_wrapper">'
                    + '<a class="event_creator">'
                        + '<div class="creator_Image">'
                        + '</div>'
                        + '<div class="creator_name">'
                            + ary['name'].toString()
                        + '</div>'
                        + '<div class="creator_info">'
                            + 'Added ' + ary['time_added'].toString()
                        + '</div>'
                    + '</a>'
                + '</div>'
            + '<div class="attendee_list">'
               + '<div class="event_attendees">Attending: </div>'
                + '<a>'
                    + '<div style="font-size:20px;float: right; margin-top: -5px;">'
                        + ary['count'].toString()
                    + '</div>'
                + '</a>'
            + '</div>'
        + '</div>'
    + '</div>';
    }
    appendVal += '<div class="event_qa" style="display: none;" id="divQA1">'
    + '</div>'
    + '</div>'
    + '</div>'
    + '</li>';
    return appendVal;
}

function GroupPersonal(ary, formattedTime) {
    var updateVal = "";
    if (prevEventDate != (new Date(ary['start_date'])).toUTCString().substr(0, 11)) {
        prevEventDate = (new Date(ary['start_date'])).toUTCString().substr(0, 11);
        updateVal += '<li id="' + ary['event_id'] + "_" + ary['type'] + "_" + (new Date(ary['start_date'])).toUTCString().substr(0, 16) + '"><div class="event_day_time" id="' + prevEventDate + '">' + prevEventDate + '</div>'
    }
    else {
        updateVal += '<li id="' + ary['event_id'] + "_" + ary['type'] + "_" + (new Date(ary['start_date'])).toUTCString().substr(0, 16) + '" style="position:relative; top:-35px;padding:0px;"><div class="event_day_time fade-out hide">' + prevEventDate + '</div>'
    }
    updateVal += '<div class="flag-wrapper direction-r">'
                                                   + '<span class="flag1"></span>'
                                                   + '<span class="arrow_box">'
                                                       + '<div class="left_data1">'
                                                           + '<img class="event_icons1" src="img/time_icon.png">'
                                                           + '<div class="event-data1">'
                           + formattedTime
                           + '</div>'
                       + '</div>'
                   + '</span>'
               + '</div>'

            + '<div class="direction-r">'
                + '<div class="desc">'
                    + '<div class="event_main_header">'
                        + '<div class="event-content">'
                            + '<div class="event_right">'
                                + '<div class="header_wrapper">'
                                    + '<div class="event-header-left">'
                                        + '<div class="event_title">';
    if ((ary['title'] != null)) {
        updateVal += ary['title'];
    }
    updateVal += '</div>';
    if ((ary['type'] != "1")) {
        updateVal += '<div class="event_group">'
              + '<div>Event in <a>'
              + ary['group_name'].toString()
              + '</a></div>'
          + '</div>';
    }
    updateVal += '</div>';
    if (ary['file_id'] != null) {
        updateVal += '<div class="attachment_img">&nbsp;</div>'
            + '<div class="tooltip" >'
                + '<div class="explain-2-box" style="top:0px;">'
                    + '<div class="explain-wedge">'
                    + '</div>'
                    + '<b class="file_link">'
                                            + '<a onclick="FetchFile(' + ary['file_id'] + ');">'
                                                + ary['file_name'] + '</a>'
                                        + '</b>'
                + '</div>'
            + '</div>';
    }
    if ((ary['type'] != "1")) {
        updateVal += '<div class="show_discussions">'
              + '<a onclick="toggleDiscussion(this);">Show Discussions</a>'
          + '</div>';
    }
    updateVal += '</div>';;
    if ((ary['location'] != null)) {
        updateVal += '<div class="info_wrapper">'
                        + '<div class="right_data" style="border-right:none;">'
                            + '<img class="event_icons" src="img/location_icon.png">'
                            + '<div class="event-data">'
                            + ary['location']
                    + '</div></div>';
        if (ary['created_by'] != null) {
            if (ary['created_by'] == "0") {
                updateVal += '<div class="event_join">'
                                + '<div class="left_btn event_status_btn">'
                                    + 'Accept'     // choice 0 nothing 1 accept 2 maybe 3 decline
                                + '</div>'
                                + '<div class="center_btn event_status_btn">'
                                    + 'Maybe'
                                + '</div>'
                                + '<div class="right_btn event_status_btn">'
                                    + 'Decline'
                                + '</div>'
                            + '</div>';
            }
        }
        updateVal += '</div>';
    }
    else {
        if (ary['created_by'] != null) {
            if (ary['created_by'] == "0") {
                updateVal += '<div class="info_wrapper">';
                updateVal += '<div class="event_join">'
                                + '<div class="left_btn event_status_btn">'
                                    + 'Accept'     // choice 0 nothing 1 accept 2 maybe 3 decline
                                + '</div>'
                                + '<div class="center_btn event_status_btn">'
                                    + 'Maybe'
                                + '</div>'
                                + '<div class="right_btn event_status_btn">'
                                    + 'Decline'
                                + '</div>'
                            + '</div>';
                updateVal += '</div>';
            }
        }
    }
    updateVal += '</div>'
+ '<div class="event_left"></div></div></div>';
    if ((ary['description'] != null)) {
        updateVal += '<div class="info_wrapper bottom_right_data">'
                + '<div class="event_info">';
        if (ary['description'].toString().length <= 220) {
            updateVal += ary['description'].toString() + '</div>';
        }
        else {
            updateVal += ary['description'].toString().substr(0, 220)
                + '<a href="#" id="description-show" class="showLink"'
                  + 'onclick="showHide(this);return false;">&nbsp;See more.</a>'
              + '<div id="description" class="more">';
            updateVal += ary['description'].toString().substr(221, ary['description'].toString().length)
                + '<a href="#" id="A7" class="hideLink"'
                + 'onclick="showHide(this);return false;">&nbsp;hide.</a>'
                + '</div>'
            + '</div>';
        }
        updateVal += '</div>';
    }
    if (ary['invites'] != null) {
        if (ary['invites'] != 0) {
            updateVal += '<div class="attendees_wrapper">'
                + '<div class="creator_wrapper">'
                + '<a class="event_creator">'
                + '<div class="creator_Image">'
                + '</div>'
                + '<div class="creator_name">'
                    + ary['name'].toString()
                + '</div>'
                + '<div class="creator_info">'
                    + 'Added ' + ary['time_added'].toString()
                + '</div>'
                + '</a>'
                + '</div>'
                + '<div class="attendee_list">'
                + '<div class="event_attendees">Attending: </div>'
                    + '<div class="event_attendees">Attending: </div>'
                    + '<a>'
                    + '<div style="font-size:20px;float: right; margin-top: -5px;">'
                        + ary['count'].toString()
                    + '</div>'
                    + '</a>'
                + '</div>'
                + '</div>'
        + '</div>';
        }
    }
    updateVal += '<div class="event_qa" style="display: none;" id="divQA1">'
+ '</div>'
+ '</div>'
+ '</div>'
+ '</li>';
    return updateVal;
}

function DisplayEvents(ary) {
    var appendString = "";

    for (var i = 0; i < ary.length; i++) {
        var formattedTime = "00:00";
        if (ary[i]['start_time'] != null) {
            var hours = ary[i]['start_time'].substr(0, 2) == 0 ? "12" :
                ary[i]['start_time'].substr(0, 2) > 12 ? ("0" + (ary[i]['start_time'].substr(0, 2) - 12)).slice(-2)
                : ("0" + ary[i]['start_time'].substr(0, 2)).slice(-2);
            var minutes = ary[i]['start_time'].substr(3, 2);
            var ampm = ary[i]['start_time'].substr(0, 2) < 12 ? "am" : "pm";
            formattedTime = hours + ":" + minutes + " " + ampm;
        }

        if (ary[i]['type'] == "1") {
            appendString += DisplayToDo(ary[i], formattedTime);
        }
        else if ((ary[i]['type'] == "2") || (ary[i]['type'] == "3")) {
            appendString += DisplayPersonalInvited(ary[i], formattedTime);
        }
        else if ((ary[i]['type'] == "4") || (ary[i]['type'] == "5")
            || (ary[i]['type'] == "6") || (ary[i]['type'] == "7")) {
            appendString += GroupPersonal(ary[i], formattedTime);
        }
        else if (ary[i]['type'] == "8") {
            if (prevEventDate != (new Date(ary[i]['start_date'])).toUTCString().substr(0, 11)) {
                prevEventDate = (new Date(ary[i]['start_date'])).toUTCString().substr(0, 11);
                appendString += '<li id="' + ary['event_id'] + "_" + ary['type'] + "_" + (new Date(ary['start_date'])).toUTCString().substr(0, 16) + '"><div class="event_day_time" id="' + prevEventDate + '">' + prevEventDate + '</div>'
            }
            else {
                appendString += '<li id="' + ary['event_id'] + "_" + ary['type'] + "_" + (new Date(ary['start_date'])).toUTCString().substr(0, 16) + '" style="position:relative; top:-35px;padding:0px;"><div class="event_day_time fade-out hide">' + prevEventDate + '</div>'
            }
            appendString += '<div class="flag-wrapper direction-r">'
                                    + '<span class="flag1"></span>'
                                    + '<span class="arrow_box">'
                                        + '<div class="left_data1">'
                                            + '<img class="event_icons1" src="img/time_icon.png">'
                                            + '<div class="event-data1">'
            + formattedTime
            + '</div>'
        + '</div>'
    + '</span>'
+ '</div>'
+ '<div class="direction-r">'
    + '<div class="desc">'
        + '<div class="event_main_header">'
            + '<div class="event-content">'
                + '<div class="event_right">'
                    + '<div class="header_wrapper">'
                        + '<div class="event-header-left">'
                            + '<div class="event_title">';
            if ((ary[i]['title'] != null)) {
                appendString += ary[i]['title'];
            }
            appendString += '</div>';
            if ((ary[i]['type'] != "1")) {
                appendString += '<div class="event_group">'
                      + '<div>Event in <a>'
                      + ary[i]['group_name']
                      + '</a></div>'
                  + '</div>';
            }
            appendString += '</div>';
            if (ary[i]['file_id'] != null) {
                appendString += '<div class="attachment_img">&nbsp;</div>'
                    + '<div class="tooltip" >'
                        + '<div class="explain-2-box" style="top:0px;">'
                            + '<div class="explain-wedge">'
                            + '</div>'
                            + '<b class="file_link">'
                                + '<a onclick="FetchFile(' + ary[i]['file_id'] + ');">'
                                    + ary[i]['file_name'] + '</a>'
                            + '</b>'
                        + '</div>'
                    + '</div>';
            }
            if ((ary[i]['type'] != "1")) {
                appendString += '<div class="show_discussions">'
                      + '<a onclick="toggleDiscussion(this);">Show Discussions</a>'
                  + '</div>';
            }
            appendString += '</div>'
  + '<div class="info_wrapper">'
      + '<div class="right_data">'
          + '<img class="event_icons" src="img/location_icon.png">'
          + '<div class="event-data">';
            if ((ary[i]['location'] != null)) {
                appendString += ary[i]['location'];
            }
            appendString += '</div>';
            //+ '<div class="event-data2">'
            //if ((ary[i]['location'] != null)) {
            //    appendString += ary[i]['location'];
            //}
            //appendString += '</div>'
            appendString += '</div>'
        + '<div class="event_join">'
            + '<div class="left_btn event_status_btn">'
                + 'Accept'     // choice 0 nothing 1 accept 2 maybe 3 decline
            + '</div>'
            + '<div class="center_btn event_status_btn">'
                + 'Maybe'
            + '</div>'
            + '<div class="right_btn event_status_btn">'
                + 'Decline'
            + '</div>'
        + '</div>'
    + '</div>'
+ '</div>'
+ '<div class="event_left">'
+ '</div>'
+ '</div>'
+ '<div class="info_wrapper bottom_right_data">'
+ '<div class="event_info">';
            if ((ary[i]['description'] != null)) {
                appendString += ary[i]['description'].toString().substr(0, 220);
            }
            appendString += '<a href="#" id="description-show" class="showLink"'
      + 'onclick="showHide(this);return false;">&nbsp;See more.</a>'
  + '<div id="description" class="more">';
            if ((ary[i]['description'] != null)) {
                appendString += ary[i]['description'].toString().substr(221, ary[i]['description'].toString().length)
            }
            appendString += '<a href="#" id="A7" class="hideLink"'
            + 'onclick="showHide(this);return false;">&nbsp;hide.</a>'
    + '</div>'
+ '</div>'
+ '</div>'
+ '<div class="attendees_wrapper">'
+ '<div class="creator_wrapper">'
    + '<a class="event_creator">'
        + '<div class="creator_Image">'
        + '</div>'
        + '<div class="creator_name">'
            + ary[i]['name'].toString()
        + '</div>'
        + '<div class="creator_info">'
            + 'Added ' + ary[i]['time_added'].toString()
        + '</div>'
    + '</a>'
+ '</div>'
+ '<div class="attendee_list">'
    + '<div class="event_attendees">Attending: </div>'
    + '<a>'
        + '<div style="font-size:20px;float: right; margin-top: -5px;">'
            + ary[i]['count'].toString()
        + '</div>'
    + '</a>'
+ '</div>'
+ '</div>'
+ '</div>'
+ '<div class="event_qa" style="display: none;" id="divQA1">'
+ '</div>'
    + '</div>'
+ '</div>'
+ '</li>';
        }
    }
    $(".timeline").append(appendString);
}

function InfiniteScrollEventBook(id, daytime, type, time) {
    // 1 to do 	-	title date time 
    // 2 personal	- 	title date time - if - desc locn attachments
    // 3 personal invited -	title date time - if - desc locn invited by accepted cnt atchmnts
    // 4 group personal 	-	title date time pic  - if - desc locn atchmnts
    // 5 group 	-	title date time pic  - if - desc locn invited by accepted cnt atchmnts
    // 6 course personal
    // 7 course

    var date = new Date(daytime);
    date = (date.getFullYear() + "-" + ("0" + (date.getMonth() + 1)).slice(-2) + "-" + ("0" + date.getDate()).slice(-2));    

    var hours = parseInt(time.substr(0, 2));
    if (time.indexOf('am') != -1 && hours == 12) {
        time = time.replace('12', '00');
    }
    if (time.indexOf('pm') != -1 && hours < 12) {
        time = time.replace(hours, (hours + 12));
    }
    time = time.replace(' ', '');
    time = time.replace(/(am|pm)/, ':00');

    $.ajax({
        url: "php/event_book_fetch.php",
        data: { event_id: id, time: time, date: date, type: type }, // event_id  time date  yyyy-mm-dd
        type: "POST",
        dataType: "json",
        success: function (responseText) {            
                DisplayEvents(responseText.events_array);            
        },
        error: function (responseText) {
            alert("error " + responseText);
        }
    });
}

function DisplayEditEvents(sender, id, type) {
    $.ajax({
        url: "php/fetch_edit_event.php",
        data: { event_id: id, type: type },
        type: "POST",
        dataType: "json",
        success: function (responseText) {
            $('#event_date').val(responseText.event_array['start_date']);
            $('#nevt-location-1').val(responseText.event_array['location']);
            $('#nevt-title-1').val(responseText.event_array['title']);
            $('#nevt-desc-1').val(responseText.event_array['description']);
            $('#set_from_time_24hr').val(responseText.event_array['start_time']);
            $('#set_to_time_24hr').val(responseText.event_array['end_time']);
            $('.repeatstate-1').text(responseText.event_array['recurrence']);
            $('#event_id').text(id);
            $('#event_type').text(type);
            $('#addEvent').trigger("click");
        },
        error: function (responseText) {
            alert(responseText);
        }
    });
}

function DeleteEvents(sender, id, type) {    
    $.ajax({
        url: "php/delete_event.php",
        data: { event_id: id, type: type },
        type: "POST",
        dataType: "text",
        success: function (responseText) {            
            $(sender).parents('.fc-event').remove();
        },
        error: function (responseText) {
            alert(responseText);
        }
    });
}

function clearInsertFields() {
    $('#event_date').val(new date());
    $('#nevt-location-1').val("");
    $('#nevt-title-1').val("");
    $('#nevt-desc-1').val("");
    $currentTime = new Date().getHours() + ':' + new Date().getMinutes() + ':00';
    $('#set_from_time_24hr').timeAutocomplete({
        increment: 15,
        formatter: 'ampm',
        start_hour: 0,
        value: $currentTime
    });
    $('#set_to_time_24hr').timeAutocomplete({
        increment: 15,
        formatter: 'ampm',
        start_hour: 0,
        value: $currentTime
    });
    $('.repeatstate-1').text("None");
    $('#event_id').text("");
    $('#event_type').text("");
}

function LinkEventInEventBook(month, date, year) {
    var eventdate = year + "-" + ("0" + (month + 1)).slice(-2) + "-" + ("0" + date).slice(-2);
    eventdate = ((new Date(eventdate)).toUTCString()).substr(0, 11);
    $('.cal_view_events').text("Event Book");
    $('.cal_view_events').trigger("click");
    window.location = "#" + eventdate;
    $(window).scrollTop(($(window).scrollTop() - 120));
}