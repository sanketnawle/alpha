<?php

    include_once '../dbconnection.php';
    include_once '../../includes/common_functions.php';

    session_start();

    // For testing, uncomment below  lines
    // $_POST['user_info'] = 286;
    // $_SESSION['user_info'] = 47;

    include "showcase_get.php";

    if (isset($_POST['user_info'])){
        //echo $_POST['user_info'];
        user_info($con, $_POST['user_info']);
    }


    function user_info($con, $user_id){

        $showcase_ele[] = get_showcase($con,$user_id);

        if($_SESSION['user_id'] == $_POST['user_info']){
            $is_owner = 'true';
        }
        else {
            $is_owner = 'false';
        }

        $p_query = $con->prepare("SELECT u.user_email, u.user_type, u.firstname, u.lastname,
            u.univ_id, u.dept_id, u.user_bio, u.dp_blob, u.status,
            p.designation, p.office_location, p.office_hours, p.website, p.book_flag, p.showcase_flag
            FROM
            user u LEFT JOIN prof_attribs p
            ON u.user_id = p.prof_id
            WHERE u.user_id =?");
        if($p_query){
            // echo "test";
            $p_query->bind_param('i',$_POST['user_info']);
            if($p_query->execute()){
                $p_query->bind_result($user_email, $user_type, $firstname, $lastname, $univ_id,
                    $dept_id, $user_bio, $dp_blob, $status, $designation,
                    $office_location, $office_hours, $website, $book_flag, $showcase_flag);
                $p_query->fetch();
                $p_query->close();
            }
        }
        $skl_query = $con->prepare("SELECT univ_name FROM university WHERE univ_id = ?");
        if($skl_query){
            $skl_query->bind_param('i',$univ_id);
            if($skl_query->execute()){
                $skl_query->bind_result($univ_name);
                $skl_query->fetch();
                $skl_query->close();
            }
        }

        if(!is_null($dept_id)){
            // fetch the dept name
            $skl_query = $con->prepare("SELECT dept_name FROM department WHERE dept_id = ? AND univ_id = ?");
            if($skl_query){
                $skl_query->bind_param('ii',$dept_id,$univ_id);
                if($skl_query->execute()){
                    $skl_query->bind_result($dept_name);
                    $skl_query->fetch();
                    $skl_query->close();
                }
            }
        }

        $dp = get_user_dp($con, $_POST['user_info']);

        $user_info[]=array('user_email'=>$user_email, 'user_type'=>$user_type,
            'firstname'=>$firstname, 'lastname'=>$lastname,
            'univ_id'=>$univ_id, 'univ_name'=>$univ_name,
            'dept_id'=>$dept_id, 'dept_name'=>$dept_name,
            'user_bio'=>$user_bio, 'dp_blob'=>$dp,
            'website'=>$website, 'status'=>$status, 'designation'=>$designation,
            'office_location'=>$office_location, 'office_hours'=>$office_hours,
            'book_flag'=>$book_flag, 'showcase_flag'=>$showcase_flag,
            'is_owner'=>$is_owner);
        echo json_encode(array("prof_info"=>$user_info,"showcase_ele"=>$showcase_ele));
    }

?>