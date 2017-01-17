<?
session_start();
if(basename($_SERVER["SCRIPT_NAME"]) != "index.php") 
{
    $error = 1;
}

include("mmsystem/mainfile2015.php");
global $CN;
include("mmsystem/verifyaccess.php");

if($_POST["ID"]!="NEW"){ $ID = intval($_POST["ID"]); if($_SESSION["TID"][$ID]){ $ID=$_SESSION["TID"][$ID];}else{$ID="NEW";} }else{ $ID=="NEW"; }//verify new with edit

if(($_SESSION["AC"]["aSUPER"]==1 || $_SESSION["AC"]["aLOGIN"]==1))
{

    if($ID!="NEW")
    {
        $x = mysqli_query($CN["dbl"],"SELECT * FROM TITLES WHERE tID='".$ID."' "); //
        if(mysqli_num_rows($x)==1)
        {
            $C = mysqli_fetch_array($x); 
            $_SESSION["THISTID"] = $C["tID"];    
                               
        }    
    }   
    else
    {
        $_SESSION["THISTID"] = "NEW";
        
    }   
    
    if(is_array($C)){$COID = $C["coID"];}else{$COID = $_SESSION["GRADINGCO"];}
    $x = mysqli_query($CN["dbl"],"SELECT coName FROM company WHERE coID='".$COID."'");
    list($coName) = mysqli_fetch_row($x);      
    
    ?>
    <div class="JT_ALL">
        <div class="SB_HDR">Job Information</div>
        <div id="SB_ERR"></div>
        <div id="SB_LINE"></div>
        
        <h2>*Job Title:</h2>
        <input class="JTINPUT" type="text" id="U_1" value="<?=$C["tName"]?>">
        
        <h2>Basic Description:</h2>
        <textarea class="JTINPUT" cols="40" id="U_2" rows="4"><?=$C["tDesc"]?></textarea>
        
        <h2>*Origin:</h2>            
        <div class="IH IH<?if(is_array($C) && $C["tOrigin"]==1){echo 2;}else{echo 1;}?>" id="TB_1"><?=$coName?></div>
        <div class="IH IH<?if(is_array($C) && $C["tOrigin"]==2){echo 2;}else{echo 1;}?>" id="TB_2">Externally</div>
        
        <div class="JT_BTNS">    
            <div class="SML BTN" id="BTN_1" style="display: none;">Save</div>
            <?
            if($_SESSION["AC"]["aSUPER"]==1)
            {
                ?>
                <div class="SML BTN" id="BTN_2" style="display:none;" >Deactivate</div>
                <?    
            }                
            ?>   
        </div>                 
    </div>
    <?
}
else
{
    echo 1;
}

