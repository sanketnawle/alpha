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


        $user = User::model()->find('user_id=:id', array(':id'=>2));




        $sql = "SELECT c.course_name, c.course_id, cs.professor, cu.class_id, u.lastname
                 FROM class_user cu
                 JOIN class cs
                 ON (cu.class_id = cs.class_id)
                 JOIN course c
                 ON (cs.course_id = c.course_id
                 AND cs.department_id = c.department_id
                 AND cs.school_id = c.school_id)
                 LEFT JOIN user u
                 ON (u.user_id = cs.professor)
                 WHERE cu.user_id = " . $user->user_id;
        $command = Yii::app()->db->createCommand($sql);


        $courses = $command->queryAll();



     /*   $sql = 'SELECT g.group_id, g.group_name
                FROM group g
                JOIN group_users gu
                ON gu.group_id = g.group_id
                WHERE gu.user_id =' . $user->user_id;

        $command = Yii::app()->db->createCommand($sql);


        $groups = $command->queryAll(); */

      $groups = $user->groups;



//        foreach ($user->courses as $course_user){
//            $class_id = $course_user['class_id'];
//        }






		$this->render('leftmenu',array('user'=>$user,'courses'=>$courses,'groups'=>$groups));
	}



    public function actionTopbar()
    {

        $user = User::model()->find('user_id=:id', array(':id'=>2));


        $this->render('topbar',array('user'=>$user));
    }



    public function actionFeeds(){

        $posts = Post::model()->findAll();



        $this->render('feeds',array('posts'=>$posts));
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