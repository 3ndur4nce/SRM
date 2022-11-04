<div class="dashcollumn">
<?php

$getckqry = mysqli_query($link, "SELECT * FROM checks WHERE id = $chk");
while($row = mysqli_fetch_array($getckqry)){
    $chkname = $row['name'];
    $chksection = $row['section'];
    $chkstring = $row['string'];
}
echo "<a>Rappports avec des résultats</a>";
$getentryqry = mysqli_query($link, "SELECT * FROM entries WHERE section = '$chksection' AND (
    data1 LIKE '%$chkstring%' OR
    data2 LIKE '%$chkstring%' OR
    data3 LIKE '%$chkstring%' OR
    data4 LIKE '%$chkstring%' OR
    data5 LIKE '%$chkstring%' OR
    data6 LIKE '%$chkstring%' OR
    data7 LIKE '%$chkstring%') GROUP BY repportid");
while($row = mysqli_fetch_array($getentryqry)){
    $getreqid = mysqli_query($link, "SELECT * FROM repports WHERE id = ".$row['repportid']);
    while($row = mysqli_fetch_array($getreqid)){
        $repid = $row['id'];
        $reqid = $row['reqid'];
        $reptime = $row['inserted'];
    }
    $getcltid = mysqli_query($link, "SELECT * FROM request WHERE id = $reqid");
    while($row = mysqli_fetch_array($getcltid)){
        $clientid = $row['clientid'];
    }
    $getclient = mysqli_query($link, "SELECT * FROM clients WHERE id = $clientid");
    while($row = mysqli_fetch_array($getclient)){
        $clientname = $row['full_name'];
    }
    echo "<a href='?a=ckvw&chk=$chk&repid=$repid' class='collumnbutton'>$clientname $reptime</a>";
}

?>
</div>
<div class="dashcollumn">
<?php
    if(!isset($repportid)){
        echo "<h1>Éléments à surveiller</h1>";
        $getcltqry = mysqli_query($link, "SELECT * FROM checks");
        while($row = mysqli_fetch_array($getcltqry)){
            echo "<a class='collumnbutton' href='?a=ckvw&chk=".$row['id']."'>".$row['name']."</a><br>";
        }
    }else{
        echo $chkname;
        $getresqry = mysqli_query($link, "SELECT * FROM entries WHERE section = '$chksection' AND repportid = $repportid AND (
            data1 LIKE '%$chkstring%' OR
            data2 LIKE '%$chkstring%' OR
            data3 LIKE '%$chkstring%' OR
            data4 LIKE '%$chkstring%' OR
            data5 LIKE '%$chkstring%' OR
            data6 LIKE '%$chkstring%' OR
            data7 LIKE '%$chkstring%')");
        while($row = mysqli_fetch_array($getresqry)){
            echo "<a class='collumnbutton'>".$row['data1']." ".$row['data2']." ".$row['data3']." ".$row['data4']." ".$row['data5']." ".$row['data6']." ".$row['data7']."</a><br>";
        }
    }
    

?>
</div>