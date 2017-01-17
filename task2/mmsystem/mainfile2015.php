<?
include("db.php");
$link = db_connect($DB_HOST,$DB_USER,$DB_PASS,$DB_NAME);

$x = mysqli_query($link,"SELECT * FROM _mainsite WHERE msActive=1 ORDER BY msID DESC LIMIT 1");
if(mysqli_num_rows($x)==1)
{
    $CN = mysqli_fetch_array($x);

    global $CN;

    $CN["dbl"] = $link;

    include("function2015.php");        

    if(isset($_GET["op"]))
    {
        $op=$_GET["op"];
    }
    else
    {
        $op="";
    }        
}
else
{
    exit;
}
?>
