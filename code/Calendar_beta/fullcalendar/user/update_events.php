<?php

/* Values received via ajax */
$oldid = $_POST['oldid'];
$newid = $_POST['newid'];
$title = $_POST['title'];
$description=$_POST['description'];
$start = $_POST['start'];
$end = $_POST['end'];
$s_id=1;
$result="Success";
// connection to the database
try {
 $bdd = new PDO('mysql:host=localhost;dbname=fullcalendar', 'root', '');
 } catch(Exception $e) {
exit('Unable to connect to database.');
}
 // update the records
/*$sql = "UPDATE personal_event SET title=?, start=?, end=?, id=? WHERE id=?, s_id=?";
$q = $bdd->prepare($sql);
$added_temp_user =$q->execute(array($title,$start,$end,$newid,$oldid,$s_id));
if ($added_temp_user) {
			echo 'ho gya';
		} else {
			echo "\nfuckPDO::errorInfo():\n";
			print_r($query->errorInfo());
			die();
		}*/

$sql = "UPDATE personal_event SET title=?, description=?, start=?, end=?, id=? WHERE (id=? AND s_id=?)";
		$query = $bdd->prepare($sql);
               
                $query->bindValue(1, $title);
                $query->bindValue(2, $description);
		$query->bindValue(3, $start);
                $query->bindValue(4, $end);
                $query->bindValue(5, $newid);
                $query->bindValue(6, $oldid);
                $query->bindValue(7, $s_id);
		
		$added = $query->execute();
		if ($added) 
                    {
			$result="Event updated successfully.";
                    } 
                else {
                        $result="Failure";
			echo "\nPDO::errorInfo():\n";
			print_r($query->errorInfo());
			die();
		}
                echo json_encode($result);
?>