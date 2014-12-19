<?php

class PartialController extends Controller
{




	public function actionLeftmenu(){
        $user = $this->get_current_user();



		$this->render('leftpanel',array('user'=>$user));
	}



    public function actionRightmenu(){


        $user = $this->get_current_user();





        $this->render('rightpanel',array('user'=>$user));
    }

    public function actionTopbar()
    {
        $user_id = Yii::app()->session['user_id'];

        //$user = User::model()->find('user_id=:id', array(':id'=>$user_id));
        $user = User::model()->find('user_id=:id', array(':id'=>1));
        //$user = $this->get_current_user();
        $school = $user->school->school_name;
        //Changed by Alex. This line was causing errors lkajsdl

        //$department = $user->department->department_name;
        $department = $user->department['department_name'];
        //$department = $user->department;

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