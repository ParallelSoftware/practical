<?
session_start();
if(basename($_SERVER["SCRIPT_NAME"]) != "index.php") 
{
    $error = 1;
}

include("mmsystem/mainfile2015.php");
global $CN;
include("mmsystem/verifyaccess.php");

if($_POST["VAL"] && $_POST["TME"] && $_SESSION["TITLE"] && $_SESSION["TID"] && $_SESSION["GRADE"]==3 && $_SESSION["AC"]["aGRADE"]==1)
{    
    $AR = explode(",",$_POST["VAL"]);
    $TME = explode(":",$_POST["TME"]);
    $SECS = ($TME[0]*60) + $TME[1];
    if($AR[0]==$AR[1])
    {
        $a = 1;
        $x = mysqli_query($CN["dbl"],"SELECT * FROM CATS ORDER BY cOrder ASC");
        while($C = mysqli_fetch_array($x))
        {            
            $i=-1;
            $y = mysqli_query($CN["dbl"],"SELECT * FROM MAIN WHERE mCATID='".$C["cID"]."' ORDER BY mID ASC");
            while($M = mysqli_fetch_array($y))
            {
                $z = mysqli_query($CN["dbl"],"SELECT * FROM SECONDARY WHERE sMID='".$M["mID"]."' ORDER BY sOrder ASC");
                while($S = mysqli_fetch_array($z))
                {
                    $a++;                                        
                    if($AR[$a]==1) //selected
                    {
                        $i++;
                        $NEWARR[$S["sID"]] = $M["mVal"] * $S["sVal"] * $C["cVal"];
                        $SPQ[$S["sID"]] = $S["sVal"];  
                        $TMP[$i] = $S["sVal"];                             
                        $RAW[] = $S["sID"];
                    }
                }                                       
            }
            $SPC[$C["cID"]] = array_sum($TMP) / count($TMP);
            unset($TMP);
        }        
        
        $aa = mysqli_query($CN["dbl"],"INSERT INTO RESULTS(rID,rCOID,rTitle,rTID,rRaw,rScore,rSPQ,rSPC,rDate,rCommittee,rTime,rConsultant,rRef,rNotes,rActive) 
        VALUES (NULL,'".$_SESSION["GRADINGCO"]."','".$_SESSION["TITLE"]."','".$_SESSION["TID"]."','".implode(",",$RAW)."','".array_sum($NEWARR)."','".implode(",",$SPQ)."','".implode(",",$SPC)."','".date("U")."','".$_SESSION["COMMITTEE"]."','".$SECS."','".$_SESSION["CO"]["ctID"]."','".$_SESSION["REF"]."','".$_SESSION["NOTES"]."',1)");
        $rID = mysqli_insert_id($CN["dbl"]);
        if($aa==1)
        {
            echo 1; //perfect
            unset($_SESSION["GRADE"]);
            unset($_SESSION["COMMITTEE"]);
            unset($_SESSION["TITLE"]);
            unset($_SESSION["TID"]);
            unset($_SESSION["REF"]);
            unset($_SESSION["NOTES"]);            
            $_SESSION["RID"][0] = $rID;            
        }
        else
        {
            echo 3; //error
        }
    }
    else
    {
        echo 2; //incomplete
    }
}            