<head>
    <link rel="stylesheet" href="style.css">
</head>

<body class="body">
    <maincontent class="maincontent">
        <header class="headerbox">
            <img src="images/Umbrella MAAS 2.png" class="headerlogo">
            <div class="toprightmenu">
                <a href="?a=logout" class="button button-right">Logout</a>
                <a onClick="<?php if(!isset($place)){ echo "javascript:history.go(0)"; }else{ echo "javascript:history.go(-1)"; } ?>" class="button button-right">Back</a>
                <a onClick="window.location.reload()" class="button button-right">Refresh</a>
            </div>
        </header>
        <leftmenu class="leftmenubox">
            <a href="?" class="leftmenumenu">Dashboard</a><br>
            <a href="?a=assets" class="leftmenumenu">Assets</a><br>
            <a href="?a=scripts" class="leftmenumenu">Scripts</a><br>
            <hr>
            <?php

            if($admin == 1) {
                echo "
                <a href='?a=users' class='leftmenumenu'>Utilisateurs</a><br>
                ";
            }

            ?>
        </leftmenu>
        <info class="bottomleftbox">
             <a href="?a=bug">Problèmes</a>
        </info>
        <bodycontent class="contentbox">
            <?php
            
            if($place == "assets"){
                require "place/assets.php";
            }elseif($place == "scripts"){
                require "place/scripts.php";
            }elseif($place == "users" & $admin == 1){
                require "place/users.php";
            }elseif($place == "bug"){
                require "place/bug.php";
            }else{
                require "place/dashboard.php";
            }
            
            ?>
        </bodycontent>
    </maincontent>
</body>
