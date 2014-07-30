<!DOCTYPE html>

<html>

<head>

    <title>Calendar</title>
    <link href='css/cal_main.css' rel='stylesheet' />    
    <link href='css/myfullcalendar.css' rel='stylesheet' />
    <link href="http://select-box.googlecode.com/svn/tags/0.2/jquery.selectbox.css" type="text/css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/background_cal.css">
    <link rel="stylesheet" type="text/css" href="css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="css/eventbook.css" />
    <link rel="stylesheet" type="text/css" href="css/eventBookold.css" />
    <link rel="stylesheet" type="text/css" href="css/add_event.css" />    
    <link type="text/css" href="css/jquery.jscrollpane.css" rel="stylesheet" media="all" />


<!--    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>-->
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript" src="http://select-box.googlecode.com/svn/tags/0.2/jquery.selectbox-0.2.min.js"></script>    
    <script src='js/jquery.min.js'></script>
    <script src='js/jquery-ui.custom.min.js'></script>
    <script src='js/myfullcalendar.js'></script>
    <script type="text/javascript" src="js/bootstrap-timepicker.js"></script>
    <script type="text/javascript" src="js/jquery.plugin.js"></script>
    <script type="text/javascript" src="js/jquery.datepick.js"></script>
    <script src="js/jquery-ui-1.10.2.custom.min.js"></script>
    <script src="js/jquery.timeAutocomplete.min.js" type="text/javascript"></script>
    <script src="js/ampm.js" type="text/javascript"></script>
    <script src="js/calendar_selector.js" type="text/javascript"></script>
    <script src="js/mycalendar-event-book.js" type="text/javascript"></script>
    <script src = "js/add_event.js"></script>
    <script src = "js/timeago.js"></script>
    <script type="text/javascript" src="js/jquery.jscrollpane.min.js"></script>
    <script type="text/javascript" src="js/jquery.mousewheel.js"></script>

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



<body >
<section class='topbar_bag'>
        <?php include 'topbar1.php';?>
    </section>
    <div class="root">


        <div class="main">

            <div class="leftsec">

                <div class="sunken_toggle">

                    <span class="active_view"></span>

                    <div class="cal_view_monthly">

                        Monthly Planner

                    </div>

                    <div class="cal_view_events" >

                        Event Book

                    </div>

                </div>

                
                <div id="event-new">

                    <div id="button-border">

                        <div class="announcecolumn toolsforclass" style="position: relative">
                            <!--<div class="addevent adminc"style="">-->
                                <button type="button"  id="addEvent"  class="btn-addevent">Add Event</button>
                            <!--</div>-->
                            <br>
                            <br>
                            <div class="hide" id="event_id"></div><div class="hide" id="event_type"></div><div class="hide" id="theme_id"></div>
                            <section class="blackcanvas30">
                                <div id="bc3contentAddEvent" class="blackcanvas30">
                                   







<!--<div class = "add-event-wedge">
        <div class = "left-wedge-outer">
        </div>
        <div class = "left-wedge-solid">
        </div>
    </div>-->
    <div class = "add-event-box">
        <div class="add-event-box-edit-header">
            Edit Event                   
        </div>
        <div class = "add-event-header">
            <div class = "add-event-pic">
                <div class = "add-event-pic-actual">
                    <!--<div class = "add-event-pic-fx">
                        <div title = "Upload theme" class = "add-event-pic-upload">
                            Theme
                        </div>                
                    </div>-->    
                </div>                
            </div>
            <div class = "add-event-pic-toggler">
                            <div class = "add-event-left">
                                <div class = "toggle-icon">
                                </div>
                            </div>

                            <div class = "add-event-right">
                                <div class = "toggle-icon">
                                </div>
                            </div>
                        </div>
            <div class = "header-inp-wrap">
                <input id = "nevt-title-1" type = "text" class = "inp-foc inp-thr event-title" label = "Event title" placeholder = "Event title">
            </div>
            <div class = "header-inp-wrap">
                <input type="text" readonly name="event_date" id="event_date" class = "set_date inp-foc inp-twof event-date inp-icon-left" label = "Event date"> 
                <!--<span class = "event-date-icon"></span>-->                
                <div class="calLayer">
                                                            <section id="mounth" class="mounth" style="margin-left: 190px; margin-top: 35px;">
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
                <div class = "event-repeat add-event-box-dd">
                    <span class = "dd-title">Repeat</span>
                    <span class = "down-arrow"></span>
                    <span class = "event-date-icon" id="repeat_date_icon" style="display:none;"></span>
                    <input class="set_date" name="event_date" id="repeat_end_date" style="display:none;" />
                                                        <div class="calLayer">
                                                            <section id="Section2" class="mounth" style="margin-left: 1px;margin-top: 7px;">
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
               </div>
               <div class = "click-out dd-box">                                                        
                        <div class='repeatoptiont-1'>None</div>
                        <!--<hr class="post_options_hr-1" />-->
                        <div class='repeatoptiont-1'>Daily</div>
                        <!--<hr class="post_options_hr-1" />-->
                        <div class='repeatoptiont-1'>Weekly</div>
                        <!--<hr class="post_options_hr-1" />-->
                        <div class='repeatoptiont-1'>Monthly</div>                    
               </div>
            </div>
            <div class = "header-inp-wrap">
                <span class = "">
                    <input type = "text" id="set_from_time_24hr" style="float:left; margin-left:1px;"
                     class = "set_time inp-foc inp-half event-start-time" label = "Event time">
                    <!--<span class = "down-arrow down-arrow-down"></span>
                    <div class = "st-time-dd">
                    </div>-->
                </span>
                <span class="">
                    <a class = "add-endtime">
                    Add an end time
                    </a>
                    <input id="set_to_time_24hr" type = "text" class = "set_time inp-foc inp-half event-end-time" label = "Event end time" >
                    <!--<span class = "down-arrow down-arrow-2 down-arrow-down"></span>
                    <span class = "revert-end-time">
                    </span>
                     <div class = "end-time-dd">
                    </div>-->
                </span>                        
            </div>
        </div>
        <div class = "add-event-box-main">
            <div class = "add-event-box-main-row">
                <span class = "event-loc-icon"></span>
                <input id="nevt-location-1" type = "text" class = "inp-foc inp-one event-loc inp-icon-left" label = "Event location" placeholder = "Location (optional)">                
            </div>
            <div class = "add-event-box-main-row">
                <textarea id="nevt-desc-1" type = "text" class = "inp-foc inp-one event-details" rows="4" 
                    label = "Event details" placeholder = "Details (optional)" style="resize:none;height:23px;padding-top:6px;"></textarea>
            </div>
            <div class = "add-event-box-main-row">
                <input type = "text" id="invitedConnections" onclick="toggleInviteConnections(this);" 
                    class = "inp-foc inp-one event-invites" label = "Event details" placeholder = "Invite people">
                <span class = "down-arrow down-arrow-3 down-arrow-down"></span>                    
                    <div class="tag-option" 
                        style="background: none repeat scroll 0% 0% #FFF;display: none; width: 498px; position: absolute; z-index: 50; border:1px solid #C0C0C0;margin-top:-11px;">
                        <div class="tag-section tagsec-r">                                            
                        </div>
                    </div>
                <div class = "add-event-dd-box-invite" id="divInviteConnections">
                    <div class = "clearfix-invite-ddbox">
                        <span class = "invite-dd-box-header">
                            Who would you like to invite?
                        </span>
                        <span class = "close-invite-ddbox">
                        </span>
                    </div>
                    <div class = "dd-box-invite-scrollwrap">
                        <ul class = "hor-scroll-invites" id="inviteConnections">                            
                        </ul>

                    </div>
                    <a class = "ddbox-hor-scroller hor-scroller-left">
                        <div class = "ddbox-hor-scroller-cont">
                        </div>
                        <i class = "ddbox-hor-scroll-icon">
                        </i>
                    </a>
                    <a class = "ddbox-hor-scroller hor-scroller-right">
                        <div class = "ddbox-hor-scroller-cont">
                        </div>
                        <i class = "ddbox-hor-scroll-icon">
                        </i>
                    </a>

                </div>
            </div>
            <div style="display:none;" id="fileAttach" class = "add-event-box-main-row">
                <img class="reply_attach" src="img/comment_attach.png"></img>
                <form enctype="multipart/form-data">
                    <input class="upload_feed_hack" id="upload_feed_hack" type="file" name="file"></input>
                </form>
                <div class="feed_upload_textprompt" style="display: block;" title=""></div>
            </div>
            <div class = "add-event-box-main-row">
                <div class = "add-event-box-btns-wrap">
                    <button class = "add-event-box-btns add-event-box-cancel" id="divCancel">
                        Cancel
                    </button>
                     <button class = "add-event-box-btns add-event-box-create"  id="btnAddThisEvent">
                        Add Event 
                    </button>
                    <button id="btnDeleteEvent" class = "add-event-box-btns add-event-box-delete"  id="btnAddThisEvent">
                        Delete 
                    </button>
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
                                <div class="cal-groups" id="class_groups">
                                    
                                </div>
                            </div>
                            <div class="my-club-cals">
                                <div class="cals-header">
                                    Your Club Events
                                    <span class="cal-group-hider">Hide</span>
                                </div>
                                <div class="cal-groups" id="club_groups">

                                </div>
                            </div>
                            <div class="my-club-cals">
                                <div class="cals-header cals-personal-hider" >
                                    Hide Personal Events                                    
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
                        
                        <div class = "eventbook-header">
                                    <div class = "header-left-title">
                                        <span id="currentEvent" style="display:none;" >Sun, Jun 01</span>
                                        <div class = "eventbook-date-cont eb-day-cont">
                                            <span class = "eb-current-day">
                                                Monday
                                            </span>
                                            <span class = "eb-next-day">
                                                Tuesday
                                            </span>
                                        </div>
                                        <div class = "eventbook-date-cont eb-month-cont">
                                            <span class = "eb-month">
                                                June
                                            </span>
                                            <span class = "eb-date">
                                                31
                                            </span>
                                        </div>
                                        <div class = "eventbook-date-cont eb-year-cont">
                                            <span class = "eb-year">
                                                2014
                                            </span>
                                        </div>
                                    </div>
                                    <div class = "header-center-fx">
                                        <div class = "fx-cont-left eb-fx-cont">
                                            <span></span>
                                        </div>
                                        <div class = "fx-cont-right eb-fx-cont">
                                            <span></span>
                                        </div>
                                    </div>
                                    <div class = "header-right-fx">
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
                    </div>

                </div>

                <div class="cal-top-border">

                    <div class="cal_border">

                        <div class="cal_wrapper">



                            <div id='calendar'></div>



                            <div class="event_view">

                                <div class="event_main">

                                    <div class="eventbook-content">
                                        <!--<li>
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

                                        </li>-->

                                    </div>



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