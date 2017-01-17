function setheight()
{
    var w = window,
    d = document,
    e = d.documentElement,
    g = d.getElementsByTagName('body')[0],
    x = w.innerWidth || e.clientWidth || g.clientWidth,
    y = w.innerHeight|| e.clientHeight|| g.clientHeight;

    var a = Math.floor((y-200)/8);
    var b = (a - 28) / 2;
    var c = a-b;    

    for(var i=0;i<=7;i++)
    {
        document.getElementById("CA_"+i).style.height = c+"px";
        document.getElementById("CA_"+i).style.paddingTop = b+"px";
    }    
}

var start = 1;
function gradecalc(e)
{    
    if(e.target !== e.currentTarget) 
    {
        if(start==1)
        {
            ticker();
            start = 0;    
        }
        
        var T = e.target;
        e.stopPropagation();                
        
        var ID = T.id.split("_"); //TBL CLASS ID  
        
        if(ID[0]=="CA") //CA
        {
            for(var i=0; i<8; i++)
            {
                var x = document.getElementById("CA1_"+i); 
                if(i==ID[1])
                {
                    x.className = "CA1 ACT";
                    document.getElementById("CA_"+i).className = "CA CAX"+i+" CA2"; 
                }
                else
                {
                    x.className = "CA1";
                    document.getElementById("CA_"+i).className = "CA CAX"+i;     
                }                
            }
        }
        else if(ID[0]=="SE") //SE
        {
            for(var i=0; i<20; i++)
            {
                if(document.getElementById("SE_"+ID[1]+"_"+ID[2]+"_"+i))
                {
                    var x = document.getElementById("SE_"+ID[1]+"_"+ID[2]+"_"+i);
                    if(i==ID[3])
                    {
                        x.className = "SE SE2";  
                    }
                    else
                    {
                        x.className = "SE SE1";   
                    }    
                }
                                
            }
            var AR = makearr();   
            progress(AR[0],AR[1]);         
        }               
    }
}

function makearr()
{
    var BACK = new Array();
    var AR = new Array();       
    var qs=0;
    var sum=0;
    for(var a=0; a<10; a++)
    {        
        if(document.getElementById("CA_"+a))
        {                         
            AR[a] = new Array();
            for(var b=0; b<6; b++)
            {                                
                if(document.getElementById("MA_"+a+"_"+b))
                {                    
                    qs++;
                    AR[a][b] = new Array();
                    for(var c=0; c<20; c++)
                    {
                        if(document.getElementById("SE_"+a+"_"+b+"_"+c))
                        {
                            if(document.getElementById("SE_"+a+"_"+b+"_"+c).className=="SE SE2"){ AR[a][b][c] = 1; sum++; }else{ AR[a][b][c] = 0; }                                   
                        }
                    }
                }                
            }    
        }               
    }
    BACK[0] = sum;
    BACK[1] = qs;
    BACK[2] = AR;
    var sc = document.getElementById("score");
    var cl = document.getElementById("close");
    if(sum==qs){ sc.style.display = "block"; cl.style.display = "block"; }else{ sc.style.display = "none"; cl.style.display = "none"; }
    return BACK;
}

function ticker()
{
    var p = document.getElementById("time");
    var s = 0;
    var timer = setInterval(function () 
    {        
        s++;        
        var mins = Math.floor(s/60);
        var secs = s - (mins * 60);
                
        if(secs.toString().length==1){ secs = '0'+secs; }
        if(mins.toString().length==1){ mins = '0'+mins; }
        p.innerHTML = mins+':'+secs;
        
    }, 1000);     
}

function progress(SUM,QS)
{    
    var max = (SUM / QS)*160;
    var pb = document.getElementById("progbar");
    var id = document.getElementById("progid");    
    var s = id.value;
    var prog = setInterval(function ()
    {        
        s++;
                
        var step = parseFloat((s * 0.02)) + parseFloat(id.value);
        if(step>=max)
        {
            clearInterval(prog);
        }
        else
        {
            var val = parseFloat(-160) + parseFloat(step);
            pb.style.backgroundPosition = Math.ceil(val)+"px 0px";
            id.value = step;
            document.getElementById("progval").innerHTML = Math.ceil((step/160)*100)+"%";
        }                                        
    }, 10);   
}

function pause()
{
    var p = document.getElementById("pause");
    var s = document.getElementsByClassName("SQ_PAUSE")[0];
    if(p.className=="topnfo off")
    {
        p.className = "topnfo on";
        s.style.display = "block";
    }
    else
    {
        p.className = "topnfo off";   
        s.style.display = "none";
    }
}

function stop()
{
    triggerthink(1);
    window.open(siteaddress+"/gradehistory.htm","_self");
}

function scorenow()
{
    triggerthink(1);
    var TME = document.getElementById("time");
    var AR = makearr();
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
                window.open(siteaddress+"/viewscore.htm","_self");    
            }
            else if(xmlhttp.responseText==2)
            {  
                ALLERR("Please answer all questions before grading this position."); 
                triggerthink(0);  
            }
            else
            {  
                ALLERR("An error occured and information was not updated. Please try again or contact support.");
                triggerthink(0); 
            }            
        }
    } 
    xmlhttp.open("POST",siteaddress+"/system/G_FILE3/",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("VAL="+AR+"&TME="+TME.innerHTML);
}