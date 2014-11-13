<?php
/*
include_once("dbconnection.php");
include_once("../includes/common_functions.php");
include_once("../includes/paginator.php");
include_once("../includes/follow.php");
include_once("../includes/feedchecks.php");
include_once("../includes/time.php");
require('../php/redirect.php');
*/

Yii:app()->session['user_id'] = 'user_id';
echo Yii::app()->session['user_id']; //prints 'user_id'


/* get all connected ids*/
$to_ids = get_connected_users($_SESSION['user_id']);
/*----------------------*/
$university_id = 0;
$first_deptid = 0;
$course_rows = 0;
$student_rows = 0;
$professor_rows = 0;
$all_rows = 0;
$group_rows = 0;
$current_semester = "";
$current_year = date("Y");
/* Another new requirement came up. Apparently, there is no end to this folly
Now everybody under NYU should be able to search for other schools clubs too.
I cannot really say if they'll wake up tomorrow and say they should be able to
search for classes in other schools too!! */
//Variable to store school_ids of all schools under parent university.
$parent_univ_list = "";

$course_sql_stmt = $con->stmt_init();
$group_sql_stmt = $con->stmt_init();
$user_sql_stmt = $con->stmt_init();
$search_course_cond = "";
$search_user_cond = "";
$search_group_cond = "";
$sel_deptid = 1;
$course_filter = "";
$filter = "";
$maxCredits = "";
$minCredits = "";
$deptCond = "";


if (isset($_POST['filter']) && $_POST['filter'] != '') {
    if (array_key_exists('minCredits', $_POST['filter'])) {
        $minCredits = $_POST['filter']['minCredits'];
        $maxCredits = $_POST['filter']['maxCredits'];
        $course_filter .= "and gtable.course_credits between ? and ?";
    }
    if (array_key_exists('dept_id', $_POST['filter'])) {
        $deptCond = $_POST['filter']['dept_id'];
        $filter .= "and gtable.dept_id = ?";
    }
}

if (isset($_POST['univid']) && $_POST['univid'] != '') {
    $university_id = $_POST['univid'];
    $par_univ_stmt = $con->prepare("SELECT univ_id FROM university WHERE parent_univ_id = (
	SELECT parent_univ_id FROM university WHERE univ_id = ?)");
    if($par_univ_stmt){
        $par_univ_stmt->bind_param("i",$university_id);
        $par_univ_stmt->execute();
        $par_univ_stmt->bind_result($par_id);
        while($par_univ_stmt->fetch()){
            $par_ids[]=$par_id;
        }
        $parent_univ_list = join(",",$par_ids);
        $parent_univ_list = "(".$parent_univ_list.")";
    }
}

if(isset($_POST['search_type'])){
    $search_type = $_POST['search_type'];
}
else
    $search_type = "All";
/*Get the current semester*/
$result = $con->query("SELECT semester from univ_semester where univ_id = $university_id and start_date <= (SELECT curdate()) and end_date >= (SELECT curdate()) ");
if ($result->num_rows > 0)
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $current_semester = $row['semester'];
    }
else {
    if ($result = $con->query("SELECT semester from univ_semester where univ_id = $university_id and start_date >= (SELECT curdate()) order by start_date")) {
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $current_semester = $row['semester'];
            break;
        }
    }
}
/////////Get all departments for university here /////////////////////////////
$deptsql = "SELECT * FROM `department` where `univ_id`='" . $university_id . "';";

if ($deptListRes = $con->query($deptsql)) {
    $deptRow = $deptListRes->fetch_array(MYSQLI_ASSOC);
    $first_deptid = $deptRow['dept_id'];
}

if (isset($_GET['deptid']) && $_GET['deptid'] != '')
{
    $sel_deptid = $_GET['deptid'];
}
else
{
    $sel_deptid = $_SESSION['dept_id'];
}

if (isset($_POST['search_string']) && $_POST['search_string'] != '') {
    $search_course_cond = "";
    $casedSearchString = str_ireplace("professor", "", $_POST['search_string']);
    $casedSearchString = str_ireplace("all", "", $_POST['search_string']);
    $casedSearchString = str_ireplace("+", "%", $casedSearchString);
    $casedSearchString = strtoupper($casedSearchString);
    /* Do not under any circumstance uncomment the ifs. It is a convoluted problem*/
    //if($search_type =="All" || $search_type =="Courses")
    $search_course_cond = "%" . $casedSearchString . "%";
    //if($search_type =="All" || $search_type =="Student" || $search_type =="Professor")
    $search_user_cond = "%" . $casedSearchString . "%";
    //if($search_type =="All" || $search_type =="Clubs")
    $search_group_cond = "%" . $casedSearchString . "%";
    //if($search_type =="All" || $search_type =="Posts")
    $search_post_cond = "%" . $casedSearchString . "%";
}
else
{
    exit("No Search String");
}
/*get everything with courses*/
$course_sql = "";
$course_keys = "";
$course_depts = array();
$user_id = array();
$class_ids = array();
$priority_array = array();
$course_array = array();
$prof_course_array = array();

/*get classes with course name and course id matching the search term*/
if (isset($search_course_cond) && $search_course_cond != "") {
    $course_sql = "SELECT gtable.course_id, gtable.dept_id, gtable.course_name,gtable.course_desc, gtable.course_credits,
							  cs.class_id, cs.section_id, cs.location, cs.professor
						FROM courses AS gtable
						JOIN courses_semester AS cs
						ON (gtable.univ_id = cs.univ_id
						AND gtable.dept_id = cs.dept_id
						AND gtable.course_id = cs.course_id)
						WHERE gtable.univ_id = ?
						AND ( upper(gtable.course_name) LIKE ?
						OR upper(gtable.course_id) LIKE ?)
						AND cs.year = ".$current_year." AND cs.semester = '".$current_semester ."'" . $course_filter .
        $filter;
    $course_sql_stmt = $con->prepare($course_sql);

    if ($course_filter == "" && $filter == "") {
        $course_sql_stmt->bind_param("iss", $university_id, $search_course_cond, $search_course_cond);
    } elseif ($course_filter != "" && $filter == "") {
        $course_sql_stmt->bind_param("issii", $university_id, $search_course_cond, $search_course_cond, $minCredits, $maxCredits);
    } elseif ($course_filter == "" && $filter != "") {
        $course_sql_stmt->bind_param("issi", $university_id, $search_course_cond, $search_course_cond, $deptCond);
    } else {
        $course_sql_stmt->bind_param("issii", $university_id, $search_course_cond, $search_course_cond, $minCredits, $maxCredits, $deptCond);
    }
    $course_sql_stmt->execute();
    $course_sql_stmt->bind_result($cid, $cdept_id, $cname, $cdesc, $ccredits, $cclass_id, $csection_id, $cloc, $cprof_id);
    while ($course_sql_stmt->fetch()) {
        $course_array[] = array(
            'name' => $cname,
            'dept_id' => $cdept_id,
            'id' => $cid,
            'desc' => $cdesc,
            'credits' => $ccredits,
            'class' => $cclass_id,
            'section' => $csection_id,
            'location' => $cloc,
            'prof' => $cprof_id,
        );
        if (is_numeric($cprof_id)) {
            $user_id[] = $cprof_id;
        }
        $course_depts[] = $cdept_id;
        $class_ids[] = $cclass_id;
        $priority_array[$cclass_id] = array(0 => 0, 1 => 0);
    }
    /* courses with search term in description*/
    $course_sql = "SELECT gtable.course_id, gtable.dept_id, gtable.course_name,gtable.course_desc, gtable.course_credits,
						  cs.class_id, cs.section_id, cs.location, cs.professor
					FROM courses AS gtable
					JOIN courses_semester AS cs
					ON (gtable.univ_id = cs.univ_id
					AND gtable.dept_id = cs.dept_id
					AND gtable.course_id = cs.course_id)
					WHERE gtable.univ_id = ?
					AND upper(gtable.course_desc) LIKE ?
					AND cs.year = $current_year
					AND cs.semester = '$current_semester'" . $course_filter . $filter;
    $course_sql_stmt = $con->prepare($course_sql);

    if ($course_filter == "" && $filter == "") {
        $course_sql_stmt->bind_param("is", $university_id, $search_course_cond);
    } elseif ($course_filter != "" && $filter == "") {
        $course_sql_stmt->bind_param("isii", $university_id, $search_course_cond, $minCredits, $maxCredits);
    } elseif ($course_filter == "" && $filter != "") {
        $course_sql_stmt->bind_param("isi", $university_id, $search_course_cond, $deptCond);
    } else {
        $course_sql_stmt->bind_param("isii", $university_id, $search_course_cond, $minCredits, $maxCredits, $deptCond);
    }

    $course_sql_stmt->execute();
    $course_sql_stmt->bind_result($cid, $cdept_id, $cname, $cdesc, $ccredits, $cclass_id, $csection_id, $cloc, $cprof_id);
    while ($course_sql_stmt->fetch()) {
        if (count($course_array)==0 || !(in_array($cclass_id, array_column($course_array,"class"))))
            $course_array[] = array(
                'name' => $cname,
                'dept_id' => $cdept_id,
                'id' => $cid,
                'desc' => $cdesc,
                'credits' => $ccredits,
                'class' => $cclass_id,
                'section' => $csection_id,
                'location' => $cloc,
                'prof' => $cprof_id,
            );
        if (is_numeric($cprof_id)) {
            $user_id[] = $cprof_id;
        }
        $course_depts[] = $cdept_id;
        $class_ids[] = $cclass_id;
        if(!isset($priority_array[$cclass_id]))
            $priority_array[$cclass_id] = array(0 => 0, 1 => 0);
    }
    /*
     * Learn your lesson from this. Always ask people to write down requirements.
     * Because people are assholes and they just want stuff without giving you anything.
     * Here write queries to show courses that a professor is taking. If the search query
     * is like firstname or lastname of a professor. And since course_array is already being used
     * I use prof_course_array. Also note, that this will be for courses the professor is teaching
     * current semester.
     */
    $course_sql = "SELECT gtable.course_id, gtable.dept_id, gtable.course_name,gtable.course_desc, gtable.course_credits,
						  cs.professor
					FROM courses AS gtable
					JOIN courses_semester AS cs
					ON (gtable.univ_id = cs.univ_id
					AND gtable.dept_id = cs.dept_id
					AND gtable.course_id = cs.course_id)
					WHERE gtable.univ_id = ?
					AND cs.professor IN (SELECT user_id from user
					where UPPER(firstname) LIKE ?
					OR UPPER(lastname) LIKE ?)
					AND cs.year = $current_year
					AND cs.semester = '$current_semester'" . $course_filter . $filter;
    $course_sql_stmt = $con->prepare($course_sql);

    if ($course_filter == "" && $filter == "") {
        $course_sql_stmt->bind_param("iss", $university_id, $search_course_cond,$search_course_cond);
    } elseif ($course_filter != "" && $filter == "") {
        $course_sql_stmt->bind_param("issii", $university_id, $search_course_cond,$search_course_cond, $minCredits,
            $maxCredits);
    } elseif ($course_filter == "" && $filter != "") {
        $course_sql_stmt->bind_param("issi", $university_id, $search_course_cond, $search_course_cond, $deptCond);
    } else {
        $course_sql_stmt->bind_param("issii", $university_id,$search_course_cond, $search_course_cond, $minCredits,
            $maxCredits, $deptCond);
    }

    $course_sql_stmt->execute();
    $course_sql_stmt->bind_result($cid, $cdept_id, $cname, $cdesc, $ccredits, $cprof_id);
    while ($course_sql_stmt->fetch()) {
        if(count($course_array)==0 || !in_array($cid,array_column($course_array,"id")))
        {
            $prof_course_array[] = array(
                'name' => $cname,
                'dept_id' => $cdept_id,
                'id' => $cid,
                'desc' => $cdesc,
                'credits' => $ccredits,
                'prof' => $cprof_id,
            );
            if (is_numeric($cprof_id)) {
                $user_id[] = $cprof_id;
            }
            $course_depts[] = $cdept_id;
        }
    }

}
/*---------------------------------------------------------------------------------------*/
// Prioritize Classes
/*---------------------------------------------------------------------------------------*/
$class_ids = array_unique($class_ids);
$course_rows =  count($class_ids);
if ($course_rows > 0) {
    $lq_class_id = $class_ids;
    //Get count of your connections who have taken the following course
    $members_sql = "SELECT count(tab.user_id), tab.class_id
							FROM (SELECT user_id, class_id from courses_user cu JOIN connect c
							ON (c.to_user_id = cu.user_id)
							WHERE c.from_user_id = ?) tab
							GROUP BY tab.class_id
							HAVING tab.class_id IN (" . implode(",", array_fill(0, count($lq_class_id), "?")) . ")";
    $memebers_sql_stmt = $con->prepare($members_sql);
    $bs = implode("", array_fill(0, count($lq_class_id), "s"));
    $bs = "i" . $bs;
    array_unshift($lq_class_id, $_SESSION['user_id']);
    array_unshift($lq_class_id, $bs);
    call_user_func_array(array($memebers_sql_stmt, 'bind_param'), refValues($lq_class_id));
    $memebers_sql_stmt->execute();
    $memebers_sql_stmt->bind_result($linq_no, $cid);
    while ($memebers_sql_stmt->fetch()) {
        $priority_array[$cid][0] = $linq_no;
    }
    $memebers_sql_stmt->close();

    //Get count of people who have taken the following course
    $members_sql = "SELECT count(user_id), class_id
							FROM courses_user
							GROUP BY class_id
							HAVING class_id IN (" . implode(",", array_fill(0, count($class_ids), "?")) . ")";
    $memebers_sql_stmt = $con->prepare($members_sql);
    array_unshift($class_ids, implode("", array_fill(0, count($class_ids), "s")));
    call_user_func_array(array($memebers_sql_stmt, 'bind_param'), refValues($class_ids));
    $memebers_sql_stmt->execute();
    $memebers_sql_stmt->bind_result($linq_no, $cid);
    while ($memebers_sql_stmt->fetch()) {
        $priority_array[$cid][1] = $linq_no;
    }
    $memebers_sql_stmt->close();

    $pq_course_array = new SplPriorityQueue();
    foreach ($course_array as $v) {
        $pq_course_array->insert($v, $priority_array[$v['class']]);
    }

    $course_array = array();
    while ($pq_course_array->valid()) {
        $course_array[] = $pq_course_array->current();
        $pq_course_array->next();
    }
}
/*---------------------------------------------------------------------------------------*/
if (count($user_id) > 0) {
    $params = array_fill(0, count($user_id), '?');
    $prof_sql = "SELECT u.user_id, u.user_email, u.firstname, u.lastname, u.dept_id, u.user_type,
						   p.designation, p.office_location,
							univ.univ_name
							FROM user AS u
							LEFT JOIN prof_attribs AS p
							ON (u.user_id = p.prof_id)
							JOIN university univ
							ON (u.univ_id = univ.univ_id)
							WHERE u.user_id IN (" . implode(",", $params) . ")";
    $prof_sql_stmt = $con->prepare($prof_sql);
    array_unshift($user_id, implode('', array_fill(0, count($user_id), 'i')));
    call_user_func_array(array($prof_sql_stmt, 'bind_param'), refValues($user_id));
    $prof_sql_stmt->execute();
    $prof_sql_stmt->store_result();
    $prof_sql_stmt->bind_result($prof_id, $prof_email, $prof_fname, $prof_lname,
        $prof_dept_id, $prof_type, $prof_desig, $prof_loc, $uname);
    $prof_array_count = 0;
    while ($prof_sql_stmt->fetch()) {
        $prof_array[] = array(
            'id' => $prof_id,
            'email' => $prof_email,
            'type' => $prof_type,
            'name' => $prof_fname . " " . $prof_lname,
            'dept_id' => $prof_dept_id,
            'picture' => get_user_dp($con, $prof_id),
            'desig' => $prof_desig,
            'location' => $prof_loc,
            'uname' => $uname
        );
        $prof_array_count += 1;
        $course_depts[] = $prof_dept_id;
    }
    $prof_sql_stmt->free_result();
    $prof_sql_stmt->close();
}
/*----------------------------------------- end of courses --------------------------------------------*/

/*-----------------------------------------start of users----------------------------------------------*/
$user_sql = "";
$depts = array();
if (isset($search_user_cond) && $search_user_cond != "") {
    $user_sql = "SELECT gtable.user_id,
						gtable.user_email,
						gtable.user_type,
						gtable.firstname,
						gtable.lastname,
						gtable.dept_id,
						gtable.user_bio,
						un.univ_name,
						un.univ_id
				   FROM user gtable
				   JOIN university un
					 ON (gtable.univ_id = un.univ_id)
					and (upper(gtable.firstname) LIKE ?
					 or upper(gtable.lastname) LIKE ?)" . $filter;

    $user_sql_stmt = $con->prepare($user_sql);
    if ($filter == "") {
        $user_sql_stmt->bind_param("ss", $search_user_cond, $search_user_cond);
    } else {
        $user_sql_stmt->bind_param("ssi", $search_user_cond, $search_user_cond, $deptCond);
    }
    $user_sql_stmt->execute();
    $user_sql_stmt->store_result();
    $user_sql_stmt->bind_result($uid, $uemail, $utype, $ufname, $ulname, $udept_id, $ubio, $uuniv_name, $univ_id);
    while ($user_sql_stmt->fetch()) {
        $user_array[] = array(
            'id' => $uid,
            'email' => $uemail,
            'type' => $utype,
            'bio' => $ubio,
            'name' => $ufname . " " . $ulname,
            'picture' => get_user_dp($con, $uid),
            'dept_id' => $udept_id,
            'uname' => $uuniv_name,
            'uid' => $univ_id
        );
        $course_depts[] = $udept_id;
    }
    $user_sql_stmt->free_result();
    $user_sql_stmt->close();
}
/*------------------------------------------------ end of users------------------------------------------*/
$group_sql = "";
if (isset($search_group_cond) && $search_group_cond != "") {
    $group_sql = "SELECT gtable.group_id,
						   gtable.group_name,
						   gtable.group_desc,
						   gtable.contact_email,
						   gtable.website,
						   gtable.founded_on
					  FROM groups gtable
					 where ( gtable.univ_id = ?
					    or gtable.univ_id IS NULL )
					   and UPPER(gtable.group_name) LIKE ?" . $filter;
    //echo $group_sql;
    $group_sql_stmt = $con->prepare($group_sql);
    if ($filter == "") {
        $group_sql_stmt->bind_param("is", $university_id, $search_group_cond);
    } else {
        $group_sql_stmt->bind_param("isi", $university_id, $search_group_cond, $deptCond);
    }
    $group_sql_stmt->execute();
    $group_sql_stmt->store_result();
    $group_sql_stmt->bind_result($gid, $gname, $gdesc, $gemail, $gwebsite, $gfounded_on);
    while ($group_sql_stmt->fetch()) {
        $group_array[] = array('id' => $gid,
            'name' => $gname,
            'desc' => $gdesc,
            'email' => $gemail,
            'website' => $gwebsite,
            'picture' => get_dp($con,$gid,'club'),
            'gfounded' => $gfounded_on
        );
        $group_rows += 1;
    }
    $group_sql_stmt->free_result();
    $group_sql_stmt->close();
}
/*------------------end of groups-----------------------------------------------------------------*/
/*$post_sql = "";
$post_user_ids = array();
$post_filter = "";
if (isset($prof_array) && is_array($prof_array) && count($prof_array) > 0) {
    $post_user_ids = array_column($prof_array, "id");
}
if (isset($user_array) && is_array($user_array) && count($user_array) > 0) {
    $post_user_ids = array_merge($post_user_ids, array_column($user_array, "id"));
}
if (isset($post_user_ids) && is_array($post_user_ids) && count($post_user_ids) > 0) {
    $post_user_ids = array_unique($post_user_ids);
    $post_filter = "or gtable.user_id IN (" . implode(",", $post_user_ids) . ")";
}

$post_sql = "SELECT gtable.post_id,
					  gtable.user_id,
					  gtable.target_univ_id,
					  gtable.post_type,
					  gtable.text_msg,
					  gtable.sub_text,
					  gtable.file_id,
					  gtable.privacy,
					  gtable.anon,
					  gtable.like_count,
					  gtable.update_timestamp
				 FROM posts gtable
				where gtable.text_msg LIKE ?
				   or gtable.sub_text LIKE ? " . $post_filter . $filter;

$post_sql_stmt = $con->prepare($post_sql);
if ($filter == "") {
    $post_sql_stmt->bind_param("ss", $search_post_cond, $search_post_cond);
} else {
    $post_sql_stmt->bind_param("ssi", $search_post_cond, $search_post_cond, $deptCond);
}
$post_sql_stmt->execute();
$post_sql_stmt->bind_result($post_id, $user_id, $target_univ_id, $post_type, $text_msg,
    $sub_text, $file_id, $privacy, $anon, $like_count, $update_timestamp);
$post_rows = 0;
while ($post_sql_stmt->fetch()) {
    $post_array[] = array(
        'post_id' => $post_id,
        'user_id' => $user_id,
        'target_univ_id' => $target_univ_id,
        'post_type' => $post_type,
        'text_msg' => $text_msg,
        'sub_text' => $sub_text,
        'file_id' => $file_id,
        'privacy' => $privacy,
        'anon' => $anon,
        'like_count' => $like_count,
        'update_timestamp' => $update_timestamp
    );
}
$post_sql_stmt->close();
foreach ($post_array as $k => $row) {
    if (in_array($privacy, getScope($_SESSION['user_id'], $row['user_id']))) {
        $post_rows += 1;
    } else {
        unset($post_array[$k]);
    }
}*/

/*----------------------------Prioritize Posts--------------------------------------------*/
/*$pq_posts_array = new SplPriorityQueue();
$prior_count = $post_rows;
foreach ($post_array as $row) {
    if (isFollowing($_SESSION['user_id'], $row['user_id'])) {
        $priority = array(1, $prior_count);
        $pq_posts_array->insert($row, $priority);
    } else {
        $priority = array(0, $prior_count);
        $pq_posts_array->insert($row, $priority);
    }
}
$post_array = array();
while ($pq_posts_array->valid()) {
    $post_array[] = $pq_posts_array->current();
    $pq_posts_array->next();
}*/
/*--------------------------------------------------------------------------------------*/
/* 									format output										*/
/*----------------------------Filter results based on search type-----------------------*/
if ($_POST['search_type'] != "All") {
    if ($_POST['search_type'] != "Courses") {
        $course_rows = 0;
        $course_array = array();
        $prof_course_array = array();
    }
    if ($_POST['search_type'] != "Professor") {
        $professor_rows = 0;
        $prof_array=array();

        if(isset($user_array))
        {
            foreach ($user_array as $key => $row) {
                if ($row['type'] == 'p')
                    unset($user_array[$key]);
            }
        }
    }
    if ($_POST['search_type'] != "Student" && isset($user_array)) {
        $student_rows = 0;
        foreach ($user_array as $key => $row) {
            if ($row['type'] == 's')
                unset($user_array[$key]);
        }
    }
    if ($_POST['search_type'] != "Clubs" && isset($group_array)) {
        $group_rows = 0;
        $group_array = array();
    }
    if ($_POST['search_type'] != "Posts" && isset($post_array)) {
        $post_rows = 0;
        $post_array = array();
    }
}
//Add courses in prof_course_array to course rows and course array
if(isset($prof_course_array) && is_array($prof_course_array))
{
    $course_rows += count($prof_course_array);
}
if ((!isset($post_array) || count($post_array) == 0)
    && (!isset($user_array) || count($user_array) == 0)
    && (!isset($prof_array) || count($prof_array) == 0)
    && (!isset($course_array) || count($course_array) == 0)
    && (!isset($prof_course_array) || count($prof_course_array) == 0)
    && (!isset($group_array) || count($group_array) == 0)
)
    exit("No Results for this query..");
/*---------------------------------------------------------------------------------------*/
/* Get the department name */
if (count($course_depts) > 0) {
    $course_depts = array_unique($course_depts);
    $course_depts = implode(",", $course_depts);
    $result = $con->query("Select dept_id, dept_name from department where dept_id in ($course_depts)");
    //	echo "Select dept_id, dept_name from department where dept_id in ($course_depts)";
    if ($result->num_rows > 0) {
        $course_depts = array();
        while ($row = $result->fetch_array()) {
            $course_depts[$row['dept_id']] = $row['dept_name'];
        }
    }
}
/*----------------make a new array with all users and groups as they have the same view--------*/
$all_user_array = array();
if (isset($prof_array))
    $all_user_array = array_merge($all_user_array, $prof_array);
if (isset($user_array)){
//    $all_user_array = array_merge($all_user_array, $user_array);
    foreach($user_array as $row)
    {
        if(!in_array($row['id'],array_column($all_user_array,"id")))
        {
            $all_user_array[]=$row;
        }
    }
}
if (isset($group_array))
    $all_user_array = array_merge($all_user_array, $group_array);

foreach ($all_user_array as $row) {
    if ($row['type'] == 'p') {
        $professor_rows += 1;
    } elseif ($row['type'] == 's') {
        $student_rows += 1;
    }
}
/*---------------------------------- Horizontal Scroll ----------------------------------------*/

$lastslide_pos = 0;
$photo_index = 0;
$photo_position = 0;
$connected_id = get_connected_users($_SESSION['user_id']);
if ($_POST['page'] == 1 && $_POST['search_type'] == "All"
    && (($course_rows > 0 || $post_rows > 0)
        && ($professor_rows > 0 || $student_rows > 0 || $group_rows > 0))
) {
    echo '<div class = "all_results_active"><div class = "horiz-area">
						<div class = "horiz-wrapper">
				<div class = "horiz-mask">
					<div class = "content-area">
					<div class = "ContentSlider">';
    foreach ($all_user_array as $row) {
        if($row['type'] == 's' || $row['type'] == 'p')
            $link = "profile.php?user_id=".$row['id'];
        else
            $link = "clubs.php?group_id=".$row['id'];
        $photo_position = 220 * $photo_index;
        $lastslide_pos = $photo_position - 220;
        $photo_index += 1;
        echo '<div class = "slide" style = "transform: matrix(1,0,0,1,' . $photo_position . ',0); -webkit-transform: matrix(1,0,0,1,' . $photo_position . ',0)">
				<div class = "slide-inner">
				<div class = "result-photo">
				<img src = "' . $row['picture'] . '">
				<h3><a href = "'.$link.'">' . $row['name'] . '</a></h3>
				<p>' . $course_depts[$row['dept_id']] . '</p>
				</div>
				<div class = "person-bottom-functions">';
        if ($row['id'] != $_SESSION['user_id']) {
            echo '<div class = "link-button">';
            if (in_array($row['id'], $to_ids)) {
                echo '<a class = "pre-linked linked" data-value = "' . $row['id'] . '">Following</a>';
            } else {
                echo '<a class = "link link-up" data-value = "' . $row['id'] . '">Follow</a>';
            }
            echo '</div>';
        }
        echo '</div>
					</div>
					</div>';
    }
    echo '</div>
			</div>
		</div>
		<div class = "arrow-disabled arrow-container arrow-prev">
			<a class = "ar-disabled ar-left"></a></div><div class = "arrow-container arrow-next">
			<a id = "ar-right" class = "ar-right"></a></div></div></div>';
}
$members_sql = "SELECT u.user_id
					FROM user AS u JOIN courses_user AS cu
					ON (u.user_id = cu.user_id)
					WHERE cu.class_id = ?";
$memebers_sql_stmt = $con->prepare($members_sql);

/*------------------------PAGINATE---------------------------------------------------*/
//$total = $course_rows + $post_rows + $professor_rows + $student_rows + $group_rows;
$total = $course_rows + $professor_rows + $student_rows + $group_rows;
$page = new Paginator(20, $total);
if (!$page->paginate($_POST['page']))
    exit();
$offset = $page->getOffset();
$isPageFull = false;
$limit = $page->getLimit();
if ($offset < $course_rows) {
    if($offset < count($course_array))
    {
        $course_array = array_slice($course_array, $offset, $limit);
        $offset = $offset + count($course_array);
        $limit -= count($course_array);
        if ($limit == 0) {
            $isPageFull = true;
            $post_array = array();
            $all_user_array = array();
        }
    }
    else
    {
        $course_array = array();
        $prof_course_array = array_slice($prof_course_array, $offset, $limit);
        $offset = $offset + count($prof_course_array);
        $limit -= count($prof_course_array);
        if ($limit == 0) {
            $isPageFull = true;
            $post_array = array();
            $all_user_array = array();
        }
    }
} else {
    $course_array = array();
}

/*if (!$isPageFull && $offset < ($course_rows + $post_rows)) {
    $post_array = array_slice($post_array, ($offset - $course_rows), $limit);
    $offset = $offset + count($post_array);
    $limit -= count($post_array);
    if ($limit == 0) {
        $isPageFull = true;
        $all_user_array = array();
    }
} else {
    $post_array = array();
}*/
//since somebody decided at the last moment that we "mute" posts(f&*$%!!!).
$post_rows = 0;
if (!$isPageFull
    && $offset <
    ($course_rows + $post_rows + $professor_rows + $student_rows + $group_rows))
{
    $all_user_array = array_slice($all_user_array, ($offset - ($course_rows + $post_rows)), $limit);
    $offset = $offset + count($all_user_array);
    $limit -= count($all_user_array);
    if ($limit == 0) {
        $isPageFull = true;
    }
} else {
    $all_user_array = array();
}
/*------------------------------VERTICAL-AREA----------------------------------------*/
echo '<div class = "vert-area">';
for ($i = 0; $i < count($course_array); $i++) {
    echo '
	<div class = "course vert-results-wrapper">
	<div class = "results-top-sec">
	<div class = "result-header">
	<div class = "title-limit" style="background-image:url(' . get_dp($con, $course_array[$i]['class'], 'class') . ')"></div>
	<a href="class.php?class_id=' . $course_array[$i]["class"] . '"><h2>' . boldKeyWord($course_array[$i]['name']) . '</h2></a>
	<p>' . boldKeyWord($course_array[$i]['section']) . '</p>
	<p>' . $course_array[$i]['credits'] . '</p>
	</div>
	<div class = "result-header-right">
	<div class = "result-functions-wrapper">
	<div class = "tooltip">
	<div class = "tool-wedge"></div>
	<div class = "tool-box">
	<span>Add This Course To My Bookmarks</span>
	</div>
	</div>
	</div>
	</div>
	</div>
	<div class = "results-main-sec">
	<p class = "description">' . boldKeyWord($course_array[$i]['desc']) . '</p>
	<div class = "lower-info-keys">
	<div class = "info-key instructor">
	Instructor
	</div>
	<div class = "info-key subject">
	Department
	</div>
	<div class = "info-key members">
	Members
	</div>
	</div>
	<div class = "lower-info">
	<div class = "info-piece instructor">';

    if (is_numeric($course_array[$i]['prof'])) {
        foreach ($prof_array as $row) {
            if (in_array($course_array[$i]['prof'], $row)) {
                echo '<a href= "profile.php?user_id=' . $row['id'] . '">' . boldKeyWord($row['name']) . '</a>';
            }
        }
    } else {
        echo "TBA";
    }
    echo '</div>
		<div class = "info-piece subject"><a href="department.php?dept_id=' . $course_array[$i]['dept_id'] . '">'.
        boldKeyWord($course_depts[$course_array[$i]['dept_id']]) . "</a></div>
			<div class = \"info-piece members\">
			<div class = \"member-pics-wrapper\">";
    $memebers_sql_stmt->bind_param("s", $course_array[$i]['class']);
    $memebers_sql_stmt->execute();
    $memebers_sql_stmt->store_result();
    $memebers_sql_stmt->bind_result($mem_uid);
    $count = 0;
    $hasJoined = false;
    while ($memebers_sql_stmt->fetch()) {
        if ($mem_uid == $_SESSION['user_id']) {
            $hasJoined = true;
            //continue;
        }
        if ($count < 5)
        {
            echo '<a href = "./profile?user_id=' . $mem_uid . '"class = "innerPic">
				<div class = "smallPic">
				<img class = "img" src = "' . get_user_dp($con, $mem_uid) . '" width = "29" height = "29">
				</div>
				</a>';
        }
        $count += 1;
    }
    $memebers_sql_stmt->free_result();
    $memebers_sql_stmt->reset();
    if ($count > 5) {
        echo '<a class = "rosterLink">
			<div class = "doubleBox">'.
            ($count - 5)
            .'</div>
			</a>';
    } elseif ($count == 0) {
        echo '<div> Be the first to join </div>';
    }
    echo '</div>
	</div>
	</div>

	<div class = "result-bottom">
	<div class = "course-schedule">

	</div>
	<div class = "course-bottom-functions">';
    if (!$hasJoined) {
        echo '<div class = "join-button">
				<a class = "join sign-up" data-value="' . $course_array[$i]['class'] . '">
				Join Class
				</a>
				</div>';
    } else {
        echo '<div class = "join-button">
			<a class = "joined sign-up" data-value="' . $course_array[$i]['class'] . '">
				Enrolled
			</a>
			</div>';
    }
    echo '</div></div></div></div>';
}
/*--------------------------------------showing prof_course_array view-----------------------------------------------*/
for ($i = 0; $i < count($prof_course_array); $i++) {
    echo '
	<div class = "course vert-results-wrapper">
	<div class = "results-top-sec">
	<div class = "result-header">
	<div class = "title-limit" style="background-image:url(' . get_dp($con, $prof_course_array[$i]['id'],
            'course') . ')"></div>
	<a href="course.php?course_id=' . $prof_course_array[$i]['id'].'"><h2>' . boldKeyWord
        ($prof_course_array[$i]['name']) .
        '</h2></a>
	<p> </p>
	<p> </p>
	</div>
	<div class = "result-header-right">
	<div class = "result-functions-wrapper">
	<div class = "tooltip">
	<div class = "tool-wedge"></div>
	<div class = "tool-box">
	</div>
	</div>
	</div>
	</div>
	</div>
	<div class = "results-main-sec">
	<p class = "description">' . boldKeyWord($prof_course_array[$i]['desc']) . '</p>
	<div class = "lower-info-keys">
	<div class = "info-key instructor">
	Instructor
	</div>
	<div class = "info-key subject">
	Department
	</div>
	<div class = "info-key members">
	Members
	</div>
	</div>
	<div class = "lower-info">
	<div class = "info-piece instructor">';

    if (is_numeric($prof_course_array[$i]['prof'])) {
        foreach ($prof_array as $row) {
            if (in_array($prof_course_array[$i]['prof'], $row)) {
                echo '<a href= "profile.php?user_id=' . $row['id'] . '">' . boldKeyWord($row['name']) . '</a>';
            }
        }
    } else {
        echo "TBA";
    }
    echo '</div>
		<div class = "info-piece subject"><a href="department.php?dept_id=' . $prof_course_array[$i]['dept_id'] . '">'.
        boldKeyWord($course_depts[$prof_course_array[$i]['dept_id']]) . "</a></div>
			<div class = \"info-piece members\">
			<div class = \"member-pics-wrapper\">";
    /*$memebers_sql_stmt->bind_param("s", $course_array[$i]['class']);
    $memebers_sql_stmt->execute();
    $memebers_sql_stmt->store_result();
    $memebers_sql_stmt->bind_result($mem_uid);
    $count = 0;
    $hasJoined = false;
    while ($memebers_sql_stmt->fetch()) {
        if ($mem_uid == $_SESSION['user_id']) {
            $hasJoined = true;
            //continue;
        }
        if ($count < 5)
        {
            echo '<a href = "./profile?user_id=' . $mem_uid . '"class = "innerPic">
                <div class = "smallPic">
                <img class = "img" src = "' . get_user_dp($con, $mem_uid) . '" width = "29" height = "29">
                </div>
                </a>';
        }
        $count += 1;
    }
    $memebers_sql_stmt->free_result();
    $memebers_sql_stmt->reset();
    if ($count > 5) {
        echo '<a class = "rosterLink">
            <div class = "doubleBox">'.
             ($count - 5)
             .'</div>
            </a>';
    } elseif ($count == 0) {
        echo '<div> Be the first to join </div>';
    }*/
    echo '</div>
	</div>
	</div>

	<div class = "result-bottom">
	<div class = "course-schedule">

	</div>
	<div class = "course-bottom-functions">';
    if (!isCourseFollowing($con,$prof_course_array[$i][$name],$_SESSION['user'])) {
        echo '<div class = "join-button">
				<a class = "followCourse sign-up" data-value="' . $prof_course_array[$i]['id'] . '">
				Follow Course
				</a>
				</div>';
    } else {
        echo '<div class = "join-button">
			<a class = "unfollowCourse sign-up" data-value="' . $prof_course_array[$i]['id'] . '">
				Unfollow Course
			</a>
			</div>';
    }
    echo '</div></div></div></div>';
}
/*-------------------------------------------------------------------------------------------------------------------*/
foreach ($all_user_array as $row) {
    if($row['type'] == 's' || $row['type'] == 'p')
        $link = "profile.php?user_id=".$row['id'];
    else
        $link = "clubs.php?group_id=".$row['id'];
    echo '<div class = "person vert-results-wrapper">
							<a class = "person-result-image" href='.$link.'>
								<div style = "background-image: url(' . $row['picture'] . ');" class = "img"></div>
							</a>
							<div class = "person-main">
								<div class = "person-header">
									<div class = "result-header">
										<a href='.$link. '><h2>' . boldKeyWord($row['name']) . '</h2></a>
										<a href="department.php?dept_id=' . $row['dept_id'] . '"><p>' . boldKeyWord($course_depts[$row['dept_id']]) . '</p></a>
									</div>
									<div class = "result-header-right">
										<div class = "result-functions-wrapper">
											<div class = "prof-tooltip tooltip">
												<div class = "tool-wedge"></div>
												<div class = "prof-tool-box tool-box">
													<span>Add This Professor To My Bookmarks</span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class = "person-result-main">
									<a href="school.php?univ_id=' . $row['uid'] . '"><div class = "person-info">
										<div style = "background-image: url(' . get_dp($con, $row['uid'], "school") . ');" class = "title-limit">
										</div>
										<h4>' . boldKeyWord($row['uname']) . '</h4>
									</div></a>
									<div class = "person-info">
										<div class = "title-limit mail">
										</div>
										<a href="mailto:' . $row['email'] . '"><h4>' . boldKeyWord($row['email']) . '</h4></a>
									</div>';
    if ($row['type'] == 'p') {
        echo '<div class = "person-info info-location">
											<div class = "title-limit location">
											</div>
											<h4>' . $location . '</h4>
										</div>';
    }
    echo '</div>
								<div class = "person-bottom-functions">';
    if ($row['id'] != $_SESSION['user_id']) {
        echo '<div class = "link-button">';
        if (in_array($row['id'], $to_ids)) {
            echo '<a class = "pre-linked linked" data-value = "' . $row['id'] . '">Following</a>';
        } else {
            echo '<a class = "link link-up" data-value = "' . $row['id'] . '">Follow</a>';
        }
        echo '</div>';
    }
    echo '</div>
							</div>
						</div>';
}

foreach ($post_array as $row) {
    //echo '<div class = "person vert-results-wrapper">';
    include '../includes/posts.php';
    //echo '</div>';
}

echo '</div>';
$maxCredit = 0;

$course_depts = array();
if (is_array($course_array)) {
    foreach ($course_array as $row) {
        $course_depts[] = $row['dept_id'];
    }
}

if (count($course_depts) > 0) {
    $course_depts = array_unique($course_depts);

    $credit_stmt = $con->prepare("SELECT max( `credits` ) FROM (
				SELECT max( `course_credits` ) AS `credits` FROM `courses` WHERE `dept_id`
				IN (" . implode(",", $course_depts) . ")) AS ctable");

    $credit_stmt->execute();
    $credit_stmt->bind_result($max);

    while ($credit_stmt->fetch()) {
        $maxCredit = $max;
    }
}
if ($maxCredit == 0)
    $maxCredit = 4;

$all_rows = $course_rows + $professor_rows + $student_rows + $group_rows + $post_rows;

if (isset($_POST['nocalc']) && $_POST['nocalc'] == "true") {
    echo '<all_rows>' . $all_rows . '</all_rows><course_rows>' . $course_rows . '</course_rows>
			  <group_rows>' . $group_rows . '</group_rows><professor_rows>' . $professor_rows . '</professor_rows>
			  <student_rows>' . $student_rows . '</student_rows><post_rows>' . $post_rows . '</post_rows><credits>' . $maxCredit . '</credits>';
}
//$con->close();

function convToSearchString($str)
{
    return str_replace("\'", "'", $str);
}

function boldKeyWord($str)
{
    global $casedSearchString;
    $keywords = explode("%", $casedSearchString);
    if (isset($keywords) && is_array($keywords) && count($keywords) > 0) {
        foreach ($keywords as $keyword) {
            $pattern = "/" . $keyword . "/i";
            preg_match_all($pattern, $str, $match, PREG_OFFSET_CAPTURE);
            if (is_array($match[0]) && count($match[0]) > 0) {
                $match_arr = array_unique($match[0][0]);
                foreach ($match_arr as $word) {
                    $replacement = "<b style='font-weight:bold'>" . $word . "</b>";
                    $str = preg_replace("/" . $word . "/", $replacement, $str);
                }
            }
        }
    }

    return $str;
}