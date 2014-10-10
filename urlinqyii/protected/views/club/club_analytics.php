<!DOCTYPE html> 
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/analytics.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/Chart.js-master/Chart.js"></script>

<script>

$(document).ready(function() {
	var dn_0 = $(".doughnut_0").get(0).getContext("2d");
    var dn_1 = $(".doughnut_1").get(0).getContext("2d");
    var dn_2 = $(".doughnut_2").get(0).getContext("2d");
    var pi_0 = $(".pie_0").get(0).getContext("2d");
    //var pi_i = $(".pie_i").get(0).getContext("2d");
    var ln_0 = $(".linegraph_0").get(0).getContext("2d");


    var current_option = $('.ga_option_cur').text();
    var group_id = <?php echo $club->group_id ?>
    alert(group_id);
//    $.getScript('js/getURLPara.js', function(){
//        var group_id = '';
//        if ($.getUrlVar("group_id") != null) {
//            group_id = $.getUrlVar("group_id").toString();
//        }
//        $.getJSON("php/analytics/club_page_view_data.php", { group_id: group_id, filter:current_option}, function(json_data) {
//
//            show_page_view_data(json_data);
//        });
//    });
   show_page_view_data();

    function show_page_view_data(){
        $.getScript('js/getURLPara.js', function(){
            var group_id = '';
            if ($.getUrlVar("group_id") != null) {
                group_id = $.getUrlVar("group_id").toString();
            }

            var current_option = $('.ga_option_cur').text();

            $.getJSON("php/analytics/club_page_view_data.php", { group_id: group_id, filter:current_option}, function(page_view_json) {
                console.log("page view data");

                console.log(page_view_json);


                var new_page_views_count = 0;
                var percent_increase = 0.0;
                //prevent divide by 0


                new_page_views_count = page_view_json['new_page_views'];
                percent_increase = new_page_views_count / page_view_json['total_page_views'];
//                if(current_option.indexOf("Week") > -1){
//                    new_page_views_count = page_view_json['new_this_week'];
//                    percent_increase = page_view_json['new_this_week'] / page_view_json['total_page_views'];
//                }else if(current_option.indexOf("Month") > -1){
//                    new_page_views_count = page_view_json['new_this_month'];
//                    percent_increase = page_view_json['new_this_month'] / page_view_json['total_page_views'];
//                }else if(current_option.indexOf("Semester") > -1){
//                    new_page_views_count = page_view_json['new_this_year'];
//                    percent_increase = page_view_json['new_this_year'] / page_view_json['total_page_views'];
//                }



                if(page_view_json['total_page_views'] != 0){
                    percent_increase = new_page_views_count / page_view_json['total_page_views'];
                }

                var page_view_data = [
                    {
                        value: page_view_json['total_page_views'] - new_page_views_count,
                        color:"#e5e5e5",
                        highlight: "#fff",
                        label: "Old dogs"
                    },
                    {
                        value: new_page_views_count,
                        color: "#4BAEF0",
                        highlight: "#63b9f2",
                        label: "Newbie"
                    }
                ];
                var chart_dn0= new Chart(dn_0).Doughnut(page_view_data, {
                    percentageInnerCutout : 87,
                    segmentShowStroke : false,
                    showTooltips: false,
                    animationSteps : 75,
                    animationEasing: "easeOutCubic"
                });

                //Round to two decimal points
                percent_increase = Math.round(percent_increase * 100) / 100;


                //reset left margin
                var $percent_text = $('#page_views_percent_increase_text');
                $percent_text.css('margin-left', '18px');

                var percent_increase_str = '';
                if(percent_increase < 1){
                    $percent_text.css('margin-left', function (index, curValue) {
                        return parseInt(curValue, 10) + 0 + 'px';
                    });
                    percent_increase_str = '+' + (percent_increase * 100).toString() + '%';
                }else if(percent_increase == 1){
                    percent_increase_str = (percent_increase * 100).toString() + '%';
                }else{
                    percent_increase_str = '+' + (percent_increase * 100).toString() + '%';
                }

                $percent_text.text(percent_increase_str);
                $('#total_page_views_text').text(page_view_json['total_page_views'].toString());
                $('#new_page_views_text').text(new_page_views_count.toString());


            });

        });

    }


    show_member_data();
    function show_member_data(){
        $.getScript('js/getURLPara.js', function(){
            var group_id = '';
            if ($.getUrlVar("group_id") != null) {
                group_id = $.getUrlVar("group_id").toString();
            }

            $.getJSON("php/analytics/club_member_count_data.php", { group_id: group_id}, function(json_data) {
                console.log(json_data);
                var current_option = $('.ga_option_cur').text().toLowerCase();
                var percent_increase = 0.0;
                var old_members_count = 0;
                var new_members_count = 0;


                if(current_option.indexOf("week") > -1){
                    old_members_count = json_data['members_count'] - json_data['joined_this_week'];
                    new_members_count = json_data['joined_this_week'];
                    percent_increase = json_data['joined_this_week'] / json_data['members_count'];
                }else if(current_option.indexOf("month") > -1){
                    old_members_count = json_data['members_count'] - json_data['joined_this_month'];
                    new_members_count = json_data['joined_this_month'];
                    percent_increase = json_data['joined_this_month'] / json_data['members_count'];
                }else if(current_option.indexOf("semester") > -1){
                    old_members_count = json_data['members_count'] - json_data['joined_this_year'];
                    new_members_count = json_data['joined_this_year'];
                    percent_increase = json_data['joined_this_year'] / json_data['members_count'];
                }


                var member_data = [
                    {
                        value: old_members_count,
                        color:"#e5e5e5",
                        highlight: "#fff",
                        label: "Old dogs"
                    },
                    {
                        value: new_members_count,
                        color: "#4BAEF0",
                        highlight: "#63b9f2",
                        label: "Newbie"
                    }
                ];
                console.log('Member data');
                console.log(member_data);

                var chart_dn1= new Chart(dn_1).Doughnut(member_data, {
                    percentageInnerCutout : 87,
                    segmentShowStroke : false,
                    showTooltips: false,
                    animationSteps : 75,
                    animationEasing: "easeOutCubic"
                });


                console.log('percent increase');
                console.log(percent_increase);

                //Round to two decimal points
                percent_increase = Math.round(percent_increase * 100) / 100;


                //reset left margin
                $('#members_percent_increase_text').css('margin-left', '18px');

                var percent_increase_str = '';
                if(percent_increase < 1){
                    $('#members_percent_increase_text').css('margin-left', function (index, curValue) {
                        return parseInt(curValue, 10) + 25 + 'px';
                    });
                    percent_increase_str = (percent_increase * 100).toString() + '%';
                }else if(percent_increase == 1){
                    percent_increase_str = (percent_increase * 100).toString() + '%';
                }else{
                    percent_increase_str = '+' + (percent_increase * 100).toString() + '%';
                }

                $('#members_percent_increase_text').text(percent_increase_str);
                $('#total_members_count_text').text(json_data['members_count'].toString());
                $('#new_members_count_text').text(new_members_count.toString());

            });
        });

    }




    show_attendance_data();
    function show_attendance_data(){
        $.getScript('js/getURLPara.js', function(){
            var group_id = '';
            if ($.getUrlVar("group_id") != null) {
                group_id = $.getUrlVar("group_id").toString();
            }

            var current_option = $('.ga_option_cur').text();

            $.getJSON("php/analytics/club_attendance_data.php", { group_id: group_id, filter:current_option}, function(attendance_json) {
                var invite_count = attendance_json['invite_count'];
                var accepted_invites_count = attendance_json['accepted_invite_count'];
                var percent_increase = 0.0;



                //prevent divide by 0
                //{"invite_count":11,"accepted_invite_count":7}
//                if(current_option.indexOf("Week") > -1){
//                    new_page_views_count = page_view_json['new_this_week'];
//                    percent_increase = page_view_json['new_this_week'] / page_view_json['total_page_views'];
//                }else if(current_option.indexOf("Month") > -1){
//                    new_page_views_count = page_view_json['new_this_month'];
//                    percent_increase = page_view_json['new_this_month'] / page_view_json['total_page_views'];
//                }else if(current_option.indexOf("Semester") > -1){
//                    new_page_views_count = page_view_json['new_this_year'];
//                    percent_increase = page_view_json['new_this_year'] / page_view_json['total_page_views'];
//                }


                //If invite count = 0, leave this as 1 so the graph actually shows
                var invite_count_graph_data = 1;

                if(invite_count != 0){
                    percent_increase = accepted_invites_count / invite_count;
                    invite_count_graph_data = invite_count - accepted_invites_count;
                }


                var attendance_data = [
                    {
                        value: invite_count_graph_data,
                        color:"#e5e5e5",
                        highlight: "#fff",
                        label: "Old dogs"
                    },
                    {
                        value: accepted_invites_count,
                        color: "#4BAEF0",
                        highlight: "#63b9f2",
                        label: "Newbie"
                    }
                ];
                var chart_dn2= new Chart(dn_2).Doughnut(attendance_data, {
                    percentageInnerCutout : 87,
                    segmentShowStroke : false,
                    showTooltips: false,
                    animationSteps : 75,
                    animationEasing: "easeOutCubic"
                });

                //Round to two decimal points
                percent_increase = Math.round(percent_increase * 100) / 100;
                console.log("ATTENDANCE PERCENT INCREASE");
                console.log(percent_increase);

                //reset left margin
                var $percent_text = $('#invite_percent_increase');
                $percent_text.css('margin-left', '18px');

                var percent_increase_str = '';
                if(percent_increase == 0){
                    $percent_text.css('margin-left', function (index, curValue) {
                        return parseInt(curValue, 10) + 25 + 'px';
                    });
                    percent_increase_str = '' + (percent_increase * 100).toString() + '%';
                }else if(percent_increase == 1){
                    percent_increase_str = (percent_increase * 100).toString() + '%';
                }else if(percent_increase < .1){
                    $percent_text.css('margin-left', function (index, curValue) {
                        return parseInt(curValue, 10) + 0 + 'px';
                    });
                    percent_increase_str = '+' + (percent_increase * 100).toString() + '%';
                }else{
                    percent_increase_str = '+' + (percent_increase * 100).toString() + '%';
                }

                $percent_text.text(percent_increase_str);
                $('#invite_count').text(invite_count.toString());
                $('#accepted_invite_count').text(accepted_invites_count.toString());
            });

        });

    }





    var data_dn_2 = [
    {
        value: 0,
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
];

//        var data_pi_0 = [
//    {
//        value: 15,
//        color: "#f04b5b",
//        highlight: "#f26370",
//        label: "Female"
//    },
//    {
//        value: 30,
//        color:"#4BAEF0",
//        highlight: "#63b9f2",
//        label: "Male"
//    }
//]


gender_data = null;

show_gender_data();
function show_gender_data(){
    $.getScript('js/getURLPara.js', function(){
        var group_id = '';
        if ($.getUrlVar("group_id") != null) {
            group_id = $.getUrlVar("group_id").toString();
        }
//        console.log("GROUP ID");
//        console.log(group_id);
        $.getJSON("php/analytics/club_gender_data.php", { group_id: group_id}, function(json_data) {
//            console.log("Gender json data for group " + group_id);
//            console.log(json_data);
            gender_data = [
                {
                    label:'Female',
                    value: json_data['female_count'],
                    color: "#f04b5b",
                    highlight: "#f26370"
                },
                {
                    label: "Male",
                    value: json_data['male_count'],
                    color:"#4BAEF0",
                    highlight: "#63b9f2"
                }
            ];
            //console.log(gender_data);
            var chart_pi0 = new Chart(pi_0).Doughnut(gender_data, {
                percentageInnerCutout : 0,
                segmentShowStroke : false,
                showTooltips: true,
                animationSteps : 75,
                animationEasing: "easeOutCubic"
            });

            //Update the mouse over data for male/female breakdown
            var user_total = json_data['male_count'] + json_data['female_count'];
            var female_percentage = (json_data['female_count'] / user_total) * 100;
            $("#female_count_span").text('Female: ' + female_percentage + '%');

            var male_percentage = (json_data['male_count'] / user_total) * 100;
            $("#male_count_span").text('Male: ' + male_percentage + '%');

        });
    });

}








    show_line_graph();
    function show_line_graph(){
        $.getScript('js/getURLPara.js', function(){
            var group_id = '';
            if ($.getUrlVar("group_id") != null) {
                group_id = $.getUrlVar("group_id").toString();
            }

            $.getJSON("php/analytics/club_line_graph_semester_data.php", { group_id: group_id}, function(json_data) {

                var line_graph_data = {
                    //"7/08", "7/15", "7/21", "8/05", "8/12", "8/19", "8/27","9/05","9/12"
                    labels: [],
                    datasets: [
                        {
                            label: "Attendence Trends",
                            fillColor: "rgba(151,187,205,0.2)",
                            strokeColor: "rgba(151,187,205,1)",
                            pointColor: "rgba(151,187,205,1)",
                            pointStrokeColor: "#fff",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(151,187,205,1)",
                            //25, 30, 20, 20, 22, 55, 40,25,39
                            data: []
                        }
                    ]
                };


                json_data['dates'] = json_data['dates'].reverse();


                $.each( json_data['dates'], function( index, date_data) {
                    var this_date_key = Object.keys(date_data)[0];
                    var attendance_count = date_data[this_date_key];
                    var this_date = new Date(this_date_key);
                    //Add 1 to month because getUTCMonth/getMonth return 0-11
                    var this_date_str = (this_date.getUTCMonth() + 1).toString() + '/' + this_date.getUTCDate().toString();
                    line_graph_data['labels'].push(this_date_str);
                    line_graph_data['datasets'][0]['data'].push(attendance_count);
                });

                var chart_ln0 = new Chart(ln_0).Line(line_graph_data, {
                    bezierCurve : false,
                    scaleBeginAtZero: true
                });

                var attendance_percentage = json_data['attendance_count'] / json_data['invite_count'] * 100;
                attendance_percentage = Math.round(attendance_percentage * 100) / 100;
                $("#total_attendance_text").text(json_data['attendance_count'].toString());
                $("#average_attendance_text").text(attendance_percentage.toString() + '%');

            });
        });

    }


//    var data_pi_i = [
//        {
//            value: 15,
//            color: "#f04b5b",
//            highlight: "#f26370",
//            label: "Female"
//        },
//        {
//            value: 30,
//            color:"#4BAEF0",
//            highlight: "#63b9f2",
//            label: "Male"
//        }
//    ];


    var chart_dn2= new Chart(dn_2).Doughnut(data_dn_2, {
    percentageInnerCutout : 87,
    segmentShowStroke : false,
    showTooltips: false,
    animationSteps : 75,
    animationEasing: "easeOutCubic"
});

//var chart_pi0= new Chart(pi_0).Doughnut(data_pi_0, {
//    percentageInnerCutout : 0,
//    segmentShowStroke : false,
//    showTooltips: true,
//    animationSteps : 75,
//    animationEasing: "easeOutCubic"
//});





//var chart_pii= new Chart(pi_i).Doughnut(data_pi_i, {
//    percentageInnerCutout : 0,
//    segmentShowStroke : false,
//    showTooltips: true,
//    animationSteps : 75,
//    animationEasing: "easeOutCubic"
//});



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
    show_page_view_data();
    show_member_data();
    show_attendance_data();
});


$(document).delegate(".anl_header_dropdown_showr","click",function(){
    $(this).closest(".anl_header_dropdown").find(".anl_header_dropdown_box").show();
});

$(document).delegate(".anl_header_dropdown_option","click",function(){
    var txt= $(this).text();
    $(this).closest(".anl_header_dropdown").find(".anl_header_dropdown_showr").html("<div class='anl_header_dropdown_showr_wedgedown'></div>"+txt);
    $(this).closest(".anl_header_dropdown").find(".anl_header_dropdown_box").hide();

    show_member_attendance();
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

function add_tag(tag,$member_div){
    $.getScript('js/getURLPara.js', function(){
        var group_id = '';
        if ($.getUrlVar("group_id") != null) {
            group_id = $.getUrlVar("group_id").toString();
        }

        var user_id = $member_div.data('user_id');
        var post_data = {'user_id':user_id,'group_id':group_id,'tag':tag};


        $.post(
            'php/analytics/club_user_add_tag',
            post_data,
            function(response) {
                if(response['success'] == 'true'){

                }else{

                }
            }, 'json'
        );

    });
}

function remove_tag(tag,$member_div){

    //remove the minus sign and space from tag
    tag = tag.replace('- ','');
    $.getScript('js/getURLPara.js', function(){
        var group_id = '';
        if ($.getUrlVar("group_id") != null) {
            group_id = $.getUrlVar("group_id").toString();
        }

        var user_id = $member_div.data('user_id');
        var post_data = {'user_id':user_id,'group_id':group_id,'tag':tag};

        console.log('REMOVING TAG ' + tag + ' from user: ' + user_id);


        $.post(
            'php/analytics/club_user_remove_tag',
            post_data,
            function(response) {
                if(response['success'] == 'true'){

                }else{

                }
            }, 'json'
        );

    });
}

$(document).delegate(".plus_button","click",function(){
    if(!$(this).hasClass("wait_to_tag")){
        $(this).addClass("wait_to_tag");
        $(this).closest(".am_cell").find(".cell_right_tags_wrap").hide();
        $(this).closest(".am_cell").find(".cell_right_input").show();
    }else{
        var new_tag= $(this).closest(".am_cell").find(".cell_right_input").val().trim();

        if(new_tag!=""){

            add_tag(new_tag,$(this).closest(".member"));
            $(this).removeClass("wait_to_tag");
            $(this).closest(".am_cell").find(".cell_right_input").val("");
            $(this).closest(".am_cell").find(".cell_right_input").hide();
            $(this).closest(".am_cell").find(".cell_right_tags_wrap").show();

            $(this).closest(".tags").append("<div class='cell_right_a_tag'>" + new_tag + "</div>");
            $(this).closest(".am_cell").find(".cell_right_tags_wrap").append("<div class='cell_right_a_tag'>" + new_tag + "</div>");

            //Handle tag overflow here
//            if($(this).closest(".am_cell").find(".cell_right_tags_wrap").children().length>=2){
//
//            }else{
//                $(this).closest(".am_cell").find(".cell_right_tags_wrap").append("<div class='cell_right_a_tag'>"+x+"</div>");
//            }
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
        remove_tag($rt.text(),$(this).closest(".member"));
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


show_member_breakdown();
function show_member_breakdown(){
    $.getScript('js/getURLPara.js', function(){
        var group_id = '';
        if ($.getUrlVar("group_id") != null) {
            group_id = $.getUrlVar("group_id").toString();
        }

        $.getJSON("php/analytics/club_class_rank_data.php", { group_id: group_id}, function(json_data) {
            var freshman_percent_str = (json_data['freshman_count'] / json_data['total_count'] * 100).toString() + '%';
            var sophomore_percent_str = (json_data['sophomore_count'] / json_data['total_count'] * 100).toString() + '%';
            var junior_percent_str = (json_data['junior_count'] / json_data['total_count'] * 100).toString() + '%';
            var senior_percent_str = (json_data['senior_count'] / json_data['total_count'] * 100).toString() + '%';
            var graduate_percent_str = (json_data['graduate_count'] / json_data['total_count'] * 100).toString() + '%';

            //Set the width of the horizontal bar graphs
            $('#freshman_percent_bar').width(freshman_percent_str);
            $('#sophomore_percent_bar').width(sophomore_percent_str);
            $('#junior_percent_bar').width(junior_percent_str);
            $('#senior_percent_bar').width(senior_percent_str);
            $('#graduate_percent_bar').width(graduate_percent_str);

            //Set percent text
            $('#freshman_percent_text').text(freshman_percent_str);
            $('#sophomore_percent_text').text(sophomore_percent_str);
            $('#junior_percent_text').text(junior_percent_str);
            $('#senior_percent_text').text(senior_percent_str);
            $('#graduate_percent_text').text(graduate_percent_str);

            //Set class rank count
            $('#freshman_count').text(json_data['freshman_count']);
            $('#sophomore_count').text(json_data['sophomore_count']);
            $('#junior_count').text(json_data['junior_count']);
            $('#senior_count').text(json_data['senior_count']);
            $('#graduate_count').text(json_data['graduate_count']);
        });
    });

}



    show_event_breakdown();
    function show_event_breakdown(){
        $.getScript('js/getURLPara.js', function(){
            var group_id = '';
            if ($.getUrlVar("group_id") != null) {
                group_id = $.getUrlVar("group_id").toString();
            }

            $.getJSON("php/analytics/club_event_data.php", { group_id: group_id}, function(json_data) {
                console.log(json_data);

                $.each( json_data['events'], function( index, event_data) {
                    var $event_div = $(" \
                        <div class='ev_cell'> \
                        <div class='ev_nondetail'> \
                        <div class='ev_cell_left'> \
                        <div class='ev_cell_left_photo event_image' style='background-image: url(<?php echo Yii::app()->getBaseUrl(true); ?>/dummy_2.jpg)'></div> \
                    <div class='ev_cell_left_name event_title' ></div> \
                    </div> \
                    <div class='ev_cell_mid_0 event_datetime' ></div> \
                    <div class='ev_cell_mid_1 event_total_attendance'></div> \
                    <div class='ev_cell_mid_2 event_attendance_percent'></div> \
                    <div class='ev_cell_right'> \
                        <span class='show_detail_of_event'><div class='anl_header_dropdown_showr_wedgedown'></div>Detail</span> \
                    </div> \
                    </div> \
                    <div class='ev_detail'> \
                        <div class='anl-header detail-anl-header'> \
                        <span>Member Breakdown</span> \
                    <div class = 'anl_header_dropdown'> \
                        <div class = 'anl_header_dropdown_showr'> \
                        <div class='anl_header_dropdown_showr_wedgedown'></div> All Schools \
                    </div> \
                    <div class = 'anl_header_dropdown_box'> \
                        <div class = 'anl_header_dropdown_option anl_option_edit'>School 1</div> \
                    <hr class = 'anl_option_hr'> \
                        <div class = 'anl_header_dropdown_option anl_option_edit'>School 2</div> \
                    <hr class = 'anl_option_hr'> \
                        <div class = 'anl_header_dropdown_option anl_option_edit'>School 3</div> \
                    <hr class = 'anl_option_hr'> \
                        <div class = 'anl_header_dropdown_option anl_option_edit'>All Schools</div> \
                    </div> \
                    </div> \
                    </div> \
                    <div class='anl-content-box-mb detail_mb'> \
                        <div class='anl-content-box-mb-left'> \
                        <div class='anl-content-box-mb-left-cell'> \
                        <div class='anl-content-box-mb-left-cell-left'><span>Freshman</span></div> \
                    <div class='anl-content-box-mb-left-cell-mid'> \
                        <div class='mb-left-cell-mid-grey'> \
                        <div class='mb-left-cell-mid-color bar_color_blue freshman_percent_bar' style='width:0%'></div> \
                    </div> \
                    <div class='mb-left-cell-mid-percent freshman_percent_text'>0%</div> \
                    </div> \
                    <div class='anl-content-box-mb-left-cell-right freshman_count'>0</div> \
                    </div> \
                    <div class='anl-content-box-mb-left-cell'> \
                        <div class='anl-content-box-mb-left-cell-left'><span>Sophomore</span></div> \
                    <div class='anl-content-box-mb-left-cell-mid'> \
                        <div class='mb-left-cell-mid-grey'> \
                        <div class='mb-left-cell-mid-color bar_color_blue sophomore_percent_bar' style='width:0%'></div> \
                    </div> \
                    <div class='mb-left-cell-mid-percent sophomore_percent_text'>0%</div> \
                    </div> \
                    <div class='anl-content-box-mb-left-cell-right sophomore_count'>0</div> \
                    </div> \
                    <div class='anl-content-box-mb-left-cell'> \
                        <div class='anl-content-box-mb-left-cell-left'><span>Junior</span></div> \
                    <div class='anl-content-box-mb-left-cell-mid'> \
                        <div class='mb-left-cell-mid-grey'> \
                        <div class='mb-left-cell-mid-color bar_color_blue junior_percent_bar' style='width:0%'></div> \
                    </div> \
                    <div class='mb-left-cell-mid-percent junior_percent_text'>0%</div> \
                    </div> \
                    <div class='anl-content-box-mb-left-cell-right junior_count'>0</div> \
                    </div> \
                    <div class='anl-content-box-mb-left-cell'> \
                        <div class='anl-content-box-mb-left-cell-left'><span>Senior</span></div> \
                    <div class='anl-content-box-mb-left-cell-mid'> \
                        <div class='mb-left-cell-mid-grey'> \
                        <div class='mb-left-cell-mid-color bar_color_blue senior_percent_bar' style='width:0%'></div> \
                    </div> \
                    <div class='mb-left-cell-mid-percent senior_percent_text'>0%</div> \
                    </div> \
                    <div class='anl-content-box-mb-left-cell-right senior_count'>0</div> \
                    </div> \
                    <div class='anl-content-box-mb-left-cell'> \
                        <div class='anl-content-box-mb-left-cell-left'><span>Graduate</span></div> \
                    <div class='anl-content-box-mb-left-cell-mid'> \
                        <div class='mb-left-cell-mid-grey'> \
                        <div class='mb-left-cell-mid-color bar_color_blue graduate_percent_bar' style='width:0%'></div> \
                    </div> \
                    <div class='mb-left-cell-mid-percent graduate_percent_text'>0%</div> \
                    </div> \
                    <div class='anl-content-box-mb-left-cell-right graduate_count'>0</div> \
                    </div> \
                    </div> \
                    <div class='anl-content-box-mb-right'> \
                        <canvas class='pie_i gender_piechart' width='180' height='180'></canvas> \
                    <div class='anl-content-box-mb-right-right gender_percent_div' > \
                        <div class='anl-content-box-mb-right-right-cell'> \
                        <div class='pattern_0 anl_pi_pattern'> \
                        <div class = 'card-tag-pattern'> \
                        <div class = 'tag-wedge-pattern'></div> \
                    <div class = 'tag-box-pattern'> \
                        <span class='female_percent_span'></span> \
                    </div> \
                    </div> \
                    </div> \
                    <div class='mb-right-cell-tag'>Female</div> \
                    </div> \
                    <div class='anl-content-box-mb-right-right-cell'> \
                        <div class='pattern_1 anl_pi_pattern'> \
                        <div class = 'card-tag-pattern'> \
                        <div class = 'tag-wedge-pattern'></div> \
                    <div class = 'tag-box-pattern'> \
                        <span class='female_percent_span'></span> \
                    </div> \
                    </div> \
                    </div> \
                    <div class='mb-right-cell-tag'>Male</div> \
                    </div> \
                    </div> \
                    </div> \
                    </div> \
                    <div class='anl-header detail-anl-header attendees_header'> \
                        <span>Presented Attendances</span> \
                    <div class='anl_tea'>Total Events Attendence</div> \
                    <div class='anl_pea'>% Total Events Attendence</div> \
                    </div> \
                    <div class='anl-content-box-am detail_anl-content-box-am attendees'></div> \
                    </div> \
                    </div>");
                    //$event_div.find('.event_name').css('background-image', 'url(' + imageUrl + ')');
                    $event_div.data('event_id',event_data['event_id']);
                    $event_div.find('.event_title').text(event_data['event_title']);
                    var $event_datetime = new Date(event_data['datetime']);
                    var $event_datetime_str = ($event_datetime.getUTCMonth() + 1).toString() + '/' + $event_datetime.getUTCDate().toString();

                    $event_div.find('.event_datetime').text($event_datetime_str);
                    $event_div.find('.event_total_attendance').text(event_data['accepted_invite_count']);
                    var $event_attendance_percent_str = (event_data['accepted_invite_count'] / event_data['invite_count'] * 100).toString() + '%';
                    $event_div.find('.event_attendance_percent').text($event_attendance_percent_str);

                    $.each( event_data['attendees'], function( index, attendee_data) {
                        var $attendee_div = $("\
                            <div class='am_cell attendee'> \
                                <div class='am_cell_left'> \
                                    <div class='am_cell_left_photo attendee_img' style='background-image: url(<?php echo Yii::app()->getBaseUrl(true); ?>/assets/dummy_1.jpg)'></div> \
                                    <div class='am_cell_left_name attendee_name'></div> \
                                </div> \
                                <div class='am_cell_mid_0 attendee_total_attendance'></div> \
                                <div class='am_cell_mid_1 attendee_attendance_percent'></div> \
                            </div>\
                        ");
                        $attendee_div.data('user_id',attendee_data['id']);
                        $attendee_div.find('.attendee_name').text(attendee_data['name']);
                        $attendee_div.find('.attendee_total_attendance').text(attendee_data['attendance_count']);
                        $attendee_div.find('.attendee_attendance_percent').text(attendee_data['attendance_percent_str']);
                        //$attendee_div.find('.attendee_img').css('background-image', 'url(' + imageUrl + ')');

                        $event_div.find('.attendees').append($attendee_div);

                    });


                    //Show gender breakdown
                    var gender_data = [
                        {
                            label:'Female',
                            value: event_data['female_count'],
                            color: "#f04b5b",
                            highlight: "#f26370"
                        },
                        {
                            label: "Male",
                            value: event_data['male_count'],
                            color:"#4BAEF0",
                            highlight: "#63b9f2"
                        }
                    ];

                    var $event_piechart = $event_div.find('.gender_piechart').get(0).getContext("2d");
                    //console.log(gender_data);
                    var chart_pi0 = new Chart($event_piechart).Doughnut(gender_data, {
                        percentageInnerCutout : 0,
                        segmentShowStroke : false,
                        showTooltips: true,
                        animationSteps : 75,
                        animationEasing: "easeOutCubic"
                    });

                    //Update the mouse over data for male/female breakdown
                    var user_total = event_data['accepted_invite_count'];


                    if(user_total > 0){
                        var female_percentage = (event_data['female_count'] / user_total) * 100;
                        $event_div.find('.female_percent_span').text('Female: ' + female_percentage + '%');

                        var male_percentage = (event_data['male_count'] / user_total) * 100;
                        $event_div.find('.male_percent_span').text('Male: ' + male_percentage + '%');



                        //Show breakdown of event class rank data
                        var freshman_percent_str = (event_data['freshman_count'] / user_total * 100).toString() + '%';
                        var sophomore_percent_str = (event_data['sophomore_count'] / user_total * 100).toString() + '%';
                        var junior_percent_str = (event_data['junior_count'] / user_total * 100).toString() + '%';
                        var senior_percent_str = (event_data['senior_count'] / user_total * 100).toString() + '%';
                        var graduate_percent_str = (event_data['graduate_count'] / user_total * 100).toString() + '%';

                        //Set the width of the horizontal bar graphs
                        $event_div.find('.freshman_percent_bar').width(freshman_percent_str);
                        $event_div.find('.sophomore_percent_bar').width(sophomore_percent_str);
                        $event_div.find('.junior_percent_bar').width(junior_percent_str);
                        $event_div.find('.senior_percent_bar').width(senior_percent_str);
                        $event_div.find('.graduate_percent_bar').width(graduate_percent_str);

                        //Set percent text
                        $event_div.find('.freshman_percent_text').text(freshman_percent_str);
                        $event_div.find('.sophomore_percent_text').text(sophomore_percent_str);
                        $event_div.find('.junior_percent_text').text(junior_percent_str);
                        $event_div.find('.senior_percent_text').text(senior_percent_str);
                        $event_div.find('.graduate_percent_text').text(graduate_percent_str);

                        //Set class rank count
                        $event_div.find('.freshman_count').text(event_data['freshman_count']);
                        $event_div.find('.sophomore_count').text(event_data['sophomore_count']);
                        $event_div.find('.junior_count').text(event_data['junior_count']);
                        $event_div.find('.senior_count').text(event_data['senior_count']);
                        $event_div.find('.graduate_count').text(event_data['graduate_count']);
                    }else{
                        //If no users went to this event, hide the female/male box and the "presented attendances" section
                        $event_div.find('.gender_percent_div').hide();
                        $event_div.find('.attendees_header').hide();
                    }




                    $('#events').append($event_div);

                });

            });
        });

    }


var member_attendance_data = null;
$.getScript('js/getURLPara.js', function(){
    var group_id = '';
    if ($.getUrlVar("group_id") != null) {
        group_id = $.getUrlVar("group_id").toString();
    }
    $.getJSON("php/analytics/club_member_data.php", { group_id: group_id}, function(json_data) {
        member_attendance_data = json_data;
        show_member_attendance();
    });
});


    function show_member_attendance(){

        var current_sort_option = $('#current_members_filter').text();
        console.log("Current sorting option is " + current_sort_option);

        $('#members').empty();
        //Sort the users list based on actively selected sort option
        if(current_sort_option == 'Most Active Members'){
            member_attendance_data['users'] = member_attendance_data['users'].sort(sort_key('attendance_count'))
        }else if(current_sort_option == 'Least Active Members'){
            member_attendance_data['users'] = (member_attendance_data['users'].sort(sort_key('attendance_count'))).reverse();
        }else if(current_sort_option == 'Newest Members'){
            member_attendance_data['users'] = member_attendance_data['users'].sort(sort_key('join_time'))
        }else if(current_sort_option == 'Oldest Members'){
            member_attendance_data['users'] = (member_attendance_data['users'].sort(sort_key('join_time'))).reverse();
        }


        $.each( member_attendance_data['users'], function( index, user_data) {
//            var $user = $('<tr class="user"></tr>');
//            $('<td class="id">' + user_json['user_id'] +'</td>').appendTo($user);
//            $('<td class="name">' + user_json['name'] +'</td>').appendTo($user);
//            $('<td class="joined_datetime">' + user_json['joined_datetime'] +'</td>').appendTo($user);
//            $group.append($user);


            var $user_div = $("\
            <div class='am_cell member' data-user_id='" + user_data['id'] + "'> \
                <div class='am_cell_left'> \
                    <div class='am_cell_left_photo' style='background-image: url(<?php echo Yii::app()->getBaseUrl(true); ?>/assets/dummy_1.jpg)'></div> \
                    <div class='am_cell_left_name'>" + user_data['name'] + "</div> \
                </div> \
                <div class='am_cell_mid_0'>" + user_data['attendance_count'].toString() + "</div> \
                <div class='am_cell_mid_1'>" + user_data['attendance_percent_str'] + "</div> \
                <div class='am_cell_right'> \
                    <div class='cell_right_tags_wrap tags'></div> \
                    <input class='cell_right_input' type='text' placeholder='add a tag' maxlength='11'> \
                </div> \
                <button class='plus_button'></button> \
            </div>");

            $.each( user_data['tags'], function( index, tag) {
                $user_div.find('.tags').append($("<div class='cell_right_a_tag'>" + tag + "</div>"));
            });

            $('#members').append($user_div);

        });
    }

    function sort_key(key,desc) {
        return function(a,b){
            return desc ? ~~(a[key] < b[key]) : ~~(a[key] > b[key]);
        }
    }




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

