<?
session_start();
$pageid = 1;
include("verificationall.php");
include("verificationprofile.php");
include("design/TEMPLATE3.php");
global $CN; 

unset($_SESSION["COID"]);
unset($_SESSION["CNTUP"]);
unset($_SESSION["THISCO"]);

if($_SESSION["AC"]["aSUPER"]!=1)
{
    ?>
    <h1>You cannot access this file directly</h1>
    <?
}
else
{
    openheader("Manage Companies",substr($CN["sitedescription"],0,150));
    ?>
    <link rel='stylesheet' type='text/css' href='design/CM.css' />  
    <script language="javascript" src="/scripts/CM.js"></script>
    <?
    closeheader("Manage Companies");

    ?>
    <div class="ALLERR"></div>
    <div id="CM_FRAME">
    <div class="ALLTHINK"></div>
    <div class="CM_ROW">

        <div class="CM_ITEM CM_SUP">
            <div class="SPWRAPPER CM_MNU">
                <div class="SPMN SPMNI" id="M1">Add New Company</div>                
                <div class="SPMN SPMNI" id="M2">View All</div>
                <div class="SPMN SPMNA" id="M3">View Active</div>
                <div class="SPMN SPMNI" id="M4">View Inactive</div>
                <div class="SPMN SORT">
                    Sort By:
                    <ul>
                        <li class="SRT_SPN" id="S1">Name</li>
                        <li class="SRT_SPN" id="S2">Region</li>
                        <li class="SRT_SPN SRT_ACT" id="S3">Date</li>
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
    document.querySelector("#CM_FRAME").addEventListener("click", MAKEMAGIC, false);
    document.querySelector("#KW").addEventListener("keyup", SEARCHNOW, false);
    SEARCHNOW();
    </script>
    <? 
    closehtml();        
}