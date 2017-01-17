function MQ_GO(ID,ACT,WHR)
{
    triggerthink(1);
    
    var form = document.createElement("form");

    form.setAttribute("method", "post");
    form.setAttribute("action", "/"+ACT);
    form.setAttribute("target", WHR);

    var hiddenField = document.createElement("input");

    hiddenField.setAttribute("name", "ID");
    hiddenField.setAttribute("value", ID);
    hiddenField.setAttribute("type", "hidden");

    form.appendChild(hiddenField);

    document.body.appendChild(form);

    form.submit();
    triggerthink(0);   
}

function MQ_MNU(e)
{
    if (e.target !== e.currentTarget) 
    {
        var T = e.target;
        e.stopPropagation();                        
        
        if(document.getElementById("A1"))
        {
            var A1 = document.getElementById("A1");
            var A2 = document.getElementById("A2");
            var A3 = document.getElementById("A3");
            var A3A = document.getElementById("A3A");
            var A3B = document.getElementById("A3B");
            var A3C = document.getElementById("A3C");
            var A4 = document.getElementById("A4");
            var A5 = document.getElementById("A5");
            var A6 = document.getElementById("A6");
            var A7 = document.getElementById("A7");
            var A7A = document.getElementById("A7A");
            var A7B = document.getElementById("A7B");
            var A7C = document.getElementById("A7C");
            var A8 = document.getElementById("A8");
                
            if(T.id=="A1")
            {
                T.className = "ACT";
                A2.style.display = "none";
                A3.style.display = "inline-block";
                A4.style.display = "inline-block";
                A5.style.display = "inline-block";
                A6.style.display = "inline-block";
                A8.style.display = "inline-block";
            }  
            if(A1.className == "ACT")                    
            {
                if(T.id=="A4" && T.className!="ACT")
                {
                    T.className="ACT";
                    A5.className="SPN";
                }
                if(T.id=="A5" && T.className!="ACT")
                {
                    T.className="ACT";
                    A4.className="SPN";
                }  
                var val = parseFloat(A3A.innerHTML);
                if(T.id=="A3B" && val<=14)
                {
                    A3A.innerHTML = val+1;    
                }
                if(T.id=="A3C" && val>=3)
                {
                    A3A.innerHTML = val-1;    
                }                                          
            }
            
            if(T.id=="A2")
            {
                T.className = "ACT";
                A1.style.display = "none";
                A7.style.display = "inline-block";
                A6.style.display = "inline-block";
                A8.style.display = "inline-block";
            }
            if(A2.className == "ACT")                    
            { 
                var val = parseFloat(A7A.innerHTML);
                if(T.id=="A7B" && val<=145)
                {
                    A7A.innerHTML = val+5;    
                }
                if(T.id=="A7C" && val>=10)
                {
                    A7A.innerHTML = val-5;    
                }                                          
            }
            if(T.id=="A8")
            {
                if(T.className=="SPN")
                {
                    T.className = "ACT";
                }
                else
                {
                    T.className = "SPN";
                }
            }
            if(T.id=="A6")
            {
                var ARR = new Array();
                if(A1.className=="ACT")
                {
                    ARR[0] = 1;
                    ARR[1] = A3A.innerHTML;
                    if(A4.className=="ACT"){ ARR[3] = "S"; }else{ ARR[3] = "M"; }
                }                
                else if(A2.className=="ACT")
                {
                    ARR[0] = 2;
                    ARR[1] = A7A.innerHTML;                    
                }
                if(A8.className=="ACT"){ ARR[2] = 1; }else{ ARR[2] = 0; }
                
                MQ_GET(ARR);                                
            }
        }
    }    
}

function MQ_GET(ARR)
{
    MQTHINK(1);
    
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
            document.getElementById("MQ_FRAME").innerHTML = xmlhttp.responseText;  
            if(ARR[0]==1)
            {
                document.querySelector(".MQFADBTN").addEventListener('mouseover', mouseDown, false);     
            }                          
            MQTHINK(0);               
        }
    } 
    xmlhttp.open("POST",siteaddress+"/system/index.php?file=MQADDEDIT",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("ID="+ARR.join(","));
}

function MQTHINK(ID)
{
    var x = document.getElementsByClassName("MQTHINK")[0];
    if(ID==1)
    {
        x.style.display = "block";
        MQFADER();
    }    
    else
    {
        x.style.display = "none";   
    }
}

function MQFADER()
{
    var x = document.getElementsByClassName("MQTHINK")[0];
    
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

function MQERR(W)
{
    var x = document.getElementsByClassName("MQERR");
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

function mouseUp()
{
    window.removeEventListener('mousemove', divMove, true);
}

function mouseDown(e){
    window.addEventListener('mousemove', divMove, true);
}

function divMove(e)
{
    var img = e.target;
    
    var div = document.getElementsByClassName("MQFADER")[0];
    var rect = div.getBoundingClientRect();
    
    var mouseX = e.clientX - rect.left - 15;    
    
    if(mouseX<=-1)
    {
        var val = 0;
    }
    else if(mouseX>=99)
    {
        var val = 100;
    }
    else
    {
        var val = mouseX;
    }
    if(img.className=="MQFADBTN")
    {
        img.style.left = val + 'px';        
    }               
}

function calckeys(e)
{
    if (e.target !== e.currentTarget) 
    {
        var T = e.target;
        e.stopPropagation(); 
        
        var AR = T.id.split("_");
        
        if(AR[0]=="A9")
        {
            var x = document.getElementsByClassName('MQCNT')[0];
            stopcnt();
            MQERR("");
            
            if(T.value.length>0)
            {
                x.style.display = "block";
                x.innerHTML = 200 - T.value.length;
            }
            else
            {
                x.innerHTML = 200;    
            }
            if(T.value.length>=200)
            {
                x.innerHTML = 0;
                MQERR("You have reached the maximum limit of this textbox. Keep it short and simple.");
                T.value = T.value.substr(0, 200);
            }
            startcnt();            
        }
    }
}

var myVar;

function startcnt() {
    var x = document.getElementsByClassName('MQCNT')[0];
    myVar = setTimeout(function(){ x.style.display = "none"; }, 3000);
}

function stopcnt() {
    clearTimeout(myVar);
}