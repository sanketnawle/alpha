
<?php

include 'dbconnection.php';

if ($con->connect_error) {
    die("$con->connect_errno: $con->connect_error");
}

$query = "SELECT `firstname` FROM user WHERE `user_id`=? LIMIT 1";
$user_id = 1;
$stmt = $con->stmt_init();
if (!$stmt->prepare($query)) {
    print "Failed to prepare statement\n";
} else {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_array(MYSQLI_NUM)) {
        echo $row['firstname'];
    }
}

$stmt->close();
$con->close();
?>
