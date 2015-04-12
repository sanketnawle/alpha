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

//Returns array $length # of random unique
//colors
function get_unique_random_color_list($length){
    $colors = Color::model()->findAllBySql('SELECT * FROM `color` GROUP BY color_id ORDER BY RAND() LIMIT ' . (string)$length);
    return $colors;
}






?>