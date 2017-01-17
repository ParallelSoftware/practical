<?
session_start();
$pageid = 1;
include("verificationall.php");
include("verificationprofile.php");
include("design/TEMPLATE_ASS.php");
global $CN; 

if($_SESSION["TITLE"] && $_SESSION["TID"] && $_SESSION["COMMITTEE"] && $_SESSION["GRADE"]==2)
{
    $_SESSION["GRADE"] = 3;
    
    openheader("Grading: ".$_SESSION["TITLE"],'');
    ?>
    <link rel='stylesheet' type='text/css' href='design/GP.css' />  
    <script language="javascript" src="/scripts/GP.js"></script>
    <?
    closeheader(); 
    ?>
    <div class="ALLERR"></div>    
    <div class="SQ_WRAPPER">
    <div class="ALLTHINK"></div>
    <?
    $a = -1;
    $nr = 0;
    $x = mysqli_query($CN["dbl"],"SELECT * FROM CATS ORDER BY cOrder ASC");
    while($C = mysqli_fetch_array($x))
    {
        $a++;
        
        ?>
        <a href="#CA_<?=$a?>" class="CA CAX<?=$a?>" id="CA_<?=$a?>"><?=$C["cName"]?></a>
        <div class="CA1" id="CA1_<?=$a?>"><?
        $b = -1;
        $y = mysqli_query($CN["dbl"],"SELECT * FROM MAIN WHERE mCATID='".$C["cID"]."' ORDER BY mID ASC");
        while($M = mysqli_fetch_array($y))
        {
            $b++;
            $nr++;
            $MNAME = str_replace("%%",$_SESSION["TITLE"],$M["mName"]);
            ?><a href="#MA_<?=$a?>_<?=$b?>" class="MA" id="MA_<?=$a?>_<?=$b?>"><?=$nr?>. <?=$MNAME?></a><?
            $c = -1;
            $z = mysqli_query($CN["dbl"],"SELECT * FROM SECONDARY WHERE sMID='".$M["mID"]."' ORDER BY sOrder ASC");
            while($S = mysqli_fetch_array($z))
            {
                $c++;
                ?><div class="SE SE1" id="SE_<?=$a?>_<?=$b?>_<?=$c?>"><?=$S["sName"]?></div><?
            }        
        }   
        ?>
        </div>
        <?
    }
    ?>         
    </div>
    <div class="admheader">
        <span class="topnfo" id="progbar"><span id="progval">0%</span></span><input type="hidden" id="progid" value=0>
        <span class="topnfo" id="score">View Results</span>
        <span class="topnfo" id="close">Close Page</span>
        <span class="topnfo" id="time">00:00</span>
        <span class="topnfo off" id="pause" onclick="pause();"></span>
        <span class="topnfo" id="stop" onclick="stop();"></span>
    </div>
    <script>
    document.querySelector(".SQ_WRAPPER").addEventListener("click", gradecalc, false);
    document.querySelector("#score").addEventListener("click", scorenow, false);
    
    setheight();    
    </script>
    <? 
    closehtml();    
}
else
{
    echo"<meta http-equiv=\"refresh\" content=\"1;url=".$CN["msAddress"]."/gradehistory.htm\">";
}

       