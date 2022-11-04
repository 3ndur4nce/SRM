<?php
if($place == "assets" && $sched == "save"){
    if(isset($newscriptid)){
        $schedtime = trim($_POST["datetime"]);
        $addsched = "INSERT INTO schedules (assetid, scriptid, runtime, userid) values (?, ?, ?, ?)";
        if($stmt = mysqli_prepare($link, $addsched)){
            mysqli_stmt_bind_param($stmt, "iisi", $asset, $newscriptid, $schedtime, $userid);
            if(mysqli_stmt_execute($stmt)){
                header("location: ?a=assets&asset=$asset&do=scripts");
                exit;
            }else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
    }
}