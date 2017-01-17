<?
function sendmail($comUID,$comWhereto,$comSubject,$comMessage,$comCode)
{  
    global $CN;
    
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: AutoGrade Job Grading <noreply@autograde.co.za>' . "\r\n";
                    
    $theMessage = "<html xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:o=\"urn:schemas-microsoft-com:office:office\" xmlns:w=\"urn:schemas-microsoft-com:office:word\" xmlns:m=\"http://schemas.microsoft.com/office/2004/12/omml\" xmlns=\"http://www.w3.org/TR/REC-html40\"><head><meta name=Generator content=\"Microsoft Word 12 (filtered medium)\">
    <style>
    <!--
    @font-face
    {
        font-family:\"Cambria Math\";
        panose-1:2 4 5 3 5 4 6 3 2 4;
    }
    @font-face
    {
        font-family:Verdana;
        panose-1:2 15 5 2 2 2 4 3 2 4;
    }
    @font-face
    {
        font-family:Verdana;
        panose-1:2 11 6 4 3 5 4 4 2 4;
    }
    
    p.MsoNormal, li.MsoNormal, div.MsoNormal
    {
        margin:0cm;
        margin-bottom:.0001pt;
        font-size:11.0pt;
        font-family:\"Verdana\",\"sans-serif\";
    }
    a:link, span.MsoHyperlink
    {
        mso-style-priority:99;
        color:blue;
        text-decoration:underline;
    }
    a:visited, span.MsoHyperlinkFollowed
    {
        mso-style-priority:99;
        color:purple;
        text-decoration:underline;  
    }
    span.EmailStyle17
    {
        mso-style-type:personal-compose;
        font-family:\"Verdana\",\"sans-serif\";
        color:windowtext;
    }
    .MsoChpDefault
    {
        mso-style-type:export-only;
    }
    @page WordSection1
    {
        size:612.0pt 792.0pt;
        margin:72.0pt 72.0pt 72.0pt 72.0pt;
    }
    div.WordSection1
    {
        page:WordSection1;
    }
    -->
    </style>
    <!--[if gte mso 9]>
    <xml>
        <o:shapedefaults v:ext=\"edit\" spidmax=\"1026\" />
    </xml>
    <![endif]-->
    <!--[if gte mso 9]>
    <xml>
        <o:shapelayout v:ext=\"edit\">
        <o:idmap v:ext=\"edit\" data=\"1\" /></o:shapelayout>
    </xml>
    <![endif]-->
    </head>
    <body lang=EN-ZA link=blue vlink=purple>

    <div class=WordSection1>

    <p class=MsoNormal><o:p>".$comMessage."</o:p></p>
    <p class=MsoNormal><o:p>&nbsp;</o:p></p>
    <p class=MsoNormal><o:p>Regards,</o:p></p>

    <div>
    <div><p class=MsoNormal>
    <b><span style='font-size:10.5pt;font-family:\"Verdana\",\"sans-serif\";color:#b0292c'>AutoGrade by Tremendis Learning<o:p></o:p></span></b></p></div>
    <p class=MsoNormal><span style='font-size:8.5pt;font-family:\"Verdana\",\"sans-serif\";color:#333333'><o:p>&nbsp;</o:p></span></p>
    <div><p class=MsoNormal><span style='font-size:8.5pt;font-family:\"Verdana\",\"sans-serif\";color:#333333'>Call Us: +27110220600<o:p></o:p></span></p></div>
    <div><p class=MsoNormal><b><span style='font-size:8.5pt;font-family:\"Verdana\",\"sans-serif\";color:#333333'>Website:</span></b><span style='font-size:8.5pt;font-family:\"Verdana\",\"sans-serif\";color:#333333'>autograde.co.za<o:p></o:p></span></p></div><p class=MsoNormal style='margin-bottom:12.0pt'><span style='font-size:8.5pt;font-family:\"Verdana\",\"sans-serif\";color:#333333'><o:p>&nbsp;</o:p></span></p></div><p class=MsoNormal><b><span style='font-size:7.0pt;font-family:\"Verdana\",\"sans-serif\";color:#969696'>Disclaimer:</span></b><span style='font-size:7.0pt;font-family:\"Verdana\",\"sans-serif\";color:#969696'><br>To read Tremendis Learning's disclaimer for this email click on the following address or copy into your internet browser: <a href=\"http://www.tremendis.co.za/3/main/anti-spam-policy.htm\"><span style='color:blue'>/antispam.htm</span></a>. If you are unable to access the disclaimer, send a blank e-mail to disclaimer@tremendis.co.za and we will send you a copy of the disclaimer.</span><o:p></o:p></p></div></body></html>"; 

    $ml = mail($comWhereto,$comSubject,$theMessage,$headers);
    if($ml==1)
    {
        $x = mysqli_query($CN["dbl"],"INSERT INTO communicate (comID,comUID,comWhereto,comWhen,comSubject,comMessage,comCode) VALUES (NULL,'".$comUID."','".$comWhereto."','".date("U")."','".addslashes($comSubject)."','".addslashes($comMessage)."','".$comCode."')"); 
        if($x==1)
        {
            return 1;
        }
    } 
}
function sendsms($comUID,$comWhereto,$comSubject,$comMessage,$comCode)
{
    global $CN;
    $x = mysqli_query($CN["dbl"],"SELECT cntyTelcode FROM contact,company,country WHERE ctID='".$comUID."' AND ctCOID=coID AND coCNTYID=cntyID "); 
    if(mysqli_num_rows($x)==1)
    { 
    	list($CDE) = mysqli_fetch_row($x);
    	$sms = str_replace(" ", "%20", $comMessage);
    	if($comWhereto[0]=='0' || $comWhereto[0]=='+')
    	{
    		$TEL = substr($comWhereto,1);	
    	}
    	else
    	{
    		$TEL = $comWhereto;
    	}
    	$tel = $CDE.$TEL;     
                     
    	$url = 'http://www.winsms.co.za/api/batchmessage.asp?user=monrebotes&Password=Porsche911X&message='.$sms.'&Numbers='.$tel;  
    	$fp = fopen($url, 'r');
    	while(!feof($fp))
    	{
        	$comCode = fgets($fp, 4000);
        	$x = mysqli_query($CN["dbl"],"INSERT INTO communicate (comID,comUID,comWhereto,comWhen,comSubject,comMessage,comCode) VALUES (NULL,'".$comUID."','".$comWhereto."','".date("U")."','".addslashes($comSubject)."','".addslashes($comMessage)."','".$comCode."')");
    	}
    	fclose($fp);
    	if($x==1)
    	{
        	return 1;
    	}
    }
}
?>