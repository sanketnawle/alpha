<?php
/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 8/8/14
 * Time: 12:16 PM
 */

if (isset($_GET['group_id'])) {
    $group_id = $_GET['group_id'];
}
include 'php/dbconnection.php';


$get_club_about_query = "SELECT group_desc FROM groups WHERE group_id = '$group_id'";
$get_club_about_query_result = $con->query($get_club_about_query);

$club_about_row = $get_club_about_query_result->fetch_array();

echo "
        <div class='group-about'>
            <div class='box-header'>
                <span class='bh-t1'>
                    ABOUT
                </span>

            </div>
            <div class='box-content content-about'>" . $club_about_row['group_desc'] . "
            </div>
        </div>
";