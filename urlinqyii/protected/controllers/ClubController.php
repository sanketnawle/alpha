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

        $user = User::model()->find('user_id=:id', array(':id'=>1));


        $is_admin = Yii::app()->db->createCommand()
            ->select('is_admin')
            ->from('group_users u')
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

        foreach ($club->users as $user) {
            if($user->user_id == $user['user_id']){
                $is_member = true;
                break;
            }
        }


        $sql = "SELECT u.user_id, u.user_type, u.firstname, u.lastname, u.dp_flag, u.dp_link, u.dp_blob, un.univ_name from `connect` c, user u, university un where c.from_user_id = " . $user->user_id . " AND c.to_user_id = u.user_id and un.univ_id = u.univ_id AND u.status = 'active'";


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
        //$club_id = $_GET['id'];
        $club = Group::model()->find('group_id=:id', array(':id'=>1));

        $user = User::model()->find('user_id=:id', array(':id'=>1));


        //$data= Campaign::model()->findAllBySql($query);

        //$club_id = $_GET['id'];
        $club = Group::model()->find('group_id=:id', array(':id'=>$club->group_id));

        $user = User::model()->find('user_id=:id', array(':id'=>1));


        $is_admin = Yii::app()->db->createCommand()
            ->select('is_admin')
            ->from('group_users u')
            ->where('user_id=:user_id and group_id=:group_id', array(':user_id'=>$user->user_id,':group_id'=>$club->group_id))
            ->queryRow();


//        $file_count = Yii::app()->db->createCommand()
//            ->select('*')
//            ->from('posts p')
//            ->join('groups_files gf', 'p.target_id = gf.group_id')
//            ->where('(p.target_type = "groups" and p.file_id is not null and p.target_id=:target_id) or gf.group_id =:group_id', array(':target_id'=>$club->group_id,':group_id'=>$club->group_id))
//            ->findAll();

//        $sql = "SELECT count(*) as file_count FROM posts p JOIN groups_files gf on (p.target_id = gf.group_id) WHERE  ((p.target_type = 'groups' and p.file_id is not null and p.target_id = " . $club->group_id . ") or gf.group_id = " . $club->group_id ;
//        $command = Yii::app()->db->createCommand($sql);
//        $file_count = $command->queryAll();

        $file_count = 5;



        $is_member = false;

        foreach ($club->users as $user) {
            if($user->user_id == $user['user_id']){
                $is_member = true;
                break;
            }
        }



//        function meFollowing($user)
//        {
//            GLOBAL $con;
//            $connect_stmt = $con->prepare("Select u.user_id, u.user_type, u.firstname, u.lastname, u.dp_flag, u.dp_link, u.dp_blob, un.univ_name
//		from connect c, user u, university un where c.from_user_id = ? and c.to_user_id = u.user_id and un.univ_id = u.univ_id and u.status = 'active'");
//            $connect_stmt->bind_param("i", $user);
//            $connect_stmt->execute();
//            $connect_stmt->store_result();
//            $connect_stmt->bind_result($user_id, $type, $firstname, $lastname, $dp_flag, $dp_link, $dp_blob, $univ_name);
//            $uarray = array();
//            while ($connect_stmt->fetch()) {
//                $dp_link1 = get_user_dp($con, $user_id);
//                $is_following = isFollowing($_SESSION['user_id'], $user_id);
//                $interests = FetchUserInterests($user_id);
//                $uarray[] = array('user_id' => $user_id, 'type' => $type, 'firstname' => $firstname, 'lastname' => $lastname, 'dp_flag' => $dp_flag, 'dp_link' => $dp_link1, 'dp_blob' => $dp_blob, 'univ_name' => $univ_name, 'is_following' => $is_following, 'interests' => $interests);
//            }
//            $connect_stmt->free_result();
//            $connect_stmt->close();
//
//            return $uarray;
//        }


//        SELECT distinct(posts.post_id), posts.user_id, privacy, target_type, target_id
//                  from posts
//                  join posts_user_inv
//                    on (posts.post_id = posts_user_inv.post_id)
//                 where ((posts_user_inv.user_id IN (SELECT to_user_id from connect where from_user_id = ".$user->user_id.")
//                    or posts_user_inv.user_id = ".$user->user_id.")
//                    or (target_type = 'university' and target_id = ".$user->univ_id.")
//    or (target_type = 'department' and target_id = ".$user->dept_id.")
//    or (target_type = 'class' and target_id IN (SELECT cu.class_id
//                                                                  from courses_user cu join courses_semester cs
//                                                                    on (cu.class_id = cs.class_id)
//                                                                    where user_id = ".$user->user_id." and cs.semester = '".$cur_sem."' and cs.`year` = ".date('Y').")))
//                    order by last_activity DESC
//                    LIMIT 0,".self::POST_LIMIT;

        $sql = "SELECT u.user_id, u.user_type, u.firstname, u.lastname, u.dp_flag, u.dp_link, u.dp_blob, un.univ_name from `connect` c, user u, university un where c.from_user_id = " . $user->user_id . " AND c.to_user_id = u.user_id and un.univ_id = u.univ_id AND u.status = 'active'";


        $command = Yii::app()->db->createCommand($sql);
        $connected_users = $command->queryAll();


//        $get_admin_flag_query = "SELECT COUNT(*) as admin_flag FROM group_users WHERE group_id = $group_id AND user_id = $user_id AND is_admin = 1";
//        $get_admin_flag_query_result = mysqli_query($con, $get_admin_flag_query);
//        $admin_row = mysqli_fetch_array($get_admin_flag_query_result);
//        $admin_flag = $admin_row['admin_flag'];
//
//// add date filter to show the evnts from current month to future 15 events
//        $get_admin_event_query = "SELECT GE.* FROM group_event GE WHERE GE.made_by_admin = 1 AND (((start_date = '$month_start_date' AND start_time >= '$month_start_time') OR (start_date > '$month_start_date')) AND ((end_date = '$month_end_date' AND end_time < '$month_end_time') OR (end_date < '$month_end_date')))";
//        $get_admin_event_query_result = mysqli_query($con, $get_admin_event_query);

        //$connected_users = array(1,2,3);
        //$count = count ( $results )



        $sql = "SELECT c.course_name, c.course_id, cs.dp_blob_id,cs.professor, cu.class_id, u.lastname
                 FROM `courses_user` cu
                 JOIN courses_semester cs
                 ON (cu.class_id = cs.class_id)
                 JOIN courses c
                 ON (cs.course_id = c.course_id
                 AND cs.dept_id = c.dept_id
                 AND cs.univ_id = c.univ_id)
                 LEFT JOIN user u
                 ON (u.user_id = cs.professor)
                 WHERE cu.user_id = " . $user->user_id;
        $command = Yii::app()->db->createCommand($sql);


        $courses = $command->queryAll();

        $this->render('test',array('club'=>$club,'user'=>$user,'is_admin'=>$is_admin,'file_count'=>$file_count,'is_member'=>$is_member,'connected_users'=>$connected_users,'courses'=>$courses));
    }




    public function actionMembers(){



        $club_id = $_GET['id'];
        $club = Group::model()->find('group_id=:id', array(':id'=>1));


        $data = array('success'=>true,'club'=>$club,'members'=>$club->users);

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
