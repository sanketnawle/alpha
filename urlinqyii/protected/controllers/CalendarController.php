<?php

class CalendarController extends Controller
{
	public function actionView()
	{

        $user = $this->get_current_user();

        if(!$user){
            $this->renderJSON(array('success'=>false));
            return;
        }




		$this->render('index',array('user'=>$user));
	}



	public function actiongooglecalendar()
	{
		$this->render('googlecalendar');
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