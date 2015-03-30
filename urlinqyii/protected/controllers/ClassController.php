<?php

class ClassController extends Controller
{


    //COULD NOT USE "CLASS" FOR THE MODEL NAME
    //SO USE ClassModel::model() WHEN ACCESSING CLASS DATA
   /* public function addUserFlags($members, $usersFollowed){
        $newMembers = [];
        $newMembers['users'] = $members;
        $newMembers['flags'] = [];
        foreach($members as $i=>$member){
            $newMembers['flags'][$i]['following'] = in_array($member->user_id,$usersFollowed);
        }
        return $newMembers;
    } */

    public function actionView()
    {

        $class_id = $_GET['id'];
        $user_id = 2;

        $class = ClassModel::model()->find('class_id=:id', array(':id' => $class_id));


        $user = $this->get_current_user();

        if(!$user){
            $this->redirect(array('/?url=/class/' . $class_id));
        }

        $course = $class->course;

        $professor = $class->professor;

        $department = $class->department;
        $university = $class->school;

        $schedules = $class->schedules;

        $schedule_strings = [];
        foreach($schedules as $schedule){
            $schedule_strings[] = $schedule->day . ' ' . $schedule->start_time . ' to ' . $schedule->end_time;
        }




        $is_member = false;
        $is_admin = false;

        $class_user = ClassUser::model()->find('class_id=:class_id and user_id=:user_id', array(':class_id'=>$class->class_id, ':user_id'=>$user->user_id));
        if($class_user){
            $is_member = true;
            if($class_user->is_admin){
                $is_admin = true;
            }
        }else{
            if($class->professor_id == $user->user_id){
                $is_member = true;
                $is_admin = true;
            }
        }



//        if($this->is_urlinq_admin($user)){
//            $is_admin = true;
//        }



        if($this->is_urlinq_admin($user)){
            $is_admin = true;
        }

        if($is_member && isset($_GET['event_id']) && isset($_GET['event_option'])){
            $this->check_event_option($user,$_GET);
        }


        if(isset($_GET['question_option_id'])){
            $this->check_question_option($user,$_GET);
        }









        $files =  Yii::app()->db->createCommand()
        ->select('u.firstname, u.lastname, c.text_msg, f.* ')
        ->from('class_file c, file f, user u')
        ->where('c.class_id=:id and c.file_id = f.file_id and c.user_id = u.user_id', array(':id'=>$class_id))
        ->queryAll();

       /* $usersFollowedQuery =  Yii::app()->db->createCommand()
            ->select('uc.to_user_id')
            ->from('user_connection uc, class_user cu')
            ->where('uc.from_user_id = :uid and cu.class_id = :cid and cu.user_id = uc.to_user_id', array(':cid'=>$class_id,'uid'=>$user_id))
            ->queryAll();
        $usersFollowed = */


        /*$following = [];
        foreach($user->usersFollowed as $userFollowed){
            foreach($class->users as $member){
                if($userFollowed->user_id == $member->user_id){
                    $following[] = $member->user_id;
                }
            }
        }*/
        $students = $class->students;
        $admins = $class->admins;

//        $other_courses_from_prof =  Yii::app()->db->createCommand()
//           // ->select('co.course_name, cl.section_id')
//            ->select('co.course_id,co.course_name')
//            ->from('course co, class cl')
//            ->where('cl.professor = :pid and cl.course_id = co.course_id and cl.class_id != :cid',
//                    array(':pid'=>$professor->user_id,':cid'=>$class_id))
//            ->queryAll();

        $students_following_that_took_course = User::model()->findAllBySql(' select u.*
            from class c1, class c2, class_user cu, user u, user_connection uc
             where c1.class_id = :cid and c1.course_id = c2.course_id and cu.class_id=c2.class_id
                and cu.user_id = u.user_id and u.user_id = uc.to_user_id and uc.from_user_id = :uid
                and (c2.year<c1.year or (c2.year=c1.year and ((c2.semester="spring" and (c1.semester = "summer"
                or c1.semester = "fall")) or (c2.semester="summer" and c1.semester="fall"))))'
                ,array(':uid'=>$user_id,':cid'=>$class_id));

//        $this->render('class',array('all_following'=>$students_following_that_took_course, 'students'=>$students,'admins'=>$admins, 'user'=>$user,'class'=>$class, 'course'=>$course, 'professor'=>$professor
//            , 'department'=>$department, 'is_member'=>$is_member, 'university'=>$university, 'is_admin'=>$is_admin
//            , 'schedules'=>$schedule_strings, 'files'=>$files, 'other_courses'=>$other_courses_from_prof)
//              );
        $this->render('class',array('all_following'=>$students_following_that_took_course, 'students'=>$students,'admins'=>$admins, 'user'=>$user,'class'=>$class, 'course'=>$course, 'professor'=>$professor
            , 'department'=>$department, 'is_member'=>$is_member, 'university'=>$university, 'is_admin'=>$is_admin, 'schedules'=>$schedule_strings, 'files'=>$files)
        );
    }
    public function ActionSylaUpload(){
        if (isset($_FILES['file'])) {
            // echo $errorIndex = $_FILES["file"]["error"];
            try {
                /*     * * check if a file was uploaded ** */
                if ($_FILES['file']['error'] == "UPLOAD_ERR_OK"               //checks for errors
                    && is_uploaded_file($_FILES['file']['tmp_name'])) {
                    $blockedExts = array(
                        # HTML may contain cookie-stealing JavaScript and web bugs
                        'html', 'htm', 'js', 'jsb', 'mhtml', 'mht', 'xhtml', 'xht',
                        # PHP scripts may execute arbitrary code on the server
                        'php', 'phtml', 'php3', 'php4', 'php5', 'phps',
                        # Other types that may be interpreted by some servers
                        'shtml', 'jhtml', 'pl', 'py', 'cgi',
                        # May contain harmful executables for Windows victims
                        'exe', 'scr', 'dll', 'msi', 'vbs', 'bat', 'com', 'pif', 'cmd', 'vxd', 'cpl' );

                    /*         * * assign our variables ** */
                    $file_size = $_FILES['file']['size'];
                    $file_type = $_FILES['file']['type'];
                    // $file_tmpname = $_FILES['file']['tmp_name'];
                    $file_name = $_FILES["file"]["name"];
                    $extension = pathinfo($file_name, PATHINFO_EXTENSION);
                    $file_name = str_replace(" ", "_", $file_name);
                    $maxsize = 4294960000; //4294967295
                    if(substr( $file_type, 0, 5 ) === "image"){
                        $im = new Imagick($_FILES['file']['tmp_name']);
                        //$im->setImageCompression($compression_type);
                        $im->setImageCompressionQuality(40);
                        $im->stripImage();
                        $im->writeImage($_FILES['file']['tmp_name']);
                    }

                    // $file_content = file_get_contents($_FILES['file']['tmp_name']);

                    /*         * *  check the file is less than the maximum file size ** */
                    if ($file_size < $maxsize) {
                        if(!in_array($extension, $blockedExts)) {
                            // You should name it uniquely.
                            // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
                            // On this example, obtain safe unique name from its binary data.
                            $md5_tail = date('Y-m-d H:i:s');
                            $nm= md5($_FILES['file']['name'].$md5_tail).".".$extension;
                            if (move_uploaded_file($_FILES['file']['tmp_name'], Yii::getPathOfAlias('webroot')."/assets/pdfrepo/".$nm)) {
                                $arr= array('uploadedfile'=>$nm);
                                echo json_encode($arr);
                            }else{
                                echo 'Failed to move uploaded file.';
                            }



                        }

                    }
                    else echo "We don't support this file format. Please report if you think we should.";

                } else {
                    /*             * * throw an exception is file is not of type ** */
                    echo "Mazaak(lol): You exceeded the maximum size limit";
                }
            } catch (Exception $e) {
                echo '<h4>*' . $e->getMessage() . '*</h4>';
            }
        }
    }



	public function actionClass()
	{
		$this->render('class');
	}




    public function actionCreate() {
        if(!isset($_POST['school_id']) || !isset($_POST['school_id']) || !isset($_POST['department_id']) || !isset($_POST['course_id']) || !isset($_POST['class_name']) || !isset($_POST['professor_id'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'all data not set', '_files'=>$_FILES,'_post'=>$_POST);
            $this->renderJSON($data);
            return;
        }



        $school_id = $_POST['school_id'];
        $department_id = $_POST['department_id'];
        $course_id = $_POST['course_id'];
        $class_name = $_POST['class_name'];
        $professor_id = $_POST['professor_id'];


        $component = '';
        if(isset($_POST['component'])){
            $component = $_POST['component'];
        }


        $location = '';
        if(isset($_POST['location'])){
            $location = $_POST['location'];
        }


        $datetime = '';
        if(isset($_POST['datetime'])){
            $datetime = $_POST['datetime'];
        }


        $picture_file_id = 3;






        //Get the picture file id from the department
        $department = Department::model()->find('department_id=:id', array(':id'=>$department_id));
        if($department){
            $picture_file_id = $department->cover_file_id;
        }




        include_once "color/color.php";


        $class = new ClassModel;
        $class->school_id = $school_id;
        $class->department_id = $department_id;
        $class->course_id = $course_id;
        $class->class_name = $class_name;
        $class->professor_id = $professor_id;
        $class->component = $component;
        $class->location = $location;
        $class->class_datetime = $datetime;
        $class->color_id = get_random_color();
        $class->cover_file_id = $picture_file_id;
        $class->picture_file_id = $picture_file_id;





        if($class->save(false)){
            $data = array('success'=>true, 'class'=>$class);
            $this->renderJSON($data);
            return;
        }else{
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'error saving class', '_files'=>$_FILES,'_post'=>$_POST);
            $this->renderJSON($data);
            return;
        }
	}



    public function actionFileUpload(){
        if (empty($_FILES)) {
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'class id not set', '_files'=>$_FILES,'_post'=>$_POST);
            $this->renderJSON($data);
            return;
        }


        if(!isset($_POST['id'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'class id not set','_files'=>$_FILES,'_post'=>$_POST);
            $this->renderJSON($data);
            return;
        }

        include "file_upload.php";
        try{
            $class_id = $_POST['id'];
            $local_directory = 'class/' . $class_id . '/';


            $data = file_upload($_FILES,$local_directory);
            if($data['success']){
                $class_file = new ClassFile;
                $class_file->class_id = $class_id;
                $class_file->file_id = $data['file_id'];
                $class_file->user_id = $this->get_current_user_id();
                $class_file->save(false);
                if($class_file){
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
    public function actionStoreSyllabus(){
        $class_id = $_POST["class_id"];
        $file_id = $_POST["file_id"];
        $user_id = $this->get_current_user_id();
        $official_syllabus = false;
        $current_user = $this->get_current_user();
        if($current_user["user_type"] == "p"){
            $official_syllabus = true;
        }
        $check_syllabus = ClassSyllabus::model()->find('class_id=:id and user_id=:user_id', array(':id'=>$class_id, ':user_id'=>$user_id));
        if($check_syllabus){
            $check_syllabus->updateByPk($check_syllabus->id, array("file_id"=>$file_id));
            $data = array('success'=>true);
            $this->renderJSON($data);
            return;
        }
        else{
        $class_syllabus = new ClassSyllabus;
        $class_syllabus->class_id = $class_id;
        $class_syllabus->file_id = $file_id;
        $class_syllabus->user_id = $user_id;
        $class_syllabus->official_syllabus = $official_syllabus;

        if($class_syllabus->save(false)){
                $data = array('success'=>true);
                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false,'error_id'=>1);
                $this->renderJSON($data);
                return;
            }
        }
    }

    public function actionStoreEvent(){
        $user_id = $this->get_current_user_id();
        $event = new Event;
        $event->title = $_POST["event_title"];
        $event->description = "";
        $event->event_type = "Syllabus";
        $event->user_id = $user_id;
        $event->origin_type = 'class';
        $event->origin_id = $_POST["class_id"];
        $event->start_date = $_POST["event_date"];
        $event->end_date = $_POST["event_date"];
        $event->description = $_POST["description"];
        $event->start_time = "00:00:00";
        $event->end_time = "00:00:00";
        $event->location = "";
        $event->all_day = 0;
        $event->file_id = $_POST["file_id"];
        $event->save(false);
        
        $class_user = Event::model()->deleteAll('origin_id=:id and user_id=:user_id and file_id!=:file_id', array(':id'=>$_POST["class_id"],':user_id'=>$user_id,':file_id'=>$_POST["file_id"]));


        echo $event->event_id;
    }

    public function actionUpdateSyllabusEvent(){
        if(isset($_POST["description"])){
            $to_edit = "description";
        }
        elseif(isset($_POST["location"])){
            $to_edit = "location";
        }
        else{
            $data = array('success'=>false);
            $this->renderJSON($data);
            return;
        }
        $event = Event::model()->find('event_id=:id', array(':id'=>$_POST["id"]));
        if($event){
            $event->updateByPk($event->event_id, array($to_edit=>$_POST[$to_edit]));
            $data = array('success'=>true);
            $this->renderJSON($data);
            return;
        }
    }




    public function actionGetEvents(){

        if(!isset($_GET['class_id']) || !isset($_GET['file_id'])){
            $data = array('success'=>false,'error_id'=>1, 'error_msg'=>'parameters not set');
            $this->renderJSON($data);
            return;
        }

        $class_id = $_GET["class_id"];
        $file_id = $_GET["file_id"];
        $user = $this->get_current_user($_GET);
        $user_id = $user->user_id;

        $class_events = Event::model()->findAll('origin_id=:id order by start_date asc', array(':id'=>$class_id));

        $this->renderJSON($class_events);
    }



    //modified by Tianming Xu at 01/07/2014
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

        $class_id = $_POST['id'];
        $class_user = ClassUser::model()->find('class_id=:id and user_id=:user_id', array(':id'=>$class_id,':user_id'=>$user_id));

        $class = ClassModel::model()->find('class_id=:id', array(':id'=>$class_id));
        if(!$class){
            $data = array('success'=>false,'error_id'=>2, 'error_msg'=>'class doesnt exist');
            $this->renderJSON($data);
            return;
        }

        $user = User::model()->find('user_id=:id',array(':id'=>$user_id));
        //Check if this user is already a member for this class
        if(!$class_user && $class->professor_id != $user->user_id){
            $class = ClassModel::model()->find('class_id=:id',array(':id'=>$class_id));

            //See if this user is already in a class with the same course id
            foreach($user->classes as $other_class){
                if($other_class->course_id == $class->course_id){
                    $data = array('success'=>false, 'error_id'=>11, 'error_msg'=>'Already in a class with this course');
                    $this->renderJSON($data);
                    return;
                }
            }


            //Create new class user
            $class_user = new ClassUser;
            $class_user->class_id = $class_id;
            $class_user->user_id = $user_id;
            $class_user->color_id = get_random_color();
            //If we save successfully, user is now apart of class
            if($class_user->save(false)){
                $has_admin_or_prof=ClassUser::model()->exists('class_id=:class_id and is_admin=true',array(':class_id'=>$class->class_id));
                if($class->professor){
                    $has_admin_or_prof=$has_admin_or_prof || $class->professor->status === "verified";
                }



                foreach($class->events as $event){
                    $already_attending =  EventUser::model()->exists('event_id=:eid and user_id=:uid',array(':eid'=>$event->event_id,':uid'=>$user_id));

                    $event_creator = ClassUser::model()->find('class_id=:class_id and user_id=:user_id',array(':class_id'=>$class->class_id
                    ,':user_id'=>$event->user_id));
                    //add all club events from admins (or anyone if no admis) to user's events
                    if(($this->is_urlinq_admin($user)||$event_creator->is_admin || !$has_admin_or_prof)&&!$already_attending){
                        $event_user = new EventUser();
                        $event_user->user_id = $user_id;
                        $event_user->event_id = $event->event_id;
                        $event_user->color_id = get_random_color();
                        $event_user->save();
                    }

                }

                $class_datetime = $class->class_datetime;
                

                if($class_datetime){
                    
                    $year = date("Y");
                    $date_array = array("spring" => array("start" => "01", "end" => "05", "start_day" => "20", "end_day" => "20"), "fall" => array("start" => "09", "start_day" => "01", "end" => "12", "end_day" => "20"));
                    $start_end = explode("-", substr($class_datetime, 4));
                    $start_day = $date_array[$class->semester]["start"];
                    $end_day = $date_array[$class->semester]["end"];
                    $week_day = substr($class_datetime, 0, 3);
                    $date_range = new DatePeriod(
                                    new DateTime("first $week_day of $year-$start_day"),
                                    DateInterval::createFromDateString("next $week_day"),
                                    new DateTime("$end_day month $year-01")
                                );
                    foreach ($date_range as $Day) {
                        if($Day){
                            $event_entry = new Event;
                            $event_entry->event_type = "lecture";
                            $event_entry->origin_type = "class";
                            $event_entry->origin_id = $class_id;
                            $event_entry->user_id = $user_id;
                            $event_entry->title = "Lecture";
                            $event_entry->start_time = (new DateTime($start_end[0]))->format("H:i:s");
                            $event_entry->end_time = (new DateTime($start_end[1]))->format("H:i:s");
                            $event_entry->start_date = $Day->format("Y-m-d");
                            $event_entry->end_date = $Day->format("Y-m-d");
                            $event_entry->location = $class->location;
                           
                            $event_entry->save(false);
                        }
                    }

                }
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
            $data = array('success'=>false,'error_id'=>1, 'error_msg'=>'user not logged in');
            $this->renderJSON($data);
            return;
        }

        $user_id = $user->user_id;

        $class_id = $_POST['id'];
        $class_user = ClassUser::model()->find('class_id=:id and user_id=:user_id', array(':id'=>$class_id,':user_id'=>$user_id));
        //Check if this user is even in this class
        if($class_user){
            //Check if we destroy this shit successfully
            if($class_user->delete()){

                //Loop through all events this user has for this class and delete them
                //Or else the database will get fucked up
                $user_events = EventUser::model()->findAllBySql("SELECT event_user.* FROM `event_user` JOIN `event` ON (event.event_id = event_user.event_id) WHERE event_user.user_id = " . $user->user_id . " AND event.origin_type = 'class' AND event.origin_id = " . $class_id);

                foreach($user_events as $event_user){
                    $event_user->delete();
                }
                //Get the events that this
                $events = Event::model()->findAllBySql("SELECT * FROM `event` WHERE event.user_id = " . $user->user_id . " AND event.origin_type = 'class' AND event.origin_id = " . $class_id);

                //$all_events = array_merge($events,$user_events);
                foreach($events as $event){
                    $event->delete();
                }

                //We also need to delete all posts that have the type event from this user in this group
                $posts = Post::model()->findAllBySql('SELECT * FROM `post` WHERE post_type = "event" AND  origin_type = "class" AND origin_id = ' . $class_id);
                foreach($posts as $post){
                    $post->delete();
                }



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


    public function actionGetSyllabusPDF(){
        $official_syllabus = true;
        $edit_access = false;
        $class_id= $_GET["class_id"];
        $user_id = $this->get_current_user_id();
        $class_syllabus = ClassSyllabus::model()->find('class_id=:id and official_syllabus=1', array(':id'=>$class_id));
        if(!$class_syllabus){
            $official_syllabus = false;
        $class_syllabus = ClassSyllabus::model()->find('class_id=:id and user_id=:user_id', array(':id'=>$class_id, ':user_id'=>$user_id));
        }

        if($class_syllabus){
            if($user_id == $class_syllabus["user_id"]){
                $edit_access = true;
            }
            $file= File::model()->find('file_id=:id', array(':id'=>$class_syllabus["file_id"]));
            $data = array('file_id'=>$file["file_id"],'file_url'=>$file["file_url"],'official_syllabus'=>$official_syllabus,'edit_access'=>$edit_access);
            $this->renderJSON($data);
            return;
        }
        else{
            $this->renderJSON(array("success"=>false));
            return;
        }

    }

    public function actionGetClassColor(){
        $class_id= $_POST["class_id"];
        
        $class = ClassUser::model()->find('class_id=:id', array(':id'=>$class_id));

        $color = Color::model()->find('color_id=:id', array(':id'=>$class["color_id"]));
        if($color){
            echo $color["hex"];
        }
        else{
            echo "#3ab9f7";
        }
    }

    //Returns only files uploaded by the professor
    public function actionClassFiles (){
        if(!isset($_GET['id'])){
            $data = array('success'=>false,'error_id'=>1);
            $this->renderJSON($data);
            return;
        }

        $user_id = $this->get_current_user_id();

        $class_id = $_GET['id'];
        $class = ClassModel::model()->find('class_id=:id', array(':id'=>$class_id));
        //Check if this user is even in this class
        if($class){
            //Check if we destroy this shit successfully
            $data = array('success'=>true,'files'=>$class->classFiles());
            $this->renderJSON($data);
            return;
        }else{
            //user is not apart of this class
            $data = array('success'=>false,'error_id'=>2);
            $this->renderJSON($data);
            return;
        }
    }


    //Returns only files uploaded by the professor
    public function actionStudentFiles (){
        if(!isset($_GET['id'])){
            $data = array('success'=>false,'error_id'=>1);
            $this->renderJSON($data);
            return;
        }

        $user_id = $this->get_current_user_id();

        $class_id = $_GET['id'];
        $class = ClassModel::model()->find('class_id=:id', array(':id'=>$class_id));
        //Check if this user is even in this class
        if($class){
            //Check if we destroy this shit successfully
            $data = array('success'=>true,'files'=>$class->studentFiles());
            $this->renderJSON($data);
            return;
        }else{
            //user is not apart of this class
            $data = array('success'=>false,'error_id'=>2);
            $this->renderJSON($data);
            return;
        }
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

        $class_id = $_POST['group_id'];
        $class_user = ClassUser::model()->find('class_id=:id and user_id=:user_id', array(':id'=>$class_id,':user_id'=>$current_user_id));
        //Check if the current user is even in this group
        if($this->is_urlinq_admin($user)||$class_user){
            //Check if current user is an admin of this group
            if($this->is_urlinq_admin($user)||$class_user->is_admin){
                $class_user_to_remove = ClassUser::model()->find('user_id=:uid and class_id=:cid',array(':cid'=>$class_id,':uid'=>$user_to_remove->user_id));
                //Check if we destroy this shit successfully
                if($class_user_to_remove->delete()){


                    //Loop through all events this user has for this group and delete them
                    //Or else the database will get fucked up
                    $user_events = EventUser::model()->findAllBySql("SELECT * FROM `event_user` JOIN `event` ON (event.event_id = event_user.event_id) WHERE event_user.user_id = " .$user_to_remove->user_id . " AND event.origin_type = 'class' AND event.origin_id = " . $class_id);
                    foreach($user_events as $event){
                        $event->delete();
                    }

                    //Get the events that this
                    $events = Event::model()->findAllBySql("SELECT * FROM `event` WHERE event.user_id = " . $user_to_remove->user_id . " AND event.origin_type = 'class' AND event.origin_id = " . $class_id);


                    foreach($events as $event){
                        $event->delete();
                    }

                    //We also need to delete all posts from this user in this group
                    $posts = Post::model()->findAllBySql('SELECT * FROM `post` WHERE  user_id = '.$user_to_remove->user_id.' AND origin_type = "class" AND origin_id = ' . $class_id);
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
            //user is not a part of this group
            $data = array('success'=>false,'error_id'=>2, 'error_msg'=>'user not in the group');
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



        $class_id = $_GET['id'];
        $file_id = $_POST['file_id'];

        $class = ClassModel::model()->find('class_id=:id',array(':id'=>$class_id));


        if($class){
            $class_file = ClassFile::model()->findBySql('SELECT * FROM `class_file` WHERE class_id=' . $class_id . ' AND file_id=' . $file_id);
            if($class_file){
                if($class_file->delete()){
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


    public function actionEventFileUpload(){
        if (empty($_FILES)) {
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'class id not set', '_files'=>$_FILES,'_post'=>$_POST);
            $this->renderJSON($data);
            return;
        }


        if(!isset($_POST['id'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'class id not set','_files'=>$_FILES,'_post'=>$_POST);
            $this->renderJSON($data);
            return;
        }

        include "file_upload.php";
        try{
            $class_id = $_POST['id'];
            $local_directory = 'class/' . $class_id . '/';


            $data = file_upload($_FILES,$local_directory);
            if($data['success']){
                $event_file = new EventFiles;
                $event_file->event_id = $_POST['event_id'];
                $event_file->user_id = $this->get_current_user_id();
                $event_file->file_id = $data['file_id'];
                $event_file->origin_id = $_POST['id'];
                $event_file->save(false);
                if($event_file){
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

    public function actionGetEventFiles(){

        if(!isset($_GET['id'])){
            $data = array('success'=>false,'error_id'=>1, 'error_msg'=>'parameters not set');
            $this->renderJSON($data);
            return;
        }

        $event_id = $_GET["id"];
        $origin_id = $_GET["origin_id"];
        $user_id = $this->get_current_user();

        $event_files = EventFiles::model()->findAll('origin_id=:id and event_id=:event_id', array(':id'=>$origin_id, ':event_id'=>$event_id));
        $filearray = array();
        foreach ($event_files as $key => $value) {
            array_push($filearray, $value->file_id);
        }
        $criteria = new CDbCriteria();
        $criteria->select = "*";
        $criteria->addInCondition('file_id', $filearray);
        $event_json = File::model()->findAll($criteria);



        $this->renderJSON($event_json);
        return;
    }

    public function actionSearchEvents(){

        if(!isset($_POST['origin_id'])){
            $data = array('success'=>false,'error_id'=>1, 'error_msg'=>'parameters not set');
            $this->renderJSON($data);
            return;
        }

        $origin_id = $_POST["origin_id"];
        $keyword = $_POST["keyword"];
        $user_id = $this->get_current_user();

        $events = Yii::app()->db->createCommand("SELECT * FROM `event` WHERE event.origin_id=".$origin_id." AND (event.title LIKE '%" . $keyword . "%' OR description LIKE '%" . $keyword . "%')")->queryAll();

        $this->renderJSON($events);
        return;
    }

    public function actiongetpeopleattending(){
        if(!isset($_POST['event_id'])){
            $data = array('success'=>false,'error_id'=>1, 'error_msg'=>'parameters not set');
            $this->renderJSON($data);
            return;
        }

        $event_id = $_POST["event_id"];

        $users = Yii::app()->db->createCommand("SELECT user_id FROM `event_user` WHERE event_user.event_id=".$event_id)->queryAll();
        if($users){
            $clause = '';
            foreach ($users as $key) {

                $clause = $clause.$key["user_id"].',';
                # code...
            }
            $user_details = Yii::app()->db->createCommand("SELECT user.firstname, user.lastname, file.file_url from `user`, `file` WHERE user.user_id in (".rtrim($clause, ",").") and user.picture_file_id=file.file_id")->queryAll();
            $this->renderJSON($user_details);
            return;
        }
            $this->renderJSON(array());
            return;
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
