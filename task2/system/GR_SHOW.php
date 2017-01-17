<?
session_start();
if(basename($_SERVER["SCRIPT_NAME"]) != "index.php") 
{
    $error = 1;
}

include("mmsystem/mainfile2015.php");
global $CN;

$ID = intval($_POST["ID"]);

if(($_SESSION["REPCO"] && $_SESSION["AC"]["aVIEW"]==1) || ($_SESSION["REPEXPIRE"] && $_SESSION["REPEXPIRE"]>date("U")))
{
    if($_SESSION["SORT"]==1){ $_SESSION["SORT"]=2; }else{ $_SESSION["SORT"]=1; }

    $SORT = array(1=>"rTitle",2=>"rID",3=>"rScore",4=>"rTime",5=>"rRef");
    $ASC = array(1=>"ASC",2=>"DESC");

    if($ID < 1 || $ID > 5){ $ID = 2; }

    $x = mysqli_query($CN["dbl"],"SELECT * FROM COMPARISON "); //
    while($TMP = mysqli_fetch_array($x))
    {
        $CMP[$TMP["cID"]] = $TMP;
    }
    
    $x = mysqli_query($CN["dbl"],"SELECT * FROM RESULTS WHERE rCOID='".$_SESSION["REPCO"]."' ORDER BY ".$SORT[$ID]." ".$ASC[$_SESSION["SORT"]]." "); //

    if(mysqli_num_rows($x)>0)
    {                
        ?>
        <table cellpadding="5" cellspacing="0" width="100%">
        <tr>           
            <td>Job Title</td>
            <td>Date</td>
            <td>Duration</td>
            <td>Ref nr</td>
            <td>Paterson</td>
            <td>Peromnes</td>
            <td>Hay</td>                        
            <td>Level</td>
        </tr>
        
        <?   
        $i=-1;             
        while($Q = mysqli_fetch_array($x))
        {
            $i++;         
            ?>    
            <tr>           
                <td><?=$Q["rTitle"]?><?if($Q["rActive"]!=1){?> <i>(Inactive)</i><?}?></td>
                <td><?=date("d F Y @ H:i",$Q["rDate"])?></td>
                <td><?$M = floor($Q["rTime"]/60); echo $M.' min, '.($Q["rTime"]-(60*$M)).' sec'?></td>
                <td><?if($Q["rRef"]){echo $Q["rRef"];}else{echo"None";}?></td>
                <td><?=$CMP[round($Q["rScore"])]["c1"]?></td>
                <td><?=$CMP[round($Q["rScore"])]["c5"]?></td>
                <td><?=$CMP[round($Q["rScore"])]["c3"]?></td>                        
                <td><?=$CMP[round($Q["rScore"])]["c7"]?></td>
            </tr>
            <?    
        }
        ?>
        </table>
        <?
    }
    else
    {
        ?>
        <h1>No previous grading history found</h1>
        <?
    }
}
else
{
    ?>
    <h1>You cannot access this page directly</h1>
    <?   
}
