<?php


//Functions in this file can be used in any controller

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
date_default_timezone_set('UTC');

class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();






    protected function renderJSON($data)
    {
        header('Content-type: application/json');
        echo CJSON::encode($data);

        foreach (Yii::app()->log->routes as $route) {
            if($route instanceof CWebLogRoute) {
                $route->enabled = false; // disable any weblogroutes
            }
        }
        Yii::app()->end();
    }

    //Checks to see if current user is authenticated
    //Returns a valid user object (which will equate to true) or false
    //Use like this for controller action functions that need to be authenticated
    //if(!$this->authenticated()){
    //  $this->redirect(Yii::app()->getBaseUrl(true) . '/');
    //}
    //or
    //$user = $this->authenticated();
    //if($user){}
    public function authenticated(){
        $user = $this->get_current_user();


        if($user && ($user->status == 'active' || $user->status == 'onboarded')){
            return $user;
        }else{
            return false;
        }

//        if(isset(Yii::app()->session['user_id'])){
//            return true;
//        }else{
//            return false;
//        }
    }





    public function is_urlinq_admin($user){

        $admin_email_list = array('@urlinq.com', 'ross.kopelman@student.touro.edu', 'rkopelma@student.touro.edu');

        foreach($admin_email_list as $admin_email){
            if(strpos($user->user_email, $admin_email) !== false){
                return true;
            }
        }

        return false;
    }

    public $supported_emails = ['nyu.edu', 'urlinq.com','student.touro.edu','touro.edu'];

    function get_supported_email_list(){
        return $this->supported_emails;
    }

    function is_supported_email($email){
        foreach($this->supported_emails as $supported_email){
            if(strpos($email, $supported_email)){
                return true;
            }
        }

        return false;
    }



    function get_university_id_by_email($email){
        if(strpos($email, 'nyu.edu')){
            return 1;
        }else if(strpos($email, 'touro.edu')){
            return 4;
        }else{
            return 1;
        }

    }

    //Returns the current User model
    //Use like this in the controllers:
    //$user = $this->get_current_user();
    //Be sure to check if user is authenticated first by doing
    //if(!$this->authenticated()){
    //  $this->redirect(Yii::app()->getBaseUrl(true) . '/');
    //}
    //at the top of your controller's function

    //If post is passed in, check if token is set
    //If token is set, check if it is valid
    function get_current_user($post = null){
        if($post && isset($post['token'])){
            $user_token = UserToken::model()->find('token=:token',array(':token'=>$post['token']));
            if($user_token){

                return User::model()->find('user_id=:id', array(':id'=>$user_token->user_id));
            }else{
                return null;
            }
        }
        $user = User::model()->find('user_id=:id', array(':id'=>Yii::app()->session['user_id']));
        //$this->register_node_js_user($user->user_id);

        return $user;
    }

    function register_node_js_user($user_id){
//        $frame = Yii::app()->nodeSocket->getFrameFactory()->createAuthenticationFrame();
//        $frame->setUserId($user_id);
//        $frame->send();
    }


    function get_current_user_id($post = null){
        if($post && isset($post['user_id'])) {
            return User::model()->find('user_id=:id', array(':id'=>$post['user_id']))->user_id;
        }
        else{
            return User::model()->find('user_id=:id', array(':id'=>Yii::app()->session['user_id']))->user_id;
        }
    }




    function is_assoc($array) {
        return (bool)count(array_filter(array_keys($array), 'is_string'));
    }

    function get_model_associations($model, array $attributes) {

        $row = array();

        foreach($model as $key => $value) {
            $row[$key] = $value;
        }

        $row = $this->walk_model($model,$row,$attributes);

        return $row;
    }

    function get_models_associations($models, array $attributes) {

        foreach($models as $i=>$model) {
            $models[$i] = $this->walk_model($model,$this->model_to_array($model),$attributes);
        }

        return $models;
    }

    function check_question_option($user, $GET){
        $question_option_id = $GET['question_option_id'];

        $option = PostQuestionOption::model()->find('option_id=:id', array(':id'=>$question_option_id));

        if($option){
            $post_id = $option->post_id;
            //Check if this user has already voted for this question
            $post = $option->post;

            //check if post is a question
            $question = $post->postQuestion;
            if($question && $question->active){

                $options = $post->postQuestionOptions;

                foreach($options as $this_option){

                    //Check if the user voted for this option
                    $user_vote = PostQuestionOptionAnswer::model()->find('option_id=:option_id and user_id=:user_id', array(':option_id'=>$this_option->option_id, ':user_id'=>$user->user_id));

                    if($user_vote){
                        if($user_vote->option_id != $option->option_id){
                            $user_vote->delete();
                        }
                    }else{
                        if($this_option->option_id == $option->option_id){
                            $new_user_vote = new PostQuestionOptionAnswer;
                            $new_user_vote->option_id = $option->option_id;
                            $new_user_vote->user_id = $user->user_id;
                            $new_user_vote->save(false);
                        }
                    }
                }
            }

        }



    }

    //Allows urls to take in event_id and option as attending, maybe_attending, not_attending to set attend_status for the event_user table
    function check_event_option($user, $GET){

        $event_id = $GET['event_id'];
        $option = $GET['event_option'];

        if($option == 'attending' || $option == 'maybe_attending' || $option == 'not_attending'){
            //Check if the event exists
            $event = Event::model()->find('event_id=:id', array(':id'=>$event_id));
            if($event){
                if($user->user_id == $event->user_id){
                    //User is default attending
                }else{
                    $event_user = EventUser::model()->find('event_id=:event_id and user_id=:user_id', array(':event_id'=>$event_id, ':user_id'=>$user->user_id));
                    if($event_user){
                        $event_user->attend_status = $option;

                        $event_user->save(false);
                    }
                }

            }
        }
    }




    //Recursively goes through a model and nests relations
    //that you give
    //For example, array('schools'=>array('pictureFile','coverFile','departments'))
    //Would return an associative array like this:
    // array('school'=>array(
    //        'school_id'=>1,
    //        'school_name':'nyu',
    //         ...,
    //        'pictureFile'=>array('file_id'=>1,...),
    //        'coverFile'=>array('file_id'=>1,...),
    //        'departments'=>array(
    //            {school1},{school2},etc
    //        )
    // );

    function walk_model($model, array $row,array $model_names){
        //array(schools => array(pictureFile))

        if($this->is_assoc($model_names)){
            foreach($model_names as $nested_model_name => $nested_attributes) {
                $name = trim($nested_model_name); //in case of spaces around commas

                $model_values = $model->{$name};

                //Check if the model association data is not null
                if($model_values){
                    if(is_array($model_values)){
                        for($i = 0; $i < count($model_values); ++$i){
                            $this_model = $model_values[$i];
                            $row[$name][$i] = array();
                            foreach($this_model as $key => $value) {
                                $row[$name][$i][$key] = $value;
                            }
                            $row[$name][$i] = $this->walk_model($this_model,$row[$name][$i],$nested_attributes);
                        }
                    }else{
                        foreach($model_values as $key => $value) {
                            $row[$name][$key] = $value;
                        }
                        $row[$name] = $this->walk_model($model_values,$row[$name],$nested_attributes);
                    }
                }else{
                    $relations = $model->relations();
                    $relation_type = $relations[$name][0];
                    if($relation_type == "CManyManyRelation" || $relation_type == "CHasManyRelation"){
                        $row[$name] = array();
                    }else{
                        $row[$name] = null;
                    }

                }
            }
        }else{
            foreach ($model_names as $attribute) {
                $name = trim($attribute); //in case of spaces around commas
                $model_data = $model->{$name};
                //Check if the model association data is not null
                if($model_data){
                    $row[$name] = array();
                    foreach($model_data as $key => $value) {
                        $row[$name][$key] = $value;
                    }
                }else{
                    $relations = $model->relations();
                    $relation_type = $relations[$name][0];
                    if($relation_type == "CManyManyRelation" || $relation_type == "CHasManyRelation"){
                        $row[$name] = array();
                    }else{
                        $row[$name] = null;
                    }
                }
            }
        }
        //var_dump($row);
        return $row;
    }


    function models_to_array($models){
        $array = array();

        foreach($models as $model){
            array_push($array,$this->model_to_array($model));
        }

        return $array;

    }

    function model_to_array($this_model){
        $row = array();
        foreach($this_model as $key => $value) {
            $row[$key] = $value;
        }
        return $row;
    }

}