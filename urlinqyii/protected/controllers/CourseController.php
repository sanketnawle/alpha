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