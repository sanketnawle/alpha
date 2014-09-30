<?php
	include_once 'includefiles.php';
	$_SESSION['user_id'] = 1;
	if(isset($_SESSION['user_id']))
	{
		$user_id = $_SESSION['user_id'];
	}
	else
	{
		header("location:login.php");
	}	
?>
<!DOCTYPE html> 
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">

<link rel = "stylesheet" type = "text/css" href = "leftmenu.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
</script>
<link href='https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<script>
$( document ).ready(function() {
	var dh=$( document ).height();
	$(".groups_list").height(dh-50);

	$( window ).resize(function() {
			var dh=$( document ).height();
			$(".groups_list").height(dh-50);
	});

});
</script>
</head>

				<div id = "tray" class = "leftmenu">
					<div class = "group_search">
						<input type = "text" placeholder = "Search your courses & clubs" class = "search_groups" id = "tray_search">
						<i class = "icon_search"></i>
						<a class = "join-group">
							<i class = "add-icon"></i>
						</a>
					</div>

					<div class = "search-results">
					</div>

					<div class = "groups_list">
						<div class = "course-groups-list sub-list">
							<div class = "sub-list-header">
								<span>COURSES</span>
							</div>
							<?php
									$select_stmt = $con->prepare("SELECT c.course_name, c.course_id, c.course_pic,
																	cs.professor, cu.class_id, u.lastname
																 FROM `courses_user` cu
																 JOIN courses_semester cs
																 ON (cu.class_id = cs.class_id)
																 JOIN courses c
																 ON (cs.course_id = c.course_id
																 AND cs.dept_id = c.dept_id
																 AND cs.univ_id = c.univ_id)
																 LEFT JOIN user u
                                                                 ON (u.user_id = cs.professor)
																 WHERE cu.user_id = ?");
									$select_stmt->bind_param("i", $user_id);
									$select_stmt->execute();
									$select_stmt->bind_result($cname, $cid, $cpic, $cprof, $class_id, $lastname);
									while($select_stmt->fetch())
									{
										if($lastname == NULL)
										{
											$lastname = $cprof;
										}
										echo '<a href = "./courses.php?cid='.$class_id.'" class = "group course-group">
												<div class = "group-pic" style = "background-image:url('.$cpic.')"></div>
												<div class = "details">
												<div class = "group-name">'.$cname.'</div>
												<div class = "group-admin">
													<strong class = "admin-title">Professor</strong>
													<span class = "admin-name">'.$lastname.'</span>
												</div>
												</div>
												<div class = "badge"></div>
											  </a>';
									}
									$select_stmt->close(); 
								?>			
						</div>
						<div class = "clubs-groups-list sub-list">
							<div class = "sub-list-header">
								<span>CLUBS</span>
							</div>
							<?php
								$select_stmt = $con->prepare('SELECT g.group_id, g.group_name, g.group_pic, CONCAT( u.firstname," ", u.lastname ) AS name
																FROM groups g
																JOIN (
																SELECT gu.group_id, g1.user_id AS admin
																FROM group_users gu
																LEFT JOIN (
																SELECT group_id, user_id
																FROM group_users
																WHERE is_admin =1
																)g1 ON ( gu.group_id = g1.group_id )
																WHERE gu.user_id =?
																)ga ON ( ga.group_id = g.group_id )
																LEFT JOIN user u ON ( ga.admin = u.user_id )');
								$select_stmt->bind_param("i", $user_id);
								$select_stmt->execute();
								$select_stmt->bind_result($gid,$gname, $gpic, $admin_name);
								while($select_stmt->fetch())
								{
									echo '<a class = "group course-group href="./groups.php?gid='.$gid.'">
									<div class = "group-pic" style = "background-image:url('.$gpic.')"></div>
									<div class = "details">
										<div class = "group-name">'.$gname.'
										</div>
										<div class = "group-admin">
											<strong class = "admin-title">President</strong>
											<span class = "admin-name">'.$admin_name.'</span>
										</div>
									</div>
									</a>';
								}
								$select_stmt->close();
							?>							
						</div>
					</div>
				</div>
</body>
</html>