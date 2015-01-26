    <?php

    class ApiController extends Controller
    {

        public function actionAddNotificationID() {
            if(!isset($_POST['user_id']) || !isset($_POST['notification_id'])){
                $data = array('success'=>false, 'error_id'=>1, 'error_msg'=>'required data not set');
                $this->renderJSON($data);
                return;
            }

            $user_id = $_POST['user_id'];
            $user = User::model()->find("user_id=:user_id", array(":user_id"=>$user_id));

            if (!$user) {
                $data = array('success'=>false, 'error_id'=>2, 'error_msg'=>'not a valid user');
                $this->renderJSON($data);
                return;            
            }

            $notification_id = str_replace(array(" "), "", $_POST['notification_id']);
            $ios_notification = new IosNotification;
            $ios_notification->user_id = $user_id;
            $ios_notification->notification_id = $notification_id;

            if ($ios_notification->save(false)) {
                $data = array('success'=>true);
                $this->renderJSON($data);
                return;
            } else {
                $data = array('success'=>false, 'error_id'=>3, 'error_msg'=>'could not save data.');
                $this->renderJSON($data);
                return;   
            }
        }
         
        public function actionGetUserPictureID() {

         if(!isset($_GET['user_id'])){
                $data = array('success'=>false, 'error_id'=>1, 'error_msg'=>'user_id not set');
                $this->renderJSON($data);
                return;
        }
            $user_id = $_GET['user_id'];
            $user = User::model()->find("user_id=:user_id", array(":user_id"=>$user_id));
            if($user){

                $file_id = $user->pictureFile->file_url;
                if($file_id){
                    
                    $data = array('success'=>true,'file_url'=>$file_id,'base_url'=>Yii::app()->getBaseUrl(true));
                    $this->renderJSON($data);
                    return;
                } else {
                    $data = array('success'=>false,'error_id'=>2,'error_msg'=>'file_id are not set');
                    $this->renderJSON($data);
                    return;
            }

            } else{
                $data = array('success'=>false, 'error_id'=>3, 'error_msg'=>'user not exists');
                $this->renderJSON($data);
                return;
            }
        }



        //Error ids
        // 1 - file id is not set
        // 2 - File doesnt exist
        public function actionGetFileUrls(){
            if(!isset($_GET['file_ids'])){
                $data = array('success'=>false,'error_id'=>1,'error_msg'=>'file_ids are not set');
                $this->renderJSON($data);
                return;
            }
            else{
                $file_urls = array();
                $file_ids = $_GET['file_ids'];
                if(count($file_ids)){
                    for($i=0; $i<count($file_ids); $i++){
                        $file_id = $file_ids[$i];
                        $file = File::model()->find("file_id=:file_id",array(":file_id"=>$file_id));
                        if($file){
                            array_push($file_urls, $file->file_url);
                        }else{
                            $data = array('success'=>false,'error_id'=>2,'error_msg'=>'File with id ' . $file_id . 'does not exist');
                            $this->renderJSON($data);
                            return;
                        }
                    }
                    $data = array('success'=>true,'file_urls'=>$file_urls,'base_url'=>Yii::app()->getBaseUrl(true));
                    $this->renderJSON($data);
                    return;
                }
                else{
                    $data = array('success'=>false,'error_id'=>1,'error_msg'=>'file_ids are not set');
                    $this->renderJSON($data);
                    return;
                }
            }
        }


        public function actionGetFileUrl(){
            if(!isset($_GET['file_id'])){
                $data = array('success'=>false,'error_id'=>1,'error_msg'=>'file_id isnt set');
                $this->renderJSON($data);
                return;
            }

            $file_id = $_GET['file_id'];
            $file = File::model()->find("file_id=:file_id",array(":file_id"=>$file_id));
            if($file){
                $data = array('success'=>true,'file_url'=>$file->file_url,'base_url'=>Yii::app()->getBaseUrl(true));
                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false,'error_id'=>2,'error_msg'=>'File with id ' . $file_id . 'does not exist');
                $this->renderJSON($data);
                return;
            }

        }


        public function actionFileUpload(){


            include "file_upload.php";




            $data = file_upload($_FILES);
            $this->renderJSON($data);
            return;

        }

        //checks nyu email and checks if user already exists

        public function actionValidateAccount(){
            if(!isset($_GET['email']) || !isset($_GET['password'])){
                $data = array('success'=>false,'error_id'=>1,'error_msg'=>'All data is not set');
                $this->renderJSON($data);
                return;
            }


            $email = $_GET['email'];


            if((strpos($email,'nyu.edu') == false) && (strpos($email,'urlinq.com') == false)){
                $data = array('success'=>false,'error_id'=>2,'error_msg'=>'NOT A VALID EMAIL');
                $this->renderJSON($data);
                return;
            }

            $user = User::model()->find("user_email=:user_email",array(":user_email"=>$email));
            //$user = User::model()->findBySql("SELECT * FROM `user` WHERE user_email='$email'");

            if($user){
                $data = array('success'=>true,'status'=>$user->status);
                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false,'error_id'=>3,'error_msg'=>'User with email ' . $email . ' doesnt exist');
                $this->renderJSON($data);
                return;
            }

        }


        //Takes in a string and returns a list of users whose
        //name or email contains that string
        public function actionSearchUsers(){
            if(!isset($_GET['input_string'])){
                $data = array('success'=>false,'error_id'=>1,'error'=>'input string is not set');
                $this->renderJSON($data);
                return;
            }
            $input_string = $_GET['input_string'];
            $users = User::model()->findAllBySql("SELECT * FROM `user` WHERE CONCAT(firstname,' ',lastname ) LIKE '%" . $input_string . "%' OR user_email LIKE '%" . $input_string . "%'");
            $users_data = array();
            foreach($users as $user){
                array_push($users_data, $this->get_model_associations($user, array('pictureFile')));
            }
            if(count($users_data) >= 0){
                $data = array('success'=>true,'users'=>$users_data);
                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false,'error_id'=>2,'error'=>'error getting users');
                $this->renderJSON($data);
                return;
            }
        }




        public function actionCreatePost(){
            try{
                if(!isset($_POST['user_id']) || !isset($_POST['anon']) || !isset($_POST['text']) || !isset($_POST['origin_type']) || !isset($_POST['privacy'])){
                    $data =array('success'=>false, 'error_id'=>1, 'error_msg'=>'required data not set');
                    $this->renderJSON($data);
                    return;
                }
                $picture_file_id = null;
                if (isset($_FILES['file']) && $_FILES['file'] != null) {
                    include "file_upload.php";

                    $file_upload_response = file_upload($_FILES,'',$_POST['user_id']);
                    if ($file_upload_response['success']) {
                        $picture_file_id = $file_upload_response['file_id'];
                    } else {
                        $picture_file_id = null;
                    }
                } else {
                    $picture_file_id = null;
                }
                $post_new = new Post;
                $post_new->user_id = $_POST['user_id'];
                $post_new->origin_type = $_POST['origin_type'];
                if($post_new->origin_type == 'user'){
                    $post_new->origin_id = $_POST['user_id'];
                }else{
                    $post_new->origin_id = $_POST['origin_id'];
                }
                $post_new->post_type = 'discussion';
                $post_new->anon = $_POST['anon'];
                $post_new->text = $_POST['text'];
                $post_new->file_id = $picture_file_id;

                if($_POST['privacy'] == 'all') {
                    $post_new->privacy = '';
                }else if($_POST['privacy'] == 'admin'){
                    $post_new->privacy = 'admin';
                }else if($_POST['privacy'] == 'members'){
                    $post_new->privacy = 'members';
                }
                else{
                    $post_new->privacy = '';
                }
                if(!$post_new->save(false)){
                    $data = array('success'=> false,'error_id'=> 3, 'error_msg'=>'Error saving post to database');
                    $this->renderJSON($data);
                    return;
                }
                else{
                    $data = array('success'=> true, 'post_id'=>$post_new->post_id);
                    $this->renderJSON($data);
                    return;
                }
            }catch (Exception $e){
                $data = array('success'=> false,'error_id'=> 2, 'error_msg'=>$e->getMessage());
                $this->renderJSON($data);
                return;
            }
        }

        public function actionCreateQuestion(){
            try{
                if(!isset($_POST['user_id']) || !isset($_POST['text']) || !isset($_POST['origin_type']) || !isset($_POST['privacy']) || !isset($_POST['anon'])) {
                    $data = array('success' => false, 'error_id' => 1, 'error_msg' => 'required data not set');
                    $this->renderJSON($data);
                }
                //echo 'options: '.$options;
                $picture_file_id = null;
                if (isset($_FILES['file']) && $_FILES['file'] != null) {
                    include "file_upload.php";

                    $file_upload_response = file_upload($_FILES,'',$_POST['user_id']);
                    if ($file_upload_response['success']) {
                        $picture_file_id = $file_upload_response['file_id'];
                    } else {
                        $picture_file_id = null;
                    }
                } else {
                    $picture_file_id = null;
                }

                $post_new = new Post();
                $post_new->user_id = $_POST['user_id'];
                $post_new->origin_type = $_POST['origin_type'];
                if($post_new->origin_type == 'user'){
                    $post_new->origin_id = $_POST['user_id'];
                }else{
                    $post_new->origin_id = $_POST['origin_id'];
                }
                $post_new->post_type = 'question';
                $post_new->text = $_POST['text'];
                $post_new->anon = $_POST['anon'];
                if(isset($_POST['subtext'])){
                    $post_new->sub_text = $_POST['subtext'];
                }
                $post_new->file_id = $picture_file_id;
                if($_POST['privacy'] == 'all') {
                    $post_new->privacy = '';
                }elseif($_POST['privacy'] == 'admin'){
                    $post_new->privacy = 'admin';
                }elseif($_POST['privacy'] == 'members'){
                    $post_new->privacy = 'members';
                }

                //save post first
                if($post_new->save(false)){
                    $question_new = new PostQuestion();
                    $question_new->post_id = $post_new->post_id;
                    $question_new->anonymous = $_POST['anon'];
                    $question = null;
                    if(!isset($_POST['answer'])) {
                        $question_new->correct_answer_id = null;
                    }
                    else{
                        $question = $_POST['answer'];
                    }

                    $options = null;
                    if(isset($_POST['options'])){
                        $options = $_POST['options'];
                    }
                    else{
                        if(!$question_new->save(false)){
                            $data = array('success'=> false,'error_id'=> 4, 'error_msg'=>'Error saving question to database');
                            $this->renderJSON($data);
                            return;
                        }
                        else{
                            $data = array('success'=> true, 'post_id'=>$post_new->post_id);
                            $this->renderJSON($data);
                            return;
                        }
                    }
                    //get options and correct answer id
                    for($i = 0; $i<count($options); $i++) {
                        $option_new = new PostQuestionOption();
                        $option_new->post_id = $post_new->post_id;
                        $option_new->option_text = $options[$i];

                        if(!$option_new->save(false)){
                            $data = array('success'=> false,'error_id'=> 5, 'error_msg'=>'Error saving option to database');
                            $this->renderJSON($data);
                            return;
                        }
                        if($question && ($question == $options[$i])) {
                            $question_new->correct_answer_id = $option_new->option_id;
                        }
                    }

                    if(!$question_new->save(false)){
                        $data = array('success'=> false,'error_id'=> 4, 'error_msg'=>'Error saving question to database');
                        $this->renderJSON($data);
                        return;
                    }

                    $data = array('success'=> true, 'post_id'=>$post_new->post_id);
                    $this->renderJSON($data);
                    return;
                }else{
                    $data = array('success'=> false,'error_id'=> 3, 'error_msg'=>'Error saving post to database');
                    $this->renderJSON($data);
                    return;
                }
            }catch (Exception $e){
                $data = array('success'=> false,'error_id'=> 2, 'error_msg'=>$e->getMessage());
                $this->renderJSON($data);
                return;
            }
        }

        //Error ids
        // 1 - all data required is not set
        // 2 - error saving user to database
        public function actionResendEmail(){
            try {
                if (!isset($_POST['user_id'])) {
                    $data = array('success' => false, 'error_id' => 1, 'error_msg' => 'All data is not set');
                    $this->renderJSON($data);
                    return;
                }
                //temp the user_token table not right on the real server
                //$user = $this->get_current_user_id($_POST);
                $user = User::model()->find('user_id=:id', array(':id'=>$_POST['user_id']));
                //$user = $this->get_current_user($_POST);
                if ($user) {
                    $user_confirmation_test = UserConfirmation::model()->find('user_id=:id', array(':id' => $user->user_id));
                    if ($user_confirmation_test) {
                        //If the user already has a confirmation, send another email with the same token
                        $user_email = $user->user_email;
                        $subject = 'Urlinq verification email';
                        $message = Yii::app()->getBaseUrl(true) . '/verify?key=' . $user_confirmation_test->key_email;
                        $from = 'team@urlinq.com';
                        $email_data = array('key' => $user_confirmation_test->key_email);
                        ERunActions::touchUrl(Yii::app()->getBaseUrl(true) . '/site/sendVerificationEmailFunction',$postData=array('to_email'=>$user_email, 'subject'=>$subject, 'message'=>$message, 'from_email'=>$from, 'key'=>$user_confirmation_test->key_email),$contentType=null);
                        $data = array('success' => true, 'user_id' => $user->user_id);
                        $this->renderJSON($data);
                        return;
                    } else {
                        //If there isnt already a user confirmation,
                        //create a new one
                        include_once 'UniqueTokenGenerator.php';
                        //Create a user_confirmation for this user
                        $user_confirmation = new UserConfirmation;
                        $user_confirmation->key_email = token();
                        $user_confirmation->user_id = $user->user_id;

                        if ($user_confirmation->save(false)) {
                            $user_email = $user->user_email;
                            $subject = 'Urlinq verification email';
                            $message = Yii::app()->getBaseUrl(true) . '/verify?key=' . $user_confirmation->key_email;
                            $from = 'team@urlinq.com';
                            $email_data = array('key' => $user_confirmation->key_email);
                            ERunActions::touchUrl(Yii::app()->getBaseUrl(true) . '/site/sendVerificationEmailFunction',$postData=array('to_email'=>$user_email, 'subject'=>$subject, 'message'=>$message, 'from_email'=>$from, 'key'=>$user_confirmation_test->key_email),$contentType=null);
                            $data = array('success' => true, 'user_id' => $user->user_id);
                            $this->renderJSON($data);
                            return;
                        } else {
                            $data = array('success' => false, 'error_id' => 6, 'error_msg' => 'error saving user confirmation');
                            $this->renderJSON($data);
                            return;
                        }

                    }
                } else {
                    $data = array('success' => false, 'error_id' => 1, 'error_msg' => 'user does not exist');
                    $this->renderJSON($data);
                    return;
                }
            }catch(Exception $e){
                $data = array('success' => false, 'error_id' => 2, 'error_msg' => $e->getMessage());
                $this->renderJSON($data);
                return;
            }

        }
        public function actionSignup() {

            if(!isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['user_type'])
                || !isset($_POST['school_id']) || !isset($_POST['department_id'])){


                $data = array('success'=>false,'error_id'=>1,'error_msg'=>'All data is not set');
                $this->renderJSON($data);
                return;
            }


            //|| isset($_FILES['uploadFile'])
            $email = $_POST['email'];
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $password = $_POST['password'];
            $user_type = $_POST['user_type'];
            $school_id = $_POST['school_id'];
            $department_id = $_POST['department_id'];
            //$picture_file_id = null;


            $user = new User;
            try {
                $user->firstname = $first_name;
                $user->lastname = $last_name;
                $user->user_email = $email;
                $user->user_type = $user_type;
                $user->school_id = $school_id;
                $user->department_id = $department_id;
                $user->picture_file_id = null;


                if($user->save(false)){

                    if(isset($_FILES['file']) && $_FILES['file'] != null){
                        include "file_upload.php";
                        $local_directory = 'profile_pictures/';
                        $file_id = null;
                        $file_upload_response = file_upload($_FILES,$local_directory,$user->user_id);
                        if($file_upload_response['success']){
                            $file_id = $file_upload_response['file_id'];
                        }else{
                            $file_id = 1;
                        }
                    }else{
                        $file_id = 1;
                    }
                    $user->picture_file_id = $file_id;
                    if($user->save(false)){
                        $data = array('success'=> false,'error_id'=> 5, 'error_msg'=>'error saving user picture into db');
                        $this->renderJSON($data);
                        return;
                    }

                    include "password_encryption.php";
                    $salt = salt();
                    $hashed_password = hash_password($password,$salt);

                    $user_login = new UserLogin;
                    $user_login->user_id = $user->user_id;
                    $user_login->password = $hashed_password;
                    $user_login->salt = $salt;

                    if(!$user_login->save(false)){
                        $data = array('success'=> false,'error_id'=> 4, 'error_msg'=>'error saving user login to db');
                        $this->renderJSON($data);
                        return;
                    }

                    //after saving user login, send email confirmation

                    $user_confirmation_test = UserConfirmation::model()->find('user_id=:id',array(':id'=>$user->user_id));
                    if($user_confirmation_test){
                        //If the user already has a confirmation, send another email with the same token
                        $user_email = $user->user_email;
                        $subject = 'Urlinq verification email';
                        $message = Yii::app()->getBaseUrl(true) . '/verify?key=' . $user_confirmation_test->key_email;
                        $from = 'team@urlinq.com';
                        $email_data = array('key'=>$user_confirmation_test->key_email);
                        ERunActions::touchUrl(Yii::app()->getBaseUrl(true) . '/site/sendVerificationEmailFunction',$postData=array('to_email'=>$user_email, 'subject'=>$subject, 'message'=>$message, 'from_email'=>$from, 'key'=>$user_confirmation_test->key_email),$contentType=null);
                    }else{
                        //If there isnt already a user confirmation,
                        //create a new one
                        include_once 'UniqueTokenGenerator.php';
                        //Create a user_confirmation for this user
                        $user_confirmation = new UserConfirmation;
                        $user_confirmation->key_email = token();
                        $user_confirmation->user_id = $user->user_id;

                        if($user_confirmation->save(false)){
                            $user_email = $user->user_email;
                            $subject = 'Urlinq verification email';
                            $message = Yii::app()->getBaseUrl(true) . '/verify?key=' . $user_confirmation->key_email;
                            $from = 'team@urlinq.com';
                            $email_data = array('key'=>$user_confirmation->key_email);
                            ERunActions::touchUrl(Yii::app()->getBaseUrl(true) . '/site/sendVerificationEmailFunction',$postData=array('to_email'=>$user_email, 'subject'=>$subject, 'message'=>$message, 'from_email'=>$from, 'key'=>$user_confirmation_test->key_email),$contentType=null);
                        }else{
                            $data = array('success'=>false,'error_id'=>6,'error_msg'=>'error saving user confirmation');
                            $this->renderJSON($data);
                            return;
                        }
                    }



                }else{
                    $data = array('success'=> false,'error_id'=> 3, 'error_msg'=>'Error saving user to database');
                    $this->renderJSON($data);
                    return;
                }


            //Send email verifications here
            ////////////////////////////////






            //$login_data = $this->login($email,$password);

    //        $data = array('success'=>true,'user_id'=>$user->user_id,'user_email'=>$user->user_email);
    //        $this->renderJSON($data);

            //Remove this once email verification is completed
            $data = $this->login($email,$password);
            $this->renderJSON($data);
            return;
            } catch (Exception $e) {
                $data = array('success'=> false,'error_id'=> 2, 'error_msg'=>'error saving user to database');
                $this->renderJSON($data);
                return;
            }
        }

        public function actionCreateEvent()
        {
    //        $data = array('success'=>true);
    //        $this->renderJSON($_POST);
    //        return;

    //        var post_data = {
    //        event:{
    //            event_name: 'Test event',
    //                origin_type:' club',
    //                origin_id: 1,
    //                title: 'Test Event',
    //                description: 'This is my test event description',
    //                start_time: '10:10:10',
    //                end_time: '11:11:11',
    //                start_date: '2014-12-01',
    //                end_date: '2014-12-01',
    //                location: 'Manhattan'
    //            }
    //        };


            if(!isset($_POST['event']['event_name']) || !isset($_POST['event']['event_type']) || !isset($_POST['event']['origin_type']) || !isset($_POST['event']['origin_id']) || !isset($_POST['event']['description'])
                || !isset($_POST['event']['start_time']) || !isset($_POST['event']['end_time']) || !isset($_POST['event']['start_date']) || !isset($_POST['event']['end_date']) || !isset($_POST['event']['location'])){
                $data = array('success'=>false,'error_id'=>1,'error_msg'=>'All data is not set');
                $this->renderJSON($data);
                return;
            }

            $event_data = $_POST['event'];


            try {

                $picture_file_id = null;
                if (isset($_FILES['file']) && $_FILES['file'] != null) {
                    include "file_upload.php";

                    $file_upload_response = file_upload($_FILES,'',$_POST['user_id']);
                    if ($file_upload_response['success']) {
                        $picture_file_id = $file_upload_response['file_id'];
                    } else {
                        $picture_file_id = null;
                    }
                } else {
                    $picture_file_id = null;
                }
                $event = new Event;
                $event->title = $event_data['event_name'];
                $event->description = $event_data['description'];
                $event->event_type = $event_data['event_type'];
                //$user->$this->get_current_user($_POST);
                //$event->user_id = $this->get_current_user_id($_POST);
                $event->user_id = $_POST['user_id'];
                $event->origin_type = $event_data['origin_type'];
                $event->origin_id = $event_data['origin_id'];
                $event->start_date = $event_data['start_date'];
                $event->end_date = $event_data['end_date'];
                $event->start_time = $event_data['start_time'];
                $event->end_time = $event_data['end_time'];
                $event->location = $event_data['location'];
                $event->file_id = $picture_file_id;
                //$event->save(false);

                if($event->save(false)){
                    //If this event was successfully created, check if there
                    //were any invitations sent out for this event
                    if(isset($_POST['event']['invites'])){
                        include_once "invite/invite.php";
                        //Loop thru the invites and send an invite to each user
                        foreach($_POST['event']['invites'] as $invite_user_id){
                            send_invite($event->user_id,$invite_user_id, $event->event_id, 'event');
                        }
                    }



                    //$event = $this->model_to_array($event);
                    //$event['color'] = $this->get_user_event_color($this->get_current_user(),$event);

                    $data = array('success'=>true,'event_id'=>$event->event_id);
                    $this->renderJSON($data);
                    return;
                }else{
                    $data = array('success'=>false,'error_id'=>2,'error_msg'=>'Error creating event ');
                    $this->renderJSON($data);
                    return;
                }

            }catch(Exception $e){
                $data = array('success'=>false,'error_id'=>3,'error_msg'=>$e->getMessage());
                $this->renderJSON($data);
                return;
            }
        }


        public function actionCreateReply()
        {
            try {
                $user = $this->get_current_user($_POST);
                if($user) {
                    $model = new Reply;
                    // Uncomment the following line if AJAX validation is needed
                    // $this->performAjaxValidation($model);
                    if (isset($_POST['comment'])) {
                        $model->attributes = $_POST['comment'];
                        $model->user_id = $user->user_id;
                        if ($model->save(false)){
                            $data = array('success' => true, 'reply_id'=> $model->reply_id);
                            $this->renderJSON($data);
                            return;
                        }
                        else{
                            $data = array('success' => false, 'error_id' => 2, 'error_msg' => 'error saving comment');
                            $this->renderJSON($data);
                            return;
                        }
                    }
                    else{
                        $data = array('success' => false, 'error_id' => 1, 'error_msg' => 'All data is not set');
                        $this->renderJSON($data);
                        return;
                    }
                }
                else{
                    $data = array('success' => false, 'error_id' => 1, 'error_msg' => 'All data is not set');
                    $this->renderJSON($data);
                    return;
                }
            }catch(Exception $e){
                $data = array('success' => false, 'error_id' => 2, 'error_msg' => $e->getMessage());
                $this->renderJSON($data);
                return;
            }

        }

        //ERROR ID's
        // 1 - All data is not set
        public function actionFacebookLogin(){
            try{
                if (!isset($_POST['facebook_email']) || !isset($_POST['facebook_token'])) {
                    $data = array('success' => false, 'error_id' => 1, 'error_msg' => 'All data is not set');
                    $this->renderJSON($data);
                    return;
                }
                $facebook_email = $_POST['facebook_email'];
                $facebook_user = UserAuthProvider::model()->findBySql("select * from `user_auth_provider` where `auth_id`='$facebook_email'");
                if (!$facebook_user) {
                        $data = array('success'=> false,'error_id'=> 2, 'error_msg'=>'facebook user not exists');
                        $this->renderJSON($data);
                        return;
                } else {
                    $user_id = $facebook_user->user_id;
                    $user_p = UserLogin::model()->find("user_id=:user_id",array(":user_id"=>$user_id));
                    $user = User::model()->find("user_id=:user_id",array(":user_id"=>$user_id));
                    $password = $user_p->password;
                    $username = $user->user_email;
                    $data = $this->login($username, $password);
                    $this->renderJSON($data);
                    return;
                }
            }catch (Exception $e){
                $data = array('success'=> false,'error_id'=> 2, 'error_msg'=>$e->getMessage());
                $this->renderJSON($data);
                return;
            }
        }

        public function actionLinkFacebook(){
            try{
                if (!isset($_POST['user_id']) || !isset($_POST['facebook_id'])) {
                    $data = array('success' => false, 'error_id' => 1, 'error_msg' => 'All data is not set');
                    $this->renderJSON($data);
                    return;
                }

                $facebook_id = $_POST['facebook_id'];
                $facebook_user = UserAuthProvider::model()->findBySql("select * from `user_auth_provider` where `auth_id`='$facebook_id'");
                if (!$facebook_user) {
                    $facebook_new = new UserAuthProvider();
                    $facebook_new->auth_id = $facebook_id;
                    $facebook_new->fb_email = $_POST['facebook_id'];
                    $facebook_new->auth_key = $_POST['facebook_token'];
                    $facebook_new->auth_provider = 'facebook';
                    if($facebook_new->save(false)){
                        $data = array('success' => false, 'error_id'=>3, 'error_msg'=>'user not');
                        $this->renderJSON($data);
                        return;
                    }
                    else{
                        $data = array('success'=> false,'error_id'=> 2, 'error_msg'=>'error saving facebook information');
                        $this->renderJSON($data);
                        return;
                    }
                } else {
                    $user_id = $facebook_user->user_id;
                    $user_p = UserLogin::model()->find("user_id=:user_id",array(":user_id"=>$user_id));
                    $user = User::model()->find("user_id=:user_id",array(":user_id"=>$user_id));
                    $password = $user_p->password;
                    $username = $user->user_email;
                    $data = $this->login($username, $password);
                    $this->renderJSON($data);
                    return;
                }
            }catch (Exception $e){
                $data = array('success'=> false,'error_id'=> 2, 'error_msg'=>$e->getMessage());
                $this->renderJSON($data);
                return;
            }

        }

        public function actionUserFollow()
        {
            if(!isset($_POST['user_id']) || !isset($_POST['from_user_id'])){
                $data = array('success'=>false,'error_id'=>1, 'error_msg'=> 'required data not set');
                $this->renderJSON($data);
                return;
            }

            $current_user_id = $_POST['from_user_id'];
            $follow_user_id = $_POST['user_id'];

            $user_connection = UserConnection::model()->findBySql("SELECT * FROM `user_connection` WHERE `from_user_id`='$current_user_id' AND `to_user_id`='$follow_user_id'");

            if(!$user_connection){
                $user_connection = new UserConnection;
                $user_connection->from_user_id = $current_user_id;
                $user_connection->to_user_id = $follow_user_id;
                $user_connection->save(false);

                //If we successfully create the userconnection, return true
                if($user_connection){
                    $data = array('success'=>true);
                    $this->renderJSON($data);
                    return;
                }else{
                    //Error creating user connection
                    $data = array('success'=>false,'error_id'=>3,'error_msg'=>'error creation user connection');
                    $this->renderJSON($data);
                    return;
                }

            }else{
                //Connection already exists
                $data = array('success'=>false,'error_id'=>2,'error_msg'=>'user connection already exists');
                $this->renderJSON($data);
                return;
            }


        }

        public function actionUserUnfollow()
        {
            if(!isset($_POST['user_id']) || !isset($_POST['from_user_id'])){
                $data = array('success'=>false,'error_id'=>1, 'error_msg'=> 'required data not set');
                $this->renderJSON($data);
                return;
            }

            $current_user_id = $_POST['from_user_id'];
            $unfollow_user_id = $_POST['user_id'];

            $user_connection = UserConnection::model()->findBySql("SELECT * FROM `user_connection` WHERE `from_user_id`='$current_user_id' AND `to_user_id`='$unfollow_user_id'");


            //if user connection exists and we can delete it, return true
            if($user_connection && $user_connection->delete()){
                $data = array('success'=>true);
                $this->renderJSON($data);
                return;
            }else{
                //Error deleting connection
                $data = array('success'=>false,'error_id'=>2,'error_msg'=>'user connection doesnt exist');
                $this->renderJSON($data);
                return;
            }
        }

        public function actionGroupJoin(){
            if(!isset($_POST['group_id']) || !isset($_POST['user_id'])){
                $data = array('success'=>false,'error_id'=>1, 'error_msg'=>'required data not set');
                $this->renderJSON($data);
                return;
            }

            $user_id = $_POST['user_id'];
            $group_id = $_POST['group_id'];

            $group_user = GroupUser::model()->find('group_id=:id and user_id=:user_id', array(':id'=>$group_id,':user_id'=>$user_id));
            //Check if this user is already a member for this group
            if(!$group_user){
                //Create new group user
                $group_user = new GroupUser;
                $group_user->group_id = $group_id;
                $group_user->user_id = $user_id;
                //If we save successfully, user is now apart of group
                if($group_user->save(false)){
                    $data = array('success'=>true);
                    $this->renderJSON($data);
                    return;
                }else{
                    $data = array('success'=>false,'error_id'=>3, 'error_msg'=>'error saving group_user table');
                    $this->renderJSON($data);
                    return;
                }
            }else{
                //user is apart of this group
                $data = array('success'=>false,'error_id'=>2, 'error_msg'=>'user already in the group');
                $this->renderJSON($data);
                return;
            }


        }


        public function actionGroupLeave(){
            if(!isset($_POST['group_id']) || !isset($_POST['user_id'])){
                $data = array('success'=>false,'error_id'=>1, 'error_msg'=>'required data not set');
                $this->renderJSON($data);
                return;
            }

            $user_id = $_POST['user_id'];
            $group_id = $_POST['group_id'];

            $group_user = GroupUser::model()->find('group_id=:id and user_id=:user_id', array(':id'=>$group_id,':user_id'=>$user_id));
            //Check if this user is even in this group
            if($group_user){
                //Check if we destroy this shit successfully
                if($group_user->delete()){
                    $data = array('success'=>true);
                    $this->renderJSON($data);
                    return;
                }else{
                    $data = array('success'=>false,'error_id'=>3, 'error_msg'=>'error deleting user');
                    $this->renderJSON($data);
                    return;
                }
            }else{
                //user is not apart of this group
                $data = array('success'=>false,'error_id'=>2, 'error_msg'=>'user not in the group');
                $this->renderJSON($data);
                return;
            }


        }

        public function actionClassJoin(){
            if(!isset($_POST['class_id']) || !isset($_POST['user_id'])){
                $data = array('success'=>false,'error_id'=>1, 'error_msg'=>'required data not set');
                $this->renderJSON($data);
                return;
            }

            $user_id = $_POST['user_id'];
            $class_id = $_POST['class_id'];

            $class_user = ClassUser::model()->find('class_id=:id and user_id=:user_id', array(':id'=>$class_id,':user_id'=>$user_id));
            //Check if this user is already a member for this class
            if(!$class_user){
                //Create new class user
                $class_user = new ClassUser;
                $class_user->class_id = $class_id;
                $class_user->user_id = $user_id;
                //If we save successfully, user is now apart of class
                if($class_user->save(false)){
                    $data = array('success'=>true);
                    $this->renderJSON($data);
                    return;
                }else{
                    $data = array('success'=>false,'error_id'=>3, 'error_msg'=>'error saving class_user table');
                    $this->renderJSON($data);
                    return;
                }
            }else{
                //user is apart of this class
                $data = array('success'=>false,'error_id'=>2, 'error_msg'=>'user already in the class');
                $this->renderJSON($data);
                return;
            }


        }

        public function actionClassLeave(){
            if(!isset($_POST['class_id']) || !isset($_POST['user_id'])){
                $data = array('success'=>false,'error_id'=>1, 'error_msg'=>'required data not set');
                $this->renderJSON($data);
                return;
            }

            $user_id = $_POST['user_id'];
            $class_id = $_POST['class_id'];

            $class_user = ClassUser::model()->find('class_id=:id and user_id=:user_id', array(':id'=>$class_id,':user_id'=>$user_id));
            //Check if this user is even in this class
            if($class_user){
                //Check if we destroy this shit successfully
                if($class_user->delete()){
                    $data = array('success'=>true);
                    $this->renderJSON($data);
                    return;
                }else{
                    $data = array('success'=>false,'error_id'=>3, 'error_msg'=>'error deleting class_user table');
                    $this->renderJSON($data);
                    return;
                }
            }else{
                //user is not apart of this class
                $data = array('success'=>false,'error_id'=>2, 'error_msg'=>'user not in the class');
                $this->renderJSON($data);
                return;
            }


        }

        public function actionDepartmentFollow(){
            if(!isset($_POST['department_id']) || !isset($_POST['user_id'])){
                $data = array('success'=>false,'error_id'=>1, 'error_msg'=>'required data not set');
                $this->renderJSON($data);
                return;
            }

            $user_id = $_POST['user_id'];
            $department_id = $_POST['department_id'];

            $department_user = DepartmentFollow::model()->find('department_id=:id and user_id=:user_id', array(':id'=>$department_id,':user_id'=>$user_id));
            //Check if this user is already a member for this class
            if(!$department_user){
                //Create new class user
                $department_user = new DepartmentFollow;
                $department_user->department_id = $department_id;
                $department_user->user_id = $user_id;
                //If we save successfully, user is now apart of class
                if($department_user->save(false)){
                    $data = array('success'=>true);
                    $this->renderJSON($data);
                    return;
                }else{
                    $data = array('success'=>false,'error_id'=>3, 'error_msg'=>'error saving department_follow table');
                    $this->renderJSON($data);
                    return;
                }
            }else{
                //user is apart of this class
                $data = array('success'=>false,'error_id'=>2, 'error_msg'=>'user already following the department');
                $this->renderJSON($data);
                return;
            }
        }

        public function actionDepartmentUnfollow(){
            if(!isset($_POST['department_id']) || !isset($_POST['user_id'])){
                $data = array('success'=>false,'error_id'=>1, 'error_msg'=>'required data not set');
                $this->renderJSON($data);
                return;
            }

            $user_id = $_POST['user_id'];
            $department_id = $_POST['department_id'];

            $department_user = DepartmentFollow::model()->find('department_id=:id and user_id=:user_id', array(':id'=>$department_id,':user_id'=>$user_id));
            //Check if this user is even in this class
            if($department_user){
                //Check if we destroy this shit successfully
                if($department_user->delete()){
                    $data = array('success'=>true);
                    $this->renderJSON($data);
                    return;
                }else{
                    $data = array('success'=>false,'error_id'=>3, 'error_msg'=>'error deleting department_follow table');
                    $this->renderJSON($data);
                    return;
                }
            }else{
                //user is not apart of this class
                $data = array('success'=>false,'error_id'=>2, 'error_msg'=>'user not following the department');
                $this->renderJSON($data);
                return;
            }
        }

        //ERROR ID's
        // 1 - All data is not set
        public function actionGetUserData(){
            if(!isset($_GET['user_id'])){
                $data = array('success'=>false,'error_id'=>1,'error_msg'=>'user_id not set');
                $this->renderJSON($data);
                return;
            }

            $user_id = $_GET['user_id'];
            $user = User::model()->find("user_id=:user_id",array(":user_id"=>$user_id));
            $data = array('success'=>true,'user'=>$this->get_model_associations($user,array('department'=>array(),'school'=>array('university'),'groups'=>array(),'classes'=>array())));
            $user = $this->get_current_user($_GET);
            if($user && ($user->user_id != $user_id)) {
                $is_attending = UserConnection::model()->find("from_user_id=:user_id and to_user_id=:id", array(":id"=>$user_id, ":user_id"=>$user->user_id));
                if($is_attending){
                    $data['user']['is_following'] = true;
                }
                else{
                    $data['user']['is_following'] = false;
                }
            }else{
                $data['user']['is_following'] = false;
            }
            $this->renderJSON($data);
            return;
        }

        //ERROR ID's
        // 1 - all data not set
        // 2 - User doesnt exist
        public function actionGetUserClubs(){
            if(!isset($_GET['user_id'])){
                $data = array('success'=>false,'error_id'=>1,'error_msg'=>'user_id not set');
                $this->renderJSON($data);
                return;
            }

            $user_id = $_GET['user_id'];

            $user = User::model()->find("user_id=:user_id",array(":user_id"=>$user_id));
            if($user){
                $data = array('success'=>true,'clubs'=>$user->groups);
                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false,'error_id'=>2);
                $this->renderJSON($data);
                return;
            }

        }

        public  function  actionGetUserDepartments(){
            if(!isset($_GET['user_id'])){
                $data = array('success'=>false,'error_id'=>1,'error_msg'=>'user_id not set');
                $this->renderJSON($data);
                return;
            }

            $user_id = $_GET['user_id'];

            $user = User::model()->find("user_id=:user_id", array(":user_id"=>$user_id));
            if($user){
                $data = array('success'=>true,'departments'=>$user->departments);
                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false,'error_id'=>2);
                $this->renderJSON($data);
                return;
            }
        }

        //ERROR ID's
        // 1 - all data not set
        // 2 - User doesnt exist
        public function actionGetUserClasses(){
            if(!isset($_GET['user_id'])){
                $data = array('success'=>false,'error_id'=>1,'error_msg'=>'user_id not set');
                $this->renderJSON($data);
                return;
            }

            $user_id = $_GET['user_id'];

            $user = User::model()->find("user_id=:user_id",array(":user_id"=>$user_id));
            if($user){
                $data = array('success'=>true,'classes'=>$user->classes);
                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false,'error_id'=>2);
                $this->renderJSON($data);
                return;
            }

        }


        public function actionGetUserFollowers(){
            if(!isset($_GET['user_id'])){
                $data = array('success'=>false, 'error_id'=>1, 'error_msg'=>'user_id not set');
                $this->renderJSON($data);
                return;
            }

            $user_id = $_GET['user_id'];

            $user = User::model()->find("user_id=:user_id", array(":user_id"=>$user_id));
            if($user){
                $followers = $user->usersFollowed;
                $followers_data = array();
                foreach($followers as $follower){
                    $follower = $this->get_model_associations($follower, array('department'=>array(),'school'=>array('university')));
                    array_push($followers_data, $follower);
                }
                $data = array('success'=>true, 'followers'=>$followers_data);
                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false, 'error_id'=>2, 'error_msg'=>'user not exists');
                $this->renderJSON($data);
                return;
            }
        }

        public function  actionGetUserFollowings(){
            if(!isset($_GET['user_id'])){
                $data = array('success'=>false, 'error_id'=>1, 'error_msg'=>'user_id not set');
                $this->renderJSON($data);
                return;
            }

            $user_id = $_GET['user_id'];

            $user = User::model()->find("user_id=:user_id", array(":user_id"=>$user_id));
            if($user){
                $followings = $user->usersFollowing;
                $followings_data = array();
                foreach($followings as $following){
                    $following = $this->get_model_associations($following, array('department'=>array(),'school'=>array('university')));
                    array_push($followings_data, $following);
                }
                $data = array('success'=>true, 'followings'=>$followings_data);
                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false, 'error_id'=>2, 'error_msg'=>'user not exists');
                $this->renderJSON($data);
                return;
            }
        }

        //ERROR ID's
        // 1 - All data is not set
        public function actionGetSchoolData(){
            if(!isset($_GET['school_id'])){
                $data = array('success'=>false,'error_id'=>1,'error_msg'=>'school_id not set');
                $this->renderJSON($data);
                return;
            }

            $school_id = $_GET['school_id'];
            //$user = User::model()->findAll(array("select"=>"user_email"));
            $school = School::model()->find("school_id=:school_id",array(":school_id"=>$school_id));
            if($school){
                $data = array('success'=>true,'school'=>$this->model_to_array($school));


                $sql = "SELECT *
                    FROM user WHERE school_id = $school_id
                    LIMIT 10;";

                $users = User::model()->findAllBySql($sql);


                $data['school']['admins'] = $school->admins;
                $data['school']['members'] = $users;
                $data['school']['department_count'] = count($school->departments);
                $data['school']['group_count'] = count($school->groups);


                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false,'error_id'=>2);
                $this->renderJSON($data);
                return;
            }

        }


        //ERROR ID's
        // 1 - All data is not set
        public function actionGetSchoolMembers(){
            if(!isset($_GET['school_id'])){
                $data = array('success'=>false,'error_id'=>1,'error_msg'=>'school_id not set');
                $this->renderJSON($data);
                return;
            }

            $school_id = $_GET['school_id'];
            //$user = User::model()->findAll(array("select"=>"user_email"));
            $school = School::model()->find("school_id=:school_id",array(":school_id"=>$school_id));
            if($school){
                $data = array('success'=>true);
                $data['members'] = $school->users;
                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false,'error_id'=>2);
                $this->renderJSON($data);
                return;
            }

        }



        //ERROR ID's
        // 1 - All data is not set
        // 2 - Department doesnt exist
        public function actionGetDepartmentData(){
            if(!isset($_GET['department_id'])){
                $data = array('success'=>false,'error_id'=>1,'error_msg'=>'department_id not set');
                $this->renderJSON($data);
                return;
            }

            $department_id = $_GET['department_id'];
            //$user = User::model()->findAll(array("select"=>"user_email"));
            $department = Department::model()->find("department_id=:department_id",array(":department_id"=>$department_id));
            if($department){
                $data = array('success'=>true,'department'=>$this->model_to_array($department));


                $sql = "SELECT *
                    FROM user WHERE department_id = $department_id
                    LIMIT 10;";

                $users = User::model()->findAllBySql($sql);


                $data['department']['admins'] = $department->admins;
                $data['department']['members'] = $users;
                $data['department']['class_count'] = count($department->classes);
                $data['department']['member_count'] = count($department->members);
                $user = $this->get_current_user($_GET);
                if($user) {
                    $is_attending = DepartmentFollow::model()->find("department_id=:id and user_id=:user_id", array(":id"=>$department_id, ":user_id"=>$user->user_id));
                    if($is_attending){
                        $data['department']['is_attending'] = true;
                    }
                    else{
                        $data['department']['is_attending'] = false;
                    }
                }else{
                    $data['department']['is_attending'] = false;
                }




                $this->renderJSON($data);
            }else{
                $data = array('success'=>false,'error_id'=>2);
                $this->renderJSON($data);
                return;
            }

        }


        //ERROR ID's
        // 1 - All data is not set
        // 2 - School doesnt exist
        public function actionGetSchoolDepartments(){
            if(!isset($_GET['school_id'])){
                $data = array('success'=>false,'error_id'=>1,'error_msg'=>'school_id not set');
                $this->renderJSON($data);
                return;
            }


            $school_id = $_GET['school_id'];
            //$user = User::model()->findAll(array("select"=>"user_email"));
            $school = School::model()->find("school_id=:school_id",array(":school_id"=>$school_id));


            if($school){
                $data = array('success'=>true,'departments'=>$school->departments);
                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false);
                $this->renderJSON($data);
                return;
            }
        }


        //ERROR ID's
        // 1 - All data is not set
        // 2 - School doesnt exist
        public function actionGetSchoolGroups(){
            if(!isset($_GET['school_id'])){
                $data = array('success'=>false,'error_id'=>1,'error_msg'=>'school_id not set');
                $this->renderJSON($data);
                return;
            }


            $school_id = $_GET['school_id'];
            //$user = User::model()->findAll(array("select"=>"user_email"));
            $school = School::model()->find("school_id=:school_id",array(":school_id"=>$school_id));


            if($school){
                $data = array('success'=>true,'groups'=>$school->groups);
                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false);
                $this->renderJSON($data);
                return;
            }
        }





        public function actionGetDepartmentMembers(){
            if(!isset($_GET['department_id'])){
                $data = array('success'=>false,'error_id'=>1,'error_msg'=>'department_id not set');
                $this->renderJSON($data);
                return;
            }


            $department_id = $_GET['department_id'];
            //$user = User::model()->findAll(array("select"=>"user_email"));
            $users = User::model()->findAll("department_id=:department_id",array(":department_id"=>$department_id));


            if($users){
                $data = array('success'=>true,'members'=>$users);
                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false);
                $this->renderJSON($data);
                return;
            }
        }


        public function actionGetDepartmentClasses(){
            if(!isset($_GET['department_id'])){
                $data = array('success'=>false,'error_id'=>1,'error_msg'=>'department_id not set');
                $this->renderJSON($data);
                return;
            }


            $department_id = $_GET['department_id'];
            //$user = User::model()->findAll(array("select"=>"user_email"));
            $department = Department::model()->find("department_id=:department_id",array(":department_id"=>$department_id));


    //        $department_classes = $department->classes;
    //        $classes = array();
    //        for ($i = 1; $i <= count($department_classes); $i++) {
    //            $class = $department_classes[$i];
    //
    //        }

            $classes = $this->get_model_associations($department,array('classes'=>array('course')))['classes'];

            if($department){
                $data = array('success'=>true,'classes'=>$classes);
                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false);
                $this->renderJSON($data);
                return;
            }
        }



        //ERROR ID's
        // 1 - All data is not set
        // 2 - Club doesnt exist
        public function actionGetClubData(){
            if(!isset($_GET['group_id'])){
                $data = array('success'=>false,'error_id'=>1,'error_msg'=>'department_id not set');
                $this->renderJSON($data);
                return;
            }


            $group_id = $_GET['group_id'];
            //$user = User::model()->findAll(array("select"=>"user_email"));
            $group = Group::model()->find("group_id=:group_id",array(":group_id"=>$group_id));
            if($group){
    //            $data = array('success'=>true,'group'=>$this->get_model_associations($group,array('admins','members')));

                $data = array('success'=>true,'group'=>$this->model_to_array($group));



                $data['group']['admins'] = $group->admins;
                $data['group']['members'] = $group->members;

                $user = $this->get_current_user($_GET);
                if($user) {
                    $is_attending = GroupUser::model()->find("group_id=:id and user_id=:user_id", array(":id"=>$group_id, ":user_id"=>$user->user_id));
                    if($is_attending){
                        $data['group']['is_attending'] = true;
                    }
                    else{
                        $data['group']['is_attending'] = false;
                    }
                }else{
                    $data['group']['is_attending'] = false;
                }

                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false,'error_id'=>2);
                $this->renderJSON($data);
                return;
            }


        }



        //ERROR ID's
        // 1 - All data is not set
        // 2 - Club doesnt exist
        public function actionGetClassData(){
            if(!isset($_GET['class_id'])){
                $data = array('success'=>false,'error_id'=>1,'error_msg'=>'department_id not set');
                $this->renderJSON($data);
                return;
            }

            $class_id = $_GET['class_id'];
            //$user = User::model()->findAll(array("select"=>"user_email"));
            $class = ClassModel::model()->find("class_id=:class_id",array(":class_id"=>$class_id));

            if($class){

    //            $data = array('success'=>true,'class'=>$this->get_model_associations($class,array('students','admins')));

                $data = array('success'=>true,'class'=>$this->model_to_array($class));
                $data['class']['admins'] = $class->admins;
                $data['class']['students'] = $class->students;
                $data['class']['course'] = $class->course;
                $data['class']['professor'] = $class->professorUser;


                $user = $this->get_current_user($_GET);
                if($user) {
                    $is_attending = ClassUser::model()->find("class_id=:id and user_id=:user_id", array(":id"=>$class_id, ":user_id"=>$user->user_id));
                    if($is_attending){
                        $data['class']['is_attending'] = true;
                    }
                    else{
                        $data['class']['is_attending'] = false;
                    }
                }else{
                    $data['class']['is_attending'] = false;
                }

                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false,'error_id'=>2);
                $this->renderJSON($data);
                return;
            }


        }



        //ERROR ID's
        // 1 - All data is not set
        // 2 - Club doesnt exist
        public function actionGetCourseData(){
            if(!isset($_GET['course_id'])){
                $data = array('success'=>false,'error_id'=>1,'error_msg'=>'department_id not set');
                $this->renderJSON($data);
                return;
            }

            $course_id = $_GET['course_id'];
            //$user = User::model()->findAll(array("select"=>"user_email"));
            $course = Course::model()->find("course_id=:course_id",array(":course_id"=>$course_id));

            if($course){
                $data = array('success'=>true,'course'=>$this->get_model_associations($course,array('pictureFile'=>array(), 'department'=>array(), 'users'=>array('pictureFile'))));

                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false,'error_id'=>2);
                $this->renderJSON($data);
                return;
            }


        }



        //ERROR ID's
        // 1 - All data is not set
        // 2 - group doesnt exist
        public function actionGetClubFiles(){
            if(!isset($_GET['group_id'])){
                $data = array('success'=>false,'error_id'=>1,'error_msg'=>'department_id not set');
                $this->renderJSON($data);
                return;
            }

            $group_id = $_GET['group_id'];
            //$user = User::model()->findAll(array("select"=>"user_email"));
            $group = Group::model()->find("group_id=:group_id",array(":group_id"=>$group_id));
            if($group){
                $data = array('success'=>true,'files'=>$group->files);
                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false,'error_id'=>2);
                $this->renderJSON($data);
                return;
            }


        }


        //ERROR ID's
        // 1 - All data is not set
        // 2 - class doesnt exist
        public function actionGetClassFiles(){
            if(!isset($_GET['class_id'])){
                $data = array('success'=>false,'error_id'=>1,'error_msg'=>'class_id is not set');
                $this->renderJSON($data);
                return;
            }

            $class_id = $_GET['class_id'];
            //$user = User::model()->findAll(array("select"=>"user_email"));
            $class = ClassModel::model()->find("class_id=:class_id",array(":class_id"=>$class_id));
            if($class){
                $data = array('success'=>true,'files'=>$class->files);
                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false,'error_id'=>2);
                $this->renderJSON($data);
                return;
            }


        }

        //ERROR ID's
        // 1 - All data is not set
        public function actionGetUniversityData(){
            if(!isset($_GET['university_id'])){
                $data = array('success'=>false,'error_id'=>1,'error_msg'=>'university_id not set');
                $this->renderJSON($data);
                return;
            }

            $university_id = $_GET['university_id'];
            //$user = User::model()->findAll(array("select"=>"user_email"));
            $university = university::model()->find("university_id=:university_id",array(":university_id"=>$university_id));


            $schools = array();
            foreach($university->schools as $school){
                array_push($schools,array('school_name'=>$school->school_name,'school_id'=>$school->school_id));
            }


            //$data = array('success'=>true,'university'=>$this->get_model_associations($university,array('pictureFile','coverFile')),'schools'=>$schools);
            $data = array('success'=>true,'university'=>$university,'schools'=>$schools);


            $this->renderJSON($data);
            return;
        }



        //Checks to see if we support the current univ edu email
        //ERROR ID's
        // 1 - All data is not set
        // 2 - Not a valid nyu email
        public function actionGetUniversityDataByEmail() {

            if(!isset($_POST['email'])){
                $data = array('success'=>false,'error_id'=>1,'error'=>'email not set');
                $this->renderJSON($data);
                return;
            }

            $email = $_POST['email'];

            if(strpos($email,'nyu.edu') > 0){
                //Get univeristy id from a table of university_id   and   @univ.edu  (the schools email pattern)
                $university = University::model()->find('university_id=:university_id',array(':university_id'=>1));

                $base_url = Yii::app()->getBaseUrl(true);
                $data = array('success'=>true,'base_url'=>$base_url,'university'=> $this->get_model_associations($university,array('schools'=>array('departments'=>array(),))));


                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false,'error_id'=>2,'error'=>'Only NYU email addresses are supported at this time');
                $this->renderJSON($data);
                return;
            }


        }

        //https://urlinq.com/api/login
        //ERROR ID's
        // 1 - all data is not set
public function actionLogin() {

    try {

            if(!isset($_POST['email']) || !isset($_POST['password'])){
                $data = array('success'=>false,'error'=>'email or password is not set');
                $this->renderJSON($data);
                return;
            }

            $email = $_POST['email'];
            $password = $_POST['password'];

            $data = $this->login($email,$password);
            $this->renderJSON($data);
        
        } catch(Exception $e){ 
                $data = array('success'=>false,'error_id'=>2,'error'=>$e->getMessage());
                $this->renderJSON($data);
                return;

    }

}




        //ERROR ID's
        // 1 - all data is not set
        // 2 - User doesnt exist
        public function actionValidToken(){
            if(!isset($_GET['email'])){
                $data = array('success'=>false,'error_id'=>1,'error'=>'email is not set');
                $this->renderJSON($data);
                return;
            }


            $email = $_GET['email'];

            $user = User::model()->find("user_email=:user_email",array(":user_email"=>$email));
            if($user){
                $current_datetime = date("Y-m-d H:i:s", time());
                $token = $user->token;

                if($token){
                    if($token->expires_at < $current_datetime){
                        $data = array('success'=>true,'status'=>'valid');
                        $this->renderJSON($data);
                        return;
                    }else{
                        $data = array('success'=>true,'status'=>'expired');
                        $this->renderJSON($data);
                        return;
                    }
                }else{
                    $data = array('success'=>true,'status'=>'not_verified');
                    $this->renderJSON($data);
                    return;
                }
            }else{
                $data = array('success'=>false,'error_id'=>2,'error'=>'User does not exist');
                $this->renderJSON($data);
                return;
            }
        }

        //Error ids
        // 1 - User with email does not exist
        public function actionOnboardStatus(){
            if(!isset($_POST['email'])){
                $data = array('success'=>false,'error'=>'email is not set');
                $this->renderJSON($data);
                return;
            }



            $email = $_POST['email'];
            $user = User::model()->find("user_email=:user_email",array(":user_email"=>$email));

            if($user){
                $data = array('success'=>true,'status'=>$user->status);
                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false,'error_id'=>1,'error'=>'User with email ' . $email . ' doesnt exist');
                $this->renderJSON($data);
                return;
            }



        }


        //Error ID's for login
        // 1 - User with email doesnt exist in our database
        // 2 - User is not 'active' which means they have not verified their email address
        // 3 - Credentials are incorrect
        public function login($email,$password){
            $user = User::model()->find("user_email=:user_email",array(":user_email"=>$email));

            if($user){

                if($user->status != 'active'){
                    return array('success'=>false,'error_id'=>2,'error'=>'User is not active so they cannot login');
                    //$this->renderJSON($data);
                    //return;
                }


                $user_token = UserToken::model()->find('user_id=:user_id',array(':user_id'=>$user->user_id));
                if($user_token){
                    $user_token->delete();
                }


                include_once 'UniqueTokenGenerator.php';
                include_once "password_encryption.php";
                $user_login = UserLogin::model()->find('user_id=:user_id',array(':user_id'=>$user->user_id));

                $salt = $user_login->salt;
                $hashed_password = hash_password($password,$salt);



                if($user_login->password == $hashed_password){ //user has successfully logged in
                    //Generate the token
                    $token = generateUniqueToken($user->user_id, $email);

                    //Save token to database
                    $user_token = new UserToken;
                    $user_token->user_id = $user->user_id;
                    $user_token->token = $token;
                    $user_token->expires_at = date("Y-m-d H:i:s",strtotime("+1 week"));
                    $user_token->save(false);

                    return array('success'=>true,'user_id'=>$user->user_id,'token'=>$token,'expires_at'=>$user_token->expires_at);
                    //$this->renderJSON($data);

                }else{ //user login failed
                    return array('success'=>false,'error_id'=>3,'error'=>'user password not correct');
                    //$this->renderJSON($data);

                }

            }else{
                return array('success'=>false,'error_id'=>1,'error'=>'user with email: ' . $email . ' doesnt exist');
                //$this->renderJSON($data);
                //return;
            }
        }


        //api/attendClass
        public function actionAttendCourses()
        {
            $user_id = $_GET['user_id'];
            $token = $_GET['token'];

            $this->render('userCourses');
        }

        //api/FollowDepartment

        //api/AttendClub

        // api/followUser
        public function actionFollowUser(){
            $user_id = $_POST['user_id'];
            $followed_user_id = $_POST['followed_user_id'];
            $toke = $_POST['token'];
        }

        // api/unfollowUser
        public function actionUnfollowUser(){
            $user_id = $_POST['user_id'];
            $unfollowed_user_id = $_POST['unfollowed_user_id'];
            $toke = $_POST['token'];
        }



        //EVENTS

        public function actionGetEventAttendees(){
            //$user = $this->get_current_user();
            $event_id = $_GET['event_id'];
            //$date = $_GET['date'];
            //user_id=:user_id AND  //':user_id'=>1,
            $event = Event::model()->find('event_id=:event_id',array('event_id'=>$event_id));

            //$attendees = $event->attendees;


            //$data = array('success'=>true,'attendees'=>$attendees);

            $data = array('success'=>true,'attendees'=>$event->attendees);

            $this->renderJSON($data);
            return;

        }

        public function actionGetUserDayEvents(){
            if(!isset($_GET['user_id']) || !isset($_GET['date'])){
                $data = array('success'=>false,'error_id'=>1,'error'=>'email is not set');
                $this->renderJSON($data);
                return;
            }


            $user_id = $_GET['user_id'];
            $date = $_GET['date'];
            try{
                $events = Event::model()->findAll('start_date<=:date and end_date>=:date and user_id=:user_id',array(':date'=>$date,':user_id'=>$user_id));


                if($events){
                    $events_data = array();
                    foreach($events as $event){
                        $event = $this->model_to_array($event);
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

                        $event_attending = EventUser::model()->find("user_id=:user_id and event_id=:event_id", array(":user_id"=>$user_id, ":event_id"=>$event['event_id']));
                        if($event_attending){
                            $event['is_attending'] = true;
                        }
                        else{
                            $event['is_attending'] = false;
                        }
                        array_push($events_data,$event);
                    }

                    $data = array('success'=>true,'events'=>$events_data);
                    $this->renderJSON($data);
                    return;
                }else{
                    $data = array('success'=>true,'events'=>array());
                    $this->renderJSON($data);
                    return;
                }
            }catch(Exception $e){
                $data = array('success'=>false,'error_id'=>2,'error_msg'=>$e->getMessage());
                $this->renderJSON($data);
                return;
            }

        }

        public function actionAttendEvent(){
            if(!isset($_POST['event_id']) || !isset($_POST['user_id'])){
                $data = array('success'=>false,'error_id'=>1, 'error_msg'=>'required data not set');
                $this->renderJSON($data);
                return;
            }

            $user_id = $_POST['user_id'];
            $event_id = $_POST['event_id'];

            $event_user = EventUser::model()->find('event_id=:id and user_id=:user_id', array(':id'=>$event_id,':user_id'=>$user_id));
            //Check if this user is already a member for this class
            if(!$event_user){
                //Create new class user
                $event_user_new = new EventUser();
                $event_user_new->event_id = $event_id;
                $event_user_new->user_id = $user_id;
                //If we save successfully, user is now apart of class
                if($event_user_new->save(false)){
                    $data = array('success'=>true);
                    $this->renderJSON($data);
                    return;
                }else{
                    $data = array('success'=>false,'error_id'=>3, 'error_msg'=>'error saving event_user table');
                    $this->renderJSON($data);
                    return;
                }
            }else{
                //user is apart of this class
                $data = array('success'=>false,'error_id'=>2, 'error_msg'=>'user already attending the class');
                $this->renderJSON($data);
                return;
            }

        }

        public function actionUnattendEvent(){
            if(!isset($_POST['event_id']) || !isset($_POST['user_id'])){
                $data = array('success'=>false,'error_id'=>1, 'error_msg'=>'required data not set');
                $this->renderJSON($data);
                return;
            }

            $user_id = $_POST['user_id'];
            $event_id = $_POST['event_id'];

            $event_user = EventUser::model()->find('event_id=:id and user_id=:user_id', array(':id'=>$event_id,':user_id'=>$user_id));
            //Check if this user is even in this class
            if($event_user){
                //Check if we destroy this shit successfully
                if($event_user->delete()){
                    $data = array('success'=>true);
                    $this->renderJSON($data);
                    return;
                }else{
                    $data = array('success'=>false,'error_id'=>3, 'error_msg'=>'error deleting event_user table');
                    $this->renderJSON($data);
                    return;
                }
            }else{
                //user is not apart of this class
                $data = array('success'=>false,'error_id'=>2, 'error_msg'=>'user not attending event');
                $this->renderJSON($data);
                return;
            }
        }


        public function actionGetUserWeekEvents(){
            if(!isset($_GET['user_id']) || !isset($_GET['date'])){
                $data = array('success'=>false,'error_id'=>1,'error'=>'email is not set');
                $this->renderJSON($data);
                return;
            }

            $user_id = $_GET['user_id'];
            $date = $_GET['date'];

            $date = date($date . " 00:00:00", time());
            $datetime = new DateTime($date);
            $date = $datetime->format('Y-m-d');

            $data = array();
            for ($i = 1; $i <= 7; $i++) {
                $events = Event::model()->findAll('start_date<=:date and end_date>=:date and user_id=:user_id',array(':date'=>$date,':user_id'=>$user_id));
                $events_data = array();
                if($events) {
                    foreach ($events as $event) {
                        $event = $this->model_to_array($event);
                        $origin = $event['origin_type'];
                        $origin_id = $event['origin_id'];
                        if ($origin != 'user') {
                            $sql = "SELECT " . $origin . '_name, color_id FROM `' . $origin . '`  WHERE ' . $origin . '_id = ' . $origin_id;
                            $command = Yii::app()->db->createCommand($sql);
                            $origin_data = $command->queryRow();
                            //echo json_encode($origin_data);
                            $event['origin_name'] = $origin_data[$origin . '_name'];
                            $event['origin_color_id'] = $origin_data['color_id'];
                            //array_push($events_data,$event);
                        } else {
                            $event['origin_name'] = null;
                            $event['origin_color_id'] = null;
                        }

                        $event_attending = EventUser::model()->find("user_id=:user_id and event_id=:event_id", array(":user_id"=>$user_id, ":event_id"=>$event['event_id']));
                        if($event_attending){
                            $event['is_attending'] = true;
                        }
                        else{
                            $event['is_attending'] = false;
                        }

                        array_push($events_data, $event);
                    }
                }
                $data['events'][$date] = $events_data;
                $datetime->modify('+1 day');
                $date = $datetime->format('Y-m-d');
            }

            $data['success'] = true;
            $this->renderJSON($data);
            return;
    //
    //        try{
    //            $events = Event::model()->findAll('start_date<=:date and end_date>=:date and user_id=:user_id',array(':date'=>$date,':user_id'=>$user_id));
    //            if($events){
    //                $data = array('success'=>true,'events'=>$events);
    //                $this->renderJSON($data);
    //                return;
    //            }else{
    //                $data = array('success'=>true,'events'=>array());
    //                $this->renderJSON($data);
    //                return;
    //            }
    //        }catch(Exception $e){
    //            $data = array('success'=>false,'error_id'=>2);
    //            $this->renderJSON($data);
    //            return;
    //        }
        }


        public function actionUploadCoverPhoto(){
            if(!isset($_POST['origin_type']) || !isset($_POST['origin_id']) || !isset($_FILES['file'])){
                $data = array('success'=>false,'error_id'=>1,'error'=>'data is not set');
                $this->renderJSON($data);
                return;
            }

            $user = $this->get_current_user($_POST);
            if(!$user){
                $data = array('success'=>false,'error_id'=>2,'error'=>'user is not logged in');
                $this->renderJSON($data);
                return;
            }



            $origin_type = $_POST['origin_type'];
            $origin_id = $_POST['origin_id'];


            if($origin_type == 'class'){
                $class = ClassModel::model()->find('class_id=:id',array(":id"=>$origin_id));

                if(!$class){
                    $data = array('success'=>false,'error_id'=>3,'error'=>'invalid class');
                    $this->renderJSON($data);
                    return;
                }

                //If this user is not the professor, make sure he is an admin
                if($user->user_id != $class->professor_id){
                    $class_user = ClassUser::model()->find('user_id=:user_id and class_id=:class_id', array(':user_id'=>$user->user_id, ':class_id'=>$origin_id));
                    if(!$class_user){
                        $data = array('success'=>false,'error_id'=>3,'error'=>'user is not a member of this class');
                        $this->renderJSON($data);
                        return;
                    }

                    if(!$class_user->is_admin){
                        $data = array('success'=>false,'error_id'=>4,'error'=>'User is not authorized to upload a photo to this class');
                        $this->renderJSON($data);
                        return;
                    }
                }


                //User is now forsure an admin. Upload the photo
                $file_data = $this->upload_cover_file($origin_type, $origin_id, $_FILES);
                if($file_data['success']){
    //                $class_file = $class->coverFile;
    //                if($class_file){
    ////                    $local_directory = $class_file->file_url;
    ////                    unlink($local_directory);
    ////                    //Delete the old file
    //                    $class_file->delete();
    //                }


                    //Assign this file id as the new cover id
                    $class->picture_file_id = $file_data['file_id'];
                    $class->cover_file_id = $file_data['file_id'];
                    $class->save(false);

                    $data = array('success'=>true, 'file'=>$file_data);
                    $this->renderJSON($data);
                    return;
                }else{
                    $data = array('success'=>false, 'error_msg'=>'Error uploading class cover photo');
                    $this->renderJSON($data);
                    return;
                }
            }else if($origin_type == 'club' || $origin_type == 'group'){


                $group = Group::model()->find('group_id=:id',array(":id"=>$origin_id));

                if(!$group){
                    $data = array('success'=>false,'error_id'=>3,'error'=>'invalid group');
                    $this->renderJSON($data);
                    return;
                }


                $group_user = GroupUser::model()->find('user_id=:user_id and group_id=:group_id', array(':user_id'=>$user->user_id, ':group_id'=>$origin_id));
                if(!$group_user){
                    $data = array('success'=>false,'error_id'=>3,'error'=>'user is not a member of this group');
                    $this->renderJSON($data);
                    return;
                }

                if(!$group_user->is_admin){
                    $data = array('success'=>false,'error_id'=>4,'error'=>'User is not authorized to upload a photo to this group');
                    $this->renderJSON($data);
                    return;
                }



                //User is now forsure an admin. Upload the photo
                $file_data = $this->upload_cover_file($origin_type, $origin_id, $_FILES);
                if($file_data['success']){
    //                $group_file = $group->coverFile;
    //                if($group_file){
    ////                    $local_directory = $group_file->file_url;
    ////                    unlink($local_directory);
    ////                    //Delete the old file
    //                    $group_file->delete();
    //                }


                    //Assign this file id as the new cover id
                    $group->picture_file_id = $file_data['file_id'];
                    $group->cover_file_id = $file_data['file_id'];
                    $group->save(false);

                    $data = array('success'=>true, 'file'=>$file_data);
                    $this->renderJSON($data);
                    return;
                }else{
                    $data = array('success'=>false, 'error_msg'=>'Error uploading group cover photo');
                    $this->renderJSON($data);
                    return;
                }

            }else if($origin_type == 'department'){
                
                
                $department = Department::model()->find('department_id=:id',array(":id"=>$origin_id));

                if(!$department){
                    $data = array('success'=>false,'error_id'=>3,'error'=>'invalid department');
                    $this->renderJSON($data);
                    return;
                }


                if($user->department_id != $department->department_id){
                    $data = array('success'=>false,'error_id'=>6,'error'=>'user is not a member of this department');
                    $this->renderJSON($data);
                    return;
                }

                if($user->user_type != 'a' && $user->user_type != 'p'){
                    $data = array('success'=>false,'error_id'=>7,'error'=>'user is not an admin');
                    $this->renderJSON($data);
                    return;
                }



                //User is now forsure an admin. Upload the photo
                $file_data = $this->upload_cover_file($origin_type, $origin_id, $_FILES);
                if($file_data['success']){
    //                $department_file = $department->coverFile;
    //                if($department_file){
    ////                    $local_directory = $department_file->file_url;
    ////                    unlink($local_directory);
    ////                    //Delete the old file
    //                    $department_file->delete();
    //               }


                    //Assign this file id as the new cover id
                    $department->picture_file_id = $file_data['file_id'];
                    $department->cover_file_id = $file_data['file_id'];
                    $department->save(false);

                    $data = array('success'=>true, 'file'=>$file_data);
                    $this->renderJSON($data);
                    return;
                }else{
                    $data = array('success'=>false, 'error_msg'=>'Error uploading department cover photo');
                    $this->renderJSON($data);
                    return;
                }

            }else if($origin_type == 'school'){

            }






        }


        function upload_cover_file($origin_type, $origin_id, $files){
            include_once "file_upload.php";
            $local_directory = $origin_type . '/' . $origin_id . '/';
            $data = file_upload($files,$local_directory);
            return $data;
        }

        public function actionGetUserMonthEvents(){
            if(!isset($_GET['user_id']) || !isset($_GET['date'])){
                $data = array('success'=>false,'error_id'=>1,'error'=>'email is not set');
                $this->renderJSON($data);
                return;
            }

            $user_id = $_GET['user_id'];
            $date = $_GET['date'];

            $date = date($date . " 00:00:00", time());
            $datetime = new DateTime($date);
            $date = $datetime->format('Y-m-d');

            $data = array();
            for ($i = 1; $i <= 31; $i++) {
                $events = Event::model()->findAll('start_date<=:date and end_date>=:date and user_id=:user_id',array(':date'=>$date,':user_id'=>$user_id));
                $events_data = array();
                if($events) {
                    foreach ($events as $event) {
                        $event = $this->model_to_array($event);
                        $origin = $event['origin_type'];
                        $origin_id = $event['origin_id'];
                        if ($origin != 'user') {
                            $sql = "SELECT " . $origin . '_name, color_id FROM `' . $origin . '`  WHERE ' . $origin . '_id = ' . $origin_id;
                            $command = Yii::app()->db->createCommand($sql);
                            $origin_data = $command->queryRow();
                            //echo json_encode($origin_data);
                            $event['origin_name'] = $origin_data[$origin . '_name'];
                            $event['origin_color_id'] = $origin_data['color_id'];
                            //array_push($events_data,$event);
                        } else {
                            $event['origin_name'] = null;
                            $event['origin_color_id'] = null;
                        }

                        $event_attending = EventUser::model()->find("user_id=:user_id and event_id=:event_id", array(":user_id"=>$user_id, ":event_id"=>$event['event_id']));
                        if($event_attending){
                            $event['is_attending'] = true;
                        }
                        else{
                            $event['is_attending'] = false;
                        }


                        array_push($events_data, $event);
                    }
                }
                $data['events'][$date] = $events_data;
                $datetime->modify('+1 day');
                $date = $datetime->format('Y-m-d');
            }

            $data['success'] = true;
            $this->renderJSON($data);
            return;

        }


        function send_verification_email($to_email, $subject, $message, $from_email, $data){

            $mail = new YiiMailer('confirmation', $data);

            $mail->setFrom($from_email, 'urlinq team');
            $mail->setSubject($subject);
            $mail->setTo($to_email);


            //$mail->SMTPDebug = 1;

            return $mail->send();

    //        if($mail->send()){
    //            return true;
    //        }else{
    //            $data = array('success'=>false,'error_id'=>6,'error_msg'=>$mail->getError());
    //            $this->renderJSON($data);
    //            return;
    //        }

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