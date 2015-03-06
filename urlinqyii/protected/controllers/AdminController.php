<?php

class AdminController extends Controller
{
	public function actionGeneratePassword()
	{
        #hashes new password

        if(!isset($_POST['password'])){
            $data = array('success'=>false, 'error_id'=>1, 'error_msg'=>'The valid data is not set.');
            $this->renderJSON($data);
            return;
        }



        $user = $this->get_current_user();
        if(!$user){
            $data = array('success'=>false, 'error_id'=>'user is not authenticated');
            $this->renderJSON($data);
            return;
        }


        if(!$this->is_urlinq_admin($user)){
            $data = array('success'=>false, 'error_id'=>'user is not authenticated');
            $this->renderJSON($data);
            return;
        }

        $password = $_POST['password'];
        include "password_encryption.php";

        $salt = salt();
        $hashed_password = hash_password($password,$salt);


        $data = array('success'=>true, 'hashed_password'=>$hashed_password, 'salt'=>$salt);
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