<?php

    include_once '../dbconnection.php';

    session_start();
    
    if (isset($_POST['user_id'])) {

        // fetch the interest for the user 
        function FetchUserInterests()
        {
            GLOBAL $con;
            $interests_stmt = "select i.interest_id, i.interest from user_interests ui inner join 
                interests i on i.interest_id = ui.interest_id and ui.user_id = ?";
            $cinterest_stmt = $con->prepare($interests_stmt);
            
            if($cinterest_stmt){
                $cinterest_stmt->bind_param('i',$_POST['user_id']);
                if($cinterest_stmt->execute()){                
                    $cinterest_stmt->bind_result($interest_id, $interest);

                    while($cinterest_stmt->fetch()){                    
                        $interests[] = array("interest_id"=>$interest_id, "interest"=>$interest);
                    }
                }
            }
            echo json_encode(array("interestsList"=>$interests));        
        }    

        // add the interest in the interests table if it is new and insert the interest in the user interest table
        if (isset($_POST['new_interest']) && isset($_POST['interest'])) 
        {        
            $interests_stmt = "INSERT INTO `interests`(`interest`) VALUES (?)";
            $cinterest_stmt = $con->prepare($interests_stmt);
            $interestID = "";
            if($cinterest_stmt){
                $cinterest_stmt->bind_param('s',$_POST['interest']);
                if($cinterest_stmt->execute()){                
                    $interestID = $cinterest_stmt->insert_id;                    
                }
            }
            
            if ($interestID != null && $interestID != "")
            {
                $interests_stmt_users = "INSERT INTO `user_interests`(`user_id`, `interest_id`) VALUES (?, ?)";
                $cinterest_stmt_users = $con->prepare($interests_stmt_users);
                
                if($cinterest_stmt_users) {
                    $cinterest_stmt_users->bind_param('ii',$_POST['user_id'], $interestID);
                    if($cinterest_stmt_users->execute()){                
                        FetchUserInterests();
                    }
                }             
            }            
        }

        // insert the interest in the  user_interest table
        if (isset($_POST['insert']) && isset($_POST['interest_id']))
        {
            $interests_stmt_insert = "INSERT INTO `user_interests`(`user_id`, `interest_id`) VALUES (?, ?)";
            $cinterest_stmt_insert = $con->prepare($interests_stmt_insert);
            
            if($cinterest_stmt_insert) {
                $cinterest_stmt_insert->bind_param('ii',$_POST['user_id'], $_POST['interest_id']);
                if($cinterest_stmt_insert->execute()){                
                    FetchUserInterests();
                }
            }   
        }

        // delete the interst in the user interest table
        if ((isset($_POST['delete_interest'])) && (isset($_POST['interest_id'])))
        {
            $interests_stmt_delete = "DELETE FROM `user_interests` WHERE `interest_id` = ?";
            $cinterest_stmt_delete = $con->prepare($interests_stmt_delete);
            
            if($cinterest_stmt_delete) {
                $cinterest_stmt_delete->bind_param('i',$_POST['interest_id']);
                if($cinterest_stmt_delete->execute()){                
                    FetchUserInterests();
                }
            }   
        }        

        if (isset($_POST['fetch']))
        {
            FetchUserInterests();
        }
        
    }

    // fetch the interest for the user for auto suggest
    if (isset($_POST['interest_autosuggest']) && isset($_POST['query'])) {
                
        $interests_stmt_autosuggest = "select interest_id, interest from interests where interest like ?";
        $cinterest_stmt_autosuggest = $con->prepare($interests_stmt_autosuggest);
        $query = '%' . $_POST['query'] . '%';
        if($cinterest_stmt_autosuggest){            
            $cinterest_stmt_autosuggest->bind_param('s', $query);
            if($cinterest_stmt_autosuggest->execute()){                
                $cinterest_stmt_autosuggest->bind_result($interest_id, $interest);
                while($cinterest_stmt_autosuggest->fetch()){                    
                    $interests_autosuggest[] = array("interest_id"=>$interest_id, "interest"=>$interest);
                }
            }
        }

        echo json_encode(array("interests"=>$interests_autosuggest));                
    }
?>
