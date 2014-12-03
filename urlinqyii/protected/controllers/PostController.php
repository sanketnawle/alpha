<?php

// If an event type post has to be created, create the event and
// then call the URL "/post/create" by sending the Post attributes (including the origin_type as event and origin_id as the acquired event_id)
// via POST method.

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

    public function __construct()
    {
        self::$cur_user_id = intval(Yii::app()->session['user_id'] || 1);

        $_POST['Post'] = array('post_type'=>'question', 'text'=>'new test qstn txt by post_cntrlr', 'privacy'=>'followers', 'anon'=>0);
        $_POST['PostQuestionOption'] = array(array('option_text'=>'opt1','answer_flag'=>1),array('option_text'=>'opt2','answer_flag'=>0),
                                        array('option_text'=>'opt3','answer_flag'=>0), array('option_text'=>'opt4','answer_flag'=>0));
        $_POST['PostQuestion'] = array('anonymous'=>0, 'live_answers'=>0, 'active'=>1);
        var_dump($_POST['Post']);
    }


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */

	public function actionCreate()
	{
        if(isset($_POST['Post'])) {

            if ($_POST['Post']['post_type'] == "file" && !isset($_FILES)) {
                $valid = FALSE;
                $data = array('success'=>false,'error_id'=>1, 'error_msg'=>'Can not find file');
                $this->renderJSON($data);
                return;
            }
            else {
                $valid = TRUE;
            }

            // check if the current user is_admin to that post
            if(isset($_POST['origin_type'])) {
                if ($_POST['origin_type'] == "group") {
                    if ($g_mod = GroupUser::model()->findbypk(array('group_id' => $_GET['id'], 'user_id' => self::$cur_user_id))) {
                        if ($g_mod->is_admin == 1)
                            $is_admin = TRUE;
                        else {
                            $is_admin = FALSE;
                            $data = array('success'=>false,'error_id'=>2, 'error_msg'=>'Access Denied: Not an Admin, but a member');
                            $this->renderJSON($data);
                            return;
                        }
                    } else{
                        $data = array('success'=>false,'error_id'=>3, 'error_msg'=>'Access Denied: Not a member');
                        $this->renderJSON($data);
                        return;
                    }
                } elseif ($_POST['origin_type'] == "class") {
                    if ($cl_mod = ClassUser::model()->findbypk(array('class_id' => $_GET['id'], 'user_id' => self::$cur_user_id))) {
                        if ($cl_mod->is_admin == 1)
                            $is_admin = TRUE;
                        else {
                            $is_admin = FALSE;
                            $data = array('success'=>false,'error_id'=>4, 'error_msg'=>'Access Denied: Not an Admin, but a member');
                            $this->renderJSON($data);
                            return;
                        }
                    } else{
                        $data = array('success'=>false,'error_id'=>5, 'error_msg'=>'Access Denied: Not a member');
                        $this->renderJSON($data);
                        return;
                    }
                } else
                    $is_admin = TRUE;
            }
            else
                $is_admin = TRUE;
            // check ends

        }
        else{
            $data = array('success'=>false,'error_id'=>6, 'error_msg'=>'Post Not set');
            $this->renderJSON($data);
            return;
        }

        if($valid && $is_admin) {
            $model = new Post;

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            $model->file_id = NULL;
            var_dump($_FILES);
            if (isset($_FILES) && sizeof($_FILES)>0) {
                $file = file_upload($_FILES);
                $model->file_id = $file['file_id'];
            }

            if (isset($_POST['Post'])) {
                $model->attributes = $_POST['Post'];
                $model->user_id = self::$cur_user_id;
//                            $model->created_at = NOW();
//                            $model->last_activity = NOW();

                if ($model->save()) {
                    echo $post_id = $model->post_id;
                    //                echo "awesome";
                    if (isset($post_id) && $_POST['Post']['post_type'] == "question") {

                        if (isset($_POST['PostQuestionOption'])) {

                            if (count($_POST['PostQuestionOption']) > 0) {

                                foreach ($_POST['PostQuestionOption'] as $key => $option) {

                                    $opt = new PostQuestionOption;
                                    $opt->option_text = $option['option_text'];
                                    $opt->post_id = $post_id;

                                    if ($opt->save()) {
                                        if ($option['answer_flag'] == 1)
                                            $correct_answer_id = $opt->option_id;
                                        echo "opt_saved";
                                    }
                                    //                                else
                                    //                                    var_dump($opt->getErrors());
                                    unset($opt);
                                }
                                if (isset($_POST['PostQuestion'])) {
                                    $question = new PostQuestion;
                                    $question->attributes = $_POST['PostQuestion'];
                                    $question->post_id = $post_id;
                                    if (isset($correct_answer_id))
                                        $question->correct_answer_id = $correct_answer_id;
                                    if ($question->save())
                                        echo "question_attribs saved";
//                                    else
//                                        var_dump($question->getErrors());
                                }
                                else{
                                    $question = new PostQuestion;
                                    $question->post_id = $post_id;
                                    if (isset($correct_answer_id))
                                        $question->correct_answer_id = $correct_answer_id;
                                    if ($question->save())
                                        echo "question_attribs saved";
//                                    else
//                                        var_dump($question->getErrors());
                                }
                            }
                        }
                    }
                    self::createNotification("posted", $post_id);
                }
//                            else
//                                var_dump($model->getErrors());

            }

            //		$this->render('create',array(
            //			'model'=>$model,
            //		));
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
        $model=$this->loadModel($_GET['id']);

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

    public function actionLike()
    {
        $model=new PostLike;
//        echo self::$cur_user_id;
        $model->post_id = $_GET['id'];
        $model->user_id = self::$cur_user_id;
        if($model->save()) {
            self::createNotification("liked", $_GET['id']);
            echo "like_success";
        }
        else
            var_dump($model->getErrors());
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

	/**
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
