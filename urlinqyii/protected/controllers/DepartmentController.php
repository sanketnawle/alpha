<?php

class DepartmentController extends Controller
{
	public function actionView()
	{
        $dept_id = $_GET['id'];
        $dept = Group::model()->find('group_id=:id', array(':id'=>$dept_id));
        $user = User::model()->find('$user_id=:id', array(':id'=>1));

        $get_course_members_query = "SELECT U.firstname, U.lastname, U.user_id, U.user_type, U.user_bio, UN.univ_name, UN.univ_id, (SELECT COUNT(*) FROM connect CO WHERE U.user_id = CO.to_user_id AND CO.from_user_id = $user_id)as follow_flag FROM user U

LEFT JOIN university UN ON UN.univ_id = U.univ_id

WHERE U.dept_id = $dept_id AND U.status = 'active'

ORDER BY user_type";

        $command = Yii::app()->db->createCommand($get_course_members_query);
        $connected_users = $command->queryAll();

        $get_course_connection_query = "SELECT U.user_id, U.firstname, U.lastname FROM course_follow CF
JOIN user U on CF.user_id = U.user_id AND U.user_type = 's'
WHERE CF.user_id IN ($connected_users) AND CF.course_id = '$this_course_id'";

        $command = Yii::app()->db->createCommand($get_course_connection_query);
        $connected_users = $command->queryAll();

        $get_class_query = "SELECT CM.section_id, CM.class_id FROM courses_semester CM WHERE CM.course_id = '$this_course_id' AND CM.semester = '$current_semester'";
        $command = Yii::app()->db->createCommand($get_class_query);
        $connected_users = $command->queryAll();


        $get_courses_query = "SELECT C.*, (SELECT COUNT(*) FROM course_follow CF WHERE C.course_id = CF.course_id AND CF.user_id = $user_id) as follow_flag, (SELECT COUNT(CM.class_id) FROM courses_semester CM WHERE CM.course_id = C.course_id AND CM.semester = '$current_semester') as class_count FROM courses C WHERE C.dept_id = $dept_id ORDER BY class_count DESC";
        $command = Yii::app()->db->createCommand($get_courses_query);
        $connected_users = $command->queryAll();

        $student_count_query = "SELECT COUNT(*) as student_count FROM user SU WHERE SU.dept_id = $dept_id AND SU.user_type = 's' AND SU.status = 'active'";
        $command = Yii::app()->db->createCommand($student_count_query);
        $connected_users = $command->queryAll();

        $prof_count_query = "SELECT COUNT(*) as prof_count FROM user PU WHERE PU.dept_id = $dept_id AND PU.user_type = 'p' AND PU.status = 'active'";
        $command = Yii::app()->db->createCommand($prof_count_query);
        $connected_users = $command->queryAll();

        $get_department_details_query = "SELECT (SELECT COUNT(*) FROM user U WHERE U.dept_id = D.dept_id AND U.status = 'active') as user_count, D.*, (SELECT COUNT(*) FROM courses C WHERE C.dept_id = D.dept_id) AS course_count, (SELECT COUNT(*) FROM user U WHERE U.dept_id = D.dept_id AND U.user_id = $user_id) as join_flag, (SELECT COUNT(*) FROM department_follow DF WHERE DF.dept_id = $dept_id AND DF.user_id = $user_id) as follow_flag FROM department D WHERE D.dept_id = $dept_id";
        $command = Yii::app()->db->createCommand($get_department_details_query);
        $connected_users = $command->queryAll();

        $get_department_about_query = "SELECT dept_desc FROM department WHERE dept_id = '$dept_id'";
        $command = Yii::app()->db->createCommand($get_department_about_query);
        $connected_users = $command->queryAll();

        $this->render('department', array('dept'=> $dept, 'member'=> $get_course_members_query, 'student_count'=> $student_count_query, 'prof_count'=> $prof_count_query, 'dept_details'=> $get_department_details_query, 'dept_description'=>$get_department_about_query, 'course_connect'=>$get_course_connection_query, 'course_query'=> $get_courses_query,'class_query'=>$get_class_query));
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