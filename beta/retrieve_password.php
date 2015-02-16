<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body>
<?php
include "includes/common_functions.php";
if(isset($_POST['email'])){
	 include "php/dbconnection.php";
    $email=$_POST['email'];
    $query=mysqli_query($con,"SELECT user_id from user WHERE user_email='$email'");
    if(!$query){
	    echo "as always database query failed getting user id";
	}else{

    while($row=mysqli_fetch_array($query)){
       $user_id=$row['user_id'];
    }
  }
    if(mysqli_num_rows($query)==0){
	    echo "email doesnt exist";
	}

    else{
	       $size = mcrypt_get_iv_size(MCRYPT_CAST_256, MCRYPT_MODE_CFB);
         $salt = mcrypt_create_iv($size, MCRYPT_DEV_RANDOM);
         $key1=hash('sha256',$salt);
         $query=mysqli_query($con,"INSERT INTO user_recovery(user_id,key1) values('$user_id','$key1')");
         if(!$query){
	          echo "as always database query failed inserting user id";
	       }else{
               $to      = $email;
               $subject = 'update your password ';
               $message = "
                 <html>
                 <head>
                 <title>Test Mail</title>
                 </head>
                 <body>
                 <p><a href='http://urlinq.com/beta/forgotpwd.php?key=$key1'>Open Link</a></p>
                 </body>
                 </html>";
                 $from="admin@urlinq.com";
                 echo mailto($to,$subject,$message,$from);
                 echo $key1;
                 
         }
	    
    }
}
?>
<form name='forgot' method="post" action="">
Email<input type="text" name="email">
<input type="submit" name="submit" >
</form>
</body>
</html>