<?php

class SchoolController extends Controller
{
    public function actionView()
    {
        $school_id = $_GET['id'];

        $school = School::model()->find('school_id=:id', array(':id'=>$school_id));

        $user = $this->get_current_user();


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


    public function actionGetDepartments(){
        if(!isset($_GET['school_id'])){
            $data = array('success'=>false,'error_id'=>1);
            $this->renderJSON($data);
            return;
        }


        $id = $_GET['school_id'];
        $school = School::model()->find('school_id=:id',array(':id'=>$id));

        if($school){
            $school_data = $this->get_model_associations($school,array('departments'=>array('pictureFile', 'users')));
            $data = array('success'=>true,'departments'=>$school_data['departments']);
            $this->renderJSON($data);
            return;
        }else{
            $data = array('success'=>false,'error_id'=>1);
            $this->renderJSON($data);
            return;
        }
    }


    public function actionGetClubs(){
        if(!isset($_GET['school_id'])){
            $data = array('success'=>false,'error_id'=>1);
            $this->renderJSON($data);
            return;
        }


        $id = $_GET['school_id'];
        $school = School::model()->find('school_id=:id',array(':id'=>$id));

        if($school){

            $clubs = array();

            $school_data = $this->get_model_associations($school,array('clubs'=>array('pictureFile')));


            $clubs = $school_data['clubs'];
            if(count($clubs) < 5){
                //add some clubs from the university
                $university_data = $this->get_model_associations($school->university,array('clubs'=>array('pictureFile')));
                $clubs = $university_data['clubs'];
            }

            $data = array('success'=>true,'clubs'=>$clubs);
            $this->renderJSON($data);
            return;
        }else{
            $data = array('success'=>false,'error_id'=>1);
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