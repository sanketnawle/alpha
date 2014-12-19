 <?php
 session_start();
 setcookie('beta_user_id',null,1,'/');
 setcookie('beta_type',null,1,'/');
 setcookie('beta_user_tz',null,1,'/');
 setcookie (session_id(), "", time() - 3600);
 session_regenerate_id();
session_destroy();
session_write_close();
 header("location:../lp_beta.php");
?>