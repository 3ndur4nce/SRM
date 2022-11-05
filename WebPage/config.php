<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'endurcom_srm');
define('DB_PASSWORD', 'IfOggEckho1');
define('DB_NAME', 'endurcom_srm');


$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if (!$link->set_charset("utf8")) {
    printf("Error loading character set utf8: %s\n", $link->error);
} 

if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

date_default_timezone_set('America/Toronto');

?>
