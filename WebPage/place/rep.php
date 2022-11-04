<?php

$getcltqry = mysqli_query($link, "SELECT * from entries where repportid = $rep AND section = 'Server'");
while($row = mysqli_fetch_array($getcltqry)){
    $servername = $row['data1'];
    $repdate = $row['data2'];
}

?>
<div class="repcollumn">
    <a class="reptitle"><?php echo $servername; ?> <?php echo $repdate; ?></a>

    <a class="reptitle2">Performance</a>
    <table class="reptable">
        <tr>
            <th>CPU / Utilisation</th>
            <th>RAM / Utilisation</th>
            <th>Disques / Espace Disponible</th>
        </tr>
    <?php
    $getappqry = mysqli_query($link, "SELECT * from entries where repportid = $rep AND servername = '$servername' AND section = 'SystemInfo'");
    while($row = mysqli_fetch_array($getappqry)){
        echo "
        <tr>
            <th>".$row['data2']."</th>
            <th>".$row['data3']."</th>
            <th>".$row['data4']."</th>
        </tr>
        ";
    }
    ?>

    <a class="reptitle2">Applications</a>
    <table class="reptable">
        <tr>
            <th>Nom</th>
            <th>Emplacement</th>
            <th>Désinstallé</th>
        </tr>
    <?php
    $getappqry = mysqli_query($link, "SELECT * from entries where repportid = $rep AND servername = '$servername' AND section = 'Apps'");
    while($row = mysqli_fetch_array($getappqry)){
        echo "
        <tr>
            <th>".$row['data1']."</th>
            <th>".$row['data2']."</th>
            <th>".$row['data3']."</th>
        </tr>
        ";
    }
    ?>
    </table>
    <a class="reptitle2">Event Log</a>
    <table class="reptable">
        <tr>
            <th>Log</th>
            <th>Sévérité</th>
            <th>Source</th>
            <th>Dernière Occurence</th>
            <th>EventID</th>
            <th>Occurence</th>
        </tr>
    <?php
    $getevntqry = mysqli_query($link, "SELECT *,COUNT(*) from entries where repportid = $rep AND servername = '$servername' AND section = 'eventvwr' GROUP BY data2");
    while($row = mysqli_fetch_array($getevntqry)){
        $style = "";
        $style2 = "";
        if($row['COUNT(*)'] > 50 && $row['COUNT(*)'] < 150){
            $style = "style='background-color:yellow;'";
        }elseif($row['COUNT(*)'] > 149 && $row['COUNT(*)'] < 500){
            $style = "style='background-color:red;'";
        }elseif($row['COUNT(*)'] > 499){
            $style = "style='background-color:darkred;'";
            $style2 = "style='background-color:darkred;'";
        }elseif($row['COUNT(*)'] < 5){
            continue;
        }
        echo "
        <tr>
            <th $style2>".$row['data3']."</th>
            <th $style2>".$row['data4']."</th>
            <th $style2 class='tooltip'>".$row['data2']."
                <span class='tooltiptext'>".$row['data6']."</span>
            </th>
            <th $style2>".$row['data5']."</th>
            <th $style2>".$row['data1']."</th>
            <th $style>".$row['COUNT(*)']."</th>
        </tr>
        ";
    }
    ?>
    </table>
    </table>
    <a class="reptitle2">Certificats</a>
    <table class="reptable">
        <tr>
            <th>Nom Commun</th>
            <th>Expiration</th>
            <th>Thmubprint</th>
        </tr>
    <?php
    $getevntqry = mysqli_query($link, "SELECT * from entries where repportid = $rep AND servername = '$servername' AND section = 'Certificates'");
    while($row = mysqli_fetch_array($getevntqry)){
        echo "
        <tr>
            <th>".$row['data1']."</th>
            <th>".$row['data2']."</th>
            <th>".$row['data3']."</th>
        </tr>
        ";
    }
    echo "</table>";

    $getveeamqry = mysqli_query($link, "SELECT * from entries where repportid = $rep AND servername = '$servername' AND section = 'Veeam'");
    if (mysqli_num_rows($getveeamqry) > 0){
        echo "<a class='reptitle2'>État Veeam</a>
        <table class='reptable'>
            <tr>
                <th>Nom de la tâche</th>
                <th>Erreurs dans le dernier mois</th>
                <th>Avertissements dans le dernier mois</th>
                <th>Dernière exécution</th>
                <th>Type de repo</th>
                <th>Dernier résultat</th>
            </tr>";
        while($row = mysqli_fetch_array($getveeamqry)){
            echo "
            <tr>
                <th>".$row['data1']."</th>
                <th>".$row['data2']."</th>
                <th>".$row['data3']."</th>
                <th>".$row['data4']."</th>
                <th>".$row['data5']."</th>
                <th>".$row['data6']."</th>
            </tr>
            ";
        }
        echo "</table>";
    }

    $getveeamqry = mysqli_query($link, "SELECT * from entries where repportid = $rep AND servername = '$servername' AND section = 'VMwareHosts'");
    if (mysqli_num_rows($getveeamqry) > 0){
        echo "<a class='reptitle2'>Hôtes VMware</a>
        <table class='reptable'>
            <tr>
                <th>Nom d'hôte</th>
                <th>Utilisation du CPU</th>
                <th>Utilisation de la RAM</th>
                <th>Version</th>
            </tr>";
        while($row = mysqli_fetch_array($getveeamqry)){
            echo "
            <tr>
                <th>".$row['data1']."</th>
                <th>".$row['data2']."</th>
                <th>".$row['data3']."</th>
                <th>".$row['data4']."</th>
            </tr>
            ";
        }
        echo "</table>";
    }

    $getveeamqry = mysqli_query($link, "SELECT * from entries where repportid = $rep AND servername = '$servername' AND section = 'VMwareVMs'");
    if (mysqli_num_rows($getveeamqry) > 0){
        echo "<a class='reptitle2'>VM sans démarrage automatique</a>
        <table class='reptable'>
            <tr>
                <th>Nom</th>
                <th>Démarrage</th>
            </tr>";
        while($row = mysqli_fetch_array($getveeamqry)){
            echo "
            <tr>
                <th>".$row['data1']."</th>
                <th>".$row['data2']."</th>
            </tr>
            ";
        }
        echo "</table>";
    }

    $getveeamqry = mysqli_query($link, "SELECT * from entries where repportid = $rep AND servername = '$servername' AND section = 'VMwareDatastores'");
    if (mysqli_num_rows($getveeamqry) > 0){
        echo "<a class='reptitle2'>Datastores VMware</a>
        <table class='reptable'>
            <tr>
                <th>Nom</th>
                <th>Espace libre</th>
                <th>Espace total</th>
            </tr>";
        while($row = mysqli_fetch_array($getveeamqry)){
            echo "
            <tr>
                <th>".$row['data1']."</th>
                <th>".$row['data2']."</th>
                <th>".$row['data3']."</th>
            </tr>
            ";
        }
        echo "</table>";
    }

    $getveeamqry = mysqli_query($link, "SELECT * from entries where repportid = $rep AND servername = '$servername' AND section = 'VMwareAlerts'");
    if (mysqli_num_rows($getveeamqry) > 0){
        echo "<a class='reptitle2'>Alertes VMware</a>
        <table class='reptable'>
            <tr>
                <th>Titre</th>
                <th>Description</th>
                <th>Temps</th>
            </tr>";
        while($row = mysqli_fetch_array($getveeamqry)){
            echo "
            <tr>
                <th>".$row['data1']."</th>
                <th>".$row['data2']."</th>
                <th>".$row['data3']."</th>
            </tr>
            ";
        }
        echo "</table>";
    }

    ?>
    </table>
</div>