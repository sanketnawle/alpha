<?php

$host = "localhost";
$user = "campusla_UrlinqU";
$password = "mArCh3!!1992X";
$database = "campusla_comingsoon";
// if(isset($con))
// $con->close();
$con = mysqli_connect($host, $user, $password, $database);
//Checking connection
if (mysqli_connect_errno()) {
//    echo "Failed to connect";
} else {
    require_once '../includes/common_functions.php';
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        if (isset($_POST['name'])) {
            $name = $_POST['name'];
        } else {
            $name = "not provided";
        }

        if (!check_abuse($email)) {
            echo json_encode(array("flag"=>0,"img"=>"/beta/img/nyu.JPG"));
            $filter_email = filter_var($email, FILTER_VALIDATE_EMAIL);
            if ($filter_email == FALSE) {
                exit;
            } else {
                preregister_email($email, 'campus@urlinq.com');
            }
        } else {
            echo json_encode(array("flag"=>1,"img"=>"beta/DefaultImages/fucku.jpg"));
            exit;
        }
        $insert_email_query = $con->prepare("INSERT IGNORE INTO new_email (full_name, email) VALUES (?,?)");
        if (!$insert_email_query) {
            echo "Error in preparing add user query: " . $con->error;
        }
        $insert_email_query->bind_param("ss", $name, $email);
        if (!$insert_email_query) {
            echo "Error in binding add user query: " . $con->error;
        }
        $insert_email_query->execute();
        if (!$insert_email_query) {
            echo "Error in executing add user query: " . $con->error;
        }
        $insert_email_query->close();
    }
}
?>