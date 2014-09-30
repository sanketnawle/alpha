<?php

class ClubController extends Controller
{
	public function actionView()
	{
        $club_id = $_GET['id'];
        $club = Group::model()->find('group_id=:id', array(':id'=>$club_id));

        $user = User::model()->find('user_id=:id', array(':id'=>1));


        $this->render('club',array('club'=>$club,'user'=>$user));
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