<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once ("php/dbconnection.php");
include "include/common_function.php";
$array_univ_signup=array();
$result = $con->query("SELECT university.univ_name,university.parent_univ_id,university.univ_id,
                                       count(*) as members,university.cover_blob_id 
                               FROM university LEFT JOIN user ON user.univ_id=university.univ_id 
                               GROUP BY university.univ_id 
                               HAVING university.parent_univ_id=1");
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $array_univ_signup[]=$row;
        }
        print_r($array_univ_signup);