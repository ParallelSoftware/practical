<?
session_start();
if(basename($_SERVER["SCRIPT_NAME"]) != "index.php") 
{
    $error = 1;
}
include("mmsystem/mainfile2015.php");
include("mmsystem/verifyaccess.php");
global $CN;

$PASS1 = $_POST["PASS1"]; 
$PASS2 = $_POST["PASS2"]; 

if($_SESSION["CO"])
{
    if($PASS1=="")
    {
        echo 1;   
    }
    elseif(strlen($PASS1)<6)
    {
        echo 2;
    }
    elseif(strlen($PASS1)>30)
    {
        echo 3;
    }
    elseif(!preg_match("#[0-9]+#", $PASS1)) 
    {
        echo 4; 
    }
    elseif(!preg_match("#[a-z]+#", strtolower($PASS1))) 
    {
        echo 5;
    }
    elseif($PASS1!=$PASS2)
    {
        echo 6;
    }
    else
    {
        $x = mysqli_query($CN["dbl"],"UPDATE contact SET ctPassword='".md5($PASS1)."' WHERE ctID='".$_SESSION["CO"]["ctID"]."' AND ctActive=1 ");
        if($x==1)
        {
            echo 7;
        }
        else
        {
            echo 8;
        }   
    }
}            
?>
