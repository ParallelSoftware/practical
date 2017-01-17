<?
session_start();
if(basename($_SERVER["SCRIPT_NAME"]) != "index.php") 
{
    $error = 1;
}

include("mmsystem/mainfile2015.php");
global $CN;
include("mmsystem/verifyaccess.php");

//CURRENT
$ID1 = intval($_POST["ID1"]); //country ID
$ID2 = intval($_POST["ID2"]); //Province ID
$ID3 = intval($_POST["ID3"]); //City ID

//WHICH ACTIVE
$ID4 = intval($_POST["ID4"]);

$KW = addslashes(strip_tags($_POST["ID5"]));

$ARR = array(3 => "cnty",4 => "prov",5 => "city");

if(strlen($KW)>2 && $ID4 > 2 && $ID4 < 6 && $ARR[$ID4])
{
    $the_array = explode(' ', $KW);
    foreach( $the_array AS $t )
    {
        $seek[] = $ARR[$ID4]."Name LIKE '%".$t."%'"; //
    } 
    $ADD = "(".implode(" AND ",$seek).")";            

    if($ID4==3)
    {
        $query = "SELECT cntyID,cntyName FROM country WHERE ".$ADD." ORDER BY cntyName ASC ";
    }
    elseif($ID4==4)
    {
        $query = "SELECT provID,provName FROM province WHERE provCNTYID='".$ID1."' AND ".$ADD." ORDER BY provName ASC ";
    }
    elseif($ID4==5)
    {
        $query = "SELECT cityID,cityName FROM city WHERE cityPROVID='".$ID2."' AND ".$ADD." ORDER BY cityName ASC ";
    }
    $x = mysqli_query($CN["dbl"],$query);
    if(mysqli_num_rows($x)==0)
    {
        echo 2;
    } 
    else
    {
        ?><ul><?
        while(list($ID,$NAME) = mysqli_fetch_array($x))
        {
            ?>
            <li id="THS_<?=$ID?>_<?=$ID4?>"><?=$NAME?></li>
            <?
        }
        ?></ul><?    
    }
    
}
else
{
    echo 1;
}
