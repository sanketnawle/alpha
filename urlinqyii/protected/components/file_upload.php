<?php



function file_upload($_FILES) {

    $user = User::model()->find('user_id=:id', array(':id'=>1));



//        if(!isset($_POST['origin_type'])){
//            $this->renderJSON(array('success'=>false,'msg'=>'origin_type is not set'));
//        }
//
//        if(!isset($_POST['origin_id'])){
//            $this->renderJSON(array('success'=>false,'msg'=>'origin_id is not set'));
//        }



//        $origin_type = $_POST['origin_type'];
//        $origin_id = $_POST['origin_id'];



    //["name"]
    if(isset($_FILES["uploadFile"])){
        include "UniqueTokenGenerator.php";

        $path_parts = pathinfo($_FILES["uploadFile"]["name"]);
        $extension = $path_parts['extension'];
        $file_type = $this->getFileMimeType($_FILES["uploadFile"]['tmp_name']);
        $random_name = token($user->user_id,$user->firstname);

        if($extension == 'jpg' || $extension == 'png' || $extension == 'gif'){
            include "ImageCompress.php";
            image_compress($_FILES["uploadFile"]["tmp_name"], 'assets/test/' . $random_name . '.jpg', 50);
        } else{
            move_uploaded_file($_FILES["uploadFile"]["tmp_name"], 'assets/test/' . $_FILES["uploadFile"]["name"]);
        }


        //Create file in file table here
        $file = new File;
        $file->file_name = $random_name . '.' . $extension;
        $file->file_url = $file_url = "/assets/" . $random_name . '.' . $extension;
        $file->file_type = $file_type;
        $file->file_extension = $extension;

        $file->save(false);
        //Use the origin and id to add files either to associative table or to a main field

        //$this->renderJSON(array('success'=>true,'file_type'=>$file_type,'file_id'=>$file->file_id,'file_name'=>$random_name . '.' . $extension,'origin_type'=>$origin_type,'origin_id'=>$origin_id,'extension'=>$extension));
        //$this->renderJSON(array('success'=>true,'file_type'=>$file_type,'file_id'=>$file->file_id,'file_name'=>$random_name . '.' . $extension,'file_url'=>$file->file_url,'extension'=>$extension));
        return array('success'=>true,'file_type'=>$file_type,'file_id'=>$file->file_id,'file_name'=>$random_name . '.' . $extension,'file_url'=>$file->file_url,'extension'=>$extension);
    }else {
        //$this->renderJSON(array('success'=>false));
        return array('success'=>false);
    }




}


?>