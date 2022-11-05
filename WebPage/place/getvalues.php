<?php

$currentusr = $_SESSION["username"];
$isadminqry = mysqli_query($link, "select * from users where username='".$currentusr."'");
while($row = mysqli_fetch_array($isadminqry)){
  $admin = $row['admin'];
  $userid = $row['id'];
}

if(isset($_GET['a'])){
    $place = $_GET['a'];
}
if(isset($_GET['asset'])){
    $asset = $_GET['asset'];
}
if(isset($_GET['do'])){
    $do = $_GET['do'];
}
if(isset($_GET['sched'])){
    $sched = $_GET['sched'];
}
if(isset($_GET['newscriptid'])){
    $newscriptid = $_GET['newscriptid'];
}
if(isset($_GET['script'])){
    $script = $_GET['script'];
}
if(isset($_GET['req'])){
    $req = trim($_GET['req']);
}
if(isset($_GET['acc'])){
    $acc = trim($_GET['acc']);
}
if(isset($_GET['clt'])){
    $cltid = trim($_GET['clt']);
}
if(isset($_GET['rep'])){
    $rep = trim($_GET['rep']);
}
if(isset($_GET['usr'])){
    $usr = trim($_GET['usr']);
}
if(isset($_GET['chk'])){
    $chk = trim($_GET['chk']);
}
if(isset($_GET['repid'])){
    $repportid = trim($_GET['repid']);
}
if(isset($_GET['searchstring'])){
    $searchstring = trim($_GET['searchstring']);
}
if(isset($_GET['dvctp'])){
    $dvctp = trim($_GET['dvctp']);
}
if(isset($_GET['stpdn'])){
    $stpdn = trim($_GET['stpdn']);
}
if(isset($_GET['repdn'])){
    $repdn = trim($_GET['repdn']);
}

if($place == "logout"){
    session_destroy();
    header("Refresh:0");
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    require "place/postactions.php";
}

if(isset($place)){
    if($place == 'delscript'){
        $delscriptqry = "DELETE FROM scripts WHERE id = ?";
        if($stmt = mysqli_prepare($link, $delscriptqry)){
            mysqli_stmt_bind_param($stmt, "i", $script);
            if(mysqli_stmt_execute($stmt)){
                header("location: ?a=scripts");
                exit;
            }else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
    }
}

require "place/theme.php";

?>