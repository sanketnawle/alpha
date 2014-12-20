<?php

class EventController extends Controller
{
    function stt($obj) {
        return strtotime($obj);
    }

    public function actionGetEvents(){
        $user = $this->get_current_user();
//        $date = '2014-11-12';
        $date = $_GET['date'];
        //user_id=:user_id AND  //':user_id'=>1,
        $events = Event::model()->findAll('start_date<=:date and end_date>=:date and user_id=:user_id',array(':date'=>$date,':user_id'=>7));


//            $weekdays = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
//
//            if(!isset($_REQUEST["date"])) die("{}");
//
//            $return_arr = Array();
//
//            $conn = mysqli_connect("localhost", "root", "root", "urlinq_new");
//            $query = "SELECT * FROM event LEFT OUTER JOIN event_repeat using(event_id)";
//            $result = mysqli_query($conn, $query);
//
//            while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
//                array_push($return_arr,$row);
//            }
//
//            $json = json_decode(json_encode($return_arr));
//
//            //echo "<pre>";
//            //echo json_encode($json, JSON_PRETTY_PRINT);
//
//            //die;
//
//            $givendate = stt(isset($_REQUEST["date"]) ? date("Y-m-d", stt($_REQUEST["date"])) : date("Y-m-d"));
//
//            $json = array_filter($json, function($obj) {
//                global $givendate;
//                global $weekdays;
//
//                $state = stt($obj->start_date) == $givendate && stt($obj->repeat_type) == NULL; // single day
//                if(!$state) $state = ( // multi day
//                    $obj->repeat_type == NULL && (
//                        $givendate >= stt($obj->start_date) &&
//                        $givendate <= stt($obj->end_date)
//                    )
//                );
//                if(!$state) $state = ( // daily
//                    $obj->repeat_type == "daily" && (
//                        $givendate >= stt($obj->start_date) &&
//                        $givendate <= stt($obj->repeat_end_date)
//                    )
//                );
//                if(!$state) $state = ( // weekly
//                    $obj->repeat_type == "weekly" && (
//                        $givendate <= stt($obj->repeat_end_date) &&
//                        (
//                            date("w", stt($obj->start_date)) == date("w", $givendate) || // weekly single day
//                            (
//                                date("w", stt($obj->start_date)) < date("w", $givendate) && // weekly multi day same week
//                                (
//                                    date("w", $givendate) <= date("w", stt($obj->end_date)) || // weekly multi day cross week
//                                    (
//                                        date("w", stt($obj->start_date)) > date("w", stt($obj->end_date)) &&
//                                        date("w", $givendate) <= (date("w", stt($obj->end_date)) + 7)
//                                    )
//                                )
//                            )
//                        )
//                    )
//                );
//                if(!$state) $state = ( // monthly on date
//                    $obj->repeat_type == "monthlydate" && (
//                        $givendate <= stt($obj->repeat_end_date) &&
//                        date("d", stt($obj->start_date)) <= date("d", $givendate) &&
//                        date("d", stt($obj->end_date)) >= date("d", $givendate)
//                    )
//                );
//                if(!$state) { // monthly on week
//                    $week = date("w", stt($obj->start_date));
//                    $target = $weekdays[$week];
//
//                    $sd = stt($obj->start_date);
//                    $diff = stt($obj->end_date) - stt($obj->start_date);
//
//                    $state = (
//                        $obj->repeat_type == "monthlyweek" && (
//                            $givendate <= stt($obj->repeat_end_date) && (
//                            TRUE
//                            )
//                        )
//                    );
//                }
//
//                return $state;
//            });
//
//            usort($json, function($a, $b) {
//                return stt($a->start_time) - stt($b->start_time);
//            });
//
//            echo json_encode($json, JSON_PRETTY_PRINT);



        $data = array('success'=>true,'events'=>$events);



        $this->renderJSON($data);
        return;

    }


    public function actionAttendees(){
        //$user = $this->get_current_user();
        $event_id = $_GET['id'];
        //$date = $_GET['date'];
        //user_id=:user_id AND  //':user_id'=>1,
        $event = Event::model()->find('event_id=:event_id',array('event_id'=>$event_id));

        //$attendees = $event->attendees;


        //$data = array('success'=>true,'attendees'=>$attendees);

        $data = array('success'=>true,'attendees'=>$event->attendees);

        $this->renderJSON($data);
        return;

    }



    public function actionGetPlannerEvents(){
        //$user_id = $_GET['user_id'];
        $user = $this->get_current_user();
//        $user = User::model()->findBySql('SELECT * FROM `user` WHERE user_id=.'$user_id');

//        $events = Event::model()->findAll('user_id=:user_id',array(':user_id'=>$user->user_id));


//        $sql_str = '';
//        if (strpos($filter, 'Week') !== FALSE){
//            $sql_str = "SELECT * FROM group_event WHERE group_id = '$group_id' AND yearweek(`start_date`) = yearweek(curdate())";
//        }elseif(strpos($filter, 'Month') !== FALSE){
//            $sql_str = "SELECT * FROM group_event WHERE group_id = '$group_id' AND MONTH(`start_date`) = MONTH(curdate())";
//        }elseif(strpos($filter, 'Semester') !== FALSE){
//            $sql_str = "SELECT * FROM group_event WHERE group_id = '$group_id' AND YEAR(`start_date`) = YEAR(curdate())";
//        }



        //get current datetime
//        $date = date("Y-m-d H:i:s", time());
//        $datetime = new DateTime($date);
//        $datetime->modify('-1 day');
//        $date = $datetime->format('Y-m-d H:i:s');
//        $date_key = $datetime->format('Y-m-d');

        $event_count = 0;

        //Get events that were due yesterday
        $date = date("Y-m-d H:i:s", time());
        $datetime = new DateTime($date);
        $datetime->modify('-1 day');
        $yesterdays_date = $datetime->format('Y-m-d');


        $sql = "SELECT * FROM event WHERE user_id = '" . $user->user_id ."' AND end_date = '" . $yesterdays_date . "'"; // AND YEAR(`start_date`) = YEAR(curdate())
        $past_due_events = Event::model()->findAllBySql($sql);
        $event_count += count($past_due_events);

        //Get events that are due today

        $datetime = new DateTime($date);
        $todays_date = $datetime->format('Y-m-d');

        $sql = "SELECT * FROM event WHERE user_id = '" . $user->user_id ."' AND end_date = '" . $todays_date . "'"; // AND YEAR(`start_date`) = YEAR(curdate())
        $todays_events = Event::model()->findAllBySql($sql);
        $event_count += count($todays_events);


        //Get events that are due tomorrow

        $datetime = new DateTime($date);
        $datetime->modify('+1 day');
        $tomorrows_date = $datetime->format('Y-m-d');

        $sql = "SELECT * FROM event WHERE user_id = '" . $user->user_id ."' AND end_date = '" . $tomorrows_date . "'"; // AND YEAR(`start_date`) = YEAR(curdate())
        $tomorrows_events = Event::model()->findAllBySql($sql);
        $event_count += count($tomorrows_events);

        $club = Group::model()->find('group_id=:group_id',array(':group_id'=>1));
        $data = array('success'=>true,'past_due_events'=>$past_due_events,'todays_events'=>$todays_events,'tomorrows_events'=>$tomorrows_events,'event_count'=>$event_count);
        //$data = array('success'=>true,'event'=>$this->get_model_associations($club,array('pictureFile')));


        //Show 7 days after tomorrow

        $this->renderJSON($data);
        return;



        //Or get all events from yesterday till tomorrow and have front end sort it



    }




    public function actionGetSuggestedEvents(){
        $events = Event::model()->findAll();

        $data = array('success'=>true,'events'=>$events);
        $this->renderJSON($data);
        return;
    }

    //Error ids
    // 1 - All data not set
    // 2 - error creating todo
	public function actionCreateTodo()
	{

        if(!isset($_POST['todo_name']) || !isset($_POST['todo_date']) || !isset($_POST['todo_time']) || !isset($_POST['origin']) || !isset($_POST['origin_id'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'All data is not set');
            $this->renderJSON($data);
            return;
        }



        try {



            $user = $this->get_current_user();

            $todo_name = $_POST['todo_name'];
            $todo_date = $_POST['todo_date'];
            $todo_time = $_POST['todo_time'];
            $todo_origin = $_POST['origin'];
            $todo_origin_id = $_POST['origin_id'];

            $event = new Event;
            $event->title = $todo_name;
            $event->event_type = 'todo';
            $event->user_id = $user->user_id;

            $event->origin_type = $todo_origin;
            $event->origin_id = $todo_origin_id;
            $event->end_date = $todo_date;
            $event->end_time = $todo_time;
            $event->save(false);

            if($event){
                $data = array('success'=>true,'event'=>$event);
                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false,'error_id'=>2,'error_msg'=>'Error creating todo');
                $this->renderJSON($data);
                return;
            }
        }catch(Exception $e){
            $data = array('success'=>false,'error_id'=>3,'error_msg'=>$e->getMessage());
            $this->renderJSON($data);
            return;
        }
	}



    //Error ids
    // 1 - All data not set
    // 2 - error creating todo
    public function actionCreate()
    {
//        $data = array('success'=>true);
//        $this->renderJSON($_POST);
//        return;

//        var post_data = {
//        event:{
//            event_name: 'Test event',
//                origin_type:' club',
//                origin_id: 1,
//                title: 'Test Event',
//                description: 'This is my test event description',
//                start_time: '10:10:10',
//                end_time: '11:11:11',
//                start_date: '2014-12-01',
//                end_date: '2014-12-01',
//                location: 'Manhattan'
//            }
//        };


        if(!isset($_POST['event']['event_name']) || !isset($_POST['event']['event_type']) || !isset($_POST['event']['origin_type']) || !isset($_POST['event']['origin_id']) || !isset($_POST['event']['title']) || !isset($_POST['event']['description'])
        || !isset($_POST['event']['start_time']) || !isset($_POST['event']['end_time']) || !isset($_POST['event']['start_date']) || !isset($_POST['event']['end_date']) || !isset($_POST['event']['location'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'All data is not set');
            $this->renderJSON($data);
            return;
        }

        $event_data = $_POST['event'];


        try {


            $event = new Event;
            $event->title = $event_data['event_name'];
            $event->description = $event_data['description'];
            $event->event_type = $event_data['event_type'];
            $event->user_id = $this->get_current_user_id();
            $event->origin_type = $event_data['origin_type'];
            $event->origin_id = $event_data['origin_id'];
            $event->start_date = $event_data['start_date'];
            $event->end_date = $event_data['end_date'];
            $event->start_time = $event_data['start_time'];
            $event->end_time = $event_data['end_time'];
            $event->location = $event_data['location'];

            $event->save(false);

            if($event){
                $data = array('success'=>true,'event'=>$event);
                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false,'error_id'=>2,'error_msg'=>'Error creating todo');
                $this->renderJSON($data);
                return;
            }
        }catch(Exception $e){
            $data = array('success'=>false,'error_id'=>3,'error_msg'=>$e->getMessage());
            $this->renderJSON($data);
            return;
        }
    }



    public function actionCheck(){
        if(!isset($_POST['event_id'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'id not set');
            $this->renderJSON($data);
            return;
        }



        $event_id = $_POST['event_id'];

        $event = Event::model()->find('event_id=:id', array(':id'=>$event_id));
        if($event){
            $event->complete = true;
            $event->save(false);

            $data = array('success'=>true);
            $this->renderJSON($data);
            return;
        }else{
            $data = array('success'=>false,'error_id'=>2,'error_msg'=>'Event doesnt exist');
            $this->renderJSON($data);
            return;
        }
    }

    public function actionUncheck(){
        if(!isset($_POST['event_id'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'id not set');
            $this->renderJSON($data);
            return;
        }



        $event_id = $_POST['event_id'];

        $event = Event::model()->find('event_id=:id', array(':id'=>$event_id));
        if($event){
            $event->complete = false;
            $event->save(false);

            $data = array('success'=>true);
            $this->renderJSON($data);
            return;
        }else{
            $data = array('success'=>false,'error_id'=>2,'error_msg'=>'Event doesnt exist');
            $this->renderJSON($data);
            return;
        }

    }

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