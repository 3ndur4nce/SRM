<head>
    <link rel="stylesheet" href="style.css">
</head>

<body class="body">
    <maincontent class="maincontent">
        <header class="headerbox">
            <img src="images/Umbrella MAAS 2.png" class="headerlogo">
            <div class="toprightmenu">
                <a href="?a=logout" class="button button-right">Logout</a>
                <a onClick="<?php if(!isset($place)){ echo "javascript:history.go(0)"; }else{ echo "javascript:history.go(-1)"; } ?>" class="button button-right">Retour</a>
                <a onClick="window.location.reload()" class="button button-right">Rafraichir</a>
            </div>
        </header>
        <leftmenu class="leftmenubox">
            <a href="?" class="leftmenumenu">Dashboard</a><br>
            <a href="?a=launch" class="leftmenumenu">Exécution</a><br>
            <a href="?a=clients" class="leftmenumenu">Clients</a><br>
            <a href="?a=repports" class="leftmenumenu">Rapports</a><br>
            <a href="?a=search" class="leftmenumenu">Recherche</a><br>
            <hr>
            <?php

            if($admin == 1) {
                echo "
                <a href='?a=cklst' class='leftmenumenu'>Vérifications</a><br>
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
            
            if($place == "launch"){
                require "place/launch.php";
            }elseif($place == "clients"){
                require "place/clients.php";
            }elseif($place == "users" & $admin == 1){
                require "place/users.php";
            }elseif($place == "repports"){
                require "place/repports.php";
            }elseif($place == "cklst"){
                require "place/checks.php";
            }elseif($place == "ckvw"){
                require "place/alerts.php";
            }elseif($place == "search"){
                require "place/search.php";
            }elseif($place == "bug"){
                require "place/bug.php";
            }else{
                require "place/dashboard.php";
            }
            
            ?>
        </bodycontent>
    </maincontent>
</body>
