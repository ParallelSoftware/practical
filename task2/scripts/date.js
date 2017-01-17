var D_arr = new Array("Mo","Tu","We","Th","Fr","Sa","Su");
var M_arr = new Array("January","February","March","April","May","June","July","August","September","October","November","December");

var d = new Date();
var thisday = d.getDate();
var thismonth = d.getMonth();
var thisyear = d.getFullYear();

function changedate(ID)
{
    var DTEVAL = document.getElementById("DATEVALUE"+ID);
    var DT = DTEVAL.value.split("-");
    if(DT.length==3)
    {
        makedate(DT[2],DT[1],DT[0],ID);   
    }   
    else
    {
        makedate(thisday,thismonth,thisyear,ID);    
    }
}

function makedate(D,M,Y,ID)
{        
    var fdate = new Date(Y, M-1, 1);   //first day of the month
    var wdate = fdate.getUTCDay(); // where it is in the week
    
    var nextM = new Date(Y, M, 1).getMonth()+1;
    var prevM = new Date(Y, M-2, 1).getMonth()+1;
    if(nextM==1){ var nextY = Y+1; }else{ var nextY = Y; }
    if(prevM==12){ var prevY = Y-1; }else{ var prevY = Y; }
    
    var txt = "<div class=\"DATE_BLOCK\"><div class=\"DATE_MONTH\">\
    <img src=\"/images/date/dateleft.png\" onclick=\"makedate("+D+","+prevM+","+prevY+","+ID+");\"><select id=\"DM"+ID+"\" onchange=\"makedate("+D+",this.value,document.getElementById('DY"+ID+"').value,"+ID+");\">";
    for(var i=1; i<=12; i++)
    {
        txt +="<option value=\""+i+"\" ";
        if(i==M)
        {
            txt +="selected";
        }
        txt +=">"+M_arr[i-1]+"</option>";
    }
    txt +="</select><select id=\"DY"+ID+"\" onchange=\"makedate("+D+",document.getElementById('DM"+ID+"').value,this.value,"+ID+");\">";
    for(var i=-100; i<=5; i++)
    {
        var z = parseInt(d.getFullYear())+parseInt(i);
        txt +="<option value=\""+z+"\" ";
        if(z==Y)
        {
            txt +="selected";
        }
        txt +=">"+z+"</option>";
    }    
    
    txt += "</select><img src=\"/images/date/dateright.png\" onclick=\"makedate("+D+","+nextM+","+nextY+","+ID+");\"><img src=\"/images/date/datetoday.png\" onclick=\"setdate('TODAY',"+ID+");\"><img src=\"/images/date/dateclose.png\" onclick=\"closedate("+ID+");\"></div>";
            
    for(var i=0; i<=6; i++)
    {                            
        txt += "<div class=\"DATE_DAY\">"+D_arr[i]+"</div>";    
    }
    for(var i=0; i<=(wdate-1); i++)
    {                                    
        txt += "<div class=\"DATE_DAY\"></div>";    
    }
    for(var i=1; i<=31; i++)
    {                                    
        var dayobj = new Date(Y, M-1, i);
        if ((dayobj.getMonth()+1!=M)||(dayobj.getDate()!=i)||(dayobj.getFullYear()!=Y))
        {
            
        }
        else
        {
            txt += "<div class=\"DATE_DAY DATE_ON\" onclick=\"setdate('"+i+"',"+ID+");\" ";
            if(thisday == i && thismonth == (M-1) && thisyear == Y)
            {
                txt += "style=\"font-weight:bold;\"";    
            }
            txt += ">"+i+"</div>";    
        }            
    }
    txt +="</div>";
    
    var x = document.getElementById("DATEBLOCK"+ID);
    x.innerHTML = txt;
    x.style.display = "block";
}

function setdate(D,ID)
{
    var DTEVAL = document.getElementById("DATEVALUE"+ID);
    var THEDATE = document.getElementById("THEDATE"+ID);
    var Y = document.getElementById('DY'+ID);
    var M = document.getElementById('DM'+ID);
    
    if(D=="TODAY")
    {
        var DA = thisday;   
        var MO = thismonth;
        var YE = thisyear;
    }
    else
    {
        var DA = D;   
        var MO = M.value;
        var YE = Y.value;      
    }
    
    DTEVAL.value = YE+'-'+MO+'-'+DA;
    if(DA.length==1)
    {
        DA = '0'+DA;
    } 
            
    THEDATE.innerHTML = DA+' '+M_arr[MO-1]+' '+YE;
    
    document.getElementById("DEL"+ID).style.display = "inline";
    var x = document.getElementById("DATEBLOCK"+ID);
    x.innerHTML = "";
    x.style.display = "none";
}

function closedate(ID)
{
    var x = document.getElementById("DATEBLOCK"+ID);
    x.innerHTML = "";
    x.style.display = "none";    
}

function deletedate(ID)
{
    var DTEVAL = document.getElementById("DATEVALUE"+ID);
    var THEDATE = document.getElementById("THEDATE"+ID);
    document.getElementById("DEL"+ID).style.display = "none";
    DTEVAL.value = "";
    THEDATE.innerHTML = "Choose Date";   
}
