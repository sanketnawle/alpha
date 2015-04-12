<?php

    include_once '../dbconnection.php';
    // include_once '../../includes/common_functions.php';
    session_start();

    // echo $_POST['user_id'] = 1;

        // Preparing statement to get and group class schedules
        $cgroup_q = "SELECT s.day, s.start_time, s.end_time FROM schedule s
            JOIN courses_semester_schedule css
                ON s.schedule_id=css.schedule_id
                WHERE css.class_id=?";
        $cgroup_stmt = $con->prepare($cgroup_q);

        // Preparing statement to fetch all courses associated to the prof.
        $psub_q = "SELECT count(*) as count, cs.* FROM courses_user cu
            INNER JOIN courses_semester cs ON cu.class_id = cs.class_id
            GROUP BY cu.class_id HAVING cu.class_id
            IN (select cusr.class_id FROM courses_user cusr WHERE cusr.user_id =?)";
        $psub_stmt = $con->prepare($psub_q);

        $psub_array = array();
        if($psub_stmt){
            $psub_stmt->bind_param('i',$_POST['user_id']);
            if($psub_stmt->execute()){
                // echo "lol";
                $psub_stmt->bind_result($count, $course_id, $dept_id, $univ_id, $section_id,
                                $semester, $year, $class_id, $location, $professor);
                while($psub_stmt->fetch()){
                    // echo "test";
                    $psub_array[] = array("count"=>$count, "course_id"=>$course_id, "dept_id"=>$dept_id, "univ_id"=>$univ_id,
                        "section_id"=>$section_id, "semester"=>$semester, "year"=>$year, "class_id"=>$class_id,
                        "location"=>$location, "professor"=>$professor);
                }
            }
        }

        // echo $psub_array;

        foreach ($psub_array as $psub) {
            // $psub['course_name'];
            // $course[]['c_id'] = $psub['course_id'];
            // $course[]['sec_id'] = $psub['section_id'];

            if(isset($psub['class_id'])){
                if($cgroup_stmt){
                    // echo $psub['class_id'];
                    if($cgroup_stmt->bind_param('s',$psub['class_id']))
                        // echo "binding";
                    if($cgroup_stmt->execute()){
                        $timing = NULL;
                        $cgroup_stmt->bind_result($day, $start_time, $end_time);
                        while($cgroup_stmt->fetch()){
                            $stime = new DateTime($start_time, new DateTimeZone("America/New_York"));
                            $etime = new DateTime($end_time, new DateTimeZone("America/New_York"));
                            if($day!="TBA") $timing .= $day." (".$stime->format('g:i A')." - ".$etime->format('g:i A').") ";
                            // else $timing .= $day;
                        }
                    }
                }
            }

            $course[] = array("c_name"=>$psub['course_name'], "c_id"=>$psub['course_id'],
                "sec_id"=>$psub['section_id'], "class_id"=>$psub['class_id'], "timing"=>$timing);
        }

        // print_r($course);

        echo json_encode(array("prof_courses"=>$course));

?>