<?php

class UniversityController extends Controller
{
	public function actionGetSchools()
	{
        if(!isset($_GET['university_id'])){
            $data = array('success'=>false,'error_id'=>1);
            $this->renderJSON($data);
            return;
        }



        $id = $_GET['university_id'];
        $university = University::model()->find('university_id=:id',array(':id'=>$id));

        if($university){
            $university_data = $this->get_model_associations($university,array('schools'=>array('pictureFile')));
            $data = array('success'=>true,'schools'=>$university_data['schools']);
            $this->renderJSON($data);
            return;
        }else{
            $data = array('success'=>false,'error_id'=>1);
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