<?
session_start();
if(basename($_SERVER["SCRIPT_NAME"]) != "index.php") 
{
    $error = 1;
}

include("mmsystem/mainfile2015.php");
global $CN;
include("mmsystem/verifyaccess.php");

$coName = addslashes(strip_tags($_POST["U0"]));
$coReg = addslashes(strip_tags($_POST["U1"]));
$coTel1 = addslashes(strip_tags($_POST["U2"]));
$coCNTYID = intval($_POST["U3"]);
$coPROVID = intval($_POST["U4"]);
$coCITYID = intval($_POST["U5"]);
$ID = intval($_POST["U6"]);

if(strlen($coName)<4)
{
    echo 1;
}
elseif(!ctype_digit($coTel1))
{
    echo 2;    
}
elseif(!$coCNTYID)
{
    echo 3;    
}
elseif(!$coPROVID)
{
    echo 4;    
}
elseif(!$coCITYID)
{
    echo 5;    
}
else
{
    if($_SESSION["THISCO"]) //update
    {
        $x = mysqli_query($CN["dbl"],"UPDATE company SET coName='".$coName."',coReg='".$coReg."',coTel1='".$coTel1."',coCNTYID='".$coCNTYID."',coPROVID='".$coPROVID."',coCITYID='".$coCITYID."' WHERE coID='".$_SESSION["THISCO"]."' ");
        if($x==1)
        {
            echo 6;
        }
        else
        {
            echo 7;
        }
    }  
    else //insert
    {
        $x = mysqli_query($CN["dbl"],"INSERT INTO company (coID,coName,coReg,coTel1,coCNTYID,coPROVID,coCITYID,coActive,coDate) VALUES (NULL,'".$coName."','".$coReg."','".$coTel1."','".$coCNTYID."','".$coPROVID."','".$coCITYID."',1,'".date("U")."') ");  
        if($x==1)
        {
            echo 6;
            $_SESSION["THISCO"] = mysqli_insert_id($CN["dbl"]);
        }
        else
        {
            echo 7;
        }  
    }
}