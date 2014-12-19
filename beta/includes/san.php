<?php

    // function check_abuse($string){
    //     $arr = explode("\n",strtolower(file_get_contents('blocked.txt')));
    //     $arr = array_map('trim',$arr);
    //     $str = explode(" ", $string);

    //     if($res = array_intersect($arr, $str)){
    //         echo(json_encode($res));
    //         // print_r($res);
    //         return "flag";
    //     }
    //     // else echo "clean";
    // }

    function check_abuse($string){
        $arr = explode("\n",strtolower(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/beta/blocked.txt')));
        $arr = array_map('trim',$arr);
        $str = explode(" ", $string);

        print_r($arr);
        echo "************";
        print_r(array_filter($arr));
        $i = 0;
        foreach(array_filter($arr) as $ab){
            echo $i;
            // if(!is_null(trim($ab)) AND !is_null($ab)){
            // if($ab != ""){

                if(stristr($string, $ab)){
                    // return TRUE;
                    return "flagged";
                }
            // }
            // }
            $i++;
        }

        if($res = array_intersect($arr, $str)) {
            echo(json_encode($res));
            // print_r($res);
            // return TRUE;
            echo "flag";
        }
        else{
            // return FALSE;
            echo "dd";
        }
    }

    echo check_abuse("fuck@fuck.com");

?>

