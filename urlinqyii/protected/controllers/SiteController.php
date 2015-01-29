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



    function actionSendVerificationEmailFunction(){

//        $user = $this->get_current_user();
//        if(!$user){
//            $data = array('success'=>false);
//            $this->renderJSON($data);
//            return;
//        }

//
//        if($user->status != 'unverified'){
//            $data = array('success'=>false);
//            $this->renderJSON($data);
//            return;
//        }




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
                $user->status = 'onboarding';

                if($user->save(false)){
                    //Delete user_confirmation for this user
                    if($user_confirmation->delete()){

                        //If the user confirmation was successful, redirect back to
                        //onboarding at step 3
                        Yii::app()->session['onboarding_step'] = 3;
                        Yii::app()->session['department_id'] = $user->department_id;
                        Yii::app()->session['school_id'] = $user->school_id;
                        Yii::app()->session['user_type'] = $user->user_type;
                        Yii::app()->session['user_type'] = $user_id;

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

        if($department->school_id != $school->school_id){
            $data = array('success'=>false,'error_id'=>3,'error_msg'=>'department is not in school');
            $this->renderJSON($data);
            return;
        }

        $user = $this->get_current_user();

        if($user){
            if($user->status == 'active' || $user->status == 'onboarding'){
                $data = array('success'=>false, 'error_msg'=>'user is already verified', 'error_id'=>10);
                $this->renderJSON($data);
                return;

            }else if($user->status == 'unverified'){
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




            //Ross requested that we block these emails
            $blocked_emails = array('aa3225@nyu.edu', 'abhinay.ashutosh@nyu.edu');
            foreach($blocked_emails as $blocked_email){
                if($email == $blocked_email){
                    $data = array('success'=>false);
                    $this->renderJSON($data);
                    return;
                }
            }

            if(!$this->valid_email($email)){
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


        if(!$user){
            $this->redirect(Yii::app()->getBaseUrl(true) . '/');
        }

        //If this user is already active, redirect to home page
        if($user && $user->status == 'active'){
            $this->redirect(Yii::app()->getBaseUrl(true) . '/home');
        }


        Yii::app()->session['onboarding_step'] = 0;

        //Take user directly to step 4
        if($user && $user->status == 'onboarding'){
            Yii::app()->session['onboarding_step'] = 3;
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


        if($gender != 'M' && $gender != 'F'){
            $data = array('success'=>false, 'error_id'=>3, 'error_msg'=>'invalid gender');
            $this->renderJSON($data);
            return;
        }

        if($classes){
            foreach($classes as $class_id){
                $class = ClassModel::model()->find('class_id=:id',array(':id'=>$class_id));
                if($class){

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
                }else{
                    $data = array('success'=>false, 'error_id'=>4, 'error_msg'=>'invalid class id');
                    $this->renderJSON($data);
                    return;
                }
            }
        }else{

            if($user->user_type == 'p'){
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
            }
        }


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
            if(isset($_POST['graduation_date'])){
                $graduation_date = $_POST['graduation_date'];
            }
            $student_attribute = StudentAttributes::model()->find('user_id=:id',array(':id'=>$user->user_id));
            if($student_attribute){
                $student_attribute->user_id = $user->user_id;
                $student_attribute->year = $graduation_date;

                if(!$student_attribute->save(false)){
                    $data = array('success'=>false, 'error_id'=>16, 'error_msg'=>'Error saving student data');
                    $this->renderJSON($data);
                    return;
                }
            }else{
                $student_attribute = new StudentAttributes;
                $student_attribute->user_id = $user->user_id;
                $student_attribute->year = $graduation_date;


                if(!$student_attribute->save(false)){
                    $data = array('success'=>false, 'error_id'=>8, 'error_msg'=>'Error saving student data');
                    $this->renderJSON($data);
                    return;
                }
            }
        }


        $user->picture_file_id = $picture_file_id;

        //Finally, change the user type to active
        //indicating that the user is done with onboarding
        $user->status = 'active';
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


            //Ross requested that we block these emails
            $blocked_emails = array('aa3225@nyu.edu', 'abhinay.ashutosh@nyu.edu');
            foreach($blocked_emails as $blocked_email){
                if($email == $blocked_email){
                    $data = array('success'=>false);
                    $this->renderJSON($data);
                    return;
                }
            }

            if(strpos($email,'nyu.edu') == false){
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

            if($user_type == 'p' || $user_type == 'a'){
                $professor = User::model()->find("user_email=:user_email",array(":user_email"=>$email));
                if($professor){
                    //Professor is already in our database

                    if($professor->status == 'active'){
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
                    $professor->school_id = null;
                    $professor->department_id = null;
                    $professor->status = 'temp';
                    try{
                        $professor->save(false);
                    }catch(Exception $e){
                        $data = array('success'=>false,'error_id'=>12, 'error'=>'Error saving professor');
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
                    }else if($user->status==='active'){
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

                    ERunActions::touchUrl(Yii::app()->getBaseUrl(true) . '/site/sendVerificationEmailFunction',$postData=array('to_email'=>$user_email, 'subject'=>$subject, 'message'=>$message, 'from_email'=>$from, 'key'=>$user_recovery_test->recovery_key),$contentType=null);
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

                        ERunActions::touchUrl(Yii::app()->getBaseUrl(true) . '/site/sendVerificationEmailFunction',$postData=array('to_email'=>$user_email, 'subject'=>$subject, 'message'=>$message, 'from_email'=>$from, 'key'=>$user_recovery->recovery_key),$contentType=null);
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