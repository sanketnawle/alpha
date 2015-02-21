<?php

class EventController extends Controller
{
    function stt($obj) {
        return strtotime($obj);
    }


    function get_user_event_color($user, $event){
        $origin_type = '';
        try{
            $origin_type = $event['origin_type'];
        }catch(Exception $e){
            $origin_type = $event->origin_type;
        }


        $origin_id = '';
        try{
            $origin_id = $event['origin_id'];
        }catch(Exception $e){
            $origin_id = $event->origin_id;
        }


        if($origin_type == 'class'){


            $class_user = ClassUser::model()->find('user_id=:user_id and class_id=:class_id',array(':user_id'=>$user->user_id,':class_id'=>$event['origin_id']));

            if($class_user){
                $color = Color::model()->find('color_id=:id',array(':id'=>$class_user->color_id));
                return $color;
            }else{
                $class = ClassModel::model()->find('class_id=:id', array(':id'=>$origin_id));
                if($class){
                    if($user->user_id == $class->professor_id){
                        $color = Color::model()->find('color_id=:id',array(':id'=>$class->color_id));
                        return $color;
                    }else{
                        $color = Color::model()->find('color_id=:id',array(':id'=>3));
                        return $color;
                    }
                }else{
                    $color = Color::model()->find('color_id=:id',array(':id'=>3));
                    return $color;
                }


            }

        }else if($origin_type == 'club' || $origin_type == 'group'){
            $group_user = GroupUser::model()->find('user_id=:user_id and group_id=:group_id',array(':user_id'=>$user->user_id,':group_id'=>$event['origin_id']));
            if($group_user){
                $color = Color::model()->find('color_id=:id',array(':id'=>$group_user->color_id));
                return $color;
            }else{
                $color = Color::model()->find('color_id=:id',array(':id'=>3));
                return $color;
            }

        }else {
            $color = Color::model()->find('color_id=:id',array(':id'=>3));
            return $color;
        }

    }

    public function actionSearchEvents(){
        if(!isset($_GET['search_text'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'date is not set');
            $this->renderJSON($data);
            return;
        }
       
        $user = $this->get_current_user($_GET);

        $text = $_GET['search_text'];
    
        //Get the events that this user is an event_user of
        $events_attending = Yii::app()->db->createCommand("SELECT * FROM `event` JOIN `event_user` ON (event.event_id = event_user.event_id) WHERE event_user.user_id = " . $user->user_id . " AND (event.title LIKE '%" . $text . "%' OR description LIKE '%" . $text . "%')")->queryAll();
        //Get the events that this
        $events = Yii::app()->db->createCommand("SELECT * FROM `event` WHERE event.user_id = " . $user->user_id . " AND (title LIKE '%" . $text . "%' OR description LIKE '%" . $text . "%')")->queryAll();

        $all_events = $this->add_event_data(array_merge($events,$events_attending), $user);


        $data = array('success'=>true,'events'=>$all_events);

        $this->renderJSON($data);
        return;
    }

    public function actionGetEvents(){
        if(!isset($_GET['date'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'date is not set');
            $this->renderJSON($data);
            return;
        }


        $user = $this->get_current_user($_GET);
//        $date = '2014-11-12';
        $date = $_GET['date'];
        //user_id=:user_id AND  //':user_id'=>1,
        //$events = Event::model()->findAll('start_date<=:date and end_date>=:date and user_id=:user_id',array(':date'=>$date,':user_id'=>7));
        //$events = $user->get_all_events();
//        $events = Event::model()->findAllBySql('SELECT *
//                                                FROM `event`
//                                                LEFT OUTER JOIN `event_user`
//                                                ON event.event_id = event_user.event_id
//                                                WHERE event_user.user_id = 7 OR event.user_id = 7');

        //Get the events that this user is an event_user of
        $events_attending = Yii::app()->db->createCommand("SELECT * FROM `event` JOIN `event_user` ON (event.event_id = event_user.event_id) WHERE event_user.user_id = " . $user->user_id . " AND start_date = '" . $date . "'")->queryAll();
        //Get the events that this
        $events = Yii::app()->db->createCommand("SELECT * FROM `event` WHERE event.user_id = " . $user->user_id . " AND start_date = '" . $date . "'")->queryAll();

        $all_events = $this->add_event_data(array_merge($events,$events_attending), $user);


        $data = array('success'=>true,'events'=>$all_events);

        $this->renderJSON($data);
        return;
    }

    function add_event_data($events, $user){
        for($i=0;$i<count($events);$i++){
            $events[$i]['color'] = $this->get_user_event_color($user,$events[$i]);


            //Get the origin data
            if($events[$i]['origin_type'] == 'class'){
                $events[$i]['origin'] = $this->model_to_array(ClassModel::model()->find('class_id=:id',array(':id'=>$events[$i]['origin_id'])));
                //reassign the name to make it easier to get in the handlebars
                $events[$i]['origin']['name'] = $events[$i]['origin']['class_name'];
            }else if($events[$i]['origin_type'] == 'department'){
                $events[$i]['origin'] = $this->model_to_array(Department::model()->find('department_id=:id',array(':id'=>$events[$i]['origin_id'])));
                //reassign the name to make it easier to get in the handlebars
                $events[$i]['origin']['name'] = $events[$i]['origin']['department_name'];
            }else if($events[$i]['origin_type'] == 'school'){
                $events[$i]['origin'] = $this->model_to_array(School::model()->find('school_id=:id',array(':id'=>$events[$i]['origin_id'])));
                //reassign the name to make it easier to get in the handlebars
                $events[$i]['origin']['name'] = $events[$i]['origin']['school_name'];

            }else if($events[$i]['origin_type'] == 'club' || $events[$i]['origin_type'] == 'group'){
                $events[$i]['origin'] = $this->model_to_array(Group::model()->find('group_id=:id',array(':id'=>$events[$i]['origin_id'])));
                //reassign the name to make it easier to get in the handlebars
                $events[$i]['origin']['name'] = $events[$i]['origin']['group_name'];
            }
        }

        return $events;
    }



    public function actionGetMonthEvents(){
        $user = $this->get_current_user($_GET);


        if(!$user){
            $data = array('success'=>false, 'error_msg'=>'user not authenticated');

            $this->renderJSON($data);
            return;
        }

//        $date = '2014-11-12';
        $date = $_GET['date'];
        //user_id=:user_id AND  //':user_id'=>1,
        //$events = Event::model()->findAll('start_date<=:date and end_date>=:date and user_id=:user_id',array(':date'=>$date,':user_id'=>7));
        //$events = $user->get_all_events();
//        $events = Event::model()->findAllBySql('SELECT *
//                                                FROM `event`
//                                                LEFT OUTER JOIN `event_user`
//                                                ON event.event_id = event_user.event_id
//                                                WHERE event_user.user_id = 7 OR event.user_id = 7');

        //Get the events that this user is an event_user of
        $events_attending = Yii::app()->db->createCommand('SELECT * FROM `event` JOIN `event_user` ON (event.event_id = event_user.event_id) WHERE event_user.user_id = ' . $user->user_id .' AND MONTH(`end_date`) = MONTH("' . $date . '")')->queryAll();
        //Get the events that this
        $events = Yii::app()->db->createCommand('SELECT * FROM `event` WHERE event.user_id = ' . $user->user_id . ' AND MONTH(`end_date`) = MONTH("' . $date . '")')->queryAll();

        $events = $this->add_event_data($events, $user);




        $data = array('success'=>true,'events'=>array_merge($events,$events_attending));

        $this->renderJSON($data);
        return;

    }




    public function actionGetWeekEvents(){



        $user = $this->get_current_user($_GET);



        if(!$user){
            $data = array('success'=>false, 'error_msg'=>'user not authenticated');

            $this->renderJSON($data);
            return;
        }

//        $date = '2014-11-12';
        $date = $_GET['date'];
        //user_id=:user_id AND  //':user_id'=>1,
        //$events = Event::model()->findAll('start_date<=:date and end_date>=:date and user_id=:user_id',array(':date'=>$date,':user_id'=>7));
        //$events = $user->get_all_events();
//        $events = Event::model()->findAllBySql('SELECT *
//                                                FROM `event`
//                                                LEFT OUTER JOIN `event_user`
//                                                ON event.event_id = event_user.event_id
//                                                WHERE event_user.user_id = 7 OR event.user_id = 7');

        //Get the events that this user is an event_user of
        $events_attending = Yii::app()->db->createCommand('SELECT * FROM `event` JOIN `event_user` ON (event.event_id = event_user.event_id) WHERE event_user.user_id = ' . $user->user_id . ' AND WEEK(`end_date`) = WEEK("' . $date . '")')->queryAll();
        //Get the events that this
        $events = Yii::app()->db->createCommand('SELECT * FROM `event` WHERE event.user_id = ' . $user->user_id . ' AND WEEK(`end_date`) = WEEK("' . $date . '")')->queryAll();

        $data = array('success'=>true,'events'=>$this->add_event_data(array_merge($events,$events_attending),$user));

        $this->renderJSON($data);
        return;

    }

    public function actionGetClassSyllabus() {
        if (!isset($_GET['class_id'])) {
            $data = array('success'=>false, 'error_id'=>1, 'error_msg'=>'all data is not set');
            $this->renderJSON($data);
            return;
        }
        $user = $this->get_current_user($_GET);
        if (!$user) {
            $data = array('success'=>false, 'error_id'=>2, 'error_msg'=>'not a valid user');
            $this->renderJSON($data);
            return;
        }

        $class = ClassModel::model()->find('class_id=:id', array(':id'=>$_GET['class_id']));

        if (!$class) {
            $data = array('success'=>false, 'error_id'=>3, 'error_msg'=>'not a valid class');
            $this->renderJSON($data);
            return;
        }

        $class_id = $_GET['class_id'];
        $event_type = "Syllabus";
        $origin_type = "class";

        $events = Event::model()->findAllBySql("SELECT * FROM `event` WHERE event_type='Syllabus' AND origin_type = 'class' AND origin_id = $class_id");
        
        $data = array('success'=>true, 'events'=>$events);
        $this->renderJSON($data);
        return;
    }

    public function actionSearchEventsTitle() {
        if (!isset($_GET['q'])) {
            $data = array('success'=>false, 'error_id'=>1, 'error_msg'=>'required data not set');
            $this->renderJSON($data);
            return;
        }

        $user = $this->get_current_user($_GET);
        if (!$user) {
            $data = array('success'=>false, 'error_id'=>2, 'error_msg'=>'not a valid user');
            $this->renderJSON($data);
            return;
        }

        $query = $_GET['q'];
        $query_lowercased = strtolower($query);
        $user_id = $user->user_id;

        $events = Event::model()->findAllBySql("SELECT * FROM `event` WHERE user_id = $user_id AND LOWER(title) LIKE LOWER('%" . $query . "%') LIMIT 5");

        $results = $this->add_event_data($this->models_to_array($events), $user);

        $data = array('success'=>true, 'results'=>$results);

        $this->renderJSON($data);
        return;

    }

    public function actionAttendees(){
        //$user = $this->get_current_user();
        $event_id = $_GET['id'];
        //$date = $_GET['date'];
        //user_id=:user_id AND  //':user_id'=>1,

        $event = Event::model()->find('event_id=:event_id',array('event_id'=>$event_id));

        if ($event) {
            $attendees = $event->attendees;
            foreach($attendees as $i=>$attendee){
                $attendees[$i] = $this->get_model_associations($attendee, array('pictureFile'));

            }

            $data = array('success'=>true,'attendees'=>$attendees);

            $this->renderJSON($data);
            return;

        } else {
            $data = array('success'=>false,'error_id'=>1, 'error_msg'=>'not a valid event');

            $this->renderJSON($data);
            return;
        }

        }



    public function actionGetPlannerEvents(){


        if(!isset($_GET['origin_type'])){
            $data = array('success'=>false, 'error_msg'=>'Origin type not set');
            $this->renderJSON($data);
            return;
        }

        $origin_type = $_GET['origin_type'];
        $origin_id = '';


        if(isset($_GET['origin_id'])){
            $origin_id = $_GET['origin_id'];
        }




        //$user_id = $_GET['user_id'];
        $user = $this->get_current_user($_GET);


        if(!$user){
            $data = array('success'=>false, 'error_msg'=>'User not authenticated');

            $this->renderJSON($data);
            return;
        }



//        $user = User::model()->findBySql('SELECT * FROM `user` WHERE user_id=.'$user_id');

//        $events = Event::model()->findAll('user_id=:user_id',array(':user_id'=>$user->user_id));


//        $sql_str = '';
//        if (strpos($filter, 'Week') !== FALSE){
//            $sql_str = "SELECT * FROM group_event WHERE group_id = '$group_id' AND yearweek(`start_date`) = yearweek(curdate())";
//        }elseif(strpos($filter, 'Month') !== FALSE){
//            $sql_str = "SELECT * FROM group_event WHERE group_id = '$group_id' AND MONTH(`start_date`) = MONTH(curdate())";
//        }elseif(strpos($filter, 'Semester') !== FALSE){
//            $sql_str = "SELECT * FROM group_event WHERE group_id = '$group_id' AND YEAR(`start_date`) = YEAR(curdate())";
//        }



        //get current datetime
//        $date = date("Y-m-d H:i:s", time());
//        $datetime = new DateTime($date);
//        $datetime->modify('-1 day');
//        $date = $datetime->format('Y-m-d H:i:s');
//        $date_key = $datetime->format('Y-m-d');

//        $event_count = 0;
//
//        //Get events that were due yesterday
//        $date = date("Y-m-d H:i:s", time());
//        $datetime = new DateTime($date);
//        $datetime->modify('-1 day');
//        $yesterdays_date = $datetime->format('Y-m-d');
//
//
//        $sql = "SELECT * FROM event WHERE user_id = '" . $user->user_id ."' AND end_date = '" . $yesterdays_date . "'"; // AND YEAR(`start_date`) = YEAR(curdate())
//        $past_due_events = Event::model()->findAllBySql($sql);
//        $event_count += count($past_due_events);
//
//        //Get events that are due today
//
//        $datetime = new DateTime($date);
//        $todays_date = $datetime->format('Y-m-d');
//
//        $sql = "SELECT * FROM event WHERE user_id = '" . $user->user_id ."' AND end_date = '" . $todays_date . "'"; // AND YEAR(`start_date`) = YEAR(curdate())
//        $todays_events = Event::model()->findAllBySql($sql);
//        $event_count += count($todays_events);
//
//
//        //Get events that are due tomorrow
//
//        $datetime = new DateTime($date);
//        $datetime->modify('+1 day');
//        $tomorrows_date = $datetime->format('Y-m-d');
//
//        $sql = "SELECT * FROM event WHERE user_id = '" . $user->user_id ."' AND end_date = '" . $tomorrows_date . "'"; // AND YEAR(`start_date`) = YEAR(curdate())
//        $tomorrows_events = Event::model()->findAllBySql($sql);
//        $event_count += count($tomorrows_events);
//
//        $club = Group::model()->find('group_id=:group_id',array(':group_id'=>1));
//        $data = array('success'=>true,'past_due_events'=>$past_due_events,'todays_events'=>$todays_events,'tomorrows_events'=>$tomorrows_events,'event_count'=>$event_count);
//        //$data = array('success'=>true,'event'=>$this->get_model_associations($club,array('pictureFile')));
//
//
//        //Show 7 days after tomorrow
//
//        $this->renderJSON($data);
//        return;




//        if($origin_type == 'club'){
//            $origin_type = 'group';
//        }







        try{


            $event_count = 0;

            //Get events that were due yesterday
            $date = date("Y-m-d H:i:s", time());
            $datetime = new DateTime($date);
            $datetime->modify('-1 day');
            $start_date= $datetime->format('Y-m-d');
            //$datetime->modify('+4 day');
            //$end_date= $datetime->format('Y-m-d');



            $events = array();

            if($origin_type != 'user'){

                //Get the events that this user is an event_user of
                $events = Yii::app()->db->createCommand("SELECT * FROM event e where (e.user_id=".$user->user_id." OR exists (select * from event_user eu where eu.user_id=" . $user->user_id . " and eu.event_id=e.event_id))  AND e.end_date >= '" . $start_date . "' AND e.origin_type = '" . $origin_type . "' AND e.origin_id = " . $origin_id." and e.complete=0 order by start_date,start_time limit 8")->queryAll();

                //Get the events that this
                //$events = Event::model()->findAll('end_date>=:start_date and end_date<=:end_date and user_id=:user_id and complete=:complete and origin_type=:origin_type and origin_id=:origin_id',array(':start_date'=>$start_date,':end_date'=>$end_date,':user_id'=>$user->user_id, ':complete'=>0, ':origin_type'=>$origin_type, ':origin_id'=>$origin_id));


               // $events = Yii::app()->db->createCommand("SELECT * FROM `event` WHERE event.user_id = " . $user->user_id . " AND end_date >= '" . $start_date . "' AND origin_type = '" . $origin_type . "' AND origin_id = " . $origin_id)->queryAll();
               // $events = array_slice(array_merge($events,$events_attending),0,8);
                $events = $this->add_event_data($events, $user);

            }else{
                //$events = Event::model()->findAllBySql('select * from event e where e.end_date>=:start_date and (e.user_id=:user_id or exists (select * from event_user eu where eu.user_id=:user_id and eu.event_id=e.event_id)) and e.complete=:complete limit 8',array(':start_date'=>$start_date,':user_id'=>$user->user_id, ':complete'=>0));
                $events = Yii::app()->db->createCommand("select * from event e where e.end_date>='" . $start_date . "' and (e.user_id=" . $user->user_id . " or exists (select * from event_user eu where eu.user_id=" . $user->user_id . " and eu.event_id=e.event_id)) and e.complete=0 order by start_date,start_time limit 8")->queryAll();
                $events = $this->add_event_data($events, $user);
            }



            $data = array('success'=>true,'events'=>$events);

            $this->renderJSON($data);
            return;


        }catch(Exception $e){
            $data = array('success'=>false, 'error_msg'=>$e->getMessage());

            $this->renderJSON($data);
            return;
        }








        //Or get all events from yesterday till tomorrow and have front end sort it



    }


    public function actionDelete(){
        if(!$this->authenticated()){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'Not authenticated');
            $this->renderJSON($data);
            return;
        }

        if(!isset($_POST['event_id'])){
            $data = array('success'=>false,'error_id'=>2,'error_msg'=>'All data is not set');
            $this->renderJSON($data);
            return;
        }

        $user = $this->get_current_user($_POST);

        $event_id = $_POST['event_id'];
        $event = Event::model()->find('event_id=:id', array(':id'=>$event_id));

        if(!$event){
            $data = array('success'=>false,'error_id'=>3,'error_msg'=>'Event doesnt exist');
            $this->renderJSON($data);
            return;
        }
        //Check if the current user is either the creator
        //Of this event or he is attending it and associated through group_user table
        if($user->user_id == $event->user_id){
            if($event->delete()){
                $this->delete_associations($event_id);


                $data = array('success'=>true);
                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false,'error_id'=>6,'error_msg'=>'Error destroying event');
                $this->renderJSON($data);
                return;
            }
        }elseif($event_user = $event->user_is_attending($user->user_id)){
            if($event_user->delete()){
                $this->delete_associations($event_id);

                $data = array('success'=>true);
                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false,'error_id'=>6,'error_msg'=>'Error destroying event_user association');
                $this->renderJSON($data);
                return;
            }

        }else{
            $data = array('success'=>false,'error_id'=>5,'error_msg'=>'User not authorized to touch this event.');
            $this->renderJSON($data);
            return;
        }




    }



    //Takes in an event id and deletes
    //notifications/posts associated with this event
    function delete_associations($event_id){
        $notifications = Notification::model()->findAll('origin_type="event" and origin_id=:origin_id', array(':origin_id'=>$event_id));



        foreach($notifications as $notification){
            $notification->delete();
        }


        $post_events = PostEvent::model()->findAll('event_id=:event_id', array(':event_id'=>$event_id));
        foreach($post_events as $post_event){
            $post = Post::model()->find('post_id=:post_id', array(':post_id'=>$post_event->post_id));
            if($post){
                //This will delete post_events associated
                //as well since they are cascade foreign keys
                $post->delete();
            }else{
                $post_event->delete();
            }
        }

    }



    public function actionGetSuggestedEvents(){
        $events = Event::model()->findAll(array('limit'=>40) );

        $data = array('success'=>true,'events'=>$events);
        $this->renderJSON($data);
        return;
    }

    //Error ids
    // 1 - All data not set
    // 2 - error creating todo
    public function actionCreateTodo()
    {

        if(!isset($_POST['todo_name']) || !isset($_POST['todo_date']) || !isset($_POST['todo_time']) || !isset($_POST['origin']) || !isset($_POST['origin_id'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'All data is not set');
            $this->renderJSON($data);
            return;
        }



        try {



            $user = $this->get_current_user($_POST);

            if (!$user) {
                $data = array('success'=>false,'error_id'=>1,'error_msg'=>'not a valid user');
                $this->renderJSON($data);
                return;
            }

            $todo_name = $_POST['todo_name'];
            $todo_date = $_POST['todo_date'];
            $todo_time = $_POST['todo_time'];
            $todo_origin = $_POST['origin'];
            $todo_origin_id = $_POST['origin_id'];

            $event = new Event;
            $event->title = $todo_name;
            $event->event_type = 'todo';
            $event->user_id = $user->user_id;

            $event->origin_type = $todo_origin;
            $event->origin_id = $todo_origin_id;
            $event->start_date = $todo_date;
            $event->start_time = $todo_time;
            $event->end_date = $todo_date;
            $event->end_time = $todo_time;
            $event->all_day = false;
            $event->save(false);

            if($event){



                if($event->origin_type == 'club' || $event->origin_type == 'group'){
                    $group = Group::model()->find('group_id=:id', array(':id'=>$event->origin_id));
                    $has_admin = GroupUser::model()->exists('group_id=:group_id and is_admin=true',array(':group_id'=>$group->group_id));
                    if($group){

                        $group_user = GroupUser::model()->find('user_id=:user_id and group_id=:group_id', array(':user_id'=>$user->user_id, ':group_id'=>$group->group_id));
                        if($group_user && $group_user->is_admin || !$has_admin){
                            foreach($group->members as $member){
                                if($member->user_id != $user->user_id){
                                    include_once 'color/color.php';
                                    $event_user = new EventUser;
                                    $event_user->user_id = $member->user_id;
                                    $event_user->event_id = $event->event_id;
                                    $event_user->color_id = get_random_color();
                                    $event_user->save(false);
                                }
                            }
                        }
                    }
                }else if($event->origin_type == 'class'){
                    $class = ClassModel::model()->find('class_id=:id', array(':id'=>$event->origin_id));
                    $has_admin_or_prof=ClassUser::model()->exists('class_id=:class_id and is_admin=true',array(':class_id'=>$class->class_id));
                    if($class->professor){
                        $has_admin_or_prof=$has_admin_or_prof || $class->professor->status === "verified";
                    }
                    if($class){

                        $class_user = ClassUser::model()->find('user_id=:user_id and class_id=:class_id', array(':user_id'=>$user->user_id, ':class_id'=>$class->class_id));
                        if(($class_user && $class_user->is_admin) || $class->professor_id == $user->user_id || !$has_admin_or_prof){

                            foreach($class->students as $member){
                                if($member->user_id != $user->user_id){
                                    include_once 'color/color.php';
                                    $event_user = new EventUser;
                                    $event_user->user_id = $member->user_id;
                                    $event_user->event_id = $event->event_id;
                                    $event_user->color_id = get_random_color();
                                    $event_user->save(false);
                                }
                            }
                        }
                    }
                }



                $data = array('success'=>true,'event'=>$event);
                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false,'error_id'=>2,'error_msg'=>'Error creating todo');
                $this->renderJSON($data);
                return;
            }
        }catch(Exception $e){
            $data = array('success'=>false,'error_id'=>3,'error_msg'=>$e->getMessage());
            $this->renderJSON($data);
            return;
        }
    }



    //Error ids
    // 1 - All data not set
    // 2 - error creating todo
    public function actionCreate()
    {
//        $data = array('success'=>true);
//        $this->renderJSON($_POST);
//        return;

//                event_name: event_name,
//                origin_type: event_origin_type,
//                origin_id: event_origin_id,
//                event_type: event_category,
//                title: event_name,
//                description: event_description,
//                start_time: event_start_time,
//                end_time: event_end_time,
//                start_date: event_start_date,
//                end_date: event_end_date,
//                location: event_location,
//                event_todo: event_todo,
//                all_day: event_all_day

        $user = $this->get_current_user($_POST);

        if(!$user){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'user not lgged in');
            $this->renderJSON($data);
            return;
        }



        if(!isset($_POST['event']['event_type']) || !isset($_POST['event']['event_name']) || !isset($_POST['event']['event_todo']) || !isset($_POST['event']['origin_type']) || !isset($_POST['event']['origin_id']) || !isset($_POST['event']['title']) || !isset($_POST['event']['description'])
        || !isset($_POST['event']['start_time']) || !isset($_POST['event']['end_time']) || !isset($_POST['event']['start_date']) || !isset($_POST['event']['end_date']) || !isset($_POST['event']['location']) || !isset($_POST['event']['all_day'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'All data is not set');
            $this->renderJSON($data);
            return;
        }

        $event_data = $_POST['event'];


        try {


            $event = new Event;
            $event->title = $event_data['event_name'];
            $event->description = $event_data['description'];
            $event->event_type = $event_data['event_type'];
            $event->user_id = $user->user_id;
            $event->origin_type = $event_data['origin_type'];
            $event->origin_id = $event_data['origin_id'];
            $event->start_date = $event_data['start_date'];
            $event->end_date = $event_data['end_date'];
            $event->start_time = $event_data['start_time'];
            $event->end_time = $event_data['end_time'];
            $event->location = $event_data['location'];

            $all_day = 0;
            if($event_data['all_day'] === true || $event_data['all_day'] == 'true'){
                $all_day = 1;
            }

            $event->all_day = $all_day;

            $event->save(false);


            if($event){
                //If this event was successfully created, check if there
                //were any invitations sent out for this event
                if(isset($_POST['event']['invites'])){
                    include_once "invite/invite.php";
                    include_once "notification/notification.php";
                    //Loop thru the invites and send an invite to each user
                    foreach($_POST['event']['invites'] as $invite_user_id){
                        send_invite($event->user_id,$invite_user_id, $event->event_id, 'event');
                        send_notification('event', $invite_user_id, $event->user_id, $event->event_id, 'event');
                    }
                }

                $event = $this->model_to_array($event);
                $event['color'] = $this->get_user_event_color($user,$event);

                $data = array('success'=>true,'event'=>$event);
                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false,'error_id'=>2,'error_msg'=>'Error creating event ');
                $this->renderJSON($data);
                return;
            }
        }catch(Exception $e){
            $data = array('success'=>false,'error_id'=>3,'error_msg'=>$e->getMessage());
            $this->renderJSON($data);
            return;
        }
    }





    //Error ids
    // 1 - All data not set
    // 2 - error creating todo
    public function actionUpdate() {
//        $data = array('success'=>true);
//        $this->renderJSON($_POST);
//        return;

//        var post_data = {
//        event:{
//            event_name: 'Test event',
//                origin_type:' club',
//                origin_id: 1,
//                title: 'Test Event',
//                description: 'This is my test event description',
//                start_time: '10:10:10',
//                end_time: '11:11:11',
//                start_date: '2014-12-01',
//                end_date: '2014-12-01',
//                location: 'Manhattan'
//            }
//        };



        $user = $this->get_current_user($_POST);
        if(!$user){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'noit logged in');
            $this->renderJSON($data);
            return;
        }


        if(!isset($_POST['event']['event_id']) || !isset($_POST['event']['event_name']) || !isset($_POST['event']['title'])
            || !isset($_POST['event']['start_time']) || !isset($_POST['event']['end_time']) || !isset($_POST['event']['start_date']) || !isset($_POST['event']['end_date'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'All data is not set');
            $this->renderJSON($data);
            return;
        }

        $event_data = $_POST['event'];
        $event_id = $event_data['event_id'];

        $event = Event::model()->find('event_id=:id', array(':id'=>$event_id));


        if($event){
            $event->title = $event_data['event_name'];
            if(isset($event_data['description']))
                $event->description = $event_data['description'];
            if(isset($event_data['event_type']))
                $event->event_type = $event_data['event_type'];
            $event->user_id = $user->user_id;
            if(isset($event_data['origin_type']))
                $event->origin_type = $event_data['origin_type'];
            if(isset($event_data['origin_id']))
                $event->origin_id = $event_data['origin_id'];
            $event->start_date = $event_data['start_date'];
            $event->end_date = $event_data['end_date'];
            $event->start_time = $event_data['start_time'];
            $event->end_time = $event_data['end_time'];
            if(isset($event_data['location']))
                $event->location = $event_data['location'];
            if(isset($event_data['all_day']))
                $event->all_day = $event_data['all_day'];



            if($event->save(false)){
                //If this event was successfully created, check if there
                //were any invitations sent out for this event
                if(isset($_POST['event']['invites'])){
                    include_once "invite/invite.php";
                    include_once "notification/notification.php";
                    //Loop thru the invites and send an invite to each user
                    foreach($_POST['event']['invites'] as $invite_user_id){
                        send_invite($event->user_id,$invite_user_id, $event->event_id, 'event');
                        send_notification('event', $invite_user_id, $event->user_id, $event_id, 'event');
                    }
                }


                $event = $this->model_to_array($event);
                $event['color'] = $this->get_user_event_color($user,$event);


                $data = array('success'=>true,'event'=>$event);
                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false,'error_id'=>2,'error_msg'=>'Error creating event ');
                $this->renderJSON($data);
                return;
            }
        }else {
            $data = array('success'=>false,'error_id'=>3,'error_msg'=>'event doesnt exist');
            $this->renderJSON($data);
            return;
        }

    }


    public function actionAttend(){
        if(!isset($_POST['event_id'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'id not set');
            $this->renderJSON($data);
            return;
        }



        $user = $this->get_current_user($_POST);

        if(!$user){
            $data = array('success'=>false,'error_id'=>2,'error_msg'=>'User doesnt exist');
            $this->renderJSON($data);
            return;
        }

        $event_id = $_POST['event_id'];

        $event = Event::model()->find('event_id=:id', array(':id'=>$event_id));
        if(!$event){
            $data = array('success'=>false,'error_id'=>2,'error_msg'=>'Event doesnt exist');
            $this->renderJSON($data);
            return;
        }

        //Check if this user is already attending
        if($event->user_id == $user->user_id){
            $data = array('success'=>false,'error_id'=>3,'error_msg'=>'User is already attending');
            $this->renderJSON($data);
            return;
        }else{
            //or check if the user is already a user for this event
            $event_user = EventUser::model()->find('event_id=:event_id and user_id=:user_id', array(':event_id'=>$event->event_id, ':user_id'=>$user->user_id));
            if($event_user){
                $data = array('success'=>false,'error_id'=>4,'error_msg'=>'User is already attending');
                $this->renderJSON($data);
                return;
            }
        }


        include_once 'color/color.php';

        $event_user = new EventUser;
        $event_user->event_id = $event->event_id;
        $event_user->user_id = $user->user_id;
        $event_user->color_id = get_random_color();

        if($event_user->save(false)){
            $data = array('success'=>true);
            $this->renderJSON($data);
            return;
        }else{
            $data = array('success'=>false,'error_id'=>5,'error_msg'=>'Error saving user');
            $this->renderJSON($data);
            return;
        }

    }



    public function actionLeave(){
        if(!isset($_POST['event_id'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'id not set');
            $this->renderJSON($data);
            return;
        }



        $user = $this->get_current_user($_POST);

        if(!$user){
            $data = array('success'=>false,'error_id'=>2,'error_msg'=>'User doesnt exist');
            $this->renderJSON($data);
            return;
        }

        $event_id = $_POST['event_id'];

        $event = Event::model()->find('event_id=:id', array(':id'=>$event_id));
        if(!$event){
            $data = array('success'=>false,'error_id'=>2,'error_msg'=>'Event doesnt exist');
            $this->renderJSON($data);
            return;
        }

        //Check if this user is already attending
        if($event->user_id == $user->user_id){
            //Since user is the owner of this event, delete it
            if($event->delete()){
                $data = array('success'=>true);
                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false,'error_id'=>3,'error_msg'=>'Error deleting event');
                $this->renderJSON($data);
                return;
            }
        }else{
            //or check if the user is already a user for this event
            $event_user = EventUser::model()->find('event_id=:event_id and user_id=:user_id', array(':event_id'=>$event->event_id, ':user_id'=>$user->user_id));
            if($event_user){
                if($event_user->delete()){
                    $data = array('success'=>true);
                    $this->renderJSON($data);
                    return;
                }else{
                    $data = array('success'=>false,'error_id'=>4,'error_msg'=>'Error deleting event user');
                    $this->renderJSON($data);
                    return;
                }
            }else{
                $data = array('success'=>false,'error_id'=>4,'error_msg'=>'User is not apart of this event');
                $this->renderJSON($data);
                return;
            }
        }

    }






    public function actionCheck(){
        if(!isset($_POST['event_id'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'id not set');
            $this->renderJSON($data);
            return;
        }



        $event_id = $_POST['event_id'];

        $event = Event::model()->find('event_id=:id', array(':id'=>$event_id));
        if($event){
            $event->complete = true;
            $event->save(false);

            $data = array('success'=>true);
            $this->renderJSON($data);
            return;
        }else{
            $data = array('success'=>false,'error_id'=>2,'error_msg'=>'Event doesnt exist');
            $this->renderJSON($data);
            return;
        }
    }

    public function actionUncheck(){
        if(!isset($_POST['event_id'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'id not set');
            $this->renderJSON($data);
            return;
        }



        $event_id = $_POST['event_id'];

        $event = Event::model()->find('event_id=:id', array(':id'=>$event_id));
        if($event){
            $event->complete = false;
            $event->save(false);

            $data = array('success'=>true);
            $this->renderJSON($data);
            return;
        }else{
            $data = array('success'=>false,'error_id'=>2,'error_msg'=>'Event doesnt exist');
            $this->renderJSON($data);
            return;
        }

    }




    // Uncomment the following methods and override them if needed
    /*
    public function filters()
    {
        // return the filter configuration for this controller, e.g.:
        return array(
            'inlineFilterName',
            array(
                'class'=>'path.to.FilterClass',
                'propertyName'=>'propertyValue',
            ),
        );
    }

    public function actions()
    {
        // return external action classes, e.g.:
        return array(
            'action1'=>'path.to.ActionClass',
            'action2'=>array(
                'class'=>'path.to.AnotherActionClass',
                'propertyName'=>'propertyValue',
            ),
        );
    }
    */
}