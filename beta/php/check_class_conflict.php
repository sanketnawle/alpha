<?php
/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 8/6/14
 * Time: 5:47 PM
 */

function checkConflict($user_id, $class_schedule)
{
    global $con;
    $schedule_array = array();

    $sel_stmt = $con->prepare("Select cs.section_id,
										cu.class_id,
										css.schedule_id,
										s.day,
										s.start_time,
										s.end_time
				from courses c join courses_semester cs
				join courses_semester_schedule css join courses_user cu
			    join schedule s
				on (cu.class_id = css.class_id
				and css.class_id = cs.class_id
				and c.course_id = cs.course_id
				and c.dept_id = cs.dept_id
				and c.univ_id = cs.univ_id
				and s.schedule_id = css.schedule_id)
				where cu.user_id = ?");
    $sel_stmt->bind_param("i", $user_id);
    $sel_stmt->execute();
    $sel_stmt->bind_result($section_id, $class_id, $schedule_id, $day, $start_time, $end_time);
    while ($sel_stmt->fetch()) {
        $schedule_array[] = array(
            'schedule' => $schedule_id,
            'course' => $section_id,
            'class' => $class_id,
            'day' => $day,
            'start' => $start_time,
            'end' => $end_time,
            'conflict' => 'FALSE');
    }
    $sel_stmt->close();
    for ($i = 0; $i < count($schedule_array); $i++) {
        if ($schedule_array[$i]['schedule'] == 1)
            continue;

        for ($j = 0; $j < count($class_schedule); $j++) {
            if ($class_schedule[$j]['course'] == $schedule_array[$i]['course']) {
                continue;
            }
            if (($class_schedule[$j]['schedule'] == $schedule_array[$i]['schedule'])
                || (($class_schedule[$j]['day'] == $schedule_array[$i]['day'])
                    && ((($class_schedule[$j]['start'] > $schedule_array[$i]['start'])
                            && ($class_schedule[$j]['start'] < $schedule_array[$i]['end']))
                        || (($class_schedule[$j]['end'] > $schedule_array[$i]['start'])
                            && ($class_schedule[$j]['end'] < $schedule_array[$i]['end']))
                    ))
            ) {
                return $schedule_array[$i]['course'];
            }
        }
    }
    return 'FALSE';
}

?>