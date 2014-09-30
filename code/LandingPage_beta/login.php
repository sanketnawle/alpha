<?php ob_start();?>
<!DOCTYPE html> 
<html>
	<head>
                <title>Urlinq</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="login.css">
		<link rel="stylesheet" href="https://yui.yahooapis.com/pure/0.3.0/pure-min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
                
        <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
  		<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script> 
        
  <?php
  
  session_start();
  //if(isset($_SESSION['logged_in']))
  //   header("Location: home.php");
  
  ?>          
            
        <script>
        var limit = 60;
		var start = 120;
		var moveBy = 1.4;
		var timer1 = setInterval(function() {
			$('#num').text(start);
			$('.body-background').css('background-position', start + 'px 0');
			start ++;
			if(start<0){
				alert("done");
				clearTimeout(timer1);
			}
		},50);
        $(document).ready(function() {
            $(document).keydown(function() {
                        $(".ui-menu-item").css("background-color","transparent");
                        $(".ui-state-focus").parent().css("background-color","#dadada");
                        });
                          
            $(document).delegate(".ui-menu-item","mouseover",function(){
                                 $(".ui-menu-item").css("background-color","transparent");
                                 $(this).css("background-color","#dadada");
                                 });

            $(document).delegate("#student-label","click",function(){
                                $("#faculty").prop('checked', false);
                                $("#student").prop('checked', true);
								$("#password-signup").css("width","150px");
                                $(".inputspassword-p").addClass("inputspassword-s");
                                $(".inputspassword-p").removeClass("inputspassword-p");
								$(".styled-select").show();
								$("#dept-signup").hide();
								$("#major-signup").show();                                
                                         });
                          
            $(document).delegate("#prof-label","click",function(){
                                $("#faculty").prop('checked', true);
                                $("#student").prop('checked', false);
                                $(".styled-select").hide();
                              	$("#major-signup").hide();
                                $("#dept-signup").show();
                                $("#password-signup").css("width","275px");
                                $(".inputspassword-s").addClass("inputspassword-p");
                                $(".inputspassword-s").removeClass("inputspassword-s");
                                               });
                          
             $(document).delegate(".typecheck","change",function(){  
                                  var id=$(this).attr("id");
                                  if(id=="faculty"){
                                    $(".styled-select").hide();
                                  	$("#major-signup").hide();
                                    $("#dept-signup").show();
                                    $("#password-signup").css("width","275px");
                                    $(".inputspassword-s").addClass("inputspassword-p");
                                    $(".inputspassword-s").removeClass("inputspassword-s");
                                  }else{
                                    if(id=="student"){
                                  $("#password-signup").css("width","150px");

                                  $(".styled-select").show();
                                  $("#dept-signup").hide();
                                  $("#major-signup").show();
                                  $(".inputspassword-p").addClass("inputspassword-s");
                                  $(".inputspassword-p").removeClass("inputspassword-p");
                                    }
                                  }
                                  
                                  
                                  });
                          
                          
            $(document).delegate("#middle-logo","mouseover",function(){
                                 $(this).css("opacity","0.2");
                                 $(this).height(86);
                                 $(this).width(334);
                                 });
                          
            $(document).delegate("#middle-logo","mouseout",function(){
                                $(this).css("opacity","1");
                                $(this).height(120);
                                $(this).width(450);
                                });
             

                          
                          
          $(document).delegate(".exit","click",function(){
                               $("#signin-popup").hide();
                               $("#black-out").hide();
                               return false;
                               });
          
                        
                          
        $(document).delegate(".exit","mouseover",function(){
                                $(this).css("opacity","1");
                                });            
        $(document).delegate(".exit","mouseout",function(){
                                $(this).css("opacity","0.6");
                                });           
                          
        });
            

            

		$.widget( "custom.catcomplete", $.ui.autocomplete, {
		_renderMenu: function( ul, items ) {
		  var that = this,
		    currentCategory = "";
		  $.each( items, function( index, item ) {
		    if ( item.category != currentCategory ) {
		      ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
		      currentCategory = item.category;
		    }
		    that._renderItemData( ul, item );
		  });
		}
		});	
        
		$(function() {
		    var data = [
		      { label: "Applied Physics", category: "Bachelor of Science" },
		      { label: "Biomolecular Science", category: "Bachelor of Science" },
		      { label: "Business and Technology Management", category: "Bachelor of Science" },
		      { label: "Chemical and Biomolecular Engineering", category: "Bachelor of Science" },
		      { label: "Civil Engineering", category: "Bachelor of Science" },
		      { label: "Computer Engineering", category: "Bachelor of Science" },
		      { label: "Computer Science", category: "Bachelor of Science" },
		      { label: "Construction Management", category: "Bachelor of Science" },
		      { label: "Electrical Engineering", category: "Bachelor of Science" },
		      { label: "Integrated Digital Media", category: "Bachelor of Science" },
		      { label: "Mathematics", category: "Bachelor of Science" },
		      { label: "Mechanical Engineering", category: "Bachelor of Science" },
		      { label: "Physics and Mathematics", category: "Bachelor of Science" },
		      { label: "Science and Technology Studies", category: "Bachelor of Science" },
		      { label: "Sustainable Urban Environments", category: "Bachelor of Science" },
		      { label: "Applied Physics", category: "Master of Science" },
		      { label: "Bioinformatics", category: "Master of Science" },
		      { label: "Biomedical Engineering", category: "Master of Science" },
		      { label: "Biotechnology", category: "Master of Science" },
		      { label: "Biotechnology and Entrepreneurship", category: "Master of Science" },
		      { label: "Chemical Engineering", category: "Master of Science" },
		      { label: "Chemistry", category: "Master of Science" },
		      { label: "Civil Engineering", category: "Master of Science" },
		      { label: "Computer Engineering", category: "Master of Science" },
		      { label: "Computer Science", category: "Master of Science" },
		      { label: "Construction Management", category: "Master of Science" },
		      { label: "Cybersecurity", category: "Master of Science" },
		      { label: "Electric Engineering", category: "Master of Science" },
		      { label: "Environmental Engineering", category: "Master of Science" },
		      { label: "Environmental Science", category: "Master of Science" },
		      { label: "Financial Engineering", category: "Master of Science" },
		      { label: "Industrial Engineering", category: "Master of Science" },
		      { label: "Integrated Digital Media", category: "Master of Science" },
		      { label: "Management of Technology", category: "Master of Science" },
		      { label: "Management", category: "Master of Science" },
		      { label: "Manufacturing Engineering", category: "Master of Science" },
		      { label: "Mathematics", category: "Master of Science" },
		      { label: "Mechanical Engineering", category: "Master of Science" },
		      { label: "Organizational Behavior", category: "Master of Science" },
		      { label: "Systems Engineering", category: "Master of Science" },
		      { label: "Transportation Management", category: "Master of Science" },
		      { label: "Transportation Planning and Engineering", category: "Master of Science" },
		      { label: "Urban Systems Engineering and Management", category: "Master of Science" }
		    ];
		 
		    $( "#major-signup" ).catcomplete({
				delay: 0,
				source: data
		    });
		});	  
            

		$(function() {
		    var data = [
		      { label: "NYU Polytechnic School of Engineering", category: "" },
		      { label: "New York University", category: "" }
		    ];
		 
		    $( "#university-signup" ).catcomplete({
				delay: 0,
				source: data
		    });
		});	
            
            
            $(function() {
              var data = [
					      { label: "Applied Physics", category: "" },
					      { label: "Chemical and Biomolecular Engineering", category: ""},
					      { label: "Civil and Urban Engineering", category: ""},
					      { label: "Computer Science and Engineering", category: ""},
					      { label: "Electrical and Computer Engineering", category: ""},
					      { label: "Finance and Risk Engineering", category: ""},
					      { label: "Mathematics", category: ""},
					      { label: "Mechanical and Aerospace Engineering", category: ""},
					      { label: "Technology Management and Innovation", category: ""},
					      { label: "Technology, Culture and Society", category: ""}
					      ];
              
              $( "#dept-signup" ).catcomplete({
                                                    delay: 0,
                                                    source: data
                                                    });
              });	        
            
		/*function showSignin() {
		   document.getElementById('signin-popup').style.display = "inline-block";
		}*/
            $(document).delegate(".signupinput","focus",function(){
                                 $(this).append("<div class='info'><div class='iwedge'></div><div id='icontent'></div></div>");
                                 });
            
        </script>
        
<?php
$error=FALSE;
$login_error=null;
include('includes/user.php');
$users = new Users;
$email=null;

require 'facebook-php-sdk-master/src/facebook.php';
//require 'facebook-php-sdk-master/src/fbmain.php';

$facebook = new Facebook(array(
  'appId'  => '237922879690774',
  'secret' => 'a964dc8a3e15cf4fe5fc5f307e31d694',
  
));

// See if there is a user from a cookie
$user = $facebook->getUser();
$_SESSION['user']=$user;
$_SESSION['fblogin']=true;
//$_SESSION['accessToken'] = $facebook->getAccessToken();
if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
    $email=$user_profile['email'];
     
  } catch (FacebookApiException $e) {
   // echo '<pre>'.htmlspecialchars(print_r($e, true)).'</pre>';
    $user = null;
  }
}

if ($user) {
     $logoutUrl = $facebook->getLogoutUrl();
} else {
  //$loginUrl = $facebook->getLoginUrl();
    $loginUrl   = $facebook->getLoginUrl(
            array(
                'scope'         => 'email,offline_access,publish_stream,user_birthday,user_location,user_work_history,user_about_me,user_hometown',
                'redirect_uri'  => 'https://urlinq.com/login_fb.php'
            )
    );
}

?>

	</head>
	<body>
		<div class = "body-background">
			<div id="banner">	


			</div>

			<div id = "content">

				<div class = "front-window">

					<div id ="banner-content">
						<div id = "logo-div">
							<img src = "src/logo.png" id = "logo" height ="0" width ="180 " alt style = "vertical-align:middle"/>
						</div>
						<form name="login-form" id="login-form" class="login-form" method='post'action='<?php //echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
							<input name = "email" type="text" id="email-signin" placeholder="University Email"></input>
					        <input name = "password" type="password" id="password-signin" placeholder="Your Password"></input>
						<div id="check-signin">
				            <input id = "demo_box_2" class="css-checkbox-s" type="checkbox"/>
				            <label for="demo_box_2" name="demo_lbl_2" class="css-label-s">Remember me</label>
				        </div>	
	                                        <div class="signinbutton" id="signin" onClick="document.forms['login-form'].submit();">

								<div class="signintext">Sign In</div>

							</div>
						</form>
	                                    
<?php
//include 'includes/user.php';
if(isset($_POST["email"],$_POST["password"]))
{
	//$users=new Users;
	$email = $_POST["email"];
	$password = hash('sha512',$_POST["password"]);
	if($email && $password)
	{
	            $connect= mysql_connect("localhost","campusla_UrlinqU","PASSurlinq@word9") or die("Could't connect to databse");
	            mysql_select_db("campusla_urlinq_demo") or die("Couldn't find databse");
	            $query= mysql_query("SELECT * FROM student_login_1 WHERE email = '$email'");
	            $numrows=  mysql_num_rows($query);
                    
                    $connect1= mysql_connect("localhost","campusla_UrlinqU","PASSurlinq@word9") or die("Could't connect to databse");
	            mysql_select_db("campusla_urlinq_demo") or die("Couldn't find databse");
	            $query1= mysql_query("SELECT * FROM professor_login_1 WHERE email = '$email'");
	            $numrows1=  mysql_num_rows($query1);
	            
	            if($numrows==1)
	            {
	                while($row=mysql_fetch_assoc($query))
	                {
	                    $dbs_id=$row['studid'];
	                    $dbemail=$row['email'];
	                    $dbpassword=$row['password'];
	                }
	                if($email==$dbemail && $password==$dbpassword)
	                {
	                    ob_start();
	                    //session_start();
	                    $_SESSION['usertype']='student';
	                    $_SESSION['logged_in']=true;
	                    $_SESSION['student_id']=$dbs_id;
	                    $_SESSION['email']=$dbemail;
	                    echo'<script> window.location="home.php"; </script> ';
	                }
					else 
						{
							$error=TRUE;
							$login_error="Incorrect Email or Password";
	                        
						}
                }
                else if($numrows1==1)
			    {
					while($row=mysql_fetch_assoc($query1))
						{
							$dbprofid=$row['profid'];
							$dbemail=$row['email'];
							$dbpassword=$row['password'];
						}
	                if($email==$dbemail && $password==$dbpassword)
	                    {
	                        ob_start();
	                        //session_start();
	                        $_SESSION['usertype']='professor';
	                        $_SESSION['logged_in']=true;
	                        $_SESSION['professor_id']=$dbprofid;
	                        $_SESSION['email']=$dbemail;
	                        echo'<script> window.location="home.php"; </script> ';
	                    }
					else 
						{
							$error=TRUE;
							$login_error="Incorrect Email or Password";
	                        
						}
                }
                else 
	            {
	                $error=TRUE;
	                $login_error="You haven't signed up";
	                        
	            }
        }   
	elseif($users->validateEduEmail($email)== false)
	     {
	         $error=TRUE;
	         $login_error="Incorrect Email";
	     }
        
        else
             {
                $error=TRUE;
                $login_error="Please Enter Your Email";
             }
	
}


	?>
	<?php if ($error) { echo '<div class = "signin-error">'.$login_error.'</div>'; } ?>
	                                    
	                                    
	                                    
	                                    
	                                    
	                                    
	                                    
	                                    <?php 
	                                            if ($user) 
	                                                {    
	                                                  //ob_clean();
	                                                  ob_start();
	                                                  if($users->userAlreadyExists($email)== FALSE)
	                                                      header ("Location: login_fb.php");
	                                                  else
	                                                  {
	                                                      ob_start();
	                                                      header("Location: home.php"); 
	                                                  }
	                                                } 
	                                             else 
	                                                 { ?>
	                                                                                                  
	                                                       <a href="<?php echo $loginUrl; ?>">
	                                                       <div class="socialbutton" id="facebook">
	                                                           <div class="signintext" >
	                                                           Sign In with Facebook
	                                                        </div>
	                                                        <img id = "fb-logo" src="src/fb-logo.png" onclick="FB.login(null,{perms:'email,offline_access,publish_stream,user_birthday'})">
	                                                      </div> </a>
	                                    <div>
	                                                  </div>
	                                                <?php } ?>
						<div id="fb-root"></div>
	                                        
	                                        <script>
	                                          window.fbAsyncInit = function() {
	                                            FB.init({
	                                              appId: '<?php echo $facebook->getAppID() ?>',
	                                              cookie: true,
	                                              xfbml: true,
	                                              oauth: true
	                                            });
	                                            };
	                                            function login()
	                                            { 
	                                                FB.getLoginStatus(function(r)
	                                                { 
	                                                    if(r.status === 'connected')
	                                                    { 
	                                                        window.location.href = 'login_fb.php';
	                                                    }
	                                                    else
	                                                    { 
	                                                        FB.login(function(response) { 
	                                                            if(response.authResponse) 
	                                                            { //if (response.perms) 
	                                                                window.location.href = 'login_fb.php'; 
	                                                            } 
	                                                            else 
	                                                            { // user is not logged in 
	                                                             } 
	                                                         },{scope:'email'}); // which data to access from user profile 
	                                                     } 
	                                                  }); 
	                                              } 
	                                            
	                                           // FB.Event.subscribe('auth.login', function(response) {
	                                           //   window.location='https://urlinq.com/login_fb.php';
	                                           // });
	                                           // FB.Event.subscribe('auth.logout', function(response) {
	                                           //   window.location.reload();
	                                           // });
	                                         // };
	                                          (function() {
	                                            var e = document.createElement('script'); e.async = true;
	                                            e.src = document.location.protocol +
	                                              '//connect.facebook.net/en_US/all.js';
	                                            document.getElementById('fb-root').appendChild(e);
	                                          }());
	                                        </script>

							
							
	                                 
						
					</div>
					<div id = "signin-controls">

				        <span class="separator">·</span>
				        <div id="forgot"><a id = "forgot-a" href="retrieve_password.php">Forgot password?</a></div>
					</div>
	                            
					<div class = "welcome">

					</div>
					<div class = "signup">

						<div id="header-signup">
							<p id = "header-p">New to Urlinq? <span id = "signup-span">Create an Account</span>
							</p>
                        </div>
                               
	                                                 
							<form id="signupform" class = "ajax" method="post" action="signup_student.php">
	                            <script src="https://code.jquery.com/jquery-1.10.1.min.js"></script>
	                            <script type="text/javascript" src="student_signup.js"></script>
								<ul class="account-types">
								  <li class="account-type student">
								    <input name="account-types" value="student" type="radio" id="student" class="typecheck" checked>
								    <label for="student" >Student</label>
								    <div id = "student-label">I'm a Student</div>
								  </li>
                                                                   
								  <li class="account-type faculty">
								    <input name="account-types" value="faculty" type="radio" id="faculty" class="typecheck">
								    <label for="faculty">Professor</label>
								    <div id = "prof-label">I'm a Professor</div>
								  </li>

								</ul>
								<div id = "input-fields">
                                                                        <div class="inputs"><input name = "name" type="text" id="name-signup" placeholder="Full Name" class="signupinput"></input><p id="nameerror"  class = "signup-error"></p></div></li>
								        <div class="inputs"><input name = "email" type="email" id="email-signup" placeholder="Your .edu Email Adress" class="signupinput"></input><p id="emailerror"  class = "signup-error"></p></div></li>
                                                                        
                                                                        
							        	<div class = "ui-widget2">
							        		<div class="inputs"><input name = "university" type="text" id="university-signup" placeholder="Your University" class="signupinput"></input><p id="universityerror" class = "signup-error"></p></div>
							        	</div>
                                                                        
								        <div class="inputspassword-s"><input name = "password" type="password" id="password-signup" placeholder="Password" class="signupinput"></input><p id="passworderror" class = "signup-error2"></p></div>

										<div class ="styled-select">  
									        <select name = "graduation-year" id = "year-signup">
									        	<option id = "placeholder_select" value = "0" selected = "1">Class Year</option>
									        	<option value = "2014">2014</option>
									        	<option value = "2015">2015</option>
									        	<option value = "2016">2016</option>
									        	<option value = "2017">2017</option>
									        	<option value = "2018">2018</option>
									        	<option value = "2019">2019</option>
									        </select>
								    	</div>
								        <div class="ui-widget">
										  <input name="major" type = "text" id="major-signup" placeholder = "Your Major" class="signupinput"></input>
										</div>
		                                <div class = "ui-widget3">
								        	<input name = "dept" type="text" id="dept-signup" placeholder="Department" class="signupinput"></input>
								        </div>

										<input style = "font-size:20px; font-weight:600;padding-top: 1.6px; padding-left: 3px;" type = "submit" id = "submit-signup" value="Sign Up"></input>
							    </div>
	                                                    <div id="ack"></div>

	    	
	 
	                                                    
	                                                    
							</form>
                                                   <script type="text/javascript" src="js/validation.js"></script>
                                               

					</div>
	                


				</div>


			</div>
		</div>
	</body>
</html>
<?php ob_end_flush(); ?>