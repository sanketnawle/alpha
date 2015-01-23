<?php

$host = "localhost";
$user = "campusla_UrlinqU";
$password = "PASSurlinq@word9";
$database = "campusla_urlinq_beta";

$con = mysqli_connect($host, $user, $password, $database);
//Checking connection
if (mysqli_connect_errno()) {
    echo "Failed to connect";
}

?>
