<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<?php
if(isset($_GET['key1'])){
 //connecting to database
   include "php/dbconnection.php";
//end of connecting db
$key1=$_GET['key1'];
echo $key1;
 $query=mysqli_query($con,"SELECT user_id from user_recovery WHERE key1='$key1'");
    if(!$query){
	    echo "as always database query failed";
	}else{
	     while($row=mysqli_fetch_array($query)){
         $user_id=$row['user_id'];}
}
}
?>
<form name='newpassword' method="post" action="updatepwd.php">
password<input type="password" name="password">
retypepassword<input type="password" name="retype">
<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
<input type="submit" name="submit">
</form>
<body>
</body>
</html>