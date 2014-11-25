<?php

class ClassController extends Controller
{


    //COULD NOT USE "CLASS" FOR THE MODEL NAME
    //SO USE ClassModel::model() WHEN ACCESSING CLASS DATA
   /* public function addUserFlags($members, $usersFollowed){
        $newMembers = [];
        $newMembers['users'] = $members;
        $newMembers['flags'] = [];
        foreach($members as $i=>$member){
            $newMembers['flags'][$i]['following'] = in_array($member->user_id,$usersFollowed);
        }
        return $newMembers;
    } */

    public function actionView()
    {

        $class_id = $_GET['id'];
        $user_id = 2;

        $class = ClassModel::model()->find('class_id=:id', array(':id' => $class_id));
        $user = User::model()->find('user_id=:id', array(':id'=>$user_id));

        $course = $class->course;

        $professor = User::model()->find('user_id = :id',array(':id'=>$class->professor));

        $department = $class->department;
        $university = $class->school;

        $schedules = $class->schedules;

        $schedule_strings = [];
        foreach($schedules as $schedule){
            $schedule_strings[] = $schedule->day . ' ' . $schedule->start_time . ' to ' . $schedule->end_time;
        }
        $is_member = false;

        foreach ($class->users as $student) {
            if($user->user_id == $student->user_id){
                $is_member = true;
                break;
            }
        }

        $is_admin = false;
        foreach ($class->admins as $student) {
            if($user->user_id == $student->user_id){
                $is_admin = true;
                break;
            }
        }

        $files =  Yii::app()->db->createCommand()
        ->select('u.firstname, u.lastname, c.text_msg, f.* ')
        ->from('class_file c, file f, user u')
        ->where('c.class_id=:id and c.file_id = f.file_id and c.user_id = u.user_id', array(':id'=>$class_id))
        ->queryAll();

       /* $usersFollowedQuery =  Yii::app()->db->createCommand()
            ->select('uc.to_user_id')
            ->from('user_connection uc, class_user cu')
            ->where('uc.from_user_id = :uid and cu.class_id = :cid and cu.user_id = uc.to_user_id', array(':cid'=>$class_id,'uid'=>$user_id))
            ->queryAll();
        $usersFollowed = */


        /*$following = [];
        foreach($user->usersFollowed as $userFollowed){
            foreach($class->users as $member){
                if($userFollowed->user_id == $member->user_id){
                    $following[] = $member->user_id;
                }
            }
        }*/
        $students = $class->students;
        $admins = $class->admins;

        $other_courses_from_prof =  Yii::app()->db->createCommand()
           // ->select('co.course_name, cl.section_id')
            ->select('co.course_id,co.course_name')
            ->from('course co, class cl')
            ->where('cl.professor = :pid and cl.course_id = co.course_id and cl.class_id != :cid',
                    array(':pid'=>$professor->user_id,':cid'=>$class_id))
            ->queryAll();

        $students_following_that_took_course = User::model()->findAllBySql(' select u.*
            from class c1, class c2, class_user cu, user u, user_connection uc
             where c1.class_id = :cid and c1.course_id = c2.course_id and cu.class_id=c2.class_id
                and cu.user_id = u.user_id and u.user_id = uc.to_user_id and uc.from_user_id = :uid
                and (c2.year<c1.year or (c2.year=c1.year and ((c2.semester="spring" and (c1.semester = "summer"
                or c1.semester = "fall")) or (c2.semester="summer" and c1.semester="fall"))))'
                ,array(':uid'=>$user_id,':cid'=>$class_id));

        $this->render('class',array('all_following'=>$students_following_that_took_course, 'students'=>$students,'admins'=>$admins, 'user'=>$user,'class'=>$class, 'course'=>$course, 'professor'=>$professor
            , 'department'=>$department, 'is_member'=>$is_member, 'university'=>$university, 'is_admin'=>$is_admin
            , 'schedules'=>$schedule_strings, 'files'=>$files, 'other_courses'=>$other_courses_from_prof)
              );

    }
	public function actionClass()
	{
		$this->render('class');
	}

    public function actionJson() {
        $course_id = Yii::app()->request->getQuery('course_id');
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
        echo CJSON::encode(array(
            'success' => true,
            'count' => count($classes),
            'data' => $classes
        ));
        Yii::app()->end();
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