<?php ob_start(); ?>
<!DOCTYPE html> 
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="school_select.css">
	<title>Urlinq Academic Social Network</title>
	<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<script>
        $(document).ready(function() {

            $(document).delegate("#poly-label","click",function(){
                                 $("#poly").prop('checked', true);
                                

                                         });
                          
            $(document).delegate("#nyu-label","click",function(){
                                $("#nyu").prop('checked', true);

                                               });

            $(document).delegate("#stern-label","click",function(){
                                $("#stern").prop('checked', true);                                

                                               });
            $(document).delegate("#abu-label","click",function(){
                                 $("#abu").prop('checked', true);
                                

                                         });
                          
            $(document).delegate("#shang-label","click",function(){
                                $("#shang").prop('checked', true);

                                               });

            $(document).delegate("#courant-label","click",function(){
                                $("#courant").prop('checked', true);                                

                                               });

            $(document).delegate("#tisch-label","click",function(){

                                $("#tisch").prop('checked', true); 

                                               });

            $(document).delegate("#gall-label","click",function(){

                                $("#gall").prop('checked', true); 
                                
                                               });

            $(document).delegate("#stein-label","click",function(){
 
                                $("#stein").prop('checked', true);                                 
                                               });
            $(document).delegate("#med-label","click",function(){
                                $("#med").prop('checked', true);                 });

            $(document).delegate("#law-label","click",function(){
                                $("#law").prop('checked', true);
                                               });

            $(document).delegate("#nursing-label","click",function(){
                                $("#nursing").prop('checked', true);
                                               });                          
            $(document).delegate("#wag-label","click",function(){
                                $("#wag").prop('checked', true);
                                               });  
            $(document).delegate("#silver-label","click",function(){
                                $("#silver").prop('checked', true);
                                               });  
            $(document).delegate("#dent-label","click",function(){
                                $("#dent").prop('checked', true);
                                               });                                                                                 
            $(".next-button").removeClass("ready-next");
            $(document).delegate("#nyu","click",function(){
				$(".next-button").removeClass("unready-next");            	
				$(".next-button").addClass("ready-next");
			 });
            $(document).delegate("#nyu-label","click",function(){
				$(".next-button").removeClass("unready-next");            	
				$(".next-button").addClass("ready-next");
			 });
            $(document).delegate("#poly-label","click",function(){
				$(".next-button").removeClass("unready-next");            	
				$(".next-button").addClass("ready-next");
			 });           
            $(document).delegate("#poly","click",function(){
				$(".next-button").removeClass("unready-next");            	
				$(".next-button").addClass("ready-next");
			});
            $(document).delegate("#stern-label","click",function(){
				$(".next-button").removeClass("unready-next");            	
				$(".next-button").addClass("ready-next");
			 });           
            $(document).delegate("#stern","click",function(){
				$(".next-button").removeClass("unready-next");            	
				$(".next-button").addClass("ready-next");
			});
            $(document).delegate("#tisch-label","click",function(){
				$(".next-button").removeClass("unready-next");            	
				$(".next-button").addClass("ready-next");
			 });           
            $(document).delegate("#tisch","click",function(){
				$(".next-button").removeClass("unready-next");            	
				$(".next-button").addClass("ready-next");
			});
            $(document).delegate("#gall-label","click",function(){
				$(".next-button").removeClass("unready-next");            	
				$(".next-button").addClass("ready-next");
			 });           
            $(document).delegate("#gall","click",function(){
				$(".next-button").removeClass("unready-next");            	
				$(".next-button").addClass("ready-next");
			});
            $(document).delegate("#stein","click",function(){
				$(".next-button").removeClass("unready-next");            	
				$(".next-button").addClass("ready-next");
			});			
            $(document).delegate("#stein-label","click",function(){
				$(".next-button").removeClass("unready-next");            	
				$(".next-button").addClass("ready-next");
			});

			$(document).delegate("#med","click",function(){
				$(".next-button").removeClass("unready-next");            	
				$(".next-button").addClass("ready-next");
			});			
            $(document).delegate("#med-label","click",function(){
				$(".next-button").removeClass("unready-next");            	
				$(".next-button").addClass("ready-next");
			});
			$(document).delegate("#law","click",function(){
				$(".next-button").removeClass("unready-next");            	
				$(".next-button").addClass("ready-next");
			});			
            $(document).delegate("#law-label","click",function(){
				$(".next-button").removeClass("unready-next");            	
				$(".next-button").addClass("ready-next");
			});
			$(document).delegate("#nursing","click",function(){
				$(".next-button").removeClass("unready-next");            	
				$(".next-button").addClass("ready-next");
			});			
            $(document).delegate("#nursing-label","click",function(){
				$(".next-button").removeClass("unready-next");            	
				$(".next-button").addClass("ready-next");
			});
			$(document).delegate("#wag","click",function(){
				$(".next-button").removeClass("unready-next");            	
				$(".next-button").addClass("ready-next");
			});			
            $(document).delegate("#wag-label","click",function(){
				$(".next-button").removeClass("unready-next");            	
				$(".next-button").addClass("ready-next");
			});
			$(document).delegate("#silver","click",function(){
				$(".next-button").removeClass("unready-next");            	
				$(".next-button").addClass("ready-next");
			});			
            $(document).delegate("#silver-label","click",function(){
				$(".next-button").removeClass("unready-next");            	
				$(".next-button").addClass("ready-next");
			});

			$(document).delegate("#dent","click",function(){
				$(".next-button").removeClass("unready-next");            	
				$(".next-button").addClass("ready-next");
			});			
            $(document).delegate("#dent-label","click",function(){
				$(".next-button").removeClass("unready-next");            	
				$(".next-button").addClass("ready-next");
			});

			$(document).delegate("#abu","click",function(){
				$(".next-button").removeClass("unready-next");            	
				$(".next-button").addClass("ready-next");
			});			
            $(document).delegate("#abu-label","click",function(){
				$(".next-button").removeClass("unready-next");            	
				$(".next-button").addClass("ready-next");
			});		

			$(document).delegate("#shang","click",function(){
				$(".next-button").removeClass("unready-next");            	
				$(".next-button").addClass("ready-next");
			});			
            $(document).delegate("#shang-label","click",function(){
				$(".next-button").removeClass("unready-next");            	
				$(".next-button").addClass("ready-next");
			});	
			$(document).delegate("#courant","click",function(){
				$(".next-button").removeClass("unready-next");            	
				$(".next-button").addClass("ready-next");
			});			
            $(document).delegate("#courant-label","click",function(){
				$(".next-button").removeClass("unready-next");            	
				$(".next-button").addClass("ready-next");
			});

        });
	</script>
</head>
<body>
		<div class = "main-container">

			<div class = "instructions-banner">
				<div onclick="window.open('http://nyu.edu','_newtab');" class = "instructions-banner-univ">


					<p class = "univ-name">NYU</p>
					<img id = "univ-logo" src = "src-school-select/univ-logo.png">
				</div>
				
				<p class = "instructions-banner-head">Please select the main school you are linked to at</p>
			</div>
			<div class = "school-select-main" >
				<form class = "school-select" method='post'action='<?php //echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
					<ul class="school-types">
					  <li class="school-type poly">
					    <input name="school-types" value ="NYU Poly" type="radio" id="poly" class="typecheck">
					    <label for="poly">Poly</label>
					    <p id = "poly-label">Polytechnic School of Engineering</p>
					  </li>

					  <li class="school-type nyu">
					    <input name="school-types" value ="NYU CAS" type="radio" id="nyu" class="typecheck">
					    <label for="nyu">NYU CAS</label>
					    <p id = "nyu-label">College of Arts and Sciences</p>
					  </li>

					  <li class="school-type stern">
					    <input name="school-types" value ="NYU STERN" type="radio" id="stern" class="typecheck">
					    <label for="stern">Stern</label>
					    <p id = "stern-label">Stern School of Business</p>
					  </li>
					  <br>
					  <li style = "margin-top:18px;" class="school-type tisch">
					    <input name="school-types" value ="NYU TISCH"type="radio" id="tisch" class="typecheck">
					    <label for="tisch">Tisch</label>
					    <p id = "tisch-label">Tisch School of the Arts</p>
					  </li>

					  <li style = "margin-top:18px;" class="school-type gall">
					    <input name="school-types" type="radio" id="gall" class="typecheck">
					    <label for="gall">Gall</label>
					    <p id = "gall-label">Gallatin School of Individualized Study</p>
					  </li>

					  <li style = "margin-top:18px;" class="school-type stein">
					    <input name="school-types" type="radio" id="stein" class="typecheck">
					    <label for="stein">Steinhardt</label>
					    <p id = "stein-label">Steinhardt School of Culture and Education</p>
					  </li>	
					  <br>	
					  <li style = "margin-top:18px;" class="school-type med">
					    <input name="school-types" type="radio" id="med" class="typecheck">
					    <label for="med">Medical</label>
					    <p id = "med-label">School of Medicine</p>
					  </li>					  

					  <li style = "margin-top:18px;" class="school-type law">
					    <input name="school-types" type="radio" id="law" class="typecheck">
					    <label for="law">NYU Law</label>
					    <p id = "law-label">School of Law</p>
					  </li>

					  <li style = "margin-top:18px;" class="school-type nursing">
					    <input name="school-types" type="radio" id="nursing" class="typecheck">
					    <label for="nursing">Nursing</label>
					    <p id = "nursing-label">School of Nursing</p>
					  </li>	
					  <br>	
					  <li style = "margin-top:18px;" class="school-type wag">
					    <input name="school-types" type="radio" id="wag" class="typecheck">
					    <label for="wag">Wagner</label>
					    <p id = "wag-label">Wagner School of Public Service</p>
					  </li>

					  <li style = "margin-top:18px;" class="school-type silver">
					    <input name="school-types" type="radio" id="silver" class="typecheck">
					    <label for="silver">Silver</label>
					    <p id = "silver-label">Silver School of Social Work</p>
					  </li>

					  <li style = "margin-top:18px;" class="school-type dent">
					    <input name="school-types" type="radio" id="dent" class="typecheck">
					    <label for="dent">Dentistry</label>
					    <p id = "dent-label">School of Dentistry</p>
					  </li>	
					  <br>	
					  <li style = "margin-top:18px;" class="school-type abu">
					    <input name="school-types" type="radio" id="abu" class="typecheck">
					    <label for="abu">Abu Dhabi</label>
					    <p id = "abu-label">NYU Abu Dhabi</p>
					  </li>

					  <li style = "margin-top:18px;" class="school-type courant">
					    <input name="school-types" type="radio" id="courant" class="typecheck">
					    <label for="courant">Courant Institute</label>
					    <p id = "courant-label">Courant Institute of Mathematical Sciences</p>
					  </li>

					  <li style = "margin-top:18px;" class="school-type shang">
					    <input name="school-types" type="radio" id="shang" class="typecheck">
					    <label for="shang">NYU Shanghai</label>
					    <p id = "shang-label">NYU Shanghai</p>
					  </li>						  

					</ul>

			</div>
			<br>
			<div class = "main-container-footer">
				<p>15 schools found</p>
			</div>
		</div>

		<div class = "top-nav">
			<div class = "top-nav-container">
				<div id = "logo-div">
					<img id = "logo-pic" src = "src-school-select/logo.png">
				</div>
				<input name = "submit-button" type = "submit" id = "next-button" class = "next-button ready-next unready-next" value = "Next"></input>
<?php
include_once 'includes/user.php';
include_once 'Mail.php';
$users = new Users;
$key = $_GET['key'];
if($key[0]=='s')
{
    $type = 'temp_user';
    $key = substr($key,1,33);
}
else if($key[0]=='p')
{
    $type = 'temp_prof';  
    $key = substr($key,1,33);
}
if(isset($_POST['school-types']))
{
    $school=$_POST['school-types'];
    if($school == 'NYU Poly')
    {
        if($users->schoolSelect($type,$school,$key) == TRUE)
        {
            $email = $users->schoolEmail($type,$key);
            $body="
                            <html>
                            <body>
                            Thank you for signing up! Please visit <a href='https://urlinq.com/confirm.php?key=".$key."'>this url</a> to verify your account.
                                </body></html>";
                        

			$headers = array(
                            
				'From' => 'Urlinq<no-reply@urlinq.com>',
				'To' => $email,
                                'Content-Type' => "text/html",
				'Subject' => 'Successfully signed up - verification needed'
			);
			$smtp = Mail::factory('smtp', array(
				'host' => 'ssl://box791.bluehost.com',
				'port' => '465',
				'auth' => true,
				'username' => 'team@urlinq.com',
				'password' => 'urlinq1234'
			));
			
			$mail = $smtp->send($email, $headers, $body);
			
			if (PEAR::isError($mail)) 
                            {
				$_SESSION['signup_message'] = "Error while sending verification email:".$mail->getMessage();
                            } 
                        else 
                            {
				$_SESSION['signup_message'] = "Successfully signed up! Check your email to verify your account.";
                                ob_start();
								$path = '?key='.$key.'&email='.$email;
                                header("Location: confirm_email.php".$path);
                            }
                           
        }
    }
    else
    {
        if($users->schoolSelect($type,$school,$key) == TRUE)
        {
            ob_start();
            header("Location: test.php");
        }
    }
}
   


?>
			</form>
			</div>
		</div>
		<footer class = "page-footer">
			<div class = "footer-wrapper">
				<nav class = "footer-links">
					<ul>
						<li>
							<span>About</span>
						</li>
						<li>
							<span>Jobs</span>
						</li>
						<li>
							<span>Contact</span>
						</li>
						<li>
							<span>Privacy</span>
						</li>
						<li>
							<span>Terms</span>
						</li>
					</ul>
				</nav>
				<p class = "copyright">
					<span>©</span>
					<span>2014</span>
					<span>Urlinq</span>
				</p>
			</div>
		</footer>

</body>
</html>