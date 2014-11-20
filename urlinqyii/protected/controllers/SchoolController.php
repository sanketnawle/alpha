<?php

class SchoolController extends Controller
{
    public function actionView()
    {


        $school = School::model()->find('school_id=:id', array(':id'=>1));
        $user_id=1;
        $user = User::model()->find('user_id=:id', array(':id'=>$user_id));
        //var_dump($user);
        //$members=User::model()->find('school_id:=id', array(':id'=>1));
        $this->render('school',array('user'=>$user,'school'=>$school, 'departments'=>$school->departments, 'users'=>$school->users));
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