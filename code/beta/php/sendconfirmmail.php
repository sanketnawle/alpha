<?php
function confirmmail($email,$con,$user_id){
               $size = mcrypt_get_iv_size(MCRYPT_CAST_256, MCRYPT_MODE_CFB);
               $salt = mcrypt_create_iv($size, MCRYPT_DEV_RANDOM);
               $key1=hash('sha256',$salt);
               $to      = $email;
               $subject = 'confirm your email';
               $message = "
                 <html>
                 <head>
                 <title>Test Mail</title>
                 </head>
                 <body>
                 <p><a href='http://urlinq.com/beta/afterconfirmation.php?key=$key1'>Open Link</a></p>
                 </body>
                 </html>";
                $from='admin@urlinq.com'; 
                mailto($to,$subject,$message,$from);
                 //storing key and user id in confirmation table
                 $query=mysqli_query($con,"SELECT user_id 
                                           FROM confirmation
                                           WHERE user_id='$user_id' 
                                              ");
                 if(mysqli_num_rows($query)===0){
                       
                 }else{
                        $query=mysqli_query($con,"DELETE FROM confirmation
                                                  WHERE user_id='$user_id'");

                 }
                 $query=mysqli_query($con,"INSERT INTO confirmation(user_id,key_email) values('$user_id','$key1')");
                        if(!$query){
                            echo "insertion into confirmation failed";
                        } else{
                           //echo "check your email";
                        }       
}      

?>          