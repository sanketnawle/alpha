<?php
include_once('includes/user.php');
include_once('Mail.php');
$users = new Users;
$error=FALSE;

if (isset($_POST['name'], $_POST['email'], $_POST['password'], $_POST['university'],$_POST['major'],$_POST['graduation-year'], $_POST['account-types']))
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	
        $name = $_POST['name'];
        $email = $_POST['email'];
	$password = hash('sha512',$_POST['password']);
        $university = $_POST['university'];
        $major = $_POST['major']; 
        $year = (int)$_POST['graduation-year'];
        $usertype= $_POST['account-types'];
        $department= $_POST['dept'];
   
   if($usertype=='student')
   {
        if (empty($name) or empty($email) or empty($password) or empty($university))
             {
                  $error=TRUE;
		  $signup_error= "";
                  
             }
	  
        else if ($users->userAlreadyExists($email) == TRUE) 
             {
                  $error=TRUE;
                  $signup_error = "There is already an account with that email address";
	     } 
         else 
             {
		$key = md5(uniqid());
                $added = $users->addTempUser($name, $email, $password, $university, $major, $year, $key);
                $_SESSION['signup_message'] = null;
                if(strcasecmp($university,'NYU')==0 or strcasecmp($university,'New York University')==0)
                   {
                        $error = TRUE;
                        $signup_error= "NYU".'s'.$key;
                   }
                else if(strcasecmp($university,'NYU Poly')==0 or strcasecmp($university,'Polytechnic Institute of NYU')==0 or strcasecmp($university,'New York University Polytechnic School of Engineering')==0 or strcasecmp($university,'NYU Polytechnic School of Engineering')==0)
                {
                        if ($added != false) {
			//send verification email
			
			error_reporting(0); //don't show deprecated/warning messages
			
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
							$error="success";
							$signup_error= 'success'.$key.' '.$email;
				
                            }
                    
                } 
                else 
                    {
						$error=TRUE;
                        $signup_error="Database error";
                    }
                }
                else
                    {
                        $error=TRUE;
                        $signup_error= "other";
                    }
                
	   }
   }
 else 
     {
        if (empty($name) or empty($email) or empty($password) or empty($university))
            {
                  $error=TRUE;
		  $signup_error= "";
                  
            }
	  
        else if ($users->profAlreadyExists($email) == FALSE) 
             {
                  $error=TRUE;
                  $signup_error = "This email address is not registered in our database";
	     } 
         else 
             {
		$key = md5(uniqid());
                $added = $users->addTempProf($name, $email, $password, $university, $department, $key);
                $_SESSION['signup_message'] = null;
                if(strcasecmp($university,'NYU')==0 or strcasecmp($university,'New York University')==0)
                   {
                        $error = TRUE;
                        $signup_error= "NYU".'p'.$key;
                   }
                else if(strcasecmp($university,'NYU Poly')==0 or strcasecmp($university,'Polytechnic Institute of NYU')==0 or strcasecmp($university,'New York University Polytechnic School of Engineering')==0 or strcasecmp($university,'NYU Polytechnic School of Engineering')==0)
                   {
                    if ($added != false) {
			//send verification email
			
			error_reporting(0); //don't show deprecated/warning messages
			
                        $body="
                            <html>
                            <body>
                            Thank you for signing up! Please visit <a href='localhost/PhpProject/landingPage/confirm.php?key=".$key."'>this url</a> to verify your account.
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
							$error="success";
							$signup_error= 'success'.$key.' '.$email;
				
                            }
                    
                } 
                else 
                    {
						$error=TRUE;
                        $signup_error="Database error";
                    }
               
               }
                else
                    {
                        $error=TRUE;
                        $signup_error= "other";
                    }
       
            }
        }
}
        

if($error==TRUE)
        echo $signup_error;
elseif($error=='success')
	echo $signup_error;
else
    echo "true";
?>