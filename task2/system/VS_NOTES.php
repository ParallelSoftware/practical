<?
session_start();
if(basename($_SERVER["SCRIPT_NAME"]) != "index.php") 
{
    $error = 1;
}

include("mmsystem/mainfile2015.php");
global $CN;
include("mmsystem/verifyaccess.php");

if($_SESSION["NOTES"] && ($_SESSION["AC"]["aGRADE"]==1 || $_SESSION["AC"]["aSUPER"]==1) )
{
    $rNotes2 = addslashes(strip_tags($_POST["ID"]));
    
    $x = mysqli_query($CN["dbl"],"UPDATE RESULTS SET rNotes2='".$rNotes2."' WHERE rID='".$_SESSION["NOTES"]."'");
    if($x==1)
    {
        echo 1;
    }
    else
    {
        echo 3;
    }
}
else
{
    echo 2;
}