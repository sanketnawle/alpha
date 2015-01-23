<?php
	require_once("dbconfig.php");

    if(isset($_GET['img_id']) && !is_null($_GET['img_id'])){
        $stmt = $con->prepare("SELECT img_content FROM display_picture where img_id = ?");
        $stmt->bind_param('i',$_GET['img_id']);
        if($stmt->execute()){
            $stmt->store_result();
            $stmt->bind_result($img);
            $stmt->fetch();
            $stmt->close();

            header("Content-Type: image/jpeg");
            echo $img;
        }
    }

?>