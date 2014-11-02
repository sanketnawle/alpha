<?php

class ApiController extends Controller
{





    public function actionFileUpload(){







        include "file_upload.php";

        file_upload($_FILES);


    }



    public function actionSignup()
    {

        if(!isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['user_type'])
        || !isset($_POST['school_id']) || !isset($_POST['department_id']) || isset($_FILES['uploadFile'])){

        }


        $email = $_POST['email'];
        $password = $_POST['password'];
        $user_type = $_POST['user_type'];
        $school_id = $_POST['school_id'];
        $department_id = $_POST['department_id'];
        $picture_file_id = null;

        include "file_upload.php";
        $file_upload_response = file_upload($_FILES);


        if($file_upload_response['success']){
            $picture_file_id = $file_upload_response['file_id'];
        }else{

        }


        //|| !isset($_POST['picture_file_id'])


        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $user_type = $_POST['user_type'];
        $gender = $_POST['gender'];



        //USER ID
        $data = array('token'=>'0298208');


        $this->renderJSON($data);
    }


    //Checks to see if we support the current univ edu email
    public function actionGetUniversityDataByEmail()
    {

        if(!isset($_POST['email'])){
            $data = array('success'=>'false','error'=>'email not set');
            $this->renderJSON($data);
            return;
        }

        $email = $_POST['email'];

        if(strpos($email,'nyu.edu') > 0){
            //Get univeristy id from a table of university_id   and   @univ.edu  (the schools email pattern)
            $university = University::model()->find('university_id=:university_id',array(':university_id'=>1));

            $base_url = Yii::app()->getBaseUrl(true);
            $data = array('success'=>'true','base_url'=>$base_url,'university'=> $this->get_model_associations($university,array('schools'=>array('departments','pictureFile'),'pictureFile'=>array())));


            $this->renderJSON($data);
            return;
        }else{
            $data = array('success'=>'false','error_id'=>0,'error'=>'Only NYU email addresses are supported at this time');
            $this->renderJSON($data);
            return;
        }


    }





    //https://urlinq.com/api/login
	public function actionLogin()
	{
        //Error ID's for login
        // 0 - User with email doesnt exist in our database
        // 1 - User is not 'active' which means they have not verified their email address
        // 2 - Credentials are incorrect

        if(!isset($_POST['email']) || !isset($_POST['password'])){
            $data = array('success'=>'false','error'=>'email or password is not set');
            $this->renderJSON($data);
            return;
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = User::model()->find("user_email=:user_email",array(":user_email"=>$email));

        if($user){

            if($user->status != 'active'){
                $data = array('success'=>'false','error_id'=>1);
                $this->renderJSON($data);
                return;
            }


            $user_token = UserToken::model()->find('user_id=:user_id',array(':user_id'=>$user->user_id));
            if($user_token){
                $user_token->delete();
            }


            include 'password_encryption.php';
            $user_login = UserLogin::model()->find('user_id=:user_id',array(':user_id'=>$user->user_id));

            $salt = $user_login->salt;
            $hashed_password = hash_password($password,$salt);



            if($user_login->password == $hashed_password){ //user has successfully logged in
                //Generate the token
                $token = salt();

                //Save token to database
                $user_token = new UserToken;
                $user_token->user_id = $user->user_id;
                $user_token->token = $token;
                $user_token->expires_at = date("Y-m-d H:i:s",strtotime("+1 week"));
                $user_token->save(false);

                $data = array('success'=>'true','user_id'=>$user->user_id,'token'=>$token,'expires_at'=>$user_token->expires_at);
                $this->renderJSON($data);
                return;
            }else{ //user login failed
                $data = array('success'=>'false','error_id'=>2,'error'=>'user with email: ' . $email . ' doesnt exist');
                $this->renderJSON($data);
                return;
            }

        }else{
            $data = array('success'=>'false','error_id'=>0,'error'=>'user with email: ' . $email . ' doesnt exist');
            $this->renderJSON($data);
            return;
        }


	}


    //https://urlinq.com/api/user/courses
	public function actionUserCourses()
	{
        $user_id = $_GET['user_id'];
        $token = $_GET['token'];





		$this->render('userCourses');
	}


    //https://urlinq.com/api/user/follow_courses
    public function actionUserFollowCourses()
    {
        $user_id = $_GET['user_id'];
        $token = $_GET['token'];





        $this->render('userCourses');
    }


    //https://urlinq.com/api/group/users/count
    public function actionGroupUsersCount(){



    }

    // api/user/follow
    public function actionFollowUser(){
        $user_id = $_POST['user_id'];
        $followed_user_id = $_POST['followed_user_id'];
        $toke = $_POST['token'];
    }

    // api/user/unfollow
    public function actionUnfollowUser(){
        $user_id = $_POST['user_id'];
        $unfollowed_user_id = $_POST['unfollowed_user_id'];
        $toke = $_POST['token'];
    }


    // api/user/courses/led/
    public function actionUserLedCourses(){
        $user_id = $_POST['user_id'];
        $user_type = $_POST['user_type'];
        $toke = $_POST['token'];
    }

    // api/user/courses/led/count
    public function actionUserLedCoursesCount(){

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