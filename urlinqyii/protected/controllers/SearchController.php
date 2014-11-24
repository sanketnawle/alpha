<?php

class SearchController extends Controller
{

    //public function actionSearch()
    public function actionView()
    {
        if (isset ($_GET["q"])){
            $q = Yii::app()->request->getQuery('q');

        }else{
            $q = '';
        }
        $user = User::model()->find('user_id=:id', array(':id'=>1));
        $this->render('search', array('user'=>$user, 'q'=>$q));
    }


    public function actionJson()
    { //We want to render JSON to the front-end so search.js can decode it

        $query = Yii::app()->request->getQuery('q');
        $filter = Yii::app()->request->getQuery('f');
        $user = $this->get_current_user();
        $university = University::model()->find('university_id=:university_id',array(':university_id'=>1));

        //$user = User::model()->find('user_id=:id', array(':id'=>1)); //temporary...


        $date = date("Y-m-d H:i:s", time());
        $datetime = new DateTime($date);
        $datetime->modify('+1 day');


        //just gets everything that contains the search string (unspecific search)
        $usql = "Select *  from `user` Where firstname LIKE '%".$query."%' OR firstname LIKE '%".$query.
            "%' OR concat(firstname, ' ' ,lastname) LIKE '%".$query."%' AND school_id = ".$user->school_id.
            " AND user_type = 's'";
        $csql = "Select * from course Where course_name LIKE '%".$query."%' OR course_desc LIKE '%".$query."%'";
        $ssql = "Select * from school where school_name LIKE '%".$query."%'";
        $dsql = "Select * from department where department_name LIKE '%".$query."%'";
        $gsql = "Select * from `group` where group_name LIKE '%.$query.%'";

        //specific queries
        $piyd = Yii::app()->db->createCommand()
            ->select('user_id, firstname, lastname, school_id, department_id, picture_file_id')
            ->from('user u')
            ->where('school_id=:sid and user_type=:type and department_id = :did', array(':sid'=>$user->school_id, ':type'=>"p", ':did'=>$user->department_id))
            ->queryRow();
        $piys = Yii::app()->db->createCommand()
            ->select('user_id, firstname, lastname, school_id, department_id, picture_file_id')
            ->from('user u')
            ->where('school_id=:sid and user_type=:type', array(':sid'=>$user->school_id, ':type'=>"p"))
            ->queryRow();
        $ciyd = Yii::app()->db->createCommand()
            ->select('course_id, course_name, school_id, department_id, picture_file_id')
            ->from('course')
            ->where('school_id=:sid and department_id = :did', array(':sid'=>$user->school_id, ':did'=>$user->department_id))
            ->queryRow();
        $ciys = Yii::app()->db->createCommand()
            ->select('course_id, course_name, school_id, department_id, picture_file_id')
            ->from('course')
            ->where('school_id=:sid', array(':sid'=>$user->school_id))
            ->queryRow();
        $giys = Yii::app()->db->createCommand()
            ->select('group_id, group_name, picture_file_id')
            ->from('group')
            ->where('school_id=:sid', array(':sid'=>$user->school_id))
            ->queryRow();

        $userContent = User::model()->findAllBySql($usql);
        $courseContent = Course::model()->findAllBySql($csql);
        $schoolContent = School::model()->findAllBySql($ssql);
        $departmentContent = Department::model()->findAllBySQL($dsql);
        $groupContent = Group::model()->findAllBySQL($gsql);


        if($filter == "piyd" && !$query)
        {   //professors in your department
            $data = array
            (
                'success'=> true,
                //'query'=>$query,
                //'filter'=>$filter,
                'professors'=>$piyd,
            );
        }
        else if($filter == "piys" && !$query)
        {   //professors in your school
            $data = array
            (
                'success'=> true,
                //'query'=>$query,
                //'filter'=>$filter,
                'professors'=>$piys
            );
        }
        else if($filter == "ciyd" && !$query)
        {   //courses in your department
            $data = array
            (
                'success'=> true,
                //'query'=>$query,
                //'filter'=>$filter,
                'courses'=>$ciyd,
            );
        }
        else if($filter == "ciys" && !$query)
        {   //courses in your school
            $data = array
            (
                'success'=> true,
                //'query'=>$query,
                //'filter'=>$filter,
                'courses'=>$ciys
            );
        }
        if($filter == "giys" && !$query)
        {   //clubs(groups) in your school
            $data = array
            (
                'success'=> true,
                //'query'=>$query,
                //'filter'=>$filter,
                'courses'=>$giys
            );
        }
        else
        {  //return all results, if we don't get a filter
            $data = array
            (
                'success'=> true,
                //'query'=>$query,
                //'filter'=>$filter,
                //if objects have content, render appropriate categories in search page. else: hide.
                'users'=>$userContent,
                //'professors'=>$professorContent, //omitted because we return professors and students simultaneously
                'courses'=>$courseContent,
                'schools'=>$schoolContent,
                'departments'=>$departmentContent,
                'clubs'=>$groupContent
                //'university'=>$this->get_model_associations($university,array('schools'=>array('pictureFile')))
                //'posts'=>$postContent
            );
        }




        $this->renderJSON($data);
    }
}




/*
 *      //get classes with course name and course id matching the search term
 *      //apparently I'm not supposed to return posts or events...
        //$psql = "Select * from post where text LIKE '%".$query."%' OR sub_text LIKE '%".$query."%'";
        //$postContent = Post::model()->findAllBySQL($psql);
        //$event_count += count($userContent);
        $matchingClasses = "SELECT cl.course_id, cl.department_id, co.course_name, co.course_desc, co.course_credits, cl.class_id, cl.section_id, cl.location, cl.professor
                            FROM classes AS cl JOIN courses AS co
                            ON (cl.school_id = co.school_id AND cl.department_id = co.department_id AND cl.course_id = co.course_id)
                            WHERE cl.school_id = ? AND (upper(co.course_name) LIKE ? OR upper(co.course_id) LIKE ?)
                            AND cl.year =  2014  AND cs.semester = 'fall' "; //.$course_filter . $filter (add this in the view)
        //get courses with search term in description
        $inCourseDescription = "SELECT co.course_id, cl.department_id, co.course_name, co.course_desc, co.course_credits, cl.class_id, cl.section_id, cl.location, cl.professor
                            FROM courses AS co JOIN classes AS cl
                            ON (cl.school_id = co.school_id AND cl.department_id = co.department_id AND cl.course_id = co.course_id)
                            WHERE cl.school_id = ? AND (upper(co.course_desc) LIKE ?
                            AND cl.year =  2014  AND cs.semester = 'fall' "; //.$course_filter . $filter (add this in the view)";
        //get courses a professor is teaching
        $professorSearch = "SELECT co.course_id, cl.department_id, co.course_name, co.course_desc, co.course_credits, cl.professor
                            FROM courses AS co JOIN classes AS cl
                            ON (cl.school_id = co.school_id AND cl.professor_id = co.department_id AND cl.course_id = co.course_id)
                            WHERE cl.school_id = ? AND cl.professor IN (SELECT user_id from user where uPPER(firstname) LIKE ? OR UPPER(lastname) LIKE ?)
                            AND cl.year =  2014  AND cs.semester = 'fall' "; //.$course_filter . $filter (add this in the view)";
        $profsql = "Select *  from `user` Where firstname LIKE '%".$query."%' OR firstname LIKE '%".$query.
                "%' OR concat(firstname, ' ' ,lastname) LIKE '%".$query."%' AND school_id = ".$user->school_id.
                " AND user_type = 'p'";


 * */