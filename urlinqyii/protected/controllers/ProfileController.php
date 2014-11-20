<?php

class ProfileController extends Controller
{


    //public $layout='//layouts/main';


	public function actionIndex(){
		$this->render('index');
	}



    public function actionGetPosts(){

        $data = array('test'=>'this is inside the profile controller and it getting my posts','test_array'=>array(1,2,3,4));

        $this->renderJSON($data);
    }


    //http://localhost/urlinqyii/profile/1
    public function actionView() {

        $user_id = $_GET['id'];
        $signedInUser = 2;
        $userProfile = User::model()->find('user_id=:id', array(':id'=>$user_id));
        $currentUser = User::model()->find('user_id=:id',array(':id'=>$signedInUser));
        $school = $userProfile->school;
        $university = $school->university;
        $department = $userProfile->department;
        $is_user = ($userProfile->user_id == $currentUser->user_id);
        $courses = $userProfile->userClasses;
        $clubs = $userProfile->groups;

        $following = $userProfile->usersFollowed;
        $followers = $userProfile->usersFollowing;

        $interests = $userProfile->userInterests;
        $showcase = $userProfile->showcase;



        $this->render('profile',array('user'=>$currentUser,'userProfile'=>$userProfile,'school'=>$school,'university'=>$university,'department'=>$department
            ,'is_user'=>$is_user, 'courses'=>$courses, 'clubs'=>$clubs, 'following'=>$following,'followers'=>$followers, 'interests'=>$interests, 'showcase'=>$showcase));
    }

    public function actionAddInterest(){

        if (isset($_POST['name'])) {
            $interest = Tag::model()->find('tag=:name', array(':name' => $_POST['name']));
            if (!$interest) {
                $interest = new Tag();
                $interest->tag = $_POST['name'];

                if (!$interest->save()) {
                    echo 'error: could not create new tag';
                    return;
                }
            }
            $userInterest = UserInterest::model()->find('tag_id=:tid and user_id=:uid'
                , array(':tid' => $interest->tag_id, 'uid' => $_POST['user_id']));
            if ($userInterest) {
                echo 'error: already in interests';
            } else {
                $userInterest = new UserInterest();
                $userInterest->user_id = $_POST['user_id'];
                $userInterest->tag_id = $interest->tag_id;
                if (!$userInterest->save()) {
                    echo 'error:could not create new user-tag connection';
                    return;
                }
                echo $_POST['name'];
            }
        }else{
            echo 'error: did not receive data';
        }
    }
    public function actionProcessThumbify(){
        file_put_contents(Yii::getPathOfAlias('webroot') . '/assets/uploads/2/test/stuff.txt', "in method");
        if(isset($_POST['data'])) {
            $data = json_decode($_POST['data'], true);
            file_put_contents(Yii::getPathOfAlias('webroot') . '/assets/uploads/2/test/stuff2.txt', "received post data");
//We'll use the GUID as our filename, but you should probably do something a bit smarter
            $file_preview = Yii::getPathOfAlias('webroot') . '/assets/uploads/2/preview/' . $data['payload']['reference'] . '.jpg';
//You could use the reference you passed in to write to a more appropriate file name
//$file = "/path_to_storage/{$data['payload']['reference']}.jpg"

//Check to see if everything has gone well
            if ($data['status'] === "success") {
                //If it has, then write the base64 decoded data to a file (which gives us our jpg file)
                file_put_contents($file_preview, base64_decode($data['payload']['image']));
            } else {
                //If it hasn't then, panic! Or just do something smarter
                echo "Bad things have happened like ->" . $data['payload']['message'];
            }
            return "receive";
        }
    }
    public function actionThumbify($path, $user_id){
        //Build an array of the POST data you want to send to the thumbifier.

            $file_name = basename($path);
            $data = array(
                "token" => "A40B08616CCFDCCDC5BAD4C31140E71C",
                "url" => $path,
                "quality" => "80",
                "size" => "256x256",
                //"reference" => "my_internal_file_db_id",
                //"page" => "0",
                "callback" => Yii::app()->getBaseUrl(true) . "/profile/processThumbify",
            );

//Build a HTTP Query from with the data you want to post (the above array)
            $postdata = http_build_query($data);
//Set the options for the HTTP Stream to be a POST method and to contain your HTTP Query data (your POST data)
            $opts = array("http" =>
                array(
                    "method" => "POST",
                    "header" => "Content-type: application/x-www-form-urlencoded",
                    "content" => $postdata
                )
            );
//Create a stream with the above options, which will make the file_get_contents perform a POST to the web service.
            $context = stream_context_create($opts);
//Now call the thumbify.me service as a POST with your given data.
            $result = file_get_contents("http://www.thumbify.me", false, $context);
            print_r( $result);
            $data = json_decode($result, true);

            if ($data['status'] === "success") {
                print_r($_REQUEST);
            }
            else return "fail";


    }
    public function actionAddShowcase(){
        $uploaddir='/assets/uploads/'.$_POST['user'].'/';
        if(!is_dir(Yii::getPathOfAlias('webroot').$uploaddir)) {
            mkdir(Yii::getPathOfAlias('webroot').$uploaddir);
        }
        if(!is_dir(Yii::getPathOfAlias('webroot').$uploaddir.'preview/')) {
            mkdir(Yii::getPathOfAlias('webroot').$uploaddir.'preview/');
        }
        if (isset($_FILES['file'])) {

            $file = $_FILES['file'];
            $file_name = basename($file['name']);
            $previous_record = File::model()->find('file_url=:furl',array(':furl'=>$uploaddir.$file_name));
            if($previous_record) {
                echo 'error: there is already a file of the same name in your showcase';
                return;
            }else{
                if(!move_uploaded_file($file['tmp_name'], Yii::getPathOfAlias('webroot').$uploaddir.$file_name)) {
                    echo 'error: could not upload file';
                    return;
                }
            }

        }else if(isset($_POST['link_url'])){
            $file_name = basename($_POST['link_url']);
            $previous_record = File::model()->find('file_url=:furl',array(':furl'=>$uploaddir.$file_name));
            if($previous_record) {
                echo 'error: there is already a file of the same name in your showcase';
                return;
            }else{
                if(!file_put_contents(Yii::getPathOfAlias('webroot').$uploaddir.$file_name,file_get_contents($_POST['link_url']))){
                    echo 'error: could not get file from link';
                    return;
                }
            }

        }else{
            echo 'error: failed to load file';
            return;
        }
        //create preview if file is not image
        preg_match('/[.](.+)/',$file_name,$match);
        $extension = $match[1];
        if($extension == "jpg" || $extension == "png"){
            $type = 'image';
            copy(Yii::getPathOfAlias('webroot').$uploaddir.$file_name, Yii::getPathOfAlias('webroot').$uploaddir."preview/");
        }
        else if($extension == "doc" || $extension == "docx"){
            $type = 'document';
            echo "error: cannot do this filetype yet";
            //$derp = $this->actionThumbify($_POST['link_url'],$_POST['user']);
        }
        else if($extension == "pdf"){
            $type = 'pdf';
            echo "error: cannot do this filetype yet";
            //$derp = $this->actionThumbify($_POST['link_url'],$_POST['user']);
        }

        $fileRecord = new File();
        $fileRecord->file_name = $file_name;
        $fileRecord->file_url = $uploaddir.$file_name;

        $fileRecord->file_extension = $extension;
        $fileRecord->file_type = $type;
        $fileRecord->created_timestamp = new CDbExpression('NOW()');
        if (!$fileRecord->save()) {
            echo "error: could not create file record\n";
            print_r($fileRecord->getErrors());
            return;
        }

        $previous_showcase = Showcase::model()->find('user_id=:uid and file_id=:fid',
            array(':uid'=>$_POST['user'],':fid'=>$fileRecord->file_id));
        if($previous_showcase){
            echo 'error:this file is already in your showcase';
            return;
        }
        $showcase = new Showcase();
        $showcase->user_id = $_POST['user'];
        $showcase->file_id = $fileRecord->file_id;
        $showcase->file_share_type='regular';
        $showcase->file_desc = $_POST['title'];
        if(!$showcase->save()){
            echo "error: could not create showcase record\n";
            print_r($showcase->getErrors());
            return;
        }
        echo $uploaddir.$file_name;
    }
    public function actionAutoComplete(){

    }
    public function actionEditProfile(){
        $new_data = array();
        if(isset($_POST['year'])){
            $student_attributes = StudentAttrib::model()->find('user_id=:uid',array(':uid'=>$_POST['user']));
            $student_attributes->year = $_POST['year'];
            if($student_attributes->save()){
                $new_data['year'] = "success";
            }else{
                $new_data['year'] = $student_attributes->getErrors();
            }

        }
        if(isset($_POST['bio'])){
            $user = User::model()->find('user_id=:uid',array(':uid'=>$_POST['user']));
            $user->user_bio = $_POST['bio'];
            if($user->save()){
                $new_data['bio'] = "success";
            }else{
                $new_data['bio'] = $user->getErrors();
            }

        }
        $this->renderJSON($new_data);
    }
    /*public function actionAutoComplete(){

    }*/
    public function actionChangeVisibility(){
        //public , just me, followers

        $user_id = Yii::app()->session['user_id'];


        $course_id = $_POST['course_id'];
        $visibility_id = $_POST['visibility_id'];

        $course_user = CourseUser::model()->find('user_id=:id,course_id=:course_id', array(':id'=>$user_id,':course_id'=>$course_id));

        $course_user->visibility_id = $visibility_id;

        $course_user->save();

    }




}