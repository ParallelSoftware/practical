<?
session_start();
if(basename($_SERVER["SCRIPT_NAME"]) != "index.php") 
{
    $error = 1;
}
$IGN_ACCESS = 1; // access id for not logged in files
include("mmsystem/mainfile2015.php");
global $CN;
include("mmsystem/verifyaccess.php");

$ID = strtolower(str_replace(" ","",$_POST["LOGIN1"]));
$password = str_replace(" ","",$_POST["LOGIN2"]);

if(!$ID || !$password)
{
    echo 1;
    exit;
}
else
{
    if(ctype_digit($ID))
    {
        $txt = "ctTel1='".$ID."'";    
    } 
    elseif(filter_var($ID,FILTER_VALIDATE_EMAIL))
    {
        $txt = "ctEmail='".$ID."'";   
    }
    else
    {
        echo 2;
        exit;
    }
    setcookie("MM_LOGIN", $ID);       
    $x = mysqli_query($CN["dbl"],"SELECT * FROM contact,company WHERE ctCOID=coID AND ctPassword='".md5($password)."' AND ".$txt." AND ctActive=1 ");        
    if(mysqli_num_rows($x)!=1)
    {
        $x = mysqli_query($CN["dbl"],"SELECT * FROM contact,company WHERE ctCOID=coID AND ctPassword='".$password."' AND ".$txt."  AND ctActive=1 ");
        if(mysqli_num_rows($x)!=1)
        {
            echo 3; //incorrect details
            exit;
        }
        else
        {
            $newpass = 1;
        }
    }  
    
    $_SESSION["CO"] = mysqli_fetch_array($x);
    $_SESSION["GRADINGCO"] = $_SESSION["CO"]["coID"];
    
    $z = mysqli_query($CN["dbl"],"SELECT * FROM ACCESS WHERE aCTID='".$_SESSION["CO"]["ctID"]."' AND aLOGIN=1");
    if(mysqli_num_rows($z)==1)
    {
        $_SESSION['AC'] = mysqli_fetch_array($z);
        $_SESSION['timeOut'] = 7200;
        $_SESSION['loggedAt'] =  time();
        $_SESSION["logged_in"] = true; 
        
        if($newpass==1)
        {
            echo 4; //goto new pass  
            exit;
        }
        else
        {
            echo 5; //goto main page
            exit; 
        }  
    }
    else
    {
        echo 6; //no access
        exit;
    } 
}
?>
