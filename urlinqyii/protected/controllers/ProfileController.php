<?php

class ProfileController extends Controller
{


    //public $layout='//layouts/main';


	/*public function actionIndex(){
		$this->render('index');
	}



    public function actionGetPosts(){

        $data = array('test'=>'this is inside the profile controller and it getting my posts','test_array'=>array(1,2,3,4));

        $this->renderJSON($data);
    }*/


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

        $clubs = $userProfile->groups;

        $following = $userProfile->usersFollowed;
        $followers = $userProfile->usersFollowing;

        $interests = $userProfile->userInterests;
        $showcase_info = $userProfile->showcase;
        $majors = $userProfile->majors;
        $minors = $userProfile->minors;
        $closedInstructions = $userProfile->closed_showcase_instructions;
        $random_image_url = 'https://s3.amazonaws.com/suh-s3-nfs/static/images/Profile_Backgrounds/'.rand(1, 120).'.jpg';
       // $default_privacy = $userProfile->privacy;


        $you_follow = false;
        foreach($followers as $follower){
            if($follower->user_id == $signedInUser){
                $you_follow = true;
                break;
            }
        }
        $follows_you = false;
        foreach($following as $followed){
            if($followed->user_id == $signedInUser){
                $follows_you = true;
                break;
            }
        }
        if($is_user) {
            $courses = $userProfile->classUsersAll;
        }
        else if($you_follow){
            $courses = $userProfile->classUsersForFollowers;
        }else{
            $courses = $userProfile->classUsersForNonFollowers;
        }



      //  $command = Yii::app()->db->createCommand('select m.name from user_major um, major m where um.user_id = '.$user_id.' and um.major_id = m.id');
      //  $majors = $command->queryAll();
       // $showcase_files= $$userProfile->showcase_files;



        $this->render('profile',array('user'=>$currentUser,'userProfile'=>$userProfile,'school'=>$school,'university'=>$university,'department'=>$department
            ,'is_user'=>$is_user, 'courses'=>$courses, 'clubs'=>$clubs, 'following'=>$following,'followers'=>$followers, 'interests'=>$interests
            , 'showcase'=>$showcase_info, 'majors'=>$majors, 'minors'=>$minors, 'you_follow'=>$you_follow, 'both_follow'=>$you_follow&&$follows_you
            , 'closedInstructions'=>$closedInstructions, 'random_image_url'=>$random_image_url));
    }

    public function actionAddInterest($interests,$user_id){

        //if (isset($_POST['interests'])) {
            foreach($interests as $name){
                $interest = Tag::model()->find('tag=:name', array(':name' => $name));
                if (!$interest) {
                    $interest = new Tag();
                    $interest->tag = $name;

                    if (!$interest->save()) {
                       // $this->renderJSON(array('status'=>'error','message'=>'could not create new tag'));
                        return 'error: could not create new tag';
                    }
                }
                $userInterest = UserInterest::model()->find('tag_id=:tid and user_id=:uid'
                    , array(':tid' => $interest->tag_id, 'uid' => $user_id));
                if ($userInterest) {
                    return 'error: already in interests';

                } else {
                    $userInterest = new UserInterest();
                    $userInterest->user_id = $user_id;
                    $userInterest->tag_id = $interest->tag_id;
                    if (!$userInterest->save()) {
                        return 'error: could not create new user-tag connection';
                    }
                    return 'success';
                }
            }

      //  }else{
     //       $this->renderJSON(array('status'=>'error','message'=>'no post interest'));
      //  }
    }
   /* public function actionProcessThumbify(){
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
    }*/
   /* public function actionThumbify($path, $user_id){
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


    }*/
    public function actionUpdateHere(){
        $vis_var=$_POST['selected'];
      //  echo $vis_var;
        $vis_var=(string)$vis_var;
       $user_id=1;
        $user_group = GroupUser::model()->find('user_id=:id', array(':id'=>$user_id));
//      $user_group = $user->group_user;
//        var_dump($user_group);
        $user_group->attributes=array('privacy'=>$vis_var);
        $user_group->save();

    }

    public function getImageFromWebsite($url){
        include 'simple_html_dom.php';
        include 'url_to_absolute.php';

        //should pick which image somehow

       $html = file_get_html($url);
         /*      $image_files = array();
             $image_urls = array();
            foreach($html->find('img') as $i=>$element) {
                 $image_files[$i]['url'] = url_to_absolute($url,$element->src);
                 $question_mark_index = strpos($image_files[$i]['url'],'?');
                 if($question_mark_index != false){
                     $image_files[$i]['url'] = substr($url,0,$question_mark_index);
                 }
                 $file_name = basename($image_files[$i]['url']);
                 $image_files[$i]['file_path'] = '/assets/temp/'.$file_name;
                 file_put_contents(Yii::getPathOfAlias('webroot') .'/assets/temp/'.$file_name, file_get_contents($image_files[$i]['url']));
             }
             $max_size = 0;
             foreach($image_files as $i=>$image_file){
                 list($width, $height, $type, $attr) = getimagesize(Yii::getPathOfAlias('webroot') .$image_file['file_path']);
                 if($width*$height>$max_size){
                     $max_size = $width*$height;
                     $best_image_index = $i;
                 }
             }


             //$preview_image = url_to_absolute($url,$html->find('img')[0]->src);
             //returns largest image
             return $image_files[$best_image_index]['url'];*/
        try {
            $preview_image = url_to_absolute($url, $html->find('img')[0]->src);
        }catch(Exception $e){
            return null;
        }
        return $preview_image;
     }
     //creates a record of a file from a link
     public function fileFromLink($url, $path, $user_id){
         //example of path: 'uploads/preview/'
         $user = User::model()->find('user_id=:id', array(':id'=>$user_id));

         include "UniqueTokenGenerator.php";
         //preg_match('/[.]([a-zA-Z]{3,4})$/',$url,$match);
         $path_parts = pathinfo(basename($url));
         if(isset($path_parts['extension'])){
             $extension = $path_parts['extension'];
         }
         else{
             $extension = 'jpg';
         }
         $question_mark_index = strpos($extension,'?');
         if($question_mark_index != false){
             $extension = substr($extension,0,$question_mark_index);
         }

         $question_mark_index = strpos($url,'?');
         if($question_mark_index != false){
             $url = substr($url,0,$question_mark_index);
         }
         //$extension = $match[1];


         //$file_type = getFileMimeType($files["uploadFile"]['tmp_name']);
         $file_type = $extension; //temporary
         $random_name = token($user->user_id,$user->firstname);



         $local_directory = 'assets/'.$path;
         if(!is_dir($local_directory)) {
             mkdir($local_directory);
         }
         try{
            file_put_contents($local_directory . $random_name .'.' .  $extension, file_get_contents($url));
         }catch(Exception $e){
             return null;
         }
         if($extension == 'jpg' || $extension == 'png' || $extension == 'gif'){
             include "ImageCompress.php";
             image_compress($local_directory . $random_name .'.' .  $extension, $local_directory . $random_name . '.jpg', 50);
             if($extension != 'jpg'){
                 unlink($local_directory . $random_name .'.' .  $extension);
             }

             $extension = 'jpg';
         }


         //Create file in file table here
         $file = new File;
         $file->file_name = $random_name . '.' . $extension;
         $file->file_url = $file_url = "/" . $local_directory . $random_name . '.' . $extension;
         $file->file_type = $file_type;
         $file->file_extension = $extension;

         $file->save(false);
         //Use the origin and id to add files either to associative table or to a main field

         //$this->renderJSON(array('success'=>true,'file_type'=>$file_type,'file_id'=>$file->file_id,'file_name'=>$random_name . '.' . $extension,'origin_type'=>$origin_type,'origin_id'=>$origin_id,'extension'=>$extension));
         //$this->renderJSON(array('success'=>true,'file_type'=>$file_type,'file_id'=>$file->file_id,'file_name'=>$random_name . '.' . $extension,'file_url'=>$file->file_url,'extension'=>$extension));
         return array('success'=>true,'file_type'=>$file_type,'file_id'=>$file->file_id,'file_name'=>$random_name . '.' . $extension,
             'file_url'=>$file->file_url,'extension'=>$extension);

     }
   //  public function updateMajorMinor
     public function actionAddShowcase(){
         include "file_upload.php";
         if (isset($_FILES['uploadFile'])) {
             $result = file_upload($_FILES,"showcase/");
             if($result['extension']=='jpg'||$result['extension']=='png'||$result['extension']=='gif'){
                 $preview_image = $result;
             }
             $share_type='regular';
            /* $file_name = basename($file['name']);
             $previous_record = File::model()->find('file_url=:furl',array(':furl'=>$uploaddir.$file_name));
             if($previous_record) {
                 $this->renderJSON(array('status'=>'error','message'=>'there is already a file of the same name in your showcase'));
                 return;
             }else{
                 if(!move_uploaded_file($file['tmp_name'], Yii::getPathOfAlias('webroot').$uploaddir.$file_name)) {
                     $this->renderJSON(array('status'=>'error','message'=>'could not upload file'));
                     return;
                 }
             }*/

        }else if(isset($_POST['link_url'])){
            $file_name = basename($_POST['link_url']);
            $ext = preg_match('/[.](.+)$/',$file_name,$match);

            if($ext == 0|| ($match[1]!='jpg' && $match[1]!='png' && $match[1]!='gif' && $match[1]!='doc' && $match[1]!='docx' && $match[1]!='xlsx'
                    && $match[1]!='pdf' && $match[1]!='xls' && $match[1]!='ppt' && $match[1]!='pptx') ){
                $preview_url = $this->getImageFromWebsite($_POST['link_url']);
              //  $this->renderJSON(array('status'=>'error','message'=>$preview_url));
               // return;
                    $preview_image = $this->fileFromLink($preview_url,'showcase/preview/', $_POST['user']);



                //temporary. Possibly should use showcase_link table
                $file = new File;
                $file->file_name = $_POST['link_url'];
                $file->file_url = $_POST['link_url'];
                $file->file_type = 'url';
                $file->file_extension = 'url';
                $file->origin_type = 'link';
                $file->save(false);
                $result = array('success'=>true,'file_type'=>'link','file_id'=>$file->file_id,'file_name'=>$_POST['link_url'],'file_url'=>$file->file_url,'extension'=>'url');

                $share_type = 'link';
            }
            else{

                $result = $this->fileFromLink($_POST['link_url'],'showcase/',$_POST['user']);
                if($result['extension']=='jpg'||$result['extension']=='png'||$result['extension']=='gif'){
                    $preview_image = $result;
                }
                $share_type='regular';
            }


        }else{
            $this->renderJSON(array('status'=>'error','message'=>'failed to load file'));
            return;
        }
     /*   if($result)
        //create preview if file is not image
        preg_match('/[.](.+)/',$file_name,$match);
        $extension = $match[1];
        if($extension == "jpg" || $extension == "png"){
            $type = 'image';
            copy(Yii::getPathOfAlias('webroot').$uploaddir.$file_name, Yii::getPathOfAlias('webroot').$uploaddir."preview/".$file_name);
        }
        else if($extension == "doc" || $extension == "docx"){
            $type = 'document';
            $this->renderJSON(array('status'=>'error','message'=>'cannot do this filetype yet'));
            //$derp = $this->actionThumbify($_POST['link_url'],$_POST['user']);
        }
        else if($extension == "pdf"){
            $type = 'pdf';
            $this->renderJSON(array('status'=>'error','message'=>'cannot do this filetype yet'));
            //$derp = $this->actionThumbify($_POST['link_url'],$_POST['user']);
        }

        $fileRecord = new File();
        $fileRecord->file_name = $file_name;
        $fileRecord->file_url = $uploaddir.$file_name;

        $fileRecord->file_extension = $extension;
        $fileRecord->file_type = $type;
        $fileRecord->created_timestamp = new CDbExpression('NOW()');
        if (!$fileRecord->save()) {
            $errors = print_r($fileRecord->getErrors());
            $this->renderJSON(array('status'=>'error','message'=>$errors));
            return;
        }*/

        $previous_showcase = Showcase::model()->find('title=:title',array(':title'=>$_POST['title']));
        if($previous_showcase){
            $this->renderJSON(array('status'=>'error','message'=>'this file is already in your showcase'));
            return;
        }
        $showcase = new Showcase();
        $showcase->user_id = $_POST['user'];
        $showcase->file_id = $result['file_id'];
        $showcase->file_share_type=$share_type;
        $showcase->file_desc = $_POST['desc'];
        $showcase->title = $_POST['title'];
        $showcase->created_timestamp = new CDbExpression('NOW()');
        if(isset($preview_image)){
            $showcase->preview_file_id = $preview_image['file_id'] ;
        }

        if(!$showcase->save()){
            $errors = print_r($showcase->getErrors());
            $this->renderJSON(array('status'=>'error','message'=>$errors));
            return;
        }
        if(isset($preview_image)){
            $this->renderJSON(array('status'=>'success','message'=>$result['file_url'],'file_extension'=>$result['extension'],
                'title'=>$showcase->title, 'desc'=>$showcase->file_desc,'preview_file'=>$showcase->preview_image->file_url));
        }else{
            $this->renderJSON(array('status'=>'success','message'=>$result['file_url'],'file_extension'=>$result['extension'],
                'title'=>$showcase->title, 'desc'=>$showcase->file_desc));
        }

    }
    public function actionAutoComplete(){
        $result = [];
        if(isset($_GET['major'])){
            $majors=Major::model()->findAll(array(
                'condition' => 'name like :text',
                'limit' => 10,
                'params' => array(':text' => '%'.$_GET['major'].'%'),
            ));
            foreach($majors as $major){
                $result[] = array(
                    "label" => $major->name
                );
            }
        }else if(isset($_GET['school'])){
            $schools=School::model()->findAll(array(
                'condition' => 'school_name like :text',
                'limit' => 10,
                'params' => array(':text' => '%'.$_GET['school'].'%'),
            ));
            foreach($schools as $school){
                $result[] = array(
                    "label" => $school->school_name
                );
            }
        }

        $this->renderJSON($result);
    }
    public function updateMajorsMinors($name_list,$focus, $user_id){
        //check all major names are valid
        //$names_valid=true;
        $majors = []; //can be major or minor
        $data = array();

        foreach($name_list as $majorname){

            $major = Major::model()->find('name = :mname',array(':mname'=>$majorname));
            if(!$major){
                $data = 'failure: some major names are not valid';
                return $data;
            }else{
                $majors[] = $major;
            }
        }

        UserMajor::model()->deleteAll('user_id = :uid and focus = :focus',array(':uid'=>$user_id,':focus'=>$focus));
        foreach($majors as $major){
            $userMajor = new UserMajor();
            $userMajor->user_id = $user_id;
            $userMajor->major_id = $major->id;
            $userMajor->degree_type_id = 3;//temporary
            $userMajor->focus = $focus;
            if(!$userMajor->save()){
                $not_saved = $userMajor;
            }

        }
        if(isset($not_saved)){
            $data = $not_saved->getErrors();
        }else{
            $data = 'success';
        }
        return $data;

    }
    public function actionEditProfile(){
        $new_data = array();
        $user_id = $_POST['user'];
        if(isset($_POST['year'])){
            $student_attributes = StudentAttrib::model()->find('user_id=:uid',array(':uid'=>$user_id));
            $student_attributes->year = $_POST['year'];
            if($student_attributes->save()){
                $new_data['year'] = "success";
            }else{
                $new_data['year'] = $student_attributes->getErrors();
            }

        }
        if(isset($_POST['bio'])){
            $user = User::model()->find('user_id=:uid',array(':uid'=>$user_id));
            $user->user_bio = $_POST['bio'];
            if($user->save()){
                $new_data['bio'] = "success";
            }else{
                $new_data['bio'] = $user->getErrors();
            }

        }
        if(isset($_POST['name'])){
            $user = User::model()->find('user_id=:uid',array(':uid'=>$user_id));
            $name = explode(' ',$_POST['name']);
            if(sizeof($name) < 2){
                $user->firstname = $name;
            }else if(sizeof($name) == 2){
                $user->firstname = $name[0];
                $user->lastname = $name[1];
            }else{
                $user->firstname = $name[0];
                $user->lastname = $name[1];
                for($i = 2;$i<sizeof($name);$i++){
                    $user->lastname .= ' '.$name[$i];
                }
            }
            if($user->save()){
                $new_data['name'] = "success";
            }else{
                $new_data['name'] = $user->getErrors();
            }
        }
        if(isset($_POST['year_name'])){
            $student_attributes = StudentAttrib::model()->find('user_id=:uid',array(':uid'=>$user_id));
            $student_attributes->year_name = $_POST['year_name'];
            if($student_attributes->save()){
                $new_data['year_name'] = "success";
            }else{
                $new_data['year_name'] = $student_attributes->getErrors();
            }
        }
        if(isset($_POST['school'])){
            $user = User::model()->find('user_id=:uid',array(':uid'=>$user_id));
            $school = School::model()->find('school_name=:sname',array(':sname'=>$_POST['school']));
            if($school){
                $user->school_id = $school->school_id;
                if($user->save()){
                    $new_data['school'] = "success";
                }else{
                    $new_data['school'] = $user->getErrors();
                }
            }else{
                $new_data['school'] = $school->getErrors();
            }


        }
        if(isset($_POST['majors'])){
            if($_POST['majors'][0] == 'none'){
                UserMajor::model()->deleteAll('user_id = :uid and focus = :focus',array(':uid'=>$user_id,':focus'=>'major'));
                $new_data['major'] = 'success';
            }
            $new_data['major']= $this->updateMajorsMinors($_POST['majors'],'major',$user_id);
        }
        if(isset($_POST['minors'])){
            if($_POST['majors'][0] == 'none'){
                UserMajor::model()->deleteAll('user_id = :uid and focus = :focus',array(':uid'=>$user_id,':focus'=>'minor'));
                $new_data['minor'] = 'success';
            }
            $new_data['minor']= $this->updateMajorsMinors($_POST['minors'],'minor',$user_id);
        }
        if(isset($_POST['interests'])){
            $new_data['interests']= $this->actionAddInterest($_POST['interests'],$user_id);

        }
        $this->renderJSON($new_data);
    }
    public function actionEditShowcase(){
        if($_POST['old_title']){
            $showcase = Showcase::model()->find('title = :title',array(':title'=>$_POST['old_title']));
            if($_POST['title']){
                $showcase->title = $_POST['title'];
            }
            if($_POST['desc']){
                $showcase->file_desc = $_POST['desc'];
            }
            if($showcase->save()){
                $this->renderJSON(array('status'=>'success'));
            }else{
                $this->renderJSON(array('status'=>'failure: could not update showcase'));
            }
        }else{
            $this->renderJSON(array('status'=>'failure: you derped'));
        }
    }
    public function actionDeleteShowcase(){
        $showcase = Showcase::model()->find('title = :tid', array(':tid'=>$_POST['title']));
        $result = array();
        if($showcase){
            $fileRecord = $showcase->file;
            $fileUrl  = $fileRecord->file_url;

            if($showcase->preview_file_id && $showcase->preview_file_id !=$fileRecord->file_id){
                $previewFile = $showcase->preview_image;
                $previewUrl = $previewFile->file_url;
            }
            $result['status']='';
            if(!$showcase->delete()){
                $result['status'] .= 'failure: could not delete showcase record';
            }
            if($fileRecord->delete()) {
                if(!preg_match('/http/',$fileUrl)){
                    try {
                        unlink(Yii::getPathOfAlias('webroot') . $fileUrl);
                    }catch(Exception $e){}
                }
            }else{
                $result['status'] .= 'failure: could not delete file record';
            }
            if(isset($previewFile)){
                if($previewFile->delete()){
                    unlink(Yii::getPathOfAlias('webroot') .$previewUrl);
                }else{
                    $result['status'] .= 'failure: could not delete preview file record';
                }
            }
            if($result['status']==''){
                $result['status'] = 'success';
            }
        }
        $this->renderJSON($result);
    }
    public function actionFollowUser(){
        if(isset($_POST['user']) && isset($_POST['user_to_follow'])&& isset($_POST['follow_unfollow'])){
            $userFollow = UserConnection::model()->find('from_user_id = :u1 and to_user_id = :u2 ',
                array(':u1'=>$_POST['user'],':u2'=>$_POST['user_to_follow']));
            if(!$userFollow && $_POST['follow_unfollow'] == 'follow'){
                $userFollow = new UserConnection();
                $userFollow->from_user_id = $_POST['user'];
                $userFollow->to_user_id = $_POST['user_to_follow'];
                $userFollow->timestamp = new CDbExpression('NOW()');
                if($userFollow->save()){
                    $this->renderJSON(array('status'=>'success'));
                }
                else{
                    $this->renderJSON(array('status'=>'failure','message'=>$userFollow->getErrors()));
                }
            }elseif($userFollow && $_POST['follow_unfollow'] == 'unfollow'){
                if($userFollow->delete()){
                    $this->renderJSON(array('status'=>'success'));
                }
                else{
                    $this->renderJSON(array('status'=>'failure','message'=>$userFollow->getErrors()));
                }
            }else{
                $this->renderJSON(array('status'=>'failure','message'=>'buttons'));
            }
        }
    }
    public function actionChangeProfilePicture(){
        include "file_upload.php";
        if(isset($_FILES['uploadFile'])){
            $result = file_upload($_FILES,"profile/");
            $user= User::model()->find('user_id = :uid',array(':uid'=>$_POST['user']));
            $user->picture_file_id = $result['file_id'];
            if($user->save()){
                $this->renderJSON(array('status'=>'success','file_url'=>$user->pictureFile->file_url));
            }else{
                $this->renderJSON(array('status'=>'failure','message'=>$user->getErrors()));
            }
        }
    }

    public function actionDownloadShowcase()
    {
        $file = File::model()->find('file_id=:fid', array(':fid' => $_GET['file_id']));

        if (file_exists(Yii::getPathOfAlias('webroot') . $file->file_url)) {

            header('Content-Description: File Transfer');
            header("Content-disposition: attachment; filename=" . basename($file->file_url));
            header("Content-type: application/octet-stream");
            readfile(Yii::getPathOfAlias('webroot') . $file->file_url);

            // Yii::app()->getRequest()->sendFile( basename($url) , @file_get_contents( Yii::getPathOfAlias('webroot').$url ) );
            $this->renderJSON(array('status' => 'success'));
        }else{
            $this->renderJSON(array('status' => 'failure: file no longer exists'));

        }

    }
    public function actionCloseShowcaseInstructions(){
        $user = User::model()->find('user_id=:uid',array(':uid'=>$_POST['user']));
        if($user->closed_showcase_instructions == 0){
            $user->closed_showcase_instructions=1;
            if($user->save()){
                $this->renderJSON(array('status' => 'success'));
            }
            $this->renderJSON(array('status' => 'failure: did not update'));
        }
        $this->renderJSON(array('status' => 'failure: already closed'));
    }
    public function actionChangeClassVisibility(){
        //public , just me, followers

       // $user_id = Yii::app()->session['user_id'];
        if(isset($_POST['user'])&&isset($_POST['class'])&&isset($_POST['visibility'])){
            $user_id = $_POST['user'];
            $class_id = $_POST['class'];
            $visibility_id = $_POST['visibility'];

            $course_user = ClassUser::model()->find('user_id=:id  and class_id=:class_id', array(':id'=>$user_id,':class_id'=>$class_id));

            $course_user->privacy = trim($visibility_id);
            if($course_user->save()){
                $this->renderJSON(array('status' => 'success'));
            }else{
                $this->renderJSON(array('status' => $course_user->getErrors()));
            }

        }


    }
    public function actionUpdateHere(){
        $vis_var=$_POST['selected'];
        //  echo $vis_var;
        $vis_var=(string)$vis_var;
        $user_id=1;
        $user_group = GroupUser::model()->find('user_id=:id', array(':id'=>$user_id));
//      $user_group = $user->group_user;
//        var_dump($user_group);
        $user_group->attributes=array('privacy'=>$vis_var);
        $user_group->save();

    }




}