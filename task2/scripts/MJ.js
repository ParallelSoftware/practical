function MJ_GO(ID,ACT,WHR)
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