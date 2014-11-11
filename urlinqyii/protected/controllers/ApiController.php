<?php

class ApiController extends Controller
{

    //Error ids
    // 1 - file id is not set
    // 2 - File doesnt exist
    public function actionGetFileUrl(){
        if(!isset($_GET['file_id'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'file_id isnt set');
            $this->renderJSON($data);
        }

        $file_id = $_GET['file_id'];
        $file = File::model()->find("file_id=:file_id",array(":file_id"=>$file_id));
        if($file){
            $data = array('success'=>true,'file_url'=>$file->file_url,'base_url'=>Yii::app()->getBaseUrl(true));
            $this->renderJSON($data);
        }else{
            $data = array('success'=>false,'error_id'=>2,'error_msg'=>'File with id ' . $file_id . 'does not exist');
            $this->renderJSON($data);
        }

    }


    public function actionFileUpload(){


        include "file_upload.php";




        $data = file_upload($_FILES);
        $this->renderJSON($data);
        return;

    }






    //Error ids
    // 1 - all data required is not set
    // 2 - error saving user to database
    public function actionSignup()
    {

        if(!isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['user_type'])
          || !isset($_POST['school_id']) || !isset($_POST['department_id'])){


            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'All data is not set');
            $this->renderJSON($data);
            return;
        }


        if(isset($_POST['facebook_flag'])){
            $facebook_email = $_POST['facebook_email'];
            $facebook_token = $_POST['facebook_token'];


        }

        //|| isset($_FILES['uploadFile'])
        $email = $_POST['email'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $password = $_POST['password'];
        $user_type = $_POST['user_type'];
        $school_id = $_POST['school_id'];
        $department_id = $_POST['department_id'];
        $picture_file_id = null;



        if(isset($_FILES['uploadFile']) && $_FILES['uploadFile'] != null){
            include "file_upload.php";

            $file_upload_response = file_upload($_FILES);
            if($file_upload_response['success']){
                $picture_file_id = $file_upload_response['file_id'];
            }else{
                $picture_file_id = 1;
            }
        }else{
            $picture_file_id = 1;
        }




        $user = new User;
        try {
            $user->firstname = $first_name;
            $user->lastname = $last_name;
            $user->user_email = $email;
            $user->user_type = $user_type;
            $user->school_id = $school_id;
            $user->department_id = $department_id;
            $user->picture_file_id = $picture_file_id;
            $user->save(false);
        } catch (Exception $e) {
            $data = array('success'=> false,'error_id'=> 2, 'error_msg'=>'error saving user to database');
            $this->renderJSON($data);
            return;
        }


        include "password_encryption.php";


        $salt = salt();
        $hashed_password = hash_password($password,$salt);

        $user_login = new UserLogin;
        $user_login->user_id = $user->user_id;
        $user_login->password = $hashed_password;
        $user_login->salt = $salt;
        $user_login->save(false);



        //Send email verifications here
        ////////////////////////////////






        //$login_data = $this->login($email,$password);
        $data = array('success'=>true,'user_id'=>$user->user_id,'user_email'=>$user->user_email);
        $this->renderJSON($data);
        return;
    }



    public function actionFacebookLogin(){
        if(!isset($_POST['facebook_email']) && !isset($_POST['facebook_token'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'All data is not set');
            $this->renderJSON($data);
            return;
        }
    }

    public function actionGetUserData(){
        if(!isset($_GET['user_id'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'user_id not set');
            $this->renderJSON($data);
            return;
        }

        $user_id = $_GET['user_id'];
        //$user = User::model()->findAll(array("select"=>"user_email"));
        $user = User::model()->find("user_id=:user_id",array(":user_id"=>$user_id));



//        $departments = array();
//        foreach($school->departments as $department){
//            array_push($departments,array('department_name'=>$department->department_name,'department_id'=>$department->department_id));
//        }

        $data = array('success'=>true,'user'=>$this->get_model_associations($user,array('department'=>array('pictureFile','coverFile'),'pictureFile'=>array(),'school'=>array('pictureFile','coverFile','university'))));




        $this->renderJSON($data);
        return;
    }

    public function actionGetSchoolData(){
        if(!isset($_GET['school_id'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'school_id not set');
            $this->renderJSON($data);
            return;
        }

        $school_id = $_GET['school_id'];
        //$user = User::model()->findAll(array("select"=>"user_email"));
        $school = School::model()->find("school_id=:school_id",array(":school_id"=>$school_id));

        $departments = array();
        foreach($school->departments as $department){
            array_push($departments,array('department_name'=>$department->department_name,'department_id'=>$department->department_id));
        }

        $data = array('success'=>true,'school'=>$this->get_model_associations($school,array('pictureFile','coverFile')),'departments'=>$departments);




        $this->renderJSON($data);
        return;
    }


    public function actionGetDepartmentData(){
        if(!isset($_GET['department_id'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'department_id not set');
            $this->renderJSON($data);
            return;
        }

        $department_id = $_GET['department_id'];
        //$user = User::model()->findAll(array("select"=>"user_email"));
        $department = Department::model()->find("department_id=:department_id",array(":department_id"=>$department_id));


        $data = array('success'=>true,'department'=>$this->get_model_associations($department,array('pictureFile','coverFile')));


        $this->renderJSON($data);
        return;
    }


    public function actionGetUniversityData(){
        if(!isset($_GET['university_id'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'university_id not set');
            $this->renderJSON($data);
            return;
        }

        $university_id = $_GET['university_id'];
        //$user = User::model()->findAll(array("select"=>"user_email"));
        $university = university::model()->find("university_id=:university_id",array(":university_id"=>$university_id));


        $schools = array();
        foreach($university->schools as $school){
            array_push($schools,array('school_name'=>$school->school_name,'school_id'=>$school->school_id));
        }


        $data = array('success'=>true,'university'=>$this->get_model_associations($university,array('pictureFile','coverFile')),'schools'=>$schools);


        $this->renderJSON($data);
        return;
    }


    //Checks to see if we support the current univ edu email
    public function actionGetUniversityDataByEmail() {

        if(!isset($_POST['email'])){
            $data = array('success'=>false,'error'=>'email not set');
            $this->renderJSON($data);
            return;
        }

        $email = $_POST['email'];

        if(strpos($email,'nyu.edu') > 0){
            //Get univeristy id from a table of university_id   and   @univ.edu  (the schools email pattern)
            $university = University::model()->find('university_id=:university_id',array(':university_id'=>1));

            $base_url = Yii::app()->getBaseUrl(true);
            $data = array('success'=>true,'base_url'=>$base_url,'university'=> $this->get_model_associations($university,array('schools'=>array('departments'=>array('pictureFile'),'pictureFile'=>array()),'pictureFile'=>array())));


            $this->renderJSON($data);
            return;
        }else{
            $data = array('success'=>false,'error_id'=>1,'error'=>'Only NYU email addresses are supported at this time');
            $this->renderJSON($data);
            return;
        }


    }

    //https://urlinq.com/api/login
    public function actionLogin()
    {

        if(!isset($_POST['email']) || !isset($_POST['password'])){
            $data = array('success'=>false,'error'=>'email or password is not set');
            $this->renderJSON($data);
            return;
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $data = $this->login($email,$password);
        $this->renderJSON($data);
    }




    //Error ids
    // 1 - User with email does not exist
    public function actionOnboardStatus(){
        if(!isset($_POST['email'])){
            $data = array('success'=>false,'error'=>'email is not set');
            $this->renderJSON($data);
            return;
        }



        $email = $_POST['email'];
        $user = User::model()->find("user_email=:user_email",array(":user_email"=>$email));

        if($user){
            $data = array('success'=>true,'status'=>$user->status);
            $this->renderJSON($data);
            return;
        }else{
            $data = array('success'=>false,'error_id'=>1,'error'=>'User with email ' . $email . ' doesnt exist');
            $this->renderJSON($data);
            return;
        }



    }


    //Error ID's for login
    // 1 - User with email doesnt exist in our database
    // 2 - User is not 'active' which means they have not verified their email address
    // 3 - Credentials are incorrect
    public function login($email,$password){
        $user = User::model()->find("user_email=:user_email",array(":user_email"=>$email));

        if($user){

            if($user->status != 'active'){
                return array('success'=>false,'error_id'=>2,'error'=>'User is not active so they cannot login');
                //$this->renderJSON($data);
                //return;
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

                return array('success'=>true,'user_id'=>$user->user_id,'token'=>$token,'expires_at'=>$user_token->expires_at);
                //$this->renderJSON($data);

            }else{ //user login failed
                return array('success'=>false,'error_id'=>3,'error'=>'user with email: ' . $email . ' doesnt exist');
                //$this->renderJSON($data);

            }

        }else{
            return array('success'=>false,'error_id'=>1,'error'=>'user with email: ' . $email . ' doesnt exist');
            //$this->renderJSON($data);
            //return;
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