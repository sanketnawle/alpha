<?php





//Returns a random color id from the database
function get_random_color(){
    $color = Color::model()->findBySql('SELECT * FROM `color` ORDER BY RAND() LIMIT 1');
    if($color){
        return $color->color_id;
    }else{
        return null;
    }
}







?>