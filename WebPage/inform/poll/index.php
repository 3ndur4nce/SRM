<?php

require_once "../../config.php";

if(isset($_GET['hostname'])){
    $hostname = $_GET['hostname'];
}

$authorisationheader = getallheaders()['Authorization'];

$getauthqry = mysqli_query($link, "SELECT 1 FROM assets WHERE token = '$authorisationheader' AND name = '$hostname' LIMIT 1");
while($row = mysqli_fetch_array($getauthqry)){
    if($row['1'] == '1'){
        $auth = 'ok';
    }
}

if($auth == 'ok'){
    $getassetqry = mysqli_query($link, "SELECT * FROM assets WHERE token = '$authorisationheader' AND name = '$hostname'");
    while($row = mysqli_fetch_array($getassetqry)){
        $assetid = $row['id'];
        $active = $row['active'];
    }
    if($active == 1){
        $date = new \DateTime();
        $datenow = $date->format("Y-m-d H:i:s");
        $date = new DateTime();
        $tosub = new DateInterval('PT12H00M');
        $halfdayago = $date->sub($tosub);
        $datehalfdayago = $date->format("Y-m-d H:i:s");
        $getschedqry = mysqli_query($link, "SELECT * FROM schedules WHERE assetid = $assetid AND runtime <= '$datenow' AND runtime >= '$datehalfdayago' AND rantime IS NULL ORDER BY runtime ASC LIMIT 1");
        while($row = mysqli_fetch_array($getschedqry)){
            $schedid = $row['id'];
        }
        if(isset($schedid)){
            echo "$schedid";
        }else{
            echo 0;
        }
    }
}