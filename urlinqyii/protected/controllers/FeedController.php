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
        self::$cur_user_id = Yii::app()->session['user_id'];
        self::$user = User::model()->find('user_id=:id', array(':id'=> self::$cur_user_id));
        self::$cur_sem = "spring";

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

    public function validatePrivacy($post_privacy, $origin_type=NULL, $origin_id=NULL, $user){
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
                    $privacy_stmt = "SELECT * FROM " . $origin_type . "_user WHERE " . $origin_type . "_id=" . $origin_id . " AND user_id=" . $user->user_id;
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
                    elseif(UserConnection::model()->findByPk(array('to_user_id'=>$origin_id,'from_user_id'=>$user->user_id)))
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

        try{
            //        echo $type;
            //        $user_now = User::model()->find('user_id=:id', array(':id'=>$id));
            //        $user_name = $user_now->firstname." ".$user_now->lastname;
            //        $user_url = "/profile/".$id;
            //        $user_pic_url = $user_now->picture_file_id;
            //        $user_info = array('user_name'=>$user_name, 'user_url'=>$user_url, 'user_pic'=>$user_pic_url, 'user_pic_url'=>$user_pic_url);
            //        return($user_info);
                    $user = User::model()->find("user_id=:user_id",array(":user_id"=>$id));

                    if($type=="reply"){
                        $data = array('user_id'=>$user->user_id,'user_name'=>$user->firstname." ".$user->lastname, 'picture_file_id'=>$user->picture_file_id, 'pictureFile'=>$user->pictureFile);
                    }
                    else {
                        $data = $this->get_model_associations($user, array('pictureFile'=>array(),'department' => array('pictureFile', 'coverFile'),
                            'school' => array('pictureFile', 'coverFile', 'university')));
                    }
                    return $data;
        }catch(Exception $e){
            $this->renderJSON(array('success'=>false, 'error_msg'=>$e->getMessage()));
            Yii::log($e->getMessage());
            return null;
        }

    }

    public function getReplies($posts, $user){


        try{



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
                            //$replies[$j]['update_timestamp'] = strtotime(gmdate('Y-m-d H:i:s',strtotime($reply1['update_timestamp']." EST")));


                            $replies[$j]['user_info'] = self::getUserInfo($reply1['user_id'],"reply");
                            //                    echo "***".$j." ".$reply1['user_id']." ".self::$cur_user_id."***";
                            if (intval($reply1['user_id']) == intval($user->user_id)) {
                                //                        echo "###".$j." ".$reply1['user_id']." ".self::$cur_user_id."###";
                                $replies[$j]['cownership'] = TRUE;
                            } else {
                                //                        echo "###".$j." ".$reply1['user_id']." ".self::$cur_user_id."###";
                                $replies[$j]['cownership'] = FALSE;
                            }

                            if($ex_model = ReplyVote::model()->findbypk(array('reply_id' => $reply1['reply_id'], 'user_id' => $user->user_id))){
                                $replies[$j]['vote_status'] = $ex_model->vote_type;
                            }else{
                                $replies[$j]['vote_status'] = NULL;

                            }
                        }
                    }
                    $posts[$i]['replies'] = $replies;
                }
            }
            return $posts;
        }catch(Exception $e){
            $this->renderJSON(array('success'=>false, 'error_msg'=>$e->getMessage()));
            Yii::log($e->getMessage());
            return array();
        }
    }


    public function getOptionsInfo($options){
        try{
            if(sizeof($options)){
                $question = PostQuestion::model()->find('post_id=:pid',array(':pid'=>$options[0]['post_id']));
            }
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

                if(!$question->active){
                    if($question->correct_answer_id == $option['option_id'])
                        $options [$k] ['correct_answer'] = TRUE;
                    else
                        $options [$k] ['correct_answer'] = FALSE;
                }

                $options [$k] ['any_correct_answer'] = $question->correct_answer_id != null;

            }
            return $options;
        }catch(Exception $e){
            $data = array('success'=>false, 'error_msg'=>$e->getMessage());
            $this->renderJSON($data);
            return array();
        }

    }

    public function addPostData($posts, $user){


        try{

            foreach($posts as $i=>$post){
    //            echo "#".$post['privacy']."*".$post['origin_type']."*".$post['origin_id']."#";
                if(!self::validatePrivacy($post['privacy'],$post['origin_type'],$post['origin_id'], $user)){
    //                echo "here";
                    unset($posts[$i]);
                    continue;
                }


                $post_model = Post::model()->find('post_id=:id', array(':id'=>$post['post_id']));
    //            else{
    //                echo "Aha!";
    //            }

                // convert boolean/tinyint into int
                $posts[$i]['anon'] = intval($post['anon']);
                $posts[$i]['like_count'] = intval($post['like_count']);

                // getting and appending the user_name
                $posts[$i]['user_info'] = self::getUserInfo($post['user_id']);

                // post-ownership flag
                if($post['user_id']==self::$user->user_id)
                    $posts[$i]['pownership'] = TRUE;
                else
                    $posts[$i]['pownership'] = FALSE;

                // getting and appending the origin
                if($post['origin_type'] == "user"){
                    $origin = User::model()->find('user_id=:id', array(':id'=>$post['origin_id']));

                    if($origin){
                        $posts [$i]['origin'] = $this->model_to_array($origin);
                    }else{
                        $posts [$i]['origin'] = null;
                    }

                }
                elseif($post['origin_type']=="class"){
                    $class = ClassModel::model()->find('class_id=:id', array(':id'=>$post['origin_id']));

                    if(!$class){
                        unset($posts[$i]);
                        continue;
                    }

                    $posts [$i] ['origin'] = $this->model_to_array($this->get_model_associations($class,array('pictureFile')));
                    $posts[$i]['origin']['name'] = $posts[$i]['origin']['class_name'];
                }
                elseif($post['origin_type']=="course"){
                    $course = Course::model()->find('course_id=:id', array(':id'=>$post['origin_id']));

                    if(!$course){
                        unset($posts[$i]);
                        continue;
                    }

                    $posts [$i] ['origin'] = $this->model_to_array($this->get_model_associations($course,array('pictureFile')));
                    $posts[$i]['origin']['name'] = $posts[$i]['origin']['course_name'];
                }
                elseif($post['origin_type']=="department"){
                    $department = Department::model()->find('department_id=:id', array(':id'=>$post['origin_id']));
                    if(!$department){
                        unset($posts[$i]);
                        continue;
                    }


                    $posts [$i] ['origin'] = $this->model_to_array($this->get_model_associations($department,array('pictureFile')));
                    $posts[$i]['origin']['name'] = $posts[$i]['origin']['department_name'];
                }

                elseif($post['origin_type']=="school"){
                    $school = School::model()->find('school_id=:id', array(':id'=>$post['origin_id']));
                    if(!$school){
                        unset($posts[$i]);
                        continue;
                    }


                    $posts [$i] ['origin'] = $this->model_to_array($this->get_model_associations($school,array('pictureFile')));
                    $posts[$i]['origin']['name'] = $posts[$i]['origin']['school_name'];
                }
                elseif($post['origin_type'] == "group" || $post['origin_type'] == 'club'){
                    $group = Group::model()->find('group_id=:id', array(':id'=>$post['origin_id']));
                    if(!$group){
                        unset($posts[$i]);
                        continue;
                    }
                    $group_user = GroupUser::model()->find('user_id=:user_id and group_id=:group_id', array(':user_id'=>$user->user_id, ':group_id'=>$group->group_id));


                    //If this group is private and the current user
                    //is not apart of the group,
                    //dont show this post
                    if($group->privacy && !$group_user){
                        unset($posts[$i]);
                        continue;
                    }else{
                        $posts[$i]['origin'] = $this->model_to_array($this->get_model_associations($group,array('pictureFile')));
                        $posts[$i]['origin']['name'] = $posts[$i]['origin']['group_name'];
                    }
                }
                else{
                    $posts[$i]['origin'] = null;
                }

                if(PostLike::model()->findBySql("SELECT * FROM post_like WHERE post_id=" . $post['post_id'] . ' AND user_id=' . $user->user_id)){
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
                if($post['post_type'] == 'question' || $post['post_type'] == 'multiple_choice' || $post['post_type'] == 'true_false'){
                    $post_que = PostQuestion::model()->find('post_id=:id', array(':id'=>$post['post_id']));


                    if(!$post_que){
                        unset($posts[$i]);
                        continue;
                    }

                    $posts[$i]['active'] = $post_que->active;
                    $posts[$i]['question'] = self::convertModelToArray($post_que);

                    // check if this user has answered this question

                     //Check if this user has already voted for this question



                  //  $posts[$i]['user_answer_option_id'] = null;

                  //  $options = $post_model->postQuestionOptions;

           /*         foreach($options as $this_option){
                        //Check if the user voted for this option
                        $user_vote = PostQuestionOptionAnswer::model()->find('option_id=:option_id and user_id=:user_id', array(':option_id'=>$option->option_id, ':user_id'=>$user->user_id));
                        if($user_vote){
                            $posts[$i]['user_answer_option_id'] = $user_vote->option_id;
                        }
                    }*/


                    // adding all the options to the array
                    $post_que_options = PostQuestionOption::model()->findAll('post_id=:id', array(':id'=>$post['post_id']));
                    $options = self::convertModelToArray($post_que_options);



                    $posts[$i]['question']['options'] = self::getOptionsInfo($options);

                   // $options_data = array();
                    $total_answers = 0;
                    foreach($post_model->postQuestionOptions as $j=>$option){
                        $your_answer = PostQuestionOptionAnswer::model()->find('user_id=:uid and option_id=:oid',array(':oid'=>$option->option_id,':uid'=>$user->user_id));
                        if($your_answer){
                            $posts[$i]['question']['your_answer']=$your_answer->option->option_text;
                        }


                        $total_answers += sizeof($option->answers);
                    }

                 //   $posts[$i]['question']['options_data'] = $options_data;
                    $posts[$i]['question']['any_answers'] = $total_answers > 0;
                    $posts[$i]['question']['total_answers'] = $total_answers;
                    if(!$post_que->active){
                        $correct_answer =  PostQuestionOption::model()->find('option_id=:oid',array(':oid'=>$post_que->correct_answer_id));
                        if($correct_answer){
                            $posts[$i]['question']['correct_answer'] = $correct_answer->option_text;
                        }
                    }

    //                // adding info of participants
    //                $option_ids = array_column($options, 'option_id');
    //                $post_que_mem = PostQuestionOptionAnswer::model()->findAll('option_id=:id', array(':id'=>$option_ids));
    //                $participants = self::convertModelToArray($post_que_mem);
    //                if(in_array(self::$cur_user_id, array_column($participants, 'user_id')))
    //                    $posts [$i] ['answered'] = TRUE;

                }

                elseif($post['post_type'] == 'event' || $post['post_type'] == 'opportunity'){




                    $post_event = PostEvent::model()->find('post_id=:id',array(':id'=>$post['post_id']));

                    if(!$post_event){
                        unset($posts[$i]);
                        continue;
                    }

                    $event = $post_event->event;

                    if($event){
                        $event = $this->model_to_array($post_event->event);




                        $posts[$i]['event'] = $event;
                 //       $posts[$i]['attend'] = false;
                       $posts[$i]['event']['attendance_count'] = count($post_event->event->attendees);


                        if($event['user_id'] == $user->user_id){
                            if($event['host_attending']=="attending"){
                                $posts[$i]['event']['attend_status'] = "Attending";
                            }else if($event['host_attending']=="not_attending") {
                                $posts[$i]['event']['attend_status'] = "Not Attending";
                            }else if($event['host_attending']=="maybe_attending") {
                                $posts[$i]['event']['attend_status'] = "Maybe Attending";
                            }
                        }else{
                            $event_user = EventUser::model()->find('event_id=:event_id and user_id=:user_id', array(':event_id'=>$event['event_id'], ':user_id'=>$user->user_id));
                            if($event_user){
                                if($event_user->attend_status=="attending"){
                                    $posts[$i]['event']['attend_status'] = "Attending";
                                }else if($event_user->attend_status=="not_attending") {
                                    $posts[$i]['event']['attend_status'] = "Not Attending";
                                }else if($event_user->attend_status=="maybe_attending") {
                                    $posts[$i]['event']['attend_status'] = "Maybe Attending";
                                }else if($event_user->attend_status=="in_calendar") {
                                    $posts[$i]['event']['attend_status'] = "In Calendar";
                                }
                            }else{
                                $posts[$i]['event']['attend_status'] = "none";
                            }
                        }

                        if(sizeof($post_event->event->attendees)>0){
                            $posts[$i]['event']['attending'] = array();
                            foreach($post_event->event->attendees as $attendee){
                                if($attendee->user_id != $this->get_current_user_id()){
                                    array_push($posts[$i]['event']['attending'],$this->get_model_associations($attendee,array('pictureFile'=>array())));
                                }
                            }
                        }

                        $conflicting_event = Yii::app()->db->createCommand('select * from event e where e.event_id!="'.$event['event_id'].'" and (e.user_id="'.$user->user_id.'" or exists (select * from event_user where event_id = e.event_id and user_id = "'.$user->user_id.'"))
                            and e.start_date = "'.$event['start_date'].'" and not(e.end_time <= "'.$event['start_time'].'" or e.start_time >= "'.$event['end_time'].'")')->queryAll();

                        if(sizeof($conflicting_event)>0){
                            $posts[$i]['event']['conflict'] = $conflicting_event[0];
                        }
                        $just_ending_event = Yii::app()->db->createCommand('select * from event e where e.event_id!="'.$event['event_id'].'" and (e.user_id="'.$user->user_id.'" or exists (select * from event_user where event_id = e.event_id and user_id = "'.$user->user_id.'"))
                            and e.start_date = "'.$event['start_date'].'" and e.end_time = "'.$event['start_time'].'"')->queryAll();
                        if(sizeof($just_ending_event)>0){
                            $posts[$i]['event']['just_ending'] = $just_ending_event[0];
                        }
                        $just_starting_event = Yii::app()->db->createCommand('select * from event e where e.event_id!="'.$event['event_id'].'" and (e.user_id="'.$user->user_id.'" or exists (select * from event_user where event_id = e.event_id and user_id = "'.$user->user_id.'"))
                            and e.start_date = "'.$event['start_date'].'" and e.start_time = "'.$event['end_time'].'"')->queryAll();
                        if(sizeof($just_starting_event)>0){
                            $posts[$i]['event']['just_starting'] = $just_starting_event[0];
                        }
                        if($post_model->origin_type == 'class'){
                            $class_user = ClassUser::model()->find('class_id=:class_id and user_id=:user_id', array(':class_id'=>$post_model->origin_id, ':user_id'=>$user->user_id));
                            if($class_user){
                                $posts[$i]['event']['color'] = $class_user->color;
                            }
                        }else if($post_model->origin_type == 'group' || $post_model->origin_type == 'club'){
                            $group_user = GroupUser::model()->find('group_id=:group_id and user_id=:user_id', array(':group_id'=>$post_model->origin_id, ':user_id'=>$user->user_id));
                            if($group_user){
                                $posts[$i]['event']['color'] = $group_user->color;
                            }
                        }



                //Get the origin data
                if($posts[$i]['event']['origin_type'] == 'class'){
                    $class = ClassModel::model()->find('class_id=:id',array(':id'=>$posts[$i]['event']['origin_id']));
                    if(!$class){
                        //If the class doesnt exist, this post shouldnt exist
                        unset($posts[$i]);
                        continue;
                    }
                    $posts[$i]['event']['origin'] = $this->model_to_array($class);
                    //reassign the name to make it easier to get in the handlebars
                    $posts[$i]['event']['origin']['name'] = $posts[$i]['event']['origin']['class_name'];
                }else if($posts[$i]['event']['origin_type'] == 'department'){
                    $department = Department::model()->find('department_id=:id',array(':id'=>$posts[$i]['event']['origin_id']));
                    if(!$department){
                        //If the class doesnt exist, this post shouldnt exist
                        unset($posts[$i]);
                        continue;
                    }


                    $posts[$i]['event']['origin'] = $this->model_to_array($department);
                    //reassign the name to make it easier to get in the handlebars
                    $posts[$i]['event']['origin']['name'] = $posts[$i]['event']['origin']['department_name'];
                }else if($posts[$i]['event']['origin_type'] == 'school'){
                    $school = School::model()->find('school_id=:id',array(':id'=>$posts[$i]['event']['origin_id']));
                    if(!$school){
                        //If the class doesnt exist, this post shouldnt exist
                        unset($posts[$i]);
                        continue;
                    }
                    $posts[$i]['event']['origin'] = $this->model_to_array($school);
                    //reassign the name to make it easier to get in the handlebars
                    $posts[$i]['event']['origin']['name'] = $posts[$i]['event']['origin']['school_name'];

                }else if($posts[$i]['event']['origin_type'] == 'club' || $posts[$i]['event']['origin_type'] == 'group'){
                    $group = Group::model()->find('group_id=:id',array(':id'=>$posts[$i]['event']['origin_id']));
                    if(!$group){
                        //If the class doesnt exist, this post shouldnt exist
                        unset($posts[$i]);
                        continue;
                    }

                    $posts[$i]['event']['origin'] = $this->model_to_array($group);
                    //reassign the name to make it easier to get in the handlebars
                    $posts[$i]['event']['origin']['name'] = $posts[$i]['event']['origin']['group_name'];
                } else {
                    $event_new = Event::model()->find('event_id=:event_id', array(':event_id'=>$event['event_id']));
                    if(!$event_new){
                         //If the class doesnt exist, this post shouldnt exist
                        unset($posts[$i]);
                        continue;
                    }
                    $posts[$i]['event']['origin'] = $this->model_to_array($event_new->user);
                    $posts[$i]['event']['origin_type'] = 'user';
                }

                    }else{
                        //REmove this post from the array
                        unset($posts[$i]);
                        continue;
                    }

                }

                //See if there are any files associated with this post
                $post_files = PostFile::model()->findAll('post_id=:id',array(':id'=>$post['post_id']));
                if($post_files && count($post_files) > 0){
                    $posts[$i]['files'] = [];
                    foreach($post_files as $post_file){
                        array_push($posts[$i]['files'],$this->model_to_array($post_file->file));
                    }
                }

                $posts[$i]['last_activity'] = strtotime($post['last_activity']);
                $posts[$i]['update_timestamp'] = strtotime($post['created_at']);
                //$posts[$i]['update_timestamp'] = strtotime(gmdate('Y-m-d H:i:s',strtotime($post['created_at']." EST")));
            }
    //        self::getReplies($posts);
            return $posts;

        }catch(Exception $e){
                $this->renderJSON(array('success'=>false, 'error_msg'=>$e->getMessage()));
                return array();
        }
    }


	public function actionGetHomePosts()
	{


        try{


            $user = $this->get_current_user($_GET);


            if(!$user){
                $this->renderJSON(array('success'=>false, 'error_msg'=>'User not logged in'));
                return;
            }


            //I was getting issues passing the date time string
            //in the standard ?created_at=2015-14-12 11:11:11 format,
            //so I put the data in a param and the created_at and last_activity into
            //a json string then decoded it here so it wouldnt get fucked up
            //in transit
            $created_at = new DateTime('now');
            $created_at = $created_at->format('Y-m-d H:i:s');
            $last_activity = new DateTime('now');
            $created_at = $last_activity->format('Y-m-d H:i:s');
            if(isset($_GET['params']) || isset($_GET['created_at']) && isset($_GET['last_activity'])){
                $params = json_decode($_GET['params'], true);

                if(isset($params['created_at'])){
                    $created_at = $params['created_at'];
                    $last_activity = $params['last_activity'];
                }

            }



            $semester = 'spring';

            $privacy_type = $user->user_type;

            if($privacy_type == 'p'){

                //Group professors and admins in the same privacy setting
                $privacy_type = 'a';
            }

            // or (post.origin_type = 'user' )


            $posts_sql_home = "SELECT distinct *
                                from post
                                join post_user_inv
                                  on (post.post_id = post_user_inv.post_id)
                               where ((post_user_inv.user_id IN (SELECT to_user_id from user_connection where from_user_id = " . $user->user_id .")
                                  or post_user_inv.user_id = " . $user->user_id . ")

                                  or (origin_type = 'university' and origin_id = " . $user->school_id . ")
                                  or (origin_type = 'department' and origin_id = " . $user->department_id .")


                                  or (origin_type = 'club' and origin_id IN (SELECT group_user.group_id
                                                                             from `group_user`
                                                                             join `group`
                                                                             on (group_user.group_id = group.group_id)
                                                                             where group_user.user_id = " . $user->user_id . "))

                                  or (origin_type = 'group' and origin_id IN (SELECT group_user.group_id
                                                                             from `group_user`
                                                                             join `group`
                                                                             on (group_user.group_id = group.group_id)
                                                                             where group_user.user_id = " . $user->user_id . "))

                                  or (origin_type = 'department' and origin_id IN (SELECT department_follow.department_id
                                                                             from `department_follow`
                                                                             join `department`
                                                                             on (department_follow.department_id = department.department_id)
                                                                             where department_follow.user_id = " . $user->user_id . "))


                                  or (origin_type = 'class' and origin_id IN (SELECT cu.class_id
                                                                                from class_user cu join class cs
                                                                                  on (cu.class_id = cs.class_id)
                                                                                  where user_id = " . $user->user_id . " and cs.semester = '" . $semester . "' and cs.`year` = ".date('Y').")))





                                  and (post.privacy = '' or (post.privacy = '" . $privacy_type . "') or (post.privacy != '" . $privacy_type . "' and post.user_id = " . $user->user_id . "))

                                  and not exists (select * from post_hide where user_id= " . $user->user_id . " and post_id = post.post_id)
                                  and created_at < '" . $created_at . "'
                                  ORDER BY created_at DESC
                                  LIMIT ".self::$start_rec.",".self::POST_LIMIT;


            $command = Yii::app()->db->createCommand($posts_sql_home);
            $posts = $command->queryAll();

//
//            $data = array('success'=>true, 'is_admin'=> FALSE, 'feed'=>$posts);
//                $this->renderJSON($data);
//                return;

            if($posts){
                $data = array('success'=>true, 'is_admin'=> FALSE, 'feed'=>self::getReplies(self::addPostData($posts, $user), $user));
                $this->renderJSON($data);
                return;
            }else{
                $this->renderJSON(array('success'=>true, 'is_admin'=> FALSE, 'feed'=>array()));
                return;
            }


        }catch(Exception $e){
            $this->renderJSON(array('success'=>false, 'error_msg'=>$e->getMessage()));
            return;
        }




//        $this->renderJSON($posts);
	}

    public function actionGetProfilePosts()
    {
        $user = $this->get_current_user($_GET);

        $created_at = new DateTime('now');
        $created_at = $created_at->format('Y-m-d H:i:s');
        $last_activity = new DateTime('now');
        $created_at = $last_activity->format('Y-m-d H:i:s');
        if(isset($_GET['params']) || isset($_GET['created_at']) && isset($_GET['last_activity'])){
            $params = json_decode($_GET['params'], true);

            if(isset($params['created_at'])){
                $created_at = $params['created_at'];
                $last_activity = $params['last_activity'];
            }

        }


        // check if the cur_user is the owner of the profile page currently viewing
        if ($prof_mod = User::model()->find('user_id=:id', array(':id'=> $_GET['id']))){
            if ($prof_mod->user_id == self::$user->user_id)
                $is_admin = TRUE;
            else
                $is_admin = FALSE;
        }
        else
            $is_admin = FALSE;
        // end check

        $posts_sql_profile = "SELECT distinct *
				  from post p
				  where p.created_at < '" . $created_at . "' and (p.origin_type = 'user' and p.origin_id = ".$_GET['id'].")
				  and not exists (select * from post_hide where user_id= " . $user->user_id . " and post_id = p.post_id)
				  and (p.origin_id != p.user_id or p.anon = 0)
					ORDER BY created_at DESC	LIMIT ".self::$start_rec.",".self::POST_LIMIT;

        $command = Yii::app()->db->createCommand($posts_sql_profile);
        if($posts = $command->queryAll()){
            $this->renderJSON(array('success'=>true, 'is_admin'=>$is_admin, 'feed'=>self::getReplies(self::addPostData($posts,$user), $user)));
            return;
        }else{
            $this->renderJSON(array('success'=>true, 'is_admin'=> FALSE, 'feed'=>array()));
            return;
        }

    }

    public function actionGetClassPosts()
    {

        $user = $this->get_current_user($_GET);
        if(!$user){
            $this->renderJSON(array('success'=>false));
            return;
        }


        $created_at = new DateTime('now');
        $created_at = $created_at->format('Y-m-d H:i:s');
        $last_activity = new DateTime('now');
        $created_at = $last_activity->format('Y-m-d H:i:s');
        if(isset($_GET['params']) || isset($_GET['created_at']) && isset($_GET['last_activity'])){
            $params = json_decode($_GET['params'], true);

            if(isset($params['created_at'])){
                $created_at = $params['created_at'];
                $last_activity = $params['last_activity'];
            }

        }



        // check if the current user is the admin of the class
        if ($cl_mod = ClassUser::model()->findbypk(array('class_id' => $_GET['id'], 'user_id' => $user->user_id))) {
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
		  where (p.origin_type = 'class' and p.origin_id = '".$_GET['id']."') and created_at < '" . $created_at ."'
		  and not exists (select * from post_hide where user_id= " . $user->user_id . " and post_id = p.post_id)
			order by created_at DESC	LIMIT " . self::$start_rec . "," . self::POST_LIMIT;

        $command = Yii::app()->db->createCommand($posts_sql_class);

        if($posts = $command->queryAll()){
            $this->renderJSON(array('success'=>true, 'is_member'=> $is_member, 'is_admin'=>$is_admin,
            'feed'=>self::getReplies(self::addPostData($posts, $user), $user)));
            return;
        }else{
            $this->renderJSON(array('success'=>true, 'is_admin'=> FALSE, 'feed'=>array()));
            return;
        }






    }

//    public function actionGetCoursePosts()
//    {
//
//        $user = $this-
//
//
//        $posts_sql_course = "SELECT distinct * from post p where (p.origin_type = 'course' and p.origin_id = '".$_GET['id']."')
//			order by last_activity DESC LIMIT ".self::$start_rec.",".self::POST_LIMIT;
//
//        //$command = Yii::app()->db->createCommand()
//        //    ->select('*')
//        //    ->distinct(true)
//        //    ->from('post p')
//        //    ->where("(p.origin_type = 'course') and p.origin_id = '".$_GET['id']."'")
//        //    ->order("last_activity DESC LIMIT ".self::$start_rec.",".self::POST_LIMIT)
//        //    ->queryAll();
//
//        $command = Yii::app()->db->createCommand($posts_sql_course);
//
//        if($posts = $command->queryAll())
//            $success_post = TRUE;
//        else
//            $success_post = FALSE;
//
//        if(self::$user->user_type == "p")
//            $is_admin = TRUE;
//        else
//            $is_admin = FALSE;
//
//        $this->renderJSON(array('success'=>$success_post, 'is_admin'=>$is_admin, 'feed'=>self::getReplies(self::addPostData($posts))));
//    }

    public function actionGetClubPosts()
    {


        $user = $this->get_current_user($_GET);
        if(!$user){
            $this->renderJSON(array('success'=>false, 'error_id'=>1, 'error_msg'=>'User is not logged in'));
            return;
        }


        //I was getting issues passing the date time string
        //in the standard ?created_at=2015-14-12 11:11:11 format,
        //so I put the data in a param and the created_at and last_activity into
        //a json string then decoded it here so it wouldnt get fucked up
        //in transit
        $created_at = new DateTime('now');
        $created_at = $created_at->format('Y-m-d H:i:s');
        $last_activity = new DateTime('now');
        $created_at = $last_activity->format('Y-m-d H:i:s');
        if(isset($_GET['params']) || isset($_GET['created_at']) && isset($_GET['last_activity'])){
            $params = json_decode($_GET['params'], true);

            if(isset($params['created_at'])){
                $created_at = $params['created_at'];
                $last_activity = $params['last_activity'];
            }

        }




        $posts_sql_club = "SELECT distinct *
		  from post p
		  where ((p.origin_type = 'group' or p.origin_type = 'club') and p.origin_id = '". $_GET['id'] ."')
		    and created_at < '" . $created_at ."'
		    and not exists (select * from post_hide where user_id= " . $user->user_id . " and post_id = p.post_id)
			order by created_at DESC
			LIMIT 10";

        //$command = Yii::app()->db->createCommand($posts_sql_club);


        $posts = $this->models_to_array(Post::model()->findAllBySql($posts_sql_club));
        $this->renderJSON(array('success'=>true, 'is_admin'=> FALSE, 'feed'=>self::getReplies(self::addPostData($posts, $user), $user)));
        return;


//        if($posts = $command->queryAll()){
//
//            // check if the current user is an admin to this group/club feed
////            if ($g_mod = GroupUser::model()->findbypk(array('group_id' => $_GET['id'], 'user_id' => self::$cur_user_id))) {
////                $is_member = TRUE;
////                if ($g_mod->is_admin == 1)
////                    $is_admin = TRUE;
////                else
////                    $is_admin = FALSE;
////            }
////            else{
////                $is_member = FALSE;
////                $is_admin = FALSE;
////            }
//            // check ends
//
//
//            $this->renderJSON(array('success'=>true, 'is_admin'=> FALSE, 'feed'=>self::getReplies(self::addPostData($posts, $user))));
//            return;
//
//
////            $command = Yii::app()->db->createCommand($posts_sql_club);
////            if($posts = $command->queryAll()){
////                $this->renderJSON(array('success'=>true, 'is_admin'=> FALSE, 'feed'=>self::getReplies(self::addPostData($posts, $user))));
////                return;
////            }else{
////                $this->renderJSON(array('success'=>true, 'is_admin'=> FALSE, 'feed'=>array()));
////                return;
////            }
//        }
//        else{
//            $this->renderJSON(array('success'=>true,'feed'=>array()));
//            return;
//        }





    }

    public function actionGetDepartmentPosts()
    {

        $user = $this->get_current_user($_GET);

        if(!$user){
            $this->renderJSON(array('success'=>false));
            return;
        }


        $created_at = new DateTime('now');
        $created_at = $created_at->format('Y-m-d H:i:s');
        $last_activity = new DateTime('now');
        $created_at = $last_activity->format('Y-m-d H:i:s');
        if(isset($_GET['params']) || isset($_GET['created_at']) && isset($_GET['last_activity'])){
            $params = json_decode($_GET['params'], true);

            if(isset($params['created_at'])){
                $created_at = $params['created_at'];
                $last_activity = $params['last_activity'];
            }

        }



        $posts_sql_dept = "SELECT distinct *
		  from post p
		  where (p.origin_type = 'department' and p.origin_id = '" . $_GET['id'] . "')
		    and created_at < '" . $created_at ."'
		    and not exists (select * from post_hide where user_id= " . $user->user_id . " and post_id = p.post_id)
			order by last_activity DESC
			LIMIT ".self::$start_rec.",".self::POST_LIMIT;

        if($user->user_type == "p")
            $is_admin = TRUE;
        else
            $is_admin = FALSE;

        $command = Yii::app()->db->createCommand($posts_sql_dept);

        if($posts = $command->queryAll()){
            $this->renderJSON(array('success'=>true, 'is_admin'=>$is_admin, 'feed'=>self::getReplies(self::addPostData($posts, $user), $user)));
            return;
        }else{
            $this->renderJSON(array('success'=>true, 'is_admin'=> FALSE, 'feed'=>array()));
            return;
        }



    }

    public function actionGetSchoolPosts()
    {

        $user = $this->get_current_user($_GET);

        if(!$user){
            $this->renderJSON(array('success'=>false));
            return;
        }

        $created_at = new DateTime('now');
        $created_at = $created_at->format('Y-m-d H:i:s');
        $last_activity = new DateTime('now');
        $created_at = $last_activity->format('Y-m-d H:i:s');
        if(isset($_GET['params']) || isset($_GET['created_at']) && isset($_GET['last_activity'])){
            $params = json_decode($_GET['params'], true);

            if(isset($params['created_at'])){
                $created_at = $params['created_at'];
                $last_activity = $params['last_activity'];
            }

        }


        $posts_sql_school = "SELECT distinct *
		  from post p
		  where (p.origin_type = 'school' and p.origin_id = '".$_GET['id']."')
		    and created_at < '" . $created_at ."'
		    and not exists (select * from post_hide where user_id= " . $user->user_id . " and post_id = p.post_id)
			order by created_at DESC
			LIMIT ".self::$start_rec.",".self::POST_LIMIT;

        $command = Yii::app()->db->createCommand($posts_sql_school);



        if($user->user_type == "p")
            $is_admin = TRUE;
        else
            $is_admin = FALSE;


        if($posts = $command->queryAll()){
            $this->renderJSON(array('success'=>true, 'is_admin'=>$is_admin, 'feed'=>self::getReplies(self::addPostData($posts, $user), $user)));
            return;
        }else{
            $this->renderJSON(array('success'=>true, 'is_admin'=>$is_admin, 'feed'=>array()));
            return;
        }

    }

//    public function actionGetUniversityPosts()
//    {
//
//        $user = $this->get_current_user($_GET);
//        if(!$user){
//            $this->renderJSON(array('success'=>false, 'error_msg'=>'user not signed in'));
//            return;
//        }
//
//
//        $created_at = new DateTime('now');
//        $created_at = $created_at->format('Y-m-d H:i:s');
//        $last_activity = new DateTime('now');
//        $created_at = $last_activity->format('Y-m-d H:i:s');
//        if(isset($_GET['params']) || isset($_GET['created_at']) && isset($_GET['last_activity'])){
//            $params = json_decode($_GET['params'], true);
//
//            if(isset($params['created_at'])){
//                $created_at = $params['created_at'];
//                $last_activity = $params['last_activity'];
//            }
//
//        }
//
//
//
//        $posts_sql_univ = "SELECT distinct *
//		  from post p
//		  where (p.origin_type = 'university' and p.origin_id = '".$_GET['id']."')
//		    and created_at < '" . $created_at ."'
//			order by last_activity DESC
//			LIMIT ".self::$start_rec.",".self::POST_LIMIT;
//
//        $command = Yii::app()->db->createCommand($posts_sql_univ);
//
//
//
//        if(self::$user->user_type == "p")
//            $is_admin = TRUE;
//        else
//            $is_admin = FALSE;
//
//
//
//        if($posts = $command->queryAll()){
//            $this->renderJSON(array('success'=>true, 'is_admin'=>$is_admin, 'feed'=>self::getReplies(self::addPostData($posts, $user))));
//            return;
//        }else{
//            $this->renderJSON(array('success'=>true, 'is_admin'=>$is_admin, 'feed'=>array()));
//            return;
//        }
//    }
//
//    public function actionGetPost()
//    {
//        $post_sql = "SELECT distinct *
//		  from post p
//		  where p.post_id = ".$_GET['id'];
//
//        $command = Yii::app()->db->createCommand($post_sql);
//        if($posts = $command->queryAll()) {
//            $success_post = TRUE;
//            $is_admin = TRUE; //hard_coded value
//
//            // check if the current user is_admin to that post
////            if($posts->origin_type == "group") {
////                echo "test";
////                if ($g_mod = GroupUser::model()->findbypk(array('group_id' => $posts->origin_id, 'user_id' => self::$cur_user_id))) {
////                    if ($g_mod->is_admin == 1)
////                        $is_admin = TRUE;
////                    else
////                        $is_admin = FALSE;
////                }
////                else
////                    $is_admin = FALSE;
////            }
////
////            elseif($posts->origin_type == "class") {
////                if ($cl_mod = ClassUser::model()->findbypk(array('class_id' => $posts->origin_id, 'user_id' => self::$cur_user_id))) {
////                    if ($cl_mod->is_admin == 1)
////                        $is_admin = TRUE;
////                    else
////                        $is_admin = FALSE;
////                }
////                else
////                    $is_admin = FALSE;
////            }
////
////            elseif($posts->origin_type == "profile") {
////                if ($prof_mod = User::model()->find('user_id=:id', array(':id'=> $posts->origin_id))){
////                    if ($prof_mod->user_id == self::$cur_user_id)
////                        $is_admin = TRUE;
////                    else
////                        $is_admin = FALSE;
////                }
////                else
////                    $is_admin = FALSE;
////            }
////
////            elseif($posts->origin_type == NULL)
////                $is_admin = FALSE;
////
////            elseif(self::$user->user_type == "p")
////                $is_admin = TRUE;
////
////            else
////                $is_admin = FALSE;
//            // check ends
//        }
//        else {
//            $success_post = FALSE;
//            $is_admin = FALSE;
//        }
//
//        $this->renderJSON(array('success'=>$success_post, 'is_admin'=>$is_admin, 'feed'=>self::getReplies(self::addPostData($posts))));
//    }

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