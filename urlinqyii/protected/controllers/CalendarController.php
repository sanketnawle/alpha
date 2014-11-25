<?php

class CalendarController extends Controller
{
	public function actionView()
	{
		$this->render('index');
	}

//
//<?php
//    function stt($obj) {
//        return strtotime($obj);
//    }
//$weekdays = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
//
//if(!isset($_REQUEST["date"])) die("{}");
//
//$return_arr = Array();
//
//$conn = mysqli_connect("localhost", "root", "root", "urlinq_new");
//$query = "SELECT * FROM event LEFT OUTER JOIN event_repeat using(event_id)";
//$result = mysqli_query($conn, $query);
//
//while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
//array_push($return_arr,$row);
//}
//
//$json = json_decode(json_encode($return_arr));
//
////echo "<pre>";
////echo json_encode($json, JSON_PRETTY_PRINT);
//
////die;
//
//$givendate = stt(isset($_REQUEST["date"]) ? date("Y-m-d", stt($_REQUEST["date"])) : date("Y-m-d"));
//
//$json = array_filter($json, function($obj) {
//    global $givendate;
//    global $weekdays;
//
//    $state = stt($obj->start_date) == $givendate && stt($obj->repeat_type) == NULL; // single day
//    if(!$state) $state = ( // multi day
//        $obj->repeat_type == NULL && (
//            $givendate >= stt($obj->start_date) &&
//            $givendate <= stt($obj->end_date)
//        )
//    );
//    if(!$state) $state = ( // daily
//        $obj->repeat_type == "daily" && (
//            $givendate >= stt($obj->start_date) &&
//            $givendate <= stt($obj->repeat_end_date)
//        )
//    );
//    if(!$state) $state = ( // weekly
//        $obj->repeat_type == "weekly" && (
//            $givendate <= stt($obj->repeat_end_date) &&
//            (
//                date("w", stt($obj->start_date)) == date("w", $givendate) || // weekly single day
//                (
//                    date("w", stt($obj->start_date)) < date("w", $givendate) && // weekly multi day same week
//                    (
//                        date("w", $givendate) <= date("w", stt($obj->end_date)) || // weekly multi day cross week
//                        (
//                            date("w", stt($obj->start_date)) > date("w", stt($obj->end_date)) &&
//                            date("w", $givendate) <= (date("w", stt($obj->end_date)) + 7)
//                        )
//                    )
//                )
//            )
//        )
//    );
//    if(!$state) $state = ( // monthly on date
//        $obj->repeat_type == "monthlydate" && (
//            $givendate <= stt($obj->repeat_end_date) &&
//            date("d", stt($obj->start_date)) <= date("d", $givendate) &&
//            date("d", stt($obj->end_date)) >= date("d", $givendate)
//        )
//    );
//    if(!$state) { // monthly on week
//        $week = date("w", stt($obj->start_date));
//        $target = $weekdays[$week];
//
//        $sd = stt($obj->start_date);
//        $diff = stt($obj->end_date) - stt($obj->start_date);
//
//        $state = (
//            $obj->repeat_type == "monthlyweek" && (
//                $givendate <= stt($obj->repeat_end_date) && (
//                TRUE
//                )
//            )
//        );
//    }
//
//    return $state;
//});
//
//usort($json, function($a, $b) {
//    return stt($a->start_time) - stt($b->start_time);
//});
//
//echo json_encode($json, JSON_PRETTY_PRINT);
//




	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}