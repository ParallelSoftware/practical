function MAKEMAGIC(e)
{        
    if (e.target !== e.currentTarget) 
    {
        var T = e.target;
        e.stopPropagation();
        
        var AR = T.id.split("_");
        
        if(T.className=="SPMN SPMNI" || T.className=="SPMN SPMNA")
        {
            T.className = "SPMN SPMNA";
            for(var i=1;i<=4;i++)
            {
                if(T.id!="M"+i)
                {
                    document.getElementById("M"+i).className = "SPMN SPMNI";
                }
            }
            
            if(T.id=="M1")
            {
                GETJOB('NEW');
            }
            else
            {
                SEARCHNOW();   
            }           
        } 
        else if(T.className=="SRT_SPN SRT_ACT" || T.className=="SRT_SPN")
        {
            T.className = "SRT_SPN SRT_ACT";
            for(var i=1;i<=3;i++)
            {
                if(T.id!="S"+i)
                {
                    document.getElementById("S"+i).className = "SRT_SPN";
                }
            }            
            SEARCHNOW();           
        }         
        else if(T.id=="UD")
        {
            if(T.className == "UPDOWN UD_U")
            {
                T.className = "UPDOWN UD_D";    
            }
            else
            {
                T.className = "UPDOWN UD_U";     
            }
            SEARCHNOW();
        }                      
        else if(AR[0]=="T")
        {
            GETJOB(parseInt(AR[1]));
            document.getElementById("M1").className = "SPMN SPMNI";
        }
        else if(AR[0]=="U")
        {
            document.getElementById("BTN_1").style.display = "inline-block";
        }
        else if(T.id=="BTN_1")
        {
            SAVEJOB();
        }
        else if(AR[0]=="TB")
        {
            for(var i=1; i<=2; i++)
            {
                document.getElementById("TB_"+i).className = "IH IH1";
            }
            T.className = "IH IH2";
            document.getElementById("BTN_1").style.display = "inline-block";
        }
    }
}

function GETJOB(ID)
{
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
            if(xmlhttp.responseText==1)
            {
                ALLERR("You cannot access more information about this job.");
            }
            else
            {
                SUPERBOX(xmlhttp.responseText);    
            }            
            ALLTHINK(0);                                  
        }
    } 
    xmlhttp.open("POST",siteaddress+"/system/B_FILE8/",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("ID="+ID);
}

function SEARCHNOW()
{
    ALLERR('');
    var KW = document.getElementById("KW");

    for(var i=2;i<=4;i++)
    {
        var x = document.getElementById("M"+i);
        if(x.className=="SPMN SPMNA")
        {
            var ID1 = i;
        }
    }
    for(var i=1;i<=3;i++)
    {
        var x = document.getElementById("S"+i);
        if(x.className=="SRT_SPN SRT_ACT")
        {
            var ID3 = i;
        }
    }
    
    var x = document.getElementById("UD");
    if(UD.className == "UPDOWN UD_U")
    {
        var ID4 = 2;
    }
    else
    {
        var ID4 = 1;
    }
    
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
            if(xmlhttp.responseText==1)
            {
                ALLERR("No information was found for the criteria specified. Try broaden your search.");
                document.getElementById("CNTHERE").innerHTML = "";
            }
            else
            {
                document.getElementById("CNTHERE").innerHTML = xmlhttp.responseText;
                KW.value = "";    
            }
            
            ALLTHINK(0);                                  
        }
    } 
    xmlhttp.open("POST",siteaddress+"/system/B_FILE2/",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("ID1="+ID1+"&ID2="+KW.value+"&ID3="+ID3+"&ID4="+ID4);
}

function SAVEJOB()
{
    triggerline(0);
    triggererror(0);
    
    for(var i=1; i<=2; i++)
    {
        if(document.getElementById("TB_"+i).className == "IH IH2")
        {
            var ID3 = i;
        }
    }
    var ID1 = document.getElementById("U_1").value;
    var ID2 = document.getElementById("U_2").value;
    
    if(ID1.length<3)
    {
        triggererror("Please ensure the Job Title is at least 3 characters long.");
    }
    else if(!ID3)
    {
        triggererror("Please choose the origin of this Job Title.");    
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
                    triggererror("Please ensure the Job Title is at least 3 characters long.");
                }
                else if(xmlhttp.responseText==2)
                {
                    triggererror("Please choose the origin of this Job Title.");    
                }            
                else if(xmlhttp.responseText==3)
                {
                    SEARCHNOW();
                    KILLBOX();
                    confBOX("<h2>Job Title Information Successfully Added/Updated</h2>");
                }
                else
                {
                    triggererror("An error occured and information was not updated. Please try again or contact support on +27110220600.");    
                }
                triggerline(0);                                 
            }
        } 
        xmlhttp.open("POST",siteaddress+"/system/B_FILE9/",true);
        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xmlhttp.send("ID1="+ID1+"&ID2="+ID2+"&ID3="+ID3);
    }    
}


