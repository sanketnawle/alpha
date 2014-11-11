<?php

class EventController extends Controller
{


    public function actionGetPlannerEvents(){
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