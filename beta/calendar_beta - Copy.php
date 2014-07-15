<!DOCTYPE html>

<html>

<head>

    <title>Calendar</title>

    <link href='css/cal_main.css' rel='stylesheet' />

    <link rel="stylesheet" type="text/css" href="css/planner.css" />

    <link href='css/myfullcalendar.css' rel='stylesheet' />

    <link href="http://select-box.googlecode.com/svn/tags/0.2/jquery.selectbox.css" type="text/css" rel="stylesheet" />

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" type="text/css" href="css/background_cal.css">

    <link rel="stylesheet" type="text/css" href="css/datepicker.css" />

    <link rel="stylesheet" type="text/css" href="css/eventBook.css" />



    <!--<link href='css/p01.css' rel='stylesheet' />

    <link type="text/css" href="css/jquery.simple-dtpicker.css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="css/banner.css">

    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

    <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css" />

    <link rel="stylesheet" type="text/css" href="css/bootstrap-timepicker.css" />

    <link rel="stylesheet" type="text/css" href="css/pygments.css" />

    <link rel="stylesheet" type="text/css" href="css/prettify.css" />

    <link rel="stylesheet" type="text/css" href="css/add.css" />-->

    <!--<link rel="stylesheet" type="text/css" href="css/minical.css">        

    <link rel="stylesheet" type="text/css" href="css/jquery.datepick.css">-->



    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

    <script type="text/javascript" src="http://select-box.googlecode.com/svn/tags/0.2/jquery.selectbox-0.2.min.js"></script>

    <script src='js/jquery.min.js'></script>

    <script src='js/jquery-ui.custom.min.js'></script>

    <script src='js/myfullcalendar.js'></script>

    <!--<script src='js/md5.js'></script>

    <script type="text/javascript" src="js/jquery.simple-dtpicker.js"></script>

    <script type="text/javascript" src="js/prettify.js"></script>

    <script type="text/javascript" src="js/bootstrap.js"></script>-->

    <script type="text/javascript" src="js/bootstrap-timepicker.js"></script>

    <script type="text/javascript" src="js/jquery.plugin.js"></script>

    <script type="text/javascript" src="js/jquery.datepick.js"></script>

    <script src="js/jquery-ui-1.10.2.custom.min.js"></script>

    <script src="js/jquery.timeAutocomplete.min.js" type="text/javascript"></script>

    <script src="js/ampm.js" type="text/javascript"></script>

    <script src="js/calendar_selector.js" type="text/javascript"></script>

    <script src="js/mycalendar-event-book.js" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
        var tdt=$(".fc-header-left .fc-header-title h2").text();
        var tdtarr=tdt.split(" ");
        var tdtarr1="<span class='tdt_0'>"+tdtarr[0]+"</span>";
        var tdtarr2="<span class='tdt_1'>"+tdtarr[1]+"</span>";
        var tdt= tdtarr1+" "+tdtarr2;
        $(".fc-header-left .fc-header-title h2").html(tdt);

        $(document).delegate(".fc-button", "click", function () {
            var tdt=$(".fc-header-left .fc-header-title h2").text();
            var tdtarr=tdt.split(" ");
            var tdtarr1="<span class='tdt_0'>"+tdtarr[0]+"</span>";
            var tdtarr2="<span class='tdt_1'>"+tdtarr[1]+"</span>";
            var tdt= tdtarr1+" "+tdtarr2;
            $(".fc-header-left .fc-header-title h2").html(tdt);
        });

        });
    </script>

</head>



<body>

    <div class="root">

        <div class="top-bar">

            <div class="top-bar-wrapper">

                <img class="logo-h" src="img/logo.png" />

            </div>

        </div>

        <div class="main">

            <div class="leftsec">

                <div class="sunken_toggle">

                    <span class="active_view"></span>

                    <div class="cal_view_monthly">

                        Monthly Planner

                    </div>

                    <div class="cal_view_events">

                        Event Book

                    </div>

                </div>

                
                <div id="event-new">

                    <div id="button-border">

                        <div class="announcecolumn toolsforclass" style="position: relative">

                            <div class="addevent adminc" id="addEvent" style="">

                                <button type="button" class="btn-addevent">Add Event</button>

                            </div>

                            <br>

                            <br>

                            <section class="blackcanvas30">

                                <div id="bc3contentAddEvent">

                                    <div class="add_event_container invite_connections" id="divInviteConnections" style="display: none;">

                                                        <div class="addevent-header0-1" style="width: 465px;">

                                                            <!--<a class="dexit-1" id="divClose">close</a>-->

                                                            <div class="dexit-1" id="divClose">

                                                                <i class="remove_icon"></i>

                                                            </div>

                                                            <h1 class="addevent-header1-1" style="width: 200px;">Invite Connections</h1>

                                                        </div>

                                                        <div class="uploadform-1">

                                                            <div class="qa_scrollcontainer" style="max-height: 400px; width: 474px; background: #FFF; z-index: 1; min-height: 350px;">

                                                                <div class="iComments" id="inviteConnections">

                                                                    

                                                                </div>

                                                            </div>

															<div class='repeatc-1 invites_done'>

                                                <button class="btn-addevent-1 btn-addevent" id="btnInviteDone">Done</button>

                                            </div>

                                                        </div>

                                                    </div>

                                    <div class="add_event_container">

                                        <div class="addevent-header0-1">

                                            <!--<a class="dexit-1" >cancel</a>-->

                                            <div class="dexit-1" id="divCancel">

                                                <i class="remove_icon"></i>

                                            </div>

                                            <h1 class="addevent-header1-1">Add Event <div class="hide" id="event_id"></div><div class="hide" id="event_type"></div></h1>

                                            <!--<div class="addevent-header-1">

                                                <div class="fa fa-caret-down">Group Tag</div>

                                                <div class="pl_options pl_options-1">

                                                    <div class="pl_option pl_option-1">Group 1 </div>

                                                    <div class="pl_option pl_option-1">Group 2</div>

                                                    <div class="pl_option pl_option-1">Group 3</div>

                                                </div>

                                            </div>-->

                                        </div>

                                        <div class="uploadform-1">

                                            <div class="uploadevent-1">



                                                <input type="text" id="nevt-title-1" placeholder="Title" class="nevt-input-1">

                                                <input type="text" id="nevt-location-1" placeholder="Location" class="nevt-input-1">



                                                <textarea id="nevt-desc-1" onkeypress="taHeight()" placeholder="Details" class="nevt-input-1"></textarea>

                                                <hr class="addevt">

                                                <div class="pdateinfo-1">

                                                    <span id="startdate-input-1">Pick a Date &#187;

                                <input class="set_date" name="event_date" id="event_date" />

                                                        <div class="calLayer">

                                                            <section id="mounth" class="mounth" style="margin-left: 43px; margin-top: 20px;">

                                                                <header class="minical-header">

                                                                    <h1 class="minical-h1">JANUARY 2013</h1>



                                                                    <nav role="padigation">

                                                                        <span class="m-prev"></span>

                                                                        <span class="m-next"></span>

                                                                    </nav>

                                                                </header>



                                                                <article>

                                                                    <div class="days">

                                                                        <b>SU</b>

                                                                        <b>MO</b>

                                                                        <b>TU</b>

                                                                        <b>WE</b>

                                                                        <b>TH</b>

                                                                        <b>FR</b>

                                                                        <b>SA</b>

                                                                    </div>

                                                                    <div class="dates">

                                                                        <span id="calcell_su_0" class="calcell disable cl_0"></span>

                                                                        <span id="calcell_mo_1" class="calcell disable cl_1"></span>

                                                                        <span id="calcell_tu_2" class="calcell disable cl_2"></span>

                                                                        <span id="calcell_we_3" class="calcell disable cl_3"></span>

                                                                        <span id="calcell_th_4" class="calcell disable cl_4"></span>

                                                                        <span id="calcell_fr_5" class="calcell disable cl_5"></span>

                                                                        <span id="calcell_sa_6" class="calcell disable cl_6"></span>

                                                                        <span id="calcell_su_7" class="calcell disable cl_7"></span>

                                                                        <span id="calcell_mo_8" class="calcell disable cl_8"></span>

                                                                        <span id="calcell_tu_9" class="calcell disable cl_9"></span>

                                                                        <span id="calcell_we_10" class="calcell disable cl_10"></span>

                                                                        <span id="calcell_th_11" class="calcell disable cl_11"></span>

                                                                        <span id="calcell_fr_12" class="calcell disable cl_12"></span>

                                                                        <span id="calcell_sa_13" class="calcell disable cl_13"></span>

                                                                        <span id="calcell_su_14" class="calcell disable cl_14"></span>

                                                                        <span id="calcell_mo_15" class="calcell disable cl_15"></span>

                                                                        <span id="calcell_tu_16" class="calcell disable cl_16"></span>

                                                                        <span id="calcell_we_17" class="calcell disable cl_17"></span>

                                                                        <span id="calcell_th_18" class="calcell disable cl_18"></span>

                                                                        <span id="calcell_fr_19" class="calcell disable cl_19"></span>

                                                                        <span id="calcell_sa_20" class="calcell disable cl_20"></span>

                                                                        <span id="calcell_su_21" class="calcell disable cl_21"></span>

                                                                        <span id="calcell_mo_22" class="calcell disable cl_22"></span>

                                                                        <span id="calcell_tu_23" class="calcell disable cl_23"></span>

                                                                        <span id="calcell_we_24" class="calcell disable cl_24"></span>

                                                                        <span id="calcell_th_25" class="calcell disable cl_25"></span>

                                                                        <span id="calcell_fr_26" class="calcell disable cl_26"></span>

                                                                        <span id="calcell_sa_27" class="calcell disable cl_27"></span>

                                                                        <span id="calcell_su_28" class="calcell disable cl_28"></span>

                                                                        <span id="calcell_mo_29" class="calcell disable cl_29"></span>

                                                                        <span id="calcell_tu_30" class="calcell disable cl_30"></span>

                                                                        <span id="calcell_we_31" class="calcell disable cl_31"></span>

                                                                        <span id="calcell_th_32" class="calcell disable cl_32"></span>



                                                                        <span id="calcell_fr_33" class="disable calcell cl_33"></span>

                                                                        <span id="calcell_sa_34" class="disable calcell cl_34"></span>

                                                                        <span id="calcell_su_35" class="disable calcell cl_35"></span>

                                                                        <span id="calcell_mo_36" class="disable calcell cl_36"></span>

                                                                        <span id="calcell_tu_37" class="disable calcell cl_37"></span>

                                                                        <span id="calcell_we_38" class="disable calcell cl_38"></span>

                                                                        <span id="calcell_th_39" class="disable calcell cl_39"></span>

                                                                        <span id="calcell_fr_40" class="disable calcell cl_40"></span>

                                                                        <span id="calcell_sa_41" class="disable calcell cl_41"></span>

                                                                    </div>

                                                                </article>

                                                            </section>

                                                        </div>



                                                    </span>

                                                    <div class='frtext-1'>

                                                        From:

                                <input id="set_from_time_24hr" class="set_time" name="event_time" style="width: 68px;" />

                                                    </div>

                                                    <div class='totext-1'>

                                                        To:

                                <input id="set_to_time_24hr" class="set_time" name="event_time" style="width: 68px;" />

                                                    </div>



                                                </div>

                                                <div class='repeatc-1'>

                                                    <div class='repeathead-1'>Repeat:</div>

                                                    <span class='repeatstate-1'>None</span>

                                                    <div class='repeatoption-1'>

                                                        <div class='repeatoptiont-1'>None</div>

                                                        <hr class="post_options_hr-1" />

                                                        <div class='repeatoptiont-1'>Daily</div>

                                                        <hr class="post_options_hr-1" />

                                                        <div class='repeatoptiont-1'>Weekly</div>

                                                        <hr class="post_options_hr-1" />

                                                        <div class='repeatoptiont-1'>Monthly</div>

                                                    </div>





                                                    <span class="repeat_date">End Date &#187;

                                <input class="set_date" name="event_date" id="repeat_end_date" />

                                                        <div class="calLayer">

                                                            <section id="Section2" class="mounth" style="margin-left: 43px; margin-top: 20px;">

                                                                <header class="minical-header">

                                                                    <h1 class="minical-h1">JANUARY 2013</h1>



                                                                    <nav role="padigation">

                                                                        <span class="m-prev"></span>

                                                                        <span class="m-next"></span>

                                                                    </nav>

                                                                </header>



                                                                <article>

                                                                    <div class="days">

                                                                        <b>SU</b>

                                                                        <b>MO</b>

                                                                        <b>TU</b>

                                                                        <b>WE</b>

                                                                        <b>TH</b>

                                                                        <b>FR</b>

                                                                        <b>SA</b>

                                                                    </div>

                                                                    <div class="dates">

                                                                        <span id="calcell_su_100" class="calcell disable cl_0"></span>

                                                                        <span id="calcell_mo_101" class="calcell disable cl_1"></span>

                                                                        <span id="calcell_tu_102" class="calcell disable cl_2"></span>

                                                                        <span id="calcell_we_103" class="calcell disable cl_3"></span>

                                                                        <span id="calcell_th_104" class="calcell disable cl_4"></span>

                                                                        <span id="calcell_fr_105" class="calcell disable cl_5"></span>

                                                                        <span id="calcell_sa_106" class="calcell disable cl_6"></span>

                                                                        <span id="calcell_su_107" class="calcell disable cl_7"></span>

                                                                        <span id="calcell_mo_108" class="calcell disable cl_8"></span>

                                                                        <span id="calcell_tu_109" class="calcell disable cl_9"></span>

                                                                        <span id="calcell_we_110" class="calcell disable cl_10"></span>

                                                                        <span id="calcell_th_111" class="calcell disable cl_11"></span>

                                                                        <span id="calcell_fr_112" class="calcell disable cl_12"></span>

                                                                        <span id="calcell_sa_113" class="calcell disable cl_13"></span>

                                                                        <span id="calcell_su_114" class="calcell disable cl_14"></span>

                                                                        <span id="calcell_mo_115" class="calcell disable cl_15"></span>

                                                                        <span id="calcell_tu_116" class="calcell disable cl_16"></span>

                                                                        <span id="calcell_we_117" class="calcell disable cl_17"></span>

                                                                        <span id="calcell_th_118" class="calcell disable cl_18"></span>

                                                                        <span id="calcell_fr_119" class="calcell disable cl_19"></span>

                                                                        <span id="calcell_sa_120" class="calcell disable cl_20"></span>

                                                                        <span id="calcell_su_121" class="calcell disable cl_21"></span>

                                                                        <span id="calcell_mo_122" class="calcell disable cl_22"></span>

                                                                        <span id="calcell_tu_123" class="calcell disable cl_23"></span>

                                                                        <span id="calcell_we_124" class="calcell disable cl_24"></span>

                                                                        <span id="calcell_th_125" class="calcell disable cl_25"></span>

                                                                        <span id="calcell_fr_126" class="calcell disable cl_26"></span>

                                                                        <span id="calcell_sa_127" class="calcell disable cl_27"></span>

                                                                        <span id="calcell_su_128" class="calcell disable cl_28"></span>

                                                                        <span id="calcell_mo_129" class="calcell disable cl_29"></span>

                                                                        <span id="calcell_tu_130" class="calcell disable cl_30"></span>

                                                                        <span id="calcell_we_131" class="calcell disable cl_31"></span>

                                                                        <span id="calcell_th_132" class="calcell disable cl_32"></span>

                                                                        <span id="calcell_fr_133" class="disable calcell cl_33"></span>

                                                                        <span id="calcell_sa_134" class="disable calcell cl_34"></span>

                                                                        <span id="calcell_su_135" class="disable calcell cl_35"></span>

                                                                        <span id="calcell_mo_136" class="disable calcell cl_36"></span>

                                                                        <span id="calcell_tu_137" class="disable calcell cl_37"></span>

                                                                        <span id="calcell_we_138" class="disable calcell cl_38"></span>

                                                                        <span id="calcell_th_139" class="disable calcell cl_39"></span>

                                                                        <span id="calcell_fr_140" class="disable calcell cl_40"></span>

                                                                        <span id="calcell_sa_141" class="disable calcell cl_41"></span>

                                                                    </div>

                                                                </article>

                                                            </section>

                                                        </div>



                                                    </span>

                                                </div>

                                                <div class='repeatc-1'>

                                                    <div class='repeathead-1 inviteConnections' id="invitedConnections" onclick="toggleInviteConnections(this);" style="cursor: pointer;">Invite Connections</div>

                                                    

                                                    <div class='repeathead-1 right'>

                                                        <div class="lfloat-mods">

														<img class="reply_attach" src="img/comment_attach.png"></img>
<form enctype="multipart/form-data">
    <input class="upload_feed_hack" id="upload_feed_hack" type="file" name="file"></input>
</form>
<div class="feed_upload_textprompt" style="display: block;" title="">

</div>
                                                            <!--<div class="upload_textprompt"></div>

                                                            <div class="right">

                                                                <a class="attach-mod" href="#" title="Attach a file to your post">

                                                                    <span class="attach-icon"></span>

                                                                </a>

                                                            </div>

                                                            <form class="attach_form">

                                                                <input type="file" class="upload_hack">

                                                                <button class="upload_button">Upload</button>

                                                            </form>-->



                                                        </div>

                                                    </div>

                                                    

                                                </div>

                                                <div class='repeatc-1'>

                                                <button class="btn-addevent-1 btn-addevent btn-addevent-modal" id="btnAddThisEvent">Add Event</button>

                                            </div>



                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </section>

                        </div>

                    </div>

                </div>

                <div class = "cal-left-sec-container">
                    <div class="my-cals">

                        <div class="my-cals-wrap">

                            <div class="my-class-cals">

                                <div class="cals-header">

                                    Your Class Events

                                    <span class="cal-group-hider">Hide</span>

                                </div>

                                <div class="cal-groups">

                                    <div class = "cal-group">
                                        <div class = "cal-group-pic">
                                        </div>
                                        <div class = "cal-group-name">
                                            <span>Principles of Microeconomics</span>
                                        </div>
                                        <div class = "cal-group-toggle cal-group-toggle-checked">
                                            <span class = "cal-group-checkmark cal-group-checkmark-checked"></span>
                                        </div>
                                    </div>
                                    <div class = "cal-group">
                                        <div class = "cal-group-pic">
                                        </div>
                                        <div class = "cal-group-name">
                                            <span>Principles of Microeconomics</span>
                                        </div>
                                        <div class = "cal-group-toggle cal-group-toggle-checked">
                                            <span class = "cal-group-checkmark cal-group-checkmark-checked"></span>
                                        </div>
                                    </div>
                                    <div class = "cal-group">
                                        <div class = "cal-group-pic">
                                        </div>
                                        <div class = "cal-group-name">
                                            <span>Principles of Microeconomics</span>
                                        </div>
                                        <div class = "cal-group-toggle cal-group-toggle-checked">
                                            <span class = "cal-group-checkmark cal-group-checkmark-checked"></span>
                                        </div>
                                    </div>
                                    <div class = "cal-group">
                                        <div class = "cal-group-pic">
                                        </div>
                                        <div class = "cal-group-name">
                                            <span>Principles of Microeconomics</span>
                                        </div>
                                        <div class = "cal-group-toggle cal-group-toggle-checked">
                                            <span class = "cal-group-checkmark cal-group-checkmark-checked"></span>
                                        </div>
                                    </div>
                                    <div class = "cal-group">
                                        <div class = "cal-group-pic">
                                        </div>
                                        <div class = "cal-group-name">
                                            <span>Principles of Microeconomics</span>
                                        </div>
                                        <div class = "cal-group-toggle cal-group-toggle-checked">
                                            <span class = "cal-group-checkmark cal-group-checkmark-checked"></span>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="my-club-cals">

                                <div class="cals-header">

                                    Your Club Events

                                    <span class="cal-group-hider">Hide</span>

                                </div>

                                <div class="cal-groups">



                                </div>

                            </div>

                            <div class="my-club-cals">

                                <div class="cals-header">

                                    Your Personal Events

                                    <span class="cal-group-hider">Hide</span>

                                </div>

                                <div class="cal-groups">



                                </div>

                            </div>

                        </div>

                    </div>
                </div>

            </div>

            <div class="midsec">

                <div class="month-fbtns">


                    <div class="ui-icon-btn">

                        <img class="icon" src="img/import_cal_icon.png">

                        <div class="ui-icon-lab">

                            Import Cals

                        </div>

                    </div>

                </div>



                <div class="incomplete-wrap">

                    <div class="evnts-incomplete">

                        12

                    </div>

                    <span class = "incomplete-text-head">Incompleted</span>

                </div>

                <div class="explain-2">

                    <div class="explain-2-box">

                        <div class="explain-wedge">

                        </div>

                        <b>12 Incomplete To-Do's</b>

                        <p>Click on any incomplete event to see its page in the planner. Once there, you can mark the event as completed.</p>

                    </div>

                </div>

                <div class="fixed-cal-fbar">

                    <div class="cal-fbar-wrap">

                        <div class="month-events">

                            <span class = "events-this-month" style="font-weight: 700;">17</span> Events this month

                        </div>



                    </div>

                </div>

                <div class="fixed-events-tabs">

                    <div class="event-tabs-border">

                        <span id="currentEvent" class="cur_event">Sun, Jun 01</span>

                        <div class="event_view_cal">

                            <img src="img/cal_icon_major.png" class="event_cal_filter" id="img_cal_filter" title="Pick a Date." />

                            <input class="set_date" name="event_date_select" id="event_date_select" style="display: none;" />

                            <button class="btn_select_today" id="btn_select_event">Today</button>



                            <div class="calLayer cal_event_select">

                                <section id="Section1" class="mounth" style="margin-left: 43px; margin-top: 20px;">

                                    <header class="minical-header">

                                        <h1 class="minical-h1">JANUARY 2013</h1>



                                        <nav role="padigation">

                                            <span class="m-prev"></span>

                                            <span class="m-next"></span>

                                        </nav>

                                    </header>



                                    <article>

                                        <div class="days">

                                            <b>SU</b>

                                            <b>MO</b>

                                            <b>TU</b>

                                            <b>WE</b>

                                            <b>TH</b>

                                            <b>FR</b>

                                            <b>SA</b>

                                        </div>

                                        <div class="dates">

                                            <span onclick="FilterEvents(this);" id="calcell_su_43" class="calcell disable cl_0"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_mo_44" class="calcell disable cl_1"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_tu_45" class="calcell disable cl_2"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_we_46" class="calcell disable cl_3"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_th_47" class="calcell disable cl_4"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_fr_48" class="calcell disable cl_5"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_sa_49" class="calcell disable cl_6"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_su_50" class="calcell disable cl_7"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_mo_51" class="calcell disable cl_8"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_tu_52" class="calcell disable cl_9"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_we_53" class="calcell disable cl_10"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_th_54" class="calcell disable cl_11"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_fr_55" class="calcell disable cl_12"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_sa_56" class="calcell disable cl_13"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_su_57" class="calcell disable cl_14"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_mo_58" class="calcell disable cl_15"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_tu_59" class="calcell disable cl_16"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_we_60" class="calcell disable cl_17"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_th_61" class="calcell disable cl_18"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_fr_62" class="calcell disable cl_19"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_sa_63" class="calcell disable cl_20"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_su_64" class="calcell disable cl_21"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_mo_65" class="calcell disable cl_22"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_tu_66" class="calcell disable cl_23"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_we_67" class="calcell disable cl_24"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_th_68" class="calcell disable cl_25"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_fr_69" class="calcell disable cl_26"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_sa_70" class="calcell disable cl_27"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_su_71" class="calcell disable cl_28"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_mo_72" class="calcell disable cl_29"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_tu_73" class="calcell disable cl_30"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_we_74" class="calcell disable cl_31"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_th_75" class="calcell disable cl_32"></span>											
                                            <span onclick="FilterEvents(this);" id="calcell_fr_76" class="disable calcell cl_33"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_sa_77" class="disable calcell cl_34"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_su_78" class="disable calcell cl_35"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_mo_79" class="disable calcell cl_36"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_tu_80" class="disable calcell cl_37"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_we_81" class="disable calcell cl_38"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_th_82" class="disable calcell cl_39"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_fr_83" class="disable calcell cl_40"></span>
                                            <span onclick="FilterEvents(this);" id="calcell_sa_84" class="disable calcell cl_41"></span>
                                        </div>
                                    </article>

                                </section>

                            </div>

                        </div>



                    </div>

                </div>

                <div class="cal-top-border">

                    <div class="cal_border">

                        <div class="cal_wrapper">



                            <div id='calendar'></div>



                            <div class="event_view">

                                <div class="event_main">

                                    <ul class="timeline">
                                        <li>
                                            <div class="event_day_time">
                                                Mon, Jun 03
                                            </div>
                                            <div class="flag-wrapper direction-r">
                                                <span class="flag1"></span>
                                                <span class="arrow_box">
                                                    <div class="left_data1">
                                                        <img class="event_icons1" src="img/time_icon.png">
                                                        <div class="event-data1">
                                                            10:00am
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>
                                            <div class="direction-r">
                                                <div class="desc">
                                                    <div class="event_main_header">
                                                        <div class="event-content">
                                                            <div class="event_right">
                                                                <div class="header_wrapper">
                                                                    <div class="event-header-left">
                                                                        <div class="event_title">
                                                                            Microeconomics Homework! 
                                                                        </div>
                                                                        <div class="event_group">
                                                                            <div>Event in <a>Principles of Economics</a></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="attachment_img">&nbsp;</div>
                                                                    <div class="show_discussions">
                                                                        <a onclick="toggleDiscussion(this);">Show Discussions</a>
                                                                    </div>
                                                                </div>
                                                                <div class="info_wrapper">																
                                                                    <div class="right_data">
                                                                        <img class="event_icons" src="img/location_icon.png">                                                                        
																		<div class="event-data">
																			Lattimore Hall Room 223
                                                                        </div>
                                                                        <div class="event-data2">
                                                                            500 Joseph C Wilson Blvd
                                                                        </div>
                                                                    </div>
                                                                    <div class="event_join">
                                                                        <!--<button class="btn-addevent-1 btn-addevent" id="Button1" style="min-width: 0px; margin-right: 5px; font-size: 10px; height: 20px; line-height: 5px;">Accept</button>
                                                                        <button class="btn-addevent-1 btn-addevent" id="Button2" style="min-width: 0px; margin-right: 5px; font-size: 10px; height: 20px; line-height: 5px;">Maybe</button>
                                                                        <button class="btn-addevent-1 btn-addevent" id="Button3" style="min-width: 0px; margin-right: 5px; font-size: 10px; height: 20px; line-height: 5px;">Reject</button>-->
                                                                        <div class="left_btn event_status_btn">
                                                                            Accept
                                                                        </div>
                                                                        <div class="center_btn event_status_btn">
                                                                            Maybe
                                                                        </div>
                                                                        <div class="right_btn event_status_btn">
                                                                            Decline
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="event_left">
                                                            </div>
                                                        </div>
                                                        <div class="info_wrapper bottom_right_data">
                                                            <div class="event_info">
                                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore 
                                                            et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris 
                                                                <a href="#" id="description-show" class="showLink"
                                                                    onclick="showHide(this);return false;">See more.</a>
                                                                <div id="description" class="more">
                                                                    nisi ut aliquip 
                                                            ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu 
                                                            fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                                                            mollit anim id est laborum
                                                                     <a href="#" id="A7" class="hideLink"
                                                                         onclick="showHide(this);return false;">hide.</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="attendees_wrapper">
                                                            <div class="creator_wrapper">
                                                                <a class="event_creator">
                                                                    <div class="creator_Image">
                                                                    </div>
                                                                    <div class="creator_name">
                                                                        Professor Ashutosh
                                                                    </div>
                                                                    <div class="creator_info">
                                                                        Added this event 5 weeks ago
                                                                    </div>
                                                                </a>
                                                            </div>
                                                            <div class="attendee_list">
                                                                <div class="event_attendees">Attending: </div>
                                                                <a class="innerPic">
                                                                    <div class="smallPic">
                                                                        <img class="img" src="img/person1.jpg" width="29" height="29">
                                                                    </div>
                                                                </a>
                                                                <a class="innerPic">
                                                                    <div class="smallPic">
                                                                        <img class="img" src="img/person2.jpg" width="29" height="29">
                                                                    </div>
                                                                </a>
                                                                <a class="innerPic">
                                                                    <div class="smallPic">
                                                                        <img class="img" src="img/person3.jpg" width="29" height="29">
                                                                    </div>
                                                                </a>
                                                                <a class="innerPic">
                                                                    <div class="smallPic">
                                                                        <img class="img" src="img/person4.jpg" width="29" height="29">
                                                                    </div>
                                                                </a>
                                                                <a class="innerPic">
                                                                    <div class="smallPic">
                                                                        <img class="img" src="img/person5.jpg" width="29" height="29">
                                                                    </div>
                                                                </a>
                                                                <a class="innerPic">
                                                                    <div class="smallPic">
                                                                        <img class="img" src="img/person1.jpg" width="29" height="29">
                                                                    </div>
                                                                </a>
                                                                <a class="innerPic">
                                                                    <div class="smallPic">
                                                                        <img class="img" src="img/person2.jpg" width="29" height="29">
                                                                    </div>
                                                                </a>
                                                                <a class="innerPic">
                                                                    <div class="smallPic">
                                                                        <img class="img" src="img/person3.jpg" width="29" height="29">
                                                                    </div>
                                                                </a>
                                                                <a class="rosterLink">
                                                                    <div class="doubleBox">
                                                                        +67
                                                                    </div>
                                                                </a>
                                                            </div>															
                                                        </div>
                                                    </div>
                                                    <div class="event_qa" style="display: none;" id="divQA1">
                                                        <div class="qa_header">
                                                            <div class="icon_text">
                                                                <img src="img/qa_icon.png" width="22" height="22">
                                                                <div>
                                                                    Discussion and Questions
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="qa_scrollcontainer">
                                                            <div class="iComments">
                                                                <div class="imageBlock comment">
                                                                    <div class="Image iLoaded">
                                                                    </div>
                                                                    <div class="ibContent">
                                                                        <a href="#" class="ibNameLink">Phillip Drake
                                                                        </a>
                                                                        <span class="ibMessage">
                                                                            <span>I need help on problem set 12!</span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="imageBlock comment">
                                                                    <div class="Image iLoaded">
                                                                    </div>
                                                                    <div class="ibContent">
                                                                        <a href="#" class="ibNameLink">Phillip Drake
                                                                        </a>
                                                                        <span class="ibMessage">
                                                                            <span>It's been a great 22 years on the east coast, but it's time to head out west. Moving to LA!</span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="imageBlock comment">
                                                                    <div class="Image iLoaded">
                                                                    </div>
                                                                    <div class="ibContent">
                                                                        <a href="#" class="ibNameLink">Phillip Drake
                                                                        </a>
                                                                        <span class="ibMessage">
                                                                            <span>It's been a great 22 years on the east coast, but it's time to head out west. Moving to LA!</span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="imageBlock comment">
                                                                    <div class="Image iLoaded">
                                                                    </div>
                                                                    <div class="ibContent">
                                                                        <a href="#" class="ibNameLink">Phillip Drake
                                                                        </a>
                                                                        <span class="ibMessage">
                                                                            <span>I need help on problem set 12!</span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="imageBlock comment">
                                                                    <div class="Image iLoaded">
                                                                    </div>
                                                                    <div class="ibContent">
                                                                        <a href="#" class="ibNameLink">Phillip Drake
                                                                        </a>
                                                                        <span class="ibMessage">
                                                                            <span>It's been a great 22 years on the east coast, but it's time to head out west. Moving to LA!</span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="imageBlock comment">
                                                                    <div class="Image iLoaded">
                                                                    </div>
                                                                    <div class="ibContent">
                                                                        <a href="#" class="ibNameLink">Phillip Drake
                                                                        </a>
                                                                        <span class="ibMessage">
                                                                            <span>It's been a great 22 years on the east coast, but it's time to head out west. Moving to LA!</span>

                                                                        </span>

                                                                    </div>

                                                                </div>

                                                                <div class="imageBlock comment">

                                                                    <div class="Image iLoaded">

                                                                    </div>

                                                                    <div class="ibContent">

                                                                        <a href="#" class="ibNameLink">Phillip Drake

                                                                        </a>

                                                                        <span class="ibMessage">

                                                                            <span>I need help on problem set 12!</span>

                                                                        </span>

                                                                    </div>

                                                                </div>

                                                                <div class="imageBlock comment">

                                                                    <div class="Image iLoaded">

                                                                    </div>

                                                                    <div class="ibContent">

                                                                        <a href="#" class="ibNameLink">Phillip Drake

                                                                        </a>

                                                                        <span class="ibMessage">

                                                                            <span>I need help on problem set 12!</span>

                                                                        </span>

                                                                    </div>

                                                                </div>

                                                                <div class="imageBlock comment">

                                                                    <div class="Image iLoaded">

                                                                    </div>

                                                                    <div class="ibContent">

                                                                        <a href="#" class="ibNameLink">Phillip Drake

                                                                        </a>

                                                                        <span class="ibMessage">

                                                                            <span>I need help on problem set 12!</span>

                                                                        </span>

                                                                    </div>

                                                                </div>

                                                                <div class="imageBlock comment">

                                                                    <div class="Image iLoaded">

                                                                    </div>

                                                                    <div class="ibContent">

                                                                        <a href="#" class="ibNameLink">Phillip Drake

                                                                        </a>

                                                                        <span class="ibMessage">

                                                                            <span>I need help on problem set 12!</span>

                                                                        </span>

                                                                    </div>

                                                                </div>

                                                                <div class="imageBlock comment">

                                                                    <div class="Image iLoaded">

                                                                    </div>

                                                                    <div class="ibContent">

                                                                        <a href="#" class="ibNameLink">Phillip Drake

                                                                        </a>

                                                                        <span class="ibMessage">

                                                                            <span>I need help on problem set 12!</span>

                                                                        </span>

                                                                    </div>

                                                                </div>

                                                                <div class="imageBlock comment">

                                                                    <div class="Image iLoaded">

                                                                    </div>

                                                                    <div class="ibContent">

                                                                        <a href="#" class="ibNameLink">Phillip Drake

                                                                        </a>

                                                                        <span class="ibMessage">

                                                                            <span>I need help on problem set 12!</span>

                                                                        </span>

                                                                    </div>

                                                                </div>

                                                                <div class="imageBlock comment">

                                                                    <div class="Image iLoaded">

                                                                    </div>

                                                                    <div class="ibContent">

                                                                        <a href="#" class="ibNameLink">Phillip Drake

                                                                        </a>

                                                                        <span class="ibMessage">

                                                                            <span>I need help on problem set 12!</span>

                                                                        </span>

                                                                    </div>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="qa_postcontainer">

                                                            <div class="qa_inputcontainer">

                                                                <input onclick="test(this);" type="text" class="qa_input" placeholder="Ask a question..">

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </li>

                                    </ul>



                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="rightsec">

            </div>

        </div>

    </div>

</body>

</html>
