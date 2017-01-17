<?
session_start();
if(basename($_SERVER["SCRIPT_NAME"]) != "index.php") 
{
    $error = 1;
}

include("mmsystem/mainfile2015.php");
global $CN;
include("mmsystem/verifyaccess.php");


$tName = addslashes(strip_tags($_POST["ID1"]));
$tDesc = addslashes(strip_tags($_POST["ID2"]));
$tOrigin = intval($_POST["ID3"]);

if(strlen($tName)<3)
{
    echo 1;
}
elseif(!$tOrigin)
{
    echo 2;    
}
else
{
    if($_SESSION["THISTID"]!="NEW") //update
    {
        $x = mysqli_query($CN["dbl"],"UPDATE TITLES SET tName='".$tName."',tDesc='".$tDesc."',tOrigin='".$tOrigin."',tCOID='".$_SESSION["GRADINGCO"]."' WHERE tID='".$_SESSION["THISTID"]."' ");
        if($x==1)
        {
            echo 3;         
            unset($_SESSION["THISTID"]);
        }
        else
        {
            echo 4;
        }
    }  
    else //insert
    {
        $x = mysqli_query($CN["dbl"],"INSERT INTO TITLES (tID,tCOID,tName,tDesc,tOrigin,tDate,tActive) VALUES (NULL,'".$_SESSION["GRADINGCO"]."','".$tName."','".$tDesc."','".$tOrigin."','".date("U")."',1) ");  
        if($x==1)
        {
            $_SESSION["NEWTID"] = mysqli_insert_id($CN["dbl"]);
            echo 3;
            unset($_SESSION["THISTID"]);            
        }
        else
        {
            echo 4;
        }  
    }
}    