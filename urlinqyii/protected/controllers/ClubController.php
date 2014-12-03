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


        if(!$this->authenticated()){
            $this->redirect(array('/'));
        }

        $club_id = $_GET['id'];


        $club = Group::model()->find('group_id=:id', array(':id'=>$club_id));

        $user = User::model()->find('user_id=:id', array(':id'=>1));


        $is_admin = Yii::app()->db->createCommand()
            ->select('is_admin')
            ->from('group_user u')
            ->where('user_id=:user_id and group_id=:group_id', array(':user_id'=>$user->user_id,':group_id'=>$club->group_id))
            ->queryRow();




        //SELECT count(*) as file_count FROM posts p JOIN groups_files gf on (p.target_id = gf.group_id) WHERE  ((p.target_type = 'groups' and p.file_id is not null and p.target_id = ?) or gf.group_id = ?
//        $file_count = Yii::app()->db->createCommand()
//            ->select('*')
//            ->from('posts p')
//            ->join('groups_files gf')
//            ->on('p.target_id = gf.group_id')
//            ->where('(p.target_type = "groups" and p.file_id is not null and p.target_id=:target_id) or gf.group_id =:group_id', array(':target_id'=>$club->group_id,':group_id'=>$club->group_id))
//            ->queryRow();

        $file_count = 5;


        $is_member = false;

        foreach ($club->users as $club_user) {
            if($club_user->user_id == $user['user_id']){
                $is_member = true;
                break;
            }
        }

        $sql = "SELECT u.user_id, u.user_type, u.firstname, u.lastname, un.school_name from `user_connection` c, user u, school un where c.from_user_id = " . $user->user_id . " AND c.to_user_id = u.user_id and un.school_id = u.school_id AND u.status = 'active'";



        $command = Yii::app()->db->createCommand($sql);
        $connected_users = $command->queryAll();


//        if (isset($_GET['group_id'])) {
//            $group_id = $_GET['group_id'];
//        }
//        if (isset($_SESSION['user_type'])) {
//            $user_type = $_SESSION['user_type'];
//        }
//        $get_admin_flag_query = "SELECT is_admin FROM group_users WHERE user_id = ? AND group_id = ?";
//        $get_admin_flag_stmt = $con->prepare($get_admin_flag_query);
//
//
//        if($get_admin_flag_stmt != null){
//            $get_admin_flag_stmt->bind_param("ii",$user_id, $group_id);
//            $get_admin_flag_stmt->execute();
//            $get_admin_flag_stmt->bind_result($admin_flag);
//            $get_admin_flag_stmt->fetch();
//            $get_admin_flag_stmt->close();
//        }
//        $get_course_about_query = "SELECT G.group_desc FROM groups G WHERE G.group_id = ?";
//        $get_course_about_stmt = $con->prepare($get_course_about_query);



        $this->render('club',array('club'=>$club,'user'=>$user,'is_admin'=>$is_admin,'file_count'=>$file_count,'is_member'=>$is_member,'connected_users'=>$connected_users  ));
	}





    public function actionTest()
    {




        //Yii::app()->getBaseUrl(true)
//        //$club_id = $_GET['id'];
//        $club = Group::model()->find('group_id=:id', array(':id'=>1));
//
//        $user = User::model()->find('user_id=:id', array(':id'=>1));
//
//
//        //$data= Campaign::model()->findAllBySql($query);
//
//        //$club_id = $_GET['id'];
//        $club = Group::model()->find('group_id=:id', array(':id'=>$club->group_id));
//
//        $user = User::model()->find('user_id=:id', array(':id'=>1));
//
//
//        $is_admin = Yii::app()->db->createCommand()
//            ->select('is_admin')
//            ->from('group_user u')
//            ->where('user_id=:user_id and group_id=:group_id', array(':user_id'=>$user->user_id,':group_id'=>$club->group_id))
//            ->queryRow();
//
//
////        $file_count = Yii::app()->db->createCommand()
////            ->select('*')
////            ->from('posts p')
////            ->join('groups_files gf', 'p.target_id = gf.group_id')
////            ->where('(p.target_type = "groups" and p.file_id is not null and p.target_id=:target_id) or gf.group_id =:group_id', array(':target_id'=>$club->group_id,':group_id'=>$club->group_id))
////            ->findAll();
//
////        $sql = "SELECT count(*) as file_count FROM posts p JOIN groups_files gf on (p.target_id = gf.group_id) WHERE  ((p.target_type = 'groups' and p.file_id is not null and p.target_id = " . $club->group_id . ") or gf.group_id = " . $club->group_id ;
////        $command = Yii::app()->db->createCommand($sql);
////        $file_count = $command->queryAll();
//
//        $file_count = 5;
//
//
//
//        $is_member = false;
//
//        foreach ($club->users as $user) {
//            if($user->user_id == $user['user_id']){
//                $is_member = true;
//                break;
//            }
//        }
//
//
//
////        function meFollowing($user)
////        {
////            GLOBAL $con;
////            $connect_stmt = $con->prepare("Select u.user_id, u.user_type, u.firstname, u.lastname, u.dp_flag, u.dp_link, u.dp_blob, un.univ_name
////		from connect c, user u, university un where c.from_user_id = ? and c.to_user_id = u.user_id and un.univ_id = u.univ_id and u.status = 'active'");
////            $connect_stmt->bind_param("i", $user);
////            $connect_stmt->execute();
////            $connect_stmt->store_result();
////            $connect_stmt->bind_result($user_id, $type, $firstname, $lastname, $dp_flag, $dp_link, $dp_blob, $univ_name);
////            $uarray = array();
////            while ($connect_stmt->fetch()) {
////                $dp_link1 = get_user_dp($con, $user_id);
////                $is_following = isFollowing($_SESSION['user_id'], $user_id);
////                $interests = FetchUserInterests($user_id);
////                $uarray[] = array('user_id' => $user_id, 'type' => $type, 'firstname' => $firstname, 'lastname' => $lastname, 'dp_flag' => $dp_flag, 'dp_link' => $dp_link1, 'dp_blob' => $dp_blob, 'univ_name' => $univ_name, 'is_following' => $is_following, 'interests' => $interests);
////            }
////            $connect_stmt->free_result();
////            $connect_stmt->close();
////
////            return $uarray;
////        }
//
//
////        SELECT distinct(posts.post_id), posts.user_id, privacy, target_type, target_id
////                  from posts
////                  join posts_user_inv
////                    on (posts.post_id = posts_user_inv.post_id)
////                 where ((posts_user_inv.user_id IN (SELECT to_user_id from connect where from_user_id = ".$user->user_id.")
////                    or posts_user_inv.user_id = ".$user->user_id.")
////                    or (target_type = 'university' and target_id = ".$user->univ_id.")
////    or (target_type = 'department' and target_id = ".$user->dept_id.")
////    or (target_type = 'class' and target_id IN (SELECT cu.class_id
////                                                                  from courses_user cu join courses_semester cs
////                                                                    on (cu.class_id = cs.class_id)
////                                                                    where user_id = ".$user->user_id." and cs.semester = '".$cur_sem."' and cs.`year` = ".date('Y').")))
////                    order by last_activity DESC
////                    LIMIT 0,".self::POST_LIMIT;
//
//        $sql = "SELECT u.user_id, u.user_type, u.firstname, u.lastname, un.school_name from `user_connection` c, user u, school un where c.from_user_id = " . $user->user_id . " AND c.to_user_id = u.user_id and un.school_id = u.school_id AND u.status = 'active'";
//
//        $connected_users = User::model()->findAllBySql($sql);
//
//
//
////        $command = Yii::app()->db->createCommand($sql);
////        $connected_users = $command->queryAll();
//
//
////        $get_admin_flag_query = "SELECT COUNT(*) as admin_flag FROM group_users WHERE group_id = $group_id AND user_id = $user_id AND is_admin = 1";
////        $get_admin_flag_query_result = mysqli_query($con, $get_admin_flag_query);
////        $admin_row = mysqli_fetch_array($get_admin_flag_query_result);
////        $admin_flag = $admin_row['admin_flag'];
////
////// add date filter to show the evnts from current month to future 15 events
////        $get_admin_event_query = "SELECT GE.* FROM group_event GE WHERE GE.made_by_admin = 1 AND (((start_date = '$month_start_date' AND start_time >= '$month_start_time') OR (start_date > '$month_start_date')) AND ((end_date = '$month_end_date' AND end_time < '$month_end_time') OR (end_date < '$month_end_date')))";
////        $get_admin_event_query_result = mysqli_query($con, $get_admin_event_query);
//
//        //$connected_users = array(1,2,3);
//        //$count = count ( $results )
//
//
//
//        $sql = "SELECT c.course_name, c.course_id, cs.professor, cu.class_id, u.lastname
//                 FROM `class_user` cu
//                 JOIN class cs
//                 ON (cu.class_id = cs.class_id)
//                 JOIN course c
//                 ON (cs.course_id = c.course_id
//                 AND cs.department_id = c.department_id
//                 AND cs.school_id = c.school_id)
//                 LEFT JOIN user u
//                 ON (u.user_id = cs.professor)
//                 WHERE cu.user_id = " . $user->user_id;
//
//
//        $command = Yii::app()->db->createCommand($sql);
//
//
//        $courses = $command->queryAll();

//        $professor = User::model()->find("user_email=:user_email",array(":user_email"=>'lol@asdasd'));
//        //$this->render('test',array('club'=>$club,'user'=>$user,'is_admin'=>$is_admin,'file_count'=>$file_count,'is_member'=>$is_member,'connected_users'=>$connected_users,'courses'=>$courses,'professor'=>$professor));
//
//
//        $university = University::model()->find('university_id=:university_id',array(':university_id'=>1));
//        $department = Department::model()->find('department_id=:department_id',array(':department_id'=>1));
//        $user = User::model()->find('user_id=:id', array(':id'=>1));
//
//        $sql = "SELECT c.course_name, c.course_id, cs.picture_file_id,cs.professor, cu.class_id, u.lastname
//                 FROM `class_user` cu
//                 JOIN class cs
//                 ON (cu.class_id = cs.class_id)
//                 JOIN course c
//                 ON (cs.course_id = c.course_id
//                 AND cs.department_id = c.department_id
//                 AND cs.school_id = c.school_id)
//                 LEFT JOIN user u
//                 ON (u.user_id = cs.professor)
//                 WHERE cu.user_id = " . $user->user_id;
//        //$command = Yii::app()->db->createCommand($sql);
//
//
//
//        //$classes = $command->queryAll();
//        $classes = ClassModel::model()->findAllBySql($sql);
//
//        //$club_id = $_GET['id'];
//        $class = ClassModel::model()->findBySql("SELECT * FROM `class` WHERE class_id=1");
//        $type = $class->relations();
//        $club = Group::model()->find('group_id=:id', array(':id'=>1));



        $classes = ClassModel::model()->findAll();
        foreach($classes as $class){
            $class->class_name = $class->course->course_name . ' ' . $class->section_id;
            $class->save(false);
        }


        $this->render('test',array('classes'=>$classes));




    }




    public function actionMembers(){



        $club_id = $_GET['id'];
        $club = Group::model()->find('group_id=:id', array(':id'=>1));


        $data = array('success'=>true,'club'=>$club,'members'=>array());

        $this->renderJSON($data);
    }

    public function actionRemoveMember(){



        $data = array('success'=>true);

        $this->renderJSON($data);
    }


    public function actionHeader(){


        $data = '';

        $this->render('club_header',array());
    }



//    club analytics functions


    public function actionGetPageViewData(){
        define('ga_email','urlinq5@gmail.com');
        define('ga_password','Daisy@619');
        define('ga_profile_id','78486849');

        require 'gapi.class.php';

        $ga = new gapi(ga_email,ga_password);



        if (isset($_GET['group_id']) && isset($_GET['filter'])) {
            require 'club/analytics_helpers.php';
            $group_id = $_GET['group_id'];
            $filter = $_GET['filter'];

            $json_data_array = array('total_page_views' => 0,'new_page_views' => 0);
            $json_data_array['total_page_views'] = get_all_views($group_id);

            if (strpos($filter, 'Week') !== FALSE){
                $json_data_array['new_page_views'] = get_this_week_views($group_id);
            }elseif(strpos($filter, 'Month') !== FALSE){
                $json_data_array['new_page_views'] = get_this_month_views($group_id);
            }elseif(strpos($filter, 'Semester') !== FALSE){
                $json_data_array['new_page_views'] = get_this_year_views($group_id);
            }




            echo json_encode($json_data_array);
        }





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
                    if($user->user_type == 's'){
                        foreach($club->events as $event){
                            $event_id = $event->event_id;
                            //Gets the invite for specific user
                            $user_json['attendance_count'] = count($event->acceptedInvites);
                        }
                    }

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
                    if($user_attribs['student_type'] == 'grad' || $user_attribs['student_type'] == 'phd'){
                        $json_data_array['graduate_count'] += 1;
                    }elseif($user_attribs['student_type'] == 'undergrad'){
                        $user_grad_year_int = intval($user_attribs['year']);
                        $current_year_int = intval(date("Y"));
                        $year_delta = $user_grad_year_int - $current_year_int;

                        if($year_delta == 4){
                            $json_data_array['freshman_count'] += 1;
                        }elseif($year_delta == 3){
                            $json_data_array['sophomore_count'] += 1;
                        }elseif($year_delta == 2){
                            $json_data_array['junior_count'] += 1;
                        }elseif($year_delta == 1){
                            $json_data_array['senior_count'] += 1;
                        }
                    }
                }
            }

            $json_data_array['success'] = true;
            $this->renderJSON($json_data_array);
            return;
        } catch (Exception $e) {
            $json_data_array = array('success'=>false,'error_id'=>2);
            $this->renderJSON($json_data_array);
            return;
        }


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
