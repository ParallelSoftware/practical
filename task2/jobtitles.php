<?
session_start();
$pageid = 1;
include("verificationall.php");
include("verificationprofile.php");
include("design/TEMPLATE3.php");
global $CN; 

openheader("Manage Job Titles",substr($CN["sitedescription"],0,150));
?>
<link rel='stylesheet' type='text/css' href='design/JT.css' />  
<script language="javascript" src="/scripts/JT.js"></script>
<?
closeheader("Manage Job Titles");
unset($_SESSION["TID"]);
unset($_SESSION["THISTID"]);

?>
<div class="ALLERR"></div>
<div id="JT_FRAME">
<div class="ALLTHINK"></div>
<div class="JT_ROW">

    <div class="JT_ITEM JT_SUP">
        <div class="SPWRAPPER JT_MNU">
            <div class="SPMN SPMNI" id="M1">Add Job Title</div>                
            <div class="SPMN SPMNI" id="M2">View All</div>
            <div class="SPMN SPMNA" id="M3">View Active</div>
            <div class="SPMN SPMNI" id="M4">View Inactive</div>
            <div class="SPMN SORT">
                Sort By:
                <ul>
                    <li class="SRT_SPN" id="S1">Name</li>
                    <li class="SRT_SPN SRT_ACT" id="S2">Date</li>
                    <li class="SRT_SPN" id="S3">Origin</li>
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
document.querySelector("#thebody").addEventListener("click", MAKEMAGIC, false);
document.querySelector("#KW").addEventListener("keyup", SEARCHNOW, false);
SEARCHNOW();
</script>
<? 
closehtml();        