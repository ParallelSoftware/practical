<?
session_start();
if(basename($_SERVER["SCRIPT_NAME"]) != "index.php") 
{
    $error = 1;
}

include("mmsystem/mainfile2015.php");
global $CN;
include("mmsystem/verifyaccess.php");

unset($_SESSION["NEWTID"]);

$ID = intval($_POST["ID1"]);
$KW = addslashes(strip_tags($_POST["ID2"]));
$ID3 = intval($_POST["ID3"]);
$ID4 = intval($_POST["ID4"]);

if($ID < 2 || $ID > 4 || !$ID){ $ID = 3; } //active inactive
if($ID3 < 1 || $ID3 > 3 || !$ID3){ $ID3 = 2; } //sortby
if(($ID4 != 1 && $ID4!= 2) || !$ID4){ $ID4 = 1; } //asc desc

$SORT = array(1=>"tName",2=>"tDate",3=>"tOrigin");
$ORDER = array(1=>"ASC",2=>"DESC");

if(strlen($KW)>2)
{
    $the_array = explode(' ', $KW);
    foreach( $the_array AS $t )
    {
        $seek[] = "tName LIKE '%".$t."%'"; //
    } 
    $ADD1 = "AND (".implode(" AND ",$seek).")";            
}
if($ID==3){ $ADD2 = "AND tActive=1"; $SAY = "active"; }elseif($ID==4){ $ADD2 = "AND tActive=0"; $SAY = "inactive"; } //

$x = mysqli_query($CN["dbl"],"SELECT tID,tName FROM TITLES WHERE tID!=0 ".$ADD2." ".$ADD1." ORDER BY ".$SORT[$ID3]." ".$ORDER[$ID4]." "); //
if(mysqli_num_rows($x)>0)
{
    $i=0;
    while(list($tID,$tName) = mysqli_fetch_array($x))
    {
        $i++;
        $_SESSION["TID"][$i] = $tID; //
        ?>
        <li class="TLI" id="T_<?=$i?>"><?=$tName?></li>        
        <?
    }
}
else
{
    echo 1;         
}


