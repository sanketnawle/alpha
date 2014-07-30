<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>update password</title>
</head>

<body>
<?php
//connecting to database
include "php/dbconnection.php";
//end of connecting db
$size = mcrypt_get_iv_size(MCRYPT_CAST_256, MCRYPT_MODE_CFB);
$salt = mcrypt_create_iv($size, MCRYPT_DEV_RANDOM);
$password=$_POST['password'];
$password=sha1($salt.$password);
$user_id=$_POST['user_id'];
echo $user_id;
$query=mysqli_query($con "SELECT * FROM login WHERE user_id='$user_id'");
if(mysqli_num_rows($query)===0){
 			$query=mysqli_query($con,"UPDATE login SET password = '$password', salt= '$salt' WHERE user_id='$user_id'");
			if(!$query){
				echo "update failed";
			}else{
				echo "update completed";
			}
}else{
           $query=mysqli_query($con,"INSERT INTO login(user_id,password,salt) VALUES('$user_id','$password','$salt')");
           if(!$query){
      	      echo "insertion of new login failed";
           }
 }			
$query=mysqli_query($con,"DELETE FROM user_recovery
                          WHERE user_id ='$user_id'");
if(!$query){
	echo "delete failed";
}
else{
		echo "delete completed";
}
?>
</body>
</html>