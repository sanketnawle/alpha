<?php
    //echo json_encode($_POST['university']);
header("Content-Type: application/json");
include "dbconnection.php" ;
if(isset($_POST['univ_id'])){      
			$univ_id=$_POST['univ_id'];
			$json_response = array();
			$query=mysqli_query($con,"SELECT dept_id, dept_name FROM department WHERE univ_id='$univ_id'");
			if(!$query){
   				//echo "fail in getting dept_name";
			}
			//$department[] = array();
			while ($row = mysqli_fetch_assoc($query)) {
        			$json_response[]= $row;
			}
  			//$json = array('dep' => $department);
  			echo json_encode($json_response);
}else if(isset($_POST['parent_univ_id'])) {
            $parent_univ_id=$_POST['parent_univ_id'];
			$json_response = array();
			$query=mysqli_query($con,"SELECT univ_id, univ_name FROM university WHERE parent_univ_id='$parent_univ_id'");
			if(!$query){
   				//echo "fail in getting dept_name";
			}
			//$department[] = array();
			while ($row = mysqli_fetch_assoc($query)) {
        			$json_response[]= $row;
			}
  			//$json = array('dep' => $department);
  			echo json_encode($json_response);

} else if(isset($_POST['univ_id_school'])&&isset($_POST['user_id_school'])){
			$univ_id=$_POST['univ_id_school'];
			$user_id=$_POST['user_id_school'];
			$json_response=array();
			$query=mysqli_query($con,"SELECT count(user_id) as members,dept_name,user.dept_id FROM user JOIN department
			                     ON user.dept_id=department.dept_id WHERE user.univ_id=$univ_id 
			                     GROUP BY user.dept_id
			                     ORDER BY dept_name");
            while ($row = mysqli_fetch_array($query)) {
        			$json_response[]= $row;
			}
			$query=mysqli_query($con,"SELECT dept_name,dept_id FROM department WHERE dept_id IN
				                (SELECT dept_id FROM department_follow WHERE user_id=$user_id)");
			while ($row = mysqli_fetch_array($query)) {
        			$json_response[]= $row;
			}
            echo json_encode($json_response);
}else if(isset($_POST['univ_id_school'])){
        $univ_id=$_POST['univ_id_school'];
        $json_response=array();
        $query=mysqli_query($con,"SELECT firstname,lastname,dp_link,dp_flag,dp_blob,profile_picture,pic_location
                            FROM user WHERE univ_id=$univ_id ");
	  while ($row = mysqli_fetch_array($query)) {
        			$json_response[]= $row;
			}
			 echo json_encode($json_response);

}			



?>