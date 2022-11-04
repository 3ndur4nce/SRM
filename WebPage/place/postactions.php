<?php
if($place == "search"){
    $searchstring = trim($_POST["searchstring"]);
    header("location: ?a=search&searchstring=$searchstring");
    exit();
}elseif($place == "launch"){
    if(isset($dvctp)){
        $newname = trim($_POST["name"]);
        $addrepport = "INSERT INTO repports (reqid, server_name, devicetype) values ($req, ?, ?)";
        if($stmt = mysqli_prepare($link, $addrepport)){
            mysqli_stmt_bind_param($stmt, "si", $newname, $dvctp);
            if(mysqli_stmt_execute($stmt)){
                header("location: ?a=launch&acc=rapp&req=$req&acc=rapp");
                exit;
            }else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
    }
}