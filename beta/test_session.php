<?php
session_start();
print_r($_SESSION);
print_r("=>");
print_r(session_id());
print_r("=>");
print_r($_COOKIE[session_id()]);
?>