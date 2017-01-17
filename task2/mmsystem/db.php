<?
$DB_HOST = "localhost";
$DB_USER = "autograd_donkey";
$DB_PASS = "JamBg5N2s?.?";
$DB_NAME = "autograd_monnas";

function db_connect($DB_HOST,$DB_USER,$DB_PASS,$DB_NAME)
{
    $sql = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    if (mysqli_connect_errno()) 
    {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    else
    {
        return $sql;
    }
}