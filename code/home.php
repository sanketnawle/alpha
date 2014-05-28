<?php

require 'facebook-php-sdk-master/src/facebook.php';

$facebook = new Facebook(array(
  'appId'  => '237922879690774',
  'secret' => 'a964dc8a3e15cf4fe5fc5f307e31d694',
  
    ));

// See if there is a user from a cookie
$user = $facebook->getUser();
$user_profile;
  
   

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
    
        
        //Retriving movies those are user like using graph api
        try{
            $email = $facebook->api("/$user/movies");
        }
        catch(Exception $o){
            print_r($o);
        }
    
  } catch (FacebookApiException $e) {
    
    $user = null;
  }
}

?>


<?php

if($user)
{
    
    echo "Name: " . $user_profile['name']."<br/>";
    echo "Email: ". $user_profile['email']."<br/>";
    echo "id: ".$user_profile['id']."<br/>";
    echo 'First Name:'.$user_profile['first_name']."<br/>";
    echo 'Last Name:'.$user_profile['last_name']."<br/>";
    echo 'User Name:'.$user_profile['username']."<br/>";
    echo 'Gender:'.$user_profile['gender']."<br/>";
    echo 'Link:'.$user_profile['link']."<br/>";
    echo 'Locale:'.$user_profile['locale']."<br/>";
    if ($user) {
    $logoutUrl = $facebook->getLogoutUrl();
} else {
    $loginUrl = $facebook->getLoginUrl();
}
 ?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title>php-sdk</title>
  </head>
  <body>
      
    <?php if ($user): ?>
    <?php echo "Welcome, ".$user_profile['first_name']. ".<br />"; ?>
     <div> <img src="https://graph.facebook.com/<?= $user_profile['id'] ?>/picture?type=large"></div>
    <a href="<?php echo $logoutUrl; ?>">
        
      <img src="images2013/fblogout.png">
    </a>
    <?php else: ?>
      <a href="<?php echo $loginUrl; ?>">
          Logout
      </a>
    <?php endif ?>
  </body>
</html>

<?php    
}
else
if (isset($_SESSION['logged_in'])) {
   

?>

<html>
	<head>
		<title>Welcome</title>
	</head>
	
	<body>
		<h1>Successfully Logged In</h1>
		<a href="logout.php">Logout</a>
	</body>
</html>

<?php 

} else {
    header("Location: login.php");

}

?>