<?
session_start();
if(basename($_SERVER["SCRIPT_NAME"]) != "index.php") 
{
    $error = 1;
}

include("mmsystem/mainfile2015.php");
global $CN;
include("mmsystem/verifyaccess.php");
 
if($_SESSION["GRADE"]==1 && $_SESSION["AC"]["aGRADE"]==1)
{
    $x = mysqli_query($CN["dbl"],"SELECT * FROM contact WHERE ctCOID='".$_SESSION["GRADINGCO"]."' AND ctActive=1 ");
    if(mysqli_num_rows($x)==0)
    {
        echo 1;
        exit;
    }
    
    
    $x = mysqli_query($CN["dbl"],"SELECT * FROM TITLES ORDER BY tName ASC ");
    while($DAT = mysqli_fetch_array($x))
    {
        $A[] = $DAT["tName"];  
        $L[strtoupper($DAT["tName"][0])] = 1;
    }
    
    ?>
    <input type="hidden" id="QTY0" value="<?=mysqli_num_rows($x)?>">
    <div class="SQ_EA">
        <div class="A" id="A1_A_0">Please choose a Job Title that you wish to grade. It is possible to add new positions if the desired position is not available however kindly try and find a suitable or similar position first.</div>
        <div class="HH" id="A1_HH_0">
            <?        
            if(is_array($L)) //make aplhabet
            {
                $i = 0;
                ?>
                <ul class="GG" id="A1_GG_0">
                <li class="G G2" id="ADDNEW">ADD</li>
                <? 
                foreach($L AS $l => $ign)
                { 
                    $i++; 
                    ?>
                    <li class="G G<?if($i==1){echo 2;}else{ echo 1;}?>" id="A1_G_0_<?=$i?>"><?=$l?></li>
                    <? 
                } 
                ?>
                <li class="G4" id="SEARCH"><input id="SRCHKW" class="SRCHIMG" type="text" onkeyup="SEARCHALL();"></li>
                </ul>
                <?
            }                                                                             
            ?>
            <div class="HROW">
            <?            
            
            foreach($A AS $i => $nme)
            {                                                        
                ?>
                <div class="H H1" id="A1_H_0_<?=$i?>" <?if(strtoupper($nme[0])!="A"){?>style="display:none;"<?}?>><?=$nme?></div>            
                <?
            }  
            ?>
            </div>
        </div>
        <?     
        unset($A); 
        unset($L);                        
        unset($DAT);  
        ?>         
    </div>
    <?
    $x = mysqli_query($CN["dbl"],"SELECT ctID,ctCOID,CONCAT(ctName,' ',ctSurname),ctTitle,ctConsult FROM contact WHERE ctActive=1 ORDER BY ctName ASC ");
    while(list($ctID,$ctCOID,$ctName,$ctTitle,$ctConsult) = mysqli_fetch_array($x))
    {
        if($ctCOID==$_SESSION["GRADINGCO"] || ($ctConsult==1 && $_SESSION["AC"]["aSUPER"]==1))
        {
            $A[$ctID] = $ctName.' ('.$ctTitle.')';    
        }        
    }
    
    ?>
    <input type="hidden" id="QTY1" value="<?=count($A)?>">
    <div class="SQ_EA">
        <div class="A" id="A2_A_1">Please choose your Grading Committee. Note that ideally five (5) members should be present when grading a job. Committee can consist of HR, Director/Exco Member, External Consultant/Grading Expert, Line Manager/Departmental/Senior Manager, Finance, Union Member.</div>
        <div class="HH" id="A2_HH_1">
        <div class="HROW">
        <?    
        $i=-1;                
        foreach($A AS $ctID => $nme)
        {
            $i++;
            ?>
            <div class="H H<?if(is_array($_SESSION["COM_MEMORY"]) && in_array($ctID, $_SESSION["COM_MEMORY"])){echo 2;}else{echo 1;}?>" id="A2_H_1_<?=$i?>"><?=$nme?></div>            
            <?
        }  
        ?>
        </div></div>
        <?     
        unset($A); 
        unset($L);                        
        ?>         
    </div>
    
    
    <div class="SQ_EA">
        <div class="A" id="A3_A_2">Reference Number: <i>(Optional)</i></div>
        <div class="HH" id="A3_HH_2"><input class="JTINPUT" type="text" id="REF"></div>
    </div>
    
    <div class="SQ_EA">
        <div class="A" id="A4_A_3">Additional Notes: <i>(Optional)</i></div>
        <div class="HH" id="A4_HH_3"><textarea class="JTINPUT" cols="40" rows="5" id="NOTES"></textarea></div>
    </div>
        
    <div class="SQBNTS"><div class="MED BTN" id="GRADE">Start Grading Now</div></div>
    <div class="SQNXT"></div>
    <?
}         