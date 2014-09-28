<?php 
/*
This will handle the ajax call from signup_school_select.php
and give dept list i.e name,id,cover pic and profile pic for the selected school
*/
        header("Content-Type: application/json");
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        include_once ("php/dbconnection.php");
        include_once("includes/common_functions.php");
        if(isset($_POST['univ_id'])){
          $univ_id=$_POST['univ_id'];
        }
        $dept_list=array();
        $result = $con->query("SELECT dept_name,dept_id
                               FROM department 
                               WHERE univ_id=$univ_id");
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) { 
           $dept_list[]=$row;                            
        }    
        echo json_encode($dept_list);
?> 