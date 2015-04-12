<html>
<head>
</head>
<body>
<?php
/*
	Add this in all pages
	Helps redirect to this page after login (if not logged in)
*/
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?> <input type="hidden" id="fb" value="<?php
if (isset($_COOKIE['beta_type'])) {
    //echo $_COOKIE['type'];  

} ?>"
    >
<?php


// check if user_credential cookies are set
// If not, then add a referral URL to get back here after login
if (!isset($_COOKIE['beta_user_id'])) {
    $_SESSION['url'] = $_SERVER['REQUEST_URI'];
    header('location:lp_beta.php');
} else if (!isset($_SESSION['beta_loggedin'])) {
    $_SESSION['url'] = $_SERVER['REQUEST_URI'];
    header('location:/beta/php/setsession.php');
}

//echo "hi after login";
//cecho $_SESSION['user_id'];
?>
<script>
    var fb = document.getElementById("fb").value;
    window.fbAsyncInit = function () {
        FB.init({
            appId: '237922879690774',
            cookie: true,  // enable cookies to allow the server to access
            // the session
            xfbml: true,  // parse social plugins on this page
            version: 'v2.0' // use version 2.0
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
        if (fb == 1) {
            FB.getLoginStatus(function (response) {
                if (response && response.status === 'connected') {
                } else {
                    window.location.href = "/beta/php/logout.php";
                }

            });
        }

    };


    // Load the SDK asynchronously
    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
</body>
</html>