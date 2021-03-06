<?php
include "../includes/common_functions.php";
include "school_other_functions.php";
function confirmmail($email,$con,$user_id,$firstname){
               $size = mcrypt_get_iv_size(MCRYPT_CAST_256, MCRYPT_MODE_CFB);
               $salt = mcrypt_create_iv($size, MCRYPT_DEV_RANDOM);
               $key1=hash('sha256',$salt);
               $to      = $email;
               $subject = 'confirm your email';
               $message = '
                <html xmlns="http://www.w3.org/1999/xhtml"><head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=320; initial-scale=.55; user-scalable=no;">
        <title>Hi'." ".$firstname.', Please Confirm your Email Address</title>
        <style type="text/css">
        body {margin: 0; padding: 0; min-width: 100%!important;}
        .content {width: 100%; max-width: 600px;padding-left: 10px;padding-right: 10px;}  

        .header{
            padding:0 20px 20px 0;
        }

        @media (max-width: 500px){
        .emailLogo{
        height: 50px!important;
        }

        .mobileGetBigP{
        font-size:25.5px!important;
        }

        .mobileGetBigA{
        font-size:30.5px!important;
        }
        }


        </style>
    </head>
    <body bgcolor="#fff">
        <table width="100%" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0">
            <tbody><tr>
                <td>
                    <table class="content" align="center" cellpadding="0" cellspacing="0" border="0" style="border-bottom:1px solid #e9e9e9;">
                        <tbody>
                            <tr>
                                <td width="600" height="70" style=" height: auto; padding: 20px 0 9px;">
                                    <img class="emailLogo" src="http://urlinq.com/beta/emailImg/grayLogo.png" height="36" style="margin-left:5px;" border="0" alt="">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="content" align="center" style="border-spacing:0; vertical-align:top; text-align:left;width:100%;padding:36px 0 0; margin:0 auto;">
                        <tbody>
                            <tr style="vertical-align:top;text-align:left;padding:0" align="center">
                                <td style="border-collapse:collapse!important;vertical-align:top;text-align:left;padding:0" align="center" valign="top">
                                    <img src="http://urlinq.com/beta/emailImg/squareLogo.png" style="border-radius:0px; display:block;margin:0 auto;border:0" alt="Navigate the Universiy." align="center" width="105" height="105">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="content" align="center" style="border-spacing:0;vertical-align:top;text-align:inherit;margin:0 auto;padding:24px 35px 10px;width:570px!important">
                        <tbody>
                            <tr style="vertical-align:top;text-align:left;padding:0;" align="center">
                                <td style="border-collapse:collapse!important;vertical-align:top;text-align:left;padding:0" align="center" valign="top">
                                    <p class="mobileGetBigP" style="color:#2a2a2a;display:block;font-family: Lucida Grande,Lucida Sans,Lucida Sans Unicode,Arial,Helvetica,Verdana,sans-serif;font-weight:normal;text-align:left;line-height:1.714em;font-size: 16.5px;margin:0 auto;padding: 0 0 10px;" align="center">
                                        Hi '.$firstname.',
                                        <br>
                                        <span style="margin-top:10px;display:block;">
                                            Welcome to Urlinq! In order to get started, you need to confirm your email address.
                                        </span>
                                    </p>
                                </td>

                            </tr>
                            <tr style="vertical-align:top;text-align:left;padding:0;" align="center">
                                <td style="border-collapse:collapse!important;vertical-align:top;text-align:left;padding:0" align="center" valign="top">
                                    <a class="mobileGetBigA" style="font-family: Lucida Grande,Lucida Sans,Lucida Sans Unicode,Arial,Helvetica,Verdana,sans-serif;border:1px solid;display:block;padding:14px 16px;text-decoration:none;border-radius: 2px;text-align:center;color:white!important;font-weight:bold;font-size:18.5px;white-space:nowrap;
                                    margin:0 auto;margin-top:.25em;cursor:pointer;background-color: rgb(0,217,160); border-bottom: 3px solid rgb(8, 184, 138);" href="http://urlinq.com/beta/afterconfirmation.php?key='.$key1.'">
                                        Confirm your Email Now
                                    </a>
                                </td>
                            </tr>
                             <tr style="vertical-align:top;text-align:left;padding:0;" align="center">
                                <td style="border-collapse:collapse!important;vertical-align:top;text-align:left;padding:0;padding-top: 16px;" align="center" valign="top">
                                    <p style="
                                        color: #2a2a2a; display: block; font-family: Lucida Grande,Lucida Sans,Lucida Sans Unicode,Arial,Helvetica,Verdana,sans-serif; font-weight: normal; text-align: left; line-height: 1.714em; font-size: 16.5px; margin: 0 auto; padding: 0 0 10px;
                                    ">If you don\'t see the button above, <a style="
                                        color: rgb(0,217,160);
                                        cursor: pointer;
                                    " href="http://urlinq.com/beta/afterconfirmation.php?key='.$key1.'">click here</a></p>
                                </td>
                            </tr>
                            <tr style="vertical-align:top;text-align:left;padding:0;" align="center">
                                <td style="border-collapse:collapse!important;vertical-align:top;text-align:left;padding:0" align="center" valign="top">
                                    <p class="mobileGetBigP" style="color:#2a2a2a;display:block;font-family: Lucida Grande,Lucida Sans,Lucida Sans Unicode,Arial,Helvetica,Verdana,sans-serif;font-weight:normal;text-align:left;line-height:1.714em;font-size: 16.5px;margin:0 auto;margin-top: .25em;padding: 0 0 10px;" align="center">
                                        Thanks,
                                        <span style="margin-top:5px;display:block;">
                                        The Urlinq Family 
                                        </span>
                                    </p>
                                </td>

                            </tr>                            
                        </tbody>
                    </table>
                    <table width="600" class="content" align="center" cellpadding="0" cellspacing="0" border="0" style="padding-top:0px;vertical-align:top;margin:0 auto; border-top:1px solid #e9e9e9">
                        <tbody>
                            <tr style="margin:0;padding:0;display: block;width: 84px;margin: 0 auto;padding-top: 12px;">
                                <td style="max-width: 30px; margin:0;padding:5px;white-space: nowrap;">
                                    <a title="Facebook" href="https://facebook.com/joinurlinq" style="margin:0;text-decoration:none;color:#999999;padding:0;">
                                        <img alt="Facebook" height="18" width="18" style="" "margin:0;padding:0;border:0;"="" src="http://urlinq.com/beta/emailImg/fb_email_icon.png">
                                    </a>
                                </td>
                                <td style="width:30px; margin:0;padding:5px;">
                                    <a title="Google Plus" href="https://plus.google.com/+urlinq" style="margin:0;text-decoration:none;color:#999999;padding:0;">
                                        <img alt="Google Plus" height="17" width="17" style="" "margin:0;padding:0;border:0;"="" src="http://urlinq.com/beta/emailImg/plus_email_icon.png">
                                    </a>
                                </td>
                                <td style="width:30px; margin:0;padding:5px;">
                                    <a title="Twitter" href="https://twitter.com/urlinq" style="margin:0;text-decoration:none;color:#999999;padding:0;">
                                        <img alt="Twitter" height="17" width="17" style="" "margin:0;padding:0;border:0;"="" src="http://urlinq.com/beta/emailImg/twitter_email_icon.png">
                                    </a>
                                </td>                                                                
                            </tr>
                            <tr style="vertical-align:top;text-align:left;padding:0;">
                                <td height="70" style="border-collapse: collapse!important; vertical-align:top; text-align:left; height: auto; padding: 0px; padding-top: 0px;">
                                    <p style="color:#999999;font-size:9px;width:340px;text-align:center;font-family:Lucida Grande,Lucida Sans,Lucida Sans Unicode,Arial,Helvetica,Verdana,sans-serif;font-weight:normal;line-height:1.714em;margin:0 auto;padding:12px 0 10px;" align="center">
                                        This email was sent to <span>'.$to.'</span>. If you would prefer not to receive future emails from Urlinq, you may <a style="font-weight:bold;cursor:pointer;">unsubscribe</a>. 

                                        <br>
                                        <br>
                                        TM and copyright © 2014 Urlinq LLC. New York City.

                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    

 </body></html>';
                $from='campus@urlinq.com'; 
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