<div class="launchcollumn">
    <a>Clients</a><br>
    <?php
    
    $getcltqry = mysqli_query($link, "select * from clients where active=1 ORDER BY full_name ASC");
    while($row = mysqli_fetch_array($getcltqry)){
        echo "<a href='?a=repports&clt=".$row['id']."' class='collumnbutton'>".$row['full_name']."</a>";
    }

    ?>
</div>

<?php

if(isset($cltid)){
    echo "<div class='launchcollumn'>";
    echo "<a>Maintenances</a>";
    $getreqqry = mysqli_query($link, "SELECT * from request where clientid = $cltid ORDER BY timestamp DESC");
    while($row = mysqli_fetch_array($getreqqry)){
        echo "<a href='?a=repports&clt=$cltid&req=".$row['id']."' class='collumnbutton'>".$row['timestamp']."</a>";
    }
    echo "</div>";
}

if(isset($req)){
    echo "<div class='launchcollumn'>";
    echo "<a>Rapports</a>";
    $getrepqry = mysqli_query($link, "SELECT * from repports where reqid = $req ORDER BY inserted DESC");
    while($row = mysqli_fetch_array($getrepqry)){
        echo "<a href='?a=repports&clt=$cltid&req=$req&rep=".$row['id']."' class='collumnbutton'>".$row['server_name']."</a>";
    }
    echo "</div>";
}

if(isset($rep)){
    require "place/rep.php";
}

?>