<?php

class SchoolController extends Controller
{
    public function actionView()
    {
        $school_id = $_GET['id'];

        $school = School::model()->find('school_id=:id', array(':id'=>$school_id));

        $user = $this->get_current_user();


        if(!$user){
            $this->redirect(array('/?url=/school/' . $school_id));
        }

        $is_member = true;


        $is_admin = false;

        if($this->is_urlinq_admin($user)){
            $is_admin = true;
        }



        $is_urlinq_admin = false;

        if($this->is_urlinq_admin($user)){
            $is_urlinq_admin = true;
        }





        //var_dump($user);
        //$members=User::model()->find('school_id:=id', array(':id'=>1));
        $this->render('school',array('user'=>$user,'school'=>$school, 'departments'=>$school->departments, 'users'=>$school->users,'is_member'=>$is_member, 'is_admin'=>$is_admin, 'is_urlinq_admin'=>$is_urlinq_admin));
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

    //Loads groups 50 at a time
    //GET: school_id
    //GET: (optional)last_id - last group id in the list that you received
    public function actionLoadGroups(){
        if(!isset($_GET['school_id'])){
            $data = array('success'=>false,'error_id'=>1);
            $this->renderJSON($data);
            return;
        }


        $id = $_GET['school_id'];
        $school = School::model()->find('school_id=:id',array(':id'=>$id));

        if($school){

            $extra_sql = '';
            if(isset($_GET['last_id'])){
                $last_group_id = $_GET['last_id'];
                $extra_sql = " AND group_id > " . $last_group_id;
            }

            $sql = "SELECT * FROM `group` WHERE school_id = '" . $id . "'" . $extra_sql . " AND privacy = 0 ORDER BY group_id LIMIT 50";

            $groups = Group::model()->findAllBySql($sql);


            $school_group_data = $this->get_models_associations($groups,array('pictureFile', 'coverFile', 'members', 'events'));


            $data = array('success'=>true,'groups'=>$school_group_data, 'data_type'=>'groups');
            $this->renderJSON($data);
            return;
        }else{
            $data = array('success'=>false,'error_id'=>1);
            $this->renderJSON($data);
            return;
        }
    }



    //Loads 50 users at a time in alphabetical order
    public function actionLoadUsers(){
        if(!isset($_GET['school_id'])){
            $data = array('success'=>false,'error_id'=>1);
            $this->renderJSON($data);
            return;
        }


        $user = $this->get_current_user($_GET);

        if(!$user){
            $data = array('success'=>false,'error_id'=>2, 'error_msg'=>'user not logged in');
            $this->renderJSON($data);
            return;
        }


        $id = $_GET['school_id'];
        $school = School::model()->find('school_id=:id',array(':id'=>$id));

        if($school){

            $extra_sql = '';
            if(isset($_GET['last_id'])){
                $last_user_id = $_GET['last_id'];
                $extra_sql = ' AND user_id > ' . $last_user_id;
            }

            $sql = "SELECT * FROM user WHERE school_id = '" . $id . "'" . $extra_sql . " ORDER BY user_id LIMIT 50";

            $users = User::model()->findAllBySql($sql);


            $school_user_data = $this->get_models_associations($users,array('pictureFile', 'studentAttributes', 'department'));

            //Go through the school data and check if current user is following these users
            foreach($school_user_data as $i=>$other_user){
                if($user->is_following($other_user['user_id'])){
                    $school_user_data[$i]['is_following'] = 'true';
                }else{
                    $school_user_data[$i]['is_following'] = 'false';
                }
            }


            $data = array('success'=>true,'users'=>$school_user_data, 'data_type'=>'users');
            $this->renderJSON($data);
            return;
        }else{
            $data = array('success'=>false,'error_id'=>1);
            $this->renderJSON($data);
            return;
        }
    }




    public function actionLoadDepartments(){
        if(!isset($_GET['school_id'])){
            $data = array('success'=>false,'error_id'=>1);
            $this->renderJSON($data);
            return;
        }


        $id = $_GET['school_id'];
        $school = School::model()->find('school_id=:id',array(':id'=>$id));

        if($school){

            $extra_sql = '';
            if(isset($_GET['last_id'])){
                $last_department_id = $_GET['last_id'];
                $extra_sql = ' AND department_id > ' . $last_department_id;
            }

            $sql = "SELECT * FROM department WHERE school_id = '" . $id . "'" . $extra_sql . " ORDER BY department_id LIMIT 50";

            $departments = Department::model()->findAllBySql($sql);


            $school_department_data = $this->get_models_associations($departments,array('pictureFile', 'admins', 'students', 'courses'));


            $data = array('success'=>true,'departments'=>$school_department_data, 'data_type'=>'departments');
            $this->renderJSON($data);
            return;
        }else{
            $data = array('success'=>false,'error_id'=>1);
            $this->renderJSON($data);
            return;
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