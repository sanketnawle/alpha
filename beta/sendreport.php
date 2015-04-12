<?php
if(isset($_POST['submit'])){
	$to='ktv205@nyu.edu';
	 $emailbody='Name: '.$_POST['name']. "\r\n" .
	            'email: '. $_POST['emailaddress']. "\r\n"
               .'Report: '. $_POST['Report'];
     //echo $emailbody;
     $headers  = 'MIME-Version: 1.0' . "\r\n";
                 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                 $headers .= 'From:'. $_POST['emailaddress'] . "\r\n";       

    mail($to, 'report-bug', $emailbody, $headers); 
    echo "Thank you for reporting";
}
else{


}
?>