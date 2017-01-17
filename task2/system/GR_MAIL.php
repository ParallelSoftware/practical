<?
session_start();
if(basename($_SERVER["SCRIPT_NAME"]) != "index.php") 
{
    $error = 1;
}

include("mmsystem/mainfile2015.php");
global $CN;
include("mmsystem/verifyaccess.php");
include("mmsystem/communicate.php");

$EMAIL = strtolower(strip_tags(addslashes($_POST["E1"])));
$NAME = ucwords(strip_tags(addslashes($_POST["E2"])));

if($_SESSION["GRADINGCO"])
{
    if(!$NAME || strlen($NAME)<3)
    {
        echo 1;
    }
    elseif(!filter_var($EMAIL,FILTER_VALIDATE_EMAIL))
    {
        echo 2;
    }
    else
    {
        $ARR = range(0,9);
        $ARR1 = range('A','Z');
        for($i=0;$i<=10;$i++)
        {
            $A = array_rand($ARR,1);
            $B = array_rand($ARR1,1);
            $C[] = $ARR[$A[0]].$ARR1[$B[0]];
        }
        shuffle($C);
        $CODE = md5(implode("",$C));
        $EXPIRE = date("U",mktime(17,0,0,date("n")+1,date("d"),date("Y")));
        
        $x = mysqli_query($CN["dbl"],"SELECT coName FROM company WHERE coID='".$_SESSION["GRADINGCO"]."' ");
        if(mysqli_num_rows($x)==1)
        {
            list($coName) = mysqli_fetch_row($x);                
            
            $x = mysqli_query($CN["dbl"],"INSERT INTO REPVIEW (rvID,rvCOID,rvName,rvEmail,rvCode,rvExpire) VALUES (NULL,'".$_SESSION["GRADINGCO"]."','".$NAME."','".$EMAIL."','".$CODE."','".$EXPIRE."')");
            if($x==1)
            {                
                $comSubject = "Job Grading Report: ".$coName;
                $comMessage = "Dear ".$NAME.",<br><br>You have been invited by ".$_SESSION["CO"]["ctName"]." ".$_SESSION["CO"]["ctSurname"]." to view a Job Grading report for ".$coName.". This report can be viewed for up to 30 days and will expire on ".date("d F Y at H:i",$EXPIRE).". To view, click on the link below:<br><br>
                <b>LINK:</b> http://www.autograde.co.za/REPORT/".$EMAIL."/".$CODE."/<br><br>Feel free to contact the AutoGrade support team should you require any additional information.";
                $snd = sendmail($_SESSION["CO"]["ctID"],$EMAIL,$comSubject,$comMessage,$CODE);     
                if($snd==1)
                {
                    echo 3;
                }
                else
                {
                    echo 4;
                }
            }
            else
            {
                echo 5;
            }  
        }
        else
        {
            echo 6;
        }              
    }
}
else
{
    ?>
    <h1>You cannot access this page directly</h1>
    <?
}