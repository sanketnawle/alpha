<?php

class SearchController extends Controller
{

    //public function actionSearch()
    public function actionView()
    {

        //urlinq.com/search?q=lakjsdl
        //$q = $_GET['q'];
        //renders the view file protected/views/search


        $filter = Yii::app()->session['filter'];
        //$q = Yii::app()->getRequest()->getQuery('q');


        $user = User::model()->find('user_id=:id', array(':id'=>1));
        $query = Yii::app()->request->getQuery('q');


        //Yii::app()->request->getPost('q');
        $this->render('search', array('user'=>$user, 'query'=>$query));
    }


    public function actionJson()
    {
        $q = Yii::app()->getRequest()->getQuery('q');
        $data = array('success'=> true, 'posts'=>array('post1','post2', $q));

        $this->renderJSON($data);
    }
}

