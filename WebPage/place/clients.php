<div class="launchcollumn">
    <a>Clients</a><br>
    <?php
    
    $getcltqry = mysqli_query($link, "select * from clients where active=1 ORDER BY full_name ASC");
    while($row = mysqli_fetch_array($getcltqry)){
        echo "<a href='?a=clients&clt=".$row['id']."' class='collumnbutton'>".$row['full_name']."</a>";
    }

    ?>
</div>

<?php

if(isset($cltid)){
    echo "<div class='launchcollumn'>";
    echo "<a>Infos</a>";
    $getreqqry = mysqli_query($link, "SELECT * from clients where id = $cltid");
    while($row = mysqli_fetch_array($getreqqry)){
        echo "<a class='collumnbutton'>Nom complet: ".$row['full_name']."</a>";
        echo "<a class='collumnbutton'>Préfix: ".$row['prefix']."</a>";
        echo "<a class='collumnbutton'>Identifiant CRM: ".$row['num']."</a>";
    }
    echo "<a class='button button-left'>Sauvegarder</a>";
    echo "<a class='button button-left'>Désactiver</a>";
    echo "</div>";
}


?>