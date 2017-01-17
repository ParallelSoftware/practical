function SQ_TCK(e)
{        
    if (e.target !== e.currentTarget) {
        var T = e.target;
        e.stopPropagation();                
        
        var AR = T.id.split("_"); //TBL CLASS ID                       
        
        if(T.id=="START")
        {
            SQNXT(AR);   
        }
        else if(T.id=="DISAGREE")
        {
            triggerthink(1);
            window.open(siteaddress+"/gradehistory.htm","_self");   
        }
        else if(T.id=="GRADE")
        {
            ALLTHINK(1);
            
            if(document.getElementById('A1_NEW'))//new title
            {
                var ID1 = "NEW";    
            }
            else
            {
                var Q1 = document.getElementById('QTY0').value;                                
                for(var i=1; i<=Q1; i++)
                {
                    var a = document.getElementById('A1_H_0_'+(i-1));
                    if(a.className == "H H2")
                    {
                        var ID1 = i;                                          
                    }
                }    
            }
            
            var Q2 = document.getElementById('QTY1').value;
            var ID3 = document.getElementById('REF').value;
            var ID4 = document.getElementById('NOTES').value;
            
            var ID2 = '';
            for(var i=1; i<=Q2; i++)
            {
                var a = document.getElementById('A2_H_1_'+(i-1));
                if(a.className == "H H2")
                {
                    ID2 = ID2+i+','; 
                }
            }
            
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
                        ALLERR("Please choose at least two (2) committee members before continuing");       
                        ALLTHINK(0);
                    }  
                    else if(xmlhttp.responseText==2)
                    {
                        ALLERR("Please choose a job to be graded before continuing");
                        ALLTHINK(0);
                    }
                    else if(xmlhttp.responseText==3)
                    {
                        window.open(siteaddress+"/DO-NOT-REFRESH-OR-CLOSE/","_self");
                    }
                    else
                    {
                        ALLERR("An error occured. Please try again or contact support.");
                        ALLTHINK(0);    
                    }                                    
                }
            } 
            xmlhttp.open("POST",siteaddress+"/system/G_FILE2/",true);
            xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xmlhttp.send("ID1="+ID1+"&ID2="+ID2+"&ID3="+ID3+"&ID4="+ID4);      
        }
        else if(AR[1]=="G") //alphabet
        {                        
            var QTY = document.getElementById('QTY'+AR[2]).value; 
            
            for(var i=1;i<=26;i++)
            {
                if(document.getElementById(AR[0]+'_'+AR[1]+'_'+AR[2]+'_'+i))
                {
                    var x = document.getElementById(AR[0]+'_'+AR[1]+'_'+AR[2]+'_'+i);
                    x.style.borderColor = "white";
                }                
            }
            T.style.borderColor = "#808080";            
            for(var i=0; i<QTY; i++)
            {
                var A = document.getElementById(AR[0]+'_H_'+AR[2]+'_'+i);
                var L = A.innerHTML;                            
                if(AR[3]==0)
                {
                    A.style.display = "block";    
                }
                else if(L.toUpperCase()[0]==T.innerHTML)
                {
                    A.style.display = "block";    
                }
                else
                {
                    A.style.display = "none";    
                }                
            }                                    
        }
        else if(AR[1]=="H")
        {
            var QTY = document.getElementById('QTY'+AR[2]).value; 
            
            var x = document.getElementById(AR[0]+'_H_'+AR[2]+'_'+AR[3]);
            if(AR[2]==0)
            {
                for(var i=0; i<QTY; i++)
                {                
                    var a = document.getElementById(AR[0]+'_H_'+AR[2]+'_'+i);
                    if(i!=AR[3])
                    {
                        if(a.className != "H H1")
                        {
                            a.className = "H H1";        
                        }                        
                    }                                    
                }    
            }
            
            if(x.className=="H H1")
            {
                x.className = "H H2";
            }
            else
            {
                x.className = "H H1";
            }
            SQ_ALL(AR,0);
        }
        else if(T.id=="ADDNEW")
        {
            GETJOB('NEW');    
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

function SQ_ALL(AR,ACT)
{
    var QTY = document.getElementById('QTY'+AR[2]).value;
    var A = new Array();
    var all = new Array();    
    var ALP = new Array();
    var sum = 0;
    for(var i=0; i<QTY; i++)
    {
        A[i] = document.getElementById(AR[0]+'_H_'+AR[2]+'_'+i);
        if(A[i].className.indexOf("H2")!=-1)
        {
            var L = A[i].innerHTML;
            all[i] = '1';
            sum++;
            ALP[sum] = L.toUpperCase()[0];
        }
        else
        {
            all[i] = '0';
        }
    }
    if(AR[2]==0)
    {
        var z = 0;
        for(var i=1;i<=26;i++)
        {
            if(document.getElementById(AR[0]+'_G_'+AR[2]+'_'+i))
            {
                z++;
                var x = document.getElementById(AR[0]+'_G_'+AR[2]+'_'+z);
                if(ALP.indexOf(x.innerHTML)!=-1 || !ALP)
                {
                    x.className = "G G3";
                }
                else
                {
                    x.className = "G G1";    
                }    
            }        
        }    
    }    
}

function SQNXT()
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
            document.getElementById("ALLCONTENT").innerHTML = xmlhttp.responseText;  
            ALLTHINK(0)                
        }
    } 
    xmlhttp.open("POST",siteaddress+"/system/G_FILE1/",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send();                          
}

function GETJOB()
{
    triggerthink(1);
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
            triggerthink(0);
            if(xmlhttp.responseText==1)
            {
                ALLERR("You are not permitted to add new jobs.");
            }
            else
            {
                SUPERBOX(xmlhttp.responseText);
            }                       
        }
    } 
    xmlhttp.open("POST",siteaddress+"/system/B_FILE8/",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send();
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
                    document.getElementById("A1_HH_0").innerHTML = "<div class=\"H H2\" id=\"A1_NEW\">"+ID1+"</div>";
                    document.getElementById("A1_A_0").innerHTML = "You've added a new job and this one is automatically selected for grading.";
                    KILLBOX();
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