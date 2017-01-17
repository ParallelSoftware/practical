<?
session_start();
$pageid = 1;
include("verificationall.php");
include("verificationprofile.php");
include("design/TEMPLATE3.php");
global $CN; 

if($_SESSION["COID"][intval($_POST["ID"])])
{
    $x = mysqli_query($CN["dbl"],"SELECT * FROM company,province,country,city WHERE coPROVID=provID AND coCNTYID=cntyID AND coCITYID=cityID AND coID='".$_SESSION["COID"][intval($_POST["ID"])]."' ");
    if(mysqli_num_rows($x)==1)
    {
        $C = mysqli_fetch_array($x);
        $_SESSION["THISCO"] = $C["coID"];
    }
}
unset($_SESSION["CNTUP"]);

if(!is_array($C) && $_SESSION["AC"]["aSUPER"]!=1)
{
    ?>
    <h1>You cannot access this file directly</h1>
    <?
}
else
{

    if(is_array($C)){$SAY = "VIEW/EDIT: ".$C["coName"];}else{$SAY = "Add New Company";}

    openheader($SAY,substr($CN["sitedescription"],0,150));
    ?>
    <link rel='stylesheet' type='text/css' href='design/VC.css' />  
    <script language="javascript" src="scripts/LI.js"></script>
    <script language="javascript" src="/scripts/VC.js"></script>
    <?
    closeheader($SAY);

    $x = mysqli_query($CN["dbl"],"SELECT * FROM COMPARISON "); //
    while($TMP = mysqli_fetch_array($x))
    {
        $CMP[$TMP["cID"]] = $TMP;
    }

    ?>
    <input type="hidden" id="COID" value="<?=$_POST["ID"]?>">
    <div class="ALLERR"></div>
    <div id="VC_FRAME">
    <div class="ALLTHINK"></div>
    <div class="VC_ROW">
        
        <div class="VC_ITEM">
            <div class="VC_HEADER THK_I" id="T_1">General Information</div>
            <div class="VC_WRAPPER">
                <h2>*Company Name:</h2>
                <input type="text" id="U_1_0" value="<?=$C["coName"]?>">
                <h2>Company Reg Nr:</h2>
                <input type="text" id="U_1_1" value="<?=$C["coReg"]?>">
                <h2>*Telephone Number:</h2>
                <input type="text" id="U_1_2" value="<?=$C["coTel1"]?>">
                <h2>*Country</h2>
                <input type="text" id="U_1_3" value="<?=$C["cntyName"]?>"><input type="hidden" id="UI_1_3" value=<?=$C["cntyID"]?>>
                <div class="DROPDOWN DD_I" id="DD_3"></div>                      
                <h2>*Province</h2>
                <input type="text" id="U_1_4" value="<?=$C["provName"]?>"><input type="hidden" id="UI_1_4" value=<?=$C["provID"]?>>
                <div class="DROPDOWN DD_I" id="DD_4"></div>
                <h2>*City</h2>
                <input type="text" id="U_1_5" value="<?=$C["cityName"]?>"><input type="hidden" id="UI_1_5" value=<?=$C["cityID"]?>>
                <div class="DROPDOWN DD_I" id="DD_5"></div>       
            </div>
            <div class="VC_BTNS">
                <div class="SML BTN" id="BTN_1" style="display: none;">Save</div>
                <?
                if($_SESSION["AC"]["aSUPER"]==1)
                {
                    ?>
                    <div class="SML BTN" id="BTN_2" <?if(!is_array($C)){echo"style=\"display:none;\"";}?>>Deactivate</div>
                    <?    
                }                
                ?>            
            </div>        
        </div>
        
        <?
        $x = mysqli_query($CN["dbl"],"SELECT rID,rScore,rTitle,rDate FROM RESULTS WHERE rCOID='".$C["coID"]."'");
        ?>
        
        <div class="VC_ITEM">
            <div class="VC_HEADER THK_I" id="T_2">Jobs Graded</div>
            <?
            if($_SESSION["AC"]["aSUPER"]==1)
            {            
                ?>
                <div class="VC_CREDITS" <?if(!is_array($C)){echo"style=\"display:none;\"";}?>>
                    <?                
                    if(is_array($C))
                    {
                        $z = mysqli_query($CN["dbl"],"SELECT crQTY FROM CREDITS WHERE crCOID='".$C["coID"]."' ORDER BY crID DESC LIMIT 1");
                        if(mysqli_num_rows($z)==1)
                        {
                            list($crQTY) = mysqli_fetch_row($z);    
                        } 
                        else
                        {
                            $crQTY = 0;   
                        }   
                    }
                    else
                    {
                        $crQTY = 0;    
                    }
                    ?>
                    <div id="BTN_3"></div>
                    <div>Add/Remove Credits<h1 id="CRDTS"><?=mysqli_num_rows($x)?>/<?=$crQTY?></h1></div>
                    <div id="BTN_4"></div>                    
                </div>
                <?
            }                
            ?>
            <div class="VC_WRAPPER">
            <?        
            if(mysqli_num_rows($x)>0)
            {
                $i=-1;
                while(list($rID,$rScore,$rTitle,$rDate) = mysqli_fetch_array($x))
                {
                    $i++;
                    $_SESSION["RID"][$i] = $rID;
                    ?>
                    <h3 id="JG_<?=$i?>"><?=$rTitle?></h3>
                    <h4><?=$CMP[round($rScore)]["c1"].'/'.$CMP[round($rScore)]["c5"].'/'.$CMP[round($rScore)]["c3"]?> (<?=date("d F Y @ H:i",$rDate)?>)</h4>
                    <?
                    
                }
            }
            else
            {
                ?>
                <h1>No Job Grading sessions found.</h1>
                <?
            }
            ?>

            </div>        
        </div>
        
        <div class="VC_ITEM">
            <div class="VC_HEADER THK_I" id="T_3">Grading Committee</div>
            <div class="VC_WRAPPER" id="M3">
            <?
            $x = mysqli_query($CN["dbl"],"SELECT * FROM contact WHERE ctCOID='".$C["coID"]."' ");
            ?>
            <input type="hidden" value=<?=mysqli_num_rows($x)?> id="UQTY">
            <?
            if(mysqli_num_rows($x)>0)
            {
                $i=0;
                while($CT = mysqli_fetch_array($x))
                {
                    $i++;
                    $_SESSION["CNTUP"][$i] = $CT["ctID"];
                    
                    $ac = mysqli_query($CN["dbl"],"SELECT * FROM ACCESS WHERE aCTID='".$CT["ctID"]."' ORDER BY aID DESC LIMIT 1 ");
                    $AC = mysqli_fetch_array($ac);
                    ?>
                    <div id="MI_<?=$i?>">
                        <div id="A_<?=$i?>">
                            <h3 id="AI_<?=$i?>_1"><?=$CT["ctName"]?> <?=$CT["ctSurname"]?></h3>
                            <h4 id="AI_<?=$i?>_2"><?=$CT["ctTitle"]?></h4>
                        </div>
                        <div class="VC_C_SH" id="B_<?=$i?>">
                            <h2>*Name:</h2>
                            <input type="text" id="CO_<?=$i?>_1" value="<?=$CT["ctName"]?>">
                            <h2>*Surname:</h2>
                            <input type="text" id="CO_<?=$i?>_2" value="<?=$CT["ctSurname"]?>">
                            <h2>*Job Title:</h2>
                            <input type="text" id="CO_<?=$i?>_3" value="<?=$CT["ctTitle"]?>">            
                            <h2>*Email Address:</h2>
                            <input type="text" id="CO_<?=$i?>_4" value="<?=$CT["ctEmail"]?>">
                            <h2>*Mobile Number:</h2>
                            <input type="text" id="CO_<?=$i?>_5" value="<?=$CT["ctTel1"]?>">
                            <h2>*Access</h2>                        
                            <div class="H H<? if(is_array($AC) && $AC["aLOGIN"]==1){echo 2;}else{echo 1;}?>" id="TB_<?=$i?>_0">Can Login</div>
                            <div class="H H<? if(is_array($AC) && $AC["aVIEW"] ==1){echo 2;}else{echo 1;}?>" id="TB_<?=$i?>_1">Can View Results</div>
                            <div class="H H<? if(is_array($AC) && $AC["aGRADE"]==1){echo 2;}else{echo 1;}?>" id="TB_<?=$i?>_2">Can Grade Jobs</div>
                            <div class="H H<? if(is_array($AC) && $AC["aADMIN"]==1){echo 2;}else{echo 1;}?>" id="TB_<?=$i?>_3">Administration Rights</div>
                            <div class="VC_BTNS">
                                <div class="XSML BTN2" id="BTN_5_<?=$i?>" style="display: none;">Save</div>
                                <div class="XSML BTN2" id="BTN_6_<?=$i?>" onClick="passreminder();">Reset Password</div>
                                <div class="XSML BTN2" id="BTN_7_<?=$i?>">Deactivate</div>
                                <div class="XSML BTN2" id="BTN_8_<?=$i?>" onClick="passreminder();">Send SMS</div>
                            </div> 
                        </div>
                    </div>
                    <?
                    
                }
            }
            else
            {
                ?>
                <h1 id="nocomm">No committee members found.</h1>
                <?
            }
            ?>
            </div>  
            <div class="VC_BTNS">
                <div class="SML BTN" id="BTN_9" <? if(!is_array($C)){echo"style=\"display:none;\"";}?>>Add Member</div>            
                <div class="SML BTN" id="BTN_10" <? if(!is_array($C)){echo"style=\"display:none;\"";}?>>SMS All</div>
            </div>       
        </div>
        
        <?
        if($_SESSION["AC"]["aSUPER"]==1)
        {
            ?>
            <div class="VC_ITEM">
                <div class="VC_HEADER THK_I" id="T_4">Grading Changeover</div>
                <div class="VC_WRAPPER" id="M4">             
                    <h2>This will enable you to grade for this specific company. This functionality is limited to SUPER users only.</h2>
                    <div class="VC_BTNS">
                        <div class="LRGE BTN" id="BTN_11" <? if(!is_array($C)){echo"style=\"display:none;\"";}?>>Active Now</div>
                    </div>      
            </div>
            <?
        }
        ?>
    </div>
    </div>

    <script>
    document.querySelector("#VC_FRAME").addEventListener("click", MAKEMAGIC, false);
    document.querySelector(".VC_ROW").addEventListener("keyup", UPDNFO, false);
    </script>
    <? 
    closehtml();      
}  