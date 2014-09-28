<script>
$( document ).ready(function() {
    $(document).delegate(".searchFiles", "keyup", function (e) {
        var curstring= $(this).val().toLowerCase().trim();
        if(curstring.length>=2){
        $(".file").each(function() {
          var tagstring_obj= $(this).find(".search_unit");
          var tagstring=tagstring_obj.text().toLowerCase().trim();

          if(tagstring.indexOf(curstring)>=0){
            $(this).removeClass("hidden_result");
          }else{
            $(this).addClass("hidden_result");
          }

        });

        }else{
          $(".hidden_result").removeClass("hidden_result");
        }

      });




      $(document).delegate(".upload-files", "click", function () {
        $(this).closest(".files-search-top").find(".upload_file_at_course").click();
      });

      $(document).delegate(".sortByDropdown", "change", function () {

        var filelist=[];
        if($(this).val()=="recent-rank"){
          filelist=[];
          $( ".file" ).each(function( index ) {
            filelist.push($(this).clone());
          });
          //alert(filelist[2].attr("id"));

          filelist.sort(function(x, y){
              return Date.parse(y.find(".file-cont").attr("id").replace(/-/g, '/')) - Date.parse(x.find(".file-cont").attr("id").replace(/-/g, '/'));
          });

          //alert(filelist[2].attr("id"));

          $.each(filelist, function( index ) {
            $(".file_sortbox").append(filelist[index]);
          });

          $(".hidden_result").removeClass("hidden_result");
          $(".searchFiles").val("");

          $(".blockwrapper").hide();
          $(".files-type-content").hide();
          $(".file_sortbox").show();
        }else{

          filelist=[];
          $(".blockwrapper").show();
          $(".files-type-content").show();
          $(".file_sortbox").hide();

          $(".hidden_result").removeClass("hidden_result");
          $(".searchFiles").val("");
          $(".file_sortbox").empty();

        }


      });
      });
</script>

<?php
/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 7/22/14
 * Time: 5:21 PM
 */

include '../php/dbconnection.php';
include '../php/file_ops.php';
include '../php/time.php';
session_start();

$class_id = "92478034-f589-11e3-b732-00259022578e";
$user_id = 1;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];
}


echo "
    <div class='files-tab-content'>
        <div class='files-search-top'>
          <input name='sb-files' type='hidden' />

          <div class='sortwrapper'>
            <label for='sort' class='sortByLabel'>Sort By</label> <select class=
            'sortByDropdown' name='sort' id='sort'>
              <option value='filetype-rank'>
                File Type
              </option>

              <option value='recent-rank'>
                Recent Uploads
              </option>

            </select>
          </div>

          <div class='filetxt_wrapper'>
            <input type='text' class='inputText searchFiles' name=
            'Search Files' placeholder='Search the files uploaded to this course...' />
          </div>

          <div class='invite-users upload-files'>
            Upload A New File
          </div><input class='upload_file_at_course' type='file' />
        </div>

        <div class='file_sortbox'></div>
";

//fetching files uploaded for this course in posts or files tab
$get_course_files_query = "SElECT FU.*, U.firstname, U.lastname, U.user_id, CF.text_msg FROM file_upload FU, user U, course_files CF WHERE CF.file_id = FU.file_id AND U.user_id = CF.user_id AND CF.class_id = '$class_id'";
$get_course_files_query_result = mysqli_query($con, $get_course_files_query);

$ppt_array = array();
$zip_array = array();
$doc_array = array();
$pdf_array = array();
$xls_array = array();
$other_array = array();

// determining type of file
while ($row = mysqli_fetch_array($get_course_files_query_result)) {
    $file_type = get_file_type($row['file_type']);
    switch ($file_type) {
        case "ppt":
            $row['file_type'] = $file_type;
            $ppt_array[] = $row;
            break;
        case "doc":
            $row['file_type'] = $file_type;
            $doc_array[] = $row;
            break;
        case "pdf":
            $row['file_type'] = $file_type;
            $pdf_array[] = $row;
            break;
        case "zip":
            $row['file_type'] = $file_type;
            $zip_array = $row;
            break;
        case "xls":
            $row['file_type'] = $file_type;
            $xls_array = $row;
            break;
        case "image":
        case "other":
            $row['file_type'] = $file_type;
            $other_array[] = $row;
            break;
        default:
            echo "Never come here!!";
            break;
    }
}

$get_posts_files_query = "SElECT FU.*, U.firstname, U.lastname, U.user_id, P.text_msg FROM file_upload FU, user U, posts P
  WHERE P.file_id = FU.file_id AND U.user_id = P.user_id AND P.target_id = '$class_id' AND P.target_type='courses_semester' AND P.file_id IS NOT NULL";
$get_posts_files_query_result = mysqli_query($con, $get_posts_files_query);

// determining type of file
while ($row = mysqli_fetch_array($get_posts_files_query_result)) {
    $file_type = get_file_type($row['file_type']);
    switch ($file_type) {
        case "ppt":
            $row['file_type'] = $file_type;
            $ppt_array[] = $row;
            break;
        case "doc":
            $row['file_type'] = $file_type;
            $doc_array[] = $row;
            break;
        case "pdf":
            $row['file_type'] = $file_type;
            $pdf_array[] = $row;
            break;
        case "zip":
            $row['file_type'] = $file_type;
            $zip_array = $row;
            break;
        case "xls":
            $row['file_type'] = $file_type;
            $xls_array = $row;
            break;
        case "image":
        case "other":
            $row['file_type'] = $file_type;
            $other_array[] = $row;
            break;
        default:
            echo "Never come here!!";
            break;
    }
}

//showing ppt files
if (count($ppt_array) > 0) {
    $sort = array();
    foreach ($ppt_array as $k => $v) {
        $sort['created_timestamp'][$k] = $v['created_timestamp'];
    }
    array_multisort($sort['created_timestamp'], SORT_DESC, $ppt_array);

    echo "
        <div class='blockwrapper'>
          <div class='members-header members-students'>
            Powerpoints (" . count($ppt_array) . ")
          </div>

          <div style='width: 828px' class='members-header-line'></div>
        </div>
        <div class='files-type-content'>
    ";
    foreach ($ppt_array as $file) {
        echo "
            <div class='file' id='" . $file['file_id'] . "'>
            <div class='file-cont' id='" . $file['created_timestamp'] . "'>
              <div class='file-wrap' id='" . $file['file_type'] . "'>
                <div class='file-thumb-wrap'>
                  <div class='file-thumb' style='background-image: url(src/file_type_ppt.png)'></div>

                  <div class='file-thumb-cover'>
                    <div class='file-download2'>
                      Download
                    </div>
                  </div>
                </div>

                <div class='file-info-area'>
                  <h4 class='file-title search_unit'>" . $file['file_name'] . "</h4><span class='file-date'>" . formattime($file['created_timestamp']) . "</span>

                  <div class='file-info-areabtm'>
                    <span class='file-creator search_unit'>" . $file['firstname'] . " " . $file['lastname'] . "</span> uploaded
                    <div class = 'file-desc'>
						" . $file['text_msg'] . "
					</div>
                    <div class='download-btn1'>
                      Download
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        ";
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

    echo "
        <div class='blockwrapper'>
          <div class='members-header members-students'>
            Documents (" . count($doc_array) . ")
          </div>

          <div style='width: 828px' class='members-header-line'></div>
        </div>
        <div class='files-type-content'>
    ";
    foreach ($doc_array as $file) {
        echo "
            <div class='file' id='" . $file['file_id'] . "'>
            <div class='file-cont' id='" . $file['created_timestamp'] . "'>
              <div class='file-wrap' id='" . $file['file_type'] . "'>
                <div class='file-thumb-wrap'>
                  <div class='file-thumb' style='background-image: url(src/file_type_doc.png)'></div>

                  <div class='file-thumb-cover'>
                    <div class='file-download2'>
                      Download
                    </div>
                  </div>
                </div>

                <div class='file-info-area'>
                  <h4 class='file-title search_unit'>" . $file['file_name'] . "</h4><span class='file-date'>" . formattime($file['created_timestamp']) . "</span>

                  <div class='file-info-areabtm'>
                    <span class='file-creator search_unit'>" . $file['firstname'] . " " . $file['lastname'] . "</span> uploaded
                    <div class = 'file-desc'>
						" . $file['text_msg'] . "
					</div>
                    <div class='download-btn1'>
                      Download
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        ";
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

    echo "
        <div class='blockwrapper'>
          <div class='members-header members-students'>
            Zipped (" . count($zip_array) . ")
          </div>

          <div style='width: 828px' class='members-header-line'></div>
        </div>
        <div class='files-type-content'>
    ";
    foreach ($zip_array as $file) {
        echo "
            <div class='file' id='" . $file['file_id'] . "'>
            <div class='file-cont' id='" . $file['created_timestamp'] . "'>
              <div class='file-wrap' id='" . $file['file_type'] . "'>
                <div class='file-thumb-wrap'>
                  <div class='file-thumb' style='background-image: url(src/file_type_zip.png)'></div>

                  <div class='file-thumb-cover'>
                    <div class='file-download2'>
                      Download
                    </div>
                  </div>
                </div>

                <div class='file-info-area'>
                  <h4 class='file-title search_unit'>" . $file['file_name'] . "</h4><span class='file-date'>" . formattime($file['created_timestamp']) . "</span>

                  <div class='file-info-areabtm'>
                    <span class='file-creator search_unit'>" . $file['firstname'] . " " . $file['lastname'] . "</span> uploaded
                    <div class = 'file-desc'>
						" . $file['text_msg'] . "
					</div>
                    <div class='download-btn1'>
                      Download
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        ";
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

    echo "
        <div class='blockwrapper'>
          <div class='members-header members-students'>
            PDF (" . count($pdf_array) . ")
          </div>

          <div style='width: 828px' class='members-header-line'></div>
        </div>
        <div class='files-type-content'>
    ";
    foreach ($pdf_array as $file) {
        echo "
            <div class='file' id='" . $file['file_id'] . "'>
            <div class='file-cont' id='" . $file['created_timestamp'] . "'>
              <div class='file-wrap' id='" . $file['file_type'] . "'>
                <div class='file-thumb-wrap'>
                  <div class='file-thumb' style='background-image: url(src/file_type_pdf.png)'></div>

                  <div class='file-thumb-cover'>
                    <div class='file-download2'>
                      Download
                    </div>
                  </div>
                </div>

                <div class='file-info-area'>
                  <h4 class='file-title search_unit'>" . $file['file_name'] . "</h4><span class='file-date'>" . formattime($file['created_timestamp']) . "</span>

                  <div class='file-info-areabtm'>
                    <span class='file-creator search_unit'>" . $file['firstname'] . " " . $file['lastname'] . "</span> uploaded
                    <div class = 'file-desc'>
						" . $file['text_msg'] . "
					</div>
                    <div class='download-btn1'>
                      Download
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        ";
    }
    //closing file-type-content div
    echo "
        </div>
    ";
}

//showing xls files
if (count($xls_array) > 0) {
    $sort = array();
    foreach ($xls_array as $k => $v) {
        $sort['created_timestamp'][$k] = $v['created_timestamp'];
    }
    array_multisort($sort['created_timestamp'], SORT_DESC, $xls_array);

    echo "
        <div class='blockwrapper'>
          <div class='members-header members-students'>
            Spreadsheets (" . count($xls_array) . ")
          </div>

          <div style='width: 828px' class='members-header-line'></div>
        </div>
        <div class='files-type-content'>
    ";
    foreach ($xls_array as $file) {
        echo "
            <div class='file' id='" . $file['file_id'] . "'>
            <div class='file-cont' id='" . $file['created_timestamp'] . "'>
              <div class='file-wrap' id='" . $file['file_type'] . "'>
                <div class='file-thumb-wrap'>
                  <div class='file-thumb' style='background-image: url(src/file_type_xls.png)'></div>

                  <div class='file-thumb-cover'>
                    <div class='file-download2'>
                      Download
                    </div>
                  </div>
                </div>

                <div class='file-info-area'>
                  <h4 class='file-title search_unit'>" . $file['file_name'] . "</h4><span class='file-date'>" . formattime($file['created_timestamp']) . "</span>

                  <div class='file-info-areabtm'>
                    <span class='file-creator search_unit'>" . $file['firstname'] . " " . $file['lastname'] . "</span> uploaded
                    <div class = 'file-desc'>
						" . $file['text_msg'] . "
					</div>
                    <div class='download-btn1'>
                      Download
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        ";
    }
    //closing file-type-content div
    echo "
        </div>
    ";
}

//showing other files
if (count($other_array) > 0) {
    $sort = array();
    foreach ($other_array as $k => $v) {
        $sort['created_timestamp'][$k] = $v['created_timestamp'];
    }
    array_multisort($sort['created_timestamp'], SORT_DESC, $other_array);

    echo "
        <div class='blockwrapper'>
          <div class='members-header members-students'>
            Others (" . count($other_array) . ")
          </div>

          <div style='width: 828px' class='members-header-line'></div>
        </div>
        <div class='files-type-content'>
    ";
    foreach ($other_array as $file) {
        echo "
            <div class='file' id='" . $file['file_id'] . "'>
            <div class='file-cont' id='" . $file['created_timestamp'] . "'>
              <div class='file-wrap' id='" . $file['file_type'] . "'>
                <div class='file-thumb-wrap'>
                  <div class='file-thumb' style='background-image: url(src/file_type_xls.png)'></div>

                  <div class='file-thumb-cover'>
                    <div class='file-download2'>
                      Download
                    </div>
                  </div>
                </div>

                <div class='file-info-area'>
                  <h4 class='file-title search_unit'>" . $file['file_name'] . "</h4><span class='file-date'>" . formattime($file['created_timestamp']) . "</span>

                  <div class='file-info-areabtm'>
                    <span class='file-creator search_unit'>" . $file['firstname'] . " " . $file['lastname'] . "</span> uploaded
                    <div class = 'file-desc'>
						" . $file['text_msg'] . "
					</div>
                    <div class='download-btn1'>
                      Download
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        ";
    }
    //closing file-type-content div
    echo "
        </div>
    ";
}

// closing file-tab-content div
echo "
    </div>
";

//mysqli_close($con);