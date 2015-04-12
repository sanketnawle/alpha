<?php

//ob_start();
//session_start();
//include_once("include/includefiles.php");
//$includepage = getInclucdePageFront(); 
//
//ini_set('post_max_size','-1');
//ini_set('memory_limit','-1');

$downld_filename = $_REQUEST['filename'];
$filename = "http://urlinq.com/Demo/uploaded/postfiles/" . $downld_filename;
echo $filename;
//$json = array(
//    'filename' => $filename    
//);
//$jsonstring = json_encode($json);
//echo $jsonstring;

function ForceDownload($filename) {
    // required for IE, otherwise Content-disposition is ignored
    if (ini_get('zlib.output_compression'))
        ini_set('zlib.output_compression', 'Off');

    $file_extension = strtolower(substr(strrchr($filename, "."), 1));
    if ($filename == "") {
        echo "download file NOT SPECIFIED.";
        exit;
    } elseif (!file_exists($filename)) {
        echo "File not found.";
        exit;
    };

    switch ($file_extension) {
        case "pdf": $ctype = "application/pdf";
            break;
        case "mp3": $ctype = "audio/x-mp3";
            break;
        //case "mp3": $ctype="application/octet-stream"; break;
        case "zip": $ctype = "application/zip";
            break;
        case "rar": $ctype = "application/zip";
            break;
        case "tar": $ctype = "application/zip";
            break;
        case "sit": $ctype = "application/zip";
            break;
        case "doc": $ctype = "application/msword";
            break;
        case "docx": $ctype = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
            break;
        case "xls": $ctype = "application/vnd.ms-excel";
            break;
        case "ppt": $ctype = "application/vnd.ms-powerpoint";
            break;
        case "gif": $ctype = "image/gif";
            break;
        case "png": $ctype = "image/png";
            break;
        case "jpeg":
        case "jpg": $ctype = "image/jpg";
            break;
        default: $ctype = "application/force-download";
    }

    header("Pragma: public"); // required
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private", false); // required for certain browsers 
    header("Content-Type: $ctype");
    header("Content-Disposition: attachment; filename=\"" . basename($filename . "_" . date('m-d-Y_H-i-s') . "." . $file_extension) . "\";");
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: " . filesize($filename));
    readfile("$filename");
    exit();
}

ForceDownload($filename);
?>