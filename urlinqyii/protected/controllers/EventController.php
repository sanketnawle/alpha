<?php

class EventController extends Controller
{


    public function actionGetEvents(){
        $user = $this->get_current_user();
        $date = '2014-11-12';
        //$date = $_GET['date'];
        //user_id=:user_id AND  //':user_id'=>1,
        $events = Event::model()->findAll('start_date=:start_date and user_id=:user_id',array('start_date'=>$date,':user_id'=>7));




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
        $user = $this->get_current_user();


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
//        $data = array('success'=>true,'past_due_events'=>$past_due_events,'todays_events'=>$todays_events,'tomorrows_events'=>$tomorrows_events,'event_count'=>$event_count);
        $data = array('success'=>true,'event'=>$this->get_model_associations($club,array('pictureFile')));


        $this->renderJSON($data);
        return;



        //Or get all events from yesterday till tomorrow and have front end sort it



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