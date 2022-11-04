<?php

require_once "../../config.php";

if(isset($_GET['schedid'])){
    $schedid = $_GET['schedid'];
}
if(isset($_GET['scriptid'])){
    $scriptid = $_GET['scriptid'];
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
        $getscriptidqry = mysqli_query($link, "SELECT * FROM schedules WHERE id = $schedid");
        while($row = mysqli_fetch_array($getscriptidqry)){
            $scriptid = $row['scriptid'];
        }
        $getscriptqry = mysqli_query($link, "SELECT * FROM scripts WHERE id = $scriptid");
        while($row = mysqli_fetch_array($getscriptqry)){
            $shell = $row['shell'];
            $script = $row['data'];
        }
        $date = new \DateTime();
        $datenow = $date->format("Y-m-d H:i:s");
        $sql = "UPDATE schedules SET rantime = ?, status = 'runnning' WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "si", $datenow, $schedid);
            if(mysqli_stmt_execute($stmt)){
                echo "$shell:$script";
                exit();
            } else{
                echo 0;
            }
        }
    }
}