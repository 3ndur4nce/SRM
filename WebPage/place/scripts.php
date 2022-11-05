<div class="launchcollumn">
    <a>Scripts</a><br>
    <?php
    
    $getscriptsqry = mysqli_query($link, "select * from scripts ORDER BY name ASC");
    while($row = mysqli_fetch_array($getscriptsqry)){
        echo "<a href='?a=scripts&script=".$row['id']."' class='collumnbutton'>".$row['name']."</a>";
    }
echo "</div>";

    if(isset($script)){
        $getscriptsqry = mysqli_query($link, "select * from scripts where id = $script");
        while($row = mysqli_fetch_array($getscriptsqry)){
            $scriptname = $row['name'];
            $scriptdata = $row['data'];
            $shell = $row['shell'];
        }
        if($shell == 'powershell'){
            $powershell = "powershell' selected='selected";
            $cmd = "cmd";
            $bash = "bash";
        }elseif($shell == 'cmd'){
            $powershell = "powershell";
            $cmd = "cmd' selected='selected";
            $bash = "bash";
        }elseif($shell == 'bash'){
            $powershell = "powershell";
            $cmd = "cmd";
            $bash = "bash' selected='selected";
        }
        echo "<div class='editcollumn'>
        <a>$scriptname</a><br>
        <form action='?a=scripts&script=$script&do=scriptedit' method='POST'>
            <select id='shell' name='shell'>
                <option value='$cmd'>CMD</option>
                <option value='$powershell'>PowerShell</option>
                <option value='$bash'>BASH</option>
            </select><br>
            <textarea type='longtext' name='script' class='input-script' placeholder='Enter Script Here'>$scriptdata</textarea>
            <input type='submit' class='button' value='Save'>
            </form>
        ";
    }