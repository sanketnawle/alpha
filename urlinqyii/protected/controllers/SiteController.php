<?php


Yii::import('ext.runactions.components.ERunActions');
ERunActions::runBackground(true);


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


        Yii::app()->nodeSocket->registerClientScripts();
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
        $test_str = 'Testing passing data from controller to front end';


        if($this->authenticated()){
            $this->redirect(array('/home'));
        }

        $redirect_url = '';
        if(isset($_GET['url'])){
            $redirect_url = $_GET['url'];
        }




        //Can specify specific layout inside view
        //$this->layout = 'new';
		$this->render('lp_beta',array('test_str'=>$test_str, 'redirect_url'=>$redirect_url));
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
        $show_tutorial_button= false;
        $show_fbar_tutorial="";
        $show_profile_tutorial="";
        $show_planner_tutorial="";
        $first_time=true;
        if($user->show_fbar_tutorial){
            $show_fbar_tutorial = "show_fbar_tutorial";
            //$show_tutorial_button = true;
        }else{
            $first_time=false;
        }
        if($user->show_planner_tutorial){
            $show_planner_tutorial = "show_planner_tutorial";
            //$show_tutorial_button = true;
        }else{
            $first_time=false;
        }






        if(isset($_GET['event_id']) && isset($_GET['event_option'])){
            $this->check_event_option($user,$_GET);
        }


        if(isset($_GET['question_option_id'])){
            $this->check_question_option($user,$_GET);
        }




       /* if($user->show_profile_tutorial){
            $show_planner_tutorial = "show_profile_tutorial";
            //$show_tutorial_button = true;
        }else{
            $first_time=false;
        }*/
        //Can specify specific layout inside view
        //$this->layout = 'new';
        $this->render('home',array('user'=>$user
            ,'show_fbar_tutorial'=>$show_fbar_tutorial,'show_planner_tutorial'=>$show_planner_tutorial, 'first_time'=>$first_time));
    }

    public function actionCompleteTutorial(){

        $user = $this->get_current_user($_POST);

        if(!$user){
            $data = array('success'=>false,'error_id'=>2, 'error_msg'=>'user is not logged in');
            $this->renderJSON($data);
            return;
        }

        if(!isset($_POST['tutorial_num'])){
            $data = array('success'=>false,'error_id'=>3, 'error_msg'=>'tutorial num not set');
            $this->renderJSON($data);
            return;
        }
        $tutorial_num = $_POST['tutorial_num'];

        if($tutorial_num==1){
            $user->show_profile_tutorial = 0;
        }else if($tutorial_num==2){
            $user->show_planner_tutorial = 0;
        }else if($tutorial_num==3){
            $user->show_fbar_tutorial = 0;
        }
        if($user->save(false)){
            $data = array('success'=>true);
            $this->renderJSON($data);
            return;
        }else{
            $data = array('success'=>false,'error_msg'=>'error saving');
            $this->renderJSON($data);
            return;
        }


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



    function actionSendResetPasswordEmailFunction(){


        if(!isset($_POST['to_email']) || !isset($_POST['subject']) || !isset($_POST['message']) || !isset($_POST['from_email']) || !isset($_POST['key'])){
            $data = array('success'=>false,'error_id'=>1, 'error_msg'=> 'all post data not set', 'post'=>$_POST);
            $this->renderJSON($data);
            return;
        }

        $key = $_POST['key'];
        $to_email = $_POST['to_email'];
        $subject = $_POST['subject'];
        $from_email = $_POST['from_email'];
        $message = $_POST['message'];


        if (ERunActions::runBackground())
		{


            ERunActions::runScript('send_reset_password_email',$params=array('to_email'=>$to_email, 'subject'=>$subject, 'message'=>$message, 'from_email'=>$from_email, 'key'=>$key),$scriptPath=null);

            Yii::log('lol wtf');

            $data = array('success'=>true,'error_id'=>'run');
            $this->renderJSON($data);
            return;
		}
		else
		{

		}
    }







    function actionSendVerificationEmailFunction(){


        if(!isset($_POST['to_email']) || !isset($_POST['subject']) || !isset($_POST['message']) || !isset($_POST['from_email']) || !isset($_POST['key'])){
            $data = array('success'=>false,'error_id'=>1, 'error_msg'=> 'all post data not set', 'post'=>$_POST);
            $this->renderJSON($data);
            return;
        }

        $key = $_POST['key'];
        $to_email = $_POST['to_email'];
        $subject = $_POST['subject'];
        $from_email = $_POST['from_email'];
        $message = $_POST['message'];


        if (ERunActions::runBackground())
		{


            ERunActions::runScript('send_verification_email',$params=array('to_email'=>$to_email, 'subject'=>$subject, 'message'=>$message, 'from_email'=>$from_email, 'key'=>$key),$scriptPath=null);

            Yii::log('lol wtf');

            $data = array('success'=>true,'error_id'=>'run');
            $this->renderJSON($data);
            return;
		}
		else
		{

		}
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

                if($user->user_type == 's'){
                    $user->status = 'active';
                }else{
                    $user->status = 'onboarding';
                }

                if($user->save(false)){
                    //Delete user_confirmation for this user
                    if($user_confirmation->delete()){

                        //If the user confirmation was successful, redirect back to
                        //onboarding at step 3
                        Yii::app()->session['onboarding_step'] = 3;
                        Yii::app()->session['department_id'] = $user->department_id;
                        Yii::app()->session['school_id'] = $user->school_id;
                        Yii::app()->session['user_type'] = $user->user_type;
                        Yii::app()->session['user_id'] = $user_id;


                        if($user->user_type == 's'){
                            $this->redirect(Yii::app()->getBaseUrl(true) . '/home');
                        }else{
                            $this->redirect(Yii::app()->getBaseUrl(true) . '/onboard');
                        }

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


    public function actionResendVerificationEmail(){

        $user = $this->get_current_user();

        if(!$user){
            $data = array('success'=>false,'error_id'=>2,'error_msg'=>'user not defined');
            $this->renderJSON($data);
            return;
        }


        //Check if this user already has a user confirmation
        $user_confirmation_test = UserConfirmation::model()->find('user_id=:id',array(':id'=>$user->user_id));
        if($user_confirmation_test){
            //If the user already has a confirmation, send another email with the same token
            $user_email = $user->user_email;
            $subject = 'Urlinq verification email';
            $message = Yii::app()->getBaseUrl(true) . '/verify?key=' . $user_confirmation_test->key_email;
            $from = 'team@urlinq.com';


            ERunActions::touchUrl(Yii::app()->getBaseUrl(true) . '/site/sendVerificationEmailFunction',$postData=array('to_email'=>$user_email, 'subject'=>$subject, 'message'=>$message, 'from_email'=>$from, 'key'=>$user_confirmation_test->key_email),$contentType=null);
            //ERunActions::runScript('send_verification_email',$params=array('to_email'=>$user_email, 'subject'=>$subject, 'message'=>$message, 'from_email'=>$from, 'key'=>$user_confirmation_test->key_email),$scriptPath=null);
            //ERunActions::runAction('site/sendVerificationEmailFunction',$params=array(),$ignoreFilters=true,$ignoreBeforeAfterAction=true,$logOutput=true,$silent=false);


            $data = array('success'=>true);
            $this->renderJSON($data);
            return;
//            if($this->send_verification_email($user_email, $subject, $message, $from, $email_data)){
//                //Function is done
//                $data = array('success'=>true);
//                $this->renderJSON($data);
//                return;
//            }else{
//                $data = array('success'=>false,'error_id'=>7,'error_msg'=>'error sending email');
//                $this->renderJSON($data);
//                return;
//            }
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

                ERunActions::touchUrl(Yii::app()->getBaseUrl(true) . '/site/sendVerificationEmailFunction',$postData=array('to_email'=>$user_email, 'subject'=>$subject, 'message'=>$message, 'from_email'=>$from, 'key'=>$user_confirmation->key_email),$contentType=null);
                //ERunActions::runScript('send_verification_email',$params=array('to_email'=>$user_email, 'subject'=>$subject, 'message'=>$message, 'from_email'=>$from, 'key'=>$user_confirmation_test->key_email),$scriptPath=null);
                //ERunActions::runAction('site/sendVerificationEmailFunction',$params=array(),$ignoreFilters=true,$ignoreBeforeAfterAction=true,$logOutput=true,$silent=false);


                $data = array('success'=>true);
                $this->renderJSON($data);
                return;
//                if($this->send_verification_email($user_email, $subject, $message, $from, $email_data)){
//                    //Function is done
//                    return;
//                }else{
//                    $data = array('success'=>false,'error_id'=>7,'error_msg'=>'error sending email');
//                    $this->renderJSON($data);
//                    return;
//                }
            }else{
                $data = array('success'=>false,'error_id'=>6,'error_msg'=>'error saving user confirmation');
                $this->renderJSON($data);
                return;
            }
        }




    }




    public function actionSendUrlinqInviteEmailFunction(){

        if(!isset($_POST['to_email']) || !isset($_POST['from_email']) || !isset($_POST['actor_id'])){
            $data = array('success'=>false,'error_id'=>1, 'error_msg'=> 'all post data not set', 'post'=>$_POST);
            $this->renderJSON($data);
            return;
        }


        $to_email = $_POST['to_email'];
        $from_email = $_POST['from_email'];


        $actor_id = $_POST['actor_id'];
//
//        $actor = $this->get_current_user($_POST);
//



        $actor = User::model()->find('user_id=:user_id', array(':user_id'=>$actor_id));

        if(!$actor){
            $data = array('success'=>false,'error_id'=>2, 'error_msg'=> 'invalid actor', 'post'=>$_POST);
            $this->renderJSON($data);
            return;
        }



        if (ERunActions::runBackground())
        {

            ERunActions::runScript('send_invite_email',$params=array('to_email'=>$to_email, 'from_email'=>$from_email, 'actor'=>$actor),$scriptPath=null);

            Yii::log('Sending urlinq invite to ' . $to_email);

            $data = array('success'=>true,'error_id'=>'run');
            $this->renderJSON($data);
            return;
        }
        else
        {

            $data = array('success'=>false,'error_id'=>'error running in background');
            $this->renderJSON($data);
            return;

        }


    }






    public function actionSendUrlinqInviteEmail(){

        if(!isset($_POST['email']) || !isset($_POST['origin_type']) || !isset($_POST['origin_id'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'required data not set');
            $this->renderJSON($data);
            return;
        }

        $user = $this->get_current_user();

        if(!$user){
            $data = array('success'=>false,'error_id'=>2,'error_msg'=>'user not defined');
            $this->renderJSON($data);
            return;
        }




        $email = $_POST['email'];
        $origin_type = $_POST['origin_type'];
        $origin_id = $_POST['origin_id'];


        if(!$this->is_supported_email($email)){
            $data = array('success'=>false,'error_id'=>3,'error_msg'=>'Invalid email address');
            $this->renderJSON($data);
            return;
        }




        $from_email = 'team@urlinq.com';
        $actor_id = $user->user_id;

        ERunActions::touchUrl(Yii::app()->getBaseUrl(true) . '/site/sendUrlinqInviteEmailFunction',$postData=array('to_email'=>$email,'from_email'=>$from_email, 'actor_id'=>$actor_id),$contentType=null);


        $data = array('success'=>true);
        $this->renderJSON($data);
        return;
    }




    public function actionSendVerificationEmail(){
        if(!isset($_POST['school_id']) || !isset($_POST['department_id'])){
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

        if(isset($_POST['university_id'])){
            $university = University::model()->find('university_id=:id',array(':id'=>$_POST['university_id']));
            if(!$university){
                $data = array('success'=>false,'error_id'=>2,'error_msg'=>'university doesnt exist');
                $this->renderJSON($data);
                return;
            }
        }



        if($department->school_id != $school->school_id){
            $data = array('success'=>false,'error_id'=>3,'error_msg'=>'department is not in school');
            $this->renderJSON($data);
            return;
        }

        $user = $this->get_current_user();

        if($user){

            $send = false;

            if($user->user_type == 's'){
                if($user->status != 'active'){
                    $send = true;
                }
            }else{

                //If user is p or a
                if($user->status == 'active'){
                    $data = array('success'=>false, 'error_msg'=>'user is already verified', 'error_id'=>10);
                    $this->renderJSON($data);
                    return;

                }elseif($user->status = 'unverified'){
                    $send = true;
                }
            }




            if($send){
                $user->school_id = $school_id;
                $user->department_id = $department_id;
                if(!$user->university_id){
                    $user->university_id = $university->university_id;
                }

                if($user->save(false)){


                    //Check if this user already has a user confirmation
                    $user_confirmation_test = UserConfirmation::model()->find('user_id=:id',array(':id'=>$user->user_id));
                    if($user_confirmation_test){
                        //If the user already has a confirmation, send another email with the same token
                        $user_email = $user->user_email;
                        $subject = 'Urlinq verification email';
                        $message = Yii::app()->getBaseUrl(true) . '/verify?key=' . $user_confirmation_test->key_email;
                        $from = 'team@urlinq.com';


                        ERunActions::touchUrl(Yii::app()->getBaseUrl(true) . '/site/sendVerificationEmailFunction',$postData=array('to_email'=>$user_email, 'subject'=>$subject, 'message'=>$message, 'from_email'=>$from, 'key'=>$user_confirmation_test->key_email),$contentType=null);
                        //ERunActions::runScript('send_verification_email',$params=array('to_email'=>$user_email, 'subject'=>$subject, 'message'=>$message, 'from_email'=>$from, 'key'=>$user_confirmation_test->key_email),$scriptPath=null);
                        //ERunActions::runAction('site/sendVerificationEmailFunction',$params=array(),$ignoreFilters=true,$ignoreBeforeAfterAction=true,$logOutput=true,$silent=false);

                        $data = array('success'=>true);
                        $this->renderJSON($data);
                        return;

    //                    if($this->send_verification_email($user_email, $subject, $message, $from, $email_data)){
    //                        //Function is done
    //                        $data = array('success'=>true);
    //                        $this->renderJSON($data);
    //                        return;
    //                    }else{
    //                        $data = array('success'=>false,'error_id'=>7,'error_msg'=>'error sending email');
    //                        $this->renderJSON($data);
    //                        return;
    //                    }
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

                            ERunActions::touchUrl(Yii::app()->getBaseUrl(true) . '/site/sendVerificationEmailFunction',$postData=array('to_email'=>$user_email, 'subject'=>$subject, 'message'=>$message, 'from_email'=>$from, 'key'=>$user_confirmation->key_email),$contentType=null);
                            //ERunActions::runScript('send_verification_email',$params=array('to_email'=>$user_email, 'subject'=>$subject, 'message'=>$message, 'from_email'=>$from, 'key'=>$user_confirmation_test->key_email),$scriptPath=null);


                            //ERunActions::runAction('site/sendVerificationEmailFunction',$params=array(),$ignoreFilters=true,$ignoreBeforeAfterAction=true,$logOutput=true,$silent=false);

                            $data = array('success'=>true);
                            $this->renderJSON($data);
                            return;
    //
    //                        if($this->send_verification_email($user_email, $subject, $message, $from, $email_data)){
    //                            //Function is done
    //                            return;
    //                        }else{
    //                            $data = array('success'=>false,'error_id'=>7,'error_msg'=>'error sending email');
    //                            $this->renderJSON($data);
    //                            return;
    //                        }
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


            $redirect_url = null;
            if(isset($_POST['redirect_url'])){
                $redirect_url = $_POST['redirect_url'];
            }





            //Ross requested that we block these emails
            $blocked_emails = array('aa3225@nyu.edu', 'abhinay.ashutosh@nyu.edu');
            foreach($blocked_emails as $blocked_email){
                if($email == $blocked_email){
                    $data = array('success'=>false);
                    $this->renderJSON($data);
                    return;
                }
            }

            if(!$this->is_supported_email($email)){
                $data = array('success'=>false, 'error_id'=>2, 'error_msg'=>'This email is not supported');
                $this->renderJSON($data);
                return;
            }



            $user = User::model()->find('user_email=:user_email',array(':user_email'=>$email));


            if(!$user){
                $data = array('success'=>false, 'error_id'=>3, 'error_msg'=>'Account does not exist');
                $this->renderJSON($data);
                return;
            }





            $user_login = UserLogin::model()->find('user_id=:user_id',array(':user_id'=>$user->user_id));

            $salt = $user_login->salt;

            $hashed_password = hash_password($password,$salt);


            if($user_login->password == $hashed_password){

                //user has successfully logged in
                Yii::app()->session['user_id'] = $user->user_id;

                if($user->status == 'onboarding'){
                    //Send user to onboarding
                    $data = array('success'=>false, 'error_id'=>6, 'error_msg'=>'user has not completed onboarding');
                    $this->renderJSON($data);
                    return;
                }




                $data = array('success'=>true, 'redirect_url'=>$redirect_url);
                $this->renderJSON($data);
                return;
            }else{
                //user login failed
                $data = array('success'=>false, 'error_id'=>4, 'error_msg'=>'Invalid login');
                $this->renderJSON($data);
                return;
            }

		}

	}



    public function actionUnsubscribe() {
        if(!isset($_GET['email'])){
            $data = array('success'=>false, 'error_id'=>1, 'error_msg'=>'Email is not set');
            $this->renderJSON($data);
            return;
        }

        $email = $_GET['email'];

        $email_unsubscribe = EmailUnsubscribe::model()->find('email=:email', array(':email'=>$email));



        $success = false;

        if($email_unsubscribe){
            $success = true;
        }else{
            $email_unsubscribe = new EmailUnsubscribe;
            $email_unsubscribe->email = $email;
            if($email_unsubscribe->save(false)){
                $success = true;
            }
        }



        $this->render('unsubscribe',array('success'=>$success));

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



    public function actionMessages(){

        $user = $this->get_current_user();


        if(!$user){
            $this->redirect(Yii::app()->getBaseUrl(true) . '/');
        }



        //Default to /home
        $url = '';
        if(isset($_GET['url'])){
            $url = $_GET['url'];
        }


        //Flag to tell the javascript we are on the messaging page
        $messaging_page = 'true';



        $this->render('messages',array('user'=>$user, 'url'=>$url, 'messaging_page'=>$messaging_page));

    }



    public function actionOnboard(){
        $user = $this->get_current_user();


        if(!$user){
            $this->redirect(Yii::app()->getBaseUrl(true) . '/');
        }

        //If this user is already active, redirect to home page
        if($user && $user->status == 'active'){
            $this->redirect(Yii::app()->getBaseUrl(true) . '/home');
        }


        Yii::app()->session['onboarding_step'] = 0;

        //Take user directly to step 4
        if(($user->user_type == 'p' || $user->user_type == 'a') && Yii::app()->session['signin_type'] != "facebook" ){
            if($user->status == 'onboarding'){
                Yii::app()->session['onboarding_step'] = 3;
            }
        }



        $school = $user->school;
        if($school){
            //Skip the select class portion for Touro students
            if($school->university_id == 4){
                if($user->user_type == 's'){
                    Yii::app()->session['onboarding_step'] = 4;
                }else {
                    //Send the professors to class select
                    Yii::app()->session['onboarding_step'] = 3;
                }
            }
        }






        Yii::app()->session['department_id'] = $user->department_id;
        Yii::app()->session['school_id'] = $user->school_id;
        Yii::app()->session['user_type'] = $user->user_type;
        Yii::app()->session['user_id'] = $user->user_id;




        //Check the required session variables
        //If they are not all set, redirect back to the login/signup page
//        $first_name = Yii::app()->session['first_name'];
//        $last_name = Yii::app()->session['last_name'];
//        $user_type = Yii::app()->session['user_type'];
//        $email = Yii::app()->session['email'];
//        $password = Yii::app()->session['password'];
//        $user_id = Yii::app()->session['user_id'];
//
//
//
//
//        if(!$first_name || !$last_name || !$user_type || !$email || !$password || !$user_id){
//            $this->redirect(Yii::app()->getBaseUrl(true) . '/');
//        }





        $this->render('onboard',array());
    }

    public function actionFinishOnboarding(){


        if(!isset($_POST['classes']) || !isset($_POST['follow_users']) || !isset($_POST['clubs']) || !isset($_POST['gender']) || !isset($_POST['picture_file_id'])){
            $data = array('success'=>false, 'error_id'=>1);
            $this->renderJSON($data);
            return;
        }

        $user = $this->get_current_user();

        if(!$user){
            $data = array('success'=>false, 'error_id'=>2, 'error_msg'=>'error getting user');
            $this->renderJSON($data);
            return;
        }

        include_once "color/color.php";

        $classes = $_POST['classes'];
        $follow_users = $_POST['follow_users'];
        $clubs = $_POST['clubs'];
        $gender = $_POST['gender'];
        $picture_file_id = $_POST['picture_file_id'];

        if(isset($_POST['user_type'])){
            $user_type = $_POST['user_type'];
            $user->user_type = $user_type;
            if($user_type == "s"){
                $student_attribute = new StudentAttributes();
                $student_attribute->user_id = $user->user_id;
                $student_attribute->save(false);
            }else if($user_type == "p"){
                $professor_attribute = new ProfessorAttribute();
                $professor_attribute->professor_id = $user->user_id;
                $professor_attribute->designation = 'professor';
                $professor_attribute->save(false);
            }
        }
        $user_auth_provider = UserAuthProvider::model()->find('user_id=:id',array(':id'=>$user->user_id));
        if($user_auth_provider){
            if(strpos(".edu",$user_auth_provider->fb_email) > 0){
                $user->user_email = $user_auth_provider->fb_email;
            }
        }
        if(isset($_POST['school_email'])){
            $email = $_POST['school_email'];
            $prev_user = User::model()->find('user_email = :email',array(':email'=>$email));
            if(!$prev_user){
                $user->user_email = $email;
            }else{
                $data = array('success'=>false, 'error_id'=>5, 'error_msg'=>'email already exists');
                $this->renderJSON($data);
                return;
            }

        }



        if($gender != 'M' && $gender != 'F' && $gender != null){
            $data = array('success'=>false, 'error_id'=>3, 'error_msg'=>'invalid gender');
            $this->renderJSON($data);
            return;
        }



        //Custom solution for auto adding Touro students to their classes
        if($user->school->university_id == 4 && $user->user_type == 's'){
            $department = $user->department;
            if($department->department_name == 'Master of Biological & Physical Sciences' || $department->department_name == 'First Year Medical Student'){

                $first_year_masters_department = Department::model()->find('department_name=:name', array(':name'=>'First Year/Masters'));
                foreach($first_year_masters_department->courses as $course){
                    foreach($course->classes as $class){
                        $class_user = new ClassUser;
                        $class_user->class_id = $class->class_id;
                        $class_user->user_id = $user->user_id;
                        $class_user->color_id = get_random_color();
                        $class_user->save(false);


                        //Get all events for this class
                    }
                }
            }

            if($department->department_name == 'First Year Medical Student'){
                $_POST['graduation_date'] = '2018';
                //$department = Department::model()->find('department_name=:name', array(':name'=>'First Year Medical Student'));
                foreach($department->courses as $course){
                    foreach($course->classes as $class){
                        $class_user = new ClassUser;
                        $class_user->class_id = $class->class_id;
                        $class_user->user_id = $user->user_id;
                        $class_user->color_id = get_random_color();
                        $class_user->save(false);
                    }
                }
            }


            if($department->department_name == 'Master of Biological & Physical Sciences'){
                $_POST['graduation_date'] = '2015';
                //$department = Department::model()->find('department_name=:name', array(':name'=>'Master of Biological & Physical Sciences'));
                foreach($department->courses as $course){
                    foreach($course->classes as $class){
                        $class_user = new ClassUser;
                        $class_user->class_id = $class->class_id;
                        $class_user->user_id = $user->user_id;
                        $class_user->color_id = get_random_color();
                        $class_user->save(false);
                    }
                }
            }


            if($department->department_name == 'Second Year Medical Student'){
                $_POST['graduation_date'] = '2017';
                //$department = Department::model()->find('department_name=:name and university_id=:university_id', array(':name'=>$department->department_name));
                foreach($department->courses as $course){
                    foreach($course->classes as $class){
                        $class_user = new ClassUser;
                        $class_user->class_id = $class->class_id;
                        $class_user->user_id = $user->user_id;
                        $class_user->color_id = get_random_color();
                        $class_user->save(false);
                    }
                }
            }

//
//            else if($user->user_type == 'p'){
//
//            }



        }else{
            if($classes){
                foreach($classes as $class_id){
                    $class = ClassModel::model()->find('class_id=:id',array(':id'=>$class_id));
                    if($class){


                        if($user->user_type == 's' || $user->user_type == 'a'){
                            //Check if this already exists
                            $class_user = ClassUser::model()->find('user_id=:user_id and class_id=:class_id',array(':user_id'=>$user->user_id, ':class_id'=>$class_id));
                            if(!$class_user){
                                //See if this user is already in a class with the same course id
                                foreach($user->classes as $other_class){
                                    if($other_class->course_id == $class->course_id){
                                        $data = array('success'=>false, 'error_id'=>11, 'error_msg'=>'Already in a class with this course');
                                        $this->renderJSON($data);
                                        return;
                                    }
                                }



                                $class_user = new ClassUser;
                                $class_user->user_id = $user->user_id;
                                $class_user->class_id = $class_id;
                                $class_user->color_id = get_random_color();

                                if($user->user_type == 'p' || $user->user_type == 'a'){
                                    $class_user->is_admin = true;
                                }

                                if(!$class_user->save(false)){
                                    $data = array('success'=>false, 'error_id'=>5, 'error_msg'=>'Error saving class user');
                                    $this->renderJSON($data);
                                    return;
                                }
                            }
                        }elseif($user->user_type == 'p'){
                            //For now, trust that the user is who the say the are
                            //(since we know they atleast verified their email, its unlikely
                            //that the user is fake))
                            //and set class's professor to this user
                            //Also check if class id is null, because if its not
                            //theres a huge chance the correct professor has already been added to the database
                            if($class->professor_id == NULL){
                                $class->professor_id = $user->user_id;
                                if(!$class->save(false)){
                                    $data = array('success'=>false, 'error_id'=>6, 'error_msg'=>'Error updating professor id in class');
                                    $this->renderJSON($data);
                                    return;
                                }
                            }

                        }


                    }else{
                        $data = array('success'=>false, 'error_id'=>4, 'error_msg'=>'invalid class id');
                        $this->renderJSON($data);
                        return;
                    }
                }
            }else{

              /*  if($user->user_type == 'p'){
                    //Check if professor is the current professor of any classes.
                    //If not, return an error
                    $class = ClassModel::model()->find('professor_id=:id',array(':id'=>$user->user_id));
                    if(!$class){
                        $data = array('success'=>false, 'error_id'=>15, 'error_msg'=>'Professor must be a professor of atleast one class if they are to select no additional classes during onboarding');
                        $this->renderJSON($data);
                        return;
                    }
                }else if($user->user_type == 's'){
                    $data = array('success'=>false, 'error_id'=>10, 'error_msg'=>'must register in atleast one class');
                    $this->renderJSON($data);
                    return;
                }*/
            }
        }




        $this->add_to_zeta_beta_tau($user);


        if($follow_users){
            foreach($follow_users as $follow_user_id){

                $user_connection = UserConnection::model()->find('from_user_id=:from_user_id and to_user_id=:to_user_id',array(':from_user_id'=>$user->user_id, ':to_user_id'=>$follow_user_id));
                if(!$user_connection){
                    $user_connection = new UserConnection;
                    $user_connection->from_user_id = $user->user_id;
                    $user_connection->to_user_id = $follow_user_id;
                }

                if(!$user_connection->save(false)){
                    $data = array('success'=>false, 'error_id'=>6, 'error_msg'=>'error saving user connection');
                    $this->renderJSON($data);
                    return;
                }
            }
        }



        if($clubs){
            foreach($clubs as $group_id){
                $group = Group::model()->find('group_id=:id',array(':id'=>$group_id));
                if($group){

                    //Check if this already exists
                    $group_user = GroupUser::model()->find('user_id=:user_id and group_id=:group_id',array(':user_id'=>$user->user_id, ':group_id'=>$group_id));
                    if(!$group_user){
                        $group_user = new GroupUser;
                        $group_user->user_id = $user->user_id;
                        $group_user->group_id = $group_id;
                        $group_user->color_id = get_random_color();

                        if($user->user_type == 'p' || $user->user_type == 'a'){
                            $group_user->is_admin = true;
                        }

                        if(!$group_user->save(false)){
                            $data = array('success'=>false, 'error_id'=>5, 'error_msg'=>'Error saving group user');
                            $this->renderJSON($data);
                            return;
                        }
                    }

                }else{
                    $data = array('success'=>false, 'error_id'=>4, 'error_msg'=>'invalid group id');
                    $this->renderJSON($data);
                    return;
                }
            }
        }



        $user->gender = $gender;

        if($user->user_type == 'a' || $user->user_type == 'p'){
//            if(!isset($_POST['office_hours']) || !isset($_POST['office_location'])){
//                $data = array('success'=>false, 'error_id'=>7, 'error_msg'=>'professor data not set');
//                $this->renderJSON($data);
//                return;
//            }

            $office_location = '';
            $office_hours = '';
            $research_interests = '';
            $designation = 'professor';
            $admin_type = 'p';

            if(isset($_POST['office_hours'])){
                $office_hours = $_POST['office_hours'];
            }

            if(isset($_POST['office_location'])){
                $office_location = $_POST['office_location'];
            }

            if(isset($_POST['research_interests'])){
                $research_interests = $_POST['research_interests'];
            }

            if(isset($_POST['admin_type'])){
                $admin_type = $_POST['admin_type'];
                if($admin_type != 'p' && $admin_type != 'a'){
                    $data = array('success'=>false, 'error_id'=>13, 'error_msg'=>'invalid admin_type');
                    $this->renderJSON($data);
                    return;
                }
            }

//            $office_location = $_POST['office_location'];
//            $office_hours = $_POST['office_hours'];


            //Check if professor attributes already exist
            $professor_attribute = ProfessorAttribute::model()->find('professor_id=:id',array(':id'=>$user->user_id));
            if($professor_attribute){
                $professor_attribute->professor_id = $user->user_id;
                $professor_attribute->designation = 'professor';
                $professor_attribute->office_location = $office_location;
                $professor_attribute->office_hours = $office_hours;

                $user->user_type = $admin_type;

                if(!$professor_attribute->save(false)){
                    $data = array('success'=>false, 'error_id'=>16, 'error_msg'=>'Error saving professor data');
                    $this->renderJSON($data);
                    return;
                }
            }else{
                $professor_attribute = new ProfessorAttribute;
                $professor_attribute->professor_id = $user->user_id;
                $professor_attribute->designation = 'professor';
                $professor_attribute->office_location = $office_location;
                $professor_attribute->office_hours = $office_hours;


                $user->user_type = $admin_type;

                if(!$professor_attribute->save(false)){
                    $data = array('success'=>false, 'error_id'=>8, 'error_msg'=>'Error saving professor data');
                    $this->renderJSON($data);
                    return;
                }
            }



        } else if($user->user_type == 's'){
            if(isset($_POST['graduation_date'])) {
                $graduation_date = $_POST['graduation_date'];
            }else{
                $graduation_date = null;
            }


            $year_name = '';
            if($graduation_date == '2018'){
                $year_name = "Freshman";
            }elseif($graduation_date == '2017'){
                $year_name = "Sophomore";
            }elseif($graduation_date == '2016'){
                $year_name = "Junior";
            }elseif($graduation_date == '2015'){
                $year_name = "Senior";
            }





            $student_attribute = StudentAttributes::model()->find('user_id=:id',array(':id'=>$user->user_id));
            if($student_attribute){
                $student_attribute->user_id = $user->user_id;
                $student_attribute->year = $graduation_date;
                $student_attribute->year_name = $year_name;


                if(!$student_attribute->save(false)){
                    $data = array('success'=>false, 'error_id'=>16, 'error_msg'=>'Error saving student data');
                    $this->renderJSON($data);
                    return;
                }
            }else{
                $student_attribute = new StudentAttributes;
                $student_attribute->user_id = $user->user_id;
                $student_attribute->year = $graduation_date;
                $student_attribute->year_name = $year_name;


                if(!$student_attribute->save(false)){
                    $data = array('success'=>false, 'error_id'=>8, 'error_msg'=>'Error saving student data');
                    $this->renderJSON($data);
                    return;
                }
            }
        }

        if($user->picture_file_id == null || $user->picture_file_id == '1' || $user->picture_file_id == ''){
            $user->picture_file_id = $picture_file_id;
        }

        //Finally, change the user type to active
        //indicating that the user is done with onboarding

        if($user->status != 'active'){
            //Set this users status to "onboarded",
            //which is a temporary state for students where they
            //have not activated their email
            $user->status = 'onboarded';
        }

        //autoverify if signed up with facebook, and the email is already in our database (faculty)
        if(isset(Yii::app()->session['auto_verify']) && Yii::app()->session['auto_verify'] == true){
            $user->status = 'active';
        }


//        if($user->user_type == 's'){
//            if($user->status != 'active'){
//                //Set this users status to "onboarded",
//                //which is a temporary state for students where they
//                //have not activated their email
//                $user->status = 'onboarded';
//            }
//        }else{
//            $user->status = 'active';
//        }

        if($user->save(false)){
            $data = array('success'=>true);
            $this->renderJSON($data);
            return;
        }else{
            $data = array('success'=>false, 'error_id'=>9, 'error_msg'=>'error updating user');
            $this->renderJSON($data);
            return;
        }



    }
    //creates a record of a file from a link
    function fileFromLink($url, $path, $user_id){
        //example of path: 'uploads/preview/'
        $user = User::model()->find('user_id=:id', array(':id'=>$user_id));

        include "UniqueTokenGenerator.php";
        //preg_match('/[.]([a-zA-Z]{3,4})$/',$url,$match);
        $path_parts = pathinfo(basename($url));
        if(isset($path_parts['extension'])){
            $extension = $path_parts['extension'];
        }
        else{
            $extension = 'jpg';
        }
        $question_mark_index = strpos($extension,'?');
        if($question_mark_index != false){
            $extension = substr($extension,0,$question_mark_index);
        }

      /*  $question_mark_index = strpos($url,'?');
        if($question_mark_index != false){
            $url = substr($url,0,$question_mark_index);
        }*/
        //$extension = $match[1];


        //$file_type = getFileMimeType($files["uploadFile"]['tmp_name']);
        $file_type = $extension; //temporary
        $random_name = token($user->user_id,$user->firstname);

        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );

        $local_directory = 'assets/'.$path;
        if(!is_dir($local_directory)) {
            mkdir($local_directory);
        }
        $get_file = file_get_contents($url,false,stream_context_create($arrContextOptions));
        if($get_file){
            file_put_contents($local_directory . $random_name .'.' .  $extension, $get_file);
        }
        else{
            return $url;
        }

        if($extension == 'jpg' || $extension == 'png' || $extension == 'gif'){
            include "ImageCompress.php";
            @image_compress($local_directory . $random_name .'.' .  $extension, $local_directory . $random_name . '.jpg', 50);
            if($extension != 'jpg'){
                unlink($local_directory . $random_name .'.' .  $extension);
            }

            $extension = 'jpg';
        }


        //Create file in file table here
        $file = new File;
        $file->file_name = $random_name . '.' . $extension;
        $file->file_url = $file_url = "/" . $local_directory . $random_name . '.' . $extension;
        $file->file_type = $file_type;
        $file->file_extension = $extension;
        if($file->save(false)){
            return array('success'=>true,'file_type'=>$file_type,'file_id'=>$file->file_id,'file_name'=>$random_name . '.' . $extension,
                'file_url'=>$file->file_url,'extension'=>$extension);
        }else{
            return array('success'=>false,'error_msg'=>'error saving file');
        }

        //Use the origin and id to add files either to associative table or to a main field

        //$this->renderJSON(array('success'=>true,'file_type'=>$file_type,'file_id'=>$file->file_id,'file_name'=>$random_name . '.' . $extension,'origin_type'=>$origin_type,'origin_id'=>$origin_id,'extension'=>$extension));
        //$this->renderJSON(array('success'=>true,'file_type'=>$file_type,'file_id'=>$file->file_id,'file_name'=>$random_name . '.' . $extension,'file_url'=>$file->file_url,'extension'=>$extension));


    }

    public function actionSaveFacebookProfilePicture(){
        if(!isset($_POST['url'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'url not set');
            $this->renderJSON($data);
            return;
        }
        $user = $this->get_current_user($_POST);
        if(!$user){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'user doesnt exist');
            $this->renderJSON($data);
            return;
        }
        $picture_data = $this->fileFromLink($_POST['url'],'profile/',$user->user_id);
        $this->renderJSON($picture_data);
        echo $picture_data;
        return;
    }



    function add_default_user_events($user){
        include_once 'color/color.php';
        $default_events = Event::model()->findAll('event_type="NYU Event"');

        foreach($default_events as $event){
            $event_user = new EventUser;
            $event_user->event_id = $event->event_id;
            $event_user->user_id = $user->user_id;
            $event_user->color_id = get_random_color();
            $event_user->save(false);
        }
    }

    public function actionRegister(){

        if(isset($_POST['password']) ||isset($_POST['firstname']) ||isset($_POST['lastname']) ||isset($_POST['account_types']) ||isset($_POST['email'])){
            $firstname = ucfirst($_POST['firstname']);
            $lastname = ucfirst($_POST['lastname']);
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


            //Ross requested that we block these emails
            $blocked_emails = array('aa3225@nyu.edu', 'abhinay.ashutosh@nyu.edu');
            foreach($blocked_emails as $blocked_email){
                if($email == $blocked_email){
                    $data = array('success'=>false);
                    $this->renderJSON($data);
                    return;
                }
            }

            if(!$this->is_supported_email($email)){
                if(strpos($email,'poly.edu')){
                    $data = array('success'=>false,'error_id'=>6, 'error'=>'Poly emails are not accepted at this time');
                    $this->renderJSON($data);
                    return;
                }else if(strpos($email,'.edu')){
                    $data = array('success'=>false,'error_id'=>6, 'error'=>'Only NYU emails are accepted at this time');
                    $this->renderJSON($data);
                    return;
                }else{
                    $data = array('success'=>false,'error_id'=>6, 'error'=>'.edu email must be used');
                    $this->renderJSON($data);
                    return;
                }
            }
            $university_id = $this->get_university_id_by_email($email);






//            $user = User::model()->find('user_email=:user_email',array(':user_email'=>$email));
//

            Yii::app()->session['onboarding_step'] = -1;
            //Yii::app()->session->destroy();

            Yii::app()->session['university_id'] = $university_id;
            Yii::app()->session['first_name'] = $firstname;
            Yii::app()->session['last_name'] = $lastname;
            Yii::app()->session['user_type'] = $user_type;
            Yii::app()->session['email'] = $email;
            Yii::app()->session['password'] = $password;
            Yii::app()->session['user_type'] = $user_type;



            include "password_encryption.php";

            if($user_type == 'p' || $user_type == 'a'){
                $professor = User::model()->findBySql("SELECT * FROM `user` LEFT JOIN `professor_attribute` ON (user.user_id = professor_attribute.professor_id) WHERE LOWER(user.user_email) LIKE LOWER('" . $email . "') OR LOWER(professor_attribute.alternate_email) LIKE LOWER('" . $email . "') LIMIT 1");
                if($professor){
                    //Professor is already in our database

                    if($professor->firstname == '' || $professor->lastname == ''){
                        $professor->firstname = $firstname;
                        $professor->lastname = $lastname;
                    }

                    if($professor->status == 'active' || $professor->status == 'onboarded'){
                        $user_login = UserLogin::model()->find('user_id=:user_id',array(':user_id'=>$professor->user_id));


                        $salt = $user_login->salt;

                        $hashed_password = hash_password($password,$salt);


                        if($user_login->password == $hashed_password){
                            //user has successfully logged in
                            Yii::app()->session['user_id'] = $professor->user_id;
                            Yii::app()->session['user_type'] = $user_type;
                            $data = array('success'=>false, 'error_id'=>10, 'error_msg'=>'user has already completed onboarding.');
                            $this->renderJSON($data);

                            return;
                        }else{
                            //user login failed
                            $data = array('success'=>false, 'error_id'=>11, 'error_msg'=>'Email already registered');
                            $this->renderJSON($data);
                            return;
                        }
                    }else{

                        $user_login = UserLogin::model()->find('user_id=:id', array(':id'=>$professor->user_id));

                        if(!$user_login){
                            $salt = salt();
                            $hashed_password = hash_password($password,$salt);

                            $user_login = new UserLogin;
                            $user_login->user_id = $professor->user_id;
                            $user_login->password = $hashed_password;
                            $user_login->salt = $salt;
                            $user_login->save(false);
                        }


                        Yii::app()->session['user_id'] = $professor->user_id;
                        Yii::app()->session['user_type'] = $user_type;


                        if($professor->school_id && $professor->department_id){
                            Yii::app()->session['onboarding_step'] = 2; //Take the professor directly to email verification
                        }else{
                            Yii::app()->session['onboarding_step'] = 0;
                        }



                        $data = array('success'=>true);
                        $this->renderJSON($data);
                        return;
                    }

                    //  $this->redirect(Yii::app()->getBaseUrl(true) . '/register/school_select?professor=1');
                }else{
                    $professor = new User;
                    $professor->user_email = $email;
                    $professor->user_type = $user_type;
                    $professor->firstname = $firstname;
                    $professor->lastname = $lastname;
                    $professor->university_id = $university_id;
                    $professor->school_id = null;
                    $professor->department_id = null;
                    $professor->status = 'unverified';
                    try{
                        $professor->save(false);

                        $this->add_default_user_events($professor);
                    }catch(Exception $e){
                        $data = array('success'=>false,'error_id'=>12, 'error'=>'Error saving professor', 'error_msg'=>$e->getMessage());
                        $this->renderJSON($data);
                        return;
                    }



                    $salt = salt();
                    $hashed_password = hash_password($password,$salt);

                    $user_login = new UserLogin;
                    $user_login->user_id = $professor->user_id;
                    $user_login->password = $hashed_password;
                    $user_login->salt = $salt;
                    $user_login->save(false);

                    Yii::app()->session['user_id'] = $professor->user_id;
                    Yii::app()->session['user_type'] = 'p';
                    Yii::app()->session['onboarding_step'] = 0;


                    $data = array('success'=>true);
                    $this->renderJSON($data);
                    return;

                    //$this->redirect(Yii::app()->getBaseUrl(true) . '/professor_verify');
                }
            }elseif($user_type == 's'){
                //Check if the user is already in the database
                $user = User::model()->find("user_email=:user_email",array(":user_email"=>$email));
                if($user){

                    //Update with the info they just input
//                    $user->user_email = $email;
//                    $user->user_type = $user_type;
                    if($user->firstname == '' || $user->lastname == ''){
                        $user->firstname = $firstname;
                        $user->lastname = $lastname;
                    }

//                    $user->school_id = null;
//                    $user->department_id = null;
                    //$user->status = 'unverified';
                    $user->save(false);

                    Yii::app()->session['user_type'] = 's';
                    Yii::app()->session['onboarding_step'] = 0;

                    if($user->status === 'invited'){
                        Yii::app()->session['user_id'] = $user->user_id;
                        $data = array('success'=>true);
                        $this->renderJSON($data);
                        return;
                    }else if($user->status === 'unverified'){
                        Yii::app()->session['user_id'] = $user->user_id;
                        $data = array('success'=>true);
                        $this->renderJSON($data);
                        return;
                    }else if($user->status==='active'|| $user->status==='onboarded'){
                        $user_login = UserLogin::model()->find('user_id=:user_id',array(':user_id'=>$user->user_id));

                        $salt = $user_login->salt;

                        $hashed_password = hash_password($password,$salt);


                        if($user_login->password == $hashed_password){
                            //user has successfully logged in
                            Yii::app()->session['user_id'] = $user->user_id;
                            $data = array('success'=>false, 'error_id'=>10, 'error_msg'=>'user has already completed onboarding.');
                            $this->renderJSON($data);
                            return;
                        }else{
                            //user login failed
                            $data = array('success'=>false, 'error_id'=>11, 'error_msg'=>'Email already registered');
                            $this->renderJSON($data);
                            return;
                        }
                        //$data = array('success'=>false, 'error_id'=>10, 'error_msg'=>'user has already completed onboarding.');
                        //$this->renderJSON($data);
                        //return;


                    }else if($user->status == 'onboarding'){
                        Yii::app()->session['user_id'] = $user->user_id;
                        Yii::app()->session['onboarding_step'] = 3;

                        $data = array('success'=>true);
                        $this->renderJSON($data);
                        return;
                    }else {
                        Yii::app()->session['user_id'] = $user->user_id;
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
                    $user->university_id = $university_id;
                    //$user->department_id = null;
                    $user->department_id = null;
                    $user->status = 'onboarding';
                    $user->save(false);


                    $this->add_default_user_events($user);


                    $salt = salt();
                    $hashed_password = hash_password($password,$salt);

                    $user_login = new UserLogin;
                    $user_login->user_id = $user->user_id;
                    $user_login->password = $hashed_password;
                    $user_login->salt = $salt;
                    $user_login->save(false);

                    Yii::app()->session['user_id'] = $user->user_id;
                    Yii::app()->session['user_type'] = 's';
                    Yii::app()->session['onboarding_step'] = 0;



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

        include_once "file_upload.php";

        $user = $this->get_current_user($_POST);

        if(!$user){
            $this->renderJSON(array('success'=>false, 'error_msg'=>'user is not logged in'));
            return;
        }

        $path = $_POST['path'];



        $data = file_upload($_FILES, $path, $user->user_id);
        $this->renderJSON($data);
        return;



    }
public function actionSendReset(){
        if(!isset($_POST['email'])){
            $data = array('success'=>false, 'error_id'=>1);
            $this->renderJSON($data);
            return;
        }

        $email = $_POST['email'];
        $user = User::model()->find('user_email=:email',array(':email'=>$email));

        if($user){
            if($user->save(false)){
                //Check if this user already has a user confirmation
                $user_recovery_test = UserRecovery::model()->find('user_id=:id',array(':id'=>$user->user_id));
                if($user_recovery_test){
                    //If the user already has a confirmation, send another email with the same token
                    $user_email = $user->user_email;
                    $subject = 'Urlinq User Recovery';
                    $message = Yii::app()->getBaseUrl(true) . '/reset?key=' . $user_recovery_test['recovery_key'];
                    $from = 'team@urlinq.com';

                    ERunActions::touchUrl(Yii::app()->getBaseUrl(true) . '/site/sendResetPasswordEmailFunction',$postData=array('to_email'=>$user_email, 'subject'=>$subject, 'message'=>$message, 'from_email'=>$from, 'key'=>$user_recovery_test->recovery_key),$contentType=null);
                    $data = array('success'=>true);
                    $this->renderJSON($data);
                    return;
                }else{
                    //If there isnt already a user confirmation,
                    //create a new one
                    include_once 'UniqueTokenGenerator.php';
                    //Create a user_confirmation for this user
                    $user_recovery = new UserRecovery;
                    $user_recovery->recovery_key = token();
                    $user_recovery->user_id = $user->user_id;

                    if($user_recovery->save(false)){
                        $user_email = $user->user_email;
                        $subject = 'Urlinq User Recovery';
                        $message = Yii::app()->getBaseUrl(true) . '/reset?key=' . $user_recovery->recovery_key;
                        $from = 'team@urlinq.com';

                        ERunActions::touchUrl(Yii::app()->getBaseUrl(true) . '/site/sendResetPasswordEmailFunction',$postData=array('to_email'=>$user_email, 'subject'=>$subject, 'message'=>$message, 'from_email'=>$from, 'key'=>$user_recovery->recovery_key),$contentType=null);
                        $data = array('success'=>true);
                        $this->renderJSON($data);
                        return;
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

    public function actionReset() {
        if(!isset($_GET['key'])){
            $data = array('success'=>false,'error_id'=>1, 'error_msg'=> 'Invalid Token');
            $this->renderJSON($data);
            return;
        }

        $token = $_GET['key'];
        $user_recovery = UserRecovery::model()->find('recovery_key=:token',array(':token'=>$token));

        if($user_recovery){
            $user = User::model()->find('user_id=:user_id',array(':user_id'=>$user_recovery->user_id));
            $this->render('reset',array('email'=>$user->user_email,'token'=>$token));
            return;
        }

    }
    public function actionFacebookSignup(){
        if(!isset($_POST['fb_email'])||!isset($_POST['first_name'])||!isset($_POST['last_name'])){
            $data = array('success'=>false,'error_id'=>1, 'error_msg'=> 'not all data set');
            $this->renderJSON($data);
            return;
        }
        $fb_email = $_POST['fb_email'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];



        $university_id = $this->get_university_id_by_email($fb_email);

        $user_auth_provider = UserAuthProvider::model()->find('fb_email = :fb_email',array(':fb_email'=>$fb_email));
        if($user_auth_provider){
            $user = $user_auth_provider->user;
            if($user->status == "active" || $user->status == "onboarded"){

                Yii::app()->session['user_id'] = $user->user_id;

                $data = array('success'=>false,'error_id'=>3, 'error_msg'=> 'account already exists', 'user_id'=>$user->user_id);
                $this->renderJSON($data);
                return;
            }else if($user->status == "onboarding"){

                Yii::app()->session['user_id'] = $user->user_id;
                Yii::app()->session['signin_type'] = 'facebook';
                Yii::app()->session['email'] = $fb_email;
                Yii::app()->session['ask_for_email'] = !isset($_POST['email']) && (strpos(".edu",$fb_email) > -1);
                Yii::app()->session['onboarding_step'] = 0;

                $data = array('success'=>true);
                $this->renderJSON($data);
                return;
            }

        }

        if(strpos(".edu",$fb_email)>-1){
            $edu_email = $fb_email;
            $previous_user_with_email = User::model()->find('user_email = :edu_email',array(':edu_email'=>$edu_email));
            if($previous_user_with_email){
                $user = $previous_user_with_email;
                if(($previous_user_with_email->user_type == 'p' || $previous_user_with_email->user_type == 'a')
                    && $previous_user_with_email->status == "unverified"){

                    $user_auth_provider = new UserAuthProvider();
                    $user_auth_provider->user_id = $user->user_id;
                    $user_auth_provider->fb_email = $fb_email;
                    $user_auth_provider->save(false);

                    Yii::app()->session['auto_verify'] = true;
                    Yii::app()->session['user_id'] = $user->user_id;
                    Yii::app()->session['signin_type'] = 'facebook';
                    Yii::app()->session['email'] = $fb_email;
                    Yii::app()->session['ask_for_email'] = false;
                    Yii::app()->session['onboarding_step'] = 0;


                    $data = array('success'=>true, 'msg'=>'email matches faculty in database');
                    $this->renderJSON($data);
                    return;
                } else{
                    $data = array('success'=>false,'error_id'=>4,  'msg'=>'user already in database');
                    $this->renderJSON($data);
                    return;
                }
            }
        }
        if(isset($_POST['email'])){
            $previous_user_with_email = User::model()->find('user_email = :edu_email',array(':edu_email'=>$_POST['email']));
            if($previous_user_with_email){
                $user = $previous_user_with_email;
                if(($previous_user_with_email->user_type == 'p' || $previous_user_with_email->user_type == 'a')
                    && $previous_user_with_email->status == "unverified"){

                    $user_auth_provider = new UserAuthProvider();
                    $user_auth_provider->user_id = $user->user_id;
                    $user_auth_provider->fb_email = $fb_email;
                    $user_auth_provider->save(false);

                    //Yii::app()->session['auto_verify'] = true;
                    Yii::app()->session['user_id'] = $user->user_id;
                    Yii::app()->session['signin_type'] = 'facebook';
                    Yii::app()->session['email'] = $fb_email;
                    Yii::app()->session['ask_for_email'] = false;
                    Yii::app()->session['onboarding_step'] = 0;


                    $data = array('success'=>true, 'msg'=>'email matches faculty in database');
                    $this->renderJSON($data);
                    return;
                } else{
                    $data = array('success'=>false,'error_id'=>5,  'msg'=>'entered email already in database');
                    $this->renderJSON($data);
                    return;
                }
            }
        }


        $user = new User;
        $user->firstname = $first_name;
        $user->lastname = $last_name;

        if($university_id){
            $user->university_id = $university_id;
        }
        $user->school_id = null;
        $user->department_id = null;
        $user->status = 'onboarding';

        if(isset($edu_email)){
            Yii::app()->session['auto_verify'] = true;
            $user->user_email = $edu_email;
        }else if(isset($_POST['email'])){
            $user->user_email = $_POST['email'];
        }else {
            $user->user_email = "";
        }
        $user_type = "";
        if(isset($_POST['account_type'])){
            $user_type = $_POST['account_type'];
            $user->user_type = $user_type;

        }
        $user->save(false);

        if($user_type == "s"){
            $student_attribute = new StudentAttributes();
            $student_attribute->user_id = $user->user_id;
            $student_attribute->save(false);
        }else if($user_type == "p"){
            $professor_attribute = new ProfessorAttribute();
            $professor_attribute->professor_id = $user->user_id;
            $professor_attribute->designation = 'professor';
            $professor_attribute->save(false);
        }
        $this->add_default_user_events($user);

        $user_auth_provider = new UserAuthProvider();
        $user_auth_provider->user_id = $user->user_id;
        $user_auth_provider->fb_email = $fb_email;
        $user_auth_provider->save(false);
/*

        $salt = salt();
        $hashed_password = hash_password($password,$salt);

        $user_login = new UserLogin;
        $user_login->user_id = $user->user_id;
        $user_login->password = $hashed_password;
        $user_login->salt = $salt;
        $user_login->save(false);  */

        Yii::app()->session['user_id'] = $user->user_id;
        Yii::app()->session['signin_type'] = 'facebook';
        Yii::app()->session['email'] = $fb_email;
        Yii::app()->session['ask_for_email'] = !isset($_POST['email']) && !isset($edu_email);
        //Yii::app()->session['ask_for_email'] = !isset($edu_email);
        Yii::app()->session['onboarding_step'] = 0;


        $data = array('success'=>true, 'msg'=>'new user was created');
        $this->renderJSON($data);
        return;
    }

    public function actionFacebookLogin(){
        if(!isset($_POST['fb_email'])){
            $data = array('success'=>false,'error_id'=>1, 'error_msg'=> 'Invalid Token');
            $this->renderJSON($data);
            return;
        }
        $fb_email=$_POST['fb_email'];
        $user_auth_provider = UserAuthProvider::model()->find('fb_email=:email',array(':email'=>$fb_email));
        if($user_auth_provider){
            $user = User::model()->find('user_id=:uid',array(':uid'=>$user_auth_provider->user_id));
            //user has successfully logged in
            Yii::app()->session['user_id'] = $user->user_id;

            if($user->status == 'onboarding'){
                //Send user to onboarding

                Yii::app()->session['signin_type'] = 'facebook';
                $data = array('success'=>false, 'error_id'=>6, 'error_msg'=>'user has not completed onboarding');
                $this->renderJSON($data);
                return;
            }




            $data = array('success'=>true);
            $this->renderJSON($data);
            return;
        }else{
            //user login failed
            $data = array('success'=>false, 'error_id'=>4, 'error_msg'=>'Invalid login');
            $this->renderJSON($data);
            return;
        }
    }

    public function actionDoReset(){
        include "password_encryption.php";
        $token = $_POST['token'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        if ($password != $confirm_password) {
            $data = array('success'=>false, 'error_id'=>1, 'error_msg'=>'Passwords do not match');
            $this->renderJSON($data);
            return;
        }
        $user_recovery = UserRecovery::model()->find('recovery_key=:token',array(':token'=>$token));
        if($user_recovery){
            $user = User::model()->find('user_id=:user_id',array(':user_id'=>$user_recovery->user_id));
            $user_login = UserLogin::model()->find('user_id=:user_id',array(':user_id'=>$user_recovery->user_id));

            $salt = $user_login->salt;
            $hashed_password = hash_password($password,$salt);

            if($user_login){


                // The password gets changed here
                $user_login->password = $hashed_password;
                $user_login->save(false);
                Yii::app()->session['user_id'] = $user->user_id;
                $data = array('success'=>true);
                $this->renderJSON($data);
                $user_recovery->delete();
                return;
            }else{
                $user_login = new UserLogin;
                // The password gets changed here
                $user_login->password = $hashed_password;
                $user_login->save(false);


                Yii::app()->session['user_id'] = $user->user_id;
                $data = array('success'=>true);
                $this->renderJSON($data);
                $user_recovery->delete();
                return;
            }

        }
    }



    public function actionAdmin(){

        $user = $this->get_current_user();

        if(!$user){
            $data = array('success'=>false);
            $this->renderJSON($data);
            return;
        }



//        if(!$this->is_urlinq_admin($user)){
//            $data = array('success'=>false, 'error_msg'=>'Not an admin');
//            $this->renderJSON($data);
//            return;
//        }










        $this->render('admin',array('user'=>$user));
        return;
    }



    public function actionSupportedEmailList(){

        $data = array('success'=>true, 'valid_email_list'=>$this->get_supported_email_list());
        $this->renderJSON($data);
        return;
    }




    function add_to_zeta_beta_tau($user){
        $zeta_beta_tau_emails = array(
            'mmm812@nyu.edu',
            'rab597@nyu.edu',
            'tm2313@nyu.edu',
            'tdr268@nyu.edu',
            'krk333@nyu.edu',
            'jba329@nyu.edu',
            'mnl278@nyu.edu',
            'll2757@nyu.edu',
            'jw3284@nyu.edu',
            'avd316@nyu.edu',
            'mjd527@nyu.edu',
            'zg367@nyu.edu',
            'js5963@nyu.edu',
            'ra1689@nyu.edu',
            'dal433@nyu.edu',
            'cw1631@nyu.edu',
            'mw2570@nyu.edu',
            'ams1085@nyu.edu',
            'kpt228@nyu.edu',
            'avu.c.92@gmail.com',
            'mbs519@nyu.edu',
            'Dcs411@nyu.edu',
            'msw359@nyu.edu',
            'tk1432@nyu.edu',
            'bb1418@nyu.edu',
            'sp2674@stern.nyu.edu',
            'smr496@stern.nyu.edu',
            'nan250@nyu.edu',
            'ib750@nyu.edu',
            'gl1036@nyu.edu',
            'cmd582@nyu.edu',
            'lpa232@nyu.edu',
            'ftm215@nyu.edu',
            'af1436@nyu.edu',
            'baa300@nyu.edu',
            'ccg267@nyu.edu',
            'iac237@nyu.edu',
            'js5845@nyu.edu',
            'gm1532@nyu.edu',
            'sgt237@nyu.edu',
            'bg1340@nyu.edu',
            'hw140@nyu.edu',
            'jnk261@nyu.edu',
            'mp3032@nyu.edu',
            'dcb353@nyu.edu',
            'ja2503@nyu.edu',
            'jcg396@nyu.edu',
            'Tm1544@nyu.edu',
            'ajb632@nyu.edu',
            'dam567@nyu.edu',
            'jsc488@nyu.edu',
            'dcl302@nyu.edu',
            'ajl511@nyu.edu',
            'jc4568@nyu.edu',
            'tmh363@nyu.edu',
            'lk1282@nyu.edu',
            'kn793@nyu.edu',
            'jt1738@nyu.edu',
            'sas878@nyu.edu',
            'nh1018@nyu.edu',
            'ms6384@nyu.edu',
            'cmp630@nyu.edu',
            'apn254@nyu.edu',
            'bgershenov@gmail.com',
            'shaanshi@gmail.com',
            'mbs480@nyu.edu',
            'maxwiseltier@gmail.com',
            'cameronwolf24@gmail.com',
            'Gf736@nyu.edu',
            'Jdm530@nyu.edu',
            'Ce646@nyu.edu',
            'jsd413@nyu.edu',
            'Cmp630@nyu.edu',
            'djf370@nyu.edu'
        );

        foreach($zeta_beta_tau_emails as $zeta_beta_tau_email){
            if($user->user_email == $zeta_beta_tau_email){
                //Check if user is member of group
                $group_user = GroupUser::model()->find('group_id=:id and user_id=:user_id', array(':id'=>'295', ':user_id'=>$user->user_id));
                if(!$group_user){
                    include_once "color/color.php";
                    //Add this user to group 295
                    $group_user = new GroupUser;
                    $group_user->group_id = 295;
                    $group_user->user_id = $user->user_id;
                    $group_user->color_id = get_random_color();
                    $group_user->save(false);
                }
                break;
            }
        }
    }

}