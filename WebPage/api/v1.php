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

if(isset($_GET['a'])){
    $a = $_GET['a'];
}
if(isset($_GET['srvnm'])){
    $srvnm = trim($_GET['srvnm']);
}
if(isset($_GET['usrnm'])){
    $usrnm = trim($_GET['usrnm']);
}
if(isset($_GET['pwd'])){
    $pwd = trim($_GET['pwd']);
}
if(isset($_GET['sct'])){
    $sct = trim($_GET['sct']);
}
if(isset($_GET['technm'])){
    $technm = trim($_GET['technm']);
}
if(isset($_GET['kee'])){
    $kee = trim($_GET['kee']);
}
if(isset($_GET['scrpt'])){
    $scrpt = trim($_GET['scrpt']);
}

$getreqqry = mysqli_query($link, "SELECT * from request where servername = '$usrnm' AND passwd = '$pwd'");
while($row = mysqli_fetch_array($getreqqry)){
  $reqid = $row['id'];
}

if($a == "reqacc" & $kee == "alsdjhfawer34667847694742456sgdfgraereajek"){
    $instreq = "INSERT into request (tech, servername, passwd) values (?, ?, ?)";
    if($stmt = mysqli_prepare($link, $instreq)){
        mysqli_stmt_bind_param($stmt, "sss", $technm, $usrnm, $pwd);
        if(mysqli_stmt_execute($stmt)){
            echo 1;
        }else{
            echo "noreqacc";
        }
    }
}
if($a == "accdoi" & $kee == "alsdjhfawer34667847694742456sgdfgraereajek"){
    $getreqqry = mysqli_query($link, "SELECT * from request where servername = '$usrnm' AND passwd = '$pwd'");
    while($row = mysqli_fetch_array($getreqqry)){
        echo $row['approved'];
    }
}
if($a == "addentry" & $reqid != ""){
    $getrepqry = mysqli_query($link, "SELECT EXISTS(SELECT * from repports where reqid = '$reqid' AND server_name = '$srvnm')");
    while($row = mysqli_fetch_array($getrepqry)){
        $repext = $row[0];
    }
    if($repext == 1){
        $getrepqry = mysqli_query($link, "SELECT * from repports where reqid = '$reqid' AND server_name = '$srvnm'");
        while($row = mysqli_fetch_array($getrepqry)){
            $repid = $row['id'];
            $cltid = $row['client_id'];
        }
    }else{
        $instrep = "INSERT into repports (reqid, server_name, devicetype) values (?, ?, ?)";
        if($stmt = mysqli_prepare($link, $instrep)){
            $devicetype = 1;
            mysqli_stmt_bind_param($stmt, "isi", $reqid, $srvnm, $devicetype);
            if(mysqli_stmt_execute($stmt)){
            }else{
            }
        }
        $getrepqry = mysqli_query($link, "SELECT * from repports where reqid = '$reqid' AND server_name = '$srvnm'");
        while($row = mysqli_fetch_array($getrepqry)){
            $repid = $row['id'];
            $cltid = $row['client_id'];
        }
    }

    $data = explode(',', $_POST["data"]);
    $data1 = $data[0];
    $data2 = $data[1];
    $data3 = $data[2];
    $data4 = $data[3];
    $data5 = $data[4];
    $data6 = $data[5];
    $data7 = $data[6];

    $instentry = "INSERT into entries (repportid, servername, section, data1, data2, data3, data4, data5, data6, data7) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    if($stmt = mysqli_prepare($link, $instentry)){
        mysqli_stmt_bind_param($stmt, "isssssssss", $repid, $srvnm, $sct, $data1, $data2, $data3, $data4, $data5, $data6, $data7);
        if(mysqli_stmt_execute($stmt)){
            echo 1;
        }else{
            echo "noinsertentry";
        }
    }
}
if($a == "getscript" & $reqid != ""){
    if($scrpt == "start"){
        $script = file_get_contents("/home/maintenance/repo/dev/startup");
        $myfile = fopen("/home/maintenance/repo/dev/startup", "r") or die("Unable to open file!");
        echo fread($myfile,filesize("/home/maintenance/repo/dev/startup"));
        fclose($myfile);
    }elseif($scrpt == "mod"){
        $script = file_get_contents("/home/maintenance/repo/dev/modules");
        $myfile = fopen("/home/maintenance/repo/dev/modules", "r") or die("Unable to open file!");
        echo fread($myfile,filesize("/home/maintenance/repo/dev/modules"));
        fclose($myfile);
    }
}
?>