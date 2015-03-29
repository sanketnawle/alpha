<?php

class ClubController extends Controller
{





//$get_group_header_query = "SELECT g.group_id, g.univ_id, g.group_name, g.website, g.dp_blob_id, g.cover_blob_id FROM groups g
//    WHERE g.group_id = ?";
//$get_group_header_stmt = $con->prepare($get_group_header_query);
//if($get_group_header_stmt != null) {
//$get_group_header_stmt->bind_param("i",$group);
//$get_group_header_stmt->execute();
//$get_group_header_stmt->bind_result($group_id, $univ_id, $group_name, $website, $dp_blob, $cover_blob);
//$get_group_header_stmt->fetch();
//$get_group_header_stmt->close();
//}
//
//$get_group_header_query = "SELECT count(*) as user_count FROM group_users WHERE group_id = ?";
//$get_group_header_stmt = $con->prepare($get_group_header_query);
//if($get_group_header_stmt != null) {
//    $get_group_header_stmt->bind_param("i",$group);
//    $get_group_header_stmt->execute();
//    $get_group_header_stmt->bind_result($user_count);
//    $get_group_header_stmt->fetch();
//    $get_group_header_stmt->close();
//}
//
//$get_group_header_query = "SELECT count(*) as file_count FROM posts p JOIN groups_files gf on (p.target_id = gf.group_id) WHERE
//    ((p.target_type = 'groups' and p.file_id is not null and p.target_id = ?) or gf.group_id = ?)";
//$get_group_header_stmt = $con->prepare($get_group_header_query);
//if($get_group_header_stmt != null) {
//    $get_group_header_stmt->bind_param("ii",$group,$group);
//    $get_group_header_stmt->execute();
//    $get_group_header_stmt->bind_result($file_count);
//    $get_group_header_stmt->fetch();
//    $get_group_header_stmt->close();
//}
//
//$get_group_header_query = "SELECT count(*), is_admin FROM group_users WHERE group_id = ? and user_id = ?";
//$get_group_header_stmt = $con->prepare($get_group_header_query);
//if($get_group_header_stmt != null) {
//    $get_group_header_stmt->bind_param("ii",$group,$user_id);
//    $get_group_header_stmt->execute();
//    $get_group_header_stmt->bind_result($is_member, $is_admin);
//    $get_group_header_stmt->fetch();
//    $get_group_header_stmt->close();



	public function actionView()
	{




        $club_id = $_GET['id'];


        $club = Group::model()->find('group_id=:id', array(':id'=>$club_id));

        $user = $this->get_current_user();

        if(!$user){
            $this->redirect(array('/?url=/club/' . $club_id));
        }

        $group_user = GroupUser::model()->find('group_id=:group_id and user_id=:user_id', array(':group_id'=>$club->group_id, ':user_id'=>$user->user_id));

        $is_member = false;
        $is_admin = false;
        if($group_user){
            $is_member = true;
            if($group_user->is_admin){
                $is_admin = true;
            }
        }


        if($this->is_urlinq_admin($user)){
            $is_admin = true;
        }


//        if(strpos($user->user_email,'@urlinq.com') !== false){
//            $is_admin = true;
//        }



        if($club->privacy && (!$is_member)){
            //user cannot see this page
            $this->redirect(array('/home'));
        }


        if($is_member && isset($_GET['event_id']) && isset($_GET['option'])){
            $this->check_event_option($user,$_GET);
        }

        if(isset($_GET['question_option_id'])){
            $this->check_question_option($user,$_GET);
        }


        $file_count = 5;

        $sql = "SELECT u.user_id, u.user_type, u.firstname, u.lastname, un.school_name from `user_connection` c, user u, school un where c.from_user_id = " . $user->user_id . " AND c.to_user_id = u.user_id and un.school_id = u.school_id AND u.status = 'active'";



        $command = Yii::app()->db->createCommand($sql);
        $connected_users = $command->queryAll();




        $this->render('club',array('club'=>$club,'user'=>$user,'is_admin'=>$is_admin,'file_count'=>$file_count,'is_member'=>$is_member,'connected_users'=>$connected_users  ));
	}




    public function actionTest2()
	{

        Yii::app()->nodeSocket->registerClientScripts();


        $club_id = 1;


        $club = Group::model()->find('group_id=:id', array(':id'=>$club_id));

        $user = $this->get_current_user();

        if(!$user){
            $this->redirect(array('/?url=/club/' . $club_id));
        }

        $group_user = GroupUser::model()->find('group_id=:group_id and user_id=:user_id', array(':group_id'=>$club->group_id, ':user_id'=>$user->user_id));

        $is_member = false;
        $is_admin = false;
        if($group_user){
            $is_member = true;
            if($group_user->is_admin){
                $is_admin = true;
            }
        }


        if($this->is_urlinq_admin($user)){
            $is_admin = true;
        }


//        if(strpos($user->user_email,'@urlinq.com') !== false){
//            $is_admin = true;
//        }



        if($club->privacy && (!$is_member)){
            //user cannot see this page
            $this->redirect(array('/home'));
        }



        $file_count = 5;

        $sql = "SELECT u.user_id, u.user_type, u.firstname, u.lastname, un.school_name from `user_connection` c, user u, school un where c.from_user_id = " . $user->user_id . " AND c.to_user_id = u.user_id and un.school_id = u.school_id AND u.status = 'active'";



        $command = Yii::app()->db->createCommand($sql);
        $connected_users = $command->queryAll();




        $this->render('club',array('club'=>$club,'user'=>$user,'is_admin'=>$is_admin,'file_count'=>$file_count,'is_member'=>$is_member,'connected_users'=>$connected_users  ));
	}





    public function actionTest()
    {
        Yii::app()->nodeSocket->registerClientScripts();


        $user = $this->get_current_user();

        if(!$user){
            $data = array('success'=>false,'error_id'=>2, 'error_msg'=>'user not logged in');
            $this->renderJSON($data);
            return;
        }


        $assets_directory = '/assets/test';

        $full_directory = dirname(__FILE__) . '/../..' . $assets_directory;

        $delete_list = array();

        $dir = new DirectoryIterator($full_directory);

        $count = 0;
        foreach ($dir as $fileinfo) {

            if (!$fileinfo->isDot()) {

                $count += 1;


                $file_name = $fileinfo->getFilename();


                $file_path = $full_directory . '/' . $file_name;

                $file_url = $assets_directory . '/' . $file_name;
                //var_dump($file_url);
                //var_dump($file_url);
                $file = File::model()->find('file_url=:url', array(':url'=>$file_url));


                if($file){
                    //Check if this file is being referenced anywhere in the DB
                    //Tables that currently use file_id's:
                    //class, class_file, class_syllabus
                    //course
                    //department
                    //event
                    //group, group_file,
                    //post, post_file
                    //reply
                    //school
                    //showcase
                    $file_id = $file->file_id;

                    $class = ClassModel::model()->find('picture_file_id=:id or cover_file_id=:id', array(':id'=>$file_id));
                    if($class){
                        //There is a class referencing this file so do nothing
                        continue;
                    }

                    $class_file = ClassFile::model()->find('file_id=:id', array(':id'=>$file_id));
                    if($class_file){
                        continue;
                    }


                    $class_syllabus = ClassSyllabus::model()->find('file_id=:id', array(':id'=>$file_id));
                    if($class_syllabus){
                        continue;
                    }

                    $course = Course::model()->find('picture_file_id=:id', array(':id'=>$file_id));
                    if($course){
                        continue;
                    }

                    $department = Department::model()->find('picture_file_id=:id or cover_file_id=:id', array(':id'=>$file_id));
                    if($department){
                        //There is a department referencing this file so do nothing
                        continue;
                    }

                    $event = event::model()->find('file_id=:id', array(':id'=>$file_id));
                    if($event){
                        //There is a event referencing this file so do nothing
                        continue;
                    }

                    $group = Group::model()->find('picture_file_id=:id or cover_file_id=:id', array(':id'=>$file_id));
                    if($group){
                        //There is a group referencing this file so do nothing
                        continue;
                    }

                    $group_file = GroupFile::model()->find('file_id=:id', array(':id'=>$file_id));
                    if($group_file){
                        continue;
                    }

                    $post = Post::model()->find('file_id=:id', array(':id'=>$file_id));
                    if($post){
                        //There is a post referencing this file so do nothing
                        continue;
                    }

                    $post_file = postFile::model()->find('file_id=:id', array(':id'=>$file_id));
                    if($post_file){
                        continue;
                    }

                    $reply = Reply::model()->find('file_id=:id', array(':id'=>$file_id));
                    if($reply){
                        continue;
                    }


                    $school = School::model()->find('picture_file_id=:id or cover_file_id=:id', array(':id'=>$file_id));
                    if($school){
                        //There is a school referencing this file so do nothing
                        continue;
                    }

                    $showcase = Showcase::model()->find('file_id=:id', array(':id'=>$file_id));
                    if($showcase){
                        continue;
                    }

                    $test_user = User::model()->find('picture_file_id=:id', array(':id'=>$file_id));
                    if($test_user){
                        continue;
                    }
                    


                    //If we get to this point, we know this file isnt used
                    //any where in the database and is safe to delete
                    array_push($delete_list, $file_path);

                }else{
                    //If file is not referenced in db, delete it.
                    //unlink($file_path);
                    array_push($delete_list, $file_path);
                }
            }
        }

//
//        foreach($delete_list as $file_path){
//            unlink($file_path);
//        }

//        var_dump($count);
//        var_dump($delete_list);







        $this->render('test',array('user'=>$user, 'delete_list'=>$delete_list));




    }

    //modified by Tianming Xu for use of App on 01/07/2014
    public function actionJoin(){

        include_once "color/color.php";
        if(!isset($_POST['id'])){
            $data = array('success'=>false,'error_id'=>1, 'error_msg'=>'required data not set');
            $this->renderJSON($data);
            return;
        }

        $user_id = null;
        if(isset($_POST['user_id'])){
            $user_id = $_POST['user_id'];
        }else {
            $user_id = $this->get_current_user_id();
        }


        $group_id = $_POST['id'];

        //Check if this is a private group
        $group = Group::model()->find('group_id=:id', array(':id'=>$group_id));
        if(!$group){
            $data = array('success'=>false,'error_id'=>2, 'error_msg'=>'required data not set');
            $this->renderJSON($data);
            return;
        }

        //if this is a private group, make sure this user
        //has an invitation from an admin in this class
        if($group->privacy){
            $invite = Invite::model()->find('user_id=:user_id and origin_id=:origin_id and origin_type=:origin_type', array(":user_id"=>$user_id, ":origin_id"=>$group_id, ":origin_type"=>"group"));
            //if there is no invite for this group, dont let the user join
            if(!$invite){
                $data = array('success'=>false,'error_id'=>3, 'error_msg'=>'Cannot join a private group without an invitation');
                $this->renderJSON($data);
                return;
            }

        }


        $group_user = GroupUser::model()->find('group_id=:id and user_id=:user_id', array(':id'=>$group_id,':user_id'=>$user_id));
        //Check if this user is already a member for this group
        if(!$group_user){
            //Create new group user
            $group_user = new GroupUser;
            $group_user->group_id = $group_id;
            $group_user->user_id = $user_id;
            $group_user->color_id = get_random_color();
            //If we save successfully, user is now apart of group

            if($group_user->save(false)){

                $has_admin=GroupUser::model()->exists('group_id=:group_id and is_admin=true',array(':group_id'=>$group->group_id));
                foreach($group->events as $event){
                    $already_attending =  EventUser::model()->exists('event_id=:eid and user_id=:uid',array(':eid'=>$event->event_id,':uid'=>$user_id));
                    $event_creator = GroupUser::model()->find('group_id=:group_id and user_id=:user_id',array(':group_id'=>$group->group_id
                        ,':user_id'=>$event->user_id));
                    //add all club events from admins (or anyone if no admis) to user's events
                    if(($this->is_urlinq_admin($event->user)||$event_creator->is_admin || !$has_admin) && !$already_attending){

                        $event_user = new EventUser();
                        $event_user->user_id = $user_id;
                        $event_user->event_id = $event->event_id;
                        $event_user->color_id = get_random_color();
                        $event_user->save();
                    }
                }
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


    public function actionLeave(){
        if(!isset($_POST['id'])){
            $data = array('success'=>false,'error_id'=>1, 'error_msg'=>'required data not set');
            $this->renderJSON($data);
            return;
        }

        $user = $this->get_current_user($_POST);

        if(!$user){
            $data = array('success'=>false,'error_id'=>2, 'error_msg'=>'user is not logged in');
            $this->renderJSON($data);
            return;
        }


        $user_id = $user->user_id;


        $group_id = $_POST['id'];
        $group_user = GroupUser::model()->find('group_id=:id and user_id=:user_id', array(':id'=>$group_id,':user_id'=>$user_id));
        //Check if this user is even in this group
        if($group_user){
            //Check if we destroy this shit successfully
            if($group_user->delete()){


                //Loop through all events this user has for this group and delete them
                //Or else the database will get fucked up
                $user_events = EventUser::model()->findAllBySql("SELECT event_user.* FROM `event_user` JOIN `event` ON (event_user.event_id = event.event_id) WHERE event_user.user_id = " .$user_id . " AND (event.origin_type = 'group' OR event.origin_type = 'club') AND event.origin_id = " . $group_id);

                foreach($user_events as $event_user){
                    echo $event_user->event_id;
                    echo $event_user->user_id;
                    $event_user->delete();
                }
                //Get the events that this user created
                $events = Event::model()->findAllBySql("SELECT * FROM `event` WHERE event.user_id = " . $user->user_id . " AND (event.origin_type = 'group' OR event.origin_type = 'club') AND event.origin_id = " . $group_id);

               // $all_events = array_merge($events,$user_events);
                foreach($events as $event){
                    $event->delete();
                }

                //We also need to delete all posts that have the type event from this user in this group
                $posts = Post::model()->findAllBySql('SELECT * FROM `post` WHERE post_type = "event" AND user_id = '.$user->user_id.'  AND  origin_type = "club" AND origin_id = ' . $group_id);
                foreach($posts as $post){
                    $post->delete();
                }

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




    public function actionMembers(){



        $club_id = $_GET['id'];
        $club = Group::model()->find('group_id=:id', array(':id'=>1));


        $data = array('success'=>true,'club'=>$club,'members'=>array());

        $this->renderJSON($data);
    }

    public function actionRemoveMember(){
        if(!isset($_POST['group_id']) || !isset($_POST['user_id'])){
            $data = array('success'=>false,'error_id'=>1, 'error_msg'=>'required data not set');
            $this->renderJSON($data);
            return;
        }

        $user = $this->get_current_user($_POST);

        if(!$user){
            $data = array('success'=>false,'error_id'=>2, 'error_msg'=>'user is not logged in');
            $this->renderJSON($data);
            return;
        }

        $user_to_remove = User::model()->find('user_id = :uid',array(':uid'=>$_POST['user_id']));
        if(!$user_to_remove){
            $data = array('success'=>false,'error_id'=>2, 'error_msg'=>'invalid user');
            $this->renderJSON($data);
            return;
        }

        $current_user_id = $user->user_id;

        $group_id = $_POST['group_id'];
        $group_user = GroupUser::model()->find('group_id=:id and user_id=:user_id', array(':id'=>$group_id,':user_id'=>$current_user_id));
        //Check if the current user is even in this group
        if($this->is_urlinq_admin($user)||$group_user){
            //Check if current user is an admin of this group
            if($this->is_urlinq_admin($user)||$group_user->is_admin){
                $group_user_to_remove = GroupUser::model()->find('user_id=:uid and group_id=:gid',array(':gid'=>$group_id,':uid'=>$user_to_remove->user_id));
                //Check if we destroy this shit successfully
                if($group_user_to_remove->delete()){


                    //Loop through all events this user has for this group and delete them
                    //Or else the database will get fucked up
                    $user_events = EventUser::model()->findAllBySql("SELECT * FROM `event_user` JOIN `event` ON (event.event_id = event_user.event_id) WHERE event_user.user_id = " .$user_to_remove->user_id . " AND event.origin_type = 'club' AND event.origin_id = " . $group_id);
                    foreach($user_events as $event){
                        $event->delete();
                    }

                    //Get the events that this
                    $events = Event::model()->findAllBySql("SELECT * FROM `event` WHERE event.user_id = " . $user_to_remove->user_id . " AND event.origin_type = 'club' AND event.origin_id = " . $group_id);


                    foreach($events as $event){
                        $event->delete();
                    }

                    //We also need to delete all posts from this user in this group
                    $posts = Post::model()->findAllBySql('SELECT * FROM `post` WHERE  user_id = '.$user_to_remove->user_id.' AND origin_type = "club" AND origin_id = ' . $group_id);
                    foreach($posts as $post){
                        $post->delete();
                    }

                    $data = array('success'=>true);
                    $this->renderJSON($data);
                    return;
                }else{
                    $data = array('success'=>false,'error_id'=>3, 'error_msg'=>'error deleting user');
                    $this->renderJSON($data);
                    return;
                }
            }else{
                //user is not an admin of this group
                $data = array('success'=>false,'error_id'=>2, 'error_msg'=>'user not an admin');
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


    public function actionHeader(){


        $data = '';

        $this->render('club_header',array());
    }



//    club analytics functions


    public function actionGetPageViewData(){

        if (!isset($_GET['group_id']) && !isset($_GET['filter'])) {
            $data = array('success'=>false,'error_id'=>1, 'error_msg'=>'all data not set');
            $this->renderJSON($data);
            return;
        }


        $group_id = $_GET['group_id'];
        $filter = $_GET['filter'];


        define('ga_email','analytics@urlinq.com');
        define('ga_password','earlInq311');
        define('ga_profile_id','97099170');

        require 'gapi.class.php';

        $ga = new gapi(ga_email,ga_password);




        require 'club/analytics_helpers.php';


        $json_data_array = array('total_page_views' => 0,'new_page_views' => 0);
        $json_data_array['total_page_views'] = get_all_views($ga,$group_id);

        if (strpos($filter, 'Week') !== FALSE){
            $json_data_array['new_page_views'] = get_this_week_views($ga,$group_id);
        }elseif(strpos($filter, 'Month') !== FALSE){
            $json_data_array['new_page_views'] = get_this_month_views($ga,$group_id);
        }elseif(strpos($filter, 'Semester') !== FALSE){
            $json_data_array['new_page_views'] = get_this_year_views($ga,$group_id);
        }



        $json_data_array['success'] = true;
        $this->renderJSON($json_data_array);
        return;



    }

    public function actionGetMemberData(){
        if (!isset($_GET['group_id'])) {
            $data = array('success'=>false,'error_id'=>1);
            $this->renderJSON($data);
            return;
        }


        $group_id = $_GET['group_id'];
//        $club = Group::model()->find('group_id=:id', array(':id'=>$group_id));

            try {
                $json_data_array = array('users' => array());



                $club = Group::model()->findBySql("SELECT * FROM `group` WHERE group_id = $group_id");
                //Get the # of events that this club/group has had
                $json_data_array['event_count'] = count($club->events);


                $group_users = GroupUser::model()->findAllBySql("SELECT * FROM `group_user` WHERE group_id = '$group_id'");
                foreach($group_users as $group_user){
                    $user = User::model()->findBySql("SELECT * FROM user WHERE user_id = " . $group_user->user_id);
                    $user_json = array('id' => $user->user_id,'name' => '', 'attendance_count' => 0,'attendance_percent_str' => '','join_time' => 0,'tags'=>array());
                    $user_json['name'] = $user['firstname'] . ' ' . $user['lastname'];

                    //get users tags for this club/group
                    //$user_tags = mysqli_query($con,"SELECT * FROM `group_users_tags` WHERE group_id = '$group_id' AND user_id = '$user_id'");
                    $group_user_tags = GroupUserTag::model()->findAllBySql("SELECT * FROM `group_user_tag` WHERE group_id = '$group_id' AND user_id = '" . $group_user->user_id . "'");
                    foreach($group_user_tags as $group_user_tag){
                        array_push($user_json['tags'], $group_user_tag->tag->tag);
                    }

                    //Convert php datetime to milliseconds for the javascript new Date(milliseconds) function
                    $user_json['join_time'] = strtotime($group_user->join_time)*1000;
                    //make sure user is student
                    //if($user->user_type == 's'){
                        foreach($club->events as $event){
                            $event_id = $event->event_id;

                            if($user->user_id == $event->user_id){
                                $user_json['attendance_count'] += 1;
                            }else{
                                //See if this user is a user for this event
                                $event_user = EventUser::model()->find('user_id=:user_id and event_id=:event_id', array(':user_id'=>$user->user_id, ':event_id'=>$event_id));
                                if($event_user){
                                    //Gets the invite for specific user
                                    $user_json['attendance_count'] += 1;
                                }
                            }
                        }
                    //}



                    $attendance_percent = round(($user_json['attendance_count'] / $json_data_array['event_count']),2);
                    $user_json['attendance_percent_str'] = strval($attendance_percent * 100) . '%';

                    //Add $user_json to the json data being passed back to javascript
                    array_push($json_data_array['users'], $user_json);
                }

                $json_data_array['success'] = true;
                $this->renderJSON($json_data_array);
                return;

            } catch (Exception $e) {
                $json_data_array['success'] = false;
                $this->renderJSON($json_data_array);
                return;
            }
    }






    public function actionGetMemberCountData(){
        if (!isset($_GET['group_id'])) {
            $this->renderJSON(array('success'=>'false','error_id'=>1));
            return;
        }


        $group_id = $_GET['group_id'];
        $json_data_array = array('members_count'=>0,'joined_this_week' => 0,'joined_this_month' => 0,'joined_this_year' => 0);


        //Get total # of members (students)
        $group_users = GroupUser::model()->findAllBySql("SELECT * FROM group_user gu JOIN user u ON (gu.user_id = u.user_id AND u.user_type = 's') WHERE group_id = '$group_id'");
        $json_data_array['members_count'] = count($group_users);


        //Get # of members who joined this week
        $members_joined_this_week = GroupUser::model()->findAllBySql("SELECT * FROM group_user gu JOIN user u ON (gu.user_id = u.user_id AND u.user_type = 's') WHERE yearweek(`join_time`) = yearweek(curdate()) AND `group_id` = '$group_id'");
        $json_data_array['joined_this_week'] = count($members_joined_this_week);



        //Get # of members who joined this month
        $members_joined_this_month = GroupUser::model()->findAllBySql("SELECT * FROM group_user gu JOIN user u ON (gu.user_id = u.user_id AND u.user_type = 's') WHERE MONTH(`join_time`) = MONTH(curdate()) AND `group_id` = '$group_id'");
        $json_data_array['joined_this_month'] = count($members_joined_this_month);



        //Get # of members who joined this year
        $members_joined_this_year = GroupUser::model()->findAllBySql("SELECT * FROM group_user gu JOIN user u ON (gu.user_id = u.user_id AND u.user_type = 's') WHERE YEAR(`join_time`) = YEAR(curdate()) AND `group_id` = '$group_id'");
        $json_data_array['joined_this_year'] = count($members_joined_this_year);


        $json_data_array['success'] = true;
        $this->renderJSON($json_data_array);
        return;

    }

    public function actionGetMemberBreakdown(){
        if (!isset($_GET['id'])) {
            $this->renderJSON(array('success'=>'false','error_id'=>1));
            return;
        }
            // ../ goes to parent directory
        $group_id = $_GET['id'];
        try {

            $group_users = GroupUser::model()->findAllbySql("SELECT * FROM `group_user` WHERE group_id = '$group_id'");


            $json_data_array = array('freshman_count' => 0,'sophomore_count' => 0,'junior_count' => 0,'senior_count' => 0,'graduate_count' => 0,'total_count' => 0);


            foreach($group_users as $group_user){
                $user_id = $group_user->user_id;
                $user = $group_user->user;
                //if the user is a student, query their student attributes
                if($user->user_type == 's'){
                    $user_attribs = $user->studentAttributes;


                    //user ids: 285/286/350
                    //$group_users = mysqli_query($con,"SELECT * FROM `group_users` WHERE group_id = '$group_id'");
                    $json_data_array['total_count'] += 1;
                    if($user_attribs['year_name'] == 'Master' || $user_attribs['student_type'] == 'PhD'){
                        $json_data_array['graduate_count'] += 1;
                    }elseif($user_attribs['year_name'] == "Freshman"){
                        $json_data_array['freshman_count'] += 1;
                    }elseif($user_attribs['year_name'] == "Sophomore"){
                        $json_data_array['sophomore_count'] += 1;
                    }elseif($user_attribs['year_name'] == "Junior"){
                        $json_data_array['junior_count'] += 1;
                    }elseif($user_attribs['year_name'] == "Senior"){
                        $json_data_array['senior_count'] += 1;
                    }


                    elseif($user_attribs['student_type'] == 'undergrad'){
//                        $user_grad_year_int = intval($user_attribs['year']);
//                        $current_year_int = intval(date("Y"));
//                        $year_delta = $user_grad_year_int - $current_year_int;
//
//                        if($year_delta == 4){
//                            $json_data_array['freshman_count'] += 1;
//                        }elseif($year_delta == 3){
//                            $json_data_array['sophomore_count'] += 1;
//                        }elseif($year_delta == 2){
//                            $json_data_array['junior_count'] += 1;
//                        }elseif($year_delta == 1){
//                            $json_data_array['senior_count'] += 1;
//                        }


                    }
                }
            }

            $json_data_array['success'] = true;
            $this->renderJSON($json_data_array);
            return;
        } catch (Exception $e) {
            $json_data_array = array('success'=>false,'error_id'=>2, 'error_msg'=>$e->getMessage());
            $this->renderJSON($json_data_array);
            return;
        }


    }




    public function actionAttendanceData(){


        if (!isset($_GET['id']) || !isset($_GET['filter'])) {
            $json_data_array = array('success'=>false,'error_id'=>1, 'error_msg'=>'id not set');
            $this->renderJSON($json_data_array);
            return;
        }

        $filter = $_GET['filter'];

        $group_id = $_GET['id'];


        $json_data_array = array('invite_count' => 0,'accepted_invite_count'=>0);

        $sql_str = '';
        if (strpos($filter, 'Week') !== FALSE){
            $sql_str = "SELECT * FROM event WHERE (origin_type = 'club' OR origin_type = 'group') AND origin_id = '$group_id' AND yearweek(`start_date`) = yearweek(curdate())";
        }elseif(strpos($filter, 'Month') !== FALSE){
            $sql_str = "SELECT * FROM event WHERE (origin_type = 'club' OR origin_type = 'group') AND origin_id = '$group_id' AND MONTH(`start_date`) = MONTH(curdate())";
        }elseif(strpos($filter, 'Semester') !== FALSE){
            $sql_str = "SELECT * FROM event WHERE (origin_type = 'club' OR origin_type = 'group') AND origin_id = '$group_id' AND YEAR(`start_date`) = YEAR(curdate())";
        }

        $events = Event::model()->findAllBySql($sql_str);



        $json_data_array['event_count'] = count($events);
        foreach($events as $event){
            $event_id = $event->event_id;

            //Count all the invites sent out for this event and add to invite_count
            $invites = Invite::model()->findAllBySql("SELECT * FROM invite WHERE (origin_type = 'club' OR origin_type = 'group') AND origin_id = " . $event_id);

            $json_data_array['invite_count'] += count($invites);

            foreach($invites as $invite){
                if($invite->choice){
                    $json_data_array['accepted_invite_count'] += 1;
                }
            }
        }



        $json_data_array['success'] = true;
        $this->renderJSON($json_data_array);
        return;

    }


    public function actionGetGenderData(){
        if (!isset($_GET['id'])) {
            $this->renderJSON(array('success'=>'false','error_id'=>1));
            return;
        }


        $group_id = $_GET['id'];

        $group = Group::model()->findBySql('SELECT * FROM `group` WHERE group_id=' . $group_id);
        $json_data_array = array('female_count' => 0,'male_count' => 0);
        if($group){
            foreach($group->members as $user){
                //only count students
                if($user->user_type == 's'){
                    if($user->gender == 'M'){
                        $json_data_array['male_count'] += 1;
                    }else{
                        $json_data_array['female_count'] += 1;
                    }
                }
            }

            $json_data_array['success'] = true;
            $this->renderJSON($json_data_array);
            return;
        }else{
            $json_data_array['false'] = true;
            $json_data_array['error_id'] = 2;
            $json_data_array['error_msg'] = 'failed to retrieve group';
            $this->renderJSON($json_data_array);
            return;
        }





    }




    public function actionClubFiles (){
        if(!isset($_GET['id'])){
            $data = array('success'=>false,'error_id'=>1);
            $this->renderJSON($data);
            return;
        }

        $user_id = $this->get_current_user_id();


        $club_id = $_GET['id'];
        $club = Group::model()->find('group_id=:id', array(':id'=>$club_id));
        //Check if this user is even in this club
        if($club){
            //Check if we destroy this shit successfully
            $data = array('success'=>true,'files'=>$club->files);
            $this->renderJSON($data);
            return;
        }else{
            //user is not apart of this club
            $data = array('success'=>false,'error_id'=>2);
            $this->renderJSON($data);
            return;
        }
    }



    public function actionFileUpload(){
        if (empty($_FILES)) {
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'group id not set', '_files'=>$_FILES,'_post'=>$_POST);
            $this->renderJSON($data);
            return;
        }


        if(!isset($_POST['id'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'group id not set','_files'=>$_FILES,'_post'=>$_POST);
            $this->renderJSON($data);
            return;
        }

        include "file_upload.php";

        try{
            $group_id = $_POST['id'];
            $local_directory = 'club/' . $group_id . '/';


            $data = file_upload($_FILES,$local_directory);
            if($data['success']){
                $group_file = new GroupFile;
                $group_file->group_id = $group_id;
                $group_file->file_id = $data['file_id'];
                $group_file->user_id = $this->get_current_user_id();
                $group_file->save(false);
                if($group_file){
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

        }catch(Exception $e){
            $data = array('success'=>false,'error_id'=>2);
            $this->renderJSON($data);
            return;
        }




    }



    public function actionRemoveFile(){
        if(!isset($_POST['file_id']) || !isset($_GET['id'])){
            $data = array('success'=>false,'error_id'=>1);
            $this->renderJSON($data);
            return;
        }



        $group_id = $_GET['id'];
        $file_id = $_POST['file_id'];

        $group = Group::model()->find('group_id=:id',array(':id'=>$group_id));


        if($group){
            $group_file = GroupFile::model()->findBySql('SELECT * FROM `group_file` WHERE group_id=' . $group_id . ' AND file_id=' . $file_id);
            if($group_file){
                if($group_file->delete()){
                    $data = array('success'=>true);
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

        }else{
            $data = array('success'=>false,'error_id'=>2);
            $this->renderJSON($data);
            return;
        }
    }

    function actionEditDescription(){
        $user = $this->get_current_user();
        $club = Group::model()->find('group_id=:id',array(':id'=>$_POST['club_id']));
        if($club){
            $club_user = GroupUser::model()->find('group_id=:gid and user_id=:uid',array(':gid'=>$club->group_id,':uid'=>$user->user_id));
            if($this->is_urlinq_admin($user)||$club_user){
                if($this->is_urlinq_admin($user) || $club_user->is_admin || $user->user_email == "rlk314@nyu.edu" || $user->user_email == "rkopelma@student.touro.edu"){
                    $club->group_desc = $_POST['description'];
                    if($club->save(false)){
                        $this->renderJSON(array('success'=>true));
                    }else{
                        $this->renderJSON(array('success'=>false,'message'=>'error saving clubs'));
                    }
                }else{
                    $this->renderJSON(array('success'=>false,'message'=>'you are not an admin of this club'));
                }
            }else{
                $this->renderJSON(array('success'=>false,'message'=>'you are not part of this club'));
            }
        }else{
            $this->renderJSON(array('success'=>false,'message'=>'invalid club'));
        }
    }
    function actionEditMission(){
        $user = $this->get_current_user();
        $club = Group::model()->find('group_id=:id',array(':id'=>$_POST['club_id']));
        if($club){
            $club_user = GroupUser::model()->find('group_id=:gid and user_id=:uid',array(':gid'=>$club->group_id,':uid'=>$user->user_id));
            if($this->is_urlinq_admin($user)||$club_user  || $user->user_email == "rlk314@nyu.edu" || $user->user_email == "rkopelma@student.touro.edu"){
                if($this->is_urlinq_admin($user) || $user->user_email == "rlk314@nyu.edu" || $user->user_email == "rkopelma@student.touro.edu"  ||  $club_user->is_admin){
                    $club->mission_statement = $_POST['mission'];
                    if($club->save(false)){
                        $this->renderJSON(array('success'=>true));
                    }else{
                        $this->renderJSON(array('success'=>false,'message'=>'error saving clubs'));
                    }
                }else{
                    $this->renderJSON(array('success'=>false,'message'=>'you are not an admin of this club'));
                }
            }else{
                $this->renderJSON(array('success'=>false,'message'=>'you are not part of this club'));
            }
        }else{
            $this->renderJSON(array('success'=>false,'message'=>'invalid club'));
        }
    }

    function actionChangeClubIcon(){

        $user = $this->get_current_user();
        if(!$user){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'user not logged in');
            $this->renderJSON($data);
            return;
        }


        if(!isset($_POST['club_id'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'group id not set','_files'=>$_FILES,'_post'=>$_POST);
            $this->renderJSON($data);
            return;
        }
        if(!isset($_FILES['file'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'file not set','_files'=>$_FILES,'_post'=>$_POST);
            $this->renderJSON($data);
            return;
        }
        include "file_upload.php";
        $club = Group::model()->find('group_id=:id',array(':id'=>$_POST['club_id']));
        if($club){
            $club_user = GroupUser::model()->find('group_id=:gid and user_id=:uid',array(':gid'=>$club->group_id,':uid'=>$user->user_id));
            if($this->is_urlinq_admin($user)||$club_user){
                if($this->is_urlinq_admin($user)||$club_user->is_admin  || $user->user_email == "rlk314@nyu.edu" || $user->user_email == "rkopelma@student.touro.edu"){
                    $extension = pathinfo($_FILES["file"]["name"])['extension'];
                    if($extension == "jpg" || $extension == "png" || $extension == "gif") {
                        $result = file_upload($_FILES, "club/");
                        $club->picture_file_id = $result['file_id'];
                        if($club->save(false)){
                            $this->renderJSON(array('success'=>true,'file_url'=>$result['file_url']));
                        }else{
                            $this->renderJSON(array('success'=>false,'message'=>'error saving clubs'));
                        }
                    }else{
                        $this->renderJSON(array('success'=>false,'message'=>'file is not a picture'));
                    }

                }else{
                    $this->renderJSON(array('success'=>false,'message'=>'you are not an admin of this club'));
                }
            }else{
                $this->renderJSON(array('success'=>false,'message'=>'you are not part of this club'));
            }
        }else{
            $this->renderJSON(array('success'=>false,'message'=>'invalid club'));
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
