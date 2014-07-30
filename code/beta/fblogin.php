<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body>
<?php
 $db_host = "localhost";
     $db_username = "campusla_UrlinqU";
     $db_pass = "mArCh3!!1992X";
     $db_name = "campusla_urlinq_beta";
     try {
           $con = new mysqli($db_host, $db_username, $db_pass, $db_name);
      } catch (Exception $e) {
           exit("Database error. $e");
       }
  session_start();
  if(isset($_SESSION['id'])){
    header("location: hometest.php");
  }
  else if(isset($_POST['id'])){
      // echo "in post id";
       $id=$_POST['id'];
      // echo $id;  
       $query=mysqli_query($con,"SELECT * FROM user_auth_provider WHERE auth_key='$id'");
         if(!$query){
           echo "query failed";

         }
         $number=mysqli_num_rows($query);
         if($number==1){
              $_SESSION['id']=$id;
              header("location: hometest.php");
         } else{

                    $firstname=$_POST['first'];
                    $lastname=$_POST['last'];
                    echo $firstname;
                    echo $lastname;
                    echo $id;
                    $_SESSION['id']=$id;
                    $email=$_POST['email'];
                    $query=mysqli_query($con,"INSERT INTO user_auth_provider(user_id,auth_key,auth_provider,fb_email) 
                                              values('','$id','facebook','$email')");
                    if(!$query){
                      echo "falied to insert into fb"; 
                    }

          }
  }        
        
?>
<form name="myform3" method="post" action="afterregister.php">
		<!-- It needn't be a "hidden" type, but anything from radio buttons to check boxes -->
        NYUid<input type="text" name="emailid"  >
         Gender:<select option id="gender" name="gender">
                     <option value="" selected="selected">youare</option>
                     <option value="M">male</option>
                     <option value="F">female</option>
                  </select>   
           I am a:<select id="account-type" name="account-type">
                     <option value="" selected="selected">select a user type</option>
                     <option value="s">student</option>
                     <option value="p">professor</option>
                  </select><br>
           University:<select id="university" name="university">
                        <option value="" selected="selected" >select a university</option>
                           <?php $query=mysqli_query($con,"SELECT univ_name FROM university");
                               if($query){
                                   echo "fail fetching univeristy names";
                                }
                              while($row=mysqli_fetch_array($query)){?>
                              <option value="<?php echo $row[univ_name]; ?>  "><?php echo $row[univ_name]; ?></option>    
                              <?php }
              ?>
                            
                      </select><br>
                      Department:<select id="department" name="department">
                                   <option value="" selected="selected" >select a Department</option>
                                   <?php
                                    $query=mysqli_query($con,"SELECT dept_name FROM department");
                                    if($query){
                                    echo "fail fetching univeristy names";
                                    }
                                    while($row=mysqli_fetch_array($query)){?>
                                    <option value="<?php echo $row[dept_name]; ?>  "><?php echo $row[dept_name]; ?></option>    
                                  <?php } ?>
                 </select><br>       
        <input type="hidden" name="first" value="<?php echo $firstname; ?>" >
        <input type="hidden" name="last" value="<?php echo $lastname; ?>" >
        <input type="hidden" name="email" value="<?php echo $email; ?>">
        <input type="hidden" name="id" value="<?php echo $id; ?>"> 
        <input type="submit" name="submit">
         
	</form>
</body>
</html>