<?
function openheader($title,$description)
{
    global $CN; 
    $url = $_SERVER['REQUEST_URI'];     
    $useragent = $_SERVER['HTTP_USER_AGENT'];
    
    if(!$_COOKIE["MM_MOBILE"])
    {
        require_once 'Mobile_Detect.php';
        $detect = new Mobile_Detect;
        $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
        
        setcookie("MM_MOBILE", $deviceType);    
    }
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>    
    <title><?=$title?></title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta http-equiv="content-language" content="english" />
    <meta name="Title" content="<?=$title?>" scheme="" />
    <meta name="Description" content="<?=substr(stripslashes(strip_tags($description)),0,300)?>" scheme="" />
    <META NAME="geo.position" CONTENT="-26.002899; 28.075664"> 
    <META NAME="geo.placename" CONTENT="Johannesburg, Gauteng"> 
    <META NAME="geo.region" CONTENT="ZA-GT">
    <meta name="google-site-verification" content="<?=$CN["msGoogle"]?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">     
    <link rel='stylesheet' type='text/css' href='design/CSS4.css' />       
    <link rel="icon" type="image/png" href="images/square.png" >        
    <script language="javascript" src="scripts/ME4.js"></script>
    <script type="text/javascript">var siteaddress = '<?=$CN["msAddress"]?>';</script>    
    <?
}

function closeheader($prheader)
{
    global $CN;
    $ip = get_client_ip();

    ?>
    </head>
    <body id="thebody">    
   
    <div id="BLACKOUT" style="display: none;"></div>  
    <div id="TOTALTHINK" style="display: none;"></div>
    
    <div id="CONF_OUTER" style="display: none;">
        <div id="CONF_INNER">
            <div id="CONF_MESS"></div>
            <div id="CONF_BTNS"><div class="SML BTN" onclick="confBOXclose();">Close</div></div>                                    
        </div>
    </div>
    
    <nav class="menu slide-menu-left" <? if($_SESSION["logged_in"]!=true || $_SESSION["AC"]["aLOGIN"]==0){ echo"style=\"display: none;\""; }?>>       
        <div class="SML BTN" id="CLSMNU">Close</div> 
        <?
        if($_SESSION["logged_in"]==true && $_SESSION["AC"]["aLOGIN"]==1)
        {
            ?>                           
            <a class="MBTNS" href="/gradenewjob.htm" >Grade a Job</a>
            <a class="MBTNS" href="/gradehistory.htm" >Grade History</a>                
            <a class="MBTNS" onclick="triggerthink(1); <?if($_SESSION["AC"]["aSUPER"]!=1){ $_SESSION["COID"][1] = $_SESSION["CO"]["coID"]; ?>GOTOPAGE(1,'viewcompany.htm','_self');<?}?>" href="<?if($_SESSION["AC"]["aSUPER"]==1){ echo '/companies.htm'; }else{?>javascript:{}<?}?>"><?if($_SESSION["AC"]["aSUPER"]==1){?>Manage Companies<?}else{?>Company Settings<?}?></a>
            <a class="MBTNS" href="/jobtitles.htm">Job Titles</a>         
            <a class="MBTNS" href="/reports.htm">Report</a>
            <a class="MBTNS" href="/support.htm">Support</a>
            <a class="MBTNS" href="/login-3-.htm">Logout</a>
            <?
        }
        ?>
    </nav>        
    
    <nav class="menu slide-menu-top" id="topnav" style="width: 100%;" >
        <div id="INNEROVA">
        <div id="HEADEROVA"><img src="images/close.png" onclick="KILLBOX();"></div>
        <div id="CONTENTOVA"></div>
        </div>        
    </nav>
             
    <h1 class="MB_TOP_BNR"><img src="/images/logo.png" /></h1>
    
    <div id="toplft" class="nav-toggler toggle-slide-left lefticon" style="top: 10px; left: 0; background-image: url(/images/leftbtn.png); <? if($_SESSION["logged_in"]!=true || $_SESSION["AC"]["aLOGIN"]==0){ echo"display: none";}?>"></div>
    <?
    if($prheader)
    {
        ?>
        <div id="prheader"><?=$prheader?></div>
        <?
    }
    ?>
    <div class="textframe">
    <?
}

function closehtml()
{
    global $CN;
    ?>                                                                              
    </div>     
     
    <div class="footerframe">AutoGrade is a system developed by Tremendis Learning. Copyright protected <?=date("Y")?>. All rights reserved. Tremendis Learning (Pty) LTD, 2016/165403/07. Website: www.tremendis.co.za, Contact Number: 011 084 6000.</div>
            
    <script language="javascript" src="scripts/CLASSIE3.js"></script>
    <script language="javascript" src="scripts/NAV3.js"></script>     
    </body>
    </html>
    <?
}
