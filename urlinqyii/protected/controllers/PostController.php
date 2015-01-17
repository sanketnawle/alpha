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



    function reArrayFiles(&$file_post) {

        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);

        for ($i=0; $i<$file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }

        return $file_ary;
    }

	public function actionCreate()
	{

//{"text":"asdasd","post_type":"discuss","origin_id":"","origin_type":"class","sub_text":"","privacy":"","anon":0,"like_count":0}


        //Because of limitations with dropzone js, if files are being uploaded,
        //I must send the post parameters as a JSON string rather than just sending them normally
        //So if files are present, we need to decode the JSON string into an array
        if(isset($_FILES['file'])) {
            $_POST['post'] = json_decode($_POST['post'], true);
        }



        if(!isset($_POST['post']['text']) || !isset($_POST['post']['origin_type']) || !isset($_POST['post']['origin_id']) || !isset($_POST['post']['post_type']) || !isset($_POST['post']['sub_text']) || !isset($_POST['post']['privacy']) || !isset($_POST['post']['anon'])){
            $return_data = array('success'=>false, 'error_id'=>1, 'error_msg'=>'All data is not set', '$POST'=>$_POST);
            $this->renderJSON($return_data);
            return;
        }

        if($_POST['post']['origin_type'] == '' || $_POST['post']['origin_id'] = ''){
            $return_data = array('success'=>false, 'error_id'=>2, 'error_msg'=>'invalid origin', '$POST'=>$_POST);
            $this->renderJSON($return_data);
            return;
        }


        try{
            $model=new Post;

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

//            $model->file_id = NULL;
//            if(isset($_FILES['fileUpload'])) {
//                $file = file_upload($_FILES);
//                $model->file_id = $file['file_id'];
//            }
            // else{
            //     // echo 'file_upload failed';
            // }



            $user = $this->get_current_user();
            if(!$user){
                $return_data = array('success'=>false, 'error_id'=>2, 'error_msg' => 'user is not logged in');
                $this->renderJSON($return_data);
                return;
            }

            if(isset($_POST['post'])){


                $model->attributes = $_POST['post'];

                $model->post_type = $_POST['post']['post_type'];
                $model->user_id = $user->user_id;
    //            $model->created_at = NOW();
    //            $model->last_activity =  = NOW();





                $model->save(false);
                $post_id = $model->post_id;



                //Changed by Alex. Dont echo
                //This function should return JSON with a success flag and
                //the post data if true

                //$_POST['Post'] -> $_POST['Post'] plz
                if($model){


                    $post_data = $this->model_to_array($model);
                    $post_data['user_info'] = $this->model_to_array($user);

                    //Save post files
                    if(isset($_FILES['file'])) {
                        $post_data['files'] = array();
                        $file_ary = $this->reArrayFiles($_FILES['file']);

                        foreach ($file_ary as $file) {



                            $file_data = file_upload2($file, 'post_files/');


                            $post_file = new PostFile;
                            $post_file->post_id = $model->post_id;
                            $post_file->file_id = $file_data['file_id'];
                            if(!$post_file->save(false)){
                                $return_data = array('success'=>false, 'error_msg'=>'error uploading file');
                                $this->renderJSON($return_data);
                                return;
                            }

                            array_push($post_data['files'], $this->model_to_array($post_file->file));

                        }
                    }


                    //echo $post_id = $model->post_id;
    //                echo "awesome";

                    if(isset($_POST['post']['question']) && ($model->post_type == 'question' || $model->post_type == 'multiple_choice' || $model->post_type == 'true_false')){

                        $post_data['question'] = array('options'=>array());

                        $question = new PostQuestion;
                        //$question->attributes = $_POST['PostQuestion'];
                        $question->post_id = $post_id;
                        $question->save(false);


                        if($model->post_type == 'multiple_choice' && isset($_POST['post']['question']['answer_index'])){
                            $correct_answer_index = $_POST['post']['question']['answer_index'];

                            $post_data['question']['answer_index'] = $correct_answer_index;


                            for($i = 0; $i < count($_POST['post']['question']['options']); $i++){
                                $option_text = $_POST['post']['question']['options'][$i];

                                if($option_text != ''){
                                    $option = new PostQuestionOption;
                                    $option->option_text = $option_text;
                                    $option->post_id = $post_id;
                                    $option->save(false);


                                    if($i == $correct_answer_index){
                                        $question->correct_answer_id = $option->option_id;
                                        $question->save(false);
                                    }

                                    array_push($post_data['question']['options'], $this->model_to_array($option));
                                }
                            }
                        }else if($model->post_type == 'true_false'){
                            $option = new PostQuestionOption;
                            $option->option_text = 'True';
                            $option->post_id = $post_id;
                            $option->save(false);

                            array_push($post_data['question']['options'], $this->model_to_array($option));

                            $option = new PostQuestionOption;
                            $option->option_text = 'False';
                            $option->post_id = $post_id;
                            $option->save(false);

                            array_push($post_data['question']['options'], $this->model_to_array($option));
                        }


                        //if(count($_POST['post']['question']['choices']) > 0){


                        //}
                    }


                    //Get the origin data
                    if($model->origin_type == 'class'){
                        $post_data['origin'] = $this->model_to_array(ClassModel::model()->find('class_id=:id',array(':id'=>$model->origin_id)));
                        //reassign the name to make it easier to get in the handlebars
                        $post_data['origin']['name'] = $post_data['class_name'];
                    }else if($model->origin_type == 'department'){
                        $post_data['origin'] = $this->model_to_array(Department::model()->find('department_id=:id',array(':id'=>$model->origin_id)));
                        //reassign the name to make it easier to get in the handlebars
                        $post_data['origin']['name'] = $post_data['department_name'];
                    }else if($model->origin_type == 'school'){
                        $post_data['origin'] = $this->model_to_array(School::model()->find('school_id=:id',array(':id'=>$model->origin_id)));
                        //reassign the name to make it easier to get in the handlebars
                        $post_data['origin']['name'] = $post_data['school_name'];

                    }else if($model->origin_type == 'club' || $model->origin_type == 'group'){
                        $post_data['origin'] = $this->model_to_array(Group::model()->find('group_id=:id',array(':id'=>$model->origin_id)));
                        //reassign the name to make it easier to get in the handlebars
                        $post_data['origin']['name'] = $post_data['group_name'];
                    }

                    //This user obviously owns this post
                    $post_data['pownership'] = true;



                    $post_data['user_info'] = $this->get_model_associations($user, array('pictureFile'));

                    $return_data = array('success'=>true,'post'=>$post_data);
                    $this->renderJSON($return_data);
                    return;



                }else{
                    $return_data = array('success'=>false,'error_id'=>2);
                    $this->renderJSON($return_data);
                    return;
                }


    //                if(isset($post_id) && $_POST['post']['post_type']=="question"){
    //
    //                    if(isset($_POST['PostQuestionOption'])){
    //
    //                        if(count($_POST['PostQuestionOption'])>0) {
    //
    //                            foreach ($_POST['PostQuestionOption'] as $key => $option) {
    //
    //                                $opt = new PostQuestionOption;
    //                                $opt->option_text = $option['option_text'];
    //                                $opt->post_id = $post_id;
    //
    //                                if($opt->save()){
    //                                    if($option['answer_flag']==1)
    //                                        $correct_answer_id = $opt->option_id;
    //                                    //echo "opt_saved";
    //                                }
    ////                                else
    ////                                    var_dump($opt->getErrors());
    //                                unset($opt);
    //                            }
    //                            if(isset($_POST['PostQuestion'])){
    //                                $question = new PostQuestion;
    //                                $question->attributes = $_POST['PostQuestion'];
    //                                $question->post_id = $post_id;
    //                                if(isset($correct_answer_id))
    //                                    $question->correct_answer_id = $correct_answer_id;
    //                                if($question->save())
    //                                    echo "question_attribs saved";
    ////                                else
    ////                                    var_dump($question->getErrors());
    //                            }
    //                        }
    //                    }
    //                }

                    //This causes error
                    //self::createNotification("posted", $post_id);




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
	public function actionDelete(){

        if(!isset($_POST['post_id'])){
            $return_data = array('success'=>false,'error_id'=>1, 'error_msg'=>'all data not set');
            $this->renderJSON($return_data);
            return;
        }


        $user = $this->get_current_user();
        if(!$user){
            $return_data = array('success'=>false,'error_id'=>2, 'error_msg'=>'user is not logged in');
            $this->renderJSON($return_data);
            return;
        }

        $post = Post::model()->find('post_id=:id',array(':id'=>$_POST['post_id']));

        if(!$post){
            $return_data = array('success'=>false,'error_id'=>3, 'error_msg'=>'post doesnt exist');
            $this->renderJSON($return_data);
            return;
        }

        //Make sure this user created this post
        if($post->user_id != $user->user_id){
            $return_data = array('success'=>false,'error_id'=>4, 'error_msg'=>'User is not authorized to delete this post');
            $this->renderJSON($return_data);
            return;
        }


        //If all goes well, delete the post
        if($post->delete()){
            $return_data = array('success'=>true);
            $this->renderJSON($return_data);
            return;
        }else{
            $return_data = array('success'=>false,'error_id'=>5, 'error_msg'=>'Error deleting post');
            $this->renderJSON($return_data);
            return;
        }





	}


    //ERROR ID's
    // 1 - Post id isnt set
    // 2 - like already exists
    // 3 - error creating post like
    public function actionAnswer(){
        try{
            if(!isset($_POST['post_id']) || !isset($_POST['option_id'])){
                $return_data = array('success'=>false,'error_id'=>1, 'error_msg'=>'all data not set');
                $this->renderJSON($return_data);
                return;
            }
            $option_id = $_POST['option_id'];
            $user = $this->get_current_user($_POST);
            if($user){
                $answer = PostQuestionOptionAnswer::model()->find('option_id=:id and user_id=:user_id', array(":id"=>$option_id, ":user_id"=>$user->user_id));
                if($answer){
                    $return_data = array('success'=>false,'error_id'=>3, 'error_msg'=>'user already answered');
                    $this->renderJSON($return_data);
                    return;
                }

                $answer_new = new PostQuestionOptionAnswer;
                $answer_new->user_id = $user->user_id;
                $answer_new->option_id = $option_id;

                if($answer->save(false)){
                    $data=array('success'=>true);
                    $this->renderJSON($data);
                    return;
                }
                else{
                    $return_data = array('success'=>false,'error_id'=>4, 'error_msg'=>'error saving answer to database');
                    $this->renderJSON($return_data);
                    return;
                }

            }
            else{
                $return_data = array('success'=>false,'error_id'=>2, 'error_msg'=>'user not exists');
                $this->renderJSON($return_data);
                return;
            }

        }catch (Exception $e){
            $data = array('success'=>false,'error_id'=>2,'error_msg'=>$e->getMessage());
            $this->renderJSON($data);
            return;
        }
    }
    public function actionLike()
    {
        try{
            if(!isset($_POST['post_id'])){
                $return_data = array('success'=>false,'error_id'=>1);
                $this->renderJSON($return_data);
                return;
            }


            $user = $this->get_current_user($_POST);
            if(!$user){
                $return_data = array('success'=>false,'error_id'=>2, 'error_msg'=>"error found user");
                $this->renderJSON($return_data);
                return;
            }
            $post_id = $_POST['post_id'];
            $post_like = PostLike::model()->findBySql("SELECT * FROM post_like WHERE post_id=" . $post_id . ' AND user_id=' . $user->user_id);


            //Make sure the user hasnt already liked this post
            if(!$post_like){
                $post_like = new PostLike;
                $post_like->post_id = $post_id;
                $post_like->user_id = $user->user_id;
                $post_like->save(false);
                if($post_like) {

                    //Notification is causing error, commented out for now
                    //self::createNotification("liked", $_GET['id']);
                    $return_data = array('success'=>true);
                    $this->renderJSON($return_data);
                    return;
                }else{
                    $return_data = array('success'=>false,'error_id'=>3, 'error_msg'=>"error saving post_user table");
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


    }

    public function actionUnlike()
    {
        try {
            if (!isset($_POST['post_id'])) {
                $return_data = array('success' => false, 'error_id' => 1);
                $this->renderJSON($return_data);
                return;
            }


            $user = $this->get_current_user($_POST);
            if (!$user) {
                $return_data = array('success' => false, 'error_id' => 2, 'error_msg' => "error found user");
                $this->renderJSON($return_data);
                return;
            }
            $post_id = $_POST['post_id'];
            $post_like = PostLike::model()->findBySql("SELECT * FROM post_like WHERE post_id=" . $post_id . ' AND user_id=' . $user->user_id);
            if ($post_like->delete()) {
                $return_data = array('success' => true);
                $this->renderJSON($return_data);
                return;
            } else {
                $return_data = array('success' => false, 'error_id' => 2, 'error_msg' => 'Error deleting post_like');
                $this->renderJSON($return_data);
                return;
            }
        }catch(Exception $e){
            $return_data = array('success'=>false,'error_id'=>3,'error_msg'=>$e->getMessage());
            $this->renderJSON($return_data);
            return;
        }


        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//		if(!isset($_GET['ajax']))
//			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }


    public function actionReply(){
        if(!isset($_POST['post_id']) || !isset($_POST['reply_text']) || !isset($_POST['reply_user_id']) || !isset($_POST['anonymous'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'All data is not set');
            $this->renderJSON($data);
            return;
        }

        try{
            //$post_id = $_POST['post_id'];
            $post_id = $_POST['post_id'];

            $reply_text = $_POST['reply_text'];
            $reply_user_id = $_POST['reply_user_id'];
            $reply_user = User::model()->find("user_id=:user_id",array(":user_id"=>$reply_user_id));

            $anonymous = $_POST['anonymous'];

            $post = Post::model()->find("post_id=:post_id",array(":post_id"=>$post_id));
            if($post){
                //Create a new reply model
                $reply = new Reply;
                $reply->reply_msg = $reply_text;
                $reply->post_id = $post_id;
                $reply->anon = $anonymous;
                $reply->user_id = $reply_user_id;
                $reply->save(false);

                if($reply){

//                {
//                  "reply_id": "1",
//                  "post_id": "10",
//                  "user_id": "2",
//                  "reply_msg": "Hey dude whats up",
//                  "up_vote": 0,
//                  "down_vote": 0,
//                  "file_id": null,
//                  "anon": 0,
//                  "update_timestamp": 1417015584,
//                  "user_info": {
//                            "user_id": "2",
//                    "user_name": "Lol Lmfao",
//                    "picture_file_id": "1"
//                  },
//                  "cownership": false,
//                  "vote_status": null
//                }
                    $reply_data = array(
                        'reply_id'=>$reply->reply_id,
                        'post_id'=>$post->post_id,
                        'reply_msg'=>$reply->reply_msg,
                        'up_vote'=>$reply->up_vote,
                        'down_vote'=>$reply->down_vote,
                        'file_id'=>$reply->file_id,
                        'anon'=>$reply->anon,
                        'update_timestamp'=>$reply->update_timestamp,
                        'user_info'=>array(
                            'user_id'=>$reply_user_id,
                            'user_name'=>$reply_user->firstname . ' ' . $reply_user->lastname,
                            'picture_file_id'=>$reply_user->picture_file_id
                        ),
                        'cownership'=>false,
                        'vote_status'=>null
                    );
                    $data = array('success'=>true,'reply'=>$reply_data);
                    $this->renderJSON($data);
                    return;
                }else{
                    $data = array('success'=>false,'error_id'=>3,'error_msg'=>'error creating reply');
                    $this->renderJSON($data);
                    return;
                }


            }else{
                $data = array('success'=>false,'error_id'=>2,'error_msg'=>'post with id ' . $post_id . 'does not exist');
                $this->renderJSON($data);
                return;
            }
        }catch(Exception $e){
            $data = array('success'=>false,'error_id'=>2,'error_msg'=>$e->getMessage());
            $this->renderJSON($data);
            return;
        }


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
