<?
session_start();
if(basename($_SERVER["SCRIPT_NAME"]) != "index.php") 
{
    $error = 1;
}

include("mmsystem/mainfile2015.php");
global $CN;
include("mmsystem/verifyaccess.php");

$AR = explode("/",addslashes(strip_tags($_POST["ID"])));

if($_SESSION["THISCO"] && $_SESSION["AC"]["aSUPER"]==1 && count($AR)==2)
{
    $z = mysqli_query($CN["dbl"],"SELECT * FROM CREDITS WHERE crCOID='".$_SESSION["THISCO"]."' ORDER BY crID DESC LIMIT 1");
    if(mysqli_num_rows($z)==1) //update
    {
        $x = mysqli_query($CN["dbl"],"UPDATE CREDITS SET crQTY='".$AR[1]."' WHERE crCOID='".$_SESSION["THISCO"]."' ");
    }
    else //insert
    {
        $x = mysqli_query($CN["dbl"],"INSERT INTO CREDITS(crID,crCOID,crQTY) VALUES (NULL,'".$_SESSION["THISCO"]."','".$AR[1]."')");        
    }
    if($x==1)
    {
        echo $AR[0].'/'.$AR[1];
    }
    else
    {
        echo "ERROR";
    }
}