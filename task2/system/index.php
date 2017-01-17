<?php
//error_reporting(E_ALL); 
//ini_set('display_errors', 1);

$badword = array("select","update","'","drop", ";", "--",".","insert", "delete","union","xp_","http","/etc","<",">","/","=");
$allowkey = array("q");

switch ($_SERVER["REQUEST_METHOD"]) {
  case "POST":
    while (list ($key, $val) = each ($_POST)) {
      if(in_array($val,$badword)){
      header("location:index.php");
     die("Forbidden words, your ip has been recorded.");
     }
      $$key = addslashes($val);
    }
    break;

  case "GET":
     while (list ($key, $val) = each ($_GET)) {
     if (in_array($val,$badword)) {
      header("location:index.php");
      die("Forbiden words. Your ip has been recorded.");
     }
    
   }
    break;
  }

if(empty($_GET['file'])) 
{
    $file = 'home';
} 
else
{
    $file = $_GET['file'];
}


if(file_exists($file.'.php')) 
{
   include($file.'.php');
} 
else
{
   echo"This file is currently unavailable or is being updated.";
   exit();
}

?>
