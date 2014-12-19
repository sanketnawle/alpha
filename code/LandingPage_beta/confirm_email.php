<!DOCTYPE html> 
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="confirm_email.css">
	<title>Urlinq Academic Social Network</title>
	<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	
</head>
<body>
		<div class = "main-container">
			<div class = "confirm-email-main">
				<p>Confirm your email address to access your academic network. A confirmation message was sent to <strong><?php echo $_GET[email];?></strong></p>
				<div class = "confirm-2ndrow">					<form method="post" action='<?php //echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>					<input type = 'hidden' name='email' value = '<?php echo $_GET['email']; ?>'></input>					<input type = 'hidden' name='key' value = '<?php echo $_GET['key']; ?>'></input>
					<input type = 'submit' value = "Resend confirmation" class = "resend-btn"></input>					
					<a class = "update-email" href="http://www.urlinq.com/">
						Update email address <img src = "src/right-arrow.png" id = "right-arrow">   
					</a>										<?php										if(isset($_POST['key'],$_POST['email']))					{							include_once('Mail.php');							$key = $_POST['key'];							$email = $_POST['email'];							$body="<html>								   <body>								   Thank you for signing up! Please visit <a href='https://urlinq.com/confirm.php?key=".$key."'>this url</a> to verify your account.								   </body></html>";																	$headers = array(																			'From' => 'Urlinq<no-reply@urlinq.com>',								'To' => $email,								'Content-Type' => "text/html",								'Subject' => 'Successfully signed up - verification needed'							);							$smtp = Mail::factory('smtp', array(								'host' => 'ssl://box791.bluehost.com',								'port' => '465',								'auth' => true,								'username' => 'team@urlinq.com',								'password' => 'urlinq1234'							));														$mail = $smtp->send($email, $headers, $body);					}?>					</form>
				</div>
			</div>
			<div class = "connects-banner">
				<div onclick="location.href='http://www.nyu.edu';" class = "connects-banner-univ">
					<p class = "univ-name">NYU</p>
					<img id = "univ-logo" src = "src/univ-logo.png">
				</div>
				
				<p class = "connects-banner-head">Some of your connections around</p>
			</div>
			<div class = "connect-pics">
				<div class = "big-connect">
					<img class = "big-connect-pic" src = "src/farring.png">
					<p class = "big-pic-label label1">
						<span class = "name">Anita Farrington</span>
						<span>·</span>
						<span class = "title">Poly Dean of Students</span>
					</p>
				</div>
				<div class = "big-connect2">
					<img class = "big-connect-pic" src = "src/memon.jpg">		
					<p class = "big-pic-label label2">
						<span class = "name">Nasir Memon</span>
						<span>·</span>
						<span class = "title">Computer Science Prof.</span>
					</p>								
				</div>
				<div class = "big-connect3">
					<img class = "big-connect-pic" src = "src/ross.png">		
					<p class = "big-pic-label label3">
						<span class = "name">Ross Kopelman</span>
						<span>·</span>
						<span class = "title">Masters Student</span>
					</p>									
				</div>				
			</div>
			<br>
			<div class = "main-container-footer">
				<p>And many other members of the NYU community inside</p>
			</div>
		</div>

		<div class = "top-nav">
			<div class = "top-nav-container">
				<div id = "logo-div">
					<img id = "logo-pic" src = "src/logo_new.png">
				</div>
			</div>
		</div>
		<footer class = "page-footer">
			<nav class = "footer-links">
			</nav>
			<p class = "copyright">
				<span>©</span>
				<span>2014</span>
				<span>Urlinq</span>
			</p>
		</footer>

</body>
</html>