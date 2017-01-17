<?
if(checkaccess()===false)
{
    echo"<meta http-equiv=\"refresh\" content=\"1;url=".$CN["msAddress"]."/login-1-.htm\">";
    exit;  
}
else
{
    $_SESSION['loggedAt']= time();       
}

