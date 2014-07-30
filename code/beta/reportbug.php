<html>
<head>
</head>
<body>
	<?php
    //connecting to the db
       $db_host = "localhost";
       $db_username = "campusla_UrlinqU";
       $db_pass = "mArCh3!!1992X";
       $db_name = "campusla_urlinq_beta";
       try {
                $con = new mysqli($db_host, $db_username, $db_pass, $db_name);
       }        catch (Exception $e) {
                exit("Database error. $e");
           }
  ?>
<form method="post" action="sendreport.php">
<table>
	<tr>
       <td>Name:</td>
             <td><input type="text" name="name" id="name"></td> 
   </tr>
   <tr>
             <td>Report:</td>
                         <td><TEXTAREA NAME="Report" ROWS="10" WRAP="hard">
                             </TEXTAREA></td>
   </tr><?php
         //$userid=$_COOKIE['userid']
         $query=mysqli_query($con,"SELECT user_email FROM user WHERE user_id=1");
         if(!$query){
             echo "query failed"; 
         }else{
             while($row=mysqli_fetch_array($query)){
                  $emailaddress=$row['user_email'];

             }

         }

        ?>
            <input type="hidden" name="emailaddress" value="<?php echo $emailaddress ?>"  >                      
   <tr>
	         <td><input type="submit" value="submit" name='submit' /></td>
   </tr>
</table> 
</form>
</body>
</html>