<?php

if(isset($_FILES['file'])){
  // echo $file_size = $_FILES['file']['size'];
  // echo $file_type = $_FILES['file']['type'];
  // echo $file_tmpname = $_FILES['file']['tmp_name'];
  echo $file_name = $_FILES["file"]["name"];
  // echo " and ";
  echo "Kuan you rock!!!";

if(isset($_POST['reply_msg'])) echo $_POST['reply_msg'];
}
else echo "Kuan, Please try again";

?>