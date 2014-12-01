<?php

class CourseController extends Controller
{
    public function actionView() {
        $user = $this->get_current_user();

        $course_id = $_GET['id'];
        if($course_id == null) {
            echo CJSON::encode(array(
                'success' => false,
                'message' => 'Invalid Course Id'
            ));
            Yii::app()->end();
        }

        $sql = "SELECT c.class_id, c.course_id, c.section_id, cr.course_name, c.department_id, d.department_name, c.component, c.color_id, c.location,
              u.firstname as prof_fname, u.lastname as prof_lname, f1.file_url AS cover_file_url, f2.file_url AS picture_file_url
            FROM class as c
            INNER JOIN course as cr
              ON c.course_id = cr.course_id
            LEFT JOIN department as d
              ON c.department_id = d.department_id
            LEFT JOIN user AS u
              ON c.professor = u.user_id
            LEFT JOIN file AS f1
              ON c.cover_file_id = f1.file_id
            LEFT JOIN file AS f2
              ON c.picture_file_id = f2.file_id
            WHERE c.course_id = $course_id
        ";

//        , s.day, s.start_time, s.end_time
        $classes = Yii::app()->db->createCommand($sql)->queryAll();
        $schedules = array();
        for($i=0; $i< count($classes); $i++)  {
            $sql = "SELECT * FROM class_schedule as cs
                      LEFT JOIN schedule AS s
                        ON cs.schedule_id = s.schedule_id
                        WHERE cs.class_id = {$classes[$i]['class_id']}";
            $classes[$i]['schedule'] = array(
                'day' => 'M',
                'start_time' => '17:00:00',
                'end_time' => '17:00:00'
            );
//            $classes[$i]['schedule'] = Yii::app()->db->createCommand($sql)->queryAll();


            $sql = "SELECT * FROM class_user as cu
                      LEFT JOIN user AS u
                        ON cu.user_id = u.user_id
                        WHERE cu.class_id = {$classes[$i]['class_id']}";
            $classes[$i]['users'] = Yii::app()->db->createCommand($sql)->queryAll();

        }
        //echo CJSON::encode(array('success' => true, 'count' => count($classes), 'data' => $classes));
        //Yii::app()->end();
        $this->render('course',array('user' => $user));
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