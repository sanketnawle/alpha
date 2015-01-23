
<?php

// place this code inside a php file and call it f.e. "download.php"
$path = "DEMO/uploaded/postfiles/"; // change the path to fit your websites document structure
$fullPath = $path . $_GET['download_file'];
echo $fullPath;
if(file_exists($fullPath)){
    echo "File exists";
}else{
    echo "Does not Exist";
}
if ($fd = fopen($fullPath, "r")) {
    $fsize = filesize($fullPath);
    $path_parts = pathinfo($fullPath);
    $ext = strtolower($path_parts["extension"]);
    switch ($ext) {
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
        default;
            header("Content-type: application/octet-stream");
            header("Content-Disposition: filename=\"" . $path_parts["basename"] . "\"");
    }
    header("Content-length: $fsize");
    header("Cache-control: private"); //use this to open files directly
    while (!feof($fd)) {
        $buffer = fread($fd, 2048);
        echo $buffer;
    }
} else {
    echo "Did not open file";
}
fclose($fd);
exit;

// example: place this kind of link into the document where the file download is offered:
// <a href="download.php?download_file=some_file.pdf">Download here</a>
?>