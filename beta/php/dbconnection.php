<?php

$host = "localhost";
$user = "campusla_UrlinqU";
$password = "mArCh3!!1992X";
$database = "campusla_urlinq_beta";
// if(isset($con))
// $con->close();
$con = mysqli_connect($host, $user, $password, $database);
//Checking connection
if (mysqli_connect_errno()) {
//    echo "Failed to connect";
}
?>