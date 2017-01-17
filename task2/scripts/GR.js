function MAKEMAGIC(e)
{        
    if (e.target !== e.currentTarget) 
    {
        var T = e.target;
        e.stopPropagation();
        
        if(T.id.length==2 && T.id[0]=="S")
        {
            for(var i=1; i<6; i++)
            {
                document.getElementById("S"+i).className = "GRBTN INA";
            }
            T.className = "GRBTN ACT";            
            SEARCHNOW(T.id[1]);   
        }
        else if(T.id=="EMAIL")
        {
            var TXT = "\
            <div style=\"max-width: 500px;\">\
            <div class=\"SB_HDR\">Email this Report</div>\
            <div id=\"SB_ERR\"></div>\
            <div id=\"SB_LINE\"></div>\
            <div class=\"SB_TXT\">Please provide an email address where this report will be sent to. Note that all reports have a 30 day viewing period.</div>\
            <div class=\"SB_BLOCK\" style=\"text-align:center;\">First Name:<br><input type=\"text\" id=\"E2\" size=\"25\" maxlength=\"70\"><br>Email Address:<br><input type=\"text\" id=\"E1\" size=\"25\" maxlength=\"70\"></div></div><div class=\"BTNBLOCK\"><div class=\"SML BTN\" id=\"EMAILNOW\">Send</div><div class=\"SML BTN\" id=\"CANEMAIL\">Cancel</div></div>\
            </div>";  
            SUPERBOX(TXT);
        }
        else if(T.id=="CANEMAIL")
        {
            KILLBOX();
        }
        else if(T.id=="EMAILNOW")
        {
            SENDMAIL(document.getElementById("E1").value,document.getElementById("E2").value);
        }
    }
}

function SEARCHNOW(ID)
{   
    ALLERR('');   
    ALLTHINK(1);
 
    if(navigator.onLine==false)
    {
        nointernet();        
    }
    else if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200 && mmaccess(xmlhttp.responseText)!=true)
        {                                                                                                                       
            document.getElementById("CNTHERE").innerHTML = xmlhttp.responseText;                                        
            ALLTHINK(0);                                  
        }
    } 
    xmlhttp.open("POST",siteaddress+"/system/B_FILE12/",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("ID="+ID);
}

function SENDMAIL(E1,E2)
{   
    if(E1=='' || E2=='')
    {
        triggererror("Please complete all fields before submitting this form.");    
    }
    else
    {
        triggerline(1);
 
        if(navigator.onLine==false)
        {
            nointernet();        
        }
        else if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200 && mmaccess(xmlhttp.responseText)!=true)
            {                                                                                                                       
                if(xmlhttp.responseText==1)
                {
                    triggererror("Please provide a first name for this person.");
                } 
                else if(xmlhttp.responseText==2)
                {
                    triggererror("Please provide a valid email address before submitting.");
                } 
                else if(xmlhttp.responseText==3)
                {
                    KILLBOX();
                    confBOX("A link to view this report was successfully emailed.");
                }
                else
                {
                    triggererror( xmlhttp.responseText+ "An error occurred. Please try again or contact support on +27110220600.");
                }
                triggerline(0);
            }
        } 
        xmlhttp.open("POST",siteaddress+"/system/B_FILE13/",true);
        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xmlhttp.send("E1="+E1+"&E2="+E2);
    }
}
