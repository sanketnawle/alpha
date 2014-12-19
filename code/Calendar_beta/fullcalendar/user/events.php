<?php
// List of events
 $json = array();
 $s_id=1;
 $cid=1;
 $groupid=1;
 // Query that retrieves events
 

 // connection to the database
 try 
 {
 $bdd = new PDO('mysql:host=localhost;dbname=fullcalendar', 'root', '');
 } 
 catch(Exception $e) 
 {
  exit('Unable to connect to database.');
 }
 // Execute the query
 
$resultat = $bdd->query("SELECT * FROM course_event where cid=1 ORDER BY eventid ") or die(print_r($bdd->errorInfo()));
 $array=$resultat->fetchAll(PDO::FETCH_ASSOC);
 
 $resultat = $bdd->query("SELECT * FROM group_event where groupid='$groupid' ORDER BY eventid ") or die(print_r($bdd->errorInfo()));
 $array1=$resultat->fetchAll(PDO::FETCH_ASSOC);

 $resultat = $bdd->query("SELECT * FROM personal_event where s_id='$s_id' ORDER BY eventid ") or die(print_r($bdd->errorInfo()));
 $array2=$resultat->fetchAll(PDO::FETCH_ASSOC);
 //print_r($array);
 // sending the encoded result to success page
 echo json_encode(array_merge($array,$array1,$array2));

?>