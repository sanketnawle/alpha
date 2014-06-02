<?php
/* Insert the event details retreived from the page and insert them into the database.*/
$host = "localhost";
$user = "campusla_UrlinqU";
$password = "PASSurlinq@word9";
$database = "campusla_urlinq_demo";
       
$con = mysqli_connect($host, $user, $password, $database);
//Checking connection
if (mysqli_connect_errno()){
    echo "Failed to connect";
}

$title = mysqli_escape_string($con, $_POST['event_name']);
$date = mysqli_escape_string($con, $_POST['event_date']);
$time = mysqli_escape_string($con, $_POST['event_time']);
$date = $date . $time;
$date = strtotime($date);
$date = date("Y-m-d h:i:sa", $date);

$sql="INSERT INTO personal_event (title, description, start)
VALUES ('$title', ' ', '$date')";

if(!mysqli_query($con, $sql)){
    echo "Error in executing query";
}

//$insert_st->close();
mysqli_close($con);
?>
