<?
session_start();
if(basename($_SERVER["SCRIPT_NAME"]) != "index.php") 
{
    $error = 1;
}

include("mmsystem/mainfile2015.php");
global $CN;
include("mmsystem/verifyaccess.php");


if($_SESSION["AC"]["aSUPER"]==1 && $_SESSION["THISCO"])
{
    $z = mysqli_query($CN["dbl"],"SELECT crQTY FROM CREDITS WHERE crCOID='".$_SESSION["THISCO"]."' ORDER BY crID DESC LIMIT 1");
    if(mysqli_num_rows($z)==1)
    {
        list($QTY1) = mysqli_fetch_row($z);
        
        $z = mysqli_query($CN["dbl"],"SELECT * FROM RESULTS WHERE rCOID='".$_SESSION["THISCO"]."' AND rActive=1 ");    
        $QTY = mysqli_num_rows($z);
        
        if( ($QTY1-$QTY) <= 0 )
        {
            echo 1;
            exit;
        }                
    }
    else
    {
        echo 1;
        exit;
    }
    
    $z = mysqli_query($CN["dbl"],"SELECT * FROM contact WHERE ctCOID='".$_SESSION["THISCO"]."' AND ctActive=1 ");    
    if(mysqli_num_rows($z)<1)
    {
        echo 2;
        exit;
    }
    else
    {
        $_SESSION["GRADINGCO"] = $_SESSION["THISCO"]; 
        echo 3;    
    }           
}