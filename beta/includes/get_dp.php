<?php
    function get_user_dp($con, $id){
        $user_dp = $con->prepare("SELECT dp_flag, dp_link, dp_blob FROM user
                            WHERE user_id = ?");
        $user_dp->bind_param('i',$id);
        if($user_dp->execute()){
            $user_dp->store_result();
            $user_dp->bind_result($dp_flag, $dp_link, $dp_blob);
            $user_dp->fetch();
            $user_dp->close();
        }

        if($dp_flag == 'blob'){
            return $blob = "includes/get_blob.php?img_id=".$dp_blob;
        }
        else if($dp_flag == 'link'){
            return $dp_link;
        }
    }

?>