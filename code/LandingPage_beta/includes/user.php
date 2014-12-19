<?php

include_once('connect.php');

class Users {
	public function validateEmail($email) {
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}
	public function validateEduEmail($email)
        {
            
            if(eregi("^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.+-]+\.edu$", $email)) 
                {
                   return true;
                }
           else 
               {
                 return false;
               }
        }
	public function userAlreadyExists($email) 
        {
            
            $connect= mysql_connect("localhost","campusla_UrlinqU","PASSurlinq@word9") or die("Couldn't connect to database");
            mysql_select_db("campusla_urlinq_demo") or die("Couldn't find database");
            $query= mysql_query("SELECT * FROM student_login_1 WHERE email = '$email'");
            $numrows=  mysql_num_rows($query);
            $connect1= mysql_connect("localhost","campusla_UrlinqU","PASSurlinq@word9") or die("Couldn't connect to database");
            mysql_select_db("campusla_urlinq_demo") or die("Couldn't find database");
            $query1= mysql_query("SELECT * FROM temp_user WHERE email = '$email'");
            $numrows1=  mysql_num_rows($query1);
            if($numrows==1 or $numrows1==1)
            {
                return TRUE;
            }
            else
            {     
                return FALSE;
                
            }
    
	}
        public function profAlreadyExists($email) 
		{
            
            $connect= mysql_connect("localhost","campusla_UrlinqU","PASSurlinq@word9") or die("Couldn't connect to database");
            mysql_select_db("campusla_urlinq_demo") or die("Couldn't find databse");
            $query= mysql_query("SELECT * FROM professor_login_1 WHERE email = '$email'");
            $numrows=  mysql_num_rows($query);
            $connect1= mysql_connect("localhost","campusla_UrlinqU","PASSurlinq@word9") or die("Couldn't connect to database");
            mysql_select_db("campusla_urlinq_demo") or die("Couldn't find databse");
            $query1= mysql_query("SELECT * FROM temp_prof WHERE email = '$email'");
            $numrows1=  mysql_num_rows($query1);
            if($numrows==1 or $numrows1==1)
            {
                return TRUE;
            }
            else
            {     
                return FALSE;
                
            }
    
	    }
        
        
	
	public function addTempUser($name, $email, $password, $university, $major, $year, $key) 
	{
		$sql = "INSERT INTO temp_user (name, email, password, university, major, year, `key`) VALUES (?, ?, ?, ?, ?, ?, ?)";
		$query = $GLOBALS['pdo']->prepare($sql);
		$query->bindValue(1, $name);
        $query->bindValue(2, $email);
        $query->bindValue(3, $password);
		$query->bindValue(4, $university);
		$query->bindValue(5, $major);
        $query->bindValue(6, $year);
        $query->bindValue(7, $key);
        $added_temp_user = $query->execute();
		if ($added_temp_user)
		{
			return true;
		} else {
			echo "\nfuckPDO::errorInfo():\n";
			print_r($query->errorInfo());
			die();
		}
	}
        
        public function addTempProf($name, $email, $password, $university, $department, $key) 
		{
		$sql = "INSERT INTO temp_prof (name, email, password, university, department, `key`) VALUES (?, ?, ?, ?, ?, ?)";
		$query = $GLOBALS['pdo']->prepare($sql);
		$query->bindValue(1, $name);
        $query->bindValue(2, $email);
        $query->bindValue(3, $password);
		$query->bindValue(4, $university);
		$query->bindValue(5, $department);
        $query->bindValue(6, $key);
        $added_temp_user = $query->execute();
		if ($added_temp_user) {
			return true;
		} else {
			echo "\nfuckPDO::errorInfo():\n";
			print_r($query->errorInfo());
			die();
		}
	}
        
        public function schoolSelect($type,$university,$key)
        {
            if($type =='temp_user')
                $sql = "UPDATE temp_user SET `university` =? WHERE (`key` =?)";
            else
                $sql = "UPDATE temp_prof SET `university` =? WHERE (`key` =?)";
            $query = $GLOBALS['pdo']->prepare($sql);
            $query->bindValue(1, $university);
            $query->bindValue(2, $key);
	    $added_temp_user = $query->execute();
            if ($added_temp_user) {
			return true;
		} else {
			echo "\nPDO::errorInfo():\n";
			print_r($query->errorInfo());
			die();
		}

        }
        public function schoolEmail($type,$key)
        {
                if($type =='temp_user')
                    $sql = "SELECT * FROM temp_user WHERE `key` = ?";
                else
                    $sql = "SELECT * FROM temp_prof WHERE `key` = ?";
                $query = $GLOBALS['pdo']->prepare($sql);
		$query->bindValue(1, $key);
		$query->execute();
                $row = $query->fetch();
                if($query->rowCount() == 1)
                {
                    
                    $email=$row['email'];
                    return $email;
                }
                else {
			echo "\nPDO::errorInfo():\n";
			print_r($query->errorInfo());
			die();
		}
                

        }
        public function resetPassword($p1,$key,$type)
        {
            
            if($type=='s')
            {
                    $sql2 = "UPDATE student_login_1 SET `password` =?, resetkey =? WHERE (`resetkey` =?)";
            }
            else if($type =='p')
            {
                    $sql2 = "UPDATE professor_login_1 SET `password` =?, resetkey =? WHERE (`resetkey` =?)";
            }
            else
            {
                return false;
            }
            $query2 = $GLOBALS['pdo']->prepare($sql2);
            $query2->bindValue(1, $p1);
            $query2->bindValue(2, '');
            $query2->bindValue(3, $key);
            $added_temp_user = $query2->execute();
            if ($added_temp_user)
            {
			return true;
            } 
            else 
            {
		echo "\nPDO::errorInfo():\n";
		print_r($query2->errorInfo());
		die();
            }
            
        }
        public function resetPasswordRequest($email)
        {
                $sql = "SELECT * FROM student_login_1 WHERE `email` = ?";
                $query = $GLOBALS['pdo']->prepare($sql);
				$query->bindValue(1, $email);
				$query->execute();
                
                $sql1 = "SELECT * FROM professor_login_1 WHERE `email` = ?";
                $query1 = $GLOBALS['pdo']->prepare($sql1);
				$query1->bindValue(1, $email);
				$query1->execute();
                
                $key = md5(uniqid());
                if($query->rowCount() == 1)
                {
                    $sql2 = "UPDATE student_login_1 SET `resetkey` =? WHERE (`email` =?)";
                    $query2 = $GLOBALS['pdo']->prepare($sql2);
                    $query2->bindValue(1, $key);
                    $query2->bindValue(2, $email);
                    $added_temp_user = $query2->execute();
                    if ($added_temp_user)
                        {
							return 's'.$key;
                        } 
                    else 
                        {
			echo "\nPDO::errorInfo():\n";
			print_r($query->errorInfo());
			die();
                        }
                }
                else if($query1->rowCount() == 1)
                {
                    $sql2 = "UPDATE professor_login_1 SET `resetkey` =? WHERE (`email` =?)";
                    $query2 = $GLOBALS['pdo']->prepare($sql2);
                    $query2->bindValue(1, $key);
                    $query2->bindValue(2, $email);
                    $added_temp_user = $query2->execute();
                    if ($added_temp_user)
                        {
								return 'p'.$key;
                        } 
                    else 
                        {
			echo "\nPDO::errorInfo():\n";
			print_r($query->errorInfo());
			die();
                        }
                    
                    
                }
                else
                {
                    return false;
                }
        }
        
        public function addFbUser($s_id, $name, $email, $university, $major, $year, $profilepic)
        {       
                
                $query2 = $GLOBALS['pdo']->prepare("INSERT INTO student_login_1 (email, fblogin) VALUES (?, ?)");
				$query2->bindValue(1, $email);
                $query2->bindValue(2, $s_id);
                $added_user1 = $query2->execute();
                
				$query4 = $GLOBALS['pdo']->prepare("SELECT * FROM student_login_1 WHERE email = ?");
				$query4->bindValue(1, $email);
				$query4->execute();
						
				if ($query4->rowCount() != 1) 
				{
					//invalid key
					echo "Row count not equal to 1. It is ".$query4->rowCount();
					return false;
				}
				$result = $query4->fetch(PDO::FETCH_ASSOC);
				$s_id = $result['studid'];
				
                  
                $query3 = $GLOBALS['pdo']->prepare("INSERT INTO student_1 (studentid, name, major, year, profilepic) VALUES (?, ?, ?, ?, ?)");
				$query3->bindValue(1, $s_id);
                $query3->bindValue(2, $name);
                $query3->bindValue(3, $major);
                $query3->bindValue(4, $year);
                $query3->bindValue(5, $profilepic);
                $added_user2 = $query3->execute();
                
                if ($added_user1 && $added_user2) 
                         return true;
                    
                else {
						echo "\nPDO::errorInfo():\n";
						print_r($query2->errorInfo());
						die();
                        return FALSE;
                    }
        
        }
	
	public function registerUser($key) {
		$query = $GLOBALS['pdo']->prepare("SELECT * FROM temp_user WHERE `key` = ?");
		$query->bindValue(1, $key);
		$query->execute();
		
		if ($query->rowCount() != 1) {
			//invalid key
			//echo "Row count not equal to 1. It is ".$query->rowCount();
			return false;
		}
		$result = $query->fetch(PDO::FETCH_ASSOC);
                $name = $result['name'];
                $email = $result['email'];
				$password = $result['password'];
                $university = $result['university'];
                $major = $result['major'];
                $year = $result['year'];
                
                $query2 = $GLOBALS['pdo']->prepare("INSERT INTO student_login_1 (email, password) VALUES (?, ?)");
				$query2->bindValue(1, $email);
                $query2->bindValue(2, $password);
                $added_user1 = $query2->execute();
                
                $query4 = $GLOBALS['pdo']->prepare("SELECT * FROM student_login_1 WHERE email = ?");
				$query4->bindValue(1, $email);
				$query4->execute();
		
		if ($query4->rowCount() != 1) {
			//invalid key
			//echo "Row count not equal to 1. It is ".$query->rowCount();
			return false;
		}
		$result = $query4->fetch(PDO::FETCH_ASSOC);
        $s_id = $result['studid'];
                	
		$query3 = $GLOBALS['pdo']->prepare("INSERT INTO student_1 (studentid, name, email, major, year) VALUES (?, ?, ?, ?, ?)");
		$query3->bindValue(1, $s_id);
        $query3->bindValue(2, $name);
		$query3->bindValue(3, $email);
		$query3->bindValue(4, $major);
        $query3->bindValue(5, $year);
        $added_user2 = $query3->execute();
		if ($added_user1 && $added_user2) 
                    {
			//now delete from temp_users table
			$query4 = $GLOBALS['pdo']->prepare("DELETE FROM temp_user WHERE `key` = ?");
			$query4->bindValue(1, $key);
			$query4->execute();
                       return true;
                    } 
                else {
			//echo "\nPDO::errorInfo():\n";
			//print_r($query2->errorInfo());
			die();
		}
	}
        public function registerProf($key) {
		$query = $GLOBALS['pdo']->prepare("SELECT * FROM temp_prof WHERE `key` = ?");
		$query->bindValue(1, $key);
		$query->execute();
		
		if ($query->rowCount() != 1) {
			//invalid key
			echo "Row count not equal to 1. It is ".$query->rowCount();
			return false;
		}
		$result = $query->fetch(PDO::FETCH_ASSOC);
        $name = $result['name'];
        $email = $result['email'];
		$password = $result['password'];
        $university = $result['university'];
        $department = $result['department'];
            
        $query4 = $GLOBALS['pdo']->prepare("SELECT * FROM professor_login_1 WHERE email = ?");
		$query4->bindValue(1, $email);
		$query4->execute();
                
        if ($query4->rowCount() != 1) 
		{
			//invalid key
			echo "Row count not equal to 1. It is ".$query4->rowCount();
			return false;
		}
		$result = $query4->fetch(PDO::FETCH_ASSOC);
        $profid = $result['profid'];
                                
        $query2 = $GLOBALS['pdo']->prepare("UPDATE professor_login_1 SET password=? WHERE (profid=? AND email=?)");
		$query2->bindValue(1, $password);
        $query2->bindValue(2, $profid);
        $query2->bindValue(3, $email);
        $added_user1 = $query2->execute();
		
		$query5 = $GLOBALS['pdo']->prepare("SELECT * FROM department_1 WHERE deptname = ?");
		$query5->bindValue(1, $department);
		$query5->execute();
		if ($query5->rowCount() != 1) 
		{
			//invalid key
			echo "Row count not equal to 1. It is ".$query5->rowCount();
			return false;
		}
		$result = $query5->fetch(PDO::FETCH_ASSOC);
        $deptid = $result['deptid'];
                
                           
		$query3 = $GLOBALS['pdo']->prepare("UPDATE professor_1 SET name=?, deptid=? WHERE (profid=?)");
		$query3->bindValue(1, $name);
        $query3->bindValue(2, $deptid);
        $query3->bindValue(3, $profid);
		$added_user2 = $query3->execute();
		if ($added_user1 && $added_user2) 
                    {
                        //now delete from temp_users table
			$query5 = $GLOBALS['pdo']->prepare("DELETE FROM temp_prof WHERE `key` = ?");
			$query5->bindValue(1, $key);
			$query5->execute();
                       return true;
                    } 
                else {
			echo " \nPDO::errorInfo():\n";
			print_r($query2->errorInfo());
			die();
		}
	}
}

?>