<?php

class DepartmentController extends Controller
{
	public function actionView()
	{

        $department_id = $_GET['id'];

        $department = Department::model()->findBySql("SELECT * FROM `department` WHERE `department_id` = " . $department_id);


        $user = $this->get_current_user();



        $is_admin = false;
        if($this->is_urlinq_admin($user)){
            $is_admin = true;
        }

        $is_following = DepartmentFollow::model()->exists('user_id =:uid and department_id = :did'
            ,array(':uid'=>$this->get_current_user_id(),':did'=>$department->department_id));

        $own_department = $user->department_id === $department->department_id;




		$this->render('department',array('department'=>$department,'user'=>$user,'is_following'=>$is_following, 'is_admin'=>$is_admin, 'own_department'=>$own_department));
	}



    public function actionTest(){


        $data = array('msg'=>'this data is from the department controller');
        $this->renderJSON($data);
    }


    public function actionGetCourses(){
        if(!isset($_GET['department_id'])){
            $data = array('success'=>false,'error_id'=>1, 'error_msg'=> 'department id not set');
            $this->renderJSON($data);
            return;
        }


        $department_id = $_GET['department_id'];

        $department = Department::model()->find('department_id=:id',array(':id'=>$department_id));

        if(!$department){
            $data = array('success'=>false,'error_id'=>2, 'error_msg'=> 'department doesnt exist');
            $this->renderJSON($data);
            return;
        }

        $department_data = $this->get_model_associations($department,array('courses'=>array('classes'=>array('pictureFile','professor'),'pictureFile'=>array(), 'department'=>array())));

        if(sizeof($department_data['courses'])<10){
            //$school = School::model()->find('school_id=:id',array(':id'=>$department->school_id));


            $criteria = new CDbCriteria;
            $criteria->condition = 'school_id=:sid and department_id!=:did';
            $criteria->limit = 15;
            $criteria->order = 'rand()';
            $criteria->params = array(':sid' => $department->school_id,':did'=>$department->department_id);

            $courses = Course::model()->findAll($criteria);
            foreach($courses as $i=>$course){
                $courses[$i] = $this->get_model_associations($course,array('classes'=>array('pictureFile','professor'),'pictureFile'=>array(), 'department'=>array()));
            }
            $courses = array_merge($department_data['courses'],$courses);
            if(sizeof($courses)<10){
                $criteria = new CDbCriteria;
                $criteria->condition = 'school_id!=:sid';
                $criteria->limit = 15;
                $criteria->order = 'rand()';
                $criteria->params = array(':sid' => $department->school_id);

                $school_courses = Course::model()->findAll($criteria);
                foreach($school_courses as $i=>$course){
                    $school_courses[$i] = $this->get_model_associations($course,array('classes'=>array('pictureFile','professor'),'pictureFile'=>array(), 'department'=>array()));
                }
                $courses = array_merge($courses,$school_courses);

            }
        }else{
            $courses = $department_data['courses'];
        }
        //Loop through the courses and get the member count


        $data = array('success'=>true, 'courses'=> $courses);
        $this->renderJSON($data);
        return;

    }

    public function actionJoin(){
        include_once "color/color.php";

        if(!isset($_POST['id'])){
            $data = array('success'=>false,'error_id'=>1, 'error_msg'=>'required data not set');
            $this->renderJSON($data);
            return;
        }

        $user_id = null;
        if(isset($_POST['user_id'])){
            $user_id = $_POST['user_id'];
        }else {
            $user_id = $this->get_current_user_id();
        }

        $department_id = $_POST['id'];
        $department_follow = DepartmentFollow::model()->find('department_id=:id and user_id=:user_id', array(':id'=>$department_id,':user_id'=>$user_id));

        $user = User::model()->find('user_id=:id',array(':id'=>$user_id));
        //Check if this user is already following this department
        if(!$department_follow){
            $department = Department::model()->find('department_id=:id',array(':id'=>$department_id));



            //Create new department follow
            $department_follow = new DepartmentFollow;
            $department_follow->department_id = $department_id;
            $department_follow->user_id = $user_id;
            $department_follow->color_id = get_random_color();
            //If we save successfully, user is now following this department
            if($department_follow->save(false)){
               /* foreach($department->events as $event){
                    $already_attending =  EventUser::model()->exists('event_id=:eid and user_id=:uid',array(':eid'=>$event->event_id,':uid'=>$user_id));
                    $event_creator = DepartmentFollow::model()->find('department_id=:dept_id and user_id=:user_id',array(':dept_id'=>$department->department_id
                    ,':user_id'=>$event->user_id));
                    //add all club events from admins (or anyone if no admis) to user's events
                    if(!$already_attending){

                        $event_user = new EventUser();
                        $event_user->user_id = $user_id;
                        $event_user->event_id = $event->event_id;
                        $event_user->color_id = get_random_color();
                        $event_user->save();
                    }
                }*/
                $data = array('success'=>true);
                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false,'error_id'=>3, 'error_msg'=>'error saving department_follow table');
                $this->renderJSON($data);
                return;
            }
        }else{
            //user is apart of this department
            $data = array('success'=>false,'error_id'=>2, 'error_msg'=>'user already following this department');
            $this->renderJSON($data);
            return;
        }


    }

    public function actionLeave(){
        if(!isset($_POST['id'])){
            $data = array('success'=>false,'error_id'=>1, 'error_msg'=>'required data not set');
            $this->renderJSON($data);
            return;
        }

        $user = $this->get_current_user($_POST);
        if(!$user){
            $data = array('success'=>false,'error_id'=>1, 'error_msg'=>'user not logged in');
            $this->renderJSON($data);
            return;
        }

        $user_id = $user->user_id;

        $department_id = $_POST['id'];
        $department_follow = DepartmentFollow::model()->find('department_id=:id and user_id=:user_id', array(':id'=>$department_id,':user_id'=>$user_id));
        //Check if this user is even in this class
        if($department_follow){
            //Check if we destroy this shit successfully
            if($department_follow->delete()){

                //Loop through all events this user has for this class and delete them
                //Or else the database will get fucked up
                $user_events = Event::model()->findAllBySql("SELECT * FROM `event` JOIN `event_user` ON (event.event_id = event_user.event_id) WHERE event_user.user_id = " . $user->user_id . " AND event.origin_type = 'department' AND event.origin_id = " . $department_id);

                //Get the events that this
                $events = Event::model()->findAllBySql("SELECT * FROM `event` WHERE event.user_id = " . $user->user_id . " AND event.origin_type = 'department' AND event.origin_id = " . $department_id);

                $all_events = array_merge($events,$user_events);
                foreach($all_events as $event){
                    $event->delete();
                }

                //We also need to delete all posts that have the type event from this user in this group
                $posts = Post::model()->findAllBySql('SELECT * FROM `post` WHERE post_type = "event" AND  origin_type = "department" AND origin_id = ' . $department_id);
                foreach($posts as $post){
                    $post->delete();
                }



                $data = array('success'=>true);
                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false,'error_id'=>3, 'error_msg'=>'error deleting department_follow table');
                $this->renderJSON($data);
                return;
            }
        }else{
            //user is not apart of this class
            $data = array('success'=>false,'error_id'=>2, 'error_msg'=>'user not following this department');
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

?>