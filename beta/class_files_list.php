<?php

include 'php/dbconnection.php';
require_once 'php/file_ops.php';
require_once 'php/time.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_POST['class_id'])) {
    $class_id = $_POST['class_id'];
}

$ppt_array = array();
$zip_array = array();
$doc_array = array();
$pdf_array = array();
$xlsx_array = array();
$image_array = array();
$other_array = array();

//fetching files uploaded for this course in posts or files tab
$get_course_files_query = "SELECT FU.*, U.firstname, U.lastname, U.user_id, CF.text_msg ".
                          "FROM file_upload FU, user U, course_files CF ".
                          "WHERE CF.file_id = FU.file_id AND U.user_id = CF.user_id AND CF.class_id = '$class_id'";
$get_course_files_query_result = mysqli_query($con, $get_course_files_query);

// determining type of file
while ($row = mysqli_fetch_array($get_course_files_query_result)) {
    $file_type = get_file_type($row['file_type']);    
    $row['file_type'] = $file_type;
    switch ($file_type) {
        case "ppt":
            $ppt_array[] = $row;
            break;
        case "doc":
            $doc_array[] = $row;
            break;
        case "pdf":
            $pdf_array[] = $row;
            break;
        case "zip":
            $zip_array[] = $row;
            break;
        case "xls":
            $xlsx_array[] = $row;
            break;
        case "image":
            $image_array[] = $row;
            break;
        case "other":
            $other_array[] = $row;
            break;
        default:
            echo "Never come here!!";
            break;
    }
}

$get_posts_files_query = "SELECT FU.*, U.firstname, U.lastname, U.user_id, P.text_msg FROM file_upload FU, user U, posts P
  WHERE P.file_id = FU.file_id AND U.user_id = P.user_id AND P.target_id = '$class_id' AND P.target_type='class' AND P.file_id IS NOT NULL";
$get_posts_files_query_result = mysqli_query($con, $get_posts_files_query);

// determining type of file
while ($row = mysqli_fetch_array($get_posts_files_query_result)) {
    $file_type = get_file_type($row['file_type']);
    $row['file_type'] = $file_type;
    switch ($file_type) {
        case "ppt":
            $ppt_array[] = $row;
            break;
        case "doc":
            $doc_array[] = $row;
            break;
        case "pdf":
            $pdf_array[] = $row;
            break;
        case "zip":            
            $zip_array[] = $row;
            break;
        case "xls":
            $xlsx_array[] = $row;
            break;
        case "image":
            $image_array[] = $row;
            break;
        case "other":
            $other_array[] = $row;
            break;
        default:
            echo "Never come here!!";
            break;
    }
}

function printBlockWrapper($title, $count) {
  echo "
        <div class='blockwrapper'>
          <div class='members-header members-students'>
            $title (" .$count. ")
          </div>

          <div style='width: 828px' class='members-header-line'></div>
        </div>
        <div class='files-type-content'>
    ";
}

function printFileBlock($id, $timestamp, $file_type, $file_name, $firstname, $lastname, $text_msg, $thumb) {
    echo "<div class='file' id='" . $id . "'>
            <div class='file-cont' id='" . $timestamp . "'>
              <div class='file-wrap " . $file_type . "'>
                <a href='php/download_file.php?file_id=" . $id . "'>
                <div class='file-thumb-wrap'>
                  <div class='file-thumb' style='background-image: url(".$thumb.")'></div>

                  <div class='file-thumb-cover'>
                    <div class='file-download2'>
                      Download
                    </div>
                  </div>
                </div>
                </a>

                <div class='file-info-area'>
                  <h4 class='file-title search_unit' title='" . $file_name . "'>" . $file_name . "</h4>
                  <span class='file-date'>" . formattime($timestamp) . "</span>

                  <div class='file-info-areabtm'>
                    <span class='file-creator search_unit'>" . $firstname . " " . $lastname . "</span> uploaded
                    <div class = 'file-desc'>" . $text_msg . "</div>
                    <a href='php/download_file.php?file_id=" . $id . "'><div class='download-btn1'>
                      Download
                    </div></a>
                  </div>
                </div>
              </div>
            </div>
            <div class='delete'></div>
          </div>";
}

//showing ppt files
if (count($ppt_array) > 0) {
    $sort = array();
    foreach ($ppt_array as $k => $v) {
        $sort['created_timestamp'][$k] = $v['created_timestamp'];
    }
    array_multisort($sort['created_timestamp'], SORT_DESC, $ppt_array);

    printBlockWrapper("Powerpoints", count($ppt_array));
    
    foreach ($ppt_array as $file) {
        if (strlen($file['file_name']) > 12) {
            $file_name = substr($file['file_name'], 0, 9) . "...";
        } else {
            $file_name = $file['file_name'];
        }
        printFileBlock($file['file_id'], $file['created_timestamp'], 
                       $file['file_type'], $file['file_name'], $file['firstname'], 
                       $file['lastname'], $file['text_msg'], 'src/file_type_ppt.png');
    }
    //closing file-type-content div
    echo "
        </div>
    ";
}

//showing doc files
if (count($doc_array) > 0) {
    $sort = array();
    foreach ($doc_array as $k => $v) {
        $sort['created_timestamp'][$k] = $v['created_timestamp'];
    }
    array_multisort($sort['created_timestamp'], SORT_DESC, $doc_array);

    printBlockWrapper("Documents", count($doc_array));

    foreach ($doc_array as $file) {
        if (strlen($file['file_name']) > 12) {
            $file_name = substr($file['file_name'], 0, 9) . "...";
        } else {
            $file_name = $file['file_name'];
        }
        printFileBlock($file['file_id'], $file['created_timestamp'], 
                       $file['file_type'], $file['file_name'], $file['firstname'], 
                       $file['lastname'], $file['text_msg'], 'src/file_type_doc.png');
    }
    //closing file-type-content div
    echo "
        </div>
    ";
}

//showing zip files
if (count($zip_array) > 0) {
    $sort = array();
    foreach ($zip_array as $k => $v) {
        $sort['created_timestamp'][$k] = $v['created_timestamp'];
    }
    array_multisort($sort['created_timestamp'], SORT_DESC, $zip_array);

    printBlockWrapper("Zipped", count($zip_array));

    foreach ($zip_array as $file) {
        if (strlen($file['file_name']) > 12) {
            $file_name = substr($file['file_name'], 0, 9) . "...";
        } else {
            $file_name = $file['file_name'];
        }
        printFileBlock($file['file_id'], $file['created_timestamp'], 
                       $file['file_type'], $file['file_name'], $file['firstname'], 
                       $file['lastname'], $file['text_msg'], 'src/file_type_zip.png');
    }
    //closing file-type-content div
    echo "
        </div>
    ";
}

//showing pdf files
if (count($pdf_array) > 0) {
    $sort = array();
    foreach ($pdf_array as $k => $v) {
        $sort['created_timestamp'][$k] = $v['created_timestamp'];
    }
    array_multisort($sort['created_timestamp'], SORT_DESC, $pdf_array);

    printBlockWrapper("PDF", count($pdf_array));

    foreach ($pdf_array as $file) {
        if (strlen($file['file_name']) > 12) {
            $file_name = substr($file['file_name'], 0, 9) . "...";
        } else {
            $file_name = $file['file_name'];
        }
        printFileBlock($file['file_id'], $file['created_timestamp'], 
                       $file['file_type'], $file['file_name'], $file['firstname'], 
                       $file['lastname'], $file['text_msg'], 'src/file_type_pdf.png');
    }
    //closing file-type-content div
    echo "
        </div>
    ";
}

//showing xls files
if (count($xlsx_array) > 0) {
    $sort = array();
    foreach ($xlsx_array as $k => $v) {
        $sort['created_timestamp'][$k] = $v['created_timestamp'];
    }
    array_multisort($sort['created_timestamp'], SORT_DESC, $xlsx_array);

    printBlockWrapper("Spreadsheets", count($xlsx_array));

    foreach ($xlsx_array as $file) {
        if (strlen($file['file_name']) > 12) {
            $file_name = substr($file['file_name'], 0, 9) . "...";
        } else {
            $file_name = $file['file_name'];
        }
        printFileBlock($file['file_id'], $file['created_timestamp'], 
                       $file['file_type'], $file['file_name'], $file['firstname'], 
                       $file['lastname'], $file['text_msg'], 'src/file_type_xls.png');
    }
    //closing file-type-content div
    echo "
        </div>
    ";
}

if (count($image_array) > 0) {
    $sort = array();
    foreach ($image_array as $k => $v) {
        $sort['created_timestamp'][$k] = $v['created_timestamp'];
    }
    array_multisort($sort['created_timestamp'], SORT_DESC, $image_array);

    printBlockWrapper("Images", count($image_array));
    
    foreach ($image_array as $file) {
        if (strlen($file['file_name']) > 12) {
            $file_name = substr($file['file_name'], 0, 9) . "...";
        } else {
            $file_name = $file['file_name'];
        }        
        printFileBlock($file['file_id'], $file['created_timestamp'], 
                       $file['file_type'], $file['file_name'], $file['firstname'], 
                       $file['lastname'], $file['text_msg'], 'php/download_file.php?file_id='.$file['file_id']);
    }
    //closing file-type-content div
    echo "</div>";
}

//showing other files
if (count($other_array) > 0) {
    $sort = array();
    foreach ($other_array as $k => $v) {
        $sort['created_timestamp'][$k] = $v['created_timestamp'];
    }
    array_multisort($sort['created_timestamp'], SORT_DESC, $other_array);

    printBlockWrapper("Others", count($other_array));
    
    foreach ($other_array as $file) {
        if (strlen($file['file_name']) > 12) {
            $file_name = substr($file['file_name'], 0, 9) . "...";
        } else {
            $file_name = $file['file_name'];
        }        
        printFileBlock($file['file_id'], $file['created_timestamp'], 
                       $file['file_type'], $file['file_name'], $file['firstname'], 
                       $file['lastname'], $file['text_msg'], 'src/file_type_oth.png');
    }
    //closing file-type-content div
    echo "</div>";
}

if((count($zip_array) + count($ppt_array) + count($doc_array) + 
    count($pdf_array) + count($xlsx_array) + count($other_array) + count($image_array)) == 0){
     echo"
        <h2 id='noFiles'> Files </h2>
        <div class='noInfoBox' id='noInfoFileBox'> Upload the first file </div> 
    ";
}


//file-tab-content close
echo "</div>";

//closing database connection
mysqli_close($con);