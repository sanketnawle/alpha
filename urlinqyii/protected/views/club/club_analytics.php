<!DOCTYPE html> 
<html>
<head>

    <script>
        base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';

        group_id = '<?php echo $club->group_id ?>';
    </script>

<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/club/analytics.css">

<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->

<script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/Chart.js-master/Chart.js"></script>

<script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/club/analytics.js"></script>
</head>
<body>


<div class='anl-frame' style="margin-left:350px;">
<div class='anl-header'>
    <span>Swimming Club ANALYTICS</span>
    <div class='anl_btn_left'>
        <div class='ga_btn ga_btn_0 anl_btn_active'>General Analytics</div>
    </div>
    <div class='anl_btn_left'>
        <div class='ga_btn ga_btn_1'>Event Analytics</div>
    </div>
</div>

<div class='anl-subframe anl-subframe_0'>

<div class='anl-content-box-ga'>
    <div class='box-ga-header'>
        <div class='cur_wrapper'><span class='ga_option_cur'><div class='anal_right_wedge'></div>This Week</span></div>
        <span class='hidden_ga_option'>
        
        <span class='ga_option ga_option_1'>This Month<span class='anal_right_wedge_hidden'></span></span>
        <span class='ga_option ga_option_2'>This Semester</span>
        </span>
    </div>
    <div class='anl-graph-part'>

    <div class='dn_wrap'>
    <span class='dn_g_left'>
    <span class='dn_0_txt graph_increase_txt dn_txt' id="page_views_percent_increase_text"></span>
    <canvas class="doughnut_0 doughnut_small" width="120" height="120"></canvas>
    </span>

    <div class='dn_g_right'>
        <span class='dn_right_t_top_n' id="total_page_views_text">0</span>
        <span class='dn_right_t_top'>Total Page Views</span>
        <div class='dn_separator'></div>
        <span class='dn_right_t_bottom_n graph_increase_txt' id="new_page_views_text">0</span>
        <span class='dn_right_t_bottom'>New</span>
    </div>
    </div>

    <div class='dn_wrap'>
    <span class='dn_g_left'>
    <span class='dn_1_txt graph_increase_txt dn_txt' id="members_percent_increase_text"></span>
    <canvas class="doughnut_1 doughnut_small" width="120" height="120"></canvas>
    </span>

    <div class='dn_g_right'>
        <span class='dn_right_t_top_n' id="total_members_count_text"></span>
        <span class='dn_right_t_top'>Total Members</span>
        <div class='dn_separator'></div>
        <span class='dn_right_t_bottom_n graph_increase_txt' ">0</span>
        <span class='dn_right_t_bottom'>New</span>
    </div>
    </div>


    <div class='dn_wrap'>
    <span class='dn_g_left'>
<!--    <span class='dn_2_txt graph_decrease_txt dn_txt' id='invite_percent_increase'></span>-->
    <span class='dn_2_txt graph_increase_txt dn_txt' id='invite_percent_increase'></span>
    <canvas class="doughnut_2 doughnut_small" width="120" height="120"></canvas>
    </span>


    <div class='dn_g_right'>
<!--        <span class='dn_right_t_top_n graph_decrease_txt' id="invite_count"></span>-->
        <span class='dn_right_t_top_n' id="invite_count"></span>
        <span class='dn_right_t_top'>Total Invites</span>
        <div class='dn_separator'></div>
        <span class='dn_right_t_bottom_n graph_increase_txt' id="accepted_invite_count"></span>
        <span class='dn_right_t_bottom'>Attendances</span>
    </div>
    </div>

    </div>
</div>

<div class='anl-header'>
    <span>Member Breakdown</span>

    <div class = 'anl_header_dropdown'>
    <div class = 'anl_header_dropdown_showr'>
       <div class='anl_header_dropdown_showr_wedgedown'></div> All Schools
    </div>
    <div class = 'anl_header_dropdown_box'>
        <div class = 'anl_header_dropdown_option anl_option_edit'>School 1</div>
        <hr class = 'anl_option_hr'>
        <div class = 'anl_header_dropdown_option anl_option_edit'>School 2</div>
        <hr class = 'anl_option_hr'>
        <div class = 'anl_header_dropdown_option anl_option_edit'>School 3</div>
        <hr class = 'anl_option_hr'>
        <div class = 'anl_header_dropdown_option anl_option_edit'>All Schools</div>
    </div>
    </div>
</div>

<div class='anl-content-box-mb'>
    <div class='anl-content-box-mb-left'>

        <div class='anl-content-box-mb-left-cell'>
            <div class='anl-content-box-mb-left-cell-left'><span>Freshman</span></div>
            <div class='anl-content-box-mb-left-cell-mid'>
                <div class='mb-left-cell-mid-grey'>
                    <div class='mb-left-cell-mid-color bar_color_blue' id="freshman_percent_bar" style='width:12%'></div>
                </div>
                <div class='mb-left-cell-mid-percent' id="freshman_percent_text">12%</div>
            </div>
            <div class='anl-content-box-mb-left-cell-right' id="freshman_count">
                24
            </div>
        </div>

        <div class='anl-content-box-mb-left-cell'>
            <div class='anl-content-box-mb-left-cell-left'><span>Sophomore</span></div>
            <div class='anl-content-box-mb-left-cell-mid'>
                <div class='mb-left-cell-mid-grey'>
                    <div class='mb-left-cell-mid-color bar_color_blue' id="sophomore_percent_bar" style='width:20%'></div>
                </div>
                <div class='mb-left-cell-mid-percent' id="sophomore_percent_text">20%</div>
            </div>
            <div class='anl-content-box-mb-left-cell-right' id="sophomore_count">
                40
            </div>
        </div>

        <div class='anl-content-box-mb-left-cell'>
            <div class='anl-content-box-mb-left-cell-left'><span>Junior</span></div>
            <div class='anl-content-box-mb-left-cell-mid'>
                <div class='mb-left-cell-mid-grey'>
                    <div class='mb-left-cell-mid-color bar_color_blue' id="junior_percent_bar" style='width:15%'></div>
                </div>
                <div class='mb-left-cell-mid-percent' id="junior_percent_text">15%</div>
            </div>
            <div class='anl-content-box-mb-left-cell-right' id="junior_count">
                30
            </div>
        </div>

        <div class='anl-content-box-mb-left-cell'>
            <div class='anl-content-box-mb-left-cell-left'><span>Senior</span></div>
            <div class='anl-content-box-mb-left-cell-mid'>
                <div class='mb-left-cell-mid-grey'>
                    <div class='mb-left-cell-mid-color bar_color_blue' id="senior_percent_bar" style='width:23%'></div>
                </div>
                <div class='mb-left-cell-mid-percent' id="senior_percent_text">23%</div>
            </div>
            <div class='anl-content-box-mb-left-cell-right' id="senior_count">
                46
            </div>
        </div>

        <div class='anl-content-box-mb-left-cell'>
            <div class='anl-content-box-mb-left-cell-left'><span>Graduate</span></div>
            <div class='anl-content-box-mb-left-cell-mid'>
                <div class='mb-left-cell-mid-grey'>
                    <div class='mb-left-cell-mid-color bar_color_blue' id="graduate_percent_bar" style='width:30%'></div>
                </div>
                <div class='mb-left-cell-mid-percent' id="graduate_percent_text">30%</div>
            </div>
            <div class='anl-content-box-mb-left-cell-right' id="graduate_count">
                60
            </div>
        </div>
    </div>


    <div class='anl-content-box-mb-right'>
        <canvas class="pie_0" width="180" height="180"></canvas>
        <div class='anl-content-box-mb-right-right'>
            <div class='anl-content-box-mb-right-right-cell'>
            <div class='pattern_0 anl_pi_pattern'>
                <div class = 'card-tag-pattern'>
                    <div class = 'tag-wedge-pattern'></div>
                    <div class = 'tag-box-pattern'>
                        <span id="female_count_span">Female: <span>35%</span></span>
                    </div>                                  
                </div>
            </div>

            <div class='mb-right-cell-tag'>Female</div>
            </div>

            <div class='anl-content-box-mb-right-right-cell'>
            <div class='pattern_1 anl_pi_pattern'>
                <div class = 'card-tag-pattern'>
                    <div class = 'tag-wedge-pattern'></div>
                    <div class = 'tag-box-pattern'>
                        <span id="male_count_span">Male: <span>65%</span></span>
                    </div>                                  
                </div>
            </div>

            <div class='mb-right-cell-tag'>Male</div>
            </div>

        </div>
    </div>
</div>


<div class='anl-header'>

    <div class='anl_dd_leftwrapper'>
    <div class = 'anl_header_dropdown anl_header_dropdown_leftfloat'>
    <div class = 'anl_header_dropdown_showr showr_left' id="current_members_filter">
       <div class='anl_header_dropdown_showr_wedgedown' ></div>Most Active Members</div>
    <div class = 'anl_header_dropdown_box'>
        <div class = 'anl_header_dropdown_option anl_option_edit'>Newest Members</div>
        <hr class = 'anl_option_hr'>
        <div class = 'anl_header_dropdown_option anl_option_edit'>Most Active Members</div>
        <hr class = 'anl_option_hr'>
        <div class = 'anl_header_dropdown_option anl_option_edit'>Oldest Members</div>
        <hr class = 'anl_option_hr'>
        <div class = 'anl_header_dropdown_option anl_option_edit'>Least Active Members</div>
    </div>
    </div>
    </div>

    <div class='anl_tea'>Total Events Attendence</div>

    <div class='anl_pea'>% Total Events Attendence</div>
</div>

<div class='anl-content-box-am' id="members">

</div>

</div>


<div class='anl-subframe anl-subframe_1'>
    
    <div class='anl-content-box-ev'>
        <div class='anl-content-box-ev-head'><span>Weekly Events Attendance Summary</span></div>

        <div class='linegraph_wrapper'>
        <canvas class="linegraph_0" width="900" height="200"></canvas>
        </div>

        <div class='anl-content-box-ev-bottom'>
            <div class='anl-content-box-ev-bottom-l'>
                <div class='ev-bottom-l-t' id="total_attendance_text"></div>
                <div class='ev-bottom-l-b'>Total Attendance</div>
            </div>
            <div class='anl-content-box-ev-bottom-l anl-content-box-ev-bottom-r'>
            <div class='ev-bottom-l-t' id="average_attendance_text"></div>
            <div class='ev-bottom-l-b'>Average Attendance</div>
            </div>
        </div>
    </div>


    <div class='anl-header'>

        <div class='anl_dd_leftwrapper'>
        <div class = 'anl_header_dropdown anl_header_dropdown_leftfloat'>
        <div class = 'anl_header_dropdown_showr showr_left'>
            <div class='anl_header_dropdown_showr_wedgedown'></div> This Week Events
        </div>  
        <div class = 'anl_header_dropdown_box'>
            <div class = 'anl_header_dropdown_option anl_option_edit'>7/08 Events</div>
            <hr class = 'anl_option_hr'>
            <div class = 'anl_header_dropdown_option anl_option_edit'>7/15 Events</div>
            <hr class = 'anl_option_hr'>
            <div class = 'anl_header_dropdown_option anl_option_edit'>7/21 Events</div>
            <hr class = 'anl_option_hr'>
            <div class = 'anl_header_dropdown_option anl_option_edit'>8/05 Events</div>
            <hr class = 'anl_option_hr'>
            <div class = 'anl_header_dropdown_option anl_option_edit'>This Week Events</div>
        </div>
        </div>
        </div>

        <div class='anl_ev_even anl_ev_date'>Date</div>
        <div class='anl_ev_even'>Total Attendence</div>
        <div class='anl_ev_even'>% Attendence</div>
    </div>

    <div class='anl-content-box-ev' id="events">

    </div>

</div>


</div>


<script type="application/javascript">

    $( document ).ready(function () {
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');


        ga('create', 'UA-45298907-1', {
            // 'userId': <?php echo $user->user_id ?>,
            'cookieDomain': 'none'
        });

        $.getScript('js/getURLPara.js', function(){
            var group_id = '';
            if ($.getUrlVar("group_id") != null) {
                group_id = $.getUrlVar("group_id").toString();
            }

            ga('send', 'pageview',{
                'dimension1': '<?php echo strval($user->user_id); ?>',
                'dimension2': group_id
            });
        });

    });

</script>


</body>


</html>

