<!--PLEASE READ (MEHUL)-->
<!-- MASTER DIV : <div class="department_feed_right_about"> (exact same as the file name) -->
<!--Here I don't know what to remove and what not to because if I try to do it like school.php's sub files
    there will only be HTML but here there are some vars inside the HTML, so I don't know what to replae them with
-->





<?php
/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 8/8/14
 * Time: 12:16 PM
 */

if (isset($_GET['dept_id'])) {
    $dept_id = $_GET['dept_id'];
}
include 'php/dbconnection.php';


$get_department_about_query = "SELECT dept_desc FROM department WHERE dept_id = '$dept_id'";
$get_department_about_query_result = $con->query($get_department_about_query);

$department_about_row = $get_department_about_query_result->fetch_array();

if ($department_about_row['dept_desc'] == 'NULL' or $department_about_row['dept_desc'] == NULL) {
    $department_about_row['dept_desc'] = "No description is given.";
}

echo "
        <div class='group-about'>
            <div class='box-header'>
                <span class='bh-t1'>
                    ABOUT
                </span>
            </div>
            <div class='box-content content-about'>" . $department_about_row['dept_desc'] . "</div>

            <div class='box-header'>
                <span class='bh-t2'>
                    Links
                </span>
            </div>
            <div class='box-content content-link'>" . $department_about_row['dept_desc'] . "</div>
        </div>
";