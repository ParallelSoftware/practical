<?
session_start();
$pageid = 1;
include("verificationall.php");
include("verificationprofile.php");
include("design/TEMPLATE3.php");
global $CN; 

if($_SESSION["GRADINGCO"] && $_SESSION["AC"]["aGRADE"]==1)
{    
    $x = mysqli_query($CN["dbl"],"SELECT coName FROM company WHERE coID='".$_SESSION["GRADINGCO"]."' ");
    if(mysqli_num_rows($x)==1)
    {
        list($coName) = mysqli_fetch_row($x);
        
        openheader("Start New Job Grading Session: ".$coName,substr($CN["sitedescription"],0,150));
        ?>
        <link rel='stylesheet' type='text/css' href='design/GJ.css' />  
        <script language="javascript" src="/scripts/GJ.js"></script>
        <?
        closeheader("Start New Job Grading Session: ".$coName);

        $_SESSION["GRADE"] = 1;

        ?>  
        <div class="ALLERR"></div>
        <div class="SQ_WRAPPER">
        <div class="ALLTHINK"></div>
        <div id="ALLCONTENT">
            <h2>Before starting your grading session kindly keep the following in mind:</h2>
            <ol>
                <li>There is reliable and fast internet availability</li>
                <li>Have at least 30 minutes available for grading</li>
                <li>Jobs are to be graded in the presence of a Grading Committee (Ideally at least 5 members)</li>
                <li>The Job Incumbant should not be present while the respective job is being graded</li>
                <li>There is a job specialist in the room (Superior/Supervisor/Manager of the respective job)</li>
                <li>Job descriptions are not essential but do help with creating an understanding of the role</li>
                <li>The grading committee needs to keep in mind that a JOB is being graded and NOT a person</li>
            </ol>
            <h2>Legal Disclaimer:</h2>

            <ol>    
                <li>Tremendis Learning retains exclusive copyrights in relation to all work embodying intellectual property id est. all grading sysems, training materials, techniques, methods, methodologies, tools and/or lectures irrespective of literary quality and in whatever mode or form expressed. Tremendis Learning further reserves the right to do or to authorise others to do certain acts in relation to the work, which acts represent in the case of each type of work the manners in which that work can be exploited or used for personal gain or profit.</li>
                <li>By use of this portal, its grading system and results produced, Tremendis Learning accepts no liability in any way for any consequential damages, special or otherwise, including but not limited to lost business , loss of jobs, loss of profits or anticipated savings, whether foreseeable or not.</li>
                <li>These terms of business shall be governed by and construed in accordance with the laws of the Republic of South Africa and any dispute arising out of this engagement or these terms shall be subject to the exclusive jurisdiction of the South African Courts</li>
                <li>By selecting the AGREE button below the user and represented organisation hereby acknowledge thay they have read and understood the above terms, conditions and disclaimer.</li>
            </ol>

            <div class="SQBNTS"><div class="MED BTN" id="START">Agree</div><div class="MED BTN" id="DISAGREE">Disagree</div></div>   
        </div>                 
        </div>
        <script>
        document.querySelector("#thebody").addEventListener("click", SQ_TCK, false);
        </script>
        <? 
        closehtml();   
    
    }
    else
    {
        ?><h1>You cannot access this file directly.</h1><?
    }
}
else
{
    ?><h1>You cannot access this file directly.</h1><?
}     