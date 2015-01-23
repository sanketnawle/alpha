<?php 
/* Banner path to upload all banner images */
define("IMG_PATH",$SITE_URL."images/");

define("UPLOAD_PATH",$SITE_PATH."uploaded/");
define("UPLOAD_URL",$SITE_URL."uploaded/");

define("COURSE_PATH",UPLOAD_PATH."course/");
define("COURSE_URL",UPLOAD_URL."course/");

define("PROFESSOR_PATH",UPLOAD_PATH."course/");
define("PROFESSOR_URL",UPLOAD_URL."course/");

define("POSTSFILE_PATH",UPLOAD_PATH."postfiles/");
define("POSTSFILE_URL",UPLOAD_URL."postfiles/");


/* MIME TYPE AND EXTENSION FOR FILE */
$FILEMIMETYPE = array("image/gif","image/jpeg","image/png","image/pjpeg","image/x-png","application/pdf","application/msword","application/vnd.openxmlformats-officedocument.wordprocessingml.document","application/excel","application/vnd.openxmlformats-officedocument.spreadsheetml.sheet","audio/mpeg","application/g-zip","application/zip","application/x-rar");
$FILEEXTENSION = array("gif","png","jpg","jpeg","pdf","doc","docx","xls","xlsx","mp3","gzip","zip","rar");	

define("MSG_IMAGEBLANK","Please select file");
define("MSG_IMGUPERR","Error in image uploading. Please contact your site administrator.");
define("MSG_NOFOLDERWRITEPERM","Uploaded folder does not have write permission");
define("MSG_NOTSUPPPORTFILEUPLOAD","Form does not support HTTP file upload");
define("MSG_NOTFILEUPLOADSELECT","Please provide file to upload");
define("MSG_OTHERFILEUPLOADERR","There was en error while uploading file on server");
define("MSG_INVALIDFILE","Please provide valid file. Supported files are ".implode(", ",$FILEEXTENSION).".");

define("USEBASE64ENCDEC",0);
define("US_DATE_FORMAT","m/d/Y");
?>