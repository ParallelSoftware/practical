<?
session_start();
if(strlen($_REQUEST["UNIQUE"])>10 && filter_var($_REQUEST["EM"],FILTER_VALIDATE_EMAIL))
{
    if(basename($_SERVER["SCRIPT_NAME"]) != "index.php") 
    {
        exit;
    }
    include("../mmsystem/mainfile2015.php");
    global $CN;
    
    date_default_timezone_set('Africa/Johannesburg');
    
    $x = mysqli_query($CN["dbl"],"SELECT rvCOID,rvExpire FROM REPVIEW WHERE rvCode='".$_REQUEST["UNIQUE"]."' AND rvEmail='".$_REQUEST["EM"]."' ORDER BY rvID DESC LIMIT 1" );
    if(mysqli_num_rows($x)==1)
    {
        list($COID,$rvExpire) = mysqli_fetch_row($x);  
    }        
}
elseif(strlen($_REQUEST["UNIQUE"])=="")
{
    include("verificationall.php");
    include("verificationprofile.php");
    $COID = $_SESSION["GRADINGCO"];
}

include("design/TEMPLATE3.php");

if($COID)
{    
    $x = mysqli_query($CN["dbl"],"SELECT coName FROM company WHERE coID='".$COID."' ");
    if(mysqli_num_rows($x)==1)
    {
        list($coName) = mysqli_fetch_row($x);
        
        if($rvExpire){ $_SESSION["REPEXPIRE"] = $rvExpire; }
        $_SESSION["REPCO"] = $COID;
        
        openheader("Graded Report: ".$coName,substr($CN["sitedescription"],0,150));
        ?>
        <link rel='stylesheet' type='text/css' href='design/GR.css' />  
        <script language="javascript" src="/scripts/GR.js"></script>
        <?
        closeheader("Graded Report: ".$coName); 
        $_SESSION["SORT"] = 1;
        ?>
        <div class="ALLERR"></div>
        <div id="GR_FRAME">            
            <div class="ALLTHINK"></div>
            <?
            if($rvExpire && $rvExpire<=date("U"))    
            {
                ?><h1>The date for viewing this report has expired. Please contact the administrator to regain access.</h1><?
            }
            else
            {
                ?>
                <div class="GR_SORT">
                    <div class="SORTBY">Sort By:</div>
                    <div class="GRBTN INA" id="S1">Job Title</div>
                    <div class="GRBTN ACT" id="S2">Grading Date</div>
                    <div class="GRBTN INA" id="S3">Grade</div>
                    <div class="GRBTN INA" id="S4">Duration</div>
                    <div class="GRBTN INA" id="S5">Ref nr</div>            
                </div>
                <div id="CNTHERE"></div>
                <?
                if($_SESSION["AC"]["aSUPER"]==1 || $_SESSION["AC"]["aADMIN"]==1)
                {
                    ?>
                    <div class="BTNBLOCK"><div class="BTN MED" id="EMAIL">Email This Report</div></div>
                    <?
                }
                ?>
                <script>
                document.querySelector("#thebody").addEventListener("click", MAKEMAGIC, false);        
                SEARCHNOW(2);
                </script>
                <?
            }
            ?>                                    
        </div>        
        <? 
        closehtml();    
    }
    else
    {
        ?><h1>Invalid ID. You cannot access this page directly.</h1><?
    }  
}
else
{
    ?><h1>You cannot access this file directly.</h1><?
}

    