<?php

class VideoController extends Controller
{
    public function actionAddVideo(){
        if(!isset($_POST['video_url']) || !isset($_POST['department_id']) || !isset($_POST['topic'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'all data not set', '_post'=>$_POST);
            $this->renderJSON($data);
            return;
        }
        $video = new Video();
        $video->department_id=$_POST['department_id'];
        $video->video_url=$_POST['video_url'];
        if($_POST['topic']!=""){
            $video->subtopic=$_POST['topic'];
        }

        if($video->save(false)){
            $data = array('success'=>true);
            $this->renderJSON($data);
            return;
        }

    }

    public function actionGetVideos(){
        $user = $this->get_current_user();
        if(!$user){
            $data = array('success'=>false, 'error_id'=>1);
            $this->renderJSON($data);
            return;
        }
        $videos = Video::model()->findAll('department_id=:did',array(':did'=>$user->department_id));
        $videos_following = Video::model()->findAllBySql('select v.* from video v, department_follow f where v.department_id = f.department_id and f.user_id = '.$user->user_id);
        $videos = array_merge($videos,$videos_following);
        foreach($videos as $i=>$video){
            $videos[$i] = $this->get_model_associations($video,array('department'=>array()));
            $videos[$i] = $this->model_to_array($videos[$i]);
            $replies = VideoReply::model()->findAll('video_id = :vid',array(':vid'=>$video->video_id));

            foreach ($replies as $j => $reply1) {

                $reply_user = $reply1->user;
                $replies[$j] = $this->model_to_array($reply1);
                // making boolean/tinyint to int
                $replies[$j]['anon'] = intval($reply1['anon']);
                //$replies[$j]['up_vote'] = intval($reply1['up_vote']);
                //$replies[$j]['down_vote'] = intval($reply1['down_vote']);

                $replies[$j]['update_timestamp'] = strtotime($reply1['update_timestamp']);
                //$replies[$j]['update_timestamp'] = strtotime(gmdate('Y-m-d H:i:s',strtotime($reply1['update_timestamp']." EST")));


                $replies[$j]['user_info'] =  array('user_id'=>$reply_user->user_id,'user_name'=>$reply_user->firstname." ".$reply_user->lastname, 'picture_file_id'=>$reply_user->picture_file_id, 'pictureFile'=>$reply_user->pictureFile);

                //                    echo "***".$j." ".$reply1['user_id']." ".self::$cur_user_id."***";
                if (intval($reply1['user_id']) == intval($user->user_id)) {
                    //                        echo "###".$j." ".$reply1['user_id']." ".self::$cur_user_id."###";
                    $replies[$j]['cownership'] = TRUE;
                } else {
                    //                        echo "###".$j." ".$reply1['user_id']." ".self::$cur_user_id."###";
                    $replies[$j]['cownership'] = FALSE;
                }

            }
            $videos[$i]['replies'] = $replies;
            $videos[$i]['like_count'] = sizeof($video->users_liked);
            $videos[$i]['liked'] = VideoLike::model()->exists('video_id=:vid and user_id=:uid',array(':vid'=>$video->video_id,':uid'=>$user->user_id));
        }


        $data = array('success'=>true, 'videos'=>$videos);
        $this->renderJSON($data);
        return;
    }

    public function actionDeleteReply(){
        if(!isset($_POST['id'])){
            $data = array('success'=>false,'error_id'=>1, 'post'=>$_POST);
            $this->renderJSON($data);
            return;
        }

        $id = $_POST['id'];


        $reply = VideoReply::model()->find('video_reply_id=:reply_id', array(':reply_id'=>$id));
        if(!$reply){
            $data = array('success'=>false,'error_id'=>2, 'post'=>$_POST);
            $this->renderJSON($data);
            return;
        }



        if($reply->delete()){
            $data = array('success'=>true);
            $this->renderJSON($data);
            return;
        }else{
            $data = array('success'=>false,'error_id'=>3, 'error_msg'=>'error deleting reply' , 'post'=>$_POST);
            $this->renderJSON($data);
            return;
        }

    }
	public function actionLike()
	{
        try{
            if(!isset($_POST['video_id'])){
                $return_data = array('success'=>false,'error_id'=>1);
                $this->renderJSON($return_data);
                return;
            }


            $user = $this->get_current_user($_POST);
            if(!$user){
                $return_data = array('success'=>false,'error_id'=>2, 'error_msg'=>"error found user");
                $this->renderJSON($return_data);
                return;
            }
            $video_id = $_POST['video_id'];

            //$post = Post::model()->find('post_id=:id', array(':id'=>$post_id));


            $video_like = PostLike::model()->findBySql("SELECT * FROM video_like WHERE video_id=" . $video_id . ' AND user_id=' . $user->user_id);


            //Make sure the user hasnt already liked this post
            if(!$video_like){
                $video_like = new VideoLike;
                $video_like->video_id = $video_id;
                $video_like->user_id = $user->user_id;
                $video_like->save(false);
                if($video_like) {

                    $return_data = array('success'=>true);
                    $this->renderJSON($return_data);
                    return;

                }else{
                    $return_data = array('success'=>false,'error_id'=>3, 'error_msg'=>"error saving post_user table");
                    $this->renderJSON($return_data);
                    return;
                }
            }else{
                $return_data = array('success'=>false,'error_id'=>2);
                $this->renderJSON($return_data);
                return;
            }

        }catch(Exception $e){
            $return_data = array('success'=>false,'error_id'=>3,'error_msg'=>$e->getMessage());
            $this->renderJSON($return_data);
            return;
        }
	}

    public function actionUnlike()
    {
        try {
            if (!isset($_POST['video_id'])) {
                $return_data = array('success' => false, 'error_id' => 1);
                $this->renderJSON($return_data);
                return;
            }


            $user = $this->get_current_user($_POST);
            if (!$user) {
                $return_data = array('success' => false, 'error_id' => 2, 'error_msg' => "error found user");
                $this->renderJSON($return_data);
                return;
            }
            $video_id = $_POST['video_id'];
            $video_like = VideoLike::model()->findBySql("SELECT * FROM video_like WHERE video_id=" . $video_id . ' AND user_id=' . $user->user_id);
            if ($video_like->delete()) {

                $return_data = array('success' => true);
                $this->renderJSON($return_data);
                return;

            } else {
                $return_data = array('success' => false, 'error_id' => 2, 'error_msg' => 'Error deleting post_like');
                $this->renderJSON($return_data);
                return;
            }
        }catch(Exception $e){
            $return_data = array('success'=>false,'error_id'=>3,'error_msg'=>$e->getMessage());
            $this->renderJSON($return_data);
            return;
        }


        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//		if(!isset($_GET['ajax']))
//			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

	public function actionReply(){
        if(!isset($_POST['video_id']) || !isset($_POST['reply_text']) || !isset($_POST['reply_user_id']) || !isset($_POST['anonymous'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'All data is not set');
            $this->renderJSON($data);
            return;
        }

        $user = $this->get_current_user($_POST);

        if (!$user) {
            $data = array('success'=>false,'error_id'=>2,'error_msg'=>'not a valid user.');
            $this->renderJSON($data);
            return;
        }

        try{

            //$post_id = $_POST['post_id'];
            $video_id = $_POST['video_id'];

            $reply_text = $_POST['reply_text'];
            $reply_user_id = $_POST['reply_user_id'];
            $reply_user = User::model()->find("user_id=:user_id",array(":user_id"=>$reply_user_id));

            $anonymous = $_POST['anonymous'];

            $video = Video::model()->find("video_id=:video_id",array(":video_id"=>$video_id));
            if($video){
                //Create a new reply model
                $reply = new VideoReply();
                $reply->reply_msg = $reply_text;
                $reply->video_id = $video_id;
                $reply->anon = $anonymous;
                $reply->user_id = $reply_user_id;
                $reply->save(false);

                if($reply){


                    $reply_data = array(
                        'reply_id'=>$reply->video_reply_id,
                        'video_id'=>$video->video_id,
                        'reply_msg'=>$reply->reply_msg,
                        'anon'=>$reply->anon,
                        //'update_timestamp'=>strtotime(gmdate('Y-m-d H:i:s')),
                        'update_timestamp'=>$reply->update_timestamp,
                        'user_info'=>array(
                            'user_id'=>$reply_user_id,
                            'user_name'=>$reply_user->firstname . ' ' . $reply_user->lastname,
                            'pictureFile'=>$reply_user->pictureFile
                        ),
                        'cownership'=>true,
                        'vote_status'=>null
                    );
                    $data = array('success'=>true,'reply'=>$reply_data);
                    $this->renderJSON($data);
                    return;
                }else{
                    $data = array('success'=>false,'error_id'=>3,'error_msg'=>'error creating reply');
                    $this->renderJSON($data);
                    return;
                }


            }else{
                $data = array('success'=>false,'error_id'=>2,'error_msg'=>'post with id ' . $video_id . 'does not exist');
                $this->renderJSON($data);
                return;
            }
        }catch(Exception $e){
            $data = array('success'=>false,'error_id'=>2,'error_msg'=>$e->getMessage());
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