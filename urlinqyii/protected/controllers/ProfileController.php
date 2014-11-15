<?php

class ProfileController extends Controller
{


    //public $layout='//layouts/main';


	public function actionIndex(){
		$this->render('index');
	}



    public function actionGetPosts(){

        $data = array('test'=>'this is inside the profile controller and it getting my posts','test_array'=>array(1,2,3,4));

        $this->renderJSON($data);
    }


    //http://localhost/urlinqyii/profile/1
    public function actionView() {
        $user_id = $_GET['id'];
        $userProfile = User::model()->find('user_id=:id', array(':id'=>$user_id));
        $currentUser = User::model()->find('user_id=:id',array(':id'=>2));
        $school = $userProfile->school;
        $university = $school->university;
        $department = $userProfile->department;
        $is_user = ($userProfile->user_id == $currentUser->user_id);
        $courses = $userProfile->takes;
        $clubs = $userProfile->groups;
        $following = $userProfile->usersFollowed;
        $followers = $userProfile->usersFollowing;


        $this->render('profile',array('user'=>$currentUser,'userProfile'=>$userProfile,'school'=>$school,'university'=>$university,'department'=>$department
            ,'is_user'=>$is_user, 'courses'=>$courses, 'clubs'=>$clubs, 'following'=>$following,'followers'=>$followers));
    }


    public function actionChangeVisibility(){
        //public , just me, followers

        $user_id = Yii::app()->session['user_id'];


        $course_id = $_POST['course_id'];
        $visibility_id = $_POST['visibility_id'];

        $course_user = CourseUser::model()->find('user_id=:id,course_id=:course_id', array(':id'=>$user_id,':course_id'=>$course_id));

        $course_user->visibility_id = $visibility_id;

        $course_user->save();

    }




}