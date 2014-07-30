<?PHP
include "php/dbconnection.php";
if($_GET['key']!==null){
	$key1=$_GET['key'];
echo $key1;
 //getting user_id
                 $query=mysqli_query($con,"SELECT user_id FROM confirmation WHERE key_email='$key1'");
                 if(!$query){
                     echo "user_id getting failed";
                 }
                 while($row=mysqli_fetch_array($query)){
                       $user_id= $row['user_id'];

                 }//deleting key_email
                  $query=mysqli_query($con,"DELETE FROM confirmation
                                             WHERE  key_email= '$key1'");            
                   if(!$query){

                        echo "deletion failed";

                   }
                   // making status active
                   $query=mysqli_query($con,"UPDATE user 
                                             SET status='active' 
                                             WHERE user_id='$user_id'");
                   if(!$query){
                        echo "making active failed in user_new";

                   }
                   else{
                     header("location:lp_beta.php");

                   }
             
      }
      ?>
                