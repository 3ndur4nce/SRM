<div class="launchcollumn">
    <a>Assets</a><br>
    <?php
    
    $getaassetqry = mysqli_query($link, "select * from assets where active=1 ORDER BY name ASC");
    while($row = mysqli_fetch_array($getaassetqry)){
        echo "<a href='?a=assets&asset=".$row['id']."' class='collumnbutton'>".$row['name']."</a>";
    }

    ?>
</div>

<?php

if(isset($asset)){
    echo "<div class='launchcollumn'>";
    echo "<a>Informations</a>";
    $getinfqry = mysqli_query($link, "SELECT * from assets where id = $asset");
    while($row = mysqli_fetch_array($getinfqry)){
        $assetdesc = $row['description'];
    }
    echo "<a class='collumnbutton'>$assetdesc</a>";
    echo "<a href='?a=assets&asset=$asset&do=scripts' class='collumnbutton'>Exécution Scripts</a>";
    echo "</div>";

    if(isset($do) && $do == 'scripts'){
        echo "<div class='launchcollumn'>";
        echo "<a>Scripts</a>";
        echo "<a href='?a=assets&asset=$asset&do=$do&sched=new' class='collumnbutton'>New</a>";
        $getschedqry = mysqli_query($link, "SELECT * from schedules where assetid = $asset ORDER BY runtime DESC");
        while($row = mysqli_fetch_array($getschedqry)){
            $scriptid = $row['scriptid'];
            $schedtime = $row['runtime'];
            $schedid = $row['id'];
            $getscriptqry = mysqli_query($link, "SELECT * from scripts where id = $scriptid");
            while($row = mysqli_fetch_array($getscriptqry)){
                $scriptname = $row['name'];
            }
            echo "<a href='?a=assets&asset=$asset&do=$do&sched=$schedid' class='collumnbutton'>$scriptname $schedtime</a>";
        }
        echo "</div>";
        if(isset($sched) && $sched != 'new' && $sched != 'set'){
            $getschedqry = mysqli_query($link, "SELECT * from schedules where id = $sched");
            while($row = mysqli_fetch_array($getschedqry)){
                $scriptid = $row['scriptid'];
                $schedtime = $row['runtime'];
                $rantime = $row['rantime'];
                $status = $row['status'];
                $output = $row['output'];
                $userid = $row['userid'];
            }
            $getscriptqry = mysqli_query($link, "SELECT * from scripts where id = $scriptid");
            while($row = mysqli_fetch_array($getscriptqry)){
                $scriptname = $row['name'];
                $scriptdesc = $row['description'];
            }
            $getuserqry = mysqli_query($link, "SELECT * from users where id = $userid");
            while($row = mysqli_fetch_array($getuserqry)){
                $username = $row['username'];
            }
            echo "<div class='launchcollumn'>";
            echo "<a>$scriptname</a>";
            echo "<a class='collumnbutton'>$scriptdesc</a>";
            echo "<a class='collumnbutton'>Time: $schedtime</a>";
            echo "<a class='collumnbutton'>CMD retreived: $rantime</a>";
            echo "<a class='collumnbutton'>Status: $status</a>";
            echo "<a class='collumnbutton'>Output: $output</a>";
            echo "<a class='collumnbutton'>Ran by: $username</a>";
        }elseif(isset($sched) && $sched == 'new'){
            echo "<div class='launchcollumn'>";
            echo "<a>New</a>";
            $getscriptsqry = mysqli_query($link, "SELECT * from scripts");
            while($row = mysqli_fetch_array($getscriptsqry)){
                echo "<a href='?a=assets&asset=$asset&do=$do&sched=set&newscriptid=".$row['id']."' class='collumnbutton'>".$row['name']."</a>";
            }
        }elseif(isset($sched) && $sched == 'set'){
            echo "<div class='launchcollumn'>";
            echo "<a>Set time</a>
            <form action='?a=assets&asset=$asset&do=$do&sched=save&newscriptid=$newscriptid' method='POST'>
            <input type='text' name='datetime' class='input' placeholder='yyyy-MM-dd HH:mm:ss'>
            <input type='submit' class='button' value='Save'>
            </form>";
            echo "</div>";
        }
    }
}

?>