<?php

class SearchController extends Controller
{

    //public function actionSearch()
    public function actionView()
    {

        //urlinq.com/search?q=lakjsdl
        //$q = $_GET['q'];
        //renders the view file protected/views/search


        $filter = Yii::app()->session['filter'];
        //$q = Yii::app()->getRequest()->getQuery('q');


        $user = User::model()->find('user_id=:id', array(':id'=>1));
        $query = Yii::app()->request->getQuery('q');


        //Yii::app()->request->getPost('q');
        $this->render('search', array('user'=>$user, 'query'=>$query));
    }
    public function actionResults()
    {
        $user = User::model()->find('user_id=:id', array(':id'=>1));
        //$this->render('search', array('user'=>$user,'q'=>$q));
        $query = Yii::app()->request->getQuery('q');

        $this->render('results', array('user'=>$user, 'query'=>$query));
    }

    public function actionSuggestion()
    {
        //Much of this dynamic query algorithm was refactored from the lptopbar_search.php file in beta, to fit the urlinq_new database
        //A search query is passed in through the query and stored in a variable via a GET request. All tables are searched and sends
        //Suggestions to the front-end via AJAX.

        //$con = Yii::app()->db;
        $con = Yii::app()->db->connectionString;

        $search = Yii::app()->getRequest()->getQuery('q');
        //$search .= "| ".$search;
        //$search = "^".$search;

        $count = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 6;
        $limit = " LIMIT ".$count;
        $rows = array();
        $table_i = 0;

        $tables = array();

        //$r = new CDbCriteria();
        //$r->addSearchCondition('firstname', $q);
        //$query = "select firstname from User where ";
        //$user = User::model()->findAll( $r );
        //$user = User::model()->find('firstname=:firstname and lastname=:lastname',array(User::Model()->getFullName()=>$q));

        $tables[] = [
            "tlb" => "user",
            "fld" => "concat(firstname, ' ', lastname) as name, user_id as id",
            "con" => "concat(firstname, ' ', lastname) REGEXP '".$search."' AND user_type = 'p' AND department_id = 5",
            "typ" => "pro"
        ];
        $tables[] = [
            "tlb" => "user",
            "fld" => "concat(firstname, ' ', lastname) as name, user_id as id",
            "con" => "concat(firstname, ' ', lastname) REGEXP '".$search."' AND user_type = 's' AND department_id = 5",
            "typ" => "stu"
        ];
        $tables[] = $tables[0];
        $tables[2]["con"] = "concat(firstname, ' ', lastname) REGEXP '".$search."' AND user_type = 'p'";
        // $tables[2]["typ"] = "prod"; // debug: without dept id

        $tables[] = $tables[1];
        $tables[3]["con"] = "concat(firstname, ' ', lastname) REGEXP '".$search."' AND user_type = 's'";
        // $tables[3]["typ"] = "stud"; // debug: without dept id

        $tables[] = [
            "tlb" => "course",
            "fld" => "course_name as name, course_id as id",
            "con" => "course_name REGEXP '".$search."' AND department_id = 5",
            "typ" => "cls"
        ];

        $tables[] = $tables[4];
        $tables[5]["con"] = "course_name REGEXP '".$search."'";
        // $tables[5]["typ"] = "clsd"; // debug: without dept id

        $tables[] = [
            "tlb" => "group",
            "fld" => "group_name as name, group_id as id",
            "con" => "group_name REGEXP '".$search."'",
            "typ" => "clb"
        ];
        $tables[] = [
            "tlb" => "department",
            "fld" => "dept_name as name, department_id as id",
            "con" => "dept_name REGEXP '".$search."'",
            "typ" => "dpt"
        ];


        while(sizeof($rows) < $count && $table_i < sizeof($tables)) {
            $query = "SELECT ".$tables[$table_i]["fld"]." FROM ".$tables[$table_i]["tlb"]." WHERE ".$tables[$table_i]["con"].$limit;

            //$result = mysqli_query($con, $query) or die(mysqli_error($con));

            $command = Yii::app()->db->createCommand($query);
            //$sql = "SELECT * FROM common_attributes_locale WHERE category_id=:category_id";
            //$command->bindParam("category_id", $categoryId, PDO::PARAM_INT);
            $rows = $command->queryAll();

            //$row_i = 0;
            //while(($row = mysqli_fetch_assoc($result)) && sizeof($rows) < $count && $row_i <= $count / 2) {
            //    $row["type"] = $tables[$table_i]["typ"];
            //    $rows[] = $row;
            //    ++$row_i;
            //}
            ++$table_i;
        }


        //$data = array('success'=>true,'posts'=>array('post1','post2', $q, $limit, $tables)); //Test
        $data = array('success'=>true,'posts'=>array('post1','post2', $search));
        $this->renderJSON($rows);
    }

    public function actionJson()
    {
        $q = Yii::app()->getRequest()->getQuery('q');
        $data = array('success'=> true, 'posts'=>array('post1','post2', $q));

        $this->renderJSON($data);
    }
}

