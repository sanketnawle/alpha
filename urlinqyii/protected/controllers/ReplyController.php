<?php

class ReplyController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */

    private static $cur_user_id;

	public $layout='//layouts/column2';

	public function actionCreate()
	{
		$model=new Reply;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Reply']))
		{
			$model->attributes=$_POST['Reply'];
            $model->user_id = self::$cur_user_id;
			if($model->save())
				echo "Reply created";
		}

	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
		$model=$this->loadModel($_GET['id']);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Reply']))
		{
			$model->attributes=$_POST['Reply'];
			if($model->save())
				echo "Reply updated";
		}
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete() {

        if(!isset($_POST['id'])){
            $data = array('success'=>false,'error_id'=>1, 'post'=>$_POST, 'error_msg'=>'required data not specified.');
            $this->renderJSON($data);
            return;
        }

        $user = $this->get_current_user($_POST);
        if (!$user) {
            $data = array('success'=>false,'error_id'=>2, 'post'=>$_POST, 'error_msg'=>'user not authenticated.');
            $this->renderJSON($data);
            return;           
        }

        $id = $_POST['id'];


        $reply = Reply::model()->find('reply_id=:reply_id', array(':reply_id'=>$id));
        if(!$reply){
            $data = array('success'=>false,'error_id'=>3, 'post'=>$_POST, 'error_msg'=>'not a valid reply.');
            $this->renderJSON($data);
            return;
        }



        if($reply->delete()){
            $data = array('success'=>true);
            $this->renderJSON($data);
            return;
        }else{
            $data = array('success'=>false,'error_id'=>4, 'error_msg'=>'error deleting reply' , 'post'=>$_POST, 'error_msg'=>'could not delete comment.');
            $this->renderJSON($data);
            return;
        }

	}

    public function actionUpvote()
    {
//        echo $reply_id = $_GET['id'];
        $vote = '';
        if(ReplyVote::model()->findbypk(array('reply_id' => $_GET['id'], 'user_id' => self::$cur_user_id))) {
            $ex_model = ReplyVote::model()->findbypk(array('reply_id' => $_GET['id'], 'user_id' => self::$cur_user_id));
            $vote = $ex_model->vote_type;
            if($ex_model->delete())
                echo "upvote deleted";
        }
        if($vote != 'upvote') {
            $model = new ReplyVote;
            //        echo self::$cur_user_id;
            $model->reply_id = $_GET['id'];
            $model->user_id = self::$cur_user_id;
            $model->vote_type = 'upvote';
            if ($model->save()) {
                self::createNotification("upvoted", $_GET['id']);
                echo "upvote_success";
            } else
                var_dump($model->getErrors());
        }
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//		if(!isset($_GET['ajax']))
//			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionDownvote()
    {
        $vote = '';
        if(ReplyVote::model()->findbypk(array('reply_id'=>$_GET['id'],'user_id'=>self::$cur_user_id))) {
            $ex_model = ReplyVote::model()->findbypk(array('reply_id' => $_GET['id'], 'user_id' => self::$cur_user_id));
            $vote = $ex_model->vote_type;
            $ex_model->delete();
        }
        if($vote != 'downvote') {
            $model = new ReplyVote;
            //        echo self::$cur_user_id;
            $model->reply_id = $_GET['id'];
            $model->user_id = self::$cur_user_id;
            $model->vote_type = 'downvote';
            if ($model->save()) {
                self::createNotification("downvoted", $_GET['id']);
                echo "downvote_success";
            } else
                var_dump($model->getErrors());
        }
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//		if(!isset($_GET['ajax']))
//			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }


    public function createNotification($action, $id){
        $model = new Notification;
        $model->user_id = self::$cur_user_id;
        $model->actor_id = self::$cur_user_id;
        $model->trigger_id = $id;
        $model->trigger_type = $action;
        if($model->save())
            echo "Notification created successfully";
        else
            var_dump($model->getErrors());
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Reply the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Reply::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Reply $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='reply-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
