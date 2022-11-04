<?php

require_once "../../config.php";

if(isset($_GET['do'])){
    $do = $_GET['do'];
}
if(isset($_GET['hostname'])){
    $hostname = $_GET['hostname'];
}

$authorisationheader = getallheaders()['Authorization'];

$getauthqry = mysqli_query($link, "SELECT 1 FROM installs WHERE secret = '$authorisationheader' LIMIT 1");
while($row = mysqli_fetch_array($getauthqry)){
    if($row['1'] == '1'){
        $auth = 'ok';
    }
}

if($auth == 'ok'){
    $getsecretqry = mysqli_query($link, "SELECT * from installs where secret = '$authorisationheader'");
    while($row = mysqli_fetch_array($getsecretqry)){
        $timegenerated = $row['timegenerated'];
        $userid = $row['userid'];
    }
    $getuserqry = mysqli_query($link, "SELECT * from users where id = $userid");
    while($row = mysqli_fetch_array($getuserqry)){
        $active = $row['active'];
    }
    if(isset($do)){
        if($do == "newasset" && isset($hostname)){
            $assetsecret = substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', mt_rand(1,250))), 1, 250);
            $addasset = "INSERT INTO assets (name, token) values (?, ?)";
            if($stmt = mysqli_prepare($link, $addasset)){
                mysqli_stmt_bind_param($stmt, "ss", $hostname, $assetsecret);
                if(mysqli_stmt_execute($stmt)){
                    echo $assetsecret;
                    exit;
                }else{
                    echo "1";
                }
            }
        }
    }
}
