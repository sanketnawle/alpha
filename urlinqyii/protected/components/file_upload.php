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







function file_upload($files, $path="", $user_id="") {
    //example of path: 'uploads/preview/'
    if($user_id == ""){
        $user = User::model()->find('user_id=:id', array(':id' => Yii::app()->session['user_id']));
    }
    else{
        $user = User::model()->find('user_id=:id', array(':id' => $user_id));
    }
    if(isset($files["file"])){
        include_once "UniqueTokenGenerator.php";

        $path_parts = pathinfo($files["file"]["name"]);
        $extension = $path_parts['extension'];
        //$file_type = getFileMimeType($files["file"]['tmp_name']);
        $file_type = $extension;
        $random_name = token($user->user_id,$user->firstname);



        $local_directory = 'assets/' . $path;
        if(!is_dir($local_directory)) {
            mkdir($local_directory);
        }
        if($extension == 'jpg' || $extension == 'png' || $extension == 'gif'){
            include_once "ImageCompress.php";
            image_compress($files["file"]["tmp_name"], $local_directory . $random_name . '.jpg', 50);
            $extension = 'jpg';
        } else{
            move_uploaded_file($files["file"]["tmp_name"], $local_directory . $random_name. '.'. $extension);

        }


        //Create file in file table here
        $file = new File;
        $file->file_name = $random_name . '.' . $extension;
        $file->original_name = $files["file"]["name"];
        $file->file_url = $file_url = "/" . $local_directory . $random_name . '.' . $extension;
        $file->file_type = $file_type;
        $file->file_extension = $extension;

        $file->save(false);
        //Use the origin and id to add files either to associative table or to a main field

        //$this->renderJSON(array('success'=>true,'file_type'=>$file_type,'file_id'=>$file->file_id,'file_name'=>$random_name . '.' . $extension,'origin_type'=>$origin_type,'origin_id'=>$origin_id,'extension'=>$extension));
        //$this->renderJSON(array('success'=>true,'file_type'=>$file_type,'file_id'=>$file->file_id,'file_name'=>$random_name . '.' . $extension,'file_url'=>$file->file_url,'extension'=>$extension));
        return array('success'=>true,'file_type'=>$file_type,'file_id'=>$file->file_id,'original_name'=>$file->original_name,'file_name'=>$random_name . '.' . $extension,'file_url'=>$file->file_url,'extension'=>$extension,'created_timestamp'=>date("Y-m-d H:i:s")/*,'download_count'=>$file->download_count*/);
    }else {
        //$this->renderJSON(array('success'=>false));
        return array('success'=>false, 'files'=>$files);
    }




}







//Takes in only 1 file at a time
function file_upload2($file_data, $path="", $user_id="") {
    //example of path: 'uploads/preview/'
    if($user_id == ""){
        $user = User::model()->find('user_id=:id', array(':id' => Yii::app()->session['user_id']));
    }
    else{
        $user = User::model()->find('user_id=:id', array(':id' => $user_id));
    }
    if(isset($file_data)){
        include_once "UniqueTokenGenerator.php";

        $path_parts = pathinfo($file_data["name"]);
        $extension = $path_parts['extension'];
        //$file_type = getFileMimeType($file_data['tmp_name']);
        $file_type = $extension;
        $random_name = token($user->user_id,$user->firstname);



        $local_directory = 'assets/' . $path;
        if(!is_dir($local_directory)) {
            mkdir($local_directory);
        }
        if($extension == 'jpg' || $extension == 'png' || $extension == 'gif'){
            include_once "ImageCompress.php";
            image_compress($file_data["tmp_name"], $local_directory . $random_name . '.jpg', 50);
            $extension = 'jpg';
        } else{
            move_uploaded_file($file_data["tmp_name"], $local_directory . $random_name. '.'. $extension);

        }


        //Create file in file table here
        $file = new File;
        $file->file_name = $random_name . '.' . $extension;
        $file->original_name = $file_data["name"];
        $file->file_url = $file_url = "/" . $local_directory . $random_name . '.' . $extension;
        $file->file_type = $file_type;
        $file->file_extension = $extension;

        $file->save(false);
        //Use the origin and id to add files either to associative table or to a main field

        //$this->renderJSON(array('success'=>true,'file_type'=>$file_type,'file_id'=>$file->file_id,'file_name'=>$random_name . '.' . $extension,'origin_type'=>$origin_type,'origin_id'=>$origin_id,'extension'=>$extension));
        //$this->renderJSON(array('success'=>true,'file_type'=>$file_type,'file_id'=>$file->file_id,'file_name'=>$random_name . '.' . $extension,'file_url'=>$file->file_url,'extension'=>$extension));
        return array('success'=>true,'file_type'=>$file_type,'file_id'=>$file->file_id/*,'original_name'=>$file->original_name*/,'file_name'=>$random_name . '.' . $extension,'file_url'=>$file->file_url,'extension'=>$extension,'created_timestamp'=>date("Y-m-d H:i:s")/*,'download_count'=>$file->download_count*/);
    }else {
        //$this->renderJSON(array('success'=>false));
        return array('success'=>false);
    }




}





?>