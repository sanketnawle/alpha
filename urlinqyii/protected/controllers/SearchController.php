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
       // $user = $this->get_current_user();
        $school = $user->school->school_name;
        $this->render('search', array('user'=>$user,'school' =>$school, 'q'=>$q));
    }

    public function actionQuickSearch(){
        if(!isset($_GET['q'])){
            $data = array('success'=>false,'error_id'=>1, 'error_msg'=>'q not set');
            $this->renderJSON($data);
            return;
        }

        $query = $_GET['q'];

        $results = array();

        $users = User::model()->findAllBySql("SELECT * FROM `user` WHERE CONCAT(firstname,' ',lastname) LIKE '%" . $query ."%' LIMIT 2");

        foreach($users as $user){
            $user = $this->get_model_associations($user, array('pictureFile'));
            $user['origin_type'] = 'user';
            $user['origin_name'] = $user['firstname'] . ' ' . $user['lastname'];
            array_push($results, $user);
        }
        //array_push($results, $users);


        $classes = ClassModel::model()->findAllBySql("SELECT * FROM `class` WHERE class_name LIKE '%" . $query ."%' LIMIT 2");

        foreach($classes as $class){
            $class = $this->get_model_associations($class, array('pictureFile'));
            $class['origin_type'] = 'class';
            $class['origin_name'] = $class['class_name'];
            $class['origin_id'] = $class['class_id'];

            array_push($results, $class);
        }

        //array_push($results, $classes);

        $schools = School::model()->findAllBySql("SELECT * FROM `school` WHERE school_name LIKE '%" . $query ."%' LIMIT 2");

        foreach($schools as $school){
            $school = $this->get_model_associations($school, array('pictureFile'));
            $school['origin_type'] = 'school';
            $school['origin_name'] = $school['school_name'];
            $school['origin_id'] = $school['school_id'];


            array_push($results, $school);
        }

        //array_push($results, $schools);




        $data = array('success'=>true,'results'=>$results);
        $this->renderJSON($data);
        return;
    }


    public function actionJson()
    { //We want to render JSON to the front-end so search.js can decode it
        $query = Yii::app()->request->getQuery('q');
        $filter = Yii::app()->request->getQuery('f');
        $user = $this->get_current_user();
        $university = University::model()->find('university_id=:university_id',array(':university_id'=>1));
        //$user = User::model()->find('user_id=:id', array(':id'=>1)); //temporary...

        //just gets everything that contains the search string (unspecific search)
        $usql = Yii::app()->db->createCommand()
            ->select('u.firstname, u.lastname, u.user_id, u.user_type, d.department_name, d.department_id, u.picture_file_id')
            ->from('user u')
            ->join('department d','u.department_id = d.department_id')
            ->where(array('like', "concat(firstname, ' ', lastname)", '%'.$query.'%'))
            ->limit(30)
            ->queryAll();
        $students = Yii::app()->db->createCommand()
            ->select('u.firstname, u.lastname, u.user_id, u.user_type, d.department_name, d.department_id, u.picture_file_id')
            ->from('user u')
            ->join('department d','u.department_id = d.department_id')
            ->where(array('like', "concat(firstname, ' ', lastname)", '%'.$query.'%'))
            ->andWhere("u.user_type = 's'")
            ->limit(30)
            ->queryAll();
        $professors = Yii::app()->db->createCommand()
            ->select('u.firstname, u.lastname, u.user_id, d.department_name, d.department_id, u.picture_file_id')
            ->from('user u')
            ->join('department d','u.department_id = d.department_id')
            ->where(array('like', "concat(firstname, ' ', lastname)", '%'.$query.'%'))
            ->andWhere("u.user_type = 'p'")
            ->limit(30)
            ->queryAll();


        $courses = Course::model()->findAllBySql("SELECT * FROM `course` WHERE course_name LIKE '%" . $query . "%' LIMIT 30");
        for($i = 0; $i < count($courses); $i++){
            $courses[$i] = $this->get_model_associations($courses[$i], array('pictureFile', 'department'));
        }
//        $csql = Yii::app()->db->createCommand()
//            ->select('c.course_name, c.course_id, c.course_desc, d.department_name, d.department_id, s.school_name, s.school_id, c.picture_file_id')
//            ->from('course c')
//            ->join('department d','c.department_id = d.department_id')
//            ->join('school s', 's.school_id = d.school_id')
//            ->where(array('like', "c.course_name", '%'.$query.'%'))
//            ->limit(30)
//            ->queryAll();



        $dsql = Yii::app()->db->createCommand()
            ->select('d.department_name, d.department_id, d.department_description, s.school_name, s.school_id, d.picture_file_id')
            ->from('department d')
            ->join('school s', 's.school_id = d.school_id')
            ->where(array('like', "d.department_name", '%'.$query.'%'))
            ->limit(30)
            ->queryAll();


        $schools = Yii::app()->db->createCommand()
            ->select('school_name')
            ->from('school s')
            //->where('university_id=:uid', array(':uid'=>$university->university_id))
            ->queryAll();
        //$dsql = "Select * from department where department_name LIKE '%".$query."%' LIMIT 30";
        $majors = Yii::app()->db->createCommand()
            ->select('name')
            ->from('major')
            ->queryAll();


        $departments = Department::model()->findAllBySql("SELECT * FROM `department` WHERE department.department_name LIKE '%" .$query. "%' LIMIT 30");
        for($i = 0; $i < count($departments); $i++){
            $course_count = count($departments[$i]->courses);
            $faculty_count = count($departments[$i]->admins);

            $student_count = count($departments[$i]->students);


            $departments[$i] = $this->get_model_associations($departments[$i], array('pictureFile', 'school'));

            $departments[$i]['course_count'] = $course_count;
            $departments[$i]['faculty_count'] = $faculty_count;
            $departments[$i]['student_count'] = $student_count;

        }
//        $departments = Yii::app()->db->createCommand()
//            ->select('department_name')
//            ->from('department')
//            ->where('school_id=:sid', array(':sid'=>$user->school->school_id))
//            ->queryAll();

        //$psql = "Select * from post where text LIKE '%".$query."%' OR sub_text LIKE '%".$query."%'";
        $gsql = "SELECT * FROM `group` g WHERE g.group_name LIKE '%" . $query."%'";


        //specific queries
        $piyd = Yii::app()->db->createCommand()
            ->select('u.user_id, u.firstname, u.lastname, u.school_id, u.department_id, u.picture_file_id, s.school_name, d.department_name')
            ->from('user u')
            ->join('department d','u.department_id = d.department_id')
            ->join('school s','u.school_id = s.school_id')
            ->where('u.school_id=:sid and u.user_type=:type and u.department_id = :did', array(':sid'=>$user->school_id, ':type'=>"p", ':did'=>$user->department_id))
            ->limit(30)
            ->queryAll();
        $piys = Yii::app()->db->createCommand()
            ->select('u.user_id, u.firstname, u.lastname, u.school_id, u.department_id, u.picture_file_id, s.school_name, d.department_name')
            ->from('user u')
            ->join('department d','u.department_id = d.department_id')
            ->join('school s','u.school_id = s.school_id')
            ->where('u.school_id=:sid and u.user_type=:type', array(':sid'=>$user->school_id, ':type'=>"p"))
            ->limit(30)
            ->queryAll();
        $ciyd = Yii::app()->db->createCommand()
            ->select('course_id, course_name, school_id, department_id, picture_file_id')
            ->from('course')
            ->where('school_id=:sid and department_id = :did', array(':sid'=>$user->school_id, ':did'=>$user->department_id))
            ->limit(30)
            ->queryAll();
        $ciys = Yii::app()->db->createCommand()
            ->select('course_id, course_name, school_id, department_id, picture_file_id')
            ->from('course')
            ->where('school_id=:sid', array(':sid'=>$user->school_id))
            ->limit(30)
            ->queryAll();
        $giys = Yii::app()->db->createCommand()
            ->select('group_id, group_name, picture_file_id')
            ->from('group')
            ->where('school_id=:sid', array(':sid'=>$user->school_id))
            ->limit(30)
            ->queryAll();
        //$schoolContent = School::model()->findAllBySql($ssql);
        $groupContent = Group::model()->findAllBySQL($gsql);

        if($query == "piyd")
        {   //professors in your department
            $data = array
            (
                'success'=> true,
                'query'=>$query,
                'filter'=>$filter,
                'users'=>$piyd
            );
        }
        else if($query == "piys")
        {   //professors in your school
            $data = array
            (
                'success'=> true,
                'query'=>$query,
                'filter'=>$filter,
                'users'=>$piys
            );
        }
        else if($query == "ciyd")
        {   //courses in your department
            $data = array
            (
                'success'=> true,
                'query'=>$query,
                'filter'=>$filter,
                'courses'=>$ciyd
            );
        }
        else if($query == "ciys")
        {   //courses in your school
            $data = array
            (
                'success'=> true,
                'query'=>$query,
                'filter'=>$filter,
                'courses'=>$ciys
            );
        }
        else if($query == "giys")
        {   //clubs(groups) in your school
            $data = array
            (
                'success'=> true,
                'query'=>$query,
                'filter'=>$filter,
                'groups'=>$giys
            );
        }
        //else if ($query == "sys" || $query != null)
        else
        {  //return all results, if we don't get a filter
            $data = array
            (
                'success'=> true,
                'query'=>$query,
                'filter'=>$filter,
                'users'=>$usql,
                'courses'=>$courses,
                'departments'=>$departments,
                'clubs'=>$groupContent,
                'students'=>$students,
                'professors'=>$professors,
                'schools'=>$schools,
                'majors'=>$majors,
                'allDepartments'=>$departments //as opposed to 'departments' from dsql which takes query
            );
        }
        echo CJSON::encode($data);
        Yii::app()->end();

//        $this->renderPartial('search', $data, false, true);
//        $this->renderJSON($data);
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