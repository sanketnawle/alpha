<?php

class SiteController extends Controller
{


    //Declare the general layout you want used here
    //located in the views/layouts folder
    //public $layout='//layouts/main';

	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
                'class' => 'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
    // urlinq.com/
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
        $test_str = 'Testing passing data from controller to front end';


        //Can specify specific layout inside view
        //$this->layout = 'new';
		$this->render('lp_beta',array('test_str'=>$test_str));
	}

    // urlinq.com/home
    public function actionHome()
    {

        //$user = User::model()->findByPk(Yii::app()->user->id);
        if(!$this->authenticated()){
            $this->redirect(array('/'));
        }


        $user_id = Yii::app()->session['user_id'];
        $user = User::model()->find('user_id=:id', array(':id'=>$user_id));
        //Can specify specific layout inside view
        //$this->layout = 'new';
        $this->render('home',array('user'=>$user));
    }



	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}



    public function actionTest()
    {

//        $post=new Post;
//        $post->title='Sample Post';
//        $post->content='content for the sample post';
//        $post->save();
//
//        $post=Post::model()->find('id=:id', array(':id'=>1));


//        $user=new User;
//        $user->name='Alex Lopez';
//        $user->email='adroitcode@gmail.com';
//        $user->save();

          $user=User::model()->find('id=:id', array(':id'=>1));
//        $user->posts = array($post);
//        $user->save();


        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        //$test_str = 'TEST PAGR FROM THE POST CONTROLLER' . $user->name;
        $test_str = 'TEST PAGR FROM THE POST CONTROLLER' . var_dump($user->posts[0]->title);
        $this->render('index',array('test_str'=>$test_str));
    }




    public function actionJson(){
        //$data = array('test'=>'lol','test_array'=>array(1,2,3,4));

        $data = array('success'=>true,'posts'=>array('post1','post2'));


        $this->renderJSON($data);
    }





	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout() {
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}


    function getFileMimeType($file) {
        if (function_exists('finfo_file')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $type = finfo_file($finfo, $file);
            finfo_close($finfo);
        } else {
            require_once 'upgradephp/ext/mime.php';
            $type = mime_content_type($file);
        }

        if (!$type || in_array($type, array('application/octet-stream', 'text/plain'))) {
            $secondOpinion = exec('file -b --mime-type ' . escapeshellarg($file), $foo, $returnCode);
            if ($returnCode === 0 && $secondOpinion) {
                $type = $secondOpinion;
            }
        }

        if (!$type || in_array($type, array('application/octet-stream', 'text/plain'))) {
            require_once 'upgradephp/ext/mime.php';
            $exifImageType = exif_imagetype($file);
            if ($exifImageType !== false) {
                $type = image_type_to_mime_type($exifImageType);
            }
        }

        return $type;
    }


    public function actionFileUpload() {

        $user = User::model()->find('user_id=:id', array(':id'=>1));



        if(!isset($_POST['origin_type'])){
            $this->renderJSON(array('success'=>false,'msg'=>'origin_type is not set'));
        }

        if(!isset($_POST['origin_type'])){
            $this->renderJSON(array('success'=>false,'msg'=>'origin_id is not set'));
        }



        $origin_type = $_POST['origin_type'];
        $origin_id = $_POST['origin_id'];
        //["name"]
        if(isset($_FILES["uploadFile"])){
            include "UniqueTokenGenerator.php";

            $path_parts = pathinfo($_FILES["uploadFile"]["name"]);
            $extension = $path_parts['extension'];
            $file_type = $this->getFileMimeType($_FILES["uploadFile"]['tmp_name']);
            $random_name = token($user->user_id,$user->firstname);

            if($extension == 'jpg' || $extension == 'png' || $extension == 'gif'){
                include "ImageCompress.php";
                image_compress($_FILES["uploadFile"]["tmp_name"], 'assets/test/' . $random_name . '.jpg', 50);
            } else{
                move_uploaded_file($_FILES["uploadFile"]["tmp_name"], 'assets/test/' . $_FILES["uploadFile"]["name"]);
            }


            //Create file in file table here
            $file = new File;
            $file->file_name = $random_name . '.' . $extension;
            $file->file_url = $file_url = "/assets/" . $random_name . '.' . $extension;
            $file->file_type = $file_type;
            $file->file_extension = $extension;

            $file->save(false);
            //Use the origin and id to add files either to associative table or to a main field

            $this->renderJSON(array('success'=>true,'file_type'=>$file_type,'file_id'=>$file->file_id,'file_name'=>$random_name . '.' . $extension,'origin_type'=>$origin_type,'origin_id'=>$origin_id,'extension'=>$extension));
        }else {
            $this->renderJSON(array('success'=>false));
        }




    }






}