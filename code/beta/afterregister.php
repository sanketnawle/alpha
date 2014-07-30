<?php
session_start();
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
if(isset($_SESSION['id'])){
   echo "you must do something";
     $firstname=$_POST['first'];
     echo $firstname;
     $lastname=$_POST['last'];
     $email=$_POST['emailid'];
     $university=$_POST['university'];
     $department=$_POST['department'];
     $user_type=$_POST['account-type'];
     $gender=$_POST['gender'];
     $fbid=$_SESSION['id'];
     $query=mysqli_query($con,"SELECT univ_id FROM university WHERE univ_name='$university'");
     echo "after query";
     if(!$query){
        echo "univ_id retrival failed";
 
     } else{
           //echo "univ_id should have been retreived ";
               while($row=mysqli_fetch_array($query)){
                    $univ_id= $row['univ_id'];
                    echo $univ_id;
                }
       } 
           if(mysqli_num_rows($result)===0){
                echo "no rows retrived in univ";  
           }

            //department_id
           $department=$_POST['department'];
           $query=mysqli_query($con,"SELECT dept_id FROM department WHERE dept_name='$department'");
           if(!$query){
               echo "dept_id retrival failed";

            } else{
           //echo "dept_id should have been retreived ";
                   while($row=mysqli_fetch_array($query)){
                       $dept_id= $row['dept_id'];
                      echo $dept_id;
                    }

             }
          if(mysqli_num_rows($result)===0){
              echo "no dept rows retrived";  
          }
          $picurl="http://graph.facebook.com/".$fbid."/picture?type=large";
          $query=mysqli_query($con,"INSERT INTO user (user_email,user_type,firstname,lastname,univ_id,dept_id,dp_link,status) 
                                 VALUES('$email','$user_type','$firstname','$lastname','$univ_id','$dept_id','$picurl','temp')");
          if(!$query){
             echo "insert user failed";       
          }
          $query=mysqli_query($con,"SELECT user_id FROM user WHERE user_email='$email'");
          if(!$query){
              echo "getting user id failed";
          }
          while($row=mysqli_fetch_array($query)){
                   $user_id= $row['user_id'];
                   echo $user_id;
          }
          $query=mysqli_query($con,"UPDATE user_auth_provider SET user_id='$user_id' WHERE auth_key='$fbid'");     
          if(!$query){
              echo "getting user id failed";
          }


}           
else if(isset($_POST['password'])){
          //echo "password set";
          $pos_first=strpos($_POST['fname'],$_POST['password']); 
          $pos_last=strpos($_POST['lname'],$_POST['password']);
           foreach($_POST as $key=>$value){
            //echo $key."=".$value;?><br><?php
               if(empty($value)){
                   $problem="All fields are to be filled";
                   header("location: lp_beta.php?problem=$problem");
                   die();
                   break 1;
               }else if($post_first===0 || $post_last===0){
                       $problem="password contains name";
                       header("location: lp_beta.php?problem=$problem");
                       die();
                       break 1;

                }else if(!preg_match('/[A-Z]/',$_POST['password'])){
                      $problem="password should contain capital small number and atleast 6 characters long";
                       header("location: lp_beta.php?problem=$problem");
                       die();
                       break 1;

                }else if(!preg_match('/[a-z]/',$_POST['password'])){
                      $problem="password should contain capital small number and atleast 6 characters long";
                       header("location: lp_beta.php?problem=$problem");
                       die();
                       break 1;

                }else if(!preg_match('/[0-9]/',$_POST['password'])){
                       $problem="password should contain capital small number and atleast 6 characters long";
                       header("location: lp_beta.php?problem=$problem");
                       die();
                       break 1;

                }else if(strlen($_POST['password'])<6){
                         $problem="password length atleast 6 chars";
                          header("location: lp_beta.php?problem=$problem");
                         die();
                         break 1;
                }
           /*if($key=="account-type" || $key=="university" || $key=="department" || $key=="gender"){
                   
                   if($value===""){
                       $problem= "please select your univ,dept,type,gender";
                       header("location: login1.php?problem=$problem");
                       die();
                       break 1;

                   }  
           }*/
               if($key=='email'&& strpos($value,'@nyu.edu')==false){
                   $problem .="invalid email";
                   header("location: lp_beta.php?problem=$problem");
                   die();
                   break 1;  
               }
       } 
       //echo "you are here"; 



      

                                                                                           
        //university_id
         $university=$_POST['university'];
         //echo $university;
        
          $query=mysqli_query($con,"SELECT univ_id FROM university WHERE univ_name='$university'");
          //echo "after query";
          if(!$query){
              echo "univ_id retrival failed";
 
          } 
           //echo "after if";
          else{
           //echo "univ_id should have been retreived ";
               while($row=mysqli_fetch_array($query)){
                    $univ_id= $row['univ_id'];
                    //echo $univ_id;
                }
          } 
          
           if(mysqli_num_rows($result)===0){
                echo "no rows retrived in univ";  
           }

            //department_id
           $department=$_POST['department'];
           $query=mysqli_query($con,"SELECT dept_id FROM department WHERE dept_name='$department'");
           if(!$query){
               echo "dept_id retrival failed";
            } else{
            //echo "dept_id should have been retreived ";
                  while($row=mysqli_fetch_array($query)){
                      $dept_id= $row['dept_id'];
                     // echo $dept_id;
                  }
              }
             
          if(mysqli_num_rows($result)===0){
             echo "no dept rows retrived";  
          }
           //inserting data in to user table
          $firstname=$_POST['fname'];
          $lastname=$_POST['lname'];
          $user_type=$_POST['account-type'];
          $email=$_POST['email'];
          $gender=$_POST['gender'];
          $query=mysqli_query($con,"INSERT INTO user (user_email,user_type,firstname,lastname,univ_id,dept_id,status) 
                                 VALUES('$email','$user_type','$firstname','$lastname','$univ_id','$dept_id','temp')");
          if(!$query){
              echo "insert user failed";        
          }
          $query=mysqli_query($con,"SELECT user_id FROM user WHERE user_email='$email'");
          if(!$query){
              echo "getting user id failed";
           }
          while($row=mysqli_fetch_array($query)){
                   $user_id= $row['user_id'];
                   echo $user_id;
          }

            //inserting into login
          $password=$_POST['password'];
          echo $password;
          $size = mcrypt_get_iv_size(MCRYPT_CAST_256, MCRYPT_MODE_CFB);
          $salt = mcrypt_create_iv($size, MCRYPT_DEV_RANDOM);
          $password=sha1($salt.$password);
          $query=mysqli_query($con,"INSERT INTO login (user_id,password,salt) VALUES ('$user_id','$password','$salt') ");
          if(!$query){
            echo 'login falied';
          }else{

            echo "passed";
          }

                                                                                    

}
else{
         $problem="password not set and all other fields are to be filled";
            header("location: lp_beta.php?problem=$problem");
            break 1; 
}
      //mail sending
if(isset($_POST['password']) || isset($_SESSION['id'])){
               $size = mcrypt_get_iv_size(MCRYPT_CAST_256, MCRYPT_MODE_CFB);
               $salt = mcrypt_create_iv($size, MCRYPT_DEV_RANDOM);
               $key1=hash('sha256',$salt);
               $to      = $email;
               $subject = 'confirm your email';
               $message = "
                 <html>
                 <head>
                 <title>Test Mail</title>
                 </head>
                 <body>
                 <p><a href='http://urlinq.com/beta/afterconfirmation.php?key=$key1'>Open Link</a></p>
                 </body>
                 </html>";
                 $headers  = 'MIME-Version: 1.0' . "\r\n";
                 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                 $headers .= 'From: Noreply <noreply@example.com>' . "\r\n";
                 mail($to, $subject, $message, $headers);
                 //storing key and user id in confirmation table
                 $query=mysqli_query($con,"INSERT INTO confirmation(user_id,key_email) values('$user_id','$key1')");
                 if(!$query){
                      echo "insertion into confirmation failed";
                   } else{
                    echo "check your email";
                   }
  }                 

?>