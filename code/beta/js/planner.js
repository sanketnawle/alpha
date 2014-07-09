$(document).ready(function () {



    //    $(function() {

    //        var ts = new Date();

    //        var hours = ts.getHours();

    //        if (hours < 10) {

    //            hours = '0' + hours;

    //        }

    //        var minutes = ts.getMinutes();

    //        if (minutes < 10) {

    //            minutes = '0' + minutes;

    //        }

    //        var seconds = ts.getSeconds();

    //        if (seconds < 10) {

    //            seconds = '0' + seconds;

    //        }

    //        var year = ts.getFullYear();

    //        var month = ts.getMonth() + 1;

    //        if (month < 10) {

    //            month = '0' + month;

    //        }

    //        var day = ts.getDate();

    //        if (day < 10) {

    //            day = '0' + day;

    //        }

    //        var time = hours + ":" + minutes + ":" + seconds;

    //        var date = year + "-" + month + "-" + day;

    //        alert(time + " " + date);

    //        $.ajax({

    //            url: "planner.php",

    //            data: {time: time, date: date},

    //            type: "POST",

    //            success: function(responseText)

    //

    //            {

    //                document.getElementById("divPlanner").innerHTML = responseText;

    ////                document.getElementById("event_count").innerHTML = responseText.event_count.toString();

    ////                          alert("responseText");

    //            }

    //        });

    //    });


    $('#event_name').on('keyup', function () {        

        $('#event_name').removeClass("event_name_error");
        $('#event_name').attr("placeholder", "+ Add new Event");
    });



    $(document).delegate(".btn_addvent", 'click',

            function () {
                var name = $("#event_name").val().toString();                
                var start_time = $("#set_time_24hr").val().toString();
                var start_date = $("#event_date").val().toString();
                var ts = new Date();

                if ((name == null) || (name.trim() == ""))
                {
                    //$('#alertModal').show();
                    //$('#alertModal').parent('.blackcanvas').show();
                    //$('#alertMessage').text("Please enter an event title.");
                    $('#event_name').addClass("event_name_error");
                    $('#event_name').attr("placeholder", "Please enter an event title...");
                    $('#event_name').focus();
                    return;
                }
                var hours = ts.getHours();

                if (hours < 10) {
                    hours = '0' + hours;
                }
                var minutes = ts.getMinutes();
                if (minutes < 10) {
                    minutes = '0' + minutes;
                }
                var seconds = ts.getSeconds();
                if (seconds < 10) {
                    seconds = '0' + seconds;
                }
                var year = ts.getFullYear();
                var month = ts.getMonth() + 1;
                if (month < 10) {
                    month = '0' + month;
                }
                var day = ts.getDate();
                if (day < 10) {
                    day = '0' + day;
                }
                var time = hours + ":" + minutes + ":" + seconds;
                var date = year + "-" + month + "-" + day;                

                $.ajax({
                    url: "php/planner_insert.php",
                    data: { event_name: name, event_time: start_time, event_date: start_date, time: time, date: date },
                    type: "POST",
                    dataType: "json",
                    success: function (responseText) {
                        document.getElementById("result").innerHTML = responseText.echo_string;
                        $('#alertModal').show();

                        $('.pl_add').css('height', '19px');
                        $('.pl_addevnt').css('display', 'none');
                        $('.pl_add').attr("placeholder", "+ Add new Event");
                        $('.pl_add').val("");
                    },
                    error: function (responseText) {                        
                        $('#alertModal').show();
                        $('#alertModal').parent('.blackcanvas').show();
                        $('#alertMessage').text("Connection Error!! Try Again.");
                    }
                });
            }
            );

    $(document).delegate('.planner_dropdown', 'click', function () {
        $('.pl_options').toggle();
        //$('.fa-caret-down').toggleClass('open_Menu');
    });
    $(document).delegate('.pl_option', 'click', function () {
        $('.pl_options').toggle();
        //$('.fa-caret-down').toggleClass('open_Menu');
    });

    $(document).delegate('.button-block button', 'click', function () {
        var $event_id = $(this).parent().parent().attr('id');
        $event_id = $event_id.replace("w-2-2", "");
        var $event_details = $event_id.split("_");
        $event_id = $event_details[0];
        var $event_type = $event_details[1];

        //        alert($event_id + " " + $event_type);
        var $this = $(this).parent();
        var $a = $(this).closest(".toDowrapper");
        if ($a.hasClass("checked")) {
            $a.removeClass('checked');
            changeIsChecked($event_id, $event_type, 0);
        } else {
            $a.addClass('checked');
            changeIsChecked($event_id, $event_type, 1);
        }

        $this.toggleClass('canceled');
        return false;
    });


    $(".evntName").each(function () {

        var txt = $(this).text();
        if (txt.length >= 42) {
            txt = txt.substring(0, 39) + "...";
        }

        $(this).text(txt);

    });





    function changeIsChecked($event_id, $event_type, $value) {

        $.ajax({

            url: "php/planner_update.php",

            data: { event_id: $event_id, value: $value, event_type: $event_type },

            type: "POST"
        });



    }







    $(document).delegate('.btn_canc', 'click', function () {



        $('.pl_add').css('height', '19px');



        $('.pl_addevnt').css('display', 'none');



        //$('.planner').css('height', '325px');



        $('.pl_add').attr("placeholder", "+ Add new Event");



        $('.pl_add').val("");







    });


    $(document).delegate(".pl_add", "click", function () {







        $('.pl_add').css('height', '34px');



        $('.pl_addevnt').css('display', 'block');



        // $('.planner').css('height', '409px');



        $('.pl_add').attr("placeholder", "Name this event...");







    });







    $(document).on("click", function (e) {
        var elem = $(e.target);
        if (!elem.hasClass("evnt_inps") &&
                !elem.hasClass("set_date")) {
            $('.calLayer').css('display', 'none');
        }
        if (elem.hasClass("days") ||
                elem.hasClass("m-prev") ||
                elem.hasClass("m-next") ||
                elem.hasClass("minical-header") ||
                elem.hasClass("minical-h1")) {
            $('.calLayer').css('display', 'block');
        }

        if (!elem.hasClass("planner_dropdown")) {
            $('.pl_options').hide();
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



});







$(document).ready(function () {



    var blinkflag = 0;



    var moveflag = 0;



    var param1 = new Date();



    var param2 = (param1.getMonth() + 1) + '/' + param1.getDate() + '/' + param1.getFullYear();



    $("#event_date").attr("value", param2);



    $startTime = 0;



    $(document).delegate(".calcell", "click", function () {
        if (!$(this).hasClass("disable")) {
            if (blinkflag == 0) {                
                // To reset the format of the timepicker
                if ((new Date().getMonth() + 1) >= $("#event_date").val().split('/')[0]) {
                    if (new Date().getDate() < $("#event_date").val().split('/')[1]) {
                        $('#set_time_24hr').timeAutocomplete({
                            increment: 10,
                            formatter: 'ampm',
                            start_hour: 0,
                            value: 'Add a time?'
                        });
                    }
                    else {
                        $('#set_time_24hr').timeAutocomplete({
                            increment: 10,
                            formatter: 'ampm',
                            start_hour: new Date().getHours(),
                            value: 'Add a time?'                            
                        });                      
                    }
                }
                else {
                    $('#set_time_24hr').timeAutocomplete({
                        increment: 10,
                        formatter: 'ampm',
                        start_hour: 0,
                        value: 'Add a time?'
                    });
                }
            }
        }
    });

    $(document).delegate('#event_date', 'click', function () {
        $('.calLayer').toggle();
    });

    // set time options for time picker 24hr
    if ((new Date().getMonth() + 1) >= $("#event_date").val().split('/')[0]) {
        if (new Date().getDate() <= $("#event_date").val().split('/')[1]) {
            $startTime = new Date().getHours();
        }
    }
    var curDt = new Date(new Date().getTime() + (10 * 60000));
    $currentTime = curDt.getHours() + ':' + ("0" + curDt.getMinutes()).slice(-2) + ':00';
    $('#set_time_24hr').timeAutocomplete({
        increment: 10,
        formatter: 'ampm',
        start_hour: $startTime,
        value: $currentTime
    });

    function UpdateEvents() {
        var dt = new Date();
        //var now_time = ("0" + dt.getHours()).slice(-2) + ':' + ("0" + new Date().getMinutes()).slice(-2) + ':00';
        //var today_date = dt.getFullYear() + "-" + ("0" + (dt.getMonth() + 1)).slice(-2) + "-" + ("0" + dt.getDate()).slice(-2);
        var hours = dt.getHours() == 0 ? "12" : dt.getHours() > 12 ? dt.getHours() - 12 : dt.getHours();
        var minutes = (dt.getMinutes() < 10 ? "0" : "") + dt.getMinutes();
        var ampm = dt.getHours() < 12 ? "am" : "pm";
        var formattedTime = hours + ":" + minutes + " " + ampm;


        if ($('#result').prop('childNodes').length >= 2) {
            $(".upc-1").each(function (index) {
                if ($(this).children('.upc-floatL').children(':last').text() == formattedTime) {
                    //$('#result').append(getEvents(today_date, now_time));
                    $.ajax({
                        url: "php/planner_events.php",
                        data: { },//date: today_date, time: now_time },
                        type: "POST",
                        dataType: "json",
                        success: function (responseText) {
                            document.getElementById("result").innerHTML = responseText.echo_string;
                        },
                        error: function (responseText) {
                            alert("failure");
                        }
                    });
                }         
            });
        }
        else {
            $.ajax({
                url: "php/planner_events.php",
                data: { },//date: today_date, time: now_time},
                type: "POST",
                dataType: "json",
                success: function (responseText) {
                    document.getElementById("result").innerHTML = responseText.echo_string;
                    $('#divPlanner').show();
                },
                error: function (responseText) {
                    var test = responseText.responseText;
                }
            });
        }
    }

    setInterval(function () { UpdateEvents() }, 1000);
    UpdateEvents();
});