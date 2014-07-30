<?php
session_start();
if(isset($_COOKIE['user_id'])){
header('location:home.php');
}else{

}
?>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
                
        <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
      <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script> 
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

?>

<div id="fb-login" class="login">
</div>
<div id="email-login" class="login">
  <form name="login" id="login" method="post" action="php/afterlogin.php">
    email:<input type="text" name="login_email" id="login_email" placeholder=".edu email">
    password:<input type="password" name="login_password" id="login_password">
    <input type="submit" name="submit" id="submit">
  </form>
  <a href="retrieve_password.php">forgot password</a>
</div>
<div id="registration" class="registration">
        <form name="register" id="register" class="register" method="post" action="php/afterregister.php" autocomplete="on">
           First name:<input type="text" name="fname" id="fname" autocomplete="on"><br>
           Last name: <input type="text" name="lname" id="fname" autocomplete="on"><br>
           E-mail: <input type="email" name="email" autocomplete="off"><br>
           password:<input type="password" name="password" id="password" name="password"><br>
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
            University:<select id="parent_university" name="university" onchange="getschool()">
                       <option value="" selected="selected">select the univeristy</option>
                       <?php $query=mysqli_query($con,"SELECT parent_univ_id,parent_univ_name FROM parent_university");
                               if($query){
                                   echo "fail fetching parent_univeristy names";
                                }
                              while($row=mysqli_fetch_array($query)){?>
                        <option value="<?php echo $row['parent_univ_id']; ?>  "><?php echo $row['parent_univ_name']; ?></option>    
                              <?php } ?>
                            </select>
                            <br>

                       school:<select id="university" name="university"  onchange="getdepartment()" >
                       <option value="" selected="selected">select the school</option>
                        
                            
                      </select><br>
                      Department:<select id="department" name="department">
                      <option value="" selected="selected">select the Department</option>
                                   
                 </select><br>     
           <input type="submit" value="submit" id="submit" name="submit">



</div>

<script>
                                           
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected' ) {
    
      // Logged into your app and Facebook.
      testAPI();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
     
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
     
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
    
      statusChangeCallback(response);
    });
  }
 

  window.fbAsyncInit = function() {
  FB.init({
    appId      : '237922879690774',
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.0' // use version 2.0
  });

  // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });

  };

  // Load the SDK asynchronously
  (function(d){
           var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
           if (d.getElementById(id)) {return;}
           js = d.createElement('script'); js.id = id; js.async = true;
           js.src = "//connect.facebook.net/en_US/all.js";
           ref.parentNode.insertBefore(js, ref);
         }(document));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    }
    

                                          </script>


<div id="fb-root">
    <form id="myform3" name="myform3" method="post" action="php/fblogin.php">
        
    </form> 
    <form name="test" id="test" method="post" action="fblogin.php">
      <input id="first" type="hidden" name="first"   value="">
        <input type="hidden" id="last" name="last" value="" >
        <input type="hidden"  id="email" name="email" value="">
        <input type="hidden" id="id" name="id" value="">
    </form>
<fb:login-button scope="public_profile,email" onlogin="checkLoginState();"></fb:login-button>
  
</div>
<div id="problem">
 <?php
if(!empty($_GET['problem'])){
    echo $_GET['problem'];

}

 ?>

</div>
<script>
 //var count=1;
 function getschool(){
  
   console.log("in getschool method");
     var parent_university=document.getElementById("parent_university");
     var parent_university_id = parent_university.options[parent_university.selectedIndex].value;
    
     console.log(parent_university_id);
     
     var select = document.getElementById("university");
     $('#university').empty();
     $('#department').empty();
      $('<option value="" selected="selected">select the school</option>').appendTo('#university');
       $('<option value="" selected="selected">select the department</option>').appendTo('#department');
     
   $.ajax({  
            type: "POST",  
            url: "php/getdepartment.php",
            datatype:"json",
            data: { parent_univ_id : parent_university_id},
            //var department=document.getElementById('department');
            //department.innerHTML='';
            //var select = document.getElementById("department");
            //var length = select.options.length;
            success: function(response) {
              for(var obj in response){
                 console.log(response[obj].univ_name);
                 $('<option value="'+ response[obj].univ_id +'">' + 
                 response[obj].univ_name + '</option>').appendTo('#university');
                   
              }
              //html += '</select>';
              //count++;
            },
            error: function(response){
              var tse = response;
            }
        });             
  



  
}
 function getdepartment(){
  
   console.log("in major method");
     var university=document.getElementById("university");
     var university_id = university.options[university.selectedIndex].value;
    
     console.log(university_id);
     
     var select = document.getElementById("department");
     $('#department').empty();
      $('<option value="" selected="selected">select the department</option>').appendTo('#department');
     
   $.ajax({  
            type: "POST",  
            url: "php/getdepartment.php",
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