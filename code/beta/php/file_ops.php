<?php

/**

 * Created by PhpStorm.

 * User: aditya841

 * Date: 7/23/14

 * Time: 10:59 AM

 */



include 'dbconnection.php';



if (isset($_POST['file_id'])) {

    delete_file($_POST['file_id'], $con);

} elseif (isset($_FILES['file'])) {

    // echo $errorIndex = $_FILES["file"]["error"];

    try {

        $up_id = upload($con);

        // echo '<p>Thank you for submitting</p>';

    } catch (Exception $e) {

        echo '<h4>' . $e->getMessage() . '</h4>';

    }

}



function upload($con)

{

    /*     * * check if a file was uploaded ** */

    if ($_FILES['file']['error'] == "UPLOAD_ERR_OK" //checks for errors

        && is_uploaded_file($_FILES['file']['tmp_name'])

    ) {



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



function get_file_type($file_type)

{

    if ((substr($file_type, -12) == "presentation") OR (substr($file_type, -13) == "ms-powerpoint")) {

        return $file_type_tag = "ppt";

    } else if ((substr($file_type, -8) == "document") OR (substr($file_type, -6) == "msword")) {

        return $file_type_tag = "doc";

    } else if (substr($file_type, -3) == "pdf") {

        return $file_type_tag = "pdf";

    } else if ((substr($file_type, -5) == "sheet") OR (substr($file_type, -8) == "ms-excel")) {

        return $file_type_tag = "xls";

    } else if (substr($file_type, -14) == "zip-compressed") {

        return $file_type_tag = "zip";

    } else if(substr( $file_type, 0, 5 ) == "image") {

        return $file_type_tag = "image";

    } else {

        return $file_type_tag = "other";

    }

}



function delete_file($file_id, $con)

{

    $delete_file_query = "DELETE FROM file_upload WHERE file_id = $file_id";

    $delete_file_query_result = mysqli_query($con, $delete_file_query);



    if ($delete_file_query_result) {

        return TRUE;

    } else {

        return FALSE;

    }

}



?>