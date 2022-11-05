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
}elseif($place == "scripts" && $do == "scriptedit"){
    if(isset($script)){
        $shell = trim($_POST["shell"]);
        $data = trim($_POST["script"]);
        $editscript = "UPDATE scripts set shell = ?, data = ? where id = $script";
        if($stmt = mysqli_prepare($link, $editscript)){
            mysqli_stmt_bind_param($stmt, "ss", $shell, $data);
            if(mysqli_stmt_execute($stmt)){
                header("location: ?a=scripts&script=$script");
                exit;
            }else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
    }
}