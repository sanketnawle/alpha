<?php

class UserController extends Controller
{
	public function actionView()
	{
		$this->render('view');
	}




    public function actionFollow()
    {
        if(!isset($_POST['user_id'])){
            $data = array('success'=>false,'error_id'=>1);
            $this->renderJSON($data);
            return;
        }
        $current_user_id = null;
        if(isset($_POST['from_user_id'])){
            $current_user_id = $_POST['from_user_id'];
        }else {
            $current_user_id = $this->get_current_user_id();
        }
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






    public function actionUnfollow()
    {
        if(!isset($_POST['user_id'])){
            $data = array('success'=>false,'error_id'=>1);
            $this->renderJSON($data);
            return;
        }

        $current_user_id = $this->get_current_user_id();
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



    //Get the classes which this user is a professor for
    //returns error if user is not a professor
    public function actionGetClassesProfessor(){
        $user = $this->get_current_user();
        if(!$user){
            $data = array('success'=>false, 'error_id'=>1);
            $this->renderJSON($data);
            return;
        }

        if($user->user_type != 'p'){
            $data = array('success'=>false, 'error_id'=>2, 'error_msg'=>'user is not a professor');
            $this->renderJSON($data);
            return;
        }


        $classes = ClassModel::model()->findAll('professor_id=:id', array(':id'=>$user->user_id));

        for($i = 0;$i < count($classes); $i++){
            $classes[$i] = $this->get_model_associations($classes[$i],array('pictureFile'=>array(), 'course'=>array('pictureFile'), 'department'=>array('pictureFile')));
        }

        $data = array('success'=>true,'classes'=>$classes);
        $this->renderJSON($data);
        return;


    }

    //Returns people this user should follow
    public function actionGetSuggestedUsers(){



        $user = $this->get_current_user();

        if(!$user){
            $data = array('success'=>false, 'error_id'=>1);
            $this->renderJSON($data);
            return;
        }


//        $users = $this->models_to_array(User::model()->findAllBySql('SELECT * FROM `user` WHERE department_id = ' . $user->department_id . ' AND user_id != ' . $user->user_id . ' LIMIT 10'));
//
//
//
//        if(count($users) < 1){
//            array_merge($users,$this->models_to_array(User::model()->findAllBySql('SELECT * FROM `user` WHERE school_id = ' . $user->school_id . ' AND user_id != ' . $user->user_id . ' LIMIT 10')));
//        }
//
//        if(count($users) < 1){
//            array_merge($users,));
//        }


        $users = $this->models_to_array(User::model()->findAllBySql('SELECT * FROM `user` WHERE user_id != ' . $user->user_id . ' LIMIT 10'));
        $data = array('success'=>true,'users'=>$users);
        $this->renderJSON($data);
        return;
    }

    public function actionNotifications(){
        $user = $this->get_current_user($_GET);
        if($user) {
            $notifications = Notification::model()->findAll("user_id=:user_id", array(":user_id" => $user->user_id));
            if ($notifications) {
                $notifications_new = array();
                foreach ($notifications as $notification) {
                    $notification = $this->model_to_array($notification);
                    $origin = $notification['origin_type'];
                    $origin_id = $notification['origin_id'];
                    $actor_id = $notification['actor_id'];

                    if($origin == '' || !$origin_id || !$actor_id){
                        $data = array('success'=>false,'error_id'=>2,'error_msg'=>'origin type or id not set');
                        $this->renderJSON($data);
                        return;
                    }

                    $actor = User::model()->find("user_id=:user_id", array(":user_id"=>$actor_id));
                    if(!$actor){
                        $data = array('success'=>false,'error_id'=>2,'error_msg'=>'actor doesnt exist');
                        $this->renderJSON($data);
                        return;
                    }

                    $notification['actor'] = $this->get_model_associations($actor,array('department'=>array(),'school'=>array('university'),'groups'=>array(),'classes'=>array()));

                    if($origin == 'event'){
                        $event = Event::model()->find("event_id=:event_id", array(":event_id"=>$origin_id));
                        if(!$event){
                            $data = array('success'=>false,'error_id'=>2,'error_msg'=>'related thing doesnt exist');
                            $this->renderJSON($data);
                            return;
                        }

                        $event = $this->model_to_array($event);
                        $origin_event = $event['origin_type'];
                        $origin__event_id = $event['origin_id'];

                        if($origin != 'user'){
                            $sql = "SELECT " . $origin_event . '_name, color_id FROM `' . $origin_event . '`  WHERE ' . $origin_event . '_id = ' . $origin__event_id;
                            $command = Yii::app()->db->createCommand($sql);
                            $origin_data = $command->queryRow();
                            //echo json_encode($origin_data);
                            $event['origin_name'] = $origin_data[$origin_event . '_name'];
                            $event['origin_color_id'] = $origin_data['color_id'];
                            //array_push($events_data,$event);
                        }else{
                            $event['origin_name'] = null;
                            $event['origin_color_id'] = null;
                        }

                        $event_attending = EventUser::model()->find("user_id=:user_id and event_id=:event_id", array(":user_id"=>$user->user_id, ":event_id"=>$event['event_id']));
                        if($event_attending){
                            $event['is_attending'] = true;
                        }
                        else{
                            $event['is_attending'] = false;
                        }

                        $notification['origin'] = $event;
                    }
                    elseif($origin == 'follow'){
                        $follow = User::model()->find("user_id=:user_id", array(":user_id"=>$origin_id));

                        if(!$follow){
                            $data = array('success'=>false,'error_id'=>2,'error_msg'=>'related thing doesnt exist');
                            $this->renderJSON($data);
                            return;
                        }
                        $notification['origin'] = $this->get_model_associations($follow,array('department'=>array(),'school'=>array('university'),'groups'=>array(),'classes'=>array()));
                    }
                    elseif($origin == 'reply'){
                        $reply = Reply::model()->find("reply_id=:reply_id", array(":reply_id"=>$origin_id));
                        if(!$reply){
                            $data = array('success'=>false,'error_id'=>2,'error_msg'=>'related thing doesnt exist');
                            $this->renderJSON($data);
                            return;
                        }

                        $post = Post::model()->find("post_id=:post_id", array(":post_id"=>$reply->post_id));
                        $reply=$this->model_to_array($reply);
                        $reply['post']=$post;
                        $notification['origin']= $reply;
                    }
                    elseif($origin == 'liked'){
                        $post = Post::model()->find("post_id=:post_id", array(":post_id"=>$origin_id));
                        if(!$post){
                            $data = array('success'=>false,'error_id'=>2,'error_msg'=>'related thing doesnt exist');
                            $this->renderJSON($data);
                            return;
                        }

                        $notification['origin'] = $post;
                    }
                    else{
                        $data = array('success'=>false,'error_id'=>2,'error_msg'=>'database doesnt support this kind of notification');
                        $this->renderJSON($data);
                        return;
                    }
                    array_push($notifications_new, $notification);
                }
                $data = array('success'=>true,'notifications'=>$notifications_new);
                $this->renderJSON($data);
                return;

            } else {
                $data = array('success'=>true,'notifications'=>array());
                $this->renderJSON($data);
                return;
            }
        }
        else{
            $data = array('success'=>false,'error_id'=>2,'error_msg'=>'user doesnt exist');
            $this->renderJSON($data);
            return;
        }
    }

    public function actionReminders(){
        $user = $this->get_current_user($_GET);
        if($user){
            $event_users = EventUser::model()->findAll("user_id=:user_id", array(":user_id"=>$user->user_id));
            $events = array();
            foreach($event_users as $event_user){
                $event_user = Event::model()->find("event_id=:id", array(":id"=>$event_user->event_id));
                if($event_user){
                    array_push($events, $event_user);
                }
            }
            if(!$events){
                $data = array('success'=>true,'reminders'=>array());
                $this->renderJSON($data);
                return;
            }
            $events_new = array();
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

                $event_attending = EventUser::model()->find("user_id=:user_id and event_id=:event_id", array(":user_id"=>$user->user_id, ":event_id"=>$event['event_id']));
                if($event_attending){
                    $event['is_attending'] = true;
                }
                else{
                    $event['is_attending'] = false;
                }

                $date = date($event['start_date'] . " 00:00:00", time());
                $datetime = new DateTime($date);
                $date = $datetime->format('Y-m-d');

                $today = date('Y-m-d');

                $datetime->modify('-5 days');
                $five_days = $datetime->format('Y-m-d');

                if($event['event_type'] == 'exam'){
                    if($five_days < $today){
                        array_push($events_new, $event);
                    }
                }
                else{
                    if($date == $today){
                        array_push($events_new, $event);
                    }
                }

            //array_push($events_new, $event);
            }
            $data = array('success'=>true,'reminders'=>$events_new);
            $this->renderJSON($data);
            return;

        }
        else{
            $data = array('success'=>false,'error_id'=>2,'error_msg'=>'user doesnt exist');
            $this->renderJSON($data);
            return;
        }

    }

    public function actionUploadProfileImage(){
        if (empty($_FILES)) {
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'class id not set', '_files'=>$_FILES,'_post'=>$_POST);
            $this->renderJSON($data);
            return;
        }

        $user = $this->get_current_user($_POST);
        if(!$user){
            $data = array('success'=>false,'error_id'=>2,'error_msg'=>'user doesnt exist');
            $this->renderJSON($data);
            return;
        }


        include_once 'file_upload.php';
        $local_directory = 'profile_pictures/';


        $data = file_upload($_FILES,$local_directory, $user->user_id);


        if($data['success']){
            $user->picture_file_id = $data['file_id'];
            if($user->save(false)){
                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false,'error_id'=>4);
                $this->renderJSON($data);
                return;
            }
        }else{
            $data = array('success'=>false,'error_id'=>3);
            $this->renderJSON($data);
            return;
        }







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


    public function actionGetGroupData(){
//        if(!$this->authenticated()){
//            $this->redirect(array('/home'));
//        }

        $user = $this->get_current_user();


        if($user){



            $user_data = $this->get_model_associations($user,array('classes','groups'));



            for($i = 0;$i < count($user_data['classes']);++$i){
//                $class_user = ClassUser::model()->find('user_id=:user_id and class_id=:class_id',array(':user_id'=>$user->user_id,':class_id'=>$classes[$i]['class_id']));
//                $color = Color::model()->find('color_id=:id',array(':id'=>$class_user->color_id));
//                $classes[$i]['color'] = array('hex'=>$color->hex);

                //$user_data['classes'][$i]['color'] = array('hex'=>'#FABBB3');

                //$user_data['classes'][$i] = array_merge($user_data['classes'][$i], array('color'=>array('hex'=>'#FABBB3')));

//                $data = array('success'=>true,'user'=>);
//                $this->renderJSON($data);
//                return;
                //$user_data['classes'][$i]['color'] = array('hex'=>'#FABBB3');
                //array_push($clubs[$i]['color'],array('hex'=>'#FABBB3'));


                //$classes[$i] = $this->array_push_assoc($classes[$i], 'color', array('hex'=>'#FABBB3'));


                $user_data['classes'][$i]['color'] = array('hex'=>'#FABBB3');
            }




            for($i = 0;$i < count($user_data['groups']);++$i){
//                $group_user = GroupUser::model()->find('user_id=:user_id and group_id=:group_id',array(':user_id'=>$user->user_id,':group_id'=>$clubs[$i]['group_id']));
//                $color = Color::model()->find('color_id=:id',array(':id'=>$group_user->color_id));
//                $clubs[$i]['color'] = array('hex'=>$color->hex);
//                array_push($clubs[$i],array('color'=>array('hex'=>'#FABBB3')));
                //$clubs[$i] = array('hex'=>'#FABBB3');
                //$clubs[$i] = $this->array_push_assoc($clubs[$i], 'color', array('hex'=>'#FABBB3'));
                //$user_data['groups'][$i] = array_merge($user_data['groups'][$i], array('color'=>array('hex'=>'#FABBB3')));


                $user_data['groups'][$i]['color'] = array('hex'=>'#FABBB3');
            }



            $data = array('success'=>true,'user'=>$user_data,'classes'=>$user_data['classes'],'clubs'=>$user_data['groups'], 'groups'=>array());
            $this->renderJSON($data);
            return;
        }else{
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'error getting user');
            $this->renderJSON($data);
            return;
        }


    }
    public function actionGroupSuggestions(){
        $user = $this->get_current_user();
        if(!($user->school)){
            $this->renderJSON(array('success'=>false,'message'=>'user does not have school'));
            return;
        }
        if($_GET['suggestion_type'] === "university_wide_suggestions"){
            $university = $user->school->university;
            $department = $user->department;
            if(isset($_GET['previous_class_id']) && isset($_GET['previous_club_id_2'])
                && isset($_GET['previous_club_id_1'])){
                //to generate a random class, first we get the count

                $suggested_classes = ClassModel::model()->findAllBySql(
                    'select c.* from class c, school s
                where s.university_id='.$university->university_id.' and c.school_id=s.school_id

                and c.class_id !='.$_GET['previous_class_id'].'
                and (c.department_id in (select department_id from department where department_name = "'
                    .$department->department_name.'") or c.school_id = '.$user->school_id.')
                and not exists (select * from class_user where class_id = c.class_id
                    and user_id='.$user->user_id.') order by rand() limit 1');
                $suggested_clubs = Group::model()->findAllBySql(
                    'select g.* from `group` g, school s
                where s.university_id='.$university->university_id.' and g.school_id=s.school_id
                 and g.group_id !='.$_GET['previous_club_id_1'].'
                 and g.group_id !='.$_GET['previous_club_id_2'].'
                 and not exists (select * from group_user where group_id = g.group_id
                    and user_id='.$user->user_id.') ORDER BY rand() limit 2');
            }else{
                $suggested_classes = ClassModel::model()->findAllBySql(
                    'select c.* from class c, school s
                where s.university_id='.$university->university_id.'
                and c.school_id=s.school_id
                and (c.department_id in (select department_id from department where department_name = "'
                    .$department->department_name.'") or c.school_id = '.$user->school_id.')
                 and not exists
                (select * from class_user where class_id = c.class_id
                    and user_id='.$user->user_id.') order by rand() limit 1');
                $suggested_clubs = Group::model()->findAllBySql(
                    'select g.* from `group` g, school s
                where s.university_id='.$university->university_id.' and
                g.school_id=s.school_id and not exists
                (select * from group_user where group_id = g.group_id
                    and user_id='.$user->user_id.') ORDER BY rand() limit 2');
            }


        }else if($_GET['suggestion_type'] === "user_school_specific_suggestions"){
            $school =  $user->school;
            if(isset($_GET['previous_class_id_1']) && isset($_GET['previous_class_id_2'])
                && isset($_GET['previous_club_id'])){
                $suggested_classes = ClassModel::model()->findAllBySql(
                    'select c.* from class c
                where c.school_id='.$school->school_id.' and c.class_id !='.$_GET['previous_class_id_1'].'
                and c.class_id !='.$_GET['previous_class_id_2'].'
                and c.department_id = '.$user->department_id.'
                and not exists (select * from class_user where class_id = c.class_id
                    and user_id='.$user->user_id.') ORDER BY rand() limit 1');
                $suggested_clubs = Group::model()->findAllBySql(
                    'select g.* from `group` g
                where g.school_id='.$school->school_id.' and g.group_id !='.$_GET['previous_club_id'].'
                and not exists (select * from group_user where group_id = g.group_id
                    and user_id='.$user->user_id.') ORDER BY rand() limit 2');
            }else{
                $suggested_classes = ClassModel::model()->findAllBySql(
                    'select c.* from class c
                where c.school_id='.$school->school_id.'
                and c.department_id = '.$user->department_id.'
                and not exists (select * from class_user where class_id = c.class_id
                    and user_id='.$user->user_id.') ORDER BY rand() limit 1');
                $suggested_clubs = Group::model()->findAllBySql(
                    'select g.* from `group` g
                where g.school_id='.$school->school_id.' and not exists
                (select * from group_user where group_id = g.group_id
                    and user_id='.$user->user_id.') ORDER BY rand() limit 2');
            }
        }else{
            $this->renderJSON(array('success'=>false,'message'=>'invalid suggestion_type'));
        }

        $result = array('clubs'=>array());

        //grab a random row from suggested_classes
        $class_count = sizeof($suggested_classes);
        $class = $suggested_classes[rand(0,$class_count-1)];

        $result['class']['picture'] = ($class->pictureFile) ?
            Yii::app()->getBaseUrl(true).$class->pictureFile->file_url : Yii::app()->getBaseUrl(true).'/assets/default/class.png';
        $result['class']['is_group'] = true;
        $result['class']['has_members'] = sizeof($class->users) >0;
        $result['class']['member_count'] = sizeof($class->users);
        $result['class']['type'] = "group_suggestion";
        $result['class']['id'] = $class->class_id;
        $result['class']['link'] = ' href='.Yii::app()->getBaseUrl(true)."/class/".$class->class_id;
        if($class->course){
            $result['class']['title'] = $class->course->course_name;
        }

        foreach($suggested_clubs as $i=>$club){
            $result['clubs'][$i]['picture'] = ($club->pictureFile) ?
                Yii::app()->getBaseUrl(true).$club->pictureFile->file_url : Yii::app()->getBaseUrl(true).'/assets/default/club.png';
            $result['clubs'][$i]['is_group'] = true;
            $result['clubs'][$i]['type'] = "group_suggestion";
            $result['clubs'][$i]['has_members'] = sizeof($club->users) >0;
            $result['clubs'][$i]['member_count'] = sizeof($club->users);
            $result['clubs'][$i]['id'] = $club->group_id;
            $result['clubs'][$i]['title'] = $club->group_name;
            $result['clubs'][$i]['link'] = ' href='.Yii::app()->getBaseUrl(true)."/club/".$club->group_id.'';
        }
        $this->renderJSON($result);
    }
    public function actionUserSuggestions(){
        $user = $this->get_current_user();
        if(!($user->school)){
            $this->renderJSON(array('success'=>false,'message'=>'user does not have school'));
            return;
        }
        if($_GET['suggestion_type'] === "university_wide_suggestions"){
            $university = $user->school->university;
            if(isset($_GET['previous_user_id_1']) && isset($_GET['previous_user_id_2'])) {
                $suggested_users = User::model()->findAllBySql(
                    'select u.* from user u, school s
                where s.university_id=' . $university->university_id . ' and u.school_id=s.school_id
                and u.user_id !=' . $_GET['previous_user_id_1'] . '
                and u.user_id !=' . $_GET['previous_user_id_2'] . '
                and u.user_id !=' . $user->user_id . '
                and not exists
                (select * from user_connection where to_user_id = u.user_id
                    and from_user_id='.$user->user_id.') ORDER BY rand() limit 2');
            }else{
                $suggested_users = User::model()->findAllBySql(
                    'select u.* from user u, school s
                where s.university_id=' . $university->university_id . ' and u.school_id=s.school_id
                and u.user_id !=' . $user->user_id . '
                and not exists
                (select * from user_connection where to_user_id = u.user_id
                    and from_user_id='.$user->user_id.') ORDER BY rand() limit 2');
            }
        }else if($_GET['suggestion_type'] === "user_school_specific_suggestions"){
            $school =  $user->school;
            if(isset($_GET['previous_user_id_1']) && isset($_GET['previous_user_id_2'])) {
                $suggested_users = User::model()->findAllBySql(
                    'select u.* from user u
                where u.school_id=' . $school->school_id . ' and u.user_id !=' . $_GET['previous_user_id_1'] . '
                and u.user_id !=' . $_GET['previous_user_id_2'] . '
                 and u.user_id !=' . $user->user_id . ' and not exists
                (select * from user_connection where to_user_id = u.user_id
                    and from_user_id='.$user->user_id.') ORDER BY rand() limit 2');
            }else{
                $suggested_users = User::model()->findAllBySql(
                    'select u.* from user u
                where u.school_id=' . $school->school_id . '
                 and u.user_id !=' . $user->user_id . ' and not exists
                (select * from user_connection where to_user_id = u.user_id
                    and from_user_id='.$user->user_id.') ORDER BY rand() limit 2');
            }
        }else{
            $this->renderJSON(array('success'=>false,'message'=>'invalid suggestion_type '.$_GET['suggestion_type']));
        }

        $result = array();
        foreach($suggested_users as $i=>$suser){
            $result[$i]['picture'] = ($suser->pictureFile) ?
                Yii::app()->getBaseUrl(true).$suser->pictureFile->file_url : Yii::app()->getBaseUrl(true).'/assets/default/user.png';
            $result[$i]['is_group'] = false;
            $result[$i]['type'] = "user_suggestion";
            $result[$i]['id'] = $suser->user_id;
            $result[$i]['title'] = $suser->user_type=="p" ? "Professor ".$suser->lastname : $suser->firstname.' '.$suser->lastname;
            $result[$i]['profile_link']=" profile_link";
            $result[$i]['profile_user_id'] = " user_id=".$suser->user_id;
        }
        $this->renderJSON($result);
    }


}