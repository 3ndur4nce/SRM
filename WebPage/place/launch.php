<div class="launchcollumn">
    <a>Maintenances</a><br>
    <?php
    $getreqqry = mysqli_query($link, "select * from request where approved!=3");
    while($row = mysqli_fetch_array($getreqqry)){
        echo "<a href='?a=launch&req=".$row['id']."' class='collumnbutton'>".$row['servername']." ".$row['treated_by']."</a>";
        $approved = $row['approved'];
        $servername = $row['servername'];
        $treated_by = $row['treated_by'];
        $clientid = $row['clientid'];
    }
    ?>
</div>
<?php

if(isset($req)){
    $getreqqry = mysqli_query($link, "select * from request where id = $req");
    while($row = mysqli_fetch_array($getreqqry)){
        $approved = $row['approved'];
        $servername = $row['servername'];
        $treated_by = $row['treated_by'];
        $clientid = $row['clientid'];
    }
    $getcltqry = mysqli_query($link, "select * from clients where id=$clientid");
    while($row = mysqli_fetch_array($getcltqry)){
        $clientname = $row['full_name'];
    }
    echo "
    <div class='launchcollumn'>
    <a>Info</a><br>
    <a>Serveur Maitre: $servername</a></br>
    <a>Traité par: $treated_by</a></br>";
    if($approved == 0){
        echo "
        <a href='?a=launch&req=$req&acc=yes' class='collumnbutton'>accepter</a>";
    }elseif($approved == 1){
        echo "<a>Status: Accepted</a><br>";
        if($clientid != 0){
            echo "<a href='?a=launch&req=$req&acc=class' class='collumnbutton'>Client: $clientname</a><br>";
            echo "<a href='?a=launch&req=$req&acc=rapp' class='collumnbutton'>Serveurs/Équipements</a>";
            #echo "<a href='?a=launch&req=$req&acc=reqend' class='collumnbutton'>Terminer la maintenance</a>";
            #echo "<a href='?a=launch&req=$req&acc=reqcont' class='collumnbutton'>Continuer la maintenance</a>";
        }else{
            echo "<a href='?a=launch&req=$req&acc=class' class='collumnbutton'>Choisir Client</a>";
        }
    }else{
        echo "<a>Status: Refusé</a><br>";
    }
    echo "</div>";
}
if(isset($acc)){
    if($acc == "class"){
        echo "
        <div class='launchcollumn'>
        <a>Choisir Client</a>";
        $getclientqry = mysqli_query($link, "select * from clients where active = 1 ORDER BY full_name ASC");
        while($row = mysqli_fetch_array($getclientqry)){
            echo "<a href='?a=launch&acc=cltclass&req=$req&clt=".$row['id']."' class='collumnbutton'>".$row['full_name']."</a><br>";
        }
        echo "</div>";
    }elseif($acc == "rapp"){
        echo "
        <div class='launchcollumn'>
        <a>Serveurs</a><br>";
        $getreppqry = mysqli_query($link, "select * from repports where reqid = $req AND repstat = 0");
        while($row = mysqli_fetch_array($getreppqry)){
            if($row['id'] == $rep){$repselect = "background-color:black;color:white";}
            echo "<a href='?a=launch&acc=rapp&req=$req&rep=".$row['id']."' class='collumnbutton' style='$repselect'>".$row['server_name']."</a><br>";
            $repselect = "";
            $thereisvalue = 1;
        }
        echo "<a href='?a=launch&acc=rapp&req=$req&rep=new' class='collumnbutton'>Ajouter</a><br>";
        if($thereisvalue != 1){
            echo "<a href='?a=launch&acc=rapp&req=$req&rep=done' class='collumnbutton'>Terminer la maintenance</a><br>";
        }
        echo "</div>";
    }
}
if(isset($rep)){
    if($rep == "new"){
        if(isset($dvctp)){
            $getdevicesqry = mysqli_query($link, "select * from devicetypes where id=$dvctp");
            while($row = mysqli_fetch_array($getdevicesqry)){
                $devicetype = ": ".$row['name'];
            }
        }
        echo "
        <a>Nouveau Serveur/Équipement</a>
        <div class='launchcollumn'>
        <form action='?a=launch&acc=rapp&req=$req&rep=new&dvctp=$dvctp' method='post'>
        <input type='text' name='name' class='input' placeholder='Nom'><input type='submit' class='button' placeholder='value'><br>
        <div class='inputbtn'><a class='collumnbutton'>Type appareil$devicetype</a>";
        $getdevicesqry = mysqli_query($link, "select * from devicetypes");
        while($row = mysqli_fetch_array($getdevicesqry)){
            echo "<span><a class='inputbtn-content' href='?a=launch&acc=rapp&req=$req&rep=new&dvctp=".$row['id']."'>".$row['name']."</a></span>";
        }
        echo "</div>
        </input>
        </form>";
        echo "</div>";
    }else{
        echo "
        <div class='launchcollumn'>
        <a>Étapes</a>";
        $getrepportqry = mysqli_query($link, "select * from repports where id = $rep");
        while($row = mysqli_fetch_array($getrepportqry)){
            $stepsdone = $row['stepsdone'];
            $servername = $row['server_name'];
            $devicetype = $row['devicetype'];
        }
        echo "<a class='collumnbutton'>".$servername."</a><br>";
        $getstepsqry = mysqli_query($link, "select * from steps where eqqtypes LIKE '%$devicetype%'");
        while($row = mysqli_fetch_array($getstepsqry)){
            $rowname = $row['name'];
            $rowid = $row['id'];
            if(strpos("$stepsdone", "<$rowid>")){
                echo "<div class='collumnsection'>$rowname<a href='?a=launch&acc=rapp&req=$req&rep=$rep&stpdn=$rowid' class='button-small success'>Fait ✓</a></div><br>";
            }else{
                echo "<div class='collumnsection'>$rowname<a href='?a=launch&acc=rapp&req=$req&rep=$rep&stpdn=$rowid' class='button-small neutral'>Fait</a></div><br>";
                $notdone = 1;
            }
        }
        if(!isset($notdone)){
            echo "<div class='collumnsection'>Équipement terminé<a href='?a=launch&acc=rapp&req=$req&rep=$rep&repdn=1' class='button-small neutral'>Fait</a></div><br>";
        }
        echo "</div>";
    }
}
?>