<?php

class DepartmentController extends Controller
{
	public function actionView()
	{

        $department_id = $_GET['id'];

        $department = Department::model()->findBySql("SELECT * FROM `department` WHERE `department_id` = " . $department_id);


        $user = $this->get_current_user();



        $is_following = false;


		$this->render('department',array('department'=>$department,'user'=>$user,'is_following'=>$is_following));
	}



    public function actionTest(){


        $data = array('msg'=>'this data is from the department controller');
        $this->renderJSON($data);
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