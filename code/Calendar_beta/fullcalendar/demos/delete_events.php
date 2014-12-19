<?php

/* Values received via ajax */
$id = $_POST['id'];


// connection to the database
try {
 $bdd = new PDO('mysql:host=localhost;dbname=fullcalendar', 'root', '');
 } catch(Exception $e) {
exit('Unable to connect to database.');
}
 // update the records
$sql = "DELETE FROM evenement WHERE id=?";

		$query = $bdd->prepare($sql);
		$query->bindValue(1, $id);
                
		
		$added_temp_user = $query->execute();
		if ($added_temp_user) {
			echo 'ho gya';
		} else {
			echo "\nfuckPDO::errorInfo():\n";
			print_r($query->errorInfo());
			die();
		}
?>