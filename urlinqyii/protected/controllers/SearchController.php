<?php
class SearchController extends Controller
{
    //public function actionSearch()
    public function actionView(){


        $user = $this->get_current_user();
        if(!$user){
            $this->redirect(Yii::app()->getBaseUrl(true) . '/');
        }

        if (isset ($_GET["q"])){
            $q = Yii::app()->request->getQuery('q');
        }else{
            $q = '';
        }

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


        $user = $this->get_current_user($_GET);
        if(!$user){
            $data = array('success'=>false,'error_id'=>2, 'error_msg'=>'user not authenticated');
            $this->renderJSON($data);
            return;
        }


        $university_id = $user->university_id;

        $query = urldecode($_GET['q']);

        $results = array();

        $users = User::model()->findAllBySql("SELECT * FROM `user` WHERE CONCAT(LOWER(firstname),' ',LOWER(lastname)) LIKE LOWER('%" . $query ."%') AND user.university_id = " . $university_id . " LIMIT 5");

        foreach($users as $user){
            $user = $this->get_model_associations($user, array('pictureFile'));
            $user['origin_type'] = 'user';
            $user['origin_id'] = $user['user_id'];
            $user['origin_name'] = $user['firstname'] . ' ' . $user['lastname'];
            array_push($results, $user);
        }
        //array_push($results, $users);


        $classes = ClassModel::model()->findAllBySql("SELECT * FROM `class` JOIN `course` ON ( course.course_tag LIKE '%" . $query ."%') WHERE class_name LIKE '%" . $query ."%' AND class.university_id = " . $university_id . " LIMIT 5");

        foreach($classes as $class){
            $class = $this->get_model_associations($class, array('pictureFile', 'course'));
            $class['origin_type'] = 'class';
            $class['origin_name'] = $class['course']['course_tag'] . ' - ' . $class['class_name'];
            $class['origin_id'] = $class['class_id'];

            array_push($results, $class);
        }

        $groups = Group::model()->findAllBySql("SELECT * FROM `group` WHERE LOWER(group_name) LIKE LOWER('%" . $query . "%') AND group.university_id = " . $university_id . " LIMIT 5");

        foreach($groups as $group){
            $group = $this->get_model_associations($group, array('pictureFile'));
            $group['origin_type'] = 'club';
            $group['origin_name'] = $group['group_name'];
            $group['origin_id'] = $group['group_id'];

            array_push($results, $group);
        }


        $courses = Course::model()->findAllBySql("SELECT * FROM `course` WHERE course_name LIKE '%" . $query ."%' OR course_tag LIKE '%" . $query ."%' AND course.university_id = " . $university_id . " LIMIT 5");

        foreach($courses as $course){
            $course = $this->get_model_associations($course, array('pictureFile'));
            $course['origin_type'] = 'course';
            $course['origin_name'] = $course['course_name'];
            $course['origin_id'] = $course['course_id'];

            array_push($results, $course);
        }


        //array_push($results, $classes);

        $schools = School::model()->findAllBySql("SELECT * FROM `school` WHERE school_name LIKE '%" . $query ."%' AND school.university_id = " . $university_id . " LIMIT 5");

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







    public function actionUsers(){
        if(!isset($_GET['q'])){
            $data = array('success'=>false,'error_id'=>1, 'error_msg'=>'q not set');
            $this->renderJSON($data);
            return;
        }

        $user = $this->get_current_user($_GET);
        if(!$user){
            $data = array('success'=>false,'error_id'=>1, 'error_msg'=>'user not authenticated');
            $this->renderJSON($data);
            return;
        }

        $university_id = $user->university_id;

        $query = $_GET['q'];

        $results = array();

        $users = User::model()->findAllBySql("SELECT * FROM `user` WHERE CONCAT(firstname,' ',lastname) LIKE '%" . $query ."%' AND user.university_id = " . $university_id . "");

        foreach($users as $user){
            $user = $this->get_model_associations($user, array('pictureFile'));
            $user['origin_type'] = 'user';
            $user['origin_name'] = $user['firstname'] . ' ' . $user['lastname'];
            array_push($results, $user);
        }


        $data = array('success'=>true,'users'=>$users);
        $this->renderJSON($data);
        return;
    }






    public function actionCourses(){
        if(!isset($_GET['q'])){
            $data = array('success'=>false,'error_id'=>1, 'error_msg'=>'q not set');
            $this->renderJSON($data);
            return;
        }


        //Make sure user is logged in
        $user = $this->get_current_user($_GET);
        if(!$user){
            $data = array('success'=>false,'error_id'=>2, 'error_msg'=>'user is not authenticated');
            $this->renderJSON($data);
            return;
        }


        $query = $_GET['q'];

        $results = array();


        $courses = Course::model()->findAllBySql("SELECT * FROM `course` WHERE course_name LIKE '%" . $query ."%' OR course_tag LIKE '%" . $query ."%' AND course.university_id = " . $university_id . " LIMIT 20");

        foreach($courses as $course){
            $course = $this->get_model_associations($course, array('pictureFile'=>array(),'classes'=>array('professor')));
            $course['origin_type'] = 'course';
            $course['origin_name'] = $course['course_name'];
            $course['origin_id'] = $course['course_id'];

            array_push($results, $course);
        }



        $data = array('success'=>true,'results'=>$results);
        $this->renderJSON($data);
        return;
    }



    public function actionJson()
    { //We want to render JSON to the front-end so search.js can decode it


        $user = $this->get_current_user($_GET);
        if(!$user){
            $data = array('success'=>false, 'error_msg'=>'Using not authenticated');
            $this->renderJSON($data);
            return;
        }


        $university_id = $user->university_id;


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
            ->andWhere("u.university_id = " . $university_id)
            ->limit(30)
            ->queryAll();
//        $students = Yii::app()->db->createCommand()
//            ->select('u.firstname, u.lastname, u.user_id, u.user_type, d.department_name, d.department_id, u.picture_file_id')
//            ->from('user u')
//            ->join('department d','u.department_id = d.department_id')
//            ->join('file f','f.file_id = u.picture_file_id')
//            ->where(array('like', "concat(firstname, ' ', lastname)", '%'.$query.'%'))
//            ->andWhere("u.user_type = 's'")
//            ->limit(30)
//            ->queryAll();

        $students = User::model()->findAllBySql("SELECT * FROM `user` WHERE (CONCAT(firstname, ' ', lastname) LIKE '%" . $query . "%' OR user_email LIKE '%" . $query . "%') AND user_type = 's' AND user.university_id = " . $university_id . " LIMIT 30");
        for($i = 0; $i < count($students); $i++){
            //CHeck if u are following this user


            $students[$i] = $this->get_model_associations($students[$i], array('pictureFile'));


            $user_connection = UserConnection::model()->find('from_user_id=:from_user_id and to_user_id=:to_user_id', array(':from_user_id'=>$user->user_id, ':to_user_id'=>$students[$i]['user_id']));
            if($user_connection){
                $students[$i]['following'] = true;
            }else{
                $students[$i]['following'] = false;
            }
            $students[$i]['own_profile'] = $students[$i]['user_id'] == $this->get_current_user_id();
        }

        $faculty = User::model()->findAllBySql("SELECT * FROM `user` WHERE (CONCAT(firstname, ' ', lastname) LIKE '%" . $query . "%' OR user_email LIKE '%" . $query . "%') AND (user_type = 'p' OR user_type = 'a') AND user.university_id = " . $university_id . " LIMIT 30");
        for($i = 0; $i < count($faculty); $i++){
            //CHeck if u are following this user
            $faculty[$i] = $this->get_model_associations($faculty[$i], array('pictureFile'));

            $user_connection = UserConnection::model()->find('from_user_id=:from_user_id and to_user_id=:to_user_id', array(':from_user_id'=>$user->user_id, ':to_user_id'=>$faculty[$i]['user_id']));
            if($user_connection){
                $faculty[$i]['following'] = true;
            }else{
                $faculty[$i]['following'] = false;
            }
            $faculty[$i]['own_profile'] = $faculty[$i]['user_id'] == $this->get_current_user_id();
        }


        $courses = Course::model()->findAllBySql("SELECT * FROM `course` WHERE course_name LIKE '%" . $query . "%' OR course_tag LIKE '%" . $query . "%' AND course.university_id = " . $university_id . " LIMIT 30");
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
            ->andWhere("d.university_id = " . $university_id)
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


        $departments = Department::model()->findAllBySql("SELECT * FROM `department` WHERE department.department_name LIKE '%" .$query. "%' AND department.university_id = " . $university_id . " LIMIT 30");
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
        $gsql = "SELECT * FROM `group` g WHERE g.group_name LIKE '%" . $query."%' AND g.privacy = 0;";


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
        $groups = Group::model()->findAllBySql("SELECT * FROM `group` WHERE LOWER(group_name) LIKE LOWER('%" . $query . "%') AND group.university_id = " . $university_id . " LIMIT 20");
        foreach($groups as $i=>$group){
            $groups[$i] = $this->model_to_array($group);
            $groups[$i]['num_members'] = sizeof($group->users);
            $groups[$i]['num_events'] = sizeof($group->upcoming_events);
            $groups[$i]['picture_url'] = $group->coverFile->file_url;
            $groups[$i]['is_member'] = GroupUser::model()->exists('group_id=:gid and user_id=:uid',array(':gid'=>$group->group_id,':uid'=>$user->user_id));
        }

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
                'clubs'=>$groups,
                'students'=>$students,
                'professors'=>$faculty,
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