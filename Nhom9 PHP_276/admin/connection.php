<?php

define('HOST', 'localhost');
define('PORT', 3306);
define('DATABASE', 'thegioididong');
define('USERNAME', 'root');
define('PASSWORD', '');
define('CHARSET', 'utf8');

$mysqliDriver = new mysqli_driver();
$mysqliDriver->report_mode = (MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$connection = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);

?>