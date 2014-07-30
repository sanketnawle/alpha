<?PHP
if($_GET['key']!==null){
	$key1=$_GET['key'];
echo $key1;

//connecting to the db
       $db_host = "localhost";
       $db_username = "campusla_UrlinqU";
       $db_pass = "mArCh3!!1992X";
       $db_name = "campusla_urlinq_beta";
       try {
                $con = new mysqli($db_host, $db_username, $db_pass, $db_name);
       }        catch (Exception $e) {
                exit("Database error. $e");
           }

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
               header("location: http/urlinq.com/beta/lp_beta.php");

             }
       
}
?>