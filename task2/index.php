<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1);



if(empty($_GET['file'])) 
{
    $file = 'login';
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