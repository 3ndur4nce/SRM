<div class="launchcollumn">
    <a>Utilisateurs</a><br>
    <?php
    
    $getcltqry = mysqli_query($link, "select * from users where active=1 AND username != 'ittech'");
    while($row = mysqli_fetch_array($getcltqry)){
        echo "<a href='?a=users&usr=".$row['id']."' class='collumnbutton'>".$row['username']."</a>";
    }

    ?>
</div>

<?php

if(isset($usr)){
    echo "<div class='launchcollumn'>";
    echo "<a>Infos</a>";
    $getreqqry = mysqli_query($link, "SELECT * from users where id = $usr");
    while($row = mysqli_fetch_array($getreqqry)){
        if($row['admin'] == 1){$admin = "Oui";}else{$admin = "Non";}
        echo "<a class='collumnbutton'>Nom d'utilisateur: ".$row['username']."</a>";
        echo "<a class='collumnbutton'>Admin: ".$admin."</a>";
    }
    echo "<a class='button button-left'>Reset MDP</a>";
    echo "<a class='button button-left'>Désactiver</a>";
    echo "<a class='button button-left'>Admin</a>";
    echo "</div>";
}


?>