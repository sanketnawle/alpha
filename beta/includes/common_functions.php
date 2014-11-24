<?php

if (!function_exists('array_column')) {
    function array_column($input = null, $columnKey = null, $indexKey = null)
    {
        $argc = func_num_args();
        $params = func_get_args();

        if ($argc < 2) {
            trigger_error("array_column() expects at least 2 parameters, {$argc} given", E_USER_WARNING);
            return null;
        }

        if (!is_array($params[0])) {
            trigger_error('array_column() expects parameter 1 to be array, ' . gettype($params[0]) . ' given', E_USER_WARNING);
            return null;
        }

        if (!is_int($params[1])
            && !is_float($params[1])
            && !is_string($params[1])
            && $params[1] !== null
            && !(is_object($params[1]) && method_exists($params[1], '__toString'))
        ) {
            trigger_error('array_column(): The column key should be either a string or an integer', E_USER_WARNING);
            return false;
        }

        if (isset($params[2])
            && !is_int($params[2])
            && !is_float($params[2])
            && !is_string($params[2])
            && !(is_object($params[2]) && method_exists($params[2], '__toString'))
        ) {
            trigger_error('array_column(): The index key should be either a string or an integer', E_USER_WARNING);
            return false;
        }

        $paramsInput = $params[0];
        $paramsColumnKey = ($params[1] !== null) ? (string)$params[1] : null;

        $paramsIndexKey = null;
        if (isset($params[2])) {
            if (is_float($params[2]) || is_int($params[2])) {
                $paramsIndexKey = (int)$params[2];
            } else {
                $paramsIndexKey = (string)$params[2];
            }
        }

        $resultArray = array();

        foreach ($paramsInput as $row) {

            $key = $value = null;
            $keySet = $valueSet = false;

            if ($paramsIndexKey !== null && array_key_exists($paramsIndexKey, $row)) {
                $keySet = true;
                $key = (string)$row[$paramsIndexKey];
            }

            if ($paramsColumnKey === null) {
                $valueSet = true;
                $value = $row;
            } elseif (is_array($row) && array_key_exists($paramsColumnKey, $row)) {
                $valueSet = true;
                $value = $row[$paramsColumnKey];
            }

            if ($valueSet) {
                if ($keySet) {
                    $resultArray[$key] = $value;
                } else {
                    $resultArray[] = $value;
                }
            }

        }

        return $resultArray;
    }

}

if (!function_exists('in_array_r')) {
    function in_array_r($needle, $haystack, $strict = false)
    {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
                return true;
            }
        }

        return false;
    }
}
if (!function_exists('refValues')) {
    function refValues($arr)
    {
        if (strnatcmp(phpversion(), '5.3') >= 0) //Reference is required for PHP 5.3+
        {
            $refs = array();
            foreach ($arr as $key => $value)
                $refs[$key] = & $arr[$key];
            return $refs;
        }
        return $arr;
    }
}

if (!function_exists('get_user_dp')) {
    function get_user_dp($con, $id)
    {
        $default = "DefaultImages/user.png";
        $dp_flag = 0;
        $dp_link = 0;
        $dp_blob = 0;
        $user_dp = $con->prepare("SELECT dp_flag, dp_link, dp_blob FROM user
						WHERE user_id = ?");
        if ($user_dp) {
            $user_dp->bind_param('i', $id);
            if ($user_dp->execute()) {
                $user_dp->store_result();
                $user_dp->bind_result($dp_flag, $dp_link, $dp_blob);
                $user_dp->fetch();
                $user_dp->close();
            }
        }

        if ($dp_flag == 'blob') {
            if ($dp_blob != NULL) return $blob = "includes/get_blob.php?img_id=" . $dp_blob;
            else return $default;
        } else if ($dp_flag == 'link') {
            if ($dp_link != NULL) return $dp_link;
            else return $default;
        } else return $default;
    }
}

if (!function_exists('get_course_dp')) {
    function get_course_dp($con, $id)
    {
        $default = "DefaultImages/class.png";

        $user_dp = $con->prepare("SELECT dp_blob_id FROM courses
                        WHERE course_id = ?");
        $user_dp->bind_param('s', $id);
        if ($user_dp->execute()) {
            $user_dp->store_result();
            $user_dp->bind_result($dp_blob);
            $user_dp->fetch();
            $user_dp->close();
        }

        if ($dp_blob != NULL) return $blob = "includes/get_blob.php?img_id=" . $dp_blob;
        else return $default;
    }
}

if (!function_exists('get_class_dp')) {
    function get_class_dp($con, $id)
    {
        $default = "DefaultImages/class.png";

        $user_dp = $con->prepare("SELECT dp_blob_id FROM courses_semester
                        WHERE class_id = ?");
        $user_dp->bind_param('s', $id);
        if ($user_dp->execute()) {
            $user_dp->store_result();
            $user_dp->bind_result($dp_blob);
            $user_dp->fetch();
            $user_dp->close();
        }

        if ($dp_blob != NULL) return $blob = "includes/get_blob.php?img_id=" . $dp_blob;
        else return $default;
    }
}

if (!function_exists('get_dept_dp')) {
    function get_dept_dp($con, $id)
    {
        $default = "DefaultImages/school.png";

        $user_dp = $con->prepare("SELECT dp_blob_id FROM department
                        WHERE dept_id = ?");
        $user_dp->bind_param('i', $id);
        if ($user_dp->execute()) {
            $user_dp->store_result();
            $user_dp->bind_result($dp_blob);
            $user_dp->fetch();
            $user_dp->close();
        }

        if ($dp_blob != NULL) return $blob = "includes/get_blob.php?img_id=" . $dp_blob;
        else return $default;
    }
}

if (!function_exists('get_school_dp')) {
    function get_school_dp($con, $id)
    {
        $default = "DefaultImages/school.png";

        $user_dp = $con->prepare("SELECT dp_blob_id FROM university
                        WHERE univ_id = ?");
        $user_dp->bind_param('i', $id);
        if ($user_dp->execute()) {
            $user_dp->store_result();
            $user_dp->bind_result($dp_blob);
            $user_dp->fetch();
            $user_dp->close();
        }

        if ($dp_blob != NULL) return $blob = "includes/get_blob.php?img_id=" . $dp_blob;
        else return $default;
    }
}

if (!function_exists('get_club_dp')) {
    function get_club_dp($con, $id)
    {
        $default = "DefaultImages/club.png";

        $user_dp = $con->prepare("SELECT dp_blob_id FROM groups
                        WHERE group_id = ?");
        $user_dp->bind_param('i', $id);
        if ($user_dp->execute()) {
            $user_dp->store_result();
            $user_dp->bind_result($dp_blob);
            $user_dp->fetch();
            $user_dp->close();
        }

        if ($dp_blob != NULL) return $blob = "includes/get_blob.php?img_id=" . $dp_blob;
        else return $default;
    }
}

if (!function_exists('get_user_info')) {
    function get_user_info($con, $id) {
        $user_info = $con->prepare("SELECT U.firstname, U.lastname, U.user_type, U.dept_id, U.gender, U.univ_id, U.user_bio, U.user_email FROM user U
                        WHERE user_id = ?");
        $user_info->bind_param('i', $id);
        if ($user_info->execute()) {
            $user_info->store_result();
            $user_info->bind_result($firstname, $lastname, $user_type, $dept_id, $gender, $univ_id, $user_bio, $user_email);
            $user_info->fetch();
            $user_info->close();
        }

        if ($firstname != NULL) return array(
            'user_email' => $user_email,
            'user_type' => $user_type,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'univ_id' => $univ_id,
            'dept_id' => $dept_id,
            'user_bio' => $user_bio,
            'gender' => $gender
        );
        else false;
    }
}




if (!function_exists('get_current_semester')) {
    function get_current_semester($con, $university)
    {
        $current_semester = "";
        $result = $con->query("SELECT semester from univ_semester where univ_id = $university and start_date <= (SELECT curdate()) and end_date >= (SELECT curdate()) ");
        if ($result->num_rows > 0)
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $current_semester = $row['semester'];
            }
        else {
            if ($result = $con->query("SELECT semester from univ_semester where univ_id = $university and start_date >= (SELECT curdate()) order by start_date")) {
                while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                    $current_semester = $row['semester'];

                }
            }
        }
        return $current_semester;
    }
}

if (!function_exists('mailto')) {
    function mailto($to, $subject, $message, $from)
    {
        //$headers .= 'From: Noreply <'.$from.'>' . "\r\n";
        $headers = 'From: ' . $from . "\r\n" .
            'Reply-To: no-reply@urlinq.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        $headers .= 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        mail($to, $subject, $message, $headers);
    }
}

if (!function_exists('formatSingularPlural')) {
    function formatSingularPlural($count, $string)
    {
        if ($string == " person") {
            return $count > 1 ? " people" : ($count == 0) ? " " : " person";
        } else if ($string == " is") {
            return $count <= 1 ? $string : " are";
        } else if ($string == " has") {
            return $count <= 1 ? $string : " have";
        } else {
            return $count > 1 ? $string . "s" : $string;
        }
    }
}
if (!function_exists('groupify')) {
    function groupify($row, $count = 1)
    {
        $result = "";
        if (is_array($row) && count($row) > $count) {
            $i = 0;
            foreach ($row as $k => $v) {
                if ($i < $count)
                    $result .= "<span class = 'keyword' data-id='" . $k . "'>" . $v . "</span>, ";
                $i++;
            }
            $result = substr($result, 0, strlen($result) - 2) . " and <span class='keyword'>" . (count($row) - $count) . "</span>" . formatSingularPlural((count($row) - $count), " other");
// 		$result .= substr($result, 0,strlen($result)-2)." and <div class='mf_liked' id='".tar_tag($con,$qlist['tag_type'],$qlist['tag_id'])."'><span class='keyword'>".(count($row)-$count)."</span>".
// 		"<div class='noti_hid'><span class='keyword'>".implode("</span><br/><span class='keyword'>", array_slice($row, $count)).
// 		"</span></div></div> ".formatSingularPlural(count($result), "other");
        } else {
            $result = implode(", ", $row);
            $pos = strripos(", ", $result);
            if ($pos > 0) {
                $result = "<span class='keyword'>" . substr($result, 0, $pos) . "</span> and <span class='keyword'>" . substr($result, $pos + 2) . "</span>";
            } else {
                $result = "<span class='keyword'>" . $result . "</span>";
            }
        }
        return $result;
    }
}
if (!function_exists('input_sanitize')) {
    function input_sanitize($string, $con)
    {
        $string = htmlspecialchars($string);
        //$string=strip_tags($string);
        $string = $con->real_escape_string($string);
        return $string;
    }
}
if (!function_exists('output_sanitize')) {
    function output_sanitize($string)
    {
        return $string = nl2br(htmlspecialchars($string));
    }
}
if (!function_exists('get_alias_univ')) {
    function get_alias_univ($con, $university)
    {
        $alias = "";
        $result = $con->query("SELECT alias FROM university WHERE univ_id=$university");
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $alias = $row['alias'];
        }
        return $alias;

    }

}
if (!function_exists('get_student_grade')) {
    function get_student_grade($user_id)
    {
	    GLOBAL $con;
        $student_type = "";
        $st_stmt = $con->prepare("SELECT student_type FROM student_attribs WHERE user_id = ?");
        if ($st_stmt) {
            $st_stmt->bind_param("i", $user_id);
            $st_stmt->execute();
            $st_stmt->bind_result($student_type);
            $st_stmt->fetch();
        }
        return $student_type;
    }
}
if(!function_exists('is_member_of'))
{
	function is_member_of($con,$user_id,$type,$id)
	{
		$is_mem =0;
		if(is_null($id) || is_null($user_id))
			return false;
		if($type == 'club'){
			$mem_stmt = $con->prepare("SELECT count(*) FROM group_users WHERE user_id =? and group_id = ?");
			if($mem_stmt){
				$mem_stmt->bind_param("ii",$user_id,$id);
				$mem_stmt->execute();
				$mem_stmt->bind_result($is_mem);
				$mem_stmt->fetch();
				$mem_stmt->close();
			}
		}
		elseif($type == 'class'){
			$mem_stmt = $con->prepare("SELECT count(*) FROM courses_user WHERE user_id =? and class_id = ?");
			if($mem_stmt){
				$mem_stmt->bind_param("is",$user_id,$id);
				$mem_stmt->execute();
				$mem_stmt->bind_result($is_mem);
				$mem_stmt->fetch();
				$mem_stmt->close();
			}
		}
		return $is_mem!=0;
	}
}
if (!function_exists('get_student_attribs')) {
    function get_student_attribs($con,$user_id)
    {
        if ($stmt = $con->prepare("SELECT * FROM student_attribs WHERE user_id = ?")) {
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $stmt->bind_result($row);
            $stmt->fetch();
            return $row;
            //$stmt->close();
        }else{
            return null;
        }
    }
}


//if (!function_exists('get_student_attribs')) {
//    function get_student_attribs($con,$user_id)
//    {
//        $user_info = $con->prepare("SELECT U.website, U.major, U.year, U.student_type, U.minor FROM student_attribs U WHERE user_id = ?");
//        $user_info->bind_param('i', $user_id);
//        if ($user_info->execute()) {
//            $user_info->store_result();
//            $user_info->bind_result($website, $major, $year, $student_type, $minor);
//            $user_info->fetch();
//            $user_info->close();
//        }
//
//        if ($website != NULL) {
//            return array(
//                'website' => $website,
//                'major' => $major,
//                'year' => $year,
//                'student_type' => $student_type,
//                'minor' => $minor
//            );
//        } else {
//            return false;
//        }
//    }
//}



if (!function_exists('get_dp')) {
    function get_dp($con, $id, $place /*dept, course, class, user, school, club*/)
    {
        //converting string to lower case
        $place = strtolower(trim($place));
        switch ($place) {
            case 'class':
                return get_class_dp($con, $id);
                break;
            case 'course':
                return get_course_dp($con, $id);
                break;
            case 'dept':
                return get_dept_dp($con, $id);
                break;
            case 'school':
                return get_school_dp($con, $id);
                break;
            case 'user':
                return get_user_dp($con, $id);
                break;
            case 'club':
                return get_club_dp($con, $id);
                break;
            default:
                return "Never get here";
        }
    }
}

if (!function_exists('get_cover_pic')) {
    function get_cover_pic($con, $id, $place /*dept, course, class, user, school, club*/)
    {
        //converting string to lower case
        $place = strtolower(trim($place));
        switch ($place) {
            case 'course':
                return get_course_cover($con, $id);
                break;
            case 'dept':
                return get_dept_cover($con, $id);
                break;
            case 'school':
                return get_school_cover($con, $id);
                break;
            case 'club':
                return get_club_cover($con, $id);
                break;
            default:
                return "Never get here";
        }
    }
}

if (!function_exists('get_dept_cover')) {
    function get_dept_cover($con, $id)
    {
        $default = "DefaultImages/school.png";

        $user_dp = $con->prepare("SELECT cover_blob_id FROM department
                        WHERE dept_id = ?");
        $user_dp->bind_param('i', $id);
        if ($user_dp->execute()) {
            $user_dp->store_result();
            $user_dp->bind_result($cover_blob);
            $user_dp->fetch();
            $user_dp->close();
        }

        if ($cover_blob != NULL) return $blob = "includes/get_blob.php?img_id=" . $cover_blob;
        else return $default;
    }
}

if (!function_exists('get_school_cover')) {
    function get_school_cover($con, $id)
    {
        $default = "DefaultImages/school.png";

        $user_dp = $con->prepare("SELECT cover_blob_id FROM university
                        WHERE univ_id = ?");
        $user_dp->bind_param('i', $id);
        if ($user_dp->execute()) {
            $user_dp->store_result();
            $user_dp->bind_result($cover_blob);
            $user_dp->fetch();
            $user_dp->close();
        }

        if ($cover_blob != NULL) return $blob = "includes/get_blob.php?img_id=" . $cover_blob;
        else return $default;
    }
}

if (!function_exists('get_club_cover')) {
    function get_club_cover($con, $id)
    {
        $default = "DefaultImages/club.png";

        $user_dp = $con->prepare("SELECT cover_blob_id FROM groups
                        WHERE group_id = ?");
        $user_dp->bind_param('i', $id);
        if ($user_dp->execute()) {
            $user_dp->store_result();
            $user_dp->bind_result($cover_blob);
            $user_dp->fetch();
            $user_dp->close();
        }

        if ($cover_blob != NULL) return $blob = "includes/get_blob.php?img_id=" . $cover_blob;
        else return $default;
    }
}

if (!function_exists('get_course_cover')) {
    function get_course_cover($con, $id)
    {
        $default = "DefaultImages/class.png";

        $user_dp = $con->prepare("SELECT cover_blob_id FROM courses
                        WHERE course_id = ?");
        $user_dp->bind_param('s', $id);
        if ($user_dp->execute()) {
            $user_dp->store_result();
            $user_dp->bind_result($cover_blob);
            $user_dp->fetch();
            $user_dp->close();
        }

        if ($cover_blob != NULL) return $blob = "includes/get_blob.php?img_id=" . $cover_blob;
        else return $default;
    }
}

if (!function_exists('check_abuse')) {
    function check_abuse($string)
    {
        $arr = explode("\n", strtolower(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/beta/blocked.txt')));
        $arr = array_map('trim', $arr);
        $str = explode(" ", $string);

        foreach (array_filter($arr) as $ab) {
            if ($ab != "") {
                if (stristr($string, $ab)) {
                    return TRUE;
                }
            }
        }

        if ($res = array_intersect($arr, $str)) {
            echo(json_encode($res));
            // print_r($res);
            return TRUE;
        } else return FALSE;
    }
}

if (!function_exists('preregister_email')) {
    function preregister_email($to, $from)
    {
        //$headers .= 'From: Noreply <'.$from.'>' . "\r\n";
        $headers = 'From: ' . $from . "\r\n" .
            'Reply-To: no-reply@urlinq.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        $headers .= 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $message = "<!DOCTYPE html>
<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <meta name='viewport' content='width=320; initial-scale=.55; user-scalable=no;'>
    <title>Welcome to Urlinq</title>
    <style type='text/css'>
        body {
            margin: 0;
            padding: 0;
            min-width: 100% !important;
        }

        .content {
            width: 100%;
            max-width: 600px;
            padding-left: 10px;
            padding-right: 10px;
        }

        .header {
            padding: 0 20px 20px 0;
        }

        @media (max-width: 500px) {
            .emailLogo {
                height: 50px !important;
            }

            .mobileGetBigP {
                font-size: 25.5px !important;
            }

            .mobileGetBigA {
                font-size: 30.5px !important;
            }
        }


    </style>
</head>
<body bgcolor='#fff'>
<table width='100%' bgcolor='#fff' border='0' cellpadding='0' cellspacing='0'>
    <tbody>
    <tr>
        <td>
            <table class='content' align='center' cellpadding='0' cellspacing='0' border='0'
                   style='border-bottom:1px solid #e9e9e9;'>
                <tbody>
                <tr>
                    <td width='600' height='70' style=' height: auto; padding: 20px 0 9px;'>
                        <img class='emailLogo' src='http://urlinq.com/beta/emailImg/grayLogo.png' height='36'
                             style='margin-left:5px;' border='0' alt=''>
                    </td>
                </tr>
                </tbody>
            </table>
            <table class='content' align='center'
                   style='border-spacing:0; vertical-align:top; text-align:left;width:100%;padding:36px 0 0; margin:0 auto;'>
                <tbody>
                <tr style='vertical-align:top;text-align:left;padding:0' align='center'>
                    <td style='border-collapse:collapse!important;vertical-align:top;text-align:left;padding:0'
                        align='center' valign='top'>
                        <img src='http://urlinq.com/beta/emailImg/squareLogo.png'
                             style='border-radius:0px; display:block;margin:0 auto;border:0'
                             alt='Navigate the Universiy.' align='center' width='105' height='105'>
                    </td>
                </tr>
                </tbody>
            </table>
            <table class='content' align='center'
                   style='border-spacing:0;vertical-align:top;text-align:inherit;margin:0 auto;padding:24px 35px 10px;width:570px!important'>
                <tbody>
                <tr style='vertical-align:top;text-align:left;padding:0;' align='center'>
                    <td style='border-collapse:collapse!important;vertical-align:top;text-align:left;padding:0'
                        align='center' valign='top'>
                        <p class='mobileGetBigP'
                           style='color:#2a2a2a;display:block;font-family: Lucida Grande,Lucida Sans,Lucida Sans Unicode,Arial,Helvetica,Verdana,sans-serif;font-weight:normal;text-align:left;line-height:1.714em;font-size: 16.5px;margin:0 auto;padding: 0 0 10px;'
                           align='center'>
                                        <span style='margin-top:10px;display:block;'>
                                            Welcome to Urlinq! Thank you for joining our pre-registration list. We will keep you updated over the next few weeks as the Urlinq academic network is released. In the meantime, feel free to read up on what we've been creating on our blog.
                                        </span>
                        </p>
                    </td>

                </tr>
                <tr style='vertical-align:top;text-align:left;padding:0;' align='center'>
                    <td style='border-collapse:collapse!important;vertical-align:top;text-align:left;padding:0'
                        align='center' valign='top'>
                        <a href='https://urlinq.com/blog' class='mobileGetBigA' style='font-family: Lucida Grande,Lucida Sans,Lucida Sans Unicode,Arial,Helvetica,Verdana,sans-serif;border:1px solid;display:block;padding:14px 16px;text-decoration:none;border-radius: 2px;text-align:center;color:white!important;font-weight:bold;font-size:18.5px;white-space:nowrap;
                                    margin:0 auto;margin-top:.25em;cursor:pointer;background-color: rgb(0,217,160); border-bottom: 3px solid rgb(8, 184, 138);'>
                            View Our Blog
                        </a>
                    </td>
                </tr>
                <tr style='vertical-align:top;text-align:left;padding:0;' align='center'>
                    <td style='border-collapse:collapse!important;vertical-align:top;text-align:left;padding:0;padding-top: 16px;'
                        align='center' valign='top'>
                        <p class='mobileGetBigP' style='
                                        color: #2a2a2a; display: block; font-family: Lucida Grande,Lucida Sans,Lucida Sans Unicode,Arial,Helvetica,Verdana,sans-serif; font-weight: normal; text-align: left; line-height: 1.714em; font-size: 16.5px; margin: 0 auto; padding: 0 0 10px;
                                    '>If you don't see the button above, <a href='https://urlinq.com/blog' style='
                                        color: rgb(0,217,160);
                                        cursor: pointer;
                                    '>click here</a></p>
                    </td>
                </tr>
                <tr style='vertical-align:top;text-align:left;padding:0;' align='center'>
                    <td style='border-collapse:collapse!important;vertical-align:top;text-align:left;padding:0'
                        align='center' valign='top'>
                        <p class='mobileGetBigP'
                           style='color:#2a2a2a;display:block;font-family: Lucida Grande,Lucida Sans,Lucida Sans Unicode,Arial,Helvetica,Verdana,sans-serif;font-weight:normal;text-align:left;line-height:1.714em;font-size: 16.5px;margin:0 auto;margin-top: .25em;padding: 0 0 10px;'
                           align='center'>
                            Thanks,
                                        <span style='margin-top:5px;display:block;'>
                                        The Urlinq Family
                                        </span>
                        </p>
                    </td>

                </tr>
                </tbody>
            </table>
            <table width='600' class='content' align='center' cellpadding='0' cellspacing='0' border='0'
                   style='padding-top:0px;vertical-align:top;margin:0 auto; border-top:1px solid #e9e9e9'>
                <tbody>
                <tr style='margin:0;padding:0;display: block;width: 84px;margin: 0 auto;padding-top: 12px;'>
                    <td style='max-width: 30px; margin:0;padding:5px;white-space: nowrap;'>
                        <a title='Facebook' href='https://facebook.com/joinurlinq'
                           style='margin:0;text-decoration:none;color:#999999;padding:0;'>
                            <img alt='Facebook' height='18' width='18' style='' 'margin:0;padding:0;border:0;'=''
                            src='http://urlinq.com/beta/emailImg/fb_email_icon.png'>
                        </a>
                    </td>
                    <td style='width:30px; margin:0;padding:5px;'>
                        <a title='Google Plus' href='https://plus.google.com/+urlinq'
                           style='margin:0;text-decoration:none;color:#999999;padding:0;'>
                            <img alt='Google Plus' height='17' width='17' style='' 'margin:0;padding:0;border:0;'=''
                            src='http://urlinq.com/beta/emailImg/plus_email_icon.png'>
                        </a>
                    </td>
                    <td style='width:30px; margin:0;padding:5px;'>
                        <a title='Twitter' href='https://twitter.com/urlinq'
                           style='margin:0;text-decoration:none;color:#999999;padding:0;'>
                            <img alt='Twitter' height='17' width='17' style='' 'margin:0;padding:0;border:0;'=''
                            src='http://urlinq.com/beta/emailImg/twitter_email_icon.png'>
                        </a>
                    </td>
                </tr>
                <tr style='vertical-align:top;text-align:left;padding:0;'>
                    <td height='70'
                        style='border-collapse: collapse!important; vertical-align:top; text-align:left; height: auto; padding: 0px; padding-top: 0px;'>
                        <p style='color:#999999;font-size:9px;width:340px;text-align:center;font-family:Lucida Grande,Lucida Sans,Lucida Sans Unicode,Arial,Helvetica,Verdana,sans-serif;font-weight:normal;line-height:1.714em;margin:0 auto;padding:12px 0 10px;'
                           align='center'>
                            This email was sent to <span>$to</span>.
                            <br>
                            <br>
                            TM and copyright © 2014 Urlinq LLC. New York City.

                        </p>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>


</body>
</html>";
        $subject = "Welcome to Urlinq";
        mail($to, $subject, $message, $headers);
    }
}