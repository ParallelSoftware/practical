<?
session_start();
if(basename($_SERVER["SCRIPT_NAME"]) != "index.php") 
{
    $error = 1;
}
$IGN_ACCESS = 1; // access id for not logged in files
include("mmsystem/mainfile2015.php");
global $CN;
include("mmsystem/verifyaccess.php");
include("mmsystem/communicate.php");

$val = strtolower(str_replace(" ","",$_POST["VAL"]));

if(!$val)
{
    echo 1;
    exit;
}
elseif(!ctype_digit($val) && !filter_var($val,FILTER_VALIDATE_EMAIL))
{
    echo 2;
    exit;
}
else
{
    if(filter_var($val,FILTER_VALIDATE_EMAIL))
    {
        $text = "ctEmail='".$val."'";
    }
    else
    {
        $text = "ctTel1='".$val."'";   
    }
    
    $x = mysqli_query($CN["dbl"],"SELECT ctID,ctName FROM contact WHERE ".$text." AND ctActive=1 ORDER BY ctID DESC LIMIT 1");        
    if(mysqli_num_rows($x)==1)
    {
        list($ctID,$ctName) = mysqli_fetch_row($x); 
        $A = array("a","b","c","d","e","f","g","h","k","m","n","p","r","s","t","v","w","x","z",1,2,3,4,5,6,7,8,9);
        for($i=0;$i<=7;$i++)
        {
            $k = array_rand($A);
            $P[$i] = $A[$k];
        } 
        $ctPassword = implode("",$P);        
        $x = mysqli_query($CN["dbl"],"UPDATE contact SET ctPassword='".$ctPassword."' WHERE ctID='".$ctID."'");
        if($x==1)
        {
            if(filter_var($val,FILTER_VALIDATE_EMAIL))
            {
                $comSubject = "Password Reset: ".$CN["msSiteName"];
                $comMessage = "Hi ".$ctName.",<br><br>You, or someone has requested that we reset your password. Your new temporary password is <b>".$ctPassword."</b> and you can login with your email address or cellphone number, depending on what we have listed on our database.<br><br>
                If you battle with something please call our support line on +27(0)11 084 6000.";
                $z = sendmail($ctID,$val,$comSubject,$comMessage,$ctPassword); 
                
                if($z==1)
                {
                    echo 5;
                }
                else
                {
                    echo 7;
                }
            }
            else
            {
                $comMessage = "Hi ".$ctName.", You've requested that we reset your password. Your new temporary password is ".$ctPassword.". See you soon!";
                $z = sendsms($ctID,$val,"",$comMessage,$ctPassword); 
                if($z==1)
                {
                    echo 6;
                }
                else
                {
                    echo 7;
                }   
            }
        }
        else
        {
            echo 4;
        }
    }
    else
    {
        echo 3;
        exit;    
    }                        
}
?>
