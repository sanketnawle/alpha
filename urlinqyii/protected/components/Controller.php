<?php


//Functions in this file can be used in any controller

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
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




    public function authenticated(){
        if(isset(Yii::app()->session['user_id'])){
            return true;
        }else{
            return false;
        }
    }

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
            }
        }else{
            foreach ($model_names as $attribute) {
                $name = trim($attribute); //in case of spaces around commas
                $model_data = $model->{$name};
                $row[$name] = array();
                foreach($model_data as $key => $value) {
                    $row[$name][$key] = $value;
                }
            }
        }
        //var_dump($row);
        return $row;
    }

}