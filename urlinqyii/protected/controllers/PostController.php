<?php
Yii::import('ext.runactions.components.ERunActions');
ERunActions::runBackground(true);


if(isset($_FILES))
    include_once "file_upload.php";

class PostController extends Controller
{
	/**
     * Made some changes in Post Model @rules
     *
     * Usage:
     * Send $_Post[] array to..
        * post/create
        * post/[:id]/update
        * post/[:id]/delete
     *
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */

    private static $cur_user_id;

	public $layout='//layouts/column2';

    // public function __construct()
    // {
    //     self::$cur_user_id = intval(Yii::app()->session['user_id'] || 1);

    //     $_POST['Post'] = array('post_type'=>'question', 'text'=>'test qstn text by post_cntrlr', 'privacy'=>'members', 'anon'=>0);
    //     $_POST['PostQuestionOption'] = array(array('option_text'=>'opt1','answer_flag'=>1),array('option_text'=>'opt2','answer_flag'=>0),
    //                                     array('option_text'=>'opt3','answer_flag'=>0), array('option_text'=>'opt4','answer_flag'=>0));
    //     $_POST['PostQuestion'] = array('anonymous'=>0, 'live_answers'=>0, 'active'=>1);
    //     //var_dump($_POST['Post']);
    // }


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */



    function reArrayFiles(&$file_post) {

        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);

        for ($i=0; $i<$file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }

        return $file_ary;
    }


    function actionSendPostEmailFunction(){

        if(!isset($_POST['post_id']) || !isset($_POST['actor_id']) || !isset($_POST['to_user_id']) || !isset($_POST['subject'])){
            $data = array('success'=>false,'error_id'=>1, 'error_msg'=> 'all post data not set', 'post'=>$_POST);
            $this->renderJSON($data);
            return;
        }


        $actor_id = $_POST['actor_id'];

        $actor = User::model()->find('user_id=:user_id', array(':user_id'=>$actor_id));

        if(!$actor){
            $data = array('success'=>false,'error_id'=>2, 'error_msg'=> 'user not logged in', 'post'=>$_POST);
            $this->renderJSON($data);
            return;
        }


        $subject = $_POST['subject'];


        $to_user_id = $_POST['to_user_id'];

        $to_user = User::model()->find('user_id=:user_id', array(':user_id'=>$to_user_id));

        if(!$to_user){
            $data = array('success'=>false,'error_id'=>3, 'error_msg'=> 'invalid user', 'post'=>$_POST);
            $this->renderJSON($data);
            return;
        }



        $post_id = $_POST['post_id'];

        $post = Post::model()->find('post_id=:post_id', array(':post_id'=>$post_id));

        if(!$post){
            $data = array('success'=>false,'error_id'=>2, 'error_msg'=> 'invalid post', 'post'=>$_POST);
            $this->renderJSON($data);
            return;
        }
        $origin_type = $post->origin_type;
        $origin_id = $post->origin_id;

        $origin = null;

        if($origin_type == 'class'){
            $class = ClassModel::model()->find('class_id=:class_id', array(':class_id'=>$origin_id));
            if($class){
                $origin = $class;
            }else{
                $data = array('success'=>false,'error_id'=>2, 'error_msg'=> 'invalid class', 'post'=>$_POST);
                $this->renderJSON($data);
                return;
            }
        }else if($origin_type == 'group' || $origin_type == 'club'){
            $group = Group::model()->find('group_id=:group_id', array(':group_id'=>$origin_id));
            if($group){
                $origin = $group;
            }else{
                $data = array('success'=>false,'error_id'=>2, 'error_msg'=> 'invalid group', 'post'=>$_POST);
                $this->renderJSON($data);
                return;
            }
        }else if($origin_type == 'department'){
            $department = Department::model()->find('department_id=:department_id', array(':department_id'=>$origin_id));
            if($department){
                $origin = $department;
            }else{
                $data = array('success'=>false,'error_id'=>2, 'error_msg'=> 'invalid department', 'post'=>$_POST);
                $this->renderJSON($data);
                return;
            }
        }
        else if($origin_type == 'school'){
            $school = School::model()->find('school_id=:school_id', array(':school_id'=>$origin_id));
            if($school){
                $origin = $school;
            }else{
                $data = array('success'=>false,'error_id'=>2, 'error_msg'=> 'invalid school', 'post'=>$_POST);
                $this->renderJSON($data);
                return;
            }
        }else{
            $data = array('success'=>false,'error_id'=>2, 'error_msg'=> 'invalid origin ' . $origin_type, 'post'=>$_POST);
            $this->renderJSON($data);
            return;
        }


        if (ERunActions::runBackground()) {
            ERunActions::runScript('send_post_email',$params=array('origin'=>$origin, 'to_user'=>$to_user,  'post'=>$post, 'subject'=>$subject, 'actor'=>$actor),$scriptPath=null);


            $data = array('success'=>true,'error_id'=>'run');
            $this->renderJSON($data);
            return;
        }else {
//            $data = array('success'=>false,'error_id'=>'didnt run in background');
//            $this->renderJSON($data);
//            return;
        }


    }



    function actionSendGroupEventEmailFunction(){

        if(!isset($_POST['to_email']) || !isset($_POST['event_id']) || !isset($_POST['actor_id']) || !isset($_POST['to_user_id']) || !isset($_POST['subject'])){
            $data = array('success'=>false,'error_id'=>1, 'error_msg'=> 'all post data not set', 'post'=>$_POST);
            $this->renderJSON($data);
            return;
        }


        $actor_id = $_POST['actor_id'];

        $user = User::model()->find('user_id=:user_id', array(':user_id'=>$actor_id));

        if(!$user){
            $data = array('success'=>false,'error_id'=>2, 'error_msg'=> 'user not logged in', 'post'=>$_POST);
            $this->renderJSON($data);
            return;
        }

        $to_email = $_POST['to_email'];
        $subject = $_POST['subject'];
        //$from_email = $_POST['from_email'];
        $from_email = 'team@urlinq.com';

        $to_user_id = $_POST['to_user_id'];

        $to_user= User::model()->find('user_id=:user_id', array(':user_id'=>$to_user_id));

        if(!$to_user){
            $data = array('success'=>false,'error_id'=>3, 'error_msg'=> 'invalid user', 'post'=>$_POST);
            $this->renderJSON($data);
            return;
        }



        $event_id = $_POST['event_id'];

        $event = Event::model()->find('event_id=:event_id', array(':event_id'=>$event_id));

        if(!$event){
            $data = array('success'=>false,'error_id'=>2, 'error_msg'=> 'invalid event', 'post'=>$_POST);
            $this->renderJSON($data);
            return;
        }


        $origin_type = $event->origin_type;
        $origin_id = $event->origin_id;
        $origin_name = '';

        if($origin_type == 'class'){
            $class = ClassModel::model()->find('class_id=:class_id', array(':class_id'=>$origin_id));
            if($class){
                $origin_name = $class->class_name;
            }else{
                $data = array('success'=>false,'error_id'=>2, 'error_msg'=> 'invalid class', 'post'=>$_POST);
                $this->renderJSON($data);
                return;
            }
        }else if($origin_type == 'group' || $origin_type == 'club'){
            $group = Group::model()->find('group_id=:group_id', array(':group_id'=>$origin_id));
            if($group){
                $origin_name = $group->group_name;
            }else{
                $data = array('success'=>false,'error_id'=>2, 'error_msg'=> 'invalid group', 'post'=>$_POST);
                $this->renderJSON($data);
                return;
            }
        }else if($origin_type == 'department'){
            $department = Department::model()->find('department_id=:department_id', array(':department_id'=>$origin_id));
            if($department){
                $origin_name = $department->department_name;
            }else{
                $data = array('success'=>false,'error_id'=>2, 'error_msg'=> 'invalid department', 'post'=>$_POST);
                $this->renderJSON($data);
                return;
            }
        }
        else if($origin_type == 'school'){
            $school = School::model()->find('school_id=:school_id', array(':school_id'=>$origin_id));
            if($school){
                $origin_name = $school->school_name;
            }else{
                $data = array('success'=>false,'error_id'=>2, 'error_msg'=> 'invalid school', 'post'=>$_POST);
                $this->renderJSON($data);
                return;
            }
        }else{
            $data = array('success'=>false,'error_id'=>2, 'error_msg'=> 'invalid origin ' . $origin_type, 'post'=>$_POST);
            $this->renderJSON($data);
            return;
        }


        if (ERunActions::runBackground()) {
            ERunActions::runScript('send_event_email',$params=array('origin_name'=>$origin_name, 'to_user'=>$to_user, 'to_email'=>$to_email, 'from_email'=>$from_email, 'event'=>$event, 'subject'=>$subject, 'user'=>$user),$scriptPath=null);


            $data = array('success'=>true,'error_id'=>'run');
            $this->renderJSON($data);
            return;
        }else {
//            $data = array('success'=>false,'error_id'=>'didnt run in background');
//            $this->renderJSON($data);
//            return;
        }


    }





	public function actionCreate()
	{

//{"text":"asdasd","post_type":"discuss","origin_id":"","origin_type":"class","sub_text":"","privacy":"","anon":0,"like_count":0}


        //Because of limitations with dropzone js, if files are being uploaded,
        //I must send the post parameters as a JSON string rather than just sending them normally
        //So if files are present, we need to decode the JSON string into an array
        if(isset($_FILES['file'])) {
            $_POST['post'] = json_decode($_POST['post'], true);
        }



        if(!isset($_POST['post']['text']) || !isset($_POST['post']['origin_type']) || !isset($_POST['post']['origin_id']) || !isset($_POST['post']['post_type']) || !isset($_POST['post']['sub_text']) || !isset($_POST['post']['privacy']) || !isset($_POST['post']['anon'])){
            $return_data = array('success'=>false, 'error_id'=>1, 'error_msg'=>'All data is not set', '$POST'=>$_POST);
            $this->renderJSON($return_data);
            return;
        }

        if($_POST['post']['origin_type'] == '' || $_POST['post']['origin_id'] == ''){
            $return_data = array('success'=>false, 'error_id'=>2, 'error_msg'=>'invalid origin', '$POST'=>$_POST);
            $this->renderJSON($return_data);
            return;
        }


        if($_POST['post']['privacy'] != '' && $_POST['post']['privacy'] != 's' && $_POST['post']['privacy'] != 'a'){
            $return_data = array('success'=>false, 'error_id'=>3, 'error_msg'=>'invalid privacy setting', '$POST'=>$_POST);
            $this->renderJSON($return_data);
            return;
        }



        if($_POST['post']['post_type'] == 'event' && !isset($_POST['post']['event'])){

            $return_data = array('success'=>false, 'error_id'=>4, 'error_msg'=>'Event is not set', '$POST'=>$_POST);
            $this->renderJSON($return_data);
            return;
        }


        if($_POST['post']['post_type'] == 'opportunity' && !isset($_POST['post']['opportunity'])){

            $return_data = array('success'=>false, 'error_id'=>4, 'error_msg'=>'opportunity is not set', '$POST'=>$_POST);
            $this->renderJSON($return_data);
            return;
        }


        try{
            $model=new Post;

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

//            $model->file_id = NULL;
//            if(isset($_FILES['fileUpload'])) {
//                $file = file_upload($_FILES);
//                $model->file_id = $file['file_id'];
//            }
            // else{
            //     // echo 'file_upload failed';
            // }



            $user = $this->get_current_user($_POST);
            if(!$user){
                $return_data = array('success'=>false, 'error_id'=>2, 'error_msg' => 'user is not logged in');
                $this->renderJSON($return_data);
                return;
            }

            if(isset($_POST['post'])){


                $model->attributes = $_POST['post'];

                $model->post_type = $_POST['post']['post_type'];
                $model->user_id = $user->user_id;
                $model->origin_id = $_POST['post']['origin_id'];
    //            $model->created_at = NOW();
    //            $model->last_activity =  = NOW();


//
//
//
//                $model->save(false);
                $model->last_activity = $model->created_at;



                $model->save(false);



                $post_id = $model->post_id;


                //Changed by Alex. Dont echo
                //This function should return JSON with a success flag and
                //the post data if true

                //$_POST['Post'] -> $_POST['Post'] plz
                if($model){

                    include_once 'notification/notification.php';


                    $post_data = $this->model_to_array($model);
                    $post_data['user_info'] = $this->model_to_array($user);

                    //Save post files
                    if(isset($_FILES['file'])) {
                        $post_data['files'] = array();
                        $file_ary = $this->reArrayFiles($_FILES['file']);

                        foreach ($file_ary as $file) {

                            $file_data = file_upload2($file, 'post_files/');


                            $post_file = new PostFile;
                            $post_file->post_id = $model->post_id;
                            $post_file->file_id = $file_data['file_id'];
                            if(!$post_file->save(false)){
                                $return_data = array('success'=>false, 'error_msg'=>'error uploading file');
                                $this->renderJSON($return_data);
                                return;
                            }

                            array_push($post_data['files'], $this->model_to_array($post_file->file));

                        }
                    }




                    if($model->post_type == 'event'){




                        $event = new Event;
                        $event->title = $_POST['post']['event']['title'];
                        $event->description = $_POST['post']['event']['description'];
                        $event->event_type = 'event';
                        $event->user_id = $user->user_id;
                        $event->origin_type = $_POST['post']['event']['origin_type'];
                        $event->origin_id = $_POST['post']['event']['origin_id'];
                        $event->start_date = $_POST['post']['event']['start_date'];
                        $event->end_date = $_POST['post']['event']['end_date'];
                        $event->start_time = $_POST['post']['event']['start_time'];
                        $event->end_time = $_POST['post']['event']['end_time'];
                        $event->location = $_POST['post']['event']['location'];

                        $all_day = 0;
                        if(isset($_POST['post']['event']['all_day']) && $_POST['post']['event']['all_day'] == true){
                            $all_day = 1;
                        }


                        $event->all_day = $all_day;

                        $event->save(false);


                        $post_event = new PostEvent;
                        $post_event->post_id = $model->post_id;
                        $post_event->event_id = $event->event_id;
                        $post_event->save(false);


//                        $actor_id = $user->user_id;
//                        $subject = 'Urlinq event';
//                        $event_id = $event->event_id;
//                        $user_id = $user->user_id;
//                        $to_email = 'afl294@nyu.edu';
//
//                        ERunActions::touchUrl(Yii::app()->getBaseUrl(true) . '/post/sendGroupEventEmailFunction',$postData=array('to_email'=>$to_email, 'event_id'=>$event_id, 'actor_id'=>$actor_id,'to_user_id'=>$user_id,'subject'=>$subject),$contentType=null);
//


                        $is_admin = false;


                        if($event->origin_type == 'club' || $event->origin_type == 'group'){
                            $group = Group::model()->find('group_id=:id', array(':id'=>$event->origin_id));
                            if($group){
                                $has_admin=GroupUser::model()->exists('group_id=:group_id and is_admin=true',array(':group_id'=>$group->group_id));


                                $group_user = GroupUser::model()->find('user_id=:user_id and group_id=:group_id', array(':user_id'=>$user->user_id, ':group_id'=>$group->group_id));

                                if($group_user && $group_user->is_admin || !$has_admin){
                                    $is_admin = true;
                                    //foreach($group->members as $member){

                                    //We want to send the email to all group members, not
                                    //just the members
                                    foreach($group->users as $member){
                                        if($member->user_id != $user->user_id){
                                            include_once 'color/color.php';
                                            $event_user = new EventUser;
                                            $event_user->user_id = $member->user_id;
                                            $event_user->event_id = $event->event_id;
                                            $event_user->color_id = get_random_color();
                                            $event_user->save(false);

                                            $subject = 'Urlinq event';
                                            $event_id = $event->event_id;
                                            $user_id = $event_user->user_id;
                                            $to_email = $event_user->user->user_email;
                                            $actor_id = $user->user_id;


                                            ERunActions::touchUrl(Yii::app()->getBaseUrl(true) . '/post/sendGroupEventEmailFunction',$postData=array('to_email'=>$to_email, 'event_id'=>$event_id, 'actor_id'=>$actor_id,'to_user_id'=>$user_id,'subject'=>$subject),$contentType=null);

                                            //ERunActions::touchUrl(Yii::app()->getBaseUrl(true) . '/post/sendGroupEventEmailFunction',$postData=array('to_email'=>$to_email, 'event_id'=>$event_id, 'user_id'=>$user_id,'subject'=>$subject),$contentType=null);

                                        }
                                        //$this->sendEventEmail($event_user->user,$event);

                                    }
                                }

                            }
                        }else if($event->origin_type == 'class'){
                            $class = ClassModel::model()->find('class_id=:id', array(':id'=>$event->origin_id));
                            if($class){

                                $has_admin=ClassUser::model()->exists('class_id=:group_id and is_admin=true',array(':class_id'=>$class->class_id));

                                $class_user = ClassUser::model()->find('user_id=:user_id and class_id=:class_id', array(':user_id'=>$user->user_id, ':class_id'=>$class->class_id));
                                if(($class_user && $class_user->is_admin) || $class->professor_id == $user->user_id || !$has_admin){
                                    $is_admin = true;
                                    foreach($class->students as $member){
                                        if($member->user_id != $user->user_id){
                                            include_once 'color/color.php';
                                            $event_user = new EventUser;
                                            $event_user->user_id = $member->user_id;
                                            $event_user->event_id = $event->event_id;
                                            $event_user->color_id = get_random_color();
                                            $event_user->save(false);

                                            $subject = 'Urlinq verification email';
                                            $event_id = $event->event_id;
                                            $user_id = $event_user->user_id;
                                            $to_email = $event_user->user->user_email;
                                            $actor_id = $user->user_id;

                                            ERunActions::touchUrl(Yii::app()->getBaseUrl(true) . '/post/sendGroupEventEmailFunction',$postData=array('to_email'=>$to_email, 'event_id'=>$event_id, 'actor_id'=>$actor_id,'to_user_id'=>$user_id,'subject'=>$subject),$contentType=null);

                                            //ERunActions::touchUrl(Yii::app()->getBaseUrl(true) . '/post/sendGroupEventEmailFunction',$postData=array('to_email'=>$to_email, 'event_id'=>$event_id, 'user_id'=>$user_id,'subject'=>$subject),$contentType=null);


                                        }
                                    }
                                }
                            }
                        }
//
//                        data = {
//                            'to_email': 'afl294@nyu.edu',
//                            'event_id': '337',
//                            'origin_id': '1',
//                            'origin_type': 'club',
//                            'subject': 'TEST EVENT EMAIL',
//
//                            'origin_name': 'Arcane Studies',
//                            'actor_name': 'Alex Lopez'
//                        }







                        $post_data['event'] = $this->model_to_array($event);


                        if($model->origin_type == 'class'){
                            $class_user = ClassUser::model()->find('class_id=:class_id and user_id=:user_id', array(':class_id'=>$model->origin_id, ':user_id'=>$user->user_id));
                            if($class_user){
                                $post_data['event']['color'] = $class_user->color;
                            }
                        }else if($model->origin_type == 'group' || $model->origin_type == 'club'){
                            $group_user = GroupUser::model()->find('group_id=:group_id and user_id=:user_id', array(':group_id'=>$model->origin_id, ':user_id'=>$user->user_id));
                            if($group_user){
                                $post_data['event']['color'] = $group_user->color;
                            }
                        }

                    }else if($model->post_type == 'opportunity'){


                        $now = new DateTime('now');


                        $event = new Event;
                        $event->title = $_POST['post']['opportunity']['title'];
                        $event->description = $_POST['post']['opportunity']['description'];
                        $event->event_type = 'event';
                        $event->user_id = $user->user_id;
                        $event->origin_type = $_POST['post']['origin_type'];
                        $event->origin_id = $_POST['post']['origin_id'];
                        $event->start_date = $now->format('Y-m-d');
                        $event->end_date = $_POST['post']['opportunity']['end_date'];
                        $event->start_time = $now->format('H:i:s');
                        $event->end_time = $_POST['post']['opportunity']['end_time'];
                        $event->location = '';
                        $all_day = 0;

                        $event->all_day = $all_day;

                        $event->save(false);


                        $post_event = new PostEvent;
                        $post_event->post_id = $model->post_id;
                        $post_event->event_id = $event->event_id;
                        $post_event->save(false);

                        $post_data['event'] = $this->model_to_array($event);

                        if($model->origin_type == 'class'){
                            $class_user = ClassUser::model()->find('class_id=:class_id and user_id=:user_id', array(':class_id'=>$model->origin_id, ':user_id'=>$user->user_id));
                            if($class_user){
                                $post_data['event']['color'] = $class_user->color;
                            }
                        }else if($model->origin_type == 'group' || $model->origin_type == 'club'){
                            $group_user = GroupUser::model()->find('group_id=:group_id and user_id=:user_id', array(':group_id'=>$model->origin_id, ':user_id'=>$user->user_id));
                            if($group_user){
                                $post_data['event']['color'] = $group_user->color;
                            }
                        }
                    }

                    //echo $post_id = $model->post_id;
    //                echo "awesome";

                    if(isset($_POST['post']['question']) && ($model->post_type == 'question' || $model->post_type == 'multiple_choice' || $model->post_type == 'true_false')){

                        $post_data['question'] = array('options'=>array());

                        $question = new PostQuestion;
                        //$question->attributes = $_POST['PostQuestion'];
                        $question->post_id = $post_id;
                        $question->save(false);


                        if($model->post_type == 'multiple_choice' && isset($_POST['post']['question']['answer_index'])){
                            $correct_answer_index = $_POST['post']['question']['answer_index'];

                            $post_data['question']['answer_index'] = $correct_answer_index;


                            for($i = 0; $i < count($_POST['post']['question']['options']); $i++){
                                $option_text = $_POST['post']['question']['options'][$i];

                                if($option_text != ''){
                                    $option = new PostQuestionOption;
                                    $option->option_text = $option_text;
                                    $option->post_id = $post_id;
                                    $option->save(false);


                                    if($i == $correct_answer_index){
                                        $question->correct_answer_id = $option->option_id;
                                        $question->save(false);
                                    }

                                    array_push($post_data['question']['options'], $this->model_to_array($option));
                                }
                            }
                        }else if($model->post_type == 'true_false'){
                            $option = new PostQuestionOption;
                            $option->option_text = 'True';
                            $option->post_id = $post_id;
                            $option->save(false);

                            array_push($post_data['question']['options'], $this->model_to_array($option));

                            $option = new PostQuestionOption;
                            $option->option_text = 'False';
                            $option->post_id = $post_id;
                            $option->save(false);

                            array_push($post_data['question']['options'], $this->model_to_array($option));
                        }


                        //if(count($_POST['post']['question']['choices']) > 0){


                        //}
                    }



                    try{
                        //Get the origin data
                        if($model->origin_type == 'class'){

                            $class = ClassModel::model()->find('class_id=:id',array(':id'=>$model->origin_id));
                            if($class){
                                $is_admin = false;
                                if($class->professor_id == $user->user_id){
                                    $is_admin = true;
                                }

                                $class_user = ClassUser::model()->find('class_id=:class_id and user_id=:user_id', array(':class_id'=>$class->class_id, ':user_id'=>$user->user_id));
                                if($class_user && $class_user->is_admin){
                                    $is_admin = true;
                                }


                                $post_data['origin'] = $this->model_to_array($class);
                                //reassign the name to make it easier to get in the handlebars
                                $post_data['origin']['name'] = $post_data['origin']['class_name'];


                                //Send a notification to everyone in this class about this post
                                foreach($class->users as $class_user){
                                    if($class_user->user_id != $user->user_id){
                                        //If this user is an admin and this post is not an event,
                                        //send a post announcement email
                                        if($is_admin && $model->post_type != 'event'){
                                            $subject = 'Urlinq announcement';
                                            $to_user_id = $class_user->user_id;
                                            $actor_id = $user->user_id;
                                            ERunActions::touchUrl(Yii::app()->getBaseUrl(true) . '/post/sendPostEmailFunction',$postData=array('to_user_id'=>$to_user_id, 'subject'=>$subject, 'actor_id'=>$actor_id, 'post_id'=>$model->post_id),$contentType=null);
                                        }

                                        send_notification('post',$user->user_id,$class_user->user_id,$post_data['post_id'],'post');
                                    }
                                }

                            }else{
                                $return_data = array('success'=>false,'error_msg'=>'class doesnt exist');
                                $this->renderJSON($return_data);
                                return;
                            }

                        }else if($model->origin_type == 'department'){
                            $department = Department::model()->find('department_id=:id',array(':id'=>$model->origin_id));

                            if($department){
                                $post_data['origin'] = $this->model_to_array($department);
                                //reassign the name to make it easier to get in the handlebars
                                $post_data['origin']['name'] = $post_data['origin']['department_name'];

                                //Send a notification to everyone in this class about this post
                                foreach($department->users as $department_user){
                                    if($department_user->user_id != $user->user_id){

                                        //If this user is an admin and this post is not an event,
                                        //send a post announcement email
                                        if(($user->user_type == 'a' || $user->user_type == 'p') && $user->department_id == $department->department_id  && $model->post_type != 'event'){
                                            $subject = 'Urlinq announcement';
                                            $to_user_id = $department_user->user_id;
                                            $actor_id = $user->user_id;
                                            ERunActions::touchUrl(Yii::app()->getBaseUrl(true) . '/post/sendPostEmailFunction',$postData=array('to_user_id'=>$to_user_id, 'subject'=>$subject, 'actor_id'=>$actor_id, 'post_id'=>$model->post_id),$contentType=null);
                                        }

                                        send_notification('post',$user->user_id,$department_user->user_id,$post_data['post_id'],'post');
                                    }
                                }
                                /* not sure if this should be added
                                //Send a notification to everyone following this department
                                foreach($department->followers as $department_follower){
                                    if($department_follower->user_id != $user->user_id){
                                        send_notification('post',$user->user_id,$department_follower->user_id,$post_data['post_id'],'post');
                                    }
                                }
                                */


                            }else{
                                $return_data = array('success'=>false,'error_msg'=>'department doesnt exist');
                                $this->renderJSON($return_data);
                                return;
                            }

                        }else if($model->origin_type == 'school'){

                            $school = School::model()->find('school_id=:id',array(':id'=>$model->origin_id));


                            if($school){
                                $post_data['origin'] = $this->model_to_array($school);
                                //reassign the name to make it easier to get in the handlebars
                                $post_data['origin']['name'] = $post_data['origin']['school_name'];


                                //Send a notification to everyone in this class about this post
                                foreach($school->users as $school_user){
                                    if($school_user->user_id != $user->user_id){


                                        //If this user is an admin and this post is not an event,
                                        //send a post announcement email
                                        if(($user->user_type == 'a' || $user->user_type == 'p') && $user->school_id == $school->school_id  && $model->post_type != 'event'){
                                            $subject = 'Urlinq announcement';
                                            $to_user_id = $school_user->user_id;
                                            $actor_id = $user->user_id;
                                            ERunActions::touchUrl(Yii::app()->getBaseUrl(true) . '/post/sendPostEmailFunction',$postData=array('to_user_id'=>$to_user_id, 'subject'=>$subject, 'actor_id'=>$actor_id, 'post_id'=>$model->post_id),$contentType=null);
                                        }

                                        send_notification('post',$user->user_id,$school_user->user_id,$post_data['post_id'],'post');
                                    }
                                }
                            }else{
                                $return_data = array('success'=>false,'error_msg'=>'school doesnt exist');
                                $this->renderJSON($return_data);
                                return;
                            }


                        }else if($model->origin_type == 'club' || $model->origin_type == 'group'){
                            $group = Group::model()->find('group_id=:id',array(':id'=>$model->origin_id));

                            if($group){

                                $is_admin = false;
                                $group_user = GroupUser::model()->find('group_id=:group_id and user_id=:user_id', array(':group_id'=>$group->group_id, ':user_id'=>$user->user_id));
                                if($group_user && $group_user->is_admin){
                                    $is_admin = true;
                                }


                                $post_data['origin'] = $this->model_to_array($group);
                                //reassign the name to make it easier to get in the handlebars
                                $post_data['origin']['name'] = $post_data['origin']['group_name'];

                                //Send a notification to everyone in this class about this post
                                foreach($group->users as $group_user){
                                    if($group_user->user_id != $user->user_id){

                                        //If this user is an admin and this post is not an event,
                                        //send a post announcement email
                                        if($is_admin && $model->post_type != 'event'){
                                            $subject = 'Urlinq announcement';
                                            $to_user_id = $group_user->user_id;
                                            $actor_id = $user->user_id;
                                            ERunActions::touchUrl(Yii::app()->getBaseUrl(true) . '/post/sendPostEmailFunction',$postData=array('to_user_id'=>$to_user_id, 'subject'=>$subject, 'actor_id'=>$actor_id, 'post_id'=>$model->post_id),$contentType=null);
                                        }

                                        send_notification('post',$user->user_id,$group_user->user_id,$post_data['post_id'],'post');
                                    }
                                }

                            }else{
                                $return_data = array('success'=>false,'error_msg'=>'group doesnt exist');
                                $this->renderJSON($return_data);
                                return;
                            }

                        }else if($model->origin_type == 'user'){
                            if($user->user_id != $model->origin_id){

                                $post_user_origin = User::model()->find('user_id=:id',array(':id'=>$model->origin_id));

                                if($post_user_origin){
                                    $post_data['origin'] = $this->model_to_array($post_user_origin);

                                    //Send a notification to the user this post was sent to
                                    send_notification('post',$user->user_id,$post_user_origin->user_id,$post_data['post_id'],'post');

                                }else{
                                    $return_data = array('success'=>false,'error_msg'=>'school doesnt exist');
                                    $this->renderJSON($return_data);
                                    return;
                                }

                            }
                        }
                    }catch(Exception $e){
                        $return_data = array('success'=>false,'post'=>$post_data, 'origin_id'=>$model->origin_id);
                        $this->renderJSON($return_data);
                        return;
                    }



                    //This user obviously owns this post
                    $post_data['pownership'] = true;


                    //$post_data['update_timestamp'] = strtotime(gmdate('Y-m-d H:i:s'));
                    $post_data['update_timestamp'] =strtotime("now");
                    $post_data['user_info'] = $this->get_model_associations($user, array('pictureFile'));

                    $return_data = array('success'=>true,'post'=>$post_data);
                    $this->renderJSON($return_data);
                    return;



                }else{
                    $return_data = array('success'=>false,'error_id'=>2);
                    $this->renderJSON($return_data);
                    return;
                }


    //                if(isset($post_id) && $_POST['post']['post_type']=="question"){
    //
    //                    if(isset($_POST['PostQuestionOption'])){
    //
    //                        if(count($_POST['PostQuestionOption'])>0) {
    //
    //                            foreach ($_POST['PostQuestionOption'] as $key => $option) {
    //
    //                                $opt = new PostQuestionOption;
    //                                $opt->option_text = $option['option_text'];
    //                                $opt->post_id = $post_id;
    //
    //                                if($opt->save()){
    //                                    if($option['answer_flag']==1)
    //                                        $correct_answer_id = $opt->option_id;
    //                                    //echo "opt_saved";
    //                                }
    ////                                else
    ////                                    var_dump($opt->getErrors());
    //                                unset($opt);
    //                            }
    //                            if(isset($_POST['PostQuestion'])){
    //                                $question = new PostQuestion;
    //                                $question->attributes = $_POST['PostQuestion'];
    //                                $question->post_id = $post_id;
    //                                if(isset($correct_answer_id))
    //                                    $question->correct_answer_id = $correct_answer_id;
    //                                if($question->save())
    //                                    echo "question_attribs saved";
    ////                                else
    ////                                    var_dump($question->getErrors());
    //                            }
    //                        }
    //                    }
    //                }

                    //This causes error
                    //self::createNotification("posted", $post_id);




    //            else
    //                var_dump($model->getErrors());

            }else{
                $return_data = array('success'=>false,'error_id'=>1);
                $this->renderJSON($return_data);
                return;
            }

    //		$this->render('create',array(
    //			'model'=>$model,
    //		));

        }catch(Exception $e){
            $return_data = array('success'=>false,'error_id'=>3,'error_msg'=>$e->getMessage());
            $this->renderJSON($return_data);
            return;
        }
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
		$model=$this->loadModel($_GET['id']);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Post']))
		{
            if($model->user_id == self::$cur_user_id) {
                $model->attributes = $_POST['Post'];

                if(isset($_GET['id']) && $model->post_type=="question") {

                    if (isset($_POST['PostQuestionOption'])) {

                        if (count($_POST['PostQuestionOption']) > 0) {

                            foreach ($_POST['PostQuestionOption'] as $key => $option) {

                                $opt = new PostQuestionOption;
                                $opt->option_text = $option['option_text'];
                                $opt->post_id = $_GET['id'];

                                if ($opt->save()) {
                                    if ($option['answer_flag'] == 1)
                                        $correct_answer_id = $opt->option_id;
                                    echo "opt_saved";
                                }
//                                else
//                                    var_dump($opt->getErrors());
                                unset($opt);
                            }
                        }
                        if(isset($correct_answer_id)){
                            $question = PostQuestion::model()->findbypk($_GET['id']);
                            $question->correct_answer_id = $correct_answer_id;
                        }
                    }
                }
                if ($model->save())
                    echo "update_success";
//                    $this->redirect(array('view', 'id' => $model->post_id));
            }
            else
                echo "Access Denied";
		}

//		$this->render('update',array(
//			'model'=>$model,
//		));
	}




    public function actionAnswerQuestion(){
        if(!isset($_POST['option_id'])){
            $return_data = array('success'=>false,'error_id'=>1, 'error_msg'=>'all data not set');
            $this->renderJSON($return_data);
            return;
        }

        $user = $this->get_current_user($_POST);

        if(!$user){
            $return_data = array('success'=>false,'error_id'=>2, 'error_msg'=>'user is not logged in');
            $this->renderJSON($return_data);
            return;
        }


        $option_id = $_POST['option_id'];

        $option = PostQuestionOption::model()->find('option_id=:id', array(':id'=>$option_id));

        if(!$option){
            $return_data = array('success'=>false,'error_id'=>2, 'error_msg'=>'option is not logged in');
            $this->renderJSON($return_data);
            return;
        }

        $post_id = $option->post_id;


        //Check if this user has already voted for this question
        $post = $option->post;

        $options = $post->postQuestionOptions;

        foreach($options as $this_option){

            //Check if the user voted for this option
            $user_vote = PostQuestionOptionAnswer::model()->find('option_id=:option_id and user_id=:user_id', array(':option_id'=>$this_option->option_id, ':user_id'=>$user->user_id));

            if($user_vote){
                if($user_vote->option_id == $option->option_id){
                    //User already voted for this shit
                    $return_data = array('success'=>true);
                    $this->renderJSON($return_data);
                    return;
                }else{
                    //Delete this vote because the user sent a new one
                    $user_vote->delete();
                }
            }else{
                if($this_option->option_id == $option->option_id){
                    $new_user_vote = new PostQuestionOptionAnswer;
                    $new_user_vote->option_id = $option->option_id;
                    $new_user_vote->user_id = $user->user_id;

                    if($new_user_vote->save(false)){
                        $return_data = array('success'=>true);
                        $this->renderJSON($return_data);
                        return;
                    }else{
                        $return_data = array('success'=>false, 'error_msg'=>'error saving vote', 'user_vote'=>$new_user_vote);
                        $this->renderJSON($return_data);
                        return;
                    }
                }
            }
        }

        $return_data = array('success'=>false, 'error_msg'=>'error with everything');
        $this->renderJSON($return_data);
        return;

    }


	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete(){

        if(!isset($_POST['post_id'])){
            $return_data = array('success'=>false,'error_id'=>1, 'error_msg'=>'all data not set');
            $this->renderJSON($return_data);
            return;
        }


        $user = $this->get_current_user($_POST);
        if(!$user){
            $return_data = array('success'=>false,'error_id'=>2, 'error_msg'=>'user is not logged in');
            $this->renderJSON($return_data);
            return;
        }

        $post = Post::model()->find('post_id=:id',array(':id'=>$_POST['post_id']));

        if(!$post){
            $return_data = array('success'=>false,'error_id'=>3, 'error_msg'=>'post doesnt exist');
            $this->renderJSON($return_data);
            return;
        }
        if($post->post_type == "event"){
            if(!isset($_POST['event_id'])){
                $return_data = array('success'=>false,'error_id'=>1, 'error_msg'=>'all data not set');
                $this->renderJSON($return_data);
                return;
            }else{
                $event = Event::model()->find('event_id=:eid',array(':eid'=>$_POST['event_id']));
            }

        }

        //Make sure this user created this post
        if($post->user_id != $user->user_id){
            if($post->origin_type == "club"){
                $origin = Group::model()->findByPk($post->origin_id);
            }else if($post->origin_type == "class"){
                $origin = ClassModel::model()->findByPk($post->origin_id);
            }else if($post->origin_type == "department"){
                $origin = Department::model()->findByPk($post->origin_id);
            }
            $is_admin=false;
            foreach($origin->admins as $admin){
                if($user->user_id == $admin->user_id){
                    $is_admin = true;
                }
            }if($is_admin == false){
                $return_data = array('success'=>false,'error_id'=>4, 'error_msg'=>'User is not authorized to delete this post');
                $this->renderJSON($return_data);
                return;
            }

        }


        //If all goes well, delete the post
        if($post->delete()){
            if(isset($event)){
                if(!$event->delete()){
                    $return_data = array('success'=>false,'error_id'=>5, 'error_msg'=>'Error deleting event');
                    $this->renderJSON($return_data);
                    return;
                }
            }


            $return_data = array('success'=>true);
            $this->renderJSON($return_data);
            return;
        }else{
            $return_data = array('success'=>false,'error_id'=>5, 'error_msg'=>'Error deleting post');
            $this->renderJSON($return_data);
            return;
        }

	}
    // param post_id
    public function actionHide(){
        if(!isset($_POST['post_id'])){
            $return_data = array('success'=>false,'error_id'=>1, 'error_msg'=>'all data not set');
            $this->renderJSON($return_data);
            return;
        }


        $user = $this->get_current_user($_POST);
        if(!$user){
            $return_data = array('success'=>false,'error_id'=>2, 'error_msg'=>'user is not logged in');
            $this->renderJSON($return_data);
            return;
        }

        $post = Post::model()->find('post_id=:id',array(':id'=>$_POST['post_id']));

        if(!$post){
            $return_data = array('success'=>false,'error_id'=>3, 'error_msg'=>'post doesnt exist');
            $this->renderJSON($return_data);
            return;
        }
        $post_hide = new PostHide();
        $post_hide->post_id = $_POST['post_id'];
        $post_hide->user_id =  $user->user_id;
        if(!$post_hide->save()) {
            $return_data = array('success' => false, 'error_id' => 5, 'error_msg' => 'error hiding post');
            $this->renderJSON($return_data);
            return;
        }else{
                $return_data = array('success'=>true);
                $this->renderJSON($return_data);
                return;
        }
    }

    // param post_id
    public function actionReport(){
        if(!isset($_POST['post_id'])){
            $return_data = array('success'=>false,'error_id'=>1, 'error_msg'=>'all data not set');
            $this->renderJSON($return_data);
            return;
        }


        $user = $this->get_current_user($_POST);
        if(!$user){
            $return_data = array('success'=>false,'error_id'=>2, 'error_msg'=>'user is not logged in');
            $this->renderJSON($return_data);
            return;
        }

        $post = Post::model()->find('post_id=:id',array(':id'=>$_POST['post_id']));

        if(!$post){
            $return_data = array('success'=>false,'error_id'=>3, 'error_msg'=>'post doesnt exist');
            $this->renderJSON($return_data);
            return;
        }
        $post_report = new PostReport();
        $post_report->post_id = $_POST['post_id'];
        $post_report->user_id =  $user->user_id;
        if(!$post_report->save()) {
            $return_data = array('success' => false, 'error_id' => 5, 'error_msg' => 'error reporting post');
            $this->renderJSON($return_data);
            return;
        }else{
            $return_data = array('success'=>true);
            $this->renderJSON($return_data);
            return;
        }
    }


    //ERROR ID's
    // 1 - Post id isnt set
    // 2 - like already exists
    // 3 - error creating post like
    public function actionAnswer(){
        try{
            if(!isset($_POST['post_id']) || !isset($_POST['option_id'])){
                $return_data = array('success'=>false,'error_id'=>1, 'error_msg'=>'all data not set');
                $this->renderJSON($return_data);
                return;
            }
            $option_id = $_POST['option_id'];
            $user = $this->get_current_user($_POST);
            if($user){
                $answer = PostQuestionOptionAnswer::model()->find('option_id=:id and user_id=:user_id', array(":id"=>$option_id, ":user_id"=>$user->user_id));
                if($answer){
                    $return_data = array('success'=>false,'error_id'=>3, 'error_msg'=>'user already answered');
                    $this->renderJSON($return_data);
                    return;
                }

                $answer_new = new PostQuestionOptionAnswer;
                $answer_new->user_id = $user->user_id;
                $answer_new->option_id = $option_id;

                if($answer->save(false)){
                    $data=array('success'=>true);
                    $this->renderJSON($data);
                    return;
                }
                else{
                    $return_data = array('success'=>false,'error_id'=>4, 'error_msg'=>'error saving answer to database');
                    $this->renderJSON($return_data);
                    return;
                }

            }
            else{
                $return_data = array('success'=>false,'error_id'=>2, 'error_msg'=>'user not exists');
                $this->renderJSON($return_data);
                return;
            }

        }catch (Exception $e){
            $data = array('success'=>false,'error_id'=>2,'error_msg'=>$e->getMessage());
            $this->renderJSON($data);
            return;
        }
    }
    public function actionLike()
    {
        try{
            if(!isset($_POST['post_id'])){
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
            $post_id = $_POST['post_id'];

            $post = Post::model()->find('post_id=:id', array(':id'=>$post_id));


            $post_like = PostLike::model()->findBySql("SELECT * FROM post_like WHERE post_id=" . $post_id . ' AND user_id=' . $user->user_id);


            //Make sure the user hasnt already liked this post
            if(!$post_like){
                $post_like = new PostLike;
                $post_like->post_id = $post_id;
                $post_like->user_id = $user->user_id;
                $post_like->save(false);
                if($post_like) {

                    //Notification is causing error, commented out for now
                    //self::createNotification("liked", $_GET['id']);

                    $post->like_count = $post->like_count + 1;
                    $post->save(false);
                    if($post){
                        if($post->user_id != $user->user_id){

                           include_once 'notification/notification.php';
                           send_notification('like',$user->user_id,$post->user_id,$post->post_id,'post');
                        }
                        $return_data = array('success'=>true);
                        $this->renderJSON($return_data);
                        return;
                    }else{
                        $return_data = array('success'=>false,'error_id'=>3, 'error_msg'=>"error saving post table");
                        $this->renderJSON($return_data);
                        return;
                    }
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
            if (!isset($_POST['post_id'])) {
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
            $post_id = $_POST['post_id'];
            $post = Post::model()->find('post_id=:id', array(':id'=>$post_id));
            $post_like = PostLike::model()->findBySql("SELECT * FROM post_like WHERE post_id=" . $post_id . ' AND user_id=' . $user->user_id);
            if ($post_like->delete()) {
                $post->like_count = $post->like_count - 1;
                $post->save(false);
                if($post){
                    $return_data = array('success' => true);
                    $this->renderJSON($return_data);
                    return;
                }else{
                    $return_data = array('success'=>false,'error_id'=>3, 'error_msg'=>"error saving post table");
                    $this->renderJSON($return_data);
                    return;
                }
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
        if(!isset($_POST['post_id']) || !isset($_POST['reply_text']) || !isset($_POST['reply_user_id']) || !isset($_POST['anonymous'])){
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
            $post_id = $_POST['post_id'];

            $reply_text = $_POST['reply_text'];
            $reply_user_id = $_POST['reply_user_id'];
            $reply_user = User::model()->find("user_id=:user_id",array(":user_id"=>$reply_user_id));

            $anonymous = $_POST['anonymous'];

            $post = Post::model()->find("post_id=:post_id",array(":post_id"=>$post_id));
            if($post){
                //Create a new reply model
                $reply = new Reply;
                $reply->reply_msg = $reply_text;
                $reply->post_id = $post_id;
                $reply->anon = $anonymous;
                $reply->user_id = $reply_user_id;
                $reply->save(false);

                if($reply){


                    if($post->user_id != $user->user_id){
                       include_once 'notification/notification.php';
                       send_notification('reply',$user->user_id,$post->user_id,$reply->reply_id,'reply');
                    }
//                    //Send notification to the creator of this post
//                    if ($user->user_id != $post->user_id) {
//                        //include_once "notification/notification.php"
//                        send_notification('reply', $user->user_id, $post->user_id, $post->post_id, 'post');
//                    }



                    //List of user id's who we need to notify
                    $user_id_list = array();

                    //Get all the users who liked this post
                    $post_likes = PostLike::model()->findAllBySql('SELECT * FROM `post_like` WHERE post_id = ' . $post->post_id);

                    //Send notification to everyone who liked this post except the user of the post
                    //and the person sending the reply
                    foreach($post_likes as $post_like){
                        if($post_like->user_id != $post->user_id && $post_like->user_id != $user->user_id && !in_array($post_like->user_id, $user_id_list)){
                            array_push($user_id_list, $post_like->user_id);

                        }
                    }

                    $post_replies = Reply::model()->findAll('post_id=:post_id', array(':post_id'=>$post->user_id));
                    //Send notification to everyone who liked this post except the user of the post
                    //and the person sending the reply
                    foreach($post_replies as $post_reply){
                        if($post_reply->user_id != $post->user_id && $post_reply->user_id != $user->user_id && !in_array($post_reply->user_id, $user_id_list)){
                            array_push($user_id_list, $post_reply->user_id);
                        }
                    }



                    foreach($user_id_list as $notify_user_id){
                        include_once 'notification/notification.php';
                        send_notification('reply', $user->user_id, $notify_user_id, $reply->reply_id,'reply');
                    }




                        //send_notification('reply', $user->user_id, 1, $post->post_id, 'post');


//                {
//                  "reply_id": "1",
//                  "post_id": "10",
//                  "user_id": "2",
//                  "reply_msg": "Hey dude whats up",
//                  "up_vote": 0,
//                  "down_vote": 0,
//                  "file_id": null,
//                  "anon": 0,
//                  "update_timestamp": 1417015584,
//                  "user_info": {
//                            "user_id": "2",
//                    "user_name": "Lol Lmfao",
//                    "picture_file_id": "1"
//                  },
//                  "cownership": false,
//                  "vote_status": null
//                }
                    $reply_data = array(
                        'reply_id'=>$reply->reply_id,
                        'post_id'=>$post->post_id,
                        'reply_msg'=>$reply->reply_msg,
                        'up_vote'=>$reply->up_vote,
                        'down_vote'=>$reply->down_vote,
                        'file_id'=>$reply->file_id,
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
                $data = array('success'=>false,'error_id'=>2,'error_msg'=>'post with id ' . $post_id . 'does not exist');
                $this->renderJSON($data);
                return;
            }
        }catch(Exception $e){
            $data = array('success'=>false,'error_id'=>2,'error_msg'=>$e->getMessage());
            $this->renderJSON($data);
            return;
        }


    }

    public function createNotification($action, $id){
        $model = new Notification;
        $model->actor_id = self::$cur_user_id;
        $model->trigger_id = $id;
        $model->trigger_type = $action;
        if($model->save())
            echo "Notification created successfully";
        else
            var_dump($model->getErrors());
    }

    public function actionGetPostComments() {
        if (!isset($_GET['post_id'])) {
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'required values not set');
            $this->renderJSON($data);
            return;
        }
        
        $user = $this->get_current_user($_GET);
        if (!$user) {
            $data = array('success'=>false,'error_id'=>2,'error_msg'=>'not a valid user.');
            $this->renderJSON($data);
            return;
        }

        $post_id = $_GET['post_id'];

        $sql = "SELECT * FROM reply WHERE post_id = $post_id;";

        $replies = Reply::model()->findAllBySql($sql);

        $replies_with_users = array();

        foreach ($replies as $reply) {

            $reply = $this->model_to_array($reply);
            $reply_user = User::model()->find("user_id=:user_id",array(":user_id"=>$reply['user_id']));
            $reply['user_info'] = $reply_user;
            array_push($replies_with_users, $reply);
        }

        $data = array('success'=>true,'replies'=>$replies_with_users);
        $this->renderJSON($data);
        return;

    }

	/**
	 * Lists all models.
	 */
//	public function actionIndex()
//	{
//		$dataProvider=new CActiveDataProvider('Post');
//		$this->render('index',array(
//			'dataProvider'=>$dataProvider,
//		));
//	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Post('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Post']))
			$model->attributes=$_GET['Post'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
    

	/*
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Post the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Post::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Post $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='post-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
