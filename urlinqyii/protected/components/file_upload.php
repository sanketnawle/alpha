<?php





function getFileMimeType($file) {
    if (function_exists('finfo_file')) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $type = finfo_file($finfo, $file);
        finfo_close($finfo);
    } else {
        require_once 'upgradephp/ext/mime.php';
        $type = mime_content_type($file);
    }

    if (!$type || in_array($type, array('application/octet-stream', 'text/plain'))) {
        $secondOpinion = exec('file -b --mime-type ' . escapeshellarg($file), $foo, $returnCode);
        if ($returnCode === 0 && $secondOpinion) {
            $type = $secondOpinion;
        }
    }

    if (!$type || in_array($type, array('application/octet-stream', 'text/plain'))) {
        require_once 'upgradephp/ext/mime.php';
        $exifImageType = exif_imagetype($file);
        if ($exifImageType !== false) {
            $type = image_type_to_mime_type($exifImageType);
        }
    }

    return $type;
}


function file_upload($files) {

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
    if(isset($files["uploadFile"])){
        include "UniqueTokenGenerator.php";

        $path_parts = pathinfo($files["uploadFile"]["name"]);
        $extension = $path_parts['extension'];
        $file_type = getFileMimeType($files["uploadFile"]['tmp_name']);
        $random_name = token($user->user_id,$user->firstname);

        if($extension == 'jpg' || $extension == 'png' || $extension == 'gif'){
            include "ImageCompress.php";
            image_compress($files["uploadFile"]["tmp_name"], 'assets/test/' . $random_name . '.jpg', 50);
        } else{
            move_uploaded_file($files["uploadFile"]["tmp_name"], 'assets/test/' . $files["uploadFile"]["name"]);
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