#!/usr/local/bin/php -q
<?
include("db.php");
$link = db_connect($DB_HOST,$DB_USER,$DB_PASS,$DB_NAME);

$x = mysqli_query($link,"SELECT * FROM company WHERE cnyActive=1 ORDER BY cnyID LIMIT 1");
$CN = mysqli_fetch_array($x);

$CN["dbl"] = $link;



include("communicate.php");

$Y = date('Y');
$M = date('n');
$D = date('d');

$x = mysqli_query($CN["dbl"],"SELECT boID,boUID,boForWho,boPOID,boUIDC,boDate,boTemp,cProduct FROM bookings,categories WHERE boCancelled=0 AND boCID=cID AND cProduct=0 AND boDate>='".date("U", mktime(6, 0, 0, $M, $D, $Y))."' AND boDate<'".date("U", mktime(23, 59, 59, $M, $D, $Y))."' ORDER BY boDate ASC ");
if(mysqli_num_rows($x)!=0)
{        
    while(list($boID,$boUID,$boForWho,$boPOID,$boUIDC,$boDate,$boTemp,$cProduct) = mysqli_fetch_array($x))
    {        
        $p = mysqli_query($CN["dbl"],"SELECT poUnit,poUnitID,poDesc,pName FROM productoptions,products WHERE poID='".$boPOID."' AND poPID=pID ");
        list($poUnit,$poUnitID,$poDesc,$pName) = mysqli_fetch_row($p);
        
        if($poDesc){ $poDesc=" (".$poDesc.")"; }
        if($boTemp==0){ $pd = "Paid"; }else{ $pd = "<font color=\"#FF0000\">Unpaid</font>"; }
        
        $u = mysqli_query($CN["dbl"],"SELECT unShor FROM units WHERE unID='".$poUnitID."' ");
        list($unShor) = mysqli_fetch_row($u);
        
        $fw = mysqli_query($CN["dbl"],"SELECT CONCAT(uName,' ',uSurn) FROM users WHERE uID='".$boForWho."' ");
        list($FORWHO) = mysqli_fetch_row($fw);
        
        $BOOKINGS[$boUIDC][] = "<tr><td width=50>".date("H:i",$boDate)."</td><td width=80>".$poUnit." ".$unShor."</td><td>".$pName.$poDesc."</td><td>".$FORWHO."</td><td>".$pd."</td></tr>";
    }
}

$b = mysqli_query($CN["dbl"],"SELECT bID,bEmail,bContact FROM branches WHERE bID=1 ");
list($bID,$bEmail,$bContact) = mysqli_fetch_row($b);

$hdr = $CN["msSiteName"]." appointments for today";
if(is_array($BOOKINGS))
{
	foreach($BOOKINGS AS $uID => $ARR)
	{
		$fw = mysqli_query($CN["dbl"],"SELECT uName,uSurn,uEmai FROM users WHERE uID='".$uID."' ");
        list($uName,$uSurn,$uEmai) = mysqli_fetch_row($fw);	
        
        $NAMES[$uID] = $uName." ".$uSurn;
        
        $txt = "Hi ".$uName.",<br><br>Herewith your pre-scheduled appointments for today.<br><br>Date: <b>".date("d F Y")."</b><br><br><table cellpadding=5 cellspacing=0 border=1 width=\"100%\"><tr><td width=50><b>Time:</b></td><td width=80><b>Duration:</b></td><td><b>Description:</b></td><td><b>Client:</b></td><td><b>Payment:</b></td></tr>".implode("",$ARR)."</table><br>Feel free to speak to your manager for queries and changes.<br><br>Have a brilliant day!";
        $eml = sendmail(0,$uEmai,$hdr,$txt,""); 
        $ALLBOOKINGS[$uID] = implode("",$ARR);
	}
}

$txt = "Dear ".$bContact.",<br><br>Herewith the pre-scheduled appointments for Metroman today.<br><br>Date: <b>".date("d F Y")."</b><br><br>";
if(is_array($ALLBOOKINGS))
{
 	$txt .= "<table cellpadding=5 cellspacing=0 border=1 width=\"100%\"><tr><td width=50><b>Time:</b></td><td width=80><b>Duration:</b></td><td><b>Description:</b></td><td><b>Client:</b></td><td><b>Payment:</b></td></tr>".implode("",$ALLBOOKINGS)."</table>";   
}
else
{
    $txt .= "NO CURRENT APPOINTMENTS BOOKED<br>";
}   

$txt .="<br>Feel free to speak to your manager for queries and changes.<br><br>Have a brilliant day!";
$eml = sendmail(0,$bEmail,$hdr,$txt,"");








