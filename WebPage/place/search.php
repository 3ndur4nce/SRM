<form action="?a=search" method="post">
        <input type="text" name="searchstring" class="searchbar" placeholder="Rechercher"></input>
        <input type="submit" class="button button-right" value="Go">
</form>
<?php

if(isset($searchstring)){
    $getresqry = mysqli_query($link, "SELECT * FROM entries WHERE (
        data1 LIKE '%$searchstring%' OR
        data2 LIKE '%$searchstring%' OR
        data3 LIKE '%$searchstring%' OR
        data4 LIKE '%$searchstring%' OR
        data5 LIKE '%$searchstring%' OR
        data6 LIKE '%$searchstring%' OR
        data7 LIKE '%$searchstring%')");
    while($row = mysqli_fetch_array($getresqry)){
        echo "<a class='collumnbutton'>".$row['data1']." ".$row['data2']." ".$row['data3']." ".$row['data4']." ".$row['data5']." ".$row['data6']." ".$row['data7']."</a><br>";
    }
}
?>