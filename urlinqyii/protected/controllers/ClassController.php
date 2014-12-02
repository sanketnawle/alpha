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
        $user = User::model()->find('user_id=:id', array(':id'=>$user_id));

        $course = $class->course;

        $professor = User::model()->find('user_id = :id',array(':id'=>$class->professor));

        $department = $class->department;
        $university = $class->school;

        $schedules = $class->schedules;

        $schedule_strings = [];
        foreach($schedules as $schedule){
            $schedule_strings[] = $schedule->day . ' ' . $schedule->start_time . ' to ' . $schedule->end_time;
        }
        $is_member = false;

        foreach ($class->users as $student) {
            if($user->user_id == $student->user_id){
                $is_member = true;
                break;
            }
        }

        $is_admin = false;
        foreach ($class->admins as $student) {
            if($user->user_id == $student->user_id){
                $is_admin = true;
                break;
            }
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

        $other_courses_from_prof =  Yii::app()->db->createCommand()
           // ->select('co.course_name, cl.section_id')
            ->select('co.course_id,co.course_name')
            ->from('course co, class cl')
            ->where('cl.professor = :pid and cl.course_id = co.course_id and cl.class_id != :cid',
                    array(':pid'=>$professor->user_id,':cid'=>$class_id))
            ->queryAll();

        $students_following_that_took_course = User::model()->findAllBySql(' select u.*
            from class c1, class c2, class_user cu, user u, user_connection uc
             where c1.class_id = :cid and c1.course_id = c2.course_id and cu.class_id=c2.class_id
                and cu.user_id = u.user_id and u.user_id = uc.to_user_id and uc.from_user_id = :uid
                and (c2.year<c1.year or (c2.year=c1.year and ((c2.semester="spring" and (c1.semester = "summer"
                or c1.semester = "fall")) or (c2.semester="summer" and c1.semester="fall"))))'
                ,array(':uid'=>$user_id,':cid'=>$class_id));

        $this->render('class',array('all_following'=>$students_following_that_took_course, 'students'=>$students,'admins'=>$admins, 'user'=>$user,'class'=>$class, 'course'=>$course, 'professor'=>$professor
            , 'department'=>$department, 'is_member'=>$is_member, 'university'=>$university, 'is_admin'=>$is_admin
            , 'schedules'=>$schedule_strings, 'files'=>$files, 'other_courses'=>$other_courses_from_prof)
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
    public function actionJoinClass(){
        if(isset($_POST['class']) && isset($_POST['user'])){
            $userClass = ClassUser::model()->find('user_id=:uid and class_id=:cid', array(':uid'=>$_POST['user'],':cid'=>$_POST['class']));
            if($userClass){
                if($userClass->delete()){
                    $this->renderJSON(array('status'=>'success','action'=>'withdraw'));
                }else{
                    $this->renderJSON(array('status'=>'error',$userClass->getError()));
                }
            }else{
                $userClass = new ClassUser();
                $userClass->user_id = $_POST['user'];
                $userClass->class_id = $_POST['class'];
                if($userClass->save()){
                    $this->renderJSON(array('status'=>'success','action'=>'enroll'));
                }
                else{
                    $this->renderJSON(array('status'=>'error','message'=>$userClass->getError()));
                }
            }
        }else{
            $this->renderJSON(array('status'=>'error','message'=>'post data not set'));
        }
    }
	public function actionClass()
	{
		$this->render('class');
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