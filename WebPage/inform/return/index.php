<?php

require_once "../../config.php";

if(isset($_GET['schedid'])){
    $schedid = $_GET['schedid'];
}
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
        $status = trim($_POST["status"]);
        $output = trim($_POST["output"]);
        $date = new \DateTime();
        $datenow = $date->format("Y-m-d H:i:s");
        $sql = "UPDATE schedules SET status = ?, output = ? WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "ssi", $status, $output, $schedid);
            if(mysqli_stmt_execute($stmt)){
                exit();
            } else{
                echo 0;
            }
        }
    }
}