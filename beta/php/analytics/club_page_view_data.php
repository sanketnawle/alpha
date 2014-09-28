<?php



define('ga_email','urlinq5@gmail.com');
define('ga_password','Daisy@619');
define('ga_profile_id','78486849');

require 'gapi.class.php';

$ga = new gapi(ga_email,ga_password);



if (isset($_GET['group_id']) && isset($_GET['filter'])) {
    require_once '../../includes/common_functions.php';
    require_once '../dbconnection.php';

    $group_id = $_GET['group_id'];
    $filter = $_GET['filter'];


    //$json_data_array = array('total_page_views' => 0,'new_page_views' => 0);
//    $json_data_array = array('total_page_views' => 0,'new_this_week' => 0,'new_this_month' => 0,'new_this_year' => 0);
//    $json_data_array['total_page_views'] = get_all_views($group_id);
//
//    if (strpos($filter, 'Week') !== FALSE){
//        $json_data_array['new_page_views'] = get_this_week_views($group_id);
//    }elseif(strpos($filter, 'Month') !== FALSE){
//        $json_data_array['new_page_views'] = get_this_month_views($group_id);
//    }elseif(strpos($filter, 'Semester') !== FALSE){
//        $json_data_array['new_page_views'] = get_this_year_views($group_id);
//    }


    $json_data_array = array('total_page_views' => 0,'new_page_views' => 0);
    $json_data_array['total_page_views'] = get_all_views($group_id);

    if (strpos($filter, 'Week') !== FALSE){
        $json_data_array['new_page_views'] = get_this_week_views($group_id);
    }elseif(strpos($filter, 'Month') !== FALSE){
        $json_data_array['new_page_views'] = get_this_month_views($group_id);
    }elseif(strpos($filter, 'Semester') !== FALSE){
        $json_data_array['new_page_views'] = get_this_year_views($group_id);
    }





    //get_user_views('2');
    //get_unqiue_visitors_count();

//    $json_data_array['new_this_week'] = get_this_week_views($group_id);
//    $json_data_array['new_this_month'] = get_this_month_views($group_id);
//    $json_data_array['new_this_year'] = get_this_year_views($group_id);
    //get_last_month_views();


    echo json_encode($json_data_array);
}


//function get_all_views(){
//    global $ga;
//    $results = $ga->requestReportData(ga_profile_id,array('source'),array('pageviews'));
//    //echo $results[0]->getPageviews();
//    if(count($results) > 0){
//        return $results[0]->getPageviews();
//    }else{
//        return null;
//    }
//}

function get_all_views($group_id){
    global $ga;
    $filter = 'ga:dimension2 == ' . $group_id;
    $results = $ga->requestReportData(ga_profile_id,array('dimension2'),array('pageviews'),null,$filter);

    if(count($results) > 0){
        return $results[0]->getPageviews();
    }else{
        return 0;
    }
}

function get_this_week_views($group_id){
    global $ga;
    $start_week = strtotime("last sunday midnight");
    $end_week = strtotime("today");

    $start_week_str = date("Y-m-d",$start_week);
    $end_week_str = date("Y-m-d",$end_week);

    $filter = 'ga:dimension2 == ' . $group_id;
    $results = $ga->requestReportData(ga_profile_id,array('dimension1'),array('pageviews'),null,$filter,$start_week_str,$end_week_str);

    if(count($results) > 0){
        return $results[0]->getPageviews();
    }else{
        return 0;
    }
}

function get_last_week_views(){
    global $ga;
    $end_week = strtotime("last sunday midnight");
    $start_week = strtotime("-1 week",$end_week);
    $end_week_str = date("Y-m-d",$end_week);
    $start_week_str = date("Y-m-d",$start_week);
    // echo $start_week;
    // echo $end_week;
    $results = $ga->requestReportData(ga_profile_id,array('source'),array('pageviews'),null,null,$start_week_str, $end_week_str);
    var_dump($results);
    if(count($results) > 0){
        return $results[0]->getPageviews();
    }else{
        return 0;
    }
}

function get_this_month_views($group_id){
    global $ga;
    //Gets the first of this month
    $start_month = strtotime(date('01-m-Y'));
    $end_month = strtotime('today');

    $start_month_str = date("Y-m-d",$start_month);
    $end_month_str = date("Y-m-d",$end_month);

    $filter = 'ga:dimension2 == ' . $group_id;
    $results = $ga->requestReportData(ga_profile_id,array('source'),array('pageviews'),null,$filter,$start_month_str, $end_month_str);
    if(count($results) > 0){
        return $results[0]->getPageviews();
    }else{
        return 0;
    }

}


function get_last_month_views(){
    global $ga;
    //Gets the first of this month
    $end_week = strtotime(date('01-m-Y'));
    $start_week = strtotime("-1 month",$end_week);
    $end_week_str = date("Y-m-d",$end_week);
    $start_week_str = date("Y-m-d",$start_week);
    // echo $start_week;
    // echo $end_week;
    $results = $ga->requestReportData(ga_profile_id,array('source'),array('pageviews'),null,null,$start_week_str, $end_week_str);
    if(count($results) > 0){
        return $results[0]->getPageviews();
    }else{
        return 0;
    }

}


function get_this_year_views($group_id){
    global $ga;
    //Gets the first of this month
    $start_year = strtotime(date('01-01-Y'));
    $end_year = strtotime('today');

    $start_year_str = date("Y-m-d",$start_year);
    $end_year_str = date("Y-m-d",$end_year);

    $filter = 'ga:dimension2 == ' . $group_id;
    $results = $ga->requestReportData(ga_profile_id,array('source'),array('pageviews'),null,$filter,$start_year_str, $end_year_str);
    if(count($results) > 0){
        return $results[0]->getPageviews();
    }else{
        return 0;
    }

}


function get_unqiue_visitors_count(){
    global $ga;
    $results = $ga->requestReportData(ga_profile_id,array('source'),array('pageviews','visitors'));
    var_dump($results);
    echo $results[0]->getVisitors();
    return $results[0]->getVisitors();
}



//Pass in user table id
//Filters by dimension "User Id"
function get_user_views($userid){
    global $ga;
    $filter = 'ga:dimension1 == ' . $userid;
    $results = $ga->requestReportData(ga_profile_id,array('dimension1'),array('pageviews'),null,$filter);
    if(count($results) > 0){
        return $results[0]->getPageviews();
    }else{
        return 0;
    }
}












?>