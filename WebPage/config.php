<?php

define('DB_SERVER', 'host');
define('DB_USERNAME', 'user');
define('DB_PASSWORD', 'pass');
define('DB_NAME', 'srm');


$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if (!$link->set_charset("utf8")) {
    printf("Error loading character set utf8: %s\n", $link->error);
} 

if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}


?>
