<?
session_start();
if(basename($_SERVER["SCRIPT_NAME"]) != "index.php") 
{
    echo"<meta http-equiv=\"refresh\" content=\"1;url=\">";
    exit;
}

include("verificationall.php");
include("design/TEMPLATE3.php");
global $CN; 

$ID1 = intval($_REQUEST["ID1"]);
$ID2 = $_REQUEST["ID2"];

$messages = array(
1=>"Your login session has expired and you have been logged out. Please login again.",
2=>"Please login or register first.",
3=>"You have logged out successfully."
);

if($ID1 && $ID2)
{
    if($ID1==4)
    {
        $x = mysqli_query($CN["dbl"],"SELECT uID FROM users WHERE uOTP='".$ID2."'");
        if(mysqli_num_rows($x)==1)
        {
            $x = mysqli_query($CN["dbl"],"UPDATE users SET uOTP='' WHERE uOTP='".$ID2."'");
            if($x==1)
            {
                    $messages[4] = "Your email address was successfully confirmed. You can now login.";    
            }
            else
            {
                $messages[4] = "Something went wrong and your email address could not be verified. Please contact support on 0110846000.";    
            }
        }    
        else
        {
            $messages[4] = "This email confirmation link is invalid. Please check this link and try again.";    
        }
    }
}
if($ID1==3)
{
    destroy();
}

global $CN;    
openheader("AutoGrade Administration Login","AutoGrade Administration Login");
?>
<script language="javascript" src="scripts/LI.js"></script>
<link rel='stylesheet' type='text/css' href='design/LI.css' />
<?
closeheader("Login to AutoGrade");
?>

<div class="ALLERR" <?if($ID1){?>style="display:block;"<?}?>><?=$messages[$ID1]?></div>
<div class="SQ_WRAPPER">
<div class="ALLTHINK"></div>
    <form method="javascript:{}" action="javascript:{}" onsubmit="checklogin();">

    <h2>Cellphone OR Email:</h2>
    <input type="text" id="CELLOREMAIL" size="25" class="inputboxes" maxlength="40" value="<?=$_COOKIE["MM_LOGIN"]?>"><br><br>

    <h2>Password:</h2>
    <input type="password" id="PASSWORD" size="25" class="inputboxes" maxlength="30">
    
    </form>
        <div class="MED BTN" onclick="checklogin();">User<br>Login</div>
        <div class="MED BTN" onclick="passreminder();">Password Reminder</div>    
</div>
<? 
closehtml(); 
    



