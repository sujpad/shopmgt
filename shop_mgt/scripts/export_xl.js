createXmlHttpRequestObject();   //Creates only if the object doesn't exist already

var timeoutId = -1;

function export_to_excel()
{
        // proceed only if the xmlHttp object isn't busy
        if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0)
        {
                xmlHttp.open("GET", "ajax_query/export_xl.php",  true);
		xmlHttp.onreadystatechange = excel_sheet_generate;
                xmlHttp.send(null);
        }
        else
        {
                if(timeoutId != -1)
			clearTimeout(timeoutId);
                timeoutId = setTimeout('export_to_excel()', 500);
        }
}


function excel_sheet_generate()
{
        if (xmlHttp.readyState == 4)
        {
                if (xmlHttp.status == 200)
                {
			var xmlResponseText = xmlHttp.responseText;
			location.href = "export_xl.php";
                }
                else
                {
			alert("There was a problem accessing the server: " + xmlHttp.statusText);
                }
        }
}


