<div class="launchcollumn">
    <a>Scripts</a><br>
    <?php
    
    $getscriptsqry = mysqli_query($link, "select * from scripts ORDER BY name ASC");
    while($row = mysqli_fetch_array($getscriptsqry)){
        echo "<a href='?a=scripts&script=".$row['id']."' class='collumnbutton'>".$row['name']."</a>";
    }

    ?>
</div>