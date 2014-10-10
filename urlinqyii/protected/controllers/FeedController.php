<?php

class FeedController extends Controller
{
    // The user_id is hard coded, it has to be taken from the SESSION
    const POST_LIMIT = 10; //this is the limit for number of posts to be fetched from the DB
    private static $cur_user_id;
    private static $cur_sem;
    private static $user;

    public function __construct(){
        self::$cur_user_id = Yii::app()->session['user_id'] || 1;
        self::$user = User::model()->find('user_id=:id', array(':id'=> self::$cur_user_id));
        self::$cur_sem = "fall";
    }


    public function addPostData($posts){
        foreach($posts as $i=>$post){
            // getting and appending the user_name
            $post_owner = User::model()->find('user_id=:id', array(':id'=>$post['user_id']));
            $posts[$i]['user_name'] = $post_owner->firstname." ".$post_owner->lastname;

            // getting and appending the target_name
            if($post['target_type']=="profile"){
                $target = User::model()->find('user_id=:id', array(':id'=>$post['target_id']));
                $posts [$i] ['target_name'] = $target->firstname." ".$post_owner->lastname;
            }
            elseif($post['target_type']=="class"){
                $class = ClassModel::model()->find('class_id=:id', array(':id'=>$post['target_id']));
                $sec_id = $class->section_id;
                $course_id = $class->course_id;
                $course = Course::model()->find('course_id=:id', array(':id'=>$course_id));
                $course_name = $course->course_name;
                $posts [$i] ['target_name'] = $course_name;
            }
            elseif($post['target_type']=="course"){
                $course = Course::model()->find('course_id=:id', array(':id'=>$post['target_id']));
                $posts [$i] ['target_name'] = $course->course_name;
            }
            elseif($post['target_type']=="department"){
                $target = Department::model()->find('dept_id=:id', array(':id'=>$post['target_id']));
                $posts [$i] ['target_name'] = $target->dept_name;
            }
            elseif($post['target_type']=="school"){
                $target = SchoolController::model()->find('univ_id=:id', array(':id'=>$post['target_id']));
                $posts [$i] ['target_name'] = $target->univ_name;
            }
            else{
                $posts [$i] ['target_name'] = NULL;
            }
        }
        return $posts;
    }

	public function actionGetHomePosts()
	{
//      print_r(User::model()->find('user_id=:id', array(':id'=> self::$cur_user_id)));

        $posts_sql_home = "SELECT distinct *
                  from posts
                  join posts_user_inv
                    on (posts.post_id = posts_user_inv.post_id)
                 where ((posts_user_inv.user_id IN (SELECT to_user_id from connect where from_user_id = ".self::$user->user_id.")
                    or posts_user_inv.user_id = ".self::$user->user_id.")
                    or (target_type = 'university' and target_id = ".self::$user->univ_id.")
                    or (target_type = 'department' and target_id = ".self::$user->dept_id.")
                    or (target_type = 'class' and target_id IN (SELECT cu.class_id
                                                                  from courses_user cu join courses_semester cs
                                                                    on (cu.class_id = cs.class_id)
                                                                    where user_id = ".self::$user->user_id." and cs.semester = '".self::$cur_sem."' and cs.`year` = ".date('Y').")))
                    order by last_activity DESC
                    LIMIT 0,".self::POST_LIMIT;

        $command = Yii::app()->db->createCommand($posts_sql_home);

        $posts = $command->queryAll();
        $this->renderJSON(self::addPostData($posts));

//        $this->renderJSON($posts);
	}

    public function actionGetProfilePosts()
    {
        $posts_sql_profile = "SELECT distinct *
				  from posts p LEFT JOIN posts_questions pq
				  ON p.post_id = pq.post_id
				  where p.user_id = ".self::$user->user_id."
				  OR (p.target_type = 'user' and p.target_id = ".$_GET['id'].")
					OR (pq.tag_type = 'user' and pq.tag_id = ".$_GET['id'].")
					ORDER BY last_activity DESC	LIMIT 0,".self::POST_LIMIT;

        $command = Yii::app()->db->createCommand($posts_sql_profile);

        $posts = $command->queryAll();

        $this->renderJSON($posts);
    }

    public function actionGetClassPosts()
    {
        

        $posts_sql_class = "SELECT distinct *
		  from posts p
		  left join posts_questions pq
		  on p.post_id = pq.post_id
		  where (p.target_type = 'class' and p.target_id = '".$_GET['id']."')
			 or (pq.tag_type = 'class' and pq.tag_id = '".$_GET['id']."')
			order by last_activity DESC	LIMIT 0,".self::POST_LIMIT;

        $command = Yii::app()->db->createCommand($posts_sql_class);

        $posts = $command->queryAll();

        $this->renderJSON($posts);
    }

    public function actionGetCoursePosts()
    {
        

        $posts_sql_course = "SELECT distinct *
		  from posts p
		  left join posts_questions pq
		  on p.post_id = pq.post_id
		  where (p.target_type = 'course' and p.target_id = '".$_GET['id']."')
		    or (pq.tag_type = 'course'	and pq.tag_id = '".$_GET['id']."')
			order by last_activity DESC
			LIMIT 0,".self::POST_LIMIT;

        $command = Yii::app()->db->createCommand($posts_sql_course);

        $posts = $command->queryAll();

        $this->renderJSON($posts);
    }

    public function actionGetClubPosts()
    {
        

        $posts_sql_club = "SELECT distinct *
		  from posts p
		  left join posts_questions pq
		  on p.post_id = pq.post_id
		  where (p.target_type = 'group' and p.target_id = '".$_GET['id']."')
		    or (pq.tag_type = 'group'	and pq.tag_id = '".$_GET['id']."')
			order by last_activity DESC
			LIMIT 0,".self::POST_LIMIT;

        $command = Yii::app()->db->createCommand($posts_sql_club);

        $posts = $command->queryAll();

        $this->renderJSON($posts);
    }

    public function actionGetDepartmentPosts()
    {
        

        $posts_sql_dept = "SELECT distinct *
		  from posts p
		  left join posts_questions pq
		  on p.post_id = pq.post_id
		  where (p.target_type = 'department' and p.target_id = '".$_GET['id']."')
		    or (pq.tag_type = 'department'	and pq.tag_id = '".$_GET['id']."')
			order by last_activity DESC
			LIMIT 0,".self::POST_LIMIT;

        $command = Yii::app()->db->createCommand($posts_sql_dept);

        $posts = $command->queryAll();

        $this->renderJSON($posts);
    }

    public function actionGetSchoolPosts()
    {
        

        $posts_sql_school = "SELECT distinct *
		  from posts p
		  left join posts_questions pq
		  on p.post_id = pq.post_id
		  where (p.target_type = 'school' and p.target_id = '".$_GET['id']."')
		    or (pq.tag_type = 'school'	and pq.tag_id = '".$_GET['id']."')
			order by last_activity DESC
			LIMIT 0,".self::POST_LIMIT;

        $command = Yii::app()->db->createCommand($posts_sql_school);

        $posts = $command->queryAll();

        $this->renderJSON($posts);
    }

    public function actionGetUniversityPosts()
    {
        

        $posts_sql_univ = "SELECT distinct *
		  from posts p
		  left join posts_questions pq
		  on p.post_id = pq.post_id
		  where (p.target_type = 'university' and p.target_id = '".$_GET['id']."')
		    or (pq.tag_type = 'university'	and pq.tag_id = '".$_GET['id']."')
			order by last_activity DESC
			LIMIT 0,".self::POST_LIMIT;

        $command = Yii::app()->db->createCommand($posts_sql_univ);

        $posts = $command->queryAll();

        $this->renderJSON($posts);
    }

    public function actionGetReplies()
    {
        $this->renderJSON('getReplies');
    }

    public function actionGetMoreReplies()
    {
        $this->renderJSON('getMoreReplies');
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