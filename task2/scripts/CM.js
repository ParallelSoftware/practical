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
                triggerthink(1);
                GOTOPAGE('','viewcompany.htm','_self');
            }
            else
            {
                SEARCHNOW();   
            }           
        } 
        if(T.className=="SRT_SPN SRT_ACT" || T.className=="SRT_SPN")
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
        
        if(T.id=="UD")
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
               
        if(AR[0]=="MQ")
        {
            triggerthink(1);
            GOTOPAGE(AR[1],'viewcompany.htm','_self');
        }
    }
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
                ALLERR("No information was found for the criteria specified. Try broaden your search.")
                document.getElementById("CNTHERE").innerHTML = '';            
            }
            else
            {
                document.getElementById("CNTHERE").innerHTML = xmlhttp.responseText;
                KW.value = "";    
            }            
            ALLTHINK(0);                                  
        }
    } 
    xmlhttp.open("POST",siteaddress+"/system/B_FILE3/",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("ID1="+ID1+"&ID2="+KW.value+"&ID3="+ID3+"&ID4="+ID4);
}


