<?php

class FileController extends Controller
{
	public function actionIncrementDownloadCount()
	{
        if(!isset($_POST['file_id'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'file_id not set');
            $this->renderJSON($data);
            return;
        }

        $file_id = $_POST['file_id'];
        $file = File::model()->find('file_id=:file_id', array(':file_id'=>$file_id));

        if($file){
            $file->download_count += 1;
            if($file->save(false)){
                $data = array('success'=>true,'download_count'=>$file->download_count);
                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false,'error_id'=>3,'error_msg'=>'error saving file');
                $this->renderJSON($data);
                return;
            }

        }else{
            $data = array('success'=>false,'error_id'=>2,'error_msg'=>'file doesnt exist');
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