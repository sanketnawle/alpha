<?php

// Values received via ajax
$title = $_POST['title'];
$start = $_POST['start'];
$end = $_POST['end'];
$url = $_POST['url'];

if(empty($start) or empty($end))
    $allday = 'true';
else
    $allday = 'false';


try {
$bdd = new PDO('mysql:host=localhost;dbname=fullcalendar', 'root', '');
} catch(Exception $e) {
exit('Unable to connect to database.');
}


                $sql = "INSERT INTO evenement (title, start, end, url, allday) VALUES (?, ?, ?, ?, ?)";
		$query = $bdd->prepare($sql);
		$query->bindValue(1, $title);
                $query->bindValue(2, $start);
                $query->bindValue(3, $end);
                $query->bindValue(4, $url);
                $query->bindValue(5, $allday);
		
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