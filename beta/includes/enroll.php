<?PHP
	include_once("/beta/includes/dbconfig.php");
	
	//Test data
	$_POST['user_id'] = 5;
	$_POST['group_id'] = 2;
	
	if(isset($_POST['user_id']) && isset($_POST['group_id'])) {
		$user_id = $_POST['user_id'];
		$univ_id = $_POST['group_id'];
	} else {
		echo "Missing arguments....";
	}
	
	group_enrolled($user_id, $group_id);
	
	function group_enrolled($user_id, $group_id) {
		$sql = "SELECT * FROM group_users WHERE user_id = ? AND group_id = ?";
		$stmt = $con -> prepare($sql);
		$stmt -> bind_param('ii', $user_id, $group_id);
		if($stmt -> execute()) {
			if($stmt -> num_rows > 0) {
				echo "User enrolled.";
				return true;
			} else {
				echo "User not enrolled.";
				return false;
			}
			
		} else {
			echo "Search Error!";
			return false;
		}
	}
?>