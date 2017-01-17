<?
session_start();
if(basename($_SERVER["SCRIPT_NAME"]) != "index.php") 
{
    $error = 1;
}

include("mmsystem/mainfile2015.php");
global $CN;
include("mmsystem/verifyaccess.php");

if($_SESSION["THISCO"])
{
    $ctName = addslashes(strip_tags($_POST["C1"]));
    $ctSurname = addslashes(strip_tags($_POST["C2"]));
    $ctTitle = addslashes(strip_tags($_POST["C3"]));
    $ctEmail = addslashes(strip_tags($_POST["C4"]));
    $ctTel1 = addslashes(strip_tags($_POST["C5"]));
    $ID = intval($_POST["C6"]);
    $AC = explode(".",$_POST["C7"]);

    if(strlen($ctName)<4)
    {
        echo 1;
    }
    elseif(strlen($ctSurname)<4)
    {
        echo 2;    
    }
    elseif(strlen($ctTitle)<4)
    {
        echo 3;    
    }
    elseif(!filter_var($ctEmail,FILTER_VALIDATE_EMAIL))
    {
        echo 4;    
    }
    elseif(!ctype_digit($ctTel1))
    {
        echo 5;    
    }
    elseif(count($AC)!=4)
    {
        echo 6;    
    }
    else
    {
        if($_SESSION["CNTUP"][$ID]) //update
        {
            $x = mysqli_query($CN["dbl"],"UPDATE contact SET ctName='".$ctName."',ctSurname='".$ctSurname."',ctTitle='".$ctTitle."',ctEmail='".$ctEmail."',ctTel1='".$ctTel1."' WHERE ctID='".$_SESSION["CNTUP"][$ID]."' ");
            if($x==1)
            {
                $x = mysqli_query($CN["dbl"],"UPDATE ACCESS SET aLOGIN='".$AC[0]."',aVIEW='".$AC[1]."',aGRADE='".$AC[2]."',aADMIN='".$AC[3]."' WHERE aCTID='".$_SESSION["CNTUP"][$ID]."'");
                if($x==1)
                {
                    echo 7;
                }
                else
                {
                    echo 8;
                }                
            }
            else
            {
                echo 8;
            }
        }  
        else //insert
        {
            $x = mysqli_query($CN["dbl"],"INSERT INTO contact (ctID,ctCOID,ctName,ctSurname,ctTitle,ctEmail,ctTel1,ctActive,ctDate) VALUES (NULL,'".$_SESSION["THISCO"]."','".$ctName."','".$ctSurname."','".$ctTitle."','".$ctEmail."','".$ctTel1."',1,'".date("U")."') ");  
            if($x==1)
            {
                $ctID = mysqli_insert_id($CN["dbl"]);
                $_SESSION["CNTUP"][$ID] = $ctID;
                
                $x = mysqli_query($CN["dbl"],"INSERT INTO ACCESS (aID,aCTID,aLOGIN,aVIEW,aGRADE,aADMIN) VALUES (NULL,'".$ctID."','".$AC[0]."','".$AC[1]."','".$AC[2]."','".$AC[3]."') ");
                if($x==1)
                {
                    echo 7;
                }
                else
                {
                    echo 8;
                }
            }
            else
            {
                echo 8;
            }  
        }
    }    
}