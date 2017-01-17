function AG_GO(ID,ACT,WHR)
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

function UPDNOTES()
{
    var ID = document.getElementById("NOTES").value;
    
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
            if(xmlhttp.responseText==2)
            {
                confBOX("You are not permitted to comment on this grading.");
            }  
            else if(xmlhttp.responseText==3)
            {
                confBOX("An error occured and information was not updated.");
            }                                    
        }
    } 
    xmlhttp.open("POST",siteaddress+"/system/B_FILE11/",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("ID="+ID);  
}