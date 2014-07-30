<?php
print_r(PDO::getAvailableDrivers());
try{
$handler=new PDO('mysql:hostname=localhost;dbname=campusla_urlinq_beta','campusla','mArCh3!!1992X');
}catch(PDOException $e){
   echo $e->getMessage();

}
$query=$handler->query('SELECT * FROM user');
while($row=$query->fetch()){
     echo $row['firstname'], '<br>';

}