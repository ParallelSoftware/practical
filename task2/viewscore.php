<?
session_start();
if($_REQUEST["ID"]=="GRADINGSAMPLE")
{
	if(basename($_SERVER["SCRIPT_NAME"]) != "index.php") 
	{
	    exit;
	}
	include("../mmsystem/mainfile2015.php");
	
	date_default_timezone_set('Africa/Johannesburg');
	$ID = 1;
}
else
{
	include("verificationall.php");
	include("verificationprofile.php");
	$ID = $_SESSION["RID"][intval($_POST["ID"])];
}

include("design/TEMPLATE3.php");

if($ID!=0)
{
    global $CN;
    $x = mysqli_query($CN["dbl"],"SELECT * FROM RESULTS WHERE rID='".$ID."' "); //results info
    if(mysqli_num_rows($x)>0)
    {
        $R = mysqli_fetch_array($x);
        
        $_SESSION["NOTES"] = $R["rID"];
        
        $x = mysqli_query($CN["dbl"],"SELECT * FROM TITLES WHERE tID='".$R["rTID"]."' "); // job title info
        $T = mysqli_fetch_array($x);

        $COM = explode(",",$R["rCommittee"]);
        foreach($COM AS $ctID)
        {
            $x = mysqli_query($CN["dbl"],"SELECT * FROM contact WHERE ctID='".$ctID."' "); //committee info
            while($TMP = mysqli_fetch_array($x))
            {
                $C[] = $TMP;
            }    
        }
        unset($TMP);
        unset($COM);        
        
        $x = mysqli_query($CN["dbl"],"SELECT * FROM contact WHERE ctID='".$R["rConsultant"]."' "); //get consultant info
        $CS = mysqli_fetch_array($x);
        
        $x = mysqli_query($CN["dbl"],"SELECT * FROM COMPARISON "); //get all grades info (comparison)
        while($TMP = mysqli_fetch_array($x))
        {
            $CMP[$TMP["cID"]] = $TMP;
        }
        unset($TMP);     
        
        $CID = round($R["rScore"]);                            
        
        openheader("Grade Results: ".$R["rTitle"],substr($CN["sitedescription"],0,150));
        ?>
        <link rel='stylesheet' type='text/css' href='design/VS.css' />  
        <script language="javascript" src="/scripts/VS.js"></script>
        <?
        closeheader("Grade Results: ".$R["rTitle"]); 
    
        $PG = round(12.9 * ($CID-1));
        if($_REQUEST["ID"]=="GRADINGSAMPLE")
        {
	        ?>
	        <div class="ALLERR" style="display: block;">This page shows a sample of the AutoGrade system grading results.</div>
	        <?
        }
        
        ?>
        <div id="VS_ALL">        
        
        <div class="VS_RESHDR"><h1>Overview</h1></div>
        
        <div id="VS_FRAME">          
            
            <div class="VS_WRAPPER">
                <div class="VS_DIAL gr_paterson"><img src="/images/gr_needle.png" style="-webkit-transform: rotate(<?=$PG?>deg); -moz-transform: rotate(<?=$PG?>deg); -ms-transform: rotate(<?=$PG?>deg); -o-transform: rotate(<?=$PG?>deg); transform: rotate(<?=$PG?>deg);"></div>    
            </div>
        
            <div class="VS_WRAPPER">
                <div class="VS_DIAL gr_peromnes"><img src="/images/gr_needle.png" style="-webkit-transform: rotate(<?=$PG?>deg); -moz-transform: rotate(<?=$PG?>deg); -ms-transform: rotate(<?=$PG?>deg); -o-transform: rotate(<?=$PG?>deg); transform: rotate(<?=$PG?>deg);"></div>    
            </div>
        
            <div class="VS_WRAPPER">
                <div class="VS_DIAL gr_hay"><img src="/images/gr_needle.png" style="-webkit-transform: rotate(<?=$PG?>deg); -moz-transform: rotate(<?=$PG?>deg); -ms-transform: rotate(<?=$PG?>deg); -o-transform: rotate(<?=$PG?>deg); transform: rotate(<?=$PG?>deg);"></div>    
            </div>
    
            <div class="VS_WRAPPER">
                <div class="VS_DIAL VS_ALLDTL">
                <table cellpadding="5" cellspacing="2" width="100%" border="0" style="padding-top: 30px;">
                <?
                $z = mysqli_query($CN["dbl"],"SELECT cnID,cnName FROM COMPNAMES ORDER BY cnOrder ASC LIMIT 6 ");
                while(list($cnID,$cnName) = mysqli_fetch_array($z))
                {
                    ?>
                    <tr>
                        <td align="right" class="VSTD"><?=$cnName?>:</td>
                        <td align="left" class="VSTD"><b><?=$CMP[$CID]["c".$cnID]?></b></td>                    
                    </tr>
                    <?
                }                    
                ?>
                </table> 
                </div>
            </div>
        
            <div class="VS_WRAPPER">
                <div class="VS_DIAL VS_ALLDTL">
                <?
                $z = mysqli_query($CN["dbl"],"SELECT cnID,cnName FROM COMPNAMES WHERE cnID=7 ");
                list($cnID,$cnName) = mysqli_fetch_array($z);
                
                    ?>
                    <h1><?=$R["rTitle"]?></h1>
                    <h3>Ref nr: <?if($R["rRef"]){echo $R["rRef"]; }else{ echo "None";}?></h3>
                    <h2>(Level: <?=$CMP[$CID]["c".$cnID]?>)</h2>                
                    <?                                
                ?>
                </div>
            </div>
            <?
            $x = mysqli_query($CN["dbl"],"SELECT coName FROM company WHERE coID='".$R["rCOID"]."' ");
            list($coName) = mysqli_fetch_row($x);            
            ?>
            <div class="VS_WRAPPER">
                <div class="VS_DIAL VS_ALLDTL">
                <h2 style="padding-top: 25px;">Company:</h2>
                <h3><?=$coName?></h3>
                <h2>Consultant:</h2>
                <h3><?=$CS["ctName"]?> <?=$CS["ctSurname"]?><br><i><?=$CS["ctTitle"]?></i></h3>
                <h2>Date Graded:</h2>
                <h3><?=date("d F Y @ H:i",$R["rDate"])?></h3>
                <h2>Duration:</h2>
                <h3><?$H = floor($R["rTime"]/60); echo $H.' minutes, '.($R["rTime"]-($H*60)).' seconds'; ?></h3>
                </div>
            </div>
                
        </div>
        
        <div class="VS_RESHDR"><h1>Grade Category Results</h1></div>
        
        <div id="PQ_FRAME">          
            <?
            $ARR = explode(",",$R["rRaw"]);
            foreach($ARR AS $sID)
            {
                $z = mysqli_query($CN["dbl"],"SELECT cName FROM CATS ORDER BY cOrder ASC ");
                while(list($cName) = mysqli_fetch_array($z))
                {                
                    $C_ARR[] = $cName;
                }
            }
            
            $ARR = explode(",",$R["rSPC"]);
            
            $i=-1;
            foreach($ARR AS $VAL)
            {
                $i++;
                $PG = round(($VAL-1) * 7.8,0);
                ?>
                <div class="PQ_WRAPPER">
                    <div class="PQ_DIAL">
                        
                        <div class="PQDTL"><?=$CMP[round($VAL)]["c1"]?>/<?=$CMP[round($VAL)]["c5"]?>/<?=$CMP[round($VAL)]["c3"]?></div>           
                        
                        <img src="/images/gr_genneedle.png" style="-webkit-transform: rotate(<?=$PG?>deg); -moz-transform: rotate(<?=$PG?>deg); -ms-transform: rotate(<?=$PG?>deg); -o-transform: rotate(<?=$PG?>deg);transform: rotate(<?=$PG?>deg);">
                    </div>  
                    
                    <div class="PQ_TIT"><?=$C_ARR[$i]?></div>
                </div>
            <?
            }
            ?> 
        </div>
        
        <?
        $x = mysqli_query($CN["dbl"],"SELECT * FROM GRADES WHERE gTID='".$R["rTID"]."' ORDER BY gID DESC ");
        if(mysqli_num_rows($x)>0)
        {
            ?>
            <div class="VS_RESHDR"><h1>Industry Comparison</h1></div>
        
            <div id="VS_FRAME">
                <div class="CMP">
                    <table cellpadding="5" cellspacing="0" width="100%">
                        <tr>
                            <td class="VS_CMPHDR"><?=$R["rTitle"]?></td>
                            <?
                            while($G = mysqli_fetch_array($x))
                            {
                                ?>
                                <td  class="VS_CMPDTL">
                                Pat. <b><? if($G["gPaterson"]){ echo $CMP[$G["gPaterson"]]["c1"]; }else{ echo "N/A"; } ?></b><br>
                                Per. <b><? if($G["gPeromnes"]){ echo $CMP[$G["gPeromnes"]]["c5"]; }else{ echo "N/A"; } ?></b><br>
                                Hay. <b><? if($G["gHay"]){ echo $CMP[$G["gHay"]]["c3"]; }else{ echo "N/A"; } ?></b></td>
                                <?    
                            }        
                            ?>                
                        </tr>
                    </table>
                </div>
            </div>
            <?                  
        }    
        ?>                
        
        <div class="VS_RESHDR"><h1>Grading Committee</h1></div>
        
        <div id="VS_FRAME">
            <div class="COMMITTEE">
                <ol>
                    <?
                    foreach($C AS $ID => $COM)
                    {
                        echo"<li>".$COM["ctName"]." ".$COM["ctSurname"]." (".$COM["ctTitle"].")</li>";                        
                    }                        
                    ?>                
                </ol>
            </div>
        </div>
        
        <div class="VS_RESHDR"><h1>Notes <i>(Editable)</i></h1></div>
        
        <div id="VS_FRAME">
            <div class="INOTE"><b>Pre-Grading Notes:</b> <?if($R["rNotes"]){echo $R["rNotes"];}else{echo "None";}?></div>
            <textarea id="NOTES" onkeyup="UPDNOTES();"><?=$R["rNotes2"]?></textarea>
        </div>
        
        </div>
        <? 
        closehtml();
    }     
}  
else
{
    ?><h1>You cannot access this file directly. IP RECORDED.</h1><?
}