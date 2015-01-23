<?php

include 'dbconnection.php';

$get_themes_query = "SELECT `theme_image`, `theme_id` FROM theme_table";
$get_themes_query_result = mysqli_query($con, $get_themes_query);


$image_string = "";
while ($row = mysqli_fetch_array($get_themes_query_result)) {
    $theme_id = $row['theme_id'];
    $image_string = $image_string . "<div class='theme_pic' style='background:"
        . "url(https://urlinq.com/beta/php/fetch_theme_blobs.php?id=$theme_id) no-repeat scroll 50% center / 100% 100% transparent;' id='" . $theme_id . "'></div>";
}

echo $image_string;
?>