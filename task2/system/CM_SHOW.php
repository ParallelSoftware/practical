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

$SORT = array(1=>"coName",2=>"provName",3=>"coDate");
$ORDER = array(1=>"ASC",2=>"DESC");

if(strlen($KW)>2)
{
    $the_array = explode(' ', $KW);
    foreach( $the_array AS $t )
    {
        $seek[] = "coName LIKE '%".$t."%' OR coTel1 LIKE '%".$t."%' OR provName LIKE '%".$t."%'"; //
    } 
    $ADD1 = "AND (".implode(" AND ",$seek).")";            
}
if($ID==3){ $ADD2 = "AND coActive=1"; }elseif($ID==4){ $ADD2 = "AND coActive=0"; } //

$x = mysqli_query($CN["dbl"],"SELECT * FROM company,province WHERE coPROVID=provID ".$ADD1." ".$ADD2." ORDER BY ".$SORT[$ID3]." ".$ORDER[$ID4]." "); //
if(mysqli_num_rows($x)>0)
{
    while($R = mysqli_fetch_array($x))
    {
        $CQ[] = $R;
    }
    foreach($CQ AS $i => $Q)
    {           
        $_SESSION["COID"][$i+1] = $Q["coID"]; //
        ?>
        <div class="CM_ITEM">
            <div class="CM_HOVER" id="MQ_<?=$i+1?>"></div>
            <div class="CM_WRAPPER">                
                <h2><?=$Q["coName"]?></h2>
                <?if($Q["coActive"]!=1){?><h4 style="color: #FF0000;"><i>Inactive</i></h4><?}?>
                <h4>Province: <?=$Q["provName"]?></h4>
                <h4>Telephone: <?=$Q["coTel1"]?></h4>
                <h4>Web: <?if($Q["coWebsite"]){echo $Q["coWebsite"];}else{echo"None";}?></h4>
            </div>
        </div>
        <?    
    }
}
else
{
    echo 1;        
}


