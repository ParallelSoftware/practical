<?
session_start();
if(basename($_SERVER["SCRIPT_NAME"]) != "index.php") 
{
    $error = 1;
}

include("mmsystem/mainfile2015.php");
global $CN;
include("mmsystem/verifyaccess.php");

if($_SESSION["CQID"][$_POST["ID"]] || $_POST["ID"])
{
    if($_SESSION["CQID"][$_POST["ID"]] )
    {
        $x = mysqli_query($CN["dbl"],"SELECT * compQs WHERE cqID='".$_SESSION["CQID"][$_POST["ID"]] ."'");
        if(mysqli_num_rows($x)==1)
        {
            $row = mysqli_fetch_array($x);
        }
        else
        {
            echo 1;
        }
    }
    else
    {
        $ARR = explode(",",$_POST["ID"]);
        if(count($ARR)<=1)
        {
            echo 1;
        }
    }
    
    ?>
    <div class="MQCNT">200</div>
    <div class="MQEA MQQHDR">
        <b>Question:</b>
        <div class="MQINPHDR"><textarea class="MQ_QHDR" cols="40" rows="2" id="A9_0"><?=$row["cqQ"]?></textarea></div>
    </div>
    <?
    if($row["cqType"]==2 || $ARR[0]==1)
    {
        if($ARR[0]==1)
        {
            $QTY = $ARR[1];
        }
        else
        {
            $x = mysqli_query($CN["dbl"],"SELECT * FROM compOs WHERE cqoCQID='".$row["cqID"]."' AND cqoActive=1 ORDER BY cqoOrder ASC");
            $QTY = mysqli_num_rows($x);
        }
        for($i=0;$i<$QTY;$i++)
        {
            ?>
            <div class="MQEA">                
                <b><?=$i+1?></b>
                <div class="MQINP"><textarea class="MQ_Q" cols="40" rows="2" id="A9_<?=$i+1?>"></textarea></div>
                <div class="MQFADER"><img class="MQFADBTN" src="/images/sliderbtn.png" id="SL<?=$i?>"></div>
            </div>
            <?
        }
    }    
    ?>    
    <span class="SPN" id="A9">Submit Question</span>
    <?    
}            