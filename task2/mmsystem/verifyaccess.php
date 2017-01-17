<?
global $CN;
$ipaddress = get_client_ip();   
$IPC = @mysqli_query($CN["dbl"],"SELECT blockID FROM blockedip WHERE blockIP='".$ipaddress."' ");
if(@mysqli_num_rows($IPC)>2)
{
    destroy();
    echo "YOU HAVE BEEN BANNED FROM THIS SITE DUE TO MULTIPLE ILLEGAL ACCESS.";
    exit;
}
elseif($error==1)
{
    recordIP("Did not use index.php as basename");
    destroy();
    echo "<h1>THIS FILE CANNOT BE ACCESSED DIRECTLY. IP HAS BEEN RECORDED. <a href=\"\">HOME PAGE</a></h1>";
    exit;
}
elseif($IGN_ACCESS!=1 && checkaccess()===false)
{ 
    destroy();
    echo "NLI";
    exit;
}
$_SESSION['loggedAt'] = time();
