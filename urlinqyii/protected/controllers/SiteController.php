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



    function send_verification_email($to_email, $subject, $message, $from_email, $data){

        $mail = new YiiMailer('confirmation', $data);

        $mail->setFrom($from_email, 'urlinq team');
        $mail->setSubject($subject);
        $mail->setTo($to_email);


        //$mail->SMTPDebug = 1;

        return $mail->send();

//        if($mail->send()){
//            return true;
//        }else{
//            $data = array('success'=>false,'error_id'=>6,'error_msg'=>$mail->getError());
//            $this->renderJSON($data);
//            return;
//        }

    }




    public function actionVerify(){
        if(!isset($_GET['key'])){
            $data = array('success'=>false,'error_id'=>1, 'error_msg'=> 'key not set');
            $this->renderJSON($data);
            return;
        }

        $key = $_GET['key'];

        $user_confirmation = UserConfirmation::model()->find('key_email=:key',array(':key'=>$key));
        if($user_confirmation){
            $user_id = $user_confirmation->user_id;

            $user = User::model()->find('user_id=:id',array(':id'=>$user_id));
            if($user){
                //User has successfully verified.
                //Set their status to onboarding so we know they
                //still have some steps to complete
                $user->status = 'onboarding';

                if($user->save(false)){
                    //Delete user_confirmation for this user
                    if($user_confirmation->delete()){

                        //If the user confirmation was successful, redirect back to
                        //onboarding at step 3
                        Yii::app()->session['onboarding_step'] = 3;
                        Yii::app()->session['department_id'] = $user->department_id;
                        Yii::app()->session['school_id'] = $user->school_id;
                        $this->redirect(Yii::app()->getBaseUrl(true) . '/onboard');
                        return;
                    }else{
                        $data = array('success'=>false,'error_id'=>6,'error_msg'=>'Error deleting user confirmation');
                        $this->renderJSON($data);
                        return;
                    }
                }else{
                    $data = array('success'=>false,'error_id'=>5,'error_msg'=>'Error saving user');
                    $this->renderJSON($data);
                    return;
                }
            }else{
                $data = array('success'=>false,'error_id'=>3,'error_msg'=>'User is not valid');
                $this->renderJSON($data);
                return;
            }
        }else{
            $data = array('success'=>false,'error_id'=>2 , 'error_msg'=> 'invalid key');
            $this->renderJSON($data);
            return;
        }


    }

    public function actionSendVerificationEmail(){
        if(!isset($_POST['school_id']) || !isset($_POST['department_id']) || !$this->get_current_user_id()){
            $data = array('success'=>false,'error_id'=>1);
            $this->renderJSON($data);
            return;
        }

        $school_id = $_POST['school_id'];
        $department_id = $_POST['department_id'];

        $school = School::model()->find('school_id=:id',array(':id'=>$school_id));
        $department = Department::model()->find('department_id=:id',array(':id'=>$department_id));

        if(!$school || !$department){
            $data = array('success'=>false,'error_id'=>2,'error_msg'=>'school or department doesnt exist');
            $this->renderJSON($data);
            return;
        }

        if($department->school_id != $school->school_id){
            $data = array('success'=>false,'error_id'=>3,'error_msg'=>'department is not in school');
            $this->renderJSON($data);
            return;
        }

        $user = $this->get_current_user();

        if($user){
            $user->school_id = $school_id;
            $user->department_id = $department_id;

            if($user->save(false)){


                //Check if this user already has a user confirmation
                $user_confirmation_test = UserConfirmation::model()->find('user_id=:id',array(':id'=>$user->user_id));
                if($user_confirmation_test){
                    //If the user already has a confirmation, send another email with the same token
                    $user_email = $user->user_email;
                    $subject = 'Urlinq verification email';
                    $message = Yii::app()->getBaseUrl(true) . '/verify?key=' . $user_confirmation_test->key_email;
                    $from = 'team@urlinq.com';
                    $email_data = array('key'=>$user_confirmation_test->key_email);
                    if($this->send_verification_email($user_email, $subject, $message, $from, $email_data)){
                        //Function is done
                        return;
                    }else{
                        $data = array('success'=>false,'error_id'=>7,'error_msg'=>'error sending email');
                        $this->renderJSON($data);
                        return;
                    }
                }else{
                    //If there isnt already a user confirmation,
                    //create a new one
                    include_once 'UniqueTokenGenerator.php';
                    //Create a user_confirmation for this user
                    $user_confirmation = new UserConfirmation;
                    $user_confirmation->key_email = token();
                    $user_confirmation->user_id = $user->user_id;

                    if($user_confirmation->save(false)){
                        $user_email = $user->user_email;
                        $subject = 'Urlinq verification email';
                        $message = Yii::app()->getBaseUrl(true) . '/verify?key=' . $user_confirmation->key_email;
                        $from = 'team@urlinq.com';
                        $email_data = array('key'=>$user_confirmation->key_email);
                        if($this->send_verification_email($user_email, $subject, $message, $from, $email_data)){
                            //Function is done
                            return;
                        }else{
                            $data = array('success'=>false,'error_id'=>7,'error_msg'=>'error sending email');
                            $this->renderJSON($data);
                            return;
                        }
                    }else{
                        $data = array('success'=>false,'error_id'=>6,'error_msg'=>'error saving user confirmation');
                        $this->renderJSON($data);
                        return;
                    }
                }
            }else{
                $data = array('success'=>false,'error_id'=>5,'error_msg'=>'error saving user');
                $this->renderJSON($data);
                return;
            }
        }else{
            $data = array('success'=>false,'error_id'=>4,'error_msg'=>'user not defined');
            $this->renderJSON($data);
            return;
        }







        $data = array('success'=>true);
        $this->renderJSON($data);
        return;
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
        $this->render('home_test',array('test_str'=>$test_str));
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

    public function actionSuggestUsers(){
        if(!$this->authenticated()){
            $this->redirect(Yii::app()->getBaseUrl(true) . '/');
        }

        $user_rankings = array();



        $user= $this->get_current_user();
      // var_dump($user->user_id);
        foreach($user->classes as $class){
         //   var_dump($user->classes);
            foreach($class->users as $class_user){
                if($class_user->user_id != $user->user_id){
                    if(isset($user_rankings[$class_user->user_id])){
                        $user_rankings[$class_user->user_id] += 1;
                    }else{
                        $user_rankings[$class_user->user_id] = 1;
                    }
                }
            }
        }

        foreach($user->groups as $group){
            //   var_dump($user->classes);
            foreach($group->users as $group_user){
                if($group_user->user_id != $user->user_id){
                    if(isset($user_rankings[$group_user->user_id])){
                        $user_rankings[$group_user->user_id] += 1;
                    }else{
                        $user_rankings[$group_user->user_id] = 1;
                    }
                }
            }
        }
        foreach($user->usersFollowed as $userFollowed){
          //  var_dump($userFollowed);
            foreach($userFollowed->usersFollowed as $followed_user){
              if($followed_user->user_id!= $user->user_id) {
                  if (isset($user_rankings[$followed_user->user_id])) {
                      $user_rankings[$followed_user->user_id] += 1;
                  } else {
                      $user_rankings[$followed_user->user_id] = 1;
                  }
              }
            }

        }
        $data = array('success'=>true,'rankings'=>$user_rankings);


        $this->renderJSON($data);
        return;
//        $users_same_class = User::model()->find('class_id=:class_id', array(':class_id'=>$class->));
//        $users_same_club = User::model()->find('club_id=:club_id', array(':club_id'=>$user->club_id));





    }



    public function actionOnboard(){
        $user = $this->get_current_user();
        //If this user is already active, redirect to home page
        if($user && $user->status == 'active'){
            $this->redirect(Yii::app()->getBaseUrl(true) . '/home');
        }


        //Check the required session variables
        //If they are not all set, redirect back to the login/signup page
        $first_name = Yii::app()->session['first_name'];
        $last_name = Yii::app()->session['last_name'];
        $user_type = Yii::app()->session['user_type'];
        $email = Yii::app()->session['email'];
        $password = Yii::app()->session['password'];


        if(!$first_name || !$last_name || !$user_type || !$email || !$password){
            $this->redirect(Yii::app()->getBaseUrl(true) . '/');
        }





        $this->render('onboard',array());
    }



    public function actionRegister(){

        if(isset($_POST['password']) ||isset($_POST['firstname']) ||isset($_POST['lastname']) ||isset($_POST['account_types']) ||isset($_POST['email'])){
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $user_type = $_POST['account_types'];
            $password = $_POST['password'];

            if($firstname == '' || $lastname == '' || $user_type == '' || $email == ''){
                $data = array('success'=>false,'error_id'=>2);
                $this->renderJSON($data);
                return;
            }

            if(strlen($password) < 6){
                $data = array('success'=>false,'error_id'=>3, 'error'=>'Password is too short');
                $this->renderJSON($data);
                return;
            }

            if(strpos($firstname,$password) > 0){
                $data = array('success'=>false,'error_id'=>4, 'error'=>'Password cant be in name');
                $this->renderJSON($data);
                return;
            }

            if(strpos($lastname,$password) > 0){
                $data = array('success'=>false,'error_id'=>5, 'error'=>'password cant be in lastname');
                $this->renderJSON($data);
                return;
            }

            if(strpos($email,'nyu.edu') == false){
                if(strpos($email,'poly.edu')){
                    $data = array('success'=>false,'error_id'=>6, 'error'=>'password cant be in lastname', 'error'=>'Poly emails are not accepted at this time');
                    $this->renderJSON($data);
                    return;
                }else if(strpos($email,'.edu')){
                    $data = array('success'=>false,'error_id'=>6, 'error'=>'password cant be in lastname', 'error'=>'Only NYU emails are accepted at this time');
                    $this->renderJSON($data);
                    return;
                }else{
                    $data = array('success'=>false,'error_id'=>6, 'error'=>'password cant be in lastname', 'error'=>'.edu email must be used');
                    $this->renderJSON($data);
                    return;
                }
            }








//            $user = User::model()->find('user_email=:user_email',array(':user_email'=>$email));
//

            Yii::app()->session['onboarding_step'] = -1;
            //Yii::app()->session->destroy();


            Yii::app()->session['first_name'] = $firstname;
            Yii::app()->session['last_name'] = $lastname;
            Yii::app()->session['user_type'] = $user_type;
            Yii::app()->session['email'] = $email;
            Yii::app()->session['password'] = $password;
            Yii::app()->session['user_type'] = $user_type;



            include "password_encryption.php";

            if($user_type == 'p'){
                $professor = User::model()->find("user_email=:user_email",array(":user_email"=>$email));
                if($professor){
                    $_SESSION['user_id']= $professor->user_id;
                    $_SESSION['professor'] = 1;


                    $data = array('success'=>false,'error_id'=>6, 'error'=>'Professor with id ' . strval($_SESSION['user_id']) . 'exists');
                    $this->renderJSON($data);
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


                    $data = array('success'=>false,'error_id'=>6, 'error'=>'Professor with id ' . strval($_SESSION['user_id']) . ' was created');
                    $this->renderJSON($data);
                    return;

                    //$this->redirect(Yii::app()->getBaseUrl(true) . '/professor_verify');
                }
            }elseif($user_type == 's'){
                //Check if the user is already in the database
                $user = User::model()->find("user_email=:user_email",array(":user_email"=>$email));
                if($user){
                    Yii::app()->session['user_id'] = $user->user_id;


                    if($user->status === 'invited'){
                        $data = array('success'=>true);
                        $this->renderJSON($data);
                        return;
                    }else if($user->status === 'unverified'){
                        $data = array('success'=>true);
                        $this->renderJSON($data);
                        return;
                    }else if($user->status==='active'){

                        $data = array('success'=>false, 'error_id'=>10, 'error_msg'=>'user has already completed onboarding.');
                        $this->renderJSON($data);
                        return;
                    }else{
                        $data = array('success'=>true);
                        $this->renderJSON($data);
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
                    $user->status = 'unverified';
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

                    $data = array('success'=>true, 'msg'=>'new user was created');
                    $this->renderJSON($data);
                    return;

                    //$this->redirect(Yii::app()->getBaseUrl(true) . '/');

                    //->redirect(Yii::app()->getBaseUrl(true) . '/register/school_select');
                }
            }else{
                $this->render('test',array('error'=>'invalid user type'));
                return;
            }



        }else{
            $data = array('success'=>false,'error_id'=>1);
            $this->renderJSON($data);
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