function GOTOPAGE(ID,ACT,HOW)
{    
    var form = document.createElement("form");

    form.setAttribute("method", "post");
    form.setAttribute("action", "/"+ACT);
    form.setAttribute("target", HOW);

    var hiddenField = document.createElement("input");

    hiddenField.setAttribute("name", "ID");
    hiddenField.setAttribute("value", ID);
    hiddenField.setAttribute("type", "hidden");

    form.appendChild(hiddenField);

    document.body.appendChild(form);

    form.submit();  
}

function nointernet()
{
    confBOX("ERROR: It seems that the internet connection is currently unavailable. Please reconnect and try again.");
}

function mmaccess(ID)
{    
    if(ID=="NLI")
    {
        document.getElementById("CONF_MESS").innerHTML = "Your session have timed out because of inactivity exceeding 2 hours. You have been logged out. Please login again.";
        document.getElementById("CONF_OUTER").style.display = "block";  
        triggerthink(0);      
        return true;
    }     
}

function triggerline(ID)
{
    if(document.getElementById("SB_LINE"))
    {
        var SB_LINE = document.getElementById("SB_LINE");
        if(ID==1)
        {
            SB_LINE.style.backgroundPosition = "center center";
        }    
        else
        {
            SB_LINE.style.backgroundPosition = "0px 30px";   
        }
    }    
}

function triggererror(ID)
{
    if(document.getElementById("SB_ERR"))
    {
        var SB_ERR = document.getElementById("SB_ERR");
        if(ID!=0)
        {
            SB_ERR.innerHTML = ID;
            SB_ERR.style.display = "block";
        }    
        else
        {
            SB_ERR.innerHTML = "";
            SB_ERR.style.display = "none";    
        }
    } 
    triggerline(0);   
}

function confBOX(message)
{    
    document.getElementById("CONF_MESS").innerHTML = message;
    document.getElementById("CONF_OUTER").style.display = "block"; 
    triggerthink(0); 
}

function confBOXclose()
{
    document.getElementById("CONF_OUTER").style.display = "none";
    document.getElementById("CONF_MESS").innerHTML = "";
}

function SUPERBOX(content)
{               
    if(navigator.onLine==false)
    {
        nointernet();        
    }
    else
    {  
        document.getElementById("CONTENTOVA").innerHTML = content;            
        document.getElementById("HEADEROVA").style.display = "block";        
        toggleTop();        
    }                            
}

function KILLBOX()
{
    classie.remove( body, activeNav );
    activeNav = "";
    document.body.removeChild(mask);
    document.getElementById("CONTENTOVA").innerHTML = "";
    document.getElementById("BLACKOUT").style.display = "none";   
    triggerthink(0); 
}

function triggerthink(id)
{
    if(navigator.onLine==false)
    {
        nointernet();        
    }
    else
    {
        var x = document.getElementById("TOTALTHINK");
        
        if(id==1)
        {
            x.style.display = "block";
        }
        else if(id==0)
        {
            x.style.display = "none";
        }    
    }
}

function ALLERR(W)
{
    var x = document.getElementsByClassName("ALLERR");
    if(W!="")
    {
        x[0].style.display = "block";
        x[0].innerHTML = W;
    }
    else
    {
        x[0].style.display = "none";
        x[0].innerHTML = '';
    }
}

var FDR = 1;

function ALLTHINK(ID)
{
    var x = document.getElementsByClassName("ALLTHINK")[0];
    if(ID==1)
    {
        x.style.display = "block";
        if(FDR==1)
        {
            ALLFADER();
            FDR = 0;    
        }        
    }    
    else
    {
        x.style.display = "none";   
        FDR = 1;
    }
}

function ALLFADER()
{
    var x = document.getElementsByClassName("ALLTHINK")[0];
    
    var op = 1;  // initial opacity
    var z = 1;
    var timer = setInterval(function () 
    {        
        x.style.opacity = op;
        x.style.filter = 'alpha(opacity=' + op * 100 + ")";        
        if(x.style.display == "none")
        {
            clearInterval(timer);  
        }
        else
        {
            if(z==1)
            {
                op -= op * 0.1;
                if (op <= 0.3)
                {
                    z = 2;    
                }   
            }
            
            if(z==2)
            {
                op += op * 0.1;
                if (op >= 0.8)
                {
                    z = 1;
                }           
            }    
        }        
    }, 50);    
}