 <?php
 session_start();
 setcookie('user_id',null,1,'/');
 setcookie('type',null,1,'/');
 session_destroy();
 header("location:lp_beta.php");
?>