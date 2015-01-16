<?php

//echo Yii::app()->request->pathInfo;

class FeedController extends Controller
{
    // The user_id is hard coded, it has to be taken from the SESSION
    const POST_LIMIT = 10; //this is the limit for number of posts to be fetched from the DB
    private static $reply_limit;
    private static $cur_user_id;
    private static $cur_sem;
    private static $user;
    private static $start_rec;
    private static $reply_rec;
    private static $reply_flag;

    public function __construct(){
        self::$cur_user_id = Yii::app()->session['user_id'] || 1;
        self::$user = User::model()->find('user_id=:id', array(':id'=> self::$cur_user_id));
        self::$cur_sem = "fall";

        // setting start_rec value
        if(isset($_POST['start_rec'])) self::$start_rec = 10*$_POST['start_rec'];
        else self::$start_rec = 0;
    }

    public function convertModelToArray($models) {
        if (is_array($models))
            $arrayMode = TRUE;
        else {
            $models = array($models);
            $arrayMode = FALSE;
        }

        $result = array();
        foreach ($models as $model) {
            $attributes = $model->getAttributes();
            $relations = array();
            foreach ($model->relations() as $key => $related) {
                if ($model->hasRelated($key)) {
                    $relations[$key] = self::convertModelToArray($model->$key);
                }
            }
            $all = array_merge($attributes, $relations);

            if ($arrayMode)
                array_push($result, $all);
            else
                $result = $all;
        }
        return $result;
    }

    public function validatePrivacy($post_privacy, $origin_type=NULL, $origin_id=NULL){
        // privacy check starts
//        echo "#".$post_privacy."#";
        if($post_privacy=="students_only" && self::$user->user_type!="s"){
            return FALSE;
        }
        elseif($post_privacy=="professors_only" && self::$user->user_type!="p"){
            return FALSE;
        }
        elseif($post_privacy=="members"){
//            echo "***";
            if(!is_null($origin_type) && !is_null($origin_id)){
//                echo "billa*";
//                echo $origin_id."**".$origin_type;

                if($origin_type=="group" || $origin_type=="class") {
                    $privacy_stmt = "SELECT * FROM " . $origin_type . "_user WHERE " . $origin_type . "_id=" . $origin_id . " AND user_id=" . self::$cur_user_id;
                    $command = Yii::app()->db->createCommand($privacy_stmt);
                    if ($priv = $command->queryAll()) {
                        //                    echo "(cccccccccccc)".count(array($priv));
                        if (count(array($priv)) == 1)
                            return TRUE;
                    }
                    return FALSE;
                }
                elseif($origin_type == "profile"){
                    if($origin_id == self::$cur_user_id)
                        return TRUE;
                    elseif(UserConnection::model()->findByPk(array('to_user_id'=>$origin_id,'from_user_id'=>self::$cur_user_id)))
                        return TRUE;
                    else
                        return FALSE;
                }

            }
//            echo "jaffa*";
            return FALSE;
        }
        else
            return TRUE;
        // privacy check ends
    }

    public function getUserInfo($id,$type="post"){
//        echo $type;
//        $user_now = User::model()->find('user_id=:id', array(':id'=>$id));
//        $user_name = $user_now->firstname." ".$user_now->lastname;
//        $user_url = "/profile/".$id;
//        $user_pic_url = $user_now->picture_file_id;
//        $user_info = array('user_name'=>$user_name, 'user_url'=>$user_url, 'user_pic'=>$user_pic_url, 'user_pic_url'=>$user_pic_url);
//        return($user_info);
        $user = User::model()->find("user_id=:user_id",array(":user_id"=>$id));

        if($type=="reply"){
            $data = array('user_id'=>$user->user_id,'user_name'=>$user->firstname." ".$user->lastname, 'picture_file_id'=>$user->picture_file_id);
        }
        else {
            $data = $this->get_model_associations($user, array('pictureFile'=>array(),'department' => array('pictureFile', 'coverFile'),
                'school' => array('pictureFile', 'coverFile', 'university')));
        }
        return $data;
    }

    public function getReplies($posts){

        // setting reply_flag
        if(isset($_GET['reply'])) {
            if ($_GET['reply'] == FALSE)
                self::$reply_flag = FALSE;
        }
        else
            self::$reply_flag = TRUE;


        foreach ($posts as $i => $post) {

            $reply_count = Reply::model()->count('post_id=:id', array(':id' => $post['post_id']));
            $posts[$i]['reply_count'] = $reply_count;

            if(self::$reply_flag) {

                // limit reply records
//                    if(!isset($_GET['reply_rec'])) {
//                        self::$reply_limit = 10;
//                        if ($reply_count > 2)
//                            self::$reply_rec = $reply_count - 2;
//                        else
//                            self::$reply_rec = 0;
//                    }
//                    elseif($_GET['reply_rec'] >= 1){
//                        if ($reply_count > 2) {
//                            if($reply_count <= (10*+2))
//                                self::$reply_rec = 0;
//                            else
//                                self::$reply_rec = $reply_count - 12;
//                            self::$reply_limit = $reply_count - 2;
//                        }
//                        else
//                            self::$reply_rec = 0;
//                        self::$reply_rec = $reply_count;
//                    }

                $reply = Reply::model()->findAll('post_id=:id', array(':id' => $post['post_id']));

                // alternate query for reply with LIMIT
//                    $reply_sql = "SELECT * FROM reply r
//                                    WHERE reply_id
//                                    in (SELECT reply_id
//                                         FROM (SELECT reply_id FROM reply WHERE post_id = $post['post_id']
//                                         ORDER BY reply_id DESC LIMIT self::$reply_rec, self::$reply_limit)
//                                        as q)
//                                    ORDER BY id ASC";
//                    $command = Yii::app()->db->createCommand($reply_sql);
//                    $reply = $command->queryAll();

                $replies = self::convertModelToArray($reply);
                //            print_r($replies);

                if ($replies != NULL) {

                    foreach ($replies as $j => $reply1) {

                        // making boolean/tinyint to int
                        $replies[$j]['anon'] = intval($reply1['anon']);
                        $replies[$j]['up_vote'] = intval($reply1['up_vote']);
                        $replies[$j]['down_vote'] = intval($reply1['down_vote']);

                        $replies[$j]['update_timestamp'] = strtotime($reply1['update_timestamp']);

                        $replies[$j]['user_info'] = self::getUserInfo($reply1['user_id'],"reply");
                        //                    echo "***".$j." ".$reply1['user_id']." ".self::$cur_user_id."***";
                        if (intval($reply1['user_id']) == intval(self::$cur_user_id)) {
                            //                        echo "###".$j." ".$reply1['user_id']." ".self::$cur_user_id."###";
                            $replies[$j]['cownership'] = TRUE;
                        } else {
                            //                        echo "###".$j." ".$reply1['user_id']." ".self::$cur_user_id."###";
                            $replies[$j]['cownership'] = FALSE;
                        }

                        if($ex_model = ReplyVote::model()->findbypk(array('reply_id' => $reply1['reply_id'], 'user_id' => self::$cur_user_id)))
                            $replies[$j]['vote_status'] = $ex_model->vote_type;
                        else
                            $replies[$j]['vote_status'] = NULL;
                    }
                }
                $posts[$i]['replies'] = $replies;
            }
        }
        return $posts;
    }


    public function getOptionsInfo($options){
        foreach($options as $k=>$option){
            $post_opt_mem = PostQuestionOptionAnswer::model()->findAll('option_id=:id', array(':id'=>$option['option_id']));
            $participants = self::convertModelToArray($post_opt_mem);

            // extracting all the user_id from participants
            // $participants_user_id = array_column($participants,"user_id");
            $participants_user_id = array_map(function ($ar) {return $ar['user_id'];}, $participants);

            $options [$k] ['participants_count'] = count($participants_user_id);

            $participants_info = array();

            foreach($participants_user_id as $l=>$p_id){
                if(isset($participants_info[$l]))
                    echo $participants_info[$l];
                    $participants_info[$l] = self::getUserInfo($p_id);
            }
            $options [$k] ['participants_info'] = $participants_info;
            
            if(in_array(self::$cur_user_id, $participants_user_id))
                $options [$k] ['user_answered'] = TRUE;
            else
                $options [$k] ['user_answered'] = FALSE;
        }
        return $options;
    }

    public function addPostData($posts){
        foreach($posts as $i=>$post){
//            echo "#".$post['privacy']."*".$post['origin_type']."*".$post['origin_id']."#";
            if(!self::validatePrivacy($post['privacy'],$post['origin_type'],$post['origin_id'])){
//                echo "here";
                unset($posts[$i]);
                continue;
            }
//            else{
//                echo "Aha!";
//            }

            // convert boolean/tinyint into int
            $posts[$i]['anon'] = intval($post['anon']);
            $posts[$i]['like_count'] = intval($post['like_count']);

            // getting and appending the user_name
            $posts[$i]['user_info'] = self::getUserInfo($post['user_id']);

            // post-ownership flag
            if($post['user_id']==self::$cur_user_id)
                $posts[$i]['pownership'] = TRUE;
            else
                $posts[$i]['pownership'] = FALSE;

            // getting and appending the origin
            if($post['origin_type']=="user"){
                $origin = User::model()->find('user_id=:id', array(':id'=>$post['origin_id']));
                $posts [$i] ['origin'] = $origin->firstname." ".$origin->lastname;

            }
            elseif($post['origin_type']=="class"){
                $class = ClassModel::model()->find('class_id=:id', array(':id'=>$post['origin_id']));
                $sec_id = $class->section_id;
                $course = $class->course;
                $course_name = $course->course_name;
                $posts [$i] ['origin_name'] = $course_name." (".$sec_id.")";
                $posts [$i] ['origin_pic_id'] = $class->picture_file_id;
//                $posts [$i] ['origin'] = $this->get_model_associations($class,array('pictureFile','coverFile', 'course'));
            }
            elseif($post['origin_type']=="course"){
                $course = Course::model()->find('course_id=:id', array(':id'=>$post['origin_id']));
                $posts [$i] ['origin_name'] = $course->course_name;
                $posts [$i] ['origin_pic_id'] = $course->picture_file_id;
            }
            elseif($post['origin_type']=="department"){
                $dept = Department::model()->find('department_id=:id', array(':id'=>$post['origin_id']));
                $posts [$i] ['origin_name'] = $dept->dept_name;
                $posts [$i] ['origin_pic_id'] = $dept->picture_file_id;
            }

            elseif($post['origin_type']=="school"){
                $origin = School::model()->find('school_id=:id', array(':id'=>$post['origin_id']));
                $posts [$i] ['origin_name'] = $origin->school_name;
                $posts [$i] ['origin_pic_id'] = $origin->picture_file_id;
            }
            elseif($post['origin_type']=="group"){
                $origin = Group::model()->find('group_id=:id', array(':id'=>$post['origin_id']));
                $posts [$i] ['origin_name'] = $origin->group_name;
                $posts [$i] ['origin_pic_id'] = $origin->picture_file_id;
            }
            else{
                $posts [$i] ['origin_name'] = NULL;
                $posts [$i] ['origin_pic_id'] = NULL;
            }

            if(PostLike::model()->findBySql("SELECT * FROM post_like WHERE post_id=" . $post['post_id'] . ' AND user_id=' . $this->get_current_user_id())){
                $posts [$i] ['like_status'] = TRUE;
            }else{
                $posts [$i] ['like_status'] = FALSE;
            }


            if($post['file_id'] != NULL) {
                $file = File::model()->find('file_id=:id', array(':id'=>$post['file_id']));
                if ($file)
                    $posts [$i] ['file'] = self::convertModelToArray($file);
                else
                    $posts [$i] ['file'] = null;
            }
            else
                $posts [$i] ['file'] = NULL;


            // handle question type posts
            if($post['post_type'] == 'question'){
                $post_que = PostQuestion::model()->find('post_id=:id', array(':id'=>$post['post_id']));

                $posts [$i] ['active'] = $post_que->active;
                $posts[$i]['question'] = self::convertModelToArray($post_que);

                // give correct answer, if NOT active
                if($post_que->active == 0)
                    $posts [$i] ['answer'] = PostQuestionOption::model()->findAll('option_id=:id', array(':id'=>$post_que['correct_answer_id']));
                else
                    $posts [$i] ['answer'] = NULL;

                // adding all the options to the array
                $post_que_options = PostQuestionOption::model()->findAll('post_id=:id', array(':id'=>$post['post_id']));
                $options = self::convertModelToArray($post_que_options);
                $posts [$i] ['options'] = self::getOptionsInfo($options);

//                // adding info of participants
//                $option_ids = array_column($options, 'option_id');
//                $post_que_mem = PostQuestionOptionAnswer::model()->findAll('option_id=:id', array(':id'=>$option_ids));
//                $participants = self::convertModelToArray($post_que_mem);
//                if(in_array(self::$cur_user_id, array_column($participants, 'user_id')))
//                    $posts [$i] ['answered'] = TRUE;

            }

            elseif($post['post_type'] == 'event'){
                $post_event = Event::model()->findByPK($post['origin_id']);
                $event = $this->model_to_array($post_event);

                $origin = $event['origin_type'];
                $origin_id = $event['origin_id'];

                if($origin != 'user'){
                    $sql = "SELECT " . $origin . '_name, color_id FROM `' . $origin . '`  WHERE ' . $origin . '_id = ' . $origin_id;
                    $command = Yii::app()->db->createCommand($sql);
                    $origin_data = $command->queryRow();
                    //echo json_encode($origin_data);
                    $event['origin_name'] = $origin_data[$origin . '_name'];
                    $event['origin_color_id'] = $origin_data['color_id'];
                    //array_push($events_data,$event);
                }else{
                    $event['origin_name'] = null;
                    $event['origin_color_id'] = null;
                }
                $user = $this->get_current_user($_GET);
                $event_attending = EventUser::model()->find("user_id=:user_id and event_id=:event_id", array(":user_id"=>$user->user_id, ":event_id"=>$event['event_id']));
                if($event_attending){
                    $event['is_attending'] = true;
                }
                else{
                    $event['is_attending'] = false;
                }

                $posts [$i] ['event'] = $posts [$i] ['event'] = $event;

            }

            $posts[$i]['last_activity'] = strtotime($post['last_activity']);
            $posts[$i]['update_timestamp'] = strtotime($post['created_at']);
        }
//        self::getReplies($posts);
        return $posts;
    }


	public function actionGetHomePosts()
	{


        if(!$this->authenticated() || !isset($_GET['token'])){

        }

//      print_r(User::model()->find('user_id=:id', array(':id'=> self::$cur_user_id)));

        // $posts_sql_home = "SELECT distinct *
        //            from post
        //            join post_user_inv
        //              on (post.post_id = post_user_inv.post_id)
        //           where ((post_user_inv.user_id IN (SELECT to_user_id from user_connection where from_user_id = ".self::$user->user_id.")
        //             or post_user_inv.user_id = ".self::$user->user_id.")
        //             or (origin_type = 'university' and origin_id = ".self::$user->school_id.")
        //             or (origin_type = 'department' and origin_id = ".self::$user->department_id.")
        //             or (origin_type = 'class' and origin_id IN (SELECT cu.class_id
        //                                                           from class_user cu join class cs
        //                                                             on (cu.class_id = cs.class_id)
        //                                                             where user_id = ".self::$user->user_id." and cs.semester = '".self::$cur_sem."' and cs.`year` = ".date('Y').")))
        //             order by last_activity DESC
        //             LIMIT ".self::$start_rec.",".self::POST_LIMIT;

        $posts_sql_home = "SELECT distinct *
                            from post
                            join post_user_inv
                              on (post.post_id = post_user_inv.post_id)
                           where ((post_user_inv.user_id IN (SELECT to_user_id from user_connection where from_user_id = ".self::$user->user_id.")
                              or post_user_inv.user_id = ".self::$user->user_id.")
                              or (origin_type = 'university' and origin_id = ".self::$user->school_id.")
                              or (origin_type = 'department' and origin_id = ".self::$user->department_id.")
                              or (origin_type = 'class' and origin_id IN (SELECT cu.class_id
                                                                            from class_user cu join class cs
                                                                              on (cu.class_id = cs.class_id)
                                                                              where user_id = ".self::$user->user_id." and cs.semester = '".self::$cur_sem."' and cs.`year` = ".date('Y').")))
                              order by last_activity DESC
                              LIMIT ".self::$start_rec.",".self::POST_LIMIT;
                  

        $command = Yii::app()->db->createCommand($posts_sql_home);
        if($posts = $command->queryAll())
            $success_post = TRUE;
        else
            $success_post = FALSE;
        $this->renderJSON(array('success'=>$success_post, 'is_admin'=> FALSE, 'feed'=>self::getReplies(self::addPostData($posts))));

//        $this->renderJSON($posts);
	}

    public function actionGetProfilePosts()
    {
        // check if the cur_user is the owner of the profile page currently viewing
        if ($prof_mod = User::model()->find('user_id=:id', array(':id'=> $_GET['id']))){
            if ($prof_mod->user_id == self::$cur_user_id)
                $is_admin = TRUE;
            else
                $is_admin = FALSE;
        }
        else
            $is_admin = FALSE;
        // end check

        $posts_sql_profile = "SELECT distinct *
				  from post p
				  where p.user_id = ".self::$user->user_id."
				  OR (p.origin_type = 'user' and p.origin_id = ".$_GET['id'].")
					ORDER BY last_activity DESC	LIMIT ".self::$start_rec.",".self::POST_LIMIT;

        $command = Yii::app()->db->createCommand($posts_sql_profile);
        $posts = $command->queryAll();
        if($posts){
            $success_post = TRUE;
        }else{
            $success_post = FALSE;
        }

        $this->renderJSON(array('success'=>$success_post, 'is_admin'=>$is_admin, 'feed'=>self::getReplies(self::addPostData($posts))));
    }

    public function actionGetClassPosts()
    {
        // check if the current user is the admin of the class
        if ($cl_mod = ClassUser::model()->findbypk(array('class_id' => $_GET['id'], 'user_id' => self::$cur_user_id))) {
            $is_member = TRUE;
            if ($cl_mod->is_admin == 1)
                $is_admin = TRUE;
            else
                $is_admin = FALSE;
        }
        else {
            $is_member = FALSE;
            $is_admin = FALSE;
        }
        // check end

        $posts_sql_class = "SELECT distinct *
		  from post p
		  where (p.origin_type = 'class' and p.origin_id = '".$_GET['id']."')
			order by last_activity DESC	LIMIT ".self::$start_rec.",".self::POST_LIMIT;

        $command = Yii::app()->db->createCommand($posts_sql_class);

        if($posts = $command->queryAll())
            $success_post = TRUE;
        else
            $success_post = FALSE;

        $this->renderJSON(array('success'=>$success_post, 'is_member'=> $is_member, 'is_admin'=>$is_admin,
            'feed'=>self::getReplies(self::addPostData($posts))));
    }

    public function actionGetCoursePosts()
    {
        $posts_sql_course = "SELECT distinct * from post p where (p.origin_type = 'course' and p.origin_id = '".$_GET['id']."')
			order by last_activity DESC LIMIT ".self::$start_rec.",".self::POST_LIMIT;

        //$command = Yii::app()->db->createCommand()
        //    ->select('*')
        //    ->distinct(true)
        //    ->from('post p')
        //    ->where("(p.origin_type = 'course') and p.origin_id = '".$_GET['id']."'")
        //    ->order("last_activity DESC LIMIT ".self::$start_rec.",".self::POST_LIMIT)
        //    ->queryAll();

        $command = Yii::app()->db->createCommand($posts_sql_course);

        if($posts = $command->queryAll())
            $success_post = TRUE;
        else
            $success_post = FALSE;

        if(self::$user->user_type == "p")
            $is_admin = TRUE;
        else
            $is_admin = FALSE;

        $this->renderJSON(array('success'=>$success_post, 'is_admin'=>$is_admin, 'feed'=>self::getReplies(self::addPostData($posts))));
    }

    public function actionGetClubPosts()
    {
        $posts_sql_club = "SELECT distinct *
		  from post p
		  where (p.origin_type = 'group' and p.origin_id = '".$_GET['id']."')
			order by last_activity DESC
			LIMIT ".self::$start_rec.",".self::POST_LIMIT;

        $command = Yii::app()->db->createCommand($posts_sql_club);

        if($posts = $command->queryAll())
            $success_post = TRUE;
        else
            $success_post = FALSE;

        // check if the current user is an admin to this group/club feed
        if ($g_mod = GroupUser::model()->findbypk(array('group_id' => $_GET['id'], 'user_id' => self::$cur_user_id))) {
            $is_member = TRUE;
            if ($g_mod->is_admin == 1)
                $is_admin = TRUE;
            else
                $is_admin = FALSE;
        }
        else{
            $is_member = FALSE;
            $is_admin = FALSE;
        }
        // check ends

        $this->renderJSON(array('success'=>$success_post, 'is_member'=>$is_member, 'is_admin'=> $is_admin,
            'feed'=>self::getReplies(self::addPostData($posts))));
    }

    public function actionGetDepartmentPosts()
    {
        $posts_sql_dept = "SELECT distinct *
		  from post p
		  where (p.origin_type = 'department' and p.origin_id = '".$_GET['id']."')
			order by last_activity DESC
			LIMIT ".self::$start_rec.",".self::POST_LIMIT;

        $command = Yii::app()->db->createCommand($posts_sql_dept);

        if($posts = $command->queryAll())
            $success_post = TRUE;
        else
            $success_post = FALSE;

        if(self::$user->user_type == "p")
            $is_admin = TRUE;
        else
            $is_admin = FALSE;

        $this->renderJSON(array('success'=>$success_post, 'is_admin'=>$is_admin, 'feed'=>self::getReplies(self::addPostData($posts))));
    }

    public function actionGetSchoolPosts()
    {
        $posts_sql_school = "SELECT distinct *
		  from post p
		  where (p.origin_type = 'school' and p.origin_id = '".$_GET['id']."')
			order by last_activity DESC
			LIMIT ".self::$start_rec.",".self::POST_LIMIT;

        $command = Yii::app()->db->createCommand($posts_sql_school);

        if($posts = $command->queryAll())
            $success_post = TRUE;
        else
            $success_post = FALSE;

        if(self::$user->user_type == "p")
            $is_admin = TRUE;
        else
            $is_admin = FALSE;

        $this->renderJSON(array('success'=>$success_post, 'is_admin'=>$is_admin, 'feed'=>self::getReplies(self::addPostData($posts))));
    }

    public function actionGetUniversityPosts()
    {
        $posts_sql_univ = "SELECT distinct *
		  from post p
		  where (p.origin_type = 'university' and p.origin_id = '".$_GET['id']."')
			order by last_activity DESC
			LIMIT ".self::$start_rec.",".self::POST_LIMIT;

        $command = Yii::app()->db->createCommand($posts_sql_univ);

        if($posts = $command->queryAll())
            $success_post = TRUE;
        else
            $success_post = FALSE;

        if(self::$user->user_type == "p")
            $is_admin = TRUE;
        else
            $is_admin = FALSE;

        $this->renderJSON(array('success'=>$success_post, 'is_admin'=>$is_admin, 'feed'=>self::getReplies(self::addPostData($posts))));
    }

    public function actionGetPost()
    {
        $post_sql = "SELECT distinct *
		  from post p
		  where p.post_id = ".$_GET['id'];
        
        $command = Yii::app()->db->createCommand($post_sql);
        if($posts = $command->queryAll()) {
            $success_post = TRUE;
            $is_admin = TRUE; //hard_coded value

            // check if the current user is_admin to that post
//            if($posts->origin_type == "group") {
//                echo "test";
//                if ($g_mod = GroupUser::model()->findbypk(array('group_id' => $posts->origin_id, 'user_id' => self::$cur_user_id))) {
//                    if ($g_mod->is_admin == 1)
//                        $is_admin = TRUE;
//                    else
//                        $is_admin = FALSE;
//                }
//                else
//                    $is_admin = FALSE;
//            }
//
//            elseif($posts->origin_type == "class") {
//                if ($cl_mod = ClassUser::model()->findbypk(array('class_id' => $posts->origin_id, 'user_id' => self::$cur_user_id))) {
//                    if ($cl_mod->is_admin == 1)
//                        $is_admin = TRUE;
//                    else
//                        $is_admin = FALSE;
//                }
//                else
//                    $is_admin = FALSE;
//            }
//
//            elseif($posts->origin_type == "profile") {
//                if ($prof_mod = User::model()->find('user_id=:id', array(':id'=> $posts->origin_id))){
//                    if ($prof_mod->user_id == self::$cur_user_id)
//                        $is_admin = TRUE;
//                    else
//                        $is_admin = FALSE;
//                }
//                else
//                    $is_admin = FALSE;
//            }
//
//            elseif($posts->origin_type == NULL)
//                $is_admin = FALSE;
//
//            elseif(self::$user->user_type == "p")
//                $is_admin = TRUE;
//
//            else
//                $is_admin = FALSE;
            // check ends
        }
        else {
            $success_post = FALSE;
            $is_admin = FALSE;
        }

        $this->renderJSON(array('success'=>$success_post, 'is_admin'=>$is_admin, 'feed'=>self::getReplies(self::addPostData($posts))));
    }

    public function actionGetMoreReplies()
    {
        if(isset($_GET['first_rec']))
            $this->renderJSON('getMoreReplies');
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