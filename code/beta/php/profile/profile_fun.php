<?php

    include_once '../dbconnection.php';
    include_once '../../includes/common_functions.php';
    session_start();

    // For testing, uncomment below  lines
    // $_POST['user_info'] = 47;
    // $_SESSION['user_info'] = 10;

    include "showcase_get.php";

    if (isset($_POST['user_info'])){
        //echo $_POST['user_info'];
        user_info($con, $_POST['user_info']);
    }

    function user_info($con, $user_id){

        $showcase_ele[] = get_showcase($con,$user_id);

        if($_SESSION['user_id'] == $_POST['user_info']){
            $is_owner = TRUE;
        }
        else {
            $is_owner = FALSE;
        }

        $p_query = $con->prepare("SELECT user_email, user_type, firstname, lastname,
            univ_id, dept_id, user_bio, dp_blob, status
            FROM user WHERE user_id =?");
        if($p_query){
            // echo "test";
            $p_query->bind_param('i',$_POST['user_info']);
            if($p_query->execute()){
                $p_query->bind_result($user_email, $user_type, $firstname, $lastname, $univ_id,
                    $dept_id, $user_bio, $dp_blob, $status);
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

        if($user_type == 's'){
            $attribs[] = get_stu_attribs($con, $user_id);
        }
        else if($user_type == 'p'){
            $attribs[] = get_prof_attribs($con,$user_id);
        }

        $user_info[]=array('user_email'=>$user_email, 'user_type'=>$user_type,
            'firstname'=>$firstname, 'lastname'=>$lastname,
            'univ_id'=>$univ_id, 'univ_name'=>$univ_name,
            'dept_id'=>$dept_id, 'dept_name'=>$dept_name,
            'user_bio'=>$user_bio, 'dp_blob'=>$dp,
            'status'=>$status, 'is_owner'=>$is_owner);

        echo json_encode(array("prof_info"=>$user_info, "attribs"=>$attribs, "showcase_ele"=>$showcase_ele));
    }

    function get_prof_attribs($con, $user_id){
        $prof_q = $con->prepare("SELECT designation, office_location, office_hours, website
                    FROM prof_attribs WHERE prof_id = ?");
        if($prof_q){
            $prof_q->bind_param('i',$_POST['user_info']);
            if($prof_q->execute()){
                $prof_q->bind_result($designation, $office_location, $office_hours, $website);
                $prof_q->fetch();
                $prof_q->close();
            }
        }
        return array('designation'=>$designation, 'office_location'=>$office_location, 'office_hours'=>$office_hours, 'website'=>$website);
    }

    function get_stu_attribs($con, $user_id){
        $prof_q = $con->prepare("SELECT website, major, year, student_type
                    FROM student_attribs WHERE user_id = ?");
        if($prof_q){
            // echo "test";
            $prof_q->bind_param('i',$_POST['user_info']);
            if($prof_q->execute()){
                $prof_q->bind_result($website, $major, $year, $student_type);
                $prof_q->fetch();
                $prof_q->close();
            }
        }
        return array('website'=>$website, 'major'=>$major, 'year'=>$year, 'student_type'=>$student_type);
    }

?>