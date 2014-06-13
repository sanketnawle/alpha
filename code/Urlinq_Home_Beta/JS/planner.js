$(document).ready(function() {

    $(document).delegate("#add_event", 'click',
            function() {
                var name = $("#event_name").val().toString();
                var time = $("#set_time_24hr").val().toString();
                var date = $("#event_date").val().toString();
                $.ajax({
                    url: "../HTML/Planner/insert.php",
                    data: {event_name: name, event_time: time, event_date: date},
                    type: "POST",
                    dataType: "json",
                    success: function(responseText)
                    {
                        document.getElementById("result").innerHTML = responseText.echo_string;
                        document.getElementById("event_count").innerHTML = responseText.event_count.toString();
//                            location.reload();

                    },
                    error: function(responseText) {
//                           document.getElementById("result").innerHTML = responseText;
                        alert("Connection Error. Try Later!");
                    }
                });
            });

    $(document).delegate('.fa-caret-down', 'click', function() {
        $('.pl_options').toggleClass('unhider');
        $('.fa-caret-down').toggleClass('open_Menu');
    });

    $(document).delegate('.button-block button', 'click', function() {
        var $event_id = $(this).parent().parent().attr('id');
        $event_id = parseInt($event_id.replace("w-2-2", ""));        
        var $this = $(this).parent();
        var $a = $(this).closest(".toDowrapper");
        if ($a.hasClass("checked")) {            
            $a.removeClass('checked');
            changeIncomplete('Increase');
            changeIsChecked($event_id, 0);
        } else {
            $a.addClass('checked');
            changeIncomplete('Decrease');
            changeIsChecked($event_id, 1);
        }

        $this.toggleClass('canceled');
        return false;
    });

    function changeIsChecked($event_id, $value) {
        $.ajax({
            url: "../HTML/Planner/update.php",
            data: {event_id: $event_id, value: $value},
            type: "POST",
            dataType: "json",            
        });
    }

    function changeIncomplete($choice) {
        switch ($choice) {
            case 'Decrease':
                $event_count = document.getElementById("event_count").innerHTML;
                $event_count = $event_count.split(" ");
                if ((parseInt($event_count[0]) - 1) === 0) {
                    document.getElementById("event_count").innerHTML = "All Complete";
                } else {
                    $event_count[0] = (parseInt($event_count[0]) - 1).toString();
                    document.getElementById("event_count").innerHTML = $event_count[0] + " " + $event_count[1];
                }
                break;
            case 'Increase':
                $event_count = document.getElementById("event_count").innerHTML;
                if ($event_count.search("All") == -1) {
                    $event_count = $event_count.split(" ");
                    $event_count[0] = (parseInt($event_count[0]) + 1).toString();
                    document.getElementById("event_count").innerHTML = $event_count[0] + " " + $event_count[1];
                } else {
                    document.getElementById("event_count").innerHTML = 1 + " " + "Incomplete";
                }
                break;
            default:
                alert("Should never come here");

        }
    }

    $(document).delegate('.btn_canc', 'click', function() {
        $('.pl_add').css('height', '19px');
        $('.pl_addevnt').css('display', 'none');
        //$('.planner').css('height', '325px');
        $('.pl_add').attr("placeholder", "+ Add new Event");
        $('.pl_add').val("");

    });

    $(document).delegate('.btn_addvent', 'click', function() {
        $('.pl_add').css('height', '19px');
        $('.pl_addevnt').css('display', 'none');
        //$('.planner').css('height', '325px');
        $('.pl_add').attr("placeholder", "+ Add new Event");
        $('.pl_add').val("");

    });

    $(document).delegate(".pl_add", "click", function() {

        $('.pl_add').css('height', '34px');
        $('.pl_addevnt').css('display', 'block');
        // $('.planner').css('height', '409px');
        $('.pl_add').attr("placeholder", "Name this event...");

    });

    $(document).on("click", function(e) {
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

$(document).ready(function() {
    $(function() {
        $('#nevt-desc').autogrow();
        $('#nevt-desc').css('overflow', 'hidden').autogrow()
    });

    var renderEventAct0 = [];
    var renderEventAct1 = [];

    $("#edit-picture").hide();

    $(document).delegate("#profile-picture", "mouseover", function() {
        $("#edit-picture").show();
    });
    $(document).delegate("#edit-picture", "mouseover", function() {
        $("#edit-picture").show();
    });
    $(document).delegate("#edit-picture", "mouseout", function() {
        $("#edit-picture").hide();
    });
    $(document).delegate("#profile-picture", "mouseout", function() {
        $("#edit-picture").hide();
    });

    $(".class-name").each(function(index) {
        if ($(this).text().length > 21) {
            //alert($(this).attr("id"));
            $(this).text($(this).text().substr(0, 18) + "...");
        }
    });
    $(".club-name").each(function(index) {
        if ($(this).text().length > 21) {
            //alert($(this).attr("id"));
            $(this).text($(this).text().substr(0, 18) + "...");
        }
    });

    $(document).delegate(".editcolumn", "keyup", function() {
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

    $(document).delegate(".editingbio", "keyup", function() {
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

    $(document).delegate(".annbuttons", "click", function() {

        $("#blackcanvas2").fadeOut();

        if ($(this).hasClass("ann-submit")) {

            var tid = $(this).attr("id").split("=");
            var cid = tid[1];
            /*cid is the course/club id*/

            /*Ajax goes here*/
        }

    });

    //need slightly revise!!
    $(document).delegate(".acabuttons", "click", function() {



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
                $.each(renderEventAct0, function(index, value) {
                    var mth = value.split("::");
                    var ind = mth[1];
                    var dte = mth[0];
                    if (parseInt(ind) == parseInt($m)) {
                        $("#" + dte).addClass("active0");
                    }
                });

                $.each(renderEventAct1, function(index, value) {
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
            $("#bc3content").animate({marginRight: "-=700px"});

            $(".blackcanvas3").hide();
            animationflag = 0;

        }

    });

    $(document).delegate(".addmore", "click", function() {
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

    $(document).delegate(".announce", "mousedown", function() {
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
    $(document).delegate(".addevent", "mousedown", function() {
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
        $("#bc3content").animate({marginRight: "+=700px"});
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

$(document).ready(function (){
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


    $(document).delegate('#event_date', 'click', function() {
//        $('.calLayer').css('display', 'block');
        $('.calLayer').toggle();
    });

    // set time options for time picker 24hr
    if ((new Date().getMonth() + 1) >= $("#event_date").val().split('/')[0]) {
        if (new Date().getDate() <= $("#event_date").val().split('/')[1]) {
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