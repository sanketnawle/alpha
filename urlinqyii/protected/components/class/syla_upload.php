<?php

// echo "*".$_FILES['file']['type']."*";
// echo "*".$_FILES['file']['tmp_name']."*";
// echo "*".$_FILES['file']['size']."*";

/*if (isset($_FILES['file'])) {
    // echo $errorIndex = $_FILES["file"]["error"];
    try {
        // echo "test";
        upload_f();
         //echo '<p>Thank you for submitting</p>';
    } catch (Exception $e) {
        echo '<h4>*' . $e->getMessage() . '*</h4>';
    }
}*/


function upload_f() {
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
                    // You should name it uniquely.
                    // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
                    // On this example, obtain safe unique name from its binary data.
                    $md5_tail = date('Y-m-d H:i:s');
                    $nm= md5($_FILES['file']['name'].$md5_tail).".".$extension;
                    if (move_uploaded_file($_FILES['file']['tmp_name'], "../pdfrepo/".$nm)) {
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
}

?>