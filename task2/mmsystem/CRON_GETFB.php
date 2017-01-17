#!/usr/local/bin/php -q
<?
include("db.php");
$link = db_connect($DB_HOST,$DB_USER,$DB_PASS,$DB_NAME);

$x = mysqli_query($link,"SELECT * FROM company WHERE cnyActive=1 ORDER BY cnyID LIMIT 1");
$CN = mysqli_fetch_array($x);

$CN["dbl"] = $link;



include("communicate.php");

if(date("N")==6 || date("N")==5)
{
    $say = "weekend";
}
elseif(date("G") > 5 && date("G") <= 12)
{
    $say = "day";
}
elseif(date("G") > 12 && date("G") <= 15)
{
    $say = "afternoon";
}
elseif(date("G") > 15 && date("G") <= 23)
{
    $say = "evening";
}

$x = mysqli_query($CN["dbl"],"SELECT boForWho,boID,cProduct FROM bookings,categories WHERE boCancelled=0 AND boDate >= '".(date("U")-7200)."' AND boDate < '".(date("U")-3600)."' AND boCID=cID AND boFB!=1 AND cProduct!=1 ");
while(list($boForWho,$boID,$cProduct) = mysqli_fetch_array($x))
{      
    $THELIST[$boForWho] = $boID;
}  
if(is_array($THELIST))
{
    foreach($THELIST AS $UID => $boID)
    {
        $x = mysqli_query($CN["dbl"],"SELECT boID,boOID FROM bookings WHERE boCancelled=0 AND boTemp=0 AND boForWho='".$UID."' ");  
        while(list($BOID,$boOID) = mysqli_fetch_array($x))
        {      
            $VISITS[$boOID] = $BOID;
        }
        
        $uz = mysqli_query($CN["dbl"],"SELECT uName,uCell FROM users WHERE uID='".$UID."'");
        list($uName,$uCell) = mysqli_fetch_row($uz);
        
        $pnts = mysqli_query($CN["dbl"],"SELECT pntVal FROM points WHERE pntUID='".$UID."' ORDER BY pntID DESC LIMIT 1");
        if(mysqli_num_rows($pnts)==1)
        {
            list($pntVal) = mysqli_fetch_row($pnts);
            if($pntVal > 4)
            {
                if(count($VISITS)==1)
                {
                    $PNT = " GroomPoints earned: ".$pntVal." :)";    
                }
                else
                {
                    $PNT = " Btw, you have ".$pntVal." GroomPoints :)";    
                }                    
            }
        }        
        
        if(count($VISITS)==1)
        {
            $sms = strtoupper($CN["msSiteName"]).": Dear ".$uName.", thank you for visiting. We'd love to see you again. Please reply and rate our service using scale 1-10.".$PNT;    
        }
        if(count($VISITS)==2)
        {
            $sms = strtoupper($CN["msSiteName"]).": Dear ".$uName.", thanks for visiting again. How was the experience? Reply using scale 1-10. Have a great ".$say.".".$PNT;    
        }
        if(count($VISITS)==3)
        {
            $sms = strtoupper($CN["msSiteName"]).": Hi ".$uName.", good to see you again. Kindly rate your experience using scale 1-10. Have a great ".$say.".".$PNT;  
        }
        if(count($VISITS)==4)
        {
            $sms = strtoupper($CN["msSiteName"]).": Hi ".$uName.", thanks again for coming by. How was the experience? Scale 1-10. Have a brilliant ".$say.".".$PNT; 
        }
        if(count($VISITS)==5)
        {
            $sms = strtoupper($CN["msSiteName"]).": Hi ".$uName.", You are a local now it seems! Thanks for the support, how was it? Scale 1-10. Have a super ".$say.".".$PNT; 
        }
        if(count($VISITS)>5)
        {
            $sms = strtoupper($CN["msSiteName"]).": Hi ".$uName.", good to see you again. Kindly rate your experience. Scale 1-10. Have a great ".$say.".".$PNT; 
        }
        if($uCell)
        {
            $SENT = sendsms($UID,$uCell,"",$sms,"THANK YOU SMS");  
            
            if($SENT==1)
            {
                $z = mysqli_query($CN["dbl"],"UPDATE bookings SET boFB=1 WHERE boID='".$boID."'");
            }      
        }      
    }
}      

$url = "https://www.winsms.co.za/api/HTTPGetReplies.ASP?User=".$CN["winsmsuser"]."&Password=".$CN["winsmspass"];
$fp = fopen($url, 'r');

while(!feof($fp))
{
    $DATA[] = fgets($fp, 4000);    
}
fclose($fp);

if(is_array($DATA))
{
    foreach($DATA AS $NFO)
    {
        $ALLDATA = explode("CLI=",$NFO);
        $i=0;
        foreach($ALLDATA AS $ID => $DTA)
        {
            if(strlen($DTA)>10)
            {
                $i++;
                $TEMP = explode(";DateReceived=",$DTA);
        
                if(strlen($TEMP[0])==11)    //this is the cell nr
                {                
                    $x = mysqli_query($CN["dbl"],"SELECT uID FROM users WHERE uCell='0".substr($TEMP[0],2)."' ORDER BY uID DESC LIMIT 1");
                    if(mysqli_num_rows($x)==1)  // checks if the nr exists on the db
                    {
                        list($uID) = mysqli_fetch_row($x);
                        $stf = mysqli_query($CN["dbl"],"SELECT stfID FROM staff WHERE stfUID='".$uID."' AND stfActive=1 ");
                        if(mysqli_num_rows($stf)>0)
                        {
                            $no = 1; // if any staff member tries to rate
                        }                                                                                      
                    }
                    else
                    {
                        $no = 1;
                    }
                    if($no!=1)
                    {
                        $D = str_split(substr($TEMP[1],0,12));
                        $RST = substr($TEMP[1],21); //this is the sms and the last stuff
                        $LAST = explode(";SentMessageID=",$RST); //0=message and 1 = message ID
                        
                        $DTL[$uID][$i]["DATE"] = date("d F Y @ H:i",mktime( $D[8].$D[9], $D[10].$D[11] , 0 , $D[4].$D[5] , $D[6].$D[7] , $D[0].$D[1].$D[2].$D[3] ));
                        $DTL[$uID][$i]["MESSAGE"] = $LAST[0];
                        $DTL[$uID][$i]["ID"] = substr($LAST[1],0,-1);
                    }                                   
                }    
            }
            unset($no);    
        }    
    }  
    
    if(is_array($DTL))
    {
        foreach($DTL AS $uID => $REST)
        {      
            foreach($REST AS $X => $IDS)
            {
                $STRING = str_split($IDS["MESSAGE"]);        
                foreach($STRING AS $VAL)
                {
                    if(ctype_digit($VAL))
                    {
                        $RATE[] = $VAL;
                    }
                }                            
                
                $z = mysqli_query($CN["dbl"],"SELECT boID,boPOID,boUIDC,boDateAdded,boDate,boOID,boGOTFB FROM bookings WHERE boCancelled=0 AND boForWho='".$uID."' ORDER BY boID DESC LIMIT 1 ");
                if(mysqli_num_rows($z)==1)
                {
                    list($boID,$boPOID,$boUIDC,$boDateAdded,$boDate,$boOID,$boGOTFB) = mysqli_fetch_array($z); 
                    
                    if($boGOTFB!=1)
                    {                                            
                        $o = mysqli_query($CN["dbl"],"SELECT oNr FROM orders WHERE oCancelled=0 AND oID='".$boOID."' "); //user
                        list($oNr) = mysqli_fetch_row($o);
                        
                        $uz = mysqli_query($CN["dbl"],"SELECT CONCAT(uName,' ',uSurn),uCell,uEmai FROM users WHERE uID='".$uID."' ORDER BY uID DESC LIMIT 1"); //user
                        list($CUST,$uCell,$uEmai) = mysqli_fetch_row($uz);       
                        
                        $po = mysqli_query($CN["dbl"],"SELECT poUnit,poUnitID,poDesc,pName FROM productoptions,products WHERE poID='".$boPOID."' AND poPID=pID ");
                        list($poUnit,$poUnitID,$poDesc,$pName) = mysqli_fetch_row($po);
                        if($poDesc){$poDesc = " (".$poDesc.")"; }
                                
                        $u = mysqli_query($CN["dbl"],"SELECT unShor FROM units WHERE unID='".$poUnitID."' ");
                        list($unShor) = mysqli_fetch_row($u);
                                
                        $co = mysqli_query($CN["dbl"],"SELECT uName FROM users WHERE uID='".$boUIDC."' "); //consultant
                        list($CONSULTANT) = mysqli_fetch_row($co);
                        
                        
                        if($boUIDC && is_array($RATE))
                        {
                            $RATING = @intval(implode("",$RATE));
                            if($RATING > 10)
                            {
                                $RATING = 10;
                            }
                            $y = mysqli_query($CN["dbl"],"INSERT INTO feedback (fbID,fbUID,fbUIDC,fbPOID,fbDate,fbRating,fbMessage) VALUES (NULL,'".$uID."','".$boUIDC."','".$boPOID."','".date("U")."','".$RATING."','".$IDS["MESSAGE"]."') ");
                            $z = mysqli_query($CN["dbl"],"UPDATE bookings SET boGOTFB=1 WHERE boID='".$boID."'");
                        } 
                        else
                        {
                            $eml = "Dear ".$CN["msSiteName"]." Administrator,<br><br>Someone replied on an SMS and did not score but send additional text. Details below:<br><br>
                            <b>CUSTOMER NAME:</b> ".$CUST." (".$uCell.")<br>
                            <b>SERVICE:</b> ".$poUnit." ".$unShor." ".$pName.$poDesc."<br>
                            <b>ORDER DATE:</b> ".date("d F Y @ h:i",$boDateAdded)."<br>
                            <b>SERVICE DATE:</b> ".date("d F Y @ h:i",$boDate)."<br>
                            <b>SMS DATE:</b> ".$IDS["DATE"]."<br>
                            <b>ORDER NUMBER:</b> ".$oNr."<br>
                            <b>CONSULTANT:</b> ".$CONSULTANT."<br>                        
                            <b>SMS ID:</b> ".$IDS["ID"]."<br>
                            <b>SMS:</b> ".htmlentities($IDS["MESSAGE"]);
                            
                            $SENT = sendmail(0,$CN["adminemail"],$CN["msSiteName"]." SMS Reply",$eml,$boID); 
                        }               
                        if($RATING <= 7 && $RATING >= 0 && is_array($RATE))
                        {                                
                            $eml = "Dear ".$CN["msSiteName"]." Administrator,<br><br>Someone scored less than 8/10 for the service they've received. Details below:<br><br>
                            <b>CUSTOMER NAME:</b> ".$CUST." (".$uCell.")<br>
                            <b>SERVICE:</b> ".$poUnit." ".$unShor." ".$pName.$poDesc."<br>
                            <b>ORDER DATE:</b> ".date("d F Y @ h:i",$boDateAdded)."<br>
                            <b>SERVICE DATE:</b> ".date("d F Y @ h:i",$boDate)."<br>
                            <b>SMS DATE:</b> ".$IDS["DATE"]."<br>
                            <b>ORDER NUMBER:</b> ".$oNr."<br>
                            <b>CONSULTANT:</b> ".$CONSULTANT."<br>                        
                            <b>SMS ID:</b> ".$IDS["ID"]."<br>
                            <b>RATING:</b> ".$RATING."/10<br>
                            <b>EXACT SMS:</b> ".htmlentities($IDS["MESSAGE"])."<br><br>
                            Please contact this client immediately to potentially rectify the issue. It might be something small or big. Please do not assume the customer is unhappy. Maybe there are a few small things ".$CN["msSiteName"]." can do to improve.";   
                            
                            $SENT = sendmail(0,$CN["adminemail"],$CN["msSiteName"]." < 8 Rating Received",$eml,"REMINDER");     
                        } 
                    }
                    unset($RATE);                
                }                                            
            }                      
        }    
    }   
}



