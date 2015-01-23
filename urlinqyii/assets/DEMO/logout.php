<?php 
ob_start();
session_start();

unset($_SESSION["usertype"]);
unset($_SESSION["student_id"]);
unset($_SESSION["professor_id"]);
unset($_SESSION['calender_notified']);
session_destroy();
header("location:index.php");
?>