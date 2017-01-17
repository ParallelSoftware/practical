<?
session_start();
$pageid = 1;
include("verificationall.php");
include("verificationprofile.php");
include("design/TEMPLATE3.php");
global $CN; 

if($_SESSION["GRADINGCO"])
{    
    $x = mysqli_query($CN["dbl"],"SELECT coName FROM company WHERE coID='".$_SESSION["GRADINGCO"]."' ");
    if(mysqli_num_rows($x)==1)
    {
        list($coName) = mysqli_fetch_row($x);
        
        openheader("Graded Positions: ".$coName,substr($CN["sitedescription"],0,150));
        ?>
        <link rel='stylesheet' type='text/css' href='design/GH.css' />  
        <script language="javascript" src="/scripts/GH.js"></script>
        <?
        closeheader("Graded Positions: ".$coName);

        ?>
        <div class="ALLERR"></div>
        <div id="GH_FRAME">
        <div class="ALLTHINK"></div>
        <div class="GH_ROW">

            <div class="GH_ITEM GH_SUP">
                <div class="SPWRAPPER GH_MNU">
                    <div class="SPMN SPMNI" id="M1">Grade New Job</div>                
                    <div class="SPMN SPMNI" id="M2">View All</div>
                    <div class="SPMN SPMNA" id="M3">View Active</div>
                    <div class="SPMN SPMNI" id="M4">View Inactive</div>
                    <div class="SPMN SORT">
                        Sort By:
                        <ul>
                            <li class="SRT_SPN" id="S1">Name</li>
                            <li class="SRT_SPN SRT_ACT" id="S2">Date</li>
                            <li class="SRT_SPN" id="S3">Grade</li>
                            <li class="UPDOWN UD_U" id="UD"></li>
                            </ul>
                        </div>
                    <div class="SPMN"><input type="text" class="KW LVE" id="KW"></div>
                </div>
            </div>
            
            <div id="CNTHERE"></div>

        </div>
        </div>

        <script>
        document.querySelector("#GH_FRAME").addEventListener("click", MAKEMAGIC, false);
        document.querySelector("#KW").addEventListener("keyup", SEARCHNOW, false);
        SEARCHNOW();
        </script>
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

    