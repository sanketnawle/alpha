<?php





function get_all_views($ga,$group_id){
//    global $ga;
    $filter = 'ga:dimension2 == ' . $group_id;
    $results = $ga->requestReportData(ga_profile_id,array('dimension2'),array('pageviews'),null,$filter);

    if(count($results) > 0){
        return $results[0]->getPageviews();
    }else{
        return 0;
    }
}

function get_this_week_views($ga,$group_id){
    //global $ga;
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

function get_last_week_views($ga){
    //global $ga;
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

function get_this_month_views($ga,$group_id){
    //global $ga;
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


function get_last_month_views($ga){
    //global $ga;
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


function get_this_year_views($ga,$group_id){
    //global $ga;
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


function get_unqiue_visitors_count($ga){
    //global $ga;
    $results = $ga->requestReportData(ga_profile_id,array('source'),array('pageviews','visitors'));
    var_dump($results);
    echo $results[0]->getVisitors();
    return $results[0]->getVisitors();
}



//Pass in user table id
//Filters by dimension "User Id"
function get_user_views($ga,$userid){
    //global $ga;
    $filter = 'ga:dimension1 == ' . $userid;
    $results = $ga->requestReportData(ga_profile_id,array('dimension1'),array('pageviews'),null,$filter);
    if(count($results) > 0){
        return $results[0]->getPageviews();
    }else{
        return 0;
    }
}




?>