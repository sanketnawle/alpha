<?php

class ApiController extends Controller
{









    public function actionCreateAccount()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $user_type = $_POST['user_type'];
        $gender = $_POST['gender'];



        //USER ID
        $data = array('token'=>'0298208');


        $this->renderJSON($data);
    }



    //https://urlinq.com/api/login
	public function actionLogin()
	{
        $username = $_POST['username'];
        $password = $_POST['password'];

        //TOKEN USERID
		$this->render('login');
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