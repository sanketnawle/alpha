<?php

// echo "*".$_FILES['file']['type']."*";
// echo "*".$_FILES['file']['tmp_name']."*";
// echo "*".$_FILES['file']['size']."*";

if (isset($_FILES['file'])) {
    // echo $errorIndex = $_FILES["file"]["error"];
    try {
        $up_id = upload($con);
        // echo '<p>Thank you for submitting</p>';
    } catch (Exception $e) {
        echo '<h4>*' . $e->getMessage() . '*</h4>';
    }
}

function upload($con) {
    /*     * * check if a file was uploaded ** */
    if ($_FILES['file']['error'] == "UPLOAD_ERR_OK"               //checks for errors
            && is_uploaded_file($_FILES['file']['tmp_name'])) {

        /*         * * assign our variables ** */
        $file_size = $_FILES['file']['size'];
        $file_type = $_FILES['file']['type'];
        // $file_tmpname = $_FILES['file']['tmp_name'];
        $file_name = $_FILES["file"]["name"];
        $file_name = str_replace(" ", "_", $file_name);
        $maxsize = 4294960000; //4294967295
        $file_content = file_get_contents($_FILES['file']['tmp_name']);

        /*         * *  check the file is less than the maximum file size ** */
        if ($file_size < $maxsize) {

            $file_ins = $con->prepare("INSERT INTO file_upload (file_type, file_content, file_name) VALUES (? ,?, ?)");
            if ($file_ins) {
                $file_ins->bind_param('sss', $file_type, $file_content, $file_name);
                if ($file_ins->execute()) {
                    // echo "success";
                    return $up_id = $con->insert_id;
                    // $up_id = "success";
                }
            }
        } else {
            /*             * * throw an exception is file is not of type ** */
//            echo "Mazaak(lol): You exceeded the maximum size limit";
            return -1;
        }
    } else {
        // if the file is not less than the maximum allowed, print an error
        throw new Exception("Unsupported file Format!");
    }
}

?>