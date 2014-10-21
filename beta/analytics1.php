<!DOCTYPE html> 
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="css/analytics.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
</script>
<script src="includes/Chart.js-master/Chart.js">
</script>

<script>
$(document).ready(function() {
	var dn_0 = $(".doughnut_0").get(0).getContext("2d");
    var dn_1 = $(".doughnut_1").get(0).getContext("2d");
    var dn_2 = $(".doughnut_2").get(0).getContext("2d");
    var pi_0 = $(".pie_0").get(0).getContext("2d");
    var pi_i = $(".pie_i").get(0).getContext("2d");
    var ln_0 = $(".linegraph_0").get(0).getContext("2d");


	var data_dn_0 = [
    {
        value: 300,
        color:"#e5e5e5",
        highlight: "#fff",
        label: "Old dogs"
    },
    {
        value: 50,
        color: "#4BAEF0",
        highlight: "#63b9f2",
        label: "Newbie"
    }
]

    var data_dn_1 = [
    {
        value: 100,
        color:"#e5e5e5",
        highlight: "#fff",
        label: "Old dogs"
    },
    {
        value: 50,
        color: "#4BAEF0",
        highlight: "#63b9f2",
        label: "Newbie"
    }
]


    var data_dn_2 = [
    {
        value: 2,
        color: "#f04b5b",
        highlight: "#f26370",
        label: "Newbie"
    },
    {
        value: 23,
        color:"#e5e5e5",
        highlight: "#fff",
        label: "Old dogs"
    }
]

        var data_pi_0 = [
    {
        value: 15,
        color: "#f04b5b",
        highlight: "#f26370",
        label: "Female"
    },
    {
        value: 30,
        color:"#4BAEF0",
        highlight: "#63b9f2",
        label: "Male"
    }
]

        var data_pi_i = [
    {
        value: 15,
        color: "#f04b5b",
        highlight: "#f26370",
        label: "Female"
    },
    {
        value: 30,
        color:"#4BAEF0",
        highlight: "#63b9f2",
        label: "Male"
    }
]

var data_ln_0 = {
    labels: ["7/08", "7/15", "7/21", "8/05", "8/12", "8/19", "8/27","9/05","9/12"],
    datasets: [
        {
            label: "Attendence Trends",
            fillColor: "rgba(151,187,205,0.2)",
            strokeColor: "rgba(151,187,205,1)",
            pointColor: "rgba(151,187,205,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(151,187,205,1)",
            data: [25, 30, 20, 20, 22, 55, 40]
        }
    ]
};


var chart_dn0= new Chart(dn_0).Doughnut(data_dn_0, {
    percentageInnerCutout : 87,
    segmentShowStroke : false,
    showTooltips: false,
    animationSteps : 75,
    animationEasing: "easeOutCubic"
});

var chart_dn1= new Chart(dn_1).Doughnut(data_dn_1, {
    percentageInnerCutout : 87,
    segmentShowStroke : false,
    showTooltips: false,
    animationSteps : 75,
    animationEasing: "easeOutCubic"
});

var chart_dn2= new Chart(dn_2).Doughnut(data_dn_2, {
    percentageInnerCutout : 87,
    segmentShowStroke : false,
    showTooltips: false,
    animationSteps : 75,
    animationEasing: "easeOutCubic"
});

var chart_pi0= new Chart(pi_0).Doughnut(data_pi_0, {
    percentageInnerCutout : 0,
    segmentShowStroke : false,
    showTooltips: true,
    animationSteps : 75,
    animationEasing: "easeOutCubic"
});

var chart_pii= new Chart(pi_i).Doughnut(data_pi_i, {
    percentageInnerCutout : 0,
    segmentShowStroke : false,
    showTooltips: true,
    animationSteps : 75,
    animationEasing: "easeOutCubic"
});

var chart_ln0 = new Chart(ln_0).Line(data_ln_0, {
    bezierCurve : false,
    scaleBeginAtZero: true
});


/*non graph part*/

$(document).delegate(".ga_btn","mouseenter",function(){
    if(!$(this).hasClass("anl_btn_active")){
    $(this).addClass("ga_btn_hover");
    }
});
$(document).delegate(".ga_btn","mouseleave",function(){
    if(!$(this).hasClass("anl_btn_active")){
    $(this).removeClass("ga_btn_hover");
    }
});

$(document).delegate(".ga_btn_hover","click",function(){
    $(".ga_btn").removeClass("anl_btn_active");
    $(this).removeClass("ga_btn_hover");
    $(this).addClass("anl_btn_active");
});


$(document).delegate(".ga_btn","click",function(){
    if($(this).hasClass("ga_btn_1")){
        $(".anl-subframe_0").hide();
        $(".anl-subframe_1").show();
    }

    if($(this).hasClass("ga_btn_0")){
        $(".anl-subframe_1").hide();
        $(".anl-subframe_0").show();
    }
});

$(document).delegate(".box-ga-header","mouseenter",function(){
    $(this).find(".hidden_ga_option").show();
    $(this).find(".hidden_ga_option").stop().animate({opacity:1,marginLeft:8},200);
});

$(document).delegate(".box-ga-header","mouseleave",function(){
    var $rt=$(this);
    $(this).find(".hidden_ga_option").stop().animate({opacity:0,marginLeft:-1},200,function(){
         $rt.find(".hidden_ga_option").hide();
    });
   
});

$(document).delegate(".ga_option","click",function(){

var txt_this= $(this).text();
var txt_cur= $(this).closest(".box-ga-header").find(".ga_option_cur").text();

if($(this).hasClass("ga_option_1")){
    $(this).html(txt_cur+"<span class='anal_right_wedge_hidden'></span>");
}else{
$(this).text(txt_cur);
}

$(this).closest(".box-ga-header").find(".ga_option_cur").html("<div class='anal_right_wedge'></div>"+txt_this);

    $(this).closest(".box-ga-header").find(".hidden_ga_option").stop().animate({opacity:0,marginLeft:-1},200,function(){
         $(this).find(".hidden_ga_option").hide();
    });
/* mutate chart value accordingly and update chart*/
chart_dn0.update();
chart_dn1.update();
chart_dn2.update();
});


$(document).delegate(".anl_header_dropdown_showr","click",function(){
    $(this).closest(".anl_header_dropdown").find(".anl_header_dropdown_box").show();
});

$(document).delegate(".anl_header_dropdown_option","click",function(){
    var txt= $(this).text();
    $(this).closest(".anl_header_dropdown").find(".anl_header_dropdown_showr").html("<div class='anl_header_dropdown_showr_wedgedown'></div>"+txt);
    $(this).closest(".anl_header_dropdown").find(".anl_header_dropdown_box").hide();
});

$(document).delegate(".anl_pi_pattern","mouseenter",function(){
    $(this).find(".card-tag-pattern").show();
});
$(document).delegate(".anl_pi_pattern","mouseleave",function(){
    $(this).find(".card-tag-pattern").hide();
});

$(document).click(function(event){
                    var $target= $(event.target);

                    //click outside hide event
                    var $container= $(".anl_header_dropdown");
                    if(!$container.is($target)&&($container.has($target).length===0)){
                        $(".anl_header_dropdown_box").stop().hide();
                    }

                });


$(document).delegate(".plus_button","click",function(){
    if(!$(this).hasClass("wait_to_tag")){
        $(this).addClass("wait_to_tag");
        $(this).closest(".am_cell").find(".cell_right_tags_wrap").hide();
        $(this).closest(".am_cell").find(".cell_right_input").show();
    }else{
        var x= $(this).closest(".am_cell").find(".cell_right_input").val().trim();
        if(x!=""){
        $(this).removeClass("wait_to_tag");
        $(this).closest(".am_cell").find(".cell_right_input").val("");
        $(this).closest(".am_cell").find(".cell_right_input").hide();
        $(this).closest(".am_cell").find(".cell_right_tags_wrap").show();
        if($(this).closest(".am_cell").find(".cell_right_tags_wrap").children().length>=2){

        }else{
        $(this).closest(".am_cell").find(".cell_right_tags_wrap").append("<div class='cell_right_a_tag'>"+x+"</div>");
        }
        }
    }

});

$(document).delegate(".cell_right_a_tag","mouseenter",function(){

    var x=$(this).text();
    $(this).html("<span class='rm_symbol'>- </span>"+x);
});


$(document).delegate(".cell_right_a_tag","mouseleave",function(){
    $(this).find(".rm_symbol").remove();
});

$(document).delegate(".cell_right_a_tag","click",function(){
    $rt=$(this);
    $(this).animate({width:0,opacity:0},function(){
        $rt.remove();
    });
});

$( ".am_cell" ).each(function( index ) {
    if($(this).closest(".am_cell").find(".cell_right_tags_wrap").children().length==0){
        $(this).find(".plus_button").addClass("wait_to_tag");
        $(this).find(".cell_right_tags_wrap").hide();
        $(this).find(".cell_right_input").show();
    }
});

$(document).delegate(".show_detail_of_event","mouseenter",function(){
    $(this).closest(".ev_cell_right").css({"opacity":"1"});
});
$(document).delegate(".show_detail_of_event","mouseleave",function(){
    $(this).closest(".ev_cell_right").css({"opacity":"0.7"});
});


$(document).delegate(".show_detail_of_event","click",function(){
    var $detail=$(this).closest(".ev_cell").find(".ev_detail");
    if($(this).hasClass("unfolded_detail")){
        $detail.hide();
        $(this).removeClass("unfolded_detail");
        $(this).find(".anl_header_dropdown_showr_wedgeup").remove();
        $(this).prepend("<div class='anl_header_dropdown_showr_wedgedown'></div>");
    }else{
        $(".ev_detail").hide();

        $detail.show();
        $(this).addClass("unfolded_detail");
        $(this).find(".anl_header_dropdown_showr_wedgedown").remove();
        $(this).prepend("<div class='anl_header_dropdown_showr_wedgeup'></div>");
    }

});

});


</script>
</head>
<body>


<div class='anl-frame'>
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
        
        <span class='ga_option ga_option_1'>This Month <span class='anal_right_wedge_hidden'></span></span> 
        <span class='ga_option ga_option_2'>This Semester</span>
        </span>
    </div>
    <div class='anl-graph-part'>

    <div class='dn_wrap'>
    <span class='dn_g_left'>
    <span class='dn_0_txt graph_increase_txt dn_txt'>+13%</span>
    <canvas class="doughnut_0 doughnut_small" width="120" height="120"></canvas>
    </span>

    <div class='dn_g_right'>
        <span class='dn_right_t_top_n graph_increase_txt'>350</span>
        <span class='dn_right_t_top'>Total Page Views</span>
        <div class='dn_separator'></div>
        <span class='dn_right_t_bottom_n'>70</span>
        <span class='dn_right_t_bottom'>New</span>
    </div>
    </div>

    <div class='dn_wrap'>
    <span class='dn_g_left'>
    <span class='dn_1_txt graph_increase_txt dn_txt'>+33%</span>
    <canvas class="doughnut_1 doughnut_small" width="120" height="120"></canvas>
    </span>

    <div class='dn_g_right'>
        <span class='dn_right_t_top_n graph_increase_txt'>150</span>
        <span class='dn_right_t_top'>Total Members</span>
        <div class='dn_separator'></div>
        <span class='dn_right_t_bottom_n'>30</span>
        <span class='dn_right_t_bottom'>New</span>
    </div>
    </div>


    <div class='dn_wrap'>
    <span class='dn_g_left'>
    <span class='dn_2_txt graph_decrease_txt dn_txt'>- 20%</span>
    <canvas class="doughnut_2 doughnut_small" width="120" height="120"></canvas>
    </span>

    <div class='dn_g_right'>
        <span class='dn_right_t_top_n graph_decrease_txt'>23</span>
        <span class='dn_right_t_top'>Total Events</span>
        <div class='dn_separator'></div>
        <span class='dn_right_t_bottom_n'>2</span>
        <span class='dn_right_t_bottom'>New</span>
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
                    <div class='mb-left-cell-mid-color bar_color_blue' style='width:12%'></div>
                </div>
                <div class='mb-left-cell-mid-percent'>12%</div>
            </div>
            <div class='anl-content-box-mb-left-cell-right'>
                24
            </div>
        </div>

        <div class='anl-content-box-mb-left-cell'>
            <div class='anl-content-box-mb-left-cell-left'><span>Sophomore</span></div>
            <div class='anl-content-box-mb-left-cell-mid'>
                <div class='mb-left-cell-mid-grey'>
                    <div class='mb-left-cell-mid-color bar_color_blue' style='width:20%'></div>
                </div>
                <div class='mb-left-cell-mid-percent'>20%</div>
            </div>
            <div class='anl-content-box-mb-left-cell-right'>
                40
            </div>
        </div>

        <div class='anl-content-box-mb-left-cell'>
            <div class='anl-content-box-mb-left-cell-left'><span>Junior</span></div>
            <div class='anl-content-box-mb-left-cell-mid'>
                <div class='mb-left-cell-mid-grey'>
                    <div class='mb-left-cell-mid-color bar_color_blue' style='width:15%'></div>
                </div>
                <div class='mb-left-cell-mid-percent'>15%</div>
            </div>
            <div class='anl-content-box-mb-left-cell-right'>
                30
            </div>
        </div>

        <div class='anl-content-box-mb-left-cell'>
            <div class='anl-content-box-mb-left-cell-left'><span>Senior</span></div>
            <div class='anl-content-box-mb-left-cell-mid'>
                <div class='mb-left-cell-mid-grey'>
                    <div class='mb-left-cell-mid-color bar_color_blue' style='width:23%'></div>
                </div>
                <div class='mb-left-cell-mid-percent'>23%</div>
            </div>
            <div class='anl-content-box-mb-left-cell-right'>
                46
            </div>
        </div>

        <div class='anl-content-box-mb-left-cell'>
            <div class='anl-content-box-mb-left-cell-left'><span>Graduate</span></div>
            <div class='anl-content-box-mb-left-cell-mid'>
                <div class='mb-left-cell-mid-grey'>
                    <div class='mb-left-cell-mid-color bar_color_blue' style='width:30%'></div>
                </div>
                <div class='mb-left-cell-mid-percent'>30%</div>
            </div>
            <div class='anl-content-box-mb-left-cell-right'>
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
                        <span>Female: <span>35%</span></span>
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
                        <span>Male: <span>65%</span></span>
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
    <div class = 'anl_header_dropdown_showr showr_left'>
       <div class='anl_header_dropdown_showr_wedgedown'></div> Most Active Members
    </div>  
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

<div class='anl-content-box-am'>
    <div class='am_cell'>
        <div class='am_cell_left'>
            <div class='am_cell_left_photo' style='background-image: url(img/dummy_1.jpg)'></div>
            <div class='am_cell_left_name'>Kushal Kadaba</div>
        </div>

        <div class='am_cell_mid_0'>
            16
        </div>

        <div class='am_cell_mid_1'>
            32%
        </div>

        <div class='am_cell_right'>
            <div class='cell_right_tags_wrap'>
                <div class='cell_right_a_tag'>Good Person</div>
                <div class='cell_right_a_tag'>Party Dog</div>
            </div>

            <input class='cell_right_input' type='text' placeholder='add a tag' maxlength="11">
        </div>
        <button class='plus_button'>
        </button>
    </div>



    <div class='am_cell'>
        <div class='am_cell_left'>
            <div class='am_cell_left_photo' style='background-image: url(img/dummy_1.jpg)'></div>
            <div class='am_cell_left_name'>Kushal Kadaba</div>
        </div>

        <div class='am_cell_mid_0'>
            16
        </div>

        <div class='am_cell_mid_1'>
            32%
        </div>

        <div class='am_cell_right'>
            <div class='cell_right_tags_wrap'>

            </div>

            <input class='cell_right_input' type='text' placeholder='add a tag' maxlength="11">
        </div>
        <button class='plus_button'>
        </button>
    </div>


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
                <div class='ev-bottom-l-t'>122</div>
                <div class='ev-bottom-l-b'>Total Attendance</div>
            </div>
            <div class='anl-content-box-ev-bottom-l anl-content-box-ev-bottom-r'>
            <div class='ev-bottom-l-t'>8.6</div>
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

    <div class='anl-content-box-ev'>

    <div class='ev_cell'>
        <div class='ev_nondetail'>
        <div class='ev_cell_left'>
            <div class='ev_cell_left_photo' style='background-image: url(img/dummy_2.jpg)'></div>
            <div class='ev_cell_left_name'>Weekly Meeting</div>
        </div>

        <div class='ev_cell_mid_0'>
            8/13, 7:30pm
        </div>

        <div class='ev_cell_mid_1'>
            120
        </div>

        <div class='ev_cell_mid_2'>
            100%
        </div>

        <div class='ev_cell_right'>
            <span class='show_detail_of_event'><div class='anl_header_dropdown_showr_wedgedown'></div>Detail</span>
        </div>

        </div>
        <div class='ev_detail'>

        <div class='anl-header detail-anl-header'>
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



<div class='anl-content-box-mb detail_mb'>
    <div class='anl-content-box-mb-left'>

        <div class='anl-content-box-mb-left-cell'>
            <div class='anl-content-box-mb-left-cell-left'><span>Freshman</span></div>
            <div class='anl-content-box-mb-left-cell-mid'>
                <div class='mb-left-cell-mid-grey'>
                    <div class='mb-left-cell-mid-color bar_color_blue' style='width:12%'></div>
                </div>
                <div class='mb-left-cell-mid-percent'>12%</div>
            </div>
            <div class='anl-content-box-mb-left-cell-right'>
                24
            </div>
        </div>

        <div class='anl-content-box-mb-left-cell'>
            <div class='anl-content-box-mb-left-cell-left'><span>Sophomore</span></div>
            <div class='anl-content-box-mb-left-cell-mid'>
                <div class='mb-left-cell-mid-grey'>
                    <div class='mb-left-cell-mid-color bar_color_blue' style='width:20%'></div>
                </div>
                <div class='mb-left-cell-mid-percent'>20%</div>
            </div>
            <div class='anl-content-box-mb-left-cell-right'>
                40
            </div>
        </div>

        <div class='anl-content-box-mb-left-cell'>
            <div class='anl-content-box-mb-left-cell-left'><span>Junior</span></div>
            <div class='anl-content-box-mb-left-cell-mid'>
                <div class='mb-left-cell-mid-grey'>
                    <div class='mb-left-cell-mid-color bar_color_blue' style='width:15%'></div>
                </div>
                <div class='mb-left-cell-mid-percent'>15%</div>
            </div>
            <div class='anl-content-box-mb-left-cell-right'>
                30
            </div>
        </div>

        <div class='anl-content-box-mb-left-cell'>
            <div class='anl-content-box-mb-left-cell-left'><span>Senior</span></div>
            <div class='anl-content-box-mb-left-cell-mid'>
                <div class='mb-left-cell-mid-grey'>
                    <div class='mb-left-cell-mid-color bar_color_blue' style='width:23%'></div>
                </div>
                <div class='mb-left-cell-mid-percent'>23%</div>
            </div>
            <div class='anl-content-box-mb-left-cell-right'>
                46
            </div>
        </div>

        <div class='anl-content-box-mb-left-cell'>
            <div class='anl-content-box-mb-left-cell-left'><span>Graduate</span></div>
            <div class='anl-content-box-mb-left-cell-mid'>
                <div class='mb-left-cell-mid-grey'>
                    <div class='mb-left-cell-mid-color bar_color_blue' style='width:30%'></div>
                </div>
                <div class='mb-left-cell-mid-percent'>30%</div>
            </div>
            <div class='anl-content-box-mb-left-cell-right'>
                60
            </div>
        </div>
    </div>


    <div class='anl-content-box-mb-right'>
        <canvas class="pie_i" width="180" height="180"></canvas>
        <div class='anl-content-box-mb-right-right'>
            <div class='anl-content-box-mb-right-right-cell'>
            <div class='pattern_0 anl_pi_pattern'>
                <div class = 'card-tag-pattern'>
                    <div class = 'tag-wedge-pattern'></div>
                    <div class = 'tag-box-pattern'>
                        <span>Female: <span>35%</span></span>
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
                        <span>Male: <span>65%</span></span>
                    </div>                                  
                </div>
            </div>

            <div class='mb-right-cell-tag'>Male</div>
            </div>

        </div>
    </div>
</div>


        <div class='anl-header detail-anl-header'>
            <span>Presented Attendances</span>

            <div class='anl_tea'>Total Events Attendence</div>

            <div class='anl_pea'>% Total Events Attendence</div>
        </div>




        <div class='anl-content-box-am detail_anl-content-box-am'>
            <div class='am_cell'>
                <div class='am_cell_left'>
                    <div class='am_cell_left_photo' style='background-image: url(img/dummy_1.jpg)'></div>
                    <div class='am_cell_left_name'>Kushal Kadaba</div>
                </div>

                <div class='am_cell_mid_0'>
                    16
                </div>

                <div class='am_cell_mid_1'>
                    32%
                </div>
            </div>

                <div class='am_cell'>
                <div class='am_cell_left'>
                    <div class='am_cell_left_photo' style='background-image: url(img/dummy_1.jpg)'></div>
                    <div class='am_cell_left_name'>Kushal Kadaba</div>
                </div>

                <div class='am_cell_mid_0'>
                    16
                </div>

                <div class='am_cell_mid_1'>
                    32%
                </div>
            </div>

                <div class='am_cell'>
                <div class='am_cell_left'>
                    <div class='am_cell_left_photo' style='background-image: url(img/dummy_1.jpg)'></div>
                    <div class='am_cell_left_name'>Kushal Kadaba</div>
                </div>

                <div class='am_cell_mid_0'>
                    16
                </div>

                <div class='am_cell_mid_1'>
                    32%
                </div>
            </div>

        </div>


        </div>
        </div>



    <div class='ev_cell'>
        <div class='ev_nondetail'>
        <div class='ev_cell_left'>
            <div class='ev_cell_left_photo' style='background-image: url(img/dummy_2.jpg)'></div>
            <div class='ev_cell_left_name'>Weekly Meeting</div>
        </div>

        <div class='ev_cell_mid_0'>
            8/13, 7:30pm
        </div>

        <div class='ev_cell_mid_1'>
            120
        </div>

        <div class='ev_cell_mid_2'>
            100%
        </div>

        <div class='ev_cell_right'>
            <span class='show_detail_of_event'><div class='anl_header_dropdown_showr_wedgedown'></div>Detail</span>
        </div>

        </div>
        <div class='ev_detail'>

        <div class='anl-header detail-anl-header'>
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



<div class='anl-content-box-mb detail_mb'>
    <div class='anl-content-box-mb-left'>

        <div class='anl-content-box-mb-left-cell'>
            <div class='anl-content-box-mb-left-cell-left'><span>Freshman</span></div>
            <div class='anl-content-box-mb-left-cell-mid'>
                <div class='mb-left-cell-mid-grey'>
                    <div class='mb-left-cell-mid-color bar_color_blue' style='width:12%'></div>
                </div>
                <div class='mb-left-cell-mid-percent'>12%</div>
            </div>
            <div class='anl-content-box-mb-left-cell-right'>
                24
            </div>
        </div>

        <div class='anl-content-box-mb-left-cell'>
            <div class='anl-content-box-mb-left-cell-left'><span>Sophomore</span></div>
            <div class='anl-content-box-mb-left-cell-mid'>
                <div class='mb-left-cell-mid-grey'>
                    <div class='mb-left-cell-mid-color bar_color_blue' style='width:20%'></div>
                </div>
                <div class='mb-left-cell-mid-percent'>20%</div>
            </div>
            <div class='anl-content-box-mb-left-cell-right'>
                40
            </div>
        </div>

        <div class='anl-content-box-mb-left-cell'>
            <div class='anl-content-box-mb-left-cell-left'><span>Junior</span></div>
            <div class='anl-content-box-mb-left-cell-mid'>
                <div class='mb-left-cell-mid-grey'>
                    <div class='mb-left-cell-mid-color bar_color_blue' style='width:15%'></div>
                </div>
                <div class='mb-left-cell-mid-percent'>15%</div>
            </div>
            <div class='anl-content-box-mb-left-cell-right'>
                30
            </div>
        </div>

        <div class='anl-content-box-mb-left-cell'>
            <div class='anl-content-box-mb-left-cell-left'><span>Senior</span></div>
            <div class='anl-content-box-mb-left-cell-mid'>
                <div class='mb-left-cell-mid-grey'>
                    <div class='mb-left-cell-mid-color bar_color_blue' style='width:23%'></div>
                </div>
                <div class='mb-left-cell-mid-percent'>23%</div>
            </div>
            <div class='anl-content-box-mb-left-cell-right'>
                46
            </div>
        </div>

        <div class='anl-content-box-mb-left-cell'>
            <div class='anl-content-box-mb-left-cell-left'><span>Graduate</span></div>
            <div class='anl-content-box-mb-left-cell-mid'>
                <div class='mb-left-cell-mid-grey'>
                    <div class='mb-left-cell-mid-color bar_color_blue' style='width:30%'></div>
                </div>
                <div class='mb-left-cell-mid-percent'>30%</div>
            </div>
            <div class='anl-content-box-mb-left-cell-right'>
                60
            </div>
        </div>
    </div>


    <div class='anl-content-box-mb-right'>
        <canvas class="pie_i" width="180" height="180"></canvas>
        <div class='anl-content-box-mb-right-right'>
            <div class='anl-content-box-mb-right-right-cell'>
            <div class='pattern_0 anl_pi_pattern'>
                <div class = 'card-tag-pattern'>
                    <div class = 'tag-wedge-pattern'></div>
                    <div class = 'tag-box-pattern'>
                        <span>Female: <span>35%</span></span>
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
                        <span>Male: <span>65%</span></span>
                    </div>                                  
                </div>
            </div>

            <div class='mb-right-cell-tag'>Male</div>
            </div>

        </div>
    </div>
</div>


        <div class='anl-header detail-anl-header'>
            <span>Presented Attendances</span>

            <div class='anl_tea'>Total Events Attendence</div>

            <div class='anl_pea'>% Total Events Attendence</div>
        </div>




        <div class='anl-content-box-am detail_anl-content-box-am'>
            <div class='am_cell'>
                <div class='am_cell_left'>
                    <div class='am_cell_left_photo' style='background-image: url(img/dummy_1.jpg)'></div>
                    <div class='am_cell_left_name'>Kushal Kadaba</div>
                </div>

                <div class='am_cell_mid_0'>
                    16
                </div>

                <div class='am_cell_mid_1'>
                    32%
                </div>
            </div>

                <div class='am_cell'>
                <div class='am_cell_left'>
                    <div class='am_cell_left_photo' style='background-image: url(img/dummy_1.jpg)'></div>
                    <div class='am_cell_left_name'>Kushal Kadaba</div>
                </div>

                <div class='am_cell_mid_0'>
                    16
                </div>

                <div class='am_cell_mid_1'>
                    32%
                </div>
            </div>

                <div class='am_cell'>
                <div class='am_cell_left'>
                    <div class='am_cell_left_photo' style='background-image: url(img/dummy_1.jpg)'></div>
                    <div class='am_cell_left_name'>Kushal Kadaba</div>
                </div>

                <div class='am_cell_mid_0'>
                    16
                </div>

                <div class='am_cell_mid_1'>
                    32%
                </div>
            </div>

        </div>


        </div>
        </div>



            <div class='ev_cell'>
        <div class='ev_nondetail'>
        <div class='ev_cell_left'>
            <div class='ev_cell_left_photo' style='background-image: url(img/dummy_2.jpg)'></div>
            <div class='ev_cell_left_name'>Weekly Meeting</div>
        </div>

        <div class='ev_cell_mid_0'>
            8/13, 7:30pm
        </div>

        <div class='ev_cell_mid_1'>
            120
        </div>

        <div class='ev_cell_mid_2'>
            100%
        </div>

        <div class='ev_cell_right'>
            <span class='show_detail_of_event'><div class='anl_header_dropdown_showr_wedgedown'></div>Detail</span>
        </div>

        </div>
        <div class='ev_detail'>

        <div class='anl-header detail-anl-header'>
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



<div class='anl-content-box-mb detail_mb'>
    <div class='anl-content-box-mb-left'>

        <div class='anl-content-box-mb-left-cell'>
            <div class='anl-content-box-mb-left-cell-left'><span>Freshman</span></div>
            <div class='anl-content-box-mb-left-cell-mid'>
                <div class='mb-left-cell-mid-grey'>
                    <div class='mb-left-cell-mid-color bar_color_blue' style='width:12%'></div>
                </div>
                <div class='mb-left-cell-mid-percent'>12%</div>
            </div>
            <div class='anl-content-box-mb-left-cell-right'>
                24
            </div>
        </div>

        <div class='anl-content-box-mb-left-cell'>
            <div class='anl-content-box-mb-left-cell-left'><span>Sophomore</span></div>
            <div class='anl-content-box-mb-left-cell-mid'>
                <div class='mb-left-cell-mid-grey'>
                    <div class='mb-left-cell-mid-color bar_color_blue' style='width:20%'></div>
                </div>
                <div class='mb-left-cell-mid-percent'>20%</div>
            </div>
            <div class='anl-content-box-mb-left-cell-right'>
                40
            </div>
        </div>

        <div class='anl-content-box-mb-left-cell'>
            <div class='anl-content-box-mb-left-cell-left'><span>Junior</span></div>
            <div class='anl-content-box-mb-left-cell-mid'>
                <div class='mb-left-cell-mid-grey'>
                    <div class='mb-left-cell-mid-color bar_color_blue' style='width:15%'></div>
                </div>
                <div class='mb-left-cell-mid-percent'>15%</div>
            </div>
            <div class='anl-content-box-mb-left-cell-right'>
                30
            </div>
        </div>

        <div class='anl-content-box-mb-left-cell'>
            <div class='anl-content-box-mb-left-cell-left'><span>Senior</span></div>
            <div class='anl-content-box-mb-left-cell-mid'>
                <div class='mb-left-cell-mid-grey'>
                    <div class='mb-left-cell-mid-color bar_color_blue' style='width:23%'></div>
                </div>
                <div class='mb-left-cell-mid-percent'>23%</div>
            </div>
            <div class='anl-content-box-mb-left-cell-right'>
                46
            </div>
        </div>

        <div class='anl-content-box-mb-left-cell'>
            <div class='anl-content-box-mb-left-cell-left'><span>Graduate</span></div>
            <div class='anl-content-box-mb-left-cell-mid'>
                <div class='mb-left-cell-mid-grey'>
                    <div class='mb-left-cell-mid-color bar_color_blue' style='width:30%'></div>
                </div>
                <div class='mb-left-cell-mid-percent'>30%</div>
            </div>
            <div class='anl-content-box-mb-left-cell-right'>
                60
            </div>
        </div>
    </div>


    <div class='anl-content-box-mb-right'>
        <canvas class="pie_i" width="180" height="180"></canvas>
        <div class='anl-content-box-mb-right-right'>
            <div class='anl-content-box-mb-right-right-cell'>
            <div class='pattern_0 anl_pi_pattern'>
                <div class = 'card-tag-pattern'>
                    <div class = 'tag-wedge-pattern'></div>
                    <div class = 'tag-box-pattern'>
                        <span>Female: <span>35%</span></span>
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
                        <span>Male: <span>65%</span></span>
                    </div>                                  
                </div>
            </div>

            <div class='mb-right-cell-tag'>Male</div>
            </div>

        </div>
    </div>
</div>


        <div class='anl-header detail-anl-header'>
            <span>Presented Attendances</span>

            <div class='anl_tea'>Total Events Attendence</div>

            <div class='anl_pea'>% Total Events Attendence</div>
        </div>




        <div class='anl-content-box-am detail_anl-content-box-am'>
            <div class='am_cell'>
                <div class='am_cell_left'>
                    <div class='am_cell_left_photo' style='background-image: url(img/dummy_1.jpg)'></div>
                    <div class='am_cell_left_name'>Kushal Kadaba</div>
                </div>

                <div class='am_cell_mid_0'>
                    16
                </div>

                <div class='am_cell_mid_1'>
                    32%
                </div>
            </div>

                <div class='am_cell'>
                <div class='am_cell_left'>
                    <div class='am_cell_left_photo' style='background-image: url(img/dummy_1.jpg)'></div>
                    <div class='am_cell_left_name'>Kushal Kadaba</div>
                </div>

                <div class='am_cell_mid_0'>
                    16
                </div>

                <div class='am_cell_mid_1'>
                    32%
                </div>
            </div>

                <div class='am_cell'>
                <div class='am_cell_left'>
                    <div class='am_cell_left_photo' style='background-image: url(img/dummy_1.jpg)'></div>
                    <div class='am_cell_left_name'>Kushal Kadaba</div>
                </div>

                <div class='am_cell_mid_0'>
                    16
                </div>

                <div class='am_cell_mid_1'>
                    32%
                </div>
            </div>

        </div>


        </div>
        </div>

    </div>

</div>


</div>

</body>
</html>
