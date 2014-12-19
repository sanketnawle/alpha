<?php

// Values received via ajax
$id = $_POST['id'];
$title = $_POST['title'];
$description=$_POST['description'];
$start = $_POST['start'];
$end = $_POST['end'];
$s_id=1;
if(empty($start) or empty($end))
    $allday = 'true';
else
    $allday = 'false';


try {
$bdd = new PDO('mysql:host=localhost;dbname=fullcalendar', 'root', '');
} catch(Exception $e) {
exit('Unable to connect to database.');
}


                $sql = "INSERT INTO personal_event (s_id, title, description, start, end, allday, id) VALUES (?, ?, ?, ?, ?, ?, ?)";
		$query = $bdd->prepare($sql);
                
                $query->bindValue(1, $s_id);
		$query->bindValue(2, $title);
                $query->bindValue(3, $description);
                $query->bindValue(4, $start);
                $query->bindValue(5, $end);
                $query->bindValue(6, $allday);
                $query->bindValue(7, $id);
		
		$added = $query->execute();
		if ($added) 
                    {
			echo 'ho gya';
                    } 
                else {
			echo "\nPDO::errorInfo():\n";
			print_r($query->errorInfo());
			die();
		}

?>