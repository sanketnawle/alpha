<?php

if(isset($_FILES))
    include_once "file_upload.php";

class PostController extends Controller
{
	/**
     * Made some changes in Post Model @rules
     *
     * Usage:
     * Send $_Post[] array to..
        * post/create
        * post/[:id]/update
        * post/[:id]/delete
     *
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */

    private static $cur_user_id;

	public $layout='//layouts/column2';

    // public function __construct()
    // {
    //     self::$cur_user_id = intval(Yii::app()->session['user_id'] || 1);

    //     $_POST['Post'] = array('post_type'=>'question', 'text'=>'test qstn text by post_cntrlr', 'privacy'=>'members', 'anon'=>0);
    //     $_POST['PostQuestionOption'] = array(array('option_text'=>'opt1','answer_flag'=>1),array('option_text'=>'opt2','answer_flag'=>0),
    //                                     array('option_text'=>'opt3','answer_flag'=>0), array('option_text'=>'opt4','answer_flag'=>0));
    //     $_POST['PostQuestion'] = array('anonymous'=>0, 'live_answers'=>0, 'active'=>1);
    //     //var_dump($_POST['Post']);
    // }


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */

	public function actionCreate()
	{

        try{
		$model=new Post;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

        $model->file_id = NULL;
        if(isset($_FILES['fileUpload'])) {
            $file = file_upload($_FILES);
            $model->file_id = $file['file_id'];
        }
        // else{
        //     // echo 'file_upload failed';
        // }
            

		if(isset($_POST['post']))
		{

            
                $model->attributes=$_POST['post'];
                $model->user_id = $this->get_current_user()->user_id;
    //            $model->created_at = NOW();
    //            $model->last_activity =  = NOW();
                $model->save(false);
            
			



            //Changed by Alex. Dont echo 
            //This function should return JSON with a success flag and
            //the post data if true

            //$_POST['Post'] -> $_POST['Post'] plz
			if($model){

                $return_data = array('success'=>true,'post'=>$model);
                $this->renderJSON($return_data);
                return;
                //echo $post_id = $model->post_id;
//                echo "awesome";
                if(isset($post_id) && $_POST['Post']['post_type']=="question"){

                    if(isset($_POST['PostQuestionOption'])){

                        if(count($_POST['PostQuestionOption'])>0) {

                            foreach ($_POST['PostQuestionOption'] as $key => $option) {

                                $opt = new PostQuestionOption;
                                $opt->option_text = $option['option_text'];
                                $opt->post_id = $post_id;

                                if($opt->save()){
                                    if($option['answer_flag']==1)
                                        $correct_answer_id = $opt->option_id;
                                    //echo "opt_saved";
                                }
//                                else
//                                    var_dump($opt->getErrors());
                                unset($opt);
                            }
                            if(isset($_POST['PostQuestion'])){
                                $question = new PostQuestion;
                                $question->attributes = $_POST['PostQuestion'];
                                $question->post_id = $post_id;
                                if(isset($correct_answer_id))
                                    $question->correct_answer_id = $correct_answer_id;
                                if($question->save())
                                    echo "question_attribs saved";
//                                else
//                                    var_dump($question->getErrors());
                            }
                        }
                    }
                }
                self::createNotification("posted", $post_id);



            }else{
                $return_data = array('success'=>false,'error_id'=>2);
                $this->renderJSON($return_data);
                return;    
            }
//            else
//                var_dump($model->getErrors());

		}else{
            $return_data = array('success'=>false,'error_id'=>1);
            $this->renderJSON($return_data);
            return;    
        }

//		$this->render('create',array(
//			'model'=>$model,
//		));

        }catch(Exception $e){
                $return_data = array('success'=>false,'error_id'=>3,'error_msg'=>$e->getMessage());
                $this->renderJSON($return_data);
                return;
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

		if(isset($_POST['Post']))
		{
            if($model->user_id == self::$cur_user_id) {
                $model->attributes = $_POST['Post'];

                if(isset($_GET['id']) && $model->post_type=="question") {

                    if (isset($_POST['PostQuestionOption'])) {

                        if (count($_POST['PostQuestionOption']) > 0) {

                            foreach ($_POST['PostQuestionOption'] as $key => $option) {

                                $opt = new PostQuestionOption;
                                $opt->option_text = $option['option_text'];
                                $opt->post_id = $_GET['id'];

                                if ($opt->save()) {
                                    if ($option['answer_flag'] == 1)
                                        $correct_answer_id = $opt->option_id;
                                    echo "opt_saved";
                                }
//                                else
//                                    var_dump($opt->getErrors());
                                unset($opt);
                            }
                        }
                        if(isset($correct_answer_id)){
                            $question = PostQuestion::model()->findbypk($_GET['id']);
                            $question->correct_answer_id = $correct_answer_id;
                        }
                    }
                }
                if ($model->save())
                    echo "update_success";
//                    $this->redirect(array('view', 'id' => $model->post_id));
            }
            else
                echo "Access Denied";
		}

//		$this->render('update',array(
//			'model'=>$model,
//		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
//        $model=$this->loadModel($_GET['id']);

        if($model->user_id == self::$cur_user_id) {
            if($this->loadModel($_GET['id'])->delete())
                echo "delete_success";
        }
        else
            echo "Access Denied";

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//		if(!isset($_GET['ajax']))
//			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}


    //ERROR ID's
    // 1 - Post id isnt set
    // 2 - like already exists
    // 3 - error creating post like
    public function actionLike()
    {
        try{
            if(!isset($_GET['id'])){
                $return_data = array('success'=>false,'error_id'=>1);
                $this->renderJSON($return_data);
                return;
            }


            $current_user_id = Yii::app()->session['user_id'];
            $post_id = $_GET['id'];
            $model = PostLike::model()->findBySql("SELECT * FROM post_like WHERE post_id=" . $post_id . ' AND user_id=' . $current_user_id);


            //Make sure the user hasnt already liked this post
            if(!$model){
                $post_like = new PostLike;
                $post_like->post_id = $post_id;
                $post_like->user_id = $current_user_id;
                $post_like->save(false);
                if($post_like) {

                    //Notification is causing error, commented out for now
                    //self::createNotification("liked", $_GET['id']);
                    $return_data = array('success'=>true);
                    $this->renderJSON($return_data);
                    return;
                }else{
                    $return_data = array('success'=>false,'error_id'=>3);
                    $this->renderJSON($return_data);
                    return;
                }
            }else{
                $return_data = array('success'=>false,'error_id'=>2);
                $this->renderJSON($return_data);
                return;
            }

        }catch(Exception $e){
            $return_data = array('success'=>false,'error_id'=>3,'error_msg'=>$e->getMessage());
            $this->renderJSON($return_data);
            return;
        }

//
//        else
//            var_dump($model->getErrors());
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//		if(!isset($_GET['ajax']))
//			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionUnlike()
    {
        $model=PostLike::model()->findByPk(array('post_id'=>$_GET['id'],'user_id'=>self::$cur_user_id));

        if($model->user_id == self::$cur_user_id) {
            if($model->delete())
                echo "delete_success";
        }
        else
            echo "Access Denied";

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//		if(!isset($_GET['ajax']))
//			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function createNotification($action, $id){
        $model = new Notification;
        $model->actor_id = self::$cur_user_id;
        $model->trigger_id = $id;
        $model->trigger_type = $action;
        if($model->save())
            echo "Notification created successfully";
        else
            var_dump($model->getErrors());
    }

	/**
	 * Lists all models.
	 */
//	public function actionIndex()
//	{
//		$dataProvider=new CActiveDataProvider('Post');
//		$this->render('index',array(
//			'dataProvider'=>$dataProvider,
//		));
//	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Post('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Post']))
			$model->attributes=$_GET['Post'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
    

	/*
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Post the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Post::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Post $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='post-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
