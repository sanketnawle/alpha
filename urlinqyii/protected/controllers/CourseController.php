<?php

class CourseController extends Controller
{
    public function actionView() {

        $course_id = $_GET['id'];
        $user = $this->get_current_user();

        $course = Course::model()->find('course_id=:id', array(':id' =>$course_id));

        $is_member = true;


        $is_admin = false;
        //echo CJSON::encode(array('success' => true, 'count' => count($Coursees), 'data' => $Coursees));
        //Yii::app()->end();


        $this->render('course',array('user' => $user, 'course'=>$course, 'is_member'=>$is_member, 'is_admin'=>$is_admin));
    }





    public function actionCreate() {
        if(!isset($_POST['school_id']) || !isset($_POST['school_id']) || !isset($_POST['department_id']) || !isset($_POST['course_name'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'all data not set', '_files'=>$_FILES,'_post'=>$_POST);
            $this->renderJSON($data);
            return;
        }



        $school_id = $_POST['school_id'];
        $department_id = $_POST['department_id'];
        $course_name = $_POST['course_name'];


        $course_description = '';
        if(isset($_POST['course_description'])){
            $course_description = $_POST['course_description'];
        }


        $course_tag = '';
        if(isset($_POST['course_tag'])){
            $course_tag = $_POST['course_tag'];
        }


        $course_credits = '';
        if(isset($_POST['course_credits'])){
            $course_credits = $_POST['course_credits'];
        }


        $picture_file_id = 3;


        //Get the picture file id from the department
        $department = Department::model()->find('department_id=:id', array(':id'=>$department_id));
        if($department){
            $picture_file_id = $department->cover_file_id;
        }




        include_once "color/color.php";


        $course = new Course;
        $course->school_id = $school_id;
        $course->department_id = $department_id;
        $course->course_name = $course_name;
        $course->course_credits = $course_credits;
        $course->course_tag = $course_tag;
        $course->course_desc = $course_description;
        $course->picture_file_id = $picture_file_id;





        if($course->save(false)){
            $data = array('success'=>true, 'course'=>$course);
            $this->renderJSON($data);
            return;
        }else{
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'error saving course', '_files'=>$_FILES,'_post'=>$_POST);
            $this->renderJSON($data);
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
                'Course'=>'path.to.FilterCourse',
                'propertyName'=>'propertyValue',
            ),
        );
    }

    public function actions()
    {
        // return external action Coursees, e.g.:
        return array(
            'action1'=>'path.to.ActionCourse',
            'action2'=>array(
                'Course'=>'path.to.AnotherActionCourse',
                'propertyName'=>'propertyValue',
            ),
        );
    }
    */
}