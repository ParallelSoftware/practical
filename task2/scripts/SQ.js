function SQ_TCK(e)
{        
    if (e.target !== e.currentTarget) {
        var T = e.target;
        e.stopPropagation();                
        
        var AR = T.id.split("_"); //TBL CLASS ID                
        
        if(T.className=="MED BTN")
        {
            SQNXT(AR);   
        }
        else 
        {
            var MM = document.getElementById('MINMAX0').value;
            var QTY = document.getElementById('QTY0').value;
            
            if(AR[1]=="B" || AR[1]=="C" || AR[1]=="D" || AR[1]=="E")
            {
                if(AR[1]=="B")
                {
                    var x = document.getElementById(AR[0]+'_HH_'+AR[2]);
                    if(T.className=="BCDE_I")
                    {
                        T.className = "BCDE_A";
                        x.className = "HH HH1";
                    }
                    else
                    {
                        T.className = "BCDE_I";    
                        x.className = "HH";
                    }                
                }
                else if(AR[1]=="E")
                {
                    var x = document.getElementById(AR[0]+'_HH_'+AR[2]);
                    if(T.className=="BCDE_I")
                    {
                        T.className = "BCDE_A";
                        document.getElementById(AR[0]+'_B_'+AR[2]).className = "BCDE_A";
                        x.className = "HH HH1";
                    }
                    else
                    {
                        T.className = "BCDE_I";
                        x.className = "HH";
                        document.getElementById(AR[0]+'_B_'+AR[2]).className = "BCDE_I";
                    }
                }
                else if(AR[1]=="C" || AR[1]=="D")
                {
                    if(AR[1]=="C")
                    {
                        SQ_ALL(AR,1);                                           
                    }
                    else if(AR[1]=="D")
                    {
                        SQ_ALL(AR,2);
                    }
                    var x = document.getElementById(AR[0]+'_HH_'+AR[2]);
                    x.className = "HH";
                    document.getElementById(AR[0]+'_B_'+AR[2]).className = "BCDE_I";
                }
            }
            else if(AR[1]=="G") //alphabet
            {                        
                var z = -1;
                for(var i=0;i<=27;i++)
                {
                    if(document.getElementById(AR[0]+'_'+AR[1]+'_'+AR[2]+'_'+i))
                    {
                        z++;
                        var x = document.getElementById(AR[0]+'_'+AR[1]+'_'+AR[2]+'_'+z);
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
                        A.style.display = "inline-block";    
                    }
                    else if(L.toUpperCase()[0]==T.innerHTML)
                    {
                        A.style.display = "inline-block";    
                    }
                    else
                    {
                        A.style.display = "none";    
                    }                
                }            
                            
            }
            else if(AR[1]=="H")
            {
                var x = document.getElementById(AR[0]+'_H_'+AR[2]+'_'+AR[3]);
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
        if(ACT==1) //check all
        {
            A[i].className = "H H2";   
        }
        else if(ACT==2) //uncheck all
        {
            A[i].className = "H H1";    
        }
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
    if(sum==QTY)
    {
        document.getElementById(AR[0]+'_C_'+AR[2]).className = "BCDE_A";    
        document.getElementById(AR[0]+'_D_'+AR[2]).className = "BCDE_I";
        document.getElementById(AR[0]+'_E_'+AR[2]).className = "BCDE_I";
    }
    else if(sum==0)
    {
        document.getElementById(AR[0]+'_C_'+AR[2]).className = "BCDE_I";
        document.getElementById(AR[0]+'_D_'+AR[2]).className = "BCDE_A";            
        document.getElementById(AR[0]+'_E_'+AR[2]).className = "BCDE_A"; 
    }
    else
    {
        document.getElementById(AR[0]+'_C_'+AR[2]).className = "BCDE_I";
        document.getElementById(AR[0]+'_D_'+AR[2]).className = "BCDE_I"; 
        document.getElementById(AR[0]+'_E_'+AR[2]).className = "BCDE_I";           
    }
    var z = 0;
    for(var i=1;i<=27;i++)
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

function SQNXT(AR)
{                    
    ALLERR("");
    if(document.getElementById('QTY'+AR[2]))
    {
        var MM = document.getElementById('MINMAX'+AR[2]).value;
        var QTY = document.getElementById('QTY'+AR[2]).value;
        var ARR = new Array();
        var z = 0;
        for(var i=0; i<QTY; i++)
        {
            var A = document.getElementById(AR[0]+'_H_'+AR[2]+'_'+i);                          
            if(A.className=="H H2"){ ARR[i]=1; z++; }else{ ARR[i]=0; }
        }
        var minmax = MM.split(",");
        var SND = "VALS="+ARR.join(".");
        if(z<MM[0] || z>MM[1])
        {
            ALLERR("For this question you are limited to at least "+MM[0]+" and a maximum of "+MM[1]+". Please fix and try again.");    
            var go = 0;
        }        
        else{ var go = 1; }
    }    
    else{ var go = 1; }
    
    if(go==1)
    { 
        ALLTHINK(1);
        if(!SND){ var SND=""; }
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
                document.getElementsByClassName("SQ_WRAPPER")[0].innerHTML = xmlhttp.responseText;  
                ALLTHINK(0);                
            }
        } 
        xmlhttp.open("POST",siteaddress+"/system/index.php?file=SQNXT",true);
        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xmlhttp.send(SND);
    }                           
}