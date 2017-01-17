function MAKEMAGIC(e)
{        
    if (e.target !== e.currentTarget) 
    {
        var T = e.target;
        e.stopPropagation();
        
        var AR = T.id.split("_");
        
        if(AR[0]=="U" && AR[1]==1) //company stuff
        {
            BTNS("1",1); //BTN_ already thr                                     
        }            
        else if(T.id=="BTN_1")
        {
            SAVECM();
        }
        else if(AR[0]=="JG")
        {
            GOTOPAGE(AR[1],'viewscore.htm','_blank');
        }
        else if(AR[0]=="THS") //choose the one
        {
            if(document.getElementById("UI_1_"+AR[2]).value!=AR[1])
            {
                document.getElementById("UI_1_"+AR[2]).value = AR[1]; //id - country
                
                if(AR[2]==3)
                {
                    document.getElementById("UI_1_4").value = ''; //province
                    document.getElementById("U_1_4").value = '';
                    document.getElementById("DD_4").style.display = "none";
                    exclaim("U_1_4",1);
                
                    document.getElementById("UI_1_5").value = ''; //city
                    document.getElementById("U_1_5").value = '';
                    document.getElementById("DD_5").style.display = "none";    
                    exclaim("U_1_5",1);
                }
                if(AR[2]==4)
                {                
                    document.getElementById("UI_1_5").value = ''; //city
                    document.getElementById("U_1_5").value = '';
                    document.getElementById("DD_5").style.display = "none";    
                    exclaim("U_1_5",1);
                }                                
            }      
            document.getElementById("U_1_"+AR[2]).value = T.innerHTML; //name
            document.getElementById("DD_"+AR[2]).style.display = "none"; //showall
            exclaim("U_1_"+AR[2],0);
        } 
        else if(AR[0]=="AI") //user open/close
        {
            var Q = document.getElementById("UQTY");
            for(var i=1;i<=Q.value; i++)
            {
                document.getElementById("B_"+i).style.display = "none";
                document.getElementById("A_"+i).style.display = "block";
            }
            document.getElementById("B_"+AR[1]).style.display = "block";
            document.getElementById("A_"+AR[1]).style.display = "none";
        }
        else if(AR[0]=="CO") //typing in contact upd
        {
            BTNS("5_"+AR[1],1); //BTN_ already thr
        }
        else if(T.id=="BTN_5_"+AR[2])
        {
            SAVECO(AR[2]);
        }
        else if(T.id=="BTN_9")
        {
            createE();
            BTNS('9',0);        
            BTNS('10',0);
        }
        else if(T.id=="BTN_9_"+AR[2]) //cancel
        {
            var d = document.getElementById("M3");
            var d_nested = document.getElementById("MI_"+AR[2]);
            var throwawayNode = d.removeChild(d_nested);
            var x = document.getElementById("UQTY");
            x.value = x.value-1;
            BTNS('9',1);        
            BTNS('10',1);
        }
        else if(AR[0]=="TB")
        {
            if(T.className=="H H1")
            {
                T.className = "H H2";
            }
            else
            {
                T.className = "H H1";
            }
            BTNS('5_'+AR[1],1);
        }
        else if(T.id=="BTN_3" || T.id=="BTN_4") //+-
        {
            var x = document.getElementById("CRDTS");
            var z = x.innerHTML.split("/");
            if(T.id=="BTN_3" && parseInt(z[0]) < parseInt(z[1]))
            {
                z[1] = parseInt(z[1])-1; 
            }
            if(T.id=="BTN_4")
            {
                z[1] = parseInt(z[1])+1;
            }
            x.innerHTML = z.join("/");  
            T.onmouseout=function(){UPDCRDTS();};                      
        }
        else if(T.id=="BTN_11")
        {
            CHANGEOVA();
        }
    }
}
function UPDCRDTS()
{
    ALLERR('');
    linethink(2,1);
    
    var x = document.getElementById("CRDTS");
    
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
            if(xmlhttp.responseText=="ERROR")
            {
                ALLERR("An error occured and credits was not updated");
            }
            else
            {
                var chk = xmlhttp.responseText.split("/");
                if(chk.length==2)
                {
                    x.innerHTML = xmlhttp.responseText;
                } 
                else
                {
                    ALLERR("An error occured and credits was not updated");   
                }   
            }
            linethink(2,0);                              
        }
    } 
    xmlhttp.open("POST",siteaddress+"/system/B_FILE7/",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("ID="+x.innerHTML);
}
function BTNS(ID,ACT)
{
    if(document.getElementById("BTN_"+ID))
    {
        var x = document.getElementById("BTN_"+ID);    
        if(ACT==1)
        {
            x.style.display = "inline-block";   
        }
        else
        {
            x.style.display = "none";     
        }    
    }    
}
function exclaim(ID,ACT)
{
    var x = document.getElementById(ID);
    if(ACT==1){ x.className = "EXCLAIM"; }else{ x.className = ""; }
}
function linethink(ID,ACT)
{
    var x = document.getElementById("T_"+ID);
    if(ACT==1){ x.className = "VC_HEADER THK_A"; }else{ x.className = "VC_HEADER THK_I"; }    
}
function UPDNFO(a)
{        
    if (a.target !== a.currentTarget) 
    {
        var T = a.target;
        a.stopPropagation();
        
        var AR = T.id.split("_");
        
        if(AR[0]=="U" && AR[1]==1) //company stuff
        {          
            for(var i=0;i<=5;i++)
            {
                var x = document.getElementById(AR[0]+'_'+AR[1]+'_'+i);
                if(x.value.length <= 3)
                {
                    exclaim(AR[0]+'_'+AR[1]+'_'+i,1);   
                    var err = 1; 
                }
                else
                {
                    exclaim(AR[0]+'_'+AR[1]+'_'+i,0);
                }
            }
            if(AR[2]==3 || AR[2]==4 || AR[2]==5)
            {
                var CO_I = document.getElementById("UI_1_3"); //id - country
                var CO_N = document.getElementById("U_1_3"); //name
                var CO_S = document.getElementById("DD_3"); //showall
                
                var PR_I = document.getElementById("UI_1_4"); //province
                var PR_N = document.getElementById("U_1_4");
                var PR_S = document.getElementById("DD_4");
                
                var CI_I = document.getElementById("UI_1_5"); //city
                var CI_N = document.getElementById("U_1_5");
                var CI_S = document.getElementById("DD_5");
                
                
                if(T.value.length>2)
                {
                    //ID1 = COiD - ID2 PRiD - ID3 CIiD - ID4: ACT - ID5: KW                    
                    SEARCHALL(CO_I.value,PR_I.value,CI_I.value,AR[2],T.value);
                } 
                   
            }            
        }
        else if(AR[0]=="CO") //company stuff
        {          
            for(var i=1;i<=5;i++)
            {
                var x = document.getElementById('CO_'+AR[1]+'_'+i);
                if(x.value.length <= 3)
                {
                    exclaim('CO_'+AR[1]+'_'+i,1);   
                    var err = 1; 
                }
                else
                {
                    exclaim('CO_'+AR[1]+'_'+i,0);
                }
            }
        }               
    }
}
function SEARCHALL(ID1,ID2,ID3,ID4,ID5)
{
    ALLERR('');
    exclaim('U_1_'+ID4,1);
    linethink(1,1);
    
    var THSBLCK = document.getElementById("DD_"+ID4);
    
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
                ALLERR("An error occured and information could not be found. Please try again or contact support on 0110220600.");
            }
            else if(xmlhttp.responseText==2)
            {
                exclaim('U_1_'+ID4,1);
            }
            else
            {
                THSBLCK.style.display = "block";
                THSBLCK.innerHTML = xmlhttp.responseText;     
            }  
            linethink(1,0);                                
        }
    } 
    xmlhttp.open("POST",siteaddress+"/system/B_FILE5/",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("ID1="+ID1+"&ID2="+ID2+"&ID3="+ID3+"&ID4="+ID4+"&ID5="+ID5);
}
function SAVECM()
{
    ALLERR('');
    linethink(1,1);
    
    for(var i=1;i<=5;i++)
    {
        exclaim('U_1_'+i,0);
    }
    
    var U0 = document.getElementById("U_1_0").value;
    var U1 = document.getElementById("U_1_1").value;
    var U2 = document.getElementById("U_1_2").value;
    var U3 = document.getElementById("UI_1_3").value;
    var U4 = document.getElementById("UI_1_4").value;
    var U5 = document.getElementById("UI_1_5").value;
    
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
                ALLERR("The company name you have provided is too short. Please ensure it's at least 3 characters long");
                exclaim('U_1_0',1);
            }
            else if(xmlhttp.responseText==2)
            {
                ALLERR("Please provide a valid company telephone number.");
                exclaim('U_1_2',1);
            }
            else if(xmlhttp.responseText==3)
            {
                ALLERR("Country information is missing. Please provide a valid country.");
                exclaim('U_1_3',1);
            }
            else if(xmlhttp.responseText==4)
            {
                ALLERR("Province information is missing. Please provide a valid province.");
                exclaim('U_1_4',1);
            }
            else if(xmlhttp.responseText==5)
            {
                ALLERR("City information is missing. Please provide a valid city.");
                exclaim('U_1_5',1);
            }
            else if(xmlhttp.responseText==6)
            {
                BTNS('1',0);
                BTNS('2',1); 
                BTNS('9',1);      
                BTNS('11',1);
                if(document.getElementsByClassName("VC_CREDITS"))
                {
                    document.getElementsByClassName("VC_CREDITS")[0].style.display = "block";    
                }                                                
            }
            else
            {
                alert(xmlhttp.responseText);
            }  
            linethink(1,0);                                
        }
    } 
    xmlhttp.open("POST",siteaddress+"/system/B_FILE4/",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("U0="+U0+"&U1="+U1+"&U2="+U2+"&U3="+U3+"&U4="+U4+"&U5="+U5);
}
function SAVECO(C6)
{
    ALLERR('');
    linethink(3,1);
    
    for(var i=1;i<=5;i++)
    {
        exclaim('CO_'+C6+'_'+i,0);
    }
    
    var C1 = document.getElementById("CO_"+C6+"_1").value;
    var C2 = document.getElementById("CO_"+C6+"_2").value;
    var C3 = document.getElementById("CO_"+C6+"_3").value;
    var C4 = document.getElementById("CO_"+C6+"_4").value;
    var C5 = document.getElementById("CO_"+C6+"_5").value;
    var AC = new Array();
    for(var i=0;i<=3;i++)
    {
        if(document.getElementById("TB_"+C6+"_"+i).className=="H H2"){ AC[i] = 1; }else{ AC[i] = 0; }
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
                ALLERR("The name of the person you have used is too short or missing. Please ensure it's at least 3 characters long");
                exclaim('CO_'+C6+'_1',1);
            }
            else if(xmlhttp.responseText==2)
            {
                ALLERR("The surname of the person you have used is too short or missing. Please ensure it's at least 3 characters long");
                exclaim('CO_'+C6+'_2',1);
            }
            else if(xmlhttp.responseText==3)
            {
                ALLERR("The job title of the person you have used is too short or missing. Please ensure it's at least 3 characters long");
                exclaim('CO_'+C6+'_3',1);
            }
            else if(xmlhttp.responseText==4)
            {
                ALLERR("Incorrect email address or address missing. Please add a valid email address");
                exclaim('CO_'+C6+'_4',1);
            }
            else if(xmlhttp.responseText==5)
            {
                ALLERR("Incorrect mobile number or number missing. Please add a valid mobile number address");
                exclaim('CO_'+C6+'_5',1);
            }
            else if(xmlhttp.responseText==6)
            {
                ALLERR("Something went wrong with the access settings. Please try again or contact support on 0110220600.");
                exclaim('CO_'+C6+'_5',1);
            }
            else if(xmlhttp.responseText==7)
            {
                BTNS("5_"+C6,0);
                document.getElementById("B_"+C6).style.display = "none";
                document.getElementById("A_"+C6).style.display = "block";
                document.getElementById("AI_"+C6+"_1").innerHTML = C1+' '+C2;
                document.getElementById("AI_"+C6+"_2").innerHTML = C3;
                BTNS('9',1);        
                BTNS('10',1);
                if(document.getElementById("BTN_9_"+C6))
                {
                    document.getElementById("VCBTNS_"+C6).removeChild(document.getElementById("BTN_9_"+C6)); 
                    BTNS('6_'+C6,1);
                    BTNS('7_'+C6,1);
                    BTNS('8_'+C6,1);  
                }
                if(document.getElementById("nocomm"))
                {
                    document.getElementById("nocomm").style.display = "none";    
                }
            }
            else
            {
                ALLERR("Something went wrong. Please try again or contact support on 0110220600.");
            }  
            linethink(3,0);                                
        }
    } 
    xmlhttp.open("POST",siteaddress+"/system/B_FILE6/",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("C1="+C1+"&C2="+C2+"&C3="+C3+"&C4="+C4+"&C5="+C5+"&C6="+C6+"&C7="+AC.join('.'));
}
function createE()
{
    var x = document.getElementById("UQTY");   
    var node = document.createElement("DIV");
    var textnode = document.createTextNode('');
    node.appendChild(textnode);
    document.getElementById("M3").appendChild(node);
    var N = parseInt(x.value)+1;
    node.id = 'MI_'+N;
    x.value = N;
    
    node.innerHTML = "<div id=\"A_"+N+"\" style=\"display: none;\">\
        <h3 id=\"AI_"+N+"_1\"></h3>\
        <h4 id=\"AI_"+N+"_2\"></h4>\
    </div>\
    <div class=\"VC_C_SH\" id=\"B_"+N+"\" style=\"display: block;\">\
        <h2>*Name:</h2>\
        <input type=\"text\" id=\"CO_"+N+"_1\" value=\"\">\
        <h2>*Surname:</h2>\
        <input type=\"text\" id=\"CO_"+N+"_2\" value=\"\">\
        <h2>*Job Title:</h2>\
        <input type=\"text\" id=\"CO_"+N+"_3\" value=\"\">\
        <h2>*Email Address:</h2>\
        <input type=\"text\" id=\"CO_"+N+"_4\" value=\"\">\
        <h2>*Mobile Number:</h2>\
        <input type=\"text\" id=\"CO_"+N+"_5\" value=\"\">\
        <h2>*Access</h2>\
        <div class=\"H H1\" id=\"TB_"+N+"_0\">Can Login</div>\
        <div class=\"H H1\" id=\"TB_"+N+"_1\">Can View Results</div>\
        <div class=\"H H1\" id=\"TB_"+N+"_2\">Can Grade Jobs</div>\
        <div class=\"H H1\" id=\"TB_"+N+"_3\">Administration Rights</div>\
        <div class=\"VC_BTNS\" id=\"VCBTNS_"+N+"\">\
            <div class=\"XSML BTN2\" id=\"BTN_5_"+N+"\" style=\"display: none;\">Save</div>\
            <div class=\"XSML BTN2\" id=\"BTN_6_"+N+"\" style=\"display: none;\">Reset Password</div>\
            <div class=\"XSML BTN2\" id=\"BTN_7_"+N+"\" style=\"display: none;\">Deactivate</div>\
            <div class=\"XSML BTN2\" id=\"BTN_8_"+N+"\" style=\"display: none;\">Send SMS</div>\
            <div class=\"XSML BTN2\" id=\"BTN_9_"+N+"\" style=\"display: inline-block;\">Cancel</div>\
        </div>\
    </div>";            
}
function CHANGEOVA()
{
    ALLERR('');
    linethink(4,1);
    
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
                ALLERR("There is not enough credits to change over to this company for grading. Please increase the number of credits.");
            }
            else if(xmlhttp.responseText==2)
            {
                ALLERR("There are no committee members listed on this company. Please add at least one committee member.");
            }
            else if(xmlhttp.responseText==3)
            {
                triggerthink(1);
                window.open(siteaddress+"/gradehistory.htm","_self");
            }
            else
            {
                ALLERR("An error occurred and change over could not happen. Please try again or contact support on +27110220600.");
            }
            linethink(4,0);  
        }
    } 
    xmlhttp.open("POST",siteaddress+"/system/B_FILE10/",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send();
}