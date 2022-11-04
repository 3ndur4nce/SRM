<?php

require_once "config.php";
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    require "place/login.php";
}else{
    require "place/getvalues.php";
}

?>