<?php
  require_once("dbconfig.php");
?>

<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Test</title>
  </head>
  <body>
      <form action="updatecomments.php" method="post" enctype="multipart/form-data">
        <label for="file">Filename:</label>
        <input type="file" name="file" id="file"><br>
        <input type="submit" name="submit" value="Submit">
      </form>
<?php
  $imgresult=mysqli_query($con,"SELECT file_content FROM file_upload WHERE file_type='image/jpeg'"); //Checks current login user liked this status or not
  $imgexist=mysqli_num_rows($imgresult);
    if($imgexist){
      while($imgrow=mysqli_fetch_array($imgresult)){
        $image  = $imgrow['file_content'];
        echo '<div>';
        echo '<img class="thumbnail" src="data:image/jpeg;base64,'.base64_encode($image).'" alt="photo"><br>';
        echo '</div>';
      }
    }
?>
  </body>
</html>