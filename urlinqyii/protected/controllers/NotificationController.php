<?php

class NotificationController extends Controller
{
	public function actionDelete()
	{


        if(!isset($_POST['notification_id'])){
            $return_data = array('success'=>false, 'error_id'=>1, 'error_msg'=>'data is not set');
            $this->renderJSON($return_data);
            return;
        }


        $user = $this->get_current_user($_POST);


        if(!$user){
            $return_data = array('success'=>false, 'error_id'=>1, 'error_msg'=>'data is not set');
            $this->renderJSON($return_data);
            return;
        }








        $notification_id = $_POST['notification_id'];

        $notification = Notification::model()->find('notification_id=:notification_id', array(':notification_id'=>$notification_id));

        if(!$notification){
            $return_data = array('success'=>false, 'error_id'=>2, 'error_msg'=>'notification doesnt exist with id: ' . $notification_id);
            $this->renderJSON($return_data);
            return;
        }


        if($notification->user_id != $user->user_id){
            $return_data = array('success'=>false, 'error_id'=>3, 'error_msg'=>'This user cant delete this notification.');
            $this->renderJSON($return_data);
            return;
        }


        $notification->delete();

        $return_data = array('success'=>true);
        $this->renderJSON($return_data);
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