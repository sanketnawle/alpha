<?php

class SchoolController extends Controller
{
    public function actionView()
    {


        $school = School::model()->find('school_id=:id', array(':id'=>1));
        $user_id=1;
        $user = User::model()->find('user_id=:id', array(':id'=>$user_id));


        $is_member = true;
        //var_dump($user);
        //$members=User::model()->find('school_id:=id', array(':id'=>1));
        $this->render('school',array('user'=>$user,'school'=>$school, 'departments'=>$school->departments, 'users'=>$school->users,'is_member'=>$is_member));
    }

    public function actionFollowDept(){

//        echo "comes here";
        $user_id =1;
        $dep_id = (int)$_POST["department_id"];
//         $sel= $_POST["selected"];
//        echo $sel;
        if ($_POST["selected"]=="follow") {
            $newfollower = new DepartmentFollow;
            $newfollower->department_id = $dep_id;
            $newfollower->user_id = $user_id;
            $newfollower->save();
            echo "department followed";
        }

         if ($_POST["selected"]=="unfollow"){
    //         $dep_id =(int) $_POST["department_id"];
             DepartmentFollow::model()->deleteAll('user_id=:id and department_id=:dept_id', array(':id'=>$user_id, ':dept_id'=>$dep_id));
             echo "department unfollowed";
         }

    }

    public function actionFollowMember(){

//        echo "comes here";
        $user_id =1;
        $mem_id = (int)$_POST["member_id"];
        $date=date('Y-m-d H:i:s');
//         $sel= $_POST["selected"];
//        echo $sel;
        if ($_POST["selected"]=="follow") {
            $newMemfollower = new UserConnection;
            $newMemfollower->from_user_id = $user_id;
            $newMemfollower->to_user_id = $mem_id;
            $newMemfollower->timestamp = $date;
            $newMemfollower->save();
            echo "Member followed";
        }

        if ($_POST["selected"]=="unfollow"){
            //         $dep_id =(int) $_POST["department_id"];
            UserConnection::model()->deleteAll('from_user_id=:id and to_user_id=:mem_id', array(':id'=>$user_id, ':mem_id'=>$mem_id));
            echo "Member unfollowed";
        }

    }

    public function actionJoinGroup(){

//        echo "comes here";
        $user_id =1;
        $grp_id = (int)$_POST["group_id"];
        $date=date('Y-m-d H:i:s');
//        echo $grp_id, $date;
////
//         $sel= $_POST["selected"];
//        echo $sel;
        if ($_POST["selected"]=="join") {
            $newGrpJoin = new GroupUser;
            $newGrpJoin->group_id = $grp_id;
            $newGrpJoin->user_id = $user_id;
            $newGrpJoin->is_admin = 0;
            $newGrpJoin->privacy = "public";
            $newGrpJoin->color_id = 1;
            $newGrpJoin->join_time = $date;
            $newGrpJoin->save();
            echo "Club Joined!";
        }
//
        if ($_POST["selected"]=="leave"){
            //         $dep_id =(int) $_POST["department_id"];
            GroupUser::model()->deleteAll('user_id=:id and group_id=:grp_id', array(':id'=>$user_id, ':grp_id'=>$grp_id));
            echo "Club Left";
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