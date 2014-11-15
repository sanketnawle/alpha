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


        if($this->authenticated()){
            $this->redirect(array('/home'));
        }

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
        $university = University::model()->find('university_id=:university_id',array(':university_id'=>1));

        $data = array('success'=>true,'posts'=>array('post1','post2'),'university'=>$this->get_model_associations($university,array('schools'=>array('pictureFile'))));


        $this->renderJSON($data);
    }





	public function actionLogin() {


		if(isset($_POST['login_email']) && isset($_POST['login_password'])) {
            include "password_encryption.php";
			$email = $_POST['login_email'];
            $password = $_POST['login_password'];

            $user = User::model()->find('user_email=:user_email',array(':user_email'=>$email));
            $user_login = UserLogin::model()->find('user_id=:user_id',array(':user_id'=>$user->user_id));

            $salt = $user_login->salt;

            $hashed_password = hash_password($password,$salt);
            if($user_login->password == $hashed_password){ //user has successfully logged in

                Yii::app()->session['user_id'] = $user->user_id;
                $this->redirect(Yii::app()->getBaseUrl(true) . '/home');

            }else{ //user login failed

                $this->redirect(Yii::app()->getBaseUrl(true) . '/login');
            }

		}
		// display the login form
		$this->render('login',array());
	}

    public function actionLogout() {
        Yii::app()->session->destroy();
        $this->redirect(Yii::app()->getBaseUrl(true) . '/');
    }



    public function actionRegister(){

        if(isset($_POST['password']) ||isset($_POST['firstname']) ||isset($_POST['lastname']) ||isset($_POST['account-types']) ||isset($_POST['email'])){
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $user_type = $_POST['account-types'];
            $password = $_POST['password'];

            if($firstname == '' || $lastname == '' || $user_type == '' || $email == ''){
                $this->render('test',array('error'=>'All fields are required'));
                return;
            }

            if(strlen($password) < 6){
                $this->render('test',array('error'=>'Password is too short'));
                return;
            }

            if(strpos($firstname,$password) > 0){
                $this->render('test',array('error'=>'Password cannot be in name'));
                return;
            }

            if(strpos($lastname,$password) > 0){
                $this->render('test',array('error'=>'Password cannot be in lastname'));
                return;
            }

            if(strpos($email,'nyu.edu') == false){
                if(strpos($email,'poly.edu')){
                    $this->render('test',array('error'=>'Poly emails are not accepted at this time'));
                    return;
                }else if(strpos($email,'.edu')){
                    $this->render('test',array('error'=>'Only NYU emails are accepted at this time'));
                    return;
                }else{
                    $this->render('test',array('error'=>'.edu email must be used'));
                    return;
                }
            }








//            $user = User::model()->find('user_email=:user_email',array(':user_email'=>$email));
//

//            $_SESSION['firstname'] = $firstname;
//            $_SESSION['lastname'] = $lastname;
//            $_SESSION['user_type'] = $user_type;
//            $_SESSION['email'] = $email;
//            $_SESSION['password'] = $password;


            include "password_encryption.php";

            if($user_type == 'p'){
                $professor = User::model()->find("user_email=:user_email",array(":user_email"=>$email));
                if($professor){
                    $_SESSION['user_id']= $professor->user_id;
                    $_SESSION['professor'] = 1;
                    $this->render('test',array('error'=>'Professor with id ' . strval($_SESSION['user_id']) . 'exists'));
                    return;
                    //  $this->redirect(Yii::app()->getBaseUrl(true) . '/register/school_select?professor=1');
                }else{
                    $professor = new User;
                    $professor->user_email = $email;
                    $professor->user_type = $user_type;
                    $professor->firstname = $firstname;
                    $professor->lastname = $lastname;
                    $professor->school_id = null;
                    $professor->department_id = null;
                    $professor->status = 'temp';
                    $professor->save(false);


                    $salt = salt();
                    $hashed_password = hash_password($password,$salt);

                    $user_login = new UserLogin;
                    $user_login->user_id = $professor->user_id;
                    $user_login->password = $hashed_password;
                    $user_login->salt = $salt;
                    $user_login->save(false);

                    Yii::app()->session['user_id'] = $professor->user_id;

                    $this->render('test',array('error'=>'Professor with id ' . strval($_SESSION['user_id']) . ' was created'));
                    return;
                    //$this->redirect(Yii::app()->getBaseUrl(true) . '/professor_verify');
                }
            }elseif($user_type == 's'){
                //Check if the user is already in the database
                $user = User::model()->find("user_email=:user_email",array(":user_email"=>$email));
                if($user){
                    $_SESSION['user_id'] = $user->user_id;

                    if($user->status === 'invited'){
                        $this->render('test',array('error'=>'User with id ' . $user->user_id . ' was already invited and stored in DB. Redirecting to school_select'));
                        return;
                        //$this->redirect(Yii::app()->getBaseUrl(true) . '/register/school_select');
                    }else if($user->status === 'temp'){

                        //<a href="/beta/php/afterselect.php">click here</a>
                        $this->render('test',array('error'=>'User with id ' . $user->user_id . ' already registered, redirect to school_select'));
                        return;
                    }else if($user->status==='active'){ //echo "You are already registered.If you forget the password.";
                        $this->render('test',array('error'=>'User with id ' . $user->user_id . ' is already active. Redirect home'));
                        return;
                    }else{
                        $this->render('test',array('error'=>'User with id ' . $user->user_id . ' already registered, redirect to school_select'));
                        return;
                    }
                }else{
                    //Create user in the DB then redirect the to school select
                    $user = new User;
                    $user->user_email = $email;
                    $user->user_type = $user_type;
                    $user->firstname = $firstname;
                    $user->lastname = $lastname;
                    //$user->school_id = null;
                    $user->school_id = null;
                    //$user->department_id = null;
                    $user->department_id = null;
                    $user->status = 'temp';
                    $user->save(false);


                    $salt = salt();
                    $hashed_password = hash_password($password,$salt);

                    $user_login = new UserLogin;
                    $user_login->user_id = $user->user_id;
                    $user_login->password = $hashed_password;
                    $user_login->salt = $salt;
                    $user_login->save(false);

                    Yii::app()->session['user_id'] = $user->user_id;


                    //Redirect to home page for now

                    $this->render('test',array('error'=>'User with id ' . $user->user_id . ' was created'));
                    return;
                    //$this->redirect(Yii::app()->getBaseUrl(true) . '/');

                    //->redirect(Yii::app()->getBaseUrl(true) . '/register/school_select');
                }
            }else{
                $this->render('test',array('error'=>'invalid user type'));
                return;
            }



        }else{
            $this->render('test',array('error'=>'A parameter is not set'));
            return;
        }

    }




    public function actionTimezone() {
        if(!$this->authenticated()){
            $data = array('error'=>'not authenticated');
            $this->renderJSON($data);
            return;
        }
        if(!isset($_GET['timezone'])){
            $data = array('error'=>'timezone not set');
            $this->renderJSON($data);
            return;
        }

        Yii::app()->session['timezone'] = $_GET['timezone'];


        $data = array('timezone'=>Yii::app()->session['timezone']);
        $this->renderJSON($data);
        return;
    }


    public function actionFileUpload() {

        include "file_upload.php";



        $data = file_upload($_FILES);
        $this->renderJSON($data);
        return;

//        $user = User::model()->find('user_id=:id', array(':id'=>1));
//
//
//
////        if(!isset($_POST['origin_type'])){
////            $this->renderJSON(array('success'=>false,'msg'=>'origin_type is not set'));
////        }
////
////        if(!isset($_POST['origin_id'])){
////            $this->renderJSON(array('success'=>false,'msg'=>'origin_id is not set'));
////        }
//
//
//
////        $origin_type = $_POST['origin_type'];
////        $origin_id = $_POST['origin_id'];
//
//
//
//        //["name"]
//        if(isset($_FILES["uploadFile"])){
//            include "UniqueTokenGenerator.php";
//
//            $path_parts = pathinfo($_FILES["uploadFile"]["name"]);
//            $extension = $path_parts['extension'];
//            $file_type = $this->getFileMimeType($_FILES["uploadFile"]['tmp_name']);
//            $random_name = token($user->user_id,$user->firstname);
//
//            if($extension == 'jpg' || $extension == 'png' || $extension == 'gif'){
//                include "ImageCompress.php";
//                image_compress($_FILES["uploadFile"]["tmp_name"], 'assets/test/' . $random_name . '.jpg', 50);
//            } else{
//                move_uploaded_file($_FILES["uploadFile"]["tmp_name"], 'assets/test/' . $_FILES["uploadFile"]["name"]);
//            }
//
//
//            //Create file in file table here
//            $file = new File;
//            $file->file_name = $random_name . '.' . $extension;
//            $file->file_url = $file_url = "/assets/" . $random_name . '.' . $extension;
//            $file->file_type = $file_type;
//            $file->file_extension = $extension;
//
//            $file->save(false);
//            //Use the origin and id to add files either to associative table or to a main field
//
//            //$this->renderJSON(array('success'=>true,'file_type'=>$file_type,'file_id'=>$file->file_id,'file_name'=>$random_name . '.' . $extension,'origin_type'=>$origin_type,'origin_id'=>$origin_id,'extension'=>$extension));
//            $this->renderJSON(array('success'=>true,'file_type'=>$file_type,'file_id'=>$file->file_id,'file_name'=>$random_name . '.' . $extension,'file_url'=>$file->file_url,'extension'=>$extension));
//
//        }else {
//            $this->renderJSON(array('success'=>false));
//        }




    }






}