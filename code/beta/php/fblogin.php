<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<title>Untitled Document</title>
</head>
<body>
<?php
  session_start();
  include "../includes/common_functions.php";
  include "dbconnection.php";
  if(isset($_COOKIE['user_id'])){
       header("location:setsession.php");
  } else if(isset($_SESSION['id'])){
      header("location: setsession.php");
  }
  else if(isset($_POST['id'])){
      // echo "in post id";
       $id=sanitize($_POST['id'],$con);
      // echo $id;  
       $query=mysqli_query($con,"SELECT * FROM user_auth_provider WHERE auth_key='$id'");
         if(!$query){
           echo "query failed";

         }
         $number=mysqli_num_rows($query);
         if($number==1){
              $_SESSION['id']=$id;
              header("location: setsession.php");
         } else{

                    $firstname=sanitize($_POST['first'],$con);
                    $lastname=sanitize($_POST['last'],$con);
                    $_SESSION['id']=$id;
                    $email=sanitize($_POST['email'],$con);
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
          University:<select id="university" name="university"  onchange="getdepartment()" >
                        <option value="" selected="selected" >select a university</option>
                           <?php $query=mysqli_query($con,"SELECT univ_id,univ_name FROM university");
                               if($query){
                                   echo "fail fetching univeristy names";
                                }
                              while($row=mysqli_fetch_array($query)){?>
                              <option value="<?php echo $row['univ_id']; ?>  "><?php echo $row['univ_name']; ?></option>    
                              <?php }
              ?>
                            
                      </select><br>
                      Department:<select id="department" name="department">
                                   
                 </select><br>     
        <input type="hidden" name="first" value="<?php echo $firstname; ?>" >
        <input type="hidden" name="last" value="<?php echo $lastname; ?>" >
        <input type="hidden" name="email" value="<?php echo $email; ?>">
        <input type="hidden" name="id" value="<?php echo $id; ?>"> 
        <input type="submit" name="submit">
         
	</form>
  <script>
 var count=1;
 function getdepartment(){
  
   console.log("in major method");
     var university=document.getElementById("university");
     var university_id = university.options[university.selectedIndex].value;
    
     console.log(university_id);
     
     var select = document.getElementById("department");
      $('#department').empty();
     
   $.ajax({  
            type: "POST",  
            url: "getdepartment.php",
            datatype:"json",
            data: { univ_id : university_id},
            //var department=document.getElementById('department');
            //department.innerHTML='';
            //var select = document.getElementById("department");
            //var length = select.options.length;
            success: function(response) {
              for(var obj in response){
                 console.log(response[obj].dept_name);
                 $('<option value="'+ response[obj].dept_id +'">' + 
                 response[obj].dept_name + '</option>').appendTo('#department');
                   
              }
              //html += '</select>';
              //count++;
            },
            error: function(response){
              var tse = response;
            }
        });             
  



  
}
</script>
</body>
</html>