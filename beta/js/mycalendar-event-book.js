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

        $(".3_7").hide();
    });
    $(document).delegate(".cal-group-toggle-unchecked", "click", function () {

        $(this).closest(".cal-group").css("opacity", "1");
        $(this).removeClass("cal-group-toggle-unchecked");
        $(this).addClass("cal-group-toggle-checked");
        $(this).find(".cal-group-checkmark").removeClass("cal-group-checkmark-unchecked");
        $(this).find(".cal-group-checkmark").addClass("cal-group-checkmark-checked");

        $(".3_7").show();
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
    $(document).delegate(".cal_view_events", "click", function (event) {



        $(window).scrollTop(0);
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



            lastScrollTop = 0;
            ScrollFunctionToSetOffset();

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

    $(document).delegate(".dd-title", "click", function () {

        $(".click-out").toggle();

    });

    $(document).delegate(".repeatoptiont-1", "click", function () {

        $(".dd-title").text($(this).text());
        $(".click-out").hide();
        if (($(this).text().trim() == "Daily") || ($(this).text().trim() == "Weekly") || ($(this).text().trim() == "Monthly")) {

            $('.repeat_date').show();

            $('#repeat_date_icon').css("display","block");

            $('#event_date').css("width", "175px");

        }
        else {

            $('.repeat_date').hide();

            $('#repeat_date_icon').css("display", "none");

            $('#event_date').css("width", "40.3%");

        }

    });

    $(document).on("click", function (e) {

        var elem = $(e.target);
        if (elem.hasClass("dd-title") || elem.hasClass("event-repeat") || elem.hasClass("down-arrow")) {
            //alert();
            //$('.repeatoption-1').css('display', 'none');
            $('.click-out').toggle();//.css('display', 'block');

        }
        else {

            $('.click-out').css('display', 'none');

        }

        if (elem.hasClass('blackcanvas30')) {

            $(".blackcanvas30").fadeOut();
            $("#bc3contentAddEvent").css('display', 'none');
            clearInsertFields();
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
        //ScrollFunctionToSetOffset();
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

            DisplayCalendarFetchEvents(responseText);

        },
        error: function (responseText) {

            alert("error " + responseText);

        }

    });

    RenderCourseClubGroups();

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

        clearInsertFields();
        /*$("#bc3contentAddEvent").css('margin-top', '-600px');
        $("#bc3contentAddEvent").animate({ marginTop: "-=600px", marginTop: "transition: all 0.5s ease-in-out;" });*/

    });

    $(document).delegate("#divClose", "click", function (e) {

        $("#divInviteConnections").hide();

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
        var end = new Date($('#repeat_end_date').val());
        if (start >= end)
        {

            end = start;
        }
        start = start.getFullYear() + '-' + ('0' + (start.getMonth() + 1)).substr(-2, 2) + '-' + ('0' + start.getDate()).substr(-2, 2);                
        end = end.getFullYear() + '-' + ('0' + (end.getMonth() + 1)).substr(-2, 2) + '-' + ('0' + end.getDate()).substr(-2, 2);
        var locn = $('#nevt-location-1').val().toString();
        var title = $('#nevt-title-1').val().toString();
        var desc = $('#nevt-desc-1').val().toString();
        var fromtime = $('#set_from_time_24hr').val().toString();
        var totime = $('#set_to_time_24hr').val().toString();
        var repeat = $('.dd-title').text().toString().toLowerCase();
        if ((repeat == "repeat") || (repeat == ""))
        {

            repeat = "none";
        }
        var event_id = $('#event_id').text();
        var event_type = $('#event_type').text();
        var theme_id = $('#theme_id').text();
        var phpFilePath = "php/event_insert.php";

        var date = new Date();
        var d = ("0" + date.getDate()).slice(-2);
        var m = ("0" + (date.getMonth() + 1)).slice(-2);
        var y = date.getFullYear();
        var monthdate = (y + "-" + m + "-" + d);

        var starttoendtime = fromtime;
        if (fromtime != totime)
        {

            starttoendtime += " to " + totime;
        }

        //To fetch the details of the invitees
        var allVals = [];

        if (event_id == "") {

            $('#inviteConnections :checked').each(function () {

                allVals.push($(this).val());

            });

        }
        else {

            $('#calendar').fullCalendar('removeEvents', event_id);

            phpFilePath = "php/edit_event_insert.php";            
        }
        $('#calendar').fullCalendar('unselect');
        $('#divCancel').trigger("click");        

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

            formData.append("month_date", monthdate);

            if (event_id != "")
            {

                formData.append("event_id", event_id);
                formData.append("type", event_type);
            }
            $.ajax({

                type: "POST",
                dataType: "json",
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

                    DisplayCalendarFetchEvents(responseText);

                    //var new_id = responseText.split("_")[0].toString().trim();

                    //var new_type = responseText.split("_")[1].toString().trim();

                    //if (new_id != "0") {

                    //    $('#calendar').fullCalendar('renderEvent',
                    //      {

                    //          id: new_id,

                    //          type: new_type,

                    //          title: title,
                    //          start: start,
                    //          end: end,
                    //          allDay: true,

                    //          editable: true,
                    //          location: locn,
                    //          startendtime: starttoendtime

                    //      },
                    //      true // make the event "stick"
                    //    );

                    //}                    

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
                data: //[dataString],
                    event_id == "" ?
                    {

                        title: title, location: locn, details: desc, start_date: start, end_date: end, start_time: fromtime
                        , end_time: totime, repeat: repeat, connections: allVals, month_date: monthdate, theme_id: theme_id
                    } :

                    {

                        title: title, location: locn, details: desc, start_date: start, end_date: end, start_time: fromtime
                        , end_time: totime, repeat: repeat, connections: allVals, event_id: event_id, type: event_type, month_date: monthdate, theme_id: theme_id
                    },
                type: "POST",
                dataType: "json",
                success: function (responseText) {

                    //var new_id = responseText.split("_")[0].toString().trim();

                    //var new_type = responseText.split("_")[1].toString().trim();

                    //if (new_id != "0") {

                    //    $('#calendar').fullCalendar('renderEvent',
                    //      {

                    //          id: new_id,

                    //          type: new_type,

                    //          title: title,
                    //          start: start,
                    //          end: end,
                    //          allDay: true,

                    //          editable: true,
                    //          location: locn,
                    //          startendtime: starttoendtime

                    //      },
                    //      true // make the event "stick"
                    //    );

                    //}

                    DisplayCalendarFetchEvents(responseText);

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
            $("div.eb-event-wrap").each(function (index) {
                var scrollWindow = (($(this).offset()).top - $(window).scrollTop());
                if ((scrollWindow >= 100) && (scrollWindow <= 160)) {
                    document.getElementById('currentEvent').innerHTML = ($(this).children(":first")).text();
                    ($(this).prevAll(".eventbook-date-break:first")).addClass("fade-out");
                    ($(this).prevAll(".eventbook-date-break:first")).removeClass("fade-in");

                    // To set the day, month and year for the top bar
                    var dayMonthYear = ($(this).prop("id")).split('_');
                    var day = dayMonthYear[dayMonthYear.length - 1].split(',')[0];
                    var month = (dayMonthYear[dayMonthYear.length - 1].split(',')[1]).trim().split(' ')[1]
                    var date = (dayMonthYear[dayMonthYear.length - 1].split(',')[1]).trim().split(' ')[0];
                    var year = (dayMonthYear[dayMonthYear.length - 1].split(',')[1]).trim().split(' ')[2];
                    if (day.toLowerCase() == "sun") {
                        day = "Sunday";
                    }
                    else if (day.toLowerCase() == "mon") {
                        day = "Monday";
                    }
                    else if (day.toLowerCase() == "tue") {
                        day = "Tuesday";
                    }
                    else if (day.toLowerCase() == "wed") {
                        day = "Wednesday";
                    }
                    else if (day.toLowerCase() == "thu") {
                        day = "Thursday";
                    }
                    else if (day.toLowerCase() == "fri") {
                        day = "Friday";
                    }
                    else {
                        day = "Saturday";
                    }
                    $('.eb-day-cont').children(':first').text(day);
                    $('.eb-month').text(month);
                    $('.eb-date').text(date);
                    $('.eb-year').text(year);
                }
                else {
                    if (!($(this).children(":first")).hasClass("hide")) {
                        ($(this).prevAll(".eventbook-date-break:first")).addClass("fade-in");
                        ($(this).prevAll(".eventbook-date-break:first")).removeClass("fade-out");
                    }
                }

                id = ($(this).prop('id')).split('_')[0];
                type = ($(this).prop('id')).split('_')[1];
                time = $(this).find("div .eventbook-event-time :last").text();
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
        $(this).parents(".header-inp-wrap").children('.calLayer').toggle();
    });

    $(document).delegate('#img_cal_filter', 'click', function () {
        //        $('.calLayer').css('display', 'block');
        $(this).parents(".event_view_cal").children('.calLayer').toggle();
    });

    $(document).delegate('#repeat_date_icon', 'click', function () {
        //        $('.calLayer').css('display', 'block');
        $(this).parents(".event-repeat").children('.calLayer').toggle();

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
        $(window).scrollTop(($(window).scrollTop() - 60));
    });
    
    $(document).delegate(".attachment_img", "mouseover", function () {
        $(this).parent().children('.tooltip').stop().show();
    });
    
    $(document).delegate(".attachment_img", "mouseout", function () {
        $(this).parent().children('.tooltip').delay(400).hide(0);
    });
    
    $(document).delegate(".tooltip", "mouseover", function () {
        $(this).parents('.header_wrapper').children('.tooltip').stop().show();
    });
    $(document).delegate(".tooltip", "mouseout", function () {
        $(this).parents('.header_wrapper').children('.tooltip').delay(400).hide(0);
    });

    $(document).delegate(".eventbook-discuss-btn", "click", function () {
        $(this).addClass("eventbook-discuss-hider");
        $(this).text("Hide this discussion");
        $(this).closest(".eventbook-groupevent-cont").closest(".eb-groupevent-wrap").find(".eb-event-discussion").animate({ opacity: "1", height: "120" }, 200);
    });
    $(document).delegate(".eventbook-discuss-hider", "click", function () {
        $(this).closest(".eventbook-groupevent-cont").closest(".eb-groupevent-wrap").find(".eb-event-discussion").animate({ opacity: "0", height: "0" }, 250).stop();
        $(this).text("View the full discussion (10)");
        $(this).removeClass("eventbook-discuss-hider");
    });

    $(document).delegate(".event-attend-status", "click", function () {
        $(this).addClass("event-attend-status-hider");
        $(this).closest(".eventbook-event-cont").find(".dd-box-attending").addClass("dd-box-show");
    });
    $(document).delegate(".event-attend-status-hider", "click", function () {
        $(this).removeClass("event-attend-status-hider");
        $(this).closest(".eventbook-event-cont").find(".dd-box-attending").removeClass("dd-box-show");
    });
    $(document).on("click", function (e) {
        var elem = $(e.target);
        if (elem.hasClass("dd-box-attending") || elem.hasClass("attending-option") || elem.hasClass("event-attend-status") || elem.hasClass("attend-icon") || elem.hasClass("attend-title-toggler") || elem.hasClass("remove-icon")) {
            return;
        }
        else {
            $('.dd-box-attending').removeClass("dd-box-show");
            $(".event-attend-status-hider").removeClass("event-attend-status-hider");
        }
    });
    if ((window).innerWidth < 941) {
        $(".eb-event-type").text("TO-DO");
    }
    if ((window).innerWidth > 942) {
        $(".eb-event-type").text("PERSONAL TO-DO");
    }
    $(window).resize(function () {
        if ((window).innerWidth < 941) {
            $(".eb-event-type").text("TO-DO");
        }
        if ((window).innerWidth > 942) {
            $(".eb-event-type").text("PERSONAL TO-DO");
        }
    });

    $(document).delegate(".fx-cont-right", "click", function () {
        var month = 0;
        if ($('.eb-month').text().toLowerCase() == "jan") {
            month = 0;
        }
        else if ($('.eb-month').text().toLowerCase() == "feb") {
            month = 1;
        }
        else if ($('.eb-month').text().toLowerCase() == "mar") {
            month = 2;
        }
        else if ($('.eb-month').text().toLowerCase() == "apr") {
            month = 3;
        }
        else if ($('.eb-month').text().toLowerCase() == "may") {
            month = 4;
        }
        else if ($('.eb-month').text().toLowerCase() == "jun") {
            month = 5;
        }
        else if ($('.eb-month').text().toLowerCase() == "jul") {
            month = 6;
        }
        else if ($('.eb-month').text().toLowerCase() == "aug") {
            month = 7;
        }
        else if ($('.eb-month').text().toLowerCase() == "sep") {
            month = 8;
        }
        else if ($('.eb-month').text().toLowerCase() == "oct") {
            month = 9;
        }
        else if ($('.eb-month').text().toLowerCase() == "nov") {
            month = 10;
        }
        else if ($('.eb-month').text().toLowerCase() == "dec") {
            month = 10;
        }
        var nextDate = new Date(Number($('.eb-year').text()), Number(month), Number($('.eb-date').text()));
        nextDate = nextDate.setDate(nextDate.getDate() + 1);
        nextDate = (new Date(nextDate)).toUTCString().substr(0, 11);
        
        window.location.hash = nextDate;
        $(window).scrollTop(($(window).scrollTop() - 60));
        $("html, body").animate({ scrollTop: $('#' + nextDate).offset().top }, 900);
        $(".eb-current-day").animate({ marginTop: "-40" }, 500);

        $(".eb-current-day").addClass("eb-prev-day");
        $(".eb-prev-day").removeClass("eb-current-day");

        $(".eb-next-day").addClass("eb-current-day");
        $(".eb-next-day").removeClass("eb-next-day");
    });

    $(document).delegate(".fx-cont-left", "click", function () {

        var month = 0;
        if ($('.eb-month').text().toLowerCase() == "jan") {
            month = 0;
        }
        else if ($('.eb-month').text().toLowerCase() == "feb") {
            month = 1;
        }
        else if ($('.eb-month').text().toLowerCase() == "mar") {
            month = 2;
        }
        else if ($('.eb-month').text().toLowerCase() == "apr") {
            month = 3;
        }
        else if ($('.eb-month').text().toLowerCase() == "may") {
            month = 4;
        }
        else if ($('.eb-month').text().toLowerCase() == "jun") {
            month = 5;
        }
        else if ($('.eb-month').text().toLowerCase() == "jul") {
            month = 6;
        }
        else if ($('.eb-month').text().toLowerCase() == "aug") {
            month = 7;
        }
        else if ($('.eb-month').text().toLowerCase() == "sep") {
            month = 8;
        }
        else if ($('.eb-month').text().toLowerCase() == "oct") {
            month = 9;
        }
        else if ($('.eb-month').text().toLowerCase() == "nov") {
            month = 10;
        }
        else if ($('.eb-month').text().toLowerCase() == "dec") {
            month = 10;
        }
        var nextDate = new Date(Number($('.eb-year').text()), Number(month), Number($('.eb-date').text()));
        nextDate = nextDate.setDate(nextDate.getDate() - 1);
        nextDate = (new Date(nextDate)).toUTCString().substr(0, 11);

        window.location.hash = nextDate;
        $(window).scrollTop(($(window).scrollTop() - 60));
        $("html, body").animate({ scrollTop: $('#' + nextDate).offset().top }, 900);
        $(".eb-prev-day").animate({ marginTop: "0" }, 500);
        $(".eb-current-day").addClass("eb-next-day");
        $(".eb-prev-day").addClass("eb-current-day");
        $(".eb-prev-day").removeClass("eb-prev-day");
        $(".eb-next-day").removeClass("eb-current-day");
        $(".eb-current-day").addClass("eb-current-day");
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
            var width = $(sender).parent().css('width').slice(0, -2);
            tooltip.css('left', width + 'px');
            if ($(sender).parent().css('left').slice(0, -2) > ((width * 7) - (2 * width))) {
                tooltip.css('left', -(tooltip.width() + 5));
            }
            else {
                tooltip.css('left', (width + 2));
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

    $(window).scrollTop(($(window).scrollTop() - 60));

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
    var event_id = $('#event_id').text();
    if ($("#inviteConnections").children('li').length == 0) {

        $.ajax({

            url: "php/connections.php",
            data: {

                user_id: 1, event_id: event_id

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
                for (var i = 0; i < responseText.people_array.length; i++) {                  
                    //$("#inviteConnections").append('<div class="invite_content '
                    //    + floatVal + '">' +
                    //    '<div class="invite_box" id="invite_details_box' + i + '">' +
                    //        '<div class="invite_image" id="inviteeImg' + i + '">' +
                    //        '</div>' +
                    //        '<div class="invite_details_box">' +
                    //            '<a href="#" class="ibNameLink">' +
                    //            '<div class="invitee_name">' + responseText.people_array[i][1] + ' ' +
                    //            responseText.people_array[i][2] + '</div>' +
                    //            '<div class="invitee_major">' + responseText.people_array[i][6] + '</div>' +
                    //            '<div class="invitee_school">' + responseText.people_array[i][5] + '</div>' +
                    //            '</a>' +
                    //        '</div>'
                    //        + '<input type="checkbox" class="invite-check-box" id="invite-check-box' + i + '" value="' + responseText.people_array[i][0] + '" />' +
                    //        '<div class="invite">&nbsp;</div>' +
                    //    '</div>' +
                    //'</div>');
                    
                    $("#inviteConnections").append('<li class = "ddbox-invite-option" id="invite_details_box' + i + '">'

                        + '<input type="checkbox" class="invite-check-box" style="display:none;" id="invite-check-box' + i + '" value="' + responseText.people_array[i][0] + '"></input>'

                                + '<div class = "invite-option-pic-wrap" id="inviteeImg' + i + '">'

                                + '</div>'

                                //+ '<div class = "invite-option-icon icon-group">'

                                //+ '</div>'

                                + '<div class = "invite-option-checkwrap">'

                                + '</div>'

                                + '<div class = "invite-option-title-wrap">'

                                + ' <p >' + responseText.people_array[i][1] + ' ' +
                                responseText.people_array[i][2] + '</p>'

                                + '</div>'

                                + '<div class = "after-click-effect"></div>'                                

                            + '</li>');



                    var path = 'url("' + '/DEMO/' + responseText.people_array[i][4] + '/' + responseText.people_array[i][3] + '")';
                    $('#inviteeImg' + i).css('background', path);
                    $('#inviteeImg' + i).css('background-size', '100% 100%');

                    if (responseText.people_array[i][7] == "1") {
                        //$('#invite_details_box' + i).css('opacity', '0.5');
                        //$('#invite_details_box' + i).css('cursor', 'default');
                        //$('#invite_details_box' + i).children('.ibNameLink').css('cursor', 'default');
                        //$('#invite_details_box' + i).parent('.invite_content').addClass('invited_content');
                        //$('#invite_details_box' + i).parent('.invite_content').removeClass('invite_content');//css('background-color', '#EBEBEB');                            
                        //$('#invite_details_box' + i).children('.invite_details_box').children('.ibNameLink').css('color', '#FFF');
                        $('#invite-check-box' + i).prop('checked', true);
                        $('#invite-check-box' + i).parents('.ddbox-invite-option').children('.after-click-effect').css("display","block");
                        $('#invite_details_box' + i).addClass('ddbox-option-invited');
                        $('#invite-check-box' + i).parents('.ddbox-invite-option').children('.invite-option-checkwrap').css({ "background-image": "url(img/checked-invite.png)", "opacity": "1" });
                        //connectionsInvited += 1;

                    }
                    else {

                        //$('#invite_details_box' + i).css('cursor', 'pointer');
                        //$('#invite_details_box' + i).children('.invite').addClass('toinvite');
                        //$('#invite_details_box' + i).children('.ibNameLink').css('cursor', 'pointer');
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
        $(sender).removeClass("ddbox-option-invited");
        $(sender).find(".after-click-effect").hide();
        $(sender).find(".invite-option-checkwrap").css({ "background-image": "url(img/unchecked-invite.png)", "opacity": ".7" });

        connectionsInvited -= 1;
        checkbox.prop('checked', false);
        //$(sender).children('.invite_details_box').css('opacity', '1');
        //$(sender).children('.invite_details_box').css('background-color', 'transparent');
        //$(sender).children('.invite_details_box').children('.ibNameLink').css('color', '#424141');
        //$(sender).children('.invite').addClass('toinvite');
        //$(sender).children('.invite').removeClass('invited');
    }
    else {
        $(sender).addClass("ddbox-option-invited");
        $(sender).find(".after-click-effect").show();
        $(sender).find(".invite-option-checkwrap").css({ "background-image": "url(img/checked-invite.png)", "opacity": "1" });
        connectionsInvited += 1;
        checkbox.prop('checked', true);
        //$(sender).children('.invite_details_box').css('opacity', '0.5');
        //$(sender).children('.invite_details_box').css('background-color', '#759E96');
        //$(sender).children('.invite_details_box').children('.ibNameLink').css('color', '#FFF');
        //$(sender).children('.invite').addClass('invited');
        //$(sender).children('.invite').removeClass('toinvite');

    }
    $('#invitedConnections').text(connectionsInvited + ' connections invited');
}

var prevEventDate = "";
var missingEventDates = new Date();
missingEventDates = missingEventDates.setDate(missingEventDates.getDate() - 1);

function DisplayEventBook() {

    // 1 to do 	-	title date time 

    // 2 personal	- 	title date time - if - desc locn attachments

    // 3 personal invited -	title date time - if - desc locn invited by accepted cnt atchmnts

    // 4 group personal 	-	title date time pic  - if - desc locn atchmnts

    // 5 group 	-	title date time pic  - if - desc locn invited by accepted cnt atchmnts

    // 6 course personal

    // 7 course



    var date = new Date();
    date = (date.getFullYear() + "-" + ("0" + (date.getMonth() + 1)).slice(-2) + "-" + ("0" + date.getDate()).slice(-2));    

    document.getElementById('currentEvent').innerHTML = new Date(date).toUTCString().substr(0,11);
    var dayMonthYear = new Date(date).toUTCString().substr(0, 16);
    var day1 = dayMonthYear.split(',')[0];
    var month1 = (dayMonthYear.split(',')[1]).trim().split(' ')[1]
    var date1 = (dayMonthYear.split(',')[1]).trim().split(' ')[0];
    var year1 = (dayMonthYear.split(',')[1]).trim().split(' ')[2];
    if (day1.toLowerCase() == "sun") {
        day1 = "Sunday";
    }
    else if (day1.toLowerCase() == "mon") {
        day1 = "Monday";
    }
    else if (day1.toLowerCase() == "tue") {
        day1 = "Tuesday";
    }
    else if (day1.toLowerCase() == "wed") {
        day1 = "Wednesday";
    }
    else if (day1.toLowerCase() == "thu") {
        day1 = "Thursday";
    }
    else if (day1.toLowerCase() == "fri") {
        day1 = "Friday";
    }
    else {
        day1 = "Saturday";
    }
    $('.eb-day-cont').children(':first').text(day1);
    $('.eb-month').text(month1);
    $('.eb-date').text(date1);
    $('.eb-year').text(year1);


    $.ajax({
        url: "php/event_book_fetch.php",
        data: { event_id: null, time: "00:00:00", date: date, type: null }, // event_id  time date  yyyy-mm-dd
        type: "POST",
        dataType: "json",
        success: function (responseText) {
            if ($(".eventbook-content").children("div.eb-event-wrap").length == 0) {
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
    var colorString = "border-color:rgba(" + ary['red_code'] + "," + ary['green_code'] + "," + ary['blue_code'] + ", 0.23) rgba("
        + ary['red_code'] + "," + ary['green_code'] + "," + ary['blue_code']
        + ", 0.23) rgba(" + ary['red_code'] + "," + ary['green_code'] + "," + ary['blue_code']
        + ", 0.23) rgba(" + ary['red_code'] + "," + ary['green_code'] + "," + ary['blue_code'] + ", 0.455);"
        + "background-image: -moz-linear-gradient(left,rgba(" + ary['red_code'] + "," + ary['green_code'] + "," + ary['blue_code'] + ", 0.2),#FFFFFF 7%);"
        + "background-image: -webkit-linear-gradient(left,rgba(" + ary['red_code'] + "," + ary['green_code'] + "," + ary['blue_code'] + ", 0.48),#FFFFFF 5%);";

    var eventTimeColor = "background-color: rgb(" + ary['red_code'] + "," + ary['green_code'] + "," + ary['blue_code'] + ");";

    appendVal += '<div id="' + ary['event_id'] + "_" + ary['type'] + "_" + (new Date(ary['start_date'])).toUTCString().substr(0, 16) + '" class = "eb-event-wrap eb-personalevent-wrap">'
        + '<div style="display:none;">' + (new Date(ary['start_date'])).toUTCString().substr(0, 12) + '</div>'
					+ '<div class = "eb-event-frame">'
						+ '<div class = "eventbook-event-cont eventbook-personalevent-cont" style="' + colorString + '">'
							+ '<div class = "eventbook-event-time eventbook-event-time-personal" style="' + eventTimeColor + '">'
								+ '<span>'
									+ formattedTime
+ '								</span>'
							+ '</div>'
							+ '<div class = "eb-event-timeuntill">'
+ '								2 hours and 30 minutes from now'
							+ '</div>'
							+ '<div class = "event-edit-btn">	     '
			                    + '<span class = "edit-icon"></span>'
			                    + '<span style = "padding-left:8px;" class = "attend-title">Edit and Invite</span>'
			               + '</div>							'
							+ '<div class = "eb-personal-event-name">'
                            + ary['title']
							+ '</div>						'
							+ '<div class = "eb-personal-event-info-header">'
								+ '<div class = "event-info-notes-header">'
+ '									Notes'
								+ '</div>'
								+ '<div class = "event-info-files-header">'
+ '									Files'
+ '								</div>								'
							+ '</div>'
							+ '<div class = "eb-personal-note-wedges">'
								+ '<div class = "eb-personal-wedges-notes-outer">'
								+ '</div>'
								+ '<div class = "eb-personal-wedges-notes-solid">'
+ '								</div>'
							+ '</div>'
							+ '<div class = "eb-personal-files-wedges">'
								+ '<div class = "eb-personal-wedges-notes-outer">'
								+ '</div>'
								+ '<div class = "eb-personal-wedges-notes-solid">'
+ '								</div>'
							+ '</div>							'
							+ '<div class = "eb-personal-event-info">'
							+ '	<div class = "eb-personal-event-notes">									'
									+ '<span class = "eb-personal-event-info-content">...'
+ '									</span>'
								+ '</div>'
								+ '<div class = "eb-personal-event-files">'
									+ '<span class = "eb-personal-event-info-content">...'
									+ '</span>'
+ '								</div>'
							+ '</div>'
							+ '<div class = "eb-personal-right">'
								+ '<div class = "eb-event-type">'
+ '									PERSONAL TO-DO'
								+ '</div>'
								+ '<div class = "eb-personal-tools-cont">'
								+ '</div>'
						+ '</div>'
	+ '					</div>						'
+ '					</div>					'
				+ '</div>';

    return appendVal;

}

function DisplayPersonalInvited(ary, formattedTime) {
    var updateVal = "";
    var colorString = "border-color:rgba(" + ary['red_code'] + "," + ary['green_code'] + "," + ary['blue_code'] + ", 0.23) rgba("
        + ary['red_code'] + "," + ary['green_code'] + "," + ary['blue_code']
        + ", 0.23) rgba(" + ary['red_code'] + "," + ary['green_code'] + "," + ary['blue_code']
        + ", 0.23) rgba(" + ary['red_code'] + "," + ary['green_code'] + "," + ary['blue_code'] + ", 0.455);"
        + "background-image: -moz-linear-gradient(left,rgba(" + ary['red_code'] + "," + ary['green_code'] + "," + ary['blue_code'] + ", 0.2),#FFFFFF 7%);"
        + "background-image: -webkit-linear-gradient(left,rgba(" + ary['red_code'] + "," + ary['green_code'] + "," + ary['blue_code'] + ", 0.48),#FFFFFF 5%);";

    var eventTimeColor = "background-color: rgb(" + ary['red_code'] + "," + ary['green_code'] + "," + ary['blue_code'] + ");";

    //if (prevEventDate != (new Date(ary['start_date'])).toUTCString().substr(0, 11)) {
    //    prevEventDate = (new Date(ary['start_date'])).toUTCString().substr(0, 11);
    //    updateVal += '<li id="' + ary['event_id'] + "_" + ary['type'] + "_" + (new Date(ary['start_date'])).toUTCString().substr(0, 16) + '"><div class="event_day_time" id="' + prevEventDate + '">' + prevEventDate + '</div>'
    //}
    //else {
    //    updateVal += '<li id="' + ary['event_id'] + "_" + ary['type'] + "_" + (new Date(ary['start_date'])).toUTCString().substr(0, 16) + '" style="position:relative; top:-35px;padding:0px;"><div class="event_day_time fade-out hide">' + prevEventDate + '</div>'
    //}
    updateVal += '<div id="' + ary['event_id'] + "_" + ary['type'] + "_" + (new Date(ary['start_date'])).toUTCString().substr(0, 16) + '" class = "eb-event-wrap eb-groupevent-wrap">'
        + '<div style="display:none;">' + (new Date(ary['start_date'])).toUTCString().substr(0, 12) + '</div>'
        + '<div class = "eventbook-event-cont eventbook-groupevent-cont" style="' + colorString + '">'
						+ '<div class = "eventbook-event-time" style="' + eventTimeColor + '">'
							+ '<span class = "eventbook-event-group">'
							+ '</span>'
							+ '<span>'
+ '								9:30 am - 11:30 am'
							+ '</span>'
						+ '</div>'
						+ '<div class = "eb-event-timeuntill">'
+ '							30 minutes from now'
	+ '					</div>'
						+ '<div class = "event-attend-status">	     '
		                    + '<span class = "attend-icon"></span>'
		                    + '<span class = "attend-title attend-title-toggler">Going</span>'
		                    + '<span class = "down-arrow"></span>'
		               + '</div>'
		               + '<div class = "dd-box-attending">'
+ '		               		<div class = "attending-option">'
		               			+ '<span class = "attend-icon remove-icon"></span>'
    + 'Remove from my calendar'
+ '</div>'
+ '</div>'
+ '<div class = "eb-event-titlepic">'
    + '<div class = "eb-event-pic-frame">'
        + '<div class = "eb-event-pic">'
        + '</div>'
    + '</div>'
    + '<div class = "eb-event-title-wrap">'
        + '<div class = "eb-event-title">'
            + 'Neuroscience Lab Meeting '
        + '</div>'
        + '<div class = "eb-event-loc-group-wrap">'
            + '<div class = "eb-event-location">'
                + '@ Lattimore 256'
            + '</div>'
            + '<span class= "midline-dot">&#183;</span>'
            + '<div class = "eb-event-group">'
                + 'Neurochemical Foundations of Behavior '
            + '</div>'
        + '</div>'
        + '<div class = "eb-event-description">'
            + 'The theories of borgeuoise republics and their images depicted in the media are poor representations of the entire domestic culture. The theories of borgeuoise republics and their images depicted in the media are poor representations of the entire domestic culture'
        + '</div>'
    + '</div>							'
+ '</div>'
+ '<div class = "eventbook-discuss-btn">'
    + 'View the full discussion <span>(10)</span>'
+ '</div>'
+ '<div class = "eventbook-groupevent-people">'
     + '<div class = "eb-group-creator">';
    if ((ary['name'] != null) && (ary['name'] != ""))
    {
    updateVal += 
        + '<div class = "eb-group-creator-picframe">'
            + '<div class = "eb-group-creator-pic">'
            + '</div>'
        + '</div>'
        + '<div class = "eb-group-creator-name">'
            + ary['name'].toString()
        + '</div>'
        + '<span class = "eb-group-created-copy">'
            + 'Added ' + ary['time_added'].toString()
        + '</span>';
}
    updateVal += '</div>'
        + '<div class = "eb-group-attending">'
            + '<div class = "eb-group-attending-header">';
    if ((ary['count'] != null) && (ary['count'] != null)) {
        updateVal += '<div class = "attending-header-left">'
            + '<span class = "people-number">' + ary['count'] + ' people attending</span>'
        + '</div>';
    }
    updateVal += '</div>'
        + '<div class = "eb-group-attendants-scrollable">'
            + '<div class = "eb-group-attendant">'
                + '<div class = "eb-attendant-pic">'
                + '</div>'
                + '<div class = "eb-attendant-name">'
                    + 'Ross Aarow Sobel Kahn Kopelman '
                + '</div>'
            + '</div>'
            + '<div class = "eb-group-attendant">'
                + '<div class = "eb-attendant-pic">'
+ '                </div>'
                + '<div class = "eb-attendant-name">'
                    + 'Anish Kumar'
                + '</div>'
            + '</div>            '
        + '</div>'
    + '</div>'
+ '</div>'
+ '</div> '
+ '<div class = "eb-event-discussion">'
+ '</div>'
+ '</div>';
    return updateVal;

}

function GroupPersonal(ary, formattedTime) {
    var updateVal = "";
    var colorString = "border-color:rgba(" + ary['red_code'] + "," + ary['green_code'] + "," + ary['blue_code'] + ", 0.23) rgba("
        + ary['red_code'] + "," + ary['green_code'] + "," + ary['blue_code']
        + ", 0.23) rgba(" + ary['red_code'] + "," + ary['green_code'] + "," + ary['blue_code']
        + ", 0.23) rgba(" + ary['red_code'] + "," + ary['green_code'] + "," + ary['blue_code'] + ", 0.455);"
        + "background-image: -moz-linear-gradient(left,rgba(" + ary['red_code'] + "," + ary['green_code'] + "," + ary['blue_code'] + ", 0.2),#FFFFFF 7%);"
        + "background-image: -webkit-linear-gradient(left,rgba(" + ary['red_code'] + "," + ary['green_code'] + "," + ary['blue_code'] + ", 0.48),#FFFFFF 5%);";

    var eventTimeColor = "background-color: rgb(" + ary['red_code'] + "," + ary['green_code'] + "," + ary['blue_code'] + ");";

    //if (prevEventDate != (new Date(ary['start_date'])).toUTCString().substr(0, 11)) {
    //    prevEventDate = (new Date(ary['start_date'])).toUTCString().substr(0, 11);
    //    updateVal += '<li id="' + ary['event_id'] + "_" + ary['type'] + "_" + (new Date(ary['start_date'])).toUTCString().substr(0, 16) + '"><div class="event_day_time" id="' + prevEventDate + '">' + prevEventDate + '</div>'
    //}
    //else {
    //    updateVal += '<li id="' + ary['event_id'] + "_" + ary['type'] + "_" + (new Date(ary['start_date'])).toUTCString().substr(0, 16) + '" style="position:relative; top:-35px;padding:0px;"><div class="event_day_time fade-out hide">' + prevEventDate + '</div>'
    //}
    updateVal += '<div id="' + ary['event_id'] + "_" + ary['type'] + "_" + (new Date(ary['start_date'])).toUTCString().substr(0, 16) + '" class = "eb-event-wrap eb-groupevent-wrap">'
        + '<div style="display:none;">' + (new Date(ary['start_date'])).toUTCString().substr(0, 12) + '</div>'
        + '<div class = "eventbook-event-cont eventbook-groupevent-cont" style="' + colorString + '">'
						+ '<div class = "eventbook-event-time" style="' + eventTimeColor + '">'
							+ '<span class = "eventbook-event-group">'
							+ '</span>'
							+ '<span>'
                            + formattedTime
							+ '</span>'
						+ '</div>'
						+ '<div class = "eb-event-timeuntill">'
+ '							30 minutes from now'
	+ '					</div>'
						+ '<div class = "event-attend-status">	     '
		                    + '<span class = "attend-icon"></span>'
		                    + '<span class = "attend-title attend-title-toggler">Going</span>'
		                    + '<span class = "down-arrow"></span>'
		               + '</div>'
		               + '<div class = "dd-box-attending">'
+ '		               		<div class = "attending-option">'
		               			+ '<span class = "attend-icon remove-icon"></span>'
    + 'Remove from my calendar'
+ '</div>'
+ '</div>'
+ '<div class = "eb-event-titlepic">'
    + '<div class = "eb-event-pic-frame">'
        + '<div class = "eb-event-pic">'
        + '</div>'
    + '</div>'
    + '<div class = "eb-event-title-wrap">';
    if (ary['title'] != null) {
        updateVal += '<div class = "eb-event-title">'
                + ary['title']
            + '</div>';
    }
    updateVal += '<div class = "eb-event-loc-group-wrap">';
    if ((ary['location'] != null) && (ary['location'] != "")) {
        updateVal += '<div class = "eb-event-location">'
                    + '@ ' + ary['location']
                + '</div>';
    }    
    if ((ary['group_name'] != null) && (ary['group_name'] != "")) {
        if ((ary['location'] != null) && (ary['location'] != "")) {
            updateVal += '<span class= "midline-dot">&#183;</span>';
        }
        updateVal += '<div class = "eb-event-group">'
            + ary['group_name']
        + '</div>';
    }
    updateVal += '</div>';
    if ((ary['group_name'] != null) && (ary['group_name'] != "")) {
        updateVal += '<div class = "eb-event-description">'
            + ary['description']
        + '</div>';
    }
    updateVal += '</div>'
+ '</div>'
+ '<div class = "eventbook-discuss-btn">'
    + 'View the full discussion <span>(10)</span>'
+ '</div>'
+ '<div class = "eventbook-groupevent-people">'
    + '<div class = "eb-group-creator">';
    if ((ary['name'] != null) && (ary['name'] != "")) {
        updateVal += '<div class = "eb-group-creator-picframe">'
            + '<div class = "eb-group-creator-pic">'
            + '</div>'
        + '</div>'
        + '<div class = "eb-group-creator-name">'
            + ary['name'].toString()
        + '</div>'
        + '<span class = "eb-group-created-copy">'
            + 'Added ' + ary['time_added'].toString()
        + '</span>';
    }
    updateVal += '</div>'
    + '<div class = "eb-group-attending">'
        + '<div class = "eb-group-attending-header">';
    if ((ary['count'] != null) && (ary['count'] != null)) {
        updateVal += '<div class = "attending-header-left">'
            + '<span class = "people-number">' + ary['count'] + ' people attending</span>'
        + '</div>';
    }
    updateVal += '</div>'
        + '<div class = "eb-group-attendants-scrollable">'
            + '<div class = "eb-group-attendant">'
                + '<div class = "eb-attendant-pic">'
                + '</div>'
                + '<div class = "eb-attendant-name">'
                    + 'Ross Aarow Sobel Kahn Kopelman '
                + '</div>'
            + '</div>'
            + '<div class = "eb-group-attendant">'
                + '<div class = "eb-attendant-pic">'
+ '                </div>'
                + '<div class = "eb-attendant-name">'
                    + 'Anish Kumar'
                + '</div>'
            + '</div>            '
        + '</div>'
    + '</div>'
+ '</div>'
+ '</div> '
+ '<div class = "eb-event-discussion">'
+ '</div>'
+ '</div>';
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

        //to be removed after the db error in sending the data from 1st jan 1970
        if (Math.round(Number((new Date((new Date(ary[i]['start_date'])).toUTCString()) - new Date(missingEventDates)) / (24 * 3600 * 1000))) < 0)
        {
            continue;
        }

        if (new Date(missingEventDates).toUTCString().substr(0, 16) != (new Date(ary[i]['start_date'])).toUTCString().substr(0, 16)) {
            var dateDiff = Math.round(Number((new Date((new Date(ary[i]['start_date'])).toUTCString()) - new Date(missingEventDates)) / (24 * 3600 * 1000)));
            //alert(dateDiff);
            var dateString = "";            
            for (var index = 1 ; index <= dateDiff; index++)
            {                
                dateString = new Date((new Date(missingEventDates)).setDate(((new Date(missingEventDates)).getDate() + 1)));
                dateString = dateString.toUTCString().substr(0, 11);
                if (i == 0) {
                    appendString +=
                '<div class = "eventbook-date-break fade-out" id="' + dateString + '">';
                }
                else {
                    appendString +=
                '<div class = "eventbook-date-break" id="' + dateString + '">';
                }                
                appendString += '<div class = "eb-db-date">'
                            + '<span class = "eb-db-day">'
                                + dateString.substr(0, 3)
                            + '</span>'
                            + '<div class = "eb-db-icon">'
                                + '<span class = "eb-db-icon-m">'
                                    + dateString.substr(8, 3)
                                + '</span>'
                                + '<span class = "eb-db-icon-d">'
                                    + dateString.substr(5, 2)
                                + '</span>'
                            + '</div>'
                        + '</div>'
                        + '<div class = "eb-db-jump">'
                        + '</div>'
                    + '</div>';

                appendString += '<div class = "eb-event-wrap" id="' + "_"
                    + (new Date((new Date(missingEventDates)).setDate(((new Date(missingEventDates)).getDate() + 1)))).toUTCString().substr(0, 16) + '">'
                    + '<div style="display:none;">' + dateString + '</div></div>';
                missingEventDates = new Date((new Date(missingEventDates)).setDate(((new Date(missingEventDates)).getDate() + 1)));
            }
            missingEventDates = new Date((new Date(missingEventDates)).setDate(((new Date(missingEventDates)).getDate() + 1)));
            if (dateString != "") {
                prevEventDate = dateString;//(new Date((new Date(missingEventDates)).setDate(((new Date(missingEventDates)).getDate() + 1)))).toUTCString().substr(0, 11);
            }
        }

        if (prevEventDate != (new Date(ary[i]['start_date'])).toUTCString().substr(0, 11)) {
            prevEventDate = (new Date(ary[i]['start_date'])).toUTCString().substr(0, 11);
            if (i == 0) {
                appendString +=
                    '<div class = "eventbook-date-break fade-out" id="' + prevEventDate + '">';
            }
            else {
                appendString +=
                    '<div class = "eventbook-date-break" id="' + prevEventDate + '">';
            }
            appendString += '<div class = "eb-db-date">'
                            + '<span class = "eb-db-day">'
                                + prevEventDate.substr(0, 3)
                            + '</span>'
                            + '<div class = "eb-db-icon">'
                                + '<span class = "eb-db-icon-m">'
                                    + prevEventDate.substr(8,3)
                                + '</span>'
                                + '<span class = "eb-db-icon-d">'
                                    + prevEventDate.substr(5, 2)
                                + '</span>'
                            + '</div>'
                        + '</div>'
                        + '<div class = "eb-db-jump">'
                        + '</div>'
                    + '</div>';
        }
        if (ary[i]['type'] == "1") {
            appendString += DisplayToDo(ary[i], formattedTime);
        }
        //else if ((ary[i]['type'] == "2") || (ary[i]['type'] == "3")) {
        //    appendString += DisplayPersonalInvited(ary[i], formattedTime);
        //}
        else if ((ary[i]['type'] == "2") || (ary[i]['type'] == "3")
            || (ary[i]['type'] == "4") || (ary[i]['type'] == "5")
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

    $(".eventbook-content").append(appendString);

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

            var param1 = new Date(responseText.event_array['start_date']);
            var param2 = (param1.getMonth() + 1) + '/' + (param1.getDate() + 1) + '/' + param1.getFullYear();
            $("#event_date").attr("value", param2);

            var startTime = "";
            if (responseText.event_array["start_time"] != null) {

                var hours = responseText.event_array["start_time"].substr(0, 2) == 0 ? "12" :
                    responseText.event_array["start_time"].substr(0, 2) > 12 ? ("0" + (responseText.event_array["start_time"].substr(0, 2) - 12)).slice(-2)
                    : ("0" + responseText.event_array["start_time"].substr(0, 2)).slice(-2);
                var minutes = responseText.event_array["start_time"].substr(3, 2);
                var ampm = responseText.event_array["start_time"].substr(0, 2) < 12 ? "am" : "pm";
                startTime = hours + ":" + minutes + " " + ampm;

            }

            $('#set_from_time_24hr').timeAutocomplete({

                increment: 15,
                formatter: 'ampm',
                start_hour: 0,
                value: startTime

            });
            var endTime = "";
            if (responseText.event_array["end_time"] != null) {

                var hours = responseText.event_array["end_time"].substr(0, 2) == 0 ? "12" :
                    responseText.event_array["end_time"].substr(0, 2) > 12 ? ("0" + (responseText.event_array["end_time"].substr(0, 2) - 12)).slice(-2)
                    : ("0" + responseText.event_array["end_time"].substr(0, 2)).slice(-2);
                var minutes = responseText.event_array["end_time"].substr(3, 2);
                var ampm = responseText.event_array["end_time"].substr(0, 2) < 12 ? "am" : "pm";
                endTime = hours + ":" + minutes + " " + ampm;

            }
            $('#set_to_time_24hr').timeAutocomplete({

                increment: 15,
                formatter: 'ampm',
                start_hour: 0,
                value: endTime

            });
            
            $('#nevt-location-1').val(responseText.event_array['location']);
            $('#nevt-title-1').val(responseText.event_array['title']);
            $('#nevt-desc-1').val(responseText.event_array['description']);
            $('#set_from_time_24hr').val(startTime);
            $('#set_to_time_24hr').val(endTime);
            $('.dd-title').text(responseText.event_array['recurrence']);

            $('#event_id').text(id);

            $('#event_type').text(type);

            $('#theme_id').text(responseText.event_array['theme_id']);

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
            $('#calendar').fullCalendar('removeEvents', id);
        },
        error: function (responseText) {
            alert(responseText);
        }
    });
}


function clearInsertFields() {

    var param1 = new Date();
    var param2 = (param1.getMonth() + 1) + '/' + param1.getDate() + '/' + param1.getFullYear();
    $("#event_date").attr("value", param2);

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
    $('.dd-title').text("None");
    $('#event_id').text("");
    $('#event_type').text("");
    $('#theme_id').text("");
    $('#inviteConnections').children('li').remove();
    $("#divInviteConnections").hide();
}

function LinkEventInEventBook(month, date, year) {
    var eventdate = year + "-" + ("0" + (month + 1)).slice(-2) + "-" + ("0" + date).slice(-2);
    eventdate = ((new Date(eventdate)).toUTCString()).substr(0, 11);
    $('.cal_view_events').text("Event Book");
    $('.cal_view_events').trigger("click");
    window.location.hash = eventdate;
    $(window).scrollTop(($(window).scrollTop() - 60));
}

function DisplayCalendarFetchEvents(responseText) {

    for (var i = 0; i < responseText.events_array.length; i++) {
        var locn = "";
        if (responseText.events_array[i]["location"] != "null") {
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
            if (starttoendtime != (hours + ":" + minutes + " " + ampm)) {
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
             startendtime: starttoendtime,
             color: "rgb(" + responseText.events_array[i]["red_color"] + "," + responseText.events_array[i]["green_color"] + "," + responseText.events_array[i]["blue_color"] + ")"
             //"startEditable: " + "true" + "," +
             //"durationEditable: " + "true" + "," +
             //"allDay: " + "false" 

             //url: 

         },
         true // make the event "stick"
       );

    }

}



function ScrollFunctionToSetOffset() {

    var st = $(window).scrollTop();
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

}



function RenderCourseClubGroups() {

    $.ajax({

        url: "php/fetch_user_groups.php",        
        type: "POST",
        dataType: "json",
        success: function (responseText) {

            for (var i = 0; i < responseText.course_array.length; i++) {

                $('#class_groups').append('<div class = "cal-group" style="background-color:rgba(' +
                    responseText.course_array[i]['red_color']
                    + ',' + responseText.course_array[i]['green_color']
                    + ',' + responseText.course_array[i]['blue_color'] + ',0.5);">'

                                        + '<div class = "cal-group-pic"></div>'

                                        + '<div class = "cal-group-name">'

                                            + '<span>' + responseText.course_array[i]['course_name'] + '</span>'

                                        + '</div>'

                                        + '<div class = "cal-group-toggle cal-group-toggle-checked" style="background-color:rgba(' +
                    responseText.course_array[i]['red_color']
                    + ',' + responseText.course_array[i]['green_color']
                    + ',' + responseText.course_array[i]['blue_color'] + ',0.5);">'

                                            + '<span class = "cal-group-checkmark cal-group-checkmark-checked"></span>'

                                        + '</div>'

                                    + '</div>');

            }



            for (var i = 0; i < responseText.group_array.length; i++) {

                $('#club_groups').append('<div class = "cal-group" style="background-color:rgba(' +
                    responseText.course_array[i]['red_color']
                    + ',' + responseText.course_array[i]['green_color']
                    + ',' + responseText.course_array[i]['blue_color'] + ',0.5);">'

                                        + '<div class = "cal-group-pic"></div>'

                                        + '<div class = "cal-group-name">'

                                            + '<span>' + responseText.group_array[i]['group_name'] + '</span>'

                                        + '</div>'

                                        + '<div class = "cal-group-toggle cal-group-toggle-checked" style="background-color:rgba(' +
                    responseText.course_array[i]['red_color']
                    + ',' + responseText.course_array[i]['green_color']
                    + ',' + responseText.course_array[i]['blue_color'] + ',0.5);">'

                                            + '<span class = "cal-group-checkmark cal-group-checkmark-checked"></span>'

                                        + '</div>'

                                    + '</div>');

            }

        //responseText.course_array['red_code'],

        //responseText.course_array['green_code'],

        //responseText.course_array['blue_code']            

        //responseText.group_array['red_code'],

        //responseText.group_array['green_code'],

        //responseText.group_array['blue_code']

        },

        error: function (responseText) {

            alert(responseText);

        }

    });

}