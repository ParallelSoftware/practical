<?
session_start();
if(basename($_SERVER["SCRIPT_NAME"]) != "index.php") 
{
    $error = 1;
}

include("mmsystem/mainfile2015.php");
global $CN;
include("mmsystem/verifyaccess.php");
 
if($_SESSION["GRADE"]==1 && $_POST["ID1"] && $_POST["ID2"] && $_SESSION["AC"]["aGRADE"]==1)
{
    if($_POST["ID1"]!="NEW")
    {
        $TID = intval($_POST["ID1"]);
    }   
    $COM = explode(",",$_POST["ID2"]);
    if(count($COM)<3)
    {
        echo 1;
    }
    elseif($_POST["ID1"]!="NEW" && $TID==0)
    {
        echo 2;
    }
    else
    {
        if($_POST["ID1"]=="NEW")
        {
            $x = mysqli_query($CN["dbl"],"SELECT tID,tName FROM TITLES WHERE tID='".$_SESSION["NEWTID"]."' "); 
            if(mysqli_num_rows($x)==1)
            {
                list($_SESSION["TID"],$_SESSION["TITLE"]) = mysqli_fetch_array($x);  
                $found=1;  
            }              
        }
        else
        {
            $i=0;
            $x = mysqli_query($CN["dbl"],"SELECT tID,tName FROM TITLES ORDER BY tName ASC ");
            while(list($tID,$tName) = mysqli_fetch_array($x))
            {
                $i++;
                if($i==$TID)
                {
                    $_SESSION["TITLE"] = $tName;        
                    $_SESSION["TID"] = $tID;  
                    $found=1;
                    break;  
                }
            }    
        }    
        if($found==1)
        {
            unset($_SESSION["NEWTID"]);
            
            $i=0;
		    $x = mysqli_query($CN["dbl"],"SELECT ctID,ctCOID,ctConsult FROM contact WHERE ctActive=1 ORDER BY ctName ASC ");
		    while(list($ctID,$ctCOID,$ctConsult) = mysqli_fetch_array($x))
		    {
		        if($ctCOID==$_SESSION["GRADINGCO"] || ($ctConsult==1 && $_SESSION["AC"]["aSUPER"]==1))
		        {
		            $i++;
		            if(in_array($i, $COM))
		            {
			            $NCOM[] = $ctID;
		            }    
		        }        
		    }    
		    
		    $_SESSION["COM_MEMORY"] = $NCOM;        
            $_SESSION["COMMITTEE"] = implode(",",$NCOM);        
            $_SESSION["REF"] = addslashes(strip_tags($_POST["ID3"]));
            $_SESSION["NOTES"] = addslashes(strip_tags($_POST["ID4"]));
            $_SESSION["GRADE"] = 2;
            echo 3;   
        } 
        else
        {
            echo 4;    
        }        
    }            
}         