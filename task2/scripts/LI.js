function checklogin()
{       
    ALLERR('');
    triggerthink(1);
    
    var LO = document.getElementById("CELLOREMAIL");
    var PA = document.getElementById("PASSWORD");
    
    if(LO.value=="")
    {
        ALLERR("Please provide your cellphone number or email address");
        triggerthink(0);
    }
    else if(PA.value=="")
    {
        ALLERR("Please provide your password");  
        triggerthink(0);
    }
    else
    {        
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
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {                  
                if(xmlhttp.responseText==1)
                {
                    ALLERR("Please complete all fields"); 
                    triggerthink(0);
                }
                else if(xmlhttp.responseText==2)
                {
                    ALLERR("The cellphone number or email address is invalid.");
                    triggerthink(0);
                }
                else if(xmlhttp.responseText==3)
                {                    
                    ALLERR("Your login details is incorrect.<br>Try again or call support on +27(0)110220600.");
                    triggerthink(0);
                }
                else if(xmlhttp.responseText==4)
                {
                    changepassword(); 
                    triggerthink(0);
                }
                else if(xmlhttp.responseText==5)
                {
                    window.open(siteaddress+"/gradehistory.htm","_self"); 
                }
                else if(xmlhttp.responseText==6)
                {                    
                    ALLERR("You no longer have access to this portal. Kindly contact us on +27(0)110220600 to reinstate access.");
                    triggerthink(0);
                }
                else
                {
                    ALLERR("An error occured and login failed. Please try again or contact us on +27(0)110220600. ");
                    triggerthink(0);
                }  
            }
        } 
        xmlhttp.open("POST",siteaddress+"/system/L_FILE1.htm",true);
        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xmlhttp.send("LOGIN1="+LO.value+"&LOGIN2="+PA.value);                    
    }         
}

function checkdigit(val)
{
    var cell = document.getElementById("cell"); 
    if(isNaN(val))
    {
        cell.value = "";
    }    
}

function changepassword()
{   
    var TXT = "\
    <div style=\"max-width: 500px;\">\
    <div class=\"SB_HDR\">Change Password</div>\
    <div id=\"SB_ERR\"></div>\
    <div id=\"SB_LINE\"></div>\
    <div class=\"SB_TXT\">Your password has not been personalised as yet. Please do this now to secure your profile.</div>\
    <div class=\"SB_BLOCK\" style=\"text-align:center;\">New Password*:<br><input class=\"PW\" type=\"password\" size=\"20\" maxlength=\"40\"><br><br>\
    Repeat Password*:<br><input class=\"PW\" type=\"password\" size=\"20\" maxlength=\"40\"></div>\
    <div class=\"BTNBLOCK\"><div class=\"MED BTN\" onclick=\"changepassnow();\">Accept</div><div class=\"MED BTN\" onclick=\"NOTNOW();\">Not Now</div></div></div>";
    SUPERBOX(TXT);
}

function NOTNOW()
{
    KILLBOX();
    triggerthink(1);
    window.open('gradehistory.htm','_self');
}

function changepassnow()
{        
    var P = document.getElementsByClassName("PW");
    
    if(P[0].value.length=="")
    {
        triggererror("Please type a new password that is at least 6 characters long and with a combination of letters and numbers.");    
    }        
    else if(P[0].value.length < 6)
    {
        triggererror("Your pasword is a bit short. It should be at least 6 characters long with a combination of letters and numbers.");
    }
    else if(P[0].value!=P[1].value)    
    {
        triggererror("The two passwords you type need to be the same. Please retype the password in the second field.");            
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
                triggerline(0);
                if(xmlhttp.responseText==1)
                {
                    triggererror("Please type a new password that is at least 6 characters long and with a combination of letters and numbers.");        
                }
                else if(xmlhttp.responseText==2)
                {
                    triggererror("Your pasword is a bit short. It should be at least 6 characters long with a combination of letters and numbers.");         
                }
                else if(xmlhttp.responseText==3)
                {
                    triggererror("Your pasword is way too long. It should be maximum 30 characters in combination of letters and numbers.");         
                }
                else if(xmlhttp.responseText==4)
                {
                    triggererror("Please note your password should contain at least one number.");
                }
                else if(xmlhttp.responseText==5)
                {
                    triggererror("Please note your password should contain at least one letter."); 
                }
                else if(xmlhttp.responseText==6)
                {
                    triggererror("Please retype your password again. It seems that they are not similar."); 
                }
                else if(xmlhttp.responseText==7)
                {
                    KILLBOX();
                    triggerthink(1);
                    window.open('gradehistory.htm','_self');
                }
                else
                {
                    triggererror("An error occurred and your password was not updated. Please try again or contact support on +27(0)110220600");
                }                        
            }
        } 
        xmlhttp.open("POST",siteaddress+"/system/L_FILE2.htm",true);
        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xmlhttp.send("PASS1="+P[0].value+"&PASS2="+P[1].value);    
    }    
}

function passreminder()
{
    var TXT = "\
    <div style=\"max-width: 500px;\">\
    <div class=\"SB_HDR\">Change Password</div>\
    <div id=\"SB_ERR\"></div>\
    <div id=\"SB_LINE\"></div>\
    <div class=\"SB_TXT\">Please provide your email address or mobile number below and we will send you a new temporary password.</div>\
    <div class=\"SB_BLOCK\" style=\"text-align:center;\">Cellphone OR Email:<br><input class=\"inputboxes\" type=\"text\" id=\"PASSOREMAIL\" size=\"25\" maxlength=\"50\"></div>\
    </div>\
    <div class=\"BTNBLOCK\"><div class=\"MED BTN\" onclick=\"sendpass();\">Reset Now</div><div class=\"MED BTN\" onclick=\"KILLBOX();\">Cancel</div></div>\
    </div>";  
    SUPERBOX(TXT);  
}

function sendpass()
{
    var PASSOREMAIL = document.getElementById("PASSOREMAIL"); 
         
    if(PASSOREMAIL.value=='')
    {
        triggererror("Please provide either your cellphone number or email address before submitting.");    
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
                    triggererror("Please provide either your cellphone number or email address before submitting.");    
                }
                else if(xmlhttp.responseText==2)
                {
                    triggererror("Please provide a valid cellphone number or email address.");
                }
                else if(xmlhttp.responseText==3)
                {
                    triggererror("The information you have provided does not exist on our database. Try our support line on +27(0)110220600.");
                }
                else if(xmlhttp.responseText==4)
                {
                    triggererror("Database error. Please try again or contact support on 0110220600.");
                }
                else if(xmlhttp.responseText==5)
                {
                    KILLBOX();
                    confBOX("We've emailed you a new password. Please check your <b>spam folder</b> should you not receive the email.  Please personalise the password when logging in.");                    
                }
                else if(xmlhttp.responseText==6)
                {
                    KILLBOX();
                    confBOX("We've sent you a temporary password to your cellphone. Please personalise the password when logging in.");                    
                }
                else
                {
                    triggererror("An error occured. Please try again or contact support on 0110220600.");
                }
                triggerline(0);
            }
        } 
        xmlhttp.open("POST",siteaddress+"/system/L_FILE5.htm",true);
        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xmlhttp.send("VAL="+PASSOREMAIL.value);      
    }            
}

function gen_pn()
{
    var nme = document.getElementById("name");
    var sur = document.getElementById("surname");
    var pf = document.getElementById("profilename");        
    pf.value = nme.value.toLowerCase()+sur.value.toLowerCase();    
}
