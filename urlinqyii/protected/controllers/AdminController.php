<?php

class AdminController extends Controller
{
	public function actionGeneratePassword()
	{
        #hashes new password

        if(!isset($_POST['password'])){
            $data = array('success'=>false, 'error_id'=>1, 'error_msg'=>'The valid data is not set.');
            $this->renderJSON($data);
            return;
        }



        $user = $this->get_current_user();
        if(!$user){
            $data = array('success'=>false, 'error_id'=>'user is not authenticated');
            $this->renderJSON($data);
            return;
        }


        if(!$this->is_urlinq_admin($user)){
            $data = array('success'=>false, 'error_id'=>'user is not authenticated');
            $this->renderJSON($data);
            return;
        }

        $password = $_POST['password'];
        include "password_encryption.php";

        $salt = salt();
        $hashed_password = hash_password($password,$salt);


        $data = array('success'=>true, 'hashed_password'=>$hashed_password, 'salt'=>$salt);
        $this->renderJSON($data);
        return;


	}

    //Changes groups cover photo to its parents
    public function actionSetToParentsPhoto(){
        if(!isset($_POST['origin_type']) || !isset($_POST['origin_id'])){
            $data = array('success'=>false, 'error_id'=>1, 'error_msg'=>'The valid data is not set.');
            $this->renderJSON($data);
            return;
        }

        $origin_type = $_POST['origin_type'];
        $origin_id = $_POST['origin_id'];


        if($origin_type == 'department'){
            $department = Department::model()->find('department_id=:id', array(':id'=>$origin_id));
            if(!$department){
                $this->renderJSON(array('success'=>false, 'error_id'=>2, 'error_msg'=>'department doesnt exist'));
                return;
            }

            $school = $department->school;

            $department->picture_file_id = $school->picture_file_id;
            $department->cover_file_id = $school->cover_file_id;
            if($department->save(false)){
                $this->renderJSON(array('success'=>true, 'file'=>$department->pictureFile));
                return;
            }else{
                $this->renderJSON(array('success'=>false, 'error_id'=>3, 'error_msg'=>'Error saving department'));
                return;
            }

        }else if($origin_type == 'course'){
            $course = Course::model()->find('course_id=:id', array(':id'=>$origin_id));
            if(!$course){
                $this->renderJSON(array('success'=>false, 'error_id'=>2, 'error_msg'=>'course doesnt exist'));
                return;
            }

            $department = $course->department;

            $course->picture_file_id = $department->picture_file_id;

            if($course->save(false)){
                $this->renderJSON(array('success'=>true, 'file'=>$course->pictureFile));
                return;
            }else{
                $this->renderJSON(array('success'=>false, 'error_id'=>3, 'error_msg'=>'Error saving course'));
                return;
            }

        }else if($origin_type == 'class'){
            $class = ClassModel::model()->find('class_id=:id', array(':id'=>$origin_id));
            if(!$class){
                $this->renderJSON(array('success'=>false, 'error_id'=>2, 'error_msg'=>'class doesnt exist'));
                return;
            }

            $department = $class->department;

            $class->picture_file_id = $department->picture_file_id;

            if($class->save(false)){
                $this->renderJSON(array('success'=>true, 'file'=>$class->pictureFile));
                return;
            }else{
                $this->renderJSON(array('success'=>false, 'error_id'=>3, 'error_msg'=>'Error saving class'));
                return;
            }

        }else{
            $this->renderJSON(array('success'=>false, 'error_id'=>4, 'error_msg'=>'Invalid origin type'));
            return;
        }
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