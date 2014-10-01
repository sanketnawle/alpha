<?PHP
include_once("includes/common_functions.php");
include_once("php/dbconnection.php");
if($_GET['key']!==null){
          $key1=input_sanitize($_GET['key'],$con);
        //echo $key1;
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        //connecting to the db
        require_once("php/dbconnection.php");
        //getting user_id
        $query=$con->query("SELECT user_id FROM confirmation
                            WHERE key_email='$key1'");
        if(!$query){
            echo "user_id getting failed";
        }else{
            if($query->num_rows==1){
                 while($row=$query->fetch_array()){
                       $user_id= $row['user_id'];
                       // making status active
                       $query=$con->query("UPDATE user 
                                           SET status='active' 
                                          WHERE user_id='$user_id'");
                        if(!$query){
                                        echo "making active failed in user_new";
                        }
                         //Deleting the cofirmation entry
                         $query=$con->query("DELETE FROM confirmation
                                             WHERE  key_email= '$key1'");            
                         if(!$query){
                              echo "deletion failed";
                         }else{
                             $time=time();
                             //setcookie('user_id',$user_id,$time+100000,'/');
                             $query=$con->query("SELECT * FROM user_auth_provider WHERE user_id=$user_id");
                             if(!$query){
                                  //echo "query failed";
                              }else{
                                  $number=$query->num_rows;
                                  if($number==1){
                                      while($row=$query->fetch_array()){
                                           $_SESSION['id']=$row['auth_key'];
                                           header("location: php/setsession.php");
                                      }
                                                           
                                  }else{
                                        setcookie('beta_user_id',$user_id,$time+100000,'/');
                                        header("location:php/setsession.php");
                                  }
                             }     

                        }        
                 }       
            }else{
                 $problem="link expired";
                 header("location:lp_beta.php?problem=$problem");
            }
        }


}else{
  header("location:../lp_beta.php");
}                
?>