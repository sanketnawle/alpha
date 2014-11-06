<?php

class SearchController extends Controller
{
	public function actionSearch()
	{
		$this->render('search');
	}


    public function actionJson(){
        $q = Yii::app()->getRequest()->getQuery('q');
        $data = array('success'=>true,'posts'=>array('post1','post2', $q));

        $this->renderJSON($data);
    }

	//public function actionFilterSearch(){}

}