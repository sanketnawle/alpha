<html xmlns="http://www.w3.org/1999/html">
<head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
        </script>
</head>
<script>
$( document ).ready(function() {
	$(document).delegate(".se","click",function(){
		var email_id= $("#eid_txt").val();
		var message= $("#etxt_txt").val();
		$eref=$("#eid_txt");
		$tref=$("#etxt_txt");
           $.ajax({
                        type: "POST",
                        url: "test_email.php",
                        data: {email_id: email_id, message: message},
                        success: function(html){ 
                                $eref.val("");
                                $tref.val("");
                    },
                    	error: function(html){ 
                    		alert(html);
                    	}
            });
	});
});
</script>

<input type='text' id="eid_txt" placeholder="Enter email_id"/>
<input type='text' id="etxt_txt" placeholder="Enter email text"/>
<button class="se">Send Mail</button>
</html>




<?php
/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 8/6/14
 * Time: 5:21 PM
 */


include 'includes/common_functions.php';

if (isset($_POST['email_id'])) {
    $email_id = $_POST['email_id'];
    if (isset($_POST['message'])) {
        $message = $_POST['message'];
        mailto($email_id, "Testing email", $message, "");
    }
}
?>