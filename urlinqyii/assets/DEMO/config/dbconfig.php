<?php 
ini_set('default_charset','iso-8859-1');
date_default_timezone_set("America/Chicago");
define("DB_HOST","localhost");
define("DB_USER","campusla_UrlinqU");
define("DB_PASSWORD","PASSurlinq@word9");
define("DB_HOST_REPLICA","");
define("DB_USER_REPLICA","");
define("DB_PASSWORD_REPLICA","");
define("DB_NAME","campusla_urlinq_demo");

$PROTOCOL = "http://";
$SITE_DOMAIN = $_SERVER['SERVER_NAME']."/";
$SITE_FOLDER = "DEMO/"; // when goes to live set value to blank Ex. $SITE_FOLDER = "";
$DOC_ROOT = $_SERVER['DOCUMENT_ROOT']."/";
$SITE_URL = $PROTOCOL.$SITE_DOMAIN.$SITE_FOLDER;
$SITE_PATH = $DOC_ROOT.$SITE_FOLDER;

?>