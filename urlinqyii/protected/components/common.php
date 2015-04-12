<?php
function models_to_array($models){
    $array = array();

    foreach($models as $model){
        array_push($array,$this->model_to_array($model));
    }

    return $array;

}

function model_to_array($this_model){
    $row = array();
    foreach($this_model as $key => $value) {
        $row[$key] = $value;
    }
    return $row;
}



?>