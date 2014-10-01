<?php

    include_once '../dbconnection.php';
    // include_once '../../includes/common_functions.php';
    session_start();

    // echo $_POST['user_id'] = 47;

        // Preparing statement to get clubs associated with the user
        $cgroup_q = "select count(*), g.group_id, g.univ_id, g.group_name, g.group_desc, g.dp_blob_id from  group_users gu inner join 
            groups g on gu.group_id = g.group_id group by gu.group_id having gu.group_id in 
                (select grp.group_id from group_users grp where grp.user_id =?)";
        $cgroup_stmt = $con->prepare($cgroup_q);

        if($cgroup_stmt){
            $cgroup_stmt->bind_param('i',$_POST['user_id']);
            if($cgroup_stmt->execute()){                
                $cgroup_stmt->bind_result($user_count, $group_id, $univ_id, $group_name, $group_desc, $dp_blob_id);
                while($cgroup_stmt->fetch()){         
                    if(!is_null($dp_blob_id)) $cl_dp = "includes/get_blob.php?img_id=".$dp_blob_id;
                    else $cl_dp = "DefaultImages/club.png";           
                    $clubs[] = array("user_count"=>$user_count, "group_id"=>$group_id, "univ_id"=>$univ_id,
                        "group_name"=>$group_name, "group_desc"=>$group_desc, "cl_dp"=>$cl_dp);
                }
            }
        }

        echo json_encode(array("user_clubs"=>$clubs));

        $con->close();

?>