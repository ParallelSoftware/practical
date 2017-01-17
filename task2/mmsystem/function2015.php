<?

function get_client_ip() 
{
    $ipaddress = '';
     if (getenv('HTTP_CLIENT_IP'))
         $ipaddress = getenv('HTTP_CLIENT_IP');
     else if(getenv('HTTP_X_FORWARDED_FOR'))
         $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
     else if(getenv('HTTP_X_FORWARDED'))
         $ipaddress = getenv('HTTP_X_FORWARDED');
     else if(getenv('HTTP_FORWARDED_FOR'))
         $ipaddress = getenv('HTTP_FORWARDED_FOR');
     else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
     else if(getenv('REMOTE_ADDR'))
         $ipaddress = getenv('REMOTE_ADDR');
     else
         $ipaddress = 'UNKNOWN';

     return $ipaddress;     
}

function destroy()
{
    unset($_SESSION["CO"]);
    unset($_SESSION["AC"]);
    unset($_SESSION['timeOut']);
    unset($_SESSION['loggedAt']);
    unset($_SESSION["logged_in"]);
    unset($_SESSION["COID"]);
    unset($_SESSION["CNTUP"]);
    unset($_SESSION["THISCO"]);
    unset($_SESSION["GRADINGCO"]);
    unset($_SESSION["TITLE"]);
    unset($_SESSION["TID"]);
    unset($_SESSION["COMMITTEE"]);
    unset($_SESSION["GRADE"]);
    unset($_SESSION["JOID"]);
    unset($_SESSION["THISTID"]);
    unset($_SESSION["RID"]);
    unset($_SESSION["CQID"]);
    unset($_SESSION["REF"]);
    unset($_SESSION["NOTES"]);
    unset($_SESSION["COM_MEMORY"]);
    @session_destroy(); 
    @session_unset();
    
    return true;
}

function checkaccess()
{
    if($_SESSION["logged_in"]===true && $_SESSION["AC"]["aLOGIN"]==1)
    {
        if((time() - $_SESSION['loggedAt']) > $_SESSION['timeOut'])
        {        
            if(destroy()===true)
            {
                return false;     
            }
            else
            {
                return true;
            }              
        }
        else
        {
            return true;
        }
    }
    else
    {
        if(destroy()===true)
        {
            return false;     
        }
        else
        {
            return true;
        }
    }    
}

function recordIP($message)
{  
    global $CN;
    $ipaddress = get_client_ip();
     
    $text = "<html><body>Attention: ".$CN["msSiteName"]." Web Administrator<br><br>
        An error has been reported onthis site. Details below:<br><br>      
        <b>Details: </b>".$message."<br> 
        <b>Client IP: </b>".$ipaddress."<br>
        <b>File Name: </b>".$_SERVER["PHP_SELF"]."<br>
        <b>Request Method: </b>".$_SERVER["REQUEST_METHOD"]."<br>
        <b>Request Time: </b>".$_SERVER["REQUEST_TIME"]."<br>
        <b>Query String: </b>".$_SERVER["QUERY_STRING"]."<br>
        <b>Remote User: </b>".$_SERVER["REMOTE_USER"]."<br>
        <b>USER ID: </b>".$_SESSION["CO"]["ctID"]."<br>
        </body>
        </html>";
    
    $x = mysqli_query($CN["dbl"],"INSERT INTO blockedip (blockID,blockIP,blockDate,blockUID) VALUES (NULL,'".$ipaddress."','".date("Y-m-d H:i:s")."','".$_SESSION["CO"]["ctID"]."') ");

    $headers  = 'MIME-Version: 1.0' . "\r\n";   
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From:Metroman<errors@metroman.co.za>" . "\r\n";

    $sent = mail($CN["adminemail"], $CN["msSiteName"]." WEB ERROR", $text, $headers);                  
}

function updlog($ACTION)
{
    global $CN;
    $LOG = mysqli_query($CN["dbl"],"INSERT INTO log (loID,loUID,loForWho,loDate,loACTID) VALUES (NULL,'".$_SESSION["CO"]["ctID"]."','".$_SESSION["CO"]["ctID"]."','".date("U")."','".$ACTION."')");
}