<?php

// echo "*".$_FILES['file']['type']."*";
// echo "*".$_FILES['file']['tmp_name']."*";
// echo "*".$_FILES['file']['size']."*";

if(isset($_POST['gdrive_id'])){
    try {
        // echo "test";
        $up_id = gdrive_share($con);
        // echo '<p>Thank you for submitting</p>';
    } catch (Exception $e) {
        echo '<h4>*' . $e->getMessage() . '*</h4>';
    }    
}

else if (isset($_FILES['file'])) {
    // echo $errorIndex = $_FILES["file"]["error"];
    try {
        // echo "test";
        $up_id = upload_f($con);
        // echo '<p>Thank you for submitting</p>';
    } catch (Exception $e) {
        echo '<h4>*' . $e->getMessage() . '*</h4>';
    }
}


function gdrive_share($con){
    $stmt = $con->prepare("INSERT INTO gdrive_share (file_gdrive_id, file_name, file_url, file_type) VALUES (?, ? ,?, ?)");
    $stmt->bind_param('ssss', $_POST['gdrive_id'], $_POST['gdrive_name'], $_POST['gdrive_url'], $_POST['gdrive_type']);
    if($stmt->execute()){
        return $up_id = $con->insert_id;
    }
}

function upload_f($con) {
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
            $im->setImageCompression($compression_type);
            $im->setImageCompressionQuality(40);
            $im->stripImage();
            $im->writeImage($_FILES['file']['tmp_name']); 
        }

        // $file_content = file_get_contents($_FILES['file']['tmp_name']);

        /*         * *  check the file is less than the maximum file size ** */
        if ($file_size < $maxsize) {
            if(!in_array($extension, $blockedExts)) {

                $file_ins = $con->prepare("INSERT INTO file_upload (file_type, file_content, file_name) VALUES (? ,?, ?)");
                if ($file_ins) {
                    $null = NULL;
                    $file_ins->bind_param('sbs', $file_type, $null, $file_name);
                    $fp = fopen($_FILES['file']['tmp_name'], 'r');
                    while (!feof($fp)) {
                        $file_ins->send_long_data(1,fread($fp,16776192));
                    }
                    if ($file_ins->execute()) {
                        // echo "success";
                        return $up_id = $con->insert_id;
                        // $up_id = "success";
                    }
                    echo "Mazaak: Something is definitely wrong here!!"; //failed to execute
                }
                else echo "Mazaak: This shouldn't happen... Hmm.. (Please report and try again)"; // failed to prepare
            }
            else echo "We don't support this file format. Please report if you think we should.";
        } else {
            /*             * * throw an exception is file is not of type ** */
           echo "Mazaak(lol): You exceeded the maximum size limit";
        }
    } else {
        // if the file is not less than the maximum allowed, print an error
        throw new Exception("Unsupported file Format!");
    }
}

?>