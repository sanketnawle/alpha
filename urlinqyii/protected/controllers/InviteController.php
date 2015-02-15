<?php

class InviteController extends Controller
{






    function delete_invite_notification($invite, $user){
        $notification = Notification::model()->find("type='invite' and user_id=:user_id and origin_id=:origin_id and origin_type=:origin_type", array(':user_id'=>$user->user_id, ':origin_id'=>$invite->origin_id, ':origin_type'=>$invite->origin_type));
        if($notification){
            $notification->delete(false);
        }
    }



	public function actionAccept(){

        if(!isset($_POST['invite_id'])){
            $return_data = array('success'=>false, 'error_id'=>1, 'error_msg'=>'data is not set');
            $this->renderJSON($return_data);
            return;
        }

        $user = $this->get_current_user($_POST);


        if(!$user){
            $return_data = array('success'=>false, 'error_id'=>1, 'error_msg'=>'user is not logged in');
            $this->renderJSON($return_data);
            return;
        }


        $invite_id = $_POST['invite_id'];

        $invite = Invite::model()->find('invite_id=:id',array(':id'=>$invite_id));

        if(!$invite){
            $return_data = array('success'=>false, 'error_id'=>3, 'error_msg'=>'invite doesnt exist');
            $this->renderJSON($return_data);
            return;
        }

        if($invite->choice){
            $return_data = array('success'=>false, 'error_id'=>4, 'error_msg'=>'user already accepted this invite');
            $this->renderJSON($return_data);
            return;
        }

        include_once 'color/color.php';




        if($invite->origin_type == 'event'){
            //Add this event to this users calendar
            $event = Event::model()->find('event_id=:id', array(':id'=>$invite->origin_id));

            if(!$event){
                $return_data = array('success'=>false, 'error_id'=>5, 'error_msg'=>'event doesnt exist');
                $this->renderJSON($return_data);
                return;
            }

            $event_user = new EventUser;
            $event_user->user_id = $user->user_id;
            $event_user->event_id = $invite->origin_id;
            $event_user->color_id = get_random_color();

            if($event_user->save(false)){
                $invite->choice = 1;
                $invite->save(false);

//
                $this->delete_invite_notification($invite, $user);
                $invite->delete(false);

                $return_data = array('success'=>true, 'msg'=>'user is now attending event ' . $event_user->event_id);
                $this->renderJSON($return_data);
                return;
            }else{
                $return_data = array('success'=>false, 'error_id'=>6, 'error_msg'=>'Error saving event user');
                $this->renderJSON($return_data);
                return;
            }

        }else if($invite->origin_type == 'club' || $invite->origin_type == 'group'){
            //Add this event to this users calendar
            $group = Group::model()->find('group_id=:id', array(':id'=>$invite->origin_id));

            if(!$group){
                $return_data = array('success'=>false, 'error_id'=>5, 'error_msg'=>'group doesnt exist');
                $this->renderJSON($return_data);
                return;
            }

            $group_user = new GroupUser;
            $group_user->user_id = $user->user_id;
            $group_user->group_id = $invite->origin_id;
            $group_user->color_id = get_random_color();

            if($group_user->save(false)){

                $invite->choice = 1;
                $invite->save(false);

                $this->delete_invite_notification($invite, $user);


                $invite->delete(false);

                $return_data = array('success'=>true, 'msg'=>'user is now attending group ' . $group_user->group_id);
                $this->renderJSON($return_data);
                return;
            }else{
                $return_data = array('success'=>false, 'error_id'=>6, 'error_msg'=>'Error saving group user');
                $this->renderJSON($return_data);
                return;
            }
        }else if($invite->origin_type == 'class'){
            //Add this event to this users calendar
            $class = ClassModel::model()->find('class_id=:id', array(':id'=>$invite->origin_id));

            if(!$class){
                $return_data = array('success'=>false, 'error_id'=>5, 'error_msg'=>'class doesnt exist');
                $this->renderJSON($return_data);
                return;
            }

            $class_user = new ClassUser;
            $class_user->user_id = $user->user_id;
            $class_user->class_id = $invite->origin_id;
            $class_user->color_id = get_random_color();

            if($class_user->save(false)){
                $invite->choice = 1;
                $invite->save(false);

                $this->delete_invite_notification($invite, $user);


                $invite->delete(false);

                $return_data = array('success'=>true, 'msg'=>'user is now attending class ' . $class_user->class_id);
                $this->renderJSON($return_data);
                return;
            }else{
                $return_data = array('success'=>false, 'error_id'=>6, 'error_msg'=>'Error saving class user');
                $this->renderJSON($return_data);
                return;
            }
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