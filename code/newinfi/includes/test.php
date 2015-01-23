<?php
  require_once("dbconfig.php");

  if(isset($_GET['file_id'])){
    $file_id = $_GET['file_id'];

    $fd_query = "SELECT 'file_name', 'file_content', 'file_type' FROM 'file_upload' WHERE 'file_id' = '".$file_id."'";
    $fd_res = mysqli_query($con,$fd_query);

    if($fd_res){
      while($fdrow = mysqli_fetch_array($fd_res)){
        header("Content-type : ".$fdrow['file_type']);
        header("Content-disposition : ".$fdrow['file_name']);
        echo $fdrow['file_content'];
      }
    }
  }
  

?>