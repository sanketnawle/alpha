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


        if($user && $user->status == 'active'){
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
        if(strpos($user->user_email, '@urlinq.com') === false){
            return false;
        }else{
            return true;
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

        return User::model()->find('user_id=:id', array(':id'=>Yii::app()->session['user_id']));
    }


    function get_current_user_id($post = null){
        if($post && isset($post['user_id'])) {
            return User::model()->find('user_id=:id', array(':id'=>$post['user_id']))->user_id;
        }
        else{
            return User::model()->find('user_id=:id', array(':id'=>Yii::app()->session['user_id']))->user_id;
        }
    }

    function valid_email($email){
        $valid_emails = ['nyu.edu', 'urlinq.com'];

        foreach($valid_emails as $valid_email){
            if(strpos($email, $valid_email)){
                return true;
            }
        }


        return false;

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