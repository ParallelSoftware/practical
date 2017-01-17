#!/usr/local/bin/php -q
<?
include("db.php");
$link = db_connect($DB_HOST,$DB_USER,$DB_PASS,$DB_NAME);

$x = mysqli_query($link,"SELECT * FROM company WHERE cnyActive=1 ORDER BY cnyID LIMIT 1");
$CN = mysqli_fetch_array($x);

$CN["dbl"] = $link;



include("communicate.php");

$now = date("U");

$x = mysqli_query($CN["dbl"],"SELECT rID,rUID,rHow,rBOID FROM reminders WHERE rWhen >='".($now-600)."' AND rWhen<='".($now+600)."' AND rSent!=1");
while(list($rID,$rUID,$rHow,$rBOID) = mysqli_fetch_array($x))
{
    $uz = mysqli_query($CN["dbl"],"SELECT uName,uCell,uEmai FROM users WHERE uID='".$rUID."'");
    list($uName,$uCell,$uEmai) = mysqli_fetch_row($uz);
    
    $bo = mysqli_query($CN["dbl"],"SELECT boForWho,boPID,boPOID,boUIDC,boDate FROM bookings WHERE boCancelled=0 AND boID='".$rBOID."'");
    list($boForWho,$boPID,$boPOID,$boUIDC,$boDate) = mysqli_fetch_array($bo);       
    
    $po = mysqli_query($CN["dbl"],"SELECT poUnit,poUnitID,poDesc,pName FROM productoptions,products WHERE poID='".$boPOID."' AND poPID=pID ");
    list($poUnit,$poUnitID,$poDesc,$pName) = mysqli_fetch_row($po);
    if($poDesc){$poDesc = " (".$poDesc.")"; }
            
    $u = mysqli_query($CN["dbl"],"SELECT unShor FROM units WHERE unID='".$poUnitID."' ");
    list($unShor) = mysqli_fetch_row($u);
            
    $fw = mysqli_query($CN["dbl"],"SELECT CONCAT(uName,' ',uSurn) FROM users WHERE uID='".$boForWho."' ");
    list($FORWHO) = mysqli_fetch_row($fw);
            
    $co = mysqli_query($CN["dbl"],"SELECT uName FROM users WHERE uID='".$boUIDC."' ");
    list($CONSULTANT) = mysqli_fetch_row($co);
    
    if($boForWho==$rUID)
    {
        $FORWHO = "yourself";         
    }
    $sms = "Dear ".$uName.", reminder for a ".$poUnit." ".$unShor." ".$pName.$poDesc." for ".ucfirst($FORWHO)." at Metroman on ".date("d F",$boDate)." at ".date("H:i",$boDate)." with ".$CONSULTANT.". See you there!";
    $eml = "Dear ".$uName.",<br><br>You have asked us to send you a reminder via email about an upcoming appointment. Well here it is:<br><br>
    <b>Your Appointment:</b> ".$poUnit." ".$unShor." ".$pName.$poDesc."<br>
    <b>For who:</b> ".ucfirst($FORWHO)."<br>
    <b>Where:</b> Metroman Kyalami<br>
    <b>Date and Time:</b> ".date("d F",$boDate)." at ".date("H:i",$boDate)."<br>
    <b>Consultant:</b> ".$CONSULTANT."<br><br>
    Feel free to contact us on 0110220600 should you have any queries.";   
    
    if($rHow==1)
    {
        $SENT = sendsms(0,$uCell,"",$sms,"REMINDER");  
    }
    elseif($rHow==2)
    {       
        $SENT = sendmail(0,$uEmai,"Metroman Appointment Reminder",$eml,"REMINDER");             
    }
    if($SENT==1)
    {
        $up = mysqli_query($CN["dbl"],"UPDATE reminders SET rSent=1 WHERE rID='".$rID."'");
    }      
}

