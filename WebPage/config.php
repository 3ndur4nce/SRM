<?php

define('DB_SERVER', 'dbhost');
define('DB_USERNAME', 'dbuser');
define('DB_PASSWORD', 'dbpasswd');
define('DB_NAME', 'dbname');


$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if (!$link->set_charset("utf8")) {
    printf("Error loading character set utf8: %s\n", $link->error);
} 

if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}


?>
