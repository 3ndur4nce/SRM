<div class="launchcollumn">
    <a>Vérifications</a><br>
    <?php
    
    $getcltqry = mysqli_query($link, "select * from checks");
    while($row = mysqli_fetch_array($getcltqry)){
        echo "<a href='?a=cklst&chk=".$row['id']."' class='collumnbutton'>".$row['name']."</a>";
    }
    echo "<a href='?a=cklst&chkadd' class='button'>Ajouter</a>";

    ?>
</div>

<?php

if(isset($chk)){
    echo "<div class='launchcollumn'>";
    echo "<a>Visualiser</a>";
    $getreqqry = mysqli_query($link, "SELECT * from checks where id = $chk");
    while($row = mysqli_fetch_array($getreqqry)){
        echo "<a href='?a=repports&clt=$cltid&req=".$row['id']."' class='collumnbutton'>Titre: ".$row['name']."</a>";
        echo "<a href='?a=repports&clt=$cltid&req=".$row['id']."' class='collumnbutton'>Section: ".$row['section']."</a>";
        echo "<a href='?a=repports&clt=$cltid&req=".$row['id']."' class='collumnbutton'>Valeur: ".$row['string']."</a>";
    }
    echo "</div>";
}

if(isset($_GET['chkadd'])){
    echo "<div class='launchcollumn'>";
    echo "<a>Ajouter une vérification</a>";
    echo "</div>";
}

?>