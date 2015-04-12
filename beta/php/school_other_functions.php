<?php
include_once "includes/common_functions.php";
if (!function_exists('get_alias_univ')) {
    function get_alias_univ($con, $university)
    {
        $alias = "";
        $result = $con->query("SELECT alias FROM university WHERE univ_id=$university");
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $alias = $row['alias'];
        }
        return $alias;

    }

}
if (!function_exists('get_name_univ')) {
    function get_name_univ($con, $university)
    {
        $univ_name = "";
        $result = $con->query("SELECT univ_name FROM university WHERE univ_id=$university");
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $univ_name = $row['univ_name'];
        }
        return $univ_name;

    }

}
if (!function_exists('get_univ_signup')) {
    function get_univ_signup($con)
    {
        $array_univ_signup=array_fill_keys(array("univ_id","univ_name","members","cover_blob_id"),'');
        
        return $array_univ_signup;

    }

}
if (!function_exists('get_alias_parent_univ')) {
    function get_alias_parent_univ($con, $university)
    {
        $alias_parent = "";
        $result = $con->query("SELECT parent_univ_id FROM university WHERE univ_id=$university");
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $parent_univ_id = $row['parent_univ_id'];
        }
        $result = $con->query("SELECT alias FROM parent_university
                                 WHERE parent_univ_id=$parent_univ_id");
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $alias_parent = $row['alias'];
        }
        return $alias_parent;


    }
}
if (!function_exists('get_univ_weblink')) {
    function get_univ_weblink($con, $university)
    {
        $weblink = "";
        $result = $con->query("SELECT weblink 
                               FROM university 
                               WHERE univ_id=$university");
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $weblink = $row['weblink'];
        }
        return $weblink;

    }

}
if (!function_exists('get_parent_univ_weblink')) {
    function get_parent_univ_weblink($con,$university)
    {
        $weblink = "";
        $result = $con->query("SELECT parent_university.weblink 
                               FROM parent_university JOIN  university 
                               ON parent_university.parent_univ_id=university.parent_univ_id 
                               WHERE univ_id=$university");
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $weblink = $row['weblink'];
        }
        return $weblink;

    }

}
if (!function_exists('get_univ_add')) {
    function get_univ_add($con, $university)
    {
        $univ_location = "";
        $result = $con->query("SELECT univ_location FROM university WHERE univ_id=$university");
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $univ_location = $row['univ_location'];
        }
        return $univ_location;

    }

}
if (!function_exists('get_department_count')) {
    function get_department_count($con, $university)
    {
        $department_count = "";
        $result = $con->query("SELECT count(*) as department_count  FROM department WHERE univ_id=$university");
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $department_count = $row['department_count'];
        }
        return $department_count;

    }

}
if (!function_exists('get_member_count')) {
    function get_member_count($con, $university)
    {
        $member_count = "";
        $result = $con->query("SELECT count(*) as member_count  FROM user WHERE univ_id=$university");
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $member_count = $row['member_count'];
        }
        return $member_count;

    }

}
if (!function_exists('get_people_know_school')) {     
    function get_people_know_school($university, $user_id)
    { 
        include 'php/dbconnection.php';
        $people_know_school = "";
        $result = $con->query("SELECT count(*) as people_know_school  FROM user WHERE user_id
                                IN (SELECT to_user_id FROM connect WHERE from_user_id=$user_id) 
                                AND univ_id=$university");
        if($result->num_rows==0){
            $people_know_school=0;
        }else{
            while ($row = $result->fetch_assoc()) {
                $people_know_school = $row['people_know_school'];
            }
        }
        return $people_know_school;

    }

}
if (!function_exists('get_department_tab_contents')) {
    function get_department_tab_contents($con, $university, $user_id)
    {
               $univ_id=$university;
               $dept_array=array(array_fill_keys(array('dept_name','dept_id','member_count','alias','cover_link','dp_link','flag_follow','flag'), ''));
               $query=$con->query("SELECT count(user_id) as members,dept_name,user.dept_id,alias,dp_blob_id,cover_blob_id
                                         FROM user JOIN department
                                         ON user.dept_id=department.dept_id WHERE user.univ_id=$univ_id 
                                         GROUP BY user.dept_id
                                         ");
               $i=1;
               while ($row = $query->fetch_array()) {

                        if($row['dp_blob_id']!==NULL){
                            $dp_blob_id=$row['dp_blob_id'];
                            $dept_array[$i]['dp_link']="includes/get_blob.php?img_id=$dp_blob_id";
                        }else{
                            $dept_array[$i]['dp_link']=get_dp($con,$row['dept_id'],'dept');
                        }

                        if($row['cover_blob_id']!==NULL){
                            $dp_blob_id=$row['cover_blob_id'];
                            $dept_array[$i]['cover_link']="includes/get_blob.php?img_id=$dp_blob_id";
                        }else{
                            $dept_array[$i]['cover_link']=get_dp($con,$row['dept_id'],'dept');
                        }

                        $dept_array[$i]['dept_id']=$row['dept_id'];
                        $dept_array[$i]['dept_name']=$row['dept_name'];
                        $dept_array[$i]['member_count']=$row['members'];
                        $dept_array[$i]['alias']=$row['alias'];
                        $i++;
              }
              //$flag_array=array(array_fill_keys(array('flag_follow','flag'), ''));
              $query=$con->query("SELECT major,minor 
                                        FROM student_attribs 
                                        WHERE user_id=$user_id");
              while($row=$query->fetch_array()){
                   if(is_numeric($row['major'])){
                       $dept_array[$row['major']]['flag']=1;
                    }
                   if(is_numeric($row['minor'])){
                        $dept_array[$row['minor']]['flag']=2;
                    }
             }
             $query=$con->query("SELECT interest FROM interests 
                                      JOIN user_interests 
                                      ON interests.interest_id=user_interests.interest_id 
                                      WHERE user_interests.user_id=$user_id 
                                      AND interest_type='department'");  
             while($row=$query->fetch_array()){
                        if(is_numeric($row['interest'])){
                            $dept_array[$row['interest']]['flag']=3;
                        }            
            }
            $query=$con->query("SELECT department_follow.dept_id as follow_dept_id 
                                      FROM department_follow 
                                      WHERE user_id=$user_id");
            while ($row = $query->fetch_array()) {
                    $dept_array[$row['follow_dept_id']]['flag_follow']=1;
            }  
            return $dept_array;                             

    }

}
if (!function_exists('get_members_department_tab')) {
    function get_members_department_tab($con, $university, $user_id)
    {
        $univ_id=$university;
        $query=$con->query("SELECT user_id,firstname,lastname,user_type,univ_id,user_bio
                                  FROM user 
                                  WHERE univ_id=$univ_id ");
        $member_array=array(array_fill_keys(array('user_id','firstname','lastname','user_type','univ_id','dp_link','flag_follow'), ''));
        
        while ($row = $query->fetch_array()) {
                    $member_array[$row['user_id']]['dp_link']=get_user_dp($con,$row['user_id']);
                    $member_array[$row['user_id']]['firstname']=$row['firstname'];
                    $member_array[$row['user_id']]['lastname']=$row['lastname'];
                    $member_array[$row['user_id']]['user_type']=$row['user_type'];
                    $member_array[$row['user_id']]['user_id']=$row['user_id'];
                    $member_array[$row['user_id']]['univ_name']=get_name_univ($con,$row['univ_id']);
                    $member_array[$row['user_id']]['univ_id']=$row['univ_id'];
                   

                      
        }

        $query=$con->query("SELECT to_user_id 
                                  FROM connect 
                                  WHERE from_user_id=$user_id");
        while ($row = $query->fetch_array()) {
                    $member_array[$row['to_user_id']]['flag_follow']=1;
        }
        return $member_array;
    }

}
?>
