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
include "php/signup_functions.php";
//end of connecting db
$salt = salt();
echo $salt;
echo "dad";
$password=$_POST['password'];
//echo $password;
$password=password($password,$salt);
//echo "   ".$password;
$user_id=$_POST['user_id'];
//echo $user_id;
$query=$con->query("SELECT * FROM login WHERE user_id='$user_id'");
if($query->num_rows===1){
 			$query=$con->query("UPDATE login SET password = '$password', salt= '$salt' WHERE user_id='$user_id'");
			if(!$query){
				//echo "update failed";
			}else{
				//echo "update completed";
			}
}else{
           $query=$con->query("INSERT INTO login(user_id,password,salt) VALUES('$user_id','$password','$salt')");
           if(!$query){
      	      //echo "insertion of new login failed";
           }
 }			
$query=$con->query("DELETE FROM user_recovery
                          WHERE user_id ='$user_id'");
if(!$query){
	echo "delete failed";
}
else{
	 $time=time();
      setcookie('beta_user_id',$user_id,$time+100000,'/');
      //echo "this is cookie".$_COOKIE['test'];
      header("location:php/setsession.php");
              	
}
?>
</body>
</html>