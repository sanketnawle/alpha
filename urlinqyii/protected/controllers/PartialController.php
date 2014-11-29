<?php

class PartialController extends Controller
{




	public function actionLeftmenu(){

//        $select_stmt = $con->prepare("SELECT c.course_name, c.course_id, cs.dp_blob_id,
//                                cs.professor, cu.class_id, u.lastname
//                             FROM `courses_user` cu
//                             JOIN courses_semester cs
//                             ON (cu.class_id = cs.class_id)
//                             JOIN courses c
//                             ON (cs.course_id = c.course_id
//                             AND cs.dept_id = c.dept_id
//                             AND cs.univ_id = c.univ_id)
//                             LEFT JOIN user u
//                             ON (u.user_id = cs.professor)
//                             WHERE cu.user_id = ?");


//        if(!$this->authenticated()){
//            $this->redirect(array('/'));
//        }


        $user_id = Yii::app()->session['user_id'];

        //$user = User::model()->find('user_id=:id', array(':id'=>$user_id));
        $user = User::model()->find('user_id=:id', array(':id'=>1));



        $sql = "SELECT c.course_name, c.course_id, cs.picture_file_id,cs.professor, cu.class_id, u.lastname
                 FROM `class_user` cu
                 JOIN class cs
                 ON (cu.class_id = cs.class_id)
                 JOIN course c
                 ON (cs.course_id = c.course_id
                 AND cs.department_id = c.department_id
                 AND cs.school_id = c.school_id)
                 LEFT JOIN user u
                 ON (u.user_id = cs.professor)
                 WHERE cu.user_id = " . $user->user_id;
        //$command = Yii::app()->db->createCommand($sql);



        //$classes = $command->queryAll();
        $classes = ClassModel::model()->findAllBySql($sql);



        $sql = 'SELECT g.group_id, g.group_name, g.picture_file_id
                FROM `group` g
                JOIN group_user gu
                ON gu.group_id = g.group_id
                WHERE gu.user_id = ' . $user->user_id;

        $groups = Group::model()->findAllBySql($sql);



//        foreach ($user->courses as $course_user){
//            $class_id = $course_user['class_id'];
//        }






		$this->render('leftpanel',array('user'=>$user,'classes'=>$classes,'groups'=>$groups));
	}


    public function actionTopbar()
    {
        $user_id = Yii::app()->session['user_id'];

        //$user = User::model()->find('user_id=:id', array(':id'=>$user_id));
        //$user = User::model()->find('user_id=:id', array(':id'=>1));
        $user = $this->get_current_user();
        $school = $user->school->school_name;
        $department = $user->department->department_name;

        $this->render('topbar',array('user'=>$user, 'school'=>$school, 'department'=>$department));
    }




    public function actionPlanner()
    {


//        $user_id = Yii::app()->session['user_id'];
//
//        //$user = User::model()->find('user_id=:id', array(':id'=>$user_id));
//        $user = User::model()->find('user_id=:id', array(':id'=>1));
//
//

        $this->render('homePlanner',array('file_url'=>$file_url));
    }


    public function actionFeed(){

        $posts = Post::model()->findAll();



        $this->render('feed',array('posts'=>$posts));
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