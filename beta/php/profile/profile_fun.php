<?php

    include_once '../dbconnection.php';
    include_once '../../includes/common_functions.php';    
    session_start();

    // For testing, uncomment below  lines
    // $_POST['user_info'] = 1;
    // $_SESSION['user_info'] = 10;

    include "showcase_fun.php";

    if (isset($_POST['user_info'])){
        //echo $_POST['user_info'];
        user_info($con, $_POST['user_info']);
    }

    function get_dept_name($con, $d_id, $un_id, &$dept_blob){
        $skl_query = $con->prepare("SELECT dept_name, dp_blob_id FROM department WHERE dept_id = ? AND univ_id = ?");
        if($skl_query){
            $skl_query->bind_param('ii',$d_id,$un_id);
            if($skl_query->execute()){
                $skl_query->bind_result($dept_name, $dept_blob_id);
                $skl_query->fetch();
                $skl_query->close();
            }
        }
        $dept_blob = $dept_blob_id;
        return $dept_name;
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
        $skl_query = $con->prepare("SELECT u.univ_name, pu.parent_univ_id , pu.parent_univ_name, u.dp_blob_id, pu.dp_blob_id
                        FROM `university` u
                        JOIN `parent_university` pu ON u.parent_univ_id = pu.parent_univ_id
                        WHERE univ_id =?");
        if($skl_query){
            $skl_query->bind_param('i',$univ_id);
            if($skl_query->execute()){
                $skl_query->bind_result($univ_name, $puniv_id, $puniv_name, $univ_dp_blob, $puniv_dp_blob);
                $skl_query->fetch();
                $skl_query->close();
            }
        }        

        if(!is_null($dept_id)){
            // fetch the dept name
            $dept_blob_id_param = "";
            $dept_name = get_dept_name($con, $dept_id, $univ_id, $dept_blob_id_param, $dept_blob_id_param);
            $dept_blob = $dept_blob_id_param;
        }

        $dp = get_user_dp($con, $_POST['user_info']);

        if($user_type == 's'){
            $attribs[] = get_stu_attribs($con, $user_id, $univ_id);
        }
        else if($user_type == 'p'){
            $attribs[] = get_prof_attribs($con,$user_id);
        }

        if ($univ_dp_blob != null)
        {
            $dp_univ = "includes/get_blob.php?img_id=" . $univ_dp_blob;
        }
        else
        {
            $dp_univ = "includes/get_blob.php?img_id=" . 0;    
        }

        if ($puniv_dp_blob != null)
        {
            $dp_puniv = "includes/get_blob.php?img_id=" . $puniv_dp_blob;
        }
        else
        {
            $dp_puniv = "includes/get_blob.php?img_id=" . 0;    
        }

        if ($dept_blob != null)
        {
            $dept_dp_blob = "includes/get_blob.php?img_id=" . $dept_blob;
        }
        else
        {
            $dept_dp_blob = "includes/get_blob.php?img_id=" . 0;    
        }

        $user_info[]=array('user_email'=>$user_email, 'user_type'=>$user_type,
            'firstname'=>$firstname, 'lastname'=>$lastname,
            'univ_id'=>$univ_id, 'univ_name'=>$univ_name,
            'puniv_id'=>$puniv_id, 'puniv_name'=>$puniv_name,
            'dept_id'=>$dept_id, 'dept_name'=>$dept_name,
            'user_bio'=>$user_bio, 'dp_blob'=>$dp,
            'status'=>$status, 'is_owner'=>$is_owner, 
            'univ_dp'=>$dp_univ, 'puniv_dp'=>$dp_puniv, 'dept_dp'=>$dept_dp_blob);

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

    function get_stu_attribs($con, $user_id, $univ_id){
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
        if(is_numeric($major)){
            // fetch the dept name
            $dept_blob_id_param = "";
            $show_major = get_dept_name($con, $major, $univ_id);
            $dept_blob = $dept_blob_id_param;
        }

        return array('website'=>$website, 'major'=>$major, 'show_major'=>$show_major, 'year'=>$year, 'student_type'=>$student_type);
    }

?>