<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "urlinq_new";

// if(isset($con))
// $con->close();
$con = mysqli_connect($host, $user, $password, $database);
//Checking connection
if (mysqli_connect_errno()) {
//    echo "Failed to connect";
}
?>