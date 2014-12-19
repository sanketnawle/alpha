<?php
 if (session_status() == PHP_SESSION_NONE) {
    session_start();
}  
header("Content-Type: application/json");
require_once("dbconnection.php");
$con->set_charset("utf8");
require_once("../includes/common_functions.php");
include "school_other_functions.php";
if(isset($_POST['univ_id'])){   

			$univ_id=$_POST['univ_id'];
			$json_response = array();
			$query=$con->query("SELECT dept_id, dept_name 
				                      FROM department 
				                      WHERE univ_id='$univ_id'");
			if(!$query){
   	
			}	
			while ($row = $query->fetch_assoc()) {
        			$json_response[]= $row;
			}
  		
  			echo json_encode($json_response);
}else if(isset($_POST['parent_univ_id'])) {
            $parent_univ_id=$_POST['parent_univ_id'];
			$json_response = array();
			$query=$con->query("SELECT univ_id, univ_name 
				                      FROM university 
				                      WHERE parent_univ_id='$parent_univ_id'");
			if(!$query){
   		
			}
			while ($row = $query->fetch_assoc()) {
        			$json_response[]= $row;
			}
  			echo json_encode($json_response);

} else if(isset($_POST['univ_id_school'])&&isset($_POST['user_id_school'])){
			$univ_id=$_POST['univ_id_school'];
			$user_id=$_POST['user_id_school'];
			$json_response=array();
			$query=$con->query("SELECT count(user_id) as members,dept_name,user.dept_id,alias,dp_id FROM user JOIN department
			                     ON user.dept_id=department.dept_id WHERE user.univ_id=$univ_id 
			                     GROUP BY user.dept_id
			                     ORDER BY dept_name");
            while ($row = $query->fetch_array()) {
            	if($row['dp_id']>0){
                    $dp_id=$row['dp_id'];
            		$row['dp_link']="../includes/get_blob.php?img_id=$dp_id";
            	}
        			$json_response[]= $row;
			}
			$query=$con->query("SELECT major,minor FROM student_attribs 
			                          WHERE user_id=$user_id");
			while($row=$query->fetch_array()){
				$json_response[]=$row;
			}
			$query=$con->query("SELECT interest FROM interests 
				                      JOIN user_interests 
				                      ON interests.interest_id=user_interests.interest_id 
				                      WHERE user_interests.user_id=$user_id");
			$query=$con->query("SELECT department_follow.dept_id as follow_dept_id 
				                      FROM department_follow 
				                      WHERE user_id=$user_id LIMIT 1");
		    while ($row = $query->fetch_array()) {
			        $json_response[]=$row;
		    }   
            echo json_encode($json_response);
}else if(isset($_POST['univ_id_school'])){
        $univ_id=$_POST['univ_id_school'];
        $user_id=$_SESSION['user_id'];
        $json_response=array();

        $query=$con->query("SELECT user_id,firstname,lastname,user_type,univ_id,user_bio
                                  FROM user 
                                  WHERE univ_id=$univ_id");

	  while ($row = $query->fetch_array()) {
	                $row['dp_link']=get_user_dp($con,$row['user_id']);
	                $row['univ_name']=get_name_univ($con,$row['univ_id']);
	                 $json_response[]= $row;
        		   	  
			}

		$query=$con->query("SELECT to_user_id 
			                      FROM connect 
			                      WHERE from_user_id=$user_id");
		while ($row = $query->fetch_array()) {
			        $json_response[]=$row;
		}        	
			 echo json_encode($json_response);

}else if(isset($_POST['dept_id'])&&isset($_POST['type'])){
        $type=$_POST['type'];
        $dept_id=$_POST['dept_id'];
        $user_id=$_SESSION['user_id'];
        $univ_id=$_SESSION['univ_id'];
        

        $query=$con->query("SELECT * FROM student_attribs 
        	                      WHERE (major='$dept_id' 
        	                      OR minor='$dept_id') 
        	                      AND user_id='$user_id'");
             if($type==3){
		                if($query->num_rows==0){
		                }else{
		                	while($row=$query->fetch_array()){
							         if($row['major']==$dept_id){
							             $query=$con->query("UPDATE student_attribs 
							             	                       SET major='NULL' 
							             	                       WHERE user_id=$user_id");                  	 
							          }else{
							             $query=$con->query("UPDATE student_atttribs 
							             	                       SET minor='NULL' 
							             	                       WHERE user_id=$user_id");
							          }
							} 
		                }                 
		                $query=$con->query("SELECT * FROM interests 
		                	                       WHERE interest_type='department' 
		                	                       AND interest=$dept_id");
		                    if($query->num_rows==0){
			                       $query=$con->query("INSERT INTO interests(interest_type,interest) 
			                       	                          values('department','$dept_id')");
			                       $lastid=$con->insert_id;
			                       $query=$con->query("INSERT INTO user_interests(user_id,interest_id) 
			                       	                         values($user_id,$lastid)");
		                    }else{
		                           while($row=$query->fetch_array()){
			                           $interest_id=$row['interest_id'];
			                           $query=$con->query("SELECT * FROM user_interests 
			                           	                            WHERE user_id=$user_id 
			                           	                                  AND interest_id=$interest_id");
			                           if($query->num_rows==0){
			                           	   $query=$con->query("INSERT INTO user_interests(user_id,interest_id) 
			                                       	                   values('$user_id','$interest_id')");
			                           }else{
			                           	   $query=$con->query("DELETE FROM user_interests 
                                  	 	                       WHERE interest_id=$interest_id AND user_id=$user_id");
			                           }
			                           
		                           }
		                    }    
            }else{
            	if($query->num_rows===0){
            		 $query=$con->query("SELECT * FROM student_attribs 
            	  	 	                       WHERE user_id=$user_id");
                         if($query->num_rows==0){
                         	if($type==2){
                         		$query=$con->query("INSERT INTO student_attribs(user_id,minor) 
                         			                      values($user_id,$dept_id)");
                         	}else{
                         		$query=$con->query("INSERT INTO student_attribs(user_id,major) values($user_id,$dept_id)");
                         	}
                          }else{
			            	  	if($type==2){
						              $query=$con->query("UPDATE student_attribs 
						              	                        SET minor=$dept_id WHERE user_id=$user_id"); 
						        }else{
 						              $query=$con->query("UPDATE student_attribs 
 						              	                        SET major=$dept_id WHERE user_id=$user_id");
						        }
						  }        
            	   }else{
                         while($row=$query->fetch_array()){
			                   if($dept_id==$row['minor'] && $type==1){
			                        $query=$con->query("UPDATE student_attribs 
			                        	                      SET major=$dept_id,minor='NULL' WHERE user_id=$user_id");
			                   }else if($dept_id==$row['major'] && $type==2){
			                        $query=$con->query("UPDATE student_attribs 
			                        	                      SET minor=$dept_id,major='NULL' WHERE user_id=$user_id");
			                   }else if($dept_id==$row['major'] && $type==1){
			                        $query=$con->query("UPDATE student_attribs 
			                        	                      SET major='NULL' WHERE user_id=$user_id");
			                   }else if($dept_id==$row['minor'] && $type==2){
			                        $query=$con->query("UPDATE student_attribs 
			                        	                      SET minor='NULL' WHERE user_id=$user_id");
			                   }else if($type==2){
			                   	    $query=$con->query("UPDATE student_attribs 
			                   	    	                      SET minor=$dept_id WHERE user_id=$user_id");
			                   }else{
			                   	     $query=$con->query("UPDATE student_attribs 
			                   	     	                       SET major=$dept_id WHERE user_id=$user_id");
			                   }
			                  
		                 }
            	  	
                }
                 $query=$con->query("SELECT user_interests.interest_id as interest_id
			                   	                         FROM user_interests WHERE user_id=$user_id AND interest_id 
			                   	                         IN(SELECT interest_id FROM interests WHERE interest_type='department' AND interest=$dept_id ) ");
                               if($query->num_rows>0){
                                  while($row=$query->fetch_array()){
                                  	 $interest_id=$row['interest_id'];
                                  	 $query=$con->query("DELETE FROM user_interests 
                                  	 	                       WHERE interest_id=$interest_id AND user_id=$user_id");
                                  }

                               }
            }

		        


}
?>