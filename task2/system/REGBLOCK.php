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
?>
<link rel='stylesheet' type='text/css' href='design/REGBLOCK.css' />
<?
$REG_ID = $_POST["ID"];

$ARR["ALLOW"][1] = array(0,1,2,3,4,5,6,7,8,9,10); //ALL
$ARR["REQ"][1] = array(1,1,1,1,1,1,0,1,1,1,1);
$ARR["HDR"][1] = "Registration";

?>
<div class="REG_HDR"><?=$ARR["HDR"][$REG_ID]?></div>

<?$B=0;?>
<div name="BLOCK" class="REG_OPT" <?if(!in_array($B,$ARR["ALLOW"][$REG_ID])){echo"style=\"display: none;\"";}?>>
<div class="REG_LEFT">Name<?if($ARR["REQ"][$REG_ID][0]==1){echo"*";}?>:</div>
<div class="REG_RIGHT"><input type="text" name="REG" size="25" class="inputboxes" maxlength="30"></div>
</div>
<?$B=1;?>
<div name="BLOCK" class="REG_OPT" <?if(!in_array($B,$ARR["ALLOW"][$REG_ID])){echo"style=\"display: none;\"";}?>>
<div class="REG_LEFT">Surname <?if($ARR["REQ"][$REG_ID][$B]==1){echo"*";}?>:</div>
<div class="REG_RIGHT"><input type="text" name="REG" size="25" class="inputboxes" maxlength="30"></div>    
</div>
<?$B=2;?>
<div name="BLOCK" class="REG_OPT" <?if(!in_array($B,$ARR["ALLOW"][$REG_ID])){echo"style=\"display: none;\"";}?>>
<div class="REG_LEFT">Profile Name<?if($ARR["REQ"][$REG_ID][$B]==1){echo"*";}?>:</div>
<div class="REG_RIGHT"><input type="text" name="REG" size="25" class="inputboxes" maxlength="30" onkeyup="checknick();"><br><font size="1">This is your Nickname that the public will see when you take part in the Metroman community.</font></div>
</div>
<?$B=3;?>
<div name="BLOCK" class="REG_OPT" <?if(!in_array($B,$ARR["ALLOW"][$REG_ID])){echo"style=\"display: none;\"";}?>>
<div class="REG_LEFT">Gender<?if($ARR["REQ"][$REG_ID][$B]==1){echo"*";}?>:</div>
<div class="REG_RIGHT"><input type="radio" name="REG" checked > Male&nbsp;&nbsp;&nbsp;<input type="radio" name="REG"> Female</div>
</div>
<?$B=4;?>
<div name="BLOCK" class="REG_OPT" <?if(!in_array($B,$ARR["ALLOW"][$REG_ID])){echo"style=\"display: none;\"";}?>>
<div class="REG_LEFT">Cellphone Number<?if($ARR["REQ"][$REG_ID][$B]==1){echo"*";}?>:</div>
<div class="REG_RIGHT"><input type="text" name="REG" size="25" class="inputboxes" onkeyup="checkdigit(this.value);" maxlength="10"></div>
</div>
<?$B=5;?>
<div name="BLOCK" class="REG_OPT" <?if(!in_array($B,$ARR["ALLOW"][$REG_ID])){echo"style=\"display: none;\"";}?>>
<div class="REG_LEFT">Email Address<?if($ARR["REQ"][$REG_ID][$B]==1){echo"*";}?>:</div>
<div class="REG_RIGHT"><input type="text" name="REG" size="25" class="inputboxes" maxlength="50"></div>
</div>
<?$B=6;?>
<div name="BLOCK" class="REG_OPT" <?if(!in_array($B,$ARR["ALLOW"][$REG_ID])){echo"style=\"display: none;\"";}?>>
<div class="REG_LEFT">Birth Date<?if($ARR["REQ"][$REG_ID][$B]==1){echo"*";}?>:</div>
<div class="REG_RIGHT"><input type="text" name="REG" size="25" class="inputboxes" maxlength="50"></div>
</div>
<?$B=7;?>
<div name="BLOCK" class="REG_OPT" <?if(!in_array($B,$ARR["ALLOW"][$REG_ID])){echo"style=\"display: none;\"";}?>>
<div class="REG_LEFT">Password<?if($ARR["REQ"][$REG_ID][$B]==1){echo"*";}?>:</div>
<div class="REG_RIGHT"><input type="password" name="REG" size="25" class="inputboxes" maxlength="30"></div>
</div>
<?$B=8;?>
<div name="BLOCK" class="REG_OPT" <?if(!in_array($B,$ARR["ALLOW"][$REG_ID])){echo"style=\"display: none;\"";}?>>
<div class="REG_LEFT">Password Repeat<?if($ARR["REQ"][$REG_ID][$B]==1){echo"*";}?>:</div>
<div class="REG_RIGHT"><input type="password" name="REG" size="25" class="inputboxes" maxlength="30"></div>
</div>
<?$B=9;?>
<div name="BLOCK" class="REG_OPT" <?if(!in_array($B,$ARR["ALLOW"][$REG_ID])){echo"style=\"display: none;\"";}?>>
<div class="REG_LEFT">Preferred Branch<?if($ARR["REQ"][$REG_ID][$B]==1){echo"*";}?>:</div>
<div class="REG_RIGHT"><select name="REG" class="inputboxes">
<option value="">Please Choose</option> 
<?
$x = mysqli_query($CN["dbl"],"SELECT bID,bName FROM branches WHERE bActi=1 ORDER BY bName ASC");
while(list($bID,$bName) = mysqli_fetch_row($x))
{
    ?>
    <option value="<?=$bID?>"><?=$bName?></option>
    <?   
}
?>
</select> 
</div>
</div>
<?$B=10;?>
<div name="BLOCK" class="REG_OPT" <?if(!in_array($B,$ARR["ALLOW"][$REG_ID])){echo"style=\"display: none;\"";}?>>
<div class="REG_LEFT">Verification<?if($ARR["REQ"][$REG_ID][$B]==1){echo"*";}?>:</div>
<div class="REG_RIGHT"><input type="text" name="REG" size=5 class="inputboxes" maxlength="10" style="display: block; float: left;">
<div class="REG_CAP">
<?
$rand = range(0,5);
shuffle($rand);
for($i=0; $i<=4; $i++)
{
    ?>
    <div class="REG_CAPPIC" style="background-position: -<?=($rand[$i]*20)?>px;"></div>
    <?
}  
$_SESSION["CAP"] = implode("",$rand);  
?>
</div>
</div>
</div>

<div class="REG_CONF"><img src="/images/confirm.png" onclick="verifyregistration();"><img src="/images/closebtn.png" onclick=""></div>

<div class="REGIMG"><img id="REG_IMG" style="display: none;" src="images/linethink.gif" border="0"></div>
<?