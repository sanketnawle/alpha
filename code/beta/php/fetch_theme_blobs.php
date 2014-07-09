<?php

require_once("dbconnection.php");

$stmt = $con->prepare("SELECT theme_image from theme_table where theme_id = ?");
$stmt->bind_param('i', $_GET['id']);
if ($stmt->execute()) {
    $stmt->store_result();
    $stmt->bind_result($img);
    $stmt->fetch();

    header("Content-Type: image/jpeg");
    echo $img;
}
?>