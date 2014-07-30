<?php
    require_once("dbconnection.php");
    // echo "*".$_FILES['img']['type']."*";
    // echo "*".$_FILES['img']['tmp_name']."*";
    // echo "*".$_FILES['img']['size']."*";

    $error = NULL;
    $img_url = NULL;

    if (isset($_FILES['img'])) {
        // echo $errorIndex = $_FILES['img']['error'];
        // echo "test";
        try {
            if($up_id = upload($con)){
                $img_url = "includes/get_blob.php?img_id=".$up_id;
                $dp_array[] = array('error'=>$error,'img_url'=>$img_url);
                echo json_encode(array("user_dp"=>$dp_array));
            }
            // echo '<p>Thank you for submitting</p>';
        } catch (Exception $e) {
            echo '<h4>' . $e->getMessage() . '</h4>';
        }
    }

    function upload($con) {
        /*     * * check if a file was uploaded ** */
        if ($_FILES['img']['error'] == "UPLOAD_ERR_OK"               //checks for errors
                && is_uploaded_file($_FILES['img']['tmp_name'])) {

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
            $img_size = $_FILES['img']['size'];
            $img_type = $_FILES['img']['type'];
            // $file_tmpname = $_FILES['img']['tmp_name'];
            // echo $img_name = $_FILES['img']['name'];
            $img_name = str_replace(" ", "_", $img_name);
            $maxsize = 16777215; //4294967295

            if ((($_FILES['img']['type'] == "image/gif")
                || ($_FILES['img']['type'] == "image/jpeg")
                || ($_FILES['img']['type'] == "image/jpg")
                || ($_FILES['img']['type'] == "image/pjpeg")
                || ($_FILES['img']['type'] == "image/x-png")
                || ($_FILES['img']['type'] == "image/png"))
                // && ($_FILES['img']['size'] < 20000)
                && (!in_array($extension, $blockedExts))) {

                if(substr( $img_type, 0, 5 ) === "image"){
                    $im = new Imagick($_FILES['img']['tmp_name']);
                    // $im->setImageCompression($compression_type);
                    $im->setImageCompressionQuality(40);
                    $im->stripImage();
                    $im->writeImage($_FILES['img']['tmp_name']);
                }

                // $img_content = file_get_contents($_FILES['img']['tmp_name']);

                /*         * *  check the file is less than the maximum file size ** */
                if ($img_size < $maxsize) {
                    
                    $img_ins = $con->prepare("INSERT INTO display_picture (img_name, img_content, img_type) VALUES (? ,?, ?)");
                    if ($img_ins) {
                        $null = NULL;
                        $img_ins->bind_param('sbs', $img_name, $img_content, $img_type);
                        $fp = fopen($_FILES['img']['tmp_name'], 'r');
                        while (!feof($fp)) {
                            $img_ins->send_long_data(1,fread($fp,16776192));
                        }
                        if ($img_ins->execute()) {
                            // echo "success";
                            return $up_id = $con->insert_id;
                            // $up_id = "success";
                        }
                        else{
                            // die('execute() failed: ('.$con->errno.')' . htmlspecialchars($img_ins->error));
                            return $error="Mazaak: Something is definitely wrong here!!"; //failed to execute
                        }
                    }
                    else return $error="Mazaak: This shouldn't happen... Hmm.. (Please report and try again)"; // failed to prepare
                    
                } else {
                    /*             * * throw an exception is file is not of type ** */
                   return $error="Mazaak: You exceeded the maximum size limit, seriously? 15.9999990463 MB is not enough for you?";
                }
            }
            else return $error="Mazaak: Sorry, we only support these image formats for now (jpeg, gif, pjpeg, x-png, png)";

        }
        else {
            // if the file is not less than the maximum allowed, print an error
            throw new Exception("Unsupported file Format!");
        }
    }

?>