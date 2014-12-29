<?php

class UserController extends Controller
{
	public function actionView()
	{
		$this->render('view');
	}




    public function actionFollow()
    {
        if(!isset($_POST['user_id'])){
            $data = array('success'=>false,'error_id'=>1);
            $this->renderJSON($data);
            return;
        }

        $current_user_id = $this->get_current_user_id();
        $follow_user_id = $_POST['user_id'];

        $user_connection = UserConnection::model()->findBySql("SELECT * FROM `user_connection` WHERE `from_user_id`='$current_user_id' AND `to_user_id`='$follow_user_id'");

        if(!$user_connection){
            $user_connection = new UserConnection;
            $user_connection->from_user_id = $current_user_id;
            $user_connection->to_user_id = $follow_user_id;
            $user_connection->save(false);

            //If we successfully create the userconnection, return true
            if($user_connection){
                $data = array('success'=>true);
                $this->renderJSON($data);
                return;
            }else{
                //Error creating user connection
                $data = array('success'=>false,'error_id'=>3,'error_msg'=>'error creation user connection');
                $this->renderJSON($data);
                return;
            }

        }else{
            //Connection already exists
            $data = array('success'=>false,'error_id'=>2,'error_msg'=>'user connection already exists');
            $this->renderJSON($data);
            return;
        }


    }

    public function actionUnfollow()
    {
        if(!isset($_POST['user_id'])){
            $data = array('success'=>false,'error_id'=>1);
            $this->renderJSON($data);
            return;
        }

        $current_user_id = $this->get_current_user_id();
        $unfollow_user_id = $_POST['user_id'];

        $user_connection = UserConnection::model()->findBySql("SELECT * FROM `user_connection` WHERE `from_user_id`='$current_user_id' AND `to_user_id`='$unfollow_user_id'");


        //if user connection exists and we can delete it, return true
        if($user_connection && $user_connection->delete()){
            $data = array('success'=>true);
            $this->renderJSON($data);
            return;
        }else{
            //Error deleting connection
            $data = array('success'=>false,'error_id'=>2,'error_msg'=>'user connection doesnt exist');
            $this->renderJSON($data);
            return;
        }
    }



}