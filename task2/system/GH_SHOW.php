<?
session_start();
if(basename($_SERVER["SCRIPT_NAME"]) != "index.php") 
{
    $error = 1;
}

include("mmsystem/mainfile2015.php");
global $CN;
include("mmsystem/verifyaccess.php");

$ID = intval($_POST["ID1"]);
$KW = addslashes(strip_tags($_POST["ID2"]));
$ID3 = intval($_POST["ID3"]);
$ID4 = intval($_POST["ID4"]);

if($ID < 2 || $ID > 4 || !$ID){ $ID = 3; } //
if($ID3 < 1 || $ID3 > 3 || !$ID3){ $ID3 = 2; } //
if(($ID4 != 1 && $ID4!= 2) || !$ID4){ $ID4 = 1; } //

$SORT = array(1=>"rTitle",2=>"rID",3=>"rScore");
$ORDER = array(1=>"ASC",2=>"DESC");

if(strlen($KW)>2)
{
    $the_array = explode(' ', $KW);
    foreach( $the_array AS $t )
    {
        $seek[] = "rTitle LIKE '%".$t."%'"; //
    } 
    $ADD1 = "AND (".implode(" AND ",$seek).")";            
}
if($ID==3){ $ADD2 = "AND rActive=1"; }elseif($ID==4){ $ADD2 = "AND rActive=0"; } //

$x = mysqli_query($CN["dbl"],"SELECT * FROM COMPARISON "); //
while($TMP = mysqli_fetch_array($x))
{
    $CMP[$TMP["cID"]] = $TMP;
}

$x = mysqli_query($CN["dbl"],"SELECT * FROM RESULTS WHERE rCOID='".$_SESSION["GRADINGCO"]."' ".$ADD1." ".$ADD2." ORDER BY ".$SORT[$ID3]." ".$ORDER[$ID4]." "); //
if(mysqli_num_rows($x)>0)
{
    while($R = mysqli_fetch_array($x))
    {
        $CQ[] = $R;
    }
    foreach($CQ AS $i => $Q)
    {           
        $_SESSION["RID"][$i] = $Q["rID"]; //
        ?>
        <div class="GH_ITEM">
            <div class="GH_HOVER" id="MQ_<?=$i?>"></div>
            <div class="GH_WRAPPER">                
                <h1><?=$Q["rTitle"]?></h1>
                <?if($Q["rActive"]!=1){?><h4 style="color: #FF0000;"><i>Inactive</i></h4><?}?>
                <h4>Date Graded: <?=date("d F Y @ H:i",$Q["rDate"])?></h4>
                <h4>Ref nr: <?if($Q["rRef"]){echo $Q["rRef"];}else{echo"None";}?></h4>
                <h2><?=$CMP[round($Q["rScore"])]["c1"]?>/<?=$CMP[round($Q["rScore"])]["c5"]?>/<?=$CMP[round($Q["rScore"])]["c3"]?></h2>
            </div>
        </div>
        <?    
    }
}
else
{
    if(strlen($KW)>0)
    {
        echo 1;
    }        
    else
    {
        echo 2;
    }
}


