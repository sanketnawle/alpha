<?php
    include "../php/dbconnection.php";
    
    // department with univ id
    // prof : user_type = p user 
    // student: " user_type = s
    // cls = courses_semester with dept_id and univ_id query user for those
    // clb = groups user_id
    // sch = university and univ id
    // 
    if(!isset($_REQUEST["ajax"])) die("503: Bad Request");
    if(!isset($_REQUEST["dept_id"])) 
    
    $count = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 6;
    $limit = " LIMIT ".$count;
    $rows = array();
    $table_i = 0;
    
    function getTables($search) {
        $array = array();
        $array[] = [
            "tlb" => "user",
            "fld" => "concat(firstname, ' ', lastname) as name, user_id as id, dp_blob as img_id",
            "con" => "concat(firstname, ' ', lastname) REGEXP '".$search."' AND user_type = 'p' AND dept_id = 5",
            "typ" => "pro"
        ];
        $array[] = [
            "tlb" => "user",
            "fld" => "concat(firstname, ' ', lastname) as name, user_id as id, dp_blob as img_id",
            "con" => "concat(firstname, ' ', lastname) REGEXP '".$search."' AND user_type = 's' AND dept_id = 5",
            "typ" => "stu"
        ];
    
        $array[] = $array[0];
        $array[2]["con"] = "concat(firstname, ' ', lastname) REGEXP '".$search."' AND user_type = 'p'";
        // $array[2]["typ"] = "prod"; // debug: without dept id
    
        $array[] = $array[1];
        $array[3]["con"] = "concat(firstname, ' ', lastname) REGEXP '".$search."' AND user_type = 's'";
        // $array[3]["typ"] = "stud"; // debug: without dept id
    
        $array[] = [
            "tlb" => "courses",
            "fld" => "course_name as name, course_id as id, dp_blob_id as img_id",
            "con" => "course_name REGEXP '".$search."' AND dept_id = 5",
            "typ" => "cls"
        ];
    
        $array[] = $array[4];
        $array[5]["con"] = "course_name REGEXP '".$search."'";
        // $array[5]["typ"] = "clsd"; // debug: without dept id
    
        $array[] = [
            "tlb" => "groups",
            "fld" => "group_name as name, group_id as id, dp_blob_id as img_id",
            "con" => "group_name REGEXP '".$search."'",
            "typ" => "clb"
        ];
        $array[] = [
            "tlb" => "department",
            "fld" => "dept_name as name, dept_id as id, dp_blob_id as img_id",
            "con" => "dept_name REGEXP '".$search."'",
            "typ" => "dpt"
        ];
        return $array;
    }

    $tables = array_merge(getTables("^".$_REQUEST["q"]), getTables(" ".$_REQUEST["q"]));
    
    while(sizeof($rows) < $count && $table_i < sizeof($tables)) {                
        $query = "SELECT ".$tables[$table_i]["fld"]." FROM ".$tables[$table_i]["tlb"]." WHERE ".$tables[$table_i]["con"].$limit;        
    
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        $row_i = 0;
        while(($row = mysqli_fetch_assoc($result)) && sizeof($rows) < $count && $row_i <= $count / 2) {
            $row["type"] = $tables[$table_i]["typ"];
            $rows[] = $row;
            ++$row_i;
        }
        ++$table_i;
    }    
    
    echo json_encode($rows);
?>
