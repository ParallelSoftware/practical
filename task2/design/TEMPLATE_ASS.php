<?
function openheader($title,$description)
{
    global $CN; 
    
    if($_COOKIE["MMFIRSTIME"]!=1)
    {
        setcookie("MMFIRSTIME", 1, time()+8035200);
        $_SESSION["FT"] = 1;     
    }  
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
    <?
}

function closeheader()
{
    global $CN;
    $ip = get_client_ip();

    ?>
    </head>
    <body> 
    
    <div class="SQ_PAUSE"></div>   
   
    <div id="BLACKOUT" style="display: none;"></div>  
    <div id="TOTALTHINK" style="display: none;"></div>
    
    <div id="CONF_OUTER" style="display: none;">
        <div id="CONF_INNER">
            <div id="CONF_MESS"></div>
            <div id="CONF_BTNS"><img id="CONF_BTN1" src="/images/buttons/B11.png" onclick="confBOXclose();"></div>                                    
        </div>
    </div>
    <?
}

function closehtml()
{
    global $CN;
    ?>                                                                              
    <script type="text/javascript">
    var siteaddress = '<?=$CN["msAddress"]?>';
    </script>    
    </body>
    </html>
    <?
}
