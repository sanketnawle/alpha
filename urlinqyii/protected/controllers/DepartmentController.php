<?php

class DepartmentController extends Controller
{
	public function actionView()
	{

        $department_id = $_GET['id'];

        $department = Department::model()->findBySql("SELECT * FROM `department` WHERE `department_id` = " . $department_id);


        $user = $this->get_current_user();



        $is_admin = false;
        if(strpos($user->user_email,'@urlinq.com') !== false){
            $is_admin = true;
        }

        $is_following = false;


		$this->render('department',array('department'=>$department,'user'=>$user,'is_following'=>$is_following, 'is_admin'=>$is_admin));
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

        //Loop through the courses and get the member count


        $data = array('success'=>true, 'courses'=> $department_data['courses']);
        $this->renderJSON($data);
        return;

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