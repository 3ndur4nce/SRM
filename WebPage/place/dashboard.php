<div class="dashcollumn">
    <h1>Événements par Occurence</h1>
    <table class="dashtable">
    <tr>
        <th>Source</th>
        <th>Log</th>
        <th>Eventid</th>
        <th>Occurence</th>
    </tr>
<?php

$getcltqry = mysqli_query($link, "SELECT *,COUNT(*) FROM entries WHERE section = 'eventvwr' GROUP BY data2, data3, data4 ORDER BY COUNT(*) DESC");
while($row = mysqli_fetch_array($getcltqry)){
    echo "<tr>";
    echo "<th>".$row['data2']."</th>";
    echo "<th>".$row['data3']." ".$row['data4']."</th>";
    echo "<th>".$row['data1']."</th>";
    echo "<th>".$row['COUNT(*)']."</th>";
    echo "</tr>";
}

?>
    </table>
</div>
<div class="dashcollumn">
    <h1>Éléments à surveiller</h1>
<?php

$getcltqry = mysqli_query($link, "SELECT * FROM checks");
while($row = mysqli_fetch_array($getcltqry)){
    echo "<a class='collumnbutton' href='?a=ckvw&chk=".$row['id']."'>".$row['name']."</a><br>";
}

?>
</div>