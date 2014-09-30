<?php

class ProfileController extends Controller
{


    //public $layout='//layouts/main';


	public function actionIndex(){
		$this->render('index');
	}




    //http://localhost/urlinqyii/profile/1
    public function actionView()
    {
        $user_id = $_GET['id'];
        $user = User::model()->find('user_id=:id', array(':id'=>$user_id));


        $this->render('profile',array('user'=>$user));
    }


}